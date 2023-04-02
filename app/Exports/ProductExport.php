<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{
    protected $produk;

    function __construct($produk) {
        $this->produk = $produk;
    }

    public function view(): View
    {
        return view('exports.product', ['produk' => $this->produk]);
    }
}
