<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <table>
        <thead>
            <tr>
                <td colspan="25" style="text-align: center; font-size: 20px;"><b>LAPORAN HASIL STOK OPNAME</b></td>
            </tr>
            <tr>
                <td colspan="25"></td>
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
                <td colspan="2"><b>Stok Aktual</b></td>
                <td colspan="2"><b>Selisih</b></td>
            </tr>

            @foreach($produk as $p)
            @php
            $max = 0;
            $isOd = true;
            $od = $p->opname_detail->where('opname_id', $opname->id)->last();
            @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$p->id}}</td>
                <td colspan="3">{{$p->nama}}</td>
                <td colspan="2">{{$p->Besaran}}</td>
                <td colspan="2">{{$p->Satuan}}</td>
                <td colspan="2">{{$p->kategori}}</td>
                @if($od != null)
                <td colspan="2">{{$od->qty_awal}}</td>
                @else
                <td colspan="2">{{$p->qty_awal}}</td>
                @endif
                <td colspan="4">
                @if($od != null && $od->opname_detail_produk != null)
                @php
                $p->produk_inven_masuk = $od->opname_detail_produk->where('jenis', 'Masuk')->values();
                if($max < $p->produk_inven_masuk->count())
                    $max = $p->produk_inven_masuk->count();
                @endphp
                @for($i=0;$i<$od->opname_detail_produk->count();$i++)
                @if($od->opname_detail_produk[$i]->jenis == 'Masuk')
                {{$od->opname_detail_produk[$i]->content}}
                @break
                @endif
                @endfor
                @else
                @php
                if($max < $p->produk_inven_masuk->count())
                    $max = $p->produk_inven_masuk->count();
                $isOd = false;
                @endphp
                @for($i=0;$i<$p->produk_inven_masuk->count();$i++)
                {{$p->produk_inven_masuk[$i]->jumlah}} pada {{$p->produk_inven_masuk[$i]->created_at}}
                @break
                @endfor
                </td>
                @endif
                <td colspan="4">
                @if($od != null && $od->opname_detail_produk != null)
                @php
                $p->produk_inven_keluar = $od->opname_detail_produk->where('jenis', 'Keluar')->values();
                if($max < $p->produk_inven_keluar->count())
                    $max = $p->produk_inven_keluar->count();
                @endphp
                @for($i=0;$i<$od->opname_detail_produk->count();$i++)
                @if($od->opname_detail_produk[$i]->jenis == 'Keluar')
                {{$od->opname_detail_produk[$i]->content}}
                @break
                @endif
                @endfor
                @else
                @php
                if($max < $p->produk_inven_keluar->count())
                    $max = $p->produk_inven_keluar->count();
                @endphp
                @for($i=0;$i<$p->produk_inven_keluar->count();$i++)
                {{$p->produk_inven_keluar[$i]->jumlah}} pada {{$p->produk_inven_keluar[$i]->created_at}}
                @break
                @endfor
                @endif
                </td>
                @if($od != null)
                <td colspan="2">{{$od->qty_system}}</td>
                @else
                <td colspan="2">{{$p->qty_akhir}}</td>
                @endif
                @if($od != null)
                <td colspan="2">{{$od->qty_actual}}</td>
                @else
                <td></td>
                @endif
                @if($od != null)
                <td colspan="2">{{$od->qty_actual - $od->qty_system < 0 ? $od->qty_actual - $od->qty_system : abs($od->qty_actual - $od->qty_system)}}</td>
                @else
                <td></td>
                @endif
            </tr>
            @for($i=1; $i<$max; $i++)
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="3"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>

                    @if($isOd)
                    @if($i < $p->produk_inven_masuk->count())
                    <td colspan="4">{{$p->produk_inven_masuk[$i]->content}}</td>
                    @else
                    <td colspan="4"></td>
                    @endif
                    @else
                    @if($i < $p->produk_inven_masuk->count())
                    <td colspan="4">{{$p->produk_inven_masuk[$i]->jumlah}} pada {{$p->produk_inven_masuk[$i]->created_at}}</td>
                    @else
                    <td colspan="4"></td>
                    @endif
                    @endif

                    @if($isOd)
                    @if($i < $p->produk_inven_keluar->count())
                    <td colspan="4">{{$p->produk_inven_keluar[$i]->content}}</td>
                    @else
                    <td colspan="4"></td>
                    @endif
                    @else
                    @if($i < $p->produk_inven_keluar->count())
                    <td colspan="4">{{$p->produk_inven_keluar[$i]->jumlah}} pada {{$p->produk_inven_keluar[$i]->created_at}}</td>
                    @else
                    <td colspan="4"></td>
                    @endif
                    @endif

                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
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