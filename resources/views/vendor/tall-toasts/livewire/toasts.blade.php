<div x-data='ToastComponent($wire)' @mouseleave="scheduleRemovalWithOlder()"
    class="fixed right-4 bottom-4 sm:top-4 sm:bottom-auto z-50 flex flex-col gap-3 w-full max-w-sm pointer-events-none"
    style="z-index: 9999;">
    <template x-for="toast in toasts.filter((a)=>a)" :key="toast.index">
        <div @mouseenter="cancelRemovalWithNewer(toast.index)" @mouseleave="scheduleRemovalWithOlder(toast.index)"
            @click="remove(toast.index)" x-show="toast.show===1" {{-- Animasi Smooth Slide & Fade --}}
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-8 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" x-init="$nextTick(()=>{toast.show=1})"
            class="pointer-events-auto transition-all">
            @include('tall-toasts::includes.content')
        </div>
    </template>
</div>
