<style type="text/css">

</style>
<div>
<table border="1" style="border-collapse: collapse;">
	<td width="900">
		<img style="padding-left: 10px;padding-top: 10px; position: absolute;" src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}">
		<div style="display: inline-block; margin-left: 32%">
			<h3 style="margin-top: 0; margin-bottom:2 ;text-align: center;">PT. Jawa Pratama Mandiri</h3>
			<p style="font-size: 12px; text-align: center; margin-top: 3px;margin-bottom: 20px;">{{$cari_fp[0]->alamat}}<br>Telp :{{$cari_fp[0]->telpon}}<br>Fax :{{$cari_fp[0]->fax}}</p>
			<h5 style="margin-top: 0; margin-bottom:2;text-align: center;">BUKTI PENGELUARAN KAS</h5>
		</div>
		<div style="float: right;">
			<p style="margin: 0 0;font-size: 14px; margin-top: 5px; margin-right: 5px;">No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<br>{{$cari_fp[0]->fp_nofaktur}}<br>Tanggal&nbsp;: {{$cari_fp[0]->fp_tgl}}<br>Cabang&nbsp;&nbsp;:{{$cari_fp[0]->nama}}</p>
		</div>
	</td>
</table>
<table border="1" style="border-collapse: collapse; margin: 5 0">
	<td width="900">
		<div>DIBAYAR KEPADA&nbsp;:&nbsp;{{$cari_fp[0]->nama}}</div>
	</td>
</table>

<table border="1" style="border-collapse: collapse; margin: 5 0; margin-bottom: 0;">
	<thead align="center">
		<tr>
		<td width="222">No. AKUN</td>
		<td width="450">KETERANGAN</td>
		<td width="222">RUPIAH</td>
		</tr>
	</thead>
	<tbody style="padding: 0 0 ">
		@foreach($harga_array as $index=>$val)
		<tr>

		@if($harga_array[$index] == ' ')
		<td align="right" style="border: none;" width="222">&nbsp;</td>
		@else	
			@if($index+1 < 10)
		<td align="left" style="border: none;" width="222">&nbsp;&nbsp;&nbsp;{{$index+1}}. {{$cari[0]->bpk_pembiayaan}}</td>
			@else
		<td align="left" style="border: none;" width="222">&nbsp;&nbsp;{{$index+1}}. {{$cari[0]->bpk_pembiayaan}}</td>	
			@endif
		@endif

		@if($harga_array[$index] == ' ')
		<td align="right" style="border: none;" width="222">&nbsp;</td>
		@else
		<td align="left" style="border: none;" width="450">&nbsp;&nbsp;&nbsp;{{$cari[0]->bpk_keterangan}}</td>
		@endif

		@if($harga_array[$index] == ' ')
		<td align="right" style="border: none;" width="222">&nbsp;</td>
		@else
		<td align="right" style="border: none;" width="222">{{"Rp " . number_format($harga_array[$index],2,",",".")}}&nbsp;&nbsp;&nbsp;</td>
		@endif

		</tr>
		@endforeach
	</tbody>
</table>
<table border="1" style="border-collapse: collapse; border-top: none;border-bottom: none;">
	<td width="900">
		<div style="float: right; margin-right: 10px;">Total : {{"Rp " . number_format($total_harga,2,",",".")}}</div>
	</td>
</table>
<table border="1" style="border-collapse: collapse;">
	<td width="900">
		<div>Terbilang : {{$terbilang}}</div>
	</td>
</table>
<table border="1" style="border-collapse: collapse; margin-top: 5px;">
	<tr align="center" style="font-size: 18px;">
		<td width="222">
			penerima :
		</td>
		<td width="222">
			Dikeluarkan Oleh :
		</td>
		<td width="222">
			Disetujui Oleh :
		</td>
		<td width="225">
			Mengetahui Keu. Pusat :
		</td>
	</tr>
	<tr>
		<td height="100">
			
		</td>
		<td >
			
		</td>
		<td >
			
		</td>
		<td >
		
		</td>
	</tr>
</table>
</div>