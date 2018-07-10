@extends('main')

@section('title', 'dashboard')
<style type="text/css">
  .table-biaya{
    overflow-x: auto;
  }
  tbody tr{
    cursor: pointer;
  }
  th{
    text-align: center !important;
  }
  .center{
    text-align: center;
  }
  .kecil{
    width: 50px;
    
  }
  .datatable tbody tr td{
    padding-top: 16px;
  }
  .dataTables_paginate{
    float: right;
  }
  #modal-biaya .modal-dialog .modal-body{
    min-height: 340px;
  }
  .disabled {
    pointer-events: none;
    opacity: 0.4;
  }
  .search{
    margin-left: 5px;
  }
  h3{
    margin: 20px 5px;

  }
  .my-bg{
    background: #f0b7d6;
  }
  td{
    font-size: 14px;
  }


</style>
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2> Faktur Pembelian </h2>
    <ol class="breadcrumb">
      <li>
        <a>Home</a>
      </li>
      <li>
        <a>Purchase</a>
      </li>
      <li>
        <a> Transaksi Purchase</a>
      </li>
      <li class="active">
        <strong> Detail Faktur Pembelian </strong>
      </li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="ibox" style="padding-top: 10px;" >
      <div class="ibox-title"><h5>Detail Faktur Pembelian</h5>
        <a href="../fakturpembelian" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
        <a class="pull-right jurnal" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal</i></a>
        <a class="pull-right jurnal_um" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal Uang Muka</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-12">
          <div class="col-sm-6"  >
            <div class="header_vendor" style="text-align: center"><h3>Form Pembayaran Vendor</h3></div>
            <form class="form_vendor">
              <table class="table table_vendor">
                {{ csrf_field() }}
                <tr>
                  <td> Cabang </td>
                  @if(Auth::user()->punyaAkses('Faktur Pembelian','cabang'))
                  <td class="cabang_td">  
                    <select class="form-control chosen-select-width cabang" name="cabang">
                    @foreach($cabang as $cabang)
                      <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif>{{$cabang->kode}} - {{$cabang->nama}} </option>
                    @endforeach
                    </select>
                  </td>
                  @else
                  <td class="disabled"> 
                    <select class="form-control chosen-select-width disabled cabang" name="cabang">
                  @foreach($cabang as $cabang)
                      <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif>{{$cabang->kode}} - {{$cabang->nama}} </option>
                  @endforeach
                    </select> 
                  </td>
                  @endif
                </tr>
                <tr>
                  <td width="150px">
                    No Faktur
                  </td>
                  <td>
                  <input type="text" value="{{$bp->fp_nofaktur}}" class="form-control nofaktur" name="nofaktur" required="" readonly="">
                  <input type="hidden" value="{{$bp->fp_idfaktur}}" class="form-control idfaktur" name="idfaktur" required="" readonly="">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td><input type="text" readonly="" value="{{carbon\carbon::parse($bp->fp_tgl)->format('d/m/Y')}}" class="form-control tanggal_vendor tgl" name="tanggal_vendor"></td>
                </tr>
                <tr>
                  <td>Jatuh Tempo</td>
                  <td><input type="text" readonly="" value="{{carbon\carbon::parse($bp->fp_jatuhtempo)->format('d/m/Y')}}" class="form-control jatuh_tempo_vendor" name="jatuh_tempo_vendor"></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td><input type="text" value="Released" readonly="" class="form-control status" name="status"></td>
                </tr>
                <tr>
                  <td>Vendor</td>
                  <td class="disabled">
                    <select class="form-control chosen-select-width-vendor nama_vendor_baru nama_vendor" name="nama_vendor">
                      <option value="0">Pilih - Vendor</option>
                      @foreach ($vendor as $val)
                        <option @if($bp->fp_supplier == $val->kode) selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>No Invoice</td>
                  <td><input type="text" value="{{$bp->fp_noinvoice}}" class="form-control no_invoice" name="no_invoice"></td>
                </tr>
                <tr>
                  <td>Keterangan</td>
                  <td><input type="text" value="{{$bp->fp_keterangan}}" class="form-control keterangan" name="Keterangan_biaya"></td>
                </tr>
                <tr>
                  <td>Total Biaya</td>
                  <td><input readonly="" type="text" style="text-align: right" class="form-control total_vendor" value="0" name="total"></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button type="button" class="btn btn-primary tambah_data_vendor" ><i class="fa fa-plus"> Tambah Data</i></button>
                    <button type="button" class="btn btn-success simpan_data_vendor disabled" ><i class="fa fa-save"> Update Data</i></button>
                    <button type="button" class="btn btn-warning tt_vendor" ><i class="fa fa-book"> Form Tanda Terima</i></button>
                    <button type="button"  class="btn btn-primary uang_muka_vendor" ><i class="fa fa-money"> Uang Muka</i></button>
                    <button type="button" onclick="print_penerus()"  class="btn btn-danger pull-right print_vendor" ><i class="fa fa-print"></i></button>
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <div class="col-sm-12">
          <table class="table table-bordered table-hover table_do_vendor">
            <thead>
              <tr>
                <th>No</th>
                <th>Delivery Order</th>
                <th>Tanggal</th>
                <th>Total Tarif</th>
                <th>Tarif Vendor</th>
                <th width="300">Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@include('purchase.pembayaran_vendor.modal_do_vendor')
`
<div id="modal_show_um" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Uang Muka</h4>
      </div>
      <div class="modal-body bp_div_um">
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('extra_scripts')
<script type="text/javascript">
{{-- GLOBAL VARIABLE --}}
var index_vendor = 1;
var array_simpan = [0];

$('.tangal_vendor').datepicker({
  format:'dd/mm/yyyy'
});

$('.tgl').datepicker({
  format:'dd/mm/yyyy'
});

$('.jatuh_tempo_vendor').datepicker({
  format:'dd/mm/yyyy'
});

var table_do_vendor = $('.table_do_vendor').DataTable({
  sort:false,
  columnDefs: [
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets: 6,
                 className: 'center'
              },
              {
                 targets: 0,
                 className: 'center'
              },
              {
                 targets:4,
                 className: 'right'
              },
              {
                 targets:3,
                 className: 'right'
              },
            ],
});
var config_vendor = {
           '.chosen-select'               : {},
           '.chosen-select-deselect'      : {allow_single_deselect:true},
           '.chosen-select-no-single'     : {disable_search_threshold:10},
           '.chosen-select-no-results'    : {no_results_text:'Oops, nothing found!'},
           '.chosen-select-width-vendor'    : {width:"100%"}
        }
for (var selector in config_vendor) {
  $(selector).chosen(config_vendor[selector]);
}  

$('.tambah_data_vendor').click(function(){
  var nama_vendor = $('.nama_vendor').val();
  var cabang    = $('.cabang').val();
  var id    = {{$id}};
  $.ajax({
      url : baseUrl + '/fakturpembelian/cari_do_vendor_edit',
      data : {id,cabang,nama_vendor,array_simpan},
      type : "get",
      success : function(response){
      $('.vendor_div').html(response);
      $('#modal_show_vendor').modal('show');
    }
    }) 
})
$('.tt_vendor').click(function(){

    $('.notandaterima').val('{{$form_tt->tt_noform}}');

    if ('{{$form_tt->tt_kwitansi}}' == 'ADA') {
      $('#Kwitansi').prop('checked',true);
    }else{
      $('#Kwitansi').prop('checked',false);
    }

    if ('{{$form_tt->tt_suratperan}}' == 'ADA') {
      $('#SuratPerananAsli').prop('checked',true);
    }else{
      $('#SuratPerananAsli').prop('checked',false);
    }

    if ('{{$form_tt->tt_suratjalanasli}}' == 'ADA') {
      $('#SuratJalanAsli').prop('checked',true);
    }else{
      $('#SuratJalanAsli').prop('checked',false);
    }

    if ('{{$form_tt->tt_faktur}}' == 'ADA') {
      $('#FakturPajak').prop('checked',true);
    }else{
      $('#FakturPajak').prop('checked',false);
    }
    $('.lain_penerus').val('{{$form_tt->tt_lainlain}}');

    var agen_vendor = $('.nama_vendor').val();
    var jatuh_tempo = $('.jatuh_tempo_vendor').val();
    var total_jml   = $('.total_vendor').val();
    total_jml       = total_jml.replace(/[^0-9\-]+/g,"")*1;
    $('.supplier_tt').val(agen_vendor);
    $('.jatuhtempo_tt').val(jatuh_tempo);
    $('.totalterima_tt_vendor').val(accounting.formatMoney(total_jml, "Rp ", 2, ".",','));
    $('#modal_tt_vendor').modal('show');
})

$('.append_vendor').click(function(){
  var nomor_vendor = [];
  table_modal_vendor.$('.check_vendor').each(function(i){
    if ($(this).is(':checked') == true) {
      nomor_vendor.push(table_modal_vendor.$('.nomor_do_vendor').eq(i).text());
      console.log(nomor_vendor);
    }
  })
  $.ajax({
      url:baseUrl +'/fakturpembelian/append_vendor',
      data: {nomor_vendor},
      dataType:'json',
      success:function(data){
        for (var i = 0; i < data.data.length; i++) {

          @if(Auth::user()->punyaAkses('Rubah Tarif Vendor','aktif'))
            var total_tarif = '<input type="text" readonly class="v_total_tarif right form-control full" value="'+accounting.formatMoney(data.data[i].total_net, "", 0, ".",',')+'" name="v_total_tarif[]">';

            var tarif_vendor = '<input type="text" onkeyup="rubah_angka_vendor()" class="right v_tarif_vendor form-control full" value="'+accounting.formatMoney(data.data[i].total_vendo, "", 0, ".",',')+'" name="v_tarif_vendor[]">';
          @else 
            var total_tarif = '<input readonly type="text" value="'+accounting.formatMoney(data.data[i].total_net, "", 0, ".",',')+'"  class="right v_total_tarif form-control full" name="v_total_tarif[]">';
            var tarif_vendor = '<input readonly type="text" value="'+accounting.formatMoney(data.data[i].total_vendo, "", 0, ".",',')+'" class="right v_tarif_vendor form-control full" name="v_tarif_vendor[]">';
          @endif

          table_do_vendor.row.add([
              '<p class="v_id_text">'+index_vendor+'</p>',

              '<p class="v_nomor_do_text">'+data.data[i].nomor+'</p>'+
              '<input type="hidden" value="'+data.data[i].nomor+'" class="v_nomor_do" name="v_nomor_do[]">',

              '<p>'+data.data[i].tanggal+'</p>',

              total_tarif,

              tarif_vendor,

              '<input type="text" value="" class="full form-control v_keterangan" name="v_keterangan[]">',

              '<button onclick="hapus_vendor(this)" class="btn btn-danger" type="button"><i class="fa fa-trash"></i>',
            ]).draw();
          index_vendor++;
          array_simpan.push(data.data[i].nomor);
        }
        var temp = 0;
        table_do_vendor.$('.v_tarif_vendor').each(function(){
          temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
        })
        $('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))
        $('.nama_vendor_td').addClass('disabled');
        $('.cabang_td').addClass('disabled');
        $('.v_tarif_vendor').maskMoney({
        precision : 0,
        thousands:'.',
        allowZero:true,
        defaultZero: true
        });
    $('#modal_show_vendor').modal('hide');
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
})


function hapus_vendor(o) {
  var par   = $(o).parents('tr');
  var nomor = $(par).find('.v_nomor_do').val();
  var i     = array_simpan.indexOf(nomor);
  array_simpan.splice(i,1);
    table_do_vendor.row(par).remove().draw(false);

    var temp = 0;
    table_do_vendor.$('.v_tarif_vendor').each(function(){
      temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
    })
    if (temp == 0) {
      $('.nama_vendor_td').removeClass('disabled');
        $('.cabang_td').removeClass('disabled');
    }
    $('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))

}
function rubah_angka_vendor(){

  var temp = 0;
    table_do_vendor.$('.v_tarif_vendor').each(function(){
      temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
    })

    $('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))
}


$('.simpan_vendor_tt').click(function(){
  var selectOutlet = $('.nama_vendor').val();
  var cabang = $('.cabang').val();
  var totalterima_tt_subcon = $('.totalterima_tt_vendor').val();
  if (totalterima_tt_subcon == 'Rp 0,00') {
  toastr.warning('Nilai Tanda Terima Tidak Boleh Nol');
  }
    swal({
      title: "Apakah anda yakin?",
      text: "Simpan Data!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, Simpan!",
      cancelButtonText: "Batal",
      closeOnConfirm: true
    },
    function(){
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        $.ajax({
        url:baseUrl + '/fakturpembelian/simpan_tt',
        type:'get',
        dataType:'json',
        data:$('.tabel_tt_vendor :input').serialize()+'&'+'agen='+selectOutlet+'&'+$('.form_vendor :input').serialize()+'&'+$('.head1 :input').serialize()+'&cabang='+cabang,
        success:function(response){
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){

                  $('.simpan_data_vendor').removeClass('disabled');
                  $('.simpan_vendor_tt').addClass('disabled');
                  $('.tambah_data_vendor').addClass('disabled');
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
})


$('.simpan_data_vendor').click(function(){
  var temp = 0;
    $('.v_nomor_do').each(function(){
      temp+=1;
    })

    if (temp == 0) {
      toastr.warning('Tidak Ada Data');
      return 1;
    }

      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          $.ajax({
          url:baseUrl + '/fakturpembelian/update_vendor',
          type:'get',
          data:$('.head1 :input').serialize()
              +'&'+$('.table_vendor :input').serialize()
              +'&'+table_do_vendor.$('input').serialize(),
          success:function(response){
            if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                      $('.simpan_data_vendor').addClass('disabled');
                      $('.idfaktur').val(response.id);
                      $('.save_vendor_um').removeClass('disabled');
                      $('.uang_muka_vendor').removeClass('disabled');

                    });
            }else{
              swal({
                title: response.pesan,
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
})
// UANG MUKA

$('.vendor_dibayar_um').maskMoney({
        precision : 0,
        thousands:'.',
        allowZero:true,
        defaultZero: true
    });
var vendor_tabel_detail_um = $('.vendor_tabel_detail_um').DataTable();
$('.uang_muka_vendor').click(function(){
  $('.save_vendor_um').removeClass('disabled');
  $('#modal_um_vendor').modal('show');
})

function hitung_um_vendor() {
  var temp = 0;
  vendor_tabel_detail_um.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    temp+=b;
  })
    console.log(temp);

  $('.vendor_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));

}
  


var array_um1 = [];
var array_um2 = [];
var array_um1 = [0];
var array_um2 = [0];

$('.vendor_nomor_um').focus(function(){
  var sup = $('.nama_vendor_baru').val();
  if (sup == '0') {
    toastr.warning('Vendor Harus Diisi');
    return false;
  }

  $.ajax({
    url:baseUrl +'/fakturpembelian/vendor_um',
    data: {sup,array_um1,array_um2},
    success:function(data){
      console.log('asd');
      $('.bp_div_um').html(data);
      $('#modal_show_um').modal('show');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })

})
var id_um    = 1;

$('.vendor_tambah_um').click(function(){
  var nota = $('.vendor_nomor_um').val();
  var sup = $('.nama_vendor').val();
  var nofaktur = $('.nofaktur').val();
  var vendor_id_um = $('.vendor_id_um').val();
  var vendor_dibayar_um = $('.vendor_dibayar_um').val();
  vendor_dibayar_um   = vendor_dibayar_um.replace(/[^0-9\-]+/g,"")/1;





  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (vendor_dibayar_um == '' || vendor_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

 $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup},
    dataType:'json',
    success:function(data){

      $('.vendor_nomor_um').val(data.data.nomor);
      $('.vendor_tanggal_um').val(data.data.um_tgl);
      $('.vendor_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.vendor_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.vendor_keterangan_um').val(data.data.um_keterangan);

      if (vendor_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (vendor_id_um == '') {
        vendor_tabel_detail_um.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(vendor_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+vendor_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_vendor(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_vendor(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+vendor_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(vendor_dibayar_um);
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(vendor_dibayar_um, "", 2, ".",','));
      }
      hitung_um_vendor();
      $('.vendor_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um_vendor(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.vendor_id_um').val(tb_faktur_um);
  $('.vendor_nomor_um').val(tb_transaksi_um);
  $('.vendor_tanggal_um').val(tb_tanggal_text);
  $('.vendor_jumlah_um').val(tb_jumlah_um_text);
  $('.vendor_sisa_um').val(tb_sisa_um_text);
  $('.vendor_keterangan_um').val(tb_keterangan_um_text)
  $('.vendor_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um_vendor(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  vendor_tabel_detail_um.row(par).remove().draw(false);

  hitung_um();
}


$('.save_vendor_um').click(function(){

  var temp = 0;
  var vendor_total_um = $('.vendor_total_um').val();
  vendor_tabel_detail_um.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    console.log(b);
    temp+=b;
  })
  var total_jml = $('.total_vendor').val();
  total_jml   = total_jml.replace(/[^0-9\-]+/g,"")*1;

  if (temp > total_jml) {
    toastr.warning("Pembayaran Lebih Besar Dari Total Faktur");
    return false;
  }

  swal({
      title: "Apakah anda yakin?",
      text: "Simpan Data!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, Simpan!",
      cancelButtonText: "Batal",
      closeOnConfirm: true
    },
    function(){
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        $.ajax({
        url:baseUrl + '/fakturpembelian/update_vendor_um',
        type:'post',
        data:$('.head1 :input').serialize()
              +'&'+$('.table_vendor :input').serialize()
              +'&'+vendor_tabel_detail_um.$('input').serialize()+'&vendor_total_um='+vendor_total_um,
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   $('.save_vendor_um').addClass('disabled');
                   $('.uang_muka_vendor').addClass('disabled');
                   
                  });
          }else if(response.status == 0){
            swal({
              title: "Data Faktur Tidak Ada",
              type: 'error',
              timer: 900,
              showConfirmButton: true

            });
          }else if(response.status == 2){
            swal({
              title: "Status Faktur Pending",
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
})

@foreach($bpd as $i=>$val)
  var no_pod              = "{{$val->bpd_pod}}";
  var DEBET               = "{{$val->bpd_debit}}";
  var keterangan_biaya    = "{{$val->bpd_memo}}";
  var nominal             = "{{$val->bpd_nominal}}";
  var harga_do            = "{{$val->total_net}}";
  var tanggal             = "{{$val->tanggal}}";
  

  @if(Auth::user()->punyaAkses('Rubah Tarif Vendor','aktif'))
    var total_tarif = '<input type="text" readonly class="v_total_tarif right form-control full" value="'+accounting.formatMoney(harga_do, "", 0, ".",',')+'" name="v_total_tarif[]">';

    var tarif_vendor = '<input type="text" onkeyup="rubah_angka_vendor()" class="right v_tarif_vendor form-control full" value="'+accounting.formatMoney(nominal, "", 0, ".",',')+'" name="v_tarif_vendor[]">';
  @else 
    var total_tarif = '<input readonly type="text" value="'+accounting.formatMoney(harga_do, "", 0, ".",',')+'"  class="right v_total_tarif form-control full" name="v_total_tarif[]">';
    var tarif_vendor = '<input readonly type="text" value="'+accounting.formatMoney(nominal, "", 0, ".",',')+'" class="right v_tarif_vendor form-control full" name="v_tarif_vendor[]">';
  @endif

  table_do_vendor.row.add([
      '<p class="v_id_text">'+index_vendor+'</p>',

      '<p class="v_nomor_do_text">'+no_pod+'</p>'+
      '<input type="hidden" value="'+no_pod+'" class="v_nomor_do" name="v_nomor_do[]">',

      '<p>'+tanggal+'</p>',

      total_tarif,

      tarif_vendor,

      '<input type="text" value="'+keterangan_biaya+'" class="full form-control v_keterangan" name="v_keterangan[]">',

      '<button onclick="hapus_vendor(this)" class="btn btn-danger" type="button"><i class="fa fa-trash"></i>',
    ]).draw();

  index_vendor++;
  array_simpan.push(no_pod);
  var temp = 0;
  table_do_vendor.$('.v_tarif_vendor').each(function(){
    temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
  })
  $('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))
  $('.nama_vendor_td').addClass('disabled');
  $('.cabang_td').addClass('disabled');
  $('.v_tarif_vendor').maskMoney({
    precision : 0,
    thousands:'.',
    allowZero:true,
    defaultZero: true
  });
  $('#modal_show_vendor').modal('hide');
@endforeach

@foreach($um as $i=>$val)

  var nofaktur        = '{{$val->umfp_nofaktur}}';
  var nomor           = '{{$val->umfpdt_transaksibank}}';
  var um_tgl          = '{{$val->umfp_tgl}}';
  var um_nomorbukti   = '{{$val->umfpdt_notaum}}';
  var total_um        = '{{$val->umfpdt_jumlahum}}';
  var sisa_um         = '{{$val->bkkd_sisa_um + $val->umfpdt_dibayar}}';
  var bp_dibayar_um   = '{{$val->umfpdt_dibayar}}';
  var um_keterangan   = '{{$val->umfpdt_keterangan}}';
  console.log(nofaktur);

  vendor_tabel_detail_um.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+nomor+'">',

            '<p class="tb_tanggal_text">'+um_tgl+'</p>',

            '<p class="tb_um_um_text">'+um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(bp_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+bp_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_vendor(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_vendor(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
    id_um++;
    array_um1.push(nomor);
    array_um2.push(um_nomorbukti);
    hitung_um();
    $('.vendor_tabel_detail_um :input').val('');
@endforeach




function print_penerus() {
  var idfaktur = $('.idfaktur').val();
  console.log(idfaktur);
  window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
}


  function jurnal() {
    var id = '{{ $id }}';
    $.ajax({
        url:baseUrl + '/fakturpembelian/biaya_penerus/jurnal',
        type:'get',
        data:{id},
        success:function(data){
           $('.tabel_jurnal').html(data);
        },
        error:function(data){
            // location.reload();
        }
    }); 
  }

  function jurnal_um() {
    var id = '{{ $id }}';
    $.ajax({
        url:baseUrl + '/fakturpembelian/biaya_penerus/jurnal_um',
        type:'get',
        data:{id},
        success:function(data){
           $('.tabel_jurnal').html(data);
        },
        error:function(data){
            // location.reload();
        }
    }); 
  }

$('.jurnal').click(function(){
  $('.modal_jurnal').modal('show');
  jurnal();
})

$('.jurnal_um').click(function(){
  $('.modal_jurnal').modal('show');
  jurnal_um();
})

</script>
@endsection