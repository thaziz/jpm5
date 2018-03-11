<table id="tableItem" class="table table-bordered table-hover" cellspacing="10">
	<thead>
		<tr>
			<th>Seq</th>
			<th>Kode Item</th>
			<th>Nama Item</th>
			<th>Keterangan</th>
			<th>Quantity</th>
			<th>Satuan</th>
			<th>Harga <strong style="font-weight: bolder;">/ITEM</strong></th>
			<th>Jumlah Item</th>
			<th>Aksi</th>
		</tr> <!-- head -->
	</thead>
	<tbody>
		@for ($i = 0; $i < count($DO); $i++)
		<tr>
			<td>{{ $i + 1 }}</td>
			<td>{{ $DO[$i]->kode_item }}</td>
			<td>{{ $DO[$i]->nama }}</td>
			<td>{{ $DO[$i]->keterangan }}</td>
			<td></td>
			<td>{{ $DO[$i]->satuan }}</td>
			<td>{{ $DO[$i]->harga }}</td>
			<td>{{ $DO[$i]->jumlah }}</td>
			<td>
				<div class="btn-group">
				<a href="" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit">
					<i class="fa fa-print"></i>
				</a>
						                                        							
				<a onclick="editForm({{ $DO[$i]->id }})" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit">
					<i class="fa fa-pencil"></i>
				</a>
						                                        							
				<a onclick="deleteData({{ $DO[$i]->id }})" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus">
					<i class="fa fa-times"></i>
				</a>
				</div>
			</td>
		</tr>
		@endfor
	</tbody>
</table>