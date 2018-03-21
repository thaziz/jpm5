@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
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
                                <td style="padding-top: 0.4cm">Subcon</td>
                                <td colspan="3">
                                    <select class="chosen-select-width form-control id_subcon"  name="id_subcon" id="id_subcon" style="width:100%" >
                                        <option selected="" disabled="">- Pilih Customer -</option>
                                        @foreach($customer as $val)
                                        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                        @endforeach

                                    </select>
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    <select class="form-control cabang chosen-select-width" disabled="" name="cabang" >
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
                                    <select class="kota_asal_modal form-control">
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Kota Tujuan</td>
                                <td>
                                    <select class="kota_asal_modal form-control">
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>   
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>
                                    <select class="jenis_modal form-control">
                                        <option value="PAKET">PAKET</option>
                                        <option value="KORAN">KORAN</option>
                                        <option value="KARGO">KARGO</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe Angkutan</td>
                                <td>
                                    <select class="tipe_angkutan_modal form-control">
                                        <option value="0">Pilih - Angkutan</option>
                                        @foreach($tipe_angkutan as $val)
                                        <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Tarif</td>
                                <td>
                                    <select class="jenis_tarif_modal form-control">
                                        <option value="0">Pilih - Jenis Tarif</option>
                                        @foreach($jenis_tarif as $val)
                                        <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
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
                                    <select class="stuan_modal form-control">
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
                                    <input class="form-control keterangan_modal" type="text" style="text-align: right">
                                </td>
                            </tr>
                            <tr >
                                <td>Acc Penjualan</td>
                                <td class="acc_tr">
                                    <select class="acc_akun_modal form-control">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                            <tr >
                                <td>CSF Penjualan</td>
                                <td class="csf_tr">
                                    <select class="csf_akun_modal form-control">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

  });
  $('.tgl1').datepicker();
  $('.tgl2').datepicker();

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
            // location.reload();
        }
    });

    $.ajax({
        url:baseUrl +'/master_sales/set_kode_akun_csf',
        data:{cabang},
        success:function(response){
            $('.csf_tr').html(response);
        },
        error:function(){
            // location.reload();
        }
    });
});

$('#btnadd').click(function(){

  $('.updt').attr('hidden',true);
  $('.tambah').attr('hidden',false);

  $('.asal').val('0').trigger('chosen:updated');
  $('.tujuan').val('0').trigger('chosen:updated');
  $('.angkutan').val('0').trigger('chosen:updated');
  $('.tarif').val('');
  $('.harga').val('');
  $('.keterangan').val('');
  $('.id_edit').val('');

  $('#modal_customer').modal('show');
});

var datatable = $('#table_data').DataTable({
                      'paging':false,
                      'searching':false
                });
var count = 0;
function tambah(){
  
  var asal        = $('.asal option:selected').text();
  var tujuan      = $('.tujuan option:selected').text();
  var angkutan    = $('.angkutan option:selected').text();
  var asal_dt     = $('.asal').val();
  var tujuan_dt   = $('.tujuan').val();
  var angkutan_dt = $('.angkutan').val();
  var tarif       = $('.tarif').val();
  var Harga       = $('.harga').val();
  var keterangan  = $('.keterangan').val();
  // console.log(asal);




  datatable.row.add([
        '<div class="asal_text">'+asal+'</div>'+'<input type="hidden" class="asal_tb hitung_'+count+'" name="asal_tb[]" value="'+asal_dt+'" >'+'<input type="hidden" class="id_table" value="'+count+'" >',
        '<div class="tujuan_text">'+tujuan+'</div>'+'<input type="hidden" class="tujuan_tb" name="tujuan_tb[]" value="'+tujuan_dt+'" >',
        '<div class="angkutan_text">'+angkutan+'</div>'+'<input type="hidden" class="angkutan_tb" name="angkutan_tb[]" value="'+angkutan_dt+'" >',
        '<div class="tarif_text">'+tarif+'</div>'+'<input type="hidden" class="tarif_tb" name="tarif_tb[]" value="'+tarif+'" >',
        '<div class="harga_text">'+Harga+'</div>'+'<input type="hidden" class="harga_tb" name="harga_tb[]" value="'+Harga+'" >',
        '<div class="keterangan_text">'+keterangan+'</div>'+'<input type="hidden" class="keterangan_tb" name="keterangan_tb[]" value="'+keterangan+'" >',
        '<button align="center" type="button" class="btn btn-xs edit btn-warning" onclick="edit(this)"><i class="fa fa-pencil"></i></button>'+'&nbsp;<button align="center" type="button" class="btn btn-xs hapus btn-danger" onclick="hapus(this)"><i class="fa fa-trash"></i></button>',
        
    ]).draw(false);
  // console.log('asd');
  count++;
  var edit = $('.edit').closest('td');

  $(edit).css('text-align','center');

  var harga = $('.harga_tb').closest('td');

  $(harga).css('text-align','right');

  $('.modal').modal('hide');
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

  $('.modal').modal('hide');
}

$('#btnsimpan').click(function(){
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
      data:$('#form_header').serialize()+'&'+datatable.$('input').serialize(),
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
