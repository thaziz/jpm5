<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\mMember;

use App\Authentication;

use Auth;

class dashboardController extends Controller
{
    public function dashboard(){ 
if(Auth::user()->punyaAkses('Dashboard','ubah')){
    	return view('dashboard');
    }else{
    	
    	return view('dashboard');
    }
    }
}
