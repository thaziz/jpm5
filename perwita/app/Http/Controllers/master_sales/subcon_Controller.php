<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
class subcon_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT * FROM subcon  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            // $data[$i]['button'] = ' <div class="btn-group">
            //                             <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
            //                             <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
            //                         </div> ';
            // $i++;

            $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Agen','ubah')) {
                                  $div_2  = ' <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
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
        $data = DB::table('subcon')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request->all());
        $simpan='';
        $crud = $request->crud;

        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $day = carbon::now()->format('d');
         // $kodecabang =  auth::user()->kode_cabang;

        if ($request->ed_kode == null || $request->ed_kode == '') {
             $kodekode = DB::table('subcon')->max('id_subcon');
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
                 $kodekode =  /*$kodecabang.*/'SC/'.'001'.'/'.$kodekode;
        }else{
           $kodekode = $request->ed_kode;
        }
          $idsubconkode = DB::table('subcon')->max('id_subcon');
              if ($idsubconkode == '' ) {
                 $idsubconkode=1;
               }
               else{
                  $idsubconkode+=1;
               }
               // return date('Y-m-d',strtotime($request->ed_tgl_kontrak));
       
        
        if ($crud == 'N') {
             $data = array(
                'id_subcon' =>$idsubconkode,
                'kode' => $kodekode,
                'cabang' => $request->cabang,
                'nama' => strtoupper($request->ed_nama),                
                'nomor_kontrak' => strtoupper($request->ed_nomor_kontrak),
                'tgl_kontrak' => date('Y-m-d',strtotime($request->ed_tgl_kontrak)),
                'penanggung_jawab' => strtoupper($request->ed_penanggung_jawab),
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'fax' => strtoupper($request->ed_fax),
                'kontak_person' => strtoupper($request->ed_kontak_person),
                'email' => strtoupper($request->ed_email),
                'keterangan' => strtoupper($request->ed_keterangan),
                'persen' => (integer)$request->persen,
                'acc_code' => $request->acc_code,
                'csf_code' => $request->csf_code,
            );
            $simpan = DB::table('subcon')->insert($data);
        }elseif ($crud == 'E') {
            $data = array(
                'id_subcon' => $request->id_subcon,
                'kode' => $request->ed_kode,
                'cabang' => $request->cabang,
                'nama' => strtoupper($request->ed_nama),                
                'nomor_kontrak' => strtoupper($request->ed_nomor_kontrak),
                'tgl_kontrak' => date('Y-m-d',strtotime($request->ed_tgl_kontrak)),
                'penanggung_jawab' => strtoupper($request->ed_penanggung_jawab),
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'fax' => strtoupper($request->ed_fax),
                'kontak_person' => strtoupper($request->ed_kontak_person),
                'email' => strtoupper($request->ed_email),
                'keterangan' => strtoupper($request->ed_keterangan),
                'persen' => (integer)$request->persen,
                'acc_code' => $request->acc_code,
                'csf_code' => $request->csf_code,
            );
            $simpan = DB::table('subcon')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('subcon')->where('kode' ,'=', $id)->delete();
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
        $akun = DB::table('d_akun')
                  ->get();
        $cabang = DB::table('cabang')
                  ->get();
        return view('master_sales.subcon.index',compact('kota','akun','cabang'));
    }

}
