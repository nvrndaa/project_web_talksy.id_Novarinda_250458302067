<div>
    {{-- Header Halaman --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.quizzes.index') }}" wire:navigate class="p-2 rounded-full hover:bg-slate-100">
                <x-phosphor-arrow-left-bold class="icon-size-md" />
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Konten Kuis</h1>
        </div>
        <p class="text-lg text-muted pl-11">{{ $quiz->title }} (KKM: {{ $quiz->passing_score }})</p>
    </div>

    {{-- Aksi Utama --}}
    <div class="flex justify-end mb-6">
        <x-button variant="primary" wire:click="openCreateQuestionModal">
            <x-slot:icon_left>
                <x-phosphor-plus-bold class="w-5 h-5" />
            </x-slot:icon_left>
            Tambah Pertanyaan Baru
        </x-button>
    </div>

    {{-- Daftar Pertanyaan --}}
    <div class="card p-6">
        @if($quiz->questions->isEmpty())
            <div class="text-center py-10 text-muted">
                <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
                <p>Kuis ini belum memiliki pertanyaan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200">
                            <th scope="col" class="px-3 py-3 font-semibold">Pertanyaan</th>
                            <th scope="col" class="px-3 py-3 font-semibold">Opsi Jawaban</th>
                            <th scope="col" class="px-3 py-3 font-semibold">Kunci</th>
                            <th scope="col" class="px-3 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quiz->questions as $question)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-3 py-3 font-semibold text-slate-800">{{ $question->question_text }}</td>
                                <td class="px-3 py-3">
                                    <ul class="list-disc pl-5">
                                        @foreach($question->options as $index => $option)
                                            <li>{{ $option }} @if($index == $question->correct_option_index) <x-phosphor-check-circle-fill class="w-4 h-4 text-emerald-500 inline-block" /> @endif</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-3 py-3">
                                    {{ chr(65 + $question->correct_option_index) }}
                                </td>
                                <td class="px-3 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="openEditQuestionModal({{ $question->id }})" class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition" title="Edit">
                                            <x-phosphor-pencil-line-bold class="icon-size-md" />
                                        </button>
                                        <button @click="confirmDelete({{ $question->id }})" class="p-1 rounded-full hover:bg-red-200 text-red-500 hover:text-red-700 transition" title="Hapus">
                                            <x-phosphor-trash-bold class="icon-size-md" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modal untuk Form Create/Edit Pertanyaan --}}
    <x-modal id="question-form-modal" wire:model="isModalOpen" maxWidth="xl"
        :title="$editingQuestion ? 'Edit Pertanyaan' : 'Tambah Pertanyaan Baru'">
        @if ($this->isModalOpen)
            @livewire('admin.quizzes.form-question', ['quizId' => $quiz->id, 'question' => $editingQuestion], key($editingQuestion?->id ?? 'new'))
        @endif
    </x-modal>
</div>
