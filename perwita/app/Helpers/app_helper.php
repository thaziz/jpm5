
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

	function get_jurnal($id_jurnal){
         return DB::select(DB::raw("select * from d_jurnal_dt where jrdt_jurnal = '".$id_jurnal."'"));
      }

	function get_id_jurnal($state, $cab, $date = null){

		// $digit = substr($state, 0, 2);

		if(substr($state, 0, 1) == 'B'){
			
			$digit = strlen(explode('-', $state)[0]);

			if(is_null($date)){
				$jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_no, 1, ".$digit.")"), $state)->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y'))->orderBy('jr_insert', 'desc')->first();

				$jr_no = ($jr) ? (explode('/', $jr->jr_no)[2] + 1) : 1;
		        $jr_no = $state."-".date("my")."/".$cab."/".str_pad($jr_no, 4, '0', STR_PAD_LEFT);
			}else{
				$jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_no, 1, ".$digit.")"), $state)->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y', strtotime($date)))->orderBy('jr_insert', 'desc')->first();

				$jr_no = ($jr) ? (explode('/', $jr->jr_no)[2] + 1) : 1;
		        $jr_no = $state."-".date("my", strtotime($date))."/".$cab."/".str_pad($jr_no, 4, '0', STR_PAD_LEFT);
			}
		}else{

			$digit = substr($state, 0, 2);

			if(is_null($date)){
				$jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_no, 1, 2)"), $digit)->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y'))->orderBy('jr_insert', 'desc')->first();

				$jr_no = ($jr) ? (explode('/', $jr->jr_no)[2] + 1) : 1;
		        $jr_no = $state."-".date("my")."/".$cab."/".str_pad($jr_no, 4, '0', STR_PAD_LEFT);
			}else{
				$jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_no, 1, 2)"), $digit)->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y', strtotime($date)))->orderBy('jr_insert', 'desc')->first();

				$jr_no = ($jr) ? (explode('/', $jr->jr_no)[2] + 1) : 1;
		        $jr_no = $state."-".date("my", strtotime($date))."/".$cab."/".str_pad($jr_no, 4, '0', STR_PAD_LEFT);
			}
		}

        return $jr_no;
	}


	function get_total_neraca_parrent($id, $deep, $initiate, $date, $throttle, $array, $withCommas = false){
		$tot = 0; $search = strlen($id);

		if($deep == 2){
			foreach ($array as $key => $value) {
				if($value->jenis == 2 && substr($value->nomor_id, 0, $search) == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($detail->akun as $key => $akun) {
							$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;

							if($throttle == 'bulan')
                              $coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;
                            else
                              $coalesce = (date('Y', strtotime($date)) < date('Y', strtotime($akun->opening_date))) ? 0 : $akun->coalesce;

							if($initiate == 'A' && $akun->akun_dka == 'K')
								$tot -= ($coalesce + $boundary);
							else if($initiate == 'P' && $akun->akun_dka == 'D')
								$tot -= ($coalesce + $boundary);
							else
								$tot += ($coalesce + $boundary);

						}
					}
				}
			}
		}elseif($deep == 3){
			foreach ($array as $key => $value) {
				if($value->jenis == 2 && $value->nomor_id == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($detail->akun as $key => $akun) {
							$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;

							if($throttle == 'bulan')
                              $coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;
                            else
                              $coalesce = (date('Y', strtotime($date)) < date('Y', strtotime($akun->opening_date))) ? 0 : $akun->coalesce;

							if($initiate == 'A' && $akun->akun_dka == 'K')
								$tot -= ($coalesce + $boundary);
							else if($initiate == 'P' && $akun->akun_dka == 'D')
								$tot -= ($coalesce + $boundary);
							else
								$tot += ($coalesce + $boundary);
						}
					}
				}
			}
		}else if($deep == 4){
			foreach ($array as $key => $value) {
				if($value->jenis == 3 && $value->nomor_id == $id){
					foreach ($value->detail as $key => $detail) {
						
						foreach ($array as $key => $data_array) {
							if($data_array->jenis == 2 && $data_array->nomor_id == $detail->id_group){
								foreach ($data_array->detail as $key => $detail_array) {
									foreach ($detail_array->akun as $key => $akun) {
										$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;

										if($throttle == 'bulan')
			                              $coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;
			                            else
			                              $coalesce = (date('Y', strtotime($date)) < date('Y', strtotime($akun->opening_date))) ? 0 : $akun->coalesce;
										
										if($initiate == 'A' && $akun->akun_dka == 'K')
											$tot -= ($coalesce + $boundary);
										else if($initiate == 'P' && $akun->akun_dka == 'D')
											$tot -= ($coalesce + $boundary);
										else
											$tot += ($coalesce + $boundary);
									}
								}
							}
						}

					}
				}
			}
		}elseif($deep == 5){
			// return $id;
			foreach ($array as $key => $value) {
				if($value->jenis == 2 && $value->nomor_id == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($detail->akun as $key => $akun) {
							$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;

							if($throttle == 'bulan')
                              $coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;
                            else
                              $coalesce = (date('Y', strtotime($date)) < date('Y', strtotime($akun->opening_date))) ? 0 : $akun->coalesce;

							if($initiate == 'A' && $akun->akun_dka == 'K')
								$tot -= ($coalesce + $boundary);
							else if($initiate == 'P' && $akun->akun_dka == 'D')
								$tot -= ($coalesce + $boundary);
							else
								$tot += ($coalesce + $boundary);
						}
					}
				}
			}
		}

		if($withCommas)
			return ($tot >= 0) ? number_format($tot, 2) : "(".number_format(str_replace("-", "", $tot), 2).")";
		else
			return $tot;

		// return $tot;
	}

	function get_total_arus_kas_parrent($id, $deep, $initiate, $date, $array){
		$tot = 0; $search = strlen($id);

		if($deep == 2){
			foreach ($array as $key => $value) {
				if($value->jenis == 2 && substr($value->nomor_id, 0, $search) == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($detail->akun as $key => $akun) {
							$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;
							$coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;

							$tot += $boundary;

							if($value->type == 'aktiva')
                                $tot = $tot * -1;

						}
					}
				}
			}
		}elseif($deep == 3){
			foreach ($array as $key => $value) {
				if($value->jenis == 2 && $value->nomor_id == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($detail->akun as $key => $akun) {
							$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;
							$coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;

							$tot += $boundary;

							if($value->type == 'aktiva')
                                $tot = $tot * -1;
						}
					}
				}
			}
		}else if($deep == 4){
			foreach ($array as $key => $value) {
				if($value->jenis == 3 && $value->nomor_id == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($array as $key => $data_array) {
							if($data_array->jenis == 2 && $data_array->nomor_id == $detail->id_group){
								foreach ($data_array->detail as $key => $detail_array) {
									foreach ($detail_array->akun as $key => $akun) {
										$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;
										$coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;

										if($data_array->type == 'aktiva'){
											$boundary = $boundary * -1;
										}

										$tot += $boundary;
									}
								}
							}
						}

					}
				}
			}
		}elseif($deep == 5){
			// return $id;
			foreach ($array as $key => $value) {
				if($value->jenis == 2 && $value->nomor_id == $id){
					foreach ($value->detail as $key => $detail) {
						foreach ($detail->akun as $key => $akun) {
							$boundary = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;
							$coalesce = (strtotime($date) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;

							$tot += $boundary;

							if($value->type == 'aktiva')
                                $tot = $tot * -1;
						}
					}
				}
			}
		}

		return ($tot < 0) ? '('.number_format(str_replace('-', '', $tot), 2).')' : number_format($tot, 2);

		// return ($tot >= 0) ? number_format($tot, 2) : "(".number_format(str_replace("-", "", $tot), 2).")";
		// return $tot;
	}

	function get_saldo_awal_arus_kas($array, $date, $throttle){
		$tot = 0;
		foreach ($array as $key => $data) {
			$mutasi = (count($data->mutasi_bank_debet) > 0) ? $data->mutasi_bank_debet[0]->total : 0;

			if($throttle == 'bulan')
              $saldo = (strtotime($date) < strtotime($data->opening_date)) ? 0 : $data->saldo;
            else
              $saldo = (date('Y', strtotime($date)) < date('Y', strtotime($data->opening_date))) ? 0 : $data->saldo;

			$tot += ($saldo + $mutasi);
		}

		return $tot;
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

	

	function getnotabm($cabang , $tgl , $kodeterima){


		$buland = date("m" , strtotime($tgl));
        $tahund = date("y" , strtotime($tgl));
       // dd($kodeterima);
        if($kodeterima != '999'){
   	        $kode = DB::select("select * from masterbank where mb_id = '$kodeterima'");
   	          //      dd($kode);
	        $akunbank = $kode[0]->mb_kode;
	        $idkode = $kode[0]->mb_id;
        }
        else {
        	$kode = '99';
        	$akunbank = '100211000';
        	$idkode = '99';
        }

        //
       $idbm = DB::select("select substr(MAX(bm_nota) , 15) as bm_nota from bank_masuk where bm_cabangtujuan = '000' and to_char(bm_tglterima, 'MM') = '$buland' and to_char(bm_tglterima, 'YY') = '$tahund' and bm_banktujuan = '110311000'");


		$index = (integer)$idbm[0]->bm_nota + 1;
     	
     	

     	if($idkode < 10){
     		$kodebank = '0'.(integer)$idkode;
     	}
     	else {
     		$kodebank = $idkode;
     	}

     	$index = str_pad($index, 4, '0', STR_PAD_LEFT);

        $notabm = 'BM' . $kodebank . '-' . $buland . $tahund . '/' . $cabang . '/' . $index;

        return $notabm;
	}

	function getdka($kode){
		$data = DB::select("select * from d_akun where id_akun = '$kode'");
		$dk = $data[0]->akun_dka;

		return $dk;
	}

	function getnotakm($cabang, $tgl){
		$bulan = date("m" , strtotime($tgl));
        $year = date("y" , strtotime($tgl));

		$datanotakm = DB::select("SELECT  substring(max(km_nota),13) as id from kas_masuk
                                    WHERE km_cabangterima = '$cabang'
                                    AND to_char(km_tgl,'MM') = '$bulan'
                                    AND to_char(km_tgl,'YY') = '$year'");

		

		if($datanotakm[0]->id == null) {
			$id = 0;
			$string = (int)$id + 1;
			$data['idkm'] = str_pad($string, 4, '0', STR_PAD_LEFT);

		}
		else {
			$string = (int)$datanotakm[0]->id + 1;
			$data['idkm'] = str_pad($string, 4, '0', STR_PAD_LEFT);
		}

		$notakm = 'KM/' . $bulan . $year . '/' . $cabang . '/' . $data['idkm'];

		return $notakm;
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