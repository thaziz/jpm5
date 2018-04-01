
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
					<table id="addColumn" width="100%" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                      <th align="center"> No.</th>
                     	  <th align="center"> Kode.</th>
                        <th align="center" height="35px"> Kota Asal</th>
                        <th align="center"> Kota Tujuan</th>
                        <th align="center"> jenis </th>
                        <th align="center"> Waktu </th>
                        <th align="center"> Akun Penjualan </th>
                        <th align="center"> Csf Penjualan </th>
                        <th align="center"> Tarif</th>
                    </tr>        
                    </thead>        
                    <tbody>
                      @foreach($dat1  as $index=>$val)
                      <tr style="font-size: 12px">
                        <td>{{ $index }}</td>
                        <td>{{ $dat1[$index][0]->kode}}</td>  
                        <td>{{ $dat1[$index][0]->asal}}</td>
                        <td>{{ $dat1[$index][0]->tujuan}}</td>
                        <td>{{ $dat1[$index][0]->jenis}}</td>
                        <td>{{ $dat1[$index][0]->waktu}} (hari)</td>
                        <td>{{ $dat1[$index][0]->acc_pen}}</td>
                        <td>{{ $dat1[$index][0]->csf_pen}}</td>
                        <td>{{"Rp " . number_format($dat1[$index][0]->harga,2,",",".")}}</td>
                      </tr>
                      @endforeach
                    </tbody>       
                  </table>

</div>
