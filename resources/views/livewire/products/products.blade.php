<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Products</h1>

    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    </button>
    <button type="button" class="bg-gray-800 text-white font-bold p-3 rounded mb-3" onclick="productModal.showModal()">
        Add Product
    </button>


    <div class="card shadow-lg">
        <div class="card-header bg-gray-800 text-white font-bold p-4">Products</div>
        <div class="card-body p-4">

            <div class="flex mb-4 gap-2">
                <input type="text" class="border border-gray-300 p-2 rounded" wire:model.live="search"
                    placeholder="Search Product...">
                <select class="border border-gray-300 p-2 rounded" wire:model.live="pagi" id="">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                </select>
            </div>
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th scope="col">S#</x-table.th>
                        <x-table.th scope="col">Images</x-table.th>
                        <x-table.th scope="col">Name</x-table.th>
                        <x-table.th scope="col">Description</x-table.th>
                        <x-table.th scope="col">Jumlah</x-table.th>
                        <x-table.th scope="col">Harga</x-table.th>
                        <x-table.th scope="col">Kategori</x-table.th>
                        <x-table.th scope="col">Action</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($products as $product)
                        <tr :product="$product" wire:key="{{ $product->id }}">
                            <x-table.td scope="row">{{ $loop->iteration }}</x-table.td>
                            <x-table.img>
                                @if ($product->image)
                                    <img class="object-contain" src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}" style="width: 100px; height: auto;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </x-table.img>

                            <x-table.td>{{ $product->name }}</x-table.td>
                            <x-table.td>{!! $product->description !!}</x-table.td>
                            <x-table.td>{{ $product->jumlah }}</x-table.td>
                            <x-table.td>Rp. {{ $product->harga }}</x-table.td>
                            <x-table.td>{{ $product->category->categories }}</x-table.td>
                            <x-table.td>
                                <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm"
                                    onclick="productModal.showModal()">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    @click="$dispatch('alert', {get_id: {{ $product->id }}})"> <i
                                        class="bi bi-trash"></i> Delete
                                </button>
                                {{-- <a href="{{ route('product.edit', $product->id) }}" wire:navigate>EDIT</a> --}}
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td colspan="4">
                                <span class="text-danger">
                                    <strong>No Product Found!</strong>
                                </span>
                            </x-table.td>
                        </tr>
                    @endforelse
                </x-table.tbody>
            </x-table>
            <div>
                <div>
                    @if ($products->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation">
                            <span>
                                @if ($products->onFirstPage())
                                    <span class="pr-3 text-zinc-400">Previous</span>
                                @else
                                    <button class="pr-3" wire:click="previousPage" wire:loading.attr="disabled"
                                        rel="prev">
                                        Previous
                                    </button>
                                @endif
                            </span>

                            <span class="px-3 text-white rounded-lg border-solid bg-slate-700">
                                {{ $products->currentPage() }}
                            </span>

                            <span>
                                @if ($products->onLastPage())
                                    <span class="pl-3 text-zinc-400">Next</span>
                                @else
                                    <button class="pl-3" wire:click="nextPage" wire:loading.attr="disabled"
                                        rel="next">
                                        Next
                                    </button>
                                @endif
                            </span>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @include('livewire.products.productModal')
    <x-delete-alert />
</div>
