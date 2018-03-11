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
                            <strong> Create Stock Opname </strong>
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
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST"> 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0" class="header table">
                            <tr>
                              <td>No Stock Opname</td>
                              <td>
                                <input type="text" readonly="" value="{{$pb}}" class="so form-control" name="so">
                              </td>
                            </tr>
                          <tr>
                            <td width="150px">
                              Lokasi Gudang
                            </td>
                            <td>
                              <select class="form-control chosen-select-width5 cabang_head" onchange="cabang()">
                                <option value="">- Pilih - Gudang -</option>
                                @foreach($cabang as $val)
                                <option value="{{$val->mg_id}}">{{$val->mg_cabang}} - {{$val->mg_namagudang}}</option>
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td> Bulan </td>
                            <td>   <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$now}}" name="tgl">
                              </div>  </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right">
                              <a class="btn btn-warning" href={{url('stockopname/stockopname')}}> Kembali </a>
                              <input type="button" name="submit" value="Simpan"  class="btn btn-success simpan">
                            </td>
                          </tr>

                          </table>

                      </div>

                    
                      </div>

                      <hr>
                      
                      <h4> Detail Barang </h4>
                      <br>
                       <!-- <a class="btn btn-success" id="tmbh_data_barang"> Tambah Data </a> -->
                       <br>
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
                          <tr>
                              <td align="center" colspan ="12">
                              data tidak ada
                              </td>
                          </tr>
                      </tbody>
                      </table>
                      </div>
                    
                      <br>
                      <br>

                    </div>
                    </form>

             
                   
  

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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">


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
    console.log(val);
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
                       +'<input type="hidden" value="'+response.data[i].sg_item+'" name="sg_item[]">'
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
                       +'<td><input type="number" readonly class="form-control val_status" name="val_status[]"></td>'
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
  } else if (val > ss) {
    $(par).find('.status').val('lebih');

    var temp = val - ss ;

    $(par).find('.val_status').val(temp);
  } else if (val < ss) {
    $(par).find('.status').val('kurang');

    var temp = ss - val ;
    $(par).find('.val_status').val(temp);

  }
  // console.log(val);
}

$('.simpan').click(function(){
  var val = $('.cabang_head').val();
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
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $.ajax({
    url:baseUrl + '/stockopname/save_stock_opname',
    data: $('.header :input').serialize()+'&'+$('#addColumn :input').serialize()+'&cabang='+val,
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
            },function(){
               location.href='../stockopname/stockopname';
                   // location.href='../subcon';
                     
            });

    },
    error:function(){

    }
  });  
 });
});

</script>
@endsection
