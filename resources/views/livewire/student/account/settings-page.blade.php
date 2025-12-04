<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Pengaturan Akun</h1>
        <p class="text-lg text-slate-500">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>

    <div x-data="{ tab: 'profile' }">
        {{-- Tab Headers --}}
        <div class="mb-6 border-b border-slate-200">
            <nav class="flex -mb-px space-x-6">
                <button @click="tab = 'profile'"
                    :class="tab === 'profile' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="px-1 py-3 whitespace-nowrap border-b-2 font-semibold text-sm transition-colors focus:outline-none">
                    Profil
                </button>
                <button @click="tab = 'password'"
                    :class="tab === 'password' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="px-1 py-3 whitespace-nowrap border-b-2 font-semibold text-sm transition-colors focus:outline-none">
                    Ubah Password
                </button>
                {{-- <button @click="tab = 'security'"
                    :class="tab === 'security' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="px-1 py-3 whitespace-nowrap border-b-2 font-semibold text-sm transition-colors focus:outline-none">
                    Keamanan (2FA)
                </button> --}}
            </nav>
        </div>

        {{-- Tab Content --}}
        <div>
                        {{-- 1. Profile Information Form --}}
                        <div x-show="tab === 'profile'" x-transition.opacity.duration.300ms>
                            <div class="card">
                                <form wire:submit.prevent="updateProfile">
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-slate-800 mb-1">Informasi Profil</h3>
                                        <p class="text-sm text-slate-500 mb-6">Perbarui foto, nama, dan alamat email Anda.</p>
            
                                         {{-- Avatar Upload Section --}}
                                        <div class="mb-6">
                                            <label class="form-label">Foto Profil</label>
                                            <div class="flex items-center gap-4" x-data="{ photoName: null, photoPreview: null }">
                                                {{-- Current Avatar --}}
                                                <div class="shrink-0">
                                                    @if ($photo)
                                                        <img x-show="photoPreview" :src="photoPreview" class="w-20 h-20 rounded-full object-cover">
                                                    @else
                                                         <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=065F46&color=fff' }}"
                                                             class="w-20 h-20 rounded-full object-cover" alt="{{ auth()->user()->name }}">
                                                    @endif
                                                </div>
                                                {{-- File Input --}}
                                                <div class="flex-1">
                                                    <input type="file" class="hidden"
                                                           wire:model="photo"
                                                           x-ref="photo"
                                                           x-on:change="
                                                                photoName = $refs.photo.files[0].name;
                                                                const reader = new FileReader();
                                                                reader.onload = (e) => {
                                                                    photoPreview = e.target.result;
                                                                };
                                                                reader.readAsDataURL($refs.photo.files[0]);
                                                           " />
                                                    <x-button type="button" variant="secondary" @click="$refs.photo.click()">
                                                        Pilih Foto
                                                    </x-button>
                                                    <div wire:loading wire:target="photo" class="text-sm text-slate-500 mt-1">Mengunggah...</div>
                                                    @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                                </div>
                                                 {{-- Save Button for Avatar --}}
                                                @if ($photo)
                                                    <x-button type="button" variant="primary" wire:click="saveAvatar" wire:target="saveAvatar,photo">
                                                        Simpan Foto
                                                    </x-button>
                                                @endif
                                            </div>
                                        </div>
            
                                        <div class="space-y-4 border-t border-slate-200 pt-6">
                                            <div>
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input type="text" id="name" wire:model.defer="profileState.name" class="form-input w-full">
                                                @error('name', 'updateProfileInformation') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="email" class="form-label">Alamat Email</label>
                                                <input type="email" id="email" wire:model.defer="profileState.email" class="form-input w-full">
                                                 @error('email', 'updateProfileInformation') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <x-button type="submit" variant="primary" wire:target="updateProfile">Simpan Perubahan Profil</x-button>
                                    </div>
                                </form>
                            </div>
                        </div>

            {{-- 2. Update Password Form --}}
            <div x-show="tab === 'password'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="card">
                    <form wire:submit.prevent="updatePassword">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-800 mb-1">Ubah Password</h3>
                            <p class="text-sm text-slate-500 mb-6">Pastikan Anda menggunakan password yang kuat dan
                                unik.</p>
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" id="current_password"
                                        wire:model.defer="passwordState.current_password" class="form-input w-full">
                                    @error('current_password', 'updatePassword') <span
                                        class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" id="password" wire:model.defer="passwordState.password"
                                        class="form-input w-full">
                                    @error('password', 'updatePassword') <span class="text-red-500 text-xs mt-1">{{
                                        $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" id="password_confirmation"
                                        wire:model.defer="passwordState.password_confirmation"
                                        class="form-input w-full">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <x-button type="submit" variant="primary" wire:target="updatePassword">Ubah Password
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 3. Two-Factor Authentication --}}
            {{-- <div x-show="tab === 'security'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="card p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Two-Factor Authentication (2FA)</h3>
                    <p class="text-sm text-slate-500">Fitur ini akan segera tersedia untuk meningkatkan keamanan akun
                        Anda.</p>
                </div>
            </div> --}}
        </div>
    </div>
</div>