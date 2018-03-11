@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Penerimaan Barang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Detail Penerimaan Barang  </strong>
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
                    <h5> Detail Penerimaan Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <a class="btn btn-danger" aria-hidden="true" href="{{ url('penerimaanbarang/penerimaanbarang')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
                    </div>
                </div>

              <form method="post" id="formId" action="{{url('penerimaanbarang/savepenerimaan')}}"  enctype="multipart/form-data" class="form-horizontal">
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->               
                  <div class="box-body">
                    <div class="col-xs-12">


                    <!-- KONTEN PAKE FP -->
                    @if($data['flag'] == 'FP')
                    <input type="hidden" class="flag" value="FP" name="flag">
                    <table border="0" class="table">
                     <tr>
                        <th style="width:200px"> Supplier </th>
                        <td style="width:400px"> <h3> {{$data['fp'][0]->nama_supplier}} </h3> </td>
                        <input type="hidden" name="idfp" value="{{$data['fp'][0]->fp_idfaktur}}" class="idfp">
                        <input type="hidden" name="idsup" value="{{$data['fp'][0]->fp_idsup}}">
                        <input type="hidden" name="comp" value="{{$data['fp'][0]->fp_comp}}">
                         <input type="hidden" name="acchutangsupplier" value="{{$data['fp'][0]->acc_hutang}}">
                         <input type="hidden" name="fp_pph" value="{{$data['fp'][0]->fp_pph}}">
                         <input type="hidden" name="fp_ppn" value="{{$data['fp'][0]->fp_ppn}}">
                         <input type="hidden" name="fp_diskon" value="{{$data['fp'][0]->fp_discount}}">
                         <input type="hidden" name="fp_hsldiskon" value="{{$data['fp'][0]->fp_hsldiscount}}">
                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                      </tr>

                      <tr>
                        <th class="suratjalan" style="width:200px"> No Surat Jalan </th>
                        <td style="width:400px"> <input type="text" class="form-control suratjalan" name="suratjalan" required>  </td>
                      </tr>

                      <tr>
                        <th class="tgl suratjalan"> Tanggal di Terima </th>
                        <td>
                          <div class="input-group date tgl">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required>
                          </div>
                        
                          <td>
                          <div class="checkbox checkbox-primary cek2">
                            <input id="lengkap" type="checkbox" class="lengkap">
                            <label for="checkbox2">
                              Lengkap
                            </label>
                           </div>
                         </td>
                      </tr>
                   
                        <tr >
                          <th style="width:200px"> No FP </th>
                          <td style="width:400px"> {{$data['fp'][0]->fp_nofaktur}} </td>
                           
                        </tr>


                        <tr>
                          <th> Update Stock </th>
                          <td> @if($data['fp'][0]->fp_updatestock == 'Y')
                                <input type="text" class="form-control" readonly="" value="IYA" name="updatestock">
                              @else
                                  <input type="text" class="form-control" readonly="" value="TIDAK" name="updatestock">
                              @endif
                          </td>
                        </tr>                      
                      </table>

                      <br>
                      <br>
                        <h4> Data Detail Barang </h4>
                         <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang" > 
                           <tr>
                              <th> No </th>
                              <th> Nama Barang </th>
                              <th> Satuan </th>
                              <th> Jumlah dikirim </th>
                              <th class="jmlhditerima"> Jumlah yang diterima </th>
                              <th> Sisa </th>
                              <th> Tambahan Qty Sampling </th>
                           </tr>
                          
                           <?php $n = 0 ?>
                           @for($x=0 ; $x < count($data['fpdt']); $x++)
                            <tr class="databarang">
                              <td> {{$x + 1}}</td>
                              <td> {{$data['fpdt'][$x]->nama_masteritem}}</td>
                              <td> {{$data['fpdt'][$x]->unitstock}}</td>
                              
                              <td> {{$data['fpdt'][$x]->fpdt_qty}}</td> <!--qty dikirim -->
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_qty}}" class=qtykirim<?php echo $n?> data-id=<?php echo $n ?> name="qtydikirim[]">
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_kodeitem}}" name="kodeitem[]" class="item kodeitem{{$x}}"> <!--kodeitem-->
                               <input type="hidden" name="accpersediaan" value="{{$data['fpdt'][$x]->acc_persediaan}}">
                         <input type="hidden" name="acchpp" value="{{$data['fpdt'][$x]->acc_hpp}}">


                              <td> <input type="number" class="form-control qtyreceive qtyterima{{$x}}" name="qtyterima[]" id=qtyterima<?php echo $n?> data-kodeitem="{{$data['fpdt'][$x]->fpdt_kodeitem}}" data-id=<?php echo $n?>> </td>
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_biaya}}" name="jumlahharga[]">
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_harga}}" name="hpp[]">
                              <td> 
                              @for($c=0; $c < count($data['sisa'][$x]); $c++)
                                @if( $data['fpdt'][$x]->fpdt_id == $data['sisa'][$x][$c]->fpdt_id)
                                  
                                        <input type="text" data-id=<?php echo $n ?> class="form-control sisa" id=sisa<?php echo $n ?> value=" {{$data['fpdt'][$x]->fpdt_qty - $data['sisa'][$x][$c]->sum}}" readonly="">
                                 
                                  @endif
                              @endfor
                              </td>


                              <td>   <button class='btn btn-xs btn-info sampling' type='button' data-kodeitem="{{$data['fpdt'][$x]->fpdt_kodeitem}}"   data-id=<?php echo $n ?> style="display:block" id=sampling<?php echo $n ?>> <i class="fa fa-plus" aria-hidden="true"> </i>  Sampling </button> <div class="row"> <div class="col-md-6"> <input type='text' class="form-control qtysampling" id=qtysampling<?php echo $n?> style="display:none" data-id=<?php echo $n ?> name="qtysampling[]" > </div> <div class="col-md-3"> <button type='button' data-id=<?php echo $n ?> class='btn btn-circle btn-success' id=close<?php echo $n ?> style="display: none" name="close"> <i class='fa fa-times'> </i> </button> </div> </div></td>
                            </tr>
                            <?php $n++; ?>
                           @endfor
                          </table>

                        <div class="text-left">
                           <input type="submit"  class="simpan btn btn-success" value="Simpan" >   
                      </div>
                        <div class="judul"> </div>                     
                       <div class="tampildata"> </div> </td>

                    @else <!-- END FP -->
                      
                  <!-- KONTEN PAKE PO -->
                    <table border="0" class="table">
                  <input type="hidden" class="flag" value="PO" name="flag">
                      <tr>
                        <th style="width:200px"> Supplier </th>
                        <td style="width:400px"> <h3> {{$data['po'][0]->nama_supplier}} </h3> </td>
                        <input type="hidden" name="comp" value="{{$data['po'][0]->spp_cabang}}">
                        <input type="hidden" name="acchutangsupplierpo" value="{{$data['po'][0]->acc_hutang}}">
                        <input type="hidden" name="ppn_po" value="{{$data['po'][0]->po_ppn}}">
                        <input type="hidden" name="diskon_po" value="{{$data['po'][0]->po_diskon}}">
                      </tr>
                      
                        <tr>
                          <th class="suratjalan" style="width:200px"> No Surat Jalan </th>
                          <td style="width:400px"> <input type="text" class="form-control suratjalan" name="suratjalan" required>  </td>
                         </tr>


                         <tr>
                          <th class="tgl suratjalan"> Tanggal di Terima </th>
                          <td>
                              <div class="input-group date tgl">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required>
                              </div>
                        
                                  <td>
                                      <div class="checkbox checkbox-primary cek2">
                                            <input id="lengkap" type="checkbox" class="lengkap">
                                            <label for="checkbox2">
                                               Lengkap
                                            </label>
                                      </div>
                                  </td>
                         </tr>


                    </table>

                    <hr>
                      <?php $n = 0 ?>
                      @for($i = 0; $i < count($data['po']); $i++)
                      <table class="table" style="margin-top:5px; width:50%">
                      <tr >
                        <th style="width:200px"> No SPP </th>
                        <td style="width:400px"> {{$data['po'][$i]->spp_nospp}}</td>
                           <input type="hidden" value="{{$data['po'][$i]->po_id}}" name="po_id" class="po_id">
                           <input type="hidden" value="{{$data['po'][0]->idsup}}" name="idsup" class="idsup">
                      </tr>

                      <tr>
                        <th> NO PO </th>
                        <th> {{$data['po'][$i]->po_no}} </th>
                      </tr>

                      <tr>
                        <th> Update Stock </th>
                        <td> @if($data['po'][$i]->spp_lokasigudang != '') <input type="text" class="form-control" readonly="" name="updatestock" value="IYA">  @else <input type="text" class="form-control" readonly="" name="updatestock" value="TIDAK"> @endif </td>
                      </tr>

                        <tr>
                         </tr>
                         <tr>
                         </tr>
                         </table>

                         <h4> Data Detail Barang </h4>
                         <table id=addColumn class="table table-bordered table-striped tbl-penerimabarang" > 
                           <tr>
                              <th> No </th>
                              <th> Nama Barang </th>
                              <th> Satuan </th>
                              <th> Jumlah dikirim </th>
                              <th class="jmlhditerima"> Jumlah yang diterima </th>
                              <th> Sisa </th>
                              <th> Tambahan Qty Sampling </th>
                           </tr>

                        
                         @for($j= 0; $j < count($data['podtbarang'][$i]); $j++)                       
                          <tr class="databarang" id=" {{$data['po'][$i]->spp_nospp}}">
                           <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <input type="hidden" class= qtykirim<?php echo $n ?> value="{{$data['podtbarang'][$i][$j]->podt_qtykirim}}" id="qtydikirim"
                            data-id=<?php echo $n ?> name="qtydikirim[]"> <input type="hidden" class="item{{$j}}" value="{{$data['podtbarang'][$i][$j]->kode_item}}">

                            <input type="hidden" value="{{$data['podtbarang'][$i][$j]->podt_jumlahharga}}" name="jumlahharga[]" class="jumlahharga{{$j}}">
                            <input type="hidden" class="item kodeitem{{$j}}" value="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" name="kodeitem[]">

                            <input type="hidden" class="item kodeitem{{$j}}" value="{{$data['podtbarang'][$i][$j]->acc_persediaan}}" name="accpersediaan[]">
                             <input type="hidden" class="item kodeitem{{$j}}" value="{{$data['podtbarang'][$i][$j]->acc_hpp}}" name="acchpp[]">
                            
                            <input type="hidden" class="item podtid" value="{{$data['podtbarang'][$i][$j]->podt_id}}" name="podtid[]">
                            <input type='hidden' value="{{$data['po'][$i]->spp_id}}" name="idspp[]">

                          <td> {{$j + 1}} </td>
                          <td> {{$data['podtbarang'][$i][$j]->nama_masteritem}} </td>
                          <td> {{$data['podtbarang'][$i][$j]->unitstock}} </td>
                           <td data-kodeitem="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" data-id={{$j}}> {{$data['podtbarang'][$i][$j]->podt_qtykirim}} <input type="hidden" class="status{{$j}}" name="status[]"> </td>

                        
                           <td class="isijmlhditerima">  <input type="number" class="form-control qtyreceive qtyterima{{$j}}" id=qtyterima<?php echo $n ?> name="qtyterima[]" data-id=<?php echo $n ?> data-kodeitem="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" data-spp="{{$data['po'][$i]->spp_id}}"> <div class=jmlhkirim<?php echo $n ?>> </div> <div class=idspp<?php echo $n ?>> <div id=idbarang<?php echo $n?>> <?php echo $n ?> </div> </td>   
                          
                          <td> 
                            
                            <input type="text" data-id=<?php echo $n ?> class="form-control sisa" id=sisa<?php echo $n ?> value="{{$data['sisa'][$n][0]->podt_qtykirim - $data['sisa'][$n][0]->sum}}" readonly="">

                          </td>
                          
                          <td> 
                            <button class='btn btn-xs btn-info sampling' type='button' data-kodeitem="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" data-idspp="{{$data['po'][$i]->spp_id}}"  data-id=<?php echo $n ?> style="display:block" id=sampling<?php echo $n ?>> <i class="fa fa-plus" aria-hidden="true"> </i>  Sampling </button> <div class="row"> <div class="col-md-6"> <input type='text'  class="form-control qtysampling" id=qtysampling<?php echo $n?> style="display:none" name="qtysampling[]" data-id=<?php echo $n ?>> </div> <div class="col-md-3"> <button type='button' data-id=<?php echo $n ?> class='btn btn-circle btn-success' id=close<?php echo $n ?> style="display: none" name="close"> <i class='fa fa-times'> </i> </button> </div> </div> 
                          </td>                      
                        </tr>
                        <?php $n++ ?>   
                      @endfor
                      </table>
                      
                      </tr>
                      @endfor

                      <div class="text-left">
                        <input type="submit"  class="simpan btn btn-success" value="Simpan">  
                      </div>
                         
                       <div class="judul"> </div>                     
                       <div class="tampildata"> </div> </td>
                       

                    </form>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
               
                </div><!-- /.box-footer --> 
                    @endif
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

   
    $('#formId').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })

    $('#formId input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formId input').change(function(){
      this.setCustomValidity("");
    })


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
     $('#lengkap').attr('disabled' , false);

    var flag = $('.flag').val();
    if(flag == 'FP'){
     
         var tempsisa = 0;
        $('.sisa').each(function(){
          var sisa = $(this).val();
          var id = $(this).data('id');
          if(sisa == 0 ) {
            $('#qtyterima'+id).attr('readonly' , true);
             tempsisa = tempsisa + 1;
          }
        })


      
        var pnjgsisa = $('.sisa').length;
        if(tempsisa == pnjgsisa) {
          $('.simpan').attr('disabled' , true);
        }      
    }
    else {
    
         var tempsisa = 0;
        $('.sisa').each(function(){
          var sisa = $(this).val();
          var id = $(this).data('id');
          if(sisa == 0 ) {
            $('#qtyterima'+id).attr('readonly' , true);
             tempsisa = tempsisa + 1;
          }
        })

        var pnjgsisa = $('.sisa').length;
        if(tempsisa == pnjgsisa) {
          $('.simpan').attr('disabled' , true);
        }

    }
 
    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
      

      

     $('.sampling').click(function(){
      kodeitem = $(this).data('kodeitem');
      idspp = $(this).data('idspp');
      id = $(this).data('id');
      j = $(this).data('j');

     
      $('#qtyterima' + id).attr('readonly', true);
      $('#qtysampling' + id).css('display','block');
      $('#close' + id).css('display', 'block');
      $(this).css('display' , 'none');
      $('#qtyterima' + id).val('');
   })

   $('button[name="close"]').click(function(){
    id = $(this).data('id');
     $('#qtyterima' + id).attr('readonly', false);
      $('#qtysampling' + id).css('display','none');
      $('#close' + id).css('display', 'none');
     $('.sampling').css('display' , 'block');
   })
   
    $('.qtysampling').each(function(){
      $(this).change(function(){
        id = $(this).data('id');
        val = parseInt($(this).val());
        qtykirim = $('.qtykirim' + id).val();
        if(val < qtykirim){
          alert('Qty Sampling harus lebih besar daripada qty kirim :)');
          $(this).val('');
        }
      })
    })

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    kodeitem = [];

    for(var i = 0; i < $('.item').length; i++) {
        item = $('.kodeitem' + i).val();
        kodeitem.push(item);
    }
      

		if(flag == 'PO') {
			 po_id = $('.po_id').val();
      var url = baseUrl + '/penerimaanbarang/gettampil';
      $.ajax({    
          type :"get",
          data : {kodeitem, po_id,flag},
          url : url,
          dataType:'json',
          success : function(response){
           
            if(response.judul.length != 0) {
               $('#lengkap').attr('disabled' , true);
              console.log('ok');
            var qtykirim = [];
            var qtyditerima = [];
            
            var judulpenerimaan = "<hr> <br> <br> <h4> Data Penerimaan Barang </h4>";
            $('.judul').html(judulpenerimaan);

            for(var j = 0 ; j < response.judul.length; j++) {
            console.log(j);
              $no = 1;
            var rowtampil = "<table class='table'> <tr> <td style='width:200px'> No LPB </td> <td> : </td> <td>" + response.judul[j].pb_lpb + "</td> </tr>" + //no lpb
                            "<tr> <td> No Surat Jalan </td> <td> : </td> <td>"+ response.judul[j].pb_suratjalan +"</td> </tr>" +
                            "<tr> <td> Tgl di Terima </td> <td style='width:20px'> :</td> <td>"+ response.judul[j].pb_date + "</td>  </tr> " +
                            "<tr> <td> Status Penerimaan Barang </td> <td> </td> <td> "+response.judul[j].pb_status+" </div> </td> </tr>" +
                            "</table>";
                rowtampil += "<table class='table table-striped table-bordered' style='width:75%'> <tr> <th> No </th> <th> Nama Barang </th> <th> Satuan </th> <th> Harga Satuan </th> <th> Jumlah Harga </th> <th> Jumlah Dikirim </th> <th> Jumlah yang diterima </th> <th> No SPP </th> </tr>"; // judul


                 for(var x =0; x < response.barang[j].length; x++) {
                  console.log(x);
                        rowtampil += "<tr> <td style='width:20px'>"+ $no +"</td>" + 
                                "<td> "+ response.barang[j][x].nama_masteritem +"</td>" +// no
                              "<td>" + response.barang[j][x].unitstock + "</td>" +
                              "<td style='text-right'>Rp " + addCommas(response.barang[j][x].podt_jumlahharga)  + "</td>";
                           
                                 
                               rowtampil +=    "<td style='text-right'>Rp " + addCommas(response.barang[j][x].pbdt_totalharga) + "</td>" +
                                 
                                "<td>"+ response.barang[j][x].podt_qtykirim +"</td>" +
                                "<td>"+ response.barang[j][x].pbdt_qty +"</td>"+
                                "<td>"+ response.barang[j][x].spp_nospp +"</td> </tr>";
                          qtykirim.push(response.barang[j][x].podt_qtykirim);
                         qtyditerima.push(response.barang[j][x].pbdt_qty);
                      $no++;
                      var sisa = parseInt(response.barang[j][x].podt_qtykirim) - parseInt(response.barang[j][x].pbdt_qty);
                  }
                     
                   var lengthjudul = 0;
                   $('.tampildata').append(rowtampil);                                 
                  
                 /* $('tr#'+ response.barang[j][x].spp_nospp).*/

                }
         
          }
          else {
            console.log('else');
          }
        }
      })
		} /*<!--end flag po -->*/
		
		else { /*<!-- flag FP -->*/
     var url = baseUrl + '/penerimaanbarang/gettampil';
			var idfp = $('.idfp').val();
     /* alert(idfp);*/
		  $.ajax({    
			  type :"get",
			  data : {kodeitem, idfp,flag},
			  url : url,
			  dataType:'json',
			  success : function(response){
			//  alert('hai');
				if(response.judul.length != 0) {
					$('#lengkap').attr('disabled' , true);
					console.log('ok');
					var qtykirim = [];
					var qtyditerima = [];
					
					var judulpenerimaan = "<hr> <br> <br> <h4> Data Penerimaan Barang </h4>";
					$('.judul').html(judulpenerimaan);

					for(var j = 0 ; j < response.judul.length; j++) {
					console.log(j);
					  $no = 1;
					var rowtampil = "<table class='table'> <tr> <td style='width:200px'> No LPB </td> <td> : </td> <td>" + response.judul[j].pb_lpb + "</td> </tr>" + //no lpb
									"<tr> <td> No Surat Jalan </td> <td> : </td> <td>"+ response.judul[j].pb_suratjalan +"</td> </tr>" +
									"<tr> <td> Tgl di Terima </td> <td style='width:20px'> :</td> <td>"+ response.judul[j].pb_date + "</td>  </tr> " +
									"<tr> <td> Status Penerimaan Barang </td> <td> </td> <td> "+response.judul[j].pb_status+" </div> </td> </tr>" +
									"</table>";
						rowtampil += "<table class='table table-striped table-bordered' style='width:75%'> <tr> <th> No </th> <th> Nama Barang </th> <th> Satuan </th> <th> Harga Satuan </th> <th> Jumlah Harga </th> <th> Jumlah Dikirim </th> <th> Jumlah yang diterima </th> <th> No FP </th> </tr>"; // judul


						 for(var x =0; x < response.barang[j].length; x++) {
						  console.log(x);
								rowtampil += "<tr> <td style='width:20px'>"+ $no +"</td>" + 
										"<td> "+ response.barang[j][x].nama_masteritem +"</td>" +// no
									  "<td>" + response.barang[j][x].unitstock + "</td>" +
									  "<td style='text-right'>Rp " + addCommas(response.barang[j][x].fpdt_harga)  + "</td>";
								   
										 
									   rowtampil +=    "<td style='text-right'>Rp " + addCommas(response.barang[j][x].fpdt_biaya) + "</td>" +
										 
										"<td>"+ response.barang[j][x].fpdt_qty +"</td>" +
										"<td>"+ response.barang[j][x].pbdt_qty +"</td>"+
										"<td>"+ response.barang[j][x].fp_nofaktur +"</td> </tr>";
								  qtykirim.push(response.barang[j][x].podt_qtykirim);
								 qtyditerima.push(response.barang[j][x].pbdt_qty);
							  $no++;
							  var sisa = parseInt(response.barang[j][x].podt_qtykirim) - parseInt(response.barang[j][x].pbdt_qty);
						  }
							 
						   var lengthjudul = 0;
						   $('.tampildata').append(rowtampil);                                 
						  
						 /* $('tr#'+ response.barang[j][x].spp_nospp).*/

						}
				 
				  }
				  else {
					console.log('else');
				  }
			  }
			})
		} <!-- end flag fp -->
		
     
 
    $('#lengkap').change(function(){   

      if($(this).is(':checked')) {
        var qtykirimlength = $('.databarang').length;      
        for(var i = 0 ; i < qtykirimlength; i++){ 
   /*     alert(qtykirimlength);   */    
          val = $('.qtykirim' + i).val();
          id = $('.qtykirim' + i).data('id');
          console.log(id);
          $('#qtyterima' + id).val(val);
        }           
      }

      if(!$(this).is(':checked')){       
         var qtykirimlength = $('.databarang').length;
        for(var i = 0 ; i < qtykirimlength; i++){
          val = $('.qtykirim' + i).val();
          id = $('.qtykirim' + i).data('id');
          kosong = '';
          $('#qtyterima' + id).val(kosong);
        }  
      }
    })


    $('.qtyreceive').change(function(){
    // alert('hei');

      val = $(this).val();
      id = $(this).data('id');
  
      kodeitem = $(this).data('kodeitem');
      console.log(kodeitem);
      sppid = $(this).data('spp');
    /*  rowspp = "<input type='text' value="+sppid+" name='idspp[]'>";
      $('.idspp'+id).html(rowspp);*/

      //appendkodeitem
      barang = "<input type='text' value="+kodeitem+" name='item[]'>";
      //$('#idbarang' + id).html('barang'); 

      //appendidspp
   //   spp = "<input type='text' value="+sppid+" name=idspp[]>";
  //    $('.idspp' + id).html(spp);


       qtykirim = $('.qtykirim' + id).val();
  
      //appendjumlahkirim
        row = "<input type='text' value="+qtykirim+" name=qtydikirim[]>";
     //   $('.jmlhkirim' + id).html(row);

    //  alert(qtykirim  + 'qtykirim');
      if(parseInt(val) == parseInt(qtykirim)) {
        status = "LENGKAP";
        $('.status' + id).val(status);
      }
      else if(val == ''){
        $('.jmlhkirim' + id).empty();
        $('.idspp' + id).empty();
      }
      else if(parseInt(val) > parseInt(qtykirim)) {
        $('.jmlhkirim' + id).empty();
        $('.idspp' + id).empty();
      }
      else {
        status = "TIDAK LENGKAP";
        $('.status' + id).val(status);
       // $('.jmlhkirim' + id).empty();
      }
       


      if(parseInt(val) > parseInt(qtykirim)){
        alert("diharapkan mengisi angka di bawah angka jumlah dikirim :) ");
        kosong = " ";
        $(this).val(kosong);
      }
      
      po_id = $('.po_id').val();
      idspp = sppid;
      flah = $('.flag').val();
      urlterima = baseUrl + '/penerimaanbarang/changeqtyterima';
       $.ajax({    
          type :"get",
          data : {kodeitem, po_id, idspp, flag, idfp},
          url : urlterima,
          dataType:'json',
          success : function(response){
            console.log(response);
       /*        row = "<input type='text' value="+qtykirim+" name=qtydikirim[]>";
            $('.jmlhkirim' + id).html(row);*/
            console.log(response);
            lengthresp = response.pbdt.length;
            qty = 0;
            for(var i = 0; i < lengthresp; i++) {
              qty = qty + response.pbdt[i].pbdt_qty
            }

            console.log(qty);

            hasilqty = parseInt(val) + parseInt(qty);
            
            if(hasilqty > qtykirim) {
              alert('tidak bisa mengisi angka di bawah jumlah angka yang diterima dari yang dikirim :) ');
              kosong = '';
              $('#qtyterima' + id ).val(kosong);
              $('.jmlhkirim' + id).empty();
                $('.idspp' + id).empty();
            }
          }
      })
    })

</script>
@endsection
