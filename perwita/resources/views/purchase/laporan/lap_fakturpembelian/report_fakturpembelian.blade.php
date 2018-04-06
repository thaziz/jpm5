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

	.page-break	{
		page-break-after: always;
	}

</style>

<div class=" pembungkus">
	<table id="addColumn" class="table table_header table-bordered table-striped"> 
                    <thead>
                    <tr>
                        <th style="width:10px;">No.</th>
                        <th> No Faktur </th>
                        <th> Tanggal </th>
                        <th> Discount </th>
                        <th> D P P </th>
                        <th> PPn </th>
                        <th> Pajak </th>
                        <th> Netto </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($dat1 as $index => $element)
                      <tr>
                        <td>{{ $index+1 }} </td>
                        <td><input type="hidden" name="" value="{{ $dat1[$index][0]->fp_nofaktur }}">{{ $dat1[$index][0]->fp_nofaktur }}</td>
                        <td>{{ $dat1[$index][0]->fp_tgl }}</td>
                        <td style="text-align: right">{{ $dat1[$index][0]->fp_discount }} </td>
                        <td style="text-align: right">{{ $dat1[$index][0]->fp_dpp }} </td>
                        <td style="text-align: right">{{ $dat1[$index][0]->fp_ppn }} </td>
                        <td style="text-align: right">{{ $dat1[$index][0]->fp_fakturpajak }} </td>
                        <td style="text-align: right">{{ $dat1[$index][0]->fp_netto }} </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
</div>
