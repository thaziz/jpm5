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
  .hover{
    color: grey;
  }
  .hover:hover{
    color: red;
  }
  .dataTables_length{
    display: none;
  }
  .ui-autocomplete.ui-front{
  z-index: 99999999999999999 !important;
  }
</style>
<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Pending </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a> Pending</a>
          </li>
          <li class="active">
              <strong> Proccess</strong>
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
    <div class="ibox">
      <div class="ibox-title">
        <h5>Form Approve Pending Order</h5>
        <a href="../pending/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6">
          <table class="table table_header">
            {{ csrf_field() }}
            <tr>
              <td>No Transaksi</td>
              <td>
                <input readonly="" class="form-control" type="text" value="{{$header->fp_nofaktur}}" name="no_trans">
                <input readonly="" value="CREATE" class="form-control" type="hidden" name="tipe_data">
                <input readonly="" class="form-control" type="hidden" value="{{$header->bp_akun_agen}}" name="akun_agen">
                <input readonly="" value="" class="form-control id" type="hidden" name="id">
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td><input readonly="" class="form-control" type="text" value="<?php echo date('d/m/Y',strtotime($header->fp_tgl)) ?>" name="tN"></td>
            </tr>
            <tr>
              <td>Persentase saat ini</td>
              <td><input readonly="" class="form-control" type="text" value="{{$percent->komisi}}%"></td>
            </tr>
            <tr>
              <td colspan="2">
                <input  type="button" name="" onclick="approve_all()" value="Approve All" class="btn btn-primary approve_all">
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>  
    <!-- body -->
    <div class="ibox" style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Tabel Resi</h5>
      </div>
      <div class="ibox-content col-sm-12">
        <table class="table table_resi table-bordered table-striped">
          <thead>
            <th>No.Order</th>
            <th>Tanggal</th>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Status</th>
            <th>Tarif</th>
            <th>Explain</th>
            <th>Persentase </th>
            <th>Aksi</th>
          </thead>
          <tbody>
            @foreach($list as $i => $val)
            <tr>
              <td>
                {{$val->bpd_pod}}
                <input type="hidden" class="resi" name="resi" value="{{$val->bpd_pod}}">
                <input type="hidden" class="id_bpd " name="id_bpd" value="{{$val->bpd_bpid}}">
                <input type="hidden" class="bpd_id_table " value="{{$val->bpd_id}}">
                <input type="hidden" class="bpd_id" value="{{$val->bpd_id}}">
                <input type="hidden" class="akun_biaya" value="{{$val->bpd_akun_biaya}}">
                <input type="hidden" class="dt_bpd ke_{{$val->bpd_bpdetail}}" name="dt_bpd" value="{{$val->bpd_bpdetail}}">
              </td>
              <td>{{$val->bpd_tgl}}</td>
              <td>{{$val->asal}}</td>
              <td>{{$val->tujuan}}</td>
              <td>{{$val->status}}</td>
              <td>
                {{'Rp ' . number_format($val->bpd_tarif_resi,2,'.',',')}}
                <input type="hidden" class="tarif" name="tarif" value="{{$val->bpd_tarif_resi}}">
              </td>
              <td>
                {{'Rp ' . number_format($val->bpd_nominal,2,'.',',')}}
                <input type="hidden" class="nominal" name="nominal" value="{{$val->bpd_nominal}}">
              </td>
              <td align="center"><input type="text" style="text-align: center; width: 70px" class="form-control percent" value="{{$persen[$i]}}" readonly=""> %</td>
              <td width="80" align="center"><a class="fa fa-cog hover" onclick="approve(this)"> Approve</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- tabel data resi -->
  </div>
</div> 

<!-- Modal Approve All-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 60%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" align="center" id="exampleModalLabel">Approve All</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table tabel_keterangan">
         <tr>
            <td>Keterangan</td>
              <td>
                <textarea class="form-control keterangan" name="keterangan"></textarea>
              </td>
            </tr>
        </table>
      <table class="table table-bordered table-striped tabel2">
        <thead>
          <th>No.Order</th>
          <th>Tarif</th>
          <th>Biaya</th>
          <th>Persentase</th>
        </thead>
        <tbody>

          @foreach($list as $i => $val)

          <tr>
            <td>
              {{$val->nomor}}
              <input type="hidden" class="id_bpd" name="id_bpd[]" value="{{$val->bpd_bpid}}">
              <input type="hidden" class="dt_bpd" name="dt_bpd[]" value="{{$val->bpd_bpdetail}}">
              <input type="hidden" class="bpd_id" name="bpd_id[]" value="{{$val->bpd_id}}">
              <input type="hidden" class="bpd_akun_biaya_all" name="bpd_akun_biaya_all[]" value="{{$val->bpd_akun_biaya}}">
            </td>
            <td>{{'Rp ' . number_format($val->bpd_tarif_resi,2,'.',',')}}</td>
            <td>{{'Rp ' . number_format($val->bpd_nominal,2,'.',',')}}</td>
            <td align="center"><input type="text" style="text-align: center; width: 70px" class="form-control" value="{{$persen[$i]}}" readonly=""> %</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary approving_all" onclick="save_all()" data-dismiss="modal">Approve</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Approve-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 40%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" align="center" id="exampleModalLabel">Approving</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <table class="table satuan">
            {{ csrf_field() }}
            <tr>
              <td>No Transaksi</td>
              <td>
                <input readonly="" class="form-control no_resi" type="text" readonly="" value="" name="no_resi">
                <input type="hidden" class="id_bpd_modal" name="id_bpd_modal" value="">
                <input type="hidden" class="dt_bpd_modal" name="dt_bpd_modal" value="">
                <input type="hidden" class="bpd_id_modal" name="bpd_id_modal" value="">
                <input type="hidden" class="bpd_akun_biaya_modal" name="bpd_akun_biaya_modal" value="">
              </td>
            </tr>
            <tr>
              <td>Tarif</td>
              <td>
                <input readonly="" class="form-control Tarif" type="text" readonly="" value="" name="no_resi">
              </td>
            </tr>
            <tr>
              <td>Biaya</td>
              <td>
                <input readonly="" class="form-control Biaya" type="text" readonly="" value="" name="Biaya">
              </td>
            </tr>
            <tr>
              <td>Persentase</td>
              <td class="form-inline ">
                <div class="input-group">
                <input readonly="" style="width: 80%" class="form-control Persentase" type="text" readonly="" value="" name="Persentase">
                <span class="input-group-addon fa fa-percent" style="padding-bottom: 12px;"></span>
              </div>
              </td>
            </tr>
            <tr>
              <td>Keterangan</td>
              <td>
                <textarea class="form-control keterangan" name="keterangan"></textarea>
              </td>
            </tr>
          </table>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary approving" data-dismiss="modal" onclick="saving()">Approve</button>
      </div>
    </div>
  </div>
</div>




<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')


<script type="text/javascript">
  var datatable = $('.table_resi').DataTable();
  var datatable1 = $('.tabel2').DataTable({
                    'searching':false
                    });

   function autoNote(){

    var note = $('.note').val();
    $( ".note" ).autocomplete({
      source:baseUrl + '/fakturpembelian/cariNote', 
      minLength: 3,
    });

   }
   function approve_all(){
    $('#myModal').modal('show');
   }
   function approve(p){
    
    var parent                  = p.parentNode.parentNode;
    var resi                    = $(parent).find('.resi').val();
    var tarif                   = $(parent).find('.tarif').val();
    var id                      = $(parent).find('.id_bpd').val();
    var dt                      = $(parent).find('.dt_bpd').val();
    var bpd_id                  = $(parent).find('.bpd_id_table').val();
    var nominal                 = $(parent).find('.nominal').val();
    var persen                  = $(parent).find('.percent').val();
    var bpd_akun_biaya_modal    = $(parent).find('.akun_biaya').val();
    nominal = accounting.formatMoney(nominal, "Rp ", 2, ".",',');
    tarif = accounting.formatMoney(tarif, "Rp ", 2, ".",',');
    $('.no_resi').val(resi);
    $('.id_bpd_modal').val(id);
    $('.dt_bpd_modal').val(dt);
    $('.bpd_id_modal').val(bpd_id);
    $('.bpd_akun_biaya_modal').val(bpd_akun_biaya_modal);
    $('.Tarif').val(tarif);
    $('.Biaya').val(nominal);
    $('.Persentase').val(persen);

    $('#myModal1').modal('show');

   }
   function saving(){
    var dt      = $('.dt_bpd_modal').val();
    var par     = $('.ke_'+dt).parents('tr');
    // console.log(par);
    swal({
    title: "Apakah anda yakin?",
    text: "Update Data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Update!",
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
      url:baseUrl + '/pending/save',
      type:'post',
      data:'status=2'+'&'+$('.satuan :input').serialize(),
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                });
        datatable.row(par).remove().draw(false)
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

 function save_all(){
    swal({
    title: "Apakah anda yakin?",
    text: "Update Data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Update!",
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
      url:baseUrl + '/pending/save',
      type:'post',
      data:'status=1'+'&'+datatable1.$('input').serialize()+'&'+$('.tabel_keterangan :input').serialize(),
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil diupdate",
                timer: 900,
               showConfirmButton: true
                },function(){
                  // location.href = '../pending/index'
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

</script>
@endsection
