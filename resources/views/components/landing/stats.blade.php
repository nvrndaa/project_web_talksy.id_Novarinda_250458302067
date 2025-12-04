@props(['stats' => []])

<section class="border-y border-slate-200 bg-white">
    <div class="container py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach ($stats as $stat)
            <div>
                <div class="text-3xl font-bold text-primary mb-1">{{ $stat['value'] }}</div>
                <div class="text-sm text-slate-500">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
