@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pembelian Order Detail </h2>
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
                            <strong> Pembelian Order  </strong>
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
                    <h5> Pembelian Order Detail
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                   <div class="text-right">
                  <a class="btn btn-success" href="{{url('purchaseorder/purchaseorder')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                   </div>
                </div>

                <div class="ibox-content">
                        <div class="row">
               <div class="col-xs-12">
            @foreach($data['po'] as $po)
            <form method="post" action="{{url('purchaseorder/updatepurchase/'.$po->po_id.'')}}"  enctype="multipart/form-data" class="form-horizontal">   
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                
                  <div class="box-body">
                     
                          <div class="row">
                          <div class="col-xs-6">

                          <table  class="table">
                      
                          <tr>

                            <td style="width:200px"> No PO </td> <td style="width:20px"> : </td> <td> <div class="col-md-8"> <h3> {{$po->po_no}} </h3> </div> </td>
                          </tr>
                          <tr>
                            <td style="width:200px">
                              Supplier
                            </td>
                            <td style="width:20px">
                                :
                            </td>
                              <td>  <div class="col-md-8">
                               <select class="input-sm  form-control supplier" disabled="" name="supplier" readonly="">
                                    @foreach($data['supplier'] as $supplier)
                                    <option value="{{$po->po_supplier}}" @if($po->po_supplier == $supplier->idsup) selected="" @endif> {{$supplier->nama_supplier}} </option>
                                    @endforeach

                                  

                              </select>
                              </div>
                            </td>
                          </tr>
                         
                          <tr>
                            <td> Jangka waktu permbayaran </td>
                            <td> : </td>
                            <td> <div class="col-md-8"> <input type="text" class="input-sm form-control" value="{{$po->po_bayar}}" name="bayar"> </div> <label class="col-md-2"> Hari </label>  </td>
                          </tr>


                          <tr>
                            <td>
                              Catatan
                            </td>
                            <td> : </td>

                            <td>
                              <div class="col-md-8">
                              <input type="text" class="input-sm  form-control catatan" readonly="" value="{{$po->po_catatan}}" name="catatan">  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              </div>
                            </td>
                          </tr>

                          </table>
                          </div>

                          <div class="col-md-6">
                          <table class="table">
                          <tr>
                            <td style="width:200px">
                              Sub Total
                            </td>
                            <td style="width:20px"> : </td>
                            <td >
                              <label class="col-md-1"> Rp </label>
                              <div class="col-md-8">
                              <input type="text" class="input-sm  form-control subtotal" readonly="" value="{{number_format($po->po_subtotal, 2)}}" name="subtotal"> </div>

                            </td>
                          </tr>

                        

                          <tr>
                            <td> Diskon </td> <td> : </td> <td> <div class="col-md-3"> <input type="text" class=" input-sm  form-control diskon" readonly="" value="{{$po->po_diskon}}" name="diskon"> </div> <label class="col-md-2"> % </label> </td>
                          </tr>

                          <tr>
                            <td> Jenis PPn </td> <td> : </td><td>
                              @if($po->po_jenisppn == 'E')
                                <select class="form-control jenisppn" disabled="" name="jenisppn" style="width:120px">
                                <option value="I"> Include </option>
                                <option value="T"> Tanpa </option>
                                <option value="E" selected=""> Tanpa </option>
                                </select>
                              @elseif($po->po_jenisppn == 'I')
                                <select class="form-control jenisppn" disabled="" name="jenisppn" style="width:120px">
                                <option value="I" selected=""> Include </option>
                                <option value="T"> Tanpa </option>
                                <option value="E"> Tanpa </option>
                                </select>

                              @else
                               <select class="form-control jenisppn" disabled="" name="jenisppn" style="width:120px">
                                <option value="I"> Include </option>
                                <option value="T" selected=""> Tanpa </option>
                                <option value="E"> Tanpa </option>
                                </select>

                              @endif
                             
                            </td>
                          </tr>
                          
                          <tr>
                            <td> PPn </td> <td> : </td> <td> <div class="col-md-3"> <input type="text" class="input-sm  form-control ppn" readonly="" value="{{$po->po_ppn}}" name="ppn"> </div> <label class="col-md-2"> % </label> </td> 

                          </tr>



                          <tr>
                            <td>
                              Total
                            </td>
                            <td> : </td>
                            <td> <label class="col-md-1"> Rp </label> <div class="col-md-8">  <input type="text" class="input-sm  form-control total" readonly="" value="{{number_format($po->po_totalharga, 2)}}" name="totalharga" style='text-align: right'> </div>
                            </td>
                          </tr>
                          @endforeach
                          </table>

                         </div>
                            
                         </div>

                    </div>
                  
                <div class="box-body">
                  
                
                @if($data['po'][0]->po_setujufinance == 'DISETUJUI')
                 <button class="btn-sm btn btn-primary edit" type="button" onclick="cetak()"> Print Data </button>
                @else
                  <button class="btn-sm btn btn-info edit" type="button"> Edit Data </button>
                @endif

                <div class="row">
                  <div class="col-xs-12"> 
                    <h4 style="color:blue"> Data SPP </h4>
                    
                     @for($k=0;$k<$data['countbrg'];$k++)
                    <table class="table">
                     
                        <tr>
                          <th style="width:200px"> No SPP </th>
                          <th style="width:20px"> : </th>
                          <td> <h3> {{$data['spp'][$k]->spp_nospp}} </h3> </td>
                          <td>  </td>
                        </tr>
                        <tr>
                          <td> Keperluan </td>
                          <td>  :</td>
                          <td> <h4> {{$data['spp'][$k]->spp_keperluan}}</h4> </td>
                        </tr>
                        <tr>
                          <td> Tgl di Butuhkan </td>
                          <td> : </td>
                          <td>  <h4> {{ Carbon\Carbon::parse($data['spp'][$k]->spp_tgldibutuhkan)->format('d-M-Y ') }}  </h4> </td>
                        </tr>
                       <tr>
                        <td> Bagian </td>
                        <td> : </td>
                        <td>  <h4> {{$data['spp'][$k]->nama_department}}  </h4> </td>
                       </tr>
                        <td> Cabang Pemohon </td>
                          <td> : </td>
                          <td>  <h4> {{$data['spp'][$k]->nama}} </h4> </td>
                        </tr>
                        <tr>
                     
                    </table>

                    <table class="table" border="0">
                      <tr>
                        <th> No </th>
                        <th> Nama Barang </th>
                        <th style="width:100px"> Jumlah yang disetujui </th>
                        <th style="width:100px"> Jumlah dikirim </th>
                        <th style="width:250px"> Harga Per Item </th>
                        <th>  Total Harga Per Item  </th>
                        <th> Dikirim ke </th>
                      </tr>

                  

                      @for ($i = 0; $i < count($data['podtbarang'][$k]); $i++)
                      <tr>
                       <td> {{$i + 1}} </td>
                        <td> {{$data['podtbarang'][$k][$i]->nama_masteritem}} </td> <!-- nama masteritem -->

                        <td> {{$data['podtbarang'][$k][$i]->podt_approval}} <input type="hidden" class="qtyapproval{{$i}}" name="qtyapproval" value="{{$data['podtbarang'][$k][$i]->podt_approval}}"> </td> <!-- QTY disetujui -->
                        
                        <td> <input type="text" class="form-control qtykirim" readonly="" value="{{$data['podtbarang'][$k][$i]->podt_qtykirim}}" name="qtykirim[]" data-id="{{$i}}{{$k}}"> <input type="hidden" class="status{{$i}}" name="statuskirim[]" value="{{$data['podtbarang'][$k][$i]->podt_statuskirim}}"> </td> <!-- qtykirim -->
                        
                        <td> <input type="text" class="form-control harga{{$i}}{{$k}}" readonly="" value="{{number_format($data['podtbarang'][$k][$i]->podt_jumlahharga, 2)}}" name="jumlahharga[]"  style='text-align: right'> </td> <!-- harga -->
                        
                        <td> <input type="text" class="form-control totalharg totalharga{{$i}}{{$k}}" readonly="" value="{{number_format($data['podtbarang'][$k][$i]->podt_totalharga, 2)}}"  style='text-align: right' name="totalharga2[]">  </td> <!-- totalharga -->
                        
                        <td> <select class="form-control lokasigudang" disabled="" name="lokasigudang[]"> @foreach($data['gudang'] as $gudang) <option value="{{$data['podtbarang'][$k][$i]->mg_id}}" @if($gudang->mg_id == $data['podtbarang'][$k][$i]->podt_lokasigudang) selected @endif> {{$gudang->mg_namagudang}}</option> @endforeach </select> </td> <!-- lokasi gudang -->
                        
                        <tr>
                      @endfor

                    </table>
                       @endfor
                  </div>
                </div>


                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                  <table border="0">
                    <tr>
                      <td>  <div class="cektb"> </div> </td>
                      <td> &nbsp; </td>
                      <td>  <div class="simpan"> </div> </td>
                    </tr>
                    </form>  
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


      function cetak(){
        var data = $('#form').serialize();
        @foreach($data['po'] as $index=>$po)
        window.open(baseUrl + '/purchaseorder/print/{{$po->po_id}}?' + data ,"_blank");  
        @endforeach
       }

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $('.edit').click(function(){
      $('.qtykirim').attr('readonly', false);
      $('.lokasigudang').attr('disabled', false);
      $('.harga').attr('readonly', false);
      $('.diskon').attr('readonly', false);
      $('.ppn').attr('readonly', false);
      tb = "<button class='btn btn-primary cek_tb' type='button'> Cek Total Biaya </button>"
      simpan = "<button class='btn btn-success save' type='submit'> Simpan </button"
      $('.simpan').html(simpan);
     /* $('.cektb').html(tb);*/
      $('.supplier').attr('disabled', false);
      $('.catatan').attr('readonly', false);

    })
      
      var jmlhhrg = 0;
      $('.qtykirim').change(function(){
          val = $(this).val();
          id = $(this).data('id');
         // console.log(id);
          qtyapprov = $('.qtyapproval' + id).val();
         // console.log(qtyapprov);
         // console.log(val);
          if(val > qtyapprov) {
           // kosong = '';
            //$('.status' + id).val(kosong);
           // $(this).val(kosong);
          //  toastr.info('Anda tidak bisa menginputkan angka lebih besar dari jumlah yang di setujui :)');
             }
                else if(val == qtyapprov) {
                  status = 'LENGKAP';
                  $('.status' + id).val(status);
                }
                else {
                   status = 'TIDAK LENGKAP';
                  $('.status' + id).val(status);
                }

            var hargaperitem = $('.harga'+id).val();
            hargaperitem2 = hargaperitem.replace(/,/g, '');
            dikali = parseFloat(parseFloat(val * hargaperitem2)).toFixed(2);

            $('.totalharga' + id).val(addCommas(dikali));

            $('.totalharg').each(function(){
              var val2 = $(this).val();
             // alert(val2);
              val = val2.replace(/,/g, '');
              jmlhhrg = parseFloat(parseFloat(jmlhhrg) + parseFloat(val)).toFixed(2);
            
            })


             $('.subtotal').val(addCommas(jmlhhrg));
            jenisppn = $('.jenisppn').val();
            disc = $('.diskon').val();
            subharga = jmlhhrg;
            diskon = (disc * parseInt(subharga)) / 100;
            ppn = $('.ppn').val();
            console.log(diskon);
            if(diskon != ''){
                if(jenisppn == 'E'){
                hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                ppnhar = hargappn.toFixed(2);
                $('.hargappn').val(addCommas(ppnhar));

                total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon));
                numhar = total.toFixed(2);
                $('.total').val(addCommas(numhar));
               console.log(numhar + 'numhar');
               console.log(total + 'total');
               console.log(hargappn + 'hargappn');
              }
              else if(jenisppn == 'I'){
                hargappn = parseFloat(subharga * parseFloat(100) / 100 + ppn );
                hargappn2 = hargappn2.toFixed(2);
                $('.hargappn').val(addCommas(hargappn2));
                total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon)).toFixed(2);
                $('.total').val(addCommas(total));
              }
              else if(jenisppn == 'T'){
                   hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                   ppnhar = hargappn.toFixed(2);
                  $('.hargappn').val(addCommas(ppnhar));
                   total = parseFloat(subharga  - diskon).toFixed(2);
                  $('.total').val(addCommas(total));
              }
            }
            else {
               if(jenisppn == 'E'){
                         hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                         ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));
                      total = parseFloat(parseFloat(subharga) + parseFloat(ppnhar));
                      numhar = total.toFixed(2);
                      $('.total').val(addCommas(numhar));
                     
                    }
                    else if(jenisppn == 'I'){
                      hargappn = parseFloat(subharga * parseFloat(100) / 100 + ppn );
                      hargappn2 = hargappn2.toFixed(2);
                      $('.hargappn').val(addCommas(hargappn2));
                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                      $('.total').val(addCommas(total));
                    }
                    else if(jenisppn == 'T'){
                         hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                         ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));
                        $('.total').val(addCommas(subharga));
                    }
            } 
            
          


        $('.save').attr('disabled', false);
      });

      
      $('.harga').change(function(){
       $('.save').attr('disabled', false);
      })


      //cek total biaya
     $('.cektb').click(function(){
      
     $('.save').attr('disabled', false);

      qtykirim = [];
      $('.qtykirim').each(function(){
        val = $(this).val(); 
        qtykirim.push(val);
      });

      arrHarga = [];
      $('.harga').each(function(){
        val = $(this).val();
         isharga = val.replace(/,/g, '');
        arrHarga.push(isharga);
      })

      //jumlahhargaperbarang
      total = 0;
      for(var i = 0 ; i < arrHarga.length; i++){
        jumlahharga = parseInt(qtykirim[i]) * parseInt(arrHarga[i]);
        total = total + jumlahharga;
      }

      diskon = $('.diskon').val();
      ppn = $('.ppn').val();

      if(diskon == '') {
        diskon = 0;
      }
      if(ppn == '') {
        ppn = 0;
      }


      totalharga = (total - diskon) + hargappn;
      numhar = Math.round(totalharga).toFixed(2);
      numtotal = Math.round(total).toFixed(2);

      $('.subtotal').val(addCommas(total));
      $('.total').val(addCommas(numtotal));
    })

      $('.diskon').change(function(){
          $('.save').attr('disabled', false);
                  $this = $(this).val();
                  subtotal =  $('.subtotal').val();
                  subharga = subtotal.replace(/,/g, '');
                  diskon = ($this * parseInt(subharga)) / 100;


                  ppn = $('.ppn').val();
                 // ppn = angkappn.replace(/,/g, '');
                  jenisppn = $('.jenisppn').val();
               /*   hargappn = (ppn * parseInt(subharga)) / 100;
*/
                  if(ppn == ''){
                    total = subharga - diskon;
                    numhar = Math.round(total).toFixed(2);
                    $('.total').val(addCommas(numhar));
                  }
                  else {
                     if(diskon != ''){
                        if(jenisppn == 'E'){
                        hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                        ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));

                        total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon));
                        numhar = total.toFixed(2);
                        $('.total').val(addCommas(numhar));
                        console.log(numhar);
                      }
                      else if(jenisppn == 'I'){
                        hargappn = parseFloat(subharga * parseFloat(100) / 100 + ppn );
                        hargappn2 = hargappn2.toFixed(2);
                        $('.hargappn').val(addCommas(hargappn2));
                        total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon)).toFixed(2);
                        $('.total').val(addCommas(total));
                      }
                      else if(jenisppn == 'T'){
                           hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                           ppnhar = hargappn.toFixed(2);
                          $('.hargappn').val(addCommas(ppnhar));
                           total = parseFloat(subharga  - diskon).toFixed(2);
                          $('.total').val(addCommas(total));
                      }
                  /*  total = (subharga - diskon) + hargappn;
                    console.log(subharga-diskon);
                    console.log(hargappn);
                    numhar = Math.round(total).toFixed(2);
                    $('.total').val(addCommas(numhar));*/
                  }
                 }
              })

              $('.ppn').change(function(){
                  $('.save').attr('disabled', false);
                $this = $(this).val();
                subtotal =  $('.subtotal').val();
                subharga = subtotal.replace(/,/g, '');

             // ppn = angkappn.replace(/,/g, '');
             /*   hargappn = ($this * parseInt(subharga)) / 100;*/
               
                disc = $('.diskon').val();
                diskon = (disc * parseInt(subharga)) / 100;
                jenisppn = $('.jenisppn').val();

                  if(disc == ''){
                    if(jenisppn == 'E'){
                             hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                             ppnhar = hargappn.toFixed(2);
                            $('.hargappn').val(addCommas(ppnhar));
                          total = parseFloat(parseFloat(subharga) + parseFloat(ppnhar));
                          numhar = total.toFixed(2);
                          $('.total').val(addCommas(numhar));
                         
                        }
                        else if(jenisppn == 'I'){
                          hargappn = parseFloat(subharga * parseFloat(100) / 100 + ppn );
                          hargappn2 = hargappn2.toFixed(2);
                          $('.hargappn').val(addCommas(hargappn2));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.total').val(addCommas(total));
                        }
                        else if(jenisppn == 'T'){
                             hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                             ppnhar = hargappn.toFixed(2);
                            $('.hargappn').val(addCommas(ppnhar));
                            $('.total').val(addCommas(subharga));
                        }

                  }
                  else {
                      if(jenisppn == 'E'){
                        hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                        ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));

                        total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon));
                        numhar = total.toFixed(2);
                        $('.total').val(addCommas(numhar));
                        console.log(numhar);
                      }
                      else if(jenisppn == 'I'){
                        hargappn = parseFloat(subharga * parseFloat(100) / 100 + ppn );
                        hargappn2 = hargappn2.toFixed(2);
                        $('.hargappn').val(addCommas(hargappn2));
                        total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon)).toFixed(2);
                        $('.total').val(addCommas(total));
                      }
                      else if(jenisppn == 'T'){
                           hargappn = parseFloat(ppn * parseFloat(subharga) / 100);
                           ppnhar = hargappn.toFixed(2);
                          $('.hargappn').val(addCommas(ppnhar));
                           total = parseFloat(subharga  - diskon).toFixed(2);
                          $('.total').val(addCommas(total));
                      }
                  }

              })

    $('.harga').change(function(){
      var id = $(this).data('id');           
        harga = $(this).val();
        numhar = Math.round(harga).toFixed(2);
      console.log(id);
      $(this).val(addCommas(numhar));
    })
   
</script>
@endsection
