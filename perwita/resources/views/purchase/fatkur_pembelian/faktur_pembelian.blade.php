<!DOCTYPE html>
<html>
<head>
	<title>FAKTUR PEMBELIAN</title>
	<style type="text/css">
		
		.s16{
			font-size: 16px !important;
		}
		.div-width{
			margin: auto;
			width: 95vw;
		}
		.underline{
			text-decoration: underline;
		}
		.italic{
			font-style: italic;
		}
		.bold{
			font-weight: bold;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.text-left{
			text-align: left;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-top{
			border-top: hidden;
		}
		.float-left{
			float: left;
		}
		.float-right{
			float: right;
		}
		.top{
			vertical-align: text-top;
		}
		.vertical-baseline{
			vertical-align: baseline;
		}
		.bottom{
			vertical-align: text-bottom;
		}
		.ttd{
			top: 0;
			position: absolute;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 18px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td{
			border:none !important;
		}
		.position-top{
			vertical-align: top;
		}
		@page {
			size: portrait;
		}
		@media print {
			margin:0;
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}
	</style>
</head>
<body>
	<div class="div-width">
		<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td width="1%"><img src="" width="120px" height="75px"></td>
				<td class="s16 text-left">
					<text class="bold">PT. Jawa Pratama Mandiri</text><br>
					<small>
						Gedung Temprina Lt.1 Jl.Wringin Anom KM 30-31 Sumengko<br>
						Telp. ( 031 ) 8986777, 896888<br>
						Email : ekspedisi@jawapos.co.id
					</small>
				</td>
				<td class="s16 position-top" width="30%">
					<table class="border-none float-right">
						<tr>
							<td class="s16">No. Faktur</td>
							<td class="s16">:</td>
							<td class="s16">{{$data['judul'][0]->fp_nofaktur}}</td>
						</tr>
						<tr>
							<td class="s16">Tanggal</td>
							<td class="s16">:</td>
							<td class="s16"> {{ Carbon\Carbon::parse($data['judul'][0]->fp_tgl)->format('d-M-Y ') }} </td>
						</tr>
						<tr>
							<td class="s16">No. Invoice</td>
							<td class="s16">:</td>
							<td class="s16"> {{$data['judul'][0]->fp_noinvoice}} </td>
						</tr>
						<tr>
								<td class="s16"> Jatuh Tempo </td>
						        <td class="s16"> : </td>
						        <td class="s16">  {{ Carbon\Carbon::parse($data['judul'][0]->fp_jatuhtempo)->format('d-M-Y ') }} </td>
												</tr>
					</table>
				</td>
				
			</tr>
			<tr>
				<td colspan="3" class="text-center bold underline">
					<h2>FAKTUR PEMBELIAN</h2>
				</td>
			</tr>
		</table>
		<fieldset style="margin-bottom: 5px;">
			<legend class="italic">Diterima Dari :</legend>
			{{$data['judul'][0]->nama_supplier}} [{{$data['judul'][0]->no_supplier}}]  <br>
			{{$data['judul'][0]->alamat}}
		</fieldset>
		<table width="100%" cellspacing="0" class="tabel" border="1px">
			<tr class="text-center">
				<td>No</td>
				<td>Kode</td>
				<td>Nama Barang / Jasa</td>
				<td>Quantity</td>
				<td>Unit</td>
				<td>Harga Satuan</td>
				<td>Jumlah Harga</td>
				<td>Biaya</td>
				<td>Netto</td>
				<td>Keterangan</td>
			</tr>
			
			 @foreach($data['barang'] as $key=>$brg)
		     <tr>
		       <td class="right"> {{$key + 1}} </td>
		       <td class="textleft right"> {{$brg->kode_item}}</td>
		       <td class="textleft right"> {{$brg->nama_masteritem}}</td>
		       <td class="textright right"> {{$brg->fpdt_qty}}</td>
		       <td class="textright right"> {{$brg->unitstock}}</td>
		       <td class="textright right"> {{number_format($brg->fpdt_harga, 2)}}</td>
		       <td class="textright right"> {{number_format($brg->fpdt_totalharga, 2)}}</td>
		       <td class="textright right"> {{number_format($brg->fpdt_biaya, 2)}}</td>
		       <td class="textright right"> {{number_format($brg->fpdt_netto, 2)}}</td>
		       <td class="textleft right"> {{$brg->fpdt_keterangan}} </td>
		     </tr>
		     @endforeach


			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr>
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				<td class="text-right"></td>
				<td class="text-center"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td colspan="3"></td>
				<td colspan="4">DPP</td>
				<td class="border-none-left"></td>
				<td class="text-right"> {{number_format($data['judul'][0]->fp_dpp, 2)}} </td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td colspan="3"></td>
				<td colspan="4">Discount</td>
				<td class="text-right border-none-left">
					@if($data['judul'][0]->fp_discount == null)
			           0%
			           @else
			            {{$data['judul'][0]->fp_discount}}
			           @endif
			    </td>
				<td class="text-right">{{number_format($data['judul'][0]->fp_hsldiscount, 2)}}</td>
				<td class="text-right"> </td>
			</tr>
			<tr class="border-none-bottom">
				<td colspan="3"></td>
				<td colspan="4">PPn</td>
				<td class="text-right border-none-left">
					 @if($data['judul'][0]->fp_ppn == 0)
		                0%
		              @else
		              {{$data['judul'][0]->fp_inputppn}} %
		              @endif
				</td>
				<td class="text-right">  {{number_format($data['judul'][0]->fp_ppn, 2)}} </td>
				<td></td>
			</tr>
			<tr class="border-none-bottom" style="height: 50px;vertical-align: top;">
				<td colspan="3"></td>
				<td colspan="4">PPH</td>
				<td class="text-right border-none-left">
					  @if($data['judul'][0]->fp_pph == 0)
		                0%
		              @else
		              {{$data['judul'][0]->fp_nilaipph}} %
		              @endif
				</td>
				<td class="text-right">{{number_format($data['judul'][0]->fp_pph, 2)}}</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td colspan="4">Netto</td>
				<td class="border-none-left"></td>
				<td class="text-right"> {{number_format($data['judul'][0]->fp_netto, 2)}} </td>
				<td></td>
			</tr>
			<tr class="text-center"  style="height: 105px;vertical-align: top;">
				@if(count($data['jurnal_dt']) != 0)
				<td colspan="3" style="padding:20px"> Jurnal
					<table width="90%" style="">
						<tr>
							<td> <b> ID AKUN </b> </td>
							<td> <b> NAMA AKUN </b> </td>
							<td> <b> K  </b> </td>
							<td> <b> D </b> </td>
						</tr>
						<tr>
							<?php $totalDebit=0;
                			$totalKredit=0; ?>
                			@for($key = 0; $key < count($data['jurnal_dt']); $key++)
                				<tr>
                					<td> {{$data['jurnal_dt'][$key]->id_akun}}</td>
                					<td class="text-left" style="padding-left: 20px"> {{$data['jurnal_dt'][$key]->nama_akun}}</td>
                						@if($data['jurnal_dt'][$key]->dk == 'D')
                						<?php $totalDebit = $totalDebit + abs($data['jurnal_dt'][$key]->jrdt_value) ?>
                							<td class="text-right"> {{number_format(abs($data['jurnal_dt'][$key]->jrdt_value), 2)}} </td>                				
                							<td> </td>
                						@elseif($data['jurnal_dt'][$key]->dk == 'K')
                							<?php $totalKredit = $totalKredit + abs($data['jurnal_dt'][$key]->jrdt_value) ?>
                							<td>  </td>
                							<td class="text-right"> {{number_format(abs($data['jurnal_dt'][$key]->jrdt_value), 2)}} </td>
                						@endif
                				</tr>
                 			@endfor
                     
                          <tr>
                                  <td colspan="2"> <b> Total </b> </td>                        
                                  <td> <?php echo number_format($totalDebit ,2) ?>  </td>
                                  <td> <?php echo number_format($totalKredit , 2) ?> </td>
                                 
                          <tr>
                     
						</tr>
					</table>
				</td>
				@endif
				<td class="border-none-bottom" colspan="5"> 


				</td>

				<td>Dibuat</td>
				<td>Diterima</td>
			</tr>
		</table>
	</div>
</body>
</html>