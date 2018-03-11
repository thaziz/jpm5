<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_comp;

use App\d_mem_comp;

use App\d_comp_year;

use App\d_mem_log;

use Session;

use DB;

use Auth;

use Validator;

class d_compController extends Controller
{
   
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('emptySession');
    }

    public function index(){
        $data = [];
        if(Session::get('mem_comp') != 'null'){
          //$data = d_comp::where('c_owner', '=', Auth::user()->m_id)->get();
          $data = 
           DB::table('d_comp')->select('d_comp.*','d_mem_comp.*')
                   ->join('d_mem_comp','d_mem_comp.mc_comp','=','d_comp.c_id')
                   ->where('c_owner', '=', Auth::user()->m_id)
                   ->get();
         // dd($data);
        }
   			
    	return view('data-master.master-perusahaan.index')->withData($data);
    }

   public function data(Request $request){
   		if($request->ajax()){
        $data = [];
        if(Session::get('mem_comp') != 'null'){
          //$data = d_comp::where('c_owner', '=', Auth::user()->m_id)->get();
          $data = 
           DB::table('d_comp')->select('d_comp.*','d_mem_comp.*')
                   ->join('d_mem_comp','d_mem_comp.mc_comp','=','d_comp.c_id')
                   ->where('c_owner', '=', Auth::user()->m_id)
                   ->get();
         // dd($data);
        }
   			return view('data-master.master-perusahaan.list-perusahaan')->withData($data);
   		}else{
   			return view('errors.401');
   		}
   }

   public function create(){
     return view('data-master.master-perusahaan.create');
   }

   public function store(Request $request){     
    $rules = [
      'c_name' => 'required',
      'c_address' => 'required',
      'c_hp' => 'required',
      'c_email' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);

    if($validator->fails()){
      Session::flash('gagal', 'Terjadi Kesalahan Input. Data Tidak Berhasil Disimpan, Silahkan Coba Lagi');
      return redirect()->back()->withInput();
    }

     $id = 'COM-'.date('His');     
     $d_comp = new d_comp;
     $d_comp->c_id = $id;
     $d_comp->c_owner = Auth::user()->m_id;
     $d_comp->c_name = $request->c_name;
     $d_comp->c_address = $request->c_address;
     $d_comp->c_hp = $request->c_hp;     
     $d_comp->c_email = $request->c_email;     
     $d_comp->c_type = 12;
     $d_comp->c_control = 1;

     if($d_comp->save()){

      $com_mem = new d_mem_comp;
      $com_mem->mc_mem = Auth::user()->m_id;
      $com_mem->mc_comp = $id;
      $com_mem->mc_lvl = 1;
      $com_mem->mc_step = 0;
      $com_mem->mc_active = 0;

      $yearAct = 0;

      if(count(Auth::user()->company) == 0){
        Session::set('mem_comp', $id);
        $com_mem->mc_active = 1;
        $yearAct = 1;
      }

      if($com_mem->save()){
        $year = new d_comp_year;

        $year->y_comp = $id;
        $year->y_year = date('Y');
        $year->y_active = 1;

        if($year->save()){
          return redirect()->route('d_comp_coa.generate_akun', ['master-perusahaan.index', $id]);
        }
      }

    }
     
   }
   public function edit($id){
       $d_comp=d_comp::find($id);       
       return view('data-master.master-perusahaan.edit',compact('d_comp'));
   }
   public function update($id, Request $request){      
    $rules = [
      'c_name' => 'required',
      'c_address' => 'required',
      'c_hp' => 'required',
      'c_email' => 'required|email',
    ];
    $validator = Validator::make($request->all(), $rules);
    if($validator->fails()){
      return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
    }else{
     $d_comp=d_comp::find($id);            
     $d_comp->c_id = $id;     
     $d_comp->c_name = $request->c_name;
     $d_comp->c_address = $request->c_address;
     $d_comp->c_hp = $request->c_hp;     
     $d_comp->c_email = $request->c_email; 
     $d_comp->save(); 
      return response()->json([
                        'success' => true,        
        ]);
    }
     //return redirect('data-master/master-perusahaan');
   }
   
    public function ping(){
        $d_mem_log = d_mem_log::where('l_mem', '=', 'MEM-132701')->where('l_active', '=','Y')->max('l_id');        
        dd($d_mem_log);
    }


}
