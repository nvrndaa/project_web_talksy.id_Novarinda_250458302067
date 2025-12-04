<div>
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Manajemen Kuis</h1>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kuis..."
                    class="form-input w-72" />
            </div>
            <x-button variant="primary" wire:target="openCreateModal" wire:click="openCreateModal">
                <x-slot:icon_left>
                    <x-phosphor-plus-bold class="w-4 h-4" />
                </x-slot:icon_left>
                Tambah
            </x-button>
        </div>

        @if($quizzes->isEmpty())
        <div class="text-center py-10 text-muted">
            <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
            <p>Belum ada kuis yang terdaftar.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 border-b border-slate-200">
                        <th scope="col" class="px-3 py-3 font-semibold">Judul Kuis</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Modul</th>
                        <th scope="col" class="px-3 py-3 font-semibold">KKM</th>
                        <th scope="col" class="px-3 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $quiz->title }}</p>
                        </td>
                        <td class="px-3 py-3">{{ $quiz->module->title ?? 'N/A' }}</td>
                        <td class="px-3 py-3">{{ $quiz->passing_score }}</td>
                        <td class="px-3 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.quizzes.show', $quiz) }}" wire:navigate class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition" title="Kelola Pertanyaan">
                                    <x-phosphor-question-duotone class="icon-size-md" />
                                </a>
                                <button wire:click="openEditModal({{ $quiz->id }})" class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition" title="Edit">
                                    <x-phosphor-pencil-line-bold class="icon-size-md" />
                                </button>
                                <button @click="confirmDelete({{ $quiz->id }})" class="p-1 rounded-full hover:bg-red-200 text-red-500 hover:text-red-700 transition" title="Hapus">
                                    <x-phosphor-trash-bold class="icon-size-md" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $quizzes->links() }}
        </div>
        @endif
    </div>

    {{-- Modal untuk Form Create/Edit Kuis --}}
    <x-modal id="quiz-form-modal" wire:model="isModalOpen" maxWidth="lg"
        :title="$editingQuiz ? 'Edit Kuis' : 'Tambah Kuis Baru'">

        @if ($this->isModalOpen)
        @livewire('admin.quizzes.form-quiz', ['quiz' => $editingQuiz], key($editingQuiz?->id ?? 'new'))
        @endif
    </x-modal>
</div>
