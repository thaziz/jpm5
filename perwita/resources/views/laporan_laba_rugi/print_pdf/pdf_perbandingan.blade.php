<style>
	.table_neraca td{
      font-weight: 400;
      border-top:1px dotted #efefef;
    }

    .table_neraca td.lv1{
      padding: 4px 10px;
    }

    .table_neraca td.lv2{
      padding: 4px 25px;
    }

    .table_neraca td.lv3{
      padding: 4px 50px;
      font-style: italic;
    }

    .table_neraca td.money{
      text-align: right;
      padding: 4px 10px;
    }

    .table_neraca td.total{
      border-top: 1px solid #bbb;
    }

    .page_break { page-break-before: always; }
</style>



<table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
	<thead>
		<tr>
			<th style="text-align: left;">Laporan Laba Rugi Keuangan Dalam Perbandingan {{ ucfirst($throttle) }}</th>
			<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
		</tr>
	</thead>
</table>

<table width="100%" border="0" style="font-size: 8pt;">
	<thead>
		<tr>
			@if($throttle == "p_bulan")
				<td style="text-align: left;">Periode : Bulan {{ $request->m }}/{{ $request->y }}, {{ ($_GET['cab'] == "all") ? "Semua Cabang" : "Cabang ".$cabang->nama }}</td>
			@elseif($throttle == "p_tahun")
				<td style="text-align: left;">Periode : Tahun {{ $request->m }} dan {{ $request->y }}, {{ ($_GET['cab'] == "all") ? "Semua Cabang" : "Cabang ".$cabang->nama }}</td>
			@endif

			<td style="text-align: right;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
		</tr>
	</thead>
</table>

<table class="table_bingkai" width="100%" border="1" style="font-size: 10pt; margin-top: 20px; border-collapse: collapse;">
	<thead>
		<tr>
			<th width="50%" style="text-align: center;">Laba Rugi {{ $request->m }}</th>
			<th style="text-align: center;">Laba Rugi {{ $request->y }}</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td style="vertical-align: top;">
				{{-- Aktiva --}}

				  <table class="table_neraca tree" width="100%" style="font-size: 8pt;" border="0">

            <?php $total_aktiva_1 = 0; ?>

            @foreach($data_neraca_1 as $data_neraca_aktiva)
                <?php 
                  $level = "lv".$data_neraca_aktiva["level"];
                  $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                  $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                ?>
                
                @if($data_neraca_aktiva["jenis"] == 1)
                  <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td colspan="3" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                  </tr>
                @elseif($data_neraca_aktiva["jenis"] == 2)
                  <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td width="50%" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                    {{-- <td class="money">{{ $data_neraca_aktiva["total"] }}</td> --}}
                  </tr>

                    @foreach($data_detail_1 as $data_detail_aktiva)
                      @if($data_detail_aktiva["id_parrent"] == $data_neraca_aktiva["nomor_id"])
                        <?php 
                          $tree_parrent = ($data_detail_aktiva['id_parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_detail_aktiva["id_parrent"]);;
                          $treegrid = "treegrid-".str_replace(".", "_", $data_detail_aktiva["nomor_id"]);

                          $num = number_format($data_detail_aktiva["total"], 2);

                          if($data_detail_aktiva["total"] < 0){
                            $num = "(".number_format(str_replace("-", "", $data_detail_aktiva["total"]), 2).")";
                          }
                        ?>

                        <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_detail_aktiva["nomor_id"] }}">
                          <td class="lv3">{{ $data_detail_aktiva["nama_referensi"] }}</td>
                          <td class="money">{{ $num }}</td>
                          <td></td>

                          <?php $total_aktiva_1 += $data_detail_aktiva["total"]; ?>
                        </tr>
                      @endif
                    @endforeach

                @elseif($data_neraca_aktiva["jenis"] == 3)
                  <?php

                    $num = number_format($data_neraca_aktiva["total"], 2);

                    if($data_neraca_aktiva["total"] < 0){
                      $num = "(".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2).")";
                    }

                  ?>

                  <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                    <td></td>
                    <td class="money total">{{ $num }}</td>
                  </tr>
                @elseif($data_neraca_aktiva["jenis"] == 4)
                  <tr class="{{ $treegrid }} {{ $tree_parrent }}">
                    <td class="{{ $level }}">&nbsp;</td>
                    <td></td>
                    <td></td>
                  </tr>
                @endif
            @endforeach

          </table>

        {{-- Aktiva End --}}

			</td>

			<td style="vertical-align: top;">
				{{-- Pasiva --}}

				  <table class="table_neraca tree" width="100%" style="font-size: 8pt;" border="0">

            <?php $total_aktiva_2 = 0; ?>

            @foreach($data_neraca_2 as $data_neraca_aktiva)
                <?php 
                  $level = "lv".$data_neraca_aktiva["level"];
                  $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                  $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                ?>
                
                @if($data_neraca_aktiva["jenis"] == 1)
                  <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td colspan="3" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                  </tr>
                @elseif($data_neraca_aktiva["jenis"] == 2)
                  <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td width="50%" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                    {{-- <td class="money">{{ $data_neraca_aktiva["total"] }}</td> --}}
                  </tr>

                    @foreach($data_detail_2 as $data_detail_aktiva)
                      @if($data_detail_aktiva["id_parrent"] == $data_neraca_aktiva["nomor_id"])
                        <?php 
                          $tree_parrent = ($data_detail_aktiva['id_parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_detail_aktiva["id_parrent"]);;
                          $treegrid = "treegrid-".str_replace(".", "_", $data_detail_aktiva["nomor_id"]);
                          $num = number_format($data_detail_aktiva["total"], 2);

                          if($data_detail_aktiva["total"] < 0){
                            $num = "(".number_format(str_replace("-", "", $data_detail_aktiva["total"]), 2).")";
                          }
                        ?>

                        <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_detail_aktiva["nomor_id"] }}">
                          <td class="lv3">{{ $data_detail_aktiva["nama_referensi"] }}</td>
                          <td class="money">{{ $num }}</td>
                          <td></td>

                          <?php $total_aktiva_2 += $data_detail_aktiva["total"]; ?>
                        </tr>
                      @endif
                    @endforeach

                @elseif($data_neraca_aktiva["jenis"] == 3)
                  <?php

                    $num = number_format($data_neraca_aktiva["total"], 2);

                    if($data_neraca_aktiva["total"] < 0){
                      $num = "(".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2).")";
                    }

                  ?>

                  <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                    <td></td>
                    <td class="money total">{{ $num }}</td>
                  </tr>
                @elseif($data_neraca_aktiva["jenis"] == 4)
                  <tr class="{{ $treegrid }} {{ $tree_parrent }}">
                    <td class="{{ $level }}">&nbsp;</td>
                    <td></td>
                    <td></td>
                  </tr>
                @endif
            @endforeach

          </table>

        {{-- Pasiva End --}}
			</td>
		</tr>
	</tbody>
</table>

<table class="table_bingkai" width="100%" border="0" style="font-size: 10pt; margin-top: 0px;">
	<tbody>
		<td width="50%" style=" border: 1px solid #000;">
			<table class="table_neraca" width="100%" style="font-size: 9pt;" border="0">
              <?php
                $num = number_format($total_aktiva_1, 2);

                if($total_aktiva_1 < 0){
                  $num = "(".number_format(str_replace("-", "", $total_aktiva_1), 2).")";
                }
              ?>

              <tr>
                <td style="text-align: center; font-weight: 600;">Total Laba Rugi {{ $request->m }}</td>
                <td class="money">{{ $num }}</td>
              </tr>
            </table>
		</td>

		<td style=" border: 1px solid #000;">
			<table class="table_neraca" width="100%" style="font-size: 9pt;" border="0">
              <?php
                $num = number_format($total_aktiva_2, 2);

                if($total_aktiva_2 < 0){
                  $num = "(".number_format(str_replace("-", "", $total_aktiva_2), 2).")";
                }
              ?>

              <tr>
                <td style="text-align: center; font-weight: 600;">Total Laba Rugi {{ $request->y }}</td>
                <td class="money">{{ $num }}</td>
              </tr>
            </table>
		</td>
	</tbody>
</table>