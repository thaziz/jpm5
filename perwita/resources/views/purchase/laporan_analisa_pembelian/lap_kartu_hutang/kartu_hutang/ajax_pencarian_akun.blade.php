{{-- @include('partials._scripts') --}}
<table class="table table-striped table-bordered">
  <tr>
    <th>No.</th>
    <th>Tanggal</th>
    <th>No bukti</th>
    <th>debet</th>
    <th>kredit</th>
    <th>saldo</th>
  </tr>
   @foreach ($data['carisupp'] as $index => $element)
     <tr>
       <td colspan="5">Supplier : [{{ $data['carisupp'][$index]['supplier'][0]->kode }}]</td>
       <td  align="right" class="saldo">{{ $data['saldoawal'][$index] }}</td>
     </tr>
      @foreach($data['kartuhutang'] as $index1 => $element1)
        @foreach($data['kartuhutang'][$index1] as $index2 => $element2)
          @if ($data['kartuhutang'][$index1][$index2]->supplier == $data['carisupp'][$index]['supplier'][0]->kode)
              <tr>
               <td>2</td>
               <td>{{ $data['kartuhutang'][$index][$index2]->tgl }}</td>
               <td>{{ $data['kartuhutang'][$index][$index2]->nota }}</td>
               @if ($data['kartuhutang'][$index][$index2]->flag == 'D')
                 <td class="debet">{{ $data['kartuhutang'][$index][$index2]->nominal }}</td>
                 <td>0</td>
               @else
                 <td>0</td>
                 <td class="kredit">{{ $data['kartuhutang'][$index][$index2]->nominal }}</td>
               @endif
              </tr>
          @endif
        @endforeach
      @endforeach
      <tr>
        <td colspan="3">Grand Total :</td>
        <td>{{ $data['totalhutangdebit'][$index] }}</td>
        <td>{{ $data['totalhutangkredit'][$index] }}</td>
        <td>1</td>
      </tr>
   @endforeach
</table>














{{-- 
<table>

  <tr>
   @foreach ($data['data'] as $index => $element)
     <tr>
       <td>{{ $index+1 }}</td>
       <td>{{ $element->tgl }}</td>
       <td>{{ $element->nota }}</td>
       @if ($element->keterangan == null)
          <td>{{ $element->keterangan }}</td>
       @else
          <td>{{ $element->keterangan }}</td>
       @endif
       
       @if ($element->flag == 'D')
          <td>{{ $element->debet }}</td>
          <td>0</td>
       @else
          <td>0</td>
          <td>{{ $element->kredit }}</td>
       @endif
       
       <td>{{ $element->flag }}</td>
     </tr>
   @endforeach
  </tr>
</table>

 --}}