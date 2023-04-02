@extends('templates.default')
@section('content')

        <div class="container-fluid">
            @if(session('errmsg') != null)
            <div class="d-flex flex-row mt-3">
                <div class="alert alert-danger alert-dismissible fade show flex-fill" role="alert">
                    {{session('errmsg')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if(session('msg') != null)
            <div class="d-flex flex-row mt-3">
                <div class="alert alert-success alert-dismissible fade show flex-fill" role="alert">
                    {{session('msg')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="d-flex flex-row mt-3">
                <h3 class="title fw-bolder" style="color: #FF9029;">Riwayat</h3>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body fw-bold" style="background :#1B1717">
                            <form method="get">
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column flex-fill">
                                        <label for="tanggal" class="form-label text-white">Tanggal</label>
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
                                <div class="table-responsive mt-3">
                                    <table id="table" class="table table-bordered" style="width:100%">
                                        <thead>
                                        <tr class="coloumn text-white" style="background: #FF9029;">
                                                <th class="nomor-karyawan text-center">Kode Staff</th>
                                                <th class="nama-karyawan text-center">Nama Staff</th>
                                                <th class="waktu-aktifitas text-center">Waktu</th>
                                                <th class="aktifitas text-center">Aktivitas</th>
                                                <th class="nama-barang text-center">Nama Barang</th>
                                                <th class="jumlah-barang text-center">Jumlah Barang</th>
                                                <th class="menu text-center">Menu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inven as $i)
                                            <tr style="background: #E2DFCC">
                                                <td class="nomor-karyawan text-center">{{$i->user->id ?? '-'}}</td>
                                                <td class="nama-karyawan text-center">{{$i->user->nama ?? '-'}}</td>
                                                <td class="waktu-aktifitas text-center">{{$i->created_at ?? '-'}}</td>
                                                <td class="aktifitas text-center">Produk {{$i->jenis ?? '-'}}</td>
                                                <td class="nama-produk text-center">{{$i->produk->nama ?? '-'}} (ID: {{$i->produk->id ?? '-'}})</td>
                                                <td class="jumlah-produk text-center">{{$i->jumlah ?? '-'}}</td>
                                                @if(session('user')->role == 'Admin')
                                                <td class="menu-history text-center">
                                                    <a href="#" class="btn btn-outline-warning mt-1 w-75 my-2 text-white fw-bold" data-bs-toggle="modal" data-bs-target="#deleteModalHistory<?= $loop->iteration ?>" style="background: #FF533C; border-color: #FF533C"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModalHistory<?= $loop->iteration ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                    <form method = "POST" action="">
            
                                                        <h1 class="modal-title fs-5 text-black">Hapus Data Riwayat</h1>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-black">
                                                        Yakin Ingin Menghapus Data Ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal" style="background: #89B83C; border-color: #89B83C">No</button>
                                                        <a href="{{ route('history.delete', ['id' => $i->id]) }}" class="btn btn-outline-danger mt-1 text-white" style="background: #FF533C; border-color: #FF533C">Yes</a>
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
                $('#table').DataTable(
                    {
                        "order": [[ 2, "desc" ]]
                    }
                );
            });
        </script>
@endsection