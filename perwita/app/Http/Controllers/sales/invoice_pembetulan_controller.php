<?php

namespace App\Http\Controllers\sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use carbon\carbon;
use DB;
class invoice_pembetulan_controller extends Controller
{
   public function index()
 	{
 		$cabang = auth::user()->kode_cabang;
        if (Auth::user()->m_level == 'ADMINISTRATOR' || Auth::user()->m_level == 'SUPERVISOR') {
            $data = DB::table('invoice_pembetulan')
                      ->join('customer','kode','=','ip_kode_customer')
                      ->get();
        }else{
            $data = DB::table('invoice_pembetulan')
                      ->join('customer','kode','=','ip_kode_customer')
                      ->where('ip_kode_cabang',$cabang)
                      ->get();
        }
        $kota = DB::table('kota')
                  ->get();
        return view('sales.invoice_pembetulan.index',compact('data'));
 	}

 	public function invoice_pembetulan_create()
 	{
 		    $customer = DB::table('customer')
                      ->get();

        $cabang   = DB::table('cabang')
                      ->get();
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                      ->get();

        return view('sales.invoice_pembetulan.invoice_pembetulan_create',compact('customer','cabang','tgl','tgl1','pajak'));
 	}

 	public function cari_invoice_pembetulan(request $request)
 	{
 		   $data = DB::table('invoice')
 				        ->join('customer','kode','=','i_kode_customer')
	              ->where('i_kode_cabang',$request->cabang)
	              ->where('i_sisa_akhir','!=',0)
	              ->get();

        return view('sales.invoice_pembetulan.tabel_invoice',compact('data'));
    	
 	}

 	public function pilih_invoice_pembetulan(request $request)
 	{
 		$data = DB::table('invoice')
 				  ->where('i_nomor',$request->id)
 				  ->first();

 		$data->tgl = carbon::parse($data->i_tanggal)->format('d/m/Y');
 		$data->jt = carbon::parse($data->i_jatuh_tempo)->format('d/m/Y');
 		$temp = DB::table('invoice_d')
 				  ->where('id_nomor_invoice',$request->id)
 				  ->get();


 		if ($data->i_pendapatan == 'KORAN') {
 			for ($i=0; $i < count($temp); $i++) { 
 				$data_dt[$i] = DB::table('delivery_orderd')
 				  			 ->join('delivery_order','nomor','=','dd_nomor')
   							 ->where('dd_nomor',$temp[$i]->id_nomor_do)
   							 ->where('dd_id',$temp[$i]->id_nomor_do_dt)
   							 ->get();
 			}
 		}else{
 			for ($i=0; $i < count($temp); $i++) { 
 				$data_dt[$i] = DB::table('delivery_order')
 						     ->where('nomor',$temp[$i]->id_nomor_do)
 						     ->get();
 			}
 		}
 		

 		return response()->json(['data'=>$data,'data_dt'=>$data_dt]);
 	}

  public function simpan_invoice_pembetulan(request $request)
  {
    // dd($request->all());
    return DB::transaction(function() use ($request) {  


        $dataItem=[];
        $cabang=$request->cb_cabang;
        $do_awal        = str_replace('/', '-', $request->do_awal);
        $do_akhir       = str_replace('/', '-', $request->do_akhir);
        $ed_jatuh_tempo = str_replace('/', '-', $request->ed_jatuh_tempo);
        $do_awal        = Carbon::parse($do_awal)->format('Y-m-d');
        $do_akhir       = Carbon::parse($do_akhir)->format('Y-m-d');
        $ed_jatuh_tempo = Carbon::parse($ed_jatuh_tempo)->format('Y-m-d');

        $total_tagihan  = filter_var($request->total_tagihan, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $netto_total    = filter_var($request->netto_total, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $diskon1        = filter_var($request->diskon1, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $diskon2        = filter_var($request->diskon2, FILTER_SANITIZE_NUMBER_FLOAT);
        $ed_total       = filter_var($request->ed_total, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $total_ppn      = filter_var($request->ppn, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $total_pph      = filter_var($request->pph, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $tagihan_awal   = filter_var($request->tagihan_awal, FILTER_SANITIZE_NUMBER_FLOAT)/100;
        $sisa_tagihan   = filter_var($request->sisa_tagihan, FILTER_SANITIZE_NUMBER_FLOAT)/100;

        $cari_no_invoice = DB::table('invoice_pembetulan')
                             ->where('ip_nomor',$request->nota_invoice)
                             ->first();
        $ppn_type='';
        $ppn_persen='';
        $nilaiPpn='';
        $akunPPH='';
        $d=[];


        $request->netto_detail = str_replace(['Rp', '\\', '.', ' '], '', $request->netto_detail);
        $request->netto_detail =str_replace(',', '.', $request->netto_detail);

        $request->diskon2 = str_replace(['Rp', '\\', '.', ' '], '', $request->diskon2);
        $request->diskon2 =str_replace(',', '.', $request->diskon2);

        if ($request->cb_jenis_ppn == 1) {
            $ppn_type = 'pkp';
            $ppn_persen = 10;
            $nilaiPpn=10/100;

            $akunPPH='2301';
        } elseif ($request->cb_jenis_ppn == 2) {
            $ppn_type = 'pkp';
            $ppn_persen = 1;
            $nilaiPpn=1/100;
            $akunPPH='2301';
        } elseif ($request->cb_jenis_ppn == 3) {//include
            $ppn_type = 'npkp';
            $ppn_persen = 1;
            $nilaiPpn=1/101;
            $akunPPH='2301';
        } elseif ($request->cb_jenis_ppn == 5) {//include
            $ppn_type = 'npkp';
            $ppn_persen = 10;
            $nilaiPpn=10/110;
            $akunPPH='2301';
        }
        
          if ($cari_no_invoice == null) {
            $save_header_invoice = DB::table('invoice_pembetulan')
                                     ->insert([
                                          'ip_nomor'              =>  $request->nota_invoice,
                                          'ip_tanggal'            =>  Carbon::now(),
                                          'ip_keterangan'         =>  $request->ed_keterangan,
                                          'ip_tgl_mulaip_do'      =>  $do_awal,
                                          'ip_tgl_sampaip_do'     =>  $do_akhir,
                                          'ip_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'ip_total'              =>  $tagihan_awal,
                                          'ip_netto_detail'       =>  $netto_total,
                                          'ip_diskon1'            =>  $diskon1,
                                          'ip_diskon2'            =>  $diskon2,
                                          'ip_total_tagihan'      =>  $tagihan_awal,
                                          'ip_total_revisi'       =>  $total_tagihan,
                                          'ip_netto'              =>  $ed_total,
                                          'ip_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'ip_ppntpe'             =>  $ppn_type,
                                          'ip_ppnrte'             =>  $ppn_persen,
                                          'ip_ppnrp'              =>  $total_ppn,
                                          'ip_kode_pajak'         =>  $request->kode_pajak_lain,
                                          'ip_pajak_lain'         =>  $total_pph,
                                          'ip_tagihan'            =>  $tagihan_awal,
                                          'ip_kode_customer'      =>  $request->ed_customer,
                                          'ip_kode_cabang'        =>  $cabang,
                                          'create_by'             =>  Auth::user()->m_name,
                                          'create_at'             =>  Carbon::now(),
                                          'update_by'             =>  Auth::user()->m_name,
                                          'update_at'             =>  Carbon::now(),
                                          'ip_pendapatan'         =>  $request->cb_pendapatan
                                     ]);

              if ($request->cb_pendapatan == 'PAKET' or $request->cb_pendapatan == 'KARGO') {
                // dd('asd');
                for ($i=0; $i < count($request->do_detail); $i++) { 

                $cari_id = DB::table('invoice_pembetulan_d')
                             ->max('ipd_id');

                 if ($cari_id == null ) {
                     $cari_id = 1;
                 }else{
                     $cari_id += 1;
                 }
                 $do = DB::table('delivery_order')
                         ->where('nomor',$request->do_detail[$i])
                         ->first();

                 $save_detail_invoice = DB::table('invoice_pembetulan_d')
                                          ->insert([
                                              'ipd_id'            => $cari_id,
                                              'ipd_nomor_invoice' => $request->nota_invoice,
                                              'ipd_nomor_do'      => $request->do_detail[$i],
                                              'create_by'         => Auth::user()->m_name,
                                              'create_at'         => Carbon::now(),
                                              'update_by'         => Auth::user()->m_name,
                                              'update_at'         => Carbon::now(),
                                              'ipd_tgl_do'        => $do->tanggal,
                                              'ipd_jumlah'        => $request->dd_jumlah[$i],
                                              'ipd_keterangan'    => $do->deskripsi,
                                              'ipd_harga_satuan'  => $request->dd_harga[$i],
                                              'ipd_harga_bruto'   => $request->dd_total[$i],
                                              'ipd_diskon'        => $request->dd_diskon[$i],
                                              'ipd_harga_netto'   => $request->harga_netto[$i],
                                              'ipd_kode_satuan'   => $do->kode_satuan,
                                              'ipd_kuantum'       => $do->jumlah,
                                              'ipd_kode_item'     => 'tidak ada',
                                              'ipd_tipe'          => 'tidak tahu',
                                              'ipd_acc_penjualan' => $do->acc_penjualan
                                          ]);

                }
              }else{
                for ($i=0; $i < count($request->do_detail); $i++) { 

                $cari_id = DB::table('invoice_d')
                             ->max('ipd_id');

                 if ($cari_id == null ) {
                     $cari_id = 1;
                 }else{
                     $cari_id += 1;
                 }
                $do = DB::table('delivery_orderd')
                         ->join('delivery_order','nomor','=','dd_nomor')
                         ->where('dd_id',$request->do_id[$i])
                         ->first();
                  // dd($request->do_id);
                 $save_detail_invoice = DB::table('invoice_pembetulan_d')
                                          ->insert([
                                              'ipd_id'            => $cari_id,
                                              'ipd_nomor_invoice' => $request->nota_invoice,
                                              'ipd_nomor_do'      => $request->do_detail[$i],
                                              'create_by'        => Auth::user()->m_name,
                                              'create_at'        => Carbon::now(),
                                              'update_by'        => Auth::user()->m_name,
                                              'update_at'        => Carbon::now(),
                                              'ipd_tgl_do'        => Carbon::parse($do->tanggal)->format('Y-m-d'),
                                              'ipd_jumlah'        => $request->dd_jumlah[$i],
                                              'ipd_keterangan'    => $do->dd_keterangan,
                                              'ipd_harga_satuan'  => $request->dd_harga[$i],
                                              'ipd_harga_bruto'   => $request->dd_total[$i],
                                              'ipd_diskon'        => $request->dd_diskon[$i],
                                              'ipd_harga_netto'   => $request->harga_netto[$i],
                                              'ipd_kode_satuan'   => $do->dd_kode_satuan,
                                              'ipd_kuantum'       => $do->dd_jumlah,
                                              'ipd_kode_item'     => $do->dd_kode_item,
                                              'ipd_tipe'          => 'tidak tahu',
                                              'ipd_acc_penjualan' => $do->dd_acc_penjualan,
                                              'ipd_nomor_do_dt'   => $request->do_id[$i]
                                          ]);
                  $update_do = DB::table('delivery_order')
                                   ->where('nomor',$request->do_detail[$i])
                                   ->update([
                                    'status_do'=>'Approved'
                                   ]);


                  }

              }


              $hasil = $tagihan_awal - $total_tagihan;

              
              if ($hasil < 0) {
                  $jenis = 'D';
                  $cari_acc = DB::table('akun_biaya')
                              ->where('kode','I1')
                              ->first();
                  $hasil = $hasil * -1;
              }else{
                  $jenis = 'K';
                  $cari_acc = DB::table('akun_biaya')
                              ->where('kode','I2')
                              ->first();
              }

              $bulan = Carbon::now()->format('m');
              $tahun = Carbon::now()->format('y');

              $cari_nota = DB::select("SELECT  substring(max(cd_nomor),12) as id from cn_dn_penjualan
                                              WHERE cd_kode_cabang = '$cabang'
                                              AND to_char(cd_tanggal,'MM') = '$bulan'
                                              AND to_char(cd_tanggal,'YY') = '$tahun'");

              $index = (integer)$cari_nota[0]->id + 1;
              $index = str_pad($index, 5, '0', STR_PAD_LEFT);
              $nota = 'CDN' . $cabang . $bulan . $tahun . $index;

                $id = DB::table('cn_dn_penjualan')
                             ->max('cd_id');
                if ($id == null) {
                  $id = 1;
                }else{
                  $id +=1;
                }

                

                $save_cd = DB::table('cn_dn_penjualan')
                             ->insert([
                              'cd_id'         => $id,
                              'cd_nomor'      => $nota,
                              'cd_tanggal'    => carbon::now(),
                              'cd_customer'   => $request->ed_customer,
                              'cd_kode_cabang'=> $cabang,
                              'cd_jenis'      => $cari_acc->jenis,
                              'cd_dpp'        => $hasil,
                              'cd_ppn'        => 0,
                              'cd_pph'        => 0,
                              'cd_total'      => $hasil,
                              'cd_acc'        => $cari_acc->acc_biaya,
                              'cd_csf'        => $cari_acc->csf_biaya,
                              'cd_keterangan' => '',
                              'cd_ref'        => $request->nota_invoice,
                              'cd_jenis_biaya'=> $cari_acc->kode,
                              'created_at'    => carbon::now(),
                              'updated_at'    => carbon::now(),
                              'created_by'    => Auth::user()->m_username,
                              'update_by'     => Auth::user()->m_username,
                            ]);


                  $cari_invoice = DB::table('invoice')
                                    ->where('i_nomor',$request->nota_invoice)
                                    ->first();

                  $save_cdd = DB::table('cn_dn_penjualan_d')
                                ->insert([
                                  'cdd_id'              => $id,
                                  'cdd_nomor_invoice'   => $request->nota_invoice,
                                  'cdd_tanggal_invoice' => $cari_invoice->i_tanggal,
                                  'cdd_jatuh_tempo'     => $cari_invoice->i_jatuh_tempo,
                                  'cdd_dpp_awal'        => $cari_invoice->i_netto_detail,
                                  'cdd_ppn_awal'        => $cari_invoice->i_ppnrp,
                                  'cdd_pph_awal'        => $cari_invoice->i_pajak_lain,
                                  'cdd_netto_awal'      => $cari_invoice->i_total_tagihan,
                                  'cdd_jenis_ppn'       => 0,
                                  'cdd_jenis_pajak'     => 0,
                                  'cdd_netto_awal'      => $cari_invoice->i_total_tagihan,
                                  'cdd_dpp_akhir'       => $hasil,
                                  'cdd_ppn_akhir'       => 0,
                                  'cdd_pph_akhir'       => 0,
                                  'cdd_netto_akhir'     => $hasil,
                                ]);

                  if ($request->jenis_debet == 'K') {
                    $hasil = $cari_invoice->i_kredit + $hasil;
                    $sisa_akhir = $cari_invoice->i_sisa_akhir - $hasil;
                    $update_invoice = DB::table('invoice')
                                        ->where('i_nomor',$request->nota_invoice)
                                        ->update([
                                          'i_kredit' =>$hasil,
                                          'i_sisa_akhir'=>$sisa_akhir
                                        ]);
                  }else{
                    $hasil = $cari_invoice->i_debet + $hasil;
                    $sisa_akhir = $cari_invoice->i_sisa_akhir + $hasil;
                    $update_invoice = DB::table('invoice')
                                        ->where('i_nomor',$request->nota_invoice)
                                        ->update([
                                          'i_debet' =>$hasil,
                                          'i_sisa_akhir'=>$sisa_akhir
                                        ]);
                  }

             return response()->json(['status' =>1, 'nota'=>$nota]);    
          }



    });
  }

  public function invoice_pembetulan_edit($id)
  {
    if (Auth::user()->punyaAkses('Invoice Penjualan','ubah')) {
       $customer = DB::table('customer')
                      ->get();

        $cabang   = DB::table('cabang')
                      ->get();
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                      ->get();


        $data = DB::table('invoice_pembetulan')
                  ->join('cn_dn_penjualan','cd_ref','=','ip_nomor')
                  ->where('ip_nomor',$id)
                  ->first();

        $data_dt = DB::table('invoice_pembetulan_d')
                  ->join('invoice_pembetulan','ip_nomor','=','ipd_nomor_invoice')
                  ->where('ip_nomor',$id)
                  ->get();

        return view('sales.invoice_pembetulan.invoice_pembetulan_edit',compact('customer','cabang','tgl','tgl1','pajak','data','data_dt'));
    }else{
      return redirect()->back();
    }
  }

  public function hapus_invoice_pembetulan(request $request)
  {
    $invoice = DB::table('invoice')
                  ->where('i_nomor',$request->id)
                  ->first();

    $invoice_pembetulan = DB::table('invoice_pembetulan_d')
                            ->where('ip_nomor',$request->id)
                            ->first();

    $penambahan = $invoice->i_sisa_pelunasan + $invoice->i_debet;
    $terbayar   = $invoice->i_sisa_pelunasan + $invoice->i_debet;

      if (($penambahan - $terbayar) < $invoice->i_debet) {
        return response()->json(['status'=>2,'ket'=>'Data Tidak Bisa Dihapus Karena Sisa kurang Dari Debet']);
      }else{


        if ($invoice->i_debet != 0) {
          $selisih = $invoice_pembetulan->ip_total_revisi - $invoice_pembetulan->ip_total_tagihan;

          $hasil = $invoice->i_sisa_akhir - $selisih;

          $update_invoice = DB::table('invoice')
                            ->where('i_nomor',$request->id)
                            ->update([
                              'i_debet' => 0,
                              'i_sisa_akhir'=> $hasil
                            ]);
        }else{
          $selisih = $invoice_pembetulan->ip_total_tagihan - $invoice_pembetulan->ip_total_revisi;

          $hasil = $invoice->i_sisa_akhir + $invoice->i_kredit;

          $update_invoice = DB::table('invoice')
                            ->where('i_nomor',$request->id)
                            ->update([
                              'i_debet' => 0,
                              'i_sisa_akhir'=> $hasil
                            ]);
        }

        $invoice_pembetulan = DB::table('invoice_pembetulan_d')
                            ->where('ip_nomor',$request->id)
                            ->delete();

        return response()->json(['status'=>1]);
      }

  }

}
