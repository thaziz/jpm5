

<?php

	function perusahaan(){
		$pt_nama = DB::table('master_perusahaan')->first();

		return $pt_nama;
	}

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

	function get_akun($data_akun, $nomor_id, $idx = null){
		$html = '';

        foreach ($data_akun as $akun) {
        	$show = ($akun["is_parrent"]) ? "none" : "";
            $nama = (strlen($akun["nama_akun"]) > 35) ? substr($akun["nama_akun"], 0, 33)."..." : $akun["nama_akun"];
        	$view = ($akun["total"] < 0) ? "(".number_format($akun["total"], 2).")" : number_format($akun["total"], 2);
        	if($akun["nomor_id"] == $nomor_id){
        		$html = $html.'<tr class="treegrid-'.$akun["id_akun"].' treegrid-parent-'.$nomor_id.'" id="'.$akun["id_akun"].'">
                            <td>'.$nama.'</td><td class="text-right" style="display:'.$show.'" id="tot-'.$idx.$akun["id_akun"].'">'.str_replace("-", "", $view).'</td>
                         </tr>';

                $html = $html.get_akun($data_akun, $akun["id_akun"], $idx);
        	}
        }

		return $html;
	}

	function get_periode(){
		$data = DB::table("d_periode_keuangan")->select("*")->orderBy("bulan", 'asc')->get();

		return $data;
	}

	function cek_periode($month = null, $year = null, $withMonth = true){
		if($month == null)
			$month = date('m');

		if($year == null)
			$year = date('Y');

		if($withMonth)
			$data = DB::table("d_periode_keuangan")->where("bulan", $month)->where("tahun", $year)->select("*")->get();
		else
			$data = DB::table("d_periode_keuangan")->where("tahun", $year)->select("*")->get();
		

		return count($data);
	} //JIKA COUNT == 0, maka belum tutup periode, jika ada maka tidak kosong

	
?>