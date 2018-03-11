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
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;">Laporan Perbandingan Laba Rugi Keuangan Dalam Bulan</td>
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;text-align: right;">PT. Jawa Putra Mandiri</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Periode : Bulan {{ $request["m"] }} Dan Bulan {{ $request["y"] }}</td>

			<td colspan="5" style="text-align:right; height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
		</tr>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="4" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Laba Rugi {{ $request["m"] }}</td>

			<td></td><td></td>
			<td colspan="4" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Laba Rugi {{ $request["y"] }}</td>
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
                  		<td width="25px;" style="{{ $style }};"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva1[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" width="25px;" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>

	                	@if($dataAktiva1[$i]["jenis"] == "1")
							<td></td><td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataAktiva1[$i]["jenis"] == "3")
                	<td></td>
            		<?php $show = ($mydatatotal1[$dataAktiva1[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]); ?>

					<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>

				@elseif($dataAktiva1[$i]["jenis"] == "2")
					<?php $show = ($dataAktiva1[$i]["total"] < 0) ? "(".number_format($dataAktiva1[$i]["total"]).")" : number_format($dataAktiva1[$i]["total"]); ?>

					<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
					<?php $naAKtiva1 += $dataAktiva1[$i]["total"]; ?>
					<td></td>
				@endif


                <td width="10px;"></td><td width="10px;"></td>

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
                  		<td width="25px;" style="{{ $style }};"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva2[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" width="25px;" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>

	                	@if($dataAktiva2[$i]["jenis"] == "1")
							<td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataAktiva2[$i]["jenis"] == "3")
                	<td></td>
            		<?php $show = ($mydatatotal2[$dataAktiva2[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva2[$i]["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva1[$i]["nomor_id"]]); ?>

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
			<td colspan="3" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Laba Rugi</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva1 < 0) ? str_replace("-", "", "(".number_format($naAKtiva1).")") : number_format($naAKtiva1) }}</td>
			<td></td><td></td>
			<td colspan="3" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Laba Rugi</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva2 < 0) ? str_replace("-", "", "(".number_format($naAKtiva2).")") : number_format($naAKtiva2) }}</td>
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
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;">Laporan Perbandingan Laba Rugi Keuangan Dalam Tahun</td>
			<td colspan="5" style="height: 20px; font-weight: bold; vertical-align: middle;text-align: right;">PT. Jawa Putra Mandiri</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5" style="height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Periode : Bulan {{ $request["m"] }} Dan Bulan {{ $request["y"] }}</td>

			<td colspan="5" style="text-align:right; height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
		</tr>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="4" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Laba Rugi {{ $request["m"] }}</td>

			<td></td><td></td>
			<td colspan="4" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Laba Rugi {{ $request["y"] }}</td>
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
                  		<td width="25px;" style="{{ $style }};"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva1[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" width="25px;" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva1[$i]["nama_perkiraan"] }}</td>

	                	@if($dataAktiva1[$i]["jenis"] == "1")
							<td></td><td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataAktiva1[$i]["jenis"] == "3")
                	<td></td>
            		<?php $show = ($mydatatotal1[$dataAktiva1[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva1[$i]["nomor_id"]]); ?>

					<td width="20px;" style="text-align: right; height: 22px; border-top: 3px solid #333333; font-weight: bold;"> {{ str_replace("-", "", $show) }}</td>

				@elseif($dataAktiva1[$i]["jenis"] == "2")
					<?php $show = ($dataAktiva1[$i]["total"] < 0) ? "(".number_format($dataAktiva1[$i]["total"]).")" : number_format($dataAktiva1[$i]["total"]); ?>

					<td width="20px;" style="text-align: right; height: 22px;"> {{ str_replace("-", "", $show) }}</td>
					<?php $naAKtiva1 += $dataAktiva1[$i]["total"]; ?>
					<td></td>
				@endif


                <td width="10px;"></td><td width="10px;"></td>

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
                  		<td width="25px;" style="{{ $style }};"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>
                	@endif
                @else

                	@if($dataAktiva2[$i]["jenis"] == "4")
						<td colspan="3"></td>
					@else
                  		<td colspan="2" width="25px;" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva2[$i]["nama_perkiraan"] }}</td>

	                	@if($dataAktiva2[$i]["jenis"] == "1")
							<td></td>
	                	@endif
                	@endif

                	
                @endif

                @if($dataAktiva2[$i]["jenis"] == "3")
                	<td></td>
            		<?php $show = ($mydatatotal2[$dataAktiva2[$i]["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva2[$i]["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva1[$i]["nomor_id"]]); ?>

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
			<td colspan="3" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Laba Rugi</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva1 < 0) ? str_replace("-", "", "(".number_format($naAKtiva1).")") : number_format($naAKtiva1) }}</td>
			<td></td><td></td>
			<td colspan="3" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Laba Rugi</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva2 < 0) ? str_replace("-", "", "(".number_format($naAKtiva2).")") : number_format($naAKtiva2) }}</td>
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
			<td colspan="3" style="height: 20px; font-weight: bold; vertical-align: middle;border:1px solid #333;">Laporan Laba Rugi Keuangan {{ ($throttle == "bulan") ? "Bulanan" : "Tahunan" }}</td>
			<td colspan="6" style="height: 20px; font-weight: bold; vertical-align: middle;text-align: right; border:1px solid #333;">PT. Jawa Putra Mandiri</td>
		</tr>

		<tr>
			<td></td>
			@if($throttle == "bulan")
				<td colspan="3" style="height: 20px; font-weight: normal; vertical-align: middle; border:1px solid #333;;font-size: 9pt;">Periode : Bulan {{ $request["m"]."/".$request["y"] }}</td>
			@else
				<td colspan="3" style="height: 20px; font-weight: normal; vertical-align: middle; border:1px solid #333;font-size: 9pt;">Periode : Tahun {{ $request["y"] }}</td>
			@endif

			<td colspan="6" style="text-align:right; height: 20px; font-weight: normal; vertical-align: middle; border-top: 5px solid #555555;font-size: 9pt;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
		</tr>

		<tr></tr>

		<tr>
			<td></td>
			<td colspan="4" style="height: 20px; background: #ccc; text-align: center; vertical-align: middle; font-weight: bold;">Laba Rugi</td>
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
	                  		<td width="800px;" style="{{ $style }};"> {{ $dataAktiva[$i]["nama_perkiraan"] }}</td>
	                	@endif
	                @else

	                	@if($dataAktiva[$i]["jenis"] == "4")
							<td colspan="3"></td>
						@else
	                  		<td colspan="2" width="800px;" style="{{ $style }} height: 22px; vertical-align: middle;"> {{ $dataAktiva[$i]["nama_perkiraan"] }}</td>

		                	@if($dataAktiva[$i]["jenis"] == "1")
								<td></td>
		                	@endif
	                	@endif

	                	
	                @endif

	                @if($dataAktiva[$i]["jenis"] == "3")
	                	<td></td>
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

			</tr>
		@endfor
	    
		<tr></tr>

		<tr>
			<td></td>
			<td colspan="3" style="text-align: center; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">Total Akhir Aktiva</td>
			<td style="text-align: right; height: 20px; vertical-align: middle; font-weight: bold;background: #ccc">{{ ($naAKtiva < 0) ? str_replace("-", "", "(".number_format($naAKtiva).")") : number_format($naAKtiva) }}</td>
		</tr>
	@endif

	

</html>