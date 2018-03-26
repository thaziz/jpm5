<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;

class customer_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('customer')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('customer')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $day = carbon::now()->format('d');
         // $kodecabang =  auth::user()->kode_cabang;

        if ($request->ed_kode == null || $request->ed_kode == '') {
             $kodekode = DB::table('customer')->max('id_cus');
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
                 $kodekode =  /*$kodecabang.*/'CS-'.'001'.'/'.$kodekode;
        }else{
           $kodekode = $request->ed_kode;
        }
          $idcuskode = DB::table('customer')->max('id_cus');
              if ($idcuskode == '' ) {
                 $idcuskode=1;
               }
               else{
                  $idcuskode+=1;
               }

        $simpan='';
        $crud = $request->crud;
       
        
        if ($crud == 'N') {
             $data = array(
                'id_cus'=>$idcuskode,
                'kode' => $kodekode/*strtoupper($request->ed_kode)*/,
                'nama' => strtoupper($request->ed_nama),
                'alamat' => strtoupper($request->ed_alamat),
                'kota' => strtoupper($request->cb_kota),
                'telpon' => strtoupper($request->ed_telpon),
                'cabang' => $request->cabang,
                //plafon numeric(20,4),
                'pajak_npwp' => strtoupper($request->ed_npwp),
                //pajak_nama character varying(64),
                //pajak_alamat character varying(128),
                //pajak_kota character varying(20),
                'nama_pph23'  => strtoupper($request->cb_nama_pajak_23),
                'kode_bank'  => strtoupper($request->ed_kode_bank),
                'type_faktur_ppn'  => strtoupper($request->cb_type_faktur),
                'acc_piutang' => strtoupper($request->ed_acc_piutang),
                'csf_piutang' => strtoupper($request->ed_csf_piutang),
                'syarat_kredit' => strtoupper($request->ed_syarat_kredit),
                //groups character varying(2),
                'hold_id' => 'HL',
                'comp_id' => 'EM',
                'sub_comp_id'  => 1,
                'pph23' => $request->ck_pph23,
                'ppn' => $request->ck_ppn,
            );
            $simpan = DB::table('customer')->insert($data);
        }elseif ($crud == 'E') {
             $data = array(
                'id_cus'=>$idcuskode,
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'alamat' => strtoupper($request->ed_alamat),
                'kota' => strtoupper($request->cb_kota),
                'telpon' => strtoupper($request->ed_telpon),
                //plafon numeric(20,4),
                'pajak_npwp' => strtoupper($request->ed_npwp),
                //pajak_nama character varying(64),
                //pajak_alamat character varying(128),
                //pajak_kota character varying(20),
                'nama_pph23'  => strtoupper($request->cb_nama_pajak_23),
                'kode_bank'  => strtoupper($request->ed_kode_bank),
                'type_faktur_ppn'  => strtoupper($request->cb_type_faktur),
                'acc_piutang' => strtoupper($request->ed_acc_piutang),
                'csf_piutang' => strtoupper($request->ed_csf_piutang),
                'syarat_kredit' => strtoupper($request->ed_syarat_kredit),
                //groups character varying(2),
                'hold_id' => 'HL',
                'comp_id' => 'EM',
                'sub_comp_id'  => 1,
                'pph23' => $request->ck_pph23,
                'ppn' => $request->ck_ppn,
            );
            $simpan = DB::table('customer')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('customer')->where('kode' ,'=', $id)->delete();
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
        $accpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $csfpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $cabang = DB::table('cabang')
                    ->get();
        return view('master_sales.customer.index', compact('kota','cabang','accpenjualan','csfpenjualan'));
    }

}
