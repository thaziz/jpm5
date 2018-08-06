

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
                    <div class="col-sm-6">
                      <table cellpadding="3" cellspacing="0" border="0" class="table">
                        @if (Auth::user()->punyaAkses('Invoice','cabang')) 
                        <tr id="filter_col1" data-column="0">
                            <td>Cabang</td>
                            <td align="center">
                              <select onchange="filtering()" class="form-control cabang chosen-select-width">
                                <option value="0">Pilih - Cabang </option>
                                @foreach ($cabang as $a)
                                  <option value="{{$a->kode}}">{{$a->kode}} - {{$a->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                        </tr>
                        @endif
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-12 append_table">
                    
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

<div class="modal fade" id="modal_pajak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                  <td>Nomor Pajak</td>
                  <td>
                    <input type="text" class="form-control nomor_pajak" name="nomor_pajak">
                    <input type="hidden" class="form-control invoice" name="invoice">
                </td>
              </tr>
              <tr>
                <td>PDF (max 1MB)</td>
                <td>
                  <div class="file-upload">
                    <div class="file-select">
                      <div class="file-select-name" id="noFile">Choose Image...</div> 
                      <input type="file" name="image" onchange="loadFile(event)" id="chooseFile">
                    </div>
                  </div>
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
                <td align="right" colspan="2"><button type="button" class="simpan_pdf btn btn-primary">Download PDF</button></td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary save_pajak" data-dismiss="modal">Save Pajak</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="row" style="padding-bottom: 50px;"></div>


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

@endsection



@section('extra_scripts')
<script type="text/javascript">


    $(document).ready(function(){
      var cabang = $('.cabang').val();
      $.ajax({
          url:baseUrl + '/sales/invoice/append_table',
          data:{cabang},
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
      var jenis_bayar = $('.jenis_bayar').val();
      $.ajax({
          url:baseUrl + '/sales/invoice/append_table',
          data:{cabang,jenis_bayar},
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
        var w = window.open(baseUrl+'/sales/cetak_nota/'+id);
        // var interval = setInterval(function(){ 
        $(w).ready(function(){
          var table = $('#tabel_data').DataTable();
          table.ajax.reload(); 
        })
        
        // }, 5000);
        // clearInterval(interval);
    }

    $(".nomor_pajak").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
       if (e.which != 8 && e.which != 0  && (e.which < 48 || e.which > 57 ) && e.which != 46  ) {
          //display error message
          
                 return false;
      }
     });

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
                         table.ajax.reload();
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
    $.ajax({
          url:baseUrl + '/sales/cari_faktur_pajak',
          data:{nomor},
          type:'get',
          dataType:'json',
          success:function(data){
            $('.nomor_pajak').val(data.data.i_faktur_pajak);
            if (data.data.i_image_pajak != null) {
              $('#output').attr('src','{{asset('perwita/storage/app/invoice')}}'+'/'+data.data.i_image_pajak);
              $('#noFile').text(data.data.i_image_pajak);
            }else{
              $('#noFile').text('Pilih FIle...');
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



$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>1048576) //do something if file size more than 1 mb (1048576)
  {
      return false;
  }
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen..."); 
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
  }
});

var loadFile = function(event) {
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>1048576) //do something if file size more than 1 mb (1048576)
  {
      iziToast.warning({
        icon: 'fa fa-times',
        message: 'File Is To Big!',
      });
      return false;
  }
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('output');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};

$('.save_pajak').click(function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formdata = new FormData();  
    formdata.append( 'files', $('#chooseFile')[0].files[0]);
       console.log(formdata);
    $.ajax({
          url:baseUrl + '/sales/pajak_invoice'+'?'+$('.table_pajak :input').serialize(),
          data:formdata,
          type:'POST',
          dataType:'json',
          processData: false,
          contentType: false,
          success:function(data){
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                        $('.invoice').val('');
                         var table = $('#tabel_data').DataTable();
                         table.ajax.reload();
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
            if (data.data.i_image_pajak !=null) {
               window.location.href = '{{asset('perwita/storage/app/invoice')}}'+'/'+data.data.i_image_pajak;
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

</script>
@endsection
