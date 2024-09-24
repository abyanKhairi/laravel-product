<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Categories</h1>

    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <button type="button" class="btn bg-gray-800 text-white font-bold hover:!text-black p-3 rounded mb-3"
        onclick="categoryModal.showModal()">
        Add Category
    </button>

    <div class="card shadow-lg">
        <div class="card-header bg-gray-800 text-white font-bold p-4">Categories</div>
        <div class="card-body p-4">

            <div class="flex mb-4 gap-2">
                <input type="text" class="border border-gray-300 p-2 rounded" wire:model.live="search"
                    placeholder="Search Categories...">
                <select class="border border-gray-300 p-2 rounded" wire:model.live="pagi">
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
                        <x-table.th scope="col">Name</x-table.th>
                        <x-table.th scope="col">Description</x-table.th>
                        <x-table.th scope="col">Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($kategori as $category)
                        <tr wire:key="{{ $category->id }}">
                            <x-table.td scope="row">{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $category->categories }}</x-table.td>
                            <x-table.td>{!! $category->keterangan !!}</x-table.td>
                            <x-table.td>
                                <button wire:click="edit({{ $category->id }})" class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal" onclick="categoryModal.showModal()"> <i
                                        class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    @click="$dispatch('alert', {get_id: {{ $category->id }}})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td colspan="4">
                                <span class="text-danger text-red-500 font-bold">
                                    No Categories Found!
                                </span>
                            </x-table.td>
                        </tr>
                    @endforelse
                </x-table.tbody>
            </x-table>

            <div>
                @if ($kategori->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation">
                        <span>
                            @if ($kategori->onFirstPage())
                                <span class="pr-3 text-zinc-400">Previous</span>
                            @else
                                <button class="pr-3" wire:click="previousPage" wire:loading.attr="disabled"
                                    rel="prev">
                                    Previous
                                </button>
                            @endif
                        </span>

                        <span class="px-3 text-white rounded-lg border-solid bg-slate-700">
                            {{ $kategori->currentPage() }}
                        </span>

                        <span>
                            @if ($kategori->onLastPage())
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

    @include('livewire.categori.categoriModal')
    <x-delete-alert />
</div>
