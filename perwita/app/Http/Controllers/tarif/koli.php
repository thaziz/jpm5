public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
          // KODE UTAMA
        $kode_utama = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->max('kode_detail_kargo');
          $datadetail = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
              $kode_detailtambahutama = $datadetail[$i]->kode_detail_kargo;
            }
            $kode_detailtambahutama+1;  
         }
        
        // return $kode_utama;
        //end
        //KODE 
        $kode_detail = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->max('kode_detail_kargo');
        
          $datadetail = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail_kargo;

            }
            $kode_detailtambah1+1;  
         }
         // for ($i=0; $i <$datadetail ; $i++) {  
         //     $datadetail[$i]->keterangan;
             
         //     dd($datadetail);
         // }
        
        $kodecabang = Auth::user()->kode_cabang ;
        

      $cekdata = DB::table('tarif_cabang_kargo')->select('kode')->get();
            
        // return $cekdata;

      

        $kodekota = $request->kodekota;

        $jt_kode = DB::table('jenis_tarif')
                     ->where('jt_id',$request->cb_jenis)
                      ->first();
        // return $request->cb_jenis;
           
        $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->orWhere('id_provinsi','=',$prov)->get();
        
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
             $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
        }
        $id_provinsi_loop =explode(' ', $id_provinsi_loop);
        json_encode($id_provinsi_loop); 

        if ($request->cb_kota_tujuan == '' || $request->cb_kota_tujuan == null) {
               if ($crud == 'N') {
                for ($save=1; $save <count($id_provinsi_loop) ; $save++) {

                if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                 $kodeutama = $kodekota.'/'.'KRG'.$jt_kode->jt_kode.$kodecabang.$kode_utama;
                    

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kodeutama = $kodekota.'/'.'KRG'.$jt_kode->jt_kode.$kodecabang.$kode_utama;           
                }
                   // return $kodeutama = $kodeutama ;

                    $data = array(
                        'kode' => strtoupper($kodeutama),
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'jenis' => $request->cb_jenis,
                        'kode_satuan' => $request->satuan,
                        'kode_angkutan' => $request->cb_angkutan,
                        'kode_detail_kargo' => $kode_detail,
                        'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                        'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                        'acc_penjualan' => $request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'create_at'=>carbon::now(),
                        'create_by'=>Auth::user()->m_username,
                        'kode_cabang'=>$request->ed_cabang,
                        'kode_provinsi'=>$request->cb_provinsi_tujuan,
                    );
                    $simpan = DB::table('tarif_cabang_kargo')->insert($data);
                }
            }
        }else if($request->cb_kota_tujuan != '' || $request->cb_kota_tujuan != null) {
           if ($crud == 'N') {
            $data = array(
                'kode' => strtoupper($kodeutama),
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'jenis' => $request->cb_jenis,
                'kode_satuan' => $request->satuan,
                'kode_angkutan' => $request->cb_angkutan,
                'kode_detail_kargo' => $kode_detail,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                'acc_penjualan' => $request->ed_acc_penjualan,
                'csf_penjualan'=>$request->ed_csf_penjualan,
                'create_at'=>carbon::now(),
                'create_by'=>Auth::user()->m_username,
                'kode_provinsi'=>$request->cb_provinsi_tujuan,
                'kode_cabang'=>$request->ed_cabang,
            );
            $simpan = DB::table('tarif_cabang_kargo')->insert($data);
        }elseif ($crud == 'E') {
            
                 $id = $request->ed_kode_old;

                $integer =  (int)$id;              
                
                // $integer = $integer;
                $integer = str_pad($integer, 5,'0',STR_PAD_LEFT);
                $kodekota = $request->kodekota;

                 
                $id_kode = $kodekota.'/'.'KRG'.$jt_kode->jt_kode.$kodecabang.$integer;           
                
                // return $request->ed_kode_lama;
                 $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

            $data = array(
                'kode' => $id_kode,
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'kode_satuan' => $request->satuan,
                'jenis' => $request->cb_jenis,
                'kode_angkutan' => $request->cb_angkutan,
                'kode_detail_kargo' => $request->ed_kode_old,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                'acc_penjualan' => $request->ed_acc_penjualan,
                'csf_penjualan'=>$request->ed_csf_penjualan,
                'update_at'=>carbon::now(),
                'create_by'=>Auth::user()->m_username,
                'kode_cabang'=>$request->ed_cabang,
                'kode_provinsi'=>$prov,
            );
            // dd($request->ed_kode);
            $simpan = DB::table('tarif_cabang_kargo')->where('kode', $request->ed_kode_lama)->update($data);
        }
        }


        
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }