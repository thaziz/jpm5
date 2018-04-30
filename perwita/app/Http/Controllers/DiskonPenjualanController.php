<?php

namespace App\Http\Controllers;

use App\d_disc_cabang;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Auth;

class DiskonPenjualanController extends Controller
{
    public function index()
    {
        $cabang = Auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Diskon Penjualan','all')) {
            $data = DB::table('d_disc_cabang')
            ->join('cabang', 'kode', '=', 'dc_cabang')
            ->join('d_akun', 'id_akun', '=', 'dc_kode')
            ->select('dc_cabang', 'nama', 'nama_akun', 'id_akun', 'dc_jenis', 'dc_diskon', 'dc_note', 'dc_kode', 'dc_id')
            ->get();
        }else{
            $data = DB::table('d_disc_cabang')
            ->join('cabang', 'kode', '=', 'dc_cabang')
            ->join('d_akun', 'id_akun', '=', 'dc_kode')
            ->select('dc_cabang', 'nama', 'nama_akun', 'id_akun', 'dc_jenis', 'dc_diskon', 'dc_note', 'dc_kode', 'dc_id')
            ->where('dc_cabang',$cabang)
            ->get();
        }
        

        $status = Session::get('cabang');

        $akun = DB::table('d_akun')
            ->select('id_akun', 'nama_akun')
            // ->where('id_akun', 'like', '5298%')
            ->get();

        if ($status == '000'){
            $cabang = DB::table('cabang')
                ->select('kode', 'nama')
                ->get();

        } else {
            $cabang = DB::table('cabang')
                ->select('kode', 'nama')
                // ->where('kode', '=', $status)
                ->get();

        }

        return view('sales/diskon_penjualan/index', compact('data', 'cabang', 'akun'));
    }

    public function create()
    {
        return view('sales/diskon_penjualan/create');
    }

    public function getAkun(Request $request)
    {
        $kode = $request->cabang;
        $akun = DB::table('d_akun')
            ->select('id_akun', 'nama_akun')
            ->where(function ($q) use ($kode) {
                $q->orWhere('id_akun', 'like', '5298%'.$kode)
                    ->orWhere('id_akun', '=', '5298');
            })
            ->get();
        return response()->json([
            'akun' => $akun
        ]);
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->id_dc == '' || $request->id_dc == null){
                if ($request->cabang == 'ALL'){

                    $cabang = DB::table('cabang')
                        ->select('kode')
                        ->get();

                    $id = DB::table('d_disc_cabang')
                        ->max('dc_id');

                    $id = $id + 1;

                    for ($i = 0; $i < count($cabang); $i++){

                        $save = new d_disc_cabang();
                        $save->dc_id = $id + $i;
                        $save->dc_cabang = $cabang[$i]->kode;
                        $save->dc_diskon = $request->diskon;
                        $save->dc_jenis = $request->jenis;
                        $save->dc_kode = $request->akun;
                        $save->dc_note = $request->keterangan;
                        $save->save();

                    }

                } else {
                    $id = DB::table('d_disc_cabang')
                        ->max('dc_id');

                    $id = $id + 1;

                    $save = new d_disc_cabang();
                    $save->dc_id = $id;
                    $save->dc_cabang = $request->cabang;
                    $save->dc_diskon = $request->diskon;
                    $save->dc_jenis = $request->jenis;
                    $save->dc_kode = $request->akun;
                    $save->dc_note = $request->keterangan;
                    $save->save();
                }

            } else {
                $data = array(
                    'dc_cabang' => $request->cabang,
                    'dc_diskon' => $request->diskon,
                    'dc_jenis' => $request->jenis,
                    'dc_kode' => $request->akun,
                    'dc_note' => $request->keterangan
                );

                DB::table('d_disc_cabang')->where('dc_id', $request->id_dc)->update($data);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }

    }

    public function getData(Request $request)
    {
        $id = $request->id;
        $data = DB::table('d_disc_cabang')
            ->join('cabang', 'kode', '=', 'dc_cabang')
            ->join('d_akun', 'id_akun', '=', 'dc_kode')
            ->select('d_disc_cabang.*', 'nama_akun', 'nama')
            ->where('dc_id', '=', $id)
            ->get();

        $akun = DB::table('d_akun')
            ->select('id_akun', 'nama_akun')
            ->where(function ($q) use ($data) {
                $q->orWhere('id_akun', 'like', '5298%'.$data[0]->dc_kode)
                    ->orWhere('id_akun', '=', '5298');
            })
            ->get();

        $cabang = DB::table('cabang')
            ->select('kode', 'nama')
            ->get();

        return response()->json([
            'data' => $data,
            'akun' => $akun,
            'cabang' => $cabang
        ]);
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            DB::table('d_disc_cabang')->where('dc_id', '=', $id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'sukses',
                'error' => $e,
            ]);
        }

    }
}
