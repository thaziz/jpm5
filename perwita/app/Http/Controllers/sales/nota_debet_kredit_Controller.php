<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use Yajra\Datatables\Datatables;
use carbon\Carbon;


class nota_debet_kredit_Controller extends Controller
{
    public function table_data () {
        //$cabang = strtoupper($request->input('kode_cabang'));
		$cabang = Auth::user()->kode_cabang;
        $data = DB::table('cn_dn_penjualan')
                  ->where('cd_kode_cabang',$cabang)
                  ->get();

        $data = collect($data);

        return Datatables::of($data)
                        ->addColumn('tombol', function ($data) {
                             return    '<div class="btn-group">
                                        <button type="button" onclick="hapus('.$data->cd_nomor.')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        <button type="button" onclick="edit('.$data->cd_nomor.')" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                                        </div>';
                            })
                        ->make(true);
  
    }

    public function create()
    {

        $cabang = DB::select(DB::raw(" SELECT * FROM cabang"));

        $customer = DB::table('customer')
                            ->get();

        $cabang = DB::table('cabang')
                    ->get();
        $pajak = DB::table('pajak')
                    ->get();

        $akun  = DB::table('d_akun')
                   // ->where('kode_cabang',$cabang)
                   ->get();
        return view('sales.nota_debet_kredit.create_cn_dn', compact('customer','cabang','pajak','akun'));
    }
    public function index(){
        $cabang = DB::select(DB::raw(" SELECT * FROM cabang"));
        return view('sales.nota_debet_kredit.index', compact('cabang'));
    }
    public function cari_invoice(request $request)
    {
        $data = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_kode_cabang',$request->cabang)
                  ->get();
        return view('sales.nota_debet_kredit.tabel_cndn',compact('data'));
    }
    public function pilih_invoice(request $request)
    {   
        // dd($request->all());
        $data = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_nomor',$request->nomor)
                  ->first();

        return response()->json(['data'=>$data]);
    }

    public function simpan_cn_dn(request $request)
    {
        // dd($request->all());

        $id=DB::table('cn_dn_penjualan')
              ->max('cd_id');
        if ($id == null) {
            $id = 1;
        }else{
            $id+=1;
        }

        $cari_invoice = DB::table('invoice')
                          ->where('i_nomor',$request->nomor_invoice)
                          ->first();
        $cari_aja = DB::table('cn_dn_penjualan')
                          ->where('cd_nomor',$request->nomor_cn_dn)
                          ->first();
        if ($request->jenis_debet =='K') {
            $kredit = $request->jumlah_biaya;
            $debet  = 0;
            $total  = $cari_invoice->i_total_tagihan - $kredit;
        }else{
            $kredit = 0;
            $debet  = $request->jumlah_biaya;
            $total  = $cari_invoice->i_total_tagihan + $debet;

        }
        if ($cari_aja == null) {
            $save = DB::table('cn_dn_penjualan')
                  ->insert([
                      'cd_id'               => $id,
                      'cd_tanggal'          => $request->tgl,
                      'cd_kode_cabang'      => $request->cabang,
                      'cd_invoice'          => $request->nomor_invoice,    
                      'cd_tagihan_invoice'  => $cari_invoice->i_total_tagihan,
                      'cd_debet'            => $debet,
                      'cd_kredit'           => $kredit, 
                      'cd_total'            => $total,
                      'cd_keterangan'       => $request->keterangan_biaya,
                      'cd_nomor'            => $request->nomor_cn_dn,
                  ]);
        }else{

            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('y');

            $cari_nota = DB::select("SELECT  substring(max(cd_nomor),12) as id from cn_dn_penjualan
                                            WHERE cd_kode_cabang = '$request->cabang'
                                            AND to_char(cd_tanggal,'MM') = '$bulan'
                                            AND to_char(cd_tanggal,'YY') = '$tahun'");

            $index = (integer)$cari_nota[0]->id + 1;

            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota = 'CDN' . $request->cabang . $bulan . $tahun . $index;

            $save = DB::table('cn_dn_penjualan')
                  ->insert([
                      'cd_id'               => $id,
                      'cd_tanggal'          => $request->tgl,
                      'cd_kode_cabang'      => $request->cabang,
                      'cd_invoice'          => $request->nomor_invoice,    
                      'cd_tagihan_invoice'  => $cari_invoice->i_total_tagihan,
                      'cd_debet'            => $debet,
                      'cd_kredit'           => $kredit, 
                      'cd_total'            => $total,
                      'cd_keterangan'       => $request->keterangan_biaya,
                      'cd_nomor'            => $nota,
                  ]);
        }
        

        return 'berhasil';
          
    }
    public function nomor_cn_dn(request $request)
    {   

        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

        $cari_nota = DB::select("SELECT  substring(max(cd_nomor),12) as id from cn_dn_penjualan
                                        WHERE cd_kode_cabang = '$request->cabang'
                                        AND to_char(cd_tanggal,'MM') = '$bulan'
                                        AND to_char(cd_tanggal,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'CDN' . $request->cabang . $bulan . $tahun . $index;
        return response()->json(['nota'=>$nota]);
    }
}
