@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
    .cssright { text-align: right; }
    .center { text-align: center; }
    .borderless td, .borderless th {
    border: none;
}
/****** IGNORE ******/





/****** CODE ******/

.file-upload{display:block;text-align:center;font-family: Helvetica, Arial, sans-serif;font-size: 12px;}
.file-upload .file-select{display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
.file-upload .file-select .file-select-button{background:#dce4ec;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
.file-upload .file-select .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
.file-upload .file-select:hover{border-color:#34495e;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload .file-select:hover .file-select-button{background:#34495e;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload.active .file-select{border-color:#3fa46a;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload.active .file-select .file-select-button{background:#3fa46a;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload .file-select input[type=file]{z-index:100;cursor:pointer;position:absolute;height:100%;width:100%;top:0;left:0;opacity:0;filter:alpha(opacity=0);}
.file-upload .file-select.file-select-disabled{opacity:0.65;}
.file-upload .file-select.file-select-disabled:hover{cursor:default;display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;margin-top:5px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
.file-upload .file-select.file-select-disabled:hover .file-select-button{background:#dce4ec;color:#666666;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
.file-upload .file-select.file-select-disabled:hover .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> NOMOR SERI PAJAK </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master Penjualan</a>
                        </li>
                        <li>
                          <a> Master DO</a>
                        </li>
                        <li class="active">
                            <strong> Nomor Seri Pajak </strong>
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
                    <h5> NOMOR SERI PAJAK
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table  class="table table_pajak table-bordered table-striped">
                    <thead>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nomor Pajak</th>
                        <th>Download PDF</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
             
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Faktur Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <table class="table table_input">
              <tr>
                  <td>Nomor Pajak</td>
                  <td>
                    <input type="text" class="form-control nomor_pajak" name="nomor_pajak">
                    <input type="hidden" class="form-control id_old" name="id_old">
                </td>
              </tr>
              <tr>
                  <td>Tanggal Pajak</td>
                  <td>
                    <input type="text" placeholder="dd/mm/yyyy" class="form-control tanggal" name="tanggal">
                </td>
              </tr>
              <tr>
                <td>PDF (max 1MB)</td>
                <td>
                  <div class="file-upload">
                    <div class="file-select">
                      <div class="file-select-name" id="noFile">Choose PDF...</div> 
                      <input type="file" name="image" onchange="loadFile(event)" id="chooseFile">
                    </div>
                  </div>
                </td>
              </tr>
              <tr hidden="">
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
        <button type="button" class="btn btn-primary save_pajak">Save Pajak</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection



@section('extra_scripts')
<script src="{{ asset('assets/vendors/mask_plugin/dist/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.nomor_pajak').mask("000.000-00.00000000", {placeholder: "___.___-__.________"});

    $('.table_pajak').DataTable({
        processing: true,
        // responsive:true,
        serverSide: true,
        ajax: {
            url:'{{ route("datatable_nomor_seri_pajak") }}',

        },
        columnDefs: [
          {
             targets: 0,
             className: 'center'
          },
          {
             targets: 3,
             className: 'center'
          },
          {
             targets: 4,
             className: 'center'
          },
          {
             targets: 5,
             className: 'center'
          },
        ],
        "columns": [
        { "data": 'DT_Row_Index'},
        { "data": "nsp_tanggal" },
        { "data": "nsp_nomor_pajak" },
        { "data": "download"},
        { "data": "aktif" },
        { "data": "aksi" },
        ]
    });

    $('.tanggal').datepicker({format:'dd/mm/yyyy'});
})

$(document).on("click","#btn_add",function(){
    $('.table_input :input').val('');
    $('.file-upload').removeClass('active');
    $('#noFile').text('Choose PDF..');
    $("#modal").modal("show");
});

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
    if ($('.nomor_pajak').val() == '') {
        toastr.warning('Nomor Pajak Harus Diisi');
        return false;
    }

    if ($('.tanggal').val() == '') {
        toastr.warning('Tanggal pajak harus diisi');
        return false;
    }
    if ($('.id_old').val() == '') {
        if ($('#chooseFile').val() == '') {
            toastr.warning('Harap mengupload bukti pajak');
            return false;
        }
    }
    
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formdata = new FormData();  
    formdata.append( 'files', $('#chooseFile')[0].files[0]);
    $.ajax({
          url:baseUrl + '/master_sales/save_pajak_invoice'+'?'+$('.table_input :input').serialize(),
          data:formdata,
          type:'POST',
          dataType:'json',
          processData: false,
          contentType: false,
          success:function(data){
            $('.table_input :input').val('');
            $('.file-upload').removeClass('active');
            $('#noFile').text('Choose PDF..');
            var table = $('.table_pajak').DataTable();
            table.ajax.reload();
            $("#modal").modal("hide");
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
          url:baseUrl + '/master_sales/hapus_faktur_pajak',
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
               
                        var table = $('.table_pajak').DataTable();
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
function edit(id) {
    $.ajax({
          url:baseUrl + '/master_sales/cari_id_pajak',
          data:{id},
          type:'get',
          dataType:'json',
          success:function(data){
            $('.nomor_pajak').val(data.data.nsp_nomor_pajak);
            $('.id_old').val(id);
            $('.tanggal').val(data.tanggal);
            $('.file-upload').addClass('active');
            $('#noFile').text(data.data.nsp_pdf);
            $("#modal").modal("show");
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
}


function download_pdf(nomor) {
    $.ajax({
          url:baseUrl + '/master_sales/cari_faktur_pajak',
          data:{nomor},
          type:'get',
          dataType:'json',
          success:function(data){
            if (data.data.nsp_pdf !=null) {
               window.open('{{asset('perwita/storage/app')}}'+'/'+data.data.nsp_pdf);
            }
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
}

function cek(id,tes) {
    var check = $(tes).is(':checked');

    $.ajax({
          url:baseUrl + '/master_sales/cek_nomor_pajak',
          data:{id,check},
          type:'get',
          dataType:'json',
          success:function(data){
            
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
}

</script>
@endsection
