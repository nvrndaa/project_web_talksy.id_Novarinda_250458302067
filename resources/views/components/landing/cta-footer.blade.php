<footer class="bg-primary text-white pt-20 pb-10">
    <div class="container text-center">
        <h2 class="section-title text-white!">Siap Memulai Perjalanan Anda?</h2>
        <p class="text-emerald-100 mb-10 max-w-2xl mx-auto">Bergabunglah dengan ribuan penuntut ilmu lainnya. Akses
            materi seumur hidup dan update gratis.</p>

        @if(Route::has('login'))
        @auth
        <x-button href="{{ route('student.dashboard') }}" variant="accent" class="px-10 py-4 mb-20">
            Dashboard Student
        </x-button>
        @else
        <x-button href="{{ route('register') }}" variant="accent" class="px-10 py-4 mb-20">
            Daftar Akun Student
        </x-button>
        @endauth
        @endif

        <div
            class="border-t border-emerald-700 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-emerald-200">
            <p>&copy; {{ date('Y') }} Talksy.id. Built with Amanah.</p>
            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
