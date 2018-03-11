<style>
	#bingkai td{
      padding: 5px 3px;
    }

	#bingkai td.header{
      font-weight: bold;
    }

    #bingkai td.child{
      padding-left: 20px;
    }

    #bingkai td.total{
      border-top: 2px solid #999;
      font-weight: 600;
    }

    #bingkai td.no-border{
      border: 0px;
    }
</style>

@if($throttle == "perbandingan_bulan")
	<table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
		<thead>
			<tr>
				<th style="text-align: left;">Laporan Perbandingan Laba Rugi Keuangan Dalam  Bulan</th>
				<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
			</tr>
		</thead>
	</table>

	<table width="100%" border="0" style="font-size: 8pt;">
		<thead>
			<tr>
				<td style="text-align: left;">Periode :  Bulan {{ $request["m"] }} Dan  Bulan {{ $request["y"] }}</td>

				<td style="text-align: right;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
			</tr>
		</thead>
	</table>

	<table id="content" width="100%" border="0" style="font-size: 9pt; margin-top: 5px;">
		<thead>
			<tr>
				<td width="50%" style="text-align: center; border: 1px solid #333;padding: 10px; font-size: 10pt;">Laba Rugi {{ $request["m"]}}</td>
				<td style="text-align: center; border: 1px solid #333;padding: 10px; font-size: 10pt;">Laba Rugi {{ $request["y"]}}</td>
			</tr>

			<tr>
				<td style="text-align: center;border: 1px solid #333; vertical-align: top;">
					<table width="100%" id="bingkai" style="font-size: 8pt;">
		                  <?php $DatatotalAktiva1 = 0; $tot = 0;?>
		                  @foreach($datat1 as $dataAktiva)
		                    <?php 
		                      $header = ""; $child = ""; $total = ""; 

		                      if($dataAktiva["jenis"] == 1){
		                        $header = "header"; $totalHeader = 0;
		                      }

		                      if($dataAktiva["parrent"] != "")
		                        $child = "child";

		                      if($dataAktiva["jenis"] == 3)
		                        $total = "total";
		                    ?>


		                    @if($dataAktiva["type"] == "aktiva")
		                      
		                        @if($dataAktiva["jenis"] == "4")
		                          <tr><td colspan="2"> </td></tr>
		                          <tr><td colspan="2"> </td></tr>
		                        @else
		                          <tr>
		                            <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
		                            @if($dataAktiva["jenis"] == 2)

		                              <?php 
		                                $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @elseif($dataAktiva["jenis"] == 3)
		                              <?php 
		                                $show = ($mydatatotal1[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva["nomor_id"]]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @endif
		                          </tr>
		                        @endif

		                      <?php 
		                        $DatatotalAktiva1 += $dataAktiva["total"];
		                        if($dataAktiva["jenis"] == 3)
		                          $tot++;
		                      ?>
		                    @endif

		                  @endforeach
		            </table>
				</td>

				<td style="text-align: center;border: 1px solid #333; vertical-align: top;">
					<table width="100%" id="bingkai" style="font-size: 8pt;">
		                  <?php $DatatotalAktiva2 = 0; $tot = 0;?>
		                  @foreach($datat2 as $dataAktiva)
		                    <?php 
		                      $header = ""; $child = ""; $total = ""; 

		                      if($dataAktiva["jenis"] == 1){
		                        $header = "header"; $totalHeader = 0;
		                      }

		                      if($dataAktiva["parrent"] != "")
		                        $child = "child";

		                      if($dataAktiva["jenis"] == 3)
		                        $total = "total";
		                    ?>


		                    @if($dataAktiva["type"] == "aktiva")
		                      
		                        @if($dataAktiva["jenis"] == "4")
		                          <tr><td colspan="2"> </td></tr>
		                          <tr><td colspan="2"> </td></tr>
		                        @else
		                          <tr>
		                            <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
		                            @if($dataAktiva["jenis"] == 2)

		                              <?php 
		                                $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @elseif($dataAktiva["jenis"] == 3)
		                              <?php 
		                                $show = ($mydatatotal2[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva["nomor_id"]]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @endif
		                          </tr>
		                        @endif

		                      <?php 
		                        $DatatotalAktiva2 += $dataAktiva["total"];
		                        if($dataAktiva["jenis"] == 3)
		                          $tot++;
		                      ?>
		                    @endif

		                  @endforeach
		            </table>
				</td>
			</tr>
		</thead>
	</table>

	<table id="tree" width="100%" style="margin-top: 20px;">
	  <tr>
	  	<td width="50%">
	  		<table width="100%" style="font-size: 10pt;">
	  			<tr>
	  				<td style="border-bottom: 1px solid #333;padding: 5px 3px; font-weight: bold;text-align: center;">Total Akhir Laba Rugi</td>
	  				<td style="text-align: right;border: 1px solid #333;padding: 5px 3px;font-weight: bold;">{{ ($DatatotalAktiva1 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva1).")") : number_format($DatatotalAktiva1) }}</td>
	  			</tr>
	  		</table>
	  	</td>

	  	<td>
	  		<table width="100%" style="font-size: 10pt;">
	  			<tr>
	  				<td style="border-bottom: 1px solid #333;padding: 5px 3px; font-weight: bold;text-align: center;">Total Akhir Laba Rugi</td>
	  				<td style="text-align: right;border: 1px solid #333;padding: 5px 3px;font-weight: bold;">{{ ($DatatotalAktiva2 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva2).")") : number_format($DatatotalAktiva2) }}</td>
	  			</tr>
	  		</table>
	  	</td>
	  </tr>     
	</table>
@elseif($throttle == "perbandingan_tahun")
	<table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
		<thead>
			<tr>
				<th style="text-align: left;">Laporan Perbandingan Laba Rugi Keuangan Dalam Tahun</th>
				<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
			</tr>
		</thead>
	</table>

	<table width="100%" border="0" style="font-size: 8pt;">
		<thead>
			<tr>
				<td style="text-align: left;">Periode : Tahun {{ $request["m"] }} Dan Tahun {{ $request["y"] }}</td>

				<td style="text-align: right;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
			</tr>
		</thead>
	</table>

	<table id="content" width="100%" border="0" style="font-size: 9pt; margin-top: 5px;">
		<thead>
			<tr>
				<td width="50%" style="text-align: center; border: 1px solid #333;padding: 10px; font-size: 10pt;">Laba Rugi {{ $request["m"]}}</td>
				<td style="text-align: center; border: 1px solid #333;padding: 10px; font-size: 10pt;">Laba Rugi {{ $request["y"]}}</td>
			</tr>

			<tr>
				<td style="text-align: center;border: 1px solid #333; vertical-align: top;">
					<table width="100%" id="bingkai" style="font-size: 8pt;">
		                  <?php $DatatotalAktiva1 = 0; $tot = 0;?>
		                  @foreach($datat1 as $dataAktiva)
		                    <?php 
		                      $header = ""; $child = ""; $total = ""; 

		                      if($dataAktiva["jenis"] == 1){
		                        $header = "header"; $totalHeader = 0;
		                      }

		                      if($dataAktiva["parrent"] != "")
		                        $child = "child";

		                      if($dataAktiva["jenis"] == 3)
		                        $total = "total";
		                    ?>


		                    @if($dataAktiva["type"] == "aktiva")
		                      
		                        @if($dataAktiva["jenis"] == "4")
		                          <tr><td colspan="2"> </td></tr>
		                          <tr><td colspan="2"> </td></tr>
		                        @else
		                          <tr>
		                            <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
		                            @if($dataAktiva["jenis"] == 2)

		                              <?php 
		                                $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @elseif($dataAktiva["jenis"] == 3)
		                              <?php 
		                                $show = ($mydatatotal1[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva["nomor_id"]]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @endif
		                          </tr>
		                        @endif

		                      <?php 
		                        $DatatotalAktiva1 += $dataAktiva["total"];
		                        if($dataAktiva["jenis"] == 3)
		                          $tot++;
		                      ?>
		                    @endif

		                  @endforeach
		            </table>
				</td>

				<td style="text-align: center;border: 1px solid #333; vertical-align: top;">
					<table width="100%" id="bingkai" style="font-size: 8pt;">
		                  <?php $DatatotalAktiva2 = 0; $tot = 0;?>
		                  @foreach($datat2 as $dataAktiva)
		                    <?php 
		                      $header = ""; $child = ""; $total = ""; 

		                      if($dataAktiva["jenis"] == 1){
		                        $header = "header"; $totalHeader = 0;
		                      }

		                      if($dataAktiva["parrent"] != "")
		                        $child = "child";

		                      if($dataAktiva["jenis"] == 3)
		                        $total = "total";
		                    ?>


		                    @if($dataAktiva["type"] == "aktiva")
		                      
		                        @if($dataAktiva["jenis"] == "4")
		                          <tr><td colspan="2"> </td></tr>
		                          <tr><td colspan="2"> </td></tr>
		                        @else
		                          <tr>
		                            <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
		                            @if($dataAktiva["jenis"] == 2)

		                              <?php 
		                                $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @elseif($dataAktiva["jenis"] == 3)
		                              <?php 
		                                $show = ($mydatatotal2[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva["nomor_id"]]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @endif
		                          </tr>
		                        @endif

		                      <?php 
		                        $DatatotalAktiva2 += $dataAktiva["total"];
		                        if($dataAktiva["jenis"] == 3)
		                          $tot++;
		                      ?>
		                    @endif

		                  @endforeach
		            </table>
				</td>
			</tr>
		</thead>
	</table>

	<table id="tree" width="100%" style="margin-top: 20px;">
	  <tr>
	  	<td width="50%">
	  		<table width="100%" style="font-size: 10pt;">
	  			<tr>
	  				<td style="border-bottom: 1px solid #333;padding: 5px 3px; font-weight: bold;text-align: center;">Total Akhir Laba Rugi</td>
	  				<td style="text-align: right;border: 1px solid #333;padding: 5px 3px;font-weight: bold;">{{ ($DatatotalAktiva1 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva1).")") : number_format($DatatotalAktiva1) }}</td>
	  			</tr>
	  		</table>
	  	</td>

	  	<td>
	  		<table width="100%" style="font-size: 10pt;">
	  			<tr>
	  				<td style="border-bottom: 1px solid #333;padding: 5px 3px; font-weight: bold;text-align: center;">Total Akhir Laba Rugi</td>
	  				<td style="text-align: right;border: 1px solid #333;padding: 5px 3px;font-weight: bold;">{{ ($DatatotalAktiva2 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva2).")") : number_format($DatatotalAktiva2) }}</td>
	  			</tr>
	  		</table>
	  	</td>
	  </tr>     
	</table>

@else
	<table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
		<thead>
			<tr>
				<th style="text-align: left;">Laporan Laba Rugi Keuangan {{ ($throttle == "bulan") ? "Bulanan" : "Tahunan" }}</th>
				<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
			</tr>
		</thead>
	</table>

	<table width="100%" border="0" style="font-size: 8pt;">
		<thead>
			<tr>
				@if($throttle == "bulan")
					<td style="text-align: left;">Periode : Bulan {{ $request["m"]."/".$request["y"] }}</td>
				@else
					<td style="text-align: left;">Periode : Tahun {{ $request["y"] }}</td>
				@endif

				<td style="text-align: right;">Berdasarkan Desain Laba Rugi Yang Aktif Periode Ini</td>
			</tr>
		</thead>
	</table>

	<table id="content" width="85%" border="0" style="font-size: 9pt; margin-top: 5px;">
		<thead>
			<tr>
				<td style="text-align: center;border: 1px solid #333; vertical-align: top;">
					<table width="100%" id="bingkai" style="font-size: 8pt;">
		                  <?php $DatatotalAktiva = 0; $tot = 0;?>
		                  @foreach($data as $dataAktiva)
		                    <?php 
		                      $header = ""; $child = ""; $total = ""; 

		                      if($dataAktiva["jenis"] == 1){
		                        $header = "header"; $totalHeader = 0;
		                      }

		                      if($dataAktiva["parrent"] != "")
		                        $child = "child";

		                      if($dataAktiva["jenis"] == 3)
		                        $total = "total";
		                    ?>


		                    @if($dataAktiva["type"] == "aktiva")
		                      
		                        @if($dataAktiva["jenis"] == "4")
		                          <tr><td colspan="2"> </td></tr>
		                          <tr><td colspan="2"> </td></tr>
		                        @else
		                          <tr>
		                            <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
		                            @if($dataAktiva["jenis"] == 2)

		                              <?php 
		                                $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @elseif($dataAktiva["jenis"] == 3)
		                            	<td style="border-top: 2px solid #999"></td>
		                              <?php 
		                                $show = ($mydatatotal[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal[$dataAktiva["nomor_id"]]); 
		                              ?>

		                              <td class="{{ $total }}" style="text-align: right;">{{ str_replace("-", "", $show) }}</td>
		                            @endif
		                          </tr>
		                        @endif

		                      <?php 
		                        $DatatotalAktiva += $dataAktiva["total"];
		                        if($dataAktiva["jenis"] == 3)
		                          $tot++;
		                      ?>
		                    @endif

		                  @endforeach
		            </table>
				</td>
			</tr>
		</thead>
	</table>

	<table id="tree" width="85%" style="margin-top: 20px;">
	  <tr>
	  	<td width="50%">
	  		<table width="100%" style="font-size: 10pt;">
	  			<tr>
	  				<td style="border-bottom: 1px solid #333;padding: 5px 3px; font-weight: bold;text-align: center;">Total Akhir Laba Rugi</td>
	  				<td style="text-align: right;border: 1px solid #333;padding: 5px 3px;font-weight: bold;">{{ ($DatatotalAktiva < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva).")") : number_format($DatatotalAktiva) }}</td>
	  			</tr>
	  		</table>
	  	</td>
	  </tr>     
	</table>
@endif





