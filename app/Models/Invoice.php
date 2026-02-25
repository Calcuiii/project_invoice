<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no',
        'tahun',
        'bulan',
        'urutan',
    ];

    public static function generateNomor(): string
    {
        $tahun = (int) date('Y');
        $bulan = (int) date('m');

        $terakhir = self::where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->max('urutan');

        $urutan = ($terakhir ?? 0) + 1;

        return sprintf(
            'CT/%d/%02d/%03d',
            $tahun,
            $bulan,
            $urutan
        );
    }
}