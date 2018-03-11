<?php

namespace App\Http\Controllers\d_trans;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\master_akun;
use App\master_kota;
use App\master_provinsi;
use App\masterTrans;
use App\masterTransDt;
use Validator;


class master_transaksiController extends Controller
{
    public function index () {            	
        return view('d_trans.index');
    }
    public function table(){
    	$d_trans=masterTrans::select(DB::raw('distinct on (tr_code) tr_code '),'tr_year','tr_name','provinsi.nama as provinsi','kota.nama as kota')    		 
    			 ->leftjoin('provinsi',function($join){
    			 		$join->on('d_trans.tr_provinsi','=','provinsi.id');    			 		
    			 })
    			 ->leftjoin('kota',function($join){
    			 		$join->on('kota.id','=','d_trans.tr_kota');    			 		
    			 })
    			 ->get();
    			     			 
		return view('d_trans.table',compact('d_trans'));
    			 
    }
    public function form(Request $request){
    	$provinsi=master_provinsi::orderBy('nama')->get();    	
    	$akun=master_akun::where('is_active',true)->orderBy('id_akun')->get();
    	$status=$request->status;
    	if($status==1){
    		return view('d_trans.form',compact('status','provinsi','akun'));
    	}
    	else if($status==2){    		
    		$d_trans=masterTrans::where('tr_year',$request->year)->where('tr_code',$request->code)->first();
    		$kota=master_kota::orderBy('nama')->where('id_provinsi',$d_trans->tr_provinsi)->get();    		
    		$d_trans_dt=masterTransDt::where('trdt_year',$request->year)->where('trdt_code',$request->code)->get();
    		return view('d_trans.form',compact('status','provinsi','akun','d_trans','d_trans_dt','status','kota'));	
    	}

    }
    public function save_data(Request $request){
    return DB::transaction(function() use ($request) {        

    	$year=date('Y');   
    		    			
      	$rules = [
    		'nama_transaksi'  => 'required',    		
    		'akun_debet.*'    => 'required',
    		'akun_kredit.*'	  => 'required'
    	];

    	$messages = [
    		'nama_transaksi.required'   => 'Inputan Nama Transaksi Tidak Boleh Kosong',    		    		
    		'akun_debet.*'	=> 'Inputan Akun Debet Tidak Boleh Kosong',
    		'akun_kredit.*'	=> 'Inputan Akun Kredit Tidak Boleh Kosong',
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);

    	if($validator->fails()){
    		$response = [
    			'status' 	=> 'gagal',
    			'content'	=> $validator->errors()->first()
    		];
    		return json_encode($response);
    	}

    	$tr_code=masterTrans::where('tr_year',$year)->max('tr_code')+1;
    	
    	masterTrans::create([
    		"tr_code" =>$tr_code,
			"tr_year" =>$year,
			"tr_name" =>$request->nama_transaksi,
			"tr_provinsi"=>$request->provinsi,
			"tr_kota" =>$request->kota,			
    	]);

    	for ($indexDebet=0; $indexDebet <count($request->akun_debet); $indexDebet++) {     		    		

    	$trdt_detailid=masterTransDt::where('trdt_code',$tr_code)->where('trdt_year',$year)->max('trdt_detailid')+1;    	
    	$listDebit=[];
    	$listDebit = explode('|', $request->akun_debet[$indexDebet]);    	    	
    	if(count($listDebit)==2){
    	if($listDebit[1]=='D'){
    		$debitDk=1;
    	}
    	else{
    		$debitDk=-1;	
    	}    	
    	}else{
    		$debitDk=3;	
    	}    	
    	masterTransDt::create([
    	"trdt_code" =>$tr_code,
    	"trdt_year" =>$year,	
		"trdt_acc"=>$listDebit[0],
		"trdt_accdk"=> $debitDk,
		"trdt_detailid"=>$trdt_detailid,
		"trdt_accstatusdk"=>'D'
    	]);
    	$listDebit=[];
    	}




    	for ($indexKredit=0; $indexKredit <count($request->akun_kredit); $indexKredit++) {     	

    	$trdt_detailid=masterTransDt::where('trdt_code',$tr_code)->where('trdt_year',$year)->max('trdt_detailid')+1;    	
    	$listKredit=[];
    	$listKredit = explode('|', $request->akun_kredit[$indexKredit]);    	    	
    	if(count($listKredit)==2){
    	if($listKredit[1]=='K'){
    		$kreditDk=1;
    	}
    	else{
    		$kreditDk=-1;	
    	}
    	}else{
    		$kreditDk=5;	
    	}
    	masterTransDt::create([
    	"trdt_code" =>$tr_code,
    	"trdt_year" =>$year,	
		"trdt_acc"=>$listKredit[0],
		"trdt_accdk"=> $kreditDk,
		"trdt_detailid"=>$trdt_detailid,
		"trdt_accstatusdk"=>'K'
    	]);
    	$listKredit=[];
    	}

    	$response = [
    			'status' 	=> 'berhasil',
    			'content'	=> 'Data Berhasil Disimpan'
    		];
    		return json_encode($response);

		});

    }


    public function update_data(Request $request){
return DB::transaction(function() use ($request) {  

    	$rules = [
    		'nama_transaksi'  => 'required',    		
    		'akun_debet.*'    => 'required',
    		'akun_kredit.*'	  => 'required'
    	];

    	$messages = [
    		'nama_transaksi.required'   => 'Inputan Nama Transaksi Tidak Boleh Kosong',    		    		
    		'akun_debet.*'	=> 'Inputan Akun Debet Tidak Boleh Kosong',
    		'akun_kredit.*'	=> 'Inputan Akun Kredit Tidak Boleh Kosong',
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);

    	if($validator->fails()){
    		$response = [
    			'status' 	=> 'gagal',
    			'content'	=> $validator->errors()->first()
    		];
    		return json_encode($response);
    	}

    	$d_trans=masterTrans::where('tr_year',$request->year)->where('tr_code',$request->code);
    	
    	$d_trans->update([
			"tr_name" =>$request->nama_transaksi,
			"tr_provinsi"=>$request->provinsi,
			"tr_kota" =>$request->kota,			
    		]);

		masterTransDt::where('trdt_code',$request->code)->where('trdt_year',$request->year)->delete();

    	for ($indexDebet=0; $indexDebet <count($request->akun_debet); $indexDebet++) {     		    		
    	$trdt_detailid=masterTransDt::where('trdt_code',$request->code)->where('trdt_year',$request->year)->max('trdt_detailid')+1;    	
    	$listDebit=[];
    	$listDebit = explode('|', $request->akun_debet[$indexDebet]);    	    	
    	if(count($listDebit)==2){
    	if($listDebit[1]=='D'){
    		$debitDk=1;
    	}
    	else{
    		$debitDk=-1;	
    	}    	
    	}else{
    		$debitDk=3;	
    	}    	
    	masterTransDt::create([
    	"trdt_code" =>$request->code,
    	"trdt_year" =>$request->year,	
		"trdt_acc"=>$listDebit[0],
		"trdt_accdk"=> $debitDk,
		"trdt_detailid"=>$trdt_detailid,
		"trdt_accstatusdk"=>'D'
    	]);
    	$listDebit=[];
    	}




    	for ($indexKredit=0; $indexKredit <count($request->akun_kredit); $indexKredit++) {     	
    	$trdt_detailid=masterTransDt::where('trdt_code',$request->code)->where('trdt_year',$request->year)->max('trdt_detailid')+1;    	
    	$listKredit=[];
    	$listKredit = explode('|', $request->akun_kredit[$indexKredit]);    	    	
    	if(count($listKredit)==2){
    	if($listKredit[1]=='K'){
    		$kreditDk=1;
    	}
    	else{
    		$kreditDk=-1;	
    	}
    	}else{
    		$kreditDk=5;	
    	}
    	masterTransDt::create([
    	"trdt_code" =>$request->code,
    	"trdt_year" =>$request->year,	
		"trdt_acc"=>$listKredit[0],
		"trdt_accdk"=> $kreditDk,
		"trdt_detailid"=>$trdt_detailid,
		"trdt_accstatusdk"=>'K'
    	]);
    	$listKredit=[];
    	}

    	$response = [
    			'status' 	=> 'berhasil',
    			'content'	=> 'Data Berhasil Diupdate'
    		];
    		return json_encode($response);

		});
    }
    public function hapus_data(Request $request){
return DB::transaction(function() use ($request) {  		
  		masterTrans::where('tr_code',$request->code)->where('tr_year',$request->year)->delete();  		
  		$response = [
    			'status' 	=> 'berhasil',
    			'content'	=> 'Data Berhasil Dihapus'
    		];
    		return json_encode($response);
});

}
    public function setKota($id_provinsi){
    	$kota=master_kota::where('id_provinsi',$id_provinsi)->get();
    	$html='';
    	$html.='<select class="form-control" name="kota">
                 <option value=0 hidden="" selected>-- Pilih Kota --</option>   
                 <option value=0>-</option>';
		foreach ($kota as $key => $data) {
		          $html.='<option value="'.$data->id.'">'.$data->nama.'</option>';
		         }                 
		
        $html.='</select>';
        return json_encode($html);
    }

}
