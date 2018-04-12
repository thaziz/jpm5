
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
              <th align="center" hidden=""> No</th>
              <th align="center"> Jenis</th>
              <th align="center"> Tipe </th>
              <th align="center"> Keterangan </th>
              <th align="center"> Harga </th>
          </tr>        
          </thead>        
          <tbody>
            @foreach($dat1 as $index => $val)
            <tr>
              <td>{{ $index+1 }}</td>
              <td hidden><input type="hidden" name="" value="{{ $dat1[$index][0]->id }}"></td>
              <td align="center">{{$dat1[$index][0]->jenis}}</td>
              <td align="center">{{$dat1[$index][0]->tipe_kiriman}}</td>
              <td align="center">{{$dat1[$index][0]->keterangan}}</td>
              <td align="right">{{"Rp " . number_format($dat1[$index][0]->harga,2,",",".")}}</td>
            </tr>
            @endforeach
          </tbody>      
        </table>



</div>
<script type="text/javascript">
    window.print();
</script>
