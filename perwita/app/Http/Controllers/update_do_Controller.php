<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Carbon\Carbon;
use App\foto;
class fotoController extends Controller
{
	public function index(){
		$foto = DB::table('foto')->get();
		return view('foto.index',compact('foto'));
	} 
/*	public function create(){
		$foto = DB::table('foto')->get();
		return view('foto.create',compact('foto','a'));
	} 
	public function store(Request $request){
	 	dd($request);
		$store = new foto;
		$file = $request->file('gege');
	 	dd($file);
        $fileName   = $file->getClientOriginalName();
        $request->file('foto')->move("img/", $fileName);

		$store->foto=$fileName;
		$store->save();
		return redirect('foto.index');
	}*/
}
