@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  <style>
    body{
      overflow-y: scroll;
    }

    #table{
      width: 100%;
    }

    #table td{
      padding: 8px 20px;
    }

    #table_form{
      border:0px solid black;
      width: 100%;
    }

    #table_form input{
      padding-left: 5px;
    }

    #table_form td{
      padding: 10px 0px 0px 0px;
      vertical-align: top;
    }

    .error-badge{
      color:#ed5565;
      font-weight: 600;
    }

    .error-badge small{
      display: none;
    }

    #table_form .right_side{
      padding-left: 10px;
    }

    .modal-open{
      overflow: inherit;
    }
    .table_form>tbody>tr>td{
      border: 1px solid #ffffff !important;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
      padding: 4px;
    }
    
  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Master Transaksi</h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Master Transaksi  </strong>
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
                    <h5> Data Master Transaksi                     
                     </h5>
                    <div class="ibox-tools">
                        <button class="btn btn-sm btn-primary tambahAkun"  onclick="tambah()">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Master Transaksi
                        </button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body" style="min-height: 330px;">
                <div id="data-table"></div>

                  
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

<div id="modal_tambah_akun" class="modal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Form Tambah Master Transaksi</h4>
                        <input type="hidden" class="parrent"/>
                      </div>
                      <div class="modal-body">
                        <div id="form-master-transaksi">
                        </div>
                      </div>
                      

                    </div>
                  </div>
                </div>

 
@endsection



@section('extra_scripts')
<script type="text/javascript">
 
  $(document).ready(function(){
  
    $('[data-toggle="tooltip"]').tooltip()

    tableDetail = $('.tbl-penerimabarang').DataTable({
          responsive: true,
          searching: true,
          sorting: false,
          paging: false,
          //"pageLength": 10,
          "language": dataTableLanguage,
    });

    

 
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });



  });
  function tambah(){      
        $.ajax(baseUrl+"/master-transaksi/form", {
           timeout: 5000,
           type: "get",
           data: {status :'1',
                  _token: "{{ csrf_token() }}"},           
           success: function (data) {
            $('#form-master-transaksi').html(data);            
             $('#modal_tambah_akun').modal({
                backdrop: 'static',
                keyboard: false  // to prevent closing with Esc button (if you want this too)
            });
             $("#modal_tambah_akun").modal('show');              
             
           }
        })
      
    }

  

function simpanTable(){
  $.ajax(baseUrl+"/master-transaksi/save-data", {
           timeout: 5000,
           type: "get",
           data: $('.simpan-form-table :input').serialize(),
           dataType: "json",
           success: function (data) {
            

 if(data.status == "gagal"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;'+data.content+'!');
              }else if(data.status == "berhasil"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;'+data.content+'!');
                table();
              }



           }
        })
}

function updateTable(){
   $.ajax(baseUrl+"/master-transaksi/update-data", {
           timeout: 5000,
           type: "get",
           data: $('.simpan-form-table :input').serialize(),
           dataType: "json",
           success: function (data) {
             if(data.status == "gagal"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;'+data.content+'!');
              }else if(data.status == "berhasil"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;'+data.content+'!');
                table();
              }
              
           }
        })
}

function hapusTable($year,$code){    
   $.ajax(baseUrl+"/master-transaksi/hapus-data", {
           timeout: 5000,
           type: "get",
           data: {year:$year,
                  code:$code,
                  _token: "{{ csrf_token() }}"
                  },  
           dataType: "json",
           success: function (data) {
             if(data.status == "gagal"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;'+data.content+'!');
              }else if(data.status == "berhasil"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;'+data.content+'!');
                table();
              }
              
           }
        })
}




function Tutup(){
  $('#modal_tambah_akun').modal('hide');
}

function kota(){
  
    $.ajax(baseUrl+"/master-transaksi/set-kota/"+$('#id_provinsi').val(), {
           timeout: 5000,
           type: "get",           
           dataType: "json",
           success: function (data) {
              $('#select-kota').html(data);
           }
        })
}
table();
function table(){  
    $.ajax(baseUrl+"/master-transaksi/table", {
           timeout: 5000,
           type: "get",           
           
           success: function (data) {
            
              $('#data-table').html(data);
           }
        })
  }

</script>
@endsection