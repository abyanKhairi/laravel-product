<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Transaction</h1>

    <!-- Display Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Customer Details -->
    <div class="mb-4">
        <label for="customer" class="block text-gray-700 font-bold mb-2">Customer Name</label>
        <input type="text" id="customer" wire:model="customer" class="w-full p-2 border border-gray-300 rounded">
        @error('customer')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label for="invoice" class="block text-gray-700 font-bold mb-2">Invoice</label>
        <input type="text" id="invoice" class="w-full p-2 border border-gray-300 rounded bg-gray-100"
            value="{{ $invoice }}" readonly>
    </div>

    <div class="mb-4">
        <label for="tanggal_transaction" class="block text-gray-700 font-bold mb-2">Transaction Date</label>
        <input type="date" id="tanggal_transaction" wire:model="tanggal_transaction"
            class="w-full p-2 border border-gray-300 rounded">
        @error('tanggal_transaction')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label for="product" class="block text-gray-700 font-bold mb-2">Select Product</label>
        <select id="product" required wire:model="selectedProductId"
            class="w-full p-2 border border-gray-300 rounded">
            <option value="">-- Select Product --</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} - Rp. {{ $product->harga }}</option>
            @endforeach
        </select>
    </div>

    <button wire:click="addToCart" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add to
        Cart</button>

    <!-- Payment Details -->
    <div class="mb-4">
        <label for="pembayaran" class="block text-gray-700 font-bold mb-2">Pembayaran</label>
        <input type="number" id="pembayaran" wire:model="pembayaran" class="w-full p-2 border border-gray-300 rounded">
        @error('pembayaran')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label for="kembalian" class="block text-gray-700 font-bold mb-2">Kembalian</label>
        <input type="text" id="kembalian" class="w-full p-2 border border-gray-300 rounded bg-gray-100"
            value="{{ $kembalian }}" readonly>
    </div>

    <!-- Cart and Transaction Details -->
    <h3 class="text-xl font-bold mt-6 mb-4">Cart</h3>
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-left">Price</th>
                <th class="px-4 py-2 text-left">Quantity</th>
                <th class="px-4 py-2 text-left">Total</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $productId => $cartItem)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $cartItem['name'] }}</td>
                    <td class="px-4 py-2">Rp. {{ $cartItem['price'] }}</td>
                    <td class="px-4 py-2">
                        <input type="number" wire:model="cart.{{ $productId }}.qty"
                            wire:change="updateCart({{ $productId }}, $event.target.value)"
                            class="w-16 p-1 border border-gray-300 rounded">
                    </td>
                    <td class="px-4 py-2">Rp. {{ $cartItem['total'] }}</td>
                    <td class="px-4 py-2">
                        <button wire:click="removeFromCart({{ $productId }})"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Save Transaction -->
    <button wire:click="saveTransaction" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-6">Save
        Transaction</button>
</div>
