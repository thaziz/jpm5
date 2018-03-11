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




            

                <!-- Setting --> 
                <li class="treeview sidebar data-master sidebar data-master">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Setting</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="sidebar {{Request::is('setting/pengguna') ? 'active' : ''}} ">
                            <a href="{{ url('setting/pengguna')}}"><i class="fa fa-building" aria-hidden="true"></i>Pengguna</a>
                        </li>
                    </ul>
                </li>
                <!-- end Setting -->

                <!-- Master --> 
                <li class="treeview sidebar data-master sidebar data-master">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Master</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="sidebar master-perusahaan {{Request::is('sales/provinsi') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/pajak')}}"><i class="fa fa-building" aria-hidden="true"></i> Pajak</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('sales/provinsi') ? 'active' : ''}} ">
                            <a href="{{ url('sales/provinsi')}}"><i class="fa fa-building" aria-hidden="true"></i> Provinsi</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('sales/kota') ? 'active' : ''}} ">
                            <a href="{{ url('sales/kota')}}"><i class="fa fa-building" aria-hidden="true"></i> Kota</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('sales/kecamatan') ? 'active' : ''}} ">
                            <a href="{{ url('sales/kecamatan')}}"><i class="fa fa-building" aria-hidden="true"></i> Kecamatan</a>
                        </li>
                        
                        <li class="nav-divider">
                    
						</li>

                        <li class="sidebar master-perusahaan {{Request::is('sales/tarif_cabang_dokumen') ? 'active' : ''}} ">
                            <a href="{{ url('sales/tarif_cabang_dokumen')}}"><i class="fa fa-building" aria-hidden="true"></i> Tarif Cabang Dokumen</a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('sales/tarif_cabang_kilogram') ? 'active' : ''}} ">
                            <a href="{{ url('sales/tarif_cabang_kilogram')}}"><i class="fa fa-building" aria-hidden="true"></i> Tarif Cabang Kilogram</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('sales/tarif_cabang_kargo') ? 'active' : ''}} ">
                            <a href="{{ url('sales/tarif_cabang_koli')}}"><i class="fa fa-building" aria-hidden="true"></i> Tarif Cabang Koli</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('sales/tarif_cabang_kargo') ? 'active' : ''}} ">
                            <a href="{{ url('sales/tarif_cabang_kargo')}}"><i class="fa fa-building" aria-hidden="true"></i> Tarif Cabang Kargo</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('sales/tarif_penerus_default') ? 'active' : ''}} ">
                            <a href="{{ url('sales/tarif_penerus_default')}}"><i class="fa fa-building" aria-hidden="true"></i> Tarif Penerus Default</a>
                        </li>
						<li class="sidebar master-perusahaan {{Request::is('sales/kontrak') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/kontrak')}}"><i class="fa fa-building" aria-hidden="true"></i>Kontrak</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_subcon/subcon') ? 'active' : ''}} ">
                            <a href="{{ url('master_subcon/subcon')}}"><i class="fa fa-building" aria-hidden="true"></i>Kontrak SUBCON</a>
                        </li>
                        <li class="nav-divider">
                    
						</li>

                        <li class="sidebar master-perusahaan {{Request::is('masteritem/*') ? 'active' : ''}} ">
                            <a href="{{ url('masteritem/masteritem')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Item Purchase </a>
                        </li>

                         <li class="sidebar master-perusahaan {{Request::is('masterbank/*') ? 'active' : ''}} ">
                            <a href="{{ url('masterbank/masterbank')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Bank </a>
                        </li>

                        
                        <li class="sidebar master-perusahaan {{Request::is('mastersupplier/*') ? 'active' : ''}}">
                            <a href="{{ url('mastersupplier/mastersupplier')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Supplier </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('konfirmasisupplier/*') ? 'active' : ''}}">
                            <a href="{{ url('konfirmasisupplier/konfirmasisupplier')}}"><i class="fa fa-building" aria-hidden="true"></i> Konfirmasi Master Supplier </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('mastergudang/*') ? 'active' : ''}}">
                            <a href="{{ url('mastergudang/mastergudang')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Gudang </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('masterdepartment/*') ? 'active' : ''}}">
                            <a href="{{ url('masterdepartment/masterdepartment')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Department </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('masterjenisitem/*') ? 'active' : ''}}">
                            <a href="{{ url('masterjenisitem/masterjenisitem')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Jenis Item </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('masteractiva/*') ? 'active' : ''}}">
                            <a href="{{ url('masteractiva/masteractiva')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Activa </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('golonganactiva/*') ? 'active' : ''}}">
                            <a href="{{ url('golonganactiva/golonganactiva')}}"><i class="fa fa-building" aria-hidden="true"></i> Golongan Activa </a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('notadebit/*') ? 'active' : ''}}">
                            <a href="{{ url('notadebit/notadebit')}}"><i class="fa fa-building" aria-hidden="true"></i> Nota Debit / Kredit Aktiva </a>
                        </li>
                     

                        <li class="sidebar master-perusahaan {{Request::is('bbm/*') ? 'active' : ''}}">
                            <a href="{{ url('bbm/index')}}"><i class="fa fa-building" aria-hidden="true"></i> Master BBM </a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('presentase/*') ? 'active' : ''}}">
                            <a href="{{ url('presentase/index')}}"><i class="fa fa-building" aria-hidden="true"></i> Master Persen </a>
                        </li>
                        <li class="nav-divider">
                    
						</li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/agen') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/agen')}}"><i class="fa fa-building" aria-hidden="true"></i>Agen</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/vendor') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/vendor')}}"><i class="fa fa-building" aria-hidden="true"></i>Vendor</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/rute') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/rute')}}"><i class="fa fa-building" aria-hidden="true"></i>Rute</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/satuan') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/satuan')}}"><i class="fa fa-building" aria-hidden="true"></i>Satuan</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/grup_item') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/grup_item')}}"><i class="fa fa-building" aria-hidden="true"></i>Group Item</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/item') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/item')}}"><i class="fa fa-building" aria-hidden="true"></i>Item</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/komisi') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/komisi')}}"><i class="fa fa-building" aria-hidden="true"></i>Komisi</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/customer') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/customer')}}"><i class="fa fa-building" aria-hidden="true"></i>Customer</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/biaya') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/biaya')}}"><i class="fa fa-building" aria-hidden="true"></i>Biaya</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/saldopiutang') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/saldopiutang')}}"><i class="fa fa-building" aria-hidden="true"></i>Saldo Piutang</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/saldoawalpiutanglain') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/saldoawalpiutanglain')}}"><i class="fa fa-building" aria-hidden="true"></i>Saldo Awal Piutang Lain</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/cabang') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/cabang')}}"><i class="fa fa-building" aria-hidden="true"></i>Cabang</a>
                        </li>
						<li class="sidebar master-perusahaan {{Request::is('master_sales/cabang') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/subcon')}}"><i class="fa fa-building" aria-hidden="true"></i>Subcon</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/tipe_angkutan') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/tipe_angkutan')}}"><i class="fa fa-building" aria-hidden="true"></i>Tipe Angkutan</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/kendaraan') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/kendaraan')}}"><i class="fa fa-building" aria-hidden="true"></i>Kendaraan</a>
                        </li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/nomorseripajak') ? 'active' : ''}} ">
                            <a href="{{ url('master_sales/nomorseripajak')}}"><i class="fa fa-building" aria-hidden="true"></i>Nomor Seri Pajak</a>
                        </li>
                        <li class="nav-divider">
                    
						</li>
                        <li class="sidebar master-perusahaan {{Request::is('master_sales/tipeangkutan') ? 'active' : ''}} ">
                            <a href="{{ url('master_keuangan/kelompok_akun')}}"><i class="fa fa-building" aria-hidden="true"></i>Kelompok Akun</a>
                        </li>
                        
			<li class="sidebar master-perusahaan {{Request::is('master_sales/nomorseripajak') ? 'active' : ''}} ">
                            <a href="{{ url('master_keuangan/akun')}}"><i class="fa fa-building" aria-hidden="true"></i>Akun</a>
                        </li>

                        <li class="sidebar master-perusahaan {{Request::is('master_sales/tipeangkutan') ? 'active' : ''}} ">
                            <a href="{{ url('master_keuangan/saldo_akun')}}"><i class="fa fa-building" aria-hidden="true"></i>Saldo Akun</a>
                        </li>

                    </ul>
                </li>
                <!-- end master -->

                <!-- Master -->
                <li class="treeview sidebar data-master sidebar data-master">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Operasional</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <!-- Operasional Penjualan -->
                        <li class="">
                            <a href="#"> Penjualan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">

                            <li class="sidebar master-perusahaan {{Request::is('sales/salesorder') ? 'active' : ''}} ">
                                <a href="{{ url('sales/salesorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Sales Order (SO)</a>
                            </li>
                            <li class="sidebar master-perusahaan {{Request::is('sales/deliveryorder') ? 'active' : ''}} ">
                                <a href="{{ url('sales/deliveryorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO)</a>
                            </li>
							<li class="sidebar master-perusahaan {{Request::is('sales/deliveryorder') ? 'active' : ''}} ">
                                <a href="{{ url('sales/deliveryorderkargo')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO) Kargo</a>
                            </li>
                            <li class="sidebar master-perusahaan {{Request::is('sales/do-home') ? 'active' : ''}}">
                                <a href="{{ url('sales/do-home') }}" >
                                    <i class="fa fa-building" aria-hidden="true"></i>
                                    DO (Koran)
                                </a>
                            </li>
                            <li class="sidebar master-perusahaan {{Request::is('updatestatus') ? 'active' : ''}} ">
                            <a href="{{ url('updatestatus')}}"><i class="fa fa-building" aria-hidden="true"></i>Update Status Order</a>
                        </li>
                            <li class="sidebar master-perusahaan {{Request::is('sales/deliveryordercabangtracking') ? 'active' : ''}} ">
                                <a href="{{ url('sales/deliveryordercabangtracking')}}"><i class="fa fa-building" aria-hidden="true"></i> Tracking Delivery Order (DO)</a>
                            </li>
                            <li class="sidebar master-perusahaan {{Request::is('sales/surat_jalan_trayek') ? 'active' : ''}} ">
                                <a href="{{ url('sales/surat_jalan_trayek')}}"><i class="fa fa-building" aria-hidden="true"></i> Surat Jalan By Trayek</a>
                            </li>
                            <!--
                            <li class="sidebar master-perusahaan {{Request::is('sales/deliveryorder') ? 'active' : ''}} ">
                                <a href="{{ url('sales/deliveryorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO)</a>
                            </li>
                            -->
                            <li class="sidebar master-perusahaan {{Request::is('sales/invoice') ? 'active' : ''}} ">
                                <a href="{{ url('sales/invoice')}}"><i class="fa fa-building" aria-hidden="true"></i> Invoice </a>
                            </li>
                            <!--
                            <li class="sidebar master-perusahaan {{Request::is('sales/fakturpajak') ? 'active' : ''}} ">
                                <a href="{{ url('sales/fakturpajak')}}"><i class="fa fa-building" aria-hidden="true"></i> Faktur Pajak</a>
                            </li>
                            -->
							<li class="sidebar master-perusahaan {{Request::is('sales/invoice_lain') ? 'active' : ''}} ">
                                <a href="{{ url('sales/invoice_lain')}}"><i class="fa fa-building" aria-hidden="true"></i> Invoice Lain Lain</a>
                            </li>
                            <li class="sidebar master-perusahaan {{Request::is('sales/penerimaanpenjualan') ? 'active' : ''}} ">
                                <a href="{{ url('sales/penerimaan_penjualan')}}"><i class="fa fa-building" aria-hidden="true"></i> Penerimaan Penjualan</a>
                            </li>
                            <li class="sidebar master-perusahaan {{Request::is('sales/postingpembayaran') ? 'active' : ''}} ">
                                <a href="{{ url('sales/posting_pembayaran')}}"><i class="fa fa-building" aria-hidden="true"></i> Posting Pembayaran</a>
                            </li>
                            
                            </ul>
                        </li>
                        <!-- end operasional penjualan -->

                        <!-- operasional pembelian -->
                        <li class="">
                            <a href="#"> Pembelian <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li class="">
                                    <a href="#"> Transaksi Kas <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                         <li class="sidebar master-perusahaan {{Request::is('biaya_penerus/*') ? 'active' : ''}}">
                                            <a href="{{ url('biaya_penerus/index')}}"><i class="fa fa-building" aria-hidden="true"></i>Biaya Penerus Kas</a>
                                        </li>  
                                        <li class="sidebar master-perusahaan {{Request::is('buktikaskeluar/*') ? 'active' : ''}}">
                                            <a href="{{ url('buktikaskeluar/index')}}"><i class="fa fa-building" aria-hidden="true"></i>Bukti Kas Keluar (BKK)</a>
                                        </li>  
                                        <li class="sidebar master-perusahaan {{Request::is('ikhtisar_kas/*') ? 'active' : ''}}">
                                            <a href="{{ url('ikhtisar_kas/index')}}"><i class="fa fa-building" aria-hidden="true"></i>Ikhtisar Kas</a>
                                        </li>                     
                                    </ul>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('penerimaanbarang/*') ? 'active' : ''}}">
                                    <a href="{{ url('penerimaanbarang/penerimaanbarang')}}"><i class="fa fa-building" aria-hidden="true"></i> Penerimaan Barang </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('pengeluaranbarang/*') ? 'active' : ''}}">
                                    <a href="{{ url('pengeluaranbarang/pengeluaranbarang')}}"><i class="fa fa-building" aria-hidden="true"></i> Pengeluaran Barang </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('konfirmasipengeluaranbarang/*') ? 'active' : ''}}">
                                    <a href="{{ url('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang')}}"><i class="fa fa-building" aria-hidden="true"></i> Konfirmasi Pengeluaran Barang </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('stockgudang/*') ? 'active' : ''}}">
                                    <a href="{{ url('stockgudang/stockgudang')}}"><i class="fa fa-building" aria-hidden="true"></i> Stock Gudang </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('stockopname/*') ? 'active' : ''}}">
                                    <a href="{{ url('stockopname/stockopname')}}"><i class="fa fa-building" aria-hidden="true"></i> Stock Opname </a>
                                </li>


                                <li class="sidebar master-perusahaan {{Request::is('suratpermintaanpembelian/*') ? 'active' : ''}} ||    {{Request::is('suratpermintaanpembelian') ? 'active' : ''}}" ?>
                                    <a href="{{ url('suratpermintaanpembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Surat Permintaan Pembeliaan</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('konfirmasi_order/*') ? 'active' : ''}}">
                                    <a href="{{ url('konfirmasi_order/konfirmasi_order')}}"><i class="fa fa-building" aria-hidden="true"></i> Konfirmasi Order </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('purchaseorder/*') ? 'active' : ''}}">
                                    <a href="{{ url('purchaseorder/purchaseorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Purchase Order </a>
                                </li>



                                <li class="sidebar master-perusahaan {{Request::is('fakturpembelian/*') ? 'active' : ''}}">
                                    <a href="{{ url('fakturpembelian/fakturpembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Faktur Pembelian </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('voucherhutang/*') ? 'active' : ''}}">
                                    <a href="{{ url('voucherhutang/voucherhutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Voucher Hutang </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('pending/*') ? 'active' : ''}}">
                                    <a href="{{ url('pending/index')}}"><i class="fa fa-building" aria-hidden="true"></i>Pending</a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('returnpembelian/*') ? 'active' : ''}}">
                                    <a href="{{ url('returnpembelian/returnpembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Return Pembelian </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('cndnpembelian/*') ? 'active' : ''}}">
                                    <a href="{{ url('cndnpembelian/cndnpembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> CN / DN Pembelian </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('uangmukapembelian/uangmukapembelian') ? 'active' : ''}}">
                                    <a href="{{ url('uangmukapembelian/uangmukapembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Uang Muka Pembelian </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('pelunasanhutang/*') ? 'active' : ''}}">
                                    <a href="{{ url('pelunasanhutang/pelunasanhutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Pelunasan Hutang / Pembayaran Kas </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('pelunasanhutangbayarbank/*') ? 'active' : ''}}">
                                    <a href="{{ url('pelunasanhutangbayarbank/pelunasanhutangbayarbank')}}"><i class="fa fa-building" aria-hidden="true"></i> Pelunasan Hutang / Pembayaran Bank </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('bankkaslain/*') ? 'active' : ''}}">
                                    <a href="{{ url('bankkaslain/bankkaslain')}}"><i class="fa fa-building" aria-hidden="true"></i> Bank / Kas Lain </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('mutasi_stock/*') ? 'active' : ''}}">
                                    <a href="{{ url('mutasi_stock/mutasi_stock')}}"><i class="fa fa-building" aria-hidden="true"></i> Mutasi Stock </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('formtandaterimatagihan/*') ? 'active' : ''}}">
                                    <a href="{{ url('formtandaterimatagihan/formtandaterimatagihan')}}"><i class="fa fa-building" aria-hidden="true"></i> Form Tanda Terima Tagihan (TTT)</a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('formaju/formaju') ? 'active' : ''}}">
                                    <a href="{{ url('formaju/formaju')}}"><i class="fa fa-building" aria-hidden="true"></i> Form Pengajuan Cek / BG (AJU)</a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('formfpg/*') ? 'active' : ''}}">
                                    <a href="{{ url('formfpg/formfpg')}}"><i class="fa fa-building" aria-hidden="true"></i> Form Permintaan Cek / BG (FPG)</a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('pelaporanfakturpajakmasukan/*') ? 'active' : ''}}">
                                    <a href="{{ url('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan')}}"><i class="fa fa-building" aria-hidden="true"></i> Pelaporan  Faktur Pajak Masukan</a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('memorialpurchase/memorialpurchase') ? 'active' : ''}}">
                                    <a href="{{ url('memorialpurchase/memorialpurchase')}}"><i class="fa fa-building" aria-hidden="true"></i> Memorial Purchase</a>
                                </li>                             
                            </ul>
                        </li>
                        <!-- end operasional pembelian -->

                        <!-- operasional keuangan -->
                        <li class="">
                            <a href="#"> Keuangan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li class="sidebar master-perusahaan {{Request::is('penerimaanbarang/*') ? 'active' : ''}}">
                                    <a href="{{ url('keuangan/penerimaan')}}"><i class="fa fa-building" aria-hidden="true"></i> Penerimaan </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('pengeluaranbarang/*') ? 'active' : ''}}">
                                    <a href="{{ url('keuangan/pengeluaran   ')}}"><i class="fa fa-building" aria-hidden="true"></i> Pengeluaran </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('konfirmasipengeluaranbarang/*') ? 'active' : ''}}">
                                    <a href="{{ url('keuangan/jurnal_umum')}}"><i class="fa fa-building" aria-hidden="true"></i> Jurnal Umum </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end operasional keuangan -->
                    </ul>
                </li>    

                <li class="treeview sidebar data-master sidebar data-master">
                    <a href="#" ><i class="fa fa-suitcase" aria-hidden="true"></i><span class="nav-label">Laporan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <!-- Laporan Penjualan -->
                        <li class="">
                            <a href="#"> Penjualan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_dokumen') ? 'active' : ''}} ">
                                    <a href="{{ url('laporan_master_penjualan/tarif_cabang_dokumen')}}"><i class="fa fa-building" aria-hidden="true"></i>Tarif Cabang Dokumen</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_koli') ? 'active' : ''}} ">
                                    <a href="{{ url('laporan_master_penjualan/tarif_cabang_koli')}}"><i class="fa fa-building" aria-hidden="true"></i>Tarif Cabang Koli</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('laporan_master_penjualan/tarif_cabang_kargo') ? 'active' : ''}} ">
                                    <a href="{{ url('laporan_master_penjualan/tarif_cabang_kargo')}}"><i class="fa fa-building" aria-hidden="true"></i>Tarif Cabang Kargo</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporansalesorder') ? 'active' : ''}} ">
                                    <a href="{{ url('sales/laporansalesorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Sales Order (SO)</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporandeliveryorder') ? 'active' : ''}} ">
                                    <a href="{{ url('sales/laporandeliveryorder')}}"><i class="fa fa-building" aria-hidden="true"></i> Delivery Order (DO)</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporaninvoicepenjualan') ? 'active' : ''}} ">
                                    <a href="{{ url('sales/laporaninvoicepenjualan')}}"><i class="fa fa-building" aria-hidden="true"></i>Penjualan</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporaninvoicepenjualanperitem') ? 'active' : ''}} ">
                                    <a href="{{ url('sales/laporaninvoicepenjualanperitem')}}"><i class="fa fa-building" aria-hidden="true"></i>Penjualan Per Item</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporanfakturpajak') ? 'active' : ''}} ">
                                    <a href="{{ url('sales/laporanfakturpajak')}}"><i class="fa fa-building" aria-hidden="true"></i> Faktur Pajak</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporankartupiutang') ? 'active' : ''}} ">
                                    <a href="{{ url('laporan_sales/kartu_piutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Kartu Piutang</a>
                                </li>
								<li class="sidebar master-perusahaan {{Request::is('sales/laporananalisapiutang') ? 'active' : ''}} ">
                                    <a href="{{ url('laporan_sales/analisa_piutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Analisa Piutang</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporanmutasipiutang') ? 'active' : ''}} ">
                                    <a href="{{ url('laporan_sales/mutasi_piutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Mutasi Piutang</a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('sales/laporanpiutangjatuhtempo') ? 'active' : ''}} ">
                                    <a href="{{ url('sales/laporanpiutangjatuhtempo')}}"><i class="fa fa-building" aria-hidden="true"></i> Piutang Jatuh Tempo</a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Laporan penjualan -->

                        <!-- Laporan pembelian -->
                        <li class="">
                            <a href="#"> Pembelian <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">

                                <li class="sidebar master-perusahaan {{Request::is('reportmasteritem/reportmasteritem') ? 'active' : ''}}" >
                                    <a href={{url('reportmasteritem/reportmasteritem')}}><i class="fa fa-building" aria-hidden="true"></i> Laporan Data Master Item</a>
                                </li>

                                
                                <li class="sidebar master-perusahaan  {{Request::is('reportmasterdepartment/reportmasterdepartment') ? 'active' : ''}} ">
                                    <a href="{{url('reportmasterdepartment/reportmasterdepartment')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Data Master Bagian / Departement</a>
                                </li>

                                <li class="sidebar master-perusahaan  {{Request::is('reportmastergudang/reportmastergudang') ? 'active' : ''}}">
                                    <a href="{{url('reportmastergudang/reportmastergudang')}}"> <i class="fa fa-building" aria-hidden="true"></i> Laporan Data Master Gudang </a>
                                </li>

                                <li class="sidebar master-perusahaan  {{Request::is('reportmastersupplier/reportmastersupplier') ? 'active' : ''}}">
                                    <a href="{{url('reportmastersupplier/reportmastersupplier')}}"> <i class="fa fa-building" aria-hidden="true"></i> Laporan Data Master Supplier </a>
                                </li>




                                <li class="sidebar master-perusahaan {{Request::is('reportspp/reportspp') ? 'active' : ''}} ">
                                    <a href="{{ url('reportspp/reportspp')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Surat Permintaan Pembelian </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('reportpo/reportpo') ? 'active' : ''}}">
                                    <a href="{{ url('reportpo/reportpo')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Pembelian Order </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportfakturpembelian/reportfakturpembelian') ? 'active' : ''}}">
                                    <a href="{{ url('reportfakturpembelian/reportfakturpembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Faktur Pembelian </a>
                                </li>

                                <li class="sidebar master-perusahaan  {{Request::is('buktikaskeluar/patty_cash') ? 'active' : ''}}">
                                    <a href="{{url('buktikaskeluar/patty_cash')}}"> <i class="fa fa-building" aria-hidden="true"></i> Laporan Patty Cash </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportbayarkas/reportbayarkas') ? 'active' : ''}}">
                                    <a href="{{ url('reportbayarkas/reportbayarkas')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Pelunasan Hutang / Bayar Kas </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportbayarbank/reportbayarbank') ? 'active' : ''}}">
                                    <a href="{{ url('reportbayarbank/reportbayarbank')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Pelunasan Hutang / Bayar Bank </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportkartuhutang/reportkartuhutang') ? 'active' : ''}}">
                                    <a href="{{ url('reportkartuhutang/reportkartuhutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Kartu Hutang </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportmutasihutang/reportmutasihutang') ? 'active' : ''}}">
                                    <a href="{{ url('reportmutasihutang/reportmutasihutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Mutasi Hutang </a>
                                </li>
                                <li class="sidebar master-perusahaan {{Request::is('reportfakturpelunasan/reportfakturpelunasan') ? 'active' : ''}}">
                                    <a href="{{ url('reportfakturpelunasan/reportfakturpelunasan')}}"><i class="fa fa-building" aria-hidden="true"></i> Historis Faktur Vs Pelunasan </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportanalisausiahutang/reportanalisausiahutang') ? 'active' : ''}}">
                                    <a href="{{ url('reportanalisausiahutang/reportanalisausiahutang')}}"><i class="fa fa-building" aria-hidden="true"></i> Laporan Analisa Usia Hutang </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportfakturpajakmasukan/reportfakturpajakmasukan') ? 'active' : ''}}">
                                    <a href="{{ url('reportfakturpajakmasukan/reportfakturpajakmasukan')}}"><i class="fa fa-building" aria-hidden="true"></i> Register Faktur Pajak Masukan </a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('historisuangmukapembelian/historisuangmukapembelian') ? 'active' : ''}}">
                                    <a href="{{ url('historisuangmukapembelian/historisuangmukapembelian')}}"><i class="fa fa-building" aria-hidden="true"></i> Historis Uang Muka Pembelian </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Laporan pembelian -->

                        <!-- Laporan keuangan -->
                        <li class="">
                            <a href="#"> Keuangan <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">

                                <li class="sidebar master-perusahaan {{Request::is('reportmasteritem/reportmasteritem') ? 'active' : ''}}" >
                                    <a href={{url('reportmasteritem/reportmasteritem')}}><i class="fa fa-building" aria-hidden="true"></i> Arus Kas/Bank</a>
                                </li>

                                <li class="sidebar master-perusahaan {{Request::is('reportmastergroupitem/reportmastergroupitem') ? 'active' : ''}}">
                                    <a href="{{url('reportmastergroupitem/reportmastergroupitem')}}"><i class="fa fa-building" aria-hidden="true"></i> Buku Besar</a>
                                </li>
                                <li class="sidebar master-perusahaan  {{Request::is('master-keuangan/laporan-laba-rugi') ? 'active' : ''}} ">
                                    <a href="{{url('master-keuangan/laporan-laba-rugi')}}"><i class="fa fa-building" aria-hidden="true"></i> Laba Rugi</a>
                                </li>

                                <li class="sidebar master-perusahaan  {{Request::is('master-keuangan/laporan-neraca') ? 'active' : ''}}">
                                    <a href="{{url('master-keuangan/laporan-neraca')}}"> <i class="fa fa-building" aria-hidden="true"></i> Laporan Neraca </a>
                                </li>
			        <li class="sidebar master-perusahaan  {{Request::is('laporan-neraca/index') ? 'active' : ''}}">
                                    <a href="{{url('laporan-neraca/index')}}"> <i class="fa fa-building" aria-hidden="true"></i> Laporan Neraca1 </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Laporan keuangan -->
                    </ul>

                </li>

                
                
                
               

                
                
                
               



        </div>
    </nav>
