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
                            <option value="{{ url('/lapagen/lapagen') }}"> LAPORAN AGEN </option>
                            <option value="{{ url('/lapbiaya/labiaya') }}"> LAPORAN BIAYA</option>
                            <option value="{{ url('/lapdiskon/lapdiskon') }}"> LAPORAN DISKON </option>
                            <option value="{{ url('/lapdiskonpenjualan/lapdiskonpenjualan') }}"> LAPORAN DISKON PENJUALAN </option>
                            <option value="{{ url('/lapgrupcustomer/lapgrupcustomer') }}"> LAPORAN GRUP CUSTOMER </option>
                            <option value="{{ url('/lapgrupitem/lapgrupitem') }}"> LAPORAN GRUP ITEM </option>
                            <option value="{{ url('/lapitem/lapitem') }}"> LAPORAN ITEM </option>
                            <option value="{{ url('/lapnoseripajak/lapnoseripajak') }}"> LAPORAN NO SERI PAJAK </option>
                            <option value="{{ url('/laprute/laprute') }}"> LAPORAN RUTE </option>
                            <option value="{{ url('/lasaldoawalpiutang/lasaldoawalpiutang') }}"> LAPORAN SALDO AWAL PIUTANG LAIN </option>
                            <option value="{{ url('/lasaldopiutang/lasaldopiutang') }}"> LAPORAN SALDO PIUTANG </option>
                            <option value="{{ url('/lapsatuan/lapsatuan') }}"> LAPORAN SATUAN </option>
                            <option value="{{ url('/lapsubcon/lapsubcon') }}"> LAPORAN SUBCON </option>
                            <option value="{{ url('/lapvendor/lapvendor') }}"> LAPORAN VENDOR </option>
                            <option value="{{ url('/lapzona/lapzona') }}"> LAPORAN ZONA </option>
                           </select>
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

