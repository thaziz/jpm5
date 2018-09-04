
<?php

	function perusahaan(){
		$pt_nama = DB::table('master_perusahaan')->first();

		return $pt_nama;
	}

	function cabang(){
		$cabang = DB::table('cabang')->get();

		return $cabang;
	}

	function print_tes(){
		return "okee";
	}

	function get_id_jurnal($state, $cab, $date = null){

		if(is_null($date)){
			$jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_no, 1, 2)"), $state)->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y'))->orderBy('jr_insert', 'desc')->first();

			$jr_no = ($jr) ? (substr($jr->jr_no, 12) + 1) : 1;
	        $jr_no = $state."-".date("my")."/".$cab."/".str_pad($jr_no, 4, '0', STR_PAD_LEFT);
		}else{
			$jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_no, 1, 2)"), $state)->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y', strtotime($date)))->orderBy('jr_insert', 'desc')->first();

			$jr_no = ($jr) ? (substr($jr->jr_no, 12) + 1) : 1;
	        $jr_no = $state."-".date("my", strtotime($date))."/".$cab."/".str_pad($jr_no, 4, '0', STR_PAD_LEFT);
		}


        return $jr_no;
	}

	function get_total_neraca_parrent($id, $array){
		$tot = 0;
		foreach ($array as $key => $value) {
			if(substr($value['nomor_id'], 0, strlen($id)) == $id && $value['jenis'] != 3 && $value['jenis'] != 4)
				$tot += $value['total'];
		}

		return ($tot >= 0) ? number_format($tot, 2) : "(".number_format(str_replace("-", "", $tot), 2).")";
		// return $tot;
	}

	function date_ind($date){
		$ret = "";
		switch ($date) {
			case '01':
				$ret = "Januari";
				break;

			case '02':
				$ret = "Februari";
				break;

			case '03':
				$ret = "Maret";
				break;

			case '04':
				$ret = "April";
				break;

			case '05':
				$ret = "Mei";
				break;

			case '06':
				$ret = "Juni";
				break;

			case '07':
				$ret = "Juli";
				break;

			case '08':
				$ret = "Agustus";
				break;

			case '09':
				$ret = "September";
				break;

			case '10':
				$ret = "Oktober";
				break;

			case '11':
				$ret = "November";
				break;

			case '12':
				$ret = "Desember";
				break;
			
			default:
				$ret = "Tidak Diketahui";
				break;
		}

		return $ret;
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
			$data = DB::table("d_periode_keuangan")->where("bulan", $month)->where("tahun", $year)->where("status", 'accessable')->select("*")->get();
		else
			$data = DB::table("d_periode_keuangan")->where("tahun", $year)->where("status", 'accessable')->select("*")->get();
		

		return count($data);
	} //JIKA COUNT == 1, maka belum tutup periode, jika ada maka tidak kosong

	

	function getnotabm($cabang){
		$buland = date('m');
        $tahund = date('y');

       $idbm = DB::select("select * from bank_masuk where bm_cabangasal = '$cabang'  and to_char(bm_tglterima, 'MM') = '$buland' and to_char(bm_tglterima, 'YY') = '$tahund' and bm_nota IS NOT NULL order by bm_id desc limit 1");

	//	$idspp =   spp_purchase::where('spp_cabang' , $request->comp)->max('spp_id');
		if(count($idbm) != 0) {		
			$explode = explode("/", $idbm[0]->bm_nota);
			$idbm = $explode[2];

			$string = (int)$idbm + 1;
			$idbm = str_pad($string, 4, '0', STR_PAD_LEFT);
		}
		else {		
			$idbm = '0001';
		}
     
        $notabm = 'BM' . '-' . $buland . $tahund . '/' . $cabang . '/' . $idbm;

        return $notabm;
	}

	function check_jurnal($nota)
	{
		$data = DB::table('d_jurnal')
				 ->join('d_jurnal_dt','jr_id','=','jrdt_jurnal')
				 ->where('jr_ref',$nota)
				 ->get();

		$d = 0;
		$k = 0;
		
		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_statusdk == 'D') {
				if ($data[$i]->jrdt_value < 0) {
					$temp = $data[$i]->jrdt_value * -1;
				}else{
					$temp = $data[$i]->jrdt_value;
				}

				$d+=$temp;
			}else{
				if ($data[$i]->jrdt_value < 0) {
					$temp = $data[$i]->jrdt_value * -1;
				}else{
					$temp = $data[$i]->jrdt_value;
				}

				$k+=$temp;
			}
		}

		if ($d == $k) {
			return 1;
		}else{
			return 0;
		}
	}

?>