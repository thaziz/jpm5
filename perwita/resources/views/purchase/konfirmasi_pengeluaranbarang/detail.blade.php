@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.warna{

  background: linear-gradient(141deg, #0fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);
}

.hide{
  display: none;
  /*height: 0px;*/
}
.mrg_high{
margin-right: 260px;
}
.mrg_low{
margin-right: 80px;
}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>  Pengeluaran Barang </h2>
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
                            <strong>  Pengeluaran Barang  </strong>
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
                    <h5> Konfirmasi Pengeluaran Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    
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
                          <div class="col-sm-5">

                          <table border="0" class="table">
                          <tr>
                            <td width="150px">
                              No BPPB
                            </td>
                            <td>
                             {{$data->pb_nota}}
                            </td>
                          </tr>
                          <tr>
                            <td> Tanggal </td>
                            <td>
                              {{$tgl}}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Keperluan Untuk
                            </td>

                            <td>
                             {{$data->pb_keperluan}}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <div class="pull-right">
                              <a class="btn btn-danger" href="{{url('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang')}}"> Kembali </a>
                               <a class="btn btn-success" onclick="approved()"><i class="fa fa-check"> Approve</i></a>
                             </div>
                            </td>
                          </tr>
                          </table>

                         </div>

                         </div>

                    </div>
                    </form>

                    <h4> Data Barang </h4>
                    <hr>
                <div class="box-body">
                <form class="form_input">
                  <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                     <tr >
                        <th class="warna" style="width:10px;text-align: center; ">NO</th>
                        <th class="warna" style="text-align: center; "> Nama Barang </th>
                        <th class="warna" style="text-align: center; width: 100px"> Jumlah yang diminta </th>
                        <th class="warna" style="text-align: center;"> Stock di Gudang </th>
                        <th class="warna" style="text-align: center; width: 50px"> Satuan </th>
                        <th class="warna" style="text-align: center;"> Keterangan </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data_dt as $i=> $val)
                      <tr>
                        <td align="center">
                          {{$i + 1}}
                          <input type="hidden" value="{{$val->pbd_id}}" name="pbd_id1[]">
                        </td>
                        <td>
                          <input type="hidden" value="{{$val->kode_item}}" name="">{{$val->nama_masteritem}}
                        </td>
                        <td align="center"><input type="text" readonly="" class="form-control input-sm" style="text-align: center" readonly="" value="{{$val->pbd_jumlah_barang}}">
                        </td>
                        <td width="180">
                          @if($temp[$i][0]->sum != null)
                          <input class="mrg_low ar form-control input-sm" readonly="" style="width: 50px;display: inline;" value="{{$temp[$i][0]->sum}}">
                          @else
                          <input class="mrg_low ar form-control input-sm" readonly="" style="width: 50px;display: inline;" value="0">
                          @endif
                            <i class="togel fa fa-angle-double-down btn btn-default btn-xs" title="pilih gudang">
                            </i>
                            <div class="box-detail hide flag2"  style="width: 350px; height: 100%;">
                            <hr>
                            <table class="table table-bordered ">
                              <thead>
                                <tr>
                                  <th class="warna" align="center">Nama Gudang</th>
                                  <th class="warna" align="center">Jml</th>
                                  <th class="warna" align="center">Qty</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($gudang as $i => $gud)
                                @foreach($gudang[$i] as $a => $gud1)
                                  @if($temp1[$i] == $val->pbd_nama_barang)
                                  <tr>
                                    <td>
                                      <input value="{{$gudang[$i][$a]['mg_namagudang']}}" type="text" class="form-control nama_gudang" readonly="" >
                                      <input type="hidden" value="{{$val->pbd_id}}" name="pbd_id[]">
                                      <input type="hidden" value="{{$gudang[$i][$a]['mg_id']}}" name="nama_gudang[]">
                                      <input type="hidden" value="{{$val->pbd_nama_barang}}" name="pbd_nama_barang[]">
                                    </td>
                                    <td align="center"><span class="jumlah_digudang">{{$jumlah[$i][$a]['qty']}}</span></td>
                                    <td align="center">
                                      @if($gudang[$i][$a]['mg_namagudang'] != 'null')
                                      <input type="text" value="" class="form-control" style="width: 50px"  name="jumlah_setuju[]">
                                      <input type="hidden" value="{{$gudang[$i][$a]['sg_id']}}" class="form-control" style="width: 50px"  name="sg_id[]">
                                      @else
                                      <input type="text" class="form-control" style="width: 50px" value="" readonly=""  name="jumlah_setuju[]">
                                      <input type="hidden" value="0" class="form-control" style="width: 50px"  name="sg_id[]">
                                      @endif
                                    </td>
                                  </tr>
                                  @endif
                                 @endforeach
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </td>
                        <td align="center">{{$val->unitstock}}</td>       
                        <td> <textarea type="text" class="keterangan_setuju form-control" name="Keterangan[]" value="{{$val->pbd_keterangan}}" style="min-width: 100%;max-width: 350px; max-height: 100%;min-height: 100%"> </textarea>   
                        </td>       
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </form>
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  


    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   
// var datatable = $('#addColumn').DataTable();

function approved(){

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
        url:baseUrl+'/konfirmasipengeluaranbarang/approve',
        data: $('.form_input').serialize()+'&id='+'{{$id}}',
        type:'post',
      success:function(response){
        if (response.status == 1) {
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       location.href='../konfirmasipengeluaranbarang';
                   // location.href='../subcon';
                     
            });

        }else if(response.status == 0){

            swal({
            title: "Harap Lengkapi Data",
                    type: 'warning',
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
var array = [];
 $('.togel').click(function(){
  var td = $(this).parents('td');
  var bd = $(td).find('.box-detail');
  var arrow = $('.ar');
  var togel = $(td).find('.togel');
  bd.slideToggle('slow');


  if (bd.hasClass('flag2')) {
    bd.removeClass('hide');
    bd.removeClass('flag2');
    bd.addClass('flager');
    arrow.addClass('mrg_high');
    arrow.addClass('tampil');
    arrow.removeClass('mrg_low');
    togel.addClass('fa-angle-double-up');
    togel.removeClass('fa-angle-double-down');
    array.push(1);
    console.log(array);

  }else if(bd.hasClass('flager')){
    arrow.removeClass('tampil');
    bd.addClass('flag2');

    array.pop();
    console.log(array);

    bd.removeClass('flager');
    // bd.addClass('hide');
    //  $(bd).each(function(){
    //   if ($(this).hasClass('flager')){
    //     array.push(1);
    //   }else{
    //     array.push(0);
    //   }
    // });
    var index = array.indexOf(1);
    console.log(index);
    if (index == -1) {
      arrow.removeClass('mrg_high');
      arrow.addClass('mrg_low');
    }
    togel.removeClass('fa-angle-double-up');
    togel.addClass('fa-angle-double-down');
  }
 });

// function cari_jumlah(p){
//   var par = p.parentNode.parentNode;
//   var kode_barang = $(par).find()
// }
</script>
@endsection
