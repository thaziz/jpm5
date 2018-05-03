@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .disabled {
    pointer-events: none;
    opacity: 1;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Stock Opname </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Detail Stock Opname </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
  <form method="POST" id="formId" action="{{url('stockopname/updatestockopname')}}"  enctype="multipart/form-data" class="form-horizontal">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Membuat Laporan Stok Opname
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0" class="header table">
                           @foreach($data['stockopname'] as $so)
                            <tr>
                              <td>No Stock Opname</td>
                              <td>
                                <input type="text" readonly="" value="{{$so->so_nota}}" class="so form-control" name="so">
                                 <input type="hidden" value="{{$so->so_id}}" name="so_id">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                              </td>
                            </tr>
                           
                            <tr>
                              <td width="150px">
                                Lokasi Cabang
                              </td>
                              <td>
                                <input type="text" readonly="" value="{{$so->kode}} - {{$so->nama}}" 
                                class="so form-control">
                                 <input type="text" readonly="" value="{{$so->kode}}" 
                                class="so form-control" name="cabang2">
                              </td>
                            </tr>
                            
                          <tr>
                            <td width="150px">
                              Lokasi Gudang
                            </td>
                            <td>
                              <input type="text" readonly="" value="{{ $so->mg_namagudang }}" 
                               class="so form-control" >
                                <input type="text" readonly="" value="{{ $so->mg_id }}" 
                               class="so form-control" name="gudang">
                            </td>
                          </tr>
                          <tr>
                            <td> Bulan </td>
                            <td>   <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{Carbon\Carbon::parse($so->so_bulan)->format('d-M-Y')}}" disabled readonly>
                              </div>  </td>
                          </tr>
                          @endforeach
                          </table>

                      </div>

                    
                      </div>

                     
                      <table class="table">
                        <tr>
                          <td style="width:120px">
                          <h4> Detail Barang </h4> </td>
                        
                          <td>  <a class="btn btn-sm btn-warning" id="editdata" type="button"> <i class="fa fa-pencil"> </i> Edit Data </a> </td>
                        </tr>
                       
                      </table>
                      <div class="table-responsive">
                      <table class="table table-bordered  tbl-penerimabarang" id="addColumn">
                      <tr>
                        <th rowspan="2" style="text-align: center;">
                          No
                        </th>
                          <th rowspan="2" style="text-align: center;">
                            Nama Barang
                          </th>

                          <th rowspan="2" style="text-align: center;">
                           Satuan
                          </th>

                          <th colspan="2" style="text-align: center;">
                          Stock Barang
                          </th>
                          
                          <th colspan="2" style="text-align: center;">
                          Jumlah Selisih
                          </th>

                          <th rowspan="2" style="text-align: center;" >
                          Keterangan
                          </th>
                      </tr>
                      <tr>
                        <th width="100" style="text-align: center;"> Stock sistem </th>
                        <th width="100" style="text-align: center;"> Stock Real </th>
                        <th width="150" style="text-align: center;">Status Barang</th>
                        <th width="100px" style="text-align: center;">Jumlah Status</th>
                      </tr>

                      <tbody class="append">
                        @foreach($data['stockopnamedt'] as $index=>$sodt)
                          <tr>
                              <td align="center">
                              {{$index+1}} 
                              </td><td align="left">
                              {{$sodt->nama_masteritem}}

                              <input type="hidden" value="{{$sodt->sod_item}},{{$sodt->sod_idstock}}" name="sg_item[]">
                              </td><td align="left">
                              {{$sodt->unitstock}}
                              </td><td align="right">
                              <input type="text" readonly value="{{round($sodt->sod_jumlah_stock)}}" class="form-control fisik" name="stock[]" readonly=""> 
                              </td><td align="right">
                              <input type="number" class="form-control real edit" onkeyup="status(this)" name="real[]" value="{{round($sodt->sod_jumlah_real)}}" readonly="">
                              </td><td align="left">

                              <select class="form-control status  disabled">
                                @if($sodt->sod_status == 'lebih')
                                  <option value="lebih" selected="">Lebih</option>
                                  <option value="kurang">Kurang</option>
                                  <option value="sama">Sama</option>
                                @elseif($sodt->sod_status == 'kurang')
                                  <option value="lebih">Lebih</option>
                                  <option value="kurang" selected="">Kurang</option>
                                  <option value="sama">Sama</option>
                                @else
                                  <option value="lebih">Lebih</option>
                                  <option value="kurang" >Kurang</option>
                                  <option value="sama" selected="">Sama</option>
                               
                                @endif
                              </select>
                              </td>
                              
                              <td align="right">
                               <input type="number" readonly class="form-control val_status" name="val_status[]" value="{{(int)$sodt->sod_jumlah_status}}" readonly="">
                               <input type="hidden" readonly class="form-control status2" name="status[]" value="{{$sodt->sod_status}},{{(int)$sodt->sod_jumlah_status}}">
                              </td>

                              <td align="left">
                              <input type="text" class="form-control keterangan edit" readonly name="keterangan[]" value="{{$sodt->sod_keterangan}}"> </td> 
                              </td>
                          </tr>
                        @endforeach 
                      </tbody>
                      </table>
                      </div>
                    
                      <br>
                      <br>

                    </div>
                    </form>

             
                   
  

                <div class="box-footer">
                  <div class="pull-right">
                      <button class="btn btn-sm btn-success simpandata" type="submit">
                        <i class="fa fa-upload">
                        </i>
                        &nbsp; Simpan
                      </button>
                      </form>
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

  @if (Session::get('cabang') != '000')
  $( document ).ready(function() {
    cabang();
  });
  @endif

  $('#editdata').click(function(){
    $('.edit').attr('readonly' , false);
    $('.simpandata').show();
  })

  $('.simpandata').hide();

  function status(p){
  var par = p.parentNode.parentNode;
  var val = parseInt(p.value);
  var ss  = parseInt($(par).find('.fisik').val());

  if (val == ss) {
    $(par).find('.status').val('sama');
    $(par).find('.val_status').val('0');
    $(par).find('.status2').val('sama,0');
  } else if (val > ss) {
    $(par).find('.status').val('lebih');

    var temp = val - ss ;

    $(par).find('.val_status').val(temp);
    $(par).find('.status2').val('lebih,' + temp);
  } else if (val < ss) {
    $(par).find('.status').val('kurang');

    var temp = ss - val ;
    $(par).find('.val_status').val(temp);
    $(par).find('.status2').val('kurang,' + temp);
  }
  // console.log(val);
}

    $('.date').datepicker({
      format: "MM",

      // minViewMode: "months"
    });


    var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width5'     : {width:"100% !important"}
             }

    for (var selector in config1) {
               $(selector).chosen(config1[selector]);
              }  
   
   function cabang(){
    var val = $('.cabang_head').val();
    
    $.ajax({
      url:baseUrl + '/stockopname/cari_sm/' + val,
      success:function(response){
        $('.append').html('');

        var count = response.data;
        console.log(count.length);
        if (count.length != 0) {
        for(var i = 0 ; i<count.length; i++){
          var tot = i+1;
          var append = '<tr><td align="center">'
                       +tot
                       +'<input type="hidden" name="id_stock[]" value="'+response.data[i].sg_id+'">'
                       +'</td>'
                       +'<td>'+response.data[i].nama_masteritem
                       +'<input type="hidden" value="'+response.data[i].sg_item+","+response.data[i].sg_id+'" name="sg_item[]">'
                       +'</td>'
                       +'<td align="center">'+response.data[i].unitstock+'</td>'
                       +'<td><input type="text" readonly value="'+response.data[i].sg_qty+'" class="form-control fisik" name="stock[]"></td>'
                       +'<td><input type="number" class="form-control real" onkeyup="status(this)" name="real[]"></td>'
                       +'<td>'
                       +'<select class="form-control status disabled" name="status[]">'
                       +'<option value="lebih">Lebih</option>'
                       +'<option value="kurang">Kurang</option>'
                       +'<option value="sama">Sama</option>'
                       +'</select>'
                       +'</td>'
                       +'<td><input type="number" readonly class="form-control val_status" name="val_status[]"><input type="hidden" readonly class="form-control status2" name="status[]"></td>'
                       +'<td><input type="text" class="form-control keterangan" name="keterangan[]"></td></tr>'
          $('.append').append(append);
        }
      }else{
         var append = '<tr><td align="center" colspan="12">Data Tidak Ada</tr>'
          $('.append').append(append);
      }
      },
      error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
   }

function status(p){
  var par = p.parentNode.parentNode;
  var val = parseInt(p.value);
  var ss  = parseInt($(par).find('.fisik').val());

  if (val == ss) {
    $(par).find('.status').val('sama');
    $(par).find('.val_status').val('0');
     $(par).find('.status2').val('sama,0');
  } else if (val > ss) {
    $(par).find('.status').val('lebih');
      var temp = val - ss ;
    $(par).find('.val_status').val(temp);
    $(par).find('.status2').val('lebih,' + temp);
  } else if (val < ss) {
    $(par).find('.status').val('kurang');

    var temp = ss - val ;
    $(par).find('.val_status').val(temp);
      $(par).find('.status2').val('kurang,' + temp);

  }
  // console.log(val);
}


  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

/*$('.formId').submit(function(event){
  event.preventDefault();
  var post_url2 = $(this).attr("action");
  var form_data2 = $(this).serialize();
   swal({
    title: "Apakah anda yakin?",
    text: "Setujui Data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, setujui!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
  },
  function(){
  $.ajax({
    type : "post",
    data : form_data2,
    url : post_url2,
    dataType : 'json',
    success:function(){
      $('.confirm').click(function(){
        console.log('asd');
        $(this).addClass('disabled');
      });
      swal({
            title: "Berhasil!",
            type: 'success',
            text: "Data berhasil disimpan",
            timer: 900,
            showConfirmButton: true
            });

    },
    error:function(){

    }
  });  
 });
});*/

   $('#formId').submit(function(event){
        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Penerimaan Barang!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
        $.ajax({
          type : "post",
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){         
                swal({
                title: "Berhasil!",
                        type: 'success',
                        text: "Data berhasil disimpan",
                        timer: 900,
                       showConfirmButton: false
                        
                });
             },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      })

function getGudang(){
  var val = $('.cabangselect').val();
  $.ajax({
      type: "GET",
      data : {gudang: val},
      url : baseUrl + "/pengeluaranbarang/createpengeluaranbarang/get_gudang",
      dataType:'json',
      success: function(data)
      {   
        var gudang = '<option value="" selected="" disabled="">-- Pilih Gudang --</option>';

        $.each(data, function(i,n){
              gudang = gudang + '<option value="'+n.mg_id+'">'+n.mg_namagudang+'</option>';
        });

        $('#selectgudang').html(gudang);
      }
  })
}

</script>
@endsection
