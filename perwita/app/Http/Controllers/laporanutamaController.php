<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class laporanutamaController extends Controller
{

	public function seluruhlaporan(){
		return view('purchase.laporan.seluruhlaporan');
	} 
}
