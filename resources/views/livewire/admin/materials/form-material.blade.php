<div>
    <form wire:submit="save">
        <div class="space-y-4 p-4">
            {{-- Title --}}
            <div>
                <label for="title" class="form-label">Judul Materi</label>
                <input type="text" id="title" wire:model="form.title"
                       class="form-input @error('form.title') is-invalid @enderror">
                @error('form.title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Type --}}
            <div>
                <label for="type" class="form-label">Tipe Materi</label>
                <select id="type" wire:model.live="form.type"
                        class="form-input @error('form.type') is-invalid @enderror">
                    @foreach($materialTypes as $type)
                        <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                    @endforeach
                </select>
                @error('form.type') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Conditional Inputs based on Type --}}

            {{-- Tipe: Video --}}
            @if($form->type === 'video')
                <div x-data="{
                    get videoId() {
                        try {
                            const url = new URL(this.$wire.form.content_url);
                            if (url.hostname === 'youtu.be') {
                                return url.pathname.slice(1);
                            }
                            if (url.hostname.includes('youtube.com')) {
                                return url.searchParams.get('v');
                            }
                            return '';
                        } catch (e) {
                            return '';
                        }
                    }
                }">
                    <label for="content_url" class="form-label">URL Video YouTube</label>
                    <input type="url" id="content_url" wire:model.blur="form.content_url"
                           placeholder="Contoh: https://www.youtube.com/watch?v=xxxx"
                           class="form-input @error('form.content_url') is-invalid @enderror">
                    @error('form.content_url') <p class="form-error">{{ $message }}</p> @enderror

                    {{-- Video Preview --}}
                    <template x-if="videoId">
                        <div class="mt-4 aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                             <iframe :src="`https://www.youtube.com/embed/${videoId}`"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </template>
                </div>

            {{-- Tipe: PDF --}}
            @elseif($form->type === 'pdf')
                 <div>
                    <label for="pdf_file" class="form-label">File PDF</label>
                    <input type="file" id="pdf_file" wire:model="pdf_file"
                           class="form-file @error('pdf_file') is-invalid @enderror">
                     <div wire:loading wire:target="pdf_file" class="text-sm text-slate-500 mt-1">Mengunggah file...</div>
                    @error('pdf_file') <p class="form-error">{{ $message }}</p> @enderror

                     @if ($form->content_url && !$pdf_file)
                         <p class="text-sm text-slate-500 mt-2">File saat ini: <a href="{{ Storage::url($form->content_url) }}" target="_blank" class="text-primary hover:underline">{{ basename($form->content_url) }}</a></p>
                     @endif
                </div>

            {{-- Tipe: Teks --}}
            @elseif($form->type === 'text')
                <div>
                    <label for="content_body" class="form-label">Isi Teks Materi</label>
                    <textarea id="content_body" wire:model="form.content_body" rows="8"
                              class="form-input @error('form.content_body') is-invalid @enderror"></textarea>
                    @error('form.content_body') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            @endif
        </div>

        <div class="modal-footer">
            <x-button type="button" variant="secondary" @click="$dispatch('close-modal')">Batal</x-button>
            <x-button type="submit" variant="primary">Simpan Materi</x-button>
        </div>
    </form>
</div>
