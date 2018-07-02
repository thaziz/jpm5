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