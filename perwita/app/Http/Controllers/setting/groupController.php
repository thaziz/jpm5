<?php

namespace App\Http\Controllers\setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use carbon\carbon;

class groupController extends Controller
{
    

    public function daftarmenu(){
    	$data = DB::table('grup_menu')
    			  ->orderBy('gm_id','ASC')
    			  ->get();
    	$data_dt = DB::table('master_menu')
    			  ->join('grup_menu','gm_id','=','mm_group')
    			  ->orderBy('mm_id','ASC')
    			  ->get();
        return view('setting.daftarmenu.index',compact('data','data_dt'));
    }

     public function savedaftarmenu(request $request){
        return DB::transaction(function() use ($request) {  

         	if ($request->nama_menu == '') {
         		return response()->json(['status'=>3]);
         	}

         	$id = DB::table('master_menu')
         			->max('mm_id');

         	$valid = DB::table('master_menu')
         			->where('mm_nama',$request->nama_menu)
         			->where('mm_group',$request->grup_item)
         			->first();
         	if ($valid != null) {
         		return response()->json(['status'=>2]);
         	}

         	if ($id == null) {
         		$id = 1;
         	}else{
         		$id+=1;
         	}

         	$save = DB::table('master_menu')
         			  ->insert([
         			  	'mm_id'=>$id,
         			  	'mm_nama'=>$request->nama_menu,
         			  	'mm_group'=>$request->grup_item,
         			  ]);

            $level =DB::table('hak_akses')
                      ->select('level')
                      ->groupBy('level')
                      ->get();

            // dd($level);
            $id1=DB::table('hak_akses')
                      ->max('id');
            if ($id1 == null) {
                $id1 = 1;
            }else{
                $id1 +=1;
            }

            for ($i=0; $i < count($level); $i++) { 
                if ($level[$i]->level == 'ADMINISTRATOR') {
                    $insert = DB::table('hak_akses')
                            ->insert([
                                'id' =>$id1,
                                'sub' =>$id,
                                'level' =>strtoupper($level[$i]->level),
                                'menu' =>$request->nama_menu,
                                'aktif' =>true,
                                'tambah' =>true,
                                'ubah' =>true,
                                'hapus' =>true,
                                'export_ke_excel' =>true,
                                'cabang' =>true,
                                'print' =>true,
                                'aksi' =>true,
                                'all' =>true,
                                'create_by' =>Auth::user()->m_username,
                                'update_by' =>Auth::user()->m_username,
                                'create_at' =>carbon::now(),
                                'update_at' =>carbon::now(),
                            ]);
                }else{
                    $insert = DB::table('hak_akses')
                            ->insert([
                                'id' =>$id1,
                                'sub' =>$id,
                                'level' =>strtoupper($level[$i]->level),
                                'menu' =>$request->nama_menu,
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

                 // $level =DB::table('hak_akses')
                 //      ->select('level','menu')
                 //      ->get();
                // dd($level);
                
            }



         	return json_encode('Success');
        });
        

    }
}
