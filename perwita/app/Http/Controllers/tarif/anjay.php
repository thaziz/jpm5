$crud = $request->crud;
        $kode_sama = DB::table('tarif_cabang_dokumen')->select('kode_sama')->max('kode_sama');    
        if ($kode_sama == '') {
            $kode_sama = 1;
        }else{
            $kode_sama += 1;
        }
        $kode_utama = DB::table('tarif_cabang_dokumen')->select('kode_detail')->max('kode_detail');    
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
         $kode_detail = DB::table('tarif_cabang_dokumen')->select('kode_detail')->max('kode_detail');
         $datadetail = DB::table('tarif_cabang_dokumen')->select('kode_detail')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail;
            }
            $kode_detailtambah1+1;  
         }
        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }


        
        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;


       /*return*/ $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->orWhere('id_provinsi','=',$prov)->get();
        $push = array(); 
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
             $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
              array_push($push,$sel_prov[$for]->id);

              $cek_1x = DB::table('tarif_cabang_dokumen')->where('kode_cabang','=',$kodecabang)->where('id_kota_asal','=',$request->cb_kota_asal)->whereIn('id_kota_tujuan',$push)->get();  

        }
            // return $cek_1x;
             $id_provinsi_loop =explode(' ', $id_provinsi_loop);
              json_encode($id_provinsi_loop); 
              // dd($request);
     if ($request->cb_kota_tujuan == '' ) {  
      for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
        // return $id_provinsi_loop;
        $check = DB::table('tarif_cabang_dokumen')->where('id_kota_asal','=',$request->cb_kota_asal)->where('id_kota_tujuan','=',$id_provinsi_loop[$save])->where('crud','!=','E')->get();     
       $cek = count($check); 
         if ($cek > 1) {
            
            $getkode = array();
            $getasal = array();
            $gettujuan = array();
            $getkodedetil = array();
            $getkodesama = array();
            $getjenis = array();

            for ($gg=0; $gg <count($cek_1x) ; $gg++) { 
                array_push($getasal,$cek_1x[$gg]->id_kota_asal);
                array_push($gettujuan,$cek_1x[$gg]->id_kota_tujuan);
                array_push($getkode,$cek_1x[$gg]->kode);
                array_push($getkodedetil,$cek_1x[$gg]->kode_detail);
                array_push($getkodesama,$cek_1x[$gg]->kode_sama);
                array_push($getjenis,$cek_1x[$gg]->jenis);
            }
            
            // return ([$getjenis,$getkode]);

               for ($loop2x=0; $loop2x <count($getkode) ; $loop2x++) { 
                      $outlet = array(
                        'kode_sama' => $getkodesama[$loop2x],
                        'kode_detail'=>$getkodedetil[$loop2x],
                        'kode'=>$getkode[$loop2x],
                        'id_kota_asal' => $getasal[$loop2x],
                        'id_kota_tujuan' => $gettujuan[$loop2x],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => $getjenis[$loop2x],
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode','=',$getkode[$loop2x])->where('crud','!=','E')->update($outlet);
               }
             


            $hasil_cek = 'Data Sudah ter-REPLACE database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
            
         }else {

          if ($crud =='N') {
             
           
              if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }
                        $regular = array(
                        'kode_sama' =>$kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_reguler,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'REGULER',
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;            
                }

            $express = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_express,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

            if ($request->harga_outlet != null) {

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;            
                }

                     $outlet = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_outlet,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
                $simpan = DB::table('tarif_cabang_dokumen')->insert($outlet);
                }else{

                }

            $simpan = DB::table('tarif_cabang_dokumen')->insert($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->insert($express);
        }
      }
  }
    }else{
                  
        $kot1 = $request->cb_kota_asal;
        $kot2 = $request->cb_kota_tujuan;
        $cek_sendiri = DB::table('tarif_cabang_dokumen')->where('id_kota_asal','=',$kot1)->where('id_kota_tujuan','=',$kot2)->get();      
        $ngecek = count($cek_sendiri);


         if ($crud == 'N') {
            if ($ngecek > 1) {
                        $hasil_cek = 'Data Sudah ada di database !';
                        $result['hasil_cek']=$hasil_cek;
                        return json_encode($result);
                    }else{
                    $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                /*return*/ $prov = $prov[0]->id_provinsi;
                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama; 
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;    
                }
                    $regular = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_reguler,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'REGULER',
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$prov,
                        'crud'=>$crud,

                    );

                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama; 
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;    
                }
                $express = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_express,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$prov,
                        'crud'=>$crud,

                    );
                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama; 
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama; 
                }
                if ($request->harga_outlet != null) {
                     $outlet = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_outlet,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$prov,
                        'crud'=>$crud,

                    );
                $simpan = DB::table('tarif_cabang_dokumen')->insert($outlet);
                }else{

                }
               
            $simpan = DB::table('tarif_cabang_dokumen')->insert($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->insert($express);
            
          }  
        }else if ($crud == 'E') {
            // dd($request);   
                
                $id_reguler_edit = $request->id_reguler_edit;
                $id_express_edit = $request->id_express_edit;
                $id_outlet_edit = $request->id_outlet_edit;
                $integer_reg =  (int)$id_reguler_edit;
                $integer_exp =  (int)$id_express_edit;
                $integer_out =  (int)$id_outlet_edit;
                
                $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

                $integer_reg = $integer_reg;
                $integer_reg = str_pad($integer_reg, 5,'0',STR_PAD_LEFT);
                $integer_exp = $integer_exp;
                $integer_exp = str_pad($integer_exp, 5,'0',STR_PAD_LEFT);
                $integer_out = $integer_out;
                $integer_out = str_pad($integer_out, 5,'0',STR_PAD_LEFT);
                
                
                    $kode_reguler_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_reg;
                    $kode_express_edit = $kodekota.'/'.'D'.'E'.$kodecabang.$integer_exp;
                    $kode_outlet_edit = $kodekota.'/'.'D'.'O'.$kodecabang.$integer_out;
                

                $regular = array(
                        'kode_sama' => $request->ed_kode_old,
                        'kode_detail'=>$request->id_reguler_edit,
                        'kode'=>$kode_reguler_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'jenis' => 'REGULER',
                        'kode_cabang' => $request->ed_cabang,      
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$prov,
                        'crud'=>$crud,
                   );
                   
                // return $regular;
                $express = array(
                        'kode_sama' => $request->ed_kode_old,
                        'kode_detail'=>$request->id_express_edit,
                        'kode'=>$kode_express_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang, 
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$prov,
                        'crud'=>$crud,
                    );
               
                   
                if ($request->harga_outlet != null) {
                   $outlet = array(
                        'kode_sama' => $request->ed_kode_old,
                        'kode_detail'=>$request->id_outlet_edit,
                        'kode'=>$kode_outlet_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$prov,
                        'crud'=>$crud,
                    );
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_outlet)->update($outlet);

            }else{
                
            }

            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_reguler)->update($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_express)->update($express);
        }
     

    }

     
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']='error';
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);  