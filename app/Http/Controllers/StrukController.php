<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Mpdf\Mpdf;

class StrukController extends Controller
{
    public function printStruk($id)
    {
        // Retrieve the transaction with related details and products
        $transaction = Transaction::with('details.product')->findOrFail($id);

        // Prepare the rows for the PDF
        $rows = [];
        foreach ($transaction->details as $detail) {
            $rows[] = [
                'nama' => $detail->product->name,
                'qty' => $detail->qty,
                'harga' => $detail->product->harga, // Use the 'harga' from the product
                'total' => $detail->qty * $detail->product->harga,
            ];
        }

        // Create a new mPDF instance
        $mpdf = new Mpdf();

        // Load the HTML view and pass data
        $html = view('pdf.struk', [
            'transaction' => $transaction,
            'rows' => $rows,
            'dibayar' => $transaction->pembayaran,
            'kembali' => $transaction->kembalian,
        ])->render();

        // Write the HTML to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF to the browser inline
        return $mpdf->Output('struk-transaksi.pdf', 'I'); // 'I' for inline display
    }
}
