<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;

class vendor_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT a.kode, a.nama, a.alamat, k.nama kota, a.telpon, a.status FROM vendor a
                    LEFT JOIN kota k ON k.id=a.id_kota  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            
            if ($data[$i]['status']==TRUE) {
                    $Aktif = 'checked';
            } else {
                    $Aktif = '';
            }
            $data[$i]['status'] = '<input type="checkbox" '.$Aktif.' id="'.$data[$i]['kode'].'" class="btnaktif" >';
            // add new button
            $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Vendor','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Vendor','hapus')) {
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
        $data = DB::table('vendor')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $statusbol = $request->ck_status;
        if ($statusbol == null || $statusbol == '') {
            $statusbol = 'false';
        }else{
            $statusbol = 'true';
        }
     
        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $day = carbon::now()->format('d');
        $kodecabang =  strtoupper($request->cb_cabang);

        if ($request->ed_kode == null || $request->ed_kode == '') {
             $kodekode = DB::table('vendor')->max('id_vendor');
              if ($kodekode == '' ) {
                 $kodekode=1;
               }
               else{
                  $kodekode+=1;
               }
               if ($kodekode < 1000) {
                  $kodekode = '000'.$kodekode;
                }
                 $kodekode =  /*$kodecabang.*/'AV-'.$kodecabang.'/'.$kodekode;
        }else{
           $kodekode = $request->ed_kode;
        }
          $idvendorkode = DB::table('vendor')->max('id_vendor');
              if ($idvendorkode == '' ) {
                 $idvendorkode=1;
               }
               else{
                  $idvendorkode+=1;
               }
        $simpan='';
        $crud = $request->crud;
        
        
        if ($crud == 'N') {
            $data = array(
                'kode' => $kodekode,
                'id_vendor'=>$idvendorkode,
                'nama' => strtoupper($request->ed_nama),
                'tipe' => strtoupper($request->cb_tipe),
                'id_kota' => strtoupper($request->cb_kota),
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'kode_pos' => strtoupper($request->ed_kode_pos),
                'status' => strtoupper(TRUE),
                'komisi_vendor' =>strtoupper($request->ed_komisi_vendor),
                'syarat_kredit' => $request->syarat_kredit,
                'cabang_vendor' => strtoupper($request->cb_cabang),
                'acc_penjualan' => strtoupper($request->ed_acc1),
                'acc_hutang' => strtoupper($request->ed_acc2),
                'csf_penjualan' => strtoupper($request->ed_acc3),
                'csf_hutang' => strtoupper($request->ed_acc4),
            );
            $simpan = DB::table('vendor')->insert($data);
        }elseif ($crud == 'E') {
              $data = array(
                'kode' => $request->ed_kode,
                'id_vendor'=>$request->ed_kode_old,
                'nama' => strtoupper($request->ed_nama),
                'tipe' => strtoupper($request->cb_tipe),
                'id_kota' => strtoupper($request->cb_kota),
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'kode_pos' => strtoupper($request->ed_kode_pos),
                'status' => strtoupper($statusbol),
                'cabang_vendor' => strtoupper($request->cb_cabang),
                'komisi_vendor' =>strtoupper($request->ed_komisi_vendor),
                'syarat_kredit' => $request->syarat_kredit,
                'acc_penjualan' => strtoupper($request->ed_acc1),
                'acc_hutang' => strtoupper($request->ed_acc2),
                'csf_penjualan' => strtoupper($request->ed_acc3),
                'csf_hutang' => strtoupper($request->ed_acc4),
            );
            $simpan = DB::table('vendor')->where('kode', $request->ed_kode)->update($data);
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
        $hapus = DB::table('vendor')->where('kode' ,'=', $id)->delete();
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
        return view('master_sales.vendor.index',compact('kota','akun','cabang'));
    }

}
