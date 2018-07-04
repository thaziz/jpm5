<table>
  <tr>
    <th>No.</th>
    <th>Tanggal</th>
    <th>No bukti</th>
    <th>Keterangan</th>
    <th>debet</th>
    <th>kredit</th>
    <th>saldo</th>
  </tr>
   @foreach ($data['carisupp'] as $index => $element)
     <tr>
       <td>{{ $data['carisupp'][$index][0]->idsup }}</td>
     </tr>
     @if ($data['carisupp'][$index][0]->idsup == $data['kartuhutang'][$index][0]->supplier )
       
       @foreach ($data['saldoawal'] as $a => $element)
         <tr>
            <td>{{ $a+1 }}</td>
            <td>{{ $data['saldoawal'][$a] }}</td>
        </tr>
       @endforeach
        
        
       @foreach ($data['kartuhutang'] as $i => $element)
        <tr>
          
         <td>{{ $i+2 }}</td>
         <td>{{ $data['kartuhutang'][$i][0]->flag }}</td>
         <td>{{ $data['kartuhutang'][$i][0]->nota }}</td>
         <td>{{ $data['kartuhutang'][$i][0]->keterangan }}</td>
         @if ($data['kartuhutang'][$i][0]->flag == 'D')
           <td>{{ $data['kartuhutang'][$i][0]->nominal }}</td>
           <td>0</td>
         @else
           <td>0</td>
           <td>{{ $data['kartuhutang'][$i][0]->nominal }}</td>
         @endif

         
        </tr>
       @endforeach
     @endif
     
   @endforeach
</table>