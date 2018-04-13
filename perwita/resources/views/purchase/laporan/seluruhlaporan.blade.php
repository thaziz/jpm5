@extends('main')

@section('title', 'dashboard')

@section('content')

	<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> LAPORAN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                     
                        <li class="active">
                            <strong>  Laporan </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                    
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                <div class="box-body">
                	<label>Pilih Laporan : </label>
                          <select class="form-control" onchange="location = this.value;">
                 	          <option selected="" disabled="">Pilih terlebih dahulu</option>
                            <option value="{{ url('/masteritem/masteritem/masteritem') }}" >Laporan Data Master Item</option>
                            {{-- <option value="{{ url('/reportmasterdepartment/reportmasterdepartment') }}">Laporan Data Department</option> --}}
                            <option value="{{ url('/mastergudang/mastergudang/mastergudang') }}" >Laporan Data Master Gudang</option>
                            <option value="{{ url('/mastersupplier/mastersupplier/mastersupplier') }}" >Laporan Data Supplier</option>
                            <option value="{{ url('/spp/spp/spp') }}">Laporan Data Surat Permintaan Pembelian</option>
                            <option value="{{ url('/masterpo/masterpo/masterpo') }}">Laporan Data Order</option>
                            <option value="{{ url('/masterfakturpembelian/masterfakturpembelian/masterfakturpembelian') }}">Laporan Data Faktur Pembelian</option>
                            <option value="{{ url('/buktikaskeluar/patty_cash') }}">Laporan Data Patty Cash</option>
                            <option value="{{ url('/masterkaskeluar/masterkaskeluar/masterkaskeluar') }}">Laporan Data Pelunasan Hutang/Bayar Kas</option>
                            <option value="{{ url('/masterbayarbank/masterbayarbank/masterbayarbank') }}">Laporan Data Pelunasan Hutang/Bayar Bank</option>
                            <option value="{{ url('/lap_ttt/lap_ttt') }}" >Laporan Data Tanda Terima Tagihan</option>
                           </select>
                 	{{-- <option value="/jpm/reportbayarbank/reportbayarbank">Laporan Data Kartu Hutang</option>
                 	<option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Mutasi Hutang</option>
                 	<option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Historis Faktur vs Pelunasan</option>
                 	<option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Analisa Usia Hutang</option>
                 	<option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Faktur Pajak Masukan</option>
                 	<option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Historis Uang Muka Pembelian</option> --}}
                 </select>
                </div><!-- /.box-body -->

                <div class="box-footer">
                  <div class="pull-right">
            
                                     
                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


	

@endsection

