<?php

namespace App\Http\Controllers\master_keuangan\laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\desain_arus_kas as aruskas;
use App\desain_arus_kas_detail as detail;
use App\master_akun as akun;

use DB;

class laporan_arus_kas extends Controller
{
    public function index_arus_kas_single(Request $request, $throttle){
    	$cek = count(DB::table("desain_arus_kas")->where("is_active", 1)->first());
	    $desain = DB::table("desain_arus_kas")->select("*")->orderBy("id_desain", "desc")->get();
	    $date = (substr($request->m, 0, 1) == 0) ? substr($request->m, 1, 1) : $request->m;

	    if(count($desain) == 0){
	        return view("laporan_arus_kas.err.empty_desain");
	    }elseif($cek == 0){
	        return view("laporan_arus_kas.err.missing_active")->withDesain($desain);
	    }

      if($throttle == 'bulan'){

        $data_date = $request->y.'-'.($request->m+1).'-01';
        $data_real = $request->y.'-'.$request->m.'-01';
        $arus_kas = aruskas::where('is_active', 1)->first();
        $id = $arus_kas->id_desain;

        $data_saldo = akun::select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0) as saldo'), 'opening_date')
                                  ->orderBy('id_akun', 'asc')->with([
                                        'mutasi_bank_debet' => function($query) use ($data_real, $data_date){
                                              $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                    ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                    ->where('jr_date', '<', $data_real)
                                                    ->where('jr_date', '>', DB::raw("opening_date"))
                                                    ->groupBy('jrdt_acc', 'opening_date')
                                                    ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                                        },
                                  ])
                                  ->where(DB::raw('substring(id_akun,1,4)'), '1001') // kas kecil
                                  ->orWhere(DB::raw('substring(id_akun,1,4)'), '1099') // kas bank
                                  ->orderBy('id_akun', 'asc')->get();

        // return $data_saldo;

        $detail = detail::where('id_desain', $arus_kas->id_desain)
                    ->with(['detail' => function($query) use ($id, $data_date, $data_real){
                      $query->where('id_desain', $id)->with(['akun' => function($query) use ($data_date, $data_real){
                        $query->select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date', 'main_id')
                              ->with([
                                        'mutasi_bank_debet' => function($query) use ($data_date, $data_real){
                                              $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                    ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                    ->where('jr_date', '>=', DB::raw("opening_date"))
                                                    ->where('jr_date', '<', $data_date)
                                                    ->where('jr_date', '>=', $data_real)
                                                    ->groupBy('jrdt_acc', 'opening_date')
                                                    ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date', DB::raw("'".$data_date."' as periode"));
                                        }
                                  ])
                                  ->orderBy('id_akun', 'asc');
                      }]);
                    }])
                    ->orderBy('nomor_id', 'asc')
                    ->get();

      }else{

        $data_date = ($request->y + 1).'-01-01';
        $data_real = $request->y.'-01-01';
        $arus_kas = aruskas::where('is_active', 1)->first();
        $id = $arus_kas->id_desain;

        $data_saldo = akun::select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0) as saldo'), 'opening_date')
                                  ->orderBy('id_akun', 'asc')->with([
                                        'mutasi_bank_debet' => function($query) use ($data_real, $data_date){
                                              $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                    ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                    ->where('jr_date', '<', $data_real)
                                                    ->where('jr_date', '>', DB::raw("opening_date"))
                                                    ->groupBy('jrdt_acc', 'opening_date')
                                                    ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                                        },
                                  ])
                                  ->where(DB::raw('substring(id_akun,1,4)'), '1001') // kas kecil
                                  ->orWhere(DB::raw('substring(id_akun,1,4)'), '1099') // kas bank
                                  ->orderBy('id_akun', 'asc')->get();

        // return $data_saldo;

        $detail = detail::where('id_desain', $arus_kas->id_desain)
                    ->with(['detail' => function($query) use ($id, $data_date, $data_real){
                      $query->where('id_desain', $id)->with(['akun' => function($query) use ($data_date, $data_real){
                        $query->select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date', 'main_id')
                              ->with([
                                        'mutasi_bank_debet' => function($query) use ($data_date, $data_real){
                                              $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                    ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                    ->where('jr_date', '>=', DB::raw("opening_date"))
                                                    ->where('jr_date', '<', $data_date)
                                                    ->where('jr_date', '>=', $data_real)
                                                    ->groupBy('jrdt_acc', 'opening_date')
                                                    ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date', DB::raw("'".$data_date."' as periode"));
                                        }
                                  ])
                                  ->orderBy('id_akun', 'asc');
                      }]);
                    }])
                    ->orderBy('nomor_id', 'asc')
                    ->get();

      }

        // return $detail;
	    return view("laporan_arus_kas.pdf_single", compact('request', 'arus_kas', 'detail', 'data_date', 'data_real', 'throttle', 'data_saldo'));
    }
}
