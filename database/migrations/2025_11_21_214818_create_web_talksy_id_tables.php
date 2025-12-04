<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 2. MODULES (Bab Pembelajaran)
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Modul
            $table->text('description')->nullable();
            $table->integer('order_index')->default(0); // Urutan Modul (1, 2, 3...)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. MATERIALS (Materi per Modul)
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->string('title');

            // Tipe Materi: Video (YouTube), PDF (File), atau Text (Bacaan)
            $table->enum('type', ['video', 'pdf', 'text']);

            $table->string('content_url')->nullable(); // Link YouTube / Path File PDF
            $table->longText('content_body')->nullable(); // Isi teks jika tipe 'text'

            $table->timestamps();
        });

        // 4. MATERIAL COMPLETIONS (Tracking Progres Siswa)
        // Tabel Pivot: Mencatat siswa sudah baca materi apa saja
        Schema::create('material_completions', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent(); // Waktu selesai

            // Composite PK: Mencegah siswa tercatat 2x di materi yang sama
            $table->primary(['user_id', 'material_id']);
        });

        // 5. QUIZZES (Ujian per Modul)
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->string('title');
            $table->integer('passing_score')->default(70); // KKM (Minimal Lulus)
            $table->timestamps();
        });

        // 6. QUESTIONS (Soal Ujian - Teknik JSON)
        // Menggunakan JSON untuk Opsi agar tidak perlu tabel terpisah (HEMAT WAKTU)
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question_text');

            // MAGICAL JSON: Simpan opsi ["Ayam", "Bebek", "Cacing", "Domba"]
            $table->json('options');

            // Kunci Jawaban: Index array (0 = A, 1 = B, dst)
            $table->integer('correct_option_index');

            $table->timestamps();
        });

        // 7. QUIZ ATTEMPTS (Riwayat Hasil Ujian Siswa)
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();

            $table->integer('score'); // Nilai Akhir (0-100)
            $table->boolean('is_passed'); // Lulus atau Tidak

            $table->timestamps();
        });

        // 8. CERTIFICATES (Penghargaan Kelulusan)
        // Diberikan jika siswa menyelesaikan semua modul/kuis
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('certificate_code')->unique(); // Kode unik sertifikat
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus urutan dari bawah (dependensi) ke atas
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('material_completions');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('modules');
    }
};
