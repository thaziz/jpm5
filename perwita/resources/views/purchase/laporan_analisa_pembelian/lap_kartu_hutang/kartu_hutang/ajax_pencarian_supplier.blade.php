{{-- @include('partials._scripts') --}}

<table>
   @foreach ($data['carisupp'] as $index => $element)
     <tr>
       <td colspan="7" >Supplier : [{{ $data['carisupp'][$index][0]->no_supplier }}] {{ $data['carisupp'][$index][0]->nama_supplier }} </td>
     </tr>
         <tr>
            <td></td>
            <td>{{ $date }}</td>
            <td colspan="5" align="right" >
            <input type="hidden" value="{{ $data['saldoawal'][$index] }}" name="" class="saldo saldo_{{ $index }}">
            {{ $data['saldoawal'][$index] }}</td>
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
                <td>
                  <input type="hidden" value="{{ $data['kartuhutang'][$index][$index2]->nominal }}" name="" class="debet debet_{{ $index }}">
                  {{ $data['kartuhutang'][$index][$index2]->nominal }}
                </td>
                <td>
                   <input type="hidden" value="0" name="" class="kredit kredit_{{ $index }}">
                   0
                </td>
               @else
                 <td>
                  <input type="hidden" value="0" name="" class="debet debet_{{ $index }}">
                  0
                 </td>
                 <td>
                  <input type="hidden" value="{{ $data['kartuhutang'][$index][$index2]->nominal }}" name="" class="kredit kredit_{{ $index }}">
                  {{ $data['kartuhutang'][$index][$index2]->nominal }}
                </td>
               @endif
              
                <td class="total"></td>
              </tr>
          @endif
        @endforeach
      @endforeach
      <tr>
        <td colspan="4">Grand Total :</td>
        <td>{{ $data['totalhutangdebit'][$index] }}</td>
        <td>{{ $data['totalhutangkredit'][$index] }}</td>
        <td class="grand grand_{{ $index }}"></td>
      </tr>
   @endforeach
</table>
