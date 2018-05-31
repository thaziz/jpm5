@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Master Department </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Laporan Purchase </a>
                        </li>
                        <li class="active">
                            <strong> Master Department </strong>
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
                    <h5> Laporan Master Department
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                 
                {{-- <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> JL. KARAH AGUNG NO 45 SURABAYA
                </h3> --}}
           
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" onclick="cetak()">
                      <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> 
                  </div>

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr >
                        <th align="center" rowspan="2">No.</th>
                        <th align="center" colspan="2">Supplier</th>
                        <th align="center" rowspan="2">Saldo Awal</th>
                        <th align="center" colspan="3">MUTASI KREDIT</th>
                        <th align="center" colspan="3">MUTASI DEBET</th>
                        <th align="center" rowspan="2">Saldo Akir.</th>
                        <th align="center" rowspan="2">Sisa Uang Muka.</th> 
                    </tr>
                    <tr>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Hutang Baru</th>
                      <th>Hutang Voucher</th>
                      <th>Nota Kredit</th>
                      <th>Bayar Cash</th>
                      <th>Byr Uang Muka</th>
                      <th>Cek/Bg/Trans</th>
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                     
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
   

</script>
@endsection
