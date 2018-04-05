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
			<td width="125px"><img src="" width="125px" height="60px"></td>
			<td align="center" width="410px"><h2>SURAT PERMINTAAN PEMBELIAN</h2></td>
			
			<td class="top" width="240px">No SPP : {{$data['spp'][0]->spp_nospp}} <br>Tanggal : {{$data['spp'][0]->spp_tgldibutuhkan}}
			</td>
		</tr>
	</table>
	<table width="100%" style="border-top:hidden;">
		<tr>
			<td colspan="9" style="text-align: left">
				Diminta oleh bagian : {{$data['spp'][0]->spp_bagian}} <br>
				Untuk keperluan : {{$data['spp'][0]->spp_keperluan}}<br>
				Tanggal dibutuhkan : {{ Carbon\Carbon::parse($data['spp'][0]->spp_tgldibutuhkan)->format('d-M-Y ') }}
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
				<div class="top-center" style="padding-bottom: 50px;">Diminta oleh</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="182px">
				<div class="top-center" style="padding-bottom: 50px;">Disetujui oleh</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="153px">
				<div class="top-center" style="padding-bottom: 50px;">Staff Pembelian</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="153px">
				<div class="top-center" style="padding-bottom: 50px;">Dikontrol Oleh</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="">
				<div class="top-center" style="padding-bottom: 50px;">Manager Keuangan dan Akuntansi</div>
				<div class="bottom">Tanggal :</div>
			</td>
		</tr>
	</table>
	<div class="bottom" style="width: 300px;float: left">1. Arsip yang meminta barang / jasa</div>
	<div class="bottom" style="width: 600px;float: right;">2. Bagian Pembelian</div>
	<div class="bottom" style="float: right;">JPM/FR/PURC/01-02-Januari 2017-00</div>

</div>

@section('page-script')
 <script type="text/javascript">
      var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
 	alert(url);
	      
</script>
@section('extra_scripts')

</body>


</html>