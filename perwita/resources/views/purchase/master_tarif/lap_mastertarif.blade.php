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
                        <option value="{{ url('/laporan_master_penjualan/tarif_cabang_dokumen') }}"> LAPORAN CABANG DOKUMEN </option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_cabang_koli') }}"> LAPORAN CABANG KOLI</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_cabang_kargo') }}"> LAPORAN CABANG KARGO</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_cabang_kilogram') }}"> LAPORAN CABANG KILOGRAM</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_cabang_sepeda') }}"> LAPORAN CABANG SEPEDA</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_penerus_dokumen') }}"> LAPORAN PENERUS DOKUMEN</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_penerus_koli') }}"> LAPORAN PENERUS KOLI</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_penerus_default') }}"> LAPORAN PENERUS DEFAULT</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_penerus_kilogram') }}"> LAPORAN PENERUS KILOGRAM</option>
                        <option value="{{ url('/laporan_master_penjualan/tarif_penerus_sepeda') }}"> LAPORAN PENERUS SEPEDA </option>
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

