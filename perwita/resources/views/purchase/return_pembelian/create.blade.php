@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Return Pembelian </h2>
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
                            <strong> Create Return Pembelian  </strong>
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
                    <h5> Tambah Data
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
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
                      <div class="col-xs-6">
                           <table border="0" class="table">
                          <tr>
                            <td width="150px">
                          No Return
                            </td>
                            <td>
                               <input type="text" class="form-control">
                            </td>
                          </tr>

                          <tr>
                            <td>   Tanggal </td>
                            <td>
                              <input type="text" class="form-control">
                            </td>
                          </tr>
                       

                          <tr>
                            <td> No Faktur </td>
                            <td>   <input type="text" class="form-control"> </td>
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Tanggal Faktur
                            </td>
                            <td>
                                <input type="text" class="form-control"> 
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Supplier
                            </td>
                            <td>
                              <input type="text" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td> Keterangan </td>
                            <td> <input type="text" class="form-control"></td>
                          </tr>

                          <tr>
                            <td> </td>
                          </tr>
                          </table>
                      </div>

                      <div class="col-sm-6">
                          <table class="table table-stripped">
                              <tr>
                                  <td> Sub Total </td>
                                  <td> <input type="text" class="form-control" name="subtotal"> </td>
                              </tr>

                              <tr>
                                  <td> Jenis PPn </td>
                                  <td> <select class="form-control" name="jenisppn">
                                          <option value="T">
                                              Tanpa
                                          </option>
                                          <option value="E">
                                              Exclude
                                          </option>
                                          <option value="I">
                                              Include
                                          </option>
                                      </select>
                                  </td>
                              </tr>
                              <tr>
                                  <td> PPn </td>
                                  <td> <input type="text" class="form-control" name="ppn"></td>
                              </tr>
                              <tr>
                                  <td> Total </td>
                                  <td> <input type="text" class="form-control" name="total"> </td>
                              </tr>
                          </table>
                      </div>
                    
                      </div>

                      <hr>

                       <div class="col-sm-12">
                             <button class="btn btn-sm btn-primary  createmodalfaktur" id="createmodal" data-toggle="modal" data-target="#myModal5" type="button"> <i class="fa fa-plus"> Tambah Data PO </i> </button>
                             <br>
                             <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4> Data PO </h4>
                                    <table class="table table-stripped" id="tbl-faktur">
                                        <tr>
                                            <td style="width:140px">  No PO  </td>
                                            <td> <input type="text" class="form-control input-sm nopoheader clear" readonly="" > <input type="hidden" class="form-control input-sm idpoheader clear" readonly=""> </td>
                                        </tr>

                                       

                                        <tr>
                                            <td>  DPP  </td>
                                            <td>  <input type="text" class="form-control input-sm dppheader clear" readonly="" style="text-align: right"></td>
                                        </tr>

                                        <tr>
                                            <td> Jenis PPN </td>
                                            <td>
                                                  <div class="col-xs-4">
                                                  <select class="form-control input-sm jenisppnheader clear" readonly="">
                                                      <option value="T">
                                                          Tanpa
                                                      </option>
                                                      <option value="I">
                                                          Input
                                                      </option>
                                                      <option value="E">
                                                          Exclude
                                                      </option>
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                  <input type="text" class="form-control input-sm inputppnheader clear" readonly=""> 
                                              </div>

                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilppnheader clear" readonly="" style="text-align: right"> 
                                              </div>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Jenis PPH
                                            </td>
                                            <td>
                                              <div class="col-xs-4">
                                                  <select class="form-control input-sm jenisppheaderclear disabled" readonly="">
                                                     @foreach($data['pph'] as $pajak)
                                                       <option value="{{$pajak->kode}}">
                                                          {{$pajak->nama}}
                                                      </option>
                                                     
                                                     @endforeach
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                 <input type="text" class="form-control input-sm nilaipphheader clear" readonly=""> 
                                              </div>      
                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilpphheader clear" readonly="" style="text-align: right"> 
                                              </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> Netto Hutang </td>
                                            <td> <input type="text" class="form-control input-sm nettoheader clear" readonly="" style="text-align: right"> </td>
                                        </tr>
                                         <tr>
                                            <td> Sisa Terbayar </td>
                                            <td> <input type="text" class="form-control input-sm sisaterbayarheader clear" readonly="" style="text-align: right"> </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-sm-6">
                                    <h4> Data CN / DN </h4>
                                    <table class="table">
                                       <tr>
                                          <td style="width:140px"> Nilai Bruto CN / DN </td>
                                          <td> <input type="text" class="form-control input-sm brutocn clear" style="text-align: right" ></td>
                                       </tr>

                                       <tr>
                                          <td> DPP </td>
                                          <td> <input type="text" class="form-control input-sm dppcn clear" style="text-align: right" readonly="">  </td>
                                       </tr>
                                         <tr>
                                            <td> Jenis PPN </td>
                                            <td>
                                                  <div class="col-xs-4">
                                                  <select class="form-control input-sm jenisppncn clear" readonly="">
                                                      <option value="T">
                                                          Tanpa
                                                      </option>
                                                      <option value="I">
                                                          Input
                                                      </option>
                                                      <option value="E">
                                                          Exclude
                                                      </option>
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                  <input type="text" class="form-control input-sm inputppncn clear" readonly=""> 
                                              </div>

                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilppncn clear" readonly="" style="text-align: right"> 
                                              </div>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Jenis PPH
                                            </td>
                                            <td>
                                              <div class="col-xs-4">
                                                  <select class="form-control input-sm jenispphcn clear" readonly="">
                                                     @foreach($data['pph'] as $pajak)
                                                       <option value="{{$pajak->kode}}">
                                                          {{$pajak->nama}}
                                                      </option>
                                                     
                                                     @endforeach
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                 <input type="text" class="form-control input-sm inputpphcn clear" readonly=""> 
                                              </div>      
                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilpphcn clear" readonly="" style="text-align: right"> 
                                              </div>
                                            </td>
                                        </tr>

                                       <tr>
                                          <td> Netto </td>
                                          <td> <input type="text" class="form-control input-sm  nettohutangcn clear" style="text-align: right" readonly=""></td>
                                       </tr>
                                    </table>
                                </div>

                               
                            </div>
                             <div class="pull-right">
                                  <button  class="btn btn-sm btn-default" type="button" id="append">
                                    <i class="fa fa-plus"> Append</i>
                                  </button>

                                    &nbsp; 
                                  <button style="margin-right: 10px" class="btn btn-sm btn-default" id="cancel" type="button">
                                    <i class="fa fa-close"> Cancel</i>
                                  </button>
                                </div>
                        </div>
                      </div>
                    
                      <br>
                      <br>

                    </div>
                    </form>

             
                   
  

                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('purchase/returnpembelian')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
         
                    
                    
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
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td>' + 
      /* Barang */    '<td>  </td>' + 
      /* Update Stock */       '<td> <select class="form-control"> <option value=""> Ya </option> <option value="tidak"> </option> </select> </td>' +
      /* Qty  */              '<td> <input type="text" class="form-control"> </td>' +
      /* Gudang */    '<td> <input type="text" class="form-control"> </td>'  +
      /* Harga */     '<td> <input type="text" class="form-control"> </td>' +
      /* Jumlah */    '<td> <input type="text" class="form-control" readonly=""> </td>' +
      /* Acc Persediaan */   '<td> <input type="text" class="form-control"></td>' +           
                            '<td><a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td>' +
                
      '</tr>');+ 




        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })

    
  
   

</script>
@endsection
