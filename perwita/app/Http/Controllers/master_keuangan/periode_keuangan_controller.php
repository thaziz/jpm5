<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun_saldo;

use App\d_periode_keuangan;
use DB;
use Session;

class periode_keuangan_controller extends Controller
{
    public function make(Request $request){

        // return json_encode($request->all());
        // dd($request->all());
        $response = [
            'status' => 'sukses',
        ];

        $cek = DB::table('d_periode_keuangan')->where('bulan', $request->bulan)->where("tahun", $request->tahun)->first();

        // return json_encode($cek);

        if(count($cek) > 0){
            $response = [
                'status' => 'exist',
            ];
            return 'Periode Sudah Ada';
            // return json_encode($response);
        }

        // $cek2 = DB::table('d_periode_keuangan')->select("*")->limit(1)->first();

        // return json_encode(value);
        // return json_encode($request->bulan.' dan '.$request->tahun);

        if($request->bulan < date("m") || $request->tahun < date("Y")){
            $response = [
                'status' => 'past_insert',
            ];

            return 'Periode Sudah Berlalu';
        }

        $id = (DB::table("d_periode_keuangan")->max("id") == null) ? 1 : (DB::table("d_periode_keuangan")->max("id")+1);
        $periode = new d_periode_keuangan;

        $periode->id = $id;
        $periode->bulan = $request->bulan;
        $periode->tahun = $request->tahun;
        $periode->status = "accessable";

        // return json_encode($ret);

        if($periode->save()){
            
            // $this->generate_akun($request);

            // return "okee berhasil";

            Session::flash('sukses', 'Periode Berhasil Dibuat');
            return redirect()->back();
        }

        $response = [
            'status' => 'gagal',
        ];

        return 'Gagal Disimpan';

        return json_encode($response);

    }

    public function setting(Request $request){
        // return json_encode($request->all());
        $response = [
            'status' => 'sukses',
        ];

        DB::table('d_periode_keuangan')->whereIn('id', $request->checked)->update([
        	'status'	=> 'locked'
        ]);

        DB::table('d_periode_keuangan')->whereNotIn('id', $request->checked)->update([
        	'status'	=> 'accessable'
        ]);

        Session::flash('sukses', 'Setting Periode Berhasil Diupdate');
        return redirect()->back();
    }


    public function generate_akun($request){
        $data = DB::table("d_akun_saldo")
                    ->where("bulan", "<", $request->bulan)
                    ->where("tahun", "<=", $request->tahun)
                    ->select(DB::raw("distinct(tahun)"), "bulan")->limit(1)->first();

            $d = 0; $t = 0;

            if(count($data) > 0){
                $d = $data->bulan; $t = $data->tahun;
            }

            $akun = DB::table("d_akun")->select("id_akun")->get();

            $ret = [];

            foreach ($akun as $key => $value) {

                $saldo = null; $transaksi = null;

                if($d != 0 && $t != 0){
                    // $saldo = DB::table("d_akun_saldo")
                    //          ->where("id_akun", $value->id_akun)
                    //          ->where("bulan", $d)
                    //          ->where("tahun", "$t")
                    //          ->select('saldo_akun')->first()->saldo_akun;

                    $transaksi = DB::table("d_jurnal_dt")
                                 ->where("jrdt_acc", $value->id_akun)
                                 ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($d, $t){
                                    $query->select("jr_id")
                                          ->from("d_jurnal")
                                          ->where(DB::raw("date_part('month', jr_date)"), $d)
                                          ->where(DB::raw("date_part('year', jr_date)"), $t)->get();
                                 })->select(DB::raw("sum(jrdt_value) as total"))->first()->total;
                }




                $saldo_baru = new master_akun_saldo;
                $saldo_baru->id_akun = $value->id_akun;
                $saldo_baru->tahun = $request->tahun;

                if($saldo == null && $transaksi == null)
                    $saldo_baru->saldo_akun = null ;
                else
                    $saldo_baru->saldo_akun = $saldo + $transaksi ;

                $saldo_baru->is_active = "1";
                $saldo_baru->bulan = $request->bulan;

                $saldo_baru->save();
                
            }

            return true;
    }

    

}
