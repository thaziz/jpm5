<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use carbon\carbon;


class kontrak_Controller extends Controller
{

    public function index(){
        $sql = "    SELECT k.*,c.nama FROM kontrak k
                    LEFT JOIN customer c ON c.kode=k.kode_customer ";
        $data =  DB::select($sql);
        return view('master_sales.kontrak.index',compact('data'));
    }
    
    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $tipe_angkutan = DB::select(" SELECT * FROM tipe_angkutan ORDER BY nama ASC ");
        $satuan = DB::table('satuan')
                         ->get();
        $jenis_tarif = DB::table('jenis_tarif')
                         ->get();
        $now1    = Carbon::now()->subDay(-30)->format('d/m/Y');
        $now    = Carbon::now()->format('d/m/Y');

        
        return view('master_sales.kontrak.form',compact('kota','customer','data','cabang','satuan','tipe_angkutan','akun','now','now1','jenis_tarif'));
    }

    public function kontrak_set_nota(request $request)
    {   
        $month    = Carbon::now()->format('m');
        $year    = Carbon::now()->format('y');
        $idfaktur =   DB::table('kontrak_customer')
                         ->where('kc_kode_cabang' , $request->cabang)
                         ->max('kc_nomor');
        //  dd($nosppid);
            // return $idfaktur;
            if(isset($idfaktur)) {
                $explode  = explode("/", $idfaktur);
                $idfaktur = $explode[2];
                $idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
                $idfaktur = str_replace('-', '', $idfaktur) ;
                $string = (int)$idfaktur + 1;
                $idfaktur = str_pad($string, 5, '0', STR_PAD_LEFT);
            }

            else {
                $idfaktur = '001';
            }

        $nota = 'KNK' . $month . $year . '/' . $request->cabang . '/' .  $idfaktur;
        return response()->json(['nota'=>$nota]);
    }
    public function set_kode_akun_acc(request $request)
    {   
       $data = DB::table('d_akun')
                 ->where('kode_cabang',$request->cabang)
                 ->where('id_parrent','LIKE','%'.'13'.'%')
                 ->get();
       return view('master_sales.kontrak.acc_drop',compact('data'));
    }
     public function set_kode_akun_csf(request $request)
    {
       $data = DB::table('d_akun')
                 ->where('kode_cabang',$request->cabang)
                 ->where('id_parrent','LIKE','%'.'13'.'%')
                 ->get();
       return view('master_sales.kontrak.csf_drop',compact('data'));
    }
}
