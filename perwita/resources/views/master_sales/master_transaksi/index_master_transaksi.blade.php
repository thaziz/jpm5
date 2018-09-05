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
                            <a>Master Bersama</a>
                        </li>
                        <li class="active">
                            <strong> Master Transaksi Akun</strong>
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
                    <h5> MASTER TRANSAKSI AKUN
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <a href="{{ url('master/master_transaksi/create') }}"><button  type="button"  class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button></a>
                    </div>
                </div>
            <div class="ibox-content">
            <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-body">   
                  <table  class="table table_pajak table-bordered table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama Akun</th>
                        <th>Id Akun</th>
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

<div class="modal modal_pajak fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <td>Nama Akun</td>
                <td>
                  <input type="text" class="form-control nama" name="nama">
                  <input type="hidden" class="form-control id_akun" name="id_akun">
                </td>
              </tr>
              <tr>
                <td>Akun</td>
                <td>
                  <select class="form-control akun chosen-select-width" class="akun">
                    @foreach ($akun as $val)
                    <option value="{{ $val->main_id }}">{{ $val->main_id }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary save">Save</button>
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
    // $('.nomor_pajak_1').mask("000", {placeholder: "TIGA DIGIT AWAL"});
    // $('.nomor_pajak_2').mask("00", {placeholder: "DUA DIGIT PAJAK"});
    // $('.nomor_pajak_awal').mask("00000000", {placeholder: "RANGE DIGIT AWAL"});
    // $('.nomor_pajak_akhir').mask("00000000", {placeholder: "RANGE DIGIT AKHIR"});

    $('.table_pajak').DataTable({
        processing: true,
        // responsive:true,
        serverSide: true,
        "order": [[ 1, "desc" ],[ 0, "desc" ]],
        ajax: {
            url:'{{ route("datatable_transaksi") }}',
        },
        columnDefs: [
          {
             targets: 0,
             className: 'center'
          },
          {
             targets: 2,
             className: 'center'
          },
          {
             targets: 3,
             className: 'center'
          },
        ],
        "columns": [
        { "data": 'DT_Row_Index'},
        { "data": "mt_nama" },
        { "data": "mt_jenis" },
        { "data": "aksi" },
        ]
    });

    // $('.tanggal').datepicker({format:'dd/mm/yyyy'});
})


$('#btn_add').click(function(){
   location.href = '{{ url('master/master_transaksi/create') }}';
})

$('.save').click(function(){
  var nama = $('.nama').val();
  var akun = $('.akun').val();
  var id = $('.id_akun').val();
  $.ajax({
    url : '{{ url('master/master_transaksi/save') }}',
    data:{id,nama,akun},
    type:'get',
    dataType:'json',
    success:function(){
      toastr.success('Data Berhasil Diupdate');
      var table = $('.table_pajak').DataTable();
      table.ajax.reload();
    },error:function(){
      toastr.warning('Data Gagal Diupdate');
    }
  })
})

function ubah(id) {
   location.href = '{{ url('master/master_transaksi/edit') }}/'+id;
}

</script>
@endsection
