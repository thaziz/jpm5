 public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
        $kode_sama_sepeda = DB::table('tarif_cabang_sepeda')->select('kode_sama_sepeda')->max('kode_sama_sepeda');    
        if ($kode_sama_sepeda == '') {
            $kode_sama_sepeda = 1;
        }else{
            $kode_sama_sepeda += 1;
        }
        $kode_utama = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->max('kode_detail_sepeda');    
        
         $kode_detail_sepeda = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->max('kode_detail_sepeda');
         $datadetail = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detail_sepedatambah1 = $datadetail[$i]->kode_detail_sepeda;
            }
            $kode_detail_sepedatambah1+1;  
         }
        


        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;


        $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->where('id_provinsi','=',$prov)->get();
        
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
             $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
        }
             $id_provinsi_loop =explode(' ', $id_provinsi_loop);
              json_encode($id_provinsi_loop); 
     
        
     if ($request->cb_kota_tujuan == '' ) {  
      for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
                



          if ($crud =='N') {

              if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }
                        $pancal = array(
                        'kode_sama_sepeda' =>$kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'sepeda_pancal',
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }

            $matik = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

           

               if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }

                     $sport = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

                if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }

                     $moge = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
                  
                  

            $simpan = DB::table('tarif_cabang_sepeda')->insert($pancal);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($sport);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($moge);
        }
      }
    }else{
        $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                     
                  

         if ($crud == 'N') {

                    if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }
                        $pancal = array(
                        'kode_sama_sepeda' =>$kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'sepeda_pancal',
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        // 'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }

            $matik = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        // 'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

           

               if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }

                     $sport = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

                if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
                }

                     $moge = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
                  
                  

            $simpan = DB::table('tarif_cabang_sepeda')->insert($pancal);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($sport);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($moge);
            

        }elseif ($crud == 'E') {
            // dd($request);    
                
                $id_sepeda_edit = $request->id_sepeda_edit;
                $id_matik_edit = $request->id_matik_edit;
                $id_sport_edit = $request->id_sport_edit;
                $id_moge_edit = $request->id_moge_edit;
                $integer_reg =  (int)$id_sepeda_edit;
                $integer_exp =  (int)$id_matik_edit;
                $integer_out =  (int)$id_moge_edit;
                $integer_sport =  (int)$id_sport_edit;
                
                
                $integer_reg = $integer_reg;
                $integer_reg = str_pad($integer_reg, 5,'0',STR_PAD_LEFT);
                $integer_exp = $integer_exp;
                $integer_exp = str_pad($integer_exp, 5,'0',STR_PAD_LEFT);
                $integer_out = $integer_out;
                $integer_out = str_pad($integer_out, 5,'0',STR_PAD_LEFT);
                $integer_sport = $integer_sport;
                $integer_sport = str_pad($integer_sport, 5,'0',STR_PAD_LEFT);
                 
                $kode_reguler_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_reg; 
                $kode_express_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_exp;  
                $kode_outlet_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_out; 
                $kode_sport_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_sport;
                // return $kode_reguler_edit;
                // return $kode_express_edit;
                // return $kode_outlet_edit;
                // return $kode_reguler_edit;
                $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

                $sepedah = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_sepeda_edit,
                        'kode'=>$kode_reguler_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'jenis' => 'sepeda_pancal',
                        'kode_cabang' => $request->ed_cabang,      
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                   );
                   
                // return $regular;
                $matik = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_matik_edit,
                        'kode'=>$kode_express_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang, 
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                    );
                     $sport = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$request->id_sport_edit,
                        'kode'=>$kode_sport_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                    );
                        // return $request->moge; 
                if ($request->moge != null || $request->moge != '') {
                    $moge = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_moge_edit,
                        'kode'=>$kode_outlet_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                    );
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_moge)->update($moge);
            }else if($request->moge == null || $request->moge == ''){ 
                
            }

            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_matik)->update($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sepeda)->update($sepedah);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sport)->update($sport);
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
    
    }



























    // lama


















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
        $array_jenis = ['sepeda_pancal','bebek_matik','laki_sport','moge'];
        $array_waktu = [];
        $array_nota  = ['SPD'];
        $array_note  = [];

        if ($request->harga_outlet == '' or null) {
            $request->harga_outlet = 0;
        }

        array_push($array_harga, $request->sepeda_pancal);
        array_push($array_harga, $request->bebek_matik);
        array_push($array_harga, $request->laki_sport);
        array_push($array_harga, $request->moge);

        array_push($array_waktu, $request->waktu);
        array_push($array_waktu, $request->waktu);
        array_push($array_waktu, $request->waktu);
        array_push($array_waktu, $request->waktu);

        $cari_kode_sama = DB::table('tarif_cabang_sepeda')
                            ->max('kode_sama_sepeda');
        if ($cari_kode_sama == null) {
            $cari_kode_sama = 1;
        }else{
            $cari_kode_sama += 1;
        }
        // return $array_waktu;
       


        // return $array_harga;

        if ($crud  == 'N') {

            for ($i=0; $i < count($cari); $i++) { 
                $cari_old0[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','sepeda_pancal')
                          ->get();

                $cari_old1[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','bebek_matik')
                          ->get();

                $cari_old2[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','laki_sport')
                          ->get();

                $cari_old3[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','moge')
                          ->get();
            }
            // return $cari_old1;
            $cari_nota0 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang' 
                                                and jenis = 'sepeda_pancal'");
            $cari_nota1 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'bebek_matik'");
            $cari_nota2 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'laki_sport'");
            $cari_nota3 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'moge'");
            // return $cari_nota2;
            $id0 = (integer)$cari_nota0[0]->id+1;
            $id1 = (integer)$cari_nota1[0]->id+1;
            $id2 = (integer)$cari_nota2[0]->id+1;
            $id3 = (integer)$cari_nota3[0]->id+1;

            // return [$id0,$id1,$id2,$id3];
            // return $request->ed_cabang;
            for ($i=0; $i < count($cari); $i++) { 
                for ($a=0; $a < count($array_harga); $a++) { 
                    
                    $index = $id0;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota0[$i] = $kodekota . '/' .  'SPD' .$request->ed_cabang .  $index;

                    $index = $id1;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota1[$i] = $kodekota . '/' .  'MTK' .$request->ed_cabang .  $index;

                    $index = $id2;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota2[$i] = $kodekota . '/' .  'SPT' .$request->ed_cabang .  $index;

                    $index = $id3;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota3[$i] = $kodekota . '/' .  'MGE' .$request->ed_cabang .  $index;
                    
                }
                $id0++;
                $id1++;
                $id2++;
                $id3++;
               
            }
            $array_note = [$nota0,$nota1,$nota2,$nota3];
            // return $array_note;

            for ($i=0; $i < count($cari); $i++) { 

                
                for ($a=0; $a < count($array_harga); $a++) { 
                    $kode_detail = DB::table('tarif_cabang_sepeda')
                            ->max('kode_detail_sepeda');
                    if ($kode_detail == null) {
                        $kode_detail = 1;
                    }else{
                        $kode_detail += 1;
                    }
                    // return $array_waktu;
                    // return $cari_old1;
                    // return ${'cari_old'.$a}[$i][0];

                        
                            if (isset(${'cari_old'.$a}[$i][0]->id_kota_asal) != $request->cb_kota_asal and
                                isset(${'cari_old'.$a}[$i][0]->id_kota_tujuan) != $cari[$i]->id and
                                isset(${'cari_old'.$a}[$i][0]->kode_cabang) != $request->ed_cabang ) {

                                    $data = DB::table('tarif_cabang_sepeda')
                                    ->insert([
                                            'kode_sama_sepeda' => $cari_kode_sama,
                                            'kode_detail_sepeda'=>$kode_detail,
                                            'kode'=>$array_note[$a][$i],
                                            'id_kota_asal' => $request->cb_kota_asal,
                                            'id_kota_tujuan' => $cari[$i]->id,
                                            'kode_cabang' => $request->ed_cabang,
                                            'jenis' => $array_jenis[$a],
                                            'harga' => $array_harga[$a],
                                            'waktu' => $array_waktu[$a],
                                            'acc_penjualan'=>$request->ed_acc_penjualan,
                                            'csf_penjualan'=>$request->ed_csf_penjualan,
                                            'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                                            'crud'=>$crud,
                                  ]);
                            }else{
                                if (${'cari_old'.$a}[$i][0]->crud != 'E') {
                                    $data = DB::table('tarif_cabang_sepeda')
                                    ->where('kode',${'cari_old'.$a}[$i][0]->kode)
                                    ->update([
                                            'harga' => $array_harga[$a],
                                            'waktu' => $array_waktu[$a],
                                            'acc_penjualan'=>$request->ed_acc_penjualan,
                                            'csf_penjualan'=>$request->ed_csf_penjualan,
                                            'crud'=>'N',
                                    ]);
                                }
                                    
                            }
                            
                        
                   
                    
                }

            }
            return response()->json(['status'=>1]);
        }else if($crud == 'E'){
          
            
           

         $id_sepeda_edit = $request->id_sepeda_edit;
                $id_matik_edit = $request->id_matik_edit;
                $id_sport_edit = $request->id_sport_edit;
                $id_moge_edit = $request->id_moge_edit;
                $integer_reg =  (int)$id_sepeda_edit;
                $integer_exp =  (int)$id_matik_edit;
                $integer_out =  (int)$id_moge_edit;
                $integer_sport =  (int)$id_sport_edit;
                
                
                $integer_reg = $integer_reg;
                $integer_reg = str_pad($integer_reg, 5,'0',STR_PAD_LEFT);
                $integer_exp = $integer_exp;
                $integer_exp = str_pad($integer_exp, 5,'0',STR_PAD_LEFT);
                $integer_out = $integer_out;
                $integer_out = str_pad($integer_out, 5,'0',STR_PAD_LEFT);
                $integer_sport = $integer_sport;
                $integer_sport = str_pad($integer_sport, 5,'0',STR_PAD_LEFT);
                 
                $kode_reguler_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_reg; 
                $kode_express_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_exp;  
                $kode_outlet_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_out; 
                $kode_sport_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_sport;
                // return $kode_reguler_edit;
                // return $kode_express_edit;
                // return $kode_outlet_edit;
                // return $kode_reguler_edit;
                $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

                $sepedah = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_sepeda_edit,
                        'kode'=>$kode_reguler_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'jenis' => 'sepeda_pancal',
                        'kode_cabang' => $request->ed_cabang,      
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                   );
                   
                // return $regular;
                $matik = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_matik_edit,
                        'kode'=>$kode_express_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang, 
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                    );
                     $sport = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_sport_edit,
                        'kode'=>$kode_sport_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                    );
                        // return $request->moge; 
                if ($request->moge != null || $request->moge != '') {
                    $moge = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_moge_edit,
                        'kode'=>$kode_outlet_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$prov,
                    );
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_moge)->update($moge);
            }else if($request->moge == null || $request->moge == ''){ 
                
            }

            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_matik)->update($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sepeda)->update($sepedah);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sport)->update($sport);
            echo json_encode('sukses');


        }
        
    
    }