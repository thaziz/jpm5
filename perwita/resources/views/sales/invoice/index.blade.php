

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
                    <h2> INVOICE </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                            <a>Penjualan</a>
                        </li>
                        <li>
                            <a>Transaksi Penjualan</a>
                        </li>
                        <li class="active">
                            <strong> INVOICE </strong>
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
                    <h5 style="margin : 8px 5px 0 0"> 
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">
                  <div class="col-sm-12">
                    <div class="col-sm-12">
                      <table cellpadding="3" cellspacing="0" border="0" class="table filter table-bordered">
                        <tr>
                            <td align="center">Tanggal Awal</td>
                            <td align="center">
                              <input type="text" class="tanggal_awal form-control date" name="tanggal_awal">
                            </td>
                            <td align="center">Tanggal Akhir</td>
                            <td align="center">
                              <input type="text" class="tanggal_akhir form-control date" name="tanggal_akhir">
                            </td>
                        </tr>
                        <tr id="filter_col1" data-column="0">
                          @if (Auth::user()->punyaAkses('Biaya Penerus Kas','cabang')) 
                            <td align="center">Cabang</td>
                            <td >
                              <select class="form-control cabang chosen-select-width" onchange="filtering()" name="cabang">
                                <option value="0">Pilih - Cabang </option>
                                @foreach ($cabang as $a)
                                  <option value="{{$a->kode}}">{{$a->kode}} - {{$a->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                          @endif
                            <td align="center">Jenis Pembayaran</td>
                            <td align="center">
                              <select onchange="filtering()" class="form-control jenis_bayar chosen-select-width">
                                <option value="0">Pilih - Jenis </option>
                                <option value="PAKET">PAKET</option>
                                <option value="KORAN">KORAN</option>
                                <option value="KARGO">KARGO</option>
                              </select>
                            </td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right">
                            Cari Berdasarkan Nota / Nomor Seri Pajak
                          </td>
                          <td>
                            <input type="text" class="nota form-control" name="nota">
                          </td>
                          <td align="center">
                            <button class="search btn btn-success" type="button" onclick="filtering_nota()"><i class="fa fa-search"> Cari Berdasarkan Nota/Pajak</i></button>
                            <button class="search btn btn-danger" type="button" onclick="filtering()"><i class="fa fa-search"> Cari</i></button>
                            <button class=" btn btn-warning jurnal_all" type="button" ><i class="fa fa-eye"></i></button>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-12 append_table" style="overflow-x: scroll;">
                    
                  </div>
                    
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

<div class="modal modal_jurnal fade" id="modal_pajak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Faktur Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <table class="table table_pajak">
              <tr>
                  <td width="350">Nomor Pajak</td>
                  <td>
                    <input readonly="" type="text" placeholder="klik disini untuk memilih faktur" class="form-control nomor_pajak" name="nomor_pajak">
                    <input type="hidden" class="form-control id_pajak" name="id_pajak">
                    <input type="hidden" class="form-control invoice" name="invoice">
                </td>
              </tr>
              <tr hidden="">
                <td>Preview</td>
                <td align="left">
                  <div class="preview_td">
                      <img style="width: 150px;height: 200px;border:1px solid pink" id="output" >
                  </div>
                </td>
              </tr>
              <tr>
                <td align="left" class="preview_div">
                  Upload PDF
                  <div class="file-upload upl_1" style="width: 100%;">
                      <div class="file-select">
                          <div class="file-select-button fileName" >PDF</div>
                          <div class="file-select-name noFile tag_image_1" >PDF OR IMAGE</div> 
                          <input type="file" class="chooseFile upload_pdf" name="image">
                      </div>
                  </div>
                <td align="right">
                  <button type="button" class="simpan_pdf btn btn-danger">Download PDF</button>
                </td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary save_pajak" data-dismiss="modal">Save PDF</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal  fade" id="modal_jurnal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Jurnal Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body tabel_jurnal">
          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal  fade" id="modal_faktur_pajak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Faktur Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body append_modal">
            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection



@section('extra_scripts')
<script type="text/javascript">


    $(document).ready(function(){
      var cabang = $('.cabang').val();
      if (cabang == 'undefined' || cabang == null || cabang == undefined) {
        cabang = 0;
      }
      var jenis_bayar = $('.jenis_bayar').val();
      $.ajax({
          url:baseUrl + '/sales/invoice/append_table',
          data:$('.filter input').serialize()+'&flag=global'+'&cabang='+cabang+'&jenis_biaya='+jenis_bayar,
          type:'get',
          success:function(data){
            $('.append_table').html(data);
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
    })


function filtering() {
  var cabang = $('.cabang').val();
  if (cabang == 'undefined' || cabang == null || cabang == undefined) {
    cabang = 0;
  }
  var jenis_bayar = $('.jenis_bayar').val();
  $.ajax({
      url:baseUrl + '/sales/invoice/append_table',
      data:$('.filter input').serialize()+'&flag=global'+'&cabang='+cabang+'&jenis_biaya='+jenis_bayar,
      type:'get',
      success:function(data){
        $('.append_table').html(data);
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
}

function filtering_nota() {
  if ($('.nota').val() == '') {
    return toastr.warning('Kode Nota Harus Diisi');
  }
  $.ajax({
      url:baseUrl + '/sales/invoice/append_table',
      data:$('.filter input').serialize()+'&flag=nota',
      type:'get',
      success:function(data){
        $('.append_table').html(data);
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
}
    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/invoice_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function edit(id){
        var id = id.replace(/\//g, "-");
        window.location.href = baseUrl + '/sales/edit_invoice/'+id;
    }
    function lihat(id){
        var id = id.replace(/\//g, "-");
        window.open(baseUrl + '/sales/lihat_invoice/'+id);
    }


    function ngeprint(id){
        var id = id.replace(/\//g, "-");
        $.ajax({
          url:baseUrl + '/sales/cetak_nota/'+id,
          type:'get',
          success:function(data){
            var w = window.open(baseUrl+'/sales/cetak_nota/'+id);
            var table = $('#tabel_data').DataTable();
            table.ajax.reload( null, false );
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
    }

    function hapus(id){
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
          url:baseUrl + '/sales/hapus_invoice',
          data:{id},
          type:'get',
          success:function(data){
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                         var table = $('#tabel_data').DataTable();
                         table.ajax.reload( null, false );
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

function faktur_pajak(nomor) {
    $('.invoice').val(nomor);
    $('.nomor_pajak').val('');
    $.ajax({
          url:baseUrl + '/sales/cari_faktur_pajak',
          data:{nomor},
          type:'get',
          dataType:'json',
          success:function(data){
            if (data.data != null) {
              $('.nomor_pajak').val(data.data.i_faktur_pajak);
              $('.id_pajak').val(data.data.i_id_pajak);
            }
            if (data.data.nsp_pdf != null) {
              $('.noFile').text(data.data.nsp_pdf);
              $('.file-upload').addClass('active');
            }else{
              $('.noFile').text('Belum Upload PDF');
              $('.file-upload').removeClass('active');
            }
            $('#modal_pajak').modal('show');
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
}



     {{-- GAMBAR --}}
    $('.chooseFile').bind('change', function () {
        var filename = $(this).val();
        var fsize = $(this)[0].files[0].size;
        if(fsize>1048576) //do something if file size more than 1 mb (1048576)
        {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'File Is To Big!',
          });
          return false;
        }
        var parent = $(this).parents(".preview_div");
        if (/^\s*$/.test(filename)) {
            $(parent).find('.file-upload').removeClass('active');
            $(parent).find(".noFile").text("No file chosen..."); 
        }
        else {
            $(parent).find('.file-upload').addClass('active');
            $(parent).find(".noFile").text(filename.replace("C:\\fakepath\\", "")); 
        }
        load(parent,this);
    });

    function load(parent,file) {
        var fsize = $(file)[0].files[0].size;
        if(fsize>2048576) //do something if file size more than 1 mb (1048576)
        {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'File Is To Big!',
          });
          return false;
        }
        var reader = new FileReader();
        reader.onload = function(e){
            $(parent).find('.output').attr('src',e.target.result);
        };
        reader.readAsDataURL(file.files[0]);
    }


$('.save_pajak').click(function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var file_data = $('.upload_pdf').prop('files')[0];
    var formData = new FormData();
    formData.append('file', file_data);
    $.ajax({
          url:baseUrl + '/sales/pajak_invoice'+'?'+$('.table_pajak :input').serialize(),
          type:'POST',
          dataType:'json',
          data:formData,
          processData: false,
          contentType: false,
          success:function(data){
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Simpan PDF Berhasil",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                        $('.invoice').val('');
                         var table = $('#tabel_data').DataTable();
                         table.ajax.reload( null, false );
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
})

$('.simpan_pdf').click(function(e) {
    e.preventDefault();  //stop the browser from following
    var nomor = $('.invoice').val();
    $.ajax({
          url:baseUrl + '/sales/cari_faktur_pajak',
          data:{nomor},
          type:'get',
          dataType:'json',
          success:function(data){
            if (data.data!=null) {
               window.open('{{asset('perwita/storage/app')}}'+'/'+data.data.nsp_pdf);
            }
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


function lihat_jurnal(id){
    $.ajax({
        url:baseUrl + '/sales/kwitansi/jurnal',
        type:'get',
        data:{id},
        success:function(data){
           $('.tabel_jurnal').html(data);
           $('#modal_jurnal').modal('show');
        },
        error:function(data){
            // location.reload();
        }
    }); 
}

$('.jurnal_all').click(function(){
  $.ajax({
      url:baseUrl + '/sales/invoice/jurnal_all',
      type:'get',
      success:function(data){
         $('.tabel_jurnal').html(data);
         $('#modal_jurnal').modal('show');
      },
      error:function(data){
          // location.reload();
      }
  }); 
})

function pilih_pajak(a) {
  var nomor = $(a).find('.nsp_nomor_pajak').val();
  var id    = $(a).find('.nsp_id').val();

  $('.nomor_pajak').val(nomor);
  $('.id_pajak').val(id);
  $('#modal_faktur_pajak').modal('hide');
}
</script>
@endsection
