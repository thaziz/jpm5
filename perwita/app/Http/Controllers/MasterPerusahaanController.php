<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Response;

use Storage;

class MasterPerusahaanController extends Controller
{

    public function index(){
        $data = DB::table('master_perusahaan')->get();
        return view('master_sales.masterperusahaan.index',compact('data'));
    }
    public function simpan(Request $request){
    	// dd($request);
    	$image = $request->file('ed_img');
    	$upload = 'upload/images';
    	$filename = '.jpg';
    	Storage::put('upload/images'.$filename,file_get_contents( $request->file('ed_img')->getRealPath()));

    	$maxid = DB::table('master_perusahaan')->max('mp_id');
    	if ($maxid == 0) {
    		$maxid = 1;
    	}
    	$cek = DB::table('master_perusahaan')->get();
    	$total = count($cek);
    	if ($total == 0) {
    		$image = DB::table('master_perusahaan')->insert([
	    		'mp_id'=>$maxid,
	    		'mp_nama' => $request->ed_nama,
	    		'mp_alamat' => $request->ed_alamat,
	    		'mp_tlp'=>$request->ed_tlp,
                'mp_img'=>$filename,
                'mp_signature1'=>$request->mp_signature1,
	    		'mp_signature2'=>$request->mp_signature2,
    		]);
    	}else{
    		$image = DB::table('master_perusahaan')->where('mp_id','=','1')->update([
	    		'mp_id'=>$maxid,
	    		'mp_nama' => $request->ed_nama,
	    		'mp_alamat' => $request->ed_alamat,
	    		'mp_tlp'=>$request->ed_tlp,
                'mp_img'=>$filename,
                'mp_signature1'=>$request->mp_signature1,
	    		'mp_signature2'=>$request->mp_signature2,
    		]);
    	}
        return redirect('master/master_perusahaan');
    	
    }

}
