<style>
	.pembungkus{
		width: 900px;
	}
	table {
    border-collapse: collapse;
	}
	table,th,td{
	border :1px solid black;
	}
	.header{
    border-collapse: collapse;
	border :1px solid black;
	font-size: 16;
	font-weight: bold;
	width: 25%;
	height:30px;
	}
</style>

<div class=" pembungkus">
					<table width="100%" style="height: 50px; padding: 0;" border="1">
					<thead>
                     <tr>
                        <th> No </th>
                        <th hidden=""> No </th>
                        <th> Kode</th>
                        <th> Tanggal </th>
                        <th> Supplier </th>
                        <th> lain lain</th>
                        <th> Tanggal Kembali </th>
                        <th> Total Terima </th>
                        <th> Kwitansi </th>
                        <th> Surat Peran </th>
                        <th> Surat Jalan Asli </th>
                        <th> No fp </th>
                        <th> Agen  </th>
                        <th> Faktur </th>
                    </tr>        
                    </thead>        
                    <tbody>
                    @foreach($dat1 as $index=>$data)
                      <tr>
                        <td>{{ $index+1 }}</td>
                        <td hidden=""><input type="hidden" name="" value="{{ $dat1[$index][0]->tt_idform }}"></td>
                        <td>{{ $dat1[$index][0]->tt_noform }}</td>
                        <td>{{ $dat1[$index][0]->tt_tgl }}</td>
                        <td>{{ $dat1[$index][0]->tt_idsupplier }}</td>
                        <td>{{ $dat1[$index][0]->tt_lainlain }}</td>
                        <td>{{ $dat1[$index][0]->tt_tglkembali }}</td>
                        <td>{{ $dat1[$index][0]->tt_totalterima }}</td> 
                        <td>{{ $dat1[$index][0]->tt_kwitansi }}</td>
                        <td>{{ $dat1[$index][0]->tt_suratperan }}</td>
                        <td>{{ $dat1[$index][0]->tt_suratjalanasli }}</td>
                        <td>{{ $dat1[$index][0]->tt_nofp }}</td>
                        <td>{{ $dat1[$index][0]->tt_idagen }}</td>
                        <td>{{ $dat1[$index][0]->tt_faktur }}</td>
                      </tr>
                    @endforeach
                    </tbody> 
					</table>
</div>
