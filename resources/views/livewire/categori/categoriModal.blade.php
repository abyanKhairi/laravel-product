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

            <div wire:ignore x-data="{ content: @entangle('keterangan') }" x-init="$nextTick(() => {
                ClassicEditor
                    .create($refs.keterangan)
                    .then(newEditor => {
                        editor = newEditor;
                        editor.model.document.on('change:data', () => {
                            content = editor.getData();
                        });
            
                        $watch('content', value => {
                            if (value !== editor.getData()) {
                                editor.setData(value);
                            }
                        });
                    });
            })">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea x-ref="keterangan" x-model="content" class="form-control @error('keterangan') is-invalid @enderror"></textarea>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <!-- Save and Cancel Buttons -->
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" wire:click="cancel" class="btn btn-danger" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</dialog>

<script>
    window.addEventListener('hide-modal', event => {
        document.getElementById('categoryModal').close();

        if (window.editor) {
            editor.setData('');
        }
    });
</script>
