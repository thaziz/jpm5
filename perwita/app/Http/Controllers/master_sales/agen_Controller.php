<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
// use auth;
use Auth;

class agen_Controller extends Controller
{
    public function table_data () {

         $cabang = Auth::user()->kode_cabang;
      if (Auth::user()->punyaAkses('Agen','all')) {
          $sql = "    SELECT a.kode, a. nama, a.kategori, k.nama kota, a.alamat, a.telpon, a.fax, a.komisi,a.komisi_agen FROM agen a
                    LEFT JOIN kota k ON k.id=a.id_kota  ";
      }else{
         $sql = "    SELECT a.kode, a. nama, a.kategori, k.nama kota, a.alamat, a.telpon, a.fax, a.komisi,a.komisi_agen FROM agen a
                    LEFT JOIN kota k ON k.id=a.id_kota where kode_cabang = '$cabang' ";
      }

    
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
             $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Agen','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Agen','hapus')) {
                                  $div_3  = '<button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>';
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
        $data = DB::table('agen')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
        $kota = strtoupper($request->cb_kota);
        if ($kota == ''){
            $kota=NULL;
        }
        // $kodekode = 0;
        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $day = carbon::now()->format('d');
         // $kodecabang =  auth::user()->kode_cabang;

        if ($request->ed_kode == null || $request->ed_kode == '') {
             $kodekode = DB::table('agen')->max('id_agen');
              if ($kodekode == '' ) {
                 $kodekode=1;
               }
               else{
                  $kodekode+=1;
               }

             


               // return $kodekode;
               if ($kodekode < 1000) {
                  $kodekode = '000'.$kodekode;
                }
                 $kodekode =  /*$kodecabang.*/'AG-'.'001'.'/'.$kodekode;
        }else{
           $kodekode = $request->ed_kode;
        }
          $idagenkode = DB::table('agen')->max('id_agen');
              if ($idagenkode == '' ) {
                 $idagenkode=1;
               }
               else{
                  $idagenkode+=1;
               }
        if ($request->ed_komisi_outlet == '') {
            $request->ed_komisi_outlet = '0';
        }
        if ($request->ed_komisi_agen == '') {
            $request->ed_komisi_agen = '0';
        }
        // return $request->ed_komisi_outlet;
        if ($crud == 'N') {
        $data = array(
                'id_agen'=>strtoupper($idagenkode),
                'kode' => strtoupper($kodekode),
                'nama' => strtoupper($request->ed_nama),
                'kode_area' => strtoupper($request->ed_kode_area),
                'kategori' => strtoupper($request->cb_kategori),
                'id_kota' => $kota,
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'fax' => strtoupper($request->ed_fax),
                'kode_cabang' => strtoupper($request->cb_cabang),
                'komisi' => strtoupper($request->ed_komisi_outlet),
                'syarat_kredit' => $request->syarat_kredit,
                'komisi_agen' => strtoupper($request->ed_komisi_agen),
                'acc_penjualan' => strtoupper($request->ed_acc1),
                'csf_penjualan' => strtoupper($request->ed_acc3),
                'acc_hutang' => strtoupper($request->ed_acc2),
            );
        }elseif ($crud == 'E') {
             $data = array(
                'id_agen'=>strtoupper($request->id_agen),
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'kode_area' => strtoupper($request->ed_kode_area),
                'kategori' => strtoupper($request->cb_kategori),
                'id_kota' => $kota,
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'syarat_kredit' => $request->syarat_kredit,
                'fax' => strtoupper($request->ed_fax),
                'kode_cabang' => strtoupper($request->cb_cabang),
                'komisi' => strtoupper($request->ed_komisi_outlet),
                'komisi_agen' => strtoupper($request->ed_komisi_agen),
                'acc_penjualan' => strtoupper($request->ed_acc1),
                'csf_penjualan' => strtoupper($request->ed_acc3),
                'acc_hutang' => strtoupper($request->ed_acc2),
            );
        }
        if ($crud == 'N') {
            $simpan = DB::table('agen')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('agen')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('agen')->where('kode' ,'=', $id)->delete();
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
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY nama ASC "));
        $akun= DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        return view('master_sales.agen.index',compact('kota','cabang','akun'));
    }

}
