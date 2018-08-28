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
        <a href="../pengeluaranbarang/pengeluaranbarang" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6 ">          
          <table class="table resi_body">
            <tr>
              <td>Kode SPPB</td>
              <td>
                <input type="text" readonly="" name="no_sppb" class="form-control no_sppb input-sm" value="">
                <input type="hidden"   class="form-control id_sppb input-sm" value="">
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td>
                <input type="text" name="tgl" class="form-control tanggal date input-sm"  value="{{$now}}">
              </td>
            </tr>
            <tr>
              <td>Jenis Pengeluaran</td>
              <td>
                <select class="jenis_keluar form-control" name="jp">
                  <option>Moving Gudang</option>
                  <option>Pemakaian Reguler</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Keperluan untuk</td>
              <td>
                <input type="text" name="keperluan" class="form-control input-sm keperluan" value="">
              </td>
            </tr>
            @if(Auth::user()->punyaAkses('Pengeluaran Barang','cabang'))
            <tr>
              <td>Cabang Penyedia</td>
              <td>
                <select class="form-control cabang" name="cabang" onchange="ganti_nota()" > 
                  @foreach($cabang as $val)
                    <option @if(Auth::user()->kode_cabang == $val->kode) selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            @else
            <tr>
              <td>Cabang Penyedia</td>
              <td class="disabled">
                <select class="form-control cabang" name="cabang" onchange="ganti_nota()"> 
                  @foreach($cabang as $val)
                    <option @if(Auth::user()->kode_cabang == $val->kode) selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            @endif
            <tr>
              <td>Cabang Bagian Peminta</td>
              <td>
                <select class="form-control cabang_peminta" id="cabang" name="cabang_peminta" onchange="getCabang()"> 
                  @foreach($cabang as $val)
                    <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
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
                <input type="text" name="peminta" class="peminta form-control input-sm">
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()" ><i class="fa fa-refresh">&nbsp;Reload</i></button>
                <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_patty disabled"  onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>
                <button class="btn btn-primary simpan pull-right" onclick="simpan()"><i class="fa fa-save"> Simpan</i></button>
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
              <tr>
                <td width="300">
                  <select class="form-control chosen-select-width5 cari_stock" name="nama_barang[]">
                    <option value="0" >- Pilih Barang -</option>
                    @foreach($item as $val)
                    <option value="{{$val->kode_item}}">{{$val->kode_item}} - {{$val->nama_masteritem}}</option>
                    @endforeach
                  </select>
                </td>
                <td width="300" class="akun_biaya_dropdown">
                  <select class="form-control akun_biaya chosen-select-width">
                    
                  </select>
                </td>
                <td align="center">
                  <input type="text" name="nopol[]" value=""  class="form-control nopol" readonly="" onkeyup="cariDATA()">
                </td>
                <td align="center">
                  <input type="text" readonly="" name="stock_gudang[]" value="0"  class="form-control stock_gudang">
                </td>
                <td align="center">
                  <input type="number" name="diminta[]" class="form-control diminta">
                </td>
                <td align="center">
                  <input type="text" readonly="" class="form-control satuan">
                </td>
                <td align="center" class="clone_append" width="">
                  <button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>
                </td>
              </tr>
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
    
$(document).ready(function(){
  var cabang = $('.cabang').val();
  var tanggal = $('.tgl').val();
        $.ajax({
            type: "GET",
            data : {cabang,tanggal},
            url : baseUrl + "/pengeluaranbarang/ganti_nota",
            dataType:'json',
            success: function(data)
            {   
              $('.no_sppb').val(data.nota);
            }
        })

  getCabang();
});

function ganti_nota() {
  var cabang = $('.cabang').val();
  var tanggal = $('.tgl').val();
        $.ajax({
            type: "GET",
            data : {cabang,tanggal},
            url : baseUrl + "/pengeluaranbarang/ganti_nota",
            dataType:'json',
            success: function(data)
            {   
              $('.no_sppb').val(data.nota);
            }
        })
}

 function getCabang(){

    var cabang = $('#cabang').val();
    $.ajax({
        type: "GET",
        data : {gudang: cabang},
        url : baseUrl + "/pengeluaranbarang/createpengeluaranbarang/get_gudang",
        dataType:'json',
        success: function(data)
        {   
          var kecamatan = '<option value="" selected="" disabled="">-- Pilih Gudang --</option>';

          $.each(data, function(i,n){
                kecamatan = kecamatan + '<option value="'+n.mg_id+'">'+n.mg_namagudang+'</option>';
          });

          $('#gudang').addClass('form-control chosen-select-width');
          $('#gudang').html(kecamatan);
        }
    })
}

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
                +'<td>'
                +'<select class="form-control akun_biaya chosen-select-width">'
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


    for (var selector in config5) {
     $(selector).chosen(config5[selector]);
    }  
    // $('.clone_append').each(function(){
    //   count_append += 1;
    // });
    // if (count_append == 1) {
    //   $('.clone_append').html(append_plus);
    // }
  $('.cari_stock').change(function(){
  var id = $(this).val();
  var par = $(this).parents('tr');
  var cabang = $('.cabang').val();
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
  $.ajax({
    url:baseUrl + '/pengeluaranbarang/akun_biaya_dropdown',
    data:{id,cabang},
    success:function(response){
      
    },
    error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
}


 $('.cari_stock').change(function(){
  var id = $(this).val();
  var par = $(this).parents('tr');
  var cabang = $('.cabang').val();

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
    },
    error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
});

function cariDATA(){

    $( ".nopol" ).autocomplete({
      source:baseUrl + '/biaya_penerus/carinopol', 
      minLength: 3,
       change: function(event, ui) {
       }

  });

}

function simpan(){

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
        url:baseUrl+'/pengeluaranbarang/save_pengeluaran',
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
