<div class="form-group mb-3" wire:ignore>
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    <div x-data="{
        editor: null,
        content: @this.get('{{ $model }}'),
        init() {
            this.editor = new Quill($refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'blockquote', 'code-block'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']
                    ]
                }
            });

            if (this.content) {
                this.editor.root.innerHTML = this.content;
                @this.set('{{ $model }}', this.content);
            }
            this.editor.on('text-change', () => {
                this.content = this.editor.root.innerHTML;
                @this.set('{{ $model }}', this.content);
            });
        }
    }">
        <div x-ref="editor" id="{{ $id }}" style="min-height: {{ $height }};"></div>
    </div>
    @error($model)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
