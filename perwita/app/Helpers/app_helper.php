
<?php

	function print_tes(){
		return "okee";
	}

	function get_sub($data, $parrent, $data_akun){
		$html = "";
		foreach ($data as $dataDetail) {
			
			$view = ($dataDetail["total"] < 0) ? "(".number_format($dataDetail["total"], 2).")" : number_format($dataDetail["total"], 2);
			if($dataDetail["parrent"] == $parrent){
				$html = $html.'<tr class="treegrid-'.$dataDetail["nomor_id"].' treegrid-parent-'.$dataDetail["parrent"].'" id="'.$dataDetail["nomor_id"].'">
                            <td>'.$dataDetail["nama_perkiraan"].' ('.$dataDetail["nomor_id"].')</td><td class="text-right" id="tot-'.$dataDetail["nomor_id"].'">'.str_replace("-", "", $view).'</td>
                         </tr>';

                 $html = $html.get_akun($data_akun, $dataDetail["nomor_id"]);
			}
		}

		return $html;
	}

	function get_akun($data_akun, $nomor_id){
		$html = '';

        foreach ($data_akun as $akun) {
        	$view = ($akun["total"] < 0) ? "(".number_format($akun["total"], 2).")" : number_format($akun["total"], 2);
        	if($akun["nomor_id"] == $nomor_id){
        		$html = $html.'<tr class="treegrid-'.$akun["id_akun"].' treegrid-parent-'.$nomor_id.'">
                            <td>'.$akun["nama_akun"].' ('.$akun["id_akun"].')</td><td class="text-right">'.str_replace("-", "", $view).'</td>
                         </tr>';
        	}
        }

		return $html;
	}

?>