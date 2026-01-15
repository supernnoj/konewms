<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionDeliveryReceipt extends Controller
{
    public function show($id)
    {
        $transaction = Transaction::with('carts.inventory', 'contractType')->findOrFail($id);

        // $pdf = Pdf::loadView('transactions.delivery-receipt-pdf', [
        //     'transaction' => $transaction,
        // ]);

        // return $pdf->download("Transaction-{$transaction->id}.pdf");

        $pdf = PDF::loadView('transactions.delivery-receipt-pdf', [
            'transaction' => $transaction->load(['contractType', 'carts.inventory']),
        ]);

        return $pdf->download("Transaction-{$transaction->id}.pdf");
    }
}
