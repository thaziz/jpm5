<?php

namespace App\Http\Controllers\master_keuangan\laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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


            $d1 = date_format(date_create($request->d1), "n-Y");
            $d2 = date_format(date_create($request->d2), "n-Y");

            $b1 = date_format(date_create($request->d1), "m-Y"); $b2 = date_format(date_create($request->d2), "m-Y");

            // return $b1." / ".$b2;
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
                    ->select("d_jurnal_dt.jrdt_value", "d_jurnal_dt.jrdt_acc as acc", "d_jurnal.jr_ref", "d_jurnal.jr_note", "d_jurnal.jr_date", "d_jurnal_dt.jrdt_statusdk")->orderBy("d_jurnal.jr_date", "asc")->get();

            // return json_encode($grap);

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

            $b1 = $d1; $b2 = $d2;

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
        return view('laporan_buku_besar.print_pdf.pdf_single', compact('request', 'throttle', 'saldo_awal', 'data', 'grap', 'time', 'b1', 'b2'));

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
