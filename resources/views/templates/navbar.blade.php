<header>
    <nav class="navbar navbar-expand-lg" style="background-color: #E2DFCC;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bolder fs-3" href="/" style="color: #FF9029;">Northern <span
                    style="color: #000000">Stock</span> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product') }}">Daftar Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('opname') }}">Stock Opname</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('history') }}">Riwayat</a>
                    </li>
                    @if (session('user')->role == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee') }}">Karyawan</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    <li class="nav-item">
                        <div class="btn-group message-wrap">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Pesan
                            </button>
                            <span class="badge">
                                0
                            </span>
                            <ul class="dropdown-menu content justify-content-center">
                                <div class="loader"></div>

                            </ul>
                        </div>
                        {{-- <a class="nav-link" href="{{ route('message') }}">Pesan</a> --}}
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
    $('document').ready(function() {

        $.ajax({
                method: "GET",
                url: "{{ route('home.notification') }}",
                success: function(data) {
                    console.log(data)
                    $('.message-wrap .badge').html(data);
                }
            });
        $('.dropdown-toggle').click(function() {

            $.ajax({
                method: "GET",
                url: "{{ route('message') }}",
                success: function(data) {
                    // console.log(data)
                    $('.content').html(data);
                }
            })

            $('.message-wrap .badge').html('0');


        });
    });
</script>
