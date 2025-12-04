<form wire:submit="save">
    <div class="space-y-4">
        {{-- Judul Kuis --}}
        <div>
            <label for="title" class="form-label">Judul Kuis</label>
            <input type="text" id="title" wire:model="form.title" class="form-input" placeholder="Contoh: Kuis Modul 1: Pengenalan Laravel">
            @error('form.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Modul Terkait --}}
        <div>
            <label for="module_id" class="form-label">Pilih Modul</label>
            <select id="module_id" wire:model="form.module_id" class="form-select">
                <option value="">-- Pilih Modul --</option>
                @foreach ($form->getModuleOptions() as $id => $title)
                    <option value="{{ $id }}">{{ $title }}</option>
                @endforeach
            </select>
            @error('form.module_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Nilai Kelulusan Minimal (Passing Score) --}}
        <div>
            <label for="passing_score" class="form-label">Nilai Kelulusan Minimal (KKM)</label>
            <input type="number" id="passing_score" wire:model="form.passing_score" class="form-input" min="0" max="100">
            @error('form.passing_score') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <x-button type="submit" variant="primary">
            <x-slot:icon_left>
                <x-phosphor-floppy-disk-bold class="w-4 h-4" />
            </x-slot:icon_left>
            Simpan Kuis
        </x-button>
    </div>
</form>
