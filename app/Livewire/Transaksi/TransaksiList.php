<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiList extends Component
{
    use WithPagination;

    public $search;
    public $pagi = 5;

    public $inv;
    public $customer;
    public $tanggal_transaction;
    public $details = [];
    public $invoice;
    public $product;
    public $qty;
    public $pembayaran;
    public $kembalian;
    public $detaL_id;
    public $totalHarga;

    public function addTran()
    {
        return redirect()->to("transaksi");
    }

    public function render()
    {
        $transaksiL = Transaction::with('details.product');

        if ($this->search) {
            $transaksiL->where('invoice', 'like', '%' . $this->search . '%');
        }

        $transaksi = $transaksiL->latest()->paginate($this->pagi);

        return view('livewire.transaksi.transaksi-list', [
            'transaksi' => $transaksi,
        ]);
    }

    
    
    public function close()
    {        
        $this->dispatch('hide-modal');
        $this->reset('customer', 'tanggal_transaction', 'invoice', 'pembayaran', 'details','kembalian');
    }

    public function detail($id)
    {
        $transaction = Transaction::with('details.product')->find($id);
        $this->invoice = $transaction->invoice;
        $this->customer = $transaction->customer;
        $this->tanggal_transaction = $transaction->tanggal_transaction;
        $this->pembayaran = $transaction->pembayaran;
        $this->details = $transaction->details;
        $this->kembalian = $transaction->kembalian;
        $this->detaL_id = $transaction->id;
        $this->totalHarga = $transaction->total_keseluruhan;

    
        $this->dispatch('openModal');
    }


    public function delete($id)
    {
        Transaction::find($id)->delete();
        session()->flash('message', 'Transaction deleted successfully.');
    }
}
