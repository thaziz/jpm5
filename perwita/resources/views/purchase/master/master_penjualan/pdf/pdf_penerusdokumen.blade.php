
<style>
	.pembungkus{
		width: 1000px;
	}
	table {
    border-collapse: collapse;
}
	table,th,td{
		border :1px solid black;
	}
</style>

<div class=" pembungkus">
{{--   @if ()
    expr
  @endif --}}
				 <table id="addColumn" width="100%" class="table table-bordered table-striped tbl-item">
          <thead>
           <tr>
              <th align="center"> No</th>
              <th align="center"> Kode</th>
              <th align="center"> Provinsin Tujuan</th>
              <th align="center"> Kota Tujuan</th>
              <th align="center"> Kecamatan Tujuan</th>
              <th align="center"> Reguler </th>
              <th align="center"> Express </th>
              <th align="center"> Type </th>
          </tr>        
          </thead>        
          <tbody>
            @foreach($dat1 as $index => $val)
            <tr> 
              <td>{{ $index+1 }}</td>
              <td><input type="hidden" name="" value="{{$dat1[$index][0]->id_tarif_dokumen}}">{{$dat1[$index][0]->id_tarif_dokumen}}</td>
              <td>{{$dat1[$index][0]->asal}}</td>
              <td>{{$dat1[$index][0]->tujuan}}</td>
              <td align="center">{{$dat1[$index][0]->kecamatan}}</td>
              <td align="right">{{"Rp " . number_format($dat1[$index][0]->harga_reg,2,",",".")}}</td>
              <td align="right">{{"Rp " . number_format($dat1[$index][0]->harga_ex,2,",",".")}}</td>
              <td align="center">{{$dat1[$index][0]->type}}</td>
            </tr>
            @endforeach
          </tbody>          
        </table>



</div>
<script type="text/javascript">
    window.print();
</script>
