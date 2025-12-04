@props([
'options' => [],
'placeholder' => '-- Pilih Opsi --',
'wireModel'
])

<div x-data="{
        open: false,
        selected: @entangle($wireModel),
        value: '{{ $placeholder }}',
        options: {{ json_encode($options) }},

        init() {
this.updateValue();
            this.$watch('selected', () => this.updateValue());
        },

updateValue() {
        let found = this.options.find(option => option.value == this.selected);
        this.value = found ? found.label : '{{ $placeholder }}';
        },
        
        selectOption(val) {
        this.selected = val;
        this.open = false;
        }
}" @click.away="open = false" class="relative w-full">
    {{-- Hidden Native Select (Untuk Form Compatibility) --}}
    <select class="hidden" {{ $attributes->whereStartsWith('wire:model') }}>
<option value="">{{ $placeholder }}</option>
        @foreach($options as $option)
<option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
        @endforeach
    </select>

{{-- TRIGGER BUTTON --}}
    <button type="button" @click="open = !open"
        class="relative w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-left shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary flex items-center justify-between group"
        :class="{ 'border-primary ring-2 ring-primary/20': open }">
        {{-- Label Text --}}
        <span class="block truncate text-sm font-medium" :class="selected ? 'text-slate-800' : 'text-slate-400'"
            x-text="value"></span>
    
        {{-- Chevron Icon (Rotates when open) --}}
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
            <svg class="h-5 w-5 text-slate-400 transition-transform duration-200 group-hover:text-primary"
                :class="{ 'rotate-180 text-primary': open }" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 256 256">
                <path
                    d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                </path>
            </svg>
        </span>
    </button>

{{-- DROPDOWN PANEL --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-75"
x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
        class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 max-h-60 overflow-auto focus:outline-none py-1"
        style="display: none;">
        <ul class="divide-y divide-slate-50">
            @foreach ($options as $option)
<li class="group relative cursor-pointer select-none py-2.5 pl-4 pr-9 text-sm transition-colors hover:bg-primary/5"
                :class="{ 'bg-primary/10 text-primary font-semibold': selected == '{{ $option['value'] }}', 'text-slate-600': selected != '{{ $option['value'] }}' }"
                @click="selectOption('{{ $option['value'] }}')">
                {{-- Option Label --}}
                <span class="block truncate" :class="{ 'font-semibold': selected == '{{ $option['value'] }}' }">
                    {{ $option['label'] }}
</span>
                
                {{-- Checkmark Icon (Only shows if selected) --}}
                <span x-show="selected == '{{ $option['value'] }}'"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-primary">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                        </path>
                    </svg>
                </span>
                </li>
            @endforeach
        </ul>
{{-- Empty State (Optional) --}}
@if(empty($options))
<div class="px-4 py-3 text-sm text-slate-400 italic text-center">
    Tidak ada opsi tersedia.
</div>
@endif
    </div>
</div>
