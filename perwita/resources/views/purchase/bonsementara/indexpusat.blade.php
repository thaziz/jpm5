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
   
    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['adminbelumdiproses']}} DATA </b></h2> <h4 style='text-align:center'> Belum di proses Admin Pusat </h4>
      </div>
    </div>

    <div class="col-md-2" style="min-height: 100px;min-width:120px" >
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['mankeubelumproses']}} DATA  </b></h2> <h4 style='text-align:center'> Belum di proses Manager Keuangan </h4>
      </div>
    </div>

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-warning alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['pencairan']}} DATA  </b></h2> <h4 style='text-align:center'> <br> Proses Transfer  </h4>
      </div>
    </div>
    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
         <h2 style='text-align:center'> <b> {{$data['selesai']}} DATA  </b></h2> <h4 style='text-align:center'> <br> SELESAI </h4>
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
                       
                    </div>
                </div>
                <div class="ibox-content">



<div class="row" >
   <form method="post" id="dataSeach">
      <div class="col-md-12 col-sm-12 col-xs-12">

              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Nomor</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control kosong" type="text" name="nomor" id="nomor" placeholder="Nomor">
                </div>
              </div>



              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1" class="form-control input-sm datepicker2" name="tanggal1" type="text">
                    <span class="input-group-addon">-</span>
                    <input id="tanggal2" "="" class="input-sm form-control datepicker2" name="tanggal2" type="text">
                  </div>
                </div>
              </div>


              <div class="col-md-2 col-sm-6 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat" title="Cari rentang tanggal" type="button" onclick="cari()">
                  <strong>
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" title="Reset" onclick="resetData()">
                  <strong>
                    <i class="fa fa-undo" aria-hidden="true"></i>
                  </strong>
                </button>
              </div>
      </div>



 


    </form>
</div>



                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-body">
                  <div class="col-sm-12">
                  <div class="table-responsive">
                    <table id="addColumn" class="table table-bordered table-striped table_tt ">
                      <thead style="color: white">
                        <tr>
                          <th>No</th>
                          <th> Cabang </th>
                          <th>Nomor</th>
                          <th>Tanggal</th>
                          <th> Nominal Cabang </th>
                          <th> Nominal Admin Pusat </th>
                          <th> Nominal Mankeu </th>
                          <th> Status </th>
                          <th> Proses </th>  
                          <th> Print </th>                       
                        </tr>
                      </thead>
                      <tbody>

                        


                      </tbody>
                    </table>
                    </div>
                  </div>
                </div><!-- /.box-body -->

                  <!-- modal -->
                                    <div class="modal inmodal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                                      <div class="modal-dialog"  style="min-width: 800px !important; min-height: 800px">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                              <h4 class="modal-title"> Data Bonsem  </h4>     
                                             </div>
                                    
                                      <div class="modal-body">
                                        <form id="statusadmin">
                                        <p> Status Admin Keuangan : <span class="label label-info statuskacab"> </span> </p>
                                        {{-- <h3> <p > Data Kas Cabang <b class="namacabang">  </b> saat ini Rp <b class="kascabang">500,000.00</b> </p> </h3>
 --}}
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
                                            <th> Status Admin Pusat </th>
                                            <td> <select class="form-control edit setujukacab" name="statuskacab" readonly> <option value="SETUJU"> Setuju </option> <option value="TIDAK SETUJU"> Tidak Setuju </select></td>
                                          </tr>

                                          <tr>
                                            <th> Keterangan Kepala Cabang </th>
                                            <td> <input type="text" class="form-control keterangankacab edit" name="keterangankacab" readonly> </td>
                                          </tr>

                                            <tr>
                                            <th> Keterangan Admin Pusat </th>
                                            <td> <input type="text" class="form-control keteranganadminpusat " name="keteranganadmin"> </td>
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



                               <div class="modal inmodal fade" id="myModalMenkeu" tabindex="-1" role="dialog"  aria-hidden="true">
                                      <div class="modal-dialog"  style="min-width: 800px !important; min-height: 800px">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                              <h4 class="modal-title"> Data Bonsem  </h4>     
                                             </div>
                                    
                                      <div class="modal-body">
                                        <form id="statuskeu">
                                        <p> Status Manager Keuangan : <span class="label label-info statuskacab"> </span> </p>
                                       {{--  <h3> <p > Data Kas Cabang <b class="namacabang">  </b> saat ini Rp <b class="kascabang">500,000.00</b> </p> </h3>
 --}}
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
                                            <th> Status Manajer Keuangan </th>
                                            <td> <select class="form-control edit setujukacab" name="statuskacab"> <option value="SETUJU"> Setuju </option> <option value="TIDAK SETUJU"> Tidak Setuju </select></td>
                                          </tr>

                                          <tr>
                                            <th> Keterangan Kepala Cabang </th>
                                            <td> <input type="text" class="form-control keterangankacab edit" name="keterangankacab" readonly> </td>
                                          </tr>

                                          <tr>
                                            <th> Keterangan Pusat </th>
                                            <td> <input type="text" class="form-control keteranganpusat edit" name="keteranganpusat"> </td>
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

var tablex;
setTimeout(function () {            
   table();
   tablex.on('draw.dt', function () {
    var info = tablex.page.info();
    tablex.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
    });
});

      }, 1500);

     function table(){
   $('#addColumn').dataTable().fnDestroy();
   tablex = $("#addColumn").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("bonsementarapusat/bonsementarapusat/table") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nomor" :$('#nomor').val(),
                    },
              },
            columns: [
            {data: 'no', name: 'no'},             
            {data: 'nama', name: 'nama'},                           
            {data: 'bp_nota', name: 'bp_nota'},            
            {data: 'bp_tgl', name: 'bp_tgl'},            
            {data: 'bp_nominalkacab', name: 'bp_nominalkacab'},
            {data: 'bp_nominaladmin', name: 'bp_nominaladmin'},
            {data: 'bp_nominalkeu', name: 'bp_nominalkeu'},
            {data: 'status_pusat', name: 'status_pusat'},
            {data: 'prosesmodal', name: 'prosesmodal'},
            {data: 'action', name: 'action'},


                            

    
     
            ],
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            "bFilter": false,
            "responsive": false,
           /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
            }*/



    });
   
}




dateAwal();
function dateAwal(){
      var d = new Date();
      d.setDate(d.getDate()-7);

      /*d.toLocaleString();*/
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",
            autoclose: true,
      })
      /*.datepicker( "setDate", d);*/
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",
            autoclose: true,
      })
      /*.datepicker( "setDate", new Date());*/
      $('.kosong').val('');
      $('.kosong').val('').trigger('chosen:updated');
}

 function cari(){
  table();
 }

 function resetData(){
  $('#tanggal1').val('');
  $('#tanggal2').val('');
  $('.kosong').val('');
  table();
  dateAwal();
}

































 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


$('#statuskeu').submit(function(event){      
          kascabang = $('.kascabang').text();
          kascabang = kascabang.replace(/,/g, '');
         

          val =$('.nominal').val();
          
          nominal = val.replace(/,/g, '');
         
        /*   if(parseFloat(kascabang) < parseFloat(nominal)){
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
          url : baseUrl + '/bonsementarapusat/updatekeu',
          dataType : 'json',
          success : function (response){
               alertSuccess();
               $('.simpandata').attr('disabled' ,true);
               $('#myModalMenkeu').modal("toggle" );
               location.reload();
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
      });


$('#statusadmin').submit(function(event){      
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
          url : baseUrl + '/bonsementarapusat/updateadmin',
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

function setujukeu(id) {
  var idpb = id;
  //alert(idpb);
  $.ajax({
    data : {idpb},
    url : baseUrl + '/bonsementarapusat/setujukeu',
    type : "get",
    dataType : 'json',
    success : function(response){
      statuskacab = response['pb'][0].bp_setujukeu;
      
      if(statuskacab === null){
         $('.statuskacab').text('BELUM DI SETUJUI');
         $('.nominal').val(addCommas(response['pb'][0].bp_nominaladmin));
      }
      else if(statuskacab == 'SETUJU'){
        $('.nominal').val(addCommas(response['pb'][0].bp_nominalkeu));
      
        $('.statuskacab').text(response['pb'][0].bp_setujukeu); 
        $('.setujukacab').val(response['pb'][0].bp_setujukeu);     
      }
      else {
        $('.statuskacab').text(response['pb'][0].bp_setujukeu);
        $('.setujukacab').val(response['pb'][0].bp_setujukeu);     

      }

      $('.keterangankacab').val(response['pb'][0].bp_keterangankacab);
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
         
         /*  if(parseFloat(kascabang) < parseFloat(nominal)){
            toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
            //$('.nominal').attr('readonly' , true);
            $(this).val('');
            return false;
           }*/

          $(this).val(val);
      })

      if(response['pb'][0].status_pusat == 'DITERIMA'){
        $('.edit').attr('readonly' , true);
      }
    }
  })
}

function setujuadmin(id) {
  var idpb = id;
  //alert(idpb);
  $.ajax({
    data : {idpb},
    url : baseUrl + '/bonsementarapusat/setujukacab',
    type : "get",
    dataType : 'json',
    success : function(response){
      statuskacab = response['pb'][0].bp_setujuadmin;
      
      if(statuskacab === null){
         $('.statuskacab').text('BELUM DI SETUJUI');
         $('.nominal').val(addCommas(response['pb'][0].bp_nominalkacab));
      }
      else if(statuskacab == 'SETUJU'){
        $('.nominal').val(addCommas(response['pb'][0].bp_nominaladmin));
      
        $('.statuskacab').text(response['pb'][0].bp_setujuadmin); 
        $('.setujukacab').val(response['pb'][0].bp_setujuadmin);     
      }
      else {
        $('.statuskacab').text(response['pb'][0].bp_setujuadmin);
        $('.setujukacab').val(response['pb'][0].bp_setujuadmin);     

      }

      $('.keterangankacab').val(response['pb'][0].bp_keterangankacab);
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
         
          /* if(parseFloat(kascabang) < parseFloat(nominal)){
            toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
            //$('.nominal').attr('readonly' , true);
            $(this).val('');
            return false;
           }*/

          $(this).val(val);
      })

      if(response['pb'][0].status_pusat == 'DITERIMA'){
        $('.edit').attr('readonly' , true);
      }
    }
  })
}
 $('body').removeClass('fixed-sidebar');
  $("body").toggleClass("mini-navbar");

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
