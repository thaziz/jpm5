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
                            <option value="{{ url('/lappajak/lappajak') }}"> LAPORAN MASTER PAJAK </option>
                            <option value="{{ url('/lapprovinsi/lapprovinsi') }}"> LAPORAN MASTER PROVINSI</option>
                            <option value="{{ url('/lapkota/lapkota') }}"> LAPORAN MASTER KOTA </option>
                            <option value="{{ url('/lapkecamatan/lapkecamatan') }}"> LAPORAN MASTER KECAMATAN </option>
                            <option value="{{ url('/lapcabang/lapcabang') }}"> LAPORAN MASTER CABANG </option>
                            <option value="{{ url('/laptipeangkutan/laptipeangkutan') }}"> LAPORAN MASTER TIPE ANGKUTAN </option>
                            <option value="{{ url('/lapkendaraan/lakendaraan') }}"> LAPORAN MASTER KENDARAAN </option>
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

