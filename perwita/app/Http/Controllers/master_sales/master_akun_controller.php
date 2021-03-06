<?php

namespace App\Http\Controllers\master_sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;
ini_set('max_execution_time', 320);
class master_akun_controller extends Controller
{
    public function index()
    {
      $cabang = Auth::user()->kode_cabang;
      $akun_patty = DB::table('master_akun_fitur')
                    ->where('maf_group','1')
                    ->where('maf_cabang',$cabang)
                    ->get();
     

      $akun_item = DB::table('master_akun_fitur')
                    ->where('maf_group','2')
                    ->where('maf_cabang',$cabang)
                    ->get();
      
      $cabang = DB::table('cabang')
                  ->orderBy('kode','ASC')
                  ->get();

      $item = DB::table('masteritem')
              ->get();

      $akun = DB::table('d_akun')
                ->get();
      // $akun  = array_merge($akun1,$akun2);
    	return view('master_sales.master_akun.index',compact('akun','akun_item','akun_patty','cabang','item'));
    }
    public function datatable_akun(request $req)
    {
    	$data = DB::table('master_akun_fitur')
                  ->where('maf_group','1')
    			        ->where('maf_cabang',$req->cabang)
                  ->orderBy('maf_id','ASC')
                  ->get();
        
        	
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="hapus1(this)" class="btn btn-danger btn-sm  " title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->make(true);
    }

    public function datatable_item(request $req)
    {
    	$data = DB::table('master_akun_fitur')
    			        ->where('maf_group','2')
                  ->where('maf_cabang',$req->cabang)
                  ->orderBy('maf_id','ASC')
                  ->get();
        
        	
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="hapus2(this)" class="btn btn-danger btn-sm" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->make(true);
    }
    public function save_akun_patty(request $req)
    {
      return DB::transaction(function() use ($req) {  

        if ($req->cabang == 'GLOBAL') {
          
          $akun = substr($req->patty,0,4);

          $data = DB::table('d_akun')
                  ->where('id_akun','like', $akun . '%')
                  ->get();

          for ($i=0; $i < count($data); $i++) { 
            $cari = DB::table('master_akun_fitur')
                      ->where('maf_kode_akun',$data[$i]->id_akun)
                      ->where('maf_cabang',$req->cabang)
                      ->get();
                      
            if ($cari == null) {

              $id = DB::table('master_akun_fitur')
                  ->max('maf_id');

              if ($id == null) {
                $id = 1;
              }else{
                $id+=1;
              }

              $save_maf = DB::table('master_akun_fitur')
                            ->insert([
                              'maf_id'        => $id,
                              'maf_kode_akun' => $data[$i]->id_akun,
                              'maf_nama'      => $data[$i]->nama_akun,
                              'maf_group'     => 1,
                              'maf_cabang'    => $data[$i]->kode_cabang,
                           ]);
            }
          }

        }else{
          $cari = DB::table('master_akun_fitur')
                  ->where('maf_kode_akun',$req->patty)
                  ->where('maf_cabang',$req->cabang)
                  ->first();

          if ($cari != null) {
            return response()->json(['status' => 2]);
          }

          $akun = DB::table('d_akun')
                    ->where('id_akun',$req->patty)
                    ->first();  

          $id = DB::table('master_akun_fitur')
                  ->max('maf_id');
          if ($id == null) {
            $id = 1;
          }else{
            $id+=1;
          }

          $save_maf = DB::table('master_akun_fitur')
                        ->insert([
                          'maf_id'        => $id,
                          'maf_kode_akun' => $akun->id_akun,
                          'maf_nama'      => $akun->nama_akun,
                          'maf_group'     => 1,
                          'maf_cabang'    => $req->cabang,
                       ]);
        } 
      });
    }

    public function save_akun_item(request $req)
    {
      return DB::transaction(function() use ($req) {  
        if ($req->cabang == 'GLOBAL') {
          $akun = substr($req->patty,0,4);

          $data = DB::table('d_akun')
                  ->where('id_akun','like', $akun . '%')
                  ->where('kode_cabang' , '=' , $req->cabang)
                  ->get();


          for ($i=0; $i < count($data); $i++) { 
            $cari = DB::table('master_akun_fitur')
                      ->where('maf_kode_akun',$data[$i]->id_akun)
                      ->get();

            if ($cari != null) {

              $id = DB::table('master_akun_fitur')
                  ->max('maf_id');

              if ($id == null) {
                $id = 1;
              }else{
                $id+=1;
              }
              $save_maf = DB::table('master_akun_fitur')
                            ->insert([
                              'maf_id'        => $id,
                              'maf_kode_akun' => $data[$i]->id_akun,
                              'maf_nama'      => $data[$i]->nama_akun,
                              'maf_group'     => 2,
                              'maf_cabang'    => $data[$i]->kode_cabang,
                           ]);
            }
          }

        }else{
          $cari = DB::table('master_akun_fitur')
                  ->where('maf_kode_akun',$req->patty)
                  ->first();

          if ($cari != null) {
            return response()->json(['status' => 2]);
          }



          $dataakun = $akun = DB::table('masteritem')
                     ->where('kode_item','=', $req->patty)                 
                    ->first();  
        //  dd($dataakun);

          $akunpersediaan2 = $dataakun->acc_persediaan;
          $akunhpp2 = $dataakun->acc_hpp;

          if($akunpersediaan2 != null) {
            $accpersediaan = substr($akunpersediaan2, 0,4);
            $akunpersediaan = DB::table('d_akun')
                         ->where('id_akun','like', $accpersediaan . '%')
                        ->where('kode_cabang' , '=' , $req->cabang)
                        ->first(); 
          }
          else if($akunhpp2 != null){
            $acchpp = substr($akunhpp2, 0,4);
             $akunhpp = DB::table('d_akun')
                         ->where('id_akun','like', $acchpp . '%')
                        ->where('kode_cabang' , '=' , $req->cabang)
                        ->first(); 
          }
         

         

          if($akunpersediaan2 != null) {           
            if(count($akunpersediaan) == 0) {
               return json_encode('akun persediaan kosong');
            }
            else {
               $id = DB::table('master_akun_fitur')
                  ->max('maf_id');
                if ($id == null) {
                  $id = 1;
                }else{
                  $id+=1;
                }

               $save_maf = DB::table('master_akun_fitur')
                      ->insert([
                        'maf_id'        => $id,
                        'maf_kode_akun' => $req->patty,
                        'maf_nama'      => $dataakun->nama_masteritem,
                        'maf_group'     => 2,
                        'maf_cabang'    => $req->cabang,
                        'maf_acc_persediaan'    => $akunpersediaan->id_akun,
                     ]);
              return json_encode('sukses');
            }
           
          }
          else if($akunhpp2 != null) {
            if(count($akunhpp) == 0){             
              return json_encode('akun hpp kosong');
            }
            else {
                 $id = DB::table('master_akun_fitur')
                  ->max('maf_id');
                if ($id == null) {
                  $id = 1;
                }else{
                  $id+=1;
                }

                $save_maf = DB::table('master_akun_fitur')
                      ->insert([
                        'maf_id'        => $id,
                        'maf_kode_akun' => $req->patty,
                        'maf_nama'      => $dataakun->nama_masteritem,
                        'maf_group'     => 2,
                        'maf_cabang'    => $req->cabang,
                        'maf_acc_hpp'    => $akunhpp->id_akun,
                     ]);
              return json_encode('sukses');
            }         
          }
          else {
            return json_encode('tidak ada akun');
          }
        } 
      });


    }

    public function ganti_akun_patty(request $req)
    { 
      if ($req->cabang =='GLOBAL' or $req->cabang == '018' or $req->cabang == '000') {
        $akun_patty = DB::table('master_akun_fitur')
                    ->where('maf_group','1')
                    ->where('maf_cabang',$req->cabang)
                    ->get();
     
        $akun = DB::table('d_akun')
                  ->orderBy('id_akun','ASC')
                  ->get();
       
      }else{
        $akun_patty = DB::table('master_akun_fitur')
                    ->where('maf_group','1')
                    ->where('maf_cabang',$req->cabang)
                    ->get();

        $akun = DB::table('d_akun')
                  ->where('kode_cabang',$req->cabang)
                  ->orderBy('id_akun','ASC')
                  ->get();
      }

      return view('master_sales.master_akun.dropdown_patty',compact('akun','akun_patty'));
      
    }

    public function ganti_akun_item(request $req)
    {

      if ($req->cabang =='GLOBAL') {
        $akun_patty = DB::table('master_akun_fitur')
                    ->where('maf_group','1')
                    ->where('maf_cabang',$req->cabang)
                    ->get();
     
        $akun = DB::table('masteritem')
                  ->get();
      }else{
        $akun_patty = DB::table('master_akun_fitur')
                    ->where('maf_group','1')
                    ->where('maf_cabang',$req->cabang)
                    ->get();
     
        $akun = DB::table('masteritem')
                  ->get();
      }

      return view('master_sales.master_akun.dropdown_item',compact('akun','akun_item'));
    }

    public function hapus_akun_patty(request $request)
    {
      // dd($request->all());
      $del = DB::table('master_akun_fitur')
               ->where('maf_cabang',$request->cabang)
               ->where('maf_group','1')
               ->where('maf_kode_akun',$request->akun)
               ->delete();
    }

    public function hapus_akun_item(request $request)
    {
      // dd($request->all());
      $del = DB::table('master_akun_fitur')
               ->where('maf_cabang',$request->cabang)
               ->where('maf_group','2')
               ->where('maf_kode_akun',$request->akun)
               ->delete();
    }

    public function insert_all()
    {

      $del = DB::table('master_akun_fitur')
               ->delete();
               
      $cabang = DB::table('cabang')
                  ->get();

      for ($i=0; $i < count($cabang); $i++) { 


        $akun0 = DB::table('d_akun')->where('id_akun','like','1002%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun1 = DB::table('d_akun')->where('id_akun','like','5%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun2 = DB::table('d_akun')->where('id_akun','like','6%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun3 = DB::table('d_akun')->where('id_akun','like','7%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun4 = DB::table('d_akun')->where('id_akun','like','8%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun5 = DB::table('d_akun')->where('id_akun','like','9%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun  = array_merge($akun0,$akun1,$akun2,$akun3,$akun4,$akun5);

        for ($a=0; $a < count($akun); $a++) { 
          $id = DB::table('master_akun_fitur')
                  ->max('maf_id')+1;

          $save_maf = DB::table('master_akun_fitur')
                          ->insert([
                            'maf_id'        => $id,
                            'maf_kode_akun' => $akun[$a]->id_akun,
                            'maf_nama'      => $akun[$a]->nama_akun,
                            'maf_group'     => 1,
                            'maf_cabang'    => $cabang[$i]->kode,
                         ]);
        }
      }



      for ($i=0; $i < count($cabang); $i++) { 


        $akun0 = DB::table('d_akun')->where('id_akun','like','1002%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun1 = DB::table('d_akun')->where('id_akun','like','1%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun2 = DB::table('d_akun')->where('id_akun','like','6%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun3 = DB::table('d_akun')->where('id_akun','like','7%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun4 = DB::table('d_akun')->where('id_akun','like','8%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun5 = DB::table('d_akun')->where('id_akun','like','9%')->where('kode_cabang',$cabang[$i]->kode)->get();
        $akun  = array_merge($akun0,$akun1,$akun2,$akun3,$akun4,$akun5);

        for ($a=0; $a < count($akun); $a++) { 
          $id = DB::table('master_akun_fitur')
                  ->max('maf_id')+1;

          $save_maf = DB::table('master_akun_fitur')
                          ->insert([
                            'maf_id'        => $id,
                            'maf_kode_akun' => $akun[$a]->id_akun,
                            'maf_nama'      => $akun[$a]->nama_akun,
                            'maf_group'     => 2,
                            'maf_cabang'    => $cabang[$i]->kode,
                         ]);
        }
      }

    } 
}
