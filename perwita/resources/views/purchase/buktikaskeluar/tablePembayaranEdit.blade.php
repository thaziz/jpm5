<table style="width: 95%; margin: auto;" class="table table-bordered table-striped table-hover table_pembayaran">
	<thead>
		 	<th>No Trans</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>No Faktur</th>
	</thead>
	<tbody>
		@foreach($bkk as $i => $val)
		<tr >
			<td>
				{{$val->nota}}
				@if($val->id == $bkkd_id && $val->faktur == $nota)
				<input type="hidden" class="bkkd_id_detail" value="hore">
				@endif
			</td>
			<td>{{$val->tgl}}</td>
			<td class="total_faktur">{{$val->total}}</td>
			<td>{{$val->faktur}}</td>
		</tr>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	
	var table_pembayaran = $('.table_pembayaran').DataTable({
					  'paging':false,
                      'searching':false
	});
	$(document).ready(function(){
	$('.total_faktur').val("{{'Rp ' .number_format($total_biaya_faktur,2,",",".")}}");
	$('.faktur_ini').val("{{$par}}");
	$('.bayar_faktur').val("{{'Rp ' .number_format($pembayaran,2,",",".")}}");
	$('.sisa_bayar_faktur').val("{{'Rp ' .number_format($sisa_terbayar,2,",",".")}}");

	});


</script>