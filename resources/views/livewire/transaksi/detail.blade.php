<div>

    <dialog id="detail" wire:ignore.self class="modal">

        <div class="modal-box">
            <h3 class="text-lg font-bold">Detail Transaksi #{{ $this->invoice }}</h3>
            <p>Customer: {{ $this->customer }}</p>
            <p>Tanggal: {{ $this->tanggal_transaction }}</p>
            <p>Total Pembayaran: Rp. {{ number_format($this->pembayaran) }}</p>
            <p>Total Kembalian: Rp. {{ number_format($this->kembalian) }}</p>
            <p>Total Harga: Rp{{ number_format($this->totalHarga) }}</p>

            <table class="table-fixed w-full mt-4">
                <thead>
                    <tr>
                        <th class="w-1/3 px-4 py-2">Produk</th>
                        <th class="w-1/3 px-4 py-2">Jumlah</th>
                        <th class="w-1/3 px-4 py-2">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->details as $detail)
                        <tr>
                            <td class="border px-4 py-2">{{ $detail->product->name }}</td>
                            <td class="border px-4 py-2">{{ $detail->qty }}</td>
                            <td class="border px-4 py-2">Rp. {{ number_format($detail->qty * $detail->product->harga) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal-action">
                <button class="btn" onclick="document.getElementById('detail').close()"
                    wire:click="close">Close</button>
            </div>
        </div>
    </dialog>
</div>
