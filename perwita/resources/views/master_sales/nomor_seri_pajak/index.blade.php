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
                        <tr>No</tr>
                        <tr>Tanggal</tr>
                        <tr>Nomor Pajak</tr>
                        <tr>Download PDF</tr>
                        <tr>Aktif</tr>
                        <tr>Aksi</tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
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
                          <table class="table table_pajak">
                              <tr>
                                  <td>Nomor Pajak</td>
                                  <td>
                                    <input type="text" class="form-control nomor_pajak" name="nomor_pajak">
                                    <input type="hidden" class="form-control invoice" name="invoice">
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
                              <tr>
                                <td align="right" colspan="2"><button type="button" class="simpan_pdf btn btn-primary">Download PDF</button></td>
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



<div class="row" style="padding-bottom: 50px;"></div>


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
            { "data": "aksi" },
            ]
        })

    })
    $(document).on("click","#btn_add",function(){
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

</script>
@endsection
