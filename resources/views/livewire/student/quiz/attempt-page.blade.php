<div>
    <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">

        @if($result)
        {{-- TAMPILAN SETELAH SUBMIT KUIS (HASIL) --}}
        <div class="text-center max-w-lg mx-auto animate-fade-in">
            @if($result->is_passed)
            <div class="inline-block p-4 bg-emerald-100 rounded-full mb-4">
                <x-phosphor-graduation-cap-bold class="w-12 h-12 text-emerald-600" />
            </div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Lulus! Alhamdulillah.</h1>
            <p class="text-slate-500 mb-6">
                Anda berhasil menyelesaikan kuis ini dengan skor yang memuaskan.
            </p>
            @else
            <div class="inline-block p-4 bg-red-100 rounded-full mb-4">
                <x-phosphor-x-circle-bold class="w-12 h-12 text-red-600" />
            </div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Perlu Coba Lagi</h1>
            <p class="text-slate-500 mb-6">
                Jangan khawatir, kegagalan adalah bagian dari proses belajar. Ulangi materi dan coba lagi.
            </p>
            @endif

            <div class="bg-slate-50 border border-slate-200 rounded-xl p-6 text-center max-w-sm mx-auto mb-8">
                <p class="text-sm text-slate-500 mb-1">Skor Akhir Anda</p>
                <p @class([ 'text-5xl font-bold' , 'text-emerald-500'=> $result->is_passed,
                    'text-red-500' => !$result->is_passed,
                    ])>
                    {{ $result->score }}
                </p>
            </div>

            <div class="flex justify-center gap-4">
                {{-- Pastikan route ini valid di web.php Anda --}}
                <x-button :href="route('student.my-learning', ['module' => $quiz->module_id])" wire:navigate
                    variant="secondary">
                    Kembali ke Modul
                </x-button>

                @if(!$result->is_passed)
                <x-button wire:click="retry" variant="primary">
                    Ulangi Kuis
                </x-button>
                @endif
            </div>
        </div>

        @else
        {{-- TAMPILAN SAAT MENGERJAKAN KUIS --}}
        <form wire:submit="submit">
            <div
                class="flex justify-between items-center border-b border-slate-200 pb-4 mb-6 sticky top-0 bg-white z-10 pt-2">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $quiz->title }}</h1>
                    <p class="text-sm text-slate-500">Jawablah pertanyaan berikut dengan teliti.</p>
                </div>
                {{-- Hitung jumlah yang tidak null --}}
                <p class="text-sm font-bold text-primary">
                    {{ count(array_filter($answers, fn($v) => !is_null($v))) }} / {{ $questions->count() }} Pertanyaan
                </p>
            </div>

            {{-- Daftar Pertanyaan --}}
            <div class="space-y-8">
                @foreach($questions as $index => $question)
                <div wire:key="question-{{ $question->id }}" class="p-4 rounded-xl hover:bg-slate-50 transition">
                    <p class="text-sm font-semibold text-slate-500 mb-2">Pertanyaan {{ $index + 1 }}</p>
                    <h4 class="text-lg font-bold text-slate-800 mb-4">{{ $question->question_text }}</h4>

                    {{-- Pilihan Jawaban --}}
                    <div class="space-y-3">
                        @if(is_array($question->options) || is_object($question->options))
                        @foreach($question->options as $optionIndex => $optionText)
                        <label wire:key="opt-{{ $question->id }}-{{ $optionIndex }}" class="relative w-full text-left p-4 rounded-xl border transition-all duration-200 flex items-center justify-between cursor-pointer
                                            {{-- Logika Style: Cek apakah answers[id] SAMA DENGAN optionIndex --}}
                                            {{ (string)$answers[$question->id] === (string)$optionIndex
                                                ? 'border-primary bg-primary/5 text-primary ring-1 ring-primary'
                                                : 'border-slate-200 hover:border-slate-300 text-slate-600'
                                            }}">
                            <span class="font-medium">{{ $optionText }}</span>

                            {{-- FIX: Gunakan wire:model.live agar UI update real-time --}}
                            <input type="radio" wire:model.live="answers.{{ $question->id }}" value="{{ $optionIndex }}"
                                class="hidden">

                            @if((string)$answers[$question->id] === (string)$optionIndex)
                            <div
                                class="w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center shrink-0">
                                <x-phosphor-check-bold class="w-3 h-3" />
                            </div>
                            @else
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 shrink-0"></div>
                            @endif
                        </label>
                        @endforeach
                        @else
                        <p class="text-red-500">Error: Options format invalid</p>
                        @endif
                    </div>
                    @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200 text-right sticky bottom-0 bg-white pb-4">
                <x-button type="submit" variant="primary" class="text-base" wire:loading.attr="disabled">
                    <x-slot:icon_left>
                        <x-phosphor-paper-plane-tilt-bold class="w-5 h-5" />
                    </x-slot:icon_left>
                    <span wire:loading.remove>Kirim Jawaban</span>
                    <span wire:loading>Menyimpan...</span>
                </x-button>
            </div>
        </form>
        @endif
    </div>
</div>