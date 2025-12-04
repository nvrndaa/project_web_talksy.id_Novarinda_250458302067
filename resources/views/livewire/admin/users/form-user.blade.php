<div>
    <form wire:submit="save">
        <div class="space-y-4 p-4">
            {{-- Name --}}
            <div>
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" wire:model="form.name"
                       class="form-input @error('form.name') is-invalid @enderror">
                @error('form.name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" wire:model="form.email"
                       class="form-input @error('form.email') is-invalid @enderror">
                @error('form.email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" wire:model="form.password"
                       class="form-input @error('form.password') is-invalid @enderror"
                       autocomplete="new-password">
                @error('form.password') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" wire:model="form.password_confirmation"
                       class="form-input @error('form.password_confirmation') is-invalid @enderror"
                       autocomplete="new-password">
                @error('form.password_confirmation') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="form-label">Role</label>
                <select id="role" wire:model="form.role"
                        class="form-input @error('form.role') is-invalid @enderror">
                    @foreach($roles as $role)
                        <option value="{{ $role->value }}">{{ ucfirst($role->value) }}</option>
                    @endforeach
                </select>
                @error('form.role') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button type="button" variant="secondary" @click="$dispatch('close-modal')">Batal</x-button>
            <x-button type="submit" variant="primary">Simpan Pengguna</x-button>
        </div>
    </form>
</div>
