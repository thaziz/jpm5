<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{ asset('assets/img/profile_small.jpg') }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Ilham</strong>
                            </span> <span class="text-muted text-xs block">Kelola Profil <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">

                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element" style="background:#f3f3f4;">
                    <img src="{{ asset('assets/img/dboard/logo/sublogo.png') }}" width="30px">
                </div>
            </li>

            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Purchase</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('purchase/suratpermintaanpembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Surat Permintaan Pembeliaan</a>
                    </li>
                </ul>
            </li>

            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Master Sales</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/item')}}"><i class="fa fa-building" aria-hidden="true"></i>Item</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/komisi')}}"><i class="fa fa-building" aria-hidden="true"></i>Komisi</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/customer')}}"><i class="fa fa-building" aria-hidden="true"></i>Customer</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/biaya')}}"><i class="fa fa-building" aria-hidden="true"></i>Biaya</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/saldopiutang')}}"><i class="fa fa-building" aria-hidden="true"></i>Saldo Piutang</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/saldoawalpiutanglain')}}"><i class="fa fa-building" aria-hidden="true"></i>Saldo Awal Piutang Lain</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/grupitem')}}"><i class="fa fa-building" aria-hidden="true"></i>Group Item</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/cabang')}}"><i class="fa fa-building" aria-hidden="true"></i>Cabang</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/tipeangkutan')}}"><i class="fa fa-building" aria-hidden="true"></i>Tipe Angkutan</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('mastersales/nomorseripajak')}}"><i class="fa fa-building" aria-hidden="true"></i>Nomor Seri Pajak</a>
                    </li>
                </ul>
            </li>


            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Sales</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/salesorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Sales Order (SO)</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/deliveryordercabang')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO) Cabang</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/deliveryordercabangtracking')}}"><i class="fa fa-building" aria-hidden="true"></i> Tracking Delivery Order (DO) Cabang</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/deliveryorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO)</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/notapenjualan')}}"><i class="fa fa-building" aria-hidden="true"></i> Invoice Penjualan</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/fakturpajak')}}"><i class="fa fa-building" aria-hidden="true"></i> Faktur Pajak</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/penerimaanpenjualan')}}"><i class="fa fa-building" aria-hidden="true"></i> Penerimaan Penjualan</a>
                    </li>
                </ul>
            </li>

            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Laporan Sales</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/laporansalesorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Sales Order (SO)</a>
                    </li>
                    <li class="sidebar mastercabangtrackingaan">
                        <a href="{{ url('sales/laporandeliveryorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO)</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/laporaninvoicepenjualan')}}"><i class="fa fa-building" aria-hidden="true"></i>Penjualan</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/laporaninvoicepenjualanperitem')}}"><i class="fa fa-building" aria-hidden="true"></i>Penjualan Per Item</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/laporanfakturpajak')}}"><i class="fa fa-building" aria-hidden="true"></i> Faktur Pajak</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/laporankartupiutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Kartu Piutang</a>
                    </li>
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('sales/laporanpiutangjatuhtempo')}}"><i class="fa fa-building" aria-hidden="true"></i> Piutang Jatuh Tempo</a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</nav>
