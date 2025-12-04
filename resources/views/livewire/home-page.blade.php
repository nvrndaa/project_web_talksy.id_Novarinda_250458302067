<div>
    <x-slot:title>
        Talksy.id - Belajar Bahasa Inggris Berkah & Profesional
    </x-slot:title>

    <main>
        {{-- Navbar --}}
        <x-landing.navbar :links="$navLinks" />

        {{-- Hero Section --}}
        <x-landing.hero />

        {{-- Stats Section --}}
        <x-landing.stats :stats="$stats" />

        {{-- Curriculum Preview Section --}}
        <x-landing.curriculum-preview :modules="$modules" />

        {{-- Evaluation & Certificate Section --}}
        <x-landing.evaluation />

        {{-- Call To Action & Footer --}}
        <x-landing.cta-footer />
        
        {{-- The main-footer is currently empty as cta-footer handles the whole section --}}
        {{-- <x-landing.main-footer /> --}}
    </main>
</div>
