<style type="text/css">
    .nav-third-level li a.active{
        color: white;
    }
</style>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{ asset('assets/img/profile_small.jpg') }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                            {{ Auth::user()->m_name }}
                        </strong>
                            </span>                             
                            {{-- <span class="text-muted text-xs block">Kelola Profil <b class="caret"></b></span>  --}}
                        </span> 
                        @if(Auth::user()->kode_cabang=='')
                         <select onchange="pilihCabang()" id="kode-cabang" class="input-sm" style="color:#009aa9">
                            @foreach( Session::get('userCabang') as $data )
                                <option @if($data->kode==Session::get('cabang'))selected="" @endif value="{{$data->kode}}" >
                                    {{$data->nama}}
                                </option>
                            @endforeach
                        </select>
                        @else
                            <select disabled="" onchange="pilihCabang()" class="input-sm" style="color:#009aa9">
                                <option>{{Session::get('namaCabang')}}</option>
                            </select>
                        @endif

                    </a>
                    {{-- <ul class="dropdown-menu animated fadeInRight m-t-xs">

                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('logout') }}">Logout</a></li>
                    </ul> --}}
                </div>
                <div class="logo-element" style="background:#f3f3f4;">
                    <img src="{{ asset('assets/img/dboard/logo/sublogo.png') }}" width="30px">
                </div>
            </li>

                <!-- Setting --> 
                <li class="treeview sidebar data-master {{Request::is('setting/pengguna') ? 'active' : '' || Request::is('setting/pengguna/*') ? 'active' : '' }}">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Setting</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="sidebar {{Request::is('setting/pengguna') ? 'active' : '' || Request::is('setting/pengguna/*') ? 'active' : '' }} ">
                            <a href="{{ url('setting/pengguna')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pengguna</a>
                        </li>

                       <!--   <li class="sidebar {{Request::is('setting/groupbaru') ? 'active' : '' || Request::is('setting/groupbaru/*') ? 'active' : '' }} ">
                            <a href="{{ url('setting/groupbaru')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Group Baru </a>
                        </li> -->

                       <!--  <li class="sidebar {{Request::is('setting/daftarmenu') ? 'active' : '' || Request::is('setting/daftarmenu/*') ? 'active' : '' }} ">
                            <a href="{{ url('setting/daftarmenu')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Daftar Menu </a>
                        </li> -->

                        <li>
                                <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Keuangan <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#" id="setting_periode"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tambah Periode</a>
                                    </li>

                                    <li>
                                        <a href="#" id="option_periode"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Setting Periode</a>
                                    </li>

                                </ul>
                            </li>

                    </ul>
                </li>
                <!-- end Setting -->

                <!-- Master --> 
        <li class="treeview sidebar data-master 
                {{ 
            /*================== sub MASTER BERSAMA ==================*/
                    /* Pajak */
                    Request::is('master_sales/pajak') ? 'active' : '' || 
                    Request::is('master_sales/pajak/*') ? 'active' : '' ||
                    /* Sales Provnsi */
                    Request::is('sales/provinsi') ? 'active' : '' || 
                    Request::is('sales/provinsi/*') ? 'active' : '' ||
                    /* Kota */
                    Request::is('sales/kota') ? 'active' : '' || 
                    Request::is('sales/kota/*') ? 'active' : '' ||
                    /* Kecamatan */
                    Request::is('sales/kecamatan') ? 'active' : '' || 
                    Request::is('sales/kecamatan/*') ? 'active' : '' ||
                    /* Cabang */
                    Request::is('master_sales/cabang') ? 'active' : '' || 
                    Request::is('master_sales/cabang/*') ? 'active' : '' ||
                    /* tipeangkutan */
                    Request::is('master_sales/tipe_angkutan') ? 'active' : '' || 
                    Request::is('master_sales/tipe_angkutan/*') ? 'active' : '' ||
                    /* Kendaraan */
                    Request::is('master_sales/kendaraan') ? 'active' : '' || 
                    Request::is('master_sales/kendaraan/*') ? 'active' : '' ||
            /*===============  sub END OF MASTER BERSAMA ==============*/

            /*===============  sub MASTER PENJUALAN ==============*/

                 /*==================== sub MASTER TARIF ===================*/
                    /* tarif_cabang_dokumen */
                    Request::is('sales/tarif_cabang_dokumen') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_dokumen/*') ? 'active' : '' ||
                    /* tarif_cabang_kilogram */
                    Request::is('sales/tarif_cabang_kilogram') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kilogram/*') ? 'active' : '' ||
                    /* tarif_cabang_koli */
                    Request::is('sales/tarif_cabang_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_koli/*') ? 'active' : '' ||
                    /* sepeda */
                    Request::is('sales/tarif_cabang_sepeda') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_sepeda/*') ? 'active' : '' ||
                    /* tarif_cabang_kargo */
                    Request::is('sales/tarif_cabang_kargo') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kargo/*') ? 'active' : '' ||
                    /* tarif penerus default */
                    Request::is('sales/tarif_penerus_default') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_default/*') ? 'active' : '' ||
                    /* tarif penerus doc */
                    Request::is('sales/tarif_penerus_dokumen') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_dokumen/*') ? 'active' : ''|| 
                    /* tarif penerus Kilogram */
                    Request::is('sales/tarif_penerus_kilogram') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_kilogram/*') ? 'active' : ''|| 
                    /* tarif penerus koli */
                    Request::is('sales/tarif_penerus_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_koli/*') ? 'active' : '' ||
                 /*================ END OF MASTER TARIF =================*/

                 /*===================== MASTER DO ======================*/
                    /* agen */
                    Request::is('master_sales/agen') ? 'active' : '' || 
                    Request::is('master_sales/agen/*') ? 'active' : '' ||
                    /* vendor */
                    Request::is('master_sales/vendor') ? 'active' : '' || 
                    Request::is('master_sales/vendor/*') ? 'active' : '' ||
                    /* rute */
                    Request::is('master_sales/rute') ? 'active' : '' || 
                    Request::is('master_sales/rute/*') ? 'active' : '' ||
                    /* satuan */
                    Request::is('master_sales/satuan') ? 'active' : '' || 
                    Request::is('master_sales/satuan/*') ? 'active' : '' ||
                     /* Zona */
                    Request::is('sales/zona') ? 'active' : '' || 
                    Request::is('sales/zona/*') ? 'active' : '' ||
                    /* Group item */
                    Request::is('master_sales/group_customer') ? 'active' : '' || 
                    Request::is('master_sales/group_customer/*') ? 'active' : '' ||
                    /* Group item */
                    Request::is('master_sales/grup_item') ? 'active' : '' || 
                    Request::is('master_sales/grup_item/*') ? 'active' : '' ||
                    /* item */
                    Request::is('master_sales/item') ? 'active' : '' || 
                    Request::is('master_sales/item/*') ? 'active' : '' ||
                    /* komisi */
                    Request::is('master_sales/komisi') ? 'active' : '' || 
                    Request::is('master_sales/komisi/*') ? 'active' : '' ||
                    /* customer */
                    Request::is('master_sales/customer') ? 'active' : '' || 
                    Request::is('master_sales/customer/*') ? 'active' : '' ||
                    /* subcon */
                    Request::is('master_sales/subcon') ? 'active' : '' || 
                    Request::is('master_sales/subcon/*') ? 'active' : '' ||
                    /* biaya */
                    Request::is('master_sales/biaya') ? 'active' : '' || 
                    Request::is('master_sales/biaya/*') ? 'active' : '' ||
                    /* saldo piutang */
                    Request::is('master_sales/saldopiutang') ? 'active' : '' || 
                    Request::is('master_sales/saldopiutang/*') ? 'active' : '' ||
                    /* saldo awal piutang akir */
                    Request::is('master_sales/saldoawalpiutanglain') ? 'active' : '' || 
                    Request::is('master_sales/saldoawalpiutanglain/*') ? 'active' : '' ||
                    /* Nomor seri pajak */
                    Request::is('master_sales/nomorseripajak') ? 'active' : '' || 
                    Request::is('master_sales/nomorseripajak/*') ? 'active' : '' ||
                    /* master diskon penjualan */
                    Request::is('master_sales/diskonpenjualan') ? 'active' : '' || 
                 /*=================  END OF MASTER DO ==================*/
                 /*================= sub MASTER KONTRAK ================= */
                    /* Kontrak */
                    Request::is('master_sales/kontrak') ? 'active' : '' || 
                    Request::is('master_sales/kontrak/*') ? 'active' : '' ||
                    /* subcon */
                    Request::is('master_subcon/subcon') ? 'active' : '' || 
                    Request::is('master_subcon/subcon/*') ? 'active' : '' ||
                 /*=============== End of sub MASTER KONTRAK ============ */

            /*===============  sub MASTER PENJUALAN ==============*/
            /* kosong */
            /*=============== sub  MASTER PEMBELIAN ==============*/
                    /* Master Group item  */
                    Request::is('masterjenisitem/masterjenisitem') ? 'active' : '' || 
                    Request::is('masterjenisitem/masterjenisitem/*') ? 'active' : '' ||
                    /* Master item purchase */
                    Request::is('masteritem/masteritem') ? 'active' : '' || 
                    Request::is('masteritem/masteritem/*') ? 'active' : '' ||
                    /* Master Supplier */
                    Request::is('mastersupplier/mastersupplier') ? 'active' : '' || 
                    Request::is('mastersupplier/mastersupplier/*') ? 'active' : '' ||
                    /* Konfirmasi Supplier */
                    Request::is('konfirmasisupplier/konfirmasisupplier') ? 'active' : '' || 
                    Request::is('konfirmasisupplier/konfirmasisupplier/*') ? 'active' : '' ||
                    /* Master Gudang */
                    Request::is('mastergudang/mastergudang') ? 'active' : '' || 
                    Request::is('mastergudang/mastergudang/*') ? 'active' : '' ||
                    /* Master Departement */
                    Request::is('masterdepartment/masterdepartment') ? 'active' : '' || 
                    Request::is('masterdepartment/masterdepartment/*') ? 'active' : '' ||
            /*================ END OF sub MASTER PEMBELIAN =======*/ 
                /*================ sub MASTER BIAYA PENERUS ======*/  
                    /* Master Gudang */
                    Request::is('presentase/index') ? 'active' : '' || 
                    Request::is('presentase/index/*') ? 'active' : '' ||
                    /* Master Departement */
                    Request::is('bbm/index') ? 'active' : '' || 
                    Request::is('bbm/index/*') ? 'active' : '' ||
                /*========== END OF MASTER BIAYA PENERUS =========*/ 
            /*======= MASTER KEUANGAN ============================*/
                    /* saldo_akun */
                    Request::is('master_keuangan/saldo_akun') ? 'active' : '' || 
                    Request::is('master_keuangan/saldo_akun/*') ? 'active' : '' ||
                    /* masterbank */
                    Request::is('masterbank/masterbank') ? 'active' : '' || 
                    Request::is('masterbank/masterbank/*') ? 'active' : '' ||
                    /* masteractiva */
                    Request::is('masteractiva/masteractiva') ? 'active' : '' || 
                    Request::is('masteractiva/masteractiva/*') ? 'active' : '' ||
                    /* golonganactiva */
                    Request::is('golonganactiva/golonganactiva') ? 'active' : '' || 
                    Request::is('golonganactiva/golonganactiva/*') ? 'active' : '' ||
                    /* notadebit */
                    Request::is('notadebit/notadebit') ? 'active' : '' || 
                    Request::is('notadebit/notadebit/*') ? 'active' : '' ||
                    /* kelompok_akun */
                    Request::is('master_keuangan/kelompok_akun') ? 'active' : '' || 
                    Request::is('master_keuangan/kelompok_akun/*') ? 'active' : '' ||
                    /* Transaksi */
                    Request::is('master-transaksi/index') ? 'active' : '' || 
                    Request::is('master-transaksi/index/*') ? 'active' : '' ||
                    /* akun */
                    Request::is('master_keuangan/akun') ? 'active' : '' || 
                    Request::is('master_keuangan/akun/*') ? 'active' : ''
            /*================= END OF MASTER KEUANGAN ===========*/
                }}

                ">
            <a href="#" class="" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label" style="font-size:100%">Master</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li class="sidebar

                {{ 

                    /*================== MASTER BERSAMA ==================*/
                    /* Pajak */
                    Request::is('master_sales/pajak') ? 'active' : '' || 
                    Request::is('master_sales/pajak/*') ? 'active' : '' ||
                    /* Sales Provnsi */
                    Request::is('sales/provinsi') ? 'active' : '' || 
                    Request::is('sales/provinsi/*') ? 'active' : '' ||
                    /* Kota */
                    Request::is('sales/kota') ? 'active' : '' || 
                    Request::is('sales/kota/*') ? 'active' : '' ||
                    /* Kecamatan */
                    Request::is('sales/kecamatan') ? 'active' : '' || 
                    Request::is('sales/kecamatan/*') ? 'active' : '' ||
                    /* Cabang */
                    Request::is('master_sales/cabang') ? 'active' : '' || 
                    Request::is('master_sales/cabang/*') ? 'active' : '' ||
                    /* tipeangkutan */
                    Request::is('master_sales/tipe_angkutan') ? 'active' : '' || 
                    Request::is('master_sales/tipe_angkutan/*') ? 'active' : '' ||
                    /* Kendaraan */
                    Request::is('master_sales/kendaraan') ? 'active' : '' || 
                    Request::is('master_sales/kendaraan/*') ? 'active' : '' 
                    /*================= END OF MASTER BERSAMA ==============*/

                }}

                ">
                    <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Master Bersama <span class="fa arrow"></span></a>
            <ul class="nav nav-third-level"  style="font-size:90%" >
                <li>
                    <a class="{{Request::is('master_sales/pajak') ? 'active' : '' ||
                 Request::is('master_sales/pajak/*') ? 'active' : ''}}" href="{{ url('master_sales/pajak')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pajak</a>
                </li>
                <li >
                    <a class="sidebar master-perusahaan {{Request::is('sales/provinsi') ? 'active' : '' || 
                    Request::is('sales/provinsi/*') ? 'active' : ''}}" href="{{ url('sales/provinsi')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Provinsi</a>
                </li>
                <li >
                    <a class="sidebar master-perusahaan 

                {{Request::is('sales/kota') ? 'active' : '' ||
                 Request::is('sales/kota/*') ? 'active' : ''}} 

                " href="{{ url('sales/kota')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kota</a>
                </li>
                <li >
                    <a class="sidebar master-perusahaan 

                {{ Request::is('sales/kecamatan') ? 'active' : '' ||
                 Request::is('sales/kecamatan/*') ? 'active' : ''}} 

                " href="{{ url('sales/kecamatan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kecamatan</a>
                </li>
                <li >
                    <a class="sidebar master-perusahaan 

                {{Request::is('master_sales/cabang') ? 'active' : '' ||
                 Request::is('master_sales/cabang/*') ? 'active' : ''}} 

                " href="{{ url('master_sales/cabang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Cabang</a>
                </li>
                @if(Auth::user()->PunyaAkses('Tipe Kendaraan','aktif'))
                <li >
                    <a class="sidebar master-perusahaan 

                {{Request::is('master_sales/tipe_angkutan') ? 'active' : '' ||
                 Request::is('master_sales/tipe_angkutan/*') ? 'active' : ''}} 

                " href="{{ url('master_sales/tipe_angkutan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tipe Angkutan</a>
                </li>
                @endif
                <li >
                    <a class="sidebar master-perusahaan 

                {{Request::is('master_sales/kendaraan') ? 'active' : '' ||
                 Request::is('master_sales/kendaraan/*') ? 'active' : ''}} 

                " href="{{ url('master_sales/kendaraan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kendaraan</a>
                </li>
            </ul>
        </li>
                        
                <li class="treeview sidebar data-master 

                {{

                    /*================== MASTER TARIF ==================*/
                    /* tarif_cabang_dokumen */
                    Request::is('sales/tarif_cabang_dokumen') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_dokumen/*') ? 'active' : '' ||
                    /* tarif_cabang_kilogram */
                    Request::is('sales/tarif_cabang_kilogram') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kilogram/*') ? 'active' : '' ||
                    /* tarif_cabang_koli */
                    Request::is('sales/tarif_cabang_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_koli/*') ? 'active' : '' ||
                     /* sepeda */
                    Request::is('sales/tarif_cabang_sepeda') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_sepeda/*') ? 'active' : '' ||
                    /* tarif_cabang_kargo */
                    Request::is('sales/tarif_cabang_kargo') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kargo/*') ? 'active' : '' ||
                    /* tarif penerus default */
                    Request::is('sales/tarif_penerus_default') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_default/*') ? 'active' : '' || 
                    /* tarif penerus doc */
                    Request::is('sales/tarif_penerus_dokumen') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_dokumen/*') ? 'active' : ''|| 
                    /* tarif penerus Kilogram */
                    Request::is('sales/tarif_penerus_kilogram') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_kilogram/*') ? 'active' : ''|| 
                    /* tarif penerus koli */
                    Request::is('sales/tarif_penerus_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_koli/*') ? 'active' : '' ||
                    /*=============== END OF MASTER TARIF ==============*/
                    /*===================== MASTER DO ======================*/
                    /* agen */
                    Request::is('master_sales/agen') ? 'active' : '' || 
                    Request::is('master_sales/agen/*') ? 'active' : '' ||
                    /* vendor */
                    Request::is('master_sales/vendor') ? 'active' : '' || 
                    Request::is('master_sales/vendor/*') ? 'active' : '' ||
                    /* rute */
                    Request::is('master_sales/rute') ? 'active' : '' || 
                    Request::is('master_sales/rute/*') ? 'active' : '' ||
                    /* satuan */
                    Request::is('master_sales/satuan') ? 'active' : '' || 
                    Request::is('master_sales/satuan/*') ? 'active' : '' ||
                     /* Zona */
                    Request::is('sales/zona') ? 'active' : '' || 
                    Request::is('sales/zona/*') ? 'active' : '' ||
                    /* Group item */
                    Request::is('master_sales/group_customer') ? 'active' : '' || 
                    Request::is('master_sales/group_customer/*') ? 'active' : '' ||
                    /* Group item */
                    Request::is('master_sales/grup_item') ? 'active' : '' || 
                    Request::is('master_sales/grup_item/*') ? 'active' : '' ||
                    /* item */
                    Request::is('master_sales/item') ? 'active' : '' || 
                    Request::is('master_sales/item/*') ? 'active' : '' ||
                    /* komisi */
                    Request::is('master_sales/komisi') ? 'active' : '' || 
                    Request::is('master_sales/komisi/*') ? 'active' : '' ||
                    /* customer */
                    Request::is('master_sales/customer') ? 'active' : '' || 
                    Request::is('master_sales/customer/*') ? 'active' : '' ||
                    /* subcon */
                    Request::is('master_sales/subcon') ? 'active' : '' || 
                    Request::is('master_sales/subcon/*') ? 'active' : '' ||
                    /* biaya */
                    Request::is('master_sales/biaya') ? 'active' : '' || 
                    Request::is('master_sales/biaya/*') ? 'active' : '' ||
                    /* saldo piutang */
                    Request::is('master_sales/saldopiutang') ? 'active' : '' || 
                    Request::is('master_sales/saldopiutang/*') ? 'active' : '' ||
                    /* saldo awal piutang akir */
                    Request::is('master_sales/saldoawalpiutanglain') ? 'active' : '' || 
                    Request::is('master_sales/saldoawalpiutanglain/*') ? 'active' : '' ||
                    /* master diskon penjualan */
                    Request::is('master_sales/diskonpenjualan') ? 'active' : '' || 
                    /* Nomor seri pajak */
                    Request::is('master_sales/nomorseripajak') ? 'active' : '' || 
                    Request::is('master_sales/nomorseripajak/*') ? 'active' : '' 
                 /*=================  END OF MASTER DO ==================*/
               

                }}

                ">
                    <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Master Penjualan <span class="fa arrow"></span></a>
                       <ul class="nav nav-second-level collapse"  style="font-size:90%"  >
                       <li class="

                       {{

                    /*================== MASTER TARIF ==================*/
                    /* tarif_cabang_dokumen */
                    Request::is('sales/tarif_cabang_dokumen') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_dokumen/*') ? 'active' : '' ||
                    /* tarif_cabang_kilogram */
                    Request::is('sales/tarif_cabang_kilogram') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kilogram/*') ? 'active' : '' ||
                    /* tarif_cabang_koli */
                    Request::is('sales/tarif_cabang_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_koli/*') ? 'active' : '' ||
                     /* sepeda */
                    Request::is('sales/tarif_cabang_sepeda') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_sepeda/*') ? 'active' : '' ||
                    /* tarif_cabang_kargo */
                    Request::is('sales/tarif_cabang_kargo') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kargo/*') ? 'active' : '' ||
                    /* tarif penerus default */
                    Request::is('sales/tarif_penerus_default') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_default/*') ? 'active' : '' ||
                    /* tarif penerus doc */
                    Request::is('sales/tarif_penerus_dokumen') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_dokumen/*') ? 'active' : ''|| 
                    /* tarif penerus Kilogram */
                    Request::is('sales/tarif_penerus_kilogram') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_kilogram/*') ? 'active' : ''|| 
                    /* tarif penerus koli */
                    Request::is('sales/tarif_penerus_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_penerus_koli/*') ? 'active' : '' 
                    /*=============== END OF MASTER TARIF ==============*/

                }}

                       " style="padding-left: 10%;">
                       <a href="#" {{-- style="padding-left: 30%;" --}} style="font-size: 13px;">Master Tarif<span class="fa arrow"></span></a>
                       <ul class="nav nav-third-level" >
                        <li class="sidebar master-perusahaan">
                            <a href="{{ url('sales/tarif_cabang_dokumen')}}" class="{{Request::is('sales/tarif_cabang_dokumen') ? 'active' : '' ||
                         Request::is('sales/tarif_cabang_dokumen/*') ? 'active' : ''}} "><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Cabang Dokumen</a>
                            </li>
                        <li>
                            <a class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_cabang_kilogram') ? 'active' : '' ||
                         Request::is('sales/tarif_cabang_kilogram/*') ? 'active' : ''}}" href="{{ url('sales/tarif_cabang_kilogram')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Cabang Kilogram</a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_cabang_koli') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_koli/*') ? 'active' : ''}} 

                        " href="{{ url('sales/tarif_cabang_koli')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Cabang Koli</a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_cabang_kargo') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_kargo/*') ? 'active' : ''}} "
                         href="{{ url('sales/tarif_cabang_kargo')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Cabang Kargo</a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{  /* sepeda */
                    Request::is('sales/tarif_cabang_sepeda') ? 'active' : '' || 
                    Request::is('sales/tarif_cabang_sepeda/*') ? 'active' : ''}} "
                         href="{{ url('sales/tarif_cabang_sepeda')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Cabang Sepeda</a>
                        </li>
                        <br>
                        <li >
                            <a
                        class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_penerus_default') ? 'active' : '' ||
                         Request::is('sales/tarif_penerus_default/*') ? 'active' : ''}} 

                        " href="{{ url('sales/tarif_penerus_default')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Penerus Default</a>
                        </li>
                        <li >
                            <a
                        class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_penerus_dokumen') ? 'active' : '' ||
                         Request::is('sales/tarif_penerus_dokumen/*') ? 'active' : ''}} 

                        " href="{{ url('sales/tarif_penerus_dokumen')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Penerus Dokumen</a>
                        </li>
                        <li >
                            <a
                        class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_penerus_kilogram') ? 'active' : '' ||
                         Request::is('sales/tarif_penerus_kilogram/*') ? 'active' : ''}} 

                        " href="{{ url('sales/tarif_penerus_kilogram')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Penerus Kilogram</a>
                        </li>
                        <li >
                            <a
                        class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_penerus_koli') ? 'active' : '' ||
                         Request::is('sales/tarif_penerus_koli/*') ? 'active' : ''}} 

                        " href="{{ url('sales/tarif_penerus_koli')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Penerus Koli</a>
                        </li>

                        <li >
                            <a
                        class="sidebar master-perusahaan 

                        {{Request::is('sales/tarif_penerus_sepeda') ? 'active' : '' ||
                         Request::is('sales/tarif_penerus_sepeda/*') ? 'active' : ''}} 


                        " href="{{ url('sales/tarif_penerus_sepeda')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tarif Penerus sepeda</a>

                        </li>
                        
                    </ul>
                </li>

            <li class="
            
            {{

                /*===================== MASTER DO ======================*/
                    /* agen */
                    Request::is('master_sales/agen') ? 'active' : '' || 
                    Request::is('master_sales/agen/*') ? 'active' : '' ||
                    /* vendor */
                    Request::is('master_sales/vendor') ? 'active' : '' || 
                    Request::is('master_sales/vendor/*') ? 'active' : '' ||
                    /* rute */
                    Request::is('master_sales/rute') ? 'active' : '' || 
                    Request::is('master_sales/rute/*') ? 'active' : '' ||
                    /* satuan */
                    Request::is('master_sales/satuan') ? 'active' : '' || 
                    Request::is('master_sales/satuan/*') ? 'active' : '' ||
                     /* Zona */
                    Request::is('sales/zona') ? 'active' : '' || 
                    Request::is('sales/zona/*') ? 'active' : '' ||
                    /* Group item */
                    Request::is('master_sales/group_customer') ? 'active' : '' || 
                    Request::is('master_sales/group_customer/*') ? 'active' : '' ||
                    /* Group item */
                    Request::is('master_sales/grup_item') ? 'active' : '' || 
                    Request::is('master_sales/grup_item/*') ? 'active' : '' ||
                    /* item */
                    Request::is('master_sales/item') ? 'active' : '' || 
                    Request::is('master_sales/item/*') ? 'active' : '' ||
                    /* komisi */
                    Request::is('master_sales/komisi') ? 'active' : '' || 
                    Request::is('master_sales/komisi/*') ? 'active' : '' ||
                    /* customer */
                    Request::is('master_sales/customer') ? 'active' : '' || 
                    Request::is('master_sales/customer/*') ? 'active' : '' ||
                    /* subcon */
                    Request::is('master_sales/subcon') ? 'active' : '' || 
                    Request::is('master_sales/subcon/*') ? 'active' : '' ||
                    /* biaya */
                    Request::is('master_sales/biaya') ? 'active' : '' || 
                    Request::is('master_sales/biaya/*') ? 'active' : '' ||
                    /* saldo piutang */
                    Request::is('master_sales/saldopiutang') ? 'active' : '' || 
                    Request::is('master_sales/saldopiutang/*') ? 'active' : '' ||
                    /* saldo awal piutang akir */
                    Request::is('master_sales/saldoawalpiutanglain') ? 'active' : '' || 
                    Request::is('master_sales/saldoawalpiutanglain/*') ? 'active' : '' ||
                    /* master diskon penjualan */
                    Request::is('master_sales/diskonpenjualan') ? 'active' : '' || 
                    /* Nomor seri pajak */
                    Request::is('master_sales/nomorseripajak') ? 'active' : '' || 
                    Request::is('master_sales/nomorseripajak/*') ? 'active' : '' 
                 /*=================  END OF MASTER DO ==================*/ 
             /*=================  END OF MASTER DO ==================*/

            }}" style="padding-left: 10%;">
                       <a href="#" {{-- style="padding-left: 30%;" --}} style="font-size: 13px;">Master DO<span class="fa arrow"></span></a>
                       <ul class="nav nav-third-level">
                       <li >
                        <a class="sidebar master-perusahaan 

                       {{Request::is('master_sales/agen') ? 'active' : '' || 
                       Request::is('master_sales/agen/*') ? 'active' : ''}} 

                       " href="{{ url('master_sales/agen')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Agen</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/vendor') ? 'active' : '' || 
                    Request::is('master_sales/vendor/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/vendor')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Vendor</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/rute') ? 'active' : '' || 
                    Request::is('master_sales/rute/*') ? 'active' : ''}}

                     " href="{{ url('master_sales/rute')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Rute</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/satuan') ? 'active' : '' || 
                    Request::is('master_sales/satuan/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/satuan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Satuan</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('sales/zona') ? 'active' : '' || 
                    Request::is('sales/zona/*') ? 'active' : ''}} 

                    " href="{{ url('sales/zona')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Zona</a>
                    </li>
                   
                      <li >
                        <a class="sidebar master-perusahaan 

                    {{  /* Group item */
                    Request::is('master_sales/group_customer') ? 'active' : '' || 
                    Request::is('master_sales/group_customer/*') ? 'active' : ''}}

                     " href="{{ url('master_sales/group_customer')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Group Customer</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/grup_item') ? 'active' : '' || 
                    Request::is('master_sales/grup_item/*') ? 'active' : ''}}

                     " href="{{ url('master_sales/grup_item')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Group Item</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/item') ? 'active' : '' || 
                    Request::is('master_sales/item/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/item')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Item</a>
                    </li>

                    <li >
                    <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/komisi') ? 'active' : '' || 
                    Request::is('master_sales/komisi/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/komisi')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Diskon</a>
                    </li>

                    <li >
                        <a class="sidebar master-perusahaan {{Request::is('master_sales/diskonpenjualan') ? 'active' : '' || Request::is('master_sales/diskonpenjualan/*') ? 'active' : ''}}" href="{{ url('master_sales/diskonpenjualan')}}">
                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>Diskon Penjualan</a>
                    </li>

                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/customer') ? 'active' : '' || 
                    Request::is('master_sales/customer/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/customer')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Customer</a>
                    </li>
                    <li>
                        <a  class="sidebar master-perusahaan 

                    {{Request::is('master_sales/subcon') ? 'active' : '' || 
                    Request::is('master_sales/subcon/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/subcon')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Subcon</a>
                        </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/biaya') ? 'active' : '' || 
                    Request::is('master_sales/biaya/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/biaya')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Biaya</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/saldopiutang') ? 'active' : '' || 
                    Request::is('master_sales/saldopiutang/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/saldopiutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Saldo Piutang</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/saldoawalpiutanglain') ? 'active' : '' || 
                    Request::is('master_sales/saldoawalpiutanglain/*') ? 'active' : ''}} 

                    " href="{{ url('master_sales/saldoawalpiutanglain')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Saldo Awal Piutang Lain</a>
                    </li>
                    <li >
                        <a class="sidebar master-perusahaan 

                    {{Request::is('master_sales/nomorseripajak') ? 'active' : '' || 
                    Request::is('master_sales/nomorseripajak/*') ? 'active' : ''}}

                    " href="{{ url('master_sales/nomorseripajak')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Nomor Seri Pajak</a>
                    </li>
                       </ul>
                   </li>

            </ul>
        </li>
                  
                         <li class="treeview sidebar data-master 

                         {{

                            /*=============== sub  MASTER PEMBELIAN ==============*/
                            /* Master Group item  */
                            Request::is('masterjenisitem/masterjenisitem') ? 'active' : '' || 
                            Request::is('masterjenisitem/masterjenisitem/*') ? 'active' : '' ||
                            /* Master item purchase */
                            Request::is('masteritem/masteritem') ? 'active' : '' || 
                            Request::is('masteritem/masteritem/*') ? 'active' : '' ||
                            /* Master Supplier */
                            Request::is('mastersupplier/mastersupplier') ? 'active' : '' || 
                            Request::is('mastersupplier/mastersupplier/*') ? 'active' : '' ||
                            /* Konfirmasi Supplier */
                            Request::is('konfirmasisupplier/konfirmasisupplier') ? 'active' : '' || 
                            Request::is('konfirmasisupplier/konfirmasisupplier/*') ? 'active' : '' ||
                            /* Master Gudang */
                            Request::is('mastergudang/mastergudang') ? 'active' : '' || 
                            Request::is('mastergudang/mastergudang/*') ? 'active' : '' ||
                            /* Master Departement */
                            Request::is('masterdepartment/masterdepartment') ? 'active' : '' || 
                            Request::is('masterdepartment/masterdepartment/*') ? 'active' : '' ||
                            /*================ END OF sub MASTER PEMBELIAN =======*/  
                             /*================ sub MASTER BIAYA PENERUS ======*/  
                            /* Master Gudang */
                            Request::is('presentase/index') ? 'active' : '' || 
                            Request::is('presentase/index/*') ? 'active' : '' ||
                            /* Master Departement */
                            Request::is('bbm/index') ? 'active' : '' || 
                            Request::is('bbm/index/*') ? 'active' : '' ||
                            /*========== END OF MASTER BIAYA PENERUS =========*/ 
                            /*================= sub MASTER KONTRAK ================= */
                            /* Kontrak */
                            Request::is('master_sales/kontrak') ? 'active' : '' || 
                            Request::is('master_sales/kontrak/*') ? 'active' : '' ||
                            /* subcon */
                            Request::is('master_subcon/subcon') ? 'active' : '' || 
                            Request::is('master_subcon/subcon/*') ? 'active' : '' 
                            /*=============== End of sub MASTER KONTRAK ============ */

                         }}

                         ">
                         <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Master Pembelian <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level" style="font-size:90%">
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('masterjenisitem/masterjenisitem') ? 'active' : '' || 
                        Request::is('masterjenisitem/masterjenisitem/*') ? 'active' : ''}}

                        " href="{{ url('masterjenisitem/masterjenisitem')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Group Item </a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('masteritem/masteritem') ? 'active' : '' || 
                            Request::is('masteritem/masteritem/*') ? 'active' : ''}} 

                        " href="{{ url('masteritem/masteritem')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Item Purchase </a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('mastersupplier/mastersupplier') ? 'active' : '' || 
                            Request::is('mastersupplier/mastersupplier/*') ? 'active' : ''}}

                        " href="{{ url('mastersupplier/mastersupplier')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Supplier </a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('konfirmasisupplier/konfirmasisupplier') ? 'active' : '' || 
                            Request::is('konfirmasisupplier/konfirmasisupplier/*') ? 'active' : ''}}

                        " href="{{ url('konfirmasisupplier/konfirmasisupplier')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Konfirmasi Supplier </a>
                        </li>

                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('mastergudang/mastergudang') ? 'active' : '' || 
                            Request::is('mastergudang/mastergudang/*') ? 'active' : ''}}

                        " href="{{ url('mastergudang/mastergudang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Gudang </a>
                        </li>

                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('masterdepartment/masterdepartment') ? 'active' : '' || 
                            Request::is('masterdepartment/masterdepartment/*') ? 'active' : ''}}

                        " href="{{ url('masterdepartment/masterdepartment')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Department </a>
                        </li>
                        <li class="

                        {{

                             /*================ sub MASTER BIAYA PENERUS ======*/  
                            /* Master Gudang */
                            Request::is('presentase/index') ? 'active' : '' || 
                            Request::is('presentase/index/*') ? 'active' : '' ||
                            /* Master Departement */
                            Request::is('bbm/index') ? 'active' : '' || 
                            Request::is('bbm/index/*') ? 'active' : '' 
                            /*========== END OF MASTER BIAYA PENERUS =========*/ 

                        }}

                        " >
                           <a href="#" style="padding-left: 20%;">Master Biaya Penerus<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                        @if(Auth::user()->PunyaAkses('Master Persen','aktif'))
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('presentase/index') ? 'active' : '' || 
                            Request::is('presentase/index/*') ? 'active' : ''}}

                        " href="{{ url('presentase/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Persen </a>
                        </li>
                        @endif
                        @if(Auth::user()->PunyaAkses('Master BBM','aktif'))
                         <li >
                            <a class="sidebar master-perusahaan 

                         {{Request::is('bbm/index') ? 'active' : '' || 
                            Request::is('bbm/index/*') ? 'active' : ''}}

                         " href="{{ url('bbm/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master BBM </a>
                        </li>
                        @endif
                           </ul>
                       </li>
                       <li class="
               
               {{

                 /*================= sub MASTER KONTRAK ================= */
                    /* Kontrak */
                    Request::is('master_sales/kontrak') ? 'active' : '' || 
                    Request::is('master_sales/kontrak/*') ? 'active' : '' ||
                    /* subcon */
                    Request::is('master_subcon/subcon') ? 'active' : '' || 
                    Request::is('master_subcon/subcon/*') ? 'active' : '' 
                 /*=============== End of sub MASTER KONTRAK ============ */

               }}

               " >
                   <a href="#" {{-- style="padding-left: 30%;" --}} style="font-size: 13px;">Master Kontrak<span class="fa arrow"></span></a>
                   <ul class="nav nav-third-level">
                @if(Auth::user()->PunyaAkses('Master Kontrak','aktif'))
                   <li >
                    <a class="sidebar master-perusahaan 

                   {{Request::is('master_sales/kontrak') ? 'active' : '' || 
                    Request::is('master_sales/kontrak/*') ? 'active' : ''}} 

                   " href="{{ url('master_sales/kontrak')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Kontrak Customer</a>
                   </li>
                @endif
             @if(Auth::user()->PunyaAkses('Master subcon','aktif'))
                <li >
                    <a class="sidebar master-perusahaan 

                    {{Request::is('master_subcon/subcon') ? 'active' : '' || 
                    Request::is('master_subcon/subcon/*') ? 'active' : ''}} 

                " href="{{ url('master_subcon/subcon')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Kontrak SUBCON</a>
                </li>
                @endif
                   </ul>
               </li>
                        </ul>
                        </li>
                
                        <li class="treeview sidebar data-master 

                        {{

                            /*======= MASTER KEUANGAN ============================*/
                            /* saldo_akun */
                            Request::is('master_keuangan/saldo_akun') ? 'active' : '' || 
                            Request::is('master_keuangan/saldo_akun/*') ? 'active' : '' ||
                            /* masterbank */
                            Request::is('masterbank/masterbank') ? 'active' : '' || 
                            Request::is('masterbank/masterbank/*') ? 'active' : '' ||
                            /* masteractiva */
                            Request::is('masteractiva/masteractiva') ? 'active' : '' || 
                            Request::is('masteractiva/masteractiva/*') ? 'active' : '' ||
                            /* golonganactiva */
                            Request::is('golonganactiva/golonganactiva') ? 'active' : '' || 
                            Request::is('golonganactiva/golonganactiva/*') ? 'active' : '' ||
                            /* notadebit */
                            Request::is('notadebit/notadebit') ? 'active' : '' || 
                            Request::is('notadebit/notadebit/*') ? 'active' : '' ||
                            /* kelompok_akun */
                            Request::is('master_keuangan/kelompok_akun') ? 'active' : '' || 
                            Request::is('master_keuangan/kelompok_akun/*') ? 'active' : '' ||
                            /* Transaksi */
                            Request::is('master-transaksi/index') ? 'active' : '' || 
                            Request::is('master-transaksi/index/*') ? 'active' : '' ||
                            /* akun */
                            Request::is('master_keuangan/akun') ? 'active' : '' || 
                            Request::is('master_keuangan/akun/*') ? 'active' : ''
                            /*================= END OF MASTER KEUANGAN ===========*/

                        }}

                        ">
                       <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Master Keuangan <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level" style="font-size:90%">
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{ Request::is('master_keuangan/saldo_akun') ? 'active' : '' || 
                            Request::is('master_keuangan/saldo_akun/*') ? 'active' : ''}} 

                        " href="{{ url('master_keuangan/saldo_akun')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Saldo Akun</a>
                        </li>

                        <li >
                            <a class="sidebar master-perusahaan 

                        {{ Request::is('master_keuangan/saldo_piutang') ? 'active' : '' || 
                            Request::is('master_keuangan/saldo_piutang/*') ? 'active' : ''}} 

                        " href="{{ url('master_keuangan/saldo_piutang/null')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Saldo Piutang</a>
                        </li>
                         
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('masterbank/masterbank') ? 'active' : '' || 
                            Request::is('masterbank/masterbank/*') ? 'active' : ''}} 

                        " href="{{ url('masterbank/masterbank')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Bank </a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('masteractiva/masteractiva') ? 'active' : '' || 
                            Request::is('masteractiva/masteractiva/*') ? 'active' : ''}}

                        " href="{{ url('masteractiva/masteractiva')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Master Activa </a>
                        </li>
                         <li >
                            <a class="sidebar master-perusahaan 

                         {{Request::is('golonganactiva/golonganactiva') ? 'active' : '' || 
                            Request::is('golonganactiva/golonganactiva/*') ? 'active' : ''}}

                         " href="{{ url('golonganactiva/golonganactiva')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Golongan Activa </a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('notadebit/notadebit') ? 'active' : '' || 
                            Request::is('notadebit/notadebit/*') ? 'active' : ''}}

                        " href="{{ url('notadebit/notadebit')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Nota Debit / Kredit Aktiva </a>
                        </li>
                        <li>
                            <a  class="sidebar master-perusahaan 

                        {{Request::is('master_keuangan/kelompok_akun') ? 'active' : '' || 
                            Request::is('master_keuangan/kelompok_akun/*') ? 'active' : ''}}

                         " href="{{ url('master_keuangan/kelompok_akun')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Kelompok Akun</a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('master-transaksi/index') ? 'active' : '' || 
                            Request::is('master-transaksi/index/*') ? 'active' : ''}} 

                        " href="{{ url('master-transaksi/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Transaksi</a>
                        </li>
                        <li >
                            <a class="sidebar master-perusahaan 

                        {{Request::is('master_keuangan/akun') ? 'active' : '' || 
                            Request::is('master_keuangan/akun/*') ? 'active' : ''}} 

                        " href="{{ url('master_keuangan/akun')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Akun</a>
                        </li>
                        </ul>
                        </li>
                       
                    </ul>
                </li>
                <!-- end master -->

                <!-- Master -->
                <li class="treeview sidebar data-master 

                {{

            /*===================== MASTER PENJUALAN OPERASIONAL ======================*/
                    /* Sales order */
                    Request::is('sales/salesorder') ? 'active' : '' || 
                    Request::is('sales/salesorder/*') ? 'active' : '' ||
                    /* delivery order */
                    Request::is('sales/deliveryorder') ? 'active' : '' || 
                    Request::is('sales/deliveryorder/*') ? 'active' : '' ||
                    /* Delivery order kargo */
                    Request::is('sales/deliveryorderkargo') ? 'active' : '' || 
                    Request::is('sales/deliveryorderkargo/*') ? 'active' : '' ||
                    /* Delivery order Kertas */
                    Request::is('sales/deliveryorderkertas') ? 'active' : '' || 
                    Request::is('sales/deliveryorderkertas/*') ? 'active' : '' ||
                    /* Update Status order */
                    Request::is('sales/deliveryorderform') ? 'active' : '' || 
                    /* DO */
                    Request::is('updatestatus') ? 'active' : '' || 
                    Request::is('updatestatus/*') ? 'active' : '' ||
                    /* Update Status order kargo*/
                    Request::is('updatestatus_kargo') ? 'active' : '' || 
                    Request::is('updatestatus_kargo/*') ? 'active' : '' ||
                    /* Tracking DO */
                    Request::is('sales/deliveryordercabangtracking') ? 'active' : '' || 
                    Request::is('sales/deliveryordercabangtracking/*') ? 'active' : '' ||
                    /* Surat jalan By Trayek */
                    Request::is('sales/surat_jalan_trayek') ? 'active' : '' || 
                    Request::is('sales/surat_jalan_trayek/*') ? 'active' : '' ||
                    /* Invoice */
                    Request::is('sales/invoice') ? 'active' : '' || 
                    Request::is('sales/invoice/*') ? 'active' : '' ||
                    /* invoice lain lain */
                    Request::is('sales/invoice_lain') ? 'active' : '' || 
                    Request::is('sales/invoice_lain/*') ? 'active' : '' ||
                    /* Penerimaan penjualan */
                    Request::is('sales/penerimaan_penjualan') ? 'active' : '' || 
                    Request::is('sales/penerimaan_penjualan/*') ? 'active' : '' ||
                    /* posting Pembayaran */
                    Request::is('sales/posting_pembayaran') ? 'active' : '' || 
                    Request::is('sales/posting_pembayarang/*') ? 'active' : ''||
            /*=================  END OF MASTER PENJUALAN OPERASIONAL ==================*/
            /*================= PEMBELIAN OPERASIONAL =================================*/

                /*============ sub MANAGEMEN PEMBELIAN ======================*/
                    /* surat permintaan pembelian */
                    Request::is('suratpermintaanpembelian') ? 'active' : '' || 
                    Request::is('suratpermintaanpembelian/*') ? 'active' : '' ||
                    /* konfirmasi_order */
                    Request::is('konfirmasi_order/konfirmasi_order') ? 'active' : '' || 
                    Request::is('konfirmasi_order/konfirmasi_order/*') ? 'active' : '' ||
                    /* Purchase order */
                    Request::is('purchaseorder/purchaseorder') ? 'active' : '' || 
                    Request::is('purchaseorder/purchaseorder/*') ? 'active' : '' ||
                    /* uang muka pembelian */
                    Request::is('uangmukapembelian/uangmukapembelian') ? 'active' : '' || 
                    Request::is('uangmukapembelian/uangmukapembelian/*') ? 'active' : '' ||
                    /* Return pembelian */
                    Request::is('returnpembelian/returnpembelian') ? 'active' : '' || 
                    Request::is('returnpembelian/returnpembelian/*') ? 'active' : '' ||
                /*=========== END OF sub MANAGEMEN GUDANG ================*/

                /*============ sub MANAGEMEN GUDANG ======================*/
                    /* penerimaan barang */
                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' ||
                    /* Pengeluaran barang */
                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' ||
                    /* konfirmasipengeluaranbarang */
                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang') ? 'active' : '' || 
                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang/*') ? 'active' : '' ||
                    /* stock gudang */
                    Request::is('stockgudang/stockgudang') ? 'active' : '' || 
                    Request::is('stockgudang/stockgudang/*') ? 'active' : '' ||
                    /* mutasi stock */
                    Request::is('mutasi_stock/mutasi_stock') ? 'active' : '' || 
                    Request::is('mutasi_stock/mutasi_stock/*') ? 'active' : ''||
                    /* stock opname */
                    Request::is('stockopname/stockopname') ? 'active' : '' || 
                    Request::is('stockopname/stockopname/*') ? 'active' : ''||
                /*=========== END OF sub MANAGEMEN PEMBELIAN ================*/

                /*============ sub TRANSAKSI HUTANG ======================*/
                    /* fakturpembelian */
                    Request::is('fakturpembelian/fakturpembelian') ? 'active' : '' || 
                    Request::is('fakturpembelian/fakturpembelian/*') ? 'active' : '' ||
                    /* uangmuka */
                    Request::is('uangmuka') ? 'active' : '' || 
                    Request::is('uangmuka/*') ? 'active' : '' ||
                    /* voucherhutang */
                    Request::is('voucherhutang/voucherhutang') ? 'active' : '' || 
                    Request::is('voucherhutang/voucherhutang/*') ? 'active' : '' ||
                    /* pending */
                    Request::is('pending/index') ? 'active' : '' || 
                    Request::is('pending/index/*') ? 'active' : '' ||
                    /* CD/DN pembelian */
                    Request::is('cndnpembelian/cndnpembelian') ? 'active' : '' || 
                    Request::is('cndnpembelian/cndnpembelian/*') ? 'active' : '' ||
                    /* Pelunasan hutang & Pembayaran kas */
                    Request::is('pelunasanhutang/pelunasanhutang') ? 'active' : '' || 
                    Request::is('pelunasanhutang/pelunasanhutang/*') ? 'active' : '' ||
                    /* Pelunasan hutang & Pembayaran BANK */
                    Request::is('pelunasanhutangbayarbank/pelunasanhutangbayarbank') ? 'active' : '' || 
                    Request::is('pelunasanhutangbayarbank/pelunasanhutangbayarbank/*') ? 'active' : '' ||
                    /* bank kas dll */
                    Request::is('bankkaslain/bankkaslain') ? 'active' : '' || 
                    Request::is('bankkaslain/bankkaslain/*') ? 'active' : '' ||
                    /* TTT */
                    Request::is('formtandaterimatagihan/formtandaterimatagihan') ? 'active' : '' || 
                    Request::is('formtandaterimatagihan/formtandaterimatagihan/*') ? 'active' : '' ||
                    /* AJU */
                    Request::is('formaju/formaju') ? 'active' : '' || 
                    Request::is('formaju/formaju/*') ? 'active' : '' ||
                    /* FPG */
                    Request::is('formfpg/formfpg') ? 'active' : '' || 
                    Request::is('formfpg/formfpg/*') ? 'active' : '' ||
                    /* pelaporan faktur pajak masukan */
                    Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan') ? 'active' : '' || 
                    Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan/*') ? 'active' : ''||
                    /* Memorial purchase */
                    Request::is('memorialpurchase/memorialpurchase') ? 'active' : '' || 
                    Request::is('memorialpurchase/memorialpurchase/*') ? 'active' : ''||
                /*=========== END OF sub TRANSAKSI HUTANG ================*/

                /*============ sub TRANSAKSI KAS ======================*/
                     /* biaya_penerus_kas */
                    Request::is('biaya_penerus/index') ? 'active' : '' || 
                    Request::is('biaya_penerus/index/*') ? 'active' : '' ||
                    /* Peding kas */
                    Request::is('pending_kas/index') ? 'active' : '' || 
                    Request::is('pending_kas/index/*') ? 'active' : '' ||
                    /* BKK */
                    Request::is('buktikaskeluar/index') ? 'active' : '' || 
                    Request::is('buktikaskeluar/index/*') ? 'active' : ''||
                    /* Iktisar kas */
                    Request::is('ikhtisar_kas/index') ? 'active' : '' || 
                    Request::is('ikhtisar_kas/index/*') ? 'active' : '' ||
                /*=========== END OF sub TRANSAKSI KAS ================*/

             /*================= END PEMBELIAN OPERASIONAL ==============================*/
             
             /*==================== MASTER KEUANGAN OPERASIONAL =========================*/
                    /* penerimaan */
                    Request::is('keuangan/penerimaan') ? 'active' : '' || 
                    Request::is('keuangan/penerimaan/*') ? 'active' : '' ||
                    /* Pengeluaran */
                    Request::is('keuangan/pengeluaran') ? 'active' : '' || 
                    Request::is('keuangan/pengeluaran/*') ? 'active' : ''||
                    /* jurnal_umum */
                    Request::is('keuangan/jurnal_umum') ? 'active' : '' || 
                    Request::is('keuangan/jurnal_umum/*') ? 'active' : ''
             /*======== END OF MASTER KEUANGAN OPERASIONAL ==============================*/


                          

                        }}
                        ">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Operasional</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <!-- Operasional Penjualan -->
                        <li class="

                        {{

                            /*===================== MASTER PENJUALAN OPERASIONAL ======================*/
                            /* Sales order */
                            Request::is('sales/salesorder') ? 'active' : '' || 
                            Request::is('sales/salesorder/*') ? 'active' : '' ||
                            /* delivery order */
                            Request::is('sales/deliveryorder') ? 'active' : '' || 
                            Request::is('sales/deliveryorder/*') ? 'active' : '' ||
                            /* Update Status order */
                            Request::is('sales/deliveryorderform') ? 'active' : '' || 
                            /* Delivery order kargo */
                            Request::is('sales/deliveryorderkargo') ? 'active' : '' || 
                            Request::is('sales/deliveryorderkargo/*') ? 'active' : '' ||
                            /* Delivery order Kertas */
                            Request::is('sales/deliveryorderkertas') ? 'active' : '' || 
                            Request::is('sales/deliveryorderkertas/*') ? 'active' : '' ||
                            /* Update Status order */
                            Request::is('updatestatus') ? 'active' : '' || 
                            Request::is('updatestatus/*') ? 'active' : '' ||
                            /* Tracking DO *//* Update Status order kargo*/
                            Request::is('updatestatus_kargo') ? 'active' : '' || 
                            Request::is('updatestatus_kargo/*') ? 'active' : '' ||
                            Request::is('sales/deliveryordercabangtracking') ? 'active' : '' || 
                            Request::is('sales/deliveryordercabangtracking/*') ? 'active' : '' ||
                            /* Surat jalan By Trayek */
                            Request::is('sales/surat_jalan_trayek') ? 'active' : '' || 
                            Request::is('sales/surat_jalan_trayek/*') ? 'active' : '' ||
                            /* Invoice */
                            Request::is('sales/invoice') ? 'active' : '' || 
                            Request::is('sales/invoice/*') ? 'active' : '' ||
                            /* invoice lain lain */
                            Request::is('sales/invoice_lain') ? 'active' : '' || 
                            Request::is('sales/invoice_lain/*') ? 'active' : '' ||
                            /* Penerimaan penjualan */
                            Request::is('sales/penerimaan_penjualan') ? 'active' : '' || 
                            Request::is('sales/penerimaan_penjualan/*') ? 'active' : '' ||
                            /* posting Pembayaran */
                            Request::is('sales/posting_pembayaran') ? 'active' : '' || 
                            Request::is('sales/posting_pembayarang/*') ? 'active' : ''
                             /*=================  END OF MASTER PENJUALAN OPERASIONAL ==================*/

                        }}

                        ">
                            <a href="#" st><i class="fa fa-folder-o" aria-hidden="true"></i> Penjualan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" style="font-size:100%;">
                                          <li class="

                                    {{

                        
                    Request::is('sales/deliveryorder') ? 'active' : '' || 
                            Request::is('sales/deliveryorder/*') ? 'active' : '' ||
                    Request::is('sales/deliveryorderkargo') ? 'active' : '' || 
                            Request::is('sales/deliveryorderkargo/*') ? 'active' : '' ||
                    Request::is('sales/deliveryorderkertas') ? 'active' : '' || 
                            Request::is('sales/deliveryorderkertas/*') ? 'active' : '' ||
                    Request::is('sales/salesorder') ? 'active' : '' || 
                            Request::is('sales/salesorder/*') ? 'active' : '' ||
                    Request::is('sales/invoice') ? 'active' : '' || 
                            Request::is('sales/invoice/*') ? 'active' : '' ||
                    Request::is('sales/invoice_lain') ? 'active' : '' || 
                            Request::is('sales/invoice_lain/*') ? 'active' : '' ||
                    Request::is('sales/penerimaan_penjualan') ? 'active' : '' || 
                    Request::is('sales/deliveryorderform') ? 'active' : '' || 
                            Request::is('sales/penerimaan_penjualan/*') ? 'active' : ''

                /*=========== END OF sub MANAGEMEN GUDANG ================*/

                                    }}

                                  " style="border-left:none;">
                                    <a  href="#" style="font-size: 96%" > Transaksi Penjualan <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%;">
                                <li>
                                       <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/deliveryorder') ? 'active' : '' || 
                            Request::is('sales/deliveryorderform') ? 'active' : '' || 
                            Request::is('sales/deliveryorder/*') ? 'active' : ''}} 

                            " href="{{ url('sales/deliveryorder')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Delivery Order (DO)</a>
                            </li>

                            @if(Auth::user()->PunyaAkses('Delivery Order','aktif'))
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/deliveryorderkargo') ? 'active' : '' || 
                            Request::is('sales/deliveryorderkargo/*') ? 'active' : ''}} 

                            " href="{{ url('sales/deliveryorderkargo')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Delivery Order (DO) Kargo</a>
                            </li>

                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/deliveryorderkertas') ? 'active' : '' || 
                            Request::is('sales/deliveryorderkertas/*') ? 'active' : ''}}

                            " href="{{ url('sales/deliveryorderkertas')}}"><i class="fa fa-building" aria-hidden="true"></i>Delivery Order (DO) Koran</a>
                            </li>
                            @endif
                          {{--    <li >
                                <a class="sidebar master-perusahaan 

                                {{Request::is('sales/salesorder') ? 'active' : '' || 
                            Request::is('sales/salesorder/*') ? 'active' : ''}} 

                                " href="{{ url('sales/salesorder')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Sales Order (SO)</a>
                            </li>
                          --}}
                            <!--
                            <li class="sidebar master-perusahaan {{Request::is('sales/deliveryorder') ? 'active' : ''}} ">
                                <a href="{{ url('sales/deliveryorder')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Delivery Order (DO)</a>
                            </li>
                            -->
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/invoice') ? 'active' : '' || 
                            Request::is('sales/invoice/*') ? 'active' : ''}} 

                            " href="{{ url('sales/invoice')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Invoice </a>
                            </li>
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/invoice_pembetulan') ? 'active' : '' || 
                            Request::is('sales/invoice_pembetulan/*') ? 'active' : ''}} 

                            " href="{{ url('sales/invoice_pembetulan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Invoice Pembetulan</a>
                            </li>
                            <!--
                            <li class="sidebar master-perusahaan {{Request::is('sales/fakturpajak') ? 'active' : ''}} ">
                                <a href="{{ url('sales/fakturpajak')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Faktur Pajak</a>
                            </li>
                            -->
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/invoice_lain') ? 'active' : '' || 
                            Request::is('sales/invoice_lain/*') ? 'active' : ''}} 

                            " href="{{ url('sales/invoice_lain')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Invoice Lain Lain</a>
                            </li>
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/penerimaan_penjualan') ? 'active' : '' || 
                            Request::is('sales/penerimaan_penjualan/*') ? 'active' : ''}} 

                            " href="{{ url('sales/penerimaan_penjualan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Kwitansi</a>
                            </li>
                            
                               
                            </ul>
                        </li>

                        {{-- transaksi paket --}}

                                   <li class="

                                    {{

                            Request::is('updatestatus') ? 'active' : '' || 
                                Request::is('updatestatus/*') ? 'active' : ''||
                            Request::is('updatestatus_kargo') ? 'active' : '' || 
                                Request::is('updatestatus_kargo/*') ? 'active' : ''||
                            Request::is('sales/deliveryordercabangtracking') ? 'active' : '' || 
                                Request::is('sales/deliveryordercabangtracking/*') ? 'active' : ''||
                            Request::is('sales/surat_jalan_trayek') ? 'active' : '' || 
                                Request::is('sales/surat_jalan_trayek/*') ? 'active' : ''
                /*=========== END OF sub MANAGEMEN GUDANG ================*/

                                    }}

                                  " style="border-left:none;">
                                    <a  href="#" style="font-size: 96%" > Transaksi Status  <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%">
                                <li>

                            <li >
                            <a class="sidebar master-perusahaan 

                            {{Request::is('updatestatus') ? 'active' : '' || 
                            Request::is('updatestatus/*') ? 'active' : ''}} 

                            " href="{{ url('updatestatus')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Update Status Paket</a>
                            </li>
                              <li >
                            <a class="sidebar master-perusahaan 

                            {{ Request::is('updatestatus_kargo') ? 'active' : '' || 
                                Request::is('updatestatus_kargo/*') ? 'active' : ''}} 

                            " href="{{ url('updatestatus')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Update Status Kargo</a>
                            </li>
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/deliveryordercabangtracking') ? 'active' : '' || 
                            Request::is('sales/deliveryordercabangtracking/*') ? 'active' : ''}} 

                            " href="{{ url('sales/deliveryordercabangtracking')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tracking Delivery Order (DO)</a>
                            </li>
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/surat_jalan_trayek') ? 'active' : '' || 
                            Request::is('sales/surat_jalan_trayek/*') ? 'active' : ''}} 

                            " href="{{ url('sales/surat_jalan_trayek')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Surat Jalan By Trayek</a>
                            </li>

                                </li>
                            </ul>
                        </li>
                         <li class="

                                    {{

                            Request::is('sales/posting_pembayaran') ? 'active' : '' || 
                            Request::is('sales/posting_pembayarang/*') ? 'active' : ''
                /*=========== END OF sub MANAGEMEN GUDANG ================*/

                                    }}

                                  " style="border-left:none;">
                                    <a  href="#" style="font-size: 96%" > Penerimaan Kwitansi <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%">
                                <li>
                            <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/nota_debet_kredit') ? 'active' : '' || 
                            Request::is('sales/nota_debet_kredti/*') ? 'active' : ''}} 

                            " href="{{ url('sales/nota_debet_kredit')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> CN/DN</a>
                            </li>
                            <li >
                                <a class="sidebar master-perusahaan {{Request::is('sales/uang_muka_penjualan') ? 'active' : '' || 
                                Request::is('sales/index/*') ? 'uang_muka_penjualan' : ''}}" href="{{ url('sales/uang_muka_penjualan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Uang Muka Penjualan</a>
                                </li> 
                             <li >
                                <a class="sidebar master-perusahaan 

                            {{Request::is('sales/posting_pembayaran') ? 'active' : '' || 
                            Request::is('sales/posting_pembayarang/*') ? 'active' : ''}} 

                            " href="{{ url('sales/posting_pembayaran')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Posting Pembayaran</a>
                            </li>
                        
                            </ul>
                        </li>
                           
                            
                            </ul>
                        </li>
                        <!-- end operasional penjualan -->

                        <!-- operasional pembelian -->
                        <li class="

                            {{

                                     /*================= PEMBELIAN OPERASIONAL =================================*/

                /*============ sub MANAGEMEN PEMBELIAN ======================*/
                    /* surat permintaan pembelian */
                    Request::is('suratpermintaanpembelian') ? 'active' : '' || 
                    Request::is('suratpermintaanpembelian/*') ? 'active' : '' ||
                    /* konfirmasi_order */
                    Request::is('konfirmasi_order/konfirmasi_order') ? 'active' : '' || 
                    Request::is('konfirmasi_order/konfirmasi_order/*') ? 'active' : '' ||
                    /* Purchase order */
                    Request::is('purchaseorder/purchaseorder') ? 'active' : '' || 
                    Request::is('purchaseorder/purchaseorder/*') ? 'active' : '' ||
                    /* uang muka pembelian */
                    Request::is('uangmukapembelian/uangmukapembelian') ? 'active' : '' || 
                    Request::is('uangmukapembelian/uangmukapembelian/*') ? 'active' : '' ||
                    /* Return pembelian */
                    Request::is('returnpembelian/returnpembelian') ? 'active' : '' || 
                    Request::is('returnpembelian/returnpembelian/*') ? 'active' : '' ||
                /*=========== END OF sub MANAGEMEN GUDANG ================*/

                /*============ sub MANAGEMEN GUDANG ======================*/
                    /* penerimaan barang */
                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' ||
                    /* Pengeluaran barang */
                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' ||
                    /* konfirmasipengeluaranbarang */
                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang') ? 'active' : '' || 
                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang/*') ? 'active' : '' ||
                    /* stock gudang */
                    Request::is('stockgudang/stockgudang') ? 'active' : '' || 
                    Request::is('stockgudang/stockgudang/*') ? 'active' : '' ||
                    /* mutasi stock */
                    Request::is('mutasi_stock/mutasi_stock') ? 'active' : '' || 
                    Request::is('mutasi_stock/mutasi_stock/*') ? 'active' : ''||
                    /* stock opname */
                    Request::is('stockopname/stockopname') ? 'active' : '' || 
                    Request::is('stockopname/stockopname/*') ? 'active' : ''||
                /*=========== END OF sub MANAGEMEN PEMBELIAN ================*/

                /*============ sub TRANSAKSI HUTANG ======================*/
                    /* fakturpembelian */
                    Request::is('fakturpembelian/fakturpembelian') ? 'active' : '' || 
                    Request::is('fakturpembelian/fakturpembelian/*') ? 'active' : '' ||
                    /* uangmuka */
                    Request::is('uangmuka') ? 'active' : '' || 
                    Request::is('uangmuka/*') ? 'active' : '' ||
                    /* voucherhutang */
                    Request::is('voucherhutang/voucherhutang') ? 'active' : '' || 
                    Request::is('voucherhutang/voucherhutang/*') ? 'active' : '' ||
                    /* pending */
                    Request::is('pending/index') ? 'active' : '' || 
                    Request::is('pending/index/*') ? 'active' : '' ||
                    /* CD/DN pembelian */
                    Request::is('cndnpembelian/cndnpembelian') ? 'active' : '' || 
                    Request::is('cndnpembelian/cndnpembelian/*') ? 'active' : '' ||
                    /* Pelunasan hutang & Pembayaran kas */
                    Request::is('pelunasanhutang/pelunasanhutang') ? 'active' : '' || 
                    Request::is('pelunasanhutang/pelunasanhutang/*') ? 'active' : '' ||
                    /* Pelunasan hutang & Pembayaran BANK */
                    Request::is('pelunasanhutangbayarbank/pelunasanhutangbayarbank') ? 'active' : '' || 
                    Request::is('pelunasanhutangbayarbank/pelunasanhutangbayarbank/*') ? 'active' : '' ||
                    /* bank kas dll */
                    Request::is('bankkaslain/bankkaslain') ? 'active' : '' || 
                    Request::is('bankkaslain/bankkaslain/*') ? 'active' : '' ||
                    /* TTT */
                    Request::is('formtandaterimatagihan/formtandaterimatagihan') ? 'active' : '' || 
                    Request::is('formtandaterimatagihan/formtandaterimatagihan/*') ? 'active' : '' ||
                    /* AJU */
                    Request::is('formaju/formaju') ? 'active' : '' || 
                    Request::is('formaju/formaju/*') ? 'active' : '' ||
                    /* FPG */
                    Request::is('formfpg/formfpg') ? 'active' : '' || 
                    Request::is('formfpg/formfpg/*') ? 'active' : '' ||
                    /* pelaporan faktur pajak masukan */
                    Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan') ? 'active' : '' || 
                    Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan/*') ? 'active' : ''||
                    /* Memorial purchase */
                    Request::is('memorialpurchase/memorialpurchase') ? 'active' : '' || 
                    Request::is('memorialpurchase/memorialpurchase/*') ? 'active' : ''||
                /*=========== END OF sub TRANSAKSI HUTANG ================*/

                /*============ sub TRANSAKSI KAS ======================*/
                     /* biaya_penerus_kas */
                    Request::is('biaya_penerus/index') ? 'active' : '' || 
                    Request::is('biaya_penerus/index/*') ? 'active' : '' ||
                    /* Peding kas */
                    Request::is('pending_kas/index') ? 'active' : '' || 
                    Request::is('pending_kas/index/*') ? 'active' : '' ||
                    /* BKK */
                    Request::is('buktikaskeluar/index') ? 'active' : '' || 
                    Request::is('buktikaskeluar/index/*') ? 'active' : ''||
                    /* Iktisar kas */
                    Request::is('ikhtisar_kas/index') ? 'active' : '' || 
                    Request::is('ikhtisar_kas/index/*') ? 'active' : ''
                /*=========== END OF sub TRANSAKSI KAS ================*/

             /*================= END PEMBELIAN OPERASIONAL ==============================*/

                            }}


                        ">
                            <a href="#" ><i class="fa fa-folder-o" aria-hidden="true"></i> Pembelian <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                  <li class="

                                    {{

                                             /* surat permintaan pembelian */
                    Request::is('suratpermintaanpembelian') ? 'active' : '' || 
                    Request::is('suratpermintaanpembelian/*') ? 'active' : '' ||
                    /* konfirmasi_order */
                    Request::is('konfirmasi_order/konfirmasi_order') ? 'active' : '' || 
                    Request::is('konfirmasi_order/konfirmasi_order/*') ? 'active' : '' ||
                    /* Purchase order */
                    Request::is('purchaseorder/purchaseorder') ? 'active' : '' || 
                    Request::is('purchaseorder/purchaseorder/*') ? 'active' : '' ||
                    /* uang muka pembelian */
                    Request::is('uangmukapembelian/uangmukapembelian') ? 'active' : '' || 
                    Request::is('uangmukapembelian/uangmukapembelian/*') ? 'active' : '' ||
                    /* Return pembelian */
                    Request::is('returnpembelian/returnpembelian') ? 'active' : '' || 
                    Request::is('returnpembelian/returnpembelian/*') ? 'active' : ''
                /*=========== END OF sub MANAGEMEN GUDANG ================*/

                                    }}

                                  " style="border-left:none;">
                                    <a  href="#" style="font-size: 85%" > Manajemen Pembelian <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%">
                                <li>
                                <a class="sidebar master-perusahaan {{Request::is('suratpermintaanpembelian') ? 'active' : '' || 
                                    Request::is('suratpermintaanpembelian/*') ? 'active' : ''}}" href="{{ url('suratpermintaanpembelian')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Surat Permintaan Pembeliaan</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('konfirmasi_order/konfirmasi_order') ? 'active' : '' || 
                                    Request::is('konfirmasi_order/konfirmasi_order/*') ? 'active' : ''}}" href="{{ url('konfirmasi_order/konfirmasi_order')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Konfirmasi Order </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('purchaseorder/purchaseorder') ? 'active' : '' || 
                                    Request::is('purchaseorder/purchaseorder/*') ? 'active' : ''}}" href="{{ url('purchaseorder/purchaseorder')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Purchase Order </a>
                                </li>
                          
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('returnpembelian/returnpembelian') ? 'active' : '' || 
                                    Request::is('returnpembelian/returnpembelian/*') ? 'active' : ''}}" href="{{ url('returnpembelian/returnpembelian')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Return Pembelian </a>
                                </li>
                            </ul>
                        </li>
                                  <li   class="as {{

                                    /*============ sub MANAGEMEN GUDANG ======================*/
                                    /* penerimaan barang */
                                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' ||
                                    /* Pengeluaran barang */
                                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' ||
                                    /* konfirmasipengeluaranbarang */
                                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang') ? 'active' : '' || 
                                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang/*') ? 'active' : '' ||
                                    /* stock gudang */
                                    Request::is('stockgudang/stockgudang') ? 'active' : '' || 
                                    Request::is('stockgudang/stockgudang/*') ? 'active' : '' ||
                                    /* mutasi stock */
                                    Request::is('mutasi_stock/mutasi_stock') ? 'active' : '' || 
                                    Request::is('mutasi_stock/mutasi_stock/*') ? 'active' : ''||
                                    /* stock opname */
                                    Request::is('stockopname/stockopname') ? 'active' : '' || 
                                    Request::is('stockopname/stockopname/*') ? 'active' : ''
                                /*=========== END OF sub MANAGEMEN PEMBELIAN ================*/

                                  }}" style="border-left:none;">
                                    <a class="

    
                                  " href="#" style="font-size: 85%"> Manajemen Gudang <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%">
                                <li >
                                    <a class="sidebar master-perusahaan {{ Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                                    Request::is('penerimaanbarang/penerimaanbarang') ? 'active' : ''}}" href="{{ url('penerimaanbarang/penerimaanbarang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Penerimaan Barang </a>
                                </li>
                                @if(Auth::user()->PunyaAkses('Pengeluaran Barang','aktif'))
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                                    Request::is('pengeluaranbarang/pengeluaranbarang') ? 'active' : ''}}" href="{{ url('pengeluaranbarang/pengeluaranbarang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pengeluaran Barang </a>
                                </li>
                                @endif
                                @if(Auth::user()->PunyaAkses('Konfirmasi Pengeluaran','aktif'))
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang') ? 'active' : '' || 
                                    Request::is('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang/*') ? 'active' : ''}}" href="{{ url('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Konfirmasi Pengeluaran Barang </a>
                                </li>
                                @endif
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('stockgudang/stockgudang') ? 'active' : '' || 
                                    Request::is('stockgudang/stockgudang/*') ? 'active' : ''}}" href="{{ url('stockgudang/stockgudang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Stock Gudang </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('mutasi_stock/mutasi_stock') ? 'active' : '' || 
                                    Request::is('mutasi_stock/mutasi_stock/*') ? 'active' : ''}}" href="{{ url('mutasi_stock/mutasi_stock')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Mutasi Stock </a>
                                </li>
                                @if(Auth::user()->PunyaAkses('Stock Opname','aktif'))
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('stockopname/stockopname') ? 'active' : '' || 
                                    Request::is('stockopname/stockopname/*') ? 'active' : ''}}" href="{{ url('stockopname/stockopname')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Stock Opname </a>
                                </li>
                                @endif

                                    </ul>
                                </li>
                                
                                 <li class="


                                 {{

                                     /*============ sub TRANSAKSI HUTANG ======================*/
                                        /* fakturpembelian */
                                        Request::is('fakturpembelian/fakturpembelian') ? 'active' : '' || 
                                        Request::is('fakturpembelian/fakturpembelian/*') ? 'active' : '' ||
                                        /* uangmuka */
                                        Request::is('uangmuka') ? 'active' : '' || 
                                        Request::is('uangmuka/*') ? 'active' : '' ||
                                        /* voucherhutang */
                                        Request::is('voucherhutang/voucherhutang') ? 'active' : '' || 
                                        Request::is('voucherhutang/voucherhutang/*') ? 'active' : '' ||
                                        /* pending */
                                        Request::is('pending/index') ? 'active' : '' || 
                                        Request::is('pending/index/*') ? 'active' : '' ||
                                        /* CD/DN pembelian */
                                        Request::is('cndnpembelian/cndnpembelian') ? 'active' : '' || 
                                        Request::is('cndnpembelian/cndnpembelian/*') ? 'active' : '' ||
                                        /* Pelunasan hutang & Pembayaran kas */
                                        Request::is('pelunasanhutang/pelunasanhutang') ? 'active' : '' || 
                                        Request::is('pelunasanhutang/pelunasanhutang/*') ? 'active' : '' ||
                                        /* Pelunasan hutang & Pembayaran BANK */
                                        Request::is('pelunasanhutangbayarbank/pelunasanhutangbayarbank') ? 'active' : '' || 
                                        Request::is('pelunasanhutangbayarbank/pelunasanhutangbayarbank/*') ? 'active' : '' ||
                                        /* bank kas dll */
                                        Request::is('bankkaslain/bankkaslain') ? 'active' : '' || 
                                        Request::is('bankkaslain/bankkaslain/*') ? 'active' : '' ||
                                        /* TTT */
                                        Request::is('formtandaterimatagihan/formtandaterimatagihan') ? 'active' : '' || 
                                        Request::is('formtandaterimatagihan/formtandaterimatagihan/*') ? 'active' : '' ||
                                        /* AJU */
                                        Request::is('formaju/formaju') ? 'active' : '' || 
                                        Request::is('formaju/formaju/*') ? 'active' : '' ||
                                        /* FPG */
                                        Request::is('formfpg/formfpg') ? 'active' : '' || 
                                        Request::is('formfpg/formfpg/*') ? 'active' : '' ||
                                        /* pelaporan faktur pajak masukan */
                                        Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan') ? 'active' : '' || 
                                        Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan/*') ? 'active' : ''||
                                        /* Memorial purchase */
                                        Request::is('memorialpurchase/memorialpurchase') ? 'active' : '' || 
                                        Request::is('memorialpurchase/memorialpurchase/*') ? 'active' : ''
                                    /*=========== END OF sub TRANSAKSI HUTANG ================*/

                                 }}

                                 " style="border-left:none;">
                                    <a href="#" style="font-size:85%"> Transaksi Hutang <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%">
                                @if(Auth::user()->PunyaAkses('Faktur Pembelian','aktif'))
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('fakturpembelian/fakturpembelian') ? 'active' : '' || 
                                        Request::is('fakturpembelian/fakturpembelian/*') ? 'active' : ''}}" href="{{ url('fakturpembelian/fakturpembelian')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Faktur Pembelian </a>
                                </li>
                                @endif
                                <li>
                                    <a class=" {{/* uangmuka */Request::is('uangmuka') ? 'active' : '' || Request::is('uangmuka/*') ? 'active' : '' }}" href="{{url('uangmuka')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Uang Muka </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('voucherhutang/voucherhutang') ? 'active' : '' || 
                                        Request::is('voucherhutang/voucherhutang/*') ? 'active' : ''}}" href="{{ url('voucherhutang/voucherhutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Voucher Hutang </a>
                                </li>

                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('pending/index') ? 'active' : '' || 
                                        Request::is('pending/index/*') ? 'active' : ''}}" href="{{ url('pending/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Pending</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('pending_subcon/*') ? 'active' : ''}}">
                                    <a href="{{ url('pending_subcon/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Pending Subcon</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('cndnpembelian/cndnpembelian') ? 'active' : '' || 
                                        Request::is('cndnpembelian/cndnpembelian/*') ? 'active' : ''}}" href="{{ url('cndnpembelian/cndnpembelian')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> CN / DN Pembelian </a>
                                </li>
                           
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('pelunasanhutangbank/pelunasanhutangbank') ? 'active' : '' || 
                                        Request::is('pelunasanhutangbank/pelunasanhutangbank/*') ? 'active' : ''}}" href="{{ url('pelunasanhutangbank/pelunasanhutangbank')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pelunasan Hutang / Pembayaran Bank </a>
                                </li>
<!--                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('formtandaterimatagihan/formtandaterimatagihan') ? 'active' : '' || 
                                        Request::is('formtandaterimatagihan/formtandaterimatagihan/*') ? 'active' : ''}}" href="{{ url('formtandaterimatagihan/formtandaterimatagihan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Form Tanda Terima Tagihan (TTT)</a>
                                </li>
 -->
                             <!--    <li >
                                    <a class="sidebar master-perusahaan {{Request::is('formaju/formaju') ? 'active' : '' || 
                                        Request::is('formaju/formaju/*') ? 'active' : ''}}" href="{{ url('formaju/formaju')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Form Pengajuan Cek / BG (AJU)</a>
                                </li>
 -->
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('formfpg/formfpg') ? 'active' : '' || 
                                        Request::is('formfpg/formfpg/*') ? 'active' : ''}}" href="{{ url('formfpg/formfpg')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Form Permintaan Cek / BG (FPG)</a>
                                </li>

<!--                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan') ? 'active' : '' || 
                                        Request::is('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan/*') ? 'active' : ''}}" href="{{ url('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pelaporan  Faktur Pajak Masukan</a>
                                </li> -->

<!--                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('memorialpurchase/memorialpurchase') ? 'active' : '' || 
                                        Request::is('memorialpurchase/memorialpurchase/*') ? 'active' : ''}}" href="{{ url('memorialpurchase/memorialpurchase')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Memorial Purchase</a>
                                </li>  -->
                                    </ul>
                                </li>
                                <li class="

                                {{

                                     /*============ sub TRANSAKSI KAS ======================*/
                                         /* biaya_penerus_kas */
                                        Request::is('biaya_penerus/index') ? 'active' : '' || 
                                        Request::is('biaya_penerus/index/*') ? 'active' : '' ||
                                        /* Peding kas */
                                        Request::is('pending_kas/index') ? 'active' : '' || 
                                        Request::is('pending_kas/index/*') ? 'active' : '' ||
                                        /* BKK */
                                        Request::is('buktikaskeluar/index') ? 'active' : '' || 
                                        Request::is('buktikaskeluar/index/*') ? 'active' : ''||
                                        /* Iktisar kas */
                                        Request::is('ikhtisar_kas/index') ? 'active' : '' || 
                                        Request::is('ikhtisar_kas/index/*') ? 'active' : ''
                                    /*=========== END OF sub TRANSAKSI KAS ================*/

                                }}

                                " style="border-left:none;">
                                    <a href="#" style="font-size:85%"> Transaksi Kas <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="padding-left: 5%;font-size: 85%">
                                         <li >
                                            <a class="sidebar master-perusahaan {{Request::is('biaya_penerus/index') ? 'active' : '' || 
                                        Request::is('biaya_penerus/index/*') ? 'active' : ''}}" href="{{ url('biaya_penerus/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Biaya Penerus Kas</a>
                                        </li>
                                        <li >
                                            <a class="sidebar master-perusahaan {{Request::is('pending_kas/index') ? 'active' : '' || 
                                        Request::is('pending_kas/index/*') ? 'active' : ''}}" href="{{ url('pending_kas/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Pending Kas</a>
                                        </li>  
                                        <li >
                                            <a class="sidebar master-perusahaan {{Request::is('buktikaskeluar/index') ? 'active' : '' || 
                                        Request::is('buktikaskeluar/index/*') ? 'active' : ''}}" href="{{ url('buktikaskeluar/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Bukti Kas Keluar (BKK)</a>
                                        </li>  
                                        <li >
                                            <a class="sidebar master-perusahaan {{Request::is('ikhtisar_kas/index') ? 'active' : '' || 
                                        Request::is('ikhtisar_kas/index/*') ? 'active' : ''}}" href="{{ url('ikhtisar_kas/index')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Ikhtisar Kas</a>
                                        </li>                     
                                    </ul>
                                </li>
                                


                                                            
                            </ul>
                        </li>
                        <!-- end operasional pembelian -->

                        <!-- operasional keuangan -->
                        <li class="

                        {{

                            /*==================== MASTER KEUANGAN OPERASIONAL =========================*/
                            /* penerimaan */
                            Request::is('keuangan/penerimaan') ? 'active' : '' || 
                            Request::is('keuangan/penerimaan/*') ? 'active' : '' ||
                            /* Pengeluaran */
                            Request::is('keuangan/pengeluaran') ? 'active' : '' || 
                            Request::is('keuangan/pengeluaran/*') ? 'active' : ''||
                            /* jurnal_umum */
                            Request::is('keuangan/jurnal_umum') ? 'active' : '' || 
                            Request::is('keuangan/jurnal_umum/*') ? 'active' : ''
                             /*======== END OF MASTER KEUANGAN OPERASIONAL ==============================*/

                        }}

                        ">
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Keuangan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" style="font-size:85%">
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('keuangan/penerimaan') ? 'active' : '' || 
                            Request::is('keuangan/penerimaan/*') ? 'active' : ''}}" href="{{ url('keuangan/penerimaan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Penerimaan </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('keuangan/pengeluaran') ? 'active' : '' || 
                            Request::is('keuangan/pengeluaran/*') ? 'active' : ''}}" href="{{ url('keuangan/pengeluaran   ')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pengeluaran </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('keuangan/jurnal_umum') ? 'active' : '' || 
                            Request::is('keuangan/jurnal_umum/*') ? 'active' : ''   }}" href="{{ url('keuangan/jurnal_umum')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Jurnal Umum </a>
                                </li>
                                <li>
                                    <a class="sidebar master-perusahaan {{Request::is('master_keuangan/desain_neraca') ? 'active' : '' || 
                            Request::is('master_keuangan/desain_neraca/*') ? 'active' : ''   }}" href="{{ url('master_keuangan/desain_neraca')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Desain Neraca </a>
                                </li>

                                <li>
                                    <a class="sidebar master-perusahaan {{Request::is('master_keuangan/desain_laba_rugi') ? 'active' : '' || 
                            Request::is('master_keuangan/desain_neraca/*') ? 'active' : ''   }}" href="{{ url('master_keuangan/desain_laba_rugi')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Desain Laba Rugi </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end operasional keuangan -->
                    </ul>
                </li>    

                <li class="treeview sidebar data-master 

                {{

            /*==================== MASTER LAPORAN =========================*/

                    /*============== sub PENJUALAN LAPORAN========================*/
                            /* LAPORAN MASTER BERSAMA */
                            Request::is('laporanbersama/laporanbersama') ? 'active' : '' || 
                            Request::is('laporanbersama/laporanbersama/*') ? 'active' : '' ||
                            /* LAPORAN MASTER DO */
                            Request::is('laporanmasterdo/laporanmasterdo') ? 'active' : '' || 
                            Request::is('laporanmasterdo/laporanmasterdo/*') ? 'active' : '' ||
                            /* lpoan cabang dokumen */
                            Request::is('laporan_master_penjualan/tarif_cabang_dokumen') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_dokumen/*') ? 'active' : '' ||
                            /* koli */
                            Request::is('laporan_master_penjualan/tarif_cabang_koli') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_koli/*') ? 'active' : ''||
                            /* kargo */
                            Request::is('laporan_master_penjualan/tarif_cabang_kargo') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_kargo/*') ? 'active' : ''||
                             /* Kilogram */
                            Request::is('laporan_master_penjualan/tarif_cabang_kilogram') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_kilogram/*') ? 'active' : ''||
                            /* sepeda */
                            Request::is('laporan_master_penjualan/tarif_cabang_sepeda') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_sepeda/*') ? 'active' : ''||
                            /* so */
                            Request::is('sales/laporansalesorder') ? 'active' : '' || 
                            Request::is('sales/laporansalesorder/*') ? 'active' : ''||
                            /* do */
                            Request::is('sales/laporandeliveryorder_total') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_total/*') ? 'active' : ''||
                            /* do */
                            Request::is('sales/laporandeliveryorder') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder/*') ? 'active' : ''||
                             /* do kargo */
                            Request::is('sales/laporandeliveryorder_kargo') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_kargo/*') ? 'active' : ''||
                            /* do koran*/
                            Request::is('sales/laporandeliveryorder_koran') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_koran/*') ? 'active' : '' ||
                            /* invoice */
                            Request::is('sales/laporan_invoice') ? 'active' : '' || 
                            Request::is('sales/laporan_invoice/*') ? 'active' : ''||
                            /* invoice lain */
                            Request::is('sales/laporan_invoice_lain') ? 'active' : '' || 
                            Request::is('sales/laporan_invoice_lain/*') ? 'active' : ''||
                            /* laporan_cndn */
                            Request::is('sales/laporan_cndn') ? 'active' : '' || 
                            Request::is('sales/laporan_cndn/*') ? 'active' : ''||
                            /* laporan_uangmuka_penjualan */
                            Request::is('sales/laporan_uangmuka_penjualan') ? 'active' : '' || 
                            Request::is('sales/laporan_uangmuka_penjualan/*') ? 'active' : ''||
                            /* laporan_posting_bayar */
                            Request::is('sales/laporan_posting_bayar') ? 'active' : '' || 
                            Request::is('sales/laporan_posting_bayar/*') ? 'active' : ''||
                            /* Kwitansi */
                            Request::is('sales/laporan_kwitansi') ? 'active' : '' || 
                            Request::is('sales/laporan_kwitansi/*') ? 'active' : ''||
                            /* penjualan */
                            Request::is('sales/laporaninvoicepenjualan') ? 'active' : '' || 
                            Request::is('sales/laporaninvoicepenjualan/*') ? 'active' : ''||
                            /* penjualan per item */
                            Request::is('sales/laporaninvoicepenjualanperitem') ? 'active' : '' || 
                            Request::is('sales/laporaninvoicepenjualanperitem/*') ? 'active' : ''||
                            /* faktur pajak */
                            Request::is('sales/laporanfakturpajak') ? 'active' : '' || 
                            Request::is('sales/laporanfakturpajak/*') ? 'active' : ''||
                            /* kartu piutang */
                            Request::is('laporan_sales/kartu_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/kartu_piutang/*') ? 'active' : ''||
                            /* analisa piutang */
                            Request::is('laporan_sales/analisa_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/analisa_piutang/*') ? 'active' : ''||
                            /* mutasipiutang */
                            Request::is('laporan_sales/mutasi_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/mutasi_piutang/*') ? 'active' : ''||
                            /* piutang jatuh tempo */
                            Request::is('sales/laporanpiutangjatuhtempo') ? 'active' : '' || 
                            Request::is('sales/laporanpiutangjatuhtempo/*') ? 'active' : ''||
                     /*============== END sub PENJUALAN ===================*/

                      /*============== sub PEMBELIAN LAPORAN ========================*/
                            /* penerimaan */
                            Request::is('sales/laporan') ? 'active' : '' || 
                            Request::is('sales/laporan/*') ? 'active' : '' ||
                            /* faktur pajak */
                            Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''||
                            /* pengeluaran barang */
                            Request::is('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                            Request::is('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang/*') ? 'active' : ''||
                            /* penerimaan  */
                            Request::is('penerimaanbarang/penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                            Request::is('penerimaanbarang/penerimaanbarang/penerimaanbarang/*') ? 'active' : ''||
                            /* kartu piutang */
                            Request::is('reportmutasihutang/reportmutasihutang') ? 'active' : '' || 
                            Request::is('reportmutasihutang/reportmutasihutang/*') ? 'active' : ''||
                            /*   */
                            Request::is('reportfakturpelunasan/reportfakturpelunasan') ? 'active' : '' || 
                            Request::is('reportfakturpelunasan/reportfakturpelunasan/*') ? 'active' : ''||
                            /*  */
                            Request::is('reportanalisausiahutang/reportanalisausiahutang') ? 'active' : '' || 
                            Request::is('reportanalisausiahutang/reportanalisausiahutang/*') ? 'active' : ''||
                            /*  */
                            Request::is('reportfakturpajakmasukan/reportfakturpajakmasukan') ? 'active' : '' || 
                            Request::is('reportfakturpajakmasukan/reportfakturpajakmasukan/*') ? 'active' : ''||
                            /*  */
                            Request::is('historisuangmukapembelian/historisuangmukapembelian') ? 'active' : '' || 
                            Request::is('historisuangmukapembelian/historisuangmukapembelian/*') ? 'active' : '' ||
                     /*============== END sub PEMEBLIAN LAPORAN===================*/

                      /*============== sub KEUANGAN LAPORAN========================*/
                            /*  */
             
                            /*  */
                            Request::is('reportmastergroupitem/reportmastergroupitem') ? 'active' : '' || 
                            Request::is('reportmastergroupitem/reportmastergroupitem/*') ? 'active' : ''||
                            /*  */
                            Request::is('master-keuangan/laporan-laba-rugi') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-laba-rugi/*') ? 'active' : '' ||
                            /*  */
                            Request::is('master-keuangan/laporan-neraca') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-neraca*') ? 'active' : ''||
                            /*  */
                            Request::is('laporan-neraca/index') ? 'active' : '' || 
                            Request::is('laporan-neraca/index/*') ? 'active' : ''
                     /*============== END sub KEUANGAN LAPORAN===================*/

            /*======== END OF MASTER LAPORAN ==============================*/

                }}

                ">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Laporan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <!-- Laporan Penjualan -->
                        <li class="

                        {{

                              /*============== sub PENJUALAN LAPORAN========================*/
                            /* LAPORAN MASTER BERSAMA */
                            Request::is('laporanbersama/laporanbersama') ? 'active' : '' || 
                            Request::is('laporanbersama/laporanbersama/*') ? 'active' : '' ||
                            /* LAPORAN MASTER DO */
                            Request::is('laporanmasterdo/laporanmasterdo') ? 'active' : '' || 
                            Request::is('laporanmasterdo/laporanmasterdo/*') ? 'active' : '' ||
                            /* lpoan cabang dokumen */
                            Request::is('laporan_master_penjualan/tarif_cabang_dokumen') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_dokumen/*') ? 'active' : '' ||
                            /* koli */
                            Request::is('laporan_master_penjualan/tarif_cabang_koli') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_koli/*') ? 'active' : ''||
                            /* kargo */
                            Request::is('laporan_master_penjualan/tarif_cabang_kargo') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_kargo/*') ? 'active' : ''||
                             /* Kilogram */
                            Request::is('laporan_master_penjualan/tarif_cabang_kilogram') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_kilogram/*') ? 'active' : ''||
                            /* sepeda */
                            Request::is('laporan_master_penjualan/tarif_cabang_sepeda') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_sepeda/*') ? 'active' : ''||
                            /* so */
                            Request::is('sales/laporansalesorder') ? 'active' : '' || 
                            Request::is('sales/laporansalesorder/*') ? 'active' : ''||
                            /* do */
                            Request::is('sales/laporandeliveryorder_total') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_total/*') ? 'active' : ''||
                            /* do */
                            Request::is('sales/laporandeliveryorder') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder/*') ? 'active' : ''||
                            /* do kargo */
                            Request::is('sales/laporandeliveryorder_kargo') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_kargo/*') ? 'active' : ''||
                            /* do koran*/
                            Request::is('sales/laporandeliveryorder_koran') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_koran/*') ? 'active' : '' ||
                             /* invoice */
                            Request::is('sales/laporan_invoice') ? 'active' : '' || 
                            Request::is('sales/laporan_invoice/*') ? 'active' : ''||
                            /* invoice lain */
                            Request::is('sales/laporan_invoice_lain') ? 'active' : '' || 
                            Request::is('sales/laporan_invoice_lain/*') ? 'active' : ''||
                            /* laporan_cndn */
                            Request::is('sales/laporan_cndn') ? 'active' : '' || 
                            Request::is('sales/laporan_cndn/*') ? 'active' : ''||
                            /* laporan_uangmuka_penjualan */
                            Request::is('sales/laporan_uangmuka_penjualan') ? 'active' : '' || 
                            Request::is('sales/laporan_uangmuka_penjualan/*') ? 'active' : ''||
                            /* laporan_posting_bayar */
                            Request::is('sales/laporan_posting_bayar') ? 'active' : '' || 
                            Request::is('sales/laporan_posting_bayar/*') ? 'active' : ''||
                            /* Kwitansi */
                            Request::is('sales/laporan_kwitansi') ? 'active' : '' || 
                            Request::is('sales/laporan_kwitansi/*') ? 'active' : ''||
                            /* penjualan */
                            Request::is('sales/laporaninvoicepenjualan') ? 'active' : '' || 
                            Request::is('sales/laporaninvoicepenjualan/*') ? 'active' : ''||
                            /* penjualan per item */
                            Request::is('sales/laporaninvoicepenjualanperitem') ? 'active' : '' || 
                            Request::is('sales/laporaninvoicepenjualanperitem/*') ? 'active' : ''||
                            /* faktur pajak */
                            Request::is('sales/laporanfakturpajak') ? 'active' : '' || 
                            Request::is('sales/laporanfakturpajak/*') ? 'active' : ''||
                            /* kartu piutang */
                            Request::is('laporan_sales/kartu_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/kartu_piutang/*') ? 'active' : ''||
                            /* analisa piutang */
                            Request::is('laporan_sales/analisa_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/analisa_piutang/*') ? 'active' : ''||
                            /* mutasipiutang */
                            Request::is('laporan_sales/mutasi_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/mutasi_piutang/*') ? 'active' : ''||
                            /* piutang jatuh tempo */
                            Request::is('sales/laporanpiutangjatuhtempo') ? 'active' : '' || 
                            Request::is('sales/laporanpiutangjatuhtempo/*') ? 'active' : ''
                     /*============== END sub PENJUALAN ===================*/

                        }}

                        ">
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Penjualan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" style="font-size:85%">
                            <li >
                                 <a class="sidebar master-perusahaan {{Request::is('laporanbersama/laporanbersama') ? 'active' : '' || 
                            Request::is('laporanbersama/laporanbersama/*') ? 'active' : ''}} " href="{{ url('laporanbersama/laporanbersama')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Master Bersama<i class="fa fa-cog fa-spin pull-right" style="color: #19ecdd;"  aria-hidden="true"></i></a>
                            </li>
                            <li >
                                    <a class=" sidebar master-perusahaan {{Request::is('laporanmasterdo/laporanmasterdo') ? 'active' : '' || 
                            Request::is('laporanmasterdo/laporanmasterdo/*') ? 'active' : ''}} " href="{{ url('laporanmasterdo/laporanmasterdo')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Master DO<i class="fa fa-cog fa-spin pull-right " style="color: #19ecdd;" aria-hidden="true"></i></a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_dokumen') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_dokumen/*') ? 'active' : ''}} " href="{{ url('laporan_master_penjualan/tarif_cabang_dokumen')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Tarif Cabang Dokumen</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_koli') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_koli/*') ? 'active' : ''}} " href="{{ url('laporan_master_penjualan/tarif_cabang_koli')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Tarif Cabang Koli</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_kargo') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_kargo/*') ? 'active' : ''}} " href="{{ url('laporan_master_penjualan/tarif_cabang_kargo')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Tarif Cabang Kargo</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_kilogram') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_kilogram/*') ? 'active' : ''}} " href="{{ url('laporan_master_penjualan/tarif_cabang_kilogram')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Tarif Cabang Kilogram</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{ Request::is('laporan_master_penjualan/tarif_cabang_sepeda') ? 'active' : '' || 
                            Request::is('laporan_master_penjualan/tarif_cabang_sepeda/*') ? 'active' : ''}} " href="{{ url('laporan_master_penjualan/tarif_cabang_sepeda')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Tarif Cabang Sepeda</a>
                                </li>
                               {{--  <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporansalesorder') ? 'active' : '' || 
                            Request::is('sales/laporansalesorder/*') ? 'active' : ''}} " href="{{ url('sales/laporansalesorder')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Sales Order (SO)</a>
                                </li> --}}
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporandeliveryorder_total') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_total/*') ? 'active' : ''}} " href="{{ url('sales/laporandeliveryorder_total')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> DO Analisa</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporandeliveryorder') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder/*') ? 'active' : ''}} " href="{{ url('sales/laporandeliveryorder')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> DO Paket</a>
                                </li>
                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporandeliveryorder_koran') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_koran/*') ? 'active' : ''}} " href="{{ url('sales/laporandeliveryorder_koran')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> DO Koran</a>
                                </li>
                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporandeliveryorder_kargo') ? 'active' : '' || 
                            Request::is('sales/laporandeliveryorder_kargo/*') ? 'active' : ''}} " href="{{ url('sales/laporandeliveryorder_kargo')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> DO Kargo</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporan_invoice') ? 'active' : '' || 
                            Request::is('sales/laporan_invoice/*') ? 'active' : ''}} " href="{{ url('sales/laporan_invoice')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Invoice</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporan_invoice_lain') ? 'active' : '' || 
                            Request::is('sales/laporan_invoice_lain/*') ? 'active' : ''}} " href="{{ url('sales/laporan_invoice_lain')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Invoice Lain</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporan_cndn') ? 'active' : '' || 
                            Request::is('sales/laporan_cndn/*') ? 'active' : ''}} " href="{{ url('sales/laporan_cndn')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> CN/DN</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporan_uangmuka_penjualan') ? 'active' : '' || 
                            Request::is('sales/laporan_uangmuka_penjualan/*') ? 'active' : ''}} " href="{{ url('sales/laporan_uangmuka_penjualan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Uangmuka</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporan_posting_bayar') ? 'active' : '' || 
                            Request::is('sales/laporan_posting_bayar/*') ? 'active' : ''}} " href="{{ url('sales/laporan_posting_bayar')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Posting Bayar</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporan_kwitansi') ? 'active' : '' || 
                            Request::is('sales/laporan_kwitansi/*') ? 'active' : ''}} " href="{{ url('sales/laporan_kwitansi')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kwitansi</a>
                                </li>
                         {{--        <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporaninvoicepenjualan') ? 'active' : '' || 
                            Request::is('sales/laporaninvoicepenjualan/*') ? 'active' : ''}} " href="{{ url('sales/laporaninvoicepenjualan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Penjualan</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporaninvoicepenjualanperitem') ? 'active' : '' || 
                            Request::is('sales/laporaninvoicepenjualanperitem/*') ? 'active' : ''}} " href="{{ url('sales/laporaninvoicepenjualanperitem')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Penjualan Per Item</a>
                                </li> --}}
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('sales/laporanfakturpajak') ? 'active' : '' || 
                            Request::is('sales/laporanfakturpajak/*') ? 'active' : ''}} " href="{{ url('sales/laporanfakturpajak')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Faktur Pajak</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_sales/kartu_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/kartu_piutang/*') ? 'active' : ''}} " href="{{ url('laporan_sales/kartu_piutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kartu Piutang</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_sales/analisa_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/analisa_piutang/*') ? 'active' : ''}} " href="{{ url('laporan_sales/analisa_piutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Analisa Piutang</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('laporan_sales/mutasi_piutang') ? 'active' : '' || 
                            Request::is('laporan_sales/mutasi_piutang/*') ? 'active' : ''}} " href="{{ url('laporan_sales/mutasi_piutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Mutasi Piutang</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{ Request::is('sales/laporanpiutangjatuhtempo') ? 'active' : '' || 
                            Request::is('sales/laporanpiutangjatuhtempo/*') ? 'active' : ''}} " href="{{ url('sales/laporanpiutangjatuhtempo')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Piutang Jatuh Tempo</a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Laporan penjualan -->

                        <!-- Laporan pembelian -->
                        <li class="

                        {{

                             /*============== sub PEMBELIAN LAPORAN ========================*/
                            /* penerimaan */
                            Request::is('sales/laporan') ? 'active' : '' || 
                            Request::is('sales/laporan/*') ? 'active' : '' ||
                            /* faktur pajak */
                            Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''||
                            /* pengeluaran barang */
                            Request::is('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                            Request::is('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang/*') ? 'active' : ''||
                            /* penerimaan  */
                            Request::is('penerimaanbarang/penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                            Request::is('penerimaanbarang/penerimaanbarang/penerimaanbarang/*') ? 'active' : ''||
                            /* kartu piutang */
                            Request::is('reportmutasihutang/reportmutasihutang') ? 'active' : '' || 
                            Request::is('reportmutasihutang/reportmutasihutang/*') ? 'active' : ''||
                            /*   */
                            Request::is('reportfakturpelunasan/reportfakturpelunasan') ? 'active' : '' || 
                            Request::is('reportfakturpelunasan/reportfakturpelunasan/*') ? 'active' : ''||
                            /*  */
                            Request::is('reportanalisausiahutang/reportanalisausiahutang') ? 'active' : '' || 
                            Request::is('reportanalisausiahutang/reportanalisausiahutang/*') ? 'active' : ''||
                            /*  */
                            Request::is('reportfakturpajakmasukan/reportfakturpajakmasukan') ? 'active' : '' || 
                            Request::is('reportfakturpajakmasukan/reportfakturpajakmasukan/*') ? 'active' : ''||
                            /*  */
                            Request::is('historisuangmukapembelian/historisuangmukapembelian') ? 'active' : '' || 
                            Request::is('historisuangmukapembelian/historisuangmukapembelian/*') ? 'active' : '' 
                     /*============== END sub PEMEBLIAN LAPORAN===================*/

                        }}

                        ">
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Pembelian <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" style="font-size:85%">

                                <li  >
                                    <a class="sidebar master-perusahaan {{ Request::is('sales/laporan') ? 'active' : '' || 
                            Request::is('sales/laporan/*') ? 'active' : ''}}" href={{url('sales/laporan')}}><i class="fa fa-folder-open-o" aria-hidden="true"></i> Laporan</a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('fakturpajakmasukan/fakturpajakmasukan') ? 'active' : '' || 
                            Request::is('fakturpajakmasukan/fakturpajakmasukan/*') ? 'active' : ''}}" href="{{ url('fakturpajakmasukan/fakturpajakmasukan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Faktur Pajak Masukan </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('penerimaanbarang/penerimaanbarang/penerimaanbarang') ? 'active' : '' || 
                            Request::is('penerimaanbarang/penerimaanbarang/penerimaanbarang/*') ? 'active' : ''}}" href="{{ url('penerimaanbarang/penerimaanbarang/penerimaanbarang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Penerimaan Barang </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang') ? 'active' : '' || 
                            Request::is('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang/*') ? 'active' : ''}}" href="{{ url('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Pengeluaran Barang </a>
                                </li>

                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''}}" href="{{ url('reportkartuhutang/reportkartuhutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Uang Muka </a>
                                </li>

                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''}}" href="{{ url('reportkartuhutang/reportkartuhutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Voucher hutang </a>
                                </li>

                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''}}" href="{{ url('reportkartuhutang/reportkartuhutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> CN/DN Pembelian </a>
                                </li>

                                 <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''}}" href="{{ url('reportkartuhutang/reportkartuhutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kartu hutang </a>
                                </li>

                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : '' || 
                            Request::is('reportkartuhutang/reportkartuhutang/*') ? 'active' : ''}}" href="{{ url('reportkartuhutang/reportkartuhutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Kartu Hutang </a>
                                </li>

                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportmutasihutang/reportmutasihutang') ? 'active' : '' || 
                            Request::is('reportmutasihutang/reportmutasihutang/*') ? 'active' : ''}}" href="{{ url('reportmutasihutang/reportmutasihutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Mutasi Hutang </a>
                                </li>
                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportfakturpelunasan/reportfakturpelunasan') ? 'active' : '' || 
                            Request::is('reportfakturpelunasan/reportfakturpelunasan/*') ? 'active' : ''}}" href="{{ url('reportfakturpelunasan/reportfakturpelunasan')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Historis Faktur Vs Pelunasan </a>
                                </li>

                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportanalisausiahutang/reportanalisausiahutang') ? 'active' : '' || 
                            Request::is('reportanalisausiahutang/reportanalisausiahutang/*') ? 'active' : ''}}" href="{{ url('reportanalisausiahutang/reportanalisausiahutang')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Laporan Analisa Usia Hutang </a>
                                </li>

                                

                                <li >
                                    <a class="sidebar master-perusahaan {{Request::is('historisuangmukapembelian/historisuangmukapembelian') ? 'active' : '' || 
                            Request::is('historisuangmukapembelian/historisuangmukapembelian/*') ? 'active' : '' }}" href="{{ url('historisuangmukapembelian/historisuangmukapembelian')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Historis Uang Muka Pembelian </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Laporan pembelian -->

                        <!-- Laporan keuangan -->
                        <li class="

                        {{

                        /*============== sub KEUANGAN LAPORAN========================*/
                            /*  */
                            
                            /*  */
                            Request::is('reportmastergroupitem/reportmastergroupitem') ? 'active' : '' || 
                            Request::is('reportmastergroupitem/reportmastergroupitem/*') ? 'active' : ''||
                            /*  */
                            Request::is('master-keuangan/laporan-laba-rugi') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-laba-rugi/*') ? 'active' : '' ||
                            /*  */
                            Request::is('master-keuangan/laporan-neraca') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-neraca*') ? 'active' : ''||
                            /*  */
                            Request::is('laporan-neraca/index') ? 'active' : '' || 
                            Request::is('laporan-neraca/index/*') ? 'active' : ''
                        /*============== END sub KEUANGAN LAPORAN===================*/

                        }}

                        ">
                            <a href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> Keuangan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">

                                {{-- <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportmasteritem/reportmasteritem') ? 'active' : '' || 
                            Request::is('reportmasteritem/reportmasteritem/*') ? 'active' : ''}}"  href={{url('reportmasteritem/reportmasteritem')}}><i class="fa fa-folder-open-o" aria-hidden="true"></i> Arus Kas/Bank</a>
                                </li> --}}

                                {{-- <li >
                                    <a class="sidebar master-perusahaan {{Request::is('reportmastergroupitem/reportmastergroupitem') ? 'active' : '' || 
                            Request::is('reportmastergroupitem/reportmastergroupitem/*') ? 'active' : ''}}" href="{{url('reportmastergroupitem/reportmastergroupitem')}}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Buku Besar</a>
                                </li> --}}

                                <li>
                                    <a class="sidebar master-perusahaan  {{Request::is('master_keuangan/laba_rugi') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-laba-rugi/*') ? 'active' : ''}} " href="{{ route("laba_rugi.index", "bulan?m=".date("m")."&y=".date("Y")."") }}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Laba Rugi</a>
                                </li>

                                <li >
                                    <a class="sidebar master-perusahaan  {{Request::is('master_keuangan/neraca') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-neraca*') ? 'active' : ''}}" href="{{ route("neraca.index", "bulan?m=".date("m")."&y=".date("Y")."") }}"> <i class="fa fa-folder-open-o" aria-hidden="true"></i> Laporan Neraca </a>
                                </li>

                                <li >
                                    <a class="sidebar master-perusahaan  {{Request::is('master_keuangan/neraca-saldo') ? 'active' : '' || 
                            Request::is('master-keuangan/laporan-neraca*') ? 'active' : ''}}" href="{{ route("neraca_saldo.index", "bulan?m=".date("m")."&y=".date("Y")."") }}"> <i class="fa fa-folder-open-o" aria-hidden="true"></i> Neraca Saldo</a>
                                </li>
                                {{-- <li >
                                    <a class="sidebar master-perusahaan  {{Request::is('laporan-neraca/index') ? 'active' : '' || 
                            Request::is('laporan-neraca/index/*') ? 'active' : ''}}" href="{{url('laporan-neraca/index')}}"> <i class="fa fa-folder-open-o" aria-hidden="true"></i> Laporan Neraca1 </a>
                                </li> --}}
                            </ul>
                        </li>
                        <!-- end Laporan keuangan -->
                    </ul>

                </li>
                
               

                
                
                
               



        </div>
    </nav>
