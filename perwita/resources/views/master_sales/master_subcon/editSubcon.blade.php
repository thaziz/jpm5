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
                     <a href="../subcon" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                                    <input type="text" name="kontrak_nomor" id="ed_nomor" readonly="readonly" class="form-control" style="text-transform: uppercase" value="{{$data->ks_nota}} " >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="ed_tanggal" value="{{$tgl3}}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="tgl1 form-control" name="ed_mulai" value="{{$tgl1}}">
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
                                <td colspan="3">
                                    <select class="chosen-select-width form-control id_subcon"  name="id_subcon" id="id_subcon" style="width:100%" >
                                        <option disabled="">- Pilih Subcon -</option>

                                        @foreach($sub as $val)
                                        @if($data->ks_nama == $val->kode)
                                        <option selected="" value="{{$val->kode}}">{{$val->nama}}</option>
                                        @else
                                        <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endif
                                        @endforeach

                                    </select>
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    <select class="form-control cabang chosen-select-width" name="cabang" >
                                      <option  disabled="">- Pilih Cabang -</option>
                                        @foreach($cabang as $val)
                                        @if($data->ks_cabang == $val->kode)
                                        <option selected="" value="{{$val->kode}}">{{$val->nama}}</option>
                                        @else
                                        <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" value="{{$data->ks_keterangan}}" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td>Aktif</td>
                                <td colspan="3">
                                  @if($data->ks_active == 'ACTIVE')
                                    <input type="checkbox" name="ck_aktif" checked="">
                                  @else
                                    <input type="checkbox" name="ck_aktif" >
                                  @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Tambah</button>
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
                      @foreach($subcon_dt as $i => $val)
                      <tr>
                        <td>
                          <div class="asal_text">{{$val->asal}}</div>
                          <input type="hidden" class="asal_tb hitung_{{$i}}" name="asal_tb[]" value="{{$val->id_asal}}">
                          <input type="hidden" class="id_table" value="{{$i}}">
                          <input type="hidden" class="id_ksd" value="{{$val->ksd_id}}">
                        </td>
                        <td>
                          <div class="tujuan_text">{{$val->tujuan}}</div>
                          <input type="hidden" class="tujuan_tb" name="tujuan_tb[]" value="{{$val->id_tujuan}}">
                        </td>
                        <td>
                          <div class="angkutan_text">{{$val->angkutan}}</div>
                          <input type="hidden" class="angkutan_tb" name="angkutan_tb[]" value="{{$val->kode_angkutan}}" >
                        </td>
                        <td>
                          <div class="tarif_text">{{$val->ksd_jenis_tarif}}</div>
                          <input type="hidden" class="tarif_tb" name="tarif_tb[]" value="{{$val->ksd_jenis_tarif}}" >
                        </td>
                        <td>
                          <div class="harga_text">{{number_format($val->ksd_harga,0,",",".")}}</div>
                          <input type="hidden" class="harga_tb" name="harga_tb[]" value="{{number_format($val->ksd_harga,0,",",".")}}" >
                        </td>
                        <td>
                            <div class="keterangan_text">{{$val->ksd_keterangan}}</div>
                            <input type="hidden" class="keterangan_tb" name="keterangan_tb[]" value="{{$val->ksd_keterangan}}" >
                        </td>
                        <td>
                            <button align="center" type="button" class="btn btn-xs edit btn-warning" onclick="edit(this)">
                            <i class="fa fa-pencil"></i></button>&nbsp;
                            <button align="center" type="button" class="btn btn-xs hapus btn-danger" onclick="hapus(this)"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Insert Edit Subcon</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal  kirim">
                                    <table id="table_data" class="table table-striped table-bordered table-hover">
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
                                                    <input type="hidden" class="form-control" name="crud" class="form-control">
                                                    <input type="hidden" class="form-control id_edit" class="form-control">
                                                    <input type="hidden" class="form-control" name="ed_nomor_kontrak" class="form-control">
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
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
                                                        <option value="KILOGRAM">KILOGRAM</option>
                                                        <option value="ONE WAY STANDART">ONE WAY STANDART</option>
                                                        <option value="EMBALASI STANDART">EMBALASI STANDART</option>
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

  $('.modal').modal('show');
});

var datatable = $('#table_data').DataTable({
                      'paging':false,
                      'searching':false
                });
var count = 0;
$(document).ready(function(){
count = <?php echo count($subcon_dt)?>;
});
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
        '<div class="asal_text">'+asal+'</div>'+'<input type="hidden" class="asal_tb hitung_'+count+'" name="asal_tb[]" value="'+asal_dt+'" >'+'<input type="hidden" class="id_table" value="'+count+'" >'+'<input type="hidden" class="id_ksd" value="0">',
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
    var id_ksd = $('.id_ksd').val();
    var par  = p.parentNode.parentNode;
   swal({
    title: "Apakah anda yakin?",
    text: "Hapus Data Terpilih!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
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
        url:baseUrl+'/master_subcon/cek_hapus',
        data: 'id='+id_ksd,
      success:function(response){
        
        if (response.status == 1) {
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil Dihapus",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                       // location.href='../buktikaskeluar/index';
            });

            datatable.row(par).remove().draw(false);

        }else{
            swal({
                title: "Data Terikat Data Lain",
                        type: 'error',
                        timer: 900,
                       showConfirmButton: true

            });
        }


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
      url:baseUrl + '/master_subcon/update_subcon',
      type:'get',
      data:'id={{$data->ks_id}}'+'&'+$('#form_header').serialize()+'&'+datatable.$('input').serialize(),
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   location.href='../subcon';
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
