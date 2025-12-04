<div>
    <form wire:submit="save">
        <div class="space-y-4 p-4">
            {{-- Title --}}
            <div>
                <label for="title" class="form-label">Judul Modul</label>
                <input type="text" id="title" wire:model="form.title"
                       class="form-input @error('form.title') is-invalid @enderror">
                @error('form.title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" wire:model="form.description" rows="3"
                          class="form-input @error('form.description') is-invalid @enderror"></textarea>
                @error('form.description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Order Index --}}
            <div>
                <label for="order_index" class="form-label">Urutan</label>
                <input type="number" id="order_index" wire:model="form.order_index"
                       class="form-input @error('form.order_index') is-invalid @enderror">
                @error('form.order_index') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Is Active --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_active" wire:model="form.is_active" class="form-check-input">
                <label for="is_active" class="form-check-label">Aktif</label>
            </div>
        </div>

        <div class="modal-footer">
            <x-button type="button" variant="secondary" @click="$dispatch('close-modal')">Batal</x-button>
            <x-button wire:target="save" type="submit" variant="primary">Simpan Modul</x-button>
        </div>
    </form>
</div>
