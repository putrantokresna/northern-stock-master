@extends('templates.default')
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-row mt-3">
            @if ($id == null)
            <h3 class="title fw-bolder" style="color: #FF9029;">Tambah <span style="color: #000">Produk</span> Baru</h3>
            @else
            <h3 class="title fw-bolder" style="color: #FF9029;">Edit <span style="color: #000">Produk</span></h3>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-9">
                <div class="card shadow">
                    <div class="card-body text-white fw-bold" style="background :#1B1717">
                        <form method="post" action="{{ route('product.post') }}">
                            @csrf
                            @if ($id != null)
                                <input type="hidden" name="id" value="{{ $id }}" readonly/>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <label for="nama" class="form-label">Nama Produk</label>
                                    @if ($id == null)
                                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror text-white fw-bold" name="nama"
                                            maxlength="100" value="{{ old('nama') }}" style="background: #FF9029; border-color: #FF9029" >
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @else
                                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror text-white fw-bold" name="nama"
                                            maxlength="100" value="{{ old('nama', $produk->nama) }}" style="background: #FF9029; border-color: #FF9029">
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="besaran" class="form-label">Besaran</label>
                                    @if ($id == null)
                                        <input type="number" id="besaran" class="form-control  @error('besaran') is-invalid @enderror text-white fw-bold" name="besaran" value="{{ old('besaran') }}" maxlength="100" style="background: #FF9029; border-color: #FF9029" >
                                        @error('besaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @else
                                        <input type="text" id="besaran" class="form-control @error('besaran') is-invalid @enderror text-white fw-bold" name="besaran" maxlength="100" value="{{ old('besaran', $produk->Besaran) }}" style="background: #FF9029; border-color: #FF9029" >
                                        @error('besaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    @if ($id == null)
                                        <input type="text" id="satuan" class="form-control @error('satuan') is-invalid @enderror text-white fw-bold" name="satuan" maxlength="100" value="{{ old('satuan') }}" style="background: #FF9029; border-color: #FF9029" >
                                        @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @else
                                        <input type="text" id="satuan" class="form-control @error('satuan') is-invalid @enderror text-white fw-bold" name="satuan" maxlength="100" value="{{ old('satuan', $produk->Satuan) }}" style="background: #FF9029; border-color: #FF9029" >
                                        @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col category-wrapper">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    @if($id == null)
                                        <select class="@error('kategori') is-invalid @enderror form-control text-white fw-bold kategori-opt" value="{{ old('kategori') }}" name="kategori" style="background: #FF9029; border-color: #FF9029" >
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $val)
                                                {
                                                <option value="{{ $val->kategori }}" {{ old('kategori') == "$val->kategori" ? 'selected' : '' }}>{{ $val->kategori }}</option>
                                                }
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @else
                                        <select class="@error('kategori') is-invalid @enderror form-control text-white fw-bold kategori-opt" value="{{old('kategori', $produk->kategori)}}" name="kategori" style="background: #FF9029; border-color: #FF9029">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $val)
                                                {
                                                <option value="{{ $val->kategori }}" {{ old('kategori', $produk->kategori) == "$val->kategori" ? 'selected' : '' }}>{{ $val->kategori }}</option>
                                                }
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                    <div id="tambah_kategori">

                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary btn-sm fw-bold" id="addButton" style="background: #89B83C; border-color: #89B83C;">
                                            <i class="fas fa-plus" style="color: #fff"></i> New Category
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="ket" class="form-label">Keterangan Masa Kadaluwarsa</label>
                                    @if ($id == null)
                                        <select name="ket" class="@error('ket') is-invalid @enderror form-control text-white fw-bold"  value="{{ old('ket')}}" style="background: #FF9029; border-color: #FF9029">
                                            <option value="">-- Pilih --</option>
                                            <option value="Expired Date" {{ old('ket') == "Expired Date" ? 'selected' : '' }}>Expired Date</option>
                                            <option value="Best Before" {{ old('ket') == "Best Before" ? 'selected' : '' }}>Best Before</option>
                                        </select>
                                        @error('ket')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @else
                                        <select name="ket" class="@error('ket') is-invalid @enderror form-control text-white fw-bold"  value="{{ old('ket', $produk->ket)}}" style="background: #FF9029; border-color: #FF9029">
                                            <option value="">-- Pilih --</option>
                                            <option value="Expired Date" {{ old('ket', $produk->ket) == "Expired Date" ? 'selected' : '' }}>Expired Date</option>
                                            <option value="Best Before" {{ old('ket', $produk->ket) == "Best Before" ? 'selected' : '' }}>Best Before</option>
                                        </select>
                                        @error('ket')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    @if ($id == null)
                                        <label for="stok" class="form-label">Stok Awal</label>
                                        <input type="number" id="stok" name="qty_awal" min="0"
                                            class="@error('qty_awal') is-invalid @enderror form-control text-white fw-bold" value="{{old('qty_awal')}}" style="background: #FF9029; border-color: #FF9029"  />
                                            @error('qty_awal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    @else
                                        <label for="stok" class="form-label">Stok Awal</label>
                                        @if ($produk->produk_inven->count() > 0)
                                            @if ($produk->opname_detail->count() > 0)
                                                <input type="number" id="stok" class="form-control text-white fw-bold"
                                                    value="{{ $produk->opname_detail->last()->qty_actual }}" style="background: #BF6A1B; border-color: #BF6A1B" disabled />
                                            @else
                                                <input type="number" id="stok" class="form-control text-white fw-bold"
                                                    value="{{ $produk->qty_awal }}" style="background: #BF6A1B; border-color: #BF6A1B" disabled />
                                            @endif
                                            <small class="text-secondary">Harap melakukan update stok di halaman awal atau
                                                stock opname</small>
                                        @else
                                            <input type="number" id="stok" name="qty_awal" min="0"
                                                class="@error('qty_awal') is-invalid @enderror form-control text-white fw-bold" value="{{old('qty_awal', $produk->qty_awal) }}" style="background: #FF9029; border-color: #FF9029"  />
                                                @error('qty_awal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary text-white fw-bold my-2" style="background: #FF9029; border-color: #FF9029">Simpan</button>
                                </div>
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
        let availableTags = [];
        let kategori = @json($kategori);
        for (var i = 0; i < kategori.length; i++)
            availableTags.push(kategori[i].kategori);
        
        let counter = 1

        $('#addButton').click(function () {
            if (counter == 1) {
                counter++;
            
                let newKategori =   `
                                            <input type="text" id="kategori" placeholder="Input New Category"
                                            autocomplete="off" class="@error('kategori') is-invalid @enderror form-control input-category mt-3 text-white fw-bold" name="kategori" maxlength="50" style="background: #FF9029; border-color: #FF9029">
                                            @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    `
                
                $('#tambah_kategori').append(newKategori)
                
                $('.kategori-opt').hide();

                $('input.input-category').on('keyup',function() {
                    if ($(this).val() != '') {
                        console.log($(this).val())
                        $('.kategori-opt').hide();
                    } else {
                        console.log($(this).val())
                        $('.kategori-opt').show();
                    }
                });
            }
            else {
                    alert("Tidak dapat Menambahkan Kategori!");
                    return;
            }
        });

        // $('#removeButton').click(function () {
        //     if(counter == 1) {
        //             alert("Tidak dapat mengurangi Kategori!");
        //             return;
        //         }
        //         else {
        //             $("#tambah_kategori").remove();
        //             $('.kategori-opt').show();
        //             counter--;
        //         }
        // });

        $(document).ready(function() {
            // $(".basicAutoComplete").autoComplete({
            //     minLength: 1,
            //     events: {
            //         search: function(qry, callback) {
            //             let finalSearch = availableTags.filter(item => item.toLowerCase().includes(qry.toLowerCase()));
            //             callback(finalSearch);
            //         }
            //     }
            // });input#kategori
            // $('.js-example-basic-multiple').select2({
            //     placeholder: "-- Pilih Kategori --",
            //     style:"background: #FF9029; border-color: #FF9029",
            //     maximumSelectionLength: 1
            // });

            $('.kategori-opt').on('change', function() {
                //   var data = $(".select2 option:selected").text();
                if ($(this).val().length != 0) {
                    $('input.input-category').removeAttr('name');
                    $('input.input-category').hide();
                } else {
                    $('input.input-category').attr('name', 'kategori');
                    $('input.input-category').show();
                }
            });

            // $('input.input-category').on('keyup',function() {
            //     if ($(this).val() != '') {
            //         console.log($(this).val())
            //         $('.select2-container').hide();
            //     } else {
            //         console.log($(this).val())
            //         $('.select2-container').show();
            //     }
            // });

        });
    </script>
@endsection
