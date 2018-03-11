<table class="scroll table table-bordered tbl_isi_akun" id="table_data">
  <thead>
    <tr>
      <th width="10%" class="text-center">No</th>
      <th class="text-center">Nama Akun</th>
      <th class="text-center">Value</th>
      <th width="10%" class="text-center">D/K</th>
    </tr>
  </thead>
  <tbody>
  		<?php $no = 1; ?>
  		@foreach($detail as $dataDetail)
			<tr>
		        <td class="text-center">{{ $no }}</td>
		        <td class="text-center">{{ $dataDetail->akun->nama_akun }}</td>
		        <td class="text-right">{{ number_format($dataDetail->jrdt_value,2,'.',',') }}</td>
		        <td class="text-center">{{ $dataDetail->jrdt_statusdk }}</td>
		    </tr>

		    <?php $no++; ?>
  		@endforeach
  </tbody>
  </th>
</table>