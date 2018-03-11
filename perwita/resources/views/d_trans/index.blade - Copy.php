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
                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
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
                        <table class="table table_form simpan-form-table" id="tambah-master">
                          <td width="30%">Nama Transaksi</td>
                          <td width="70%"><input type="text" name="nama_transaksi" class="form-control input-sm"></td>
                          <tr>
                            <td>Provinsi</td>
                            <td>
                              <select class="form-control" id="id_provinsi" name="provinsi" onclick="kota()">
                                <option  value="Null" hidden="" selected>Pilih Provinsi</option>                                
                                <option>-</option>
                                @foreach($provinsi as $data)
                                  <option value="{{$data->id}}">{{$data->nama}}</option>
                                @endforeach
                              </select>                              
                            </td>
                          </tr>
                          <tr>
                            <td>Kota</td>
                            <td id="select-kota">
                              <select class="form-control" name="kota">
                                <option value="Null" hidden="" selected>-- Pilih Kota --</option>   
                                <option>-</option>                             
                              </select>                              
                            </td>
                          </tr>
                          <tr>
                            <td>Transaksi Untuk</td>
                            <td>
                              <select class="form-control" name="transaksi">
                                <option value="" hidden="" selected>-- Pilih Transaksi --</option>
                                <option>Penjualan</option>
                                <option>Pembelian</option>
                              </select>                              
                            </td>
                          </tr>
                         
                          
                        </table>

                        <strong>Akun Debet</strong> 
                            <button class="btn btn-primary btn-xs" onclick="akunDebet()">
                            <i class="fa fa-plus"></i>
                            </button>
                        <table class="table simpan-form-table" id="table-debet">
                          <tr>
                          </tr>
                          <tr class="debet-0">
                            <td width="30%">Pilih Akun</td>
                            <td width="70%">                            
                              <select class="form-control" name="akun_debet[]">
                                <option value="" hidden="" selected>-- Pilih Akun Debet --</option>
                                @foreach($akun as $data)
                                <option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>
                                @endforeach
                              </select>                  
                            </td>  
                            <td>                              
                              <div style="margin-top: 8%">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger" data-original-title="Hapus Akun" onclick="hapusDebet('0')"><i class="fa fa-minus"></i></button>
                              </div>
                            </td>                     
                          </tr>                                                   
                        </table>
                           
                          
                          <strong>Akun Kredit</strong> 
                          <button class="btn btn-primary btn-xs" onclick="akunKredit()">
                            <i class="fa fa-plus"></i>
                          </button>

                          <table  class="table simpan-form-table" id="table-kredit">  
                          <tr>                              
                          </tr>                                                                           
                           <tr class="kredit-0">
                            <td width="30%">Pilih Akun</td>
                            <td width="70%">                            
                              <select class="form-control" name="akun_kredit[]">
                                <option value="" hidden="" selected>-- Pilih Akun Kredit --</option>
                                @foreach($akun as $data)
                                <option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>
                                @endforeach
                              </select>                  
                            </td>  
                            <td>                              
                              <div style="margin-top: 8%">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger" data-original-title="Hapus Akun" onclick="hapusKredit('0')"><i class="fa fa-minus"></i></button>
                              </div>
                            </td>                     
                          </tr>  

                        </table>
                      </div>
                      <div class="modal-footer">
        <input type="submit" class="btn btn-sm btn-primary pull-right" id="btn_simpan" value="Simpan Data" onclick="simpanTable()">
                      </div>

                    </div>
                  </div>
                </div>

 
@endsection



@section('extra_scripts')
<script type="text/javascript">
var row_index_debet=1;
var row_index_kredit=1;
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

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      
    })

 
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });



  })

  function akunDebet(){
     row_index_debet;
$html='<tr class="debet-'+row_index_debet+'">'+
        '<td width="30%">Pilih Akun</td>'+
        '<td width="70%">'+        
        '<select class="form-control" name="akun_debet[]">'+
        '<option value="" hidden="" selected>-- Pilih Akun Debet --</option>'+
                                @foreach($akun as $data)
                                '<option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>'+
                                @endforeach
                              '</select>'+
        '</td>'+
        '<td>'+
        '<div style="margin-top: 8%">'+
        '<button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger"'+
        'data-original-title="Hapus Akun" onclick="hapusDebet('+row_index_debet+')"><i class="fa fa-minus"></i></button>'+
        '</div>'+
        '</td>'+
        '</tr>';
        $('#table-debet tr:last').after($html);
        row_index_debet++;
}

function akunKredit(){
     row_index_kredit;
$html='<tr class="kredit-'+row_index_kredit+'">'+
        '<td width="30%">Pilih Akun</td>'+
        '<td width="70%">'+        
        '<select class="form-control" name="akun_kredit[]">'+
        '<option value="" hidden="" selected>-- Pilih Akun Kredit --</option>'+
                                @foreach($akun as $data)
                                '<option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>'+
                                @endforeach
                              '</select>'+
        '</td>'+
        '<td>'+
        '<div style="margin-top: 8%">'+
        '<button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger"'+
        'data-original-title="Hapus Akun" onclick="hapusKredit('+row_index_kredit+')"><i class="fa fa-minus"></i></button>'+
        '</div>'+
        '</td>'+
        '</tr>';
        $('#table-kredit tr:last').after($html);
        row_index_kredit++;
}

function hapusDebet(row_index){  
  $('.debet-'+row_index).remove();
}

function hapusKredit(row_index){  
  $('.kredit-'+row_index).remove();
}

function simpanTable(){
  $.ajax(baseUrl+"/master-transaksi/save_data", {
           timeout: 5000,
           type: "get",
           data: $('.simpan-form-table :input').serialize(),
           dataType: "json",
           success: function (data) {
              /*console.log(data);
              if(data.status == "gagal"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;Gagal Disimpan. '+data.content+'!');
              }else if(data.status == "berhasil"){
                $("#message_server").html('<i class="fa fa-check-circle"></i> &nbsp;Data Berhasil Disimpan!');
                $("#table_data").prepend('<tr><td class="text-center">+</td><td class="text-center">'+data.content.id_akun+'</td><td class="text-center">'+data.content.nama_akun+'</td></tr>')
              }

              $change = true;
              $("#btn_simpan").removeAttr("disabled");*/
           }
        })
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