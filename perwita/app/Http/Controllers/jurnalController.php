<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class jurnalController extends Controller
{
    function lihatJurnal($ref,$note){
    	 $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$ref' and jr_note='$note')"));
    	 return view('jurnal',compact('jurnal_dt','note','$nomor'));
    }
    function lihatJurnalUmum(Request $request){
    	$note=$request->note;
    	$nomor=$request->ref;
    	 $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$request->ref' and jr_note='$request->note')"));
    	 return view('jurnal',compact('jurnal_dt','note','nomor'));
    }

      function lihatJurnalPemb(Request $request){
        $note=$request->note;
        $nomor=$request->ref;
         $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$request->ref' and jr_detail='$request->note')"));
         return view('jurnal',compact('jurnal_dt','note','nomor'));
    }



}
