<template x-if="toast.type==='debug'">
    <x-phosphor-bug class="w-6 h-6 text-slate-500" weight="duotone" />
</template>

<template x-if="toast.type==='info'">
    <x-phosphor-info class="w-6 h-6 text-blue-500" weight="duotone" />
</template>

<template x-if="toast.type==='success'">
    {{-- Menggunakan warna Primary Emerald dari app.css --}}
    <x-phosphor-check-circle class="w-6 h-6 text-emerald-600" weight="duotone" />
</template>

<template x-if="toast.type==='warning'">
    {{-- Menggunakan warna Accent/Yellow --}}
    <x-phosphor-warning class="w-6 h-6 text-yellow-500" weight="duotone" />
</template>

<template x-if="toast.type==='danger'">
    <x-phosphor-warning-octagon class="w-6 h-6 text-red-500" weight="duotone" />
</template>
