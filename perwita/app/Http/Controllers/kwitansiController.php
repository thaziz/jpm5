<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class kwitansiController extends Controller
{
	public function kwitansi(){
		return view('kwitansi');
	} 
	public function invoice(){
		return view('invoice');
	}
	public function outlet(){
		return view('pembayaran_outlet');
	}
	public function suratjalan(){
		return view('suratjalan');
	}
	public function nota(){
		return view('nota');
	}
	public function faktur(){
		return view('faktur_pembelian');
	}
	public function fpg(){
		return view('fpg');
	}
	public function po(){
		return view('po');
	}
	public function stockopname(){
		return view('stockopname');
	}
	public function kartustock(){
		return view('kartustock');
	}
	public function bppb(){
		return view('bppb');
	}
	public function laporanopname(){
		return view('laporanopname');
	}
	public function laporanstock(){
		return view('laporanstock');
	}
	public function laporanpenerimaan(){
		return view('laporanpenerimaan');
	}
}
