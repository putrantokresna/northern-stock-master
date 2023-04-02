@extends('templates.default')
@section('content')
        <div class="container-fluid">
            @if(session('errmsg') != null || $errmsg != null)
            <div class="d-flex flex-row mt-3">
                <div class="alert alert-danger alert-dismissible fade show flex-fill" role="alert">
                    {{session('errmsg') ?: $errmsg}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if(session('msg') != null || $msg != null)
            <div class="d-flex flex-row mt-3">
                <div class="alert alert-success alert-dismissible fade show flex-fill" role="alert">
                    {{session('msg') ?: $msg}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="d-flex flex-row mt-3">
                <h3 class="title fw-bolder" style="color: #FF9029;">Stock <span style="color: #000">Opname</span></h3>
                @if($opname != null)
                @if($opname->opname_detail->count() > 0)
                <div class="d-flex flex-column ms-auto align-items-start">
                <a href="{{ route('opname.export', ['tanggal' => $tanggal, 'kategori' => $kategori]) }}" class="btn btn-primary fw-bold" style="background: #297DBB; border-color: #297DBB;">Cetak Stock Opname</a>
                </div>
                @endif
                @endif
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body fw-bold" style="background :#1B1717">
                                <form method="get">
                                <div class="d-flex flex-row text-white fw-bold">
                                    <div class="d-flex flex-column flex-fill">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select id="kategori" class="form-select text-white fw-bold" name="kategori" style="background: #FF9029; border-color: #FF9029">
                                            @if($kategori == "" || $kategori == null)
                                            <option value="" selected disabled></option>
                                            @else
                                            <option value="" disabled></option>
                                            @endif
                                            @foreach($kategoriList as $k)
                                            @if($kategori == $k->kategori)
                                            <option value="{{$k->kategori}}" selected>{{$k->kategori}}</option>
                                            @else
                                            <option value="{{$k->kategori}}">{{$k->kategori}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ms-2 d-flex flex-column flex-fill">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        @if($tanggal == "" || $tanggal == null)
                                        <input type="date" id="tanggal" class="form-control text-white fw-bold" name="tanggal" style="background: #FF9029; border-color: #FF9029"/>
                                        @else
                                        <input type="date" id="tanggal" class="form-control text-white fw-bold" name="tanggal" value="{{$tanggal}}" style="background: #FF9029; border-color: #FF9029"/>
                                        @endif
                                    </div>
                                    <div class="ms-2 d-flex flex-col flex-lg-fill align-self-end">
                                        <div class="d-flex flex-row ms-auto">
                                            <button type="submit" class="btn btn-warning text-white fw-bold" style="background: #FF9029; border-color: #FF9029">Filter</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <form method="post" action="{{route('opname.post')}}">
                                @csrf
                                @if($tanggal != null)
                                <input type="hidden" name="tanggal" value="{{$tanggal}}" />
                                @else
                                <input type="hidden" name="tanggal" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" />
                                @endif
                                <div class="table-responsive mt-3">
                                    <table id="table" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr class="coloumn text-white" style="background: #FF9029;">
                                                <th class="no-produk text-center">No</th>
                                                <th class="kode-produk text-center">Kode</th>
                                                <th class="nama-produk text-center">Nama Produk</th>
                                                <th class="besaran-produk text-center">Besaran</th>
                                                <th class="satuan-produk text-center">Satuan</th>
                                                <th class="kategori-produk text-center">Kategori</th>
                                                <th class="stok-awal-produk text-center">Stok Awal / Opname</th>
                                                <th class="masuk-produk text-center">Produk Masuk</th>
                                                <th class="keluar-produk text-center">Produk Keluar</th>
                                                <th class="stok-akhir-produk text-center">Stok Akhir</th>
                                                <th class="stok-aktual-produk text-center">Stok Aktual</th>
                                                <th class="selisih-produk text-center">Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody style="background: #E2DFCC">
                                            @php
                                            $continue = true;
                                            @endphp
                                            @if($opname != null)
                                            @if($opname->opname_detail->count() > 0)
                                            @php
                                            $continue = false;
                                            @endphp

                                            @foreach($produk as $p)
                                            <tr>
                                                <!-- <td class="no-produk text-center">{{$loop->iteration}}</td> -->
                                                @php
                                                $od = $p->opname_detail->where('opname_id', $opname->id)->last();
                                                @endphp
                                                <td>{{$loop->iteration}}</td>
                                                <td class="id-produk text-center">{{$p->id}}</td>
                                                <td class="nama-produk text-center">{{$p->nama}}</td>
                                                <td class="besaran-produk text-center">{{$p->Besaran}}</td>
                                                <td class="satuan-produk text-center">{{$p->Satuan}}</td>
                                                <td class="kategori-produk text-center">{{$p->kategori}}</td>
                                                @if($od != null)
                                                <td class="qty-awal-produk-od text-center">{{$od->qty_awal}}</td>
                                                @else
                                                <td class="qty-awal-produk text-center">{{$p->qty_awal}}</td>
                                                @endif
                                                <td>
                                                @if($od != null && $od->opname_detail_produk != null)
                                                @for($i=0;$i<$od->opname_detail_produk->count();$i++)
                                                @if($od->opname_detail_produk[$i]->jenis == 'Masuk')
                                                {{$od->opname_detail_produk[$i]->content}}
                                                <br/>
                                                @endif
                                                @endfor
                                                @else
                                                @for($i=0;$i<$p->produk_inven_masuk->count();$i++)
                                                {{$p->produk_inven_masuk[$i]->jumlah}} produk pada {{$p->produk_inven_masuk[$i]->created_at}}
                                                @if($i < $p->produk_inven_masuk->count()-1)
                                                <br/>
                                                @endif
                                                @endfor
                                                </td>
                                                @endif
                                                <td>
                                                @if($od != null && $od->opname_detail_produk != null)
                                                @for($i=0;$i<$od->opname_detail_produk->count();$i++)
                                                @if($od->opname_detail_produk[$i]->jenis == 'Keluar')
                                                {{$od->opname_detail_produk[$i]->content}}
                                                <br/>
                                                @endif
                                                @endfor
                                                @else
                                                @for($i=0;$i<$p->produk_inven_keluar->count();$i++)
                                                {{$p->produk_inven_keluar[$i]->jumlah}} produk pada {{$p->produk_inven_keluar[$i]->created_at}}
                                                @if($i < $p->produk_inven_keluar->count()-1)
                                                <br/>
                                                @endif
                                                @endfor
                                                @endif
                                                </td>
                                                @if($od != null)
                                                <td class="qty-system-produk-od text-center">{{$od->qty_system}}</td>
                                                @else
                                                <td class="qty-akhir-produk text-center">{{$p->qty_akhir}}</td>
                                                @endif
                                                @if($od != null)
                                                <td class="qty-actual-produk text-center">{{$od->qty_actual}}</td>
                                                @else
                                                <td></td>
                                                @endif
                                                @if($od != null)
                                                <td class="qty-selisih-produk text-center">{{$od->qty_actual - $od->qty_system < 0 ? $od->qty_actual - $od->qty_system : abs($od->qty_actual - $od->qty_system)}}</td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            
                                            @endif
                                            @endif

                                            @if($opname == null || $continue)
                                            @php
                                                $index = 0;
                                                $odp_contents = [];
                                                $odp_jenises = [];
                                            @endphp
                                            @foreach($produk as $p)
                                            @php
                                                array_push($odp_contents, "");
                                                array_push($odp_jenises, "");
                                            @endphp
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td><input type="hidden" name="produk_id[]" value="{{$p->id}}"/>{{$p->id}}</td>
                                                <td>{{$p->nama}}</td>
                                                <td>{{$p->Besaran}}</td>
                                                <td>{{$p->Satuan}}</td>
                                                <td>{{$p->kategori}}</td>
                                                <td><input type="hidden" name="qty_awal[]" value="{{$p->qty_awal}}"/>{{$p->qty_awal}}</td>
                                                <td>
                                                @for($i=0;$i<$p->produk_inven_masuk->count();$i++)
                                                + {{$p->produk_inven_masuk[$i]->jumlah}} produk pada {{$p->produk_inven_masuk[$i]->created_at}}
                                                @php
                                                    $odp_contents[$index] .= $p->produk_inven_masuk[$i]->jumlah.' produk pada '.$p->produk_inven_masuk[$i]->created_at;
                                                    $odp_jenises[$index] .= 'Masuk';
                                                @endphp
                                                @if($i < $p->produk_inven_masuk->count()-1)
                                                @php
                                                    $odp_contents[$index] .= ';';
                                                    $odp_jenises[$index] .= ';';
                                                @endphp
                                                <br/>
                                                @else
                                                @php
                                                    $odp_contents[$index] .= ';';
                                                    $odp_jenises[$index] .= ';';
                                                @endphp
                                                @endif
                                                @endfor
                                                </td>
                                                <td>
                                                @for($i=0;$i<$p->produk_inven_keluar->count();$i++)
                                                - {{$p->produk_inven_keluar[$i]->jumlah}} produk pada {{$p->produk_inven_keluar[$i]->created_at}}
                                                @php
                                                    $odp_contents[$index] .= $p->produk_inven_keluar[$i]->jumlah.' produk pada '.$p->produk_inven_keluar[$i]->created_at;
                                                    $odp_jenises[$index] .= 'Keluar';
                                                @endphp
                                                @if($i < $p->produk_inven_keluar->count()-1)
                                                @php
                                                    $odp_contents[$index] .= ';';
                                                    $odp_jenises[$index] .= ';';
                                                @endphp
                                                <br/>
                                                @endif
                                                @endfor
                                                <input type="hidden" name="odp_content[]" value="{{$odp_contents[$index]}}"/>
                                                <input type="hidden" name="odp_jenis[]" value="{{$odp_jenises[$index]}}"/>
                                                </td>
                                                <td><input type="hidden" name="qty_akhir[]" value="{{$p->qty_akhir}}"/>{{$p->qty_akhir}}</td>
                                                <td><input type="number" min="0" name="qty_actual[]" class="form-control"/></td>
                                                <td><input type="number" readonly id="sisa" class="form-control"/></td>
                                            </tr>
                                            @php
                                            $index++;
                                            @endphp
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @if($continue && count($produk) > 0)
                                <div class="d-flex flex-col flex-lg-fill align-self-end mt-3">
                                    
                                    <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #FF9029; border-color: #FF9029">
                                        Simpan
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-black" id="exampleModalLabel">Simpan Stock Opname</h1>
                                            <button type="button" class="btn-clos`e" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-black">
                                            Yakin sudah menginput opname dengan benar?
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal" style="background: #89B83C; border-color: #89B83C;">No</button>
                                        <button type="submit" class="btn btn-success text-white" style="background: #FF533C; border-color: #FF533C">Yes</button>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                $('#table').DataTable(
                    {
                        paging: false,
                        "order": [[ 0, "asc" ]],
                        "columnDefs": [
                            { "sortable": false, "targets": [4,5,7,8] }
                        ]
                    }
                );
            });
        </script>
@endsection