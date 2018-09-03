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
   
}
