<table class="table table_resi table-bordered resi_body">
 {{ csrf_field() }}
@if($tipe_data == 'CREATE')
<div class="asd" hidden="">
<a style="margin-left: 5px;" class="btn btn-info pull-right reload fa fa-refresh" onclick="reload()" >&nbsp;Reload</a>
<a class="fa asw fa-print btn btn-danger pull-right" align="center"  onclick="buktikas()"  title="print" > Bukti Kas</a>
<a class="fa asw fa-print btn btn-warning pull-right" align="center"  onclick="detailkas()" title="print" > Detail</a>
</div>
@else
<a class="fa asw fa-print btn btn-danger pull-right" align="center" title="print" onclick="buktikas()"> Bukti Kas</a>
<a class="fa asw fa-print btn btn-warning pull-right" align="center"  title="print" onclick="detailkas()" > Detail</a>

@endif

<a class="fa asw fa-save btn btn-primary pull-right" align="center"  title="print" onclick="save_data()"> Process</a>

<thead>
 <tr>
   <th>No. Resi</th>
   <th>Tanggal</th>
   <th>Pengirim</th>
   <th>Penerima</th>
   <th>Kota Asal</th>
   <th>Kota Tujuan</th>
   <th>Status</th>
   <th>Tarif</th>
   <th>Penerus</th>
  </tr> 
</thead>			  
<tbody>
	@foreach($data as $index => $val)
  <tr>
	<td>
		<input type="hidden" name="no_resi[]" value="{{$data[$index][0]->nomor}}">
		{{$data[$index][0]->nomor}}
	</td>
	<td>
		<input type="hidden" name="tanggal[]" value="{{$data[$index][0]->tanggal}}">
		{{$data[$index][0]->tanggal}}
	</td>
    <td>
    	<input type="hidden" name="pengirim[]" value="{{$data[$index][0]->nama_pengirim}}">
    	{{$data[$index][0]->nama_pengirim}}
    </td>
    <td>
    	<input type="hidden" name="penerima[]" value="{{$data[$index][0]->nama_penerima}}">
    	{{$data[$index][0]->nama_penerima}}
    </td>
    <td>
    	<input type="hidden" name="asal[]" value="{{$data[$index][0]->id}}">
    	{{$data[$index][0]->nama}}
    </td>
    <td>
    	<input type="hidden" name="tujuan[]" value="{{$tujuan[$index][0]->id}}">
    	{{$tujuan[$index][0]->nama}}
    </td>
    <td>
    	<input type="hidden" name="status[]" value="{{$data[$index][0]->status}}">
    	{{$data[$index][0]->status}}
    </td>
    <td>
    	<input type="hidden" name="tarif[]" value="{{$data[$index][0]->tarif_dasar}}">
    	<input type="hidden" name="total_tarif" value="{{$total_tarif}}">
    	{{$data[$index][0]->tarif_dasar}}
    </td>
    <td>
    	<input type="hidden" name="penerus[]" value="{{$penerus[$index]}}">
    	<input type="hidden" name="total_penerus" value="{{$total_penerus}}">
    	<input type="hidden" name="comp[]" value="{{$data[$index][0]->kode_cabang}}">
    	{{$penerus[$index]}}
    </td>
  </tr>
  @endforeach
</tbody>
</table>  

<script type="text/javascript">
var datatable;

datatable = $('.table_resi').DataTable({
            responsive: true,
            searching: false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
})

</script>
