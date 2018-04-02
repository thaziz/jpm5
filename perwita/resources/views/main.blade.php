
<!DOCTYPE html>
<html>
    <head>

        @include('partials._head')
        @yield('extra_styles')

    </head>

    <body class="">
        <div id="wrapper">
            @include('partials._sidebar')

          <div id="page-wrapper" class="gray-bg dashbard-1">


            @include('partials._topnav')
            
            @if(cek_periode() == 0)
                <div class="alert alert-danger">
                    <strong>Periode Keuangan Untuk Bulan Ini Belum Ada.</strong> Harap Membuatnya Terlebih Dahulu Di Menu <strong> Setting > Keuangan > Tambah Periode </strong>, Lalu Muat Ulang Halaman.
                </div>
            @endif

            @yield('content')

            @include('partials._footer')
          </div>
        </div>

        @include('partials._scripts')
        @yield('extra_scripts')
        
        @include('partials._modal')
        
    </body>
</html>
