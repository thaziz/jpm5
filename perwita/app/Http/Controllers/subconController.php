<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use PDF;
use DB;
use Auth;
use Redirect;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Yajra\Datatables\Datatables;


class subconController extends Controller
{

	public function subcon(){
		$cabang =Auth::user()->kode_cabang;
			$data = DB::table('kontrak_subcon')
				 ->join('cabang','kode','=','ks_cabang')
				 ->orderBy('ks_id','asc')
				 ->get();

			$subcon = DB::table('subcon')
				 ->get();

	

		for ($i=0; $i < count($data); $i++) { 
			$tgl1[$i] = Carbon::parse($data[$i]->ks_tgl_mulai)->format('d/m/Y');
			$tgl2[$i] = Carbon::parse($data[$i]->ks_tgl_akhir)->format('d/m/Y');
			for ($a=0; $a < count($subcon); $a++) { 
				if ($data[$i]->ks_nama == $subcon[$a]->kode) {
					$data[$i]->nama_subcon = $subcon[$a]->nama;
				}
			}
		}

		for ($i=0; $i < count($data); $i++) { 
			if(!isset($data[$i]->nama_subcon)){
				$data[$i]->nama_subcon = 'DATA TIDAK DITEMUKAN';
			}
		}
		return view('master_subcon.indexSubcon',compact('data','tgl1','tgl2','subcon'));
	}

	public function tambahkontraksubcon(){

	

		$data = DB::table('subcon')
				 ->leftjoin('kontrak_subcon','kode','=','ks_nama')
				 ->where('ks_nama',null)
				 ->get();

		$now = Carbon::now()->format('d-m-Y');

		$tgl2 = Carbon::parse($now)->subDay(-7)->format('d-m-Y');
		$jenis_tarif = DB::table('jenis_tarif')
					     ->get();
		$cabang = DB::table('cabang')
					->get();
		$kota   = DB::table('kota')
					->get();
		$angkutan = DB::table('tipe_angkutan')
					  ->get();
		
		return view('master_subcon.tambahkontraksubcon',compact('jenis_tarif','data','now','cabang','kota','angkutan','tgl2'));
	}

	public function hapus_subcon(request $request)
	{
		$hapus = DB::table('kontrak_subcon')
				   ->where('ks_id',$request->id)
				   ->delete();
		return 'Success';
	}

	public function save_subcon(request $request){
		// dd($request->all());
        return DB::transaction(function() use ($request) {  

		if (isset($request->ck_aktif)) {
			$cek = 'ACTIVE';
		}else{
			$cek = 'NOT ACTIVE';
		}

		
		
		$request->kontrak_nomor = str_replace(' ', '', $request->kontrak_nomor);

		$cari_nota = DB::table('kontrak_subcon')
						->where('ks_nota',$request->kontrak_nomor)
						->where('ks_cabang',$request->cabang)
						->where('ks_nama',$request->id_subcon)
						->first();

		if($cari_nota != null){
			$id = $cari_nota->ks_id;
			$data = array(
							'ks_nota'		=>	$request->kontrak_nomor,
							'ks_tgl'		=>	Carbon::parse($request->ed_tanggal)->format('Y-m-d'),
							'ks_tgl_mulai'	=>  Carbon::parse($request->ed_mulai)->format('Y-m-d'),
							'ks_tgl_akhir'  =>	Carbon::parse($request->ed_akhir)->format('Y-m-d'),
							'ks_cabang'		=>	$request->cabang,
							'ks_keterangan' =>	strtoupper($request->ed_keterangan),
							'ks_active'		=>	$cek,	
							'ks_edit'		=>  'UNALLOWED',
							'ks_nama'		=>	$request->id_subcon,
							'updated_at'	=>	Carbon::now(),
							'updated_by'	=>  Auth::user()->m_username,
						);

			$kontrak_subcon = DB::table('kontrak_subcon')
								->where('ks_id',$id)
								->update($data);
		}else{
			$cari_id = DB::table('kontrak_subcon')
                          ->where('ks_nota',$request->kontrak_nomor)
                          ->first();

            if ($cari_id != null) {
              $id = $cari_id->ks_id;
            }else{
              $id = DB::table('kontrak_subcon')
				->max('ks_id');

			  if ($id == null) {
				$id = 1;
			  }else{
				$id+=1;
			  }

            }

            $data = array(
							'ks_id'			=>	$id,
							'ks_nota'		=>	$request->kontrak_nomor,
							'ks_tgl'		=>	Carbon::parse($request->ed_tanggal)->format('Y-m-d'),
							'ks_tgl_mulai'	=>  Carbon::parse($request->ed_mulai)->format('Y-m-d'),
							'ks_tgl_akhir'  =>	Carbon::parse($request->ed_akhir)->format('Y-m-d'),
							'ks_cabang'		=>	$request->cabang,
							'ks_keterangan' =>	strtoupper($request->ed_keterangan),
							'ks_active'		=>	$cek,	
							'ks_edit'		=>  'UNALLOWED',
							'ks_nama'		=>	$request->id_subcon,
							'updated_at'	=>	Carbon::now(),
							'created_at'	=>	Carbon::now(),
							'updated_by'	=>  Auth::user()->m_username,
						    'created_by'	=>  Auth::user()->m_username,
						);


            
         
	          if ($cari_id != null) {

	            $save_kontrak = DB::table('kontrak_subcon')
	                            ->where('ks_id',$id)
	                            ->update($data);
	          }else{
	            $save_kontrak = DB::table('kontrak_subcon')
	                            ->insert($data);
	          }
		}
		



			

			

		if ($request->id_detail == '') {
		  $id_dt = DB::table('kontrak_subcon_dt')
                    ->max('ksd_id');

          $dt = DB::table('kontrak_subcon_dt')
                    ->where('ksd_nota',$request->kontrak_nomor)
                    ->max('ksd_ks_dt');

          if ($dt == null) {
              $dt = 1;
          }else{
              $dt += 1;
          }

          if ($id_dt == null) {
              $id_dt = 1;
          }else{
              $id_dt += 1;
          }

        }else{
          $dt = $request->id_detail;
        }
        
        

        if ($request->id_detail == '') {

        	$data_dt = array(
                            'ksd_id'			=> $id_dt,
					   		'ksd_ks_id'			=> $id,
					   		'ksd_ks_dt'			=> $dt,
					   		'ksd_keterangan'	=> strtoupper($request->keterangan),
					   		'ksd_asal'			=> $request->asal,
					   		'ksd_tujuan'		=> $request->tujuan,
					   		'ksd_angkutan'		=> $request->angkutan,
					   		'ksd_harga'			=> filter_var($request->harga, FILTER_SANITIZE_NUMBER_INT),
					   		'ksd_jenis_tarif'	=> $request->tarif,
					   		'ksd_nota'       	=> $request->kontrak_nomor,
					   		'updated_at'		=>	Carbon::now(),
							'created_at'		=>	Carbon::now()
                        );

         	$save_detail = DB::table('kontrak_subcon_dt')
                          ->insert($data_dt);
        }else{

        	$data_dt = array(
					   		'ksd_keterangan'	=> strtoupper($request->keterangan),
					   		'ksd_asal'			=> $request->asal,
					   		'ksd_tujuan'		=> $request->tujuan,
					   		'ksd_angkutan'		=> $request->angkutan,
					   		'ksd_harga'			=> filter_var($request->harga, FILTER_SANITIZE_NUMBER_INT),
					   		'ksd_nota'       	=> $request->kontrak_nomor,
					   		'ksd_jenis_tarif'	=> $request->tarif,
					   		'updated_at'		=>	Carbon::now(),
                        );

          	$save_detail = DB::table('kontrak_subcon_dt')
                          ->where('ksd_nota',$request->kontrak_nomor)
                          ->where('ksd_ks_dt',$request->id_detail)
                          ->update($data_dt);
        }

         // $data = ['kontrak'=>url('master_sales/edit_kontrak/'.$request->id),'status'=>'Customer'];

        // Mail::send('hello', $data, function ($mail)
        //     {
        //       // Email dikirimkan ke address "momo@deviluke.com" 
        //       // dengan nama penerima "Momo Velia Deviluke"
        //       $mail->from('jpm@gmail.com', 'SYSTEM JPM');
        //       $mail->to('dewa17a@gmail.com', 'Admin');
         
        //       // Copy carbon dikirimkan ke address "haruna@sairenji" 
        //       // dengan nama penerima "Haruna Sairenji"
        //       $mail->cc('dewa17a@gmail.com', 'ADMIN JPM');
         
        //       $mail->subject('KONTRAK VERIFIKASI');
        //     });

        

        

        return response()->json(['status'=>1]);

    	});
	}

	public function edit_subcon($id){
		$data = DB::table('kontrak_subcon')
				 ->join('cabang','kode','=','ks_cabang')
				 ->where('ks_id',$id)
				 ->orderBy('ks_id','asc')
				 ->first();

		$subcon = DB::table('kontrak_subcon')
				 ->join('subcon','kode','=','ks_nama')
				 ->where('ks_id',$id)
				 ->orderBy('ks_id','asc')
				 ->first();
		$jenis_tarif = DB::table('jenis_tarif')
					     ->get();
		 $subcon_dt = DB::SELECT("SELECT kontrak_subcon.*,kontrak_subcon_dt.*, asal.nama as asal ,asal.id as id_asal,
						 				tujuan.nama as tujuan, tujuan.id as id_tujuan,
						 				angkutan.kode as kode_angkutan, angkutan.nama as angkutan
									    from kontrak_subcon 
									    inner join kontrak_subcon_dt
									    on ksd_ks_id = ks_id
									    inner join 
									    (SELECT nama,id from kota) as asal
									    on asal.id = ksd_asal
									    inner join 
							 	 	    (SELECT nama,id from kota) as tujuan
								 	    on tujuan.id = ksd_tujuan
								 	    inner join
								 	    (SELECT kode,nama from tipe_angkutan) as angkutan
								 	    on angkutan.kode  = ksd_angkutan
								 	    where ks_id = '$id'");

		for ($i=0; $i < count($subcon_dt); $i++) { 
		 	$subcon_dt[$i]->ksd_harga = round($subcon_dt[$i]->ksd_harga);
		}
		

		$sub = DB::table('subcon')
				 ->get();

		$cabang = DB::table('cabang')
					->get();
		$kota   = DB::table('kota')
					->get();
		$angkutan = DB::table('tipe_angkutan')
					->get();

		$tgl1 = Carbon::parse($data->ks_tgl_mulai)->format('d-m-Y');
		$tgl2 = Carbon::parse($data->ks_tgl_akhir)->format('d-m-Y');
		$tgl3 = Carbon::parse($data->ks_tgl)->format('d-m-Y');


		return view('master_subcon.editSubcon',compact('data','subcon','subcon_dt','tgl1','tgl2','tgl3','cabang','kota','angkutan','sub','jenis_tarif','id'));
	}

	public function update_subcon(request $request){
		// dd($request->all());
		$request->ed_tanggal = str_replace('/', '-', $request->ed_tanggal);
		$request->ed_mulai = str_replace('/', '-', $request->ed_mulai);
		$request->ed_akhir = str_replace('/', '-', $request->ed_akhir);
		
		if (isset($request->ck_aktif)) {
			$cek = 'ACTIVE';
		}else{
			$cek = 'NOT ACTIVE';
		}

		$request->kontrak_nomor = str_replace(' ', '', $request->kontrak_nomor);
		
		$kontrak_subcon = DB::table('kontrak_subcon')
							->where('ks_id',$request->id)
							->update([
								'ks_tgl'		=>	Carbon::parse($request->ed_tanggal)->format('Y-m-d'),
								'ks_tgl_mulai'	=>  Carbon::parse($request->ed_mulai)->format('Y-m-d'),
								'ks_tgl_akhir'  =>	Carbon::parse($request->ed_akhir)->format('Y-m-d'),
								'ks_keterangan' =>	$request->ed_keterangan,
								'ks_active'		=>	$cek,	
								'ks_edit'		=>  'UNALLOWED',
								'updated_at'	=>	Carbon::now(),
								'updated_by'	=>  Auth::user()->m_username,
							]);


		for ($i=0; $i < count($request->asal_tb); $i++) { 

			$harga=str_replace('.', '', $request->harga_tb[$i]);

			$id_dt = DB::table('kontrak_subcon_dt')
					   ->max('ksd_id');

			if ($id_dt == null) {
				$id_dt = 1;
			}else{
				$id_dt+=1;
			}

			if ($request->aktif[$i] == 'on') {
               $kcd_aktif[$i] = true;
            }else{
               $kcd_aktif[$i] = false;
            }

			if ($request->id_ksd[$i] != '0') {
				$kontrak_subcon_dt = DB::table('kontrak_subcon_dt')
									->where('ksd_id',$request->id_ksd[$i])
								    ->update([
								   		'ksd_ks_id'			=> $request->id,
								   		'ksd_ks_dt'			=> $i+1,
								   		'ksd_keterangan'	=> $request->keterangan_tb[$i],
								   		'ksd_asal'			=> $request->asal_tb[$i],
								   		'ksd_tujuan'		=> $request->tujuan_tb[$i],
								   		'ksd_angkutan'		=> $request->angkutan_tb[$i],
								   		'ksd_harga'			=> $harga,
								   		'ksd_jenis_tarif'	=> $request->tarif_tb[$i],
								   		'ksd_active'		=> $kcd_aktif[$i],
								   		'updated_at'		=>	Carbon::now(),
								   ]);
			}else{
				$kontrak_subcon_dt = DB::table('kontrak_subcon_dt')
								   ->insert([
								   		'ksd_id'			=> $id_dt,
								   		'ksd_ks_id'			=> $request->id,
								   		'ksd_ks_dt'			=> $i+1,
								   		'ksd_keterangan'	=> $request->keterangan_tb[$i],
								   		'ksd_asal'			=> $request->asal_tb[$i],
								   		'ksd_tujuan'		=> $request->tujuan_tb[$i],
								   		'ksd_angkutan'		=> $request->angkutan_tb[$i],
								   		'ksd_harga'			=> $harga,
								   		'ksd_jenis_tarif'	=> $request->tarif_tb[$i],
								   		'updated_at'		=>	Carbon::now(),
								   		'ksd_active'		=> $kcd_aktif[$i],
										'created_at'		=>	Carbon::now()
								   ]);
			}
			
		}

		 $data = ['kontrak'=>url('master_subcon/edit_subcon/'.$request->id),'status'=>'Subcon'];
         // if (in_array(false, $kcd_aktif)) {
         //   Mail::send('hello', $data, function ($mail)
         //  {
         //    // Email dikirimkan ke address "momo@deviluke.com" 
         //    // dengan nama penerima "Momo Velia Deviluke"
         //    $mail->from('jpm@gmail.com', 'SYSTEM JPM');
         //    $mail->to('dewa17a@gmail.com', 'Admin');
       
         //    // Copy carbon dikirimkan ke address "haruna@sairenji" 
         //    // dengan nama penerima "Haruna Sairenji"
         //    $mail->cc('dewa17a@gmail.com', 'ADMIN JPM');
       
         //    $mail->subject('KONTRAK VERIFIKASI');
         //  });
         // }
		// return $db = DB::table('kontrak_subcon_dt')
		// 				->get();
		return 'Success';

	}	
	public function cek_hapus(request $request){
		// dd($request);
		$cari_id = DB::table('kontrak_subcon')
		 		  ->join('kontrak_subcon_dt','ksd_ks_id','=','ks_id')
				  ->where('ksd_id',$request->id)
				  ->get();

		// return $nota =  $cari_id[0]->ks_nota;
		if ($cari_id != null) {
			$cari_faktur = DB::table('pembayaran_subcon')
								 ->join('faktur_pembelian','fp_nofaktur','=','pb_faktur')
								 // ->where('pb_ref',$nota)
								 ->where('pb_jenis_kendaraan',$cari_id[0]->ksd_angkutan)
								 ->where('pb_asal',$cari_id[0]->ksd_asal)
								 ->where('pb_tujuan',$cari_id[0]->ksd_tujuan)
								 ->where('fp_netto',$cari_id[0]->ksd_harga)
								 ->get();
		}else{
			$cari_faktur = null;
		}
		

		if ($cari_faktur == null) {
			return response()->json([
							'status' => 1
						]);
		}else{
			return response()->json([
							'status' => 0
						]);
		}
	}
public function nota_kontrak_subcon(request $request)
{

	$year =Carbon::now()->format('y'); 
	$month =Carbon::now()->format('m'); 
	$idfaktur =   DB::table('kontrak_subcon')
						->where('ks_cabang' , $request->cabang)
						->max('ks_nota');
		//	dd($nosppid);
		if(isset($idfaktur)) {
			$explode  = explode("/", $idfaktur);
			$idfaktur = $explode[2];
			$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
			$idfaktur = str_replace('-', '', $idfaktur) ;
			$string = (int)$idfaktur + 1;
			$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
		}

		else {
			$idfaktur = '001';
		}

		$nota = 'KSC' . $month . $year . '/' . $request->cabang . '/' .  $idfaktur;
		return response()->json(['nota'=>$nota]);
}

public function datatable_kontrak(request $request)
{
	// dd($request->all());
		$data = DB::table('kontrak_subcon_dt')
                  ->where('ksd_nota',$request->nota)
                  ->orderBy('ksd_ks_dt','ASC')
                  ->get();
        
        
        // return $data;
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('harga', function ($data) {
                                return number_format($data->ksd_harga,0,',','.');
                        })
                        ->addColumn('asal', function ($data) {

                          $kota = DB::table('kota')
                                    ->get();

                          $tipe_angkutan = DB::table('tipe_angkutan')
                                    ->get();

                          for ($a=0; $a < count($kota); $a++) { 
                            if ($data->ksd_asal == $kota[$a]->id) {
                              $kota_asal = $kota[$a]->nama;
                            }
                          }
                          return $data->ksd_asal . '-' . $kota_asal;
                                
                        })
                        ->addColumn('tujuan', function ($data) {

                          $kota = DB::table('kota')
                                    ->get();

                          $tipe_angkutan = DB::table('tipe_angkutan')
                                    ->get();

                          for ($a=0; $a < count($kota); $a++) { 
                            if ($data->ksd_tujuan == $kota[$a]->id) {
                              $kota_tujuan = $kota[$a]->nama;
                            }
                          }
                          return $data->ksd_tujuan . '-' . $kota_tujuan;
                        })
                        ->addColumn('angkutan', function ($data) {
                          $kota = DB::table('kota')
                                    ->get();

                          $tipe_angkutan = DB::table('tipe_angkutan')
                                    ->get();

                          for ($a=0; $a < count($tipe_angkutan); $a++) { 
                            if ($data->ksd_angkutan == $tipe_angkutan[$a]->kode) {
                              $angkutan = $tipe_angkutan[$a]->nama;
                            }
                          }
                          return $data->ksd_angkutan . '-' . $angkutan;
                        })
                        ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-warning edit btn-sm" title="edit">'.
                                   '<label class="fa fa-pencil"></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger hapus btn-sm" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })
                        ->addColumn('tarif', function ($data) {
                          $jt = DB::table('jenis_tarif')
                                    ->get();
                          for ($a=0; $a < count($jt); $a++) { 
                            if ($data->ksd_jenis_tarif == $jt[$a]->jt_id) {
                              $jt = $jt[$a]->jt_nama_tarif;
                            }
                          }
                          return $jt;
                        })
                        ->addColumn('active', function ($data) {
                          if (Auth::user()->punyaAkses('Verifikasi','aktif')) {
                            if($data->ksd_active == true){
                              return '<input checked type="checkbox" onchange="check(this)" class="form-control check">';
                            }else{
                              return '<input type="checkbox" onchange="check(this)" class="form-control check">';
                            }
                          }else{
                              return '-';
                          }
                           
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->make(true);
}
public function set_modal(request $request)
{
	$data = DB::table('kontrak_subcon_dt')
                ->where('ksd_nota',$request->nota)
                ->where('ksd_ks_dt',$request->ksd_dt)
                ->first();
    return response()->json(['data'=>$data]);
}

public function hapus_d_kontrak(request $request)
{
// return $request->all();
  $data = DB::table('kontrak_subcon_dt')
            ->where('ksd_nota',$request->nota)
            ->where('ksd_ks_dt',$request->ksd_dt)
            ->delete();
}
public function check_kontrak(request $request)
{
	if ($request->check == 'true') {
         // return $request->check;

        $data_dt = DB::table('kontrak_subcon_dt')
            ->where('ksd_nota',$request->nota)
            ->where('ksd_ks_dt',$request->kcd_dt)
            ->update([
              'ksd_active' => true 
            ]);

         
         return json_encode('success 1');

    }else{

      $data_dt = DB::table('kontrak_subcon_dt')
            ->where('ksd_nota',$request->nota)
            ->where('ksd_ks_dt',$request->kcd_dt)
            ->update([
              'ksd_active' => $request->check 
            ]);
         return json_encode('success 2');
    }
}
}

