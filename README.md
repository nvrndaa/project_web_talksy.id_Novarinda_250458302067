<div align="center">
  <br />
  <h1 style="font-weight: bold; font-size: 2.5rem;">
    Talksy<span style="color: #D4AF37;">.id</span>
  </h1>
  <p>
    Ethical & Professional English Learning Platform
  </p>
  <br />
</div>

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel Version">
    <img src="https://img.shields.io/badge/Livewire-3.x-4E56A6.svg?style=for-the-badge&logo=livewire" alt="Livewire Version">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC.svg?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS Version">
    <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License">
</p>

## Tentang Talks.id

**Talksy.id** adalah sebuah *Learning Management System* (LMS) yang berfokus pada pembelajaran Bahasa Inggris dengan pendekatan yang modern, profesional, dan berlandaskan nilai-nilai Islam. Platform ini dirancang untuk memberikan pengalaman belajar yang interaktif, terstruktur, dan memotivasi, mulai dari pendaftaran hingga mendapatkan sertifikat kelulusan.

Proyek ini dibangun sebagai contoh aplikasi web modern dengan tumpukan teknologi TALL (Tailwind, Alpine, Laravel, Livewire) yang diperluas, dengan fokus pada arsitektur yang bersih, *scalable*, dan mudah dikelola.

## Fitur Utama

Aplikasi ini memiliki dua peran utama dengan fitur yang lengkap: **Student** dan **Admin**.

### Untuk Siswa (Student)
- **Dashboard Dinamis:** Ringkasan progres, statistik personal (rata-rata skor, modul tuntas), dan feed aktivitas terbaru.
- **Alur Belajar Terpandu:** Halaman "My Learning" yang menampilkan peta jalan kurikulum, progres per modul, dan status materi.
- **Konsumsi Materi:** Tampilan untuk menikmati materi dalam format Video (YouTube), Teks (HTML), dan PDF (unduh).
- **Navigasi Materi:** Kemampuan untuk berpindah ke materi sebelum dan sesudahnya dengan mudah.
- **Sistem Kuis Interaktif:** Mengerjakan kuis di akhir setiap modul untuk menguji pemahaman.
- **Riwayat & Hasil Kuis:** Halaman khusus untuk melihat kembali semua riwayat pengerjaan kuis, skor, dan status kelulusan.
- **Sertifikasi Otomatis:** Sistem secara otomatis menerbitkan sertifikat setelah semua materi dan kuis berhasil diselesaikan.
- **Unduh Sertifikat PDF:** Siswa dapat mengunduh sertifikat kelulusan mereka dalam format PDF yang profesional.
- **Pengaturan Akun:** Kemampuan untuk mengubah nama, email, password, dan mengunggah foto profil (avatar).

### Untuk Admin
- **Dashboard Analitik:** Ringkasan statistik platform (total siswa, total modul, dll.) dan grafik tren pengguna baru.
- **Manajemen Konten (CRUD Lengkap):** Kemampuan penuh untuk membuat, membaca, mengubah, dan menghapus (CRUD) semua konten pembelajaran:
    - Modul
    - Materi (Video, Teks, PDF)
    - Kuis
    - Pertanyaan Kuis
- **Manajemen Pengguna:** Kemampuan untuk mengelola pengguna dengan peran siswa.
- **Laporan & Analitik:** Halaman khusus untuk memantau progres siswa, hasil kuis, dan daftar sertifikat yang telah diterbitkan.

### Fitur Publik
- **Landing Page Dinamis:** Halaman depan yang menampilkan statistik dan preview kurikulum nyata dari database.
- **Validasi Sertifikat Publik:** Halaman `/verify-certificate` yang memungkinkan siapa pun untuk memverifikasi keaslian sertifikat menggunakan kode unik.

## Arsitektur & Teknologi

Proyek ini dibangun dengan penekanan kuat pada arsitektur yang bersih dan modern.

### Prinsip Arsitektur
- **Livewire 3 sebagai SPA:** Aplikasi ini berfungsi seperti *Single-Page Application* (SPA) dengan memanfaatkan `wire:navigate` dari Livewire 3 untuk transisi halaman yang instan tanpa *full page reload*.
- **Service Layer & Query Objects:** Logika bisnis yang kompleks dipisahkan dari komponen Livewire (yang hanya bertindak sebagai *controller*).
    - **Services** (`app/Services`): Menangani logika tulis (Create, Update, Delete) dan proses bisnis.
    - **Query Objects** (`app/Queries`): Menangani logika baca (Read) yang kompleks dan teroptimasi untuk mencegah masalah N+1.
- **Form Objects:** State dari form yang kompleks dienkapsulasi dalam kelas-kelas Form Object (`app/Livewire/.../Forms`) untuk membuat komponen utama lebih bersih.
- **Otentikasi Headless:** Menggunakan **Laravel Fortify** untuk backend otentikasi, dengan UI yang sepenuhnya dikendalikan oleh komponen Livewire.

### Tumpukan Teknologi (Tech Stack)
| Kategori      | Teknologi / Package                                   |
|---------------|-------------------------------------------------------|
| **Backend**   | Laravel 12                                            |
| **Frontend**  | Livewire 3, Alpine.js                                 |
| **Styling**   | Tailwind CSS v4 (via `@theme` directive)              |
| **Database**  | MySQL                                                 |
| **Otentikasi**| Laravel Fortify                                       |
| **PDF**       | `barryvdh/laravel-dompdf`                             |
| **UI & Ikon** | Blade UI Kit, Phosphor Icons (`codeat3/blade-phosphor-icons`) |

## Panduan Instalasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Kloning Repositori**
    ```bash
    git clone https://link-ke-repositori-anda.git
    cd nama-direktori-proyek
    ```

2.  **Instalasi Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env` dan generate kunci aplikasi.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Setup Database**
    Buka file `.env` Anda dan perbarui kredensial database sesuai dengan pengaturan lokal Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5.  **Migrasi & Seeding (Langkah Penting!)**
    Jalankan perintah ini untuk membuat semua tabel database dan mengisinya dengan data sampel yang kaya dan realistis.
    ```bash
    php artisan migrate:fresh --seed
    ```
    *Perintah ini akan menghapus semua data lama Anda.*

6.  **Buat Symlink Storage**
    Perintah ini penting agar file yang diunggah (seperti avatar dan PDF) dapat diakses dari web.
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server**
    Buka dua tab terminal:
    - Di tab pertama, jalankan Vite untuk kompilasi aset frontend:
      ```bash
      npm run dev
      ```
    - Di tab kedua, jalankan server pengembangan Laravel:
      ```bash
      php artisan serve
      ```

8.  **Selesai!**
    Buka `http://127.0.0.1:8000` di browser Anda.

## Akun Demo

Setelah menjalankan `migrate:fresh --seed`, Anda dapat menggunakan akun-akun berikut untuk menguji coba platform.

| Email                 | Password   | Peran            | Deskripsi                                        |
|-----------------------|------------|------------------|----------------------------------------------------|
| `admin@talksy.id`     | `password` | **Admin**        | Akun untuk mengelola seluruh platform.             |
| `super@talksy.id`     | `password` | **Student**      | Siswa yang sudah menyelesaikan 100% kursus.        |
| `rajin@talksy.id`     | `password` | **Student**      | Siswa dengan progres belajar sekitar 60%.          |
| `berjuang@talksy.id`  | `password` | **Student**      | Siswa yang pernah gagal di beberapa kuis.          |
| `baru@talksy.id`      | `password` | **Student**      | Siswa baru tanpa progres sama sekali.            |


## Lisensi

Proyek Talks.id adalah perangkat lunak sumber terbuka yang dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).