<table class="scroll table table-bordered tbl_isi_akun" id="table_data">
  <thead>
    <tr>
      <th class="text-center">Nama Akun</th>
      <th class="text-center">Debet</th>
      <th class="text-center">Kredit</th>
    </tr>
  </thead>
  <tbody>
  		<?php $no = 1; $totDeb = $totKred = 0; ?>
  		@foreach($detail as $dataDetail)
			<tr>
		        <td class="text-left">{{ $dataDetail->akun->nama_akun }}</td>

            @if($dataDetail->jrdt_statusdk == "D")
              <td class="text-right">{{ str_replace('-', '', number_format($dataDetail->jrdt_value,2,'.',',')) }}</td>
              <td class="text-right">{{ str_replace('-', '', number_format(0,2,'.',',')) }}</td>
              <?php $totDeb += str_replace('-', '', $dataDetail->jrdt_value) ?>
            @else
              <td class="text-right">{{ str_replace('-', '', number_format(0,2,'.',',')) }}</td>
              <td class="text-right">{{ str_replace('-', '', number_format($dataDetail->jrdt_value,2,'.',',')) }}</td>
              <?php $totKred += str_replace('-', '', $dataDetail->jrdt_value) ?>
            @endif

		    </tr>

		    <?php $no++; ?>
  		@endforeach
  </tbody>

  <tfoot>
      <tr>
            <td class="text-center" style="background: #efefef; font-weight: bold;">Total</td>
            <td class="text-right" style="background: #efefef; font-weight: bold;">{{ str_replace('-', '', number_format($totDeb,2,'.',',')) }}</td>
            <td class="text-right" style="background: #efefef; font-weight: bold;">{{ str_replace('-', '', number_format($totKred,2,'.',',')) }}</td>
        </tr>
  </tfoot>
  </th>
</table>