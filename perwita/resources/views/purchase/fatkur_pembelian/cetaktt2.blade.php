<div>
  <img style=" display: inline-block; " src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}" width="110">
  <div style="display: inline-block;">
  	<label><b>PT. JAWA PRATAMA MANDIRI</b></label>
  	<p style="margin:0 0 ;font-size: 12px;">JL. KARAH AGUNG NO. 45 SURABAYA</p>
  	<p style="margin:0 0;font-size: 12px;">Telp.031.8290606</p>
  	<p style="margin:0 0;font-size: 12px;">Email : </p> 
  </div>
  <div style="display: inline-block; float: right;">
  	<p style="margin:0 0 ;">No.TT&nbsp;&nbsp;&nbsp;: {{$data['tt'][0]->tt_noform}}&nbsp;</p>
  	<p style="margin:0 0;">Tanggal : 13-12-2017</p>
  </div>
  <div style="width: 250px; margin:0 auto; text-align: center;">
  	<h3 style="border-bottom: 1px solid;">TANDA TERIMA TAGIHAN</h3>
  </div>
  <div style="display: inline-block;">
  	<p style=" display: inline-block">Dari : </p>
  	<label style="border-bottom: 1px solid;">{{$data['tt'][0]->nama_supplier}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
  </div>
  <div style=" float: right;">
  	<p style=" display: inline-block">Alamat : </p>
  	<label  style="border-bottom: 1px solid;">{{$data['tt'][0]->alamat}}</label>
  </div>
  <div style="font-size: 14px">
  	<p style=" display: block; margin: 0 0">Telah kami terima berupa</p>
  	<div style="display: inline-block;">
  	<table style="font-size: 14px; margin-bottom: 10px;" >
  		<tr>
  			<td>1.</td>
  			<td>Kwitansi/Invoice/Nota</td>
  			<td width="20"></td>
  			<td align="center" style="border: 1px solid black">ADA</td>
  		</tr>
  		<tr>
  			<td>2.</td>
  			<td>Faktur Pajak</td>
  			<td width="20"></td>
  			<td align="center" style="border: 1px solid black">ADA</td>
  		</tr>
  		<tr>
  			<td>3.</td>
  			<td>Surat Peranan Asli</td>
  			<td width="20"></td>
  			<td align="center" style="border: 1px solid black">ADA</td>
  		</tr>
  		<tr>
  			<td>4.</td>
  			<td>Surat Jalan Asli</td>
  			<td width="20"></td>
  			<td align="center" style="border: 1px solid black">ADA</td>
  		</tr>
  	</table>
  </div>
  <div style="display: inline-block; float: right;">
  	5. Lain-lain sebutkan ________________<br>_________________________________

  </div>
</div>
<div style="width: 100%" >
	<table border="1" style="border-collapse: collapse; width: 100% ;font-size: 12px;">
  	<tr>
  		<td colspan="3" width="50" align="center">Nilai Penagihan</td>
  		<td colspan="3" rowspan="2" width="300" align="center">Keterangan</td>
  	</tr>
  	<tr align="center">
  		<td>Tgl. Nota</td>
  		<td>No. Nota</td>
  		<td>Rupiah</td>
  	</tr>
  	<tr  style="border-bottom: none;">
  		<td align="center"><?php echo date('d-m-Y',strtotime($data['tt'][0]->tt_tgl))?></td>
  		<td align="left">{{$data['tt'][0]->tt_noform}}</td>
  		<td align="right">{{"Rp " . number_format($data['tt'][0]->tt_totalterima,2,",",".")}}</td>
  		<td align="left">&nbsp;{{$data['tt'][0]->fp_keterangan}}</td>
  		
  	</tr>
  	<tr align="center" style="border-top: 0px;">
  		<td height="100"></td>	
  		<td height="100"></td>		
  		<td height="100"></td>
  		<td height="100" rowspan="2"></td>	
  	</tr>
  	<tr align="center" style="border-top: 0px;">
  		<td colspan="2">Total</td>	
  		<td align="right">{{"Rp " . number_format($data['tt'][0]->tt_totalterima,2,",",".")}}</td>	
  	</tr>
  	<tr>
  		<td colspan="6">
  			Harap Kembali:&nbsp;&nbsp;<label style="border-bottom: 1px solid black; margin-right: 70px">{{$data['tgl']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
  			Tanggal:&nbsp;&nbsp;<label style="border-bottom: 1px solid black;margin-right: 20px"><?php echo date('d-m-Y',strtotime($data['tt'][0]->tt_tglkembali))?></label>
  			Atau menghubungi dulu kantor kami melalui Telepon No.______________
  		</td>	
  	</tr>
  	<tr >
  		<td colspan="6" style="border-bottom: none;">
  			Terbilang : {{$data['terbilang']}} rupiah
  		</td>	
  	</tr>
  </table>
  <table border="1" style="border-collapse: collapse; width: 100%; font-size: 14px; ">
  	<tr align="center">
  		<td >
  			Hutang
  		</td>	
  		<td >
  			Akutansi
  		</td>	
  		<td colspan="4" width="213" rowspan="3" align="right">
  			Surabaya,.............................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
  			Diterima Oleh, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  			<br>
  			<br>
  			<br>
  			Tanda tangan & Nama terang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  		</td>
  	</tr>
  	<tr style="border-bottom: none;">
  		<td height="50"></td>
  		<td height="50"></td>
  	</tr>
  	<tr align="center" style="border-top: none;">
  		<td>Tanda Tangan</td>
  		<td>Tanda Tangan</td>
  	</tr>
  </table>
</div>
<script type="text/javascript">
// <!--
window.print();
//-->
</script>