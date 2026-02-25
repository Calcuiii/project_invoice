<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function create()
    {
        $invoiceNo = Invoice::generateNomor();
        return view('invoice.create', compact('invoiceNo'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'kepada'         => 'required|string|max:255',
            'username'       => 'required|string|max:255',
            'alamat'         => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jatuh_tempo'    => 'required|date',
            'invoice_no'     => 'required|string|max:100',
            'rekening'       => 'required|in:joko,lilis',  
            'items'          => 'required|array|min:1',
            'keterangan' => 'required|string|max:500',
            'items.*.nama'   => 'required|string|max:255',
            'items.*.qty'    => 'required|numeric|min:0',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.harga'  => 'required|numeric|min:0',
        ]);

        $rekeningList = [
            'joko'  => ['nama' => 'JOKO PITOYO',    'nomor' => '6720449321', 'bank' => 'BCA'],
            'lilis' => ['nama' => 'Lilis Sugijanti', 'nomor' => '2710795471', 'bank' => 'BCA'],
        ];

        $items = collect($validated['items'])->map(function ($item) {
            $item['total'] = $item['qty'] * $item['harga'];
            return $item;
        });

        $grandTotal = $items->sum('total');

        $data = [
            'kepada'      => $validated['kepada'],
            'username'    => $validated['username'],
            'alamat'      => $validated['alamat'],
            'tanggal'     => Carbon::parse($validated['tanggal']),
            'jatuh_tempo' => Carbon::parse($validated['jatuh_tempo']),
            'invoice_no'  => $validated['invoice_no'],
            'rekening'    => $rekeningList[$validated['rekening']], 
            'items'       => $items,
            'keterangan' => $validated['keterangan'],
            'grand_total' => $grandTotal,
        ];

        $parts = explode('/', $validated['invoice_no']); // ['CT','2026','02','001']

        Invoice::create([
            'invoice_no' => $validated['invoice_no'],
            'tahun'      => (int) $parts[1],
            'bulan'      => (int) $parts[2],
            'urutan'     => (int) end($parts),
        ]);
        $pdf = Pdf::loadView('invoice.pdf', $data)
            ->setPaper('a4', 'portrait');

        $filename = 'invoice_' . str_replace('/', '-', $validated['invoice_no']) . '.pdf';

        return $pdf->download($filename); 
    }
}