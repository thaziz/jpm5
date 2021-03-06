@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
      .center {text-align:center; }
      .lebar {width:200px }
      .right{text-align: right;}
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> KONTRAK
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../master_subcon/subcon" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <form id="form_header" class="form-horizontal">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="kontrak_nomor" id="ed_nomor" readonly="readonly" class="form-control ed_nomor" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <div class="input-group date" style="width: 100%">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="ed_tanggal" value="{{$now}}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="tgl1 form-control" name="ed_mulai" value="{{$now}}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Berakhir</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="tgl2 form-control" name="ed_akhir" value="{{$tgl2}}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Subcon</td>
                                <td colspan="3" class="customer_td">
                                    <select class="chosen-select-width form-control id_subcon"  name="id_subcon" id="id_subcon" style="width:100%" >
                                        <option selected="" value="0">- Pilih Subcon -</option>
                                        @foreach($data as $val)
                                        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                        @endforeach

                                    </select>
                                
                                </td>
                            </tr>
                            @if(Auth::user()->punyaAkses('Kontrak Subcon','cabang'))
                            <tr>
                                <td  style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3" class="cabang_td">
                                    <select onchange="ganti_nota()" class="form-control cabang " name="cabang" >
                                      @foreach($cabang as $val)
                                                @if(Auth::user()->kode_cabang == $val->kode)
                                                <option selected value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                      @endforeach
                                    </select>
                                </td>
                            </tr>
                            @else
                            <tr class="disabled">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3" class="cabang_td">
                                    <select class="form-control cabang" disabled="" name="cabang" >
                                      @foreach($cabang as $val)
                                                @if(Auth::user()->kode_cabang == $val->kode)
                                                <option selected value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                      @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td>Aktif</td>
                                <td colspan="3">
                                    <input type="checkbox" name="ck_aktif" checked="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Tambah</button>
                        </div>


                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Angkutan</th>
                            <th>Tarif</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                
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

<div id="modal_sub" class="modal_sub modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Customer</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal  kirim">
                    <table class="table table_modal table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="padding-top: 0.4cm">Kota Asal</td>
                                <td>   
                                    <select class="chosen-select-width asal"  name="asal" id="cb_kota_asal" style="width:100%">
                                        <option value="0">- Pilih Asal -</option>
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="form-control id_detail" name="id_detail" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                <td>   
                                    <select class="chosen-select-width tujuan"  name="tujuan" style="width:100%">
                                        <option value="0">- Pilih Tujuan -</option>
                                         @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Tipe Angkutan</td>
                                <td>
                                    <select class="form-control chosen-select-width angkutan" name="angkutan" >
                                        <option value="0">- Pilih Angkutan -</option>
                                        @foreach($angkutan as $val)
                                        <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Jenis Tarif</td>
                                <td>
                                    <select class="form-control tarif" name="tarif" >
                                          <option value="0">Pilih - Tarif</option>
                                       @foreach($jenis_tarif as $val)
                                          <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                                       @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm;">Harga</td>
                                <td>
                                    <input type="text" name="harga" class="form-control harga" style="text-transform: uppercase;text-align:right">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td>
                                    <input type="text" name="keterangan" class="form-control keterangan" style="text-transform: uppercase" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <div class="tambah"><button type="submit" class="btn btn-primary " onclick="tambah()" id="btnsave">Append</button></div>
                <div hidden=""  class="updt"><button type="submit" class="btn btn-primary " onclick="updt()" id="update">Update</button></div>
            </div>
    </div>

  </div>
</div>

<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  $('.tgl').datepicker({

  });
  $('.tgl1').datepicker();
  $('.tgl2').datepicker();

 $(document).ready( function () {
        

  var asd = $('.harga').maskMoney({thousands:'.', precision:0});

  var config2 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"100%"}
             }
             for (var selector in config2) {
               $(selector).chosen(config2[selector]);
             }

  $('.cabang').chosen(config2); 


var cabang = $('.cabang').val();
$.ajax({
        url:baseUrl + '/master_subcon/nota_kontrak_subcon',
        data:{cabang},
        dataType:'json',
        success:function(data){
            $('.ed_nomor').val(data.nota);
        }
    })

 $('#table_data').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_kontrak_subcon') }}',
              data:{nota: function() { return $('.ed_nomor').val() }}
          },
          columnDefs: [
          {
             targets: 7 ,
             className: 'center'
          },
          {
             targets: 0 ,
             className: 'center ksd_dt'
          },
          {
             targets: 5 ,
             className: 'right'
          },
          {
             targets: 1 ,
             className: 'lebar'
          },
          {
             targets: 2 ,
             className: 'lebar'
          },
       
        ],
        columns: [
            {data: 'ksd_ks_dt', name: 'ksd_ks_dt'},
            {data: 'asal', name: 'asal'},
            {data: 'tujuan', name: 'tujuan'},
            {data: 'angkutan', name: 'angkutan'},
            {data: 'tarif', name: 'tarif'},
            {data: 'harga', name: 'harga'},
            {data: 'ksd_keterangan', name: 'ksd_keterangan'},
            {data: 'aksi', name: 'aksi'}
        ]

    });

});



function ganti_nota() {
  var cabang = $('.cabang').val();
$.ajax({
        url:baseUrl + '/master_subcon/nota_kontrak_subcon',
        data:{cabang},
        dataType:'json',
        success:function(data){
            $('.ed_nomor').val(data.nota);
        }
    })
}
$('#btnadd').click(function(){
  var id_subcon = $('.id_subcon').val();
  var cabang    = $('.cabang').val();
  if (id_subcon == '0') {
    return toastr.warning('Harap Mengisi Nama Subcon.');
  }
  if (cabang == '0') {
    return toastr.warning('Harap Mengisi Cabang.');
  }
  $('.updt').attr('hidden',true);
  $('.tambah').attr('hidden',false);

  $('.asal').val('0').trigger('chosen:updated');
  $('.tujuan').val('0').trigger('chosen:updated');
  $('.angkutan').val('0').trigger('chosen:updated');
  $('.tarif').val('0');
  $('.harga').val('0');
  $('.keterangan').val('');
  $('.id_detail').val('');

  $('.modal_sub').modal('show');
});

var count = 0;
function tambah(){
  
  var asal        = $('.asal option:selected').text();
  var tujuan      = $('.tujuan option:selected').text();
  var angkutan    = $('.angkutan option:selected').text();

  var asal_dt     = $('.asal').val();
  var tujuan_dt   = $('.tujuan').val();
  var angkutan_dt = $('.angkutan').val();
  var tarif       = $('.tarif ').val();
  var Harga       = $('.harga').val();
  var keterangan  = $('.keterangan').val();
  var cabang = $('.cabang').val();

  if (asal_dt == 0) {
    return toastr.warning('Harap Mengisi Asal Kota.');
  }

  if (tujuan_dt == 0) {
    return toastr.warning('Harap Mengisi Tujuan Kota.');
  }

  if (angkutan_dt == 0) {
    return toastr.warning('Harap Mengisi Angkutan.');
  }

  if (tarif == 0) {
    return toastr.warning('Harap Mengisi Tarif.');
  }

  if (Harga == 0 || Harga == '') {
    return toastr.warning('Harga Tidak Boleh 0.');
  }

  if (keterangan == 0) {
    return toastr.warning('Harap Mengisi Keterangan.');
  }



  $.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

      $.ajax({
      url:baseUrl + '/master_subcon/save_subcon',
      type:'get',
      data:$('#form_header').serialize()+'&'+$('.table_modal :input').serialize()+'&cabang='+cabang,
      dataType:'json',
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
                showConfirmButton: true
                },function(){
                  var table = $('#table_data').DataTable();
                  table.ajax.reload(null,false);
                  $('.cabang_td').addClass('disabled');
                  $('.customer_td').addClass('disabled');

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
}
  
function hapus(p){
var auth = '{{ Auth::user()->punyaAkses('Kontrak Subcon','hapus') }}';

if (auth == 0) {
return toastr.warning('User tidak memiliki akses untuk menghapus');
}

var par    = $(p).parents('tr');
var nota   = $('#ed_nomor').val();
var ksd_dt = $(par).find('.ksd_dt').text();

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
      url:baseUrl + '/master_subcon/hapus_d_kontrak',
      data:{nota,ksd_dt},
      type:'get',
      success:function(data){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload(null,false);
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

function edit(p){

var auth = '{{ Auth::user()->punyaAkses('Kontrak Subcon','ubah') }}';
if (auth == 0) {
return toastr.warning('User tidak memiliki akses untuk menghapus');
}

var par = $(p).parents('tr');
var nota   = $('#ed_nomor').val();
var ksd_dt = $(par).find('.ksd_dt').text();

$.ajax({
    url:baseUrl + '/master_subcon/set_modal',
    type:'get',
    data:{nota,ksd_dt},
    dataType:'json',
    success:function(data){

        $('.asal').val(data.data.ksd_asal).trigger('chosen:updated');
        $('.tujuan').val(data.data.ksd_tujuan).trigger('chosen:updated');
        $('.angkutan').val(data.data.ksd_angkutan).trigger('chosen:updated');
        $('.tarif').val(data.data.ksd_jenis_tarif);
        $('.harga').val(accounting.formatMoney(data.data.ksd_harga,"",0,'.',','));
        $('.keterangan').val(data.data.ksd_keterangan);
        $('.id_detail').val(ksd_dt);
        // $('.updt').attr('hidden',false);
        // $('.tambah').attr('hidden',true);
        $('#modal_sub').modal('show');
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

  
}

function updt(){
  var id            = $('.id_edit').val();
  var asal_text     = $('.asal option:selected').text();
  var tujuan_text   = $('.tujuan option:selected').text();
  var angkutan_text = $('.angkutan option:selected').text();
  var asal          = $('.asal').val();
  var tujuan        = $('.tujuan').val();
  var angkutan      = $('.angkutan').val();
  var tarif         = $('.tarif').val();
  var harga         = $('.harga').val();
  var keterangan    = $('.keterangan').val();



  var par         = $('.hitung_'+id).parents('tr');

  $(par).find('.asal_text').html(asal_text);
  $(par).find('.tujuan_text').html(tujuan_text);
  $(par).find('.angkutan_text').html(angkutan_text);
  $(par).find('.tarif_text').html(tarif);
  $(par).find('.harga_text').html(harga);
  $(par).find('.keterangan_text').html(keterangan);

  $(par).find('.asal_tb').val(asal);
  $(par).find('.tujuan_tb').val(tujuan);
  $(par).find('.angkutan_tb').val(angkutan);
  $(par).find('.tarif_tb').val(tarif);
  $(par).find('.harga_tb').val(harga);
  $(par).find('.keterangan_tb').val(keterangan);

  $('.modal_sub').modal('hide');
}

$('#btnsimpan').click(function(){
var count = datatable.page.info().recordsTotal;
if (count == 0) {
  toastr.info('Tidak Ada Data Periksa Kembali');
  return 1;
}
   var cabang = $('.cabang').val();

   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Subcon!",
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
      url:baseUrl + '/master_subcon/save_subcon',
      type:'get',
      data:$('#form_header').serialize()+'&'+$('#table_data input').serialize()+'cabang='+cabang,
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   location.href='../master_subcon/subcon';
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
});
</script>
@endsection
