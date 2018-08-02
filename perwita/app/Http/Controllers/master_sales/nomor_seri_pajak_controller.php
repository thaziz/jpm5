<?php

namespace App\Http\Controllers\master_sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class nomor_seri_pajak_controller extends Controller
{
    public function index()
    {
        return view('master_sales.nomor_seri_pajak.index');
    }
}
