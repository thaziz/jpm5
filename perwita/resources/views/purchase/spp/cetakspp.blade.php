<!DOCTYPE html>
<html>
<head>
	<title>Print Surat Permintaan Pembelian</title>
	<style>
*{
	font-family: arial;
	text-align: center;
	
}
table {
    border-collapse: collapse;
    font-size:12px;
}

table, td, th {
    border: 1px solid black;
}
.table1 tr > td{
	border-style: hidden;
}
.div-width{
	width: 900px;
}
.top
{
	vertical-align: top;
	text-align: left;
}
.top-center
{
	vertical-align: top
	text-align:center;
}
.bottom
{
	vertical-align: bottom;
	text-align: left;
}
.blank
{
	height: 15px;
}
.tebal
{
	font-weight: bold;
}
.half-left
{
	float: left;
	width: 49.9%;
	border-right: 1px solid black;
}
.half-right
{
	float: right;
	width: 49.9%;
	border-left: 1px solid black;
}
.footer
{
	height: 70px;
}
div.bottom
{
	font-size: 12px;
}

	</style>
</head>
<body>
<div class="div-width">
	<table width="100%">
		<tr>
			<td width="125px"><img src="{{ asset('perwita/storage/app/upload/images.jpg') }}"  width="200" height="100"></td>
			<td align="center" width="410px"><h2>SURAT PERMINTAAN PEMBELIAN</h2></td>
			
			<td class="top" width="240px">No SPP : {{$data['spp'][0]->spp_nospp}} <br>Tanggal Input : {{ Carbon\Carbon::parse($data['spp'][0]->tglinput)->format('d-M-Y ') }}

			<br> No PO : <br> @foreach($data['po'] as $po) &nbsp; -  {{$po->po_no}} <br> @endforeach
			</td>


			</td>
		</tr>
	</table>
	<table width="100%" style="border-top:hidden;" id="hargatable">
		<tr>
			<td colspan="9" style="text-align: left">
				Diminta oleh bagian : {{$data['spp'][0]->spp_bagian}} <br>
				Untuk keperluan : {{$data['spp'][0]->spp_keperluan}}<br>
				Tanggal dibutuhkan : {{ Carbon\Carbon::parse($data['spp'][0]->created_at)->format('d-M-Y ') }}
			</td>
		</tr>
		<tr>
			<td colspan="4" class="tebal">Diisi oleh bagian yang membutuhkan barang / jasa</td>
			<td colspan="5" class="tebal">Diisi oleh bagian pembelian</td>
		</tr>
		<tr>
			<td rowspan="2" width="40px">No</td>
			<td rowspan="2" width="190px">Uraian / Nama Barang-Jasa</td>

			<td rowspan="2" width="50px">Jumlah</td>
			  @if($data['countkendaraan'] > 0)           
                <td rowspan="2" width="150px"> Kendaraan </td>                         
             @endif
			<td rowspan="2" width="10px">Satuan</td>
			<td colspan="{{$data['count']}}" width="200">Harga untuk masing-masing suplier</td>
			<!-- <td rowspan="2" width="65px">NO. PO</td> -->
			<td rowspan="2" width="170px">Keterangan</td>
		</tr>
		

		<tr class="data-supplier">
          @foreach($data['spptb'] as $index=>$spptb)
          <td width='100px' class="supplier{{$index}} tebal" data-id="{{$index}}" data-supplier="{{$spptb->spptb_supplier}}"> 
             {{$spptb->nama_supplier}} 
                 
          </td> 
          @endforeach
        </tr>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <input type="hidden" name="idspp" value="{{$data['spp'][0]->spp_id}}" class="idspp">
		 @foreach($data['sppdt_barang'] as $idbarang=>$sppd)                 
                      <tr class="brg{{$idbarang}} barang" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$sppd->sppd_kodeitem}}" >
                        <td>  {{$idbarang + 1}} </td>
                        <td> 
                             {{$sppd->nama_masteritem}}
                            
                             
                        </td>
                        <td>   {{$sppd->sppd_qtyrequest}} </td>
                    
                         @if($data['countkendaraan'] > 0) 
                            <td>  {{$sppd->nopol}} - {{$sppd->merk}}  </td>                       
                         @endif



                      
                        <td> {{$sppd->unitstock}}</td>
                            <!-- harga -->
                            @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
                       
                        	
                        		
                        	 <!-- 	<td>  </td> -->
                        	
                        	
                        
                        <td>{{$data['spp'][0]->spp_keterangan}} </td>

                      </tr>                     
                      @endforeach
                     
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>    </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		</tr>

		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>    </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>  </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>    </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>    </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>    </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
	
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>    </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>   </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                            <td>  </td>                       
                         @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                <td>  </td>                       
             @endif
			<td></td>
			 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			   @if($data['countkendaraan'] > 0) 
                <td>  </td>                       
           		@endif
			<td></td>
		 @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
			<td></td>
		
		</tr>
		<tr>
			<td rowspan="3" class="tebal">Catatan : </td>
		</tr>
		<tr>
			<td colspan="9" style="text-align: left;font-size: 11px;">1. Hubungi minimal 2 suplier dan tuliskan nama suplier yang dihubungi, bila hanya ada 1 suplier tuliskan diketerangan alasannya</td>
		</tr>
		<tr>
			<td colspan="9" style="text-align: left;font-size: 11px;">2. Lingkari dan berii paraf pada suplier yang dipilih (yang dilakukan oleh Manager Keuangan dan Akuntansi)</td>
		</tr>
		<tr>
			<td colspan="4" class="tebal">Peminta Barang / Jasa</td>
			<td colspan="5" class="tebal">Bagian Pembelian Barang / Jasa</td>
		</tr>
	</table>

	<table width="100%" style="border-top: hidden;">
		<tr>
			<td width="200px" class="footer">
				<div class="top-center" style="padding-bottom: 50px;">Diminta oleh <br>
					{{$data['spp'][0]->create_by}}</div>

				<p> &nbsp; </p>
				<div class="bottom">Tanggal :  {{ Carbon\Carbon::parse($data['spp'][0]->tglinput)->format('d-M-Y ') }} </div>
			</td>
			<td width="182px">
				<div class="top-center" style="padding-bottom: 50px;">Diketahui oleh
				<br>
				{{$data['spp'][0]->spp_namakabag}} 
				</div>
					@if($data['spp'][0]->spp_statuskabag != 'BELUM MENGETAHUI')
					<p> BELUM MENGETAHUI </p>
					@endif
				<div class="bottom">Tanggal :
					@if($data['spp'][0]->spp_statuskabag == 'SETUJU')
				 {{ Carbon\Carbon::parse($data['spp'][0]->spp_timesetujukabag)->format('d-M-Y ') }}</div>
					@endif
			</td>	
		</tr>
	</table>
	<div class="bottom" style="width: 300px;float: left">1. Arsip yang meminta barang / jasa</div>
	<div class="bottom" style="width: 600px;float: right;">2. Bagian Pembelian</div>
	<div class="bottom" style="float: right;"> {{$data['spp'][0]->spp_noform}}</div>

</div>


  <script src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"> </script>
  	<script  type="text/javascript">
    var baseurl = {!! json_encode(url('/')) !!}
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

    var countitem = $('.itm').length;
    console.log(countitem);

    var arritem = [];
    $(function(){
      for (var z = 0; z < countitem; z++ ){
          var value = $('.item' + z).val();
          arritem.push(value);
      }
    })

	$(function(){
      var url = baseurl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').serialize();
       
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(idspp);
        $.ajax({     
          type :"get",
          data : idspp,
          url : url,
          dataType:'json',
          success : function(data){
         //	alert(data);
              $('#hargatable').each(function(){    
                      for(var n=0;n<data.sppdt_barang.length;n++){
                       var kodebrg =  $('.brg'+ n).data("kodeitem");
                       console.log('kodebrg');
                       console.log(kodebrg);
                          for(var i = 0 ; i <data.sppdt.length;i++){
                            if(kodebrg == data.sppdt[i].sppd_kodeitem) {
                               for(var j =0; j < data.spptb.length; j++){
                                if(data.sppdt[i].sppd_supplier == data.spptb[j].spptb_supplier) {
                                    console.log(data.sppdt[i].sppd_supplier + 'supplier');
                                        if(data.sppdt[i].sppd_kendaraan != null) {
                                          var row = $('td[data-supplier="'+ data.sppdt[i].sppd_supplier + '"]').index() + 5;
                                        }
                                        else {
                                         var row = $('td[data-supplier="'+ data.sppdt[i].sppd_supplier + '"]').index() + 4; 
                                        }
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + addCommas(data.sppdt[i].sppd_harga) + 
                                                            '<div class="col-xs-6">';
                                        
                                     

                                        tampilharga += '<input type="hidden" name="itembarang[]" value="'+arritem[n]+''+','+''+n+'" >';
                                        
                                        tampilharga += '<div class="tampilsupplier'+j+'"> <input type="hidden" name="idsuplier[]" value='+data.spptb[j].spptb_supplier+'> </div>';

                                        tampilharga += '<div class="tampilsyaratkredit'+j+'"> <input type="hidden" name="syaratkredit[]" value='+data.sppdt[i].sppd_bayar+'> </div>';

                                        tampilharga += '<input type="hidden" name="idsppd[]" value='+data.sppdt[i].sppd_idsppdetail+'>';
                                      tampilharga +=  '<div class="disetujui'+i+'" data-id="'+i+'"> </div>  <div class="btlsetuju'+i+'" data-id="'+i+'" data-supplier='+data.sppdt[i].sppd_supplier+' data-harga='+data.sppdt[i].sppd_harga+' data-totalhrg='+data.spptb[j].spptb_totalbiaya+'> </div> </div> </div> ';

                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  
                                }

                                }
                              }  



                            }
                      }

                                $('.hrg').each(function(){
                                  $(this).change(function(){
                                     var id = $(this).data('id');
                                      harga = $(this).val();
                                      numhar = Math.round(harga).toFixed(2);
                                      $('.harga' + id).val(addCommas(numhar));
                                  })
                                })

                 })
                

              
             }

        })
 
      })
  
</script>


</body>


</html>