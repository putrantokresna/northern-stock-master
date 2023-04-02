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
                @if($id == null)
                <h3 class="title fw-bolder" style="color: #FF9029;">Tambah <span style="color: #000">Karyawan</span> Baru</h3>
                @else
                <h3 class="title fw-bolder" style="color: #FF9029;">Edit <span style="color: #000">Karyawan</span></h3>
                @endif
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body text-white fw-bold" style="background :#1B1717">
                            <form method="post" action="{{ route('employee.post') }}">
                                @csrf
                                @if($id != null)
                                <input type="hidden" name="id" value="{{$id}}"/>
                                @endif
                                <div class="row">
                                    <div class="col">
                                        <label for="nama" class="form-label">Nama Karyawan</label>
                                        @if($id == null)
                                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror text-white fw-bold" value="{{ old('nama') }}" name="nama" maxlength="50" style="background: #FF9029; border-color: #FF9029">
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @else
                                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror text-white fw-bold" name="nama" maxlength="50" value="{{ old('nama', $employee->nama) }}" style="background: #FF9029; border-color: #FF9029">
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <label for="nama" class="form-label">Alamat</label>
                                        @if($id == null)
                                        <textarea rows="3" id="alamat" class="form-control @error('alamat') is-invalid @enderror text-white fw-bold" value="{{ old('alamat') }}" name="alamat" style="background: #FF9029; border-color: #FF9029">{{ old('alamat')}}</textarea>
                                        @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @else
                                        <textarea rows="3" id="alamat" class="form-control @error('alamat') is-invalid @enderror text-white fw-bold" value="{{ old('alamat', $employee->alamat) }}" name="alamat" style="background: #FF9029; border-color: #FF9029">{{ old('alamat', $employee->alamat) }}</textarea>
                                        @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <label for="nama" class="form-label">Email</label>
                                        @if($id == null)
                                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror text-white fw-bold" name="email" maxlength="100" value="{{ old('email') }}" style="background: #FF9029; border-color: #FF9029">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @else
                                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror text-white fw-bold" name="email" maxlength="100" value="{{ old('email', $employee->email) }}" style="background: #FF9029; border-color: #FF9029">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <label for="nama" class="form-label">Password</label>
                                        @if($id == null)
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror text-white fw-bold" value="{{ old('password') }}" name="password" style="background: #FF9029; border-color: #FF9029">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @else
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror text-white fw-bold" value="{{ old('password', $employee->password) }}" name="password" style="background: #FF9029; border-color: #FF9029">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary text-white fw-bold" style="background: #FF9029; border-color: #FF9029">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection