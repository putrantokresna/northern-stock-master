@extends('templates.default')

@section('content')
    <div class="container-fluid">
        @if (session('errmsg') != null)
            <div class="d-flex flex-row mt-3">
                <div class="alert alert-danger alert-dismissible fade show flex-fill" role="alert">
                    {{ session('errmsg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if (session('msg') != null)
            <div class="d-flex flex-row mt-3">
                <div class="alert alert-success alert-dismissible fade show flex-fill" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="d-flex flex-row mt-3">
            <h3 class="title fw-bolder" style="color: #FF9029;">Daftar <span style="color: #000">Stok</span></h3>
            @if (session('user')->role == 'Admin')
                <div class="d-flex flex-column ms-auto align-items-start">
                    <a href="{{ route('product.edit') }}" class="btn btn-success fw-bold" style="background: #89B83C; border-color: #89B83C;">Tambah Produk</a>
                </div>
                <div class="d-flex flex-column ms-2 align-items-start">
                    <a href="{{ route('product.export', ['tanggal' => $tanggal, 'kategori' => $kategori]) }}"
                        class="btn btn-primary fw-bold" style="background: #297DBB; border-color: #297DBB;">Cetak Laporan Harian</a>
                </div>
            @else
                <div class="d-flex flex-column ms-auto align-items-start">
                    <a href="{{ route('product.export', ['tanggal' => $tanggal, 'kategori' => $kategori]) }}"
                        class="btn btn-primary fw-bold" style="background: #297DBB; border-color: #297DBB;">Cetak Laporan Harian</a>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body fw-bold" style="background :#1B1717">
                        <form method="get">
                            <div class="d-flex flex-row fw-bold text-white">
                                <div class="d-flex flex-column flex-fill">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select id="kategori" class="form-select text-white font-weight-bold" name="kategori" style="background: #FF9029; border-color: #FF9029">
                                        @if ($kategori == '' || $kategori == null)
                                            <option value="" selected disabled></option>
                                        @else
                                            <option value="" disabled></option>
                                        @endif
                                        @foreach ($kategoriList as $k)
                                            @if ($kategori == $k->kategori)
                                                <option value="{{ $k->kategori }}" selected>{{ $k->kategori }}</option>
                                            @else
                                                <option value="{{ $k->kategori }}">{{ $k->kategori }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ms-2 d-flex flex-column flex-fill">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    @if ($tanggal == '' || $tanggal == null)
                                    <input type="date" id="tanggal" class="form-control text-white fw-bold" name="tanggal" style="background: #FF9029; border-color: #FF9029"/>
                                    @else
                                    <input type="date" id="tanggal" class="form-control text-white fw-bold" name="tanggal" style="background: #FF9029; border-color: #FF9029"
                                    value="{{ $tanggal }}" />
                                    @endif
                                </div>
                                <div class="ms-2 d-flex flex-col flex-lg-fill align-self-end">
                                    <div class="d-flex flex-row ms-auto">
                                        <button type="submit" class="btn btn-warning text-white fw-bold" style="background: #FF9029; border-color: #FF9029">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table id="table" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="coloumn text-white" style="background: #FF9029;">
                                            <th class="nomor-produk text-center">Nomor</th>
                                            <th class="kode-produk text-center">Kode Produk</th>
                                            <th class="nama-produk text-center">Nama Produk</th>
                                            <th class="besaran-produk text-center">Besaran</th>
                                            <th class="satuan-produk text-center">Satuan</th>
                                            <th class="kategori-produk text-center">Kategori</th>
                                            <th class="stok-awal-produk text-center">Stok Awal / Opname</th>
                                            <th class="masuk-produk text-center">Produk Masuk</th>
                                            <th class="keluar-produk text-center">Produk Keluar</th>
                                            <th class="stok-akhir-produk text-center">Stok Akhir</th>
                                            <th class="masa-kadarluasa-produk text-center">Masa Kadaluarsa</th>
                                            <th class="ket-kadaluwarsa text-center">Keterangan</th>
                                            @if(session('user')->role == 'Admin')
                                            <th class="menu-produk text-center">Menu</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                    <tr style="background: #E2DFCC">
                                        <td class="nomor-produk text-center">{{$loop->iteration}}</td>
                                        <td class="id-produk text-center">{{$p->id}}</td>
                                        <td class="nama-produk text-center">{{$p->nama}}</td>
                                        <td class="besaran-produk text-center">{{$p->Besaran}}</td>
                                        <td class="satuan-produk text-center">{{$p->Satuan}}</td>
                                        <td class="kategori-produk text-center">{{$p->kategori}}</td>
                                        <td class="qty-awal-produk text-center">{{$p->qty_awal}}</td>
                                        <td>
                                                @for($i=0;$i<$p->produk_inven_masuk->count();$i++)
                                                + {{$p->produk_inven_masuk[$i]->jumlah}} produk pada {{$p->produk_inven_masuk[$i]->created_at}}
                                                @if($i < $p->produk_inven_masuk->count()-1)
                                                <br/>
                                                @endif
                                                @endfor
                                            </td>
                                            <td>
                                                @for($i=0;$i<$p->produk_inven_keluar->count();$i++)
                                                - {{$p->produk_inven_keluar[$i]->jumlah}} produk pada {{$p->produk_inven_keluar[$i]->created_at}}
                                                @if($i < $p->produk_inven_keluar->count()-1)
                                                <br/>
                                                @endif
                                                @endfor
                                            </td>
                                            @if ($p->qty_akhir < 5)
                                            <td class="qty-akhir-produk text-center text-danger">{{$p->qty_akhir}}</td>
                                            @else
                                            <td class="qty-akhir-produk text-center">{{$p->qty_akhir}}</td>
                                            @endif
                                            <td>
                                                @for($i=0;$i<$p->kadaluarsa->count();$i++)
                                                • {{$p->kadaluarsa[$i]->jumlah}} produk kadaluarsa pada {{substr($p->kadaluarsa[$i]->kadaluarsa, 0, 10)}} (sisa {{$p->kadaluarsa[$i]->sisa_hari}} hari)
                                                @if($i < $p->kadaluarsa->count()-1)
                                                <br/>
                                                @endif
                                                @endfor
                                            </td>
                                            <td class="ket-masadaluwarsa text-center">{{$p->ket}}</td>
                                            @if(session('user')->role == 'Admin')
                                            <td class="menu-produk text-center">
                                                <a href="{{ route('product.edit', ['id' => $p->id]) }}" class="btn btn-outline-warning mt-1 w-75 my-2 text-white fw-bold" style="background: #D4C10F; border-color: #D4C10F"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-outline-warning mt-1 w-75 my-2 text-white fw-bold" data-bs-toggle="modal" data-bs-target="#deleteModalProduk<?= $loop->iteration ?>" style="background: #FF533C; border-color: #FF533C"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModalProduk<?= $loop->iteration ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                <form method = "POST" action="">
        
                                                    <h1 class="modal-title fs-5 text-black">Hapus Data Produk</h1>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-black">
                                                    Yakin Ingin Menghapus Data <span class = "text-danger">{{$p->nama}}</span> ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal" style="background: #89B83C; border-color: #89B83C">No</button>
                                                    <a href="{{ route('product.delete', ['id' => $p->id]) }}" class="btn btn-outline-danger mt-1 text-white" style="background: #FF533C; border-color: #FF533C">Yes</a>
                                                </div>
                                                </div>
                                                </form>
                                            </div>
                                            </div>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        
@section('js')
    <script>
        $(function() {
            let role = "{{ session('user')->role }}";
            if (role == 'Admin')
                $('#table').DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "columnDefs": [{
                            "searchable": false,
                            "targets": [8]
                        },
                        {
                            "sortable": false,
                            "targets": [4, 5, 7, 8]
                        }
                    ]
                });
            else
                $('#table').DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "columnDefs": [{
                        "sortable": false,
                        "targets": [4, 5, 7]
                    }]
                });
        });

        $(document).ready(function() {
            $(document).on('click', '#delete_product', function(){
                var id = $(this).p('id');
                $('#id').val(id);
            });
        });
    </script>


@endsection
