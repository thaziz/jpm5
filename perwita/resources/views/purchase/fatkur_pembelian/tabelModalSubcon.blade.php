<table class="table table-bordered table-striped table-hover tb_modal">
	<thead>
		<th>No.Subcon</th>
		<th>Asal</th>
		<th>Tujuan</th>
		<th>Angkutan</th>
		<th>Harga</th>
		<th>Jenis Tarif</th>
	</thead>
	<tbody>
	@if(isset($fix))
	  @foreach( $fix as $val )
	  <tr style="cursor: pointer;" onclick="pilih_kontrak(this)">
		<td style="width: 20px; text-align: center;">
			{{$val['ksd_nota']}}
			<input type="hidden" class="id_kontrak" value="{{$val['ksd_id']}}">
		</td>
		<td><p class="ksd_asal">{{$val['ksd_asal']}}</p></td>
		<td><p class="ksd_tujuan">{{$val['ksd_tujuan']}}</p></td>
		<td><p class="ksd_angkutan">{{$val['ksd_angkutan']}}</p></td>
		<td><p class="ksd_harga">{{number_format($val['ksd_harga'])}}</p></td>
		<td><p class="ksd_jenis_tarif">{{$val['ksd_jenis_tarif']}}</p></td>
	  </tr>
	  @endforeach
	  @endif
	</tbody>
</table>

<script type="text/javascript">
	$('.tb_modal').DataTable();
</script>