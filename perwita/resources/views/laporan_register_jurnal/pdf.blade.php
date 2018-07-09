<style>

	@page { margin: 10px; }
	body { margin: 10px; }

	.table_neraca td{
      font-weight: 400;
      padding: 7px;
      border-top:1px dotted #efefef;
    }

    .table_neraca td.money{
      text-align: right;
    }

    .table_neraca th{
      font-weight: 600;
      text-align: center;
      padding: 5px;
      border:1px solid #efefef;
    }

    .page_break { page-break-before: always; }

    .page-number:after { content: counter(page); }

</style>

<table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
	<thead>
		<tr>
			<th style="text-align: left;">Laporan Register Jurnal {{ ucfirst($request->jenis) }}</th>
			<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
		</tr>
	</thead>
</table>

<table width="100%" border="0" style="font-size: 8pt;">
	<thead>
		<tr>
			<td style="text-align: left;">Periode : Bulan {{ $request->tanggal }} s/d {{ $request->sampai }}</td>
			<td style="text-align: right;"></td>
		</tr>
	</thead>
</table>