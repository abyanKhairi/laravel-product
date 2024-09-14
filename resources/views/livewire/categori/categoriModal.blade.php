<div class="modal fade" wire:ignore.self @close.window="$el.querySelector('[data-bs-dismiss=modal]').click();"
    id="categoryModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">{{ $title }}</h5>
                <button type="button" wire:click="cancel" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save">
                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="categories" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('categories') is-invalid @enderror"
                            id="categories" wire:model.defer="categories">
                        @error('categories')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- keterangan -->
                    <div wire:ignore x-data="{ content: @entangle('keterangan') }" x-init="$nextTick(() => {
                        ClassicEditor
                            .create(document.querySelector('#keterangan'))
                            .then(newEditor => {
                                editor = newEditor;
                                editor.model.document.on('change:data', () => {
                                    @this.set('keterangan', editor.getData());
                                });
                            })
                    })">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea x-model="content" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                            wire:model.defer="keterangan"></textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" wire:click="cancel" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('show-category-modal', event => {
            $('#categoryModal').modal('show');
        });

        window.addEventListener('hide-modal', event => {
            $('#categoryModal').modal('hide');

            if (window.editor) {
                editor.setData('');
            }
        });

        Livewire.on('editCategory', () => {
            if (window.editor) {
                editor.setData(@this.keterangan);
            }
        });
    });
</script>
