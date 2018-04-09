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
	width: 30%;
	height:30px;
	}
</style>

<div class=" pembungkus">
			<table width="100%" {{-- style="height: 50px; padding: 0;" --}} border="1">
				<thead> 
                      <th  style="text-align: center"> No.</th>                      
                      <th  style="text-align: center"> kode.</th>                      
                      <th  style="text-align: center"> nopol</th>
                      <th  style="text-align: center"> Divisi </th>
                      <th  style="text-align: center"> Status </th>
                      <th  style="text-align: center"> vdrcde </th>
                      <th  style="text-align: center"> vdrnme </th>
                      <th  style="text-align: center"> Kode</th>
                      <th  style="text-align: center"> Merk </th>
                      <th  style="text-align: center"> Tipe Angkutan </th>
                      <th  style="text-align: center"> No Rangka </th>
                      <th  style="text-align: center"> No mesin </th>
                      <th  style="text-align: center"> jenis_bak </th>
                      <th  style="text-align: center"> P , L , T , Volume</th>
                      <th  style="text-align: center"> Tahun </th>
                      <th  style="text-align: center"> seri unit </th>
                      <th  style="text-align: center"> warna kabin </th>
                      <th  style="text-align: center"> No. Bpbk </th>
                      <th  style="text-align: center"> tgl Bpkb </th>
                      <th  style="text-align: center"> No. Kir </th>
                      <th  style="text-align: center"> Tgl kir </th>
                      <th  style="text-align: center"> Tgl Pajak </th>
                      <th  style="text-align: center"> Tgl Stnk </th>
                      <th  style="text-align: center"> Gps </th>
                      <th  style="text-align: center"> Posisi Bpkb </th>
                      <th  style="text-align: center"> Ket Bpkb </th>
                      <th  style="text-align: center"> Asuransi </th>
                      <th  style="text-align: center"> Harga Perolehan </th>
                      <th  style="text-align: center"> Tgl Perolehan </th>
                      <th  style="text-align: center"> Keterangan </th>
                      <th  style="text-align: center"> tgl pjk tahunan </th>
                      <th  style="text-align: center"> tgl pjk 5 thn </th>
                      <th  style="text-align: center"> Kode Subcon </th>
                </tdead>
                <tbody>
                    @foreach ($dat1 as $index => $e)
                    <tr>
                      <td style="text-align: center"> {{ $index+1 }} </td>                      
                      <td style="text-align: center"> {{ $dat1[$index][0]->id }}</td>                      
                      <td style="text-align: center"> {{ $dat1[$index][0]->nopol }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->divisi }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->status }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->vdrcde }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->vdrnme }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->kode }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->merk }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tipe_angkutan }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->no_rangka }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->no_mesin }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->jenis_bak }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->p }} , {{ $dat1[$index][0]->l }} , {{ $dat1[$index][0]->t }} , {{ $dat1[$index][0]->volume }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tahun }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->seri_unit }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->warna_kabin }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->no_bpkb }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_bpkb }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->no_kir }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_kir }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_pajak }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_stnk }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->gps }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->posisi_bpkb }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->ket_bpkb }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->asuransi }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->harga }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_perolehan }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->keterangan }} </td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_pajak_tahunan }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->tgl_pajak_5_tahunan }}</td>
                      <td style="text-align: center"> {{ $dat1[$index][0]->kode_subcon }}</td>
                    </tr>
                    @endforeach
                    </tbody>
			</table>
</div>
