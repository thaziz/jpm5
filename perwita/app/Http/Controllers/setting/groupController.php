<?php

namespace App\Http\Controllers\setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class groupController extends Controller
{
    

    public function daftarmenu(){
        return view('setting.daftarmenu.index');
    }

     public function savedaftarmenu(){
        return json_encode('sukses');

    }
}
