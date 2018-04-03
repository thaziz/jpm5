<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class saldo_piutang_controller extends Controller
{
    public function index(){
    	return view("keuangan.saldo_piutang.index");
    }

    public function add(){
    	return view("keuangan.saldo_piutang.insert");
    }
}
