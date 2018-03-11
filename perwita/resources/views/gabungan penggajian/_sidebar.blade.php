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
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Profile</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('coba') }}"><i class="fa fa-building" aria-hidden="true"></i> Index</a>
                    </li>                   
                </ul>
            </li>
            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Seragam Pekerja</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan">
                        <a href="{{ url('seragam') }}"><i class="fa fa-building" aria-hidden="true"></i> Daftar Order Seragam</a>
                    </li>                   
                </ul>
            </li>
            

            <!-- Form Surat - Surat -->
              <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Form Surat - Surat</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('form_surat_surat/pengalamankerja') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Keterangan Pengalaman Kerja</a>
                        <a href="{{ url('form_surat_surat/tidaklagibekerja') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Keterangan Tidak Lagi Bekerja</a>
                        <a href="{{ url('form_surat_surat/legalisirdataupah') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Permohonan Legalisir Data Upah</a>
                         <a href="{{ url('form_surat_surat/surattidakaktifBPJS') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Tidak Aktif BPJS</a>
                          <a href="{{ url('form_surat_surat/suratlaporanpekerjaresign') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Laporan Pekerja Resign</a>
                          <a href="{{ url('form_surat_surat/pengajuanpinjambank') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Pengajuan Pinjam Bank</a>
                          <a href="{{ url('form_surat_surat/pengantarpendaftaranbpjskesehatan') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Pengantar Pendaftaran BPJS Kesehatan</a>
                           <a href="{{ url('form_surat_surat/keterangankerjapengajuankpr') }}"><i class="fa  fa-book" aria-hidden="true"></i> Surat Keterangan Kerja Pengajuan KPR</a>

                    </li>                   
                </ul>
            </li>
            


            <!-- master hrd -->
             <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Master HRD</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('master_hrd/index') }}"><i class="fa  fa-book" aria-hidden="true"></i> Data Mitra</a>
                        <a href="{{ url('master_hrd/index2') }}"><i class="fa  fa-book" aria-hidden="true"></i> Data Pegawai Perwita</a>
                        <a href="{{ url('master_hrd/index3') }}"><i class="fa  fa-book" aria-hidden="true"></i> Data Tenaga Kerja Outsourching</a>
                    </li>                   
                </ul>
            </li>
            
            
            
            
            
            
            

            <li class="treeview sidebar data-master {{
                 Request::is('data-master/master-akun') ? 'active' : '' 
              || Request::is('data-master/master-akun/*') ? 'active' : '' 
              || Request::is('data-master/master-transaksi-akun') ? 'active' : ''
              || Request::is('data-master/master-transaksi-akun/*') ? 'active' : ''}}">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Data Master</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                    
                    <li class="{{ Request::is('data-master/master-akun') ? 'active' : '' || Request::is('data-master/master-akun/*') ? 'active' : ''  }} sidebar master-akun">
                        <a id="step2" href="{{ url('data-master/master-akun') }}">
                            <i class="fa  fa-book" aria-hidden="true"></i><span class="nav-label">Master Akun</span>
                        </a>
                    </li>

                 
                </ul>
            </li>


            <!-- BPJS KESEHATAN -->
            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">BPJS Kesehatan</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <!-- <a href="{{ url('bpjs/datapeserta') }}"><i class="fa  fa-book" aria-hidden="true"></i>Daftar Peserta BPJS</a> -->
                        <a href="{{ url('bpjs/daftarbpjs') }}"><i class="fa  fa-book" aria-hidden="true"></i>Daftar BPJS</a>
                        <a href="{{ url('bpjs/keluarbpjs') }}"><i class="fa  fa-book" aria-hidden="true"></i>Daftar Keluar BPJS</a>
                        <!-- <a href="{{ url('bpjs/daftargaji') }}"><i class="fa  fa-book" aria-hidden="true"></i>Daftar Gaji</a> -->
                    </li>                   
                </ul>
            </li>


             <!-- BPJS TK -->
            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">BPJS TK</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('bpjs/datapeserta') }}"><i class="fa  fa-book" aria-hidden="true"></i>Daftar Peserta BPJS</a>
                    </li>                   
                </ul>
            </li>

            <!-- RBH -->
             <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">RBH</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('bpjs/rbh') }}"><i class="fa  fa-book" aria-hidden="true"></i>RBH</a>
                    </li>                   
                </ul>
            </li>


            <!-- PENGGAJIAN -->
            <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Penggajian</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('penggajian/daftargaji') }}"><i class="fa  fa-book" aria-hidden="true"></i>Daftar Gaji</a>
                    </li>   
                       <li class="sidebar master-perusahaan" >
                        <a href="{{ url('penggajian/master_upah_tenaga_kerja') }}"><i class="fa  fa-book" aria-hidden="true"></i>Master Upah Tenaga Kerja</a>
                    </li>                     
                </ul>
            </li>

            <!-- MANAGEMENT KEUANGAN -->
              <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">Managemen Keuangan</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('keuangan/aruskas') }}"><i class="fa  fa-book" aria-hidden="true"></i>Laporan Arus Kas</a>
                        <a href="{{ url('keuangan/neraca') }}"><i class="fa  fa-book" aria-hidden="true"></i>Laporan Neraca</a>
                        <a href="{{ url('keuangan/labarugi') }}"><i class="fa  fa-book" aria-hidden="true"></i>Laporan LabaRugi</a>
                        <a href="{{ url('keuangan/hutang') }}"><i class="fa  fa-book" aria-hidden="true"></i>Hutang</a>
                        <a href="{{ url('keuangan/piutang') }}"><i class="fa  fa-book" aria-hidden="true"></i>Piutang</i></a>
                        <!-- <a href="#"><i class="fa  fa-book" aria-hidden="true"></i>Pajak</i></a> -->
                        <!-- <a href="#"><i class="fa  fa-book" aria-hidden="true"></i>Analisa Keuangan</i></a> -->
                    </li>                   
                </ul>
            </li> 
               <li class="treeview sidebar data-master">
                <a href="#" ><i class="fa fa-file-o"></i> <span class="nav-label">PTJKI</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">                   
                    <li class="sidebar master-perusahaan" >
                        <a href="{{ url('master_hrd/index') }}"><i class="fa  fa-book" aria-hidden="true"></i> Data Mitra</a>
                      <!--   <a href="{{ url('master_hrd/index2') }}"><i class="fa  fa-book" aria-hidden="true"></i> Data Pegawai Perwita</a> -->
                        <a href="{{ url('master_hrd/index3') }}"><i class="fa  fa-book" aria-hidden="true"></i> Data Tenaga Kerja Outsourching</a>
                    </li>                   
                </ul>
            </li>
        </ul>
    </div>
</nav>