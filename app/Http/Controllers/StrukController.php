<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Mpdf\Mpdf;

class StrukController extends Controller
{
    public function printStruk($id)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);

        $rows = [];
        foreach ($transaction->details as $detail) {
            $rows[] = [
                'nama' => $detail->product->name,
                'qty' => $detail->qty,
                'harga' => $detail->product->harga, 
                'total' => $detail->qty * $detail->product->harga,
            ];
        }

        $mpdf = new Mpdf();

        $html = view('pdf.struk', [
            'transaction' => $transaction,
            'rows' => $rows,
            'dibayar' => $transaction->pembayaran,
            'total_keseluruhan' => $transaction->total_keseluruhan,
            'kembali' => $transaction->kembalian,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('struk-transaksi.pdf', 'I'); 
    }
}
