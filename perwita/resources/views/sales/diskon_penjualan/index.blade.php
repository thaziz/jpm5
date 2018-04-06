@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Tambah Data Diskon Penjualan </h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Sales</a>
            </li>
            <li class="active">
                <strong> Diskon Penjualan </strong>
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
                    <h5> Diskon Penjualan
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                   <div class="text-right">
                       <a class="btn btn-success" onclick="tambah()" aria-hidden="true" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i> Tambah Data</a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
           
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="get">
                  <div class="box-body">
                </div>        
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-diskonpenjualan">
                    <thead>
                     <tr>
                        <th width="10%" style="width:5%">NO</th>
                        <th width="20%"> Cabang </th>
                        <th width="10%"> Diskon </th>
                        <th width="10%"> Jenis </th>
                        <th width="30%"> Akun </th>
                        <th width="10%"> Keterangan </th>
                        <th width="10%"> Aksi </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $index=>$data)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $data->nama }}</td>
                          <td style="text-align: right">{{ $data->dc_diskon }}%</td>
                          <td>{{ $data->dc_jenis }}</td>
                          <td>{{ $data->dc_kode }} -- {{ $data->nama_akun }}</td>
                          <td class="tdket">{{ $data->dc_note }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button type="button" onclick="edit({{ $data->dc_id }})" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="glyphicon glyphicon-pencil"></i></button>
                              <button type="button" onclick="hapus({{ $data->dc_id }})" title="Delete" class="btn btn-danger btn-xs btndelete"><i class="glyphicon glyphicon-remove"></i></button>                                     
                            </div>
                          </td>
                        </tr>
                      @endforeach
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

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {{-- <i class="fa fa-laptop modal-icon"></i> --}}
                <h4 class="modal-title">Tambah Data Diskon Penjualan</h4>
                <small class="font-bold">Data diskon ini digunakan untuk membatasi pemberian diskon pada setiap cabang.</small>
            </div>
            <div class="modal-body">
              <form id="diskon_penjualan">
                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                  <tr>
                    <td class=""><strong>Cabang</strong></td>
                    <td colspan="5">
                      <input type="hidden" name="id_dc" value="" id="id_dc">
                      <select class="form-control chosen-select-width" onchange="getAkun()" name="cabang" style="width:100%" id="cabang">
                      @if(count($cabang) == 1)
                        <option value="{{ $cabang[0]->kode }}"> {{ $cabang[0]->nama }} </option>
                      @else
                          <option value="ALL"> Global</option>
                        @foreach ($cabang as $row)
                          <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                        @endforeach
                      @endif
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td class=""><strong>Diskon</strong></td>
                    <td colspan="5">
                        <input class="form-control" id="diskon" onkeyup="DiscCtrl()" type="text" value="0" name="diskon" style="text-align:right">
                    </td>
                  </tr>
                  <tr>
                    <td class=""><strong>DO</strong></td>
                    <td colspan="5">
                        <select class="form-control chosen-select-width"  name="do" style="width:100%" id="do">
                        <option value="PAKET"> PAKET </option>
                        <option value="KARGO"> KARGO </option>
                        <option value="KORAN"> KORAN </option>
                    </td>
                  </tr>
                  <tr>
                    <td class=""><strong>Kode Akun</strong></td>
                    <td colspan="5">
                        <select class="form-control chosen-select-width"  name="akun" style="width:100%" id="akun">
                          <option value="" disabled selected>-- Pilih Kode --</option>
                        @if(count($akun) == 1)
                          <option value="{{ $akun[0]->id_akun }}"> {{ $akun[0]->nama_akun }} </option>
                        @else
                          @foreach ($akun as $row)
                              <option value="{{ $row->id_akun }}">{{ $row->id_akun }} - {{ $row->nama_akun }} </option>
                          @endforeach
                        @endif
                    </td>
                  </tr>
                  <tr>
                    <td class=""><strong>Keterangan</strong></td>
                    <td colspan="5">
                        <textarea class="form-control keter" name="keterangan"></textarea>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
$(document).ready( function () {
    var tableDetail = $('.tbl-diskonpenjualan').DataTable({
        responsive: true,
        searching: true,
        "pageLength": 10,
        "language": dataTableLanguage,
        "columnDefs": [ {
          "targets"  : [6],
          "orderable": false,
        }]
    });

    $("input[name='diskon']").TouchSpin({
        min: 0,
        max: 100,
        step: 1,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '%'
    });
});

function DiscCtrl(){
  var disc = $("input[name='diskon']").val();
  if (!isNaN(disc) && disc > 100) {
    $("input[name='diskon']").val(100);
  }
}

function tambah(){
  $('textarea.keter').val('');
  $('select[name="cabang"]').val( '' ).trigger("chosen:updated");
  $("input[name='diskon']").val(0);
  $('select[name="do"]').val( '' ).trigger("chosen:updated");
  $('select[name="akun"]').val( '' ).trigger("chosen:updated");
}

function getAkun(){
  var cabang = $("select[name='cabang']").val();
  $.ajax({
    url: baseUrl + '/master_sales/diskonpenjualan/getAkun',
    type: 'get',
    data: {cabang: cabang},
    success: function(response){
      var akunselect = '<option value="" selected="" disabled="">-- Pilih Kode --</option>';
      $.each(response.akun, function(i,n){
          akunselect = akunselect + '<option value="'+n.id_akun+'">'+n.id_akun+' -- '+n.nama_akun+'</option>';
      });

      $('#akun').html(akunselect);
      $('#akun').addClass('form-control chosen-select-width');
      $("#akun").trigger("chosen:updated");
    }, error:function(x, e) {
        if (x.status == 0) {
            alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
        } else if (x.status == 404) {
            alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
        } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
        } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
        } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
        } else {
            alert('Unknow Error.\n' + x.responseText);
        }
      }
  })
}

function simpan(){
  var keter = $('textarea.keter').val();
  var cabang = $("select[name='cabang']").val();
  var diskon = $("input[name='diskon']").val();
  var jenisdo = $("select[name='do']").val();
  var akun = $("select[name='akun']").val();
  var id = $("input[name='id_dc']").val();
  var value = { cabang: cabang,
            diskon: diskon,
            jenis: jenisdo,
            akun: akun,
            keterangan: keter,
            id_dc: id
          };
  $.ajax({
    url: baseUrl + '/master_sales/diskonpenjualan/simpan',
    type: 'get',
    data: value,
    success: function(response){
      if (response.status == 'sukses') {
        swal({
            title: "Berhasil",
            text: "Data telah tersimpan",
            showConfirmButton: false,
            type: "success"
        });
        location.reload();
      } else {
        swal({
            title: "Gagal!!",
            text: "Periksa data anda, mungkin terjadi duplikasi data",
            type: "error"
        });
      }
    }, error:function(x, e) {
        if (x.status == 0) {
            alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
        } else if (x.status == 404) {
            alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
        } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
        } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
        } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
        } else {
            alert('Unknow Error.\n' + x.responseText);
        }
      }
  })
}

function edit(id){
  $.ajax({
    url: baseUrl + '/master_sales/diskonpenjualan/getData',
    type: 'get',
    data: {id: id},
    success: function(response){
      $("input[name='id_dc']").val(response.data[0].dc_id);
      $("input[name='diskon']").val(response.data[0].dc_diskon);
      $('select[name="cabang"]').val( response.data[0].dc_cabang ).trigger("chosen:updated");
      $('select[name="do"]').val( response.data[0].dc_jenis ).trigger("chosen:updated");
      $('select[name="akun"]').val( response.data[0].dc_kode ).trigger("chosen:updated");
      $('textarea.keter').val(response.data[0].dc_note);
      $('#myModal').modal('show');
    }, error:function(x, e) {
        if (x.status == 0) {
            alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
        } else if (x.status == 404) {
            alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
        } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
        } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
        } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
        } else {
            alert('Unknow Error.\n' + x.responseText);
        }
      }
  })
}

function hapus(id){
  swal({
      title: "Apakah anda yakin?",
      text: "data yang dihapus tidak bisa dikembalikan!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "lanjutkan!",
      cancelButtonText: "Batalkan",
      closeOnConfirm: false,
      closeOnCancel: false },
  function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: baseUrl + '/master_sales/diskonpenjualan/hapus',
          type: 'get',
          data: {id: id},
          success: function(response){
            if (response.status == 'sukses') {
              swal({
                title: "Terhapus",
                text: "Data telah dihapus",
                showConfirmButton: false,
                type: "success"
            });
              location.reload();
            } else {
              swal({
                  title: "Gagal!!",
                  text: "Data tidak terhapus",
                  type: "error"
              });
            }
          }, error:function(x, e) {
              if (x.status == 0) {
                  alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
              } else if (x.status == 404) {
                  alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
              } else if (x.status == 500) {
                  alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
              } else if (e == 'parsererror') {
                  alert('Error.\nParsing JSON Request failed.');
              } else if (e == 'timeout'){
                  alert('Request Time out. Harap coba lagi nanti');
              } else {
                  alert('Unknow Error.\n' + x.responseText);
              }
            }
        })
      } else {
          swal("Cancelled", "Your imaginary file is safe :)", "error");
      }
  });
}

</script>
@endsection
