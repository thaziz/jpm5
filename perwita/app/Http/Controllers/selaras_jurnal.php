<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use carbon\carbon;
use Auth;
use App\d_jurnal;
use App\d_jurnal_dt;
use Exception;
    set_time_limit(60000);
class selaras_jurnal  extends Controller
{
    public function sync_jurnal()
    {
        return 'ON DEVELOP';
    }

    public function biaya_penerus_kas(request $req)
    {
        return DB::transaction(function() use ($req) {  

            $bpk = DB::table('biaya_penerus_kas')
                     ->select('bpk_nota','bpk_comp','created_by','bpk_tanggal','bpk_kode_akun','bpk_acc_biaya','bpk_keterangan','bpk_tarif_penerus')
                     ->orderBy('bpk_id','ASC')
                     ->get();

            $comp = DB::table('biaya_penerus_kas')
                     ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
                     ->select('bpkd_kode_cabang_awal','bpk_nota')
                     ->orderBy('bpk_id','ASC')
                     ->get();

            $detail = DB::table('biaya_penerus_kas')
                     ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
                     ->orderBy('bpk_id','ASC')
                     ->get();

            $delete_jurnal = DB::table('d_jurnal')
                               ->where('jr_note','BIAYA PENERUS KAS')
                               ->delete();
            
            $comp = array_map("unserialize", array_unique( array_map( 'serialize', $comp ) ));
            $bpk = array_map("unserialize", array_unique( array_map( 'serialize', $bpk ) ));
            $comp = array_values($comp);
            $bpk = array_values($bpk);
            $filter_comp = [];
            for ($i=0; $i < count($bpk); $i++) { 
                for ($a=0; $a < count($comp); $a++) { 
                    if ($bpk[$i]->bpk_nota == $comp[$a]->bpk_nota) {
                        $filter_comp[$bpk[$i]->bpk_nota][$a] = $comp[$a]->bpkd_kode_cabang_awal;
                        
                    }
                }
                $filter_comp[$bpk[$i]->bpk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bpk[$i]->bpk_nota] ) ));
                $filter_comp[$bpk[$i]->bpk_nota] = array_values($filter_comp[$bpk[$i]->bpk_nota]);
                
            }
            
            for ($i=0; $i < count($bpk); $i++) { 
                $delete = DB::table('patty_cash')
                           ->where('pc_no_trans',$bpk[$i]->bpk_nota)
                           ->delete();

                
                // //JURNAL
                $delete_patty = DB::table('patty_cash')
	                               ->where('pc_no_trans',$bpk[$i]->bpk_nota)
	                               ->delete();
                $cari_id_pc = DB::table('patty_cash')
	                                 ->max('pc_id')+1;

                $save_patty = DB::table('patty_cash')
                       ->insert([
                            'pc_id'           => $cari_id_pc,
                            'pc_tgl'          => $bpk[$i]->bpk_tanggal,
                            'pc_ref'          => 10,
                            'pc_akun'         => $bpk[$i]->bpk_kode_akun,
                            'pc_akun_kas'     => $bpk[$i]->bpk_kode_akun,
                            'pc_keterangan'   => $bpk[$i]->bpk_keterangan,
                            'pc_asal_comp'    => $bpk[$i]->bpk_comp,
                            'pc_comp'         => $bpk[$i]->bpk_comp,
                            'pc_edit'         => 'UNALLOWED',
                            'pc_reim'         => 'UNRELEASED',
                            'pc_debet'        => $bpk[$i]->bpk_tarif_penerus,
                            'pc_user'         => $bpk[$i]->created_by,
                            'pc_no_trans'     => $bpk[$i]->bpk_nota,
                            'pc_kredit'       => 0,
                            'created_at'      => Carbon::now(),
                            'updated_at'      => Carbon::now()
                ]);
                $id_jurnal=d_jurnal::max('jr_id')+1;

                $jenis_bayar = DB::table('jenisbayar')
                                 ->where('idjenisbayar',10)
                                 ->first();

                $jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
                                            'jr_year'   => carbon::parse($bpk[$i]->bpk_tanggal)->format('Y'),
                                            'jr_date'   => carbon::parse($bpk[$i]->bpk_tanggal)->format('Y-m-d'),
                                            'jr_detail' => $jenis_bayar->jenisbayar,
                                            'jr_ref'    => $bpk[$i]->bpk_nota,
                                            'jr_note'   => 'BIAYA PENERUS KAS',
                                            'jr_insert' => carbon::now(),
                                            'jr_update' => carbon::now(),
                                            ]);

                $cari_coa = DB::table('d_akun')
                                      ->where('id_akun','like',substr($bpk[$i]->bpk_kode_akun,0, 4).'%')
                                      ->where('kode_cabang',$bpk[$i]->bpk_comp)
                                      ->first();
                    
                if ($cari_coa->akun_dka == 'D') {
                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
                    $data_akun[0]['jrdt_detailid']  = 1;
                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
                    $data_akun[0]['jrdt_value']     = -$bpk[$i]->bpk_tarif_penerus;
                    $data_akun[0]['jrdt_statusdk'] = 'K';
                	  $data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bpk[$i]->bpk_keterangan);
                }else{
                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
                    $data_akun[0]['jrdt_detailid']  = 1;
                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
                    $data_akun[0]['jrdt_value']     = -$bpk[$i]->bpk_tarif_penerus;
                    $data_akun[0]['jrdt_statusdk'] = 'D';
                	$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bpk[$i]->bpk_keterangan);
                }
                
                $jurnal_dt = d_jurnal_dt::insert($data_akun);

                $lihat_jurnal = DB::table('d_jurnal_dt')
                                ->where('jrdt_jurnal',$id_jurnal)
                                ->get();

                for ($a=0; $a < count($filter_comp[$bpk[$i]->bpk_nota]); $a++) { 
                    $harga = 0;


                    for ($b=0; $b < count($detail); $b++) { 
                        if ($filter_comp[$bpk[$i]->bpk_nota][$a] == $detail[$b]->bpkd_kode_cabang_awal and
                            $bpk[$i]->bpk_nota == $detail[$b]->bpk_nota) {
                            $harga+=$detail[$b]->bpkd_tarif_penerus;
                        }
                    }

                    

                    $cari_id_pc = DB::table('patty_cash')
                                 ->max('pc_id')+1;
                    $cari_akun = DB::table('d_akun')
                                   ->where('id_akun','like',substr($bpk[$i]->bpk_acc_biaya,0, 4).'%')
                                   ->where('kode_cabang',$filter_comp[$bpk[$i]->bpk_nota][$a])
                                   ->first();
                    $save_patty = DB::table('patty_cash')
                           ->insert([
                                'pc_id'           => $cari_id_pc,
                                'pc_tgl'          => $bpk[$i]->bpk_tanggal,
                                'pc_ref'          => 10,
                                'pc_akun'         => $cari_akun->id_akun,
                                'pc_akun_kas'     => $bpk[$i]->bpk_kode_akun,
                                'pc_keterangan'   => $bpk[$i]->bpk_keterangan,
                                'pc_asal_comp'    => $filter_comp[$bpk[$i]->bpk_nota][$a],
                                'pc_comp'         => $bpk[$i]->bpk_comp,
                                'pc_edit'         => 'UNALLOWED',
                                'pc_reim'         => 'UNRELEASED',
                                'pc_debet'        => 0,
                                'pc_user'         => $bpk[$i]->created_by,
                                'pc_no_trans'     => $bpk[$i]->bpk_nota,
                                'pc_kredit'       => $harga,
                                'created_at'      => Carbon::now(),
                                'updated_at'      => Carbon::now()
                    ]);


                    $cari_coa = DB::table('d_akun')
                                      ->where('id_akun','like',$cari_akun->id_akun)
                                      ->first();
                    $dt = DB::table('d_jurnal_dt')
                                    ->where('jrdt_jurnal',$id_jurnal)
                                    ->max('jrdt_detailid')+1;
                    if ($cari_coa->akun_dka == 'D') {
                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
                        $data_akun[0]['jrdt_detailid']  = $dt;
                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
                        $data_akun[0]['jrdt_value']     = $harga;
                        $data_akun[0]['jrdt_statusdk']  = 'D';
                		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bpk[$i]->bpk_keterangan);
                    }else{
                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
                        $data_akun[0]['jrdt_detailid']  = $dt;
                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
                        $data_akun[0]['jrdt_value']     = $harga;
                        $data_akun[0]['jrdt_statusdk']  = 'k';
                		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bpk[$i]->bpk_keterangan);
                    }
                    
                    $jurnal_dt = d_jurnal_dt::insert($data_akun);

                    $lihat_jurnal = DB::table('d_jurnal_dt')
                                    ->where('jrdt_jurnal',$id_jurnal)
                                    ->get();

                }
            }
        });
    }

    public function bukti_kas_keluar(request $req)
    {
        return DB::transaction(function() use ($req) {  

            $bkk = DB::table('bukti_kas_keluar')
                     ->orderBy('bkk_id','ASC')
                     ->get();


            $delete_jurnal = DB::table('d_jurnal')
                               ->where('jr_note','BUKTI KAS KELUAR')
                               ->delete();

            // HAPUS DATA KOSONG
            for ($i=0; $i < count($bkk); $i++) { 
            	$comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->select('bkk_nota','bkkd_akun')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();
                if ($comp == null) {
                    $delete = DB::table('patty_cash')
                       ->where('pc_no_trans',$bkk[$i]->bkk_nota)
                       ->delete();
                    
                    $delete_bkk = DB::table('bukti_kas_keluar')
                          ->where('bkk_id',$bkk[$i]->bkk_id)
                          ->delete();
                }
            }

    
            // RE INITIALIZE BKK
            $bkk = DB::table('bukti_kas_keluar')
                     ->orderBy('bkk_id','ASC')
                     ->get();
            for ($i=0; $i < count($bkk); $i++) { 

                if ($bkk[$i]->bkk_jenisbayar == 2) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->select('bkk_nota','fp_comp as cabang')
                              ->where('fp_jenisbayar',2)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->where('fp_jenisbayar',2)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    
	                  $delete_patty = DB::table('patty_cash')
	                               ->where('pc_no_trans',$bkk[$i]->bkk_nota)
	                               ->delete();
	                // //JURNAL

	                  $cari_id_pc = DB::table('patty_cash')
	                                 ->max('pc_id')+1;

                    $save_patty = DB::table('patty_cash')
                           ->insert([
                                'pc_id'           => $cari_id_pc,
                                'pc_tgl'          => $bpk[$i]->bkk_tgl,
                                'pc_ref'          => 10,
                                'pc_akun'         => $bkk[$i]->bkk_akun_kas,
                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
                                'pc_keterangan'   => $bkk[$i]->bkk_keterangan,
                                'pc_asal_comp'    => $bkk[$i]->bkk_comp,
                                'pc_comp'         => $bkk[$i]->bkk_comp,
                                'pc_edit'         => 'UNALLOWED',
                                'pc_reim'         => 'UNRELEASED',
                                'pc_debet'        => $bkk[$i]->bkk_total,
                                'pc_user'         => $bkk[$i]->created_by,
                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
                                'pc_kredit'       => 0,
                                'created_at'      => Carbon::now(),
                                'updated_at'      => Carbon::now()
                    ]);
	                $id_jurnal=d_jurnal::max('jr_id')+1;

	                $jenis_bayar = DB::table('jenisbayar')
	                                 ->where('idjenisbayar',2)
	                                 ->first();

	                $jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
	                                            'jr_year'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y'),
	                                            'jr_date'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y-m-d'),
	                                            'jr_detail' => $jenis_bayar->jenisbayar,
	                                            'jr_ref'    => $bkk[$i]->bkk_nota,
	                                            'jr_note'   => 'BUKTI KAS KELUAR',
	                                            'jr_insert' => carbon::now(),
	                                            'jr_update' => carbon::now(),
	                                            ]);

	                $cari_coa = DB::table('d_akun')
                                  ->where('id_akun','like',substr($bkk[$i]->bkk_akun_kas,0, 4).'%')
                                  ->where('kode_cabang',$bkk[$i]->bkk_comp)
                                  ->first();
	                    
	                if ($cari_coa->akun_dka == 'D') {
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'K';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }else{
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'D';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }
	                
	                $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                $lihat_jurnal = DB::table('d_jurnal_dt')
	                                ->where('jrdt_jurnal',$id_jurnal)
	                                ->get();
	               	for ($a=0; $a < count($comp); $a++) { 
	                    if ($bkk[$i]->bkk_nota == $comp[$a]->bkk_nota) {
	                        $filter_comp[$bkk[$i]->bkk_nota][$a] = $comp[$a]->cabang;
	                    }
	                }
	                // if ($bkk[$i]->bkk_nota == 'BKK0618/008/035') {

	                // 	dd($comp[$a]->bkk_nota);
	                // }
	                $filter_comp[$bkk[$i]->bkk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bkk[$i]->bkk_nota] ) ));
	                $filter_comp[$bkk[$i]->bkk_nota] = array_values($filter_comp[$bkk[$i]->bkk_nota]);

	                for ($a=0; $a < count($filter_comp[$bkk[$i]->bkk_nota]); $a++) { 
                    	$harga = 0;

	                    for ($b=0; $b < count($detail); $b++) { 

	                        if ($filter_comp[$bkk[$i]->bkk_nota][$a] == $detail[$b]->fp_comp and
	                            $bkk[$i]->bkk_nota == $detail[$b]->bkk_nota) {
	                            $harga+=$detail[$b]->bkkd_total;
	                        }
	                    }


	                    $cari_id_pc = DB::table('patty_cash')
                                 ->max('pc_id')+1;
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2101'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $save_patty = DB::table('patty_cash')
	                           ->insert([
	                                'pc_id'           => $cari_id_pc,
	                                'pc_tgl'          => $bpk[$i]->bkk_tgl,
	                                'pc_ref'          => 2,
	                                'pc_akun'         => $cari_akun->id_akun,
	                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
	                                'pc_keterangan'   => $bkk[$b]->bkk_keterangan,
	                                'pc_asal_comp'    => $filter_comp[$bkk[$i]->bkk_nota][$a],
	                                'pc_comp'         => $bkk[$i]->bkk_comp,
	                                'pc_edit'         => 'UNALLOWED',
	                                'pc_reim'         => 'UNRELEASED',
	                                'pc_debet'        => 0,
	                                'pc_user'         => $bkk[$i]->created_by,
	                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
	                                'pc_kredit'       => $harga,
	                                'created_at'      => Carbon::now(),
	                                'updated_at'      => Carbon::now()
	                    ]);
	                    
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2101'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $cari_coa = DB::table('d_akun')
	                                      ->where('id_akun','like',$cari_akun->id_akun)
	                                      ->first();
	                    $dt = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->max('jrdt_detailid')+1;
	                    if ($cari_coa->akun_dka == 'D') {
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'K';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }else{
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'D';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }
	                    
	                    $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                    $lihat_jurnal = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->get();
	                }

                }else if ($bkk[$i]->bkk_jenisbayar == 3) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('v_hutang','v_nomorbukti','=','bkkd_ref')
                              ->select('bkk_nota','vc_comp as cabang')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('v_hutang','v_nomorbukti','=','bkkd_ref')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();
                }else if ($bkk[$i]->bkk_jenisbayar == 4) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('d_uangmuka','um_nomorbukti','=','bkkd_ref')
                              ->select('bkk_nota','um_comp as cabang')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('d_uangmuka','um_nomorbukti','=','bkkd_ref')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();
                }else if ($bkk[$i]->bkk_jenisbayar == 6) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->select('bkk_nota','fp_comp as cabang')
                              ->where('fp_jenisbayar',6)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->where('fp_jenisbayar',6)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();
                    // dd($comp);
                    $delete_jurnal = DB::table('d_jurnal')
	                               ->where('jr_ref',$bkk[$i]->bkk_nota)
	                               ->delete();
	                  $delete_patty = DB::table('patty_cash')
	                               ->where('pc_no_trans',$bkk[$i]->bkk_nota)
	                               ->delete();
	                // //JURNAL

	                  $cari_id_pc = DB::table('patty_cash')
	                                 ->max('pc_id')+1;

                    $save_patty = DB::table('patty_cash')
                           ->insert([
                                'pc_id'           => $cari_id_pc,
                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
                                'pc_ref'          => 10,
                                'pc_akun'         => $bkk[$i]->bkk_akun_kas,
                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
                                'pc_keterangan'   => $bkk[$i]->bkk_keterangan,
                                'pc_asal_comp'    => $bkk[$i]->bkk_comp,
                                'pc_comp'         => $bkk[$i]->bkk_comp,
                                'pc_edit'         => 'UNALLOWED',
                                'pc_reim'         => 'UNRELEASED',
                                'pc_debet'        => $bkk[$i]->bkk_total,
                                'pc_user'         => $bkk[$i]->created_by,
                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
                                'pc_kredit'       => 0,
                                'created_at'      => Carbon::now(),
                                'updated_at'      => Carbon::now()
                    ]);
	                $id_jurnal=d_jurnal::max('jr_id')+1;

	                $jenis_bayar = DB::table('jenisbayar')
	                                 ->where('idjenisbayar',6)
	                                 ->first();

	                $jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
	                                            'jr_year'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y'),
	                                            'jr_date'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y-m-d'),
	                                            'jr_detail' => $jenis_bayar->jenisbayar,
	                                            'jr_ref'    => $bkk[$i]->bkk_nota,
	                                            'jr_note'   => 'BUKTI KAS KELUAR',
	                                            'jr_insert' => carbon::now(),
	                                            'jr_update' => carbon::now(),
	                                            ]);

	                $cari_coa = DB::table('d_akun')
                                  ->where('id_akun','like',substr($bkk[$i]->bkk_akun_kas,0, 4).'%')
                                  ->where('kode_cabang',$bkk[$i]->bkk_comp)
                                  ->first();
	                    
	                if ($cari_coa->akun_dka == 'D') {
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'K';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }else{
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'D';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }
	                
	                $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                $lihat_jurnal = DB::table('d_jurnal_dt')
	                                ->where('jrdt_jurnal',$id_jurnal)
	                                ->get();
	               	for ($a=0; $a < count($comp); $a++) { 
	                    if ($bkk[$i]->bkk_nota == $comp[$a]->bkk_nota) {
	                        $filter_comp[$bkk[$i]->bkk_nota][$a] = $comp[$a]->cabang;
	                    }
	                }
	 
	                $filter_comp[$bkk[$i]->bkk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bkk[$i]->bkk_nota] ) ));
	                $filter_comp[$bkk[$i]->bkk_nota] = array_values($filter_comp[$bkk[$i]->bkk_nota]);

	                for ($a=0; $a < count($filter_comp[$bkk[$i]->bkk_nota]); $a++) { 
                    	$harga = 0;

	                    for ($b=0; $b < count($detail); $b++) { 

	                        if ($filter_comp[$bkk[$i]->bkk_nota][$a] == $detail[$b]->fp_comp and
	                            $bkk[$i]->bkk_nota == $detail[$b]->bkk_nota) {
	                            $harga+=$detail[$b]->bkkd_total;
	                        }
	                    }


	                    $cari_id_pc = DB::table('patty_cash')
                                 ->max('pc_id')+1;
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2102'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $save_patty = DB::table('patty_cash')
	                           ->insert([
	                                'pc_id'           => $cari_id_pc,
	                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
	                                'pc_ref'          => 6,
	                                'pc_akun'         => $cari_akun->id_akun,
	                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
	                                'pc_keterangan'   => $bkk[$b]->bkk_keterangan,
	                                'pc_asal_comp'    => $filter_comp[$bkk[$i]->bkk_nota][$a],
	                                'pc_comp'         => $bkk[$i]->bkk_comp,
	                                'pc_edit'         => 'UNALLOWED',
	                                'pc_reim'         => 'UNRELEASED',
	                                'pc_debet'        => 0,
	                                'pc_user'         => $bkk[$i]->created_by,
	                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
	                                'pc_kredit'       => $harga,
	                                'created_at'      => Carbon::now(),
	                                'updated_at'      => Carbon::now()
	                    ]);
	                    
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2102'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $cari_coa = DB::table('d_akun')
	                                      ->where('id_akun','like',$cari_akun->id_akun)
	                                      ->first();
	                    $dt = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->max('jrdt_detailid')+1;
	                    if ($cari_coa->akun_dka == 'D') {
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'K';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }else{
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'D';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }
	                    
	                    $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                    $lihat_jurnal = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->get();
	                }
                }else if ($bkk[$i]->bkk_jenisbayar == 7) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->select('bkk_nota','fp_comp as cabang')
                              ->where('fp_jenisbayar',7)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->where('fp_jenisbayar',7)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();


                    $delete_jurnal = DB::table('d_jurnal')
	                               ->where('jr_ref',$bkk[$i]->bkk_nota)
	                               ->delete();
	                $delete_patty = DB::table('patty_cash')
	                               ->where('pc_no_trans',$bkk[$i]->bkk_nota)
	                               ->delete();
	                // //JURNAL

	                $cari_id_pc = DB::table('patty_cash')
	                                 ->max('pc_id')+1;

                    $save_patty = DB::table('patty_cash')
                           ->insert([
                                'pc_id'           => $cari_id_pc,
                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
                                'pc_ref'          => 10,
                                'pc_akun'         => $bkk[$i]->bkk_akun_kas,
                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
                                'pc_keterangan'   => $bkk[$i]->bkk_keterangan,
                                'pc_asal_comp'    => $bkk[$i]->bkk_comp,
                                'pc_comp'         => $bkk[$i]->bkk_comp,
                                'pc_edit'         => 'UNALLOWED',
                                'pc_reim'         => 'UNRELEASED',
                                'pc_debet'        => $bkk[$i]->bkk_total,
                                'pc_user'         => $bkk[$i]->created_by,
                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
                                'pc_kredit'       => 0,
                                'created_at'      => Carbon::now(),
                                'updated_at'      => Carbon::now()
                    ]);
	                $id_jurnal=d_jurnal::max('jr_id')+1;

	                $jenis_bayar = DB::table('jenisbayar')
	                                 ->where('idjenisbayar',7)
	                                 ->first();

	                $jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
	                                            'jr_year'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y'),
	                                            'jr_date'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y-m-d'),
	                                            'jr_detail' => $jenis_bayar->jenisbayar,
	                                            'jr_ref'    => $bkk[$i]->bkk_nota,
	                                            'jr_note'   => 'BUKTI KAS KELUAR',
	                                            'jr_insert' => carbon::now(),
	                                            'jr_update' => carbon::now(),
	                                            ]);

	                $cari_coa = DB::table('d_akun')
                                  ->where('id_akun','like',substr($bkk[$i]->bkk_akun_kas,0, 4).'%')
                                  ->where('kode_cabang',$bkk[$i]->bkk_comp)
                                  ->first();
	                    
	                if ($cari_coa->akun_dka == 'D') {
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'K';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }else{
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'D';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }
	                
	                $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                $lihat_jurnal = DB::table('d_jurnal_dt')
	                                ->where('jrdt_jurnal',$id_jurnal)
	                                ->get();
	               	for ($a=0; $a < count($comp); $a++) { 
	                    if ($bkk[$i]->bkk_nota == $comp[$a]->bkk_nota) {
	                        $filter_comp[$bkk[$i]->bkk_nota][$a] = $comp[$a]->cabang;
	                    }
	                }
	                // if ($bkk[$i]->bkk_nota == 'BKK0618/008/035') {

	                // 	dd($comp[$a]->bkk_nota);
	                // }
	                $filter_comp[$bkk[$i]->bkk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bkk[$i]->bkk_nota] ) ));
	                $filter_comp[$bkk[$i]->bkk_nota] = array_values($filter_comp[$bkk[$i]->bkk_nota]);

	                for ($a=0; $a < count($filter_comp[$bkk[$i]->bkk_nota]); $a++) { 
                    	$harga = 0;

	                    for ($b=0; $b < count($detail); $b++) { 

	                        if ($filter_comp[$bkk[$i]->bkk_nota][$a] == $detail[$b]->fp_comp and
	                            $bkk[$i]->bkk_nota == $detail[$b]->bkk_nota) {
	                            $harga+=$detail[$b]->bkkd_total;
	                        }
	                    }


	                    $cari_id_pc = DB::table('patty_cash')
                                 ->max('pc_id')+1;
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2102'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $save_patty = DB::table('patty_cash')
	                           ->insert([
	                                'pc_id'           => $cari_id_pc,
	                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
	                                'pc_ref'          => 7,
	                                'pc_akun'         => $cari_akun->id_akun,
	                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
	                                'pc_keterangan'   => $bkk[$b]->bkk_keterangan,
	                                'pc_asal_comp'    => $filter_comp[$bkk[$i]->bkk_nota][$a],
	                                'pc_comp'         => $bkk[$i]->bkk_comp,
	                                'pc_edit'         => 'UNALLOWED',
	                                'pc_reim'         => 'UNRELEASED',
	                                'pc_debet'        => 0,
	                                'pc_user'         => $bkk[$i]->created_by,
	                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
	                                'pc_kredit'       => $harga,
	                                'created_at'      => Carbon::now(),
	                                'updated_at'      => Carbon::now()
	                    ]);
	                    
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2102'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $cari_coa = DB::table('d_akun')
	                                      ->where('id_akun','like',$cari_akun->id_akun)
	                                      ->first();
	                    $dt = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->max('jrdt_detailid')+1;
	                    if ($cari_coa->akun_dka == 'D') {
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'K';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }else{
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'D';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }
	                    
	                    $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                    $lihat_jurnal = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->get();
	                }
                }else if ($bkk[$i]->bkk_jenisbayar == 8) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->select('bkk_nota','bkkd_akun')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();
               
                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

  	                $delete_jurnal = DB::table('d_jurnal')
  	                               ->where('jr_ref',$bkk[$i]->bkk_nota)
  	                               ->delete();
  	                $delete_patty = DB::table('patty_cash')
  	                               ->where('pc_no_trans',$bkk[$i]->bkk_nota)
  	                               ->delete();
  	                // //JURNAL

  	                $cari_id_pc = DB::table('patty_cash')
  	                                 ->max('pc_id')+1;

                    $save_patty = DB::table('patty_cash')
                           ->insert([
                                'pc_id'           => $cari_id_pc,
                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
                                'pc_ref'          => 10,
                                'pc_akun'         => $bkk[$i]->bkk_akun_kas,
                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
                                'pc_keterangan'   => $bkk[$i]->bkk_keterangan,
                                'pc_asal_comp'    => $bkk[$i]->bkk_comp,
                                'pc_comp'         => $bkk[$i]->bkk_comp,
                                'pc_edit'         => 'UNALLOWED',
                                'pc_reim'         => 'UNRELEASED',
                                'pc_debet'        => $bkk[$i]->bkk_total,
                                'pc_user'         => $bkk[$i]->created_by,
                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
                                'pc_kredit'       => 0,
                                'created_at'      => Carbon::now(),
                                'updated_at'      => Carbon::now()
                    ]);
	                $id_jurnal=d_jurnal::max('jr_id')+1;

	                $jenis_bayar = DB::table('jenisbayar')
	                                 ->where('idjenisbayar',8)
	                                 ->first();

	                $jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
	                                            'jr_year'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y'),
	                                            'jr_date'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y-m-d'),
	                                            'jr_detail' => $jenis_bayar->jenisbayar,
	                                            'jr_ref'    => $bkk[$i]->bkk_nota,
	                                            'jr_note'   => 'BUKTI KAS KELUAR',
	                                            'jr_insert' => carbon::now(),
	                                            'jr_update' => carbon::now(),
	                                            ]);

	                $cari_coa = DB::table('d_akun')
                                  ->where('id_akun','like',substr($bkk[$i]->bkk_akun_kas,0, 4).'%')
                                  ->where('kode_cabang',$bkk[$i]->bkk_comp)
                                  ->first();
	                    
	                if ($cari_coa->akun_dka == 'D') {
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'K';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }else{
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'D';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }
	                
	                $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                $lihat_jurnal = DB::table('d_jurnal_dt')
	                                ->where('jrdt_jurnal',$id_jurnal)
	                                ->get();
	               	for ($a=0; $a < count($comp); $a++) { 
	                    if ($bkk[$i]->bkk_nota == $comp[$a]->bkk_nota) {
	                        $filter_comp[$bkk[$i]->bkk_nota][$a] = $comp[$a]->bkkd_akun;
	                    }
	                }
	                // if ($bkk[$i]->bkk_nota == 'BKK0618/008/035') {

	                // 	dd($comp[$a]->bkk_nota);
	                // }
	                $filter_comp[$bkk[$i]->bkk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bkk[$i]->bkk_nota] ) ));
	                $filter_comp[$bkk[$i]->bkk_nota] = array_values($filter_comp[$bkk[$i]->bkk_nota]);
	                // SAVE PATTY_CASH
	                for ($b=0; $b < count($detail); $b++) { 
                    	$cari_id_pc = DB::table('patty_cash')
                                 ->max('pc_id')+1;
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like',substr($detail[$b]->bkkd_akun,0, 4).'%')
	                                   ->where('kode_cabang',$bkk[$i]->bkk_comp)
	                                   ->first();

	                    $save_patty = DB::table('patty_cash')
	                           ->insert([
	                                'pc_id'           => $cari_id_pc,
	                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
	                                'pc_ref'          => 10,
	                                'pc_akun'         => $cari_akun->id_akun,
	                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
	                                'pc_keterangan'   => $detail[$b]->bkkd_keterangan,
	                                'pc_asal_comp'    => $bkk[$i]->bkk_comp,
	                                'pc_comp'         => $bkk[$i]->bkk_comp,
	                                'pc_edit'         => 'UNALLOWED',
	                                'pc_reim'         => 'UNRELEASED',
	                                'pc_debet'        => 0,
	                                'pc_user'         => $bkk[$i]->created_by,
	                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
	                                'pc_kredit'       => $detail[$b]->bkkd_total,
	                                'created_at'      => Carbon::now(),
	                                'updated_at'      => Carbon::now()
	                    ]);
                        
                    }
                    // SAVE JURNAL DETAIL
	                for ($a=0; $a < count($filter_comp[$bkk[$i]->bkk_nota]); $a++) { 
                    	$harga = 0;
                    	$in = 1;
	                    for ($b=0; $b < count($detail); $b++) { 
	                        if ($filter_comp[$bkk[$i]->bkk_nota][$a] == $detail[$b]->bkkd_akun and
	                            $bkk[$i]->bkk_nota == $detail[$b]->bkk_nota) {
	                            $harga+=$detail[$b]->bkkd_total;
	                        }
	                        $in++;
	                    }

	                    
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like',substr($filter_comp[$bkk[$i]->bkk_nota][$a],0, 4).'%')
	                                   ->where('kode_cabang',$bkk[$i]->bkk_comp)
	                                   ->first();

	                    $cari_coa = DB::table('d_akun')
	                                      ->where('id_akun','like',$cari_akun->id_akun)
	                                      ->first();
	                    $dt = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->max('jrdt_detailid')+1;
	                    if ($cari_coa->akun_dka == 'D') {
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = $harga;
	                        $data_akun[0]['jrdt_statusdk']  = 'D';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }else{
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = $harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'K';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }
	                    
	                    $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                    $lihat_jurnal = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->get();
	                }
                }else if ($bkk[$i]->bkk_jenisbayar == 9) {
                    $comp = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->select('bkk_nota','fp_comp as cabang')
                              ->where('fp_jenisbayar',9)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $detail = DB::table('bukti_kas_keluar')
                              ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
                              ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
                              ->where('fp_jenisbayar',9)
                              ->where('bkk_id',$bkk[$i]->bkk_id)
                              ->get();

                    $delete_jurnal = DB::table('d_jurnal')
	                               ->where('jr_ref',$bkk[$i]->bkk_nota)
	                               ->delete();
	                $delete_patty = DB::table('patty_cash')
	                               ->where('pc_no_trans',$bkk[$i]->bkk_nota)
	                               ->delete();
	                // //JURNAL

	                $cari_id_pc = DB::table('patty_cash')
	                                 ->max('pc_id')+1;

                    $save_patty = DB::table('patty_cash')
                           ->insert([
                                'pc_id'           => $cari_id_pc,
                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
                                'pc_ref'          => 10,
                                'pc_akun'         => $bkk[$i]->bkk_akun_kas,
                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
                                'pc_keterangan'   => $bkk[$i]->bkk_keterangan,
                                'pc_asal_comp'    => $bkk[$i]->bkk_comp,
                                'pc_comp'         => $bkk[$i]->bkk_comp,
                                'pc_edit'         => 'UNALLOWED',
                                'pc_reim'         => 'UNRELEASED',
                                'pc_debet'        => $bkk[$i]->bkk_total,
                                'pc_user'         => $bkk[$i]->created_by,
                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
                                'pc_kredit'       => 0,
                                'created_at'      => Carbon::now(),
                                'updated_at'      => Carbon::now()
                    ]);
	                $id_jurnal=d_jurnal::max('jr_id')+1;

	                $jenis_bayar = DB::table('jenisbayar')
	                                 ->where('idjenisbayar',9)
	                                 ->first();

	                $jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
	                                            'jr_year'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y'),
	                                            'jr_date'   => carbon::parse($bkk[$i]->bkk_tgl)->format('Y-m-d'),
	                                            'jr_detail' => $jenis_bayar->jenisbayar,
	                                            'jr_ref'    => $bkk[$i]->bkk_nota,
	                                            'jr_note'   => 'BUKTI KAS KELUAR',
	                                            'jr_insert' => carbon::now(),
	                                            'jr_update' => carbon::now(),
	                                            ]);

	                $cari_coa = DB::table('d_akun')
                                  ->where('id_akun','like',substr($bkk[$i]->bkk_akun_kas,0, 4).'%')
                                  ->where('kode_cabang',$bkk[$i]->bkk_comp)
                                  ->first();
	                    
	                if ($cari_coa->akun_dka == 'D') {
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'K';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }else{
	                    $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                    $data_akun[0]['jrdt_detailid']  = 1;
	                    $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                    $data_akun[0]['jrdt_value']     = -$bkk[$i]->bkk_total;
	                    $data_akun[0]['jrdt_statusdk'] = 'D';
              	  		$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                }
	                
	                $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                $lihat_jurnal = DB::table('d_jurnal_dt')
	                                ->where('jrdt_jurnal',$id_jurnal)
	                                ->get();
	               	for ($a=0; $a < count($comp); $a++) { 
	                    if ($bkk[$i]->bkk_nota == $comp[$a]->bkk_nota) {
	                        $filter_comp[$bkk[$i]->bkk_nota][$a] = $comp[$a]->cabang;
	                    }
	                }
	                // if ($bkk[$i]->bkk_nota == 'BKK0618/008/035') {

	                // 	dd($comp[$a]->bkk_nota);
	                // }
	                $filter_comp[$bkk[$i]->bkk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bkk[$i]->bkk_nota] ) ));
	                $filter_comp[$bkk[$i]->bkk_nota] = array_values($filter_comp[$bkk[$i]->bkk_nota]);

	                for ($a=0; $a < count($filter_comp[$bkk[$i]->bkk_nota]); $a++) { 
                    	$harga = 0;

	                    for ($b=0; $b < count($detail); $b++) { 

	                        if ($filter_comp[$bkk[$i]->bkk_nota][$a] == $detail[$b]->fp_comp and
	                            $bkk[$i]->bkk_nota == $detail[$b]->bkk_nota) {
	                            $harga+=$detail[$b]->bkkd_total;
	                        }
	                    }


	                    $cari_id_pc = DB::table('patty_cash')
                                 ->max('pc_id')+1;
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2102'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $save_patty = DB::table('patty_cash')
	                           ->insert([
	                                'pc_id'           => $cari_id_pc,
	                                'pc_tgl'          => $bkk[$i]->bkk_tgl,
	                                'pc_ref'          => 9,
	                                'pc_akun'         => $cari_akun->id_akun,
	                                'pc_akun_kas'     => $bkk[$i]->bkk_akun_kas,
	                                'pc_keterangan'   => $bkk[$b]->bkk_keterangan,
	                                'pc_asal_comp'    => $filter_comp[$bkk[$i]->bkk_nota][$a],
	                                'pc_comp'         => $bkk[$i]->bkk_comp,
	                                'pc_edit'         => 'UNALLOWED',
	                                'pc_reim'         => 'UNRELEASED',
	                                'pc_debet'        => 0,
	                                'pc_user'         => $bkk[$i]->created_by,
	                                'pc_no_trans'     => $bkk[$i]->bkk_nota,
	                                'pc_kredit'       => $harga,
	                                'created_at'      => Carbon::now(),
	                                'updated_at'      => Carbon::now()
	                    ]);
	                    
	                    $cari_akun = DB::table('d_akun')
	                                   ->where('id_akun','like','2102'.'%')
	                                   ->where('kode_cabang',$filter_comp[$bkk[$i]->bkk_nota][$a])
	                                   ->first();

	                    $cari_coa = DB::table('d_akun')
	                                      ->where('id_akun','like',$cari_akun->id_akun)
	                                      ->first();
	                    $dt = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->max('jrdt_detailid')+1;
	                    if ($cari_coa->akun_dka == 'D') {
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'K';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }else{
	                        $data_akun[0]['jrdt_jurnal']    = $id_jurnal;
	                        $data_akun[0]['jrdt_detailid']  = $dt;
	                        $data_akun[0]['jrdt_acc']       = $cari_coa->id_akun;
	                        $data_akun[0]['jrdt_value']     = -$harga;
	                        $data_akun[0]['jrdt_statusdk'] = 'D';
                			$data_akun[0]['jrdt_detail']    = $cari_coa->nama_akun . ' ' . strtoupper($bkk[$i]->bkk_keterangan);

	                    }
	                    
	                    $jurnal_dt = d_jurnal_dt::insert($data_akun);

	                    $lihat_jurnal = DB::table('d_jurnal_dt')
	                                    ->where('jrdt_jurnal',$id_jurnal)
	                                    ->get();
	                }
                }
                
            }
        });    
    }


  public function invoice(Request $req)
  {
    return DB::transaction(function() use ($req) {  
    	$error_invoice = [];
      	$invoice = DB::table('invoice')
                   ->get();
		$delete = d_jurnal::where('jr_detail','like','INVOICE%')->delete();

      	for ($i=0; $i < count($invoice); $i++) { 
	        // SET PPN AWAL
	        $tipe   = $invoice[$i]->i_ppntpe;
	        $persen = $invoice[$i]->i_ppnrte;
	        $ppn_type = $tipe;
	        $ppn_persen = $persen;

	        if ($tipe== 'npkp') {
	          $nilaiPpn=$persen/(100+$persen);
	        }else{
	          $nilaiPpn=$persen/100;
	        }
	        if ($persen == '10') {
	          $akunPPN='2398';
	        }else if($persen == '1'){
	          $akunPPN='2301';
	        }

	        $id_jurnal=d_jurnal::max('jr_id')+1;
	        $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
	                        'jr_year'   => carbon::parse($invoice[$i]->i_tanggal)->format('Y'),
	                        'jr_date'   => $invoice[$i]->i_tanggal,
	                        'jr_detail' => 'INVOICE ' . $invoice[$i]->i_pendapatan,
	                        'jr_ref'    => $invoice[$i]->i_nomor,
	                        'jr_note'   => 'INVOICE '.$invoice[$i]->i_keterangan,
	                        'jr_insert' => carbon::now(),
	                        'jr_update' => carbon::now(),
	                      ]);

	        if ($invoice[$i]->i_pendapatan == 'PAKET') {
	          $tot_vendor = 0;
	          $tot_own = 0;
	          $invoice_detail = DB::table('invoice_d')
	                              ->where('id_nomor_invoice',$invoice[$i]->i_nomor)
	                              ->get();

	          for ($a=0; $a < count($invoice_detail); $a++) { 
	            $do = DB::table('delivery_order')
	                    ->where('nomor',$invoice_detail[$a]->id_nomor_do)
	                    ->first();
	            try{
	            	$tot_vendor += $do->total_vendo;
	            	$tot_own += $do->total_dpp;
	            }catch(Exception $er){
	            	$erno = [];
	            	array_push($erno, $invoice_detail[$a]->id_nomor_do);
	          		// dd($erno);
	            }
	            
	          }
	          $akun     = [];
	          $akun_val = [];
	          if ($invoice[$i]->i_jenis_ppn != 4) {
	            // MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
	            if ($ppn_type == 'npkp') {
	                $tot_own1    = $invoice[$i]->i_ppnrp/($invoice[$i]->i_netto_detail+$invoice[$i]->i_ppnrp)* $tot_own;
	                $tot_vendor1 = $invoice[$i]->i_ppnrp/($invoice[$i]->i_netto_detail+$invoice[$i]->i_ppnrp) * $tot_vendor;
	                $tot_own    -= $tot_own1;
	                $tot_vendor -= $tot_vendor1;
	            }

	            array_push($akun, $invoice[$i]->i_acc_piutang);
	            array_push($akun_val, round($invoice[$i]->i_total_tagihan));
	            // if ($invoice[$i]->i_nomor == 'FP0418/02/A0009') {
             //  		// dd($tot_own);
             //  	}
	            // DISKON
	            // dd($request->diskon2 );
	            if ($invoice[$i]->i_diskon2 > 0) {
	              $akun_diskon = DB::table('d_akun')
	                            ->where('id_akun','like','5398'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_diskon == null) {
	              	// $error_invoice[$i]['invoice'] = $invoice[$i]->i_nomor;
	              	// $error_invoice[$i]['message'] = 'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET';
	                return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	              }
	              array_push($akun, $akun_diskon->id_akun);
	              array_push($akun_val, round($invoice[$i]->i_diskon2));
	            }
	            // JURNAL PPN
	            if (isset($akunPPN)) {
	              $akun_ppn = DB::table('d_akun')
	                            ->where('id_akun','like',$akunPPN.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_ppn == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak TerkaitPAKET']);
	              }
	              array_push($akun, $akun_ppn->id_akun);
	              array_push($akun_val,round($invoice[$i]->i_ppnrp));
	            }

	            // JURNAL PPH
	            if ($invoice[$i]->i_pajak_lain != '0') {
	              if ($invoice[$i]->i_kode_pajak != 'T') {
	                $cari_pajak = DB::table('pajak')
	                              ->where('kode',$invoice[$i]->i_pajak_lain)
	                              ->first();
	                $akun_pph1 = $cari_pajak->acc1;
	                $akun_pph1 = substr($akun_pph1,0, 4);
	                $akun_pph  = DB::table('d_akun')
	                              ->where('id_akun','like',$akun_pph1.'%')
	                              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                              ->first();
	                if ($akun_pph == null) {
	                  return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	                }
	                array_push($akun, $akun_pph->id_akun);
	                array_push($akun_val,round($invoice[$i]->i_pajak_lain));
	              }
	            }
	            // PENDAPATAN VENDOR
	            if ($tot_vendor != 0) {
	              $akun_vendor = DB::table('d_akun')
	                            ->where('id_akun','like','4501'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_vendor == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	              }
	              array_push($akun, $akun_vendor->id_akun);
	              array_push($akun_val, round($tot_vendor));
	            }
	            // PENDAPATAN OWN
	            if ($tot_own != 0) {
	              $akun_own = DB::table('d_akun')
	                            ->where('id_akun','like','4301'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_own == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	              }
	              
	              array_push($akun, $akun_own->id_akun);
	              array_push($akun_val, round($tot_own));
	            }
	            
	          }else{
	            // NON PPN
	            array_push($akun, $cari_acc_piutang);
	            array_push($akun_val, round($total_tagihan));
	            // DISKON
	            if ($invoice[$i]->i_diskon2 != 0) {
	              $akun_diskon = DB::table('d_akun')
	                            ->where('id_akun','like','5398'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_diskon == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	              }
	              array_push($akun, $akun_diskon->id_akun);
	              array_push($akun_val, round($invoice[$i]->i_diskon2));
	            }

	            // JURNAL PPH
	            if ($invoice[$i]->i_pajak_lain != '0') {
	              if ($invoice[$i]->i_kode_pajak != 'T') {
	                $cari_pajak = DB::table('pajak')
	                              ->where('kode',$invoice[$i]->i_pajak_lain)
	                              ->first();
	                $akun_pph1 = $cari_pajak->acc1;
	                $akun_pph1 = substr($akun_pph1,0, 4);
	                $akun_pph  = DB::table('d_akun')
	                              ->where('id_akun','like',$akun_pph1.'%')
	                              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                              ->first();
	                if ($akun_pph == null) {
	                  return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	                }
	                array_push($akun, $akun_pph->id_akun);
	                array_push($akun_val,round($invoice[$i]->i_pajak_lain));
	              }
	            }

	            // PENDAPATAN VENDOR
	            if ($tot_vendor != 0) {
	              $akun_vendor = DB::table('d_akun')
	                            ->where('id_akun','like','4501'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_vendor == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	              }
	              array_push($akun, $akun_vendor->id_akun);
	              array_push($akun_val, round($tot_vendor));
	            }
	            // PENDAPATAN OWN
	            if ($tot_own != 0) {
	              $akun_own = DB::table('d_akun')
	                            ->where('id_akun','like','4301'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_own == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait PAKET']);
	              }
	              array_push($akun, $akun_own->id_akun);
	              array_push($akun_val, round($tot_own));
	            }
	          }
	        }elseif ($invoice[$i]->i_pendapatan == 'KARGO'){
	          // KARGO
	          $tot_subcon = 0;
	          $tot_own = 0;

	          $invoice_detail = DB::table('invoice_d')
	                              ->where('id_nomor_invoice',$invoice[$i]->i_nomor)
	                              ->get();

	          for ($a=0; $a < count($invoice_detail); $a++) { 
	            $do = DB::table('delivery_order')
	                    ->where('nomor',$invoice_detail[$a]->id_nomor_do)
	                    ->first();

	            if ($do->status_kendaraan == 'OWN') {
	              $tot_own += $do->total_net;
	            }else{
	              $tot_subcon += $do->total_net;
	            }
	          }
	          $akun     = [];
	          $akun_val = [];

	          if ($invoice[$i]->i_jenis_ppn != 4) {
	            // MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
	            if ($ppn_type == 'npkp') {

	                $tot_own1    = $invoice[$i]->i_ppnrp/($invoice[$i]->i_netto_detail+$invoice[$i]->i_ppnrp) * $tot_own;
	                $tot_subcon1 = $invoice[$i]->i_ppnrp/($invoice[$i]->i_netto_detail+$invoice[$i]->i_ppnrp) * $tot_subcon;
	                $tot_own    -= $tot_own1;
	                $tot_subcon -= $tot_subcon1;
	            }
	              // dd($total_tagihan);

	            array_push($akun, $invoice[$i]->i_acc_piutang);
	            array_push($akun_val, round($invoice[$i]->i_total_tagihan));
	            // DISKON
	            if ($invoice[$i]->i_diskon2 > 0) {
	              $akun_diskon = DB::table('d_akun')
	                            ->where('id_akun','like','5398'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_diskon == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_diskon->id_akun);
	              array_push($akun_val, round($invoice[$i]->i_diskon2));
	            }
	            // JURNAL PPN
	            if (isset($akunPPN)) {
	              $akun_ppn = DB::table('d_akun')
	                            ->where('id_akun','like',$akunPPN.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_ppn == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_ppn->id_akun);
	              array_push($akun_val,round($invoice[$i]->i_ppnrp));
	            }

	            // JURNAL PPH
	            if ($invoice[$i]->i_pajak_lain != '0') {
	              if ($invoice[$i]->i_kode_pajak != 'T') {
	                $cari_pajak = DB::table('pajak')
	                              ->where('kode',$invoice[$i]->i_pajak_lain)
	                              ->first();
	                $akun_pph1 = $cari_pajak->acc1;
	                $akun_pph1 = substr($akun_pph1,0, 4);
	                $akun_pph  = DB::table('d_akun')
	                              ->where('id_akun','like',$akun_pph1.'%')
	                              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                              ->first();
	                if ($akun_pph == null) {
	                  return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	                }
	                array_push($akun, $akun_pph->id_akun);
	                array_push($akun_val,round($invoice[$i]->i_pajak_lain));
	              }
	            }

	            // PENDAPATAN SUBCON
	            if ($tot_subcon != 0) {
	              $akun_vendor = DB::table('d_akun')
	                            ->where('id_akun','like','4401'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_vendor == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_vendor->id_akun);
	              array_push($akun_val, round($tot_subcon));
	            }
	            // PENDAPATAN OWN
	            if ($tot_own != 0) {
	              $akun_own = DB::table('d_akun')
	                            ->where('id_akun','like','4201'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_own == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_own->id_akun);
	              array_push($akun_val,round( $tot_own));
	            }

	          }else{
	            // NON PPN
	            array_push($akun, $invoice[$i]->i_acc_piutang);
	            array_push($akun_val, $invoice[$i]->i_total_tagihan);
	            // DISKON
	            if ($invoice[$i]->i_diskon2 > 0) {
	              $akun_diskon = DB::table('d_akun')
	                            ->where('id_akun','like','5398'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_diskon == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_diskon->id_akun);
	              array_push($akun_val, round($invoice[$i]->i_diskon2));
	            }

	            // JURNAL PPH
	            if ($invoice[$i]->i_pajak_lain != '0') {
	              if ($invoice[$i]->i_kode_pajak != 'T') {
	                $cari_pajak = DB::table('pajak')
	                              ->where('kode',$invoice[$i]->i_pajak_lain)
	                              ->first();
	                $akun_pph1 = $cari_pajak->acc1;
	                $akun_pph1 = substr($akun_pph1,0, 4);
	                $akun_pph  = DB::table('d_akun')
	                              ->where('id_akun','like',$akun_pph1.'%')
	                              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                              ->first();
	                if ($akun_pph == null) {
	                  return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	                }
	                array_push($akun, $akun_pph->id_akun);
	                array_push($akun_val,round($invoice[$i]->i_pajak_lain));
	              }
	            }

	            // PENDAPATAN SUBCON
	            if ($tot_subcon != 0) {
	              $akun_vendor = DB::table('d_akun')
	                            ->where('id_akun','like','4401'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_vendor == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_vendor->id_akun);
	              array_push($akun_val, round($tot_subcon));
	            }
	            // PENDAPATAN OWN
	            if ($tot_own != 0) {
	              $akun_own = DB::table('d_akun')
	                            ->where('id_akun','like','4201'.'%')
	                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
	                            ->first();
	              if ($akun_own == null) {
	                return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KARGO']);
	              }
	              array_push($akun, $akun_own->id_akun);
	              array_push($akun_val, round($tot_own));
	            }
	          }
	        }else if($invoice[$i]->i_pendapatan == 'KORAN'){
				$pendapatan_koran = [];
				$harga_koran      = [];
				$invoice_detail = DB::table('invoice_d')
	                              ->where('id_nomor_invoice',$invoice[$i]->i_nomor)
	                              ->get();

				for ($a=0; $a < count($invoice_detail); $a++) { 

					$do = DB::table('delivery_orderd')
					        ->where('dd_nomor',$invoice_detail[$a]->id_nomor_do)
					        ->where('dd_id',$invoice_detail[$a]->id_nomor_do_dt)
					        ->first();
					$temp = DB::table('item')
					          ->where('kode',$do->dd_kode_item)
					          ->first();
					array_push($pendapatan_koran, $temp->acc_penjualan);
				}

	        	$pendapatan_koran = array_unique($pendapatan_koran);
	        	$tes = [];
	        	for ($a=0; $a < count($pendapatan_koran); $a++) { 
		          for ($b=0; $b < count($invoice_detail); $b++) { 
		            $do = DB::table('delivery_orderd')
					        ->where('dd_nomor',$invoice_detail[$b]->id_nomor_do)
					        ->where('dd_id',$invoice_detail[$b]->id_nomor_do_dt)
					        ->first();
		            $temp = DB::table('item')
		                      ->where('kode',$do->dd_kode_item)
		                      ->first();
		            if ($temp->acc_penjualan == $pendapatan_koran[$a]) {
		              if (!isset($harga_koran[$a])) {
		                $harga_koran[$a] = 0;
		              }
		              array_push($tes, $invoice_detail[$b]->id_harga_netto);
		              $harga_koran[$a] += $invoice_detail[$b]->id_harga_netto;
		            }
		          }
		        }
		        $akun     = [];
	        	$akun_val = [];
		        if ($invoice[$i]->i_jenis_ppn != 4) {
		        	// MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
					if ($ppn_type == 'npkp') {
						for ($a=0; $a < count($pendapatan_koran); $a++) { 
						  $harga_koran1 = $invoice[$i]->i_ppnrp/($invoice[$i]->i_netto_detail+$invoice[$i]->i_ppnrp) * $harga_koran[$a];
						  $harga_koran[$a] -= $harga_koran1;
						}
					}
					// PIUTANG
					// dd(substr($cari_acc_piutang,0, 4));
					$akun_piutang = DB::table('d_akun')
						              ->where('id_akun','like',substr($invoice[$i]->i_acc_piutang,0, 4).'%')
						              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
						              ->first();
					if ($akun_piutang == null) {
						return response()->json(['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
					}
					array_push($akun, $akun_piutang->id_akun);
	            	array_push($akun_val, round($invoice[$i]->i_total_tagihan));
	            	// DISKON
		            if ($invoice[$i]->i_diskon2 > 0) {
		              $akun_diskon = DB::table('d_akun')
		                            ->where('id_akun','like','5398'.'%')
		                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
		                            ->first();
		              if ($akun_diskon == null) {
		                return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
		              }
		              array_push($akun, $akun_diskon->id_akun);
		              array_push($akun_val, round($invoice[$i]->i_diskon2));
		            }

		            // JURNAL PPN
		            if (isset($akunPPN)) {
		              $akun_ppn = DB::table('d_akun')
		                            ->where('id_akun','like',$akunPPN.'%')
		                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
		                            ->first();
		              if ($akun_ppn == null) {
		                return response()->json(['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
		              }
		              array_push($akun, $akun_ppn->id_akun);
		              array_push($akun_val,round($invoice[$i]->i_ppnrp));
		            }

		            // JURNAL PPH
		            if ($invoice[$i]->i_pajak_lain != '0') {
		              if ($invoice[$i]->i_kode_pajak != 'T') {
		                $cari_pajak = DB::table('pajak')
		                              ->where('kode',$invoice[$i]->i_pajak_lain)
		                              ->first();
		                $akun_pph1 = $cari_pajak->acc1;
		                $akun_pph1 = substr($akun_pph1,0, 4);
		                $akun_pph  = DB::table('d_akun')
		                              ->where('id_akun','like',$akun_pph1.'%')
		                              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
		                              ->first();
		                if ($akun_pph == null) {
		                  return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
		                }
		                array_push($akun, $akun_pph->id_akun);
		                array_push($akun_val,round($invoice[$i]->i_pajak_lain));
		              }
		            }
					    // JURNAL PENDAPATAN
					for ($a=0; $a < count($pendapatan_koran); $a++) { 
						// dd($$pendapatan_koran[$a]);
						$akun_pendapatan = DB::table('d_akun')
						                      ->where('id_akun','like',substr($pendapatan_koran[$a],0, 4).'%')
						                      ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
						                      ->first();
						if ($akun_pendapatan == null) {
							// dd($pendapatan_koran[$a]);
						  return response()->json(['status'=>'gagal','info'=>'Terdapat Akun Pendapatan Yang Tidak Tersedia Untuk Cabang Ini, Harap Hubungi Pihak Terkait KORAN']);
						}
						array_push($akun, $akun_pendapatan->id_akun);
						array_push($akun_val,round($harga_koran[$a]));
					}
		        }else{
		        	// MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
					// PIUTANG
					// dd(substr($cari_acc_piutang,0, 4));
					$akun_piutang = DB::table('d_akun')
						              ->where('id_akun','like',substr($invoice[$i]->i_acc_piutang,0, 4).'%')
						              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
						              ->first();
					if ($akun_piutang == null) {
						return response()->json(['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
					}
					array_push($akun, $akun_piutang->id_akun);
	            	array_push($akun_val, round($invoice[$i]->i_total_tagihan));
	            	// DISKON
		            if ($invoice[$i]->i_diskon2 > 0) {
		              $akun_diskon = DB::table('d_akun')
		                            ->where('id_akun','like','5398'.'%')
		                            ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
		                            ->first();
		              if ($akun_diskon == null) {
		                return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
		              }
		              array_push($akun, $akun_diskon->id_akun);
		              array_push($akun_val, round($invoice[$i]->i_diskon2));
		            }

		            // JURNAL PPH
		            if ($invoice[$i]->i_pajak_lain != '0') {
		              if ($invoice[$i]->i_kode_pajak != 'T') {
		                $cari_pajak = DB::table('pajak')
		                              ->where('kode',$invoice[$i]->i_pajak_lain)
		                              ->first();
		                $akun_pph1 = $cari_pajak->acc1;
		                $akun_pph1 = substr($akun_pph1,0, 4);
		                $akun_pph  = DB::table('d_akun')
		                              ->where('id_akun','like',$akun_pph1.'%')
		                              ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
		                              ->first();
		                if ($akun_pph == null) {
		                  return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait KORAN']);
		                }
		                array_push($akun, $akun_pph->id_akun);
		                array_push($akun_val,round($invoice[$i]->i_pajak_lain));
		              }
		            }
					    // JURNAL PENDAPATAN
					for ($a=0; $a < count($pendapatan_koran); $a++) { 
						$akun_pendapatan = DB::table('d_akun')
						                      ->where('id_akun','like',substr($pendapatan_koran[$a],0, 4).'%')
						                      ->where('kode_cabang',$invoice[$i]->i_kode_cabang)
						                      ->first();
						if ($akun_pendapatan == null) {
						  return response()->json(['status'=>'gagal','info'=>'Terdapat Akun Pendapatan Yang Tidak Tersedia Untuk Cabang Ini, Harap Hubungi Pihak Terkait KORAN']);
						}
						array_push($akun, $akun_pendapatan->id_akun);
						array_push($akun_val,round($harga_koran[$a]));
					}
		        }
	        }
	        $data_akun = [];
			for ($a=0; $a < count($akun); $a++) { 

				$cari_coa = DB::table('d_akun')
				          ->where('id_akun',$akun[$a])
				          ->first();

				if (substr($akun[$a],0, 1)==1) {
				  try{
				  	if ($cari_coa->akun_dka == 'D') {
					    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
					    $data_akun[$a]['jrdt_detailid'] = $a+1;
					    $data_akun[$a]['jrdt_acc']      = $akun[$a];
					    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
					    $data_akun[$a]['jrdt_statusdk'] = 'D';
					    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
					  }else{
					    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
					    $data_akun[$a]['jrdt_detailid'] = $a+1;
					    $data_akun[$a]['jrdt_acc']      = $akun[$a];
					    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
					    $data_akun[$a]['jrdt_statusdk'] = 'K';
					    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
					  }
					}catch(Exception $e){
						dd($akun[$a]);
					}
				  
				}else if (substr($akun[$a],0, 4)==2302 or substr($akun[$a],0, 4)==2398) {

				  if ($cari_coa->akun_dka == 'D') {
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'D';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }else{
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'K';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }
				}else if (substr($akun[$a],0, 4)==2305 or substr($akun[$a],0, 4)==2306 or substr($akun[$a],0, 4)==2307 or substr($akun[$a],0, 4)==2308 or substr($akun[$a],0, 4)==2309) {

				  if ($cari_coa->akun_dka == 'D') {
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = -$akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'K';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }else{
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = -$akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'D';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }
				}else if (substr($akun[$a],0, 4)==2301) {
				    if ($cari_coa->akun_dka == 'D') {
				      $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				      $data_akun[$a]['jrdt_detailid'] = $a+1;
				      $data_akun[$a]['jrdt_acc']      = $akun[$a];
				      $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				      $data_akun[$a]['jrdt_statusdk'] = 'D';
				      $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				    }else{
				      $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				      $data_akun[$a]['jrdt_detailid'] = $a+1;
				      $data_akun[$a]['jrdt_acc']      = $akun[$a];
				      $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				      $data_akun[$a]['jrdt_statusdk'] = 'K';
				      $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				    }
				  }else if (substr($akun[$a],0, 1)==4) {

				  if ($cari_coa->akun_dka == 'D') {
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'D';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }else{
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'K';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }
				}
				else if (substr($akun[$a],0, 1)==5) {

				  if ($cari_coa->akun_dka == 'D') {
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'K';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }else{
				    $data_akun[$a]['jrdt_jurnal']   = $id_jurnal;
				    $data_akun[$a]['jrdt_detailid'] = $a+1;
				    $data_akun[$a]['jrdt_acc']      = $akun[$a];
				    $data_akun[$a]['jrdt_value']    = $akun_val[$a];
				    $data_akun[$a]['jrdt_statusdk'] = 'D';
				    $data_akun[$a]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($invoice[$i]->i_keterangan);
				  }
				}
			}
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
      	}

      	$lihat = DB::table('d_jurnal')->where('jr_detail','like','INVOICE%')->get();
      	// dd($lihat);
    });    
  }
}
