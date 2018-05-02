<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\tb_coa;
use App\tb_jurnal;
use App\patty_cash;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;

class StockOpnameController extends Controller
{
    public function detailstockopname($id) {
        $data['stockopname'] = DB::select("select * from stock_opname, cabang, mastergudang where so_id = '$id' and so_gudang = mg_id and so_comp = kode");

        $data['stockopnamedt'] = DB::select("select * from stock_opname_dt , stock_opname, masteritem where sod_so_id = so_id and so_id = '$id' and sod_item = kode_item");
        /*dd($data);*/

        return view('purchase/stock_opname/detail' , compact('data'));
    }

    public function printstockopname($id){
        $data['stockopname'] = DB::select("select * from stock_opname, mastergudang where so_id = '$id' and so_gudang = mg_id");
        for ($i=0; $i < count($data['stockopname']); $i++) { 
            $data['tgl'][$i] = Carbon::parse($data['stockopname'][$i]->so_bulan)->format('F');
        }

        $data['stockopname_dt'] = DB::select("select * from stock_opname_dt, masteritem where sod_so_id = '$id' and sod_item = kode_item");
      /*  dd($data);*/
        return view('purchase/stock_opname/print_laporan_opname' , compact('data'));
    }

    public function deletestockopname(Request $request){
        $id = $request->id;
        $dataso = DB::select("select * from stock_opname, stock_opname_dt where sod_so_id = so_id and so_id = '$id'");
        for($i = 0; $i < count($dataso); $i++){
            $status = $dataso[$i]->sod_status;
            if($status == 'kurang'){
                 $qtyselisih = $dataso[$i]->sod_jumlah_status;
                 $item = $dataso[$i]->sod_item;
                 $idso = $dataso[$i]->so_id;
                 $datasm = DB::select("select * from stock_opname_sm where smt_idso = '$idso' and smt_kodeitem = '$item'");
                
                for($b = 0 ; $b < count($datasm); $b++){
                    $idsm = $datasm[$b]->smt_idsm;
                    $smtqty = $datasm[$b]->smt_qty;

                    $stokmutation = DB::select("select * from stock_mutation where sm_id = '$idsm'");
                    $use = $stokmutation[0]->sm_use;
                    $sisa = $stokmutation[0]->sm_sisa;
                    $sm_use = $use - $smtqty;
                    $sm_sisa = $sisa + $smtqty;
                      $updatesm = DB::table('stock_mutation')
                        ->where([['sm_id' , '=' ,$idsm]])
                        ->update([
                            'sm_use' => $sm_use,
                            'sm_sisa' => $sm_sisa,                                        
                        ]);    
                    

                }

            }
            
        }

        DB::delete("DELETE from  stock_mutation where sm_po = '$id' and sm_flag = 'SO'");
        DB::delete("DELETE from  stock_opname where so_id = '$id'");

    }

    public function savestockopname(Request $request){

        return DB::transaction(function() use ($request) { 
        $cari_max_id = DB::table('stock_opname')
                         ->max('so_id');
        if ($cari_max_id != null) {
            $cari_max_id += 1;
        }else{
            $cari_max_id = 1;
        }
        if (in_array('lebih', $request->status) || in_array('kurang', $request->status)) {
            $status = 'TIDAK';
        }else{
            $status = 'SESUAI';
        }
        $today = date("Y-m-d");
        $save_stock_opname = DB::table('stock_opname')
                           ->insert([
                            'so_id'       => $cari_max_id,
                            'so_gudang'   => $request->gudang,
                            'so_bulan'    => $request->tgl,
                            'so_nota'     => $request->so,
                            'so_comp'     => $request->cabang2,
                            'so_user'     => $request->username,
                            'so_status'   => $status,
                            'created_at'  => Carbon::now(),
                            'updated_at'  => Carbon::now(),
                            'so_tgl'      => $today,
                            'create_by'   => $request->username,
                            'update_by'   => $request->username,
                        ]);

        for($i = 0; $i < count($request->sg_item); $i++){


            $explodeitem = explode(",", $request->sg_item[$i]);
            $explodestatus = explode("," , $request->status[$i]);
            $val_status = $explodestatus[1];
            $status = $explodestatus[0];
            $item = $explodeitem[0];
            $idstock = $explodeitem[1];
            $cabang = $request->cabang2;
            $gudang = $request->gudang;

            $dataselisih = DB::select("select * from stock_mutation where sm_item = '$item' and sm_mutcat = '1' and sm_comp = '$cabang' and sm_id_gudang = '$gudang' and sm_sisa != '0' order by sm_id asc");

            /*return $dataselisih[0]->sm_id;*/
            //save stock mutation
            $sisa = $dataselisih[0]->sm_sisa;
           
			if($status != 'sama'){
				if((int)$sisa > (int)$val_status) {
				   if($status == 'kurang')  {
					$cari_id_sm = DB::table('stock_mutation')
									->max('sm_id');
					$cari_id_sm += 1;
					$selisihharga = $dataselisih[0]->sm_hpp;
					$harga = $val_status * $selisihharga;
					$create_sm_mutation = DB::table('stock_mutation')
											->insert([
												'sm_stock'      => $idstock,
												'sm_id'         => $cari_id_sm,
												'sm_comp'       => $request->cabang2,
												'sm_date'       => Carbon::now(),
												'sm_item'       => $item,
												'sm_mutcat'     => 2,
												'sm_qty'        => $val_status,
												'sm_use'        => $val_status,
												'sm_hpp'        => $selisihharga,
												'sm_spptb'      => $request->so,
												'created_at'    => Carbon::now(),
												'updated_at'    => Carbon::now(),
												'sm_po'         => $cari_max_id,
												'sm_id_gudang'  => $request->gudang,
												'sm_sisa'       => 0,
												'sm_flag'       => 'SO',
												'created_by'    => $request->username,
												'updated_by' => $request->username,
											]);

					$smsisa = $dataselisih[0]->sm_sisa - $val_status;
                    $sm_use = $dataselisih[0]->sm_use + $val_status;

				   /* $query5 = stock_mutation::where('sm_id' , '=' , $dataselisih[0]->sm_id);
					$query5->update([
						'sm_use' => $request->val_status[$i],
						'sm_sisa' => $smsisa,
					]); 
	*/
					$setuju_dt = DB::table('stock_mutation')
					->where('sm_id' , $dataselisih[0]->sm_id)
					->update([
						'sm_use' => $sm_use,
						'sm_sisa' => $smsisa,                                        
					]);     

                    $cari_max_ids = DB::table('stock_opname_sm')
                         ->max('smt_id');
                    if ($cari_max_ids != null) {
                        $cari_max_ids += 1;
                    }else{
                        $cari_max_ids = 1;
                    }

                    $create_sm_mutations = DB::table('stock_opname_sm')
                                    ->insert([
                                        'smt_idso'      => $cari_max_id,
                                        'smt_id'         => $cari_max_ids,
                                        'smt_idsm'      =>$dataselisih[0]->sm_id,
                                        'smt_kodeitem'       => $item,
                                        'smt_hpp'     => $selisihharga,
                                        'smt_qty'       => $val_status,
                                        ]);

					}  
				else {
				   $cari_id_sm = DB::table('stock_mutation')
									->max('sm_id');
					$cari_id_sm += 1;
					$selisihharga = $dataselisih[0]->sm_hpp;
					$harga = $val_status * $selisihharga;
					$create_sm_mutation = DB::table('stock_mutation')
											->insert([
												'sm_stock'      => $idstock,
												'sm_id'         => $cari_id_sm,
												'sm_comp'       => $request->cabang2,
												'sm_date'       => Carbon::now(),
												'sm_item'       => $item,
												'sm_mutcat'     => 1,
												'sm_qty'        => $val_status,
												'sm_use'        => 0,
												'sm_hpp'        => $selisihharga,
												'sm_spptb'      => $request->so,
												'created_at'    => Carbon::now(),
												'updated_at'    => Carbon::now(),
												'sm_po'         => $cari_max_id,
												'sm_id_gudang'  => $request->gudang,
												'sm_sisa'       => 0,
												'sm_flag'       => 'SO',
												'created_by'    => $request->username,
												'updated_by' => $request->username,
											]); 
				}       
			   
					//save sodt
					$cari_max_sod = DB::table('stock_opname_dt')
								  ->max('sod_id');

					if ($cari_max_sod != null) {
						$cari_max_sod += 1;
					}else{
						$cari_max_sod = 1;
					}

				 
					$cabang = $request->cabang2;
					$gudang = $request->gudang;

				/*	$dataselisih = DB::select("select * from stock_mutation where sm_item = '$item' and sm_mutcat = '1' and sm_comp = '$cabang' and sm_id_gudang = '$gudang' and sm_sisa != '0' order by sm_id asc");*/


					$selisihharga = $dataselisih[0]->sm_hpp;
					$harga = $val_status * $selisihharga;
					$save_stock_opname_dt = DB::table('stock_opname_dt')
								   ->insert([
									'sod_id'            => $cari_max_sod,
									'sod_so_id'         => $cari_max_id,
									'sod_so_dt'         => $i+1,
									'sod_item'          => $item,
									'sod_jumlah_stock'  => $request->stock[$i],
									'sod_jumlah_real'   => $request->real[$i],
									'sod_status'        => $status,
									'sod_jumlah_status' => $val_status,
									'sod_keterangan'    => $request->keterangan[$i],
									'created_at'        => Carbon::now(),
									'updated_at'        => Carbon::now(),
									'sod_hargaselisih'  => $selisihharga,
									'sod_jumlahselisih' => $harga, 
								]);

            }
            else { // lebihdarisatukali
              /*  return json_encode($dataselisih);/**/
                $tempvalsisa = 1;
                $sisa = 0;
                $hargahasil = 0;
                $selisihhasil = 0;
                $hasil = 0;
                for($x = 0 ; $x < count($dataselisih); $x++){
                    $sisa = (int)$sisa + (int)$dataselisih[$x]->sm_sisa;
                    $hasil = (int)$sisa - (int)$val_status;
                    if((int)$hasil < 0){
                        $tempvalsisa = $tempvalsisa + 1;
                    }
                }
               
                $sisa = 0;
                $hasil = 0;
                for($g=0;$g < $tempvalsisa; $g++){
                   /* return json_encode($dataselisih);*/

                    $sm_qty = $dataselisih[$g]->sm_sisa;

                    $sisa = (int)$sisa + (int)$dataselisih[$g]->sm_sisa;
                    $hasil = (int)$sisa - (int)$val_status;

                   

                    if((int)$hasil > 0){
                        $hasilsisa = (int)$val_status - (int)$sisa2;
                    }
                    else {
                        $hasilsisa = $dataselisih[$g]->sm_sisa;
                        $sisa2 = $sisa;
                    }

                     $selisihharga1 = $dataselisih[$g]->sm_hpp;
                     $harga = $hasilsisa * $selisihharga1;
                     $hargahasil = $hargahasil + $harga;

                      $cari_id_sm = DB::table('stock_mutation')
                                ->max('sm_id');
                      $cari_id_sm += 1;


                      if($status == 'kurang')  {
                            $cari_id_sm = DB::table('stock_mutation')
                                            ->max('sm_id');
                            $cari_id_sm += 1;

                            $selisihharga = $dataselisih[$g]->sm_hpp;
                            $harga = $val_status * $selisihharga;
                            
                            $create_sm_mutation = DB::table('stock_mutation')
                                                    ->insert([
                                                        'sm_stock'      => $idstock,
                                                        'sm_id'         => $cari_id_sm,
                                                        'sm_comp'       => $request->cabang2,
                                                        'sm_date'       => Carbon::now(),
                                                        'sm_item'       => $item,
                                                        'sm_mutcat'     => 2,
                                                        'sm_qty'        => $hasilsisa,
                                                        'sm_use'        => $hasilsisa,
                                                        'sm_hpp'        => $selisihharga,
                                                        'sm_spptb'      => $request->so,
                                                        'created_at'    => Carbon::now(),
                                                        'updated_at'    => Carbon::now(),
                                                        'sm_po'         => $cari_max_id,
                                                        'sm_id_gudang'  => $request->gudang,
                                                        'sm_sisa'       => 0,
                                                        'sm_flag'       => $dataselisih[$g]->sm_id,
                                                        'created_by'    => $request->username,
                                                        'updated_by' => $request->username,
                                                    ]);

                               $smsisa2 = $dataselisih[$g]->sm_qty - $hasilsisa;
                                if((int)$smsisa2 < 0){
                                    $smsisa = 0;
                                }
                                else {
                                    $smsisa = $dataselisih[$g]->sm_sisa - $hasilsisa;
                                }

                              
                                $sm_use = $dataselisih[$g]->sm_use + $hasilsisa;
                            
                                $setuju_dt = DB::table('stock_mutation')
                                                            ->where('sm_id' , $dataselisih[$g]->sm_id)
                                                            ->update([
                                                                'sm_use' => $sm_use,
                                                                'sm_sisa' => $smsisa,                                        
                                                            ]);     
                                
                                $cari_max_ids = DB::table('stock_opname_sm')
                                 ->max('smt_id');
                                if ($cari_max_ids != null) {
                                    $cari_max_ids += 1;
                                }else{
                                    $cari_max_ids = 1;
                                }

                                $create_sm_mutations = DB::table('stock_opname_sm')
                                                ->insert([
                                                    'smt_idso'      => $cari_max_id,
                                                    'smt_id'         => $cari_max_ids,
                                                    'smt_idsm'      =>$dataselisih[$g]->sm_id,
                                                    'smt_kodeitem'       => $item,
                                                    'smt_hpp'     => $selisihharga,
                                                    'smt_qty'   => $hasilsisa,
                                                    ]);

                        }  
                        else { //lebih (stock_mutcat == 1)
                           $cari_id_sm = DB::table('stock_mutation')
                                            ->max('sm_id');
                            $cari_id_sm += 1;
                            $selisihharga = $dataselisih[$g]->sm_hpp;
                            $harga = $hasilsisa * $selisihharga;
                            $hargahasil = $hargahasil + $harga;
                            $create_sm_mutation = DB::table('stock_mutation')
                                                    ->insert([
                                                        'sm_stock'      => $idstock,
                                                        'sm_id'         => $cari_id_sm,
                                                        'sm_comp'       => $request->cabang2,
                                                        'sm_date'       => Carbon::now(),
                                                        'sm_item'       => $item,
                                                        'sm_mutcat'     => 1,
                                                        'sm_qty'        => $hasilsisa,
                                                        'sm_use'        => 0,
                                                        'sm_hpp'        => $selisihharga,
                                                        'sm_spptb'      => $request->so,
                                                        'created_at'    => Carbon::now(),
                                                        'updated_at'    => Carbon::now(),
                                                        'sm_po'         => $cari_max_id,
                                                        'sm_id_gudang'  => $request->gudang,
                                                        'sm_sisa'       => $hasilsisa,
                                                        'sm_flag'       => 'SO',
                                                        'created_by'    => $request->username,
                                                        'updated_by' => $request->username,
                                                    ]); 
                        }
				} // looping tempvalsisa
				 $cari_max_sod = DB::table('stock_opname_dt')
                              ->max('sod_id');

                if ($cari_max_sod != null) {
                    $cari_max_sod += 1;
                }else{
                    $cari_max_sod = 1;
                }

              /*  $item = $request->sg_item[$i];*/
                $cabang = $request->cabang2;
                $gudang = $request->gudang;

              
               /* $harga = $request->val_status[$i] * $selisihharga;*/
                $save_stock_opname_dt = DB::table('stock_opname_dt')
                               ->insert([
                                'sod_id'            => $cari_max_sod,
                                'sod_so_id'         => $cari_max_id,
                                'sod_so_dt'         => $i+1,
                                'sod_item'          => $item,
                                'sod_jumlah_stock'  => $request->stock[$i],
                                'sod_jumlah_real'   => $request->real[$i],
                                'sod_status'        => $status,
                                'sod_jumlah_status' => $val_status,
                                'sod_keterangan'    => $request->keterangan[$i],
                                'created_at'        => Carbon::now(),
                                'updated_at'        => Carbon::now(),
                                
                                'sod_jumlahselisih' => $hargahasil, 
                            ]);
                } // lebih dari satu kali 
            } //sama
            else {
                $cari_max_sod = DB::table('stock_opname_dt')
                              ->max('sod_id');

                if ($cari_max_sod != null) {
                    $cari_max_sod += 1;
                }else{
                    $cari_max_sod = 1;
                }

              /*  $item = $request->sg_item[$i];*/
                $cabang = $request->cabang2;
                $gudang = $request->gudang;

              
               /* $harga = $request->val_status[$i] * $selisihharga;*/
                $save_stock_opname_dt = DB::table('stock_opname_dt')
                               ->insert([
                                'sod_id'            => $cari_max_sod,
                                'sod_so_id'         => $cari_max_id,
                                'sod_so_dt'         => $i+1,
                                'sod_item'          => $item,
                                'sod_jumlah_stock'  => $request->stock[$i],
                                'sod_jumlah_real'   => $request->real[$i],
                                'sod_status'        => $status,
                                'sod_jumlah_status' => $val_status,
                                'sod_keterangan'    => $request->keterangan[$i],
                                'created_at'        => Carbon::now(),
                                'updated_at'        => Carbon::now(),
                            ]);
            }

           /* $iditem = $request->sg_item[$i];*/
            $idcabang = $request->cabang2;
            $idgudang = $request->gudang;

            $iditem = $explodeitem[0];
          

            //updatestockgudang
            if($status == 'kurang'){
                $datagudang = DB::select("select * from stock_gudang where sg_item = '$iditem' and sg_cabang = '$idcabang'and sg_gudang = '$idgudang'");
                $qtygudang = $datagudang[0]->sg_qty;

                $hasilqty = (int)$qtygudang - (int)$val_status;

                $update_stock = DB::table('stock_gudang')
                                  ->where('sg_id',$idstock)
                                  ->update([
                                    'sg_qty'  =>   $hasilqty
                                  ]);
            }
            else if($status == 'lebih'){
                /*   $iditem = $request->sg_item[$i];*/
                    $idcabang = $request->cabang2;
                    $idgudang = $request->gudang;

                $datagudang = DB::select("select * from stock_gudang where sg_item = '$iditem' and sg_cabang = '$idcabang'and sg_gudang = '$idgudang'");
                $qtygudang = $datagudang[0]->sg_qty;

                $hasilqty = (int)$qtygudang + (int)$val_status;

                $update_stock = DB::table('stock_gudang')
                                  ->where('sg_id',$idstock)
                                  ->update([
                                    'sg_qty'  =>   $hasilqty
                                  ]);
            }
        
		}

        }); //save return
    }

}
