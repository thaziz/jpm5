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
                                <td >
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
                                        <option value="L"> LAIN-LAIN </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="F"> NOTA/BIAYA LAIN</option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="disabled">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td>
                                    <select class="form-control cabang chosen-select-width" name="cb_cabang" >
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
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Customer</td>
                                <td>
                                    <select class="form-control customer chosen-select-width" name="customer" >
                                    @foreach ($customer as $row)
                                            <option selected="" value="{{ $row->kode }}">{{ $row->kode }} -  {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
 {{--                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Kas / Bank</td>
                                <td colspan="4">
                                    <select class="form-control" name="cb_kas_bank" >
                                        <option value="T"> TUNAI/CASH </option>
                                        <option value="C"> TRANSFER </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
                                    <input type="hidden" name="ed_kas_bank" value="{{ $data->jenis_pembayaran or null }}" >
                                </td>
                            </tr> --}}
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
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor CEK/BG</td>
                                <td>
                                    <input type="text"  class="form-control input-sm nomor_cek" name="nomor_cek">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px;">Akun Bank</td>
                                <td>
                                    <select class="form-control cb_jenis_pembayaran" name="akun_bank" >
                                        @foreach ($akun as $val)
                                            <option value="{{$val->mb_id}}">{{$val->mb_nama}}</option>
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
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <button type="submit" class="btn btn-primary" id="append">Append</button>
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

var table_data = $('#table_data').DataTable({
    paging:false,
    searching:false,
    columnDefs:[
        {
             targets: 3 ,
             className: 'center'
        },
        {
             targets: 1 ,
             className: 'right'
        },
        {
             targets: 2 ,
             className: 'center'
        },
    ],
});


$(document).ready(function(){
var cabang = $('.cabang').val();
      $.ajax({
        url  :baseUrl+'/sales/posting_pembayaran_form/nomor_posting',
        data : {cabang},
        success:function(data){
          $('.nomor_posting').val(data.nota);
        }
      })
});

$('#btn_kwitansi').click(function(){
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    var cabang = $('.cabang').val();
    var customer = $('.customer').val();
    
    if (cb_jenis_pembayaran != 'U') {
        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/cari_kwitansi',
            data : {cabang,cb_jenis_pembayaran,customer,array_simpan},
            success:function(data){
              $('.kirim').html(data);
              $('#modal').modal('show');

            }
        })
    }else{
        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/cari_uang_muka',
            data : {cabang,cb_jenis_pembayaran,customer,array_simpan},
            success:function(data){
              $('.kirim').html(data);
              $('#modal').modal('show');
            }
        })
    }
    
})
// check all
function check_parent(){
  var parent_check = $('.parent_box:checkbox:checked');
  if (parent_check.length >0) {

    table_modal_d.$('.tes:checkbox').prop('checked',true);
  }else if(parent_check.length==0) {
    table_modal_d.$('.tes:checkbox').removeAttr('checked');
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
$('#append').click(function(){
    var cabang = $('.cabang').val();
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    var nomor = [];

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
                table_data.row.add([
                    data.data[i].k_nomor+'<input type="hidden" value="'+data.data[i].k_nomor+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',
                    accounting.formatMoney(data.data[i].k_netto,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].k_netto+'" class="form-control d_netto" name="d_netto[]">',
                    '<input type="text" class="form-control d_keterangan" name="d_keterangan[]">',
                    '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                ]).draw();
            }
            $('#modal').modal('hide');
            hitung();
        }
    })

})

function hapus_detail(o) {
    var par = o.parentNode.parentNode;
    var arr = $(par).find('.d_nomor_kwitansi').val();
    var index = array_simpan.indexOf(arr);
    array_simpan.splice(index,1);

    table_data.row(par).remove().draw(false);
}

$('#btnsimpan').click(function(){
    swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data Kwitansi!",
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
          type:'get',
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
                        // location.reload();
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
