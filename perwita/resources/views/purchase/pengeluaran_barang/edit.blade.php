@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.warna{
  background: linear-gradient(141deg, #0fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);
}
 .disabled {
    pointer-events: none;
    opacity: 0.4;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pengeluaran Barang </h2>
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
                            <strong> Create Pengeluaran Barang  </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- tabel data resi -->
    <div class="ibox valid_key" style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Tabel Data Resi</h5>
        <a href="../pengeluaranbarang" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6 ">          
          <table class="table resi_body">
            <tr>
              <td>Kode SPPB</td>
              <td>
                <input type="text" readonly="" name="no_sppb" class="form-control no_sppb input-sm" value="{{$data->pb_nota}}">
                <input type="hidden"   class="form-control id_sppb input-sm" value="">
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td>
                <input type="text" name="tgl" class="form-control date input-sm"  value="{{$tgl}}">
              </td>
            </tr>
            <tr>
              <td>Jenis Pengeluaran</td>
              <td>
                <select class="jenis_keluar form-control" name="jp">
                  @if($data->pb_jenis_keluar == 'Moving Gudang')
                  <option selected="">Moving Gudang</option>
                  <option>Pemakaian Reguler</option>
                  @else
                  <option>Moving Gudang</option>
                  <option selected="">Pemakaian Reguler</option>
                  @endif
                </select>
              </td>
            </tr>
            <tr>
              <td>Keperluan untuk</td>
              <td>
                <input type="text" name="keperluan" value="{{$data->pb_keperluan}}" class="form-control input-sm keperluan" value="">
              </td>
            </tr>
            <tr>
              <td>Cabang Penyedia</td>
              <td class="disabled">
                <select class="form-control cabang"  name="cabang"> 
                  @foreach($cabang as $val)
                    @if($val->kode == $data->pb_comp)
                      <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                    @else
                      <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                    @endif
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td>Cabang Bagian Peminta</td>
              <td>
                <select class="form-control cabang_peminta" id="cabang" name="cabang_peminta" onchange="getCabang()"> 
                  @foreach($cabang as $val)
                    @if($val->kode == $data->pb_peminta)
                      <option  value="{{ $val->kode }}">{{$val->kode}} - {{$val->nama}}</option>
                    @else
                      <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                    @endif
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td>Tujuan Gudang</td>
              <td>
                <select class="form-control gudang_peminta" id="gudang" name="gudang_peminta" style="width:100%" >
                      
                </select>

              </td>
            </tr>
            <tr>
              <td>Nama Peminta</td>
              <td>
                <input type="text" name="peminta" value="{{$data->pb_nama_peminta}}" class="peminta form-control input-sm">
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()" ><i class="fa fa-refresh">&nbsp;Reload</i></button>
                <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_patty disabled"  onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>
                <button class="btn btn-primary simpan pull-right" onclick="simpan()"><i class="fa fa-save"> Update</i></button>
              </td>
            </tr>
          </table>     
        </div>
        <div class="col-sm-12 data_barang" style="margin-bottom: 200px">
          <br>
          <br>
          <hr>
          <table class="table tabel_barang table-bordered table-striped" >
            <thead >
              <th style="text-align: center;" class="warna">Nama Barang</th>
              <th style="text-align: center;" class="warna">Akun Biaya</th>
              <th style="text-align: center;" class="warna">Nopol Kendaraan</th>
              <th style="text-align: center;" class="warna">Stock Gudang</th>
              <th style="text-align: center;" class="warna">Jumlah Diminta</th>
              <th style="text-align: center;" class="warna">Satuan</th>
              <th style="text-align: center;" class="warna">Aksi</th>
            </thead>
            <tbody class="clone_barang">
              @foreach($data_dt as $i=>$val)
              @if($count == 1)
              <tr>
                <td width="300">
                  <select class="form-control chosen-select-width5 cari_stock" name="nama_barang[]">
                        <option value="0" >- Pilih Barang -</option>
                        @foreach($item as $vald)
                          @if($vald->kode_item == $val->pbd_nama_barang)
                          <option selected="" value="{{$vald->kode_item}}">{{$vald->kode_item}} - {{$vald->nama_masteritem}}</option>
                          @else
                          <option value="{{$vald->kode_item}}">{{$vald->kode_item}} - {{$vald->nama_masteritem}}</option>
                          @endif
                        @endforeach
                  </select>
                </td>
                <td width="300" class="akun_biaya_dropdown">
                  <select class="form-control akun_biaya chosen-select-width" name="akun_biaya[]">
                    
                  </select>
                </td>
                <td align="center">
                      <input type="text" name="nopol[]" value="{{$val->pbd_nopol}}"  class="form-control nopol" readonly="" onkeyup="cariDATA()">
                    </td>
                <td align="center">
                  <input type="text" readonly="" name="stock_gudang[]" value="0"  class="form-control stock_gudang">
                </td>
                <td align="center">
                  <input type="number" name="diminta[]" value="{{$val->pbd_jumlah_barang}}" class="form-control diminta">
                </td>
                <td align="center">
                  <input type="text" readonly="" class="form-control satuan">
                </td>
                <td align="center" class="clone_append" width="">
                  <button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>
                </td>
              </tr>
              @else
                @if($i != count($data_dt)-1)
                  <tr>
                    <td width="300">
                      <select class="form-control chosen-select-width5 cari_stock" name="nama_barang[]">
                        <option value="0" >- Pilih Barang -</option>
                        @foreach($item as $vald)
                          @if($vald->kode_item == $val->pbd_nama_barang)
                          <option selected="" value="{{$vald->kode_item}}">{{$vald->kode_item}} - {{$vald->nama_masteritem}}</option>
                          @else
                          <option value="{{$vald->kode_item}}">{{$vald->kode_item}} - {{$vald->nama_masteritem}}</option>
                          @endif
                        @endforeach
                      </select>
                    </td>
                    <td width="300" class="akun_biaya_dropdown">
                      <select class="form-control akun_biaya chosen-select-width" name="akun_biaya[]">
                        
                      </select>
                    </td>
                    <td align="center">
                      <input type="text" name="nopol[]" value="{{$val->pbd_nopol}}"  class="form-control nopol" readonly="" onkeyup="cariDATA()">
                    </td>
                    <td align="center">
                      <input type="text" readonly="" name="stock_gudang[]" value=""  class="form-control stock_gudang">
                    </td>
                    <td align="center">
                      <input type="number" name="diminta[]" value="{{$val->pbd_jumlah_barang}}" class="form-control diminta">
                    </td>
                    <td align="center">
                      <input type="text" readonly="" class="form-control satuan">
                    </td>
                    <td align="center" class="clone_append" width="">
                      <div class="btn btn-group">
                        <button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>
                        <button class="btn btn-default btn-sm append" onclick="remove_append(this)"><a class="fa fa-minus"></a></button>
                      </div>
                    </td>
                  </tr>
                @else
                  <tr>
                    <td width="300">
                      <select class="form-control chosen-select-width5 cari_stock" name="nama_barang[]">
                        <option value="0" >- Pilih Barang -</option>
                        @foreach($item as $vald)
                          @if($vald->kode_item == $val->pbd_nama_barang)
                          <option selected="" value="{{$vald->kode_item}}">{{$vald->kode_item}} - {{$vald->nama_masteritem}}</option>
                          @else
                          <option value="{{$vald->kode_item}}">{{$vald->kode_item}} - {{$vald->nama_masteritem}}</option>
                          @endif
                        @endforeach
                      </select>
                    </td>
                    <td width="300" class="akun_biaya_dropdown">
                      <select class="form-control akun_biaya chosen-select-width" name="akun_biaya[]"> 
                        
                      </select>
                    </td>
                    <td align="center">
                      <input type="text" name="nopol[]" value="{{$val->pbd_nopol}}"  class="form-control nopol" readonly="" onkeyup="cariDATA()">
                    </td>
                    <td align="center">
                      <input type="text" readonly="" name="stock_gudang[]" value="0"  class="form-control stock_gudang">
                    </td>
                    <td align="center">
                      <input type="number" name="diminta[]" value="{{$val->pbd_jumlah_barang}}" class="form-control diminta">
                    </td>
                    <td align="center">
                      <input type="text" readonly="" class="form-control satuan">
                    </td>
                    <td align="center" class="clone_append" width="">
                      <div class="btn btn-group">
                        <button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>
                        <button class="btn btn-default btn-sm append" onclick="remove_append(this)"><a class="fa fa-minus"></a></button>
                      </div>
                    </td>
                  </tr>
                @endif
              @endif
              @endforeach
            </tbody>
          </table>
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

    format: 'dd/mm/yyyy'
});
    
// var tabel_barang  = $('.tabel_barang').DataTable({
//                   'searching' :false,
//               });

$(document).ready(function(){
  getCabang();
})

var config5 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width5'     : {width:"100% !important"}
              }

 for (var selector in config5) {
   $(selector).chosen(config5[selector]);
 }  


 function getCabang(){

    var cabang = $('#cabang').val();
    var gudang_peminta = '{{ $data->pb_gudang_cabang }}';
    $.ajax({
        type: "GET",
        data : {gudang: cabang},
        url : baseUrl + "/pengeluaranbarang/createpengeluaranbarang/get_gudang",
        dataType:'json',
        success: function(data)
        {   
          var kecamatan = '<option value="" disabled="">-- Pilih Gudang --</option>';

          $.each(data, function(i,n){
            if (n.mg_id == gudang_peminta) {
              kecamatan = kecamatan + '<option selected value="'+n.mg_id+'">'+n.mg_namagudang+'</option>';
            }else{
              kecamatan = kecamatan + '<option value="'+n.mg_id+'">'+n.mg_namagudang+'</option>';
            }
          });

          $('#gudang').addClass('form-control chosen-select-width');
          $('#gudang').html(kecamatan);
        }
    })
}


function append(p){
 
  var par = $(p).parents('tr');
  var count_append = 0;

                  
  var append = '<button class="btn btn-default btn-sm append" onclick="remove_append(this)"><a class="fa fa-minus"></a></button>';
  var append_plus = '<button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>';

  // $(par).find('.clone_append').html(append);
  // console.log(data);
  // tabel_barang.row.add(data);
    var html    ='<tr>'
                +'<td>'
                +'<select class="form-control chosen-select-width5 cari_stock" name="nama_barang[]">'
                +'<option value="0" >- Pilih Barang -</option>'
                +'@foreach($item as $val)'
                +'<option value="{{$val->kode_item}}">{{$val->kode_item}} - {{$val->nama_masteritem}}</option>'
                +'@endforeach'
                +'</select>'
                +'</td>'
                +'<td class="td_biaya">'
                +'<select class="akun_biaya form-control chosen-select-width5" name="akun_biaya[]">'
                +'</select>'
                +'</td>'
                +'<td align="center">'
                +'<input type="text" name="nopol[]" value=""  class="form-control nopol" readonly="" onkeyup="cariDATA()">'
                +'</td>'
                +'<td align="center">'
                +'<input type="text" readonly="" value="0" name="stock_gudang[]"  class="form-control stock_gudang">'
                +'</td>'
                +'<td align="center">'
                +'<input type="number" name="diminta[]" class="form-control diminta">'
                +'</td>'
                +'<td align="center">'
                +'<input type="text" readonly="" class="form-control satuan">'
                +'</td>'
                +'<td align="center" class="clone_append">'
                +'<div class="btn btn-group">'
                +append_plus
                +append
                +'</div>'
                +'</td>'
                +'</tr>';

    $('.clone_barang').append(html);

    var config5 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width5'     : {width:"100% !important"}
              }

    for (var selector in config5) {
     $(selector).chosen(config5[selector]);
    }  

  $('.cari_stock').change(function(){
  var id = $(this).val();
  var par = $(this).parents('tr');
  var cabang = $('.cabang').val();
  var akun_biaya = $(par).find('.akun_biaya')
  $.ajax({
    url:baseUrl + '/pengeluaranbarang/cari_stock',
    data:{id,cabang},
    success:function(response){

      if (response.data != 1) {
        $(par).find('.stock_gudang').val(response.data[0].sg_qty);
        $(par).find('.satuan').val(response.data[0].unitstock);

        if (response.jenis.jenisitem == 'S') {
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',false);
        }else{
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',true);
        }
      }else{

        if (response.jenis.jenisitem == 'S') {
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',false);

        }else{
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',true);

        }

        $(par).find('.stock_gudang').val(0);
        $(par).find('.satuan').val('None');
      }
      akun_biaya_dropdown(id,par,cabang);
      akun_biaya.trigger('chosen:update');
    },
    error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
});
}

function remove_append(p){
  var par = $(p).parents('tr');

  $(par).remove();
}

function akun_biaya_dropdown(id,par,cabang) {
  var jenis_keluar = $('.jenis_keluar').val();
  $.ajax({
    url:baseUrl + '/pengeluaranbarang/akun_biaya_dropdown',
    data:{id,cabang},
    success:function(response){
      if (jenis_keluar == 'Pemakaian Reguler') {
        var akun_biaya = $(par).find('.akun_biaya')
        akun_biaya.html('');
        var kecamatan = '';
        for (var i = 0; i < response.data.length; i++) {
          kecamatan +=  '<option value="'+response.data[i].id_akun+'">'+response.data[i].id_akun+'-'+response.data[i].nama_akun+'</option>';
        }            

        akun_biaya.html(kecamatan);
        akun_biaya.trigger('chosen:updated');
      }
    },
    error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
}

$(document).ready(function(){
  $('.cari_stock').each(function(){
  var id = $(this).val();
  var par = $(this).parents('tr');
 var cabang = $('.cabang').val();
 console.log(cabang);
  console.log(id);
  $.ajax({
    url:baseUrl + '/pengeluaranbarang/cari_stock',
    data:{id,cabang},
    success:function(response){
      
      if (response.data != null) {
        $(par).find('.stock_gudang').val(response.data[0].sg_qty);
        $(par).find('.satuan').val(response.data[0].unitstock);

        if (response.jenis.jenisitem == 'S') {

          // $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',false);
        }else{
          // $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',true);
        }
      }else{

        if (response.jenis.jenisitem == 'S') {
          // $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',false);
        }else{
          // $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',true);
        }

        $(par).find('.stock_gudang').val(0);
        $(par).find('.satuan').val('None');
      }
      akun_biaya_dropdown(id,par,cabang);
    },
    error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
    })
  });
});

 $('.cari_stock').change(function(){
  var id = $(this).val();
  var par = $(this).parents('tr');
 var cabang = $('.cabang').val();


  $.ajax({
    url:baseUrl + '/pengeluaranbarang/cari_stock',
    data:{id,cabang},
    success:function(response){
      
      if (response.data != null) {
        $(par).find('.stock_gudang').val(response.data[0].sg_qty);
        $(par).find('.satuan').val(response.data[0].unitstock);

        if (response.jenis.jenisitem == 'S') {

          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',false);
        }else{
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',true);
        }
      }else{

        if (response.jenis.jenisitem == 'S') {
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',false);
        }else{
          $(par).find('.nopol').val('');
          $(par).find('.nopol').attr('readonly',true);
        }

        $(par).find('.stock_gudang').val(0);
        $(par).find('.satuan').val('None');
      }
      akun_biaya_dropdown(id,par,cabang);
    },
    error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
});

function simpan(){
  var total = 0;
  $('.diminta').each(function(){
     total += $(this).val();
  })
  if ($('.keperluan').val() == '') {
    return toastr.warning('Keperluan Harus Diisi');
  }
  if ($('#gudang').val() == null) {
    return toastr.warning('Gudang Tujuan Harus Diisi');
  }
  if ($('.peminta').val() == '') {
    return toastr.warning('Nama Peminta Harus Diisi');
  }
  if (total == 0) {
    return toastr.warning('Tidak Ada Permintaan Pengeluaran Barang, Gagal Simpan');
  }
  
  if ($('.jenis_keluar').val() == 'Pemakaian Reguler') {
      var jenis_keluar = 0;
      $('.akun_biaya').each(function(){
         if ($(this).val() == null) {
             jenis_keluar+=1;
         }
      })

      if (jenis_keluar != 0) {
        return toastr.warning('Terdapat Akun Yang Kosong/Cabang Tidak Memiliki Akun Untuk Item Ini');
      }
  }
  
  var stock_gudang = 0;
  $('.stock_gudang').each(function(){
     if ($(this).val() == '0') {
        stock_gudang+=1;
     }
  })

  if (stock_gudang != 0) {
    return toastr.warning('Terdapat Stock Gudang Yang Kosong');
  }
   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Pengeluaran Barang!",
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
        url:baseUrl+'/pengeluaranbarang/update_pengeluaran/'+'{{$id}}',
        data: $('.resi_body :input').serialize()
        +'&'+$('.tabel_barang :input').serialize(),
        type:'get',
      success:function(response){
        if (response.status == 1) {
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       // location.href='../buktikaskeluar/index';
                       $('.id_sppb').val(response.id);
                       $('.print_patty').removeClass('disabled'); 
                       $('.simpan').addClass('disabled'); 
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

function printing(){
  var id = $('.id_sppb').val();
  window.open("{{url('buktikaskeluar/detailkas')}}"+'/'+id)
}
</script>
@endsection
