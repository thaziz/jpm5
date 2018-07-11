<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use App\master_akun;
use App\master_akun_saldo;

class cabang_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT a.kode, a. nama, k.nama kota, a.alamat, a.telpon, a.fax FROM cabang a
                    LEFT JOIN kota k ON k.id=a.id_kota  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $div_1  =   '<div class="btn-group">';
                              // if (Auth::user()->punyaAkses('Cabang','ubah')) {
                              // $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" >'.'<i class="fa fa-pencil"></i></button>';
                              // }else{
                              $div_2 = '';
                              // }
                              if (Auth::user()->punyaAkses('Cabang','hapus')) {
                              $div_3  = '<button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" >'.
                                        '<i class="fa fa-trash"></i></button>';
                              }else{
                                $div_3 = '';
                              }
                              $div_4   = '</div>';
            $all_div = $div_1 . $div_2 . $div_3 . $div_4;

            $data[$i]['button'] = $all_div;

            $i++;

        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('cabang')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;

        $kode = DB::table('cabang')->max('kode');
        if ($kode == null or 0) {
            $kode = 001;
        }else{
            $kode = $kode;
            $kode = str_pad($kode+1, 3, '0', STR_PAD_LEFT);
        }
        $data = array(
                'kode' => $kode,
                'nama' => strtoupper($request->ed_nama),
                'id_kota' => strtoupper($request->cb_kota),
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'fax' => strtoupper($request->ed_fax),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('cabang')->insert($data);

            $main_id = DB::table("d_akun")->select(DB::raw("distinct(main_id)"))->get();

            foreach ($main_id as $key => $data_main_id) {

                $acc = DB::table("d_akun")->where("main_id", $data_main_id->main_id)->first();

                $prov = DB::table("kota")
                        ->where("kota.id", $request->cb_kota)
                        ->select("kota.id_provinsi")->first();

                $cek = DB::table('d_akun')->where('id_akun', $data_main_id->main_id.''.$prov->id_provinsi.''.$kode)->first();

                if(count($cek) == 0){

                    $akun = new master_akun;
                    $akun->id_akun = $data_main_id->main_id.''.$prov->id_provinsi.''.$kode;
                    $akun->nama_akun = $acc->main_name." ".strtoupper($request->ed_nama);
                    $akun->id_parrent = '\n';
                    $akun->id_provinsi = $prov->id_provinsi;
                    $akun->akun_dka = $acc->akun_dka;
                    $akun->is_active = $acc->is_active;
                    $akun->kode_cabang = $kode;
                    $akun->type_akun = $acc->type_akun;
                    $akun->main_id = $acc->main_id;
                    $akun->main_name = $acc->main_name;
                    $akun->group_neraca = $acc->group_neraca;
                    $akun->group_laba_rugi = $acc->group_laba_rugi;
                    $akun->shareable = $acc->shareable;

                    if($akun->save()){
                        $saldo = new master_akun_saldo;
                        $saldo->id_akun = $data_main_id->main_id.''.$prov->id_provinsi.''.$kode;
                        $saldo->tahun = date("Y");
                        $saldo->is_active = 1;
                        $saldo->bulan = date("m");
                        $saldo->saldo_akun = 0;

                        $saldo->save();
                    }
                }

            }

        }elseif ($crud == 'E') {

            $simpan = DB::table('cabang')->where('kode', $request->ed_kode_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data (Request $request) {
        
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('cabang')->where('kode' ,'=', $id)->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function index(){
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        return view('master_sales.cabang.index',compact('kota'));
    }

}
