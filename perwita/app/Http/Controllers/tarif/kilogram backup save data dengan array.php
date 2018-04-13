  public function save_data (Request $request) {
        // dd($request->all());
        $simpan='';
        $cari = DB::table('kota')  
                  ->where('id_provinsi',$request->cb_provinsi_tujuan)
                  ->get();
        // return $cari;
        $crud = $request->crud;
        

        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;

        $array_harga = [];
        $array_harga_kge = [];
        $array_jenis = ['REGULER','REGULER','REGULER','REGULER','REGULER'];
        $array_jenis_kge = ['EXPRESS','EXPRESS','EXPRESS','EXPRESS','EXPRESS'];
        $array_keterangan  = ['Tarif Kertas / Kg','Tarif <= 10 Kg','Tarif Kg selanjutnya <= 10 Kg','Tarif <= 20 Kg','Tarif Kg selanjutnya <= 20 Kg'];
        $array_keterangan_kge = ['Tarif Kertas / Kg','Tarif <= 10 Kg','Tarif Kg selanjutnya <= 10 Kg','Tarif <= 20 Kg','Tarif Kg selanjutnya <= 20 Kg'];
        $array_waktu = [];
        $array_waktu_kge = [];
        $array_nota  = ['KGR','KGE'];
        $array_note  = [];


        if ($request->harga_outlet == '' or null) {
            $request->harga_outlet = 0;
        }

        array_push($array_harga, $request->tarifkertas_reguler);
        array_push($array_harga, $request->tarif0kg_reguler);
        array_push($array_harga, $request->tarif10kg_reguler);
        array_push($array_harga, $request->tarif20kg_reguler);
        array_push($array_harga, $request->tarifkgsel_reguler);

        array_push($array_harga_kge, $request->tarifkertas_express);
        array_push($array_harga_kge, $request->tarif0kg_express);
        array_push($array_harga_kge, $request->tarif10kg_express);
        array_push($array_harga_kge, $request->tarif20kg_express);
        array_push($array_harga_kge, $request->tarifkgsel_express);

        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);

        array_push($array_waktu_kge, $request->waktu_express);
        array_push($array_waktu_kge, $request->waktu_express);
        array_push($array_waktu_kge, $request->waktu_express);
        array_push($array_waktu_kge, $request->waktu_express);
        array_push($array_waktu_kge, $request->waktu_express);

        $cari_kode_sama = DB::table('tarif_cabang_kilogram')
                            ->max('kode_sama_kilo');
        if ($cari_kode_sama == null) {
            $cari_kode_sama = 1;
        }else{
            $cari_kode_sama += 1;
        }
        if ($crud  == 'N') {
            for ($i=0; $i < count($cari); $i++) { 
                $cari_old0[$i] = DB::table('tarif_cabang_kilogram')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->cb_cabang)
                          ->where('jenis','REGULER')
                          ->get();
                $cari_old1[$i] = DB::table('tarif_cabang_kilogram')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->cb_cabang)
                          ->where('jenis','EXPRESS')
                          ->get();
            }
            $cari_nota0 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_kilogram
                                                WHERE kode_cabang = '$request->cb_cabang'
                                                and jenis = 'REGULER'
                                                ");
            // return $cari_nota0;
            $cari_nota1 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_kilogram
                                                WHERE kode_cabang = '$request->cb_cabang'
                                                and jenis = 'EXPRESS'
                                                ");
            $kode_utama = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
            
            $b=0;
            $s=[];
            $o=[];
             $cabang= Auth::user()->kode_cabang;
             $cari_nota = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_kilogram
                                            WHERE kode_cabang = '$cabang'
                                            AND jenis='REGULER'");
             $index = (integer)$cari_nota[0]->id;

             $cari_nota_kge = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_kilogram
                                            WHERE kode_cabang = '$cabang'
                                            AND jenis='EXPRESS'");
             $index_kge = (integer)$cari_nota[0]->id;

             $d =1;
             $e =1;

                for ($i=0; $i <count($cari) ; $i++) { 
                     for ($a=0; $a < count($array_harga); $a++) { 
                         $index = str_pad($d++, 5, '0', STR_PAD_LEFT);
                         $nota = $request->kodekota.'/KGR' . Auth::user()->kode_cabang . $index;
                         array_push($s, $nota);
                    }
                    $d++;
                }
                for ($p=0; $p <count($cari) ; $p++) { 
                    for ($i=0; $i <count($array_harga_kge) ; $i++) {   
                         $index = str_pad($e++, 5, '0', STR_PAD_LEFT);
                         $nota = $request->kodekota.'/KGE' . Auth::user()->kode_cabang . $index;
                         array_push($o, $nota);
                    }
                    $e++;
                }
                
            $array_note = [$s,$o];
            $array_time = [$array_waktu,$array_waktu_kge];
            $array_keterangan = [$array_keterangan,$array_keterangan_kge];
            $array_uang = [$array_harga,$array_harga_kge];
            $array_jenising = [$array_jenis,$array_jenis_kge];
                        
            $array_nota_baru = 0;
            for ($i=0; $i <count($array_note); $i++) { 
                for ($a=0; $a <count($array_note[$i]) ; $a++) { 
                    // return $array_note[$i];
                    $kode_baru[$array_nota_baru] = $array_note[$i][$a]; 
                $array_nota_baru++;
                }
            }
            $array_waktu_baru = 0;
            for ($i=0; $i <count($array_time); $i++) { 
                for ($a=0; $a <count($array_time[$i]) ; $a++) { 
                    // return $array_note[$i];
                    $waktu_baru[$array_waktu_baru] = $array_time[$i][$a]; 
                $array_waktu_baru++;
                }
            }

            $array_uang_baru = 0;
            for ($i=0; $i <count($array_uang); $i++) { 
                for ($a=0; $a <count($array_uang[$i]) ; $a++) { 
                    // return $array_note[$i];
                    $uang_baru[$array_uang_baru] = $array_uang[$i][$a]; 
                $array_uang_baru++;
                }
            }

            $array_keterangan_baru = 0;
            for ($i=0; $i <count($array_keterangan); $i++) { 
                for ($a=0; $a <count($array_keterangan[$i]) ; $a++) { 
                    // return $array_note[$i];
                    $keterangan_baru[$array_keterangan_baru] = $array_keterangan[$i][$a]; 
                $array_keterangan_baru++;
                }
            }

            $array_jenising_baru = 0;           
            for ($i=0; $i <count($array_jenising); $i++) { 
                for ($a=0; $a <count($array_jenising[$i]) ; $a++) { 
                    // return $array_note[$i];
                    $jenis_baru[$array_jenising_baru] = $array_jenising[$i][$a]; 
                $array_jenising_baru++;
                }
            }
            
            // return $uang_baru;

            $anjay = 0;
            
            for ($i=0; $i <count($cari) ; $i++) { 
                // return $cari[$i]->id;
                for ($k=0; $k <count($uang_baru); $k++) {
                // return $uang_baru; 

                     $kode_detail = DB::table('tarif_cabang_kilogram')
                            ->max('kode_detail_kilo');
                    if ($kode_detail == null) {
                        $kode_detail = 1;
                    }else{
                        $kode_detail += 1;
                    } 
                        // return $kode_baru;
                       $data= DB::table('tarif_cabang_kilogram')
                                    ->insert([
                                            'kode'=>$kode_baru[$anjay],
                                            'kode_sama_kilo' => $cari_kode_sama,
                                            'kode_detail_kilo'=>$kode_detail,
                                            'id_kota_asal' => $request->cb_kota_asal,
                                            'id_kota_tujuan' => $cari[$i]->id,
                                            'kode_cabang' => $request->cb_cabang,
                                            'keterangan' => $keterangan_baru[$k],
                                            'jenis' => $jenis_baru[$k],
                                            'harga' => $uang_baru[$k],
                                            'waktu' => $waktu_baru[$k],
                                            'acc_penjualan'=>$request->cb_acc_penjualan,
                                            'csf_penjualan'=>$request->cb_csf_penjualan,
                                            'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                                            'crud'=>$crud,
                                  ]); 


                    $anjay++;                        
                }   

            }
            return $anjay;  


            // return [$array_time,$array_keterangan,$array_note];
            // for ($i=0; $i < count($cari); $i++) { 
            //     for ($a=0; $a < count($uang_baru); $a++) { 
            //         $kode_detail = DB::table('tarif_cabang_kilogram')
            //                 ->max('kode_detail_kilo');
            //         if ($kode_detail == null) {
            //             $kode_detail = 1;
            //         }else{
            //             $kode_detail += 1;
            //         }   
            //                 if (isset(${'cari_old'.$a}[$i][0]->id_kota_asal) != $request->cb_kota_asal and
            //                     isset(${'cari_old'.$a}[$i][0]->id_kota_tujuan) != $cari[$i]->id and
            //                     isset(${'cari_old'.$a}[$i][0]->kode_cabang) != $request->cb_cabang ) {
            //                     for ($j=0; $j <count($kode_baru) ; $j++) {

            //                         // return $uang_baru; 
            //                        $data = DB::table('tarif_cabang_kilogram')
            //                         ->insert([
            //                                 'kode'=>$kode_baru[$j],
            //                                 'kode_sama_kilo' => $cari_kode_sama,
            //                                 'kode_detail_kilo'=>$kode_detail,
            //                                 'id_kota_asal' => $request->cb_kota_asal,
            //                                 'id_kota_tujuan' => $cari[$i]->id,
            //                                 'kode_cabang' => $request->cb_cabang,
            //                                 'keterangan' => $array_keterangan[$a][$i],
            //                                 'jenis' => $array_jenising[$a][$i],
            //                                 'harga' => $uang_baru[$j],
            //                                 'waktu' => $waktu_baru[$a][$i],
            //                                 'acc_penjualan'=>$request->cb_acc_penjualan,
            //                                 'csf_penjualan'=>$request->cb_csf_penjualan,
            //                                 'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
            //                                 'crud'=>$crud,
            //                       ]); 
            //                     }
            //                        $data1 = DB::table('tarif_cabang_kilogram')
            //                         ->insert([
            //                                 'kode'=>$array_note[$a][$i],
            //                                 'kode_sama_kilo' => $cari_kode_sama,
            //                                 'kode_detail_kilo'=>$kode_detail,
            //                                 'id_kota_asal' => $request->cb_kota_asal,
            //                                 'id_kota_tujuan' => $cari[$i]->id,
            //                                 'kode_cabang' => $request->cb_cabang,
            //                                 'keterangan' => $array_keterangan[$a],
            //                                 'jenis' => $array_jenis[$a],
            //                                 'harga' => $array_harga[$a],
            //                                 'waktu' => $array_waktu[$a],
            //                                 'acc_penjualan'=>$request->cb_acc_penjualan,
            //                                 'csf_penjualan'=>$request->cb_csf_penjualan,
            //                                 'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
            //                                 'crud'=>$crud,
            //                       ]);
            //                 }else{
            //                     if (isset(${'cari_old'.$a}[$i][0]->crud) != 'E') {
            //                         $data = DB::table('tarif_cabang_kilogram')
            //                         ->where('kode',isset(${'cari_old'.$a}[$i][0]->kode))
            //                         ->update([
            //                                 'harga' => $array_harga[$a],
            //                                 'waktu' => $array_waktu[$a],
            //                                 'acc_penjualan'=>$request->ed_acc_penjualan,
            //                                 'csf_penjualan'=>$request->ed_csf_penjualan,
            //                                 'crud'=>'N',
            //                         ]);
            //                     }
                                    
            //                 }
            //     }

            // }
            // return response()->json(['status'=>1]);
        }else if($crud == 'E'){
            $cari_reguler = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_kilogram
                                                WHERE kode = '$request->id_reguler'");
            $cari_express = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_kilogram
                                                WHERE kode = '$request->id_express'");
            $cari_outlet  = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_kilogram
                                                WHERE kode = '$request->id_outlet'");

            
            $index = (integer)$cari_reguler[0]->id;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota  = $kodekota . '/' . 'DR' .$request->cb_cabang .  $index;

            $index = (integer)$cari_express[0]->id;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota1 = $kodekota . '/' . 'DE' .$request->cb_cabang .  $index;

            if ($cari_outlet != null) {
                 $index = (integer)$cari_outlet[0]->id;
                 $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                 $nota2 = $kodekota . '/' . 'DO' .$request->cb_cabang .  $index;

                 if ($nota2 != $request->id_outlet) {
                 $update_outlet = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_outlet)
                                ->update([
                                    'kode'=>$nota2,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_outlet,
                                    'waktu' => $request->waktu_outlet,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
                }else{
                     $update_outlet = DB::table('tarif_cabang_kilogram')
                                    ->where('kode',$request->id_outlet)
                                    ->update([
                                        'id_kota_asal' => $request->cb_kota_asal,
                                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                                        'kode_cabang' => $request->cb_cabang,
                                        'harga' => $request->harga_outlet,
                                        'waktu' => $request->waktu_outlet,
                                        'acc_penjualan'=>$request->ed_acc_penjualan,
                                        'csf_penjualan'=>$request->ed_csf_penjualan,
                                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                        'crud'=>$crud,
                                    ]);
                }
            }
           
            
            if ($nota != $request->id_reguler) {
                $update_reguler = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_reguler)
                                ->update([
                                    'kode'=>$nota,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_regular,
                                    'waktu' => $request->waktu_regular,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }else{
                $update_reguler = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_reguler)
                                ->update([
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_regular,
                                    'waktu' => $request->waktu_regular,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }
            if ($nota1 != $request->id_express) {
                $update_express = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_express)
                                ->update([
                                    'kode'=>$nota1,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_express,
                                    'waktu' => $request->waktu_express,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }else{
                $update_express = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_express)
                                ->update([
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_express,
                                    'waktu' => $request->waktu_express,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }

            
            
           

            echo json_encode('sukses');


        }
        
    
    }s