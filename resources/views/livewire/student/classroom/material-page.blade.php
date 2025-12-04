<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg">
        {{-- KONTEN MATERI (Video, Teks, atau PDF) --}}
        <div class="p-2">
            @switch($material->type->value ?? $material->type)
            @case('video')
            @if ($videoUrl)
            {{-- UPDATE DI SINI: Gunakan 'aspect-video' native dan iframe full width/height --}}
            <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-900 shadow-lg">
                <iframe src="{{ $videoUrl }}" class="absolute top-0 left-0 w-full h-full" title="Video Player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>
            @else
            <div class="aspect-video bg-slate-800 rounded-xl flex flex-col items-center justify-center text-white">
                <x-phosphor-video-camera-slash-bold class="w-12 h-12 text-slate-500 mb-4" />
                <p class="font-semibold">Video tidak valid atau URL rusak.</p>
            </div>
            @endif
            @break

            @case('text')
            <div class="prose prose-lg max-w-none p-6 lg:p-8">
                {!! $material->content_body !!}
            </div>
            @break

            @case('pdf')
            <div class="p-8 text-center">
                <x-phosphor-file-pdf-bold class="w-16 h-16 text-red-500 mx-auto mb-4" />
                <h3 class="text-xl font-bold text-slate-800">Materi PDF</h3>
                <p class="text-slate-500 mb-6">Materi ini tersedia dalam format PDF.</p>
                <x-button variant="primary" as="a" href="{{ Storage::url($material->content_url) }}" target="_blank">
                    <x-slot:icon_left>
                        <x-phosphor-download-simple-bold />
                    </x-slot:icon_left>
                    Unduh PDF
                </x-button>
            </div>
            @break
            @endswitch
        </div>

        {{-- FOOTER KONTEN --}}
        <div class="px-6 lg:px-8 py-6 border-t border-slate-200">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                {{-- Judul Materi dan Breadcrumb --}}
                <div>
                    <nav class="text-sm font-medium text-slate-500 mb-1">
                        <a href="{{ route('student.my-learning') }}" wire:navigate class="hover:text-primary">My
                            Learning</a>
                        <span class="mx-2 text-slate-300">/</span>
                        <span class="font-bold text-primary">{{ $material->module->title }}</span>
                    </nav>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $material->title }}</h1>
                </div>

                {{-- Tombol Aksi --}}
                <div class="w-full sm:w-auto shrink-0">
                    @if ($isCompleted)
                    <div
                        class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-100 text-emerald-700 font-bold">
                        <x-phosphor-check-circle-bold class="w-6 h-6" />
                        <span>Selesai</span>
                    </div>
                    @else
                    <x-button wire:click="markAsComplete" variant="primary" class="w-full">
                        <x-slot:icon_left>
                            <x-phosphor-check-circle-bold class="w-6 h-6" />
                        </x-slot:icon_left>
                        Tandai Selesai
                    </x-button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mt-8">
        @if ($previousMaterial)
        <x-button :href="route('student.material.show', $previousMaterial)" wire:navigate variant="secondary-ghost">
            <x-slot:icon_left>
                <x-phosphor-arrow-left-bold />
            </x-slot:icon_left>
            Materi Sebelumnya
        </x-button>
        @else
        <div></div> {{-- Placeholder untuk menjaga layout justify-between --}}
        @endif

        @if ($nextMaterial)
        <x-button :href="route('student.material.show', $nextMaterial)" wire:navigate variant="secondary-ghost">
            Materi Selanjutnya
            <x-slot:icon_right>
                <x-phosphor-arrow-right-bold />
            </x-slot:icon_right>
        </x-button>
        @else
        {{-- Jika tidak ada materi selanjutnya, tampilkan tombol ke kuis --}}
        @if ($material->module->quiz)
        <x-button :href="route('student.quiz.attempt', ['quiz' => $material->module->quiz->id])" wire:navigate
            variant="primary">
            Lanjut ke Kuis Modul
            <x-slot:icon_right>
                <x-phosphor-arrow-right-bold />
            </x-slot:icon_right>
        </x-button>
        @endif
        @endif
    </div>
</div>