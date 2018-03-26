<?php

namespace App\Http\Controllers\master_keuangan\laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class laporan_neraca_saldo extends Controller
{
    public function index_neraca_saldo(Request $request, $throttle){
      return view("laporan_neraca_saldo.index")
              ->withRequest($request)
              ->withThrottle($throttle);
    }
}
