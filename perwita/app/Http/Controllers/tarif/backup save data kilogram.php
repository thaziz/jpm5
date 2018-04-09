public function save_data (Request $request) {
        // dd($request);    
        $simpan='';
        $crud = $request->crud;

        $kode_sama = DB::table('tarif_cabang_kilogram')->select('kode_sama_kilo')->max('kode_sama_kilo');    
        if ($kode_sama == '') {
            $kode_sama = 1;
        }else{
            $kode_sama += 1;
        }

        // KODE UTAMA
        $kode_utama = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
          $datadetail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
              $kode_detailtambahutama = $datadetail[$i]->kode_detail_kilo;
            }
            $kode_detailtambahutama+1;  
         }
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
        // return $kode_utama;
        
        $kode_detail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }
          $datadetail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo','keterangan')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail_kilo;

            }
            $kode_detailtambah1+1;  
         }
        $kodecabang = Auth::user()->kode_cabang ;
        $cekdata = DB::table('tarif_cabang_kilogram')->select('kode')->get();
        $kodekota = $request->kodekota;
         
        $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->where('id_provinsi','=',$prov)->get();
        $push = array(); 
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
            $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
             array_push($push,$sel_prov[$for]->id);
              $cek_1x[$for] = DB::table('tarif_cabang_kilogram')->where('kode_cabang','=',$request->cb_cabang)->where('id_kota_asal','=',$request->cb_kota_asal)->where('id_kota_tujuan','=',$push[$for])->get();  
        // return $push[$for];
            
        }
        // return $request->cb_kota_asal;
        // return $cek_1x;
            $id_provinsi_loop =explode(' ', $id_provinsi_loop);
            json_encode($id_provinsi_loop); 

        
    if ($request->cb_kota_tujuan == '') {
         for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
            // return $id_provinsi_loop;    
          $check = DB::table('tarif_cabang_kilogram')->where('kode_cabang','=',$request->cb_cabang)->where('id_kota_asal','=',$request->cb_kota_asal)->Where('id_kota_tujuan','=',$id_provinsi_loop[$save])->get();     
        /*return */$cek = count($check); 
         if ($cek > 0) {
            
            $getkode = array();
            $getasal = array();
            $gettujuan = array();
            $getkodedetil = array();
            $getkodesama = array();
            $getjenis = array();


            $array_waktu = [];
            array_push($array_waktu, $request->waktu_regular);
            array_push($array_waktu, $request->waktu_express);
            // return $array_waktu;
            $array_harga = [];
            array_push($array_harga, $request->tarifkertas_reguler);
            array_push($array_harga, $request->tarif0kg_reguler);
            array_push($array_harga, $request->tarif10kg_reguler);
            array_push($array_harga, $request->tarif20kg_reguler);
            array_push($array_harga, $request->tarifkgsel_reguler);
            array_push($array_harga, $request->tarifkertas_express);
            array_push($array_harga, $request->tarif0kg_express);
            array_push($array_harga, $request->tarif10kg_express);
            array_push($array_harga, $request->tarif20kg_express);
            array_push($array_harga, $request->tarifkgsel_express);
            // return $array_harga;

            $array_jenis = ['Tarif Kertas / Kg','Tarif <= 10 Kg','Tarif Kg selanjutnya <= 10 Kg','Tarif <= 20 Kg','Tarif Kg selanjutnya <= 20 Kg','Tarif Kertas / Kg','Tarif <= 10 Kg','Tarif Kg selanjutnya <= 10 Kg','Tarif <= 20 Kg','Tarif Kg selanjutnya <= 20 Kg'];
            // return $cek_1x;
            for ($gg=0; $gg <count($cek_1x) ; $gg++) { 
                // return $cek_1x[$gg][$gg]->id_kota_tujuan;
                array_push($getasal,$cek_1x[$gg][$gg]->id_kota_asal);
                array_push($gettujuan,$cek_1x[$gg][$gg]->id_kota_tujuan);
                array_push($getkode,$cek_1x[$gg][$gg]->kode);
                array_push($getkodedetil,$cek_1x[$gg][$gg]->kode_detail_kilo);
                array_push($getkodesama,$cek_1x[$gg][$gg]->kode_sama_kilo);
                array_push($getjenis,$cek_1x[$gg][$gg]->jenis);
            }
            
            // return ([$getjenis,$getkode]);
            // dd($request);
               for ($loop2x=0; $loop2x <count($getkode) ; $loop2x++) { 
                        // return $getjenis;
                      $outlet = array(
                                'kode' => $getkode[$loop2x],
                                'kode_sama_kilo' => $getkodesama[$loop2x],
                                'kode_detail_kilo' => $getkodedetil[$loop2x],
                                'keterangan' => $array_jenis[$loop2x],
                                'harga' => $array_harga[$loop2x],
                                'id_kota_tujuan' => $id_provinsi_loop[$save],
                                'crud'=>$crud,
                                //BAWAH SAMA SEMUA
                                'waktu' => '1',
                                'jenis' => $getjenis[$loop2x],
                                'id_kota_asal' => $request->cb_kota_asal,
                                'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                                'kode_cabang' => $request->cb_cabang,
                                'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                                'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                                'crud'=>strtoupper($crud),
                    );
                      // return $outlet;
                      $simpan = DB::table('tarif_cabang_kilogram')->where('kode','=',$getkode[$loop2x])->where('crud','!=','E')->update($outlet);

                                
               }
            $hasil_cek = 'Data Sudah ter-REPLACE database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
         }else{ 
             //GEGE 
            if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }

             $kertas_reguler = array(
                                'kode' => $kode_reguler,
                                'kode_sama_kilo' => $kode_sama,
                                'kode_detail_kilo' => $kode_detail,
                                'keterangan' => 'Tarif Kertas / Kg',
                                'harga' => $request->tarifkertas_reguler,
                                'id_kota_tujuan' => $id_provinsi_loop[$save],
                                'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                                'crud'=>$crud,
                                //BAWAH SAMA SEMUA
                                'waktu' => $request->waktu_regular,
                                'jenis' => 'REGULER',
                                'id_kota_asal' => $request->cb_kota_asal,
                                'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                                'kode_cabang' => $request->cb_cabang,
                                'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                                'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                                'crud'=>strtoupper($crud),
                                // 'id_provinsi_cabkilogram'=>
                            );

                if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
                // return $kode_utama;   
               
               $tarif0_10reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
                // return $kode_utama;   
               
               $tarif10_20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
                // return $kode_utama;   
               
                 $tarif20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                 if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
                // return $kode_utama;   
               
              $tarifkgsel20kg_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

            //----------------------------------- EXPRESSSS ----------------------------------//

            if ($datadetailcount != 0) {
                $kode_detail += 1;
                 $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

                 $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                  if ($datadetailcount != 0) {
                $kode_detail += 1;
                $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

              $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

                $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'crud'=>strtoupper($crud),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

               $tarifkgsel20kg_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );
                    // end GEGE
              // END OF EXPRESS //

            //--------------------------------- SAVE REGULER --------------------------------------//   
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_reguler);
            //---------------------------------- SAVE EXPRESS --------------------------------------//
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_express);
         }
     }
    }else{
    if ($crud == 'N') {
        $kode_utama = $kode_utama+1;
        $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);         
        $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;
        $kot1 = $request->cb_kota_asal;
        $kot2 = $request->cb_kota_tujuan;
        $cek_sendiri = DB::table('tarif_cabang_kilogram')->where('id_kota_asal','=',$kot1)->where('id_kota_tujuan','=',$kot2)->get();      
        $ngecek = count($cek_sendiri);
        if ($ngecek > 1) {
            $hasil_cek = 'Data Sudah ada di database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
        }else{
            //------------------------------------ REGULER ----------------------------------------//
               $kertas_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
             
               
               $tarif0_10reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarif10_20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );   

              if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarif20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );
               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarifkgsel20kg_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );
               // return $kode_reguler;
                //-------------------------------- EXPRESS --------------------------------------//
               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }
                // return $kode_express;

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

              if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
               $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

              if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );   

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );
               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarifkgsel20kg_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

            //------------------------------------------- REGULER -------------------------------------------------/
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_reguler);
            //------------------------------------------- EXPRESS -------------------------------------------------/
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_express);

            }
        }
            elseif ($crud == 'E') {
                // dd($request);
                $kodekota = $request->kodekota;

                $kode0 = $request->kode0; 
                $kode1 = $request->kode1; 
                $kode2 = $request->kode2; 
                $kode3 = $request->kode3; 
                $kode4 = $request->kode4; 
                $kode5 = $request->kode5; 
                $kode6 = $request->kode6; 
                $kode7 = $request->kode7; 
                $kode8 = $request->kode8; 
                $kode9 = $request->kode9; 

                $integer_kode0 =  (int)$kode0;
                $integer_kode1 =  (int)$kode1;
                $integer_kode2 =  (int)$kode2;
                $integer_kode3 =  (int)$kode3;
                $integer_kode4 =  (int)$kode4;
                $integer_kode5 =  (int)$kode5;
                $integer_kode6 =  (int)$kode6;
                $integer_kode7 =  (int)$kode7;
                $integer_kode8 =  (int)$kode8;
                $integer_kode9 =  (int)$kode9;
        
                $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

                $integer_kode0 = $integer_kode0;
                $integer_kode0 = str_pad($integer_kode0, 5,'0',STR_PAD_LEFT);
                $kode0_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode0; 

                $integer_kode1 = $integer_kode1;
                $integer_kode1 = str_pad($integer_kode1, 5,'0',STR_PAD_LEFT);
                $kode1_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode1;
                
                $integer_kode2 = $integer_kode2;
                $integer_kode2 = str_pad($integer_kode2, 5,'0',STR_PAD_LEFT);   
                $kode2_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode2;
                
                $integer_kode3 = $integer_kode3;
                $integer_kode3 = str_pad($integer_kode3, 5,'0',STR_PAD_LEFT); 
                $kode3_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode3;
                
                $integer_kode4 = $integer_kode4;
                $integer_kode4 = str_pad($integer_kode4, 5,'0',STR_PAD_LEFT);  
                $kode4_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode4;
                
                $integer_kode5 = $integer_kode5;
                $integer_kode5 = str_pad($integer_kode5, 5,'0',STR_PAD_LEFT);  
                $kode5_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode5;
                
                $integer_kode6= $integer_kode6;
                $integer_kode6 = str_pad($integer_kode6, 5,'0',STR_PAD_LEFT);    
                $kode6_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode6;
                
                $integer_kode7 = $integer_kode7;
                $integer_kode7 = str_pad($integer_kode7, 5,'0',STR_PAD_LEFT);   
                $kode7_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode7;
                
                $integer_kode8 = $integer_kode8;
                $integer_kode8 = str_pad($integer_kode8, 5,'0',STR_PAD_LEFT);  
                $kode8_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode8;
                
                $integer_kode9 = $integer_kode9;
                $integer_kode9 = str_pad($integer_kode9, 5,'0',STR_PAD_LEFT);   
                $kode9_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode9;



            $kertas_reguler = array(
                    'kode' => $kode0_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode0,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,

                );
               $tarif0_10reguler = array(
                    'kode' => $kode1_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode1,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );    
               $tarif10_20reguler = array(
                    'kode' => $kode2_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode2,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );    
               $tarif20reguler = array(
                    'kode' => $kode3_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode3,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarifkgselreguler = array(
                    'kode' => $kode4_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode4,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               //----------------------------------- EXPRESS --------------------------------------------------//
                $kertas_express = array(
                    'kode' => $kode5_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode5,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarif0_10express = array(
                    'kode' => $kode6_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode6,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarif10_20express = array(
                    'kode' => $kode7_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode7,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );   
               $tarif20express = array(
                    'kode' => $kode8_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode8,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarifkgselexpress = array(
                    'kode' => $kode9_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode9,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );

            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id0)->update($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id1)->update($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id2)->update($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id3)->update($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id4)->update($tarifkgselreguler);

            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id5)->update($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id6)->update($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id7)->update($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id8)->update($tarif20express);

            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id9)->update($tarifkgselexpress);
        }
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']='eror';
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }