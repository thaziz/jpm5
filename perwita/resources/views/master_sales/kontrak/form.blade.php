@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
      .center {text-align:center; }
      .lebar {width:200px }
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> KONTRAK
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../master_sales/kontrak" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                                    <input type="text" name="kontrak_nomor" id="ed_nomor" readonly="readonly" class="form-control" style="text-transform: uppercase" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <input type="text" class="form-control tgl" name="ed_tanggal" value="{{$now}}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" class="tgl1 form-control" name="ed_mulai" value="{{$now}}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Berakhir</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="tgl2 form-control" name="ed_akhir" value="{{$now1}}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td colspan="3">
                                    <select class="chosen-select-width form-control id_subcon"  name="id_subcon" id="id_subcon" style="width:100%" >
                                        <option selected="" disabled="">- Pilih Customer -</option>
                                        @foreach($customer as $val)
                                        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @if(Auth()->user()->punyaAkses('Master Kontrak','cabang'))
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    <select class="form-control cabang chosen-select-width"  name="cabang" >
                                      <option selected="" disabled="">- Pilih Cabang -</option>
                                      @foreach($cabang as $val)
                                      @if(Auth::user()->kode_cabang == $val->kode)
                                      <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                      @else
                                      <option  value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                </td>
                            </tr>
                            @else
                             <tr class="disabled">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    <select class="form-control cabang chosen-select-width"  name="cabang" >
                                      <option selected="" disabled="">- Pilih Cabang -</option>
                                      @foreach($cabang as $val)
                                      @if(Auth::user()->kode_cabang == $val->kode)
                                      <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                      @else
                                      <option  value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control ed_keterangan" style="text-transform: uppercase" value="" >
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
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" >
                                <i class="glyphicon glyphicon-plus"></i>Tambah</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>


                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Jenis Tarif</th>
                            <th>Satuan</th>
                            <th>Tipe Angkutan</th>`
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

                  <!-- modal -->
                <div id="modal_customer" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Kontrak Customer</h4>
                      </div>
                      <div class="modal-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Kota Asal</td>
                                <td>
                                    <select class="kota_asal_modal form-control chosen-select-width">
                                        <option value="0">Pilih - Asal</option>
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Kota Tujuan</td>
                                <td>
                                    <select class="kota_tujuan_modal form-control chosen-select-width">
                                        <option value="0">Pilih - Tujuan</option>
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>   
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>
                                    <select class="jenis_modal form-control chosen-select-width">
                                        <option value="0">Pilih - Jenis</option>
                                        <option value="PAKET">PAKET</option>
                                        <option value="KORAN">KORAN</option>
                                        <option value="KARGO">KARGO</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="type_tarif_tr">
                                <td>Tipe Tarif</td>
                                <td>
                                    <select class="type_tarif_modal form-control chosen-select-width">
                                        <option value="0">Pilih - Jenis</option>
                                        <option value="DOKUMEN">DOKUMEN</option>
                                        <option value="KOLI">KOLI</option>
                                        <option value="KILO">KILO</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Tarif</td>
                                <td>
                                    <select class="jenis_tarif_modal form-control chosen-select-width">
                                        <option value="0">Pilih - Jenis Tarif</option>
                                        @foreach($jenis_tarif as $val)
                                        <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe Angkutan</td>
                                <td>
                                    <select name="tipe_angkutan" class="form-control tipe_angkutan chosen-select-width">
                                        <option value="0">Pilih - Tipe Angkutan</option>
                                        @foreach($tipe_angkutan as $val)
                                            <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>
                                    <input class="form-control harga_modal" type="text" style="text-align: right">
                                </td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>
                                    <select class="satuan_modal form-control chosen-select-width">
                                        <option value="0">Pilih - Satuan</option>
                                        @foreach($satuan as $val)
                                        <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>
                                    <input class="form-control keterangan_modal" type="text">
                                </td>
                            </tr>
                            <tr >
                                <td>Acc Penjualan</td>
                                <td class="acc_tr">
                                    <select class="acc_akun_modal form-control chosen-select-width">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                            <tr >
                                <td>CSF Penjualan</td>
                                <td class="csf_tr">
                                    <select class="csf_akun_modal form-control chosen-select-width">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="tambah()" data-dismiss="modal">Simpan</button>
                      </div>
                    </div>

                  </div>
                </div>
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
<script type="text/javascript">
   $('.tgl').datepicker({
    format:'dd/mm/yyyy'
  });
  $('.tgl1').datepicker({
    format:'dd/mm/yyyy'
  });
  $('.tgl2').datepicker({
    format:'dd/mm/yyyy'

  });

 $(document).ready( function () {
            
    $('.harga_modal').maskMoney({precision:0});
    var asd = $('.harga').maskMoney({thousands:'.', precision:0});
    var cabang = $('.cabang').val();

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

    $.ajax({
        url:baseUrl+'/master_sales/kontrak_set_nota',
        data:{cabang},
        dataType:'json',
        success:function(response){
            $('#ed_nomor').val(response.nota);
            $('#ed_nomor').val(response.nota);
        },
        error:function(){
            // location.reload();
        }

    })

    $.ajax({
        url:baseUrl +'/master_sales/set_kode_akun_acc',
        data:{cabang},
        success:function(response){
            $('.acc_tr').html(response);
        },
        error:function(){
            location.reload();
        }
    });

    $.ajax({
        url:baseUrl +'/master_sales/set_kode_akun_csf',
        data:{cabang},
        success:function(response){
            $('.csf_tr').html(response);
        },
        error:function(){
            location.reload();
        }
    });
});

$('#btnadd').click(function(){


    var harga_modal              = $('.harga_modal').val(0);
    var keterangan_modal         = $('.keterangan_modal ').val('');
    var kota_asal_modal          = $('.kota_asal_modal').val(0).trigger('chosen:updated');
    var kota_tujuan_modal        = $('.kota_tujuan_modal ').val(0).trigger('chosen:updated');
    var jenis_modal              = $('.jenis_modal').val(0).trigger('chosen:updated');
    var jenis_tarif_modal        = $('.jenis_tarif_modal').val(0).trigger('chosen:updated');
    var acc_akun_modal           = $('.acc_akun_modal ').val(0).trigger('chosen:updated');
    var type_tarif_modal         = $('.type_tarif_modal ').val(0).trigger('chosen:updated');
    var csf_akun_modal           = $('.csf_akun_modal').val(0).trigger('chosen:updated');
    var satuan_modal             = $('.satuan_modal').val(0).trigger('chosen:updated');

    var id_subcon                = $('.id_subcon').val();
    var ed_keterangan            = $('.ed_keterangan').val();
    var validasi                 = [];


    if (id_subcon != 0) {
        validasi.push(1);
    }else{
        validasi.push(0);
    }

    if (ed_keterangan != '') {
        validasi.push(1);
    }else{
        validasi.push(0);
    }
    var index = validasi.indexOf(0)
    if (index == -1) {
        $('#modal_customer').modal('show');  
    }else{
        toastr.warning("Harap Periksa Data Anda Kembali");
    }


});
$('.jenis_modal').change(function(){
    if ($(this).val() == 'PAKET') {
        $('.type_tarif_tr').attr('hidden',false);
    }else{
        $('.type_tarif_modal').val(0).trigger('chosen:updated');
        $('.type_tarif_tr').attr('hidden',true);
    }
});
var datatable = $('#table_data').DataTable({
                      'paging':false,
                      'searching':false,
                      columnDefs: [
                      {
                         targets: 6 ,
                         className: 'center'
                      },
                      {
                         targets: 0 ,
                         className: 'lebar'
                      },
                      {
                         targets: 1 ,
                         className: 'lebar'
                      },
                   
                    ]
                });
var count = 0;
function tambah(){
  
var kota_asal_modal_text     = $('.kota_asal_modal  option:selected').text();
var kota_tujuan_modal_text   = $('.kota_tujuan_modal  option:selected').text();
var jenis_modal_text         = $('.jenis_modal option:selected').text();
var jenis_tarif_modal_text   = $('.jenis_tarif_modal option:selected').text();
var acc_akun_modal_text      = $('.acc_akun_modal option:selected ').text();
var csf_akun_modal_text      = $('.csf_akun_modal option:selected').text();
var satuan_modal_text        = $('.satuan_modal option:selected').text();
var tipe_angkutan_text       = $('.tipe_angkutan option:selected').text();

var harga_modal              = $('.harga_modal').val();
var keterangan_modal         = $('.keterangan_modal ').val();

var kota_asal_modal          = $('.kota_asal_modal').val();
var type_tarif_modal         = $('.type_tarif_modal').val();
var kota_tujuan_modal        = $('.kota_tujuan_modal ').val();
var jenis_modal              = $('.jenis_modal').val();
var jenis_tarif_modal        = $('.jenis_tarif_modal').val();
var acc_akun_modal           = $('.acc_akun_modal ').val();
var csf_akun_modal           = $('.csf_akun_modal').val();
var satuan_modal             = $('.satuan_modal').val();
var tipe_angkutan            = $('.tipe_angkutan').val();
console.log(harga_modal);
kota_asal_modal_text   = kota_asal_modal_text.split('-');
kota_tujuan_modal_text = kota_tujuan_modal_text.split('-');

  datatable.row.add([
           kota_asal_modal_text[1]+'<input type="hidden" class="kota_asal" value="'+kota_asal_modal+'" name="kota_asal[]">' ,
           kota_tujuan_modal_text[1]+'<input type="hidden" class="kota_tujuan" value="'+kota_tujuan_modal+'" name="kota_tujuan[]">' ,
           jenis_modal_text+'<input type="hidden" class="jenis_detail" value="'+jenis_modal+'" name="jenis_modal[]">'+
           '<input type="hidden" class="jenis_tarif_detail" value="'+jenis_tarif_modal+'" name="jenis_tarif[]">',
           satuan_modal_text+'<input type="hidden" class="satuan" value="'+satuan_modal+'" name="satuan[]">' ,
           tipe_angkutan_text+'<input type="hidden" class="tipe_angkutan" value="'+tipe_angkutan+'" name="tipe_angkutan[]">' ,
           '<input type="text" class="harga form-control" style="text-align:right" value="'+harga_modal+'" name="harga[]">'+
           '<input type="hidden" class="type_tarif form-control" value="'+type_tarif_modal+'" name="type_tarif[]">',
           '<input type="text" class="keterangan form-control" value="'+keterangan_modal+'" name="keterangan[]">',
           '<button type="button" onclick="hapus(this)" class="btn btn-danger hapus btn-sm" title="hapus">'+
           '<label class="fa fa-trash"></label></button>'+
           '<input type="hidden" class="akun_acc form-control" value="'+acc_akun_modal+'" name="akun_acc[]">'+
           '<input type="hidden" class="akun_csf form-control" value="'+csf_akun_modal+'" name="akun_csf[]">',
      
    ]).draw();
  // console.log('asd');

  $('.modal_customer').modal('hide');
}
  
function hapus(p){
  var par = p.parentNode.parentNode;
  datatable.row(par).remove().draw(false);
}

function edit(p){
var par  = p.parentNode.parentNode;
var asal = $(par).find('.asal_tb').val();
var tujuan = $(par).find('.tujuan_tb').val();
var angkutan = $(par).find('.angkutan_tb').val();
var tarif = $(par).find('.tarif_tb').val();
var harga = $(par).find('.harga_tb').val();
var keterangan = $(par).find('.keterangan_tb').val();
var id = $(par).find('.id_table').val();

  $('.asal').val(asal).trigger('chosen:updated');
  $('.tujuan').val(tujuan).trigger('chosen:updated');
  $('.angkutan').val(angkutan).trigger('chosen:updated');
  $('.tarif').val(tarif);
  $('.harga').val(harga);
  $('.keterangan').val(keterangan);
  $('.id_edit').val(id);
  $('.updt').attr('hidden',false);
  $('.tambah').attr('hidden',true);
  $('.modal').modal('show');
}

// function updt(){
//   var id            = $('.id_edit').val();
//   var asal_text     = $('.asal option:selected').text();
//   var tujuan_text   = $('.tujuan option:selected').text();
//   var angkutan_text = $('.angkutan option:selected').text();
//   var asal          = $('.asal').val();
//   var tujuan        = $('.tujuan').val();
//   var angkutan      = $('.angkutan').val();
//   var tarif         = $('.tarif').val();
//   var harga         = $('.harga').val();
//   var keterangan    = $('.keterangan').val();



//   var par         = $('.hitung_'+id).parents('tr');

//   $(par).find('.asal_text').html(asal_text);
//   $(par).find('.tujuan_text').html(tujuan_text);
//   $(par).find('.angkutan_text').html(angkutan_text);
//   $(par).find('.tarif_text').html(tarif);
//   $(par).find('.harga_text').html(harga);
//   $(par).find('.keterangan_text').html(keterangan);

//   $(par).find('.asal_tb').val(asal);
//   $(par).find('.tujuan_tb').val(tujuan);
//   $(par).find('.angkutan_tb').val(angkutan);
//   $(par).find('.tarif_tb').val(tarif);
//   $(par).find('.harga_tb').val(harga);
//   $(par).find('.keterangan_tb').val(keterangan);

//   $('.modal').modal('hide');
// }

$('#btnsimpan').click(function(){
    var cabang = $('.cabang').val();
   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Kontrak!",
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
      url:baseUrl + '/master_sales/save_kontrak',
      type:'post',
      data:$('#form_header').serialize()+'&'+datatable.$('input').serialize()+'&cabang='+cabang,
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   location.reload();
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
