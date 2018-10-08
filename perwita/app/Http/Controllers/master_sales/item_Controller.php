<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use carbon\Carbon;
use Auth;

class item_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT i.kode, i.nama, i.harga, i.keterangan, gi.nama grup_item, s.nama satuan 
                    FROM item i
                    LEFT JOIN satuan s ON s.kode=i.kode_satuan 
                    LEFT JOIN grup_item gi ON gi.kode=i.kode_grup_item ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button

             $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Item','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Item','hapus')) {
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
        $data = DB::table('item')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {

        $simpan='';
        $crud = $request->crud;

        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $day = carbon::now()->format('d');
         $kodecabang =  auth::user()->kode_cabang;
        if ($request->ed_kode == null || $request->ed_kode == '') {
             $kodekode = DB::table('item')->max('id_item');
              if ($kodekode == '' ) {
                 $kodekode=1;
               }
               else{
                  $kodekode+=1;
               }
               // return $kodekode;
               if ($kodekode < 100) {
                  $kodekode = '0000'.$kodekode;
                }
                 $kodekode =  'ITM/'.$kodecabang.'/'.$day.$month.$year.'/'.$kodekode;
        }else{
           $kodekode = $request->ed_kode;
        }
          $id_kode = DB::table('item')->max('id_item');
              if ($id_kode == '' ) {
                 $id_kode=1;
               }
               else{
                  $id_kode+=1;
               }
        
        if ($crud == 'N') {

            $kode = DB::table('item')
                      ->where('kode_grup_item',strtoupper($request->cb_grup_item))
                      ->max('id_item')+1;


            $data = array(
                // 'id_item' => $id_kode,
                'kode' => $kodekode,
                'id_item' => $kode,
                'nama' => strtoupper($request->ed_nama),
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_grup_item' => strtoupper($request->cb_grup_item),
                'kode_satuan' => strtoupper($request->cb_satuan),
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'pakai_angkutan' => $request->ck_pakai_angkutan,
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
            );
            $simpan = DB::table('item')->insert($data);
        }elseif ($crud == 'E') {
            $data = array(
                // 'id_item' => $request->id_item,
                'kode' => $request->ed_kode,
                'nama' => strtoupper($request->ed_nama),
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_grup_item' => strtoupper($request->cb_grup_item),
                'kode_satuan' => strtoupper($request->cb_satuan),
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'pakai_angkutan' => $request->ck_pakai_angkutan,
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
            );
            $simpan = DB::table('item')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('item')->where('kode' ,'=', $id)->delete();
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
        $grup_item = DB::select(DB::raw(" SELECT kode,nama FROM grup_item ORDER BY nama ASC "));
        $satuan = DB::select(DB::raw(" SELECT kode,nama FROM satuan ORDER BY nama ASC "));
        $akun = DB::table('d_akun')
                   ->where('id_akun','like','4'.'%')
                   ->where('is_active', 1)
                  ->get();
        $akun1 = DB::table('d_akun')
                   ->where('id_akun','like','4'.'%')
                   ->where('is_active', 1)
                  ->get();

        return view('master_sales.item.index',compact('satuan','grup_item','akun','akun1'));
    }
    public function pilih_nota(request $request)
    {
        $kode = DB::table('item')
                  ->where('kode_grup_item','like',$request->cb_grup_item.'%')
                  ->max('id_item');
        $kode = filter_var($kode, FILTER_SANITIZE_NUMBER_INT);
        if ($kode == null) {
          $kode = $request->cb_grup_item.'1';
        }else{
          $kode += 1;
          $kode = $request->cb_grup_item.$kode;
        }

        return response()->json(['kode'=>$kode]);
    }

}
