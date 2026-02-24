<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('invoice.create');
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

        $pdf = Pdf::loadView('invoice.pdf', $data)
            ->setPaper('a4', 'portrait');

        $filename = 'invoice_' . str_replace('/', '-', $validated['invoice_no']) . '.pdf';

        return $pdf->download($filename); 
    }
}