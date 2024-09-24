<div class="container mx-auto py-5 px-4 lg:px-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Transaction</h1>

    <!-- Display Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-6 shadow-lg">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('kurang'))
        <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-lg">
            {{ session('kurang') }}
        </div>
    @endif

    <div class="card bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="card-header bg-gray-800 text-white font-bold p-4">Transaction Detail</div>
        <div class="card-body p-6">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Customer Details -->
                <div class="mb-6">
                    <label for="customer" class="block text-gray-700 font-semibold mb-2">Customer Name</label>
                    <input type="text" id="customer" wire:model="customer"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('customer')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="invoice" class="block text-gray-700 font-semibold mb-2">Invoice</label>
                    <input type="text" id="invoice"
                        class="w-full p-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $invoice }}"
                        readonly>
                </div>

                <div class="mb-6">
                    <label for="tanggal_transaction" class="block text-gray-700 font-semibold mb-2">Transaction
                        Date</label>
                    <input type="date" id="tanggal_transaction" wire:model="tanggal_transaction"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal_transaction')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <div class="mb-6">
                    <label for="product" class="block text-gray-700 font-semibold mb-2">Select Product</label>
                    <select id="product" required wire:model="selectedProductId"
                        class="w-full p-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - Rp. {{ $product->harga }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button wire:click="addToCart"
                class="bg-blue-600 ml-40 text-white w-3/12 px-4 py-2 rounded-lg hover:bg-blue-700 transition">Add to
                Cart</button>


            <!-- Cart and Transaction Details -->
            <h3 class="text-2xl font-bold mt-8 mb-6 text-gray-800">Cart</h3>
            <table class="w-full mb-8 table-auto border-collapse border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-3 text-left text-gray-700">Product</th>
                        <th class="px-4 py-3 text-left text-gray-700">Jumlah</th>
                        <th class="px-4 py-3 text-left text-gray-700">Price</th>
                        <th class="px-4 py-3 text-left text-gray-700">Quantity</th>
                        <th class="px-4 py-3 text-left text-gray-700">Total</th>
                        <th class="px-4 py-3 text-left text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $productId => $cartItem)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $cartItem['name'] }}</td>
                            <td class="px-4 py-3">{{ $cartItem['jumlah'] }}</td>
                            <td class="px-4 py-3">Rp. {{ $cartItem['price'] }}</td>
                            <td class="px-4 py-3">
                                <input type="number" wire:model="cart.{{ $productId }}.qty"
                                    wire:change="updateCart({{ $productId }}, $event.target.value)"
                                    class="w-20 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3">Rp. {{ $cartItem['total'] }}</td>
                            <td class="px-4 py-3">
                                <button wire:click="removeFromCart({{ $productId }})"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Payment Details -->
            <div class="grid gap-6 md:grid-cols-2">
                <div class="mb-6">
                    <label for="pembayaran" class="block text-gray-700 font-semibold mb-2">Pembayaran</label>
                    <input type="number" id="pembayaran" wire:model.live="pembayaran"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('pembayaran')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="total" class="block text-gray-700 font-semibold mb-2">Total</label>
                    <input type="number" readonly id="total" wire:model="total"
                        class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100">
                    @error('total')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kembalian" class="block text-gray-700 font-semibold mb-2">Kembalian</label>
                    <input type="text" id="kembalian"
                        class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100" value="{{ $kembalian }}"
                        readonly>
                </div>
            </div>

            <!-- Save Transaction -->
            <button wire:click="saveTransaction"
                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition mt-8">Save
                Transaction</button>
        </div>
    </div>
    @if (session()->has('kurang'))
        <div class="bg-red-600 text-white p-4 rounded-lg mt-6 shadow-lg">
            {{ session('kurang') }}
        </div>
    @endif
    <x-sweet-alert></x-sweet-alert>
</div>
