<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Riwayat & Hasil Kuis</h1>
        <p class="text-lg text-slate-500">Lihat kembali semua riwayat pengerjaan kuis Anda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg">
        <div class="divide-y divide-slate-100">
            @forelse ($attempts as $attempt)
                <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-sm text-slate-400 font-medium">{{ $attempt->quiz->module->title }}</p>
                        <h3 class="text-lg font-bold text-slate-800 hover:text-primary transition">
                           <a href="{{ route('student.quiz.attempt', $attempt->quiz) }}" wire:navigate>
                                {{ $attempt->quiz->title }}
                           </a>
                        </h3>
                         <p class="text-sm text-slate-500 mt-1">
                            Dikerjakan pada: {{ $attempt->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-6 w-full sm:w-auto">
                        <div class="text-center">
                            <p class="text-sm text-slate-500">Skor</p>
                            <p @class([
                                'text-2xl font-bold',
                                'text-primary' => $attempt->is_passed,
                                'text-red-500' => !$attempt->is_passed
                            ])>
                                {{ $attempt->score }}
                            </p>
                        </div>
                        <div class="text-center">
                             @if ($attempt->is_passed)
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    <x-phosphor-check-circle-bold class="w-4 h-4"/>
                                    Lulus
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                     <x-phosphor-x-circle-bold class="w-4 h-4"/>
                                    Gagal
                                </span>
                            @endif
                        </div>
                        <div class="shrink-0">
                             <x-button :href="route('student.quiz.attempt', $attempt->quiz)" wire:navigate variant="secondary-ghost">
                                Coba Lagi
                            </x-button>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="p-8 text-center">
                    <x-phosphor-info-bold class="w-10 h-10 text-slate-400 mx-auto mb-4" />
                    <h3 class="text-lg font-bold text-slate-700">Belum Ada Riwayat Kuis</h3>
                    <p class="text-sm text-slate-500">Anda belum pernah mengerjakan kuis sama sekali.</p>
                </div>
            @endforelse
        </div>

         @if($attempts->hasPages())
            <div class="p-6 border-t border-slate-200">
                {{ $attempts->links() }}
            </div>
        @endif
    </div>
</div>
