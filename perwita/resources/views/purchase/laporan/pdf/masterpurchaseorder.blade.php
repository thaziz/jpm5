<style>
	.pembungkus{
		width: 100%;
	}
	table {
    border-collapse: collapse;
	}
	table,th,td{
	border :1px solid black;
	}
	/*.header{
    border-collapse: collapse;
	border :1px solid black;
	font-size: 16;
	font-weight: bold;
	width: 35%;
	height:30px;
	}*/
	.page-break	{
		page-break-after: always;
	}

</style>

<div class=" pembungkus">
	{{-- <div class="header" style="margin-bottom: 20px">
		<table width="100%">
			<tr><td>Laporan Faktur Pembelian</td></tr>
		</table>
	</div> --}}
					<table width="100%" style="height: 50px; padding: 0;" border="1">
									<tr align="center">
										<th height="40px;" >No.</th>
										 <th style="width:10px"> Perusahaan Pemohon </th>
					                        <th> No.po </th>
					                        <th> Tanggal Dibutuhkan </th>
					                        <th> Status </th>
					                        <th> Catatan</th>
									</tr>
								   @foreach ($data2 as $index => $data)
				                    <tr style="font-size: 14px;">
				                       <td style="width: 5%; text-align: center"> <input class="br"  type="hidden" name="pemohon[]" value="{{$data->po_id}}">{{$index+1}}</td>
                    <td>
                      <input class="br"  type="hidden" name="pemohon[]" value="{{$data->nama}}">{{ $data->nama }}</td>
                    <td>

                      <input class="br" type="hidden" name="spp[]" value="{{$data->po_no}}">{{$data->po_no}}</td>
                    <td>

                      <input class="br"  type="hidden" name="butuh[]" value="{{$data->spp_tgldibutuhkan}}">{{$data->spp_tgldibutuhkan}}</td>
                    
                    {{-- <td hidden="">{{$data->created_at}}</td> --}}
                    <td>
                      <input class="br"  type="hidden" name="status[]" value="{{$data->spp_status}}">
                      {{$data->spp_status}}
                    </td>   
                    <td>
                      <input class="br"  type="hidden" name="status[]" value="{{$data->po_catatan}}">
                      {{$data->po_catatan}}
                    </td>   
				                    </tr>
				                   @endforeach
								</table>
								<div class="page-break"></div>
								<table>
									<tr>
										<td>hgjgj</td>
									</tr>
								</table>
</div>
