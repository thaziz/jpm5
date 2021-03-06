<?php

namespace App\Http\Controllers\master_keuangan\laporan;

ini_set('max_execution_time', 300);

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun as akun;

use DB;
use Dompdf\Dompdf;
use PDF;
use Excel;
use Session;

class laporan_buku_besar extends Controller
{

    // buku besar index start

    public function index_buku_besar_single(Request $request){

        // return json_encode($request->all());

        $throttle = $request->jenis;

    	  $data = []; $saldo_awal = [];

        if($throttle == "Bulan"){


            $d1 = date_format(date_create($request->d1), "n"); $y1 = date_format(date_create($request->d1), "Y");
            $d2 = date_format(date_create($request->d2), "n"); $y2 = date_format(date_create($request->d2), "Y");

            $data_date = date_format(date_create($request->d1), "Y-m").'-01';

            // return json_encode($date.'-01');

            $b1 = date_format(date_create($request->d1), "m-Y"); $b2 = date_format(date_create($request->d2), "m-Y");

            if($request->buku_besar_cabang != 'all'){

                $data_saldo = akun::select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date')
                                ->where('kode_cabang', $request->buku_besar_cabang)
                                ->orderBy('id_akun', 'asc')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '<', $data_date)
                                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_statusdk", 'D')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                      'mutasi_bank_kredit' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '<', $data_date)
                                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_statusdk", 'K')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                ])
                                ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                                ->orderBy('id_akun', 'asc')->get();

                $data = akun::where('kode_cabang', $request->buku_besar_cabang)
                            ->with(['jurnal_detail' => function($query) use ($d1, $d2, $y1, $y2){
                                $query->select('jrdt_acc', 'jrdt_jurnal', 'jr_date', 'jrdt_value', 'jrdt_statusdk')
                                        ->join('d_jurnal', 'jr_id', '=', 'jrdt_jurnal')
                                        ->with(['d_jurnal' => function($query) use ($d1, $d2, $y1, $y2){
                                            $query->select('jr_id', 'jr_note', 'jr_date', 'jr_ref', 'jr_no')->with('detail');
                                        }])->whereHas('d_jurnal', function($query) use ($d1, $d2, $y1, $y2){
                                            $query->whereBetween(DB::raw("date_part('month', jr_date)"), [$d1, $d2])
                                                    ->whereBetween(DB::raw("date_part('year', jr_date)"), [$y1, $y2]);
                                        })->orderBy('jr_date');
                            }])
                            ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                            ->select('id_akun', 'nama_akun')
                            ->orderBy('id_akun', 'asc')->get();

                // dd($data);
            }else{

                $data_saldo = akun::select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date')
                                ->orderBy('id_akun', 'asc')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '<', $data_date)
                                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_statusdk", 'D')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                      'mutasi_bank_kredit' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '<', $data_date)
                                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_statusdk", 'K')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                ])
                                ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                                ->orderBy('id_akun', 'asc')->get();

                $data = DB::select(DB::raw("select id_akun, nama_akun, d_jurnal.jr_id, d_jurnal.jr_ref, d_jurnal.jr_date, d_jurnal.jr_note, d_jurnal_dt.jrdt_value, d_jurnal_dt.jrdt_statusdk from d_akun
                  join d_jurnal_dt on d_jurnal_dt.jrdt_acc = d_akun.id_akun
                  join d_jurnal on d_jurnal.jr_id = d_jurnal_dt.jrdt_jurnal
                  order by id_akun asc, jr_date asc"));

                $subledger = DB::select(DB::raw("select * from d_jurnal_dt where jrdt_jurnal in (select d_jurnal.jr_id from d_akun
                  join d_jurnal_dt on d_jurnal_dt.jrdt_acc = d_akun.id_akun
                  join d_jurnal on d_jurnal.jr_id = d_jurnal_dt.jrdt_jurnal
                  order by id_akun asc, jr_date asc)"));
                  
                  // return json_encode($subledger);
            }

        }elseif($throttle == "Tahun"){

            $d1 = $request->y1;
            $d2 = $request->y2;

            $b1 = $d1; $b2 = $d2;

            $data_date = $d1.'-01-01';

            // return json_encode($data_date;

            if($request->buku_besar_cabang != 'all'){

                $data_saldo = akun::select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date')
                                ->where('kode_cabang', $request->buku_besar_cabang)
                                ->orderBy('id_akun', 'asc')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '<', $data_date)
                                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_statusdk", 'D')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                      'mutasi_bank_kredit' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '<', $data_date)
                                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_statusdk", 'K')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                ])
                                ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                                ->orderBy('id_akun', 'asc')->get();

                $data = akun::where('kode_cabang', $request->buku_besar_cabang)
                            ->with(['jurnal_detail' => function($query) use ($d1, $d2){
                                $query->select('jrdt_acc', 'jrdt_jurnal', 'jr_date', 'jrdt_value', 'jrdt_statusdk')
                                        ->join('d_jurnal', 'jr_id', '=', 'jrdt_jurnal')
                                        ->with(['d_jurnal' => function($query) use ($d1, $d2){
                                            $query->select('jr_id', 'jr_note', 'jr_date', 'jr_ref', 'jr_no')->with('detail');
                                        }])->whereHas('d_jurnal', function($query) use ($d1, $d2){
                                                    $query->whereBetween(DB::raw("date_part('year', jr_date)"), [$d1, $d2]);
                                        })->orderBy('jr_date');
                            }])
                            ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                            ->select('id_akun', 'nama_akun')
                            ->orderBy('id_akun', 'asc')->get();
            }else{
                $data = akun::with(['jurnal_detail' => function($query) use ($d1, $d2){
                                $query->select('jrdt_acc', 'jrdt_jurnal', 'jr_date', 'jrdt_value', 'jrdt_statusdk')
                                        ->join('d_jurnal', 'jr_id', '=', 'jrdt_jurnal')
                                        ->with(['d_jurnal' => function($query) use ($d1, $d2){
                                            $query->select('jr_id', 'jr_note', 'jr_date', 'jr_ref', 'jr_no')->with('detail');
                                        }])->whereHas('d_jurnal', function($query) use ($d1, $d2){
                                                    $query->whereBetween(DB::raw("date_part('year', jr_date)"), [$d1, $d2]);
                                        })->orderBy('jr_date');
                            }])
                            ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                            ->select('id_akun', 'nama_akun')
                            ->orderBy('id_akun', 'asc')->get();
            }
            
        }

        // return json_encode($saldo);
        return view('laporan_buku_besar.print_pdf.pdf_single', compact('request', 'throttle', 'saldo_awal', 'data', 'grap', 'time', 'b1', 'b2', 'data_saldo', 'data_date', 'subledger'));

    	// $pdf = PDF::loadView('laporan_buku_besar.print_pdf.pdf_single', compact('request', 'throttle', 'saldo_awal', 'data', 'grap', 'time'))
                  // ->setPaper('folio','landscape');

        // if($throttle == "Bulan")
        //   return $pdf->stream('Laporan_Buku_Besar_Bulan_'.$request["m"].'/'.$request["y"].'.pdf');
        // else if($throttle == "Tahun")
        //   return $pdf->stream('Laporan_Buku_Besar_tahun_'.$request["y"].'.pdf');

    }

    // buku besar index end


    // buku besar print pdf start

    // laporan neraca pdf start

  public function print_pdf_buku_besar_single(Request $request, $throttle){

    $data = []; $saldo_awal = []; 
    //return json_encode($request->all());

    $throttle = "Bulan";

    if($throttle == "Bulan"){


            $d1 = date_format(date_create($request->d1), "n-Y");
            $d2 = date_format(date_create($request->d2), "n-Y");

            // return $d1." / ".$d2;
            // return $request->akun1." / ".$request->akun2;

            $time = DB::table('d_jurnal')
                    ->whereBetween(DB::raw("concat_ws('-', date_part('month', jr_date), date_part('year', jr_date))"), [$d1, $d2])
                    ->select(DB::raw("distinct(concat_ws('-', date_part('month', jr_date), date_part('year', jr_date))) as time"))->orderBy("time", "asc")->get();

            $data = DB::table("d_jurnal_dt")
                ->join("d_jurnal", "d_jurnal.jr_id", "=", "d_jurnal_dt.jrdt_jurnal")
                ->join("d_akun", "d_akun.id_akun", "=", "d_jurnal_dt.jrdt_acc")
                ->where("d_akun.kode_cabang", $request->buku_besar_cabang)
                ->whereBetween(DB::raw("concat_ws('-', date_part('month', jr_date), date_part('year', jr_date))"), [$d1, $d2])
                ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                ->select(DB::raw("distinct (d_akun.id_akun) as akun"), "d_akun.nama_akun as main_name")->get();

            $grap = DB::table("d_jurnal_dt")
                    ->join("d_jurnal", "d_jurnal.jr_id", "=", "d_jurnal_dt.jrdt_jurnal")
                    ->whereBetween(DB::raw("concat_ws('-', date_part('month', jr_date), date_part('year', jr_date))"), [$d1, $d2])
                    ->whereBetween('d_jurnal_dt.jrdt_acc', [$request->akun1, $request->akun2])
                    ->select("d_jurnal_dt.jrdt_value", "d_jurnal_dt.jrdt_acc as acc", "d_jurnal.jr_ref", "d_jurnal.jr_note", "d_jurnal.jr_date", "d_jurnal_dt.jrdt_statusdk")->orderBy("d_jurnal_dt.jrdt_statusdk", "asc")->get();

            // return json_encode($data);

            foreach($time as $key => $data_time){
                $m = (explode("-", $data_time->time)[0] >= 10) ? explode("-", $data_time->time)[0] : "0".explode("-", $data_time->time)[0];
                $y = explode("-", $data_time->time)[1];

                foreach ($data as $key => $data_akun) {
                    $saldo_awal[$data_time->time."/".$data_akun->akun] = DB::table("d_akun_saldo")
                                                    ->where("d_akun_saldo.id_akun", $data_akun->akun)
                                                    ->where("d_akun_saldo.bulan", $m)
                                                    ->where("d_akun_saldo.tahun", $y)
                                                    ->select(DB::raw("COALESCE(sum(d_akun_saldo.saldo_akun), 0) as saldo"))->first()->saldo;
                }
            }
            

            // return json_encode($saldo_awal);

        }elseif($throttle == "Tahun"){

            $d1 = $request->y1;
            $d2 = $request->y2;

            $time = DB::table('d_jurnal')
                    ->whereBetween(DB::raw("date_part('year', jr_date)"), [$d1, $d2])
                    ->select(DB::raw("distinct(date_part('year', jr_date)) as time"))->orderBy("time", "asc")->get();

            $data = DB::table("d_jurnal_dt")
                ->join("d_jurnal", "d_jurnal.jr_id", "=", "d_jurnal_dt.jrdt_jurnal")
                ->join("d_akun", "d_akun.id_akun", "=", "d_jurnal_dt.jrdt_acc")
                ->where("d_akun.kode_cabang", $request->buku_besar_cabang)
                ->whereBetween(DB::raw("date_part('year', jr_date)"), [$d1, $d2])
                ->whereBetween('d_akun.id_akun', [$request->akun1, $request->akun2])
                ->select(DB::raw("distinct (d_akun.id_akun) as akun"), "d_akun.nama_akun as main_name")->get();

            $grap = DB::table("d_jurnal_dt")
                    ->join("d_jurnal", "d_jurnal.jr_id", "=", "d_jurnal_dt.jrdt_jurnal")
                    ->whereBetween(DB::raw("date_part('year', jr_date)"), ['2017', '2018'])
                    ->whereBetween('d_jurnal_dt.jrdt_acc', [$request->akun1, $request->akun2])
                    ->select("d_jurnal_dt.jrdt_value", "d_jurnal_dt.jrdt_acc as acc", "d_jurnal.jr_ref", "d_jurnal.jr_note", "d_jurnal.jr_date", "d_jurnal_dt.jrdt_statusdk")->orderBy("d_jurnal_dt.jrdt_statusdk", "asc")->get();

            foreach($time as $key => $data_time){
                foreach ($data as $key => $data_akun) {
                    $saldo_awal[$data_time->time."/".$data_akun->akun] = DB::table("d_akun_saldo")
                                                    ->where("d_akun_saldo.id_akun", $data_akun->akun)
                                                    ->where("d_akun_saldo.tahun", $data_time->time)
                                                    ->select(DB::raw("COALESCE(sum(d_akun_saldo.saldo_akun), 0) as saldo"))->first()->saldo;
                }
            }
        }

    // return json_encode($grap);

    // $pdf = PDF::loadView('laporan_buku_besar.print_pdf.pdf_single', compact('request', 'throttle', 'saldo_awal', 'data', 'grap', 'time'))
                  // ->setPaper('folio','landscape');

    if($throttle == "Bulan")
      return $pdf->stream('Laporan_Buku_Besar_Bulan_'.$request["m"].'/'.$request["y"].'.pdf');
    else if($throttle == "Tahun")
      return $pdf->stream('Laporan_Buku_Besar_tahun_'.$request["y"].'.pdf');
  }

    // buku besar print pdf end
}
