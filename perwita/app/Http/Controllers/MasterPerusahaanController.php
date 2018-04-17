<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Response;

class MasterPerusahaanController extends Controller
{

    public function index(){
        
        return view('master_sales.masterperusahaan.index',compact('kota','cabang','akun'));
    }

}
