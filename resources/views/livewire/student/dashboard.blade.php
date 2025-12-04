<div>
    {{-- Seksi 1: Header Sambutan & Aksi Utama --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Halo, {{ auth()->user()->name }}!</h1>
        <p class="text-lg text-slate-500 mb-6">Selamat datang kembali. Semangat menuntut ilmu hari ini.</p>

        @if ($nextMaterial)
            <x-button :href="$nextMaterial->route" wire:navigate variant="primary" class="text-base px-6 py-3">
                <x-slot:icon_left>
                    <x-phosphor-play-circle-bold class="w-5 h-5" />
                </x-slot:icon_left>
                {{ $nextMaterial->title }}
            </x-button>
        @else
             <x-button href="{{ route('student.my-learning') }}" wire:navigate variant="primary" class="text-base px-6 py-3">
                <x-slot:icon_left>
                    <x-phosphor-book-open-text-bold class="w-5 h-5" />
                </x-slot:icon_left>
                Lihat Semua Kurikulum
            </x-button>
        @endif
    </div>

    {{-- Seksi 2: Kartu Statistik Personal (KPI) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-chart-line-up-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-slate-500">Progres Kursus</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $overallCourseProgress }}%</h3>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-target-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-slate-500">Rata-rata Skor Kuis</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $averageQuizScore }}</h3>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-stack-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-slate-500">Modul Tuntas</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $completedModulesCount }}</h3>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center shrink-0">
                <x-phosphor-certificate-duotone class="icon-size-xl" />
            </div>
            <div>
                <p class="text-sm text-slate-500">Sertifikat</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $certificateStatus }}</h3>
            </div>
        </div>
    </div>

    {{-- Seksi 3: Grafik & Aktivitas Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom Kiri: Grafik Aktivitas Belajar --}}
        <div class="lg:col-span-2 card p-6">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Aktivitas Belajar (7 Hari Terakhir)</h3>
            {{-- Chart akan di-render di sini oleh Alpine.js --}}
            <div x-data='apexChart(@json($activityTrendData))'></div>
        </div>

        {{-- Kolom Kanan: Pencapaian Terbaru --}}
        <div class="card p-6">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Pencapaian Terbaru</h3>
            <div class="space-y-4">
                @forelse ($recentAchievements as $achievement)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center shrink-0">
                             <x-dynamic-component :component="$achievement['icon']" class="w-6 h-6 {{ $achievement['color'] }}" />
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $achievement['text'] }}</p>
                            <p class="text-xs text-slate-500">{{ $achievement['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada pencapaian terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>