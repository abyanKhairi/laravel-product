<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <x-nav-link href="{{ route('product') }}">Product</x-nav-link>
                        <x-nav-link href="{{ route('categori') }}">Kategori</x-nav-link>
                        <x-nav-link href="{{ route('transaksiList') }}">Transaksi</x-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
