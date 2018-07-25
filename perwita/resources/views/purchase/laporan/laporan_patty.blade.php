  @extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .table-biaya{
    overflow-x: auto;
  }
  tbody tr{
    cursor: pointer;
  }
  th{
    text-align: center !important;
  }
  .tengah{
    text-align: center;
  }
  .kecil{
    width: 50px;
    
  }
  .datatable tbody tr td{
    padding-top: 16px;
  }
  .dataTables_paginate{
    float: right;
  }
  #modal-biaya .modal-dialog .modal-body{
    min-height: 340px;
  }
  .disabled {
    pointer-events: none;
    opacity: 0.4;
  }
  .search{
    margin-left: 5px;
  }
  h3{
    margin: 20px 5px;

  }
  .my-bg{
    background: #f0b7d6;
  }
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Laporan Petty Cash </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Laporan</a>
          </li>
          <li>
            <a> Pembelian</a>
          </li>
          <li class="active">
              <strong>Laporan Petty Cash</strong>
          </li>
      </ol>
  </div>
 </div>
<div hidden="" class="alert-class alert-info row wrapper border-bottom my-bg page-heading " style="margin-top: 10px; padding: 0 0;">
<h3 class="pending" style="padding: 10px 0 margin:0px 0px !important;"></h3>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- HEADER -->
    <div class="ibox">&nbsp;
      <div class="ibox-title">
        <h5>Laporan Petty Cash</h5>
        <a href="../buktikaskeluar/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">

        <div class="col-sm-12">
          <table class="table table_header table-striped">
            {{ csrf_field() }}
            <tr>
              <td>Tanggal</td>
              <td>
                <input  class="form-control reportrange" type="text" value="{{$start}} - {{$second}}" name="rangepicker"  >
              </td>
            </tr>
            <tr>
              <td>Jenis Bayar</td>
              <td>
                  <select class="jenisbayar form-control" name="jenisbayar" style="width: 100% ; display: inline-block;">
                    {{-- <option value="">Pilih Bayar</option> --}}
                    @foreach($jenisbayar as $val)
                    <option value="{{$val->idjenisbayar}}">{{$val->idjenisbayar}} - {{$val->jenisbayar}}</option>
                    @endforeach
                  </select>                        
              </td>
            </tr>
            <tr>
              <td>Akun Kas</td>
              <td>
                  <select class="akun_kas form-control" name="akun_kas" style="width: 100% ; display: inline-block;">
                    {{-- <option value=""> pilih Akun Kas</option> --}}
                    @foreach($akun_kas as $val)
                    <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                    @endforeach
                  </select>                           
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button type="button" class="btn btn-primary" onclick="cari_patty()"><i class="fa fa-search">&nbsp;Search</i></button>                         
              </td>
            </tr>

            <hr>
          </table>
        </div>
      </div>
    </div>  
    <!-- body Patty Cash-->
<div class="ibox patty_cash" hidden="" style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Detail Petty Cash</h5>
      </div>
  <div class=" ibox-content col-sm-12 tb_sb_hidden tabel_patty" >
  
  </div>
</div>
<!-- End Body Patty Cash -->
    <!-- tabel data resi -->
  </div>
</div> 
@endsection



@section('extra_scripts')

<script type="text/javascript">
// patty cash
function starto(){
  $.ajax({
    url:baseUrl +'/buktikaskeluar/cari_patty',
    success:function(response){
      $('.tabel_patty').html(response);
      $('.patty_cash').attr('hidden',false);

    }
  });
}
starto();
$('.reportrange').daterangepicker({
          "autoApply": true,
          "opens": "right",
          locale: {
          format: 'DD/MM/YYYY'
      }         
});
// $('.reportrange').daterangepicker({
//     "autoApply": true,
// }, function(start, end, label) {
//   console.log('New date range selected: ' + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY') + ' (predefined range: ' + label + ')');
// });

function cari_patty(){
  $.ajax({
    url:baseUrl +'/buktikaskeluar/cari_patty',
    data:$('.table_header :input').serialize(),
    success:function(response){
      if (response.status == 2) {
        toastr.warning('Harap isi dengan benar')
        return 1;
      }
      $('.tabel_patty').html(response);
      $('.patty_cash').attr('hidden',false);

    }
  });
}
</script>
@endsection
