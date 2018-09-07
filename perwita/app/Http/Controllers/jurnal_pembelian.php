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
        $tgl = '01-08-2018';
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
      $databankmasuk = DB::select("select * from bank_masuk");
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
        else {
           $databm = DB::select("select * from bank_masuk where bm_idfpgb = '$idfpgb'");
           $idbm = $databm[0]->bm_id;
           DB::DELETE("DELETE FROM bank_masuk where bm_id = '$idbm'");
        }
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
}
