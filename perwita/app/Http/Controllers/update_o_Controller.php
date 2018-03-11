<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\updateso;
use App\update1;
use App\updatesodo;
use Illuminate\Http\Request;
use App\Http\Requests;
use redirect;
use Response;
use DB;
use Validator;
use App\Http\Controllers\Controller;

class update_o_Controller extends Controller
{
	public function index(){
		return view('updatestatus.index');
	}
	public function up1(){
    $data = DB::table('surat_jalan_trayek')->limit(1000)->get();
		return view('updatestatus/up1',compact('data'));
	}
  public function data1(Request $request , $nomor_do){
      /*dd($nomor_do);*/
         $data1 = DB::table('surat_jalan_trayek_d')
        ->select('nomor_do')
        ->where('nomor_surat_jalan_trayek','=',$nomor_do)
        ->get();
          return response()->json([
                            'status' => 'berhasil',
                            'data' => $data1,
               ]);
  }
	public function data2(Request $request,$nomor){
      /*dd($nomor_do);*/
         $data2 = DB::table('delivery_order')
        ->select('nomor')
        ->where('nomor','=',$nomor)
        ->get();
          return response()->json([
                            'status' => 'berhasil',
                            'data' => $data2,
               ]);
  }

	public function up2(){
    $nodo = DB::table('delivery_order')->orderBy('tanggal','DESC')->limit(5000)->get();
		return view('updatestatus/up2',compact('nodo'));
	}
  public function autocomplete(Request $request){
  
        $term = $request->term;
        
        $results = array();
        $queries = DB::table('delivery_order')
            ->where('delivery_order.nomor', 'like', '%'.$term.'%')
            ->take(10)->get();

        if ($queries == null){
            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($queries as $query)
            {
                $results[] = [ 'id' => $query->nomor, 'label' => $query->nomor];
            }
        }

        return Response::json($results);
    }
	public function store1(Request $request){
		  // return $request->asw;
      /* dd($request);*/
       $store = new updateso;
       $store->u_o_nomor=$request->a[0]['value'];
       $store->Status=$request->a[1]['value'];
       $store->catatan=$request->a[2]['value'];
       $store->save();
       $anj = DB::table('update_detail1')->max('id');
       if ($anj == '' ) {
         $anj=1;
       }
       else{
          $anj+=1;
       }
       for ($i=0; $i<count($request->asw); $i++) {
        $v = DB::table('update_detail1')->max('id_u');
       if ($v == '' ) {
         $v=1;
       }
       else{
          $v+=1;
       }
       $store1 = new update1;
       $store1->id=$anj;
       $store1->id_u=$v;
       $store1->nomor_surat_jalan_trayek=$request->b[0]['value'];
       $store1->nomor_do=$request->asw[$i];
       $store1->status=$request->b[1]['value'];
       $store1->save();
       }
        for ($i=0; $i<count($request->asw); $i++) {
          $data12 = $request->asw;
        }
       /* dd($request);*/
       for ($i=0; $i<count($data12); $i++) {
        $update1 = array(
                'status' => $request->b[1]['value'],
            );
        $simpan = DB::table('delivery_order')->where('nomor', $request->asw[$i])->update($update1);
       }
       /*dd($update1);*/
     
        return response()->json([
                            'status' => 'berhasil',
                            'data' => $store,
               ]);


	}
	public function store2(Request $request){
				/*dd($request);*/
				// return $request->asw;

       $store = new updatesodo;
			 $store->no_do=$request->a[0]['value'];
       $store->status=$request->a[1]['value'];
       $store->catatan=$request->a[2]['value'];
       $store->nama=$request->a[3]['value'];
       $store->id=$request->a[4]['value'];
       $store->save();

       $a = DB::table('update_detail1')->max('id');
       if ($a == '' ) {
         $a=1;
       }
       else{
          $a+=1;
       }

			for ($i=0; $i<count($request->asw); $i++) {
			 $v = DB::table('update_detail1')->max('id_u');
			if ($v == '' ) {
				$v=1;
			}
			else{
				 $v+=1;
			}
       $store1 = new update1;
       $store1->id=$a;
       $store1->id_u=$v;
       $store1->nomor_do=$request->b[0]['value'];
       $store1->status=$request->b[1]['value'];
       $store1->save();
			 }
        
        for ($i=0; $i<count($request->asw); $i++) {
        $update1 = array(
                'status' => $request->b[1]['value'],
            );
        $simpan = DB::table('delivery_order')->where('nomor', $request->b[0]['value'])->update($update1);
       }
   
   
   
	       return response()->json([
                            'status' => 'berhasil',
                            'data' => $store,
               ]);

	}
}
