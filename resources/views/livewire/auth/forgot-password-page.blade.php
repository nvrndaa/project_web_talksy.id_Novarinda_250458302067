<div class="auth-card">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-extrabold text-dark">Lupa Password Anda?</h1>
        <p class="text-muted">Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan tautan untuk reset password.</p>
    </div>

    {{-- Menampilkan status session dari Fortify --}}
    @if (session('status'))
        <div class="mb-4 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="btn btn-primary w-full py-3 text-base">
                    Kirim Tautan Reset Password
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8 text-center text-sm">
        <p class="text-muted">
            Ingat password Anda?
            <a href="{{ route('login') }}" wire:navigate class="font-semibold text-primary hover:underline">
                Kembali ke halaman Login
            </a>
        </p>
    </div>
</div>
