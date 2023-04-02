        @extends('templates.default')
        
        @section('content')
        <section>
        <div class="container-fluid" style="background-color: #E2DFCC; padding: 4rem 0 8rem 0;">
            <div class="row justify-content-center">
                <div class="col-md-8 col-12 mx-md-2 mx-1">
                    @if(session('errmsg') != null)
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{session('errmsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('msg') != null)
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{session('msg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <h3 class="mt-3 fw-bolder" style="color: #FF9029">Penerimaan <span style="color: #000000">Produk</span></h3>
                    <div class="card shadow mt-3">
                        <div class="card-body newproduct-wrapper fw-bold" style="background :#1B1717">
                            <form action="{{route('home.masuk')}}" method="post" id="formMasuk">
                            @csrf
                            <div class="row" id="masuk1">
                                <div class="col-3">
                                    <label for="produk_mas1" class="form-label" style="color: #fff">Pilih Produk</label>
                                    <select id="produk_mas1"  class="form-select text-white" name="produk_id[]" style="background: #FF9029; border-color: #FF9029" required>
                                        <option value="" disabled selected></option>
                                        @foreach($produk as $p)
                                        <option value="{{$p->id}}" data-name="{{str_replace(' ', '', $p->nama)}}">{{$p->nama.' (ID: '.$p->id.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label for="besaranProductMas" class="form-label " style="color: #fff">Besaran Produk</label>
                                    <input type="number" class="form-control dummy-besaranproductMas text-white" id="dummyBesaranProductMas1" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @foreach ($produk as $p)
                                    <input type="number" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control besaran-product-mas d-none text-white" id="besaranProductMas{{$loop->iteration}}" name="besaranProductMas1" value="{{$p->Besaran}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <label for="satuanProductMas" class="form-label " style="color: #fff">Satuan Produk</label>
                                    <input type="text" class="form-control dummy-satuanproductMas text-white" id="dummySatuanProductMas1" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @foreach ($produk as $p)
                                    <input type="text" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control satuan-product-mas d-none text-white" id="satuanProductMas{{$loop->iteration}}" name="satuanProductMas1" value="{{$p->Satuan}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <label for="jumlah" class="form-label" style="color: #fff">Jumlah Produk</label>
                                    <input type="number" min="1" id="jumlah" class="form-control text-white" name="jumlah[]" style="background: #FF9029; border-color: #FF9029" required/>
                                </div>
                                <div class="col-3 text-white">
                                    <label for="kadaluarsa" class="form-label" style="color: #fff">Kadaluarsa</label>
                                    <input type="text" autocomplete="off" id="kadaluarsa" placeholder="yyyy-mm-dd" class="form-control text-white exp-datepicker" name="kadaluarsa[]" style="background: #FF9029; border-color: #FF9029" required/>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-2">
                                <div class="col-12 text-end">
                                <button type="button" class="btn btn-danger" onclick="kurangMasuk()" style="background: #FF533C; border-color: #FF533C"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-success" onclick="tambahMasuk()" style="background: #89B83C; border-color: #89B83C"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-2">
                                <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary fw-bold" style="background: #FF9029; border-color: #FF9029">Masuk Stok</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <h3 class="mt-3 fw-bolder" style="color: #FF9029">Pengeluaran <span style="color: #000000">Produk</span></h3>
                    <div class="card shadow mt-3">
                        <div class="card-body" style="background :#1B1717">
                            <form action="{{route('home.keluar')}}" method="post" id="formKeluar">
                            @csrf
                            <div class="row fw-bold" id="keluar1">
                                <div class="col-2">
                                    <label for="produk_kel1" class="form-label" style="color: #fff">Pilih Produk</label>
                                    
                                    <select id="produk_kel1" class="form-select text-white" name="produk_id[]" style="background: #FF9029; border-color: #FF9029" required>
                                        @foreach($produk as $p)
                                        <option value="" disabled selected></option>
                                        @if($p->qty_akhir < 5)
                                        <option value="{{$p->id}}" disabled selected data-name="{{str_replace(' ', '', $p->nama)}}">{{$p->nama.' (ID: '.$p->id.')'}}</option>
                                        @else
                                        <option value="{{$p->id}}" data-name="{{str_replace(' ', '', $p->nama)}}">{{$p->nama.' (ID: '.$p->id.')'}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label for="besaranProduct" class="form-label " style="color: #fff">Besaran Produk</label>
                                    <input type="number" class="form-control dummy-besaranproduct text-white" id="dummyBesaranProduct1" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @foreach ($produk as $p)
                                    <input type="number" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control besaran-product d-none text-white" id="besaranProduct{{$loop->iteration}}" name="besaranProduct1" value="{{$p->Besaran}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <label for="satuanProduct" class="form-label " style="color: #fff">Satuan Produk</label>
                                    <input type="text" class="form-control dummy-satuanproduct text-white" id="dummySatuanProduct1" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @foreach ($produk as $p)
                                    <input type="text" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control satuan-product d-none text-white" id="satuanProduct{{$loop->iteration}}" name="satuanProduct1" value="{{$p->Satuan}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <label for="latestProduct" class="form-label " style="color: #fff">Produk Akhir</label>
                                    <input type="number" class="form-control dummy-latestproduct text-white" id="dummyLatestProduct1" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @foreach ($produk as $p)
                                    <input type="number" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control latest-product d-none text-white" id="latestProduct{{$loop->iteration}}" name="latestProduct1" value="{{$p->qty_akhir}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <label for="jumlah_kel1" class="form-label" style="color: #fff">Jumlah Produk</label> 
                                    <input type="number" min="1" id="jumlah_kel1" class="form-control text-white" name="jumlah[]" style="background: #FF9029; border-color: #FF9029" required/>
                                </div>
                                <div class="col-2">
                                    <label for="sisa1" class="form-label" style="color: #fff">Sisa Produk</label>
                                    <input type="number" min="0" id="sisa1" class="form-control" style="background: #FF9029; border-color: #FF9029" readonly/>
                                    <small id="warning" class="text-secondary"></small>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-2">
                                <div class="col-12 text-end">
                                <button type="button" class="btn btn-danger" onclick="kurangKeluar()" style="background: #FF533C; border-color: #FF533C"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-success" id="addColumnOut" onclick="tambahKeluar()" style="background: #89B83C; border-color: #89B83C"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-2">
                                <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary fw-bold" style="background: #FF9029; border-color: #FF9029">Keluar Stok</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 mx-md-2 mx-1">

                    <h3 class="mt-3 fw-bolder" style="color: #FF9029">Masa <span style="color: #000">Kadaluarsa</span></h3>
                    <div class="card shadow mt-3 my-3">
                        <div class="card body p-3" style="background :#1B1717" >
                            @foreach($expInven as $exp)
                            <h3 style="color: #fff">{{$exp->produk->nama.' (ID: '.$exp->produk->id.')'}}</h3>
                            <h5 style="color: #fff">{{'Jumlah Produk Masuk: '.$exp->jumlah}}</h5>
                            <h5 class="text-danger">{{'Sisa: '.$exp->sisa_hari.' hari ('.$exp->produk->ket.')'}}</h5>
                            <h6 style="color: #fff">{{'Kadaluarsa: '.substr($exp->kadaluarsa, 0, 10)}}</h6>
                            <form action="{{route('home.masuk.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$exp->id}}"/>
                                <button type="button" class="btn btn-primary fw-bold my-3"
                                                            data-bs-toggle="modal" data-bs-target="#habisModal<?= $loop->iteration ?>" style="background: #FF533C; border-color: #FF533C; color: #fff">
                                                            Sudah Habis
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="habisModal<?= $loop-> iteration ?>" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                            Sudah Habis</h1>
                                                                        <button type="button" class="btn-clos`e"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Yakin produk sudah habis?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning" style="background: #89B83C; border-color: #89B83C; color: #fff">Yakin</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    
    @section('js')
    <script>
        var itemMas = 1;
        var itemKel = 1;
        var dateToday = new Date();

            let daftarProduk = @json($produk);
            function hitungSisa(id) {
                let jumlah = $('#jumlah_kel'+id).val();
                let produk = $('#produk_kel'+id).val();
                if(jumlah != null && produk != null) {
                    if(jumlah.length > 0 && produk.length > 0) {
                        var sisa = 0;
                        for(var i=0; i<daftarProduk.length; i++) {
                            if(daftarProduk[i].id == produk) {
                                sisa = daftarProduk[i].qty_akhir;
                                $("#jumlah_kel"+id).attr({
                                    "max" : daftarProduk[i].qty_akhir
                                });
                                break;
                            }
                        }
                        var sisaStock = sisa-jumlah;
                        $('#sisa'+id).val(sisaStock);
                        if (sisaStock < 5) {
                            $('#sisa'+id).addClass('text-danger')
                            $('#sisa'+id).removeClass('text-white')
                        }
                        else {
                            $('#sisa'+id).addClass('text-white')
                            $('#sisa'+id).removeClass('text-danger')
                        }
                    }
                }
            }
            $('#jumlah_kel1').on('change', function() {
                hitungSisa(1);
            });
            $('#produk_kel1').on('change', function() {
                hitungSisa(1);
            });
            
            function tambahKeluar() {
                itemKel++;
                $(`
                    <div class="row mt-2 text-white fw-bold" id="keluar`+itemKel+`">
                        <div class="col-2">
                            <label for="produk_kel`+itemKel+`" class="form-label">Pilih Produk</label>
                            <select id="produk_kel`+itemKel+`" class="form-select text-white" name="produk_id[]" style="background: #FF9029; border-color: #FF9029" required>
                            @foreach($produk as $p)
                                <option value="" disabled selected></option>
                                @if($p->qty_akhir < 5)
                                <option value="{{$p->id}}" disabled data-name="{{str_replace(' ', '', $p->nama)}}">{{$p->nama.' (ID: '.$p->id.')'}}</option>
                                @else
                                <option value="{{$p->id}}" data-name="{{str_replace(' ', '', $p->nama)}}">{{$p->nama.' (ID: '.$p->id.')'}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                        <label for="besaranProduct" class="form-label " style="color: #fff">Besaran Produk</label>
                        <input type="number" class="form-control dummy-besaranproduct text-white" id="dummyBesaranProduct`+itemKel+`" style="background: #FF9029; border-color: #FF9029" readonly/>
                        @foreach ($produk as $p)
                        <input type="number" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control besaran-product d-none text-white" id="besaranProduct{{$loop->iteration}}-`+itemKel+`" name="besaranProduct`+itemKel+`" value="{{$p->Besaran}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                        @endforeach
                        </div>
                        <div class="col-2">
                        <label for="satuanProduct" class="form-label " style="color: #fff">Satuan Produk</label>
                        <input type="text" class="form-control dummy-satuanproduct text-white" id="dummySatuanProduct`+itemKel+`" style="background: #FF9029; border-color: #FF9029" readonly/>
                        @foreach ($produk as $p)
                        <input type="text" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control satuan-product d-none text-white" id="satuanProduct{{$loop->iteration}}-`+itemKel+`" name="satuanProduct`+itemKel+`" value="{{$p->Satuan}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                        @endforeach
                        </div>
                        <div class="col-2">
                        <label for="latestProduct" class="form-label " style="color: #fff">Produk Akhir</label>
                        <input type="number" class="form-control dummy-latestproduct text-white" id="dummyLatestProduct`+itemKel+`" style="background: #FF9029; border-color: #FF9029" readonly/>
                        @foreach ($produk as $p)
                        <input type="number" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control latest-product d-none text-white" id="latestProduct{{$loop->iteration}}-`+itemKel+`" name="latestProduct`+itemKel+`" value="{{$p->qty_akhir}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                        @endforeach
                        </div>
                        <div class="col-2">
                        <label for="jumlah_kel`+itemKel+`" class="form-label">Jumlah Produk</label>
                        <input type="number" min="1" id="jumlah_kel`+itemKel+`" class="form-control text-white" name="jumlah[]" style="background: #FF9029; border-color: #FF9029" required/>
                        </div>
                        <div class="col-2">
                        <label for="sisa`+itemKel+`" class="form-label">Sisa Produk</label>
                        <input type="number" min="0" id="sisa`+itemKel+`" class="form-control text-white" style="background: #FF9029; border-color: #FF9029" readonly/>
                        </div>
                    </div>
                `).insertAfter("#keluar"+(itemKel-1));
                $('#jumlah_kel'+itemKel).on('change', function() {
                    hitungSisa(itemKel);
                });
                $('#produk_kel'+itemKel).on('change', function() {
                    hitungSisa(itemKel);
                });

                $('#produk_kel'+itemKel).on('change', function(){
                for(var id = 0; id < $('#produk_kel'+itemKel).find('option').length;id++)
                {
                    if($(this).find('option:selected').data('name') == $('#latestProduct'+id+'-'+itemKel).data('name') || $(this).find('option:selected').data('name') == $('#besaranProduct'+id+'-'+itemKel).data('name')
                    || $(this).find('option:selected').data('name') == $('#satuanProduct'+id+'-'+itemKel).data('name')) {
                        console.log('itemkel2', $('#latestProduct'+id+'-'+itemKel))
                        if($('.latest-product[name="latestProduct'+itemKel+'"]').hasClass('d-none')){
                            $('#dummyLatestProduct'+itemKel).addClass('d-none')
                            $('.latest-product[name="latestProduct'+itemKel+'"]').addClass('d-none')
                        }
                        if($('.besaran-product[name="besaranProduct'+itemKel+'"]').hasClass('d-none')){
                            $('#dummyBesaranProduct'+itemKel).addClass('d-none')
                            $('.besaran-product[name="besaranProduct'+itemKel+'"]').addClass('d-none')
                        }
                        if($('.satuan-product[name="satuanProduct'+itemKel+'"]').hasClass('d-none')){
                            $('#dummySatuanProduct'+itemKel).addClass('d-none')
                            $('.satuan-product[name="satuanProduct'+itemKel+'"]').addClass('d-none')
                        }
                        $('#latestProduct'+id+'-'+itemKel).removeClass('d-none')
                        $('#besaranProduct'+id+'-'+itemKel).removeClass('d-none')
                        $('#satuanProduct'+id+'-'+itemKel).removeClass('d-none')
                        id++;
                    }
                }

                // console.log($(this).val())
            })
            $('#jumlah_kel'+itemKel).keyup(function(){
                    if($(this).val() != ''){
                        $('#addColumnOut').attr('disabled', false)
                    }else{
                        $('#addColumnOut').attr('disabled', true)

                    }
                })
            }
            function tambahMasuk() {
                itemMas++;
                $(`
                    <div class="row mt-2 text-white fw-bold" id="masuk`+itemMas+`">
                        <div class="col-3">
                            <label for="produk_mas`+itemMas+`" class="form-label">Pilih Produk</label>
                            <select id="produk_mas`+itemMas+`" class="form-select text-white" name="produk_id[]" style="background: #FF9029; border-color: #FF9029" required>
                                <option value="" disabled selected></option>
                                @foreach($produk as $p)
                                <option value="{{$p->id}}" data-name="{{str_replace(' ', '', $p->nama)}}">{{$p->nama.' (ID: '.$p->id.')'}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="besaranProductMas" class="form-label " style="color: #fff">Besaran Produk</label>
                            <input type="number" class="form-control dummy-besaranproductMas text-white" id="dummyBesaranProductMas`+itemMas+`" style="background: #FF9029; border-color: #FF9029" readonly/>
                            @foreach ($produk as $p)
                            <input type="number" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control besaran-product-mas d-none text-white" id="besaranProductMas{{$loop->iteration}}-`+itemMas+`" name="besaranProductMas`+itemMas+`" value="{{$p->Besaran}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                            @endforeach
                        </div>
                        <div class="col-2">
                            <label for="satuanProductMas" class="form-label " style="color: #fff">Satuan Produk</label>
                            <input type="text" class="form-control dummy-satuanproductMas text-white" id="dummySatuanProductMas`+itemMas+`" style="background: #FF9029; border-color: #FF9029" readonly/>
                            @foreach ($produk as $p)
                            <input type="text" data-name="{{str_replace(' ', '', $p->nama)}}" class="form-control satuan-product-mas d-none text-white" id="satuanProductMas{{$loop->iteration}}-`+itemMas+`" name="satuanProductMas`+itemMas+`" value="{{$p->Satuan}}" style="background: #FF9029; border-color: #FF9029" readonly/>
                            @endforeach
                        </div>
                        <div class="col-2">
                            <label for="jumlah" class="form-label">Jumlah Produk</label>
                            <input type="number" min="1" id="jumlah`+itemMas+`" class="form-control text-white" name="jumlah[]" style="background: #FF9029; border-color: #FF9029" required/>
                        </div>
                        <div class="col-3">
                            <label for="kadaluarsa" class="form-label" style="color: #fff">Kadaluarsa</label>
                            <input type="text" autocomplete="off" id="kadaluarsa`+itemMas+`" placeholder="yyyy-mm-dd" class="form-control text-white exp-datepicker" name="kadaluarsa[]" style="background: #FF9029; border-color: #FF9029" required/>
                        </div>
                    </div>
                `).insertAfter("#masuk"+(itemMas-1));

                $('#produk_mas'+itemMas).on('change', function(){
                for(var id = 0; id < $('#produk_mas'+itemMas).find('option').length;id++)
                {
                    console.log(id)
                    if($(this).find('option:selected').data('name') == $('#besaranProductMas'+id+'-'+itemMas).data('name')
                    || $(this).find('option:selected').data('name') == $('#satuanProductMas'+id+'-'+itemMas).data('name')) {
                        if($('.besaran-product-mas[name="besaranProductMas'+itemKel+'"]').hasClass('d-none')){
                            
                            $('#dummyBesaranProductMas'+itemMas).addClass('d-none')
                            $('.besaran-product-mas[name="besaranProductMas'+itemMas+'"]').addClass('d-none')
                        }
                        if($('.satuan-product-mas[name="satuanProductMas'+itemMas+'"]').hasClass('d-none')){
                            
                            $('#dummySatuanProductMas'+itemMas).addClass('d-none')
                            $('.satuan-product-mas[name="satuanProductMas'+itemMas+'"]').addClass('d-none')
                        }
                        
                        $('#besaranProductMas'+id+'-'+itemMas).removeClass('d-none')
                        $('#satuanProductMas'+id+'-'+itemMas).removeClass('d-none')
                        
                        
                        id++;

                    }
                }});

                $( "#kadaluarsa"+itemMas).datepicker({
                showOn: 'focus',
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                minDate: dateToday
                });
            }
            function kurangKeluar() {
                if(itemKel == 1) {
                    alert("Tidak dapat mengurangi masukan produk keluar");
                    return;
                }
                $("#keluar"+itemKel).remove();
                itemKel--;
            }
            function kurangMasuk() {
                if(itemMas == 1) {
                    alert("Tidak dapat mengurangi masukan produk masuk");
                    return;
                }
                $("#masuk"+itemMas).remove();
                itemMas--;
            }
            $('document').ready(function(){

                // $('#jumlah_kel1').keyup(function(){
                //     if($(this).val() != ''){
                //         $('#addColumnOut').attr('disabled', false)
                //     }else{
                //         $('#addColumnOut').attr('disabled', true)

                //     }
                // })

                $("body").on("focus", ".exp-datepicker", function() {
    var context = $(this).parents('.newproduct-wrapper');
    console.log(context)
    $($(this), context).datepicker({
        showOn: 'focus',
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                minDate: dateToday,
                onSelect: function(selectedDate) {}
    });
});

            // $( ".exp-datepicker").datepicker({
            //     showOn: 'focus',
            //     changeMonth: true,
            //     changeYear: true,
            //     dateFormat: 'yy-mm-dd',
            //     minDate: dateToday

            // });
            // console.log($('#produk_kel1 option').length);
            $('#produk_kel1').on('change', function(){
                for(var id = 0; id < $('#produk_kel1 option').length;id++)
                {
                    console.log(id)
                    if($(this).find('option:selected').data('name') == $('#latestProduct'+id).data('name') || $(this).find('option:selected').data('name') == $('#besaranProduct'+id).data('name')
                    || $(this).find('option:selected').data('name') == $('#satuanProduct'+id).data('name')) {
                        if($('.besaran-product').hasClass('d-none')){
                            
                            $('#dummyBesaranProduct1').addClass('d-none')
                            $('.besaran-product[name="besaranProduct1"]').addClass('d-none')
                        }
                        if($('.satuan-product').hasClass('d-none')){
                            
                            $('#dummySatuanProduct1').addClass('d-none')
                            $('.satuan-product[name="satuanProduct1"]').addClass('d-none')
                        }
                        if($('.latest-product').hasClass('d-none')){
                            
                            $('#dummyLatestProduct1').addClass('d-none')
                            $('.latest-product[name="latestProduct1"]').addClass('d-none')
                        }
                        $('#besaranProduct'+id).removeClass('d-none')
                        $('#satuanProduct'+id).removeClass('d-none')
                        $('#latestProduct'+id).removeClass('d-none')
                        
                        
                        id++;

                    }
                }})
            $('#produk_mas1').on('change', function(){
                for(var id = 0; id < $('#produk_mas1 option').length;id++)
                {
                    console.log(id)
                    if($(this).find('option:selected').data('name') == $('#besaranProductMas'+id).data('name')
                    || $(this).find('option:selected').data('name') == $('#satuanProductMas'+id).data('name')) {
                        if($('.besaran-product-mas').hasClass('d-none')){
                            
                            $('#dummyBesaranProductMas1').addClass('d-none')
                            $('.besaran-product-mas[name="besaranProductMas1"]').addClass('d-none')
                        }
                        if($('.satuan-product-mas').hasClass('d-none')){
                            
                            $('#dummySatuanProductMas1').addClass('d-none')
                            $('.satuan-product-mas[name="satuanProductMas1"]').addClass('d-none')
                        }
                        
                        $('#besaranProductMas'+id).removeClass('d-none')
                        $('#satuanProductMas'+id).removeClass('d-none')
                        
                        
                        id++;

                    }
                }})
                    // else if($(this).find('option:selected').data('name') == $('#besaranProduct'+id).data('name')) {
                    //     if($('.besaran-product').hasClass('d-none')){
                            
                    //         $('#dummyBesaranProduct1').addClass('d-none')
                    //         $('.besaran-product[name="besaranProduct1"]').addClass('d-none')
                    //     }

                    // }
                    // else if($(this).find('option:selected').data('name') == $('#satuanProduct'+id).data('name')) {
                    //     if($('.satuan-product').hasClass('d-none')){
                            
                    //         $('#dummySatuanProduct1').addClass('d-none')
                    //         $('.satuan-product[name="satuanProduct1"]').addClass('d-none')
                    //     }
                    // }
                    // $('#latestProduct'+id).removeClass('d-none')
                    // id++;
                    // $('#besaranProduct'+id).removeClass('d-none')
                    // id++;
                    // $('#satuanProduct'+id).removeClass('d-none')
                    // id++;
                // console.log($(this).val())
            
            // $('#produk_kel1').on('change', function(){
            //     for(var id = 0; id < $('#produk_kel1 option').length;id++)
            //     {
            //         console.log(id)
            //         if($(this).find('option:selected').data('name') == $('#besaranProduct'+id).data('name')) {
            //             if($('.besaran-product').hasClass('d-none')){
                            
            //                 $('#dummyBesaranProduct1').addClass('d-none')
            //                 $('.besaran-product[name="besaranProduct1"]').addClass('d-none')
            //             }
            //             $('#besaranProduct'+id).removeClass('d-none')
            //             id++;
            //         }
            //     }
            //     // console.log($(this).val())
            // })
            // $('#produk_kel1').on('change', function(){
            //     for(var id = 0; id < $('#produk_kel1 option').length;id++)
            //     {
            //         console.log(id)
            //         if($(this).find('option:selected').data('name') == $('#satuanProduct'+id).data('name')) {
            //             if($('.satuan-product').hasClass('d-none')){
                            
            //                 $('#dummySatuanProduct1').addClass('d-none')
            //                 $('.satuan-product[name="satuanProduct1"]').addClass('d-none')
            //             }
            //             $('#satuanProduct'+id).removeClass('d-none')
            //             id++;
            //         }
            //     }
            //     // console.log($(this).val())
            // })
            })
</script>
@endsection