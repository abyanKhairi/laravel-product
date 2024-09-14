<?php

namespace App\Livewire\Transaksi;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Livewire\Component;
use Illuminate\Support\Str;

class Transaksi extends Component
{
    public $products;
    public $selectedProductId;
    public $cart = [];
    public $customer;
    public $invoice;
    public $tanggal_transaction;
    public $pembayaran;
    public $kembalian;

    public function mount()
    {
        // Load all products and generate invoice number
        $this->products = Product::all();
        $this->Inv();
    }

    public function Inv()
    {
        $this->invoice = strtoupper('INV-' . Str::random(8)); // Generate invoice
    }

    public function addToCart()
    {
        if ($this->selectedProductId) {
            $product = Product::find($this->selectedProductId);
            if ($product) {
                if (isset($this->cart[$this->selectedProductId])) {
                    $this->cart[$this->selectedProductId]['qty'] += 1;
                    $this->cart[$this->selectedProductId]['total'] = $this->cart[$this->selectedProductId]['qty'] * $product->harga;
                } else {
                    $this->cart[$this->selectedProductId] = [
                        'name' => $product->name,
                        'price' => $product->harga,
                        'qty' => 1,
                        'total' => $product->harga,
                    ];
                }
            }
            $this->selectedProductId = null; // Reset the selected product
            $this->calculateKembalian();
        }
    }

    public function updateCart($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty'] = $quantity;
            $this->cart[$productId]['total'] = $this->cart[$productId]['price'] * $quantity;
        }
        $this->calculateKembalian();
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateKembalian();
    }

    public function calculateKembalian()
    {
        $total = $this->getTotalPrice();
        $this->kembalian = $this->pembayaran - $total;
    }

    public function getTotalPrice()
    {
        return array_sum(array_column($this->cart, 'total'));
    }

    public function updatedPembayaran()
    {
        $this->calculateKembalian();
    }

    public function saveTransaction()
    {
        $this->validate([
            'customer' => 'required',
            'invoice' => 'required',
            'tanggal_transaction' => 'required|date',
            'pembayaran' => 'required|numeric|min:' . $this->getTotalPrice(),
        ]);

        $transaction = Transaction::create([
            'customer' => $this->customer,
            'invoice' => $this->invoice,
            'tanggal_transaction' => $this->tanggal_transaction,
            'pembayaran' => $this->pembayaran,
            'kembalian' => $this->kembalian,
        ]);

        foreach ($this->cart as $productId => $cartItem) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productId,
                'qty' => $cartItem['qty'],
                'total' => $cartItem['total'],
            ]);
        }

        // Clear the cart and reset form
        $this->reset(['customer', 'invoice', 'tanggal_transaction', 'cart', 'selectedProductId', 'pembayaran', 'kembalian']);
        session()->flash('message', 'Transaction saved successfully.');
        $this->Inv(); // Generate new invoice for next transaction
    }

    public function render()
    {
        return view('livewire.transaksi.transaksi');
    }
}
