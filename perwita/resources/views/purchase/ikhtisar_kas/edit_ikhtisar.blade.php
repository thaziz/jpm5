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
</style>
<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Ikhtisar kas </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Pembelian</a>
          </li>
          <li>
              <a>Transaksi Kas</a>
          </li>
          <li class="active">
              <strong>Ikhtisar Kas</strong>
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
        <h5>Laporan Patty Cash</h5>
        <a href="../buktikaskeluar/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6">
          <table class="table table_header ">
            {{ csrf_field() }}
            <tr>
              <td>Nomor Ikhtisar</td>
              <td>
                <input  class="form-control nomor_ik" type="text" value="{{$data->ik_nota}}" name="ik" readonly=""  >
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td>
                <input  class="form-control" readonly="" type="text" value="{{$end}}" name="rangepicker"  >
              </td>
            </tr>
            <tr>
              <td>Status</td>
              <td>
                <input  class="form-control status" type="text" readonly="" value="Released"  >
              </td>
            </tr>
            <tr>
              <td>Cabang</td>
              <td>
                <input readonly=""  class="form-control cabang" type="text" value="{{$data->nama}}"  >  
                <input  class="form-control cabang" type="hidden" value="{{$data->kode}}"  >         

              </td>
            </tr>
            <tr>
              <td>Keterangan</td>
              <td>
                  <input type="text" name="Keterangan" class="form-control" value="{{$data->ik_keterangan}}">                         
              </td>
            </tr>
            <tr>
              <td>Approved</td>
              <td align="left">
                @if($data->ik_status == 'APPROVED')
                  <input name="checked" class="" type="checkbox" checked="">
                  @else
                  <input name="checked" class="" type="checkbox">
                @endif
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button type="button" class="btn btn-primary" onclick="simpan()"><i class="fa fa-save">&nbsp;Update</i></button>           
              </td>
            </tr>
            <hr>
          </table>
        </div>
      </div>
    </div>  
    <!-- body Patty Cash-->
<div class="ibox patty_cash"  style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Detail Patty Cash</h5>
      </div>
  <div class=" ibox-content col-sm-12 tb_sb_hidden tabel_patty" >
    <h3>Tabel Detail Patty Cash</h3>
  <hr>
      <table class="table table-bordered table-hover tabel_patty_cash">
          <thead align="center">
            <tr>
            <th>Pilih</th>
            <th>Tanggal</th>
            <th>No Ref</th>
            <th>Akun Biaya</th>
            <th>Nominal</th>
            <th>Keterangan</th>
            <th>User ID</th>
            </tr>
          </thead> 
          <tbody class="">
            @foreach($data_dt as $val)
            <tr>
              <td align="center">
                <input type="checkbox" name="checker[]" class="ck" checked="" >
                <input type="hidden" name="id_pc[]" class="id_table" value="{{$val->pc_id}}">
                <input type="hidden" name="id_ikd[]" class="id_table" value="{{$val->ikd_ik_dt}}">
                <input type="hidden" name="id_ik[]" class="id_table" value="{{$val->ikd_ik_id}}">
              </td>
              <td><?php echo date('d/m/Y',strtotime($val->pc_tgl));?></td>
              <td>{{$val->pc_no_trans}}</td>
              <td>{{$val->pc_akun}}</td>
   
              <td>{{$val->pc_kredit}}</td>
            
              <td>{{$val->pc_keterangan}}</td>
              <td>{{$val->pc_user}}</td>
            </tr>
            @endforeach
          </tbody>    
      </table>
  </div>
</div>
<!-- End Body Patty Cash -->
    <!-- tabel data resi -->
  </div>
</div> 
@endsection



@section('extra_scripts')


<script type="text/javascript">
$('.reportrange').daterangepicker({
          autoclose: true,
          "opens": "left",
          locale: {
          format: 'DD/MM/YYYY'
      }         
});


var tabel_patty = $('.tabel_patty_cash').DataTable({
    'searching':false
  })


function simpan(){
    $.ajax({
    url:baseUrl +'/ikhtisar_kas/update',
    data:$('.table_header :input').serialize()+'&'+tabel_patty.$('input').serialize(),
    success:function(response){
      if (response.status == 2) {
        toastr.warning('Harap isi dengan benar')
        return 1;
      }
      // $('.tabel_patty').html(response);
      // $('.patty_cash').attr('hidden',false);

    }
  });
}

function simpan(){


  swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Ikhtisar!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
         url:baseUrl +'/ikhtisar_kas/update',
         data:$('.table_header :input').serialize()+'&'+tabel_patty.$('input').serialize(),
         type:'get',
      success:function(response){
  
          swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       location.href='../index';
            });

            

      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 900,
               showConfirmButton: true

    });
   }
  });  
 });
}


$.fn.serializeArray = function () {
    var rselectTextarea= /^(?:select|textarea)/i;
    var rinput = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i;
    var rCRLF = /\r?\n/g;
    
    return this.map(function () {
        return this.elements ? jQuery.makeArray(this.elements) : this;
    }).filter(function () {
        return this.name && !this.disabled && (this.checked || rselectTextarea.test(this.nodeName) || rinput.test(this.type) || this.type == "checkbox");
    }).map(function (i, elem) {
        var val = jQuery(this).val();
        if (this.type == 'checkbox' && this.checked === false) {
            val = 'off';
        }
        return val == null ? null : jQuery.isArray(val) ? jQuery.map(val, function (val, i) {
            return {
                name: elem.name,
                value: val.replace(rCRLF, "\r\n")
            };
        }) : {
            name: elem.name,
            value: val.replace(rCRLF, "\r\n")
        };
    }).get();
}
</script>
@endsection
