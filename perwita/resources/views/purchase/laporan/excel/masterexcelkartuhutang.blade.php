<div class=" pembungkus">
  <table>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" ><h3> PT JAWA PRATAMA MANDIRI </h3></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">Laporan Register Rekap Kartu Hutang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">Menampilkan Tanggal {{ $awal }} - {{ $akir }}</td>
    </tr>
  </table>
                  
	<table id="addColumn" class="table table-bordered table-striped tbl-item" width="100%">
                    <thead>
                     <tr>
                        <th style="text-align:center;height: 30px;" width= '3%'> No  </th>
                        <th style="text-align:center" width="22%"> No Faktur  </th>
                        <th style="text-align:center" width="12%"> Tanggal  </th>
                        <th style="text-align:center" width="28%"> Keterangan  </th>
                        <th style="text-align:center" width="12%"> DPP  </th>
                        <th style="text-align:center" width="12%"> netto </th>
                        <th style="text-align:center" width="12%"> netto </th>
                    </tr>
                   
                    </thead>
                    <tbody>
                      @foreach ($data as $index => $a)               
                    <tr align="center">
                      <td> {{ $index+1 }}  </td>
                      <td> {{ $a->fp_nofaktur }}  </td>
                      <td> {{ $a->fp_tgl }} </td>
                      <td> {{ $a->fp_keterangan}} </td>
                      <td style="text-align: right"> {{ number_format($a->fp_dpp,0,',','.') }} </td>
                      <td style="text-align: right"> {{ number_format($a->fp_netto,0,',','.') }}</td>
                      <td style="text-align: right"> {{ number_format($a->fp_netto,0,',','.') }} </td>
                    </tr>
                     @endforeach
                     <tr style="border-top: none;">
                  		<td align="right" colspan="4">Total :</td>
                  		<td align="right">{{ number_format($debet,0,',','.') }}</td>
                  		<td align="right">{{ number_format($kredit,0,',','.') }}</td>
                  		<td align="right">{{ number_format($saldo,0,',','.') }}</td>
                  	</tr>
                    
                
                    </tbody>
                   
                  </table>
                  <table>
                
                  		
</div>
