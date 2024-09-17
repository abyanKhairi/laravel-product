<div class="modal fade" wire:ignore.self @close.window="$el.querySelector('[data-bs-dismiss=modal]').click();"
    id="productModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">{{ $title }}</h5>
                <button type="button" wire:click="cancel" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                            wire:model="name"></input>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div wire:ignore x-data="{ content: @entangle('description') }" x-init="$nextTick(() => {
                        ClassicEditor
                            .create(document.querySelector('#description'))
                            .then(newEditor => {
                                editor = newEditor;
                                editor.model.document.on('change:data', () => {
                                    @this.set('description', editor.getData());
                                });
                            })
                    })">
                        <label for="description" class="form-label">Product description</label>
                        <textarea x-model="content" class="form-control @error('description') is-invalid @enderror" id="description"
                            wire:model.defer="description"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select wire:model="category_id" class="form-control @error('category_id') is-invalid @enderror"
                            id="category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->categories }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Product Quantity</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                            wire:model="jumlah">
                        @error('jumlah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="harga" class="form-label">Product Price</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga"
                            wire:model="harga">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            wire:model="image">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Display existing image -->
                        {{-- @if ($product_id && ($product = \App\Models\Product::find($product_id) && $product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                class="img-fluid mt-2">
                        @endif --}}
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" wire:click="cancel" class="btn btn-danger"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('show-product-modal', event => {
            $('#productModal').modal('show');
        });

        window.addEventListener('hide-modal', event => {
            $('#productModal').modal('hide');

            if (window.editor) {
                editor.setData('');
            }
        });

        Livewire.on('editProduct', () => {
            if (window.editor) {
                editor.setData(@this.description);
            }
        });
    });

    Livewire.on('editProduct', () => {
        if (window.editor) {
            editor.setData(@this.description);
        }
    });
</script>
