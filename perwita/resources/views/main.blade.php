
<!DOCTYPE html>
<html>
    <head>

        @include('partials._head')
        @yield('extra_styles')

        <style type="text/css">
            #overlay {

                position: fixed;

                display: none;

                width: 100%;

                height: 100%;

                top: 0;

                left: 0;

                right: 0;

                bottom: 0;

                background-color: rgba(0,0,0,0.6);

                z-index: 2500;

            }
        </style>

    </head>

    <body class="">
        <div id="wrapper">
            @include('partials._sidebar')

          <div id="page-wrapper" class="gray-bg dashbard-1">


            @include('partials._topnav')

            @include('partials._rightbar')
            
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
