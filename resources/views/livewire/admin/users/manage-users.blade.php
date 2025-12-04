<div>
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Manajemen Pengguna</h1>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pengguna..." class="form-input w-72" />

                {{-- Filter Role --}}
                <select wire:model.live="filterRole" class="form-input w-40">
                    <option value="">Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->value }}">{{ ucfirst($role->value) }}</option>
                    @endforeach
                </select>
            </div>

            <x-button variant="primary" wire:target="openCreateModal" wire:click="openCreateModal">
                <x-slot:icon_left>
                    <x-phosphor-plus-bold class="w-4 h-4 font-bold" />
                </x-slot:icon_left>
                Tambah
            </x-button>
        </div>

        @if($users->isEmpty())
            <div class="text-center py-10 text-muted">
                <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
                <p>Belum ada pengguna yang terdaftar.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200">
                            <th scope="col" class="px-3 py-3 font-semibold">Pengguna</th>
                            <th scope="col" class="px-3 py-3 font-semibold">Role</th>
                            <th scope="col" class="px-3 py-3 font-semibold">Status Verifikasi</th>
                            <th scope="col" class="px-3 py-3 font-semibold">Tanggal Daftar</th>
                            <th scope="col" class="px-3 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-3 py-3 flex items-center gap-3">
                                    <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}" class="w-9 h-9 rounded-full" />
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                                        <p class="text-xs text-muted">{{ $user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    @if($user->role === App\Enums\UserRole::ADMIN)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">Admin</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-700">Student</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Terverifikasi</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Belum Verifikasi</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-3 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="openEditModal({{ $user->id }})" class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition">
                                            <x-phosphor-pencil-line-bold class="icon-size-md" />
                                        </button>
                                        {{-- Jangan izinkan admin menghapus dirinya sendiri --}}
                                        @if($user->id !== auth()->id())
                                            <button @click="confirmDelete({{ $user->id }})" class="p-1 rounded-full hover:bg-red-200 text-red-500 hover:text-red-700 transition">
                                                <x-phosphor-trash-bold class="icon-size-md" />
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Modal untuk Form Create/Edit Pengguna --}}
    <x-modal id="user-form-modal" wire:model="isModalOpen" maxWidth="lg"
        :title="$editingUser ? 'Edit Pengguna: ' . $editingUser->name : 'Tambah Pengguna Baru'">

        @if ($this->isModalOpen)
            @livewire('admin.users.form-user', ['user' => $editingUser], key($editingUser?->id ?? 'new'))
        @endif
    </x-modal>
</div>
