<?php

namespace App\Http\Controllers\setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use carbon\carbon;
use Auth;

class hak_akses_Controller extends Controller
{
    public function table_data (Request $request) {
        $level = $request->level;
        //$sql = " SELECT * FROM hak_akses WHERE level = '$level' ORDER BY id,sub,kode";
        $sql = "    SELECT *,menu FROM hak_akses WHERE sub = 0 AND level = '$level'
                    UNION ALL
                    SELECT *,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'||menu as menu FROM hak_akses WHERE sub > 1 AND level = '$level'
                    ORDER BY id,sub,kode " ;

        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            // Aktif
            if ($data[$i]['aktif']==TRUE) {
                    $Aktif = 'checked';
            } else {
                    $Aktif = '';
            }
            $data[$i]['aktif'] = '<input type="checkbox" '.$Aktif.' id="'.$data[$i]['kode'].'" class="btnaktif" >';

            //Tambah
            if ($data[$i]['tambah']==TRUE) {
                    $Tambah = 'checked';
            } else {
                    $Tambah = '';
            }
            $data[$i]['tambah'] = '<input type="checkbox" '.$Tambah.' id="'.$data[$i]['kode'].'" class="btntambah" >';

            //Ubah
            if ($data[$i]['ubah']==TRUE) {
                    $Ubah = 'checked';
            } else {
                    $Ubah = '';
            }
            $data[$i]['ubah'] = '<input type="checkbox" '.$Ubah.' id="'.$data[$i]['kode'].'" class="btnubah" >';

            //Hapus
            if ($data[$i]['hapus']==TRUE) {
                    $Hapus = 'checked';
            } else {
                    $Hapus = '';
            }
            $data[$i]['hapus'] = '<input type="checkbox" '.$Hapus.' id="'.$data[$i]['kode'].'" class="btnhapus" >';

            //Function1
            if ($data[$i]['function1']==TRUE) {
                    $Function1 = 'checked';
            } else {
                    $Function1 = '';
            }
            $data[$i]['function1'] = '<input type="checkbox" '.$Function1.' id="'.$data[$i]['kode'].'" class="btnfunction1" >';

            //Function2
            if ($data[$i]['function2']==TRUE) {
                    $Function2 = 'checked';
            } else {
                    $Function2 = '';
            }
            $data[$i]['function2'] = '<input type="checkbox" '.$Function2.' id="'.$data[$i]['kode'].'" class="btnfunction2" >';
            //$data[$i]['Function2'] = '<input type="checkbox" checked="" />';

            //Function3
            if ($data[$i]['function3']==TRUE) {
                    $Function3 = 'checked';
            } else {
                    $Function3 = '';
            }
            $data[$i]['function3'] = '<input type="checkbox" '.$Function3.' id="'.$data[$i]['kode'].' " class="btnfunction3" >';

            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('pengguna')->where('nama', $id)->first();
        echo json_encode($data);
    }

   

    public function save_data (Request $request) {
        $loop = DB::table('master_menu')
                  ->orderBy('mm_id','ASC')
                  ->get();

        $count = 1;
        
        $valid = DB::table('hak_akses')
                  ->where('level',$request->ed_level)
                  ->get();

        if ($valid != null) {
            return redirect(url('setting/hak_akses'));
        }

        for ($i=0; $i < count($loop); $i++) { 



            $id = DB::table('hak_akses')
                    ->max('id');
            if ($id == null) {
                $id = 1;
            }else{
                $id+=1;
            }

            $save = DB::table('hak_akses')
                      ->insert([
                        'id' =>$id,
                        'sub' =>$loop[$i]->mm_id,
                        'level' =>$request->ed_level,
                        'menu' =>$loop[$i]->mm_nama,
                        'aktif' =>false,
                        'tambah' =>false,
                        'ubah' =>false,
                        'hapus' =>false,
                        'export_ke_excel' =>false,
                        'cabang' =>false,
                        'print' =>false,
                        'aksi' =>false,
                        'all' =>false,
                        'create_by' =>Auth::user()->m_username,
                        'update_by' =>Auth::user()->m_username,
                        'create_at' =>carbon::now(),
                        'update_at' =>carbon::now(),
                ]);
        }

        return redirect(url('setting/hak_akses'));  
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $level=$request->level;
        $hapus = DB::table('hak_akses')->where('level' ,'=', $level)->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }
    
    public function edit_hak_akses (Request $request) {
        $id = $request->id;
        $nilai = $request->nilai;
        $keterangan = $request->keterangan;
        if ($keterangan == 'aktif') {
            $data = DB::select(" UPDATE hak_akses SET aktif='$nilai' where kode='$id' ");
            return $data;
        } else if ($keterangan == 'tambah') {
            $data = DB::select(" UPDATE hak_akses SET tambah='$nilai' where kode='$id' ");
            return $data;
        } else if ($keterangan == 'ubah') {
            $data = DB::select(" UPDATE hak_akses SET ubah='$nilai' where kode='$id' ");
            return $data;
        } else if ($keterangan == 'hapus') {
            $data = DB::select(" UPDATE hak_akses SET hapus='$nilai' where kode='$id' ");
            return $data;
        } else if ($keterangan == 'function1') {
            $data = DB::select(" UPDATE hak_akses SET function1='$nilai' where kode='$id' ");
            return $data;
        } else if ($keterangan == 'function2') {
            $data = DB::select(" UPDATE hak_akses SET function2='$nilai' where kode='$id' ");
            return $data;
        } else if ($keterangan == 'function3') {
            $data = DB::select(" UPDATE hak_akses SET function3='$nilai' where kode='$id' ");
            return $data;
        }
    }
    public function index(){
        $level = DB::select(" SELECT DISTINCT level FROM hak_akses ORDER BY level ASC");
        return view('setting.hak_akses.index',compact('level'));
    }

    public function form($level=null){
        if ($level != null) {
            $level = DB::table('hak_akses')->where('level', $level)->first();
        }else{
            $level = null;
        }
        return view('setting.hak_akses.form',compact('level'));
    }

    public function cari_data(request $request)
    {
       
           $data = DB::table('master_menu')
                     ->join('hak_akses','menu','=','mm_nama')
                     ->where('level',$request->cblevel)
                     ->get();

     

        // return $data;
       return view('setting.hak_akses.table_data',compact('data','filter'));
    }

}
