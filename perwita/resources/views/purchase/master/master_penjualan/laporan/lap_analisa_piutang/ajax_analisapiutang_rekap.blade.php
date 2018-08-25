<table id="addColumn" class="table table-bordered table-striped tbl-item">
  <thead>
     <tr>
        <th align="center"> Invoice</th>
        <th align="center"> Customer</th>
        <th align="center"> Tanggal</th>
        <th align="center"> Jatuh Tempo</th>
        <th align="center"> Saldo Awal</th>
        <th align="center"> Terbayar</th>
        <th align="center"> Sisa Saldo</th>
        <th align="center"> Umur</th>
        <th align="center"> Belum jatuh tempo </th>
        <th align="center"> Umur 0 s/d 30 </th>
        <th align="center"> Umur 31 s/d 60 </th>
        <th align="center"> Umur 61 s/d 90 </th>
        <th align="center"> Umur 91 s/d 120 </th>
        <th align="center"> Umur 121 s/d 180 </th>
        <th align="center"> Umur 181 s/d 360 </th>
        <th align="center"> Lebih dari 360 </th>
    </tr> 
         
  </thead>        
  <tbody>
    @foreach ($invoice as $i=>$data)
      <tr>
        <td>{{ $data->i_nomor }}</td>
        <td>{{ $data->i_kode_customer }}</td>
        <td>{{ $data->i_tanggal }}</td>
        @if ($data->i_jatuh_tempo_tt != null)
          <td>{{ $data->i_jatuh_tempo_tt }}</td>
        @else
          <td>{{ $data->i_jatuh_tempo }}</td>
        @endif
        <td>{{ number_format($data->i_total_tagihan, 2, ",", ".") }}</td>
        <td>{{ number_format($data->i_total_tagihan-$data->i_sisa_akhir, 2, ",", ".") }}</td>
        <td>{{ number_format($data->i_sisa_akhir, 2, ",", ".") }}</td>
        <td>{{ $umur[$i] }} </td>
        <td>{{ number_format($invoice_0[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_0_30[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_31_60[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_61_90[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_91_120[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_121_180[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_181_360[$i],2,",",".") }}</td>
        <td>{{ number_format($invoice_360[$i],2,",",".") }}</td>
      </tr>
    @endforeach
  </tbody>  
  <tfoot>
      <tr>
        <td colspan="3"><b>Total :</b></td>
        <td><b>{{ number_format($total_invoice,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_terbayar,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_sisa_saldo,2,",",".") }}</b></td>
        <td><b>{{ $total_umur }}</b></td>
        <td><b>{{ number_format($total_invoice_0,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_0_30,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_31_60,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_61_90,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_91_120,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_121_180,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_181_360,2,",",".") }}</b></td>
        <td><b>{{ number_format($total_invoice_360,2,",",".") }}</b></td>
      </tr>
  </tfoot>
</table>


<script type="text/javascript">
  $(document).ready(function(){

  })
</script>