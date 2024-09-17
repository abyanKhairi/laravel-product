<dialog wire:ignore.self id="categoryModal" class="modal">
    <form wire:submit.prevent="save" class="modal-box">
        <h3 class="font-bold text-lg">{{ $title }}</h3>

        <div class="modal-body">
            <!-- Category Name -->
            <div class="mb-3">
                <label for="categories" class="form-label">Category Name</label>
                <input type="text" class="form-control @error('categories') is-invalid @enderror" id="categories"
                    wire:model.defer="categories">
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
        </div>
    </form>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        Livewire.on('editCategory', () => {
            if (window.editor) {
                editor.setData(@this.keterangan);
            }
        });
    });

    window.addEventListener('hide-modal', event => {
        document.getElementById('categoryModal').close();

        if (window.editor) {
            editor.setData('');
        }
    });

    Livewire.on('editCategory', () => {
        if (window.editor) {
            editor.setData(@this.keterangan);
        }
    });
</script>
