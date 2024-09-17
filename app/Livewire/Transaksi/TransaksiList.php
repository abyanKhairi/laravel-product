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

    public function delete($id)
    {
        Transaction::find($id)->delete();
        session()->flash('message', 'Transaction deleted successfully.');
    }
}
