
<style>
	.pembungkus{
		width: 100%;
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
                     	<th align="center"> No.</th>
                        <th align="center" height="35px"> Kota Asal</th>
                        <th align="center"> Kota Tujuan</th>
                        <th style="display: none;">kode</th>
                        <th align="center"> jenis </th>
                        <th align="center"> Akun Penjualan </th>
                        <th align="center"> Tarif</th>
                    </tr>        
                    </thead>        
                    <tbody>
                      @foreach($data2 as $index => $val)
                      <tr style="font-size: 12px">
                        <td >{{$index+1}}</td>
                        <td>{{$val->asal}}</td>
                        <td>{{$val->tujuan}}</td>
                        <td style="display: none;">{{$val->kode}}</td>
                        <td align="center">{{$val->jenis}}</td>
                        <td align="center">{{$val->acc_penjualan}}</td>
                        <td>{{"Rp " . number_format($val->harga,2,",",".")}}</td>
                      </tr>
                      @endforeach
                    </tbody>       
                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
