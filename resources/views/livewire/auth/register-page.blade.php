<div class="auth-card">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-extrabold text-dark">Buat Akun Baru</h1>
        <p class="text-muted">Mulailah perjalanan belajar Anda bersama kami.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="space-y-5">
            {{-- Name --}}
            <div>
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="form-input @error('name') is-invalid @enderror">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="form-input @error('email') is-invalid @enderror">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Password --}}
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" required
                       class="form-input @error('password') is-invalid @enderror">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input">
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="btn btn-primary w-full py-3 text-base">
                    Daftar
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8 text-center text-sm">
        <p class="text-muted">
            Sudah punya akun?
            <a href="{{ route('login') }}" wire:navigate class="font-semibold text-primary hover:underline">
                Masuk di sini
            </a>
        </p>
    </div>
</div>
