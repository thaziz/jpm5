@extends('main')

@section('title', 'dashboard')

@section('content')
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
  .tengah{
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
</style>
<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Transaksi Kas </h2>
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
                            <strong> Transaksi Kas </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
 </div>
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- HEADER -->
    <div class="ibox">
      <div class="ibox-title">
        <h5>Biaya Penerus Kas</h5>
        <a href="../biaya_penerus/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6">
          <table class="table table_header">
            {{ csrf_field() }}  
            <tr>
              <td>No Transaksi</td>
              <td>
                <input readonly="" value="{{$data[0]->bpk_nota}}" class="form-control" type="text" name="no_trans">
                <input readonly="" value="EDIT" class="form-control" type="hidden" name="tipe_data">
                <input readonly="" value="{{$data[0]->bpk_id}}" class="form-control id" type="hidden" name="id">
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td><input readonly="" class="form-control" value="{{$data[0]->bpk_tanggal}}" type="text" name="tN"></td>
            </tr>
          </table>
        </div>
      </div>
    </div>  
    <!-- body -->
    <div class="ibox" style="padding-top: 10px;">
      <div class="ibox-title"><h5>Form Biaya Penerus Kas</h5></div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-8" style="margin: 0 15%">  
        {{ csrf_field() }}   
            <table class="table table_data">
              <tr>
                <td>Akun Kas</td>
                <td class="form-inline">
                  <input readonly="" class="form-control kode_kas" type="text" name="kode_kas" value="{{$data[0]->bpk_kode_akun}}" style="width: 19.8%;">
                  <select class="form-control nama_kas" type="text" style="width: 79.2%">
                    <option value="0" selected>- Pilih Akun Kas -</option>
                    @foreach($akun as $val)
                    <option value="{{$val->id_akun}}">{{$val->nama_akun}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jenis Pembiayaan</td>
                <td>
                  <select class="form-control jenis_pembiayaan" type="text" name="jenis_pembiayaan">
                    <option value="0" selected>- Pilih Jenis Pembiayaan -</option>
                    <option value="PAKET">PAKET</option>
                    <option value="CARGO">CARGO</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td >Pembiayaan</td>
                <!-- AWAL PEMBIAYAAN -->
                <td class="pembiayaan">
                  <select class="form-control pembiayaan" type="text">
                    <option value="0" selected>- Pilih Jenis Biaya -</option>
                  </select>
                </td>
                <!-- PAKET DROPDOWN-->
                <td hidden="" class="pembiayaan_paket">
                  <select  class="form-control pembiayaan pembiayaan_paket" type="text" name="pembiayaan_paket">
                    <option value="0" selected>- Pilih Jenis Biaya -</option>
                    @foreach($akun_biaya_paket as $val)
                    <option value="{{$val->kode}}">{{$val->kode_akun}} - {{$val->nama}}</option>
                    @endforeach
                  </select>
                </td>
                <!-- CARGO DROPDOWN-->
                <td hidden="" class="pembiayaan_cargo">
                  <select  class="form-control pembiayaan pembiayaan_cargo" type="text" name="pembiayaan_cargo">
                    <option value="0" selected>- Pilih Jenis Biaya -</option>
                    @foreach($akun_biaya_cargo as $val)
                    <option value="{{$val->kode}}">{{$val->kode_akun}} - {{$val->nama}}</option>
                    @endforeach
                  </select>
                </td>

              </tr>
              <tr>
                <td>Jenis Kendaraan</td>
                <td>
                  <select class="form-control jenis_kendaraan" type="text" name="jenis_kendaraan" onchange="jenis_kendaraan()">
                    <option value="0">- Pilih Jenis Kendaraan -</option>
                    @foreach($angkutan as $val)
                    <option value="{{$val->kode}}">{{$val->nama}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Biaya Lain-Lain</td>
                <td>
                  <input  onkeyup="hitung()" class="form-control biaya_dll" type="text" name="biaya_dll" value="" placeholder="Biaya Lain-Lain" >
                </td>
              </tr>
              <tr>
                <td>Kilometer (KM)</td>
                <td>
                  <input class="form-control kilometer" type="text" name="km" value="" placeholder="kilometer" onkeyup="hitung_bbm()">
                  <input class="form-control km_liter" type="hidden">
                  <input class="form-control bbm" type="hidden" name="km_val">
                </td>
              </tr>
              <tr>
                <td>
                  Biaya Bahan Bakar :
                  <input readonly="" class="form-control total_bbm" type="text" name="total_bbm" value="Rp 0" placeholder="" >
                </td>
                <td style="color: red">
                  Total Biaya Keseluruhan :
                  <input readonly="" class="form-control total" type="text" name="total" value="Rp 0">
                </td>
              </tr>
              <tr>
                <td>Nopol Kendaraan</td>
                <td>
                  <input  class="form-control nopol" type="text" name="nopol" value="{{$data[0]->bpk_nopol}}" >
                </td>
              </tr>
              <tr>
                <td>Nama sopir</td>
                <td>
                  <input  class="form-control nama_sopir" type="text" name="nama_sopir" value="{{$data[0]->bpk_sopir}}" placeholder="nama sopir">
                </td>
              </tr>
              <tr>
                <td>Note</td>
                <td>
                  <textarea class="form-control note" name="note"  placeholder="fill this note" >{{$data[0]->bpk_keterangan}}</textarea>
                </td>
              </tr>
              <tr>
                <td>Nota Resi (dipisah dengan spasi)<span class="require" style="color: red"> *</span></td>
                <td>
                  <textarea class="form-control resi" id="resi" name="resi" value="" placeholder="Nota Resi" >
                  </textarea>
                  <br><label>Untuk Pembiayaan Lintas, hanya di isi No Resi Lintas</label>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button class="search btn btn-success pull-right" onclick="search()"><i class="fa fa-search"> Update Data</i></button>
                </td>
              </tr>
            </table>          
        </div>
      </div>
    </div>
    <!-- tabel data resi -->
    <div hidden="" class="ibox valid_key" style="padding-top: 10px;">
      <div class="ibox-title"><h5>Tabel Data Resi</h5></div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-12 resi_body">          
                    
        </div>
      </div>
    </div> 
  </div>
</div> 




<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')

<script src="{{ asset('assets/vendors/chosen/chosen.jquery.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $('.hid').attr('hidden',true);
    $('.search').attr('disabled',false);
    $('.nama_kas').val({{$data[0]->bpk_kode_akun}});
    $('.jenis_pembiayaan').val("{{$data[0]->bpk_jenis_biaya}}");
    $('.jenis_kendaraan').val("{{$data[0]->bpk_tipe_angkutan}}");
    $('.biaya_dll').val("{{"Rp " . number_format($data[0]->bpk_biaya_lain,0,",",".")}}");
    $('.kilometer').val("{{$data[0]->bpk_jarak}}");

    var id = $('.jenis_kendaraan').val();
    var dll = $('.biaya_dll').val();
    var km = $('.kilometer').val();
    var bbm_liter = parseInt($('.km_liter').val());
    var harga_bbm = parseInt($('.bbm').val());
    var hasil  = 0;
    var temp   = 0;
    var jk     = $('.jenis_kendaraan').val();
    var bayar = $('.biaya_dll').val();
    $('.biaya_dll').maskMoney({precision:0, prefix:'Rp ',thousands:'.'});


    if ('{{$data[0]->bpk_jenis_biaya}}' =='PAKET') {
      $('.pembiayaan_paket').attr('hidden',false);
      $('.pembiayaan_cargo').attr('hidden',true);
      $('.pembiayaan').attr('hidden',true);
      $('.pembiayaan_paket').val("{{$data[0]->bpk_pembiayaan}}");
    }else if('{{$data[0]->bpk_jenis_biaya}}' =='CARGO'){
      $('.pembiayaan_paket').attr('hidden',true);
      $('.pembiayaan_cargo').attr('hidden',false);
      $('.pembiayaan').attr('hidden',true);
      $('.pembiayaan_cargo').val("{{$data[0]->bpk_pembiayaan}}");
    }
    console.log(id); 
    $.ajax({
      url:baseUrl + '/biaya_penerus/getbbm/'+id,
      type:'get',
      success:function(data){


        bbm_liter = data[0].bbm_per_liter;
        harga_bbm = data[0].mb_harga;
        $('.km_liter').val(bbm_liter);
        $('.bbm').val(harga_bbm);

        if(km != "" && jk != "0"){
          
          parseInt(km);
          hasil = km/bbm_liter;
          hasil = hasil * harga_bbm;
          hasil = Math.round(hasil);
          hasil = hasil.toLocaleString();
          hasil = 'Rp ' + hasil;
          $('.total_bbm').val(hasil);
          var hitung = bayar.replace(/[^0-9\-]+/g,"");
          total[0] = hitung;


          total[1] = hasil;
          if(total[0]=="" ){
            total[0]=0;
          }
          total[1] = total[1].replace("Rp ","");
          total[1] = total[1].replace(/[^0-9\.-]+/g,"");

          for(var i = 0 ; i<total.length;i++){
            temp+=parseInt(total[i]);
          }
          temp = temp.toLocaleString()
          temp = 'Rp ' + temp;
          $('.total').val(temp);
          $('.search').click();


        }else if(km == ""){
          $('.total_bbm').val(0);
          total[1] = 0;
          if(total[0]==""){
            total[0]=0;
          }
          for(var i = 0 ; i<total.length;i++){
            temp+=parseInt(total[i]);
          }
          temp = temp.toLocaleString()
          temp = 'Rp ' + temp;
      
          $('.total').val(temp);
          $('.search').click();
        }
      }

    })
    var resi='';
   @foreach($string_resi as $index => $val)
     resi+='{{$string_resi[$index]}}'+' ';
   @endforeach
   $('#resi').val(resi);

   
  });


  // $('.resi').keyup(function() {
  // var foo = $(this).val().split("-").join(""); // remove hyphens
  // if (foo.length > 0) {
  //   foo = foo.match(new RegExp('.{1,7}', 'g')).join("-");
  // }
  // $(this).val(foo);
  // });
/////////////////////////////////////////////
  $('.nama_kas').change(function(){

    var ini = $(this).val();
    var jenis = $('.jenis_kendaraan').val();
    var nama_kas = $('.nama_kas').val();
    var jenis_pembiayaan = $('.jenis_pembiayaan').val();
    
    
    if (jenis != 0 && nama_kas != 0 && jenis_pembiayaan != 0){
      $('.search').attr('disabled',false);
    }

    $('.kode_kas').val(ini);
  });
/////////////////////////////////////////////
  $('.pembiayaan').change(function(){
    var jenis = $('.jenis_kendaraan').val();
    var nama_kas = $('.nama_kas').val();
    var jenis_pembiayaan = $('.jenis_pembiayaan').val();
    var pembiayaan = $('.pembiayaan').val();

    
    if (jenis != 0 && nama_kas != 0 && jenis_pembiayaan != 0 ){
      $('.search').attr('disabled',false);
    }
  });
//////////////////////////////////////////////////////
 $('.jenis_pembiayaan').change(function(){

    var ini = $(this).val();
    var jenis = $('.jenis_kendaraan').val();
    var nama_kas = $('.nama_kas').val();
    var jenis_pembiayaan = $('.jenis_pembiayaan').val();
    var pembiayaan = $('.pembiayaan').val();

    
    if (jenis != 0 && nama_kas != 0 && jenis_pembiayaan != 0 ){
      $('.search').attr('disabled',false);
    }
    if(ini == 'PAKET'){
  
      $('.pembiayaan_paket').attr('hidden',false);
      $('.pembiayaan_cargo').attr('hidden',true);
      $('.pembiayaan').attr('hidden',true);
    }else if(ini == 'CARGO'){
      $('.pembiayaan_paket').attr('hidden',true);
      $('.pembiayaan_cargo').attr('hidden',false);
      $('.pembiayaan').attr('hidden',true);
    }
  });
//////////////////////////////////////////////////////
 function jenis_kendaraan(){

  var id = $('.jenis_kendaraan').val();
  var jenis = $('.jenis_kendaraan').val();
  var nama_kas = $('.nama_kas').val();
  var jenis_pembiayaan = $('.jenis_pembiayaan').val();
  var pembiayaan = $('.pembiayaan').val();
  var km        = $('.kilometer').val();
  var bbm_liter = parseInt($('.km_liter').val());
  var harga_bbm = parseInt($('.bbm').val());
  var jk        = $('.jenis_kendaraan').val();
  var hasil = 0;
  var temp = 0;

  if (jenis != 0 && nama_kas != 0 && jenis_pembiayaan != 0){
      $('.search').attr('disabled',false);
    }

  $.ajax({
      url:baseUrl + '/biaya_penerus/getbbm/'+id,
      type:'get',
      success:function(data){
        bbm_liter = data[0].bbm_per_liter;
        harga_bbm = data[0].mb_harga;
        $('.km_liter').val(bbm_liter);
        $('.bbm').val(harga_bbm);

        if(km != "" && jk != "0"){
          parseInt(km);
          hasil = km/bbm_liter;
          hasil = hasil * harga_bbm;
          hasil = Math.round(hasil);
          hasil = hasil.toLocaleString();
          hasil = 'Rp ' + hasil;
          $('.total_bbm').val(hasil);


          total[1] = hasil;
          if(total[0]==undefined ){
            total[0]=0;
          }
          total[1] = total[1].replace("Rp ","");
          total[1] = total[1].replace(/[^0-9\.-]+/g,"");

          for(var i = 0 ; i<total.length;i++){
            temp+=parseInt(total[i]);
          }
          temp = temp.toLocaleString()
          temp = 'Rp ' + temp;
          $('.total').val(temp);


        }else if(km == ""){
          $('.total_bbm').val(0);
          total[1] = 0;
          if(total[0]==undefined){
            total[0]=0;
          }
          for(var i = 0 ; i<total.length;i++){
            temp+=parseInt(total[i]);
          }
          temp = temp.toLocaleString()
          temp = 'Rp ' + temp;
      
          $('.total').val(temp);
        }
      }

    })



 }
 //////////////////////////////////////////////
 var total = [];
 function hitung(){
  var bayar = $('.biaya_dll').val();
  var hitung = bayar.replace(/[^0-9\-]+/g,"");
  // conssol
  total[0] = hitung;
  var temp = 0;
   if(total[0]==""){
      total[0]=0;
    }
  if(total[1] != undefined && total[1] != ""){
   total[1] = total[1].replace("Rp ","");
   total[1] = total[1].replace(/[^0-9\.-]+/g,"");
  }

   for(var i = 0 ; i<total.length;i++){
        temp+=parseInt(total[i]);
   }
  temp = temp.toLocaleString()
  $('.total').val('Rp '+temp);

   $('.valid_key').attr('hidden',true);
  $('.resi_body').html('');
 }

 function hitung_bbm(){

  var km        = $('.kilometer').val();
  var bbm_liter = parseInt($('.km_liter').val());
  var harga_bbm = parseInt($('.bbm').val());
  var jk        = $('.jenis_kendaraan').val();
  var hasil = 0;
  var temp = 0;

  if(km != "" && jk != "0"){
    parseInt(km);
    hasil = km/bbm_liter;
    hasil = hasil * harga_bbm;
    hasil = Math.round(hasil);
    hasil = hasil.toLocaleString();
    hasil = 'Rp ' + hasil;


    $('.total_bbm').val(hasil);


    total[1] = hasil;
    if(total[0]==undefined ){
      total[0]=0;
    }
    total[1] = total[1].replace("Rp ","");
    total[1] = total[1].replace(/[^0-9\.-]+/g,"");

    for(var i = 0 ; i<total.length;i++){
      temp+=parseInt(total[i]);
    }
    temp = temp.toLocaleString()
    temp = 'Rp ' + temp;
    $('.total').val(temp);


  }else if(km == ""){
    $('.total_bbm').val(0);
    total[1] = 0;
    if(total[0]==undefined){
      total[0]=0;
    }
    for(var i = 0 ; i<total.length;i++){
      temp+=parseInt(total[i]);
    }
    temp = temp.toLocaleString()
    temp = 'Rp ' + temp;
    $('.total').val(temp);
  }

   $('.valid_key').attr('hidden',true);
  $('.resi_body').html('');
 }

function search(){

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $.ajax({
      url:baseUrl + '/biaya_penerus/cariresiedit',
      type:'post',
      data:'id='+'{{$id_edit}}'+'&'+$('.table_header :input').serialize()+'&'+$('.table_data :input').serialize(),
      success:function(data){
        $('.resi_body').html('');
        if(typeof data.status !== 'undefined'){
                  console.log(data.status);
          toastr.warning('data tidak ada');
        }else{
          $('.valid_key').attr('hidden',false);
          $('.resi_body').html(data);
        }
       
      }

    })
}

function save_data(){

  swal({
    title: "Apakah anda yakin?",
    text: "Update Data Biaya Penerus!",
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
      url:baseUrl + '/biaya_penerus/update_penerus',
      type:'post',
      data: datatable.$('input').serialize()+'&'+$('.table_header :input').serialize()+'&'+$('.table_data :input').serialize(),
      success:function(data){
        if(data.status == '1'){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil diUpdate",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     window.location = baseUrl+ '/biaya_penerus/index';
          });
        }else if(data.status == '2'){
          swal({
          title: "Berhasil!",
                  type: 'warning',
                  text: "Data berhasil diupdate dengan status PENDING, biaya minimal adalah ("+data.minimal+")",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     window.location = baseUrl + '/biaya_penerus/index';
          });
        }
        $('.asd').attr('hidden',false);
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
function detailkas(){
  var id = $('.id').val();
  window.open("{{url('biaya_penerus/detailkas')}}"+'?id='+id);
}
function buktikas(){
  var id = $('.id').val();
  window.open("{{url('biaya_penerus/buktikas')}}"+'?id='+id);
}



</script>
@endsection
