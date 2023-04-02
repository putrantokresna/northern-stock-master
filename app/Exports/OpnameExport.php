<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OpnameExport implements FromView
{
    protected $opname;
    protected $produk;

    function __construct($opname, $produk) {
        $this->opname = $opname;
        $this->produk = $produk;
    }

    public function view(): View
    {
        return view('exports.opname', ['opname' => $this->opname, 'produk' => $this->produk]);
    }
}
