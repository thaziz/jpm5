<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\cabang;

use Session;

class cabangController extends Controller
{
    public function cabang($kode){
    	$cabang=cabang::where('kode',$kode)->first();      
    	session::set('cabang',$cabang->kode);
        session::set('namaCabang',$cabang->nama);           
        
        return json_encode($cabang->kode);
    }
}
