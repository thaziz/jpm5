<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use Yajra\Datatables\Datatables;
use carbon\Carbon;
use App\d_jurnal;
use App\d_jurnal_dt;

class nota_debet_kredit_Controller extends Controller
{
    public function table_data () {
        //$cabang = strtoupper($request->input('kode_cabang'));
    		$cabang = Auth::user()->kode_cabang;

        if (Auth::user()->punyaAkses('CN/DN','all')) {
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
                              if (Auth::user()->punyaAkses('CN/DN','ubah')) {
                              $div_2  = '<button type="button" onclick="edit(\''.$data->cd_nomor.'\')" class="btn btn-xs btn-warning">'.
                                        '<i class="fa fa-pencil"></i></button>';
                              }else{
                                $div_2 = '';
                              }
                              if (Auth::user()->punyaAkses('CN/DN','hapus')) {
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
          // JURNAL CN/DN
          if ($request->jenis_debet == 'K') {
            $jenis = "KREDIT";
          }else{
            $jenis = "DEBET";
          }
          $id_jurnal=d_jurnal::max('jr_id')+1;
          $delete = d_jurnal::where('jr_ref',$request->nomor_cn_dn)->delete();
          $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                        'jr_year'   => carbon::parse($request->tgl)->format('Y'),
                        'jr_date'   => carbon::parse($request->tgl)->format('Y-m-d'),
                        'jr_detail' => $jenis.' NOTA',
                        'jr_ref'    => $request->nomor_cn_dn,
                        'jr_note'   => 'DEBET KREDIT NOTA',
                        'jr_insert' => carbon::now(),
                        'jr_update' => carbon::now(),
                        ]);
          // PIUTANG
          $akun_piutang_temp = [];
          $nilai_piutang_temp = [];
          $akun_pendapatan_temp = [];
          $nilai_pendapatan_temp = [];
          for ($i=0; $i < count($request->d_nomor); $i++) { 
            $invoice = DB::table('invoice')
                          ->where('i_nomor',$request->d_nomor[$i])
                          ->first();
            $invoice_d = DB::table('invoice_d')
                          ->join('delivery_order','nomor','=','id_nomor_do')
                          ->where('id_nomor_invoice',$request->d_nomor[$i])
                          ->get();
            for ($a=0; $a < count($invoice_d); $a++) { 
              if ($invoice_d[$a]->pendapatan == 'PAKET') {
                $akun_vendor = DB::table('d_akun')
                                ->where('id_akun','like','4501'.'%')
                                ->where('kode_cabang',$invoice_d[$a]->kode_cabang)
                                ->first();

                $akun_own = DB::table('d_akun')
                                ->where('id_akun','like','4301'.'%')
                                ->where('kode_cabang',$invoice_d[$a]->kode_cabang)
                                ->first();
                if ($invoice_d[$a]->total_vendo != 0) {
                  array_push($akun_pendapatan_temp,$akun_vendor->id_akun);
                  array_push($nilai_pendapatan_temp,$invoice_d[$a]->total_vendo);
                }

                if ($invoice_d[$a]->total_dpp != 0) {
                  array_push($akun_pendapatan_temp,$akun_own->id_akun);
                  array_push($nilai_pendapatan_temp,$invoice_d[$a]->total_dpp);
                }
              }elseif ($invoice_d[$a]->pendapatan == 'KARGO') {
                $akun_vendor = DB::table('d_akun')
                                ->where('id_akun','like','4401'.'%')
                                ->where('kode_cabang',$invoice_d[$a]->kode_cabang)
                                ->first();

                $akun_own = DB::table('d_akun')
                                ->where('id_akun','like','4201'.'%')
                                ->where('kode_cabang',$invoice_d[$a]->kode_cabang)
                                ->first();
                if ($invoice_d[$a]->kode_subcon == 0) {
                  array_push($akun_pendapatan_temp,$akun_vendor->id_akun);
                  array_push($nilai_pendapatan_temp,$invoice_d[$a]->total_vendo);
                }elseif ($invoice_d[$a]->kode_subcon != 0) {
                  array_push($akun_pendapatan_temp,$akun_own->id_akun);
                  array_push($nilai_pendapatan_temp,$invoice_d[$a]->total_dpp);
                }
              }elseif ($invoice_d[$a]->pendapatan == 'KORAN') {
                $do_d = DB::table('delivery_order_d')
                          ->where('dd_nomor',$invoice_d[$a]->nomor)
                          ->get();
                for ($c=0; $c < count($do_d); $c++) { 
                  $temp = DB::table('item')
                      ->where('kode',$do_d[$c]->dd_kode_item)
                      ->first();
                  if ($temp == null) {
                    return response()->json(['Master Item Untuk Invoice Koran Tidak Ada']);
                  }else{
                    $akun = DB::table('d_akun')
                                ->where('id_akun','like',substr($temp->acc_penjualan,0,4).'%')
                                ->where('kode_cabang',$invoice_d[$a]->kode_cabang)
                                ->first();
                    array_push($akun_pendapatan_temp,$akun->id_akun);
                    array_push($nilai_pendapatan_temp,$do_d[$c]->dd_total);
                  }
                }
              }
            }

            array_push($akun_piutang_temp, $invoice->i_acc_piutang);
            array_push($nilai_piutang_temp, round(filter_var($request->d_netto[$i], FILTER_SANITIZE_NUMBER_INT)/100));
          }

          $akun_piutang_fix = array_values(array_unique($akun_piutang_temp));
          $nilai_piutang_fix = [];

          $akun_pendapatan_fix = array_values(array_unique($akun_pendapatan_temp));
          $nilai_pendapatan_fix = [];
          // PIUTANG
          for ($i=0; $i < count($akun_piutang_fix); $i++) { 
            for ($a=0; $a < count($akun_piutang_temp); $a++) { 
              if ($akun_piutang_temp[$a] == $akun_piutang_fix[$i]) {
                if (!isset($nilai_piutang_fix[$i])) {
                  $nilai_piutang_fix[$i] = 0;
                }
                $nilai_piutang_fix[$i]+=$nilai_piutang_temp[$a];
              }
            }
          }
          // PENDAPATAN
          for ($i=0; $i < count($akun_pendapatan_fix); $i++) { 
            for ($a=0; $a < count($akun_pendapatan_temp); $a++) { 
              if ($akun_pendapatan_temp[$a] == $akun_pendapatan_fix[$i]) {
                if (!isset($nilai_pendapatan_fix[$i])) {
                  $nilai_pendapatan_fix[$i] = 0;
                }
                $nilai_pendapatan_fix[$i]+=$nilai_pendapatan_temp[$a];
              }
            }
          }
          // PPN
          for ($i=0; $i < count($request->d_jenis_ppn); $i++) { 
            # code...
          }
          $akun     = [];
          $akun_val = [];


          for ($i=0; $i < count($akun_piutang_fix); $i++) { 
              array_push($akun,$akun_piutang_fix[$i]);
              array_push($akun_val,$nilai_piutang_fix[$i]);
          }
        
          dd($akun);


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
      if (Auth::user()->punyaAkses('CN/DN','ubah')) {
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
          // dd($data_dt);
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
                       ->first();

      if ($cari_cdn->cd_ref == null) {
      
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
      }else{
        return response()->json(['status'=>2]);
      }
    }

    public function update_cn_dn(request $request)
    {
      $this->hapus_cn_dn($request);
      return $this->simpan_cn_dn($request);
    }


}
