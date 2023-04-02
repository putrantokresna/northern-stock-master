<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <table>
        <thead>
            <tr>
                <td colspan="28" style="text-align: center; font-size: 20px;"><b>LAPORAN KELUAR MASUK HARIAN</b></td>
            </tr>
            <tr>
                <td colspan="28" style="text-align: center; font-size: 15px;" value="#tanggal"></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>No</b></td>
                <td><b>Kode</b></td>
                <td colspan="3"><b>Nama Produk</b></td>
                <td colspan="2"><b>Besaran</b></td>
                <td colspan="2"><b>Satuan</b></td>
                <td colspan="2"><b>Kategori</b></td>
                <td colspan="2"><b>Stok Awal</b></td>
                <td colspan="4"><b>Barang Masuk</b></td>
                <td colspan="4"><b>Barang Keluar</b></td>
                <td colspan="2"><b>Stok Akhir</b></td>
                <td colspan="4"><b>Masa Kadaluarsa</b></td>
            </tr>
            @foreach($produk as $p)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$p->id}}</td>
                <td colspan="3">{{$p->nama}}</td>
                <td colspan="2">{{$p->Besaran}}</td>
                <td colspan="2">{{$p->Satuan}}</td>
                <td colspan="2">{{$p->kategori}}</td>
                <td colspan="2">{{$p->qty_awal}}</td>
                @php
                $isMasuk = false;
                $isKeluar = false;
                @endphp
                @foreach($p->produk_inven_masuk as $pi)
                    @php
                    $isMasuk = true;
                    @endphp
                    <td colspan="4">+ {{$pi->jumlah}} produk pada {{$pi->created_at}}</td>
                    @break
                @endforeach
                @if(!$isMasuk)
                <td colspan="4"></td>
                @endif
                @foreach($p->produk_inven_keluar as $pi)
                    @php
                    $isKeluar = true;
                    @endphp
                    <td colspan="4">- {{$pi->jumlah}} produk pada {{$pi->created_at}}</td>
                    @break
                @endforeach
                @if(!$isKeluar)
                <td colspan="4"></td>
                @endif
                <td colspan="2">{{$p->qty_akhir}}</td>
                @foreach($p->kadaluarsa as $k)
                    <td colspan="4">{{$k->jumlah}} produk kadaluarsa pada {{substr($k->kadaluarsa, 0, 10)}} (sisa {{$k->sisa_hari}} hari)</td>
                    @break
                @endforeach
            </tr>
            @php
            $max = $p->produk_inven_keluar->count();
            if($max < $p->produk_inven_masuk->count())
                $max = $p->produk_inven_masuk->count();
            if($max < $p->kadaluarsa->count())
                $max = $p->kadaluarsa->count();
            @endphp
            @for($i=1; $i<$max; $i++)
                <tr>
                    <td colspan="4"></td>
                    <td colspan="4"></td>
                    <td colspan="3"></td>
                    <td colspan="2"></td>
                    @if($i < $p->produk_inven_masuk->count())
                    <td colspan="4">+ {{$p->produk_inven_masuk[$i]->jumlah}} produk pada {{$p->produk_inven_masuk[$i]->created_at}}</td>
                    @else
                    <td colspan="4"></td>
                    @endif
                    @if($i < $p->produk_inven_keluar->count())
                    <td colspan="4">- {{$p->produk_inven_keluar[$i]->jumlah}} produk pada {{$p->produk_inven_keluar[$i]->created_at}}</td>
                    @else
                    <td colspan="4"></td>
                    @endif
                    <td colspan="2"></td>
                    @if($i < $p->kadaluarsa->count())
                    <td colspan="4">{{$p->kadaluarsa[$i]->jumlah}} produk kadaluarsa pada {{substr($p->kadaluarsa[$i]->kadaluarsa, 0, 10)}} (sisa {{$p->kadaluarsa[$i]->sisa_hari}} hari)</td>
                    @else
                    <td></td>
                    @endif
                </tr>
            @endfor
            @endforeach
        </tbody>
        <tfoot>
            <tr colspan="3" style="text-align : left"></tr>
            <tr colspan="3" style="text-align : left">
                <td colspan="2">
                    Diketahui,
                </td>
                <td></td>
                <td></td>
                <td colspan="2">
                    Disetujui,
                </td>
            </tr>
            <tr colspan="3">
                <td colspan="2"></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr colspan="3">
                <td colspan="2"></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr colspan="3">
                <td colspan="2"></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr colspan="3" style="text-align : left">
                <td colspan="2">Store Manager</td>
                <td></td>
                <td></td>
                <td colspan="2">Owner Resto</td>
            </tr>
        </tfoot>
    </table>
</html>