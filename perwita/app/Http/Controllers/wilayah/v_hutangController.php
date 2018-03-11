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
    public function store1(Request $request){
    
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
        $store1->v_supid=$request->supplierid;
        $store1->v_keterangan=$request->ket;
        $store1->v_hasil=$request->total;
        $store1->save();
         $anj = DB::table('v_hutangd')->max('vd_no');
       if ($anj == '' ) {
         $anj=1;
       }
       else{
          $anj+=1;
       }
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
    public function voucherhutang() {
      $data = DB::table('v_hutang')->get();
     // dd($data);
    return view('purchase/voucher_hutang/index',compact('data'));
    }
    public function createvoucherhutang() {
      $data = DB::table('v_hutang')->get();
      $sup = DB::table('supplier')->get();

      //CREATE NOMER VOUCHER HUTANG
      $time = Carbon::now();
  //  $newtime = date('Y-M-d H:i:s', $time);  
    
      $year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
      $month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

      if($month < 10) {
        $month = '0' . $month;
      }

      $year = substr($year, 2);

      $idvoucher =  v_hutang::where('vc_comp' , 'C001')->max('v_id');
      
      //dd($idfaktur);

      if(isset($idvoucher)) {
        /*$explode = explode("/", $idfaktur);
        $idfaktur = $explode[2];*/

        $string = (int)$idvoucher + 1;
        $idvoucher = str_pad($string, 3, '0', STR_PAD_LEFT);
      }

      else {
        $idvoucher = '001';
      }



      $nofp = 'VC' . $month . $year . '/' . 'C001' . '/' .  $idvoucher;

      $akun = DB::select("select * from d_akun where id_kota = '1'");
      return view('purchase/voucher_hutang/create',compact('data','sup','nofp', 'akun'));
    }
    public function editvoucherhutang($v_id) {
       $data1= v_hutang::findOrfail($v_id);
       $sup = DB::table('supplier')
              ->get();
       $data = DB::table('v_hutangd')->join('v_hutang','v_hutangd.vd_no','=','v_hutang.v_id')->join('supplier','supplier.no_supplier','=','v_hutang.v_supid')->where('vd_no','=',$v_id)->get();
      return view('purchase/voucher_hutang/edit',compact('data1','suping','data','sup','a','b','c','d','e','f','g'));
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
    /*  foreach ($data as $key => $value) {
        $h = $value->;
      }
      foreach ($data as $key => $value) {
        $i = $value->;
      }*/
      /*dd($data);*/
      return view('purchase/voucher_hutang/detail',compact('data','a','b','c','d','e','f','g','h','i'));
    }
}
