
<?php

	function print_tes(){
		return "okee";
	}

	function get_sub($data, $parrent){
		$html = "";
		foreach ($data as $dataDetail) {
			
			$view = ($dataDetail["total"] < 0) ? "(".number_format($dataDetail["total"], 2).")" : number_format($dataDetail["total"], 2);
			if($dataDetail["parrent"] == $parrent){
				$html = $html.'<tr class="treegrid-'.$dataDetail["nomor_id"].' treegrid-parent-'.$dataDetail["parrent"].'">
                            <td>'.$dataDetail["nama_perkiraan"].'</td><td class="text-right">'.str_replace("-", "", $view).'</td>
                         </tr>';
			}
		}

		return $html;
	}

?>