<div>
    {{-- Seksi 1: Header Sambutan --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Dashboard Administrator</h1>
        <p class="text-lg text-muted">Selamat datang kembali, {{ auth()->user()->name }}! Berikut adalah ringkasan
            platform Talksy.id.</p>
    </div>

    {{-- Seksi 2: Stat Cards (KPI Utama) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-users-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-muted">Total Siswa</p>
                <h3 class="text-2xl font-bold text-dark">{{ $totalStudents }}</h3>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-stack-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-muted">Total Modul</p>
                <h3 class="text-2xl font-bold text-dark">{{ $totalModules }}</h3>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-chart-pie-slice-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-muted">Tingkat Lulus Kuis</p>
                <h3 class="text-2xl font-bold text-dark">{{ $quizPassRate }}%</h3>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-certificate-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-muted">Sertifikat Terbit</p>
                <h3 class="text-2xl font-bold text-dark">{{ $totalCertificates }}</h3>
            </div>
        </div>
    </div>

    {{-- Seksi 3: Grafik & Aktivitas Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom Kiri: Grafik Pendaftaran Siswa --}}
        <div class="lg:col-span-2 card p-6">
            <h3 class="font-bold text-lg text-dark mb-4">Pendaftaran Siswa (7 Hari Terakhir)</h3>
            <div x-data='apexChart(@json($newUserTrendData))'>
                {{-- Chart akan di-render di sini oleh Alpine.js --}}
            </div>
        </div>

        {{-- Kolom Kanan: Siswa Terbaru --}}
        <div class="card p-6">
            <h3 class="font-bold text-lg text-dark mb-4">Siswa Terbaru</h3>
            <div class="space-y-4">
                @forelse ($recentStudents as $student)
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=0D894F&color=fff"
                             class="w-10 h-10 rounded-full" alt="{{ $student->name }}"/>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $student->name }}</p>
                            <p class="text-xs text-slate-500">Bergabung {{ $student->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-sm text-slate-500 py-4">
                        Belum ada siswa baru yang terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
