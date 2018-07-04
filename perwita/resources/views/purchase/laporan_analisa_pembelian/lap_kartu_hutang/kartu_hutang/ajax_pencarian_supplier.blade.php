{{-- @include('partials._scripts') --}}

<table>
   @foreach ($data['carisupp'] as $index => $element)
     <tr>
       <td colspan="7" >Supplier : [{{ $data['carisupp'][$index][0]->no_supplier }}] {{ $data['carisupp'][$index][0]->nama_supplier }} </td>
     </tr>
         <tr>
            <td></td>
            <td>{{ $date }}</td>
            <td>Saldo Awal</td>
            <td colspan="4" align="right" >
            <input type="hidden" value="{{ $data['saldoawal'][$index] }}" name="" class="saldo saldo_{{ $index }}">
            {{ number_format($data['saldoawal'][$index],0,'.','.') }}</td>
        </tr>
      @foreach($data['kartuhutang'] as $index1 => $element1)
        @foreach($data['kartuhutang'][$index1] as $index2 => $element2)
          @if ($data['kartuhutang'][$index1][$index2]->supplier == $data['carisupp'][$index][0]->idsup)
              <tr>
               <td></td>
               <td>{{ $data['kartuhutang'][$index][$index2]->tgl }}</td>
               <td>{{ $data['kartuhutang'][$index][$index2]->nota }}</td>
               <td>{{ $data['kartuhutang'][$index][$index2]->keterangan }}</td>
               @if ($data['kartuhutang'][$index][$index2]->flag == 'D')
                <td align="right">
                  <input type="hidden" value="{{ $data['kartuhutang'][$index][$index2]->nominal }}" name="" class="debet debet_{{ $index }}">
                  {{ number_format($data['kartuhutang'][$index][$index2]->nominal,0,'.','.') }}
                </td>
                <td align="right">
                   <input type="hidden" value="0" name="" class="kredit kredit_{{ $index }}">
                   0
                </td>
               @else
                 <td align="right">
                  <input type="hidden" value="0" name="" class="debet debet_{{ $index }}">
                  0
                 </td>
                 <td align="right">
                  <input type="hidden" value="{{ $data['kartuhutang'][$index][$index2]->nominal }}" name="" class="kredit kredit_{{ $index }}">
                  {{ number_format($data['kartuhutang'][$index][$index2]->nominal,0,'.','.') }}
                </td>
               @endif
              
                <td class="total" align="right"></td>
              </tr>
          @endif
        @endforeach
      @endforeach
      <tr>
        <td colspan="4">Grand Total :</td>
        <td align="right">{{ number_format($data['totalhutangdebit'][$index],0,'.','.') }}</td>
        <td align="right">{{ number_format($data['totalhutangkredit'][$index],0,'.','.') }}</td>
        <td align="right" class="grand grand_{{ $index }}"></td>
      </tr>
   @endforeach
</table>
