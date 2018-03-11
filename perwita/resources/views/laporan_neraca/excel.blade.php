<html>
	
	@if($throttle == "perbandingan_bulan")
		<?php
			$dataAktiva1 = []; $dataPasiva1 = []; $noPasiva = 0; $noAktiva = 0; $naAKtiva1 = 0; $naPasiva1 = 0;

			foreach($data1 as $dataDetail){
				if($dataDetail["type"] == "aktiva"){
					$dataAktiva1[$noAktiva] = $dataDetail;

					$noAktiva++;
				}else{
					$dataPasiva1[$noPasiva] = $dataDetail;

					$noPasiva++;
				}
			}

			$dataAktiva2 = []; $dataPasiva2 = []; $noPasiva = 0; $noAktiva = 0; $naAKtiva2 = 0; $naPasiva2 = 0;

			foreach($data2 as $dataDetail){
				if($dataDetail["type"] == "aktiva"){
					$dataAktiva2[$noAktiva] = $dataDetail;

					$noAktiva++;
				}else{
					$dataPasiva2[$noPasiva] = $dataDetail;

					$noPasiva++;
				}
			}

		?>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;">Laporan Perbandingan Neraca Keuangan Dalam Bulan</td>
			<td colspan="2" style="height: 20px; font-weight: bold; vertical-align: middle;text-align: right;">PT. Jawa Putra Mandiri</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Periode : Bulan {{ $request["m"] }} Dan Bulan {{ $request["y"] }}</td>

			<td colspan="2" style="text-align: right; border-top: 5px solid #555555;">Berdasarkan Desain Neraca Yang Aktif Periode Ini</td>
		</tr>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Aktiva {{ $request["m"] }}</td>

			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Aktiva {{ $request["y"] }}</td>
		</tr>


		@for($i = 0; $i < count($dataAktiva1); $i++)

			<tr>
				<td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataAktiva1[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataAktiva1[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataAktiva1[$i]["parrent"] != "")
                	@if($dataAktiva1[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva1[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>

	                	@if($dataAktiva1[$i]["jenis"] == "1")
							<td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataAktiva1[$i]["jenis"] == "3")
            		<?php $show = ($mydatatotal1[$dataAktiva1[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]); ?>

					<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
				@elseif($dataAktiva1[$i]["jenis"] == "2")
					<?php $show = ($dataAktiva1[$i]["total"] < 0) ? "(".number_format($dataAktiva1[$i]["total"]).")" : number_format($dataAktiva1[$i]["total"]); ?>

					<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
					<?php $naAKtiva1 += $dataAktiva1[$i]["total"]; ?>
				@endif


                <td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataAktiva2[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataAktiva2[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataAktiva2[$i]["parrent"] != "")
                	@if($dataAktiva2[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva2[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>

                	@endif

                	
                @endif

                	@if($dataAktiva2[$i]["jenis"] == "3")
                		<?php $show = ($mydatatotal2[$dataAktiva2[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva2[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva2[$i]["nomor_id"]]); ?>

						<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
					@elseif($dataAktiva2[$i]["jenis"] == "2")
						<?php $show = ($dataAktiva1[$i]["total"] < 0) ? "(".number_format($dataAktiva2[$i]["total"]).")" : number_format($dataAktiva2[$i]["total"]); ?>

						<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
						<?php $naAKtiva2 += $dataAktiva2[$i]["total"]; ?>
					@endif

			</tr>
		@endfor
	    
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Aktiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva1 < 0) ? str_replace("-", "", "(".number_format($naAKtiva1).")") : number_format($naAKtiva1) }}</td>

			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Aktiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva2 < 0) ? str_replace("-", "", "(".number_format($naAKtiva2).")") : number_format($naAKtiva2) }}</td>
		</tr>

		<tr></tr><tr></tr>

		<tr>
			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Pasiva {{ $request["m"] }}</td>

			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Pasiva {{ $request["y"] }}</td>
		</tr>

		@for($i = 0; $i < count($dataPasiva1); $i++)

			<tr>
				<td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataPasiva1[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataPasiva1[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataPasiva1[$i]["parrent"] != "")
                	@if($dataPasiva1[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataPasiva1[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataPasiva1[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataPasiva1[$i]["nama_perkiraan"] }}</td>

	                	@if($dataPasiva1[$i]["jenis"] == "1")
							<td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataPasiva1[$i]["jenis"] == "3")
            		<?php $show = ($mydatatotal1[$dataPasiva1[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataPasiva1[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataPasiva1[$i]["nomor_id"]]); ?>

					<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
				@elseif($dataPasiva1[$i]["jenis"] == "2")
					<?php $show = ($dataPasiva1[$i]["total"] < 0) ? "(".number_format($dataPasiva1[$i]["total"]).")" : number_format($dataPasiva1[$i]["total"]); ?>

					<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
					<?php $naPasiva1 += $dataPasiva1[$i]["total"]; ?>
				@endif


                <td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataPasiva2[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataPasiva2[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataPasiva2[$i]["parrent"] != "")
                	@if($dataPasiva2[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataPasiva2[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataPasiva2[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataPasiva2[$i]["nama_perkiraan"] }}</td>

                	@endif

                	
                @endif

                	@if($dataPasiva2[$i]["jenis"] == "3")
                		<?php $show = ($mydatatotal2[$dataPasiva2[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataPasiva2[$i]["nomor_id"]]).")" : number_format($mydatatotal2[$dataPasiva2[$i]["nomor_id"]]); ?>

						<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
					@elseif($dataPasiva2[$i]["jenis"] == "2")
						<?php $show = ($dataPasiva2[$i]["total"] < 0) ? "(".number_format($dataPasiva2[$i]["total"]).")" : number_format($dataPasiva2[$i]["total"]); ?>

						<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
						<?php $naPasiva2 += $dataPasiva2[$i]["total"]; ?>
					@endif

			</tr>
		@endfor
	    
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Pasiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naPasiva1 < 0) ? str_replace("-", "", "(".number_format($naPasiva1).")") : number_format($naPasiva1) }}</td>

			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Pasiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naPasiva2 < 0) ? str_replace("-", "", "(".number_format($naPasiva2).")") : number_format($naPasiva2) }}</td>
		</tr>
	@elseif($throttle == "perbandingan_tahun")
		<?php
			$dataAktiva1 = []; $dataPasiva1 = []; $noPasiva = 0; $noAktiva = 0; $naAKtiva1 = 0; $naPasiva1 = 0;

			foreach($data1 as $dataDetail){
				if($dataDetail["type"] == "aktiva"){
					$dataAktiva1[$noAktiva] = $dataDetail;

					$noAktiva++;
				}else{
					$dataPasiva1[$noPasiva] = $dataDetail;

					$noPasiva++;
				}
			}

			$dataAktiva2 = []; $dataPasiva2 = []; $noPasiva = 0; $noAktiva = 0; $naAKtiva2 = 0; $naPasiva2 = 0;

			foreach($data2 as $dataDetail){
				if($dataDetail["type"] == "aktiva"){
					$dataAktiva2[$noAktiva] = $dataDetail;

					$noAktiva++;
				}else{
					$dataPasiva2[$noPasiva] = $dataDetail;

					$noPasiva++;
				}
			}

		?>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;">Laporan Perbandingan Neraca Keuangan Dalam Tahun</td>
			<td colspan="2" style="height: 20px; font-weight: bold; vertical-align: middle;text-align: right;">PT. Jawa Putra Mandiri</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Periode : Tahun {{ $request["m"] }} Dan Tahun {{ $request["y"] }}</td>

			<td colspan="2" style="text-align: right; border-top: 5px solid #555555;">Berdasarkan Desain Neraca Yang Aktif Periode Ini</td>
		</tr>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Aktiva {{ $request["m"] }}</td>

			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Aktiva {{ $request["y"] }}</td>
		</tr>


		@for($i = 0; $i < count($dataAktiva1); $i++)

			<tr>
				<td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataAktiva1[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataAktiva1[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataAktiva1[$i]["parrent"] != "")
                	@if($dataAktiva1[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva1[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>

	                	@if($dataAktiva1[$i]["jenis"] == "1")
							<td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataAktiva1[$i]["jenis"] == "3")
            		<?php $show = ($mydatatotal1[$dataAktiva1[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]); ?>

					<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
				@elseif($dataAktiva1[$i]["jenis"] == "2")
					<?php $show = ($dataAktiva1[$i]["total"] < 0) ? "(".number_format($dataAktiva1[$i]["total"]).")" : number_format($dataAktiva1[$i]["total"]); ?>

					<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
					<?php $naAKtiva1 += $dataAktiva1[$i]["total"]; ?>
				@endif


                <td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataAktiva2[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataAktiva2[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataAktiva2[$i]["parrent"] != "")
                	@if($dataAktiva2[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva2[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>

                	@endif

                	
                @endif

                	@if($dataAktiva2[$i]["jenis"] == "3")
                		<?php $show = ($mydatatotal2[$dataAktiva2[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva2[$i]["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva2[$i]["nomor_id"]]); ?>

						<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
					@elseif($dataAktiva2[$i]["jenis"] == "2")
						<?php $show = ($dataAktiva2[$i]["total"] < 0) ? "(".number_format($dataAktiva2[$i]["total"]).")" : number_format($dataAktiva2[$i]["total"]); ?>

						<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
						<?php $naAKtiva2 += $dataAktiva2[$i]["total"]; ?>
					@endif

			</tr>
		@endfor
	    
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Aktiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva1 < 0) ? str_replace("-", "", "(".number_format($naAKtiva1).")") : number_format($naAKtiva1) }}</td>

			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Aktiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva2 < 0) ? str_replace("-", "", "(".number_format($naAKtiva2).")") : number_format($naAKtiva2) }}</td>
		</tr>

		<tr></tr><tr></tr>

		<tr>
			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Pasiva {{ $request["m"] }}</td>

			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Pasiva {{ $request["y"] }}</td>
		</tr>

		@for($i = 0; $i < count($dataPasiva1); $i++)

			<tr>
				<td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataPasiva1[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataPasiva1[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataPasiva1[$i]["parrent"] != "")
                	@if($dataPasiva1[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataPasiva1[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataPasiva1[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataPasiva1[$i]["nama_perkiraan"] }}</td>

	                	@if($dataPasiva1[$i]["jenis"] == "1")
							<td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataPasiva1[$i]["jenis"] == "3")
            		<?php $show = ($mydatatotal1[$dataPasiva1[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataPasiva1[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataPasiva1[$i]["nomor_id"]]); ?>

					<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
				@elseif($dataPasiva1[$i]["jenis"] == "2")
					<?php $show = ($dataPasiva1[$i]["total"] < 0) ? "(".number_format($dataPasiva1[$i]["total"]).")" : number_format($dataPasiva1[$i]["total"]); ?>

					<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
					<?php $naPasiva1 += $dataPasiva1[$i]["total"]; ?>
				@endif


                <td width="10px;"></td>

				<?php 
                  $style = "";

                  if($dataPasiva2[$i]["jenis"] == 1)
                  	$style = "font-weight: bold;";

                  if($dataPasiva2[$i]["jenis"] == 3)
                    $style = "border-top: 2px solid #999; font-weight: 600;";
                ?>

                @if($dataPasiva2[$i]["parrent"] != "")
                	@if($dataPasiva2[$i]["jenis"] == "4")
						<td colspan="3" style="height: 20px;"></td>
					@else
                  		<td width="4px;"></td>
                  		<td width="300px;" style="{{ $style }};"> {{ $dataPasiva2[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataPasiva2[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataPasiva2[$i]["nama_perkiraan"] }}</td>

                	@endif

                	
                @endif

                	@if($dataPasiva2[$i]["jenis"] == "3")
                		<?php $show = ($mydatatotal2[$dataPasiva2[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataPasiva2[$i]["nomor_id"]]).")" : number_format($mydatatotal2[$dataPasiva2[$i]["nomor_id"]]); ?>

						<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
					@elseif($dataPasiva2[$i]["jenis"] == "2")
						<?php $show = ($dataPasiva2[$i]["total"] < 0) ? "(".number_format($dataPasiva2[$i]["total"]).")" : number_format($dataPasiva2[$i]["total"]); ?>

						<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
						<?php $naPasiva2 += $dataPasiva2[$i]["total"]; ?>
					@endif

			</tr>
		@endfor
	    
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Pasiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naPasiva1 < 0) ? str_replace("-", "", "(".number_format($naPasiva1).")") : number_format($naPasiva1) }}</td>

			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Pasiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naPasiva2 < 0) ? str_replace("-", "", "(".number_format($naPasiva2).")") : number_format($naPasiva2) }}</td>
		</tr>

	@else

		<?php 

			$dataAktiva = []; $noAktiva = 0; $dataPasiva = []; $noPasiva = 0; $loop = 0; $naAKtiva = 0; $naPasiva = 0;

			foreach($data as $dataDetail){
				if($dataDetail["type"] == "aktiva"){
					$dataAktiva[$noAktiva] = $dataDetail;

					$noAktiva++;
				}else{
					$dataPasiva[$noPasiva] = $dataDetail;

					$noPasiva++;
				}
			}

			if(count($dataAktiva) > count($dataPasiva)){
				$loop = count($dataAktiva);
			}else{
				$loop = count($dataPasiva);
			}
		?>
		
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;">Laporan Neraca Keuangan {{ ($throttle == "bulan") ? "Bulanan" : "Tahunan" }}</td>
			<td colspan="2" style="height: 20px; font-weight: bold; vertical-align: middle;text-align: right;">PT. Jawa Putra Mandiri</td>
		</tr>

		<tr>
			<td></td>
			@if($throttle == "bulan")
				<td colspan="5" style="height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Periode : Bulan {{ $request["m"]."/".$request["y"] }}</td>
			@else
				<td colspan="5" style="height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Periode : Tahun {{ $request["y"] }}</td>
			@endif

			<td colspan="2" style="text-align: right; border-top: 5px solid #555555;">Berdasarkan Desain Neraca Yang Aktif Periode Ini</td>
		</tr>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Aktiva</td>
			<td></td>
			<td colspan="3" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Pasiva</td>
		</tr>


		@for($i = 0; $i < $loop; $i++)

			<tr>
				<td width="10px;"></td>
				@if($i < count($dataAktiva))
					<?php 
	                  $style = "";

	                  if($dataAktiva[$i]["jenis"] == 1)
	                  	$style = "font-weight: bold;";

	                  if($dataAktiva[$i]["jenis"] == 3)
	                    $style = "border-top: 2px solid #999; font-weight: 600;";
	                ?>

	                @if($dataAktiva[$i]["parrent"] != "")
	                	@if($dataAktiva[$i]["jenis"] == "4")
							<td colspan="3" style="height: 20px;"></td>
						@else
	                  		<td width="4px;"></td>
	                  		<td width="300px;" style="{{ $style }};"> {{ $dataAktiva[$i]["nama_perkiraan"] }}</td>
	                	@endif
	                @else

	                	@if($dataAktiva[$i]["jenis"] == "4")
							<td colspan="3"></td>
						@else
	                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva[$i]["nama_perkiraan"] }}</td>

		                	@if($dataAktiva[$i]["jenis"] == "1")
								<td></td>
		                	@endif
	                	@endif

	                	
	                @endif

	                @if($dataAktiva[$i]["jenis"] == "3")
                		<?php $show = ($mydatatotal[$dataAktiva[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal[$dataAktiva[$i]["nomor_id"]]).")" : number_format($mydatatotal[$dataAktiva[$i]["nomor_id"]]); ?>

						<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
					@elseif($dataAktiva[$i]["jenis"] == "2")
						<?php $show = ($dataAktiva[$i]["total"] < 0) ? "(".number_format($dataAktiva[$i]["total"]).")" : number_format($dataAktiva[$i]["total"]); ?>

						<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
						<?php $naAKtiva += $dataAktiva[$i]["total"]; ?>
					@endif
				@else
					<td></td><td></td><td></td>
				@endif

				<td></td>

				@if($i < count($dataPasiva))
					<?php 
	                  $style = "";

	                  if($dataPasiva[$i]["jenis"] == 1)
	                  	$style = "font-weight: bold;";

	                  if($dataPasiva[$i]["jenis"] == 3)
	                    $style = "border-top: 2px solid #999; font-weight: 600;";
	                ?>

	                @if($dataPasiva[$i]["parrent"] != "")
	                	@if($dataPasiva[$i]["jenis"] == "4")
							<td colspan="3" style="height: 20px;"></td>
						@else
	                  		<td width="4px;"></td>
	                  		<td width="300px;" style="{{ $style }};"> {{ $dataPasiva[$i]["nama_perkiraan"] }}</td>
	                	@endif
	                @else

                	@if($dataPasiva[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataPasiva[$i]["nama_perkiraan"] }} - {{ $dataPasiva[$i]["jenis"] }}</td>
                	@endif

	                	
	                @endif

                	@if($dataPasiva[$i]["jenis"] == "3")
                		<?php $show = ($mydatatotal[$dataPasiva[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal[$dataPasiva[$i]["nomor_id"]]).")" : number_format($mydatatotal[$dataPasiva[$i]["nomor_id"]]); ?>

						<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>
					@elseif($dataPasiva[$i]["jenis"] == "2")
						<?php $show = ($dataPasiva[$i]["total"] < 0) ? "(".number_format($dataPasiva[$i]["total"]).")" : number_format($dataPasiva[$i]["total"]); ?>

						<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
						<?php $naPasiva += $dataPasiva[$i]["total"]; ?>
					@endif

				@else
					<td></td>
				@endif

			</tr>
		@endfor
	    
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Aktiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva < 0) ? str_replace("-", "", "(".number_format($naAKtiva).")") : number_format($naAKtiva) }}</td>

			<td></td>
			<td colspan="2" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Pasiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naPasiva < 0) ? str_replace("-", "", "(".number_format($naPasiva).")") : number_format($naPasiva) }}</td>
		</tr>
	@endif

	

</html>