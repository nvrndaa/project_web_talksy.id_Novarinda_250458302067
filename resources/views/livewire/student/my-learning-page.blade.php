<div>
    {{-- 1. Ringkasan Progres Global --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 mb-8">
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ringkasan Progres Anda</h2>

        <div class="mb-4">
            <div class="flex justify-between items-end mb-1">
                <h3 class="text-xl font-bold text-slate-800">Total Kursus Selesai</h3>
                <span class="font-bold text-primary text-xl">{{ $overallProgress }}%</span>
            </div>
            <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full" style="width: {{ $overallProgress }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center mt-6">
            <div class="bg-slate-50 rounded-lg p-3">
                <p class="text-2xl font-bold text-primary">{{ $completedModules }}<span
                        class="text-base text-slate-400 font-medium">/{{ $totalModules }}</span></p>
                <p class="text-xs text-slate-500">Modul Selesai</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-3">
                <p class="text-2xl font-bold text-primary">{{ $passedQuizzes }}<span
                        class="text-base text-slate-400 font-medium">/{{ $totalQuizzes }}</span></p>
                <p class="text-xs text-slate-500">Kuis Lulus</p>
            </div>
        </div>
    </div>

    {{-- 2. Daftar Modul Interaktif (Accordion) --}}
    <div class="space-y-4">
        @forelse ($curriculum as $module)
        @php
        $totalMaterialsInModule = $module->materials->count();
        $completedMaterialsInModule = $module->materials->where('is_completed', true)->count();
        $quizPassed = $module->quiz?->latestAttempt?->is_passed ?? false;
        $moduleProgress = 0;
        if ($totalMaterialsInModule > 0) {
        $progressPoints = $completedMaterialsInModule;
        $totalPoints = $totalMaterialsInModule;
        if($module->quiz) {
        $totalPoints += 1; //tambah 1 untuk kuis
        if ($quizPassed) $progressPoints += 1;
        }
        $moduleProgress = round(($progressPoints / $totalPoints) * 100);
        }
        $isModuleCompleted = $moduleProgress >= 100;
        @endphp
        <div x-data="{ open: @json($isModuleCompleted ? false : true) }"
            class="bg-white rounded-2xl shadow-lg transition-all duration-300"
            ::class="{'shadow-lg': open, 'shadow-sm': !open}">
            {{-- Header Accordion --}}
            <button @click="open = !open" class="w-full text-left p-6 flex items-center gap-4">
                <div @class([ 'w-12 h-12 rounded-lg flex items-center justify-center shrink-0'
                    , 'bg-primary text-white'=> $isModuleCompleted,
                    'bg-primary/10 text-primary' => !$isModuleCompleted,
                    ])>
                    <x-phosphor-book-bookmark-bold class="w-6 h-6" />
                </div>

                <div class="flex-1">
                    <p class="text-xs text-slate-400 font-medium">Modul {{ $module->order_index }}</p>
                    <h3 class="text-lg font-bold text-slate-800">{{ $module->title }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: {{ $moduleProgress }}%"></div>
                        </div>
                        <span class="text-xs font-medium text-slate-500 w-12 text-right">{{ $moduleProgress }}%</span>
                    </div>
                </div>

                @if($isModuleCompleted)
                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded-full">Selesai</span>
                @endif
                <x-phosphor-caret-down-bold class="icon-size-md text-slate-400 transition-transform"
                    ::class="{'rotate-180': open}" />
            </button>

            {{-- Konten Accordion --}}
            <div x-show="open" x-collapse.duration.300ms class="px-6 pb-6">
                <div class="border-t border-slate-200 pt-4">
                    <ul class="space-y-2 mb-6">
                        @foreach ($module->materials as $material)
                        <li class="p-3 rounded-lg hover:bg-slate-50 transition">
                            <a href="{{ route('student.material.show', $material) }}" wire:navigate
                                class="flex items-center gap-4">
                                @if($material->is_completed)
                                <x-phosphor-check-circle-bold class="w-6 h-6 text-emerald-500 shrink-0" />
                                @else
                                <x-phosphor-circle-dashed-bold class="w-6 h-6 text-slate-300 shrink-0" />
                                @endif

                                <div class="flex-1">
                                    <p class="font-medium text-slate-700">{{ $material->title }}</p>
                                    <p class="text-xs text-slate-400 capitalize">{{ $material->type->value }}</p>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    @if($module->quiz)
                    @php
                    $allMaterialsDone = $completedMaterialsInModule >= $totalMaterialsInModule;
                    @endphp
                    <x-button
                        :href="$allMaterialsDone ? route('student.quiz.attempt', ['quiz' => $module->quiz->id]) : '#'"
                        :disabled="!$allMaterialsDone" wire:navigate
                        variant="{{ $quizPassed ? 'success-ghost' : 'primary' }}" class="w-full">
                        @if($quizPassed)
                        <x-slot:icon_left>
                            <x-phosphor-check-circle-bold />
                        </x-slot:icon_left>
                        Kuis Lulus (Skor: {{ $module->quiz->latestAttempt->score }})
                        @else
                        <x-slot:icon_left>
                            <x-phosphor-pencil-simple-bold />
                        </x-slot:icon_left>
                        Kerjakan Kuis Modul
                        @endif
                    </x-button>
                    @if(!$allMaterialsDone)
                    <p class="text-center text-xs text-slate-400 mt-2">Selesaikan semua materi untuk membuka kuis.</p>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
            <x-phosphor-info-bold class="w-10 h-10 text-slate-400 mx-auto mb-4" />
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Kurikulum</h3>
            <p class="text-sm text-slate-500">Saat ini belum ada modul belajar yang tersedia. Silakan cek kembali nanti.
            </p>
        </div>
        @endforelse
    </div>
</div>