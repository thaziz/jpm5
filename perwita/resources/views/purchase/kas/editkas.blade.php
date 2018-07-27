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
    opacity: 0.8;
  }
  .search{
    margin-left: 5px;
  }
  h3{
    margin: 20px 5px;

  }
  .my-bg{
    background: #f0b7d6;
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
<div hidden="" class="alert-class alert-info row wrapper border-bottom my-bg page-heading " style="margin-top: 10px; padding: 0 0;">
<h3 class="pending" style="padding: 10px 0 margin:0px 0px !important;"></h3>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- HEADER -->
    <div class="ibox">
      <div class="ibox-title">
        <h5>Biaya Penerus Kas</h5>
        <a href="../biaya_penerus/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
        <a class="pull-right jurnal" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal</i></a>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6">
          <table class="table table_header">
            {{ csrf_field() }}
            <tr>
              <td>No Transaksi</td>
              <td>
                <input readonly="" value="{{ $data->bpk_nota }}" class="form-control no_trans" type="text" name="no_trans">
                <input readonly="" value="EDIT" class="form-control tipe_data" type="hidden" name="tipe_data">
                <input readonly="" value="" class="form-control id" type="hidden" name="id">
              </td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td class="disabled">
                    <select class="form-control cabang_select" name="cabang">
                        @foreach($cabang as $val)
                        @if($data->bpk_comp == $val->kode)
                            <option selected value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                        @else
                            <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="cabang_input" class="cabang_input form-control input-sm">
                </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td class="disabled"><input readonly="" class="form-control tanggal" value="{{ carbon\carbon::parse($data->bpk_tanggal)->format('d-m-Y') }}" type="text" name="tN"></td>
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
            <table class="table table_data">
              {{ csrf_field() }}  
              <tr>
                <td>Akun Kas</td>
                <td class="form-inline akun_kas_td">
                 <select style="display: inline-block; " class="form-control nama_kas chosen-select-width1" name="nama_kas">
                     <option selected=""  value="0">- pilih-akun -</option>
                     @foreach($akun_kas as $val)
                     <option @if($val->id_akun == $data->bpk_kode_akun) selected="" @endif value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                     @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jenis Pembiayaan</td>
                <td>
                  <select class="form-control jenis_pembiayaan" type="text" name="jenis_pembiayaan">
                    <option value="0" selected>- Pilih Jenis Pembiayaan -</option>
                    <option @if($data->bpk_jenis_biaya == 'PAKET') selected="" @endif value="PAKET">PAKET</option>
                    <option @if($data->bpk_jenis_biaya == 'KARGO') selected="" @endif value="KARGO">KARGO</option>
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
                   <select class="form-control " name="pembiayaan_paket" >
                    @foreach($akun_paket as $val)
                     <option @if($data->bpk_pembiayaan == $val->kode) selected="" @endif value="{{ $val->jenis_bbm }}">{{ $val->kode}} - {{ $val->nama }}</option>
                    @endforeach
                   </select>
                </td>
                <!-- CARGO DROPDOWN-->
                <td hidden="" class="pembiayaan_cargo">
                    <select class="form-control " name="pembiayaan_cargo" >
                     @foreach($akun_kargo as $val)
                     <option @if($data->bpk_pembiayaan == $val->kode) selected="" @endif value="{{ $val->jenis_bbm }}">{{ $val->kode }} - {{ $val->nama }}</option>
                    @endforeach
                    </select>
                </td>

              </tr>
              <tr>
                <td>Jenis Kendaraan</td>
                <td>
                  <select class="form-control jenis_kendaraan chosen-select-width1" type="text" name="jenis_kendaraan" onchange="jenis_kendaraan()">
                    <option value="0">- Pilih Jenis Kendaraan -</option>
                    @foreach($angkutan as $val)
                    <option @if($data->bpk_tipe_angkutan == $val->kode) selected="" @endif value="{{$val->kode}}">{{$val->nama}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Biaya Parkir & Tol</td>
                <td>
                  <input  onkeyup="hitung()" class="form-control biaya_dll" type="text" name="biaya_dll" value="Rp {{ number_format($data->bpk_biaya_lain,0) }}" placeholder="Biaya Lain Lain" >
                </td>
              </tr>
            
              <tr>
                <td>
                  Biaya Bahan Bakar :
                  <input readonly="" class="form-control total_bbm" type="text" name="total_bbm" value="Rp {{ number_format($data->bpk_harga_bbm,0) }}" placeholder="" >
                </td>
                <td style="color: red">
                  Total Biaya Keseluruhan :
                  <input readonly="" class="form-control total" type="text" name="total" value="Rp 0">
                </td>
              </tr>
              <tr>
                <td>Kilometer (KM)</td>
                <td>
                  <input class="form-control kilometer" type="text" name="km" value="{{ $data->bpk_jarak }}" placeholder="kilometer" onkeyup="hitung_bbm()">
                  <input class="form-control km_liter" type="hidden">
                  <input class="form-control bbm" type="hidden" name="km_val">
                </td>
              </tr>
              <tr>
                <td>Nopol Kendaraan</td>
                <td class="nopol_td">
                  <input  class="form-control nopol" type="text" name="nopol" value="" onkeyup="cariDATA()" placeholder="nomor polisi">
                </td>
              </tr>
              <tr>
                <td>Nama sopir</td>
                <td>
                  <input  class="form-control nama_sopir" type="text" name="nama_sopir" value="{{ $data->bpk_sopir }}" placeholder="nama sopir">
                </td>
              </tr>
              <tr>
                <td>Note</td>
                <td>
                  <textarea class="form-control note" name="note" value="{{ $data->bpk_keterangan }}" placeholder="fill this note" >{{ $data->bpk_keterangan }}</textarea>
                </td>
              </tr>
              <tr>
                <td>Nota Resi (dipisah dengan spasi)<span class="require" style="color: red"> *</span></td>
                <td>
                  <textarea style="height: 100px" class="form-control resi" id="resi"  value="" placeholder="Nota Resi" >{{$resi}}</textarea>
                  <br><label>Untuk Pembiayaan Lintas, hanya di isi No Resi Lintas</label>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button class="search cari btn btn-success pull-right" onclick="search()"><i class="fa fa-search"> Search</i></button>
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



<div class="modal modal_jurnal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
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

<script src="{{ asset('assets/vendors/chosen/chosen.jquery.js') }}"></script>
<script type="text/javascript">
var datatable;

$('.jurnal').click(function(){
  var id = '{{ $id }}';
  $.ajax({
      url:baseUrl + '/biaya_penerus/jurnal',
      type:'get',
      data:{id},
      success:function(data){
         $('.tabel_jurnal').html(data);
         $('.modal_jurnal').modal('show');
      },
      error:function(data){
          // location.reload();
      }
  }); 
})

$('.tanggal').datepicker({
  format:'dd-mm-yyyy'
});
  $(document).ready(function(){
    // $('.hid').attr('hidden',true);
    $('.search').attr('disabled',true);

    var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"100%"}
             }

              for (var selector in config1) {
               $(selector).chosen(config1[selector]);
              }  

    var ini = $('.jenis_pembiayaan').val();
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
    }else if(ini == 'KARGO'){
      $('.pembiayaan_paket').attr('hidden',true);
      $('.pembiayaan_cargo').attr('hidden',false);
      $('.pembiayaan').attr('hidden',true);
    }
    

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
        var bbm_liter = data.angkutan[0].bbm_per_liter;
        var harga_bbm = data.angkutan[0].mb_harga;
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
    
    var id_nopol = "{{ $data->bpk_nopol }}";
    $.ajax({
          url:baseUrl + '/biaya_penerus/nopol',
          data:{jenis,id_nopol},
          success:function(data){
              $('.nopol_td').html(data);

          },
          error:function(){
              location.reload();
          }
      })
    hitung();
    search();
    // jurnal();
  });
   var asd = $('.biaya_dll').maskMoney({precision:0, prefix:'Rp '});



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
        var bbm_liter = data.angkutan[0].bbm_per_liter;
        var harga_bbm = data.angkutan[0].mb_harga;
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

      $.ajax({
          url:baseUrl + '/biaya_penerus/nopol',
          data:{jenis},
          success:function(data){
              $('.nopol_td').html(data);

          },
          error:function(){
              location.reload();
          }
      })

 }
 //////////////////////////////////////////////
 var total = [];
 function hitung(){
  var bayar = $('.biaya_dll').val();
  var hitung = bayar.replace(/[^0-9\.-]+/g,"");
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
  var resi = $('#resi').val();
  var head = $('.table_header :input').serializeArray();
  var data = $('.table_data :input').serializeArray();
  var resi_array = resi.split(" ");
  var id = '{{ $id }}'
  // console.log(id);
  // data.push(resi_array);
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $.ajax({
      url:baseUrl + '/biaya_penerus/cariresiedit',
      type:'post',
      data: {head,data,resi_array,id},
      success:function(data){
        $('.resi_body').html('');
        if(typeof data.status !== 'undefined'){
                  console.log(data.status);
          toastr.warning('data tidak ada/sudah ada');
        }else if (data.status == 0){
          toastr.warning('data sudah ada');
        }else{
          $('.valid_key').attr('hidden',false);
          $('.resi_body').html(data);
        }
       
      }

    })
}

function save_data(){
var id  =  '{{ $id }}';
  swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Biaya Penerus!",
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
      url:baseUrl + '/biaya_penerus/update_penerus',
      type:'post',
      data: datatable.$('input').serialize()+'&'+$('.table_header :input').serialize()+'&'+$('.table_data :input').serialize()+'&id='+id,
      success:function(data){
        if(data.status == '0'){
          swal({
          title: "Gagal menyimpan, Data Sudah Ada",
                type: 'error',
                timer: 900,
                showConfirmButton: true
          });
        }else if(data.status == '1'){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){

                    
          });
          $('.process').addClass('disabled');
          $('.cari').addClass('disabled');
          $('.asd').attr('hidden',false);
          $('.id').val(data.id);
          jurnal();
        }else if(data.status == '2'){
          $('.pending').html("Data Belum disimpan biaya maksimal ("+data.minimal+")");
          $("html, body").animate({ scrollTop: 0 }, "slow");
          $('.my-bg').attr('hidden',false);
          swal({
          title: "Berhasil!",
                  type: 'warning',
                  text: "Data Belum disimpan PENDING biaya maksimal ("+data.minimal+")",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
        
          });
          $('.id').val(data.id);
          $('.asd').attr('hidden',false);
          $('.process').addClass('disabled');
          $('.cari').addClass('disabled');
        }else if (response.status == 3) {
          swal({
              title: "Peringatan!",
              type: 'warning',
              text: response.data,
              timer: 900,
             showConfirmButton: true
              },function(){
              toastr.warning('No DO telah diganti menjadi ' + response.nota)
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
  var id = '{{ $id }}';
  window.open("{{url('biaya_penerus/detailkas')}}"+'?id='+id);
}
function buktikas(){
  var id = '{{ $id }}';
  window.open("{{url('biaya_penerus/buktikas')}}"+'?id='+id);
}


function cariDATA(){
    $( ".nopol" ).autocomplete({
      source:baseUrl + '/biaya_penerus/carinopol', 
      minLength: 3,
       change: function(event, ui) {
       }

  });

}
function reload(){
  location.reload();
}


</script>
@endsection
