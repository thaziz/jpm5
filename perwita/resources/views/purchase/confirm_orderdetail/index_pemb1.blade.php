@extends('main')

@section('title', 'dashboard')

@section('content')


<style>
  .row-eq-height {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }

    .table input{
      padding-left: 5px;
    }

    .table th{
      padding:5px;
      border: 1px solid #ccc;
      font-weight: 600;
      font-size : 12px;
    }

    .table td{
       font-size : 12px;
    }

    .table input{
     
      font-size :12px;
    }

    .table select{
    
      font-size :12px;
    }


    .hargatable {
      width: 800px; margin: 0 auto;
    }

    .chosen-drop {
      color : black;
    }
      .disabled {
      pointer-events: none;
      opacity: 1;
    }

    .colorblack{
      background-color: grey;
    }



  </style>

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Konfirmasi Order </h2>
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
                            <strong> Konfirmasi Order </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
              <br>
          <div class="alert alert-info" id="statuskeuangan">
              <p> Pihak Keuangan bisa melakukan transaksi jika pihak pembelian sudah mensetujui transaksi ini </p>
          </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5> Konfirmasi Order SPP
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                    
                          <a class="btn btn-sm btn-default" href="{{url('konfirmasi_order/konfirmasi_order')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                    
                    </div>
                </div>
                  <form method="post" action="{{url('konfirmasi_order/savekonfirmasiorderdetail')}}"  enctype="multipart/form-data" class="form-horizontal" id="formsave">
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->



                
                @foreach($data['spp'] as $spp)
                  <div class="box-body">
                    <div class="row">
                      <div class="col-xs-6">
                          <table border="0" class="table">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="idspp" value="{{$spp->spp_id}}" class="idspp">
                           <input type="hidden" name="idco" value="{{$spp->co_id}}">
                          <tr>
                            <td width="200px">
                             <b> No SPP </b>
                            </td>
                            <td>
                               <input type="text" class="form-control" readonly="" value="{{$spp->spp_nospp}}">
                            </td>
                          </tr>
                          <tr>
                            <td> <b> Tanggal </b> </td>
                            <td>
                             <input type="text" class="form-control" readonly="" value="{{$spp->spp_tgldibutuhkan}}">
                            </td>
                          </tr>

                          <tr>
                            <th> Jenis Item </th>
                            <td> {{$data['jenisitem']}} <input type='hidden' class='jenisitem' value="{{$data['kodejenisitem']}}" name='jenisitem'> </td>
                          </tr>

                          <tr>
                            <td>
                             <b> Keperluan </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->spp_keperluan}}">
                            </td>
                          </tr>
                           <tr>
                            <td>
                             <b> Keterangan </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->spp_keterangan}}">
                            </td>
                          </tr>
                          <tr>
                            <td>
                            <b> Cabang </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->nama}}">
                            </td>
                          </tr>

                           <tr>
                            <td>
                            <b> Tipe </b>
                            </td>
                            <td>
                              <input type="text" class="form-control tipespp" readonly="" value="{{$namatipe}}" name='namatipe'>
                              <input type="hidden" class="prosespembelian" readonly="" value="{{$spp->staff_pemb}}">
                            </td>
                          </tr>

                          <tr>
                            <td> <b> Pemroses </b> </td>
                            <td class="disabled"> 
                                <select class="form-control pemroses" name="pemroses">
                                      
                                      <option value="PEMBELIAN" selected="">
                                         PIHAK PEMBELIAN
                                      </option>
                                   </select>

                            </td>
                          </tr>

                          </table>
                         </div>

                         <div class="col-xs-6">
                            <table class="table">
                              <tr>
                                <th colspan="2" style="text-align:center">
                                    Status Persetujuan
                                </th>
                              </tr>
                              <tr>
                                  <th style="text-align:center"> Staff Pembelian </th>
                                  <th style="text-align:center"> Manager Keuangan </th>
                              </tr>
                              <tr>
                                  <th> 
                                      <input type="hidden" class="form-control statusmankeuangan" value="{{$spp->man_keu}}">

                                      @if($spp->staff_pemb == 'DISETUJUI')
                                         <div style='text-align: center'>  <p class="label label-info" > {{$spp->staff_pemb}} </p> </div>
                                      @else
                                        <div style='text-align: center'>  <p class="label label-danger" > {{$spp->staff_pemb}} </p> </div>
                                      @endif
                                  </th>
                                  <th>
                                    @if($spp->man_keu == 'DISETUJUI')
                                       <div style='text-align: center'>  <p class="label label-info" > {{$spp->man_keu}} </p> </div>
                                    @else
                                      <div style='text-align: center'> <p class="label label-danger" style='text-align: center'>{{$spp->man_keu}} </p> </div>
                                    @endif
                                  </th>
                              </tr>
                            </table>

                            <h3> PEMBAYARAN </h3>
                            
                            <table class="table" id="tbl-pembayaran">
                              <thead>
                              <tr>
                                  <th style='text-align: center'> Nama Supplier </th> <th style="text-align: center"> Total Biaya </th> <th style="text-align: center"> Syarat Kredit </th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                           
                         </div>


                         </div>
                    @endforeach
                    </div>

                    <hr>
                    
                    <h4> Data Barang </h4>

                    <hr>
                    
                  @if($data['countcodt'] > 0)
                     <table class="table table-bordered table-striped hargatable" id="hargatable" style="width:100%">
                      <tr>
                        <td rowspan="2"  style="width:20px"> No </td>
                        <td rowspan="2"  style="width:200px"> Nama Barang </td>
                        <td rowspan="2"  style="width:50px"> Jumlah Permintaan </td>
                        <td rowspan="2"  style="width:50px"> Jumlah Disetujui </td>
                        <td rowspan="2"  style="width:50px"> Satuan </td>
                          @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')                  
                            <td rowspan="2" class='kendaraan'> Kendaraan </td>
                          @endif
                        <td rowspan="2"  style="width:50px"> Stock Gudang </td>
                        <td colspan= {{$data['count']}} style="text-align: center"> Supplier </td>
                      </tr>

                      <tr class="data-supplier">
                         <!--  @foreach($data['codt_supplier'] as $index=>$codtsup)
                          <td class="supplier{{$index}} spl" data-id="{{$index}}" data-supplier="{{$codtsup->codtk_supplier}}">
                            <select class="form-control supplier{{$index}} sup"  data-supplier="{{$codtsup->codtk_supplier}}" disabled="">
                                  <option value="{{$codtsup->codtk_supplier}}"> {{$codtsup->codtk_supplier}} </option>
                              @foreach($data['supplier'] as $sup)
                              <option value="{{$codtsup->codtk_supplier}}" @if($codtsup->codtk_supplier == $sup->no_supplier) selected="" @endif>  {{$sup->nama_supplier}};
                              </option>
                            
                             @endforeach 
                            </select> --> 
                            <td class="supplier{{$index}} spl" data-id="{{$index}}" data-supplier="{{$codtsup->codtk_supplier}}" style="text-align: center">
                               {{$codtsup->nama_supplier}}
                           </td> 
                         <!--  @endforeach -->
                      </tr>


                      @foreach($data['codt_barang'] as $idbarang=>$codt)
                      <tr class="brg{{$idbarang}}" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$codt->codtk_kodeitem}}" >
                        <td> {{$idbarang + 1}} </td>
                        <td> {{$codt->nama_masteritem}} </td>
                        <td> {{$codt->codtk_qtyrequest}} </td>
                        <td> {{$codt->codtk_qtyapproved}} </td>
                        <td> {{$codt->unitstock}}</td>

                          @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')                  
                        <td>  {{$codt->nopol}} </td>
                          @endif
                        <td> 
                        @if($tipespp != 'J')
                          @if($codt->sg_qty == '')
                           Kosong
                            @else
                            {{$codt->sg_qty}}
                             @endif
                        @else
                          -
                          @endif

                         </td>
                         @foreach($data['codt_supplier'] as $codtsupp)
                          <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier"> </td>
                         @endforeach
                       
                      </tr>

                      @endforeach

                       <tr class="totalbiaya">
                        @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')
                           <td colspan="7" style="text-align: center"> <b> Total Biaya </b> </td> 
                       
                        @else
                           <td colspan="6" style="text-align: center"> <b> Total Biaya </b> </td> 
                       
                        @endif                      
                        
                        @foreach($data['codt_tb'] as $cotb)
                          <td data-suppliertotal="{{$cotb->cotbk_supplier}}"> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='input-sm form-control totalbiaya'  value="{{number_format($cotb->cotbk_totalbiaya, 2)}}" readonly="" > </div>  </div></td>
                          @endforeach
                        </tr>

                     

                     </table>
                @else 
                @if($data['spp'][0]->staff_pemb != 'DITOLAK')
                <div class="box-body">
                <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                      
                      <th> Barang </th>
                      <th> Qty Request </th>
                      <th> Qty Approval </th>
                      <th> Satuan </th>
                      <th class='kendaraan'> Kendaraan </th>
                      <th> Ditolak </th>
                      <th> Keterangan Tolak </th>
                      <th style='min-width: 10px'> Harga </th>
                      <th> Supplier </th>
                      <th> Aksi </th>
                      
                  </tr>
                </thead>
                <tbody>
                    @foreach($data['sppdt_barang'] as $index=>$sppdtbarang)
                    <tr class="databarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}">
                      <td rowspan="3"> {{$sppdtbarang->nama_masteritem}} </td>
                      <td rowspan="3"> {{$sppdtbarang->sppd_qtyrequest}}  </td>
                      <td rowspan="3">  <input type="text" class="form-control input-sm qtyreq qtyreq{{$index}}" value="{{$sppdtbarang->sppd_qtyrequest}}" data-id="{{$index}}" style="width: 90px" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}"> </td>
                      

                      <td rowspan="3"> {{$sppdtbarang->unitstock}} </td>
                      @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')
                      <td rowspan="3" class='kendaraan'>  
                        {{$sppdtbarang->nopol}}
                      </td>
                      @endif
                      
                      <td rowspan="3"> <div class="checkbox">
                                          <input type="checkbox"  class="checktolak" value="option1" aria-label="Single checkbox One" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">
                                          <label></label>
                                        </td>
                      <td rowspan="3"> <input type="text" class="form-control keterangantolak keterangantolak{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly=""> </td>


                      <td>                       
                        <input type='text' class="form-control hargacek hargacek0 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0' style="min-width:30px" name="hargacek[]"> 

                        <input type='hidden' class="form-control hargamanual0 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0'>
                        
                        <input type='hidden' class="barang{{$index}}" name="barang[]" value="{{$sppdtbarang->sppd_kodeitem}}">

                        <input type="hidden" class="form-control status{{$index}}" value="SETUJU" name="status[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">

                        <input type="hidden" class="form-control keterangancektolak{{$index}}" name="keterangantolak[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly="">
                                  
                      </td> <!-- Kodeitem -->

                      <td>
                        <select class="chosen-select-width form-control suppliercek0 suppliercek suppliercekbarang{{$index}}" name="suppliercek[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0'>  <option value="" > </option>  </select>

                          <input type='hidden' class="form-control suppliermanual0 suppliercekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0'>

                          <input type="hidden" value="{{$sppdtbarang->sppd_qtyrequest}}" name="qtyrequest[]">

                          @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')                  
                          <input type="hidden" value="{{$sppdtbarang->sppd_kendaraan}}" name="kendaraan[]">
                          @endif

                          <input type='hidden' class='qtybarang{{$index}}' data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" name='qtyapproval[]' value="{{$sppdtbarang->sppd_qtyrequest}}">
                      </td> <!-- Harga -->
                      

                      <tr class="datacek1 datacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}">
                        <td>
                          <!--Kodeitem  -->
                          <input type='text' class="form-control hargacek hargacek1 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1' style="min-width:30px" name="hargacek[]">

                          <input type='hidden' class="form-control hargamanual1 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1'>

                        <input type='hidden' class="barang{{$index}}" name="barang[]" value="{{$sppdtbarang->sppd_kodeitem}}">

                       
                          @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')                  
                          <input type="hidden" value="{{$sppdtbarang->sppd_kendaraan}}" name="kendaraan[]">
                          @endif
                        <input type="hidden" value="{{$sppdtbarang->sppd_qtyrequest}}" name="qtyrequest[]">
                        <input type='hidden' class='qtybarang{{$index}}' data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" name='qtyapproval[]' value="{{$sppdtbarang->sppd_qtyrequest}}">

                          <input type="hidden" class="form-control keterangancektolak{{$index}}" name="keterangantolak[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly="">

                        <input type="hidden" class="form-control status{{$index}}" value="SETUJU" name="status[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">
                        </td>
                        <!-- Supplier -->
                        <td>
                          <select class="chosen-select-width form-control suppliercek1 suppliercekbarang{{$index}} suppliercek" name="suppliercek[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1'> <option value=""> </option> </select>

                          <input type='hidden' class="form-control suppliermanual1 suppliercekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1'>

                        </td>

                        <td> <button class="btn btn-md btn-danger removecek removecek1 removecekbarang{{$index}}" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="1"> <i class="fa fa-trash"> </i> </button> </td>

                      </tr>
                      <tr class="datacek2 datacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}">
                        <td>
                          <!-- Kodeitem -->
                          <input type='text' class="form-control hargacek hargacek2 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2' style="min-width:30px" name="hargacek[]">

                          <input type='hidden' class="form-control hargamanual2 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2'>
                           <input type='hidden' class="barang{{$index}}" name="barang[]" value="{{$sppdtbarang->sppd_kodeitem}}">
                           <input type="hidden" value="{{$sppdtbarang->sppd_qtyrequest}}" name="qtyrequest[]">
                           <input type="hidden" class="form-control status{{$index}}" value="SETUJU" name="status[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">

                           <input type='hidden' class='qtybarang{{$index}}' data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" name='qtyapproval[]' value="{{$sppdtbarang->sppd_qtyrequest}}">

                          <input type="hidden" class="form-control keterangancektolak{{$index}}" name="keterangantolak[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly="">


                          @if($namatipe == 'NON STOCK' && $data['kodejenisitem'] == 'S')                  
                          <input type="hidden" value="{{$sppdtbarang->sppd_kendaraan}}" name="kendaraan[]">
                          @endif                        </td>
                        <!-- Harga -->
                        <td class='supplier1'>
                          <select class="chosen-select-width form-control suppliercek suppliercek2 suppliercekbarang{{$index}}" name="suppliercek[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2'> <option value="">  </option> </select>

                          <input type='hidden' class="form-control suppliermanual2 suppliercekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2'>


                        </td>

                        <td> <button class="btn btn-md btn-danger removecek removecek2 removecekbarang{{$index}}" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="2"> <i class="fa fa-trash"> </i> </button> </td>
                      </tr>

                    @endforeach
                </tbody>
                </table>
              </div>
                <button class="btn btn-md btn-danger" type="button" id="cektb"> Cek Total Biaya </button>
                <button class="btn btn-md btn-success simpantb" type="simpan"> Simpan</button>
                 
                </div><!-- /.box-body -->
                @endif
                @endif
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
<div class="modal fade" id="modalsupplier" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 800px !important; min-height: 600px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h4 class="modal-title" style="text-align: center;"> DATA SUPPLIER </h4>     
                  </div>
                                
                  <div class="modal-body"> 
                    <table border="0">
                      <tr>
                          <th> <h3> Data Kode Item : </h3> </th> <th> <h3 class="kodeitemsupplier" style="color:grey"> </h3>
                         </th>
                      </tr>
                    </table>
                   
                    <table class="table table-bordered" id="table-supplier" width="100%">
                      <thead>
                        <tr>
                          <th> No </th> <th> Nama Supplier </th> <th> Harga </th>
                        </tr>
                      </thead>
                    
                    </table>
                  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="buttongetid">Simpan</button>
                       
                    </div>
                </div>
              </div>
           </div>

@endsection



@section('extra_scripts')
<script type="text/javascript">

  clearInterval(reset);
  var reset =setInterval(function(){
     $(document).ready(function(){
      var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"80%"}
                }

             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }
    })
   }, 2000)
  
  $('th.kendaraan').hide();
  $('td.kendaraan').hide();

  tipespp = $('.tipespp').val();
  jenisitem = $('.jenisitem').val();
  if(tipespp == 'NON STOCK' && jenisitem == 'S'){
    $('th.kendaraan').show();
    $('td.kendaraan').show();
  }

  $('.simpantb').attr('disabled' , true);


  //qty request
  $('.qtyreq').change(function(){
    id = $(this).data('id');
    val = $(this).val();
    kodeitem = $(this).data('kodeitem');

    $('.qtybarang' + id + '[data-kodeitem = '+kodeitem+']').val(val);
    $('.simpantb').attr('disabled' , true);
  })

  $('.keterangantolak').change(function(){
     id = $(this).data('id');
    val = $(this).val();
    kodeitem = $(this).data('kodeitem');

    $('.keterangancektolak' + id + '[data-kodeitem = '+kodeitem+']').val(val);
    $('.simpantb').attr('disabled' , true);
  })

  $('.hargacek').change(function(){
    val = $(this).val();
       val = accounting.formatMoney(val, "", 2, ",",'.');
      $(this).val(val);
    $('.simpantb').attr('disabled' , true);
  })

  $('#formsave').submit(function(event){
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
             alertSuccess(); 
             $('.simpantb').hide();
             $('.cektb').hide();
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      })


  $('.removecek').click(function(){
    id = $(this).data('id');
    kodeitem = $(this).data('kodeitem');
    $('tr.datacek' + id + '[data-kodeitem = '+kodeitem+']').addClass('disabled');
    $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').addClass('colorblack');
    $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').addClass('disabled');
    $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , true);
    $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').val('');
    $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').val('');

    $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').trigger("chosen:updated");
     $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').trigger("liszt:updated");
     $('.simpantb').attr('disabled' , true);
  })

  $('.checktolak').change(function(){
    if($(this).is(':checked')){       
      id = $(this).data('id');
      kodeitem = $(this).data('kodeitem');
    


      $('.hargacekbarang' + id + '[data-kodeitem = '+kodeitem+']').addClass('colorblack');
    
      $('.hargacekbarang' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , true);
      $('.suppliercekbarang' + id + '[data-kodeitem = '+kodeitem+']').val('');
      $('.hargacekbarang' + id + '[data-kodeitem = '+kodeitem+']').val('');

      $('.suppliercekbarang' + id + '[data-kodeitem = '+kodeitem+']').trigger("chosen:updated");
      $('.suppliercekbarang' + id + '[data-kodeitem = '+kodeitem+']').trigger("liszt:updated");

      $('.status' + id + '[data-kodeitem = '+kodeitem+']').val('TIDAK SETUJU');
      $('.keterangancektolak' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , false);
      $('.keterangantolak' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , false);
      $('.simpantb').attr('disabled' , true);
    }
    else {
      id = $(this).data('id');
      kodeitem = $(this).data('kodeitem');
      harga  =      $('.hargacekmanual' + id + '[data-kodeitem = '+kodeitem+']').val();
      supplier =   $('.suppliercekmanual' + id + '[data-kodeitem = '+kodeitem+']').val();
      
      $('.hargacekmanual' + id +  '[data-kodeitem = '+kodeitem+']').each(function(){
        id2 = $(this).data('id');
        val = $(this).val();
        $('.hargacek' + id2 + '[data-kodeitem= '+kodeitem+']').val(val);
      });

       $('.suppliercekmanual' + id +  '[data-kodeitem = '+kodeitem+']').each(function(){
        id2 = $(this).data('id');
        val = $(this).val();
        $('.suppliercek' + id2 + '[data-kodeitem= '+kodeitem+']').val(val);
      });


      $('.hargacekbarang' + id + '[data-kodeitem = '+kodeitem+']').removeClass('colorblack');
      $('.suppliercekbarang' + id + '[data-kodeitem = '+kodeitem+']').removeClass('disabled');
      $('.hargacekbarang' + id + '[data-kodeitem = '+kodeitem+']').attr('disabled' , false);

      $('.suppliercekbarang' + id + '[data-kodeitem = '+kodeitem+']').trigger("chosen:updated");
      $('.suppliercekbarang' + id + '[data-kodeitem = '+kodeitem+']').trigger("liszt:updated");

        $('.status' + id + '[data-kodeitem = '+kodeitem+']').val('SETUJU');
        $('.keterangantolak' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , true);
        $('.keterangancektolak' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , true);
        
         $('.simpantb').attr('disabled' , true);
    }

  })

   function removeDuplicates(inputArray) {
            var i;
            var len = inputArray.length;
            var outputArray = [];
            var temp = {};

            for (i = 0; i < len; i++) {
                temp[inputArray[i]] = 0;
            }
            for (i in temp) {
                outputArray.push(i);
            }
            return outputArray;
     }

    function find_duplicate_in_array(arra1) {
        var object = {};
        var result = [];

        arra1.forEach(function (item) {
          if(!object[item])
              object[item] = 0;
            object[item] += 1;
        })

        for (var prop in object) {
           if(object[prop] >= 2) {
               result.push(prop);
           }
        }

        return result;

    }

  $('#cektb').click(function(){
     
      arrjumlahtotal = [];

      $('.qtyreq').each(function(){
        qty = $(this).val();
        idqty = $(this).data('id');
     
     
        $('.hargacekbarang' + idqty).each(function(){
          harga2 = $(this).val();
          idharga = $(this).data('id');
          kodeitem = $(this).data('kodeitem');
          supplier = $('.suppliercek' + idharga + '[data-kodeitem = '+kodeitem+']').val();
          
          if(harga2 == '' && supplier == ''){
           /* toastr.info("Harga ada yang kosong mohon dilengkapi :)");
            return false*/
          }
          else {            
            harga = harga2.replace(/,/g, '');
            totalharga = (parseFloat(qty) * parseFloat(harga)).toFixed(2);          
            arrjumlahtotal.push({
              totalharga : totalharga,
              supplier :supplier,
             
            });
          }
        })
      })

      arrsupplier = [];
      $('.suppliercek').each(function(){
        val = $(this).val();
        if(val == ''){
        /*  toastr.info("Data Supplier ada yang kosong, mohon diisi :)");
          return false;*/
        }
        else{ 
                arrsupplier.push(val);
              }
      })


      hslsupplier = removeDuplicates(arrsupplier);
      console.log(hslsupplier);
      console.log(arrjumlahtotal);
      console.log(arrsupplier);
      if(hslsupplier.length > 3){
        toastr.info("Terdapat lebih dari 3 supplier yang berbeda, tidak bisa di proses kembali :)");
        return false;
      }

      hargasupplier = [];
   
     hargasupplier2 = [];

      $duplicatesupplier = find_duplicate_in_array(arrsupplier);
      for($i = 0; $i < $duplicatesupplier.length; $i++){
        jumlahtotal = 0;
        supplierduplicate = $duplicatesupplier[$i];
        for($j = 0; $j < arrjumlahtotal.length; $j++){
          if(supplierduplicate == arrjumlahtotal[$j]['supplier']){
            jumlahtotal = parseFloat(jumlahtotal) + parseFloat(arrjumlahtotal[$j]['totalharga']);   
          }
        }

          index = arrjumlahtotal.indexOf(supplierduplicate);
         hargasupplier2.push({
          supplier : supplierduplicate,
          jumlahtotal : jumlahtotal,
          index : index,
         });
      }

      for($i = 0; $i < hslsupplier.length; $i++){
          jumlahtotal = 0;
          for($k = 0; $k < arrjumlahtotal.length; $k++){
            supplier1 = hslsupplier[$i];
            supplier2 = arrjumlahtotal[$k]['supplier'];
            if(supplier1 == supplier2){
              jumlahtotal = parseFloat(parseFloat(jumlahtotal) + parseFloat(arrjumlahtotal[$k]['totalharga'])).toFixed(2);
            }
            else {
              //jumlahtotal = parseFloat(jumlahtotal) + parseFloat(arrjumlahtotal[$k]['totalharga']);
            }
          }
          hargasupplier.push(jumlahtotal);
      } 
/*
      console.log($duplicatesupplier);*/
      
       

      hslsupplier = hslsupplier; 
      idspp = $('.idspp').val();
      $.ajax({
        url : baseUrl + '/konfirmasi_order/cekhargatotal',
        data : {hslsupplier, idspp},
        type : "get",      
        dataType : 'json',
        success : function(response){
           $('.simpantb').attr('disabled' , false);
            $('tr.totalcekpembayaran').remove();
            for($j = 0; $j < response.datasupplier.length; $j++){
              html ="<tr class='totalcekpembayaran'> <td>"+response.datasupplier[$j][0].nama_supplier+" <input type='hidden' name='suppliercekbayar[]' value="+response.datasupplier[$j][0].idsup+"></td>"+
                    "<td>"+addCommas(hargasupplier[$j])+" <input type='hidden' name='totalbayarpembayaran[]' value="+hargasupplier[$j]+"></td>";
                    if(response.temp[$j] == 0){
                    html += "<td>"+response.datasupplier[$j][0].syarat_kredit+" Hari <input type='hidden' name='syaratkredit[]' value="+response.datasupplier[$j][0].syarat_kredit+"></td>";
                    }
                    else {
                    html +=  "<td>"+response.datasupplier[$j][0].spptb_bayar+" Hari <input type='hidden' name='syaratkredit[]' value="+response.datasupplier[$j][0].spptb_bayar+"> </td>";
                    }
              html += "</tr>"
            
              $('#tbl-pembayaran').append(html);
            }
        }
      })      
  });

  idspp = $('.idspp').val();
  $.ajax({
    url : baseUrl + '/konfirmasi_order/ceksupplier',
    type : 'get',
    data : {idspp},
    dataType : 'json',
    success : function(response){
//      console.log(response.sppd.length);

      for($i = 0; $i < response.sppdt.length; $i++) {
        $key = 0;
        $temp = 0;
        for($j = 0; $j < response.sppd.length; $j++){
          kodeitem = $('.hargacekbarang' + $i).data('kodeitem');
    

          if(response.sppd[$j].sppd_kodeitem == kodeitem){
             if($temp == 1){
                $key = 0;
             }              

                    
              $('.hargacek' + $key + '[data-kodeitem = '+kodeitem+']').val(addCommas(response.sppd[$j].sppd_harga));
              $('.hargamanual' + $key + '[data-kodeitem = '+kodeitem+']').val(addCommas(response.sppd[$j].sppd_harga));

               if(response.temp[$i] == '0'){
                  for($z = 0; $z < response.sppd.length; $z++){
                    for($hg = 0; $hg < response.supplier[$z].length; $hg++){
                        $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').append("<option value="+response.supplier[$z][$hg].is_idsup+">" + response.supplier[$z][$hg].no_supplier+" - "+response.supplier[$z][$hg].nama_supplier+"</option>");
                    }
                  }
               }
               else if(response.temp[$i] == '1'){
                  for($z = 0; $z < response.supplier2.length; $z++){
                    $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').append("<option value="+response.supplier2[$z].idsup+">" +response.supplier2[$z].no_supplier+" - "+response.supplier2[$z].nama_supplier+"</option>");
                    
                  }
               }  
                
                console.log(response.sppd[$j].sppd_supplier);
                $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').val(response.sppd[$j].sppd_supplier);
                $('.suppliermanual' + $key + '[data-kodeitem = '+kodeitem+']').val(response.sppd[$j].sppd_supplier);
                $('.suppliercek' + $key).trigger("chosen:updated");
                $('.suppliercek' + $key).trigger("liszt:updated");

             
              $temp = 0;
          }
          else {
              
             $temp = 1;
          }
          $key++;
        }        
      }

      for($k = 0; $k < response.temp.length; $k++){
          kodeitem = $('.hargacekbarang' + $k).data('kodeitem');
        $('.suppliercekbarang' + $k).each(function(){
          val = $(this).val();
          if(val == ''){
            
             if(response.temp[$k] == '0'){  
                  for($h = 0; $h < response.sppd.length; $h++){
                     for($z = 0; $z < response.supplier[$h].length; $z++){
                      $(this).append("<option value="+response.itemsupplier[$h][$z].is_idsup+">" +response.itemsupplier[$h][$z].no_supplier+" - "+response.itemsupplier[$h][$z].nama_supplier+"</option>");
                  
                   }
                  }              
                 
                $(this).trigger("chosen:updated");
                $(this).trigger("liszt:updated");
               }
               else if(response.temp[$k] == '1'){
             
                  for($z = 0; $z < response.supplier2.length; $z++){                 
                    $(this).append("<option value="+response.supplier2[$z].idsup+">" +response.supplier2[$z].no_supplier+" - "+response.supplier[$z].nama_supplier+"</option>");
                  }

                 $(this).trigger("chosen:updated");
                $(this).trigger("liszt:updated");
               }
              
          }
        })
      }


    },
    error : function(){
      location.reload();
    }
  })


  $('.suppliercek').change(function(){
    id = $(this).data('id');
    kodeitem = $(this).data('kodeitem');
    supplier = $(this).val();
    $.ajax({
      url : baseUrl + '/konfirmasi_order/cekharga',
      type : "get",
      dataType : 'json',
      data : {kodeitem,supplier},
      success : function(response){
          status = $('.status' + id + '[data-kodeitem = '+kodeitem+']').val();
          if(status == 'TIDAK SETUJU'){
          
            $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').val('');
            $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').val('');           
            $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').trigger("chosen:updated");
            $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').trigger("liszt:updated");
            toastr.info("Data Barang ditolak, tidak bisa memilih supplier ini :)");
            return false;

          }
          else if(status == 'SETUJU'){
            $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').val(addCommas(response.harga));
          }
      }
    })
    $('.simpantb').attr('disabled' , true);
  })


  $('.kettolak').attr('readonly' , true);
     $('#statuskeuangan').hide();
  prosespembelian = $('.prosespembelian').val();
  pemroses = $('.pemroses').val();
  if(pemroses == 'KEUANGAN'){
      if(prosespembelian !== "DISETUJUI"){
          $('.cektotal').attr('disabled' , true);
          $('#statuskeuangan').show();
      }
      else {
         $('#statuskeuangan').hide();
      }
     
  }
  else {
    $('#statuskeuangan').hide();
    $('.cektotal').attr('disabled' , false);  
  }

  $('.pemroses').change(function(){
    val = $(this).val();
    if(val == 'KEUANGAN'){
       if(prosespembelian != "DISETUJUI"){
          $('.cektotal').attr('disabled' , true);
          $('#statuskeuangan').show();
        }
        else {
           $('#statuskeuangan').hide();
        }
    }
    else {
        $('#statuskeuangan').hide();
        $('.cektotal').attr('disabled' , false);  
    }
   
  })

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




    $('.sup').each(function(){
        $(this).change(function(){
          id = $(this).data('id');
          val = $(this).val();
         //// alert(val);
          string = val.split(",");
          syaratkredit = string[1];
          $('.bayar' + id).val(syaratkredit);
          $('.supplierco' + id).val(string[0]);
          //alert(id);
      })
    })

    $('.tolak').change(function(){
      var id = $(this).data('id');
        if($('input.tolak'+id).is(':checked')){
        
          $('.qtyapproval'+id).attr('readonly' , true); 
           $('.checkbox' + id).prop('checked' , false); 
          $('.checkbox' + id).attr('disabled' , true);
          $('.kettolak' + id).attr('readonly' , false);

          $('.hrga' + id ).attr('readonly' , true); 
          $('.simpan').attr('disabled', true);
          $('.hrga' + id).val('0');
          databarang = $(this).data('barang');
          $('.databarangtolak').val(databarang);
          $('.status' + id).val('TOLAK');
        }
        else {
        $('.qtyapproval'+id).attr('readonly' , false); 
          $('.checkbox' + id).attr('disabled' , false);
         $('.kettolak'+id).attr('readonly' , true); 
          hargahid = $('.hargahid' + id).val();
          $('.status' + id).val('SETUJU');
        //  alert(hargahid);
          $('.hrga' + id).val(hargahid);
          
        }
    })


    $(function(){
      var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').val();
        var pemroses = $('.pemroses').val();
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({     
          type :"GET",
          data : {idspp,pemroses},
          url : url,
          dataType:'json',
          success : function(data){
            tipespp = $('.tipespp').val();
            jenisitem = $('.jenisitem').val();
            if(data.codt.length > 0) {

              $('#hargatable').each(function(){
                for(var n=0; n < data.sppdt_barang.length; n++){
                  var kodebrg = $('.brg' + n).data("kodeitem");
             
                    for(var i = 0; i < data.codt.length; i++){
                        if(kodebrg == data.codt[i].codtk_kodeitem) {
                       
                          for (var j = 0; j < data.codt_tb.length; j++) {

                            if(data.codt[i].codtk_supplier == data.codt_tb[j].cotbk_supplier){
                              if(tipespp == 'NON STOCK' && jenisitem == 'S'){
                                  var row = $('td[data-supplier="'+ data.codt[i].codtk_supplier + '"]').index() + 7;
                                
                              }
                              else {
                                  var row = $('td[data-supplier="'+ data.codt[i].codtk_supplier + '"]').index() + 6;
                                }
                                     // alert(data.codt[i].codtk_harga);
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + 
                                                            '<div class="col-xs-6">';
                                        
                                        tampilharga += '<input type="text" class="input-sm form-control hrg harga'+i+'"  disabled="" data-id="'+i+'" name="harga[]" value="'+addCommas(data.codt[i].codtk_harga)+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.codt[i].codtk_supplier+'"> <input type="hidden" value="'+addCommas(data.codt[i].codtk_harga)+' class="hargahid'+i+'" "> </div>';
                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  
                            }
                          }
                        }
                    }
                }

              })
            } 
            var nourut = 1;         
            if(data.codt.length == 0) { 
              $('#hargatable').each(function(){
              console.log(data.sppdt_barang.length);
                      for(var n=0;n<data.sppdt_barang.length;n++){
                       var kodebrg =  $('.brg'+ n).data("kodeitem");
                          for(var i = 0 ; i <data.sppdt.length;i++){
                            if(kodebrg == data.sppdt[i].sppd_kodeitem) {
                               for(var j =0; j < data.spptb.length; j++){
                                if(data.sppdt[i].sppd_supplier == data.spptb[j].spptb_supplier) {
                                        var row = $('td[data-supplier="'+ data.sppdt[i].sppd_supplier + '"]').index() + 6; 
                                        console.log(row);
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + 
                                                            '<div class="col-xs-6">';
                                        
                                        tampilharga += '<input type="text" class="input-sm form-control hrg harga'+i+' hrga'+n+'"  disabled="" data-id="'+i+'" name="harga[]" value="'+addCommas(data.sppdt[i].sppd_harga)+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.sppdt[i].sppd_supplier+'" data-kontrak="'+data.sppdt[i].sppd_kontrak+'" data-hargaasli="'+data.sppdt[i].sppd_harga+'"> <input type="hidden" value="'+addCommas(data.sppdt[i].sppd_harga)+'" class="hargahid hargahid'+i+'" data-brg="'+n+'" data-id="'+i+'""> <input type="hidden" class="statuskontrak'+i+'" data-brg="'+n+'" data-id="'+i+'" value="'+data.sppdt[i].sppd_kontrak+'">  </div> <div class="datasup datasup'+ i+'" data-supplier="'+j+'">  </div> ';

                                        tampilharga += '<div class="col-sm-2"> <div class="checkbox checkbox-primary ">' +
                                            '<input id="cek" type="checkbox" value='+data.sppdt[i].sppd_supplier+' class="checkboxhrg checkbox'+n+'" data-val='+i+' data-id='+nourut+' required data-supplier='+data.sppdt[i].sppd_supplier+' data-harga='+data.sppdt[i].sppd_harga+' data-totalhrg='+data.spptb[j].spptb_totalbiaya+' data-n='+n+' data-kontrak='+data.sppdt[i].sppd_kontrak+'>' +
                                            '<label for="checkbox'+nourut+'">' +  
                                            '<div class="suppliercek'+nourut+'">  </div> '                                           
                                            '</label>' +
                                        '</div> </div>';

                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  


                                         $('input[class^="checkbox"]').change(function(){
                                          
                                           var $this = $(this);
                                          idsup = $(this).val();
                                          id = $(this).data('id');
                                          val = $(this).data('val');
                                          n = $(this).data('n');
                                          supplier = $(this).data('supplier');
                                          kontrak = $(this).data('kontrak');
                                                $('.checkbox'+n).each(function(){
                                                  if($this.is(":checked")) {
                                              
                                                      rowsupplier = "<input type='hidden' class='supplierco"+n+"'  value="+idsup+" name='datasup[]'>"+n+"";
                                                      $('.suppliercek'+id).html(rowsupplier);

                                                      $('.harga' + val).attr('disabled', false);

                                                      $('.hrg').each(function(){
                                                        dataid = $(this).data('id');
                                                        datan = $(this).data('brg');
                                                        if(datan == n){
                                                          if(dataid != val){
                                                            $(this).val('0');
                                                          }
                                                        }
                                                      })

                                                      $(".checkbox"+n).not($this).prop({ disabled: true, checked: false }); 
                                                      $('.simpan').attr('disabled', true);          

                                                      $('.sup').each(function(){
                                                        supplier = $(this).data('supplier');
                                                        if(supplier == idsup){
                                                          $(this).attr('disabled' , false);
                                                            $(this).trigger("chosen:updated");
                                                              $(this).trigger("liszt:updated");

                                                          if(kontrak == 'YA'){
                                                            $('td[data-supplier="'+supplier+ '"]').addClass('disabled');
                                                              $('td[data-supplier="'+supplier+ '"]').trigger("chosen:updated");
                                                              $('td[data-supplier="'+supplier+ '"]').trigger("liszt:updated");
                                                          }
                                                          else {
                                                             $('td[data-supplier="'+supplier+ '"]').removeClass('disabled');
                                                              $('td[data-supplier="'+supplier+ '"]').trigger("chosen:updated");
                                                              $('td[data-supplier="'+supplier+ '"]').trigger("liszt:updated");

                                                             
                                                          }
                                                        }
                                                      })
                                                    
                                                  } else {
                                                        
                                                    hargaasli = $(this).data('harga');
                                                     $('.hrg').each(function(){
                                                        dataid = $(this).data('id');
                                                        datan = $(this).data('brg');
                                                        nilai = $('.hargahid' + dataid).val();

                                                        if(datan == n){
                                                          if(dataid != val){
                                                            $(this).val(addCommas(nilai));
                                                          }
                                                        }
                                                      });

                                                   

                                                      $('.suppliercek'+id).empty();

                                                      $('.harga' + val).prop("disabled" , true);

                                                      $(".checkbox"+n).prop("disabled", false);
                                                      $('.simpan').attr('disabled', true);  

                                                      $('.sup').each(function(){
                                                        supplier = $(this).data('supplier');
                                                        if(supplier == idsup){
                                                          $(this).attr('disabled', true);
                                                           $(this).trigger("chosen:updated");
                                                              $(this).trigger("liszt:updated");
                                                        }
                                                      })
                                                  }
                                                })
                                        })

                                        $('.hrg').each(function(){
                                        $(this).change(function(){
                                          kontrak = $(this).data('kontrak');
                                          harga = $(this).data('hargaasli');
                                          if(kontrak == 'YA'){
                                            toastr.info("Barang termasuk kontrak, tidak bisa dirubah :)");
                                            $(this).val(addCommas(harga));
                                            return false;
                                          }
                                          else{
                                            val = $(this).val();    
                                            val = accounting.formatMoney(val, "", 2, ",",'.');
                                            $(this).val(val);
                                          }
                                        })
                                      })


                                }

                                }
                              }  
                              nourut++;
                            }
                      }
                 })
              
              }
             },
			 error : function(){
				location.reload();
			 }

        })
 
      })
  

  $('.qtyrequest').each(function(){
    id = $(this).data('id');
    val = $(this).val();
    $('.qtyapproval'+id).val(val);
    console.log('val' + id);
  })


  
   $('.qty').each(function(){
      $(this).change(function(){
        val = $(this).val();
        id = $(this).data('id');
        qtyrequest = $('.qtyrequest' + id).val();
        $('.simpan').prop("disabled" , true);
      })
   })
   
    
    var total = 0;
     function btnsetuju(index) {

          var thisis = $(this);
          var indexcol = thisis.index();
    //      console.log(indexcol);
          var val = index;
      //    $('.datasup' + val).remove();
          var kosong = '';
          var datasupplier = $('.btn-setuju' + index).data('supplier');
          var thiss = $('.btn-setuju' + val).data('n');
          console.log(thiss);
          var ttd = '<label class="control-label"> Disetujui </label>';
          var batal = '<span class="label label-danger" style="cursor:pointer" onclick="btlsetuju('+index+')" data-btlsupplier="'+datasupplier+'" data-n="'+thiss+'"> BATAL SETUJU </span>';
          

          var data_supplier = "<input type='hidden' value="+datasupplier+" name='datasup[]'>"; 
          $('.datasup' + val).html(data_supplier);

//          $('.btn-setuju'+val).not($(this)).hide();

         // .prop('disabled', true);
         /* $('#cek0').prop('disabled', true);*/

          $('.harga' + val).attr('disabled', false);
          $('.disetujui' + val).html(ttd);
          $('.btlsetuju' + val).html(batal);
        //  $('.btn-setuju' + val).empty();

        //disabled centang setuju
//        var supliersetuju = $('td[data-tbsupplier="'+ datasupplier+'"]');

  //      ('td#supplier').not(suppliersetuju).find($('#cek0')).hide();

          //disabled-supplier
         var tdsuplier = $('td[data-supplier="'+ datasupplier + '"]');


          (tdsuplier).find("select").attr('disabled', false);

           $('.harga' + index).change(function(){
                var id = $(this).data('id');
                val = $(this).val();
            
                val = accounting.formatMoney(val, "", 2, ",",'.');

               var tdtotalsuplier = $('td[data-suppliertotal="'+ datasupplier + '"]');
               // $('.harga' + index).val(addCommas(numhar));
                $('.harga' + index).val(val);

               // (tdtotalsuplier).find("input").val(addCommas(numhar));
               /* total = parseInt(harga) + total;
                totalnum = Math.round(total).toFixed(2);
                $('.total').html(addCommas(total));*/

          })
      }

      function btlsetuju(index){
        var val = index;       
        var icon = '<a class="btn-setuju'+index+'" data-id="'+index+'" data-count="'+index+'"  onclick="btnsetuju('+index+')"> <i class="fa fa-check" aria-hidden="true"></i>' +
              '</a> </div>';

      

         var harga = $('.btlsetuju' + index).data('harga');
         var datasupplier = $('.btlsetuju' + index).data('supplier');
         var thiss = $('.btlsetuju' + index).data('n');

            $('.harga' + val).attr('disabled', true);

           $('.harga' + val).val(harga);
            
            $('.btlsetuju'+ val).empty();
            $('.disetujui' + val).empty();   
            $('.btn-setuju' + val).html(icon);
            kosong = '';
                $('.datasup' + val).empty();

          var tdsuplier = $('td[data-supplier="'+ datasupplier + '"]');
          (tdsuplier).find("select").attr('disabled', true);   
      }



    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   

    //harga
      var counthrg = $('.hrg').length;
      var countqty = $('.qty').length;
  //    alert(counthrg);

       //supplier
      var countsup = $('.sup').length;
   //     console.log(countsup);



      for(var n=0; n <  counthrg; n++) {
         $('.harga' + n).change(function(){
                var id = $(this).data('id');
                var kontrak = $(this).data('kontrak');
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
               
                if(kontrak == 'YA'){
                  toastr.info("Tidak bisa mengedit harga, karena termasuk harga kontrak :)");
                  return false;
                }
                else if(kontrak == 'TIDAK') {
                  $('.harga' + id).val(addCommas(numhar));
                  $('.simpan').prop("disabled" , true);

                }
            })
      }

       
    

      $('.edit').click(function(){
    
         $('.qty').attr('readonly', false);
       
    //     $('.sup').attr('disabled', false);
         $('.item').attr('disabled', false);
         $('.sup').attr('disabled', false);
      

         var hapusSup =" <div class='col-sm-2'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a </div>";
         $('.hapusup').html(hapusSup); 
        
        var hapusbrg = "<label class='col-sm-2 col-sm-2 control-label'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a> </label>";

         $('.hapusbarang').html(hapusbrg);

       //hapusupplier
     })

   
    
    function setujumngstaffpemb() {
      document.getElementById("setujui").disabled = true;
       $(this).find($(".fa")).removeClass('fa-check')
    

       var input = "<input type='text' hidden value='DISETUJUI'  name='mngstaffpemb'>";
      $('.inputmngstaffpemsetuju').html(input);
       var setuju = 'DISETUJUI';
      $('.setujui').html(setuju);
    }

   /* $('.mngstffpemb').click(function(){
     /* $(this).next('i').slideToggle('500');

      $(this).find($(".fa")).toggleClass('fa-check fa-times');*/
     /* $(this).find($(".fa")).removeClass('fa-check');
      
      var setuju = 'DISETUJUI';
      $('.setujui').html(setuju);
      $('.setujui').disabled = true;

    })*/

     function setujumngpemb() {
      document.getElementById("setujuipemb").disabled = true;
       $(this).find($(".fa")).removeClass('fa-check')

       var input = "<input type='text' hidden value='DISETUJUI' name='mngpembsetuju'>";
       var setuju = 'DISETUJUI';
      $('.setujuipemb').html(setuju);
    //  $('.inputmngpemsetuju').html(input);
    }



</script>
@endsection
