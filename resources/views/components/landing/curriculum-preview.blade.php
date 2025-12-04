@props(['modules' => []])

<section id="kurikulum" class="section-padding bg-slate-50">
    <div class="container">
        <div class="text-center mb-16">
            <h2 class="section-title">Kurikulum Tersusun Rapi</h2>
            <p class="section-subtitle">Materi disusun bertahap (Step-by-step) agar mudah dipahami pemula.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            @foreach ($modules as $module)
            <div class="card flex flex-col">
                <div class="p-6 bg-linear-to-br from-slate-50 to-white border-b border-slate-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded">Modul {{
                            $module->order_index }}</span>
                        {{-- Progress bar dihilangkan karena tidak relevan untuk pengunjung --}}
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $module->title }}</h3>
                    <p class="text-sm text-slate-500 line-clamp-2">{{ $module->description }}</p>
                </div>

                <div class="p-4 flex-1">
                    <ul class="space-y-3">
                        @foreach ($module->materials as $material)
                        <li class="flex items-center gap-3 p-2">
                            <div @class([
                                'w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                                'bg-slate-100 text-slate-400'
                                ])>
                                @if ($material->type === 'video')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z">
                                    </path>
                                </svg>
                                @else
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700">{{
                                    $material->title }}</p>
                                <p class="text-xs text-slate-400 capitalize">{{ $material->type }}</p>
                            </div>

                            {{-- Ikon checkmark dihilangkan karena tidak relevan untuk pengunjung --}}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer">
                     {{-- Tombol dihilangkan karena pengunjung tidak bisa mengerjakan kuis --}}
                     <div class="text-center text-xs text-slate-400 py-2">Dan materi lainnya...</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
