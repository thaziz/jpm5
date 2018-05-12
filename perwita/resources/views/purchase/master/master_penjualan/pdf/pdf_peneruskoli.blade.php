
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
                        <th align="center"> Reguler 10kg </th>
                        <th align="center"> Express 10kg </th>
                        <th align="center"> Reguler 20kg</th>
                        <th align="center"> Express 20kg</th>
                        <th align="center"> Reguler 30kg</th>
                        <th align="center"> Express 30kg</th>
                        <th align="center"> Reguler > 30kg</th>
                        <th align="center"> Express > 30kg</th>
                    </tr>        
                    </thead>        
                    <tbody>
                      @foreach($dat1 as $index => $val)
                      <tr> 
                        <td>{{ $index+1 }}</td>
                        <td><input type="hidden" name="" value="{{$dat1[$index][0]->id_tarif_koli}}">{{$dat1[$index][0]->id_tarif_koli}}</td>
                        <td>{{$dat1[$index][0]->prov}}</td>
                        <td>{{$dat1[$index][0]->kot}}</td>
                        <td align="center">{{$dat1[$index][0]->kec}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h1,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h2,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h3,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h4,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h5,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h6,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h7,0,",",".")}}</td>
                        <td align="right">{{"Rp " . number_format($dat1[$index][0]->h8,0,",",".")}}</td>
                      </tr>
                      @endforeach
                    </tbody>       
                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
