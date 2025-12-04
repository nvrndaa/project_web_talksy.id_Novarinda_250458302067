<div class="relative overflow-hidden bg-white rounded-xl shadow-lg border border-slate-100 cursor-pointer select-none hover:bg-slate-50 transition duration-300"
    x-bind:class="{
        'border-l-4 border-l-blue-500': toast.type === 'info',
        'border-l-4 border-l-emerald-600': toast.type === 'success', {{-- Menggunakan Primary Emerald --}}
        'border-l-4 border-l-yellow-500': toast.type === 'warning', {{-- Menggunakan Accent Gold/Yellow --}}
        'border-l-4 border-l-red-500': toast.type === 'danger'
    }">
    <div class="p-4 flex items-start space-x-4 rtl:space-x-reverse">
        {{-- Icon Section --}}
        <div class="shrink-0 mt-0.5">
            @include('tall-toasts::includes.icon')
        </div>

        {{-- Text Section --}}
        <div class="flex-1 w-0">
            <div class="text-sm font-bold text-slate-900 font-sans mb-0.5" x-html="toast.title"
                x-show="toast.title !== undefined"></div>

            <div class="text-sm text-slate-600 leading-snug font-sans" x-show="toast.message !== undefined"
                x-html="toast.message"></div>
        </div>

        {{-- Close Button (Optional Visual Indicator) --}}
        <div class="shrink-0 ml-4 flex self-start">
            <button class="text-slate-400 hover:text-slate-600 transition">
                <span class="sr-only">Close</span>
                <x-phosphor-x class="w-4 h-4" />
            </button>
        </div>
    </div>
</div>
