@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
        .id {display:none; }
        .right { text-align: right; }

        .disabled {
            pointer-events: none;
            opacity: 1;
        }
        .center{
            text-align: center;
        }
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> POSTING PEMBAYARAN DETAIL
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../sales/posting_pembayaran" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                        <div class="box-body">
                      
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">

                            </table>
                        <div class="col-xs-6">
                        </div>
                    </div>
                </form>
                <form id="form_header" class="form-horizontal">
                    <div class="col-sm-6">
                        <table class="table table-striped table-bordered table-hover table_header1">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor Posting</td>
                                <td>
                                    <input type="text" readonly="" class="form-control input-sm nomor_posting" name="nomor_posting">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td class="tanggal_td">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control ed_tanggal" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px;">Jenis Posting</td>
                                <td>
                                    <select class="form-control cb_jenis_pembayaran" name="cb_jenis_pembayaran" >
                                        <option value="C"> TRANSFER </option>
                                        <option value="T"> TRANSFER KAS </option>
                                        <option value="L"> LAIN-LAIN </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="B"> NOTA/BIAYA LAIN </option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
                                </td>
                            </tr>
                            @if(Auth::user()->punyaAkses('Posting Pembayaran','cabang'))
                            <tr class="">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td class="cabang_td">
                                    <select onchange="ganti_nota()" class="form-control cabang chosen-select-width" name="cb_cabang" >
                                    @foreach ($cabang as $row)
                                        @if(Auth::user()->kode_cabang == $row->kode)
                                            <option selected="" value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @else
                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @else
                            <tr class="">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td class="cabang_td disabled">
                                    <select onchange="ganti_nota()" class="form-control cabang chosen-select-width" name="cb_cabang" >
                                    @foreach ($cabang as $row)
                                        @if(Auth::user()->kode_cabang == $row->kode)
                                            <option selected="" value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @else
                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="4" >
                                    <input type="text" name="ed_keterangan" class="form-control ed_keterangan" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-info " id="btn_kwitansi" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Pilih Nomor Kwitansi</button>
                                        <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table table_header2 table-striped table-bordered table-hover">
                        <tbody>
                         {{--    <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor CEK/BG</td>
                                <td>
                                    <input type="text"  class="form-control input-sm nomor_cek" name="nomor_cek">
                                </td>
                            </tr> --}}
                            <tr>
                                <td style="width:110px;">Akun Bank</td>
                                <td>
                                    <select class="form-control akun_bank chosen-select-width" name="akun_bank" >
                                        @foreach ($akun as $val)
                                            <option value="{{$val->mb_id}}">{{$val->mb_kode}} - {{$val->mb_nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                                    <tr>
                                        <td style="width:120px; padding-top: 0.4cm">Jumlah</td>
                                        <td colspan="4">
                                    <input type="text" class="form-control ed_jumlah_text" readonly="readonly" style="text-align: right">
                                    <input type="hidden" class="form-control ed_jumlah" name="ed_jumlah" readonly="readonly" style="text-align: right">
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Penerimaan</th>
                            <th>Customer</th>
                            <th>Jumlah</th>
                            <th>Nomor Cek</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{csrf_field()}}
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
                
                <!-- modal -->
                <div id="modal" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Pilih Nomor Penerimaan</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal  kirim">
                                    
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary append" id="append">Append</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal kas-->
                <div id="modal_kas" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detail Lain Lain</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal ">
                                    <table class="table ">
                                       <tr>
                                           <td>Kas</td>
                                           <td class="akun_dropdown">
                                               <select onchange="m_kode_akun()" class="form-control m_akun_kas chosen-select-width">
                                                        <option value="0">Pilih - Akun</option>
                                                    @foreach ($d_akun as $val)
                                                        <option value="{{$val->id_akun}}">{{$val->id_akun}}-{{$val->nama_akun}}</option>
                                                    @endforeach
                                               </select>
                                           </td>
                                       </tr>
                                       <tr>
                                           <td>Jumlah</td>
                                           <td>
                                               <input type="text" class="form-control m_jumlah_kas" value="0">
                                           </td>
                                       </tr>
                                       <tr>
                                           <td>Keterangan</td>
                                           <td>
                                               <input type="text" class=" form-control m_keterangan_kas">
                                           </td>
                                       </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary append" id="append">Append</button>
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
// datatable
var array_simpan = [];
var nomor = [0];

var table_data = $('#table_data').DataTable({
    paging:false,
    searching:false,
    columnDefs:[

        {
             targets: 1 ,
             className: 'left'
        },
        {
             targets: 2 ,
             className: 'right'
        },
        {
             targets: 3 ,
             className: 'center'
        },
        {
             targets: 4 ,
             className: 'center'
        },
        {
             targets: 5 ,
             className: 'center'
        },
    ],
});

$('.ed_tanggal').datepicker({
    format:'yyyy-mm-dd'
})

function ganti_akun() {
  var cabang = $('.cabang').val();
  $.ajax({
    url  :baseUrl+'/sales/posting_pembayaran_form/akun_dropdown',
    data : {cabang},
    success:function(data){
        $('.m_akun_kas').html('');
        for (var i = 0; i < data.data.length; i++) {
            var html = '<option value="'+data.data[i].id_akun+'">'+data.data[i].id_akun+' - '+data.data[i].nama_akun+'</option>';
            $('.m_akun_kas').append(html);
        }
        $('.m_akun_kas').trigger('chosen:updated');
    }
  })
}

$(document).ready(function(){
var cabang = $('.cabang').val();
  $.ajax({
    url  :baseUrl+'/sales/posting_pembayaran_form/nomor_posting',
    data : {cabang},
    success:function(data){
      $('.nomor_posting').val(data.nota);
    }
  })




$('.m_jumlah_kas').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
ganti_akun();
});



function ganti_nota() {
    var cabang = $('.cabang').val();
      $.ajax({
        url  :baseUrl+'/sales/posting_pembayaran_form/nomor_posting',
        data : {cabang},
        success:function(data){
          $('.nomor_posting').val(data.nota);
        }
      })
    ganti_akun()
}

$('#btn_kwitansi').click(function(){
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    var cabang = $('.cabang').val();
    var akun_bank = $('.akun_bank').val();
    var id = 0;
    if (cb_jenis_pembayaran == 'C'  || cb_jenis_pembayaran == 'F' || cb_jenis_pembayaran == 'B' || cb_jenis_pembayaran == 'T') {
        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/cari_kwitansi',
            data : {id,cabang,cb_jenis_pembayaran,array_simpan,akun_bank,nomor},
            success:function(data){
              $('.kirim').html(data);
              $('#modal').modal('show');

            }
        })
    }else if (cb_jenis_pembayaran == 'U') {
        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/cari_uang_muka',
            data : {cabang,cb_jenis_pembayaran,array_simpan,akun_bank},
            success:function(data){
              $('.kirim').html(data);
              $('#modal').modal('show');
            }
        })
    }else if (cb_jenis_pembayaran == 'L'){
        $('.m_jumlah_kas').val('');
        $('.m_keterangan_kas').val('');
        $('#modal_kas').modal('show');
    }
    
})
// check all
function check_parent(){
  var parent_check = $('.parent_box:checkbox:checked');
  if (parent_check.length >0) {

    table_modal_d.$('.tanda:checkbox').prop('checked',true);
  }else if(parent_check.length==0) {
    table_modal_d.$('.tanda:checkbox').removeAttr('checked');
  }

}
function hitung() {
    var temp = 0;
    $('.d_netto').each(function(){
        var temp1 = $(this).val();
        temp1     = parseFloat(temp1);
        temp     += temp1;
    });
    $('.ed_jumlah_text').val(accounting.formatMoney(temp,"",2,'.',','));
    $('.ed_jumlah').val(temp);
}

$('.append').click(function(){

    var cabang = $('.cabang').val();
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    var nomor = [];
    var tanggal = [];
    var ed_tanggal = $('.ed_tanggal').val();
if (cb_jenis_pembayaran == 'C'|| cb_jenis_pembayaran == 'F' || cb_jenis_pembayaran == 'B' || cb_jenis_pembayaran == 'T') {
    $('.tanda').each(function(){
        var check = $(this).is(':checked');
        if (check == true) {
            var par   = $(this).parents('tr');
            var inv   = $(par).find('.kwitansi_modal').val();
            var tgl   = $(par).find('.tanggal').text();
            nomor.push(inv);
            tanggal.push(tgl);
            array_simpan.push(inv);

        }  
    })

    $.ajax({
        url  :baseUrl+'/sales/posting_pembayaran_form/append',
        data : {nomor,cabang,nomor,cb_jenis_pembayaran,tanggal,ed_tanggal},
        dataType:'json',
        success:function(data){
            if (data.status == '1') {
                for (var i = 0; i < data.data.length; i++) {
                    if (cb_jenis_pembayaran == 'F') {
                        var cek = '<input type="text" value="" class="form-control d_cek" name="d_cek[]">';
                    }else{
                        var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';

                    }
                    table_data.row.add([
                        data.data[i].k_nomor+'<input type="hidden" value="'+data.data[i].k_nomor+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                        data.data[i].nama+'<input type="hidden" value="'+data.data[i].kode+'" class="form-control d_customer" name="d_customer[]">'+
                        '<input type="hidden" value="'+data.data[i].k_kode_akun+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                        accounting.formatMoney(data.data[i].k_netto,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].k_netto+'" class="form-control d_netto" name="d_netto[]">',
                        cek,

                        '<input type="text" class="form-control d_keterangan" placeholder="keterangan..." name="d_keterangan[]">',

                        '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                    ]).draw();
                }
                $('#modal').modal('hide');
                hitung();
                $('.cb_jenis_pembayaran').addClass('disabled');
                $('.cabang_td').addClass('disabled');
                $('.tanggal_td').addClass('disabled');
                $('.ed_tanggal').prop('readonly',true);
            }else if(data.status == '0'){
                return toastr.warning('Tanggal Kwitansi Tidak Boleh Melebihi Tanggal Posting');
                $('#modal').modal('hide');
            }
        }
    })

}else if (cb_jenis_pembayaran == 'U'){
    $('.tanda').each(function(){
        var check = $(this).is(':checked');
        if (check == true) {
            var par   = $(this).parents('tr');
            var inv   = $(par).find('.kwitansi_modal').val();
            nomor.push(inv);
            array_simpan.push(inv);

        }  
    })

    $.ajax({
        url  :baseUrl+'/sales/posting_pembayaran_form/append',
        data : {nomor,cabang,nomor,cb_jenis_pembayaran},
        dataType:'json',
        success:function(data){
            for (var i = 0; i < data.data.length; i++) {

     
                var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';


                table_data.row.add([
                    data.data[i].nomor+'<input type="hidden" value="'+data.data[i].nomor+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                    data.data[i].nama+'<input type="hidden" value="'+data.data[i].nama+'" class="form-control d_customer" name="d_customer[]">'+
                    '<input type="hidden" value="'+data.data[i].kode_acc+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                    accounting.formatMoney(data.data[i].jumlah,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].jumlah+'" class="form-control d_netto" name="d_netto[]">',
                    cek,
                    '<input type="text" class="form-control d_keterangan" placholder="keterangan..." name="d_keterangan[]">',

                    '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                ]).draw();
            }
            $('#modal').modal('hide');
            hitung();
            $('.cb_jenis_pembayaran').addClass('disabled');
            $('.cabang_td').addClass('disabled');
        }
    })
}else{
 var m_akun_kas       = $('.m_akun_kas').val();
 var m_akun_kas_text  = $('.m_akun_kas option:selected').text();
 var m_jumlah_kas     = $('.m_jumlah_kas').val();
 var m_keterangan_kas = $('.m_keterangan_kas').val();
 m_jumlah_kas         = m_jumlah_kas.replace(/[^0-9\-]+/g,"");

 var m_keterangan_kas = $('.m_keterangan_kas').val();
            var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';

            table_data.row.add([
                m_akun_kas_text+'<input type="hidden" value="NON KWITANSI" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                'NON CUSTOMER'+'<input type="hidden" value="'+'NON CUSTOMER'+'" class="form-control d_customer" name="d_customer[]">'+
                '<input type="hidden" value="'+m_akun_kas+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                accounting.formatMoney(m_jumlah_kas,"",2,'.',',')+'<input type="hidden" value="'+m_jumlah_kas+'" class="form-control d_netto" name="d_netto[]">',
                cek,

                '<input type="text" class="form-control d_keterangan" value="'+m_keterangan_kas+'"  placholder="keterangan..." name="d_keterangan[]">',

                '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
            ]).draw();
            $('#modal_kas').modal('hide');
            hitung();
            $('.cb_jenis_pembayaran').addClass('disabled');
            $('.cabang_td').addClass('disabled');
}
})
function m_kode_akun(argument) {
   var jenis =  $('.m_akun_kas').find(':selected').data('kode_acc');
   $('.m_data_acc').val(jenis);
}
function hapus_detail(o) {
    var par = o.parentNode.parentNode;
    var arr = $(par).find('.d_nomor_kwitansi').val();
    var index = array_simpan.indexOf(arr);
    array_simpan.splice(index,1);

    var temp = 0;

    table_data.row(par).remove().draw(false);

    $('.d_nomor_kwitansi').each(function(){
        temp+=1;
    });
    if (temp == 0) {
        $('.cb_jenis_pembayaran').removeClass('disabled');
        $('.cabang_td').removeClass('disabled');
        $('.tanggal_td').removeClass('disabled');
        $('.ed_tanggal').prop('readonly',false);
    }
    hitung();
}

$('#btnsimpan').click(function(){
    var temp  = [];
    var temp1 = 0;
    var temp2 = [];
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    table_data.$('.d_keterangan').each(function(){
        if ($(this).val() != '') {
            temp.push(1);
        }else{
            temp.push(0);
        }
        temp1=1;
    });

    
    if (temp1 == 0) {
        toastr.warning('Tidak Ada Yang Di Posting');
        return 1;
    }

    var index = temp.indexOf(0);
    if (index != -1) {
        toastr.warning('Kolom Keterangan Pada Sequence Harus Diisi');
        return 1;
    }
    if (cb_jenis_pembayaran == 'F') {
        table_data.$('.d_cek').each(function(){
            if ($(this).val() != '') {
                temp2.push(1);
            }else{
                temp2.push(0);
            }
        });

        var index1 = temp2.indexOf(0);
        if (index1 != -1) {
            toastr.warning('Nomor Cek Harus Diisi');
            return 1;
        }
    }
    

    


    swal({
        title: "Apakah anda yakin?",
        text: "Update Data!",
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
          url:baseUrl + '/sales/posting_pembayaran_form/simpan_posting',
          type:'post',
          dataType:'json',
          data:$('.table_header1 :input').serialize()
               +'&'+$('.table_header2 :input').serialize()
               +'&'+table_data.$('input').serialize(),
          success:function(response){
            if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                        window.location.href='{{url('sales/posting_pembayaran')}}';
                });
            }else{
                $('#nota_kwitansi').val(response.nota);
                toastr.info('Nomor Kwitansi Telah Dirubah Menjadi '+response.nota);
                $('#btnsimpan').click();
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

</script>
@endsection
