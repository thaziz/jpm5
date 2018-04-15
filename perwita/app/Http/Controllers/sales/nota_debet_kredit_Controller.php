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

        if (Auth::user()->punyaAkses('CN DN Penjualan','all')) {
          $data = DB::table('cn_dn_penjualan')
                      ->join('customer','kode','=','cd_customer')
                      ->get();

        }else{
          $data = DB::table('cn_dn_penjualan')
                      ->join('customer','kode','=','cd_customer')
                      ->where('cd_kode_cabang',$cabang)
                      ->get();
        }

      

        $data = collect($data);

        return Datatables::of($data)
                        ->addColumn('tombol', function ($data) {
                              $div_1  =   '<div class="btn-group">';
                              if (Auth::user()->punyaAkses('CN DN Penjualan','ubah')) {
                              $div_2  = '<button type="button" onclick="edit(\''.$data->cd_nomor.'\')" class="btn btn-xs btn-warning">'.
                                        '<i class="fa fa-pencil"></i></button>';
                              }else{
                                $div_2 = '';
                              }
                              if (Auth::user()->punyaAkses('CN DN Penjualan','hapus')) {
                              $div_3  = '<button type="button" onclick="hapus(\''.$data->cd_nomor.'\')" class="btn btn-xs btn-danger">'.
                                        '<i class="fa fa-trash"></i></button>';
                              }else{
                                $div_3 = '';
                              }
                              $div_4   = '</div>';
                              return $div_1 . $div_2 . $div_3 . $div_4;
                            })  
                        ->addColumn('hasil', function ($data) {
                             return number_format($data->cd_total, 2, ",", ".");
                            })
                        ->addColumn('debet', function ($data) {
                              if ($data->cd_jenis == 'D') {
                                $debet = $data->cd_dpp + $data->cd_ppn - $data->cd_ppn;
                              }else{
                                $debet = 0;
                              }
                              return number_format($debet, 2, ",", ".");
                            })
                        ->addColumn('kredit', function ($data) {
                             if ($data->cd_jenis == 'K') {
                                $kredit = $data->cd_dpp + $data->cd_ppn - $data->cd_ppn;
                              }else{
                                $kredit = 0;
                              }
                              return number_format($kredit, 2, ",", ".");
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
                  ->where('i_sisa_pelunasan','!=',0)
                  ->get();

        $temp1 = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_kode_cabang',$request->cabang)
                  ->where('i_sisa_pelunasan','!=',0)
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
                        ->where('cd_nomor','!=',$request->nomor_cn_dn)
                        ->where('cd_jenis','D')
                        ->get();

        $nota_kredit = DB::table('cn_dn_penjualan_d')
                        ->join('cn_dn_penjualan','cdd_id','=','cd_id')
                        ->where('cdd_nomor_invoice',$request->nomor)
                        ->where('cd_nomor','!=',$request->nomor_cn_dn)
                        ->where('cd_jenis','K')
                        ->get();

        $jumlah_debet  = [];
        $jumlah_kredit = [];

        if ($nota_debet != null) {
          for ($i=0; $i < count($nota_debet); $i++) { 
            $temp = $nota_debet[$i]->cdd_dpp_akhir+$nota_debet[$i]->cdd_ppn_akhir-$nota_debet[$i]->cdd_pph_akhir;
            array_push($jumlah_debet, $temp);
          }
            $jumlah_debet = array_sum($jumlah_debet);

        }else{
          $jumlah_debet = 0;
        }

        if ($nota_kredit != null) {
          for ($i=0; $i < count($nota_kredit); $i++) { 
            $temp = $nota_kredit[$i]->cdd_dpp_akhir+ $nota_kredit[$i]->cdd_ppn_akhir- $nota_kredit[$i]->cdd_pph_akhir;
            array_push($jumlah_kredit, $temp);
          }
            $jumlah_kredit = array_sum($jumlah_kredit);

        }else{
          $jumlah_kredit = 0;
        }
        
        


        return response()->json(['data'=>$data,'D'=>$jumlah_debet,'K'=>$jumlah_kredit]);
    }

    public function simpan_cn_dn(request $request)
    {
        // dd($request->all());
      // dd($request->all());
        return DB::transaction(function() use ($request) {  

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
                        'cd_jenis_biaya'=> $request->akun_biaya,
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
                            'cdd_jenis_ppn'       => $request->d_jenis_ppn[$i],
                            'cdd_jenis_pajak'     => $request->d_pajak_lain[$i],
                            'cdd_netto_awal'      => $cari_invoice->i_total_tagihan,
                            'cdd_dpp_akhir'       => filter_var($request->d_dpp[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                            'cdd_ppn_akhir'       => filter_var($request->d_ppn[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                            'cdd_pph_akhir'       => filter_var($request->d_pph[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                            'cdd_netto_akhir'     => filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100,
                          ]);

            if ($request->jenis_debet == 'K') {
              $hasil = $cari_invoice->i_kredit + filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100;
              $sisa_akhir = $cari_invoice->i_sisa_akhir - filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100;
              $update_invoice = DB::table('invoice')
                                  ->where('i_nomor',$request->d_nomor[$i])
                                  ->update([
                                    'i_kredit' =>$hasil,
                                    'i_sisa_akhir'=>$sisa_akhir
                                  ]);
            }else{
              $hasil = $cari_invoice->i_debet + filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100;
              $sisa_akhir = $cari_invoice->i_sisa_akhir + filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100;
              $update_invoice = DB::table('invoice')
                                  ->where('i_nomor',$request->d_nomor[$i])
                                  ->update([
                                    'i_debet' =>$hasil,
                                    'i_sisa_akhir'=>$sisa_akhir
                                  ]);
            }

          }
          return response()->json(['status'=>1]);
        }else{
          return response()->json(['status'=>2]);
        }

        });

          
    }
    public function nomor_cn_dn(request $request)
    {   

        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

        $cari_nota = DB::select("SELECT  substring(max(cd_nomor),11) as id from cn_dn_penjualan
                                        WHERE cd_kode_cabang = '$request->cabang'
                                        AND to_char(cd_tanggal,'MM') = '$bulan'
                                        AND to_char(cd_tanggal,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        if ($request->jenis_cd == 'K') {
          $nota = 'KN' . $request->cabang . $bulan . $tahun . $index;
        }else{
          $nota = 'DN' . $request->cabang . $bulan . $tahun . $index;
        }
        return response()->json(['nota'=>$nota]);
    }
    public function riwayat(request $request)
    {
      $cd   =  DB::table('cn_dn_penjualan_d')
                  ->join('cn_dn_penjualan','cd_id','=','cdd_id')
                  ->join('invoice','i_nomor','=','cdd_nomor_invoice')
                  ->where('cdd_nomor_invoice',$request->nomor)
                  ->where('cd_nomor','!=',$request->id)
                  ->get();

      $kwitansi =  DB::table('kwitansi')
                  ->join('kwitansi_d','k_id','=','kd_id')
                  ->where('kd_nomor_invoice',$request->nomor)
                  ->get();

      return view('sales.nota_debet_kredit.riwayat',compact('cd','kwitansi'));
    }
    public function edit($id)
    {
      if (Auth::user()->punyaAkses('CN DN Penjualan','ubah')) {
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

          $data = DB::table('cn_dn_penjualan')
                    ->where('cd_nomor',$id)
                    ->first();

          $data_dt = DB::table('cn_dn_penjualan_d')
                    ->join('cn_dn_penjualan','cd_id','=','cdd_id')
                    ->join('invoice','i_nomor','=','cdd_nomor_invoice')
                    ->where('cd_nomor',$id)
                    ->get();

          return view('sales.nota_debet_kredit.edit_cn_dn', compact('customer','cabang','pajak','akun','pajak','akun_biaya','data','data_dt'));
      }else{

        return redirect()->back();
      }
       

    }

    public function hapus_cn_dn(request $request)
    {


      $cari_cdn = DB::table('cn_dn_penjualan')
                       ->join('cn_dn_penjualan_d','cd_id','=','cdd_id')
                       ->where('cd_nomor',$request->nomor_cn_dn)
                       ->get();

      for ($i=0; $i < count($cari_cdn); $i++) { 
        
        $cari_invoice = DB::table('invoice')
                              ->where('i_nomor',$cari_cdn[$i]->cdd_nomor_invoice)
                              ->first();

        if ($cari_cdn[$i]->cd_jenis == 'K') {
              $hasil = $cari_invoice->i_kredit - $cari_cdn[$i]->cdd_netto_akhir;
              $sisa_akhir = $cari_invoice->i_sisa_akhir + $cari_cdn[$i]->cdd_netto_akhir;
              $update_invoice = DB::table('invoice')
                                  ->where('i_nomor',$cari_cdn[$i]->cdd_nomor_invoice)
                                  ->update([
                                    'i_kredit' =>$hasil,
                                    'i_sisa_akhir' =>$sisa_akhir,
                                  ]);
        }else{
              $hasil = $cari_invoice->i_debet - $cari_cdn[$i]->cdd_netto_akhir;
              $sisa_akhir = $cari_invoice->i_sisa_akhir - $cari_cdn[$i]->cdd_netto_akhir;
              $update_invoice = DB::table('invoice')
                                  ->where('i_nomor',$request->d_nomor[$i])
                                  ->update([
                                    'i_debet' =>$hasil,
                                    'i_sisa_akhir' =>$sisa_akhir,
                                  ]);
        }

      }

      $hapus = DB::table('cn_dn_penjualan')
                       ->where('cd_nomor',$request->nomor_cn_dn)
                       ->delete();

      return response()->json(['status'=>1]);
    }

    public function update_cn_dn(request $request)
    {
      $this->hapus_cn_dn($request);
      return $this->simpan_cn_dn($request);
    }


}
