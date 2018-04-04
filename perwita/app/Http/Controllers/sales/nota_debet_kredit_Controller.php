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

        $pajak    = DB::table('pajak')
                      ->get();

        $akun_biaya    = DB::table('akun_biaya')
                      ->get();
        return view('sales.nota_debet_kredit.create_cn_dn', compact('customer','cabang','pajak','akun','pajak','akun_biaya'));
    }
    public function index(){
        $cabang = DB::select(DB::raw(" SELECT * FROM cabang"));
        return view('sales.nota_debet_kredit.index', compact('cabang'));
    }
    public function cari_invoice(request $request)
    {
        $temp = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_kode_cabang',$request->cabang)
                  ->where('i_kode_customer',$request->customer)
                  ->get();

        $temp1 = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_kode_cabang',$request->cabang)
                  ->where('i_kode_customer',$request->customer)
                  ->get();



        if (isset($request->array_simpan)) {
            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->array_simpan); $a++) { 
                    if ($request->array_simpan[$a] == $temp1[$i]->i_nomor) {
                        unset($temp[$i]);
                    }
                }
            }
            $temp = array_values($temp);
            $data = $temp;
            
        }else{
            $data = $temp;
        }
        return view('sales.nota_debet_kredit.tabel_cndn',compact('data'));

    }
    public function pilih_invoice(request $request)
    {   
        // dd($request->all());
        $data = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_nomor',$request->nomor)
                  ->first();
        $nota_debet  = DB::table('cn_dn_penjualan_d')
                        ->join('cn_dn_penjualan','cdd_id','=','cd_id')
                        ->where('cdd_nomor_invoice',$request->nomor)
                        ->where('cd_jenis','D')
                        ->get();

        $nota_kredit = DB::table('cn_dn_penjualan_d')
                        ->join('cn_dn_penjualan','cdd_id','=','cd_id')
                        ->where('cdd_nomor_invoice',$request->nomor)
                        ->where('cd_jenis','K')
                        ->get();

        $jumlah_debet  = [];
        $jumlah_kredit = [];
        for ($i=0; $i < count($nota_debet); $i++) { 
          $jumlah_debet[$i] = $nota_debet[$i]->cdd_netto_akhir;
        }
        for ($i=0; $i < count($nota_kredit); $i++) { 
          $jumlah_kredit[$i] = $nota_kredit[$i]->cdd_netto_akhir;
        }

        $jumlah_debet = array_sum($jumlah_debet);
        $jumlah_kredit = array_sum($jumlah_kredit);

        return response()->json(['data'=>$data,'D'=>$jumlah_debet,'K'=>$jumlah_kredit]);
    }

    public function simpan_cn_dn(request $request)
    {
        // dd($request->all());

        $cari_nota = DB::table('cn_dn_penjualan')
                       ->where('cd_nomor',$request->nomor_cn_dn)
                       ->first();

        if ($cari_nota == null) {

          $id = DB::table('cn_dn_penjualan')
                       ->max('cd_id');
          if ($id == null) {
            $id = 1;
          }else{
            $id +=1;
          }

          $cari_acc = DB::table('akun_biaya')
                        ->where('kode',$request->akun_biaya)
                        ->first();

          $save_cd = DB::table('cn_dn_penjualan')
                       ->insert([
                        'cd_id'         => $id,
                        'cd_nomor'      => $request->nomor_cn_dn,
                        'cd_tanggal'    => $request->tgl,
                        'cd_customer'   => $request->customer,
                        'cd_kode_cabang'=> $request->cabang,
                        'cd_jenis'      => $request->jenis_debet,
                        'cd_dpp'        => filter_var($request->jumlah_dpp, FILTER_SANITIZE_NUMBER_INT)/100,
                        'cd_ppn'        => filter_var($request->jumlah_ppn, FILTER_SANITIZE_NUMBER_INT)/100,
                        'cd_pph'        => filter_var($request->jumlah_pph, FILTER_SANITIZE_NUMBER_INT)/100,
                        'cd_total'      => filter_var($request->jumlah_nota, FILTER_SANITIZE_NUMBER_INT)/100,
                        'cd_acc'        => $cari_acc->acc_biaya,
                        'cd_csf'        => $cari_acc->csf_biaya,
                        'cd_keterangan' => $request->keterangan,
                        'created_at'    => carbon::now(),
                        'updated_at'    => carbon::now(),
                        'created_by'    => Auth::user()->m_username,
                        'update_by'     => Auth::user()->m_username,
                      ]);

          for ($i=0; $i < count($request->d_netto); $i++) { 

            $cari_invoice = DB::table('invoice')
                              ->where('i_nomor',$request->d_nomor[$i])
                              ->first();
            $save_cdd = DB::table('cn_dn_penjualan_d')
                          ->insert([
                            'cdd_id'              => $id,
                            'cdd_nomor_invoice'   => $request->d_nomor[$i],
                            'cdd_tanggal_invoice' => $cari_invoice->i_tanggal,
                            'cdd_jatuh_tempo'     => $cari_invoice->i_jatuh_tempo,
                            'cdd_dpp_awal'        => $cari_invoice->i_netto_detail,
                            'cdd_ppn_awal'        => $cari_invoice->i_ppnrp,
                            'cdd_pph_awal'        => $cari_invoice->i_pajak_lain,
                            'cdd_netto_awal'      => $cari_invoice->i_total_tagihan,
                            'cdd_dpp_akhir'       => filter_var($request->d_dpp[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                            'cdd_ppn_akhir'       => filter_var($request->d_ppn[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                            'cdd_pph_akhir'       => filter_var($request->d_pph[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                            'cdd_netto_akhir'     => filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                          ]);
          }
          return response()->json(['status'=>1]);
        }else{
          return response()->json(['status'=>2]);
        }


          
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
