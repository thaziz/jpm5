<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\v_hutang;
use App\vd_hutang;
use Illuminate\Http\Request;
use redirect;
use Response;
use DB;
use App\Http\Controllers\v_hutangController;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Auth;
Use App\d_jurnal_dt;
Use App\d_jurnal;

class v_hutangController extends Controller
{
   public function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = $this->kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . $this->kekata($x - 100);
    } else if ($x <1000) {
        $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . $this->kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
 
  public function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim($this->kekata($x));
    } else {
        $hasil = trim($this->kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}
  
  
    public function simpan(Request $request){
      return DB::transaction(function() use ($request) {  
          $comp = $request->cabang;
      $datakun2 = DB::select("select * from d_akun where id_akun LIKE '2101%' and kode_cabang = '$comp'");
      
      if(count($datakun2) == 0){
        $dataInfo=['status'=>'gagal','info'=>'Akun Voucher Hutang Untuk Cabang '.$comp.' Tersedia'];
        DB::rollback();
        return json_encode($dataInfo);    
      }
      else {
        $dataakunitem = $datakun2[0]->id_akun;
      }

      $datajurnal = [];
      $totalhutang = 0;
        

       $anj = DB::table('v_hutang')->max('v_id');

       if ($anj == '' ) {
         $anj=1;
       //  return json_encode('kosong');
       }
       else{
          $anj+=1;
       // return json_encode('tdk kosong');
       }

          $nosupplier = $request->suppilername;

          $datasupplier = DB::select("select * from supplier where no_supplier = '$nosupplier'");
          $acchutangsup = $datasupplier[0]->acc_hutang;

          $subacchutang = substr($acchutangsup, 0 , 4);
          $datakun = DB::select("select * from d_akun where id_akun LIKE '$subacchutang%' and  kode_cabang = '$comp'");
          $acchutangsupplier = $datakun[0]->id_akun;

       $total = str_replace("," , "" , $request->hasil);

        $store1 = new v_hutang;
        $store1->v_id  = $anj;
        $store1->v_nomorbukti =$request->nobukti;
        $store1->v_tgl =$request->tgl;
        $store1->v_tempo =$request->tempo;
        $store1->v_supid =$request->suppilername;
        $store1->v_keterangan =$request->ket;
        $store1->v_hasil =$total;
        $store1->v_pelunasan =$total;
   //     $store1->v_akunhutang = $dataakunitem;
        $store1->vc_comp = $request->cabang;
        $store1->v_acchutang = $acchutangsupplier;
        $store1->created_by = $request->username;
        $store1->updated_by = $request->username;
     //   return json_encode($request->suppilername);
       $store1->save();

     //   return json_encode($request->nobukti);
      $comp = $request->cabang;
       for ($i=0; $i <count($request->accountid); $i++) {


        $nominal = str_replace(',', '', $request->nominal[$i]);
        $idbaru = vd_hutang::max('vd_id');       
        $store2 = new vd_hutang;
        $store2->vd_no=$anj;
        $store2->vd_acc=$request->accountid[$i];
        $store2->vd_keterangan=$request->keterangan[$i];
        $store2->vd_nominal=$nominal;
        $store2->vd_id=$idbaru+1;
        $store2->save();



        $subacchutang = substr($request->accountid[$i], 0 , 4);
        $datakun = DB::select("select * from d_akun where id_akun LIKE '$subacchutang%' and kode_cabang = '$comp'");
        $acchutang = $datakun[0]->id_akun;
        $akundka = $datakun[0]->akun_dka;

        if($akundka == 'K'){
          $datajurnal[$i]['id_akun'] = $acchutang;
          $datajurnal[$i]['subtotal'] = '-' . $nominal;
          $datajurnal[$i]['dk'] = 'D';
        }
        else {
          $datajurnal[$i]['id_akun'] = $acchutang;
          $datajurnal[$i]['subtotal'] = $nominal;
          $datajurnal[$i]['dk'] = 'D';

        }

         /* $datajurnal[$i]['id_akun'] = $acchutang;
          $datajurnal[$i]['subtotal'] = '-' . $nominal;
          $datajurnal[$i]['dk'] = 'D';*/

      }

        //savejurnal
          $nosupplier = $request->suppilername;

          $datasupplier = DB::select("select * from supplier where no_supplier = '$nosupplier'");
          $acchutangsup = $datasupplier[0]->acc_hutang;

          $subacchutang = substr($acchutangsup, 0 , 4);
          $datakun = DB::select("select * from d_akun where id_akun LIKE '$subacchutang%' and  kode_cabang = '$comp'");
          $acchutangsupplier = $datakun[0]->id_akun;
          $akundka = $datakun[0]->akun_dka;

        $lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
        if(isset($lastidjurnal)) {
          $idjurnal = $lastidjurnal;
          $idjurnal = (int)$idjurnal + 1;
        }
        else {
          $idjurnal = 1;
        }
      
        $year = date('Y');  
        $date = date('Y-m-d');
        $jurnal = new d_jurnal();
        $jurnal->jr_id = $idjurnal;
            $jurnal->jr_year = date('Y');
            $jurnal->jr_date = date('Y-m-d');
            $jurnal->jr_detail = 'VOUCHER HUTANG';
            $jurnal->jr_ref = $request->nobukti;
            $jurnal->jr_note = $request->ket;
            $jurnal->save();
            
            if($akundka == 'D'){
              $dataakun = array (
                'id_akun' => $acchutangsupplier,
                'subtotal' => '-' .$total,
                'dk' => 'K',
              );
            }
            else {
             $dataakun = array (
                'id_akun' => $acchutangsupplier,
                'subtotal' => $total,
                'dk' => 'K',
              ); 
            }

           array_push($datajurnal, $dataakun );
          $key  = 1;
          for($j = 0; $j < count($datajurnal); $j++){
            
            $lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
          if(isset($lastidjurnaldt)) {
            $idjurnaldt = $lastidjurnaldt;
            $idjurnaldt = (int)$idjurnaldt + 1;
          }
          else {
            $idjurnaldt = 1;
          }

            $jurnaldt = new d_jurnal_dt();
            $jurnaldt->jrdt_jurnal = $idjurnal;
            $jurnaldt->jrdt_detailid = $key;
            $jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
            $jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
            $jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
            $jurnaldt->save();
            $key++;
          }


       /* return response()->json([
                            'status' => 'berhasil',
                            'data' => $store1,
            
                    ]);*/

        return json_encode('sukses');
      });    
    }

    public function voucherhutang() {
     /* $data = DB::table('v_hutang')->get()->OrderBy('v_id' , desc);*/
      $data = DB::select("select * from v_hutang order by v_id desc");

     // dd($data);
    return view('purchase/voucher_hutang/index',compact('data'));
    }
    public function createvoucherhutang() {
      $data = DB::table('v_hutang')->get();
      $sup = DB::select("select * from supplier where status ='SETUJU' and active = 'AKTIF' ");
       $akunselect = DB::table('d_akun')->get();
      //CREATE NOMER VOUCHER HUTANG
      
  //  $newtime = date('Y-M-d H:i:s', $time);  
    
     $year = carbon::now()->format('y');
     $month = carbon::now()->format('m');

      

         //select max dari um_id dari table d_uangmuka
    $maxid = DB::Table('v_hutang')->select('v_id')->max('v_id');

    //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
    if ($maxid <= 0 || $maxid <= '') {
      $maxid  = 1;
    }else{
      $maxid += 1;
    }

    //jika kurang dari 100 maka maxid mimiliki 00 didepannya
    if ($maxid < 100) {
      $maxid = '00'.$maxid;
    }


       $nofp = 'VC' . $month . $year . '/' . 'C001' . '/' .  $maxid;

       $cabang = DB::select("select * from cabang");

      $akun = DB::select("select * from d_akun");
      return view('purchase/voucher_hutang/create',compact('akunselect','data','sup','nofp', 'akun', 'cabang'));
    }
    public function editvoucherhutang($v_id) {
       $data1= v_hutang::findOrfail($v_id);
       $sup = DB::table('supplier')
              ->get();
       $akunselect = DB::table('d_akun')->get();
       $data = DB::select("select * from v_hutang , v_hutangd, supplier where vd_no = v_id and v_supid = no_supplier and active = 'AKTIF'");
   //    dd($data);
      return view('purchase/voucher_hutang/edit',compact('akunselect','data1','suping','data','sup','a','b','c','d','e','f','g'));
    }


    public function getnota(Request $request){


      $cabang = $request->comp;
      $bulan = Carbon::now()->format('m');
      $tahun = Carbon::now()->format('y');

      $vc = DB::select("select * from v_hutang where vc_comp = '$cabang' and to_char(v_tgl, 'MM') = '$bulan' and to_char(v_tgl, 'YY') = '$tahun' order by v_id desc limit 1");

//      return $vc;
      if(count($vc) > 0) {
      
        $explode = explode("/", $vc[0]->v_nomorbukti);
        $idnota = $explode[2];
      

        $idnota = (int)$idnota + 1;
        $idvhc = str_pad($idnota, 4, '0', STR_PAD_LEFT);
        
      }

      else {
    
        $idvhc = '0001';
      }

      $datainfo = ['status' => 'sukses' , 'data' => $idvhc];

      return json_encode($datainfo);
  }


    public function updatevoucherhutang(Request $request,$v_id){
    
            $this->hapusvoucherhutang($v_id);
            $this->simpan($request);

    }



    public function hapusvoucherhutang($v_id){
       DB::table('v_hutang')->where('v_id','=',$v_id)->delete();  
       DB::table('v_hutangd')->where('vd_no','=',$v_id)->delete();         
      return redirect('voucherhutang/voucherhutang');
    }
    public function detailvoucherhutang($v_id) {  
      $data = DB::table('v_hutangd')->join('v_hutang','v_hutangd.vd_no','=','v_hutang.v_id')->join('supplier','supplier.no_supplier','=','v_hutang.v_supid')->where('vd_no','=',$v_id)->get();
      foreach ($data as $key => $value) {
        $a = $value->v_nomorbukti;
      }
      foreach ($data as $key => $value) {
        $b = $value->v_tgl;
      }
      foreach ($data as $key => $value) {
        $c = $value->v_supid;
      }
      foreach ($data as $key => $value) {
        $d = $value->v_keterangan;
      }
      foreach ($data as $key => $value) {
        $e = $value->v_tempo;
      }
      foreach ($data as $key => $value) {
        $f = $value->nama_supplier;
      }
      foreach ($data as $key => $value) {
        $g = $value->v_hasil;
      }
    //  dd($data);
      return view('purchase/voucher_hutang/detail',compact('data','a','b','c','d','e','f','g','h','i'));
    }
    public function cetakvoucherhutang($v_id){
       $data=DB::table('v_hutang')->join('v_hutangd','v_hutang.v_id','=','v_hutangd.vd_no')->join('supplier','supplier.no_supplier','=','v_hutang.v_supid')->join('d_akun','d_akun.id_akun','=','v_hutangd.vd_acc')->where('v_id',$v_id)->get();
      foreach ($data as $key => $value) {
        $a = $value->v_nomorbukti; 
      }

      foreach ($data as $key => $value) {
        $b = $value->v_tgl;
      }
      foreach ($data as $key => $value) {
        $c = $value->v_supid;
      }
      foreach ($data as $key => $value) {
        $d = $value->nama_akun;
      }
      foreach ($data as $key => $value) {
        $e = $value->v_hasil;
      }    
      foreach ($data as $key => $value) {
        $f = $value->nama_supplier;
      }
      $g = $this->terbilang($e,$style=3);
      return view('purchase/voucher_hutang/print_voucherhutang',compact('data','a','b','c','d','e','f','g','h','i','j','k','l'));

    }
}
