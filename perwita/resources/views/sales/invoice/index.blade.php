

@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .center { text-align: center; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> INVOICE </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                            <a>Penjualan</a>
                        </li>
                        <li>
                            <a>Transaksi Penjualan</a>
                        </li>
                        <li class="active">
                            <strong> INVOICE </strong>
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
                    <h5 style="margin : 8px 5px 0 0"> 
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">

                    <table style="font-size: 12px" id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Cabang </th>
                                <th>Customer</th>
                                <th>JT</th>
                                <th>Tagihan </th>
                                <th>Sisa Tagihan </th>
                                <th>Keterangan </th>
                                <th>No Faktur Pajak </th>
                                <th>Status Print</th>
                                <th style="width:10%"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">





                    </div>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal_jurnal fade" id="modal_pajak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Faktur Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <table class="table table_pajak">
              <tr>
                  <td>Nomor Pajak</td>
                  <td>
                    <input type="text" class="form-control" name="nomor_pajak">
                    <input type="hidden" class="form-control invoice" name="invoice">
                </td>
              </tr>
              <tr>
                <td>PDF (max 1MB)</td>
                <td>
                  <div class="file-upload">
                    <div class="file-select">
                      <div class="file-select-name" id="noFile">Choose Image...</div> 
                      <input type="file" name="image" onchange="loadFile(event)" id="chooseFile">
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Preview</td>
                <td align="left">
                  <div class="preview_td">
                      <img style="width: 150px;height: 200px;border:1px solid pink" id="output" >
                  </div>
                </td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary save_pajak" data-dismiss="modal">Save Pajak</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
    $(document).ready( function () {

         $('#tabel_data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_invoice1") }}',
            },
            columnDefs: [
              {
                 targets: 5,
                 className: 'cssright'
              },
              {
                 targets: 6,
                 className: 'cssright'
              },
              {
                 targets:7,
                 className: 'center'
              },
              {
                 targets:10,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "i_nomor" },
            { "data": "i_tanggal" },
            { "data": "cabang" },
            { "data": "customer"},
            { "data": "i_jatuh_tempo" },
            { "data": "tagihan" },
            { "data": "sisa"},
            { "data": "i_keterangan" },
            { "data": "faktur_pajak" },
            { "data": "status" },
            { "data": "aksi" },
            
            ]
      });
      $.fn.dataTable.ext.errMode = 'throw';
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/invoice_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function edit(id){
        var id = id.replace(/\//g, "-");
        window.location.href = baseUrl + '/sales/edit_invoice/'+id;
    }
    function lihat(id){
        var id = id.replace(/\//g, "-");
        window.open(baseUrl + '/sales/lihat_invoice/'+id);
    }


    function ngeprint(id){
        var id = id.replace(/\//g, "-");
        var w = window.open(baseUrl+'/sales/cetak_nota/'+id);
        // var interval = setInterval(function(){ 
        $(w).ready(function(){
          var table = $('#tabel_data').DataTable();
          table.ajax.reload(); 
        })
        
        // }, 5000);
        // clearInterval(interval);
    }

    function hapus(id){
        swal({
        title: "Apakah anda yakin?",
        text: "Hapus Data!",
        type: "warning",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
    },

    function(){

         $.ajax({
          url:baseUrl + '/sales/hapus_invoice',
          data:{id},
          type:'get',
          success:function(data){
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                         var table = $('#tabel_data').DataTable();
                         table.ajax.reload();
              });
          },
          error:function(data){

            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false
        });
       }
      });
    });
}

function faktur_pajak(nomor) {
    $('.invoice').val(nomor);
    $('#modal_pajak').modal('show');
}



$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>1048576) //do something if file size more than 1 mb (1048576)
  {
      return false;
  }
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen..."); 
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
  }
});

var loadFile = function(event) {
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>1048576) //do something if file size more than 1 mb (1048576)
  {
      iziToast.warning({
        icon: 'fa fa-times',
        message: 'File Is To Big!',
      });
      return false;
  }
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('output');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};

$('.save_pajak').click(function(){


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formdata = new FormData();  
    formdata.append( 'files', $('#chooseFile')[0].files[0]);
       console.log(formdata);
    $.ajax({
          url:baseUrl + '/sales/pajak_invoice'+'?'+$('.table_pajak :input').serialize(),
          data:formdata,
          type:'POST',
          dataType:'json',
          processData: false,
          contentType: false,
          success:function(data){
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                        $('.invoice').val('');
                         
              });
          },
          error:function(data){

            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false
        });
       }
    });
})
</script>
@endsection
