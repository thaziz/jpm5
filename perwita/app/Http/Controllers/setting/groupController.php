<?php

namespace App\Http\Controllers\setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


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


     	return json_encode('Success');
        

    }
}
