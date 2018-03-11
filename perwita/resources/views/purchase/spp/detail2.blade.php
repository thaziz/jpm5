@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Surat Permintaan Pembelian </h2>
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
                            <strong> Detail Surat Permintaan Pembelian  </strong>
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
                    <h5> Detail Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                       <div class="text-right">
                          <div class="text-right">
                          <a class="btn btn-info edit"> Edit Data ? </a>
                      </div>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->

                @foreach($data['spp'] as $spp)
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                          <div class="row">
                          <div class="col-xs-6">

                          <table border="0">
                          <tr>
                            <td width="150px">
                              No SPP
                            </td>
                            <td>
                               <input type="text" class="form-control nospp" readonly="" value="{{$spp->spp_nospp}}" name="nospp">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>    Tgl di Butuhkan </td>
                            <td>
                               <div class="input-group date">
                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_dibutuhkan" name="tgl_dibutuhkan" required="" value="{{Carbon\Carbon::parse($spp->spp_tgldibutuhkan)->format('d-M-Y ')}}" disabled="">
                                </div>

                            </td>
                          </tr>
                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>
                          <tr>
                            <td> Cabang </td>


                            <td>  <select class="form-control cabang" name="cabang" disabled=""> @foreach($data['cabang'] as $cbg) <option value="{{$spp->kode_kantorcabang}}" @if($spp->kode_kantorcabang == $cbg->kode_kantorcabang) selected="" @endif>  {{$cbg->nama_cabang}} </option> @endforeach </select></td>
                            </td>
                          </tr>

                          <tr>
                      <!--     <td>  <select class="form-control"> <option value=""> A </option> <option value="" disabled=""> B </option> <option value=""> C </option> </select>
                          </td> -->

                          </tr>

                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0">
                          <tr>`
                            <td width="200px">
                              Bagian
                            </td>
                            <td>
                            
                              <select class="form-control bagian" name="cabang" disabled=""> @foreach($data['department'] as $department) <option value="{{$department->kode_department}}" @if($department->kode_department == $spp->kode_department) selected="" @endif> {{$department->nama_department}} </option> @endforeach </select>

                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>


                           <tr>
                            <td> Keperluan </td>
                             <td>
                               <input type="text" class="form-control keperluan" readonly="" value="{{$spp->spp_keperluan}}" name="keperluan">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                        
                          <tr>
                          <td> &nbsp; </td>
                          </tr>


                          @endforeach
                          </table>
                         </div>

                         <div class="col-sm-6">
                           <table class="table">
                              <tr>
                                <th> Supplier </th>
                                <th> Pembayaran </th>
                              </tr>

                              @foreach($data['supplier_bayar'] as $sp)
                              <tr>
                                <td> {{$sp->nama_supplier}} </td>
                              </tr>
                              @endforeach
                           </table>
                        </div>

                         </div>

                    </div>
                    

                    <br>

                    <hr>
                    
                    <h4> Data Barang </h4>

                    <hr>
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th style="width:20px" rowspan="2"> No  </th>
                        <th style="width:200px; text-align: center" rowspan="2"> Nama Barang</th>
                        <th style="width:10px" rowspan="2"> Jumlah </th>
                        <th style="width:50px" rowspan="2"> Stock Gudang </th>
                        <th style="width:100px" rowspan="2"> Satuan </th>
                    
                      
                        <th style="text-align: center" colspan="{{$data['count']}}"> Supplier </th>
                    </tr>

                   <!--  supplier -->
                    <tr>
                      @foreach($data['spptb'] as $spptb)
                      <td style="text-align: center"> 
                      <!--   <div class="form-group">
                          <div class="col-sm-8"> -->
                            <select class="form-control" name="supplier[]" disabled="">
                              @foreach($data['supplier'] as $index=>$sup)
                              <option value="{{$sup->no_supplier}}" @if($spptb->spptb_supplier == $sup->no_supplier) selected="" @endif>  {{$sup->nama_supplier}}
                              </option>
                
                              @endforeach
                            </select>
                       <!--    </div> -->
                    <!--   <label  class="col-sm-6 control-label hapus sup"> </label> -->

                          

                           <div class="col-sm-3 hapusup" onclick="hapusData('{{$spptb->spptb_id}}')">
                                 {{ Form::open(['url'=>'suratpermintaanpembelian/deletesup/'. $spptb->spptb_id, 'method' => 'delete', 'id' => $spptb->spptb_id ]) }}
                                 {{ Form::close() }}
                           </div>
                               

                        </div>
                      </td> 
                      @endforeach
                    </tr>

                 
                    </thead>
                    <tbody>
                        @foreach($data['sppdt_barang'] as $index=>$sppd)
                     
                      <tr id="barang{{$index}}">
                        <td>  {{$index + 1}} </td>
                        <td> 

                              <select class="form-control masteritem" disabled="" name="item[]"> 
                                @foreach($data['barang'] as $brg)
                                 
                                    <option value="{{$brg->kode_item}}"  @if($sppd->sppd_kodeitem == $brg->kode_item) selected=""      @endif > {{$brg->nama_masteritem}} </option>
                              
                                @endforeach
                              </select>
                           <!--  </div>
                          </div> -->
                        </td>
                        <td>  <input type="text" class="form-control qty" value="{{$sppd->sppd_qtyrequest}}" readonly="">  </td>
                        <td> 
                        @if ($sppd->sg_qty == '')
                           Kosong
                        @else
                        {{$sppd->sg_qty}}
                         @endif
                         </td>

                        <td> <input type="text" class="form-control satuan" value="{{$sppd->unitstock}} " disabled=""></td>
                        <!--supplier-->
                          @foreach($data['sppdt'] as $index=>$sppdt)
                              @if($sppdt->sppd_kodeitem == $sppd->sppd_kodeitem)
                             <td>  <div class='form-group'><label class='col-sm-1 col-sm-1 control-label'> @ </label> <label class='col-sm-1 col-sm-1 control-label'> Rp </label> <div class='col-sm-8'> <input type="text" class="form-control harga{{$index}} hrg" value="{{number_format($sppdt->sppd_harga, 2)}}" readonly="" data-id="{{$index}}"> <input type="hidden" class="qty{{$index}}" value="{{$sppdt->sppd_qtyrequest}},{{$sppdt->sppd_supplier}}"> </div>  </div>  </td>
                              @endif
                        @endforeach
                      


                      </tr>                     
                      @endforeach

                      <tr>
                        <td colspan="5" style="text-align: center"> Pembayaran  </td>
                          @foreach($data['supplier_bayar'] as $index=>$sp)
                                <td>  <div class='form-group'> <div class="col-sm-8"> <input type="text" class="form-control bayar{{$index}}" value=" {{$sp->sppd_bayar}}" readonly="" data-id="{{$index}}"> </div> <label class='col-sm-2 col-sm-2 control-label'> Hari </label>   </div> <input type="hidden" class="supplier{{$index}}" value="{{$sp->sppd_supplier}}">
                                 </td>

                              @endforeach
                      </tr>

                        <tr> <td colspan="5" style="text-align: center"> Total Biaya </td> 
                        @foreach($data['spptb'] as $spptb)
                          <td> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='form-control totalbiaya' name='bayar[]' value="{{number_format($spptb->spptb_totalbiaya, 2)}}" readonly=""> </div>  </div></td>
                          @endforeach
                        </tr>


                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                      <table border="0">
                        <tr>  
                          <td> <div class="simpan"> </div> </td>
                             </form>
                          <td> <div class="cek_tb">  </div> </td>
                        </tr>
                      </table>
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
    
 
  
     $('.edit').click(function(){
      // $('.nospp').attr('readonly', false);
       $('.tgl_dibutuhkan').attr('disabled', false);
       $('.cabang').attr('readonly', false);
       $('.bagian').attr('readonly', false);
       $('.keperluan').attr('readonly', false);
       $('.masteritem').attr('disabled', false);
       $('.qty').attr('readonly', false);
       $('.harga').attr('readonly', false);
       $('.supplier').attr('disabled', false);
       $('.cabang').attr('disabled', false);
    

       /*var hapusSup =" <div class='col-sm-2'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a </div>";
       $('.hapusup').html(hapusSup); 
      
      var hapusbrg = "<label class='col-sm-2 col-sm-2 control-label'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a> </label>";

       $('.hapusbarang').html(hapusbrg);*/

       //hapusupplier

       var simpan = "<button type='submit' class='btn btn-success btn-flat simpan' disabled=''>Simpan Data</button>";
       var cektotalbiaya = "<a  class='btn btn-danger btn-flat cek_tb'> Cek Total Biaya </a>";
       $('.simpan').html(simpan); 
       $('.cek_tb').html(cektotalbiaya); 

     })



      hasilqty = [];
     $('.cek_tb').click(function(){
        var row =  $('#addColumn tr').length;
        var hasilRow = row - 4;
   

            var counthrg = $('.hrg').length;
      
            var td = $('#barang0 td').find('.harga0').val();
            console.log(td);
            
            var td2 = $('#barang0 td').length;
            var countsup = td2 - 5;

        var arrtothrg = [];
        var arrhrgsup = [];
        var supplier = [];



        for (var j = 0; j < counthrg; j++) {  
              var harga =$('.harga'+j).val();
              var qty2 =$('.qty'+j).val();
              console.log(qty2);
              var pecahstring  = qty2.split(",",);
              qty = pecahstring[0];
              idsup = pecahstring[1];
              var  hasil_harga = harga.replace(/,/g, '');
              var perkalian = parseInt(qty * hasil_harga);   
          
              arrtothrg.push(perkalian);
        }      

        var jmlhtb = [];
        var jumlahtotal = 0
        for (var n = 0 ; n < countsup; n++) {
            var suplier = $('.supplier'+n).val();
             console.log(supplier)

              for(var j = 0 ; j < counthrg; j++) {
                var harga =$('.harga'+j).val();
                var qty2 =$('.qty'+j).val();
                var pecahstring  = qty2.split(",",);
                qty = pecahstring[0];
                idsup = pecahstring[1];
                var  hasil_harga = harga.replace(/,/g, '');
                console.log(idsup);

                
                   if (suplier[n] == idsup[j]) {
                     var perkalian = parseInt(qty * hasil_harga);
               //      console.log(hasil_harga);
                     jumlahtotal = parseInt(jumlahtotal + perkalian);
                     console.log(jumlahtotal);
                  }
              }

            supplier.push(suplier);
        }




        var barang = $('#barang0').find('.hrg').val();
    //    console.log(barang);

        $('.simpan').attr('disabled' , false);
     })


     function hapusData(id){
            swal({
            title: "apa anda yakin?",
                    text: "data yang dihapus tidak akan dapat dikembalikan",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
            },
                    function(){                        
                    $('#' +id).submit();
                    swal("Terhapus!", "Data Anda telah terhapus.", "success");
                    });
            }

</script>
@endsection

