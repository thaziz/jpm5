<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use App\v_hutang;
use App\vd_hutang;
use Illuminate\Http\Request;
use redirect;
use Response;
use DB;
use App\Http\Controllers\v_hutangController;
use Validator;
use App\Http\Controllers\Controller;

class zona_Controller extends Controller
{
    public function index(){
        // return 'a';
        $data = DB::table('zona')->get();
        $id = DB::table('zona')->select('id_zona')->max('id_zona');    
        if ($id == '') {
            $id = 1;
        }else{
            $id += 1;
        }
        $nama= 'ZONA-'.$id;

            
       return view('zona.index',compact('data','nama'));
    }	
    public function getdata(Request $request){
        // return 'a';
        $data = DB::table('zona')->where('id_zona','=',$request->id)->get();

       // return view('zona.index',compact('data'));
        echo json_encode($data);
    }
    public function simpan(Request $request){

    	$id = DB::table('zona')->select('id_zona')->max('id_zona');    
        if ($id == '') {
            $id = 1;
        }else{
            $id += 1;
        }
        if ($request->crud == 'N') {
        	$data = array(
	                    'id_zona' =>$id,
	                    'nama' =>$request->ed_nama,
	                    'keterangan' => $request->ed_keterangan,
	                    'jarak_awal' => $request->ed_jarakawal,
	                    'jarak_akir' => $request->ed_jarakakir,
	                    'harga_zona' => $request->ed_harga,
	                );
            $simpan = DB::table('zona')->insert($data);
        }else{
        	$data = array(
	                    'id_zona' =>$request->ed_kode_old,
	                    'nama' =>$request->ed_nama,
	                    'keterangan' => $request->ed_keterangan,
	                    'jarak_awal' => $request->ed_jarakawal,
	                    'jarak_akir' => $request->ed_jarakakir,
	                    'harga_zona' => $request->ed_harga,
	                );
            $simpan = DB::table('zona')->where('id_zona','=',$request->ed_kode_old)->update($data);
        }
	    	
    }
    public function hapus(Request $request){
    	$id = $request->id;
        $hapus = DB::table('zona')->where('id_zona' ,'=', $id)->delete();
    }
        
}
