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
    public function store1(Request $request){
      if ($nomorbukti == null || $nomorbukti == '') {
       $nomorbukti = DB::table('v_hutang')->select('v_nomorbukti')->get();
       $anj = DB::table('v_hutang')->max('v_id');
       if ($anj == '' ) {
         $anj=1;
       }
       else{
          $anj+=1;
       }
        $store1 = new v_hutang;
        $store1->v_id=$anj;
        $store1->v_nomorbukti=$request->nobukti;
        $store1->v_tgl=$request->tgl;
        $store1->v_tempo=$request->tempo;
        $store1->v_supid=$request->suppilername;
        $store1->v_keterangan=$request->ket;
        $store1->v_hasil=$request->total;
        $store1->v_pelunasan=$request->total;
        $store1->save();

       for ($i=0; $i <count($request->accountid); $i++) {
        $idbaru = vd_hutang::max('vd_id');       
        $store2 = new vd_hutang;
        $store2->vd_no=$anj;
        $store2->vd_acc=$request->accountid[$i];
        $store2->vd_keterangan=$request->keterangan[$i];
        $store2->vd_nominal=$request->nominal[$i];
        $store2->vd_id=$idbaru+1;
        $store2->save();
}

        
          

        return response()->json([
                            'status' => 'berhasil',
                            'data' => $store1,
            
                    ]);

      }
      else{
        return redirect('voucherhutang.voucherhutang');
      }
    }
    public function voucherhutang() {
      $data = DB::table('v_hutang')->get();
     // dd($data);
    return view('purchase/voucher_hutang/index',compact('data'));
    }
    public function createvoucherhutang() {
      $data = DB::table('v_hutang')->get();
      $sup = DB::table('supplier')->get();
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

      $akun = DB::select("select * from d_akun where kode_cabang = 'C001'");
      return view('purchase/voucher_hutang/create',compact('akunselect','data','sup','nofp', 'akun'));
    }
    public function editvoucherhutang($v_id) {
       $data1= v_hutang::findOrfail($v_id);
       $sup = DB::table('supplier')
              ->get();
       $akunselect = DB::table('d_akun')->get();
       $data = DB::table('v_hutangd')->join('v_hutang','v_hutangd.vd_no','=','v_hutang.v_id')->join('supplier','supplier.no_supplier','=','v_hutang.v_supid')->where('vd_no','=',$v_id)->where('status','=','SETUJU')->where('active','=','ACTIF')->get();
      return view('purchase/voucher_hutang/edit',compact('akunselect','data1','suping','data','sup','a','b','c','d','e','f','g'));
    }



    public function updatevoucherhutang(Request $request,$v_id){
    
            $this->hapusvoucherhutang($v_id);
            $this->store1($request);

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
