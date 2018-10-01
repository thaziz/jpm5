@extends('main')

@section('title', 'dashboard')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Bank Masuk </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Transaksi Bank Masuk </a>
                        </li>
                        <li class="active">
                            <strong> Bank Masuk </strong>
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
        <h2 style='text-align:center'> <b> {{$data['belumdiproses']}} DATA </b></h2> <h4 style='text-align:center'> Belum di proses  </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['sudahdiproses']}} DATA  </b></h2> <h4 style='text-align:center'> Sudah di proses </h4>
      </div>
    </div>


    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Daftar Bank Masuk
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                        <a type="button" class='btn btn-sm btn-success' id="tmbhdatabm" href="{{url('bankmasuk/createbankmasuk')}}"> <i class="fa fa-plus"> </i> Tambah Data </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped konfirmasi">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> Nota Bank Masuk </th>
                        <th> Nota Transaksi </th>
                        <th> Bank Asal </th>
                        <th> Bank Tujuan </th>
                        <th> Nominal </th>
                        <th> Jenis Bayar </th>                   
                        <th> Status </th>
                        <th> Aksi </th>                    
                       
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['bankmasuk'] as $key=>$bankmasuk)
                        <tr>
                        <td> {{$key + 1}} </td>
                        <td> @if($bankmasuk->bm_nota != '')
                                {{$bankmasuk->bm_nota}}
                            @else
                                -
                            @endif
                        </td>
                        <td> {{$bankmasuk->bm_notatransaksi}} </td>
                        <td> {{$bankmasuk->bm_bankasal}} - {{$bankmasuk->bm_namabankasal}} </td>
                        <td> {{$bankmasuk->bm_banktujuan}} - {{$bankmasuk->bm_namabanktujuan}} </td>
                        <td style="text-align: right"> {{number_format($bankmasuk->bm_nominal ,2)}} </td>
                      
                        <td> {{$bankmasuk->bm_jenisbayar}}</td>
                        <td> <span class="label label-info"> {{$bankmasuk->bm_status}} </span></td>
                        <td>
                        @if($bankmasuk->bm_status == 'DITERIMA')
                          @if($bankmasuk->bm_notatransaksi == 'TRANSAKSI BM')
                               <a onclick="lihatjurnal('{{$bankmasuk->bm_nota}}')" class="btn-xs btn-primary" aria-hidden="true"> <i class="fa  fa-eye"> </i>
                               </a>   &nbsp;  <a class="btn btn-warning btn-xs" type="button" href="{{url('bankmasuk/editdata/'.$bankmasuk->bm_id.'')}}"> <i class="fa fa-pencil"> </i> </a> &nbsp;  <a class="btn btn-danger btn-xs" type="button" onclick="hapusdata({{$bankmasuk->bm_id}})"> <i class="fa fa-trash"> </i> </a> 
                          @else
                            @if($bankmasuk->fpgb_jeniskelompok == 'BEDA BANK')
                              <a onclick="lihatjurnal('{{$bankmasuk->bm_nota}}')" class="btn-xs btn-primary" aria-hidden="true"> <i class="fa  fa-eye"> </i> </a> &nbsp;
                              <a onclick="editjurnalbeda('{{$bankmasuk->bm_nota}}')" class="btn-xs btn-primary" aria-hidden="true"> <i class="fa  fa-pencil"> </i> </a> &nbsp; 
                              <a onclick="hapusjurnalbeda('{{$bankmasuk->bm_nota}}')" class="btn-xs btn-primary" aria-hidden="true"> <i class="fa  fa-trash"> </i> </a>
                            @else
                             <a onclick="lihatjurnal('{{$bankmasuk->bm_nota}}')" class="btn-xs btn-primary" aria-hidden="true"> <i class="fa  fa-eye"> </i>
                             &nbsp;  Jurnal &nbsp; </a>
                            @endif
                            @endif
                           </a>
                        @else
                           <a class="btn btn-success btn-sm" onclick="proses('{{$bankmasuk->bm_id}}')" type="button" data-toggle="modal" data-target="#myModal5"> <i class="fa fa-book"> </i> &nbsp; PROSES &nbsp; </a>
                            
                          @endif

                        </td>
                        
                    </tr>
                        @endforeach
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>
 <div id="jurnal" class="modal" >
                        <div class="modal-dialog">
                          <div class="modal-content no-padding">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h5 class="modal-title">Laporan Jurnal</h5>
                              <input type="hidden" class="refbank">

                              <h4 class="modal-title bk"> No BM:  <u> <p class="notabm"> </u> </h4>
                             
                              
                            </div>
                            <div class="modal-body" style="padding: 15px 20px 15px 20px">                            
                                      <table id="table_jurnal" class="table table-bordered table-striped">
                                          <thead>
                                              <tr>
                                                  <th> ID Akun </th>
                                                  <th>Akun</th>
                                                  <th>Debit</th>
                                                  <th>Kredit</th>
                                                  <th> Uraian </th>                                         
                                              </tr>
                                          </thead>
                                          
                                      </table>                            
                                </div>                          
                          </div>
                        </div>
                      </div>


 <!-- Edit Bank -->
 <div class="row" style="padding-bottom: 50px;"></div>
    <div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 800px !important; min-height: 600px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h2 class="modal-title" style="text-align: center;"> Terima Uang </h2>     
                  </div>
                                
                  <div class="modal-body"> 
                    <form id="editterima">
                    <table class="table table-stripped tbl-faktur" id="tbl-faktur">
                        <tr>
                            <th> Nota Transaksi </th>
                            <td> <input type="text" class="form-control input-sm notatransaksi" name="notransaksi" readonly=""> <input type="hidden" class="form-control input-sm bmid" name="id">  </td>
                        </tr>
                        <tr>
                            <th> Tgl Terima </th>
                            <td> <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tgl" required="">
                                      </div>
                                         
                                       
                                      </td>
                        </tr>
                        <tr>
                            <th> Bank Asal </th>
                            <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control input-sm bankasal" name="bankasal" readonly=""> </div> <div class="col-md-6"> <input type="text" class="form-control namabankasal" readonly=""> </div> </div> </td>
                        </tr>
                        <tr>
                            <th> Bank Tujuan </th>
                            <td> <div class="row"> <div class="col-md-4"><input type="text" class="form-control input-sm banktujuan" name="banktujuan" readonly=""> </div>
                            <div class="col-md-6">  <input type="text" class="form-control namabanktujuan" readonly=""></div> <input type="hidden" class="form-control input-sm cabangasal" name="cabangasal" readonly="">
                            <input type="hidden" class="form-control input-sm cabangtujuan" name="cabangtujuan" readonly=""> </td>
                        </tr>
                        <tr>
                            <th> Nominal </th>
                            <td> <input type="text" class="form-control input-sm nominal" name="nominal" readonly=""></td>
                        </tr>
                    </table>
                  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="buttongetid">Simpan</button>
                       </form>
                    </div>
                </div>
              </div>
           </div>



  <div class="row" style="padding-bottom: 50px;"></div>
    <div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 800px !important; min-height: 600px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h2 class="modal-title" style="text-align: center;"> Terima Uang </h2>     
                  </div>
                                
                  <div class="modal-body"> 
                    <form id="saveterima">
                    <table class="table table-stripped tbl-faktur" id="tbl-faktur">
                        <tr>
                            <th> Nota Transaksi </th>
                            <td> <input type="text" class="form-control input-sm notatransaksi" name="notransaksi" readonly=""> <input type="hidden" class="form-control input-sm bmid" name="id">  </td>
                        </tr>
                        <tr>
                            <th> Tgl Terima </th>
                            <td> <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tgl" required="">
                                      </div>
                                         
                                       
                                      </td>
                        </tr>
                        <tr>
                            <th> Bank Asal </th>
                            <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control input-sm bankasal" name="bankasal" readonly=""> </div> <div class="col-md-6"> <input type="text" class="form-control namabankasal" readonly=""> </div> </div> </td>
                        </tr>
                        <tr>
                            <th> Bank Tujuan </th>
                            <td> <div class="row"> <div class="col-md-4"><input type="text" class="form-control input-sm banktujuan" name="banktujuan" readonly=""> </div>
                            <div class="col-md-6">  <input type="text" class="form-control namabanktujuan" readonly=""></div> <input type="hidden" class="form-control input-sm cabangasal" name="cabangasal" readonly="">
                            <input type="hidden" class="form-control input-sm cabangtujuan" name="cabangtujuan" readonly=""> </td>
                        </tr>
                        <tr>
                            <th> Nominal </th>
                            <td> <input type="text" class="form-control input-sm nominal" name="nominal" readonly=""></td>
                        </tr>
                    </table>
                  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="buttongetid">Simpan</button>
                       </form>
                    </div>
                </div>
              </div>
           </div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
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

    function hapusdata(id){

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
      $.ajax({
        data : {id},
        type : "get",
        url : baseUrl + '/bankmasuk/hapusdata',
        dataType : "json",
        success : function(response){
          if(response == 'sukses'){
               swal({
                  title: "Berhasil!",
                          type: 'success',
                          text: "Data Berhasil Dihapus",
                          timer: 2000,
                          showConfirmButton: true
                          },function(){
                             location.reload();
                  });
          }
          else {

          }
        }
      })
      )
    }

    function editdata(id){
      idbm = id;
     $.ajax({
        data : {idbm},
        type : "get",
        baseUrl : baseUrl + '/  /editdata',
        dataType : "json",
        success : function(response){

        }
      })
    }

    $('#saveterima').submit(function(){
      event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
        
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data!",
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
          url : baseUrl + '/bankmasuk/saveterima',
          dataType : 'json',
          success : function (response){
               alertSuccess();
              
               $('#myModal5').modal("toggle" );
              // location.reload();
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
    })

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function editjurnalbeda(ref){
        ref = ref;
    $.ajax({
        data : {ref},
        type : 'get',
        url : baseUrl + '/bankmasuk/databank',
        dataType : 'json',
        success : function(response){
          $('.notatransaksi').val(response.bank[0].bm_notatransaksi);
          $('.bankasal').val(response.bank[0].bm_bankasal);
          $('.banktujuan').val(response.bank[0].bm_banktujuan);
          $('.nominal').val(addCommas(response.bank[0].bm_nominal));
          $('.bmid').val(response.bank[0].bm_id);
          $('.cabangasal').val(addCommas(response.bank[0].bm_cabangasal));
          $('.cabangtujuan').val(addCommas(response.bank[0].bm_cabangtujuan));
          $('.namabanktujuan').val(addCommas(response.bank[0].bm_namabanktujuan));
          $('.namabankasal').val(addCommas(response.bank[0].bm_namabankasal));
        }
    })
    }

    function proses(ref){
        ref = ref;
    $.ajax({
        data : {ref},
        type : 'get',
        url : baseUrl + '/bankmasuk/databank',
        dataType : 'json',
        success : function(response){
          $('.notatransaksi').val(response.bank[0].bm_notatransaksi);
          $('.bankasal').val(response.bank[0].bm_bankasal);
          $('.banktujuan').val(response.bank[0].bm_banktujuan);
          $('.nominal').val(addCommas(response.bank[0].bm_nominal));
          $('.bmid').val(response.bank[0].bm_id);
          $('.cabangasal').val(addCommas(response.bank[0].bm_cabangasal));
          $('.cabangtujuan').val(addCommas(response.bank[0].bm_cabangtujuan));
          $('.namabanktujuan').val(addCommas(response.bank[0].bm_namabanktujuan));
          $('.namabankasal').val(addCommas(response.bank[0].bm_namabankasal));
        }
    })
    }

    tableDetail = $('.konfirmasi').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

   $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate : 'today',
    }).datepicker("setDate", "0");
    

    function lihatjurnal(ref){
            ref = ref;
            
          $.ajax({
          type : "get",
          url : baseUrl + '/penerimaanbarang/lihatjurnal',
          data : {ref},
          dataType : "json",
          success : function(response){
                console.log(response);
               $('.notabm').text(response.jurnalref);
                /*$('#data-jurnal').html(response);*/
                $('#jurnal').modal('show');
               
                $('#jurnal').modal('show'); 
             $('.loading').css('display', 'none');
                $('.listjurnal').empty();
                $totalDebit=0;
                $totalKredit=0;
                        console.log(response);
                      
                        for(key = 0; key < response.countjurnal; key++) {
                           
                          var rowtampil2 = "<tr class='listjurnal'> <td>"+response.jurnal[key].id_akun+" </td> <td> "+response.jurnal[key].nama_akun+"</td>";

                          if(response.jurnal[key].dk == 'D'){
                            $totalDebit = parseFloat($totalDebit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                            rowtampil2 += "<td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td> </td> <td>"+response.jurnal[key].jrdt_detail+"</td>";
                          }
                          else {
                            $totalKredit = parseFloat($totalKredit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                            rowtampil2 += "<td> </td><td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td>"+response.jurnal[key].jrdt_detail+"</td>";
                          }

                            rowtampil2 += +
                            $('#table_jurnal').append(rowtampil2);
                        }
                     var rowtampil1 = "</tbody>" +
                      "<tfoot>" +
                          "<tr class='listjurnal'> " +
                                  "<th colspan='2'>Total</th>" +                        
                                  "<th>"+accounting.formatMoney($totalDebit, "", 2, ",",'.')+"</th>" +
                                  "<th>"+accounting.formatMoney($totalKredit,"",2,',','.')+"</th>"
                          "<tr>" +
                      "</tfoot>";
                                     
                   
                      $('#table_jurnal').append(rowtampil1);
              }
        });
   }

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
       
    })
</script>
@endsection
