@extends('main')

@section('title', 'dashboard')

@section('content')



<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Bon Sementara </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a>Transaksi Hutang</a>
          </li>
          <li class="active">
              <strong> Bon Sementara </strong>
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
                    <h5> Bon Sementara
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('bonsementaracabang/createcabang')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-body">
                  <div class="col-sm-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table_tt ">
                      <thead style="color: white">
                        <tr>
                          <th>No</th>
                          <th> Cabang </th>
                          <th>Nomor</th>
                          <th>Tanggal</th>
                          <th> Nominal Cabang </th>
                          <th> Nominal KACAB </th>
                          <th>Keperluan</th>
                          <th> Status </th>
                          <th> Proses </th>
                          <th> Terima Uang </th>
                          <th> Aksi </th>                    
                        </tr>
                      </thead>
                      <tbody>

                          @foreach($data['bonsem'] as $index=>$bonsem)
                          <tr>
                            <td> {{$index + 1}} </td>
                            <td> {{$bonsem->nama}} </td>
                            <td> {{$bonsem->bp_nota}} </td>
                            <td> {{ Carbon\Carbon::parse($bonsem->bp_tgl)->format('d-m-Y') }} </td>
                            <td>{{ number_format($bonsem->bp_nominal ,2)}} </td>
                            <td> @if($bonsem->bp_nominalkacab == null)
                                    <span class="label label-info"> BELUM DI PROSES </span>
                                 @else
                                  {{ number_format($bonsem->bp_nominalkacab ,2)}} 
                                 @endif</td>
                            <td> {{$bonsem->bp_keperluan}} </td>
                            <td style="text-align:center"> <span class="label label-success">  {{$bonsem->status_pusat}} </span></td>
                            <td style="text-align:center">

                               @if(Auth::user()->PunyaAkses('Bon Sementara Kabang','aktif'))
                             <button type="button" class="btn btn-sm btn-primary" onclick="kacab({{$bonsem->bp_id}})" data-toggle="modal" data-target="#myModal2">  PROSES KACAB </button>      
                              @endif

                             </td>

                             <td> @if(Auth::user()->PunyaAkses('Bon Sementara Kabang','aktif'))
                                    @if($bonsem->bp_pelunasan == '0.00') 
                                  <button class="btn btn-sm btn-danger" onclick="uangterima({{$bonsem->bp_id}})" data-toggle="modal" data-target="#modaluangterima"> <i class="fa fa-money"> </i> Terima Uang ? </button> </td>
                                    @endif
                                  @endif
                             <td>
                               @if(Auth::user()->PunyaAkses('Bon Sementara Cabang','aktif'))
                                @if($bonsem->bp_setujukacab != 'SETUJU')
                                <button class="btn btn-warning btn-sm" onclick="editform({{$bonsem->bp_id}})" data-toggle="modal" data-target="#myModaledit"> <i class="fa fa-pencil"> </i>  </button>
                                <button class="btn btn-danger btn-sm" onclick="hapusData({{$bonsem->bp_id}})"> <i class="fa fa-trash"> </i> </button>
                                @endif
                                @endif
                              </td>

                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div><!-- /.box-body -->



                 <!-- modal kacab-->
                            <div class="modal inmodal fade" id="modaluangterima" tabindex="-1" role="dialog"  aria-hidden="true">
                              <div class="modal-dialog"  style="min-width: 800px !important; min-height: 400px">
                                  <div class="modal-content">
                                     <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                      <h4 class="modal-title"> Terima Uang  </h4>

                                     </div>
                            
                              <div class="modal-body">
                                <form id="terimauang">
                                  <div class="table-responsive">
                                  <table class="table table-bordered table-striped" style="width:100%">
                                    <tr>
                                      <th> Nota Bonsem </th>
                                      <th> Pengajuan Cabang </th>
                                      <th> Persetujuan Kepala Cabang </th>
                                      <th> Persetujuan Admin Pusat </th>
                                      <th> Persetujuan Manager Keu Pusat </th>
                                    </tr>
                                    <tr>
                                        <td> <input type='text' class='form-control notabonsem' style="min-width: 150px" readonly=""> </td>
                                        <td> <input type='text' class='form-control nominalcabang' style="min-width: 120px; text-align: right;" readonly=""> </td>
                                        <td> <input type='text' class='form-control nominalkabag' style="min-width: 120px;text-align: right;"  readonly=""> </td>
                                        <td> <input type='text' class='form-control nominaladmin' style="min-width: 120px;text-align: right;" readonly=""> </td>
                                        <td> <input type='text' class='form-control nominalmenkeu' style="min-width: 120px;text-align: right;" readonly=""> <input type="hidden" class="idbonsem"> </td>
                                    </tr>
                                  </table>


                                  <table style="border: 0px">
                                    <tr>
                                        <td> Apakah Cabang sudah menerima uang ? </td>
                                        <td> &nbsp; </td>
                                        <td> <button class="btn btn-sm btn-success" type="button" id="terima"> Terima </button> </td>
                                        <td> &nbsp; </td>
                                        <td>

                                            <button class="btn btn-sm btn-danger" type="button" id="batalterima"> Batal </button>
                                          </td>
                                          <td>
                                              &nbsp;
                                          </td>
                                          <td>
                                            <p class="doneterima" style="color: blue">  <i> *Uang sudah diterima </i>  </p>
                                        </td>
                                    </tr>
                                  </table>
                                </form>
                                </div>
                              </div>



                        
                       </div>
                  </div> 

                      </div> <!-- ENd Modal -->

                  <!-- modal kacab-->
                            <div class="modal inmodal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                              <div class="modal-dialog"  style="min-width: 800px !important; min-height: 800px">
                                  <div class="modal-content">
                                     <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                      <h4 class="modal-title"> Data Bonsem  </h4>     
                                     </div>
                            
                              <div class="modal-body">
                                <form id="statuskacab">
                                <p> Status Kepala Cabang : <span class="label label-info statuskacab"> </span> </p>
                                <h3> <p > Data Kas Cabang <b class="namacabang">  </b> saat ini Rp <b class="kascabang">500,000.00</b> </p> </h3>

                                  <table class="table" style="width:80%">
                                  <tr>
                                    <th> Cabang </th>
                                    <td>
                                      <input type="text" class="form-control cabang" name="cabang" readonly="">
                                       <input type="hidden" class="form-control idpb" name="idpb" readonly="">
                                     </td>
                                  </tr>
                                  <tr>
                                    
                                    <input type='hidden' name='username' value="{{Auth::user()->m_name}}">

                                    <th> No Nota </th>
                                      <td> <input type="text" class="form-control input-sm nonota" name="nonota" required="" readonly="">  </td>
                                  </tr>
                                  <tr>  
                                  <th> Tanggal </th>
                                  <td class="disabled"> <input type="text" class="input-sm form-control tgl" name="tgl" readonly="">
                                          
                                        </td>
                                  </tr>
                                  <tr>
                                    <th> Bagian </th>
                                    <td> <input type="text" class="form-control bagian input-sm capital" name="bagian" readonly=""> </td>
                                  </tr>
                                  <tr>
                                    <th> Nominal </th>
                                    <td> <input type="text" class="nominal form-control input-sm edit" name="nominal" style="text-align:right"> </td>
                                  </tr>
                                  <tr> 
                                    <th> Keperluan </th>
                                    <td> <input type="text" class="form-control input-sm keperluan capital" name="keperluan" readonly=""></td>
                                  </tr>

                                  <tr>
                                    <th> Status Kepala Cabang </th>
                                    <td> <select class="form-control edit setujukacab" name="statuskacab"> <option value="SETUJU"> Setuju </option> <option value="TIDAK SETUJU"> Tidak Setuju </select></td>
                                  </tr>

                                  <tr>
                                    <th> Keterangan Kepala Cabang </th>
                                    <td> <input type="text" class="form-control keterangankacab edit" name="keterangankacab"> </td>
                                  </tr>
                                </table>


                              
                              </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                           
                             <button type="submit"  class="simpan btn btn-success"> Simpan  </button>
                            </form>
                        </div>
                       </div>
                  </div> 

                      </div> <!-- ENd Modal -->


                      <!-- Modal edit -->
                        <div class="modal inmodal fade" id="myModaledit" tabindex="-1" role="dialog"  aria-hidden="true">
                              <div class="modal-dialog"  style="min-width: 800px !important; min-height: 800px">
                                  <div class="modal-content">
                                     <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                      <h4 class="modal-title"> Data Bonsem  </h4>     
                                     </div>
                            
                              <div class="modal-body">
                                <form id="editcabang">
                                
                                <h3> <p > Data Kas Cabang <b class="namacabang">  </b> saat ini Rp <b class="kascabang">500,000.00</b> </p> </h3>

                                  <table class="table" style="width:80%">
                                  <tr>
                                    <th> Cabang </th>
                                    <td>
                                      <input type="text" class="form-control cabang" name="cabang" readonly="">
                                       <input type="hidden" class="form-control idpb" name="idpb" readonly="">
                                     </td>
                                  </tr>
                                  <tr>
                                    

                                    <th> No Nota </th>
                                      <td> <input type="text" class="form-control input-sm nonota" name="nonota" required="" readonly="">  </td>
                                  </tr>
                                  <tr>  
                                  <th> Tanggal </th>
                                  <td ><div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tgl" required="">
                                      </div>
                                         
                                        </td>
                                  </tr>
                                  <tr>
                                    <th> Bagian </th>
                                    <td> <input type="text" class="form-control bagian input-sm capital" name="bagian"> </td>
                                  </tr>
                                  <tr>
                                    <th> Nominal </th>
                                    <td> <input type="text" class="nominal form-control input-sm edit" name="nominal" style="text-align:right"> </td>
                                  </tr>
                                  <tr> 
                                    <th> Keperluan </th>
                                    <td> <input type="text" class="form-control input-sm keperluan capital" name="keperluan"></td>
                                  </tr>

                                </table>
                              </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                           
                             <button type="submit"  class="simpan btn btn-success"> Simpan  </button>
                            </form>
                        </div>
                       </div>
                  </div> 

                      </div>




                <div class="box-footer">
                  <div class="pull-right">
                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

 $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
       
    })

  $('#terima').click(function(){   
     idbonsem = $('.idbonsem').val();
     $.ajax({
        url : baseUrl + '/bonsementaracabang/terimauang',
        type : "POST",
        dataType : "json",
        data : {idbonsem},
        success : function(){
            alertSuccess();
            location.reload();
        }
      })
  })

  $('#batalterima').click(function(){
    $('#modaluangterima').modal('hide');
  })
  
  $('#editcabang').submit(function(event){
     event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
        
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Faktur Pembelian!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
               
        $.ajax({
          type : "POST",          
          data : form_data2,
          url : baseUrl + '/bonsementaracabang/updatecabang',
          dataType : 'json',
          success : function (response){
               alertSuccess();
               $('.simpandata').attr('disabled' ,true);
               $('#myModaledit').modal("toggle" );
               location.reload();
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
  });



function hapusData(id){
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
      url:baseUrl + '/bonsementaracabang/hapus/'+id,
      type:'get',
      success:function(data){
      
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data Berhasil Dihapus",
                timer: 2000,
                showConfirmButton: true
                },function(){
                   location.reload();
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

$('#statuskacab').submit(function(event){ 
          kascabang = $('.kascabang').text();
          kascabang = kascabang.replace(/,/g, '');
         

          val =$('.nominal').val();
          
          nominal = val.replace(/,/g, '');
         
          /* if(parseFloat(kascabang) < parseFloat(nominal)){
            toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
          
            $(this).val('');
            return false;
           }*/

        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
        
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Faktur Pembelian!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
               
        $.ajax({
          type : "POST",          
          data : form_data2,
          url : baseUrl + '/bonsementaracabang/updatekacab',
          dataType : 'json',
          success : function (response){
               alertSuccess();
               $('.simpandata').attr('disabled' ,true);
               $('#myModal2').modal("toggle" );
               location.reload();
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
      });


  function editform(id){
    var idpb = id;
    $.ajax({
       data : {idpb},
    url : baseUrl + '/bonsementaracabang/setujukacab',
    type : "get",
    dataType : 'json',
    success : function(response){
      statuskacab = response['pb'][0].bp_setujukacab;
      
      $('.edit').attr('readonly' , false);

      if(statuskacab === null){
         $('.statuskacab').text('BELUM DI SETUJUI');
         $('.nominal').val(addCommas(response['pb'][0].bp_nominal));
      }
      else if(statuskacab == 'SETUJU'){
        $('.nominal').val(addCommas(response['pb'][0].bp_nominalkacab));
        $('.keterangankacab').val(response['pb'][0].bp_keterangankacab);
        $('.statuskacab').text(response['pb'][0].bp_setujukacab); 
        $('.setujukacab').val(response['pb'][0].bp_setujukacab);     
      }
      else {
        $('.statuskacab').text(response['pb'][0].bp_setujukacab);
        $('.setujukacab').val(response['pb'][0].bp_setujukacab);     

      }

      $('.cabang').val(response['pb'][0].nama);
      $('.nonota').val(response['pb'][0].bp_nota);
      $('.tgl').val(response['pb'][0].bp_tgl);
      $('.bagian').val(response['pb'][0].bp_bagian);
      
      $('.keperluan').val(response['pb'][0].bp_keperluan);
      $('.idpb').val(response['pb'][0].bp_id);

      $('.nominal').change(function(){
         kascabang = $('.kascabang').text();
          kascabang = kascabang.replace(/,/g, '');
         

          val =$(this).val();
          val = accounting.formatMoney(val, "", 2, ",",'.');

          nominal = val.replace(/,/g, '');
         
           /*if(parseFloat(kascabang) < parseFloat(nominal)){
            toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
            //$('.nominal').attr('readonly' , true);
            $(this).val('');
            return false;
           }*/

          $(this).val(val);
      })
    }
    })
  }

function uangterima(id){
  
   var idpb = id;
  //alert(idpb);
  $.ajax({
    data : {idpb},
    url : baseUrl + '/bonsementaracabang/setujukacab',
    type : "get",
    dataType : 'json',
    success : function(response){
      $('.notabonsem').val(response['pb'][0].bp_nota);
      $('.nominalcabang').val(addCommas(response['pb'][0].bp_nominal));
      $('.nominalkabag').val(addCommas(response['pb'][0].bp_nominalkacab));
      $('.nominaladmin').val(addCommas(response['pb'][0].bp_nominaladmin));
      $('.nominalmenkeu').val(addCommas(response['pb'][0].bp_nominalkeu));
     $('.idbonsem').val(response['pb'][0].bp_id);
      if(response['pb'][0].bp_terima == 'DONE'){
        $('#terima').attr('disabled' , true);
      }
    }
  })
}

function kacab(id) {
  var idpb = id;
  //alert(idpb);
  $.ajax({
    data : {idpb},
    url : baseUrl + '/bonsementaracabang/setujukacab',
    type : "get",
    dataType : 'json',
    success : function(response){
      statuskacab = response['pb'][0].bp_setujukacab;
      
      if(statuskacab === null){
         $('.statuskacab').text('BELUM DI SETUJUI');
         $('.nominal').val(addCommas(response['pb'][0].bp_nominal));
      }
      else if(statuskacab == 'SETUJU'){
        $('.nominal').val(addCommas(response['pb'][0].bp_nominalkacab));
        $('.keterangankacab').val(response['pb'][0].bp_keterangankacab);
        $('.statuskacab').text(response['pb'][0].bp_setujukacab); 
        $('.setujukacab').val(response['pb'][0].bp_setujukacab);     
      }
      else {
        $('.statuskacab').text(response['pb'][0].bp_setujukacab);
        $('.setujukacab').val(response['pb'][0].bp_setujukacab);     

      }

      $('.cabang').val(response['pb'][0].nama);
      $('.nonota').val(response['pb'][0].bp_nota);
      $('.tgl').val(response['pb'][0].bp_tgl);
      $('.bagian').val(response['pb'][0].bp_bagian);
      
      $('.keperluan').val(response['pb'][0].bp_keperluan);
      $('.idpb').val(response['pb'][0].bp_id);

      $('.nominal').change(function(){
         kascabang = $('.kascabang').text();
          kascabang = kascabang.replace(/,/g, '');
         

          val =$(this).val();
          val = accounting.formatMoney(val, "", 2, ",",'.');

          nominal = val.replace(/,/g, '');
         
           /*if(parseFloat(kascabang) < parseFloat(nominal)){
            toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
            //$('.nominal').attr('readonly' , true);
            $(this).val('');
            return false;
           }*/

          $(this).val(val);
      })

      if(response['pb'][0].bp_setujuadmin == 'SETUJU'){
      
        $('.edit').attr('readonly' , true);
      }
    }
  })
}


function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }
</script>
@endsection
