<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Transaction List</h1>

    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <a wire:navigate href="{{ route('transaksi') }}"
        class="btn bg-gray-800 font-bold text-white p-3 hover:!text-black rounded mb-3">
        Make Transaction
    </a>

    <div class="card shadow-lg">
        <div class="card-header bg-gray-800 text-white font-bold p-4">Transactions</div>
        <div class="card-body p-4">
            <div class="flex mb-4 gap-2">
                <input type="text" class="border border-gray-300 p-2 rounded" wire:model.live="search"
                    placeholder="Search Transactions...">
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
                        <x-table.th>Invoice</x-table.th>
                        <x-table.th>Customer</x-table.th>
                        <x-table.th>Transaction Date</x-table.th>
                        <x-table.th>Total</x-table.th>
                        <x-table.th>Bayar</x-table.th>
                        <x-table.th>Kembali</x-table.th>
                        <x-table.th>Action</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($transaksi as $transaction)
                        <tr>
                            <x-table.td>{{ $transaction->invoice }}</x-table.td>
                            <x-table.td>{{ $transaction->customer ? $transaction->customer : 'Customer' }}</x-table.td>
                            <x-table.td>{{ \Carbon\Carbon::parse($transaction->tanggal_transaction)->format('d/m/Y') }}</x-table.td>
                            <x-table.td>Rp.
                                {{ number_format($transaction->total_keseluruhan) }}
                            </x-table.td>

                            <x-table.td>Rp.
                                {{ number_format($transaction->pembayaran) }}</x-table.td>

                            <x-table.td>Rp.
                                {{ number_format($transaction->kembalian) }}</x-table.td>
                            <x-table.td>
                                <button class="btn btn-primary btn-sm" wire:click="detail({{ $transaction->id }})"
                                    onclick="detail.showModal()"> <i class="bi bi-pen"></i>Detail</button>

                                <button class="btn btn-danger btn-sm"
                                    @click="$dispatch('alert', {get_id: {{ $transaction->id }}})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>

                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td colspan="4">
                                <span class="text-danger text-red-500 font-bold">
                                    No Transaction Found!
                                </span>
                            </x-table.td>
                        </tr>
                    @endforelse
                </x-table.tbody>
            </x-table>
            <div class="mt-4">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>
    @include('livewire.transaksi.detail')
    <x-delete-alert />
</div>

<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('openModal', () => {
            document.getElementById('detail').showModal();
        });
    });

    window.addEventListener('hide-modal', event => {
        document.getElementById('detail').close();

        if (window.editor) {
            editor.setData('');
        }
    });
</script>
