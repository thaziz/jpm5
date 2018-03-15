@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Faktur Pembelian </h2>
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
                            <strong> Detail Faktur Pembelian </strong>
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
                    <h5> Detail Faktur Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    
                      <div class="text-right">
                        <a class="btn btn-danger" href="{{url('fakturpembelian/fakturpembelian')}}" aria-hidden="true"> <i class="fa fa-arrow-left" aria-hidden="true"> Kembali </i> </a>
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
                      <div class="col-xs-12">
                         <table border="0" class="table">
                         
                         @foreach($data['faktur'] as $faktur)
                          <tr>
                            <td width="150px">
                          No Faktur
                            </td>
                            <td>
                              <input type='text' readonly="" class="form-control" value="{{$faktur->fp_nofaktur}}">
                            </td>

                            <td>
                              &nbsp;
                            </td>

                            <td>
                              No Invoice
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$faktur->fp_noinvoice}}">
                            </td>

                          </tr>

                          <tr>
                            <td>   Tanggal </td>
                            <td>
                              
                              <div class="input-group date">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="tgl" required="" value="{{ Carbon\Carbon::parse($faktur->fp_tgl)->format('d-M-Y') }}" readonly="">
                                </div>
                            </td>

                            <td>
                              &nbsp;
                            </td>

                            <td>
                              Jatuh Tempo
                            </td>
                           
                            <td>
                                 <input type="text" class="form-control" readonly="" value="{{ Carbon\Carbon::parse($faktur->fp_jatuhtempo)->format('d-M-Y') }}">
                            </td>


                          </tr>
                          
                          <tr>
                            <td> Supplier </td>
                            <td> <input type="text" class="form-control" readonly="" value="{{$faktur->nama_supplier}}"> </td>
                            </td>

                            <td>
                              &nbsp;
                            </td>

                             <td>
                              Tipe
                            </td>
                            <td> <input type="text" readonly=""  class="form-control" value="{{$faktur->fp_tipe}}"> </td>
                          </tr>

                          <tr>
                            <td>
                              Keterangan
                            </td>
                            <td>
                             <input type="text" class="form-control" readonly="" value="{{$faktur->fp_keterangan}}">
                            </td>

                          </tr>
                          @endforeach
                          </table>
                      </div>
                      </div>

                      
                      <table class="table" border="0">
                      <tr>
                        <td style="width:200px"> <h4> Detail Faktur </h4> </td>
                        <td> 
                           <button class="btn btn-primary" style="margin-right: 10px;" type="text" id="createmodal" data-toggle="modal" data-target="#myModal5"><i class="fa fa-book">&nbsp;Buat Tanda Terima</i></button> 
                       &nbsp;
                       
                           <a class="btn btn-info " href="{{url('fakturpembelian/cetaktt/'.$data['tt'][0]->tt_idform.'')}}" "><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>
                          
                        </td>
                      </tr>
                      </table>
                    
                    <hr>
                   <h4> Daftar Detail Fatkur </h4>

                   <br>

                   <div class="box-body">
                

                    <div class="table-responsive">
                         @if($data['faktur'][0]->fp_tipe != 'PO')
                      <table class="table  table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                          <th> No </th>
                          <th width="150px"> Nama Item </th>
                          <th> Qty </th>
                          <th width="150px">Gudang </th>
                          <th width="100px"> Harga / unit </th>
                          <th> Amount </th>
                          <th> Update Stock ? </th>
                          <th> Diskon </th>
                          <th>  Biaya </th>
                       
                          <th> Account Biaya </th>
                          <th> Keterangan</th>
                        </thead>

                      </tr>
                      <tbody>
                          @foreach($data['fakturdt'] as $index=>$fakturdt)
                          <tr>
                            <td> {{$index + 1}} </td>
                            <td> {{$fakturdt->nama_masteritem}} </td>
                            <td> {{$fakturdt->fpdt_qty}}</td>
                            <td> {{$fakturdt->fpdt_gudang}}</td>
                            <td> {{ number_format($fakturdt->fpdt_harga, 2) }} </td>
                            <td> {{ number_format($fakturdt->fpdt_totalharga, 2) }}</td>
                            <td> {{$fakturdt->fpdt_updatedstock}}</td>
                            <td> {{$fakturdt->fpdt_diskon}} </td>
                            <td> {{ number_format($fakturdt->fpdt_biaya, 2) }}</td>
                          
                            <td> {{$fakturdt->fpdt_accbiaya}} </td>
                            <td> {{$fakturdt->fpdt_keterangan}} </td>
                          </tr>
                          @endforeach
                      </tbody>
                      </table>
                      @else
                      <table class="table table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                          <th> No </th>
                          <th> No Bukti</th>
                          <th width="150px"> Nama Item </th>
                          <th> Qty </th>                       
                          <th width="100px"> Harga / unit </th>
                          <th> Total Harga </th>
                          <th> Update Stock ? </th>
                          <th> Account Persediaan </th>
                         
                        </thead>

                      </tr>
                      <tbody>
                          @foreach($data['fakturdtpo'] as $index=>$fakturdt)
                          <tr>
                            <td> {{$index + 1}} </td>
                                @if($data['status'] == 'PO')
                                    <td> {{$fakturdt->po_no}}</td>
                                @else 
                                    <td> {{$fakturdt->fp_nofaktur}}</td>
                                @endif
                            <td> {{$fakturdt->nama_masteritem}} </td>
                            <td> {{$fakturdt->fpdt_qty}}</td>
                            <td> {{ number_format($fakturdt->fpdt_harga, 2) }} </td>
                            <td> {{ number_format($fakturdt->fpdt_totalharga, 2) }}</td>
                            <td> {{$fakturdt->fpdt_updatedstock}}</td>
                            <td> {{$fakturdt->fpdt_accbiaya}} </td>
                         
                          </tr>
                          @endforeach
                      </tbody>
                      </table>

                      @endif
                      </div>
                   </div>
                   
                <!-- modal -->
                 <div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                          <h4 class="modal-title" style="text-align: center;"> FORM TANDA TERIMA </h4>     
                        </div>
                                      
                        <div class="modal-body">              
                        <table class="table table-stripped">
                          <tr>
                            <td width="150px">
                              No Tanda Terima
                            </td>
                            <td>
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="text" class="form-control" value="{{$data['tt'][0]->tt_noform}}" required="">
                              <input type="hidden" class="idform" value="{{$data['tt'][0]->tt_idform}}" name="idform" class="idform">
                            </td>
                          </tr>
                          <tr>
                            <td> Tanggal </td>
                            <td>
                               <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{ Carbon\Carbon::parse($faktur->fp_tgl)->format('d-M-Y') }}" readonly="">
                              </div>
                            </td>
                          </tr>
                         
                          <tr>
                            <td> Supplier </td>
                            <td> <input type='text' class="form-control" value="{{$data['tt']['0']->nama_supplier}}" readonly=""></td>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                               <div class="row">
                                  <div class="col-sm-3"> 
                                    <div class="checkbox checkbox-info checkbox-circle">
                                        <input id="Kwitansi" type="checkbox" checked="">
                                          <label for="Kwitansi">
                                              Kwitansi / Invoice / No
                                          </label>
                                    </div> 
                                  </div>
                                  <div class="col-sm-3"> 
                                    <div class="checkbox checkbox-info checkbox-circle">
                                        <input id="FakturPajak" type="checkbox" checked="">
                                          <label for="FakturPajak">
                                              Faktur Pajak
                                          </label>
                                    </div> 
                                  </div>

                                  <div class="col-sm-3"> 
                                    <div class="checkbox checkbox-info checkbox-circle">
                                        <input id="SuratPerananAsli" type="checkbox" checked="">
                                          <label for="SuratPerananAsli">
                                              Surat Peranan Asli
                                          </label>
                                    </div> 
                                  </div>

                                   <div class="col-sm-3"> 
                                    <div class="checkbox checkbox-info checkbox-circle">
                                        <input id="SuratJalanAsli" type="checkbox" checked="">
                                          <label for="SuratJalanAsli">
                                             Surat Jalan Asli
                                          </label>
                                    </div> 
                                  </div>
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                             Lain Lain
                            </td>
                            <td>
                              @if($data['tt'][0]->tt_lainlain != '')
                              <input type="text" class="form-control lainlain" name="lainlain" value="{{$data['tt'][0]->tt_lainlain}}">
                              @else
                              <input type="text" class="form-control lainlain" name="lainlain">
                              @endif
                            </td>
                          </tr>

                          <tr>
                            <td> Tanggal Kembali </td>
                            <td>   <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{ Carbon\Carbon::parse($faktur->fp_jatuhtempo)->format('d-M-Y') }}" readonly="">
                              </div> </td>
                          </tr>

                          <tr>
                            <td>
                             Total di Terima
                            </td>
                            <td> <div class="row"> <div class="col-sm-3"> <label class="col-sm-3 label-control"> Rp </label> </div> <div class="col-sm-6"> <input type="text" class="form-control" value="{{ number_format($data['tt'][0]->tt_totalterima, 2) }} " style="text-align:right;" readonly=""></div> </div> </td>
                          </tr>
                         
                           </table>                           
                                   
                             </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary" id="buttongetid">Simpan</button>
                             
                          </div>
                           </form>
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
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">


    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
    });
    
 $('#buttongetid').click(function(){
   
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       var idform = $('.idform').val();
       var lainlain = $('.lainlain').val();

      $.ajax({
      url:baseUrl + '/fakturpembelian/update_tt',
      type:'post',
      data:{idform,lainlain},
      success:function(response){
        console.log(response);
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: false
                },function(){
                  location.reload();
        });
      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 900,
               showConfirmButton: true

		});
	},
	});
});


</script>
@endsection
