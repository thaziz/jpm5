<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use carbon\carbon;
use Auth;
use App\d_jurnal;
use App\formfpg;
use App\d_jurnal_dt;
use App\bank_masuk;
use Exception;
    set_time_limit(60000);

class jurnal_pembelian  extends Controller
{
    public function index()
    { 

        return view('purchase.jurnalselaras.index');
    }

    public function fakturpembelian(){
      return DB::transaction(function() use ($request) { 

       $carifp = DB::select("select * from faktur_pembelian
                            where fp_tipe = 'NS' or fp_tipe = 'J'");

       //deletejurnal
       for($key = 0; $key < count($carifp); $key++){
         $nota = $carifp[$key]->fp_nofaktur;
         $delete = DB::table('d_jurnal')
                           ->where('jr_ref',$nota)
                           ->delete();
       }

       $datajurnalfaktur = [];
       //jurnal kembali
       for($no = 0; $no < count($carifp); $no++){ // per mota
        $nota = $carifp[$no]->fp_nofaktur;
        $jenistransaksi = $carifp[$no]->fp_tipe;
        $ppn = $carifp[$no]->fp_ppn;
        $pph = $carifp[$no]->fp_pph;
        $keterangan = $carifp[$no]->fp_keterangan;
        $jenispph = $carifp[$no]->fp_jenispph;
        $cabang = $carifp[$no]->fp_comp;
        $netto = $carifp[$no]->fp_netto;

        if($jenistransaksi == 'J' || $jenistransaksi == 'NS'){
          $akunhutang =  $carifp[$no]->fp_acchutang;
          $idfp = $carifp[$no]->fp_idfaktur;
          $datafaktur = DB::select("select * from faktur_pembelian,faktur_pembeliandt where fp_idfaktur = '$idfp' and fpdt_idfp = fp_idfaktur");

          //HEADER
            

           if($ppn != ''){ // JURNAL PPN
                $datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$comp'");
                if(count($datakun2) == 0){
                   $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
                    DB::rollback();
                    return json_encode($dataInfo);
                }
                else {
                  $akunppn = $datakun2[0]->id_akun;
                  $akundka = $datakun2[0]->akun_dka;

                    if($akundka == 'K'){
                      $dataakun = array (
                      'id_akun' => $akunppn,
                      'subtotal' => '-' . $ppn,
                      'dk' => 'K',
                      'detail' => $keterangan,
                      );
                    }
                    else {
                      $dataakun = array (
                      'id_akun' => $akunppn,
                      'subtotal' => $ppn,
                      'dk' => 'D',
                      'detail' => $keterangan,
                      );
                    }
                    array_push($datajurnalfaktur, $dataakun );
                  }              
                }
                // END PPN

                //AKUN PPH
                if($pph != ''){       
                  $datapph = DB::select("select * from pajak where id = '$jenispph'");
                  $kodepajak2 = $datapph[0]->acc1;
                  $kodepajak = substr($kodepajak2, 0,4);
                  if($kodepajak != ''){
                  $datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$comp'");
                  if(count($datakun2) == 0){
                    $dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
                      DB::rollback();
                      return json_encode($dataInfo);
                  }
                  else {
                    $akunpph = $datakun2[0]->id_akun;
                    $akundka = $datakun2[0]->akun_dka;

                    if($akundka == 'D'){
                      $dataakun = array (
                      'id_akun' => $akunpph,
                      'subtotal' => '-' . $pph,
                      'dk' => 'K',
                      'detail' => $keterangan,
                      );
                    }
                    else {
                      $dataakun = array (
                      'id_akun' => $akunpph,
                      'subtotal' => $pph,
                      'dk' => 'D',
                      'detail' => $keterangan,
                      );
                    }
                    array_push($datajurnalfaktur, $dataakun);
                  }
                }
              } // END PPH

              // Akun Hutang
              $dataakunhutang = DB::select("select * from d_akun where id_akun LIKE '$akunhutang' where kode_cabang = '$cabang'");

               if($dataakunhutang == 'D'){
                     $dataakun2 = array (
                      'id_akun' => $akunhutang,
                      'subtotal' => '-' . $netto,
                      'dk' => 'D',
                      'detail' => $keterangan,
                      );
               }
               else{
                    $dataakun2 = array (
                      'id_akun' => $akunhutang,
                      'subtotal' => '-' . $pph,
                      'dk' => 'K',
                      'detail' => $keterangan,
                      );
               }

               array_push($datajurnalfaktur, $dataakun2);

          for($j = 0; $j < count($datafaktur); $j++){ //LOOPING 1 FAKTUR
            //akunhutang
            $persediaan = $datafaktur[$j]->fpdt_accpersediaan;
            $biaya = $datafaktur[$j]->fpdt_accbiaya;
            $nominal = $datafaktur[$j]->fpdt_netto;  

            if($persediaan != null){
                $datapersediaan = DB::select("select * from d_akun where id_akun = '$persediaan' and kode_cabang = '$cabang'");

                if($datapersediaan == 'D'){
                  $dataakunpersediaan = array (
                      'id_akun' => $persediaan,
                      'subtotal' => '-' . $nominal,
                      'dk' => 'D',
                      'detail' => $keterangan,
                      );
                }
                else {
                  $dataakunpersediaan = array (
                      'id_akun' => $persediaan,
                      'subtotal' => '-' . $nominal,
                      'dk' => 'K',
                      'detail' => $keterangan,
                      );
                }

               array_push($datajurnalfaktur, $dataakunpersediaan); 
            }

            if($biaya != null){
              $databiaya = DB::select("select * from d_akun = '$biaya' and kode_cabang = '$cabang'");

              if($databiaya == 'D'){
                   $dataakunpersediaan = array (
                      'id_akun' => $persediaan,
                      'subtotal' => '-' . $nominal,
                      'dk' => 'D',
                      'detail' => $keterangan,
                      );
              }
              else {
                    $dataakunpersediaan = array (
                      'id_akun' => $persediaan,
                      'subtotal' => '-' . $nominal,
                      'dk' => 'K',
                      'detail' => $keterangan,
                      );
              }
               array_push($datajurnalfaktur, $dataakunpersediaan); 
            }
          } // end LOOPING 1 FAKTUR

          $jr_no = get_id_jurnal('MM' , $cabang);
          //save jurnal
          $lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
          if(isset($lastidjurnal)) {
            $idjurnal = $lastidjurnal;
            $idjurnal = (int)$idjurnal + 1;
          }
          else {
            $idjurnal = 1;
          }

          $jr_no = get_id_jurnal('MM' , $cabang);

          $year = date('Y');  
          $date = date('Y-m-d');
          $jurnal = new d_jurnal();
          $jurnal->jr_id = $idjurnal;
              $jurnal->jr_year = date('Y');
              $jurnal->jr_date = date('Y-m-d');
              $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
              $jurnal->jr_ref = $nofaktur;
              $jurnal->jr_note = $keterangan;
              $jurnal->jr_no = $jr_no;
              $jurnal->save();

        } // END JURNAL J dan NS
        else {

        }

       }
      return json_encode($carifp);
    });
    }



    function item(Request $request){
       return DB::transaction(function() use ($request) { 
      $cabang = DB::select("select * from cabang");
      $item = DB::select("select * from masteritem");
      DB::delete("DELETE  from master_akun_fitur where maf_group = '2'");
      for($j = 0; $j < count($cabang); $j++){
        for($k = 0; $k < count($item); $k++){
          $kodeakun = $item[$k]->kode_item;
          $namaitem = $item[$k]->nama_masteritem;
          $mafgroup = '2';
          $mafcabang = $cabang[$j]->kode;
          $mafaccpersediaan = $item[$k]->acc_persediaan;
          $mafacchpp = $item[$k]->acc_hpp;

          $mafaccpersediaan = substr($mafaccpersediaan, 0,4);
          $mafacchpp = substr($mafacchpp, 0,4);

          $cekdiaccper = DB::select("select * from d_akun where id_akun LIKE '$mafaccpersediaan%' and kode_cabang = '$mafcabang'");
          $cekdiacchpp = DB::select("select * from d_akun where id_akun LIKE '$mafacchpp%' and kode_cabang = '$mafcabang'");



           $id = DB::table('master_akun_fitur')
                  ->max('maf_id');

              if ($id == null) {
                $id = 1;
              }else{
                $id+=1;
              }

          if($mafaccpersediaan != null){
              if(count($cekdiaccper) != 0) {
                $accpersediaan = $cekdiaccper[0]->id_akun;
                 $save_maf = DB::table('master_akun_fitur')
                    ->insert([
                      'maf_id'        => $id,
                      'maf_kode_akun' => $kodeakun,
                      'maf_nama'      => $namaitem,
                      'maf_group'     => 2,
                      'maf_cabang'    => $mafcabang,
                      'maf_acc_persediaan' => $accpersediaan,
                   ]);
              }
          
          }
          else if($mafacchpp != null) {
            if(count($cekdiacchpp) != 0) {
                $acchpp = $cekdiacchpp[0]->id_akun;
                $save_maf = DB::table('master_akun_fitur')
                        ->insert([
                          'maf_id'        => $id,
                          'maf_kode_akun' => $kodeakun,
                          'maf_nama'      => $namaitem,
                          'maf_group'     => 2,
                          'maf_cabang'    => $mafcabang,
                          'maf_acc_hpp' => $acchpp,
                       ]);
            }
          }

        }
      }

      return json_encode('sukses');
    });
    }

    function nofpg(){
        $date = Carbon::parse($tgl)->format('m');

        $data = DB::select("select * from fpg order by fpg_tgl asc");
        DB::table('fpg')
        ->update(['fpg_nofpg' => null]);

        for($j = 0; $j < count($data); $j++){ 
          $idfpg = $data[$j]->idfpg;         
          $tgl = $data[$j]->fpg_tgl;
          $getmonth = Carbon::parse($tgl)->format('m');
          $gettahun = Carbon::parse($tgl)->format('y');
          $cabang = $data[$j]->fpg_cabang;


          $carinota = DB::select("SELECT  substring(max(fpg_nofpg),13) as id from fpg
                                        WHERE fpg_cabang = '$cabang'
                                        AND to_char(fpg_tgl,'MM') = '$getmonth'
                                        AND to_char(fpg_tgl,'YY') = '$gettahun'");
          

        //  dd($carinota)
            $index = (integer)$carinota[0]->id + 1;
            $index = str_pad($index, 4, '0' , STR_PAD_LEFT);
            $nota = 'FPG' .  $getmonth . $gettahun . '/' . $cabang . '/' . $index;

          DB::table('fpg')
           ->where('idfpg' , $idfpg)
          ->update(['fpg_nofpg' => $nota]);         
        }
    }


    function gantispp(){
      
        
        $data = DB::select("select * from spp order by created_at asc");
        DB::table('spp')
        ->update(['spp_nospp' => null]);

        for($j = 0; $j < count($data); $j++){ 
          $idspp = $data[$j]->spp_id;         
          $tgl = $data[$j]->spp_tgldibutuhkan;

          $getmonth = Carbon::parse($tgl)->format('m');
          $gettahun = Carbon::parse($tgl)->format('y');
          $cabang = $data[$j]->spp_cabang;


          $carinota = DB::select("SELECT  substring(max(spp_nospp),13) as id from spp
                                        WHERE spp_cabang = '$cabang'
                                        AND to_char(spp_tgldibutuhkan,'MM') = '$getmonth'
                                        AND to_char(spp_tgldibutuhkan,'YY') = '$gettahun'");
          

        //  dd($carinota)
            $index = (integer)$carinota[0]->id + 1;
            $index = str_pad($index, 4, '0' , STR_PAD_LEFT);
            $nota = 'SPP' .  $getmonth . $gettahun . '/' . $cabang . '/' . $index;

          DB::table('spp')
           ->where('spp_id' , $idspp)
          ->update(['spp_nospp' => $nota]);  

          if($getmonth == '8'){
             DB::table('spp')
           ->where('spp_id' , $idspp)
          ->update(['spp_tglinput' => $tgl]); 
          }       
        }
    
    }


    function nospp(){
      $date = Carbon::parse($tgl)->format('m');

        $data = DB::select("select * from spp order by spp_ asc");
        DB::table('fpg')
        ->update(['fpg_nofpg' => null]);

        for($j = 0; $j < count($data); $j++){ 
          $idfpg = $data[$j]->idfpg;         
          $tgl = $data[$j]->fpg_tgl;
          $getmonth = Carbon::parse($tgl)->format('m');
          $gettahun = Carbon::parse($tgl)->format('y');
          $cabang = $data[$j]->fpg_cabang;


          $carinota = DB::select("SELECT  substring(max(fpg_nofpg),13) as id from fpg
                                        WHERE fpg_cabang = '$cabang'
                                        AND to_char(fpg_tgl,'MM') = '$getmonth'
                                        AND to_char(fpg_tgl,'YY') = '$gettahun'");
          

        //  dd($carinota)
            $index = (integer)$carinota[0]->id + 1;
            $index = str_pad($index, 4, '0' , STR_PAD_LEFT);
            $nota = 'FPG' .  $getmonth . $gettahun . '/' . $cabang . '/' . $index;

          DB::table('fpg')
           ->where('idfpg' , $idfpg)
          ->update(['fpg_nofpg' => $nota]);         
        }
    }


    function tglpo(){
      $data = DB::select("select * from pembelian_order");
    
      for($j = 0; $j < count($data); $j++){
        $tglpo = Carbon::parse($data[$j]->created_at)->format('Y-m-d');
        $idpo = $data[$j]->po_id;

        DB::table('pembelian_order')
        ->where('po_id' , $idpo)
        ->update(['po_tglspp' => $tglpo]);

        
      }
      return json_encode('sukses');
    }


    function fpgbankmasuk(){
      $databankmasuk = DB::select("select * from bank_masuk order by bm_idfpgb desc");
      $datafpgs = [];

      for($key = 0; $key < count($databankmasuk); $key++){
        $idbm = $databankmasuk[$key]->bm_id;
        $idfpgb = $databankmasuk[$key]->bm_idfpgb;

        $datafpg = DB::select("select * from fpg , fpg_cekbank where fpgb_idfpg = idfpg and fpgb_id = '$idfpgb'");
    
        if(count($datafpg) > 0){
                $notafpg = $datafpg[0]->fpg_nofpg;
                $keteranganfpg = $datafpg[0]->fpg_keterangan;
              
                DB::table('bank_masuk')
                ->where('bm_id' , $idbm)
                ->where('bm_idfpgb' , $idfpgb)
                ->where('bm_keterangan' , $keteranganfpg)
                ->update(['bm_notatransaksi' => $notafpg]);
        }
        else if(count($datafpg) == 0) {
           /*$databm = DB::select("select * from bank_masuk where bm_idfpgb = '$idfpgb'");
           $idbm = $databm[0]->bm_id;
           DB::DELETE("DELETE FROM bank_masuk where bm_id = '$idbm'");
           array_push($datafpgs , $idfpgb);*/
        }



        return $datafpgs;
      }
    }
    


    function duplicatebank(){
      $dataduplicate = DB::select("SELECT mbdt_noseri AS N, count(mbdt_noseri)  FROM masterbank_dt GROUP BY mbdt_noseri HAVING  count(mbdt_noseri) > 1
      ");

        for ($i = 0; $i < count($dataduplicate); $i++){
          $noseri = $dataduplicate[$i]->n;
          $countnoseri = $dataduplicate[$i]->count;
         $carinoseri = DB::select("select mbdt_noseri, mbdt_id,mbdt_nofpg from masterbank_dt where mbdt_noseri = '$noseri'");

         $countnoseri2 = (int)count($carinoseri) - 1;


          //dd($countseri);
          for($j = 0; $j < $countnoseri2; $j++){
           
            $idmbdt = $carinoseri[$j]->mbdt_id;
            $mbdt_nofpg = $carinoseri[$j]->mbdt_nofpg;
            if($mbdt_nofpg == null){
                DB::DELETE("DELETE from masterbank_dt where  mbdt_id = '$idmbdt'");
            }               
          }

        }
    }

    function getupdatefpgbbk(){
      $databbkd = DB::select("select * from bukti_bank_keluar_detail");
      $databbkab = DB::select("select * from bukti_bank_keluar_akunbg");
      $data2 = [];
      

      for($i = 0; $i < count($databbkd); $i++){
        $idfpg2 = $databbkd[$i]->bbkd_idfpg;
        $datafpg = DB::select("select idfpg from fpg where idfpg = '$idfpg2' order by idfpg asc");

        

        if(count($datafpg) == 0){
          array_push($data2, $idfpg2);
        }
        else {
          DB::table('fpg')
            ->where('idfpg' , $idfpg2)
           ->update(['fpg_posting' => "DONE"]);
        }        
      }


       $datanotbbkbg = DB::select("select idfpg from fpg where idfpg NOT IN(select bbkab_idfpg from bukti_bank_keluar_akunbg where bbkab_idfpg is not null) and idfpg not in(select bbkd_idfpg from bukti_bank_keluar_detail where bbkd_idfpg is not null)");
        for($j = 0 ; $j < count($datanotbbkbg); $j++){
          $idfpgbbkbg = $datanotbbkbg[$j]->idfpg;
           DB::table('fpg')
            ->where('idfpg' , $idfpgbbkbg)
           ->update(['fpg_posting' => "NOT"]);
        }


         $arrfpg = [];
      for($j = 0; $j < count($databbkab); $j++){
         $idfpg = $databbkab[$j]->bbkab_idfpg;
          $datafpg = DB::select("select idfpg from fpg where idfpg = '$idfpg' order by idfpg asc");

          array_push($data2 , $datafpg);

          if(count($datafpg) == 0){
            array_push($arrfpg , $idfpg);
          }
          else {
            DB::table('fpg')
              ->where('idfpg' ,$idfpg)
             ->update(['fpg_posting' => "DONE"]);
          }
      }
      return $data2;
    }

    function nofpgbbkab(){
      $dataid = [];
      $databbkb = [];
      $databbkab = DB::select("select * from bukti_bank_keluar_akunbg");
      for($j = 0; $j < count($databbkab); $j++){
        $idfpg = $databbkab[$j]->bbkab_idfpg;
        $datafpg = DB::select("select idfpg, fpg_nofpg from fpg where idfpg = '$idfpg'");
        if(count($datafpg) > 0){
                $nofpg = $datafpg[0]->fpg_nofpg;       
                DB::table('bukti_bank_keluar_akunbg')
                ->where('bbkab_idfpg' , $idfpg)
                ->update(['bbkab_nofpg' => $nofpg]);
              //array_push($databbkb , $datafpg);
        }
        else {
            array_push($dataid , $idfpg);
        }
      }

      return $databbkb;
    }

    function bankmasuk(){
        return DB::transaction(function() {  
      DB::DELETE("DELETE FROM bank_masuk");
      DB::DELETE("DELETE FROM d_jurnal where jr_detail = 'BUKTI BANK MASUK'");
      $datafpg = DB::select("select * from fpg where fpg_jenisbayar = '12' order by idfpg asc");
      for($i = 0; $i < count($datafpg); $i++){
        $kelompokbank = $datafpg[$i]->fpg_kelompok; //kelompok bank
        $idfpg = $datafpg[$i]->idfpg;
        $datafpgb = DB::select("select * from fpg_cekbank, fpg where fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpg_jenisbayar = '12'");
        
            for($j = 0; $j < count($datafpgb); $j++){
              $idfpgb = $datafpgb[$j]->fpgb_id;

              $asalbank = $datafpgb[$j]->fpgb_kodebank;
              $databankasal = DB::select("select * from masterbank where mb_id = '$asalbank'");
              $bankasal = $databankasal[0]->mb_kode;
              $cabangasal = $databankasal[0]->mb_cabangbank;
              $bm_namabankasal = $databankasal[0]->mb_nama;

              $tujuanbank = $datafpgb[$j]->fpgb_banktujuan;
              $databanktujuan = DB::select("select * from masterbank where mb_id = '$tujuanbank'");


              $banktujuan = $databanktujuan[0]->mb_kode;
              $cabangtujuan = $databanktujuan[0]->mb_cabangbank;
              $bm_namabanktujuan = $databanktujuan[0]->mb_nama;
              

              $created_at = $datafpg[$i]->created_at;
              $updated_at = $datafpg[$i]->updated_at;
              $created_by = $datafpg[$i]->create_by;
              $updated_by = $datafpg[$i]->update_by;
              $bm_notatransaksi = $datafpg[$i]->fpg_nofpg;

              if($datafpgb[$j]->fpgb_jenisbayarbank == 'CEKBG'){
                $bm_jenisbayar = $datafpgb[$j]->fpgb_nocheckbg; 
              }
              else {
                $bm_jenisbayar = "INTERNET BANKING"; 
              }

              $bm_idfpgb = $datafpgb[$j]->fpgb_id;
              $bm_nominal = $datafpgb[$j]->fpgb_nominal;
              $bm_keterangan = $datafpg[$i]->fpg_keterangan;
             
              $bankmasuk = new bank_masuk();
  
              $lastid_bm = bank_masuk::max('bm_id');
              if(isset($lastid_bm)){
                $idbm = $lastid_bm;
                $idbm = (int)$idbm + 1;
              }
              else {
                $idbm = 1;
              }

              DB::table('bank_masuk')
              ->insert([
                    'bm_id' => $idbm,
                    'bm_bankasal' => $bankasal,
                    'bm_cabangasal' => $cabangasal,
                    'bm_cabangtujuan' => $cabangtujuan,
                    'bm_banktujuan' => $banktujuan,
                    'bm_status' => 'DIKIRIM',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                    'created_by' => $created_by,
                    'updated_by' => $updated_by,
                    'bm_notatransaksi' => $bm_notatransaksi,
                    'bm_transaksi' => $bm_jenisbayar,
                    'bm_jenisbayar' => $datafpgb[$j]->fpgb_jenisbayarbank,
                    'bm_idfpgb' => $idfpgb,
                    'bm_nominal' => $bm_nominal,
                    'bm_keterangan' => $bm_keterangan,
                    'bm_namabanktujuan' => $bm_namabanktujuan,
                    'bm_namabankasal' => $bm_namabankasal,

              ]);


              //save bbkd
              if($datafpgb[$j]->fpg_kelompok == 'SAMA BANK'){
                if((int)$tujuanbank < 10) {
                  $kodebank = '0' . $tujuanbank;
                }
                else {
                  $kodebank = $tujuanbank;
                }

              $databbkd = DB::select("select * from bukti_bank_keluar,bukti_bank_keluar_detail where bbkd_idfpg = '$idfpg' and bbkd_idbbk = bbk_id");
              
              

              if(count($databbkd) > 0){
                    $tglbbkd = $databbkd[0]->bbk_tgl;
                    $notabm = getnotabm($cabangtujuan , $tglbbkd);

                    $refbm = explode("-", $notabm);
          

                    $kode = $refbm[0] . $kodebank;
                    $notabm = $kode . '-' . $refbm[1];


                    DB::table('bank_masuk')
                    ->where('bm_notatransaksi' , $bm_notatransaksi)
                    ->where('bm_idfpgb' , $idfpgb)
                    ->where('bm_keterangan' , $bm_keterangan)
                    ->update([
                        'bm_tglterima' => $tglbbkd,
                        'bm_status'  => 'DITERIMA',
                        'bm_nota' => $notabm,
                  ]);

                 //  return $notabm;

                    DB::table('bukti_bank_keluar_detail')
                      ->where('bbkd_idfpg' , $idfpg)
                      ->update(['bbkd_notabm' => $notabm]);

               
                    

                    $akunkasbank = '109911000';
                    $datakasbank = DB::select("select * from d_akun where id_akun = '$akunkasbank'");
                    $akundkakasbank = $datakasbank[0]->akun_dka;
                    
                    $databanktujuan = DB::select("select * from d_akun where id_akun = '$banktujuan'");
                    $akundkabank = $databanktujuan[0]->akun_dka;

                    //TUJUAN BANK
                    if($akundkabank == 'D'){
                      $jurnalpbkeluar[0]['id_akun'] = $banktujuan;
                      $jurnalpbkeluar[0]['subtotal'] = $bm_nominal;
                      $jurnalpbkeluar[0]['dk'] = 'D';
                      $jurnalpbkeluar[0]['detail'] = $bm_keterangan;  
                    }
                    else {
                      $jurnalpbkeluar[0]['id_akun'] = $banktujuan;
                      $jurnalpbkeluar[0]['subtotal'] = '-' .$bm_nominal;
                      $jurnalpbkeluar[0]['dk'] = 'D';
                      $jurnalpbkeluar[0]['detail'] = $bm_keterangan;
                    }

                    if($akundkakasbank == 'K'){
                      $jurnalpbkeluar[1]['id_akun'] = $akunkasbank;
                      $jurnalpbkeluar[1]['subtotal'] = $bm_nominal;
                      $jurnalpbkeluar[1]['dk'] = 'K';
                      $jurnalpbkeluar[1]['detail'] = $bm_keterangan;
                    }
                    else {
                      $jurnalpbkeluar[1]['id_akun'] = $akunkasbank;
                      $jurnalpbkeluar[1]['subtotal'] = $bm_nominal;
                      $jurnalpbkeluar[1]['dk'] = 'K';
                      $jurnalpbkeluar[1]['detail'] = $bm_keterangan;
                    }

                    //return $jurnalpbkeluar;
                    if(count($jurnalpbkeluar) != 0){

                        $lastidjurnald = DB::table('d_jurnal')->max('jr_id'); 
                        if(isset($lastidjurnald)) {
                          $idjurnald = $lastidjurnald;
                          $idjurnald = (int)$idjurnald + 1;
                        }
                        else {
                          $idjurnald = 1;
                        }


                        $jr_no = get_id_jurnal('BM'  , $cabangtujuan, $tglbbkd);

                        $ref = explode("-", $jr_no);

                        
                      
                        $kode = $ref[0] . $kodebank;
                        $jr_no = $kode . '-' . $ref[1];

                        $jurnal = new d_jurnal();
                        $jurnal->jr_id = $idjurnald;
                            $jurnal->jr_year = Carbon::parse($tglbbkd)->format('Y');
                            $jurnal->jr_date = $tglbbkd;
                            $jurnal->jr_detail = 'BUKTI BANK MASUK';
                            $jurnal->jr_ref = $notabm;
                            $jurnal->jr_note = $bm_keterangan;
                            $jurnal->jr_no = $jr_no;
                            $jurnal->save();

                        $key = 1;
                      for($j = 0; $j < count($jurnalpbkeluar); $j++){
                            $lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
                        if(isset($lastidjurnaldt)) {
                          $idjurnaldt = $lastidjurnaldt;
                          $idjurnaldt = (int)$idjurnaldt + 1;
                        }
                        else {
                          $idjurnaldt = 1;
                        }

                          $jurnaldt = new d_jurnal_dt();
                          $jurnaldt->jrdt_jurnal = $idjurnald;
                          $jurnaldt->jrdt_detailid = $key;
                          $jurnaldt->jrdt_acc = $jurnalpbkeluar[$j]['id_akun'];
                          $jurnaldt->jrdt_value = $jurnalpbkeluar[$j]['subtotal'];
                          $jurnaldt->jrdt_statusdk = $jurnalpbkeluar[$j]['dk'];
                          $jurnaldt->jrdt_detail = $jurnalpbkeluar[$j]['detail'];
                          $jurnaldt->save();
                          $key++;
                      }

                      //cekjurnal

                      $cekjurnal = check_jurnal($notabm);
                        if($cekjurnal == 0){
                          $dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
                        DB::rollback();
                                          
                        }
                        elseif($cekjurnal == 1) {
                          $dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
                                  
                        } 

                 } // end jurnal pb keluar

            } // bbkd > 0

            } // end sama bank

          } // end data fpgb
      }// end fata fpg
      return 'ok';
    });
    }


    function kasmasuk(){
      $datafpg = DB::select("select * from fpg where fpg_jenisbayar = '1'");
      
    }
}
