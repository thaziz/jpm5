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
			<th style="text-align: left;">Laporan Buku Besar Dalam {{ ucfirst($throttle) }}</th>
			<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
		</tr>
	</thead>
</table>

<table width="100%" border="0" style="font-size: 8pt;">
	<thead>
		<tr>
			@if($throttle == "bulan")
				<td style="text-align: left;">Periode : Bulan {{ date_ind($request->m) }} {{ $request->y }}</td>
			@elseif($throttle == "tahun")
				<td style="text-align: left;">Periode : Tahun {{ $request->y }}</td>
			@endif

			<td style="text-align: right;"></td>
		</tr>
	</thead>
</table>

<?php $urt = 0; ?>

@foreach($time as $data_time)
 @foreach($data as $data_akun)
    <?php $mt = ($urt == 0) ? "m-t" : "m-t-lg"; $saldo = $saldo_awal[$data_time->time."/".$data_akun->akun]; ?>
     <table width="100%" border="0" style="font-size: 9pt; margin-top: 10px;">
		<thead>
			<tr>
				<td style="text-align: right; font-weight: 400; padding: 7px 20px 0px 0px; border-top: 1px solid #efefef;">Nama Perkiraan : {{ $data_akun->akun }} {{ $data_akun->main_name }}</td>
			</tr>
		</thead>
	</table>

	<table class="table_neraca tree" border="0" width="100%" style="font-size: 7.5pt; border-bottom: 2px solid #efefef; margin-bottom: 5px; margin-top: 5px;">
		<thead>
			<tr>
				<th width="10%">Tanggal</th>
		        <th width="14%">No.Bukti</th>
		        <th width="37%">Keterangan</th>
		        <th width="13%">Debet</th>
		        <th width="13%">Kredit</th>
		        <th width="13%">Saldo</th>
			</tr>
		</thead>

		<tbody>

			<tr>
              <td style="text-align: center;"></td>
              <td style="text-align: center;"></td>
              <td style="padding-left: 50px;">Saldo Awal</td>
              <td class="money"></td>
              <td class="money"></td>
              <td class="money">{{ number_format($saldo, 2) }}</td>
            </tr>

			@foreach($grap as $data_grap)
              @if($data_grap->acc == $data_akun->akun)

                <?php
                  if($throttle == "Bulan")
                    $cek = date("n-Y", strtotime($data_grap->jr_date)) == $data_time->time;
                  else
                    $cek = date("Y", strtotime($data_grap->jr_date)) == $data_time->time;
                ?>

                @if($data_grap->acc == $data_akun->akun && $cek)

                  <?php 
                    $debet = 0; $kredit = 0;

                    $saldo += $data_grap->jrdt_value;

                    if($data_grap->jrdt_statusdk == "D")
                      $debet = str_replace("-", "", $data_grap->jrdt_value);
                    else
                      $kredit = str_replace("-", "", $data_grap->jrdt_value);

                  ?>

                  <tr>
                    <td class="text-center">{{ date("d-m-Y", strtotime($data_grap->jr_date)) }}</td>
                    <td class="text-center">{{ $data_grap->jr_ref }}</td>
                    <td>{{ $data_grap->jr_note }}</td>
                    <td class="money">{{ number_format($debet, 2) }}</td>
                    <td class="money">{{ number_format($kredit, 2) }}</td>
                    <td class="money">{{ number_format($saldo, 2) }}</td>
                  </tr>
                @endif
			  @endif
			@endforeach
		</tbody>
	</table>

	<table width="100%" border="0" style="font-size: 7pt; margin-top: 0px;">
		<thead>
			<tr>
				@if($throttle == "Bulan")
					<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Bulan {{ date_ind(explode('-', $data_time->time)[0]) }} {{ explode('-', $data_time->time)[1] }}</td>
				@elseif($throttle == "Tahun")
					<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Tahun {{ $request->y }}</td>
				@endif
			</tr>
		</thead>
	</table>

	<div style="page-break-before: always;"></div>
  @endforeach
@endforeach