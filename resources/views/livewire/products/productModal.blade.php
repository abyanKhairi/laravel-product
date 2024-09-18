<dialog wire:ignore.self id="productModal" class="modal">
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="modal-box">
        <h3 class="font-bold text-lg">{{ $title }}</h3>

        <div class="modal-body">
            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input class="input input-bordered w-full @error('name') input-error @enderror" id="name"
                    wire:model="name">
                @error('name')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Product Description -->
            <div wire:ignore x-data="{ content: @entangle('description') }" x-init="$nextTick(() => {
                ClassicEditor.create(document.querySelector('#description'))
                    .then(newEditor => {
                        editor = newEditor;
                        editor.model.document.on('change:data', () => {
                            @this.set('description', editor.getData());
                        });
                    });
            })">
                <label for="description" class="form-label">Product Description</label>
                <textarea x-model="content" class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                    id="description" wire:model.defer="description"></textarea>
                @error('description')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select wire:model="category_id"
                    class="select select-bordered w-full @error('category_id') select-error @enderror" id="category">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->categories }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Quantity -->
            <div class="mb-3">
                <label for="jumlah" class="form-label">Product Quantity</label>
                <input type="number" class="input input-bordered w-full @error('jumlah') input-error @enderror"
                    id="jumlah" wire:model="jumlah">
                @error('jumlah')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="harga" class="form-label">Product Price</label>
                <input type="number" class="input input-bordered w-full @error('harga') input-error @enderror"
                    id="harga" wire:model="harga">
                @error('harga')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file"
                    class="file-input file-input-bordered w-full @error('image') input-error @enderror" id="image"
                    wire:model="image">
                @error('image')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
            

            {{-- <div class="items-center justify-center ">
                <img class="object-contain" src="{{ asset('storage/' . $image) }}" alt="{{ $image }}"
                    style="width: auto; height: auto;">
            </div> --}}
        </div>

        <div class="modal-action">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" wire:click="cancel" class="btn">Cancel</button>
        </div>
    </form>
</dialog>


<script>
    document.addEventListener('DOMContentLoaded', function() {



        Livewire.on('editProduct', () => {
            if (window.editor) {
                editor.setData(@this.description);
            }
        });
    });

    window.addEventListener('hide-modal', event => {
        document.getElementById('productModal').close();

        if (window.editor) {
            editor.setData('');
        }
    });

    Livewire.on('editProduct', () => {
        if (window.editor) {
            editor.setData(@this.description);
        }
    });
</script>
