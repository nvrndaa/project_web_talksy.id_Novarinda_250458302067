<form wire:submit="save">
    <div class="space-y-4">
        {{-- Teks Pertanyaan --}}
        <div>
            <label for="question_text" class="form-label">Teks Pertanyaan</label>
            <textarea id="question_text" wire:model="form.question_text" class="form-input" rows="3" placeholder="Contoh: Apa nama ibukota Indonesia?"></textarea>
            @error('form.question_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Opsi Jawaban --}}
        <div>
            <label class="form-label mb-2 block">Opsi Jawaban (Pilih satu sebagai kunci jawaban)</label>
            @foreach($form->options as $index => $option)
                <div class="flex items-center gap-2 mb-2">
                    <input type="radio" wire:model="form.correct_option_index" value="{{ $index }}" id="correct_option_{{ $index }}" class="form-radio">
                    <label for="correct_option_{{ $index }}" class="sr-only">Opsi {{ chr(65 + $index) }}</label>
                    <input type="text" wire:model="form.options.{{ $index }}" class="form-input flex-grow" placeholder="Opsi {{ chr(65 + $index) }}">
                    @if(count($form->options) > 2)
                        <button type="button" wire:click="removeOption({{ $index }})" class="p-2 rounded-full hover:bg-red-100 text-red-500" title="Hapus Opsi">
                            <x-phosphor-x-bold class="w-4 h-4" />
                        </button>
                    @endif
                </div>
                @error('form.options.'.$index) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            @endforeach
            @error('form.options') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            @error('form.correct_option_index') <span class="text-red-500 text-xs">Pilih salah satu kunci jawaban.</span> @enderror

            <x-button type="button" variant="secondary" wire:click="addOption" class="mt-2">
                <x-slot:icon_left>
                    <x-phosphor-plus-bold class="w-4 h-4" />
                </x-slot:icon_left>
                Tambah Opsi
            </x-button>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <x-button type="submit" variant="primary">
            <x-slot:icon_left>
                <x-phosphor-floppy-disk-bold class="w-4 h-4" />
            </x-slot:icon_left>
            Simpan Pertanyaan
        </x-button>
    </div>
</form>
