<div class="auth-card">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-extrabold text-dark">Selamat Datang Kembali</h1>
        <p class="text-muted">Silakan masuk untuk melanjutkan belajar.</p>
    </div>

    {{-- Menampilkan error global dari Fortify (misal: "These credentials do not match our records.") --}}
    {{-- @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
            {{ $errors->first() }}
        </div>
    @endif --}}

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-5">
            {{-- Email --}}
            <div>
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="form-input @error('email') is-invalid @enderror">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <div class="flex justify-between items-center">
                    <label for="password" class="form-label">Password</label>
                    <a href="{{ route('password.request') }}" wire:navigate tabindex="-1"
                       class="text-sm text-primary hover:underline">Lupa Password?</a>
                </div>
                <input type="password" id="password" name="password" required
                       class="form-input @error('password') is-invalid @enderror">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox" class="form-check-input" />
                    <label for="remember" class="form-check-label">Ingat saya</label>
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="btn btn-primary w-full py-3 text-base">
                    Masuk
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8 text-center text-sm">
        <p class="text-muted">
            Belum punya akun?
            <a href="{{ route('register') }}" wire:navigate class="font-semibold text-primary hover:underline">
                Daftar di sini
            </a>
        </p>
    </div>
</div>
