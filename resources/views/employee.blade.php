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
            <h3 class="title fw-bolder" style="color: #FF9029;">Daftar <span style="color: #000">Karyawan</span></h3>
                <div class="d-flex flex-column ms-auto align-items-start">
                <a href="{{ route('employee.edit') }}" class="btn btn-success text-white fw-bold" style="background: #89B83C; border-color: #89B83C;">Tambah Karyawan</a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body fw-bold" style="background :#1B1717">
                            <div class="table-responsive mt-3">
                                <table id="table" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="coloumn text-white" style="background: #FF9029;">
                                            <th class="nomor-karyawan text-center">Nomor</th>
                                            <th class="kode-karyawan text-center">Kode</th>
                                            <th class="nama-karyawan text-center">Nama</th>
                                            <th class="email-karyawan text-center">Email</th>
                                            <th class="alamat-karyawan text-center">Alamat</th>
                                            <th class="peran-karyawan text-center">Peran</th>
                                            <th class="menu-karyawan text-center">Menu</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background: #E2DFCC">
                                    @foreach($employee as $e)
                                        <tr style="background: #E2DFCC">
                                            <td class="nomor-karyawan text-center">{{$loop->iteration}}</td>
                                            <td class="id-karyawan text-center">{{$e->id}}</td>
                                            <td class="nama-karyawan text-center">{{$e->nama}}</td>
                                            <td class="email-karyawan text-center">{{$e->email}}</td>
                                            <td class="alamt-karyawan text-center">{{$e->alamat ?: ""}}</td>
                                            <td class="peran-karyawan text-center">{{$e->role}}</td>
                                            <td class="menu-karyawan text-center">
                                                <a href="{{ route('employee.edit', ['id' => $e->id]) }}" class="btn btn-outline-warning mt-1 w-75 my-2 text-white fw-bold" style="background: #D4C10F; border-color: #D4C10F3"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-outline-warning mt-1 w-75 my-2 text-white fw-bold" data-bs-toggle="modal" data-bs-target="#deleteModalKaryawan<?= $loop->iteration ?>" style="background: #FF533C; border-color: #FF533C"><i class="fas fa-trash-alt"></i></a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModalKaryawan<?= $loop->iteration ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5 text-black" id="exampleModalLabel">Hapus Data Karyawan</h1>
                                                        <button type="button" class="btn-clos`e" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-black">
                                                        Yakin Ingin Menghapus Data <span class = "text-danger">{{$e->nama}}</span> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal" style="background: #89B83C; border-color: #89B83C;">No</button>
                                                        <a href="{{ route('employee.delete', ['id' => $e->id]) }}" class="btn btn-outline-danger mt-1 text-white" style="background: #FF533C; border-color: #FF533C">Yes</a>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                        "order": [[ 0, "asc" ]],
                        "columnDefs": [
                            { "searchable": false, "targets": [5] },
                            { "sortable": false, "targets": [5] }
                        ]
                    }
                );
            });
        </script>
@endsection