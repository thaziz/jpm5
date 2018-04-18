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
   

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('pengguna')->where('nama', $id)->first();
        echo json_encode($data);
    }

   

    public function save_data (Request $request) {
        // dd($request->all());
        
        

        $count = 1;
        
        $valid = DB::table('hak_akses')
                  ->where('level',$request->ed_level)
                  ->get();

        if ($valid != null) {
            return redirect(url('setting/hak_akses'));
        }

        $level = DB::table('hak_akses')
                   ->where('level',strtoupper($request->ed_level))
                   ->delete();

        $loop = DB::table('master_menu')
                  ->orderBy('mm_id','ASC')
                  ->get();
             
        for ($i=0; $i < count($loop); $i++) { 

            $save = DB::table('hak_akses')
                      ->insert([
                        'id' =>$i+1,
                        'sub' =>$loop[$i]->mm_id,
                        'level' =>strtoupper($request->ed_level),
                        'menu' =>$loop[$i]->mm_nama,
                        'aktif' =>true,
                        'tambah' =>true,
                        'ubah' =>true,
                        'hapus' =>true,
                        'export_ke_excel' =>true,
                        'cabang' =>false,
                        'print' =>true,
                        'aksi' =>false,
                        'all' =>false,
                        'create_by' =>Auth::user()->m_username,
                        'update_by' =>Auth::user()->m_username,
                        'create_at' =>carbon::now(),
                        'update_at' =>carbon::now(),
                ]);


        }

          $save = DB::table('hak_akses')
                      ->join('master_menu','menu','=','mm_nama')
                      ->where('level',strtoupper($request->ed_level))
                         // ->where('level','!=','ADMINISTRATOR')
                      ->whereIn('mm_group',[1,18,19,20,2])
                      ->update([
                        'aktif' =>false,
                        'tambah' =>false,
                        'ubah' =>false,
                        'hapus' =>false,
                        'export_ke_excel' =>false,
                        'cabang' =>false,
                        'print' =>false,
                        'aksi' =>false,
                        'all' =>false,
                ]);

        return redirect(url('setting/hak_akses'));  
    }

    public function edit($id)
    {
        if (Auth::user()->punyaAkses('Hak Akses','ubah')) {
            $level = DB::table('hak_akses')->where('level', $id)->first();

            

            return view('setting.hak_akses.edit',compact('level'));

        }
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
    
    public function edit_data (Request $request) {
       $update = DB::table('hak_akses')
                   ->where('level',$request->ed_level_old)
                   ->update([
                    'level' => strtoupper($request->ed_level)
                   ]);


        return redirect(url('setting/hak_akses'));
    }
    public function index(){
        // dd($request->all());
        // $update = DB::table('hak_akses')
        //            ->where('level','')
        //            ->delete();
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
                     ->join('grup_menu','gm_id','=','mm_group')
                     ->where('level',$request->cblevel)
                     ->orderBy('mm_id','ASC')
                     ->get();

     

        // return $data;
       return view('setting.hak_akses.table_data',compact('data'));
    }

    public function simpan_perubahan(request $request)
    {
        // dd($request->all());
        // $update = DB::table('hak_akses')
        //            ->where('level',$request->cblevel)
        //            ->delete();

        for ($i=0; $i < count($request->nama); $i++) { 
            if ($request->aktif[$i] == 'on') {
                $aktif[$i] = true;
            }else if ($request->aktif[$i]  == 'off'){
                $aktif[$i] = false;
            }

            if ($request->tambah[$i] == 'on') {
                $tambah[$i] = true;
            }else if ($request->tambah[$i]  == 'off'){
                $tambah[$i] = false;
            }

            if ($request->ubah[$i] == 'on') {
                $ubah[$i] = true;
            }else if ($request->ubah[$i]  == 'off'){
                $ubah[$i] = false;
            }

            if ($request->hapus[$i] == 'on') {
                $hapus[$i] = true;
            }else if ($request->hapus[$i]  == 'off'){
                $hapus[$i] = false;
            }

            if ($request->cabang[$i] == 'on') {
                $cabang[$i] = true;
            }else if ($request->cabang[$i]  == 'off'){
                $cabang[$i] = false;
            }

            if ($request->print[$i] == 'on') {
                $print[$i] = true;
            }else if ($request->print[$i]  == 'off'){
                $print[$i] = false;
            }

            if ($request->global[$i] == 'on') {
                $all[$i] = true;
            }else if ($request->global[$i]  == 'off'){
                $all[$i] = false;
            }
        }

        // return $aktif;


        // $loop = DB::table('master_menu')
        //           ->orderBy('mm_id','ASC')
        //           ->get();
             
        // for ($i=0; $i < count($loop); $i++) { 

        //     $save = DB::table('hak_akses')
        //               ->insert([
        //                 'id' =>$i+1,
        //                 'sub' =>$loop[$i]->mm_id,
        //                 'level' =>strtoupper($request->cblevel),
        //                 'menu' =>$loop[$i]->mm_nama,
        //                 'aktif' =>true,
        //                 'tambah' =>true,
        //                 'ubah' =>true,
        //                 'hapus' =>true,
        //                 'export_ke_excel' =>true,
        //                 'cabang' =>false,
        //                 'print' =>true,
        //                 'aksi' =>false,
        //                 'all' =>false,
        //                 'create_by' =>Auth::user()->m_username,
        //                 'update_by' =>Auth::user()->m_username,
        //                 'create_at' =>carbon::now(),
        //                 'update_at' =>carbon::now(),
        //         ]);


        // }

        //   $save = DB::table('hak_akses')
        //               ->join('master_menu','menu','=','mm_nama')
        //               ->where('level',strtoupper($request->cblevel))
        //                  // ->where('level','!=','ADMINISTRATOR')
        //               ->whereIn('mm_group',[1,18,19,20,2])
        //               ->update([
        //                 'aktif' =>false,
        //                 'tambah' =>false,
        //                 'ubah' =>false,
        //                 'hapus' =>false,
        //                 'export_ke_excel' =>false,
        //                 'cabang' =>false,
        //                 'print' =>false,
        //                 'aksi' =>false,
        //                 'all' =>false,
        //         ]);

         for ($i=0; $i < count($request->nama); $i++) { 
             $update = DB::table('hak_akses')
                         ->where('menu',$request->nama[$i])
                         ->where('level','=',$request->cblevel)
                         ->update([
                            'aktif' =>$aktif[$i],
                            'tambah' =>$tambah[$i],
                            'ubah' =>$ubah[$i],
                            'hapus' =>$hapus[$i],
                            'export_ke_excel' =>true,
                            'cabang' =>$cabang[$i],
                            'print' =>$print[$i],
                            'all' =>$all[$i],
                            'update_by' =>Auth::user()->m_username,
                            'update_at' =>carbon::now(),
                        ]);
         }

         // $save = DB::table('hak_akses')
         //              ->join('master_menu','menu','=','mm_nama')
         //              // ->where('level',strtoupper($request->ed_level))
         //                 // ->where('level','!=','ADMINISTRATOR')
         //              ->whereIn('mm_group',[1,18,19,20,2])
         //              ->update([
         //                'aktif' =>false,
         //                'tambah' =>false,
         //                'ubah' =>false,
         //                'hapus' =>false,
         //                'export_ke_excel' =>false,
         //                'cabang' =>false,
         //                'print' =>false,
         //                'aksi' =>false,
         //                'all' =>false,
         //        ]);

         return 'success';


    }

}
