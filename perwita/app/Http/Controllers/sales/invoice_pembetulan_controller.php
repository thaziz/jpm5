<?php

namespace App\Http\Controllers\sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use carbon\carbon;
use DB;
use App\d_jurnal;
use App\d_jurnal_dt;
class invoice_pembetulan_controller extends Controller
{

      public function penyebut($nilai=null) {
        $_this = new self;
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
      $temp = $_this->penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
      $temp = $_this->penyebut($nilai/10)." puluh". $_this->penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . $_this->penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = $_this->penyebut($nilai/100) . " ratus" . $_this->penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . $_this->penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = $_this->penyebut($nilai/1000) . " ribu" . $_this->penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = $_this->penyebut($nilai/1000000) . " juta" . $_this->penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = $_this->penyebut($nilai/1000000000) . " milyar" . $_this->penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = $_this->penyebut($nilai/1000000000000) . " trilyun" . $_this->penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
    }
   public function index()
 	{
 		$cabang = auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Invoice Pembetulan','all')) {
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

        $gp     = DB::table('grup_item')
                      ->get();

        return view('sales.invoice_pembetulan.invoice_pembetulan_create',compact('customer','cabang','tgl','tgl1','pajak','gp'));
 	}

 	public function cari_invoice_pembetulan(request $request)
 	{     
 		  $data = DB::table('invoice')
                ->join('customer','kode','=','i_kode_customer')
 				        ->leftjoin('invoice_pembetulan','ip_nomor','=','i_nomor')
                ->where('i_kode_cabang',$request->cabang)
	              ->where('ip_nomor','=',null)
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
    return DB::transaction(function() use ($request) {  


        $dataItem=[];
        $cabang=$request->cb_cabang;
        $do_awal        = str_replace('/', '-', $request->do_awal);
        $tgl            = str_replace('/', '-', $request->tgl);
        $do_akhir       = str_replace('/', '-', $request->do_akhir);
        $ed_jatuh_tempo = str_replace('/', '-', $request->ed_jatuh_tempo);
        $do_awal        = Carbon::parse($do_awal)->format('Y-m-d');
        $tgl            = Carbon::parse($tgl)->format('Y-m-d');
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


        if ($request->cb_pendapatan == 'PAKET') {
          $cari_acc_piutang1 = DB::table('d_akun')
                                ->where('id_akun','like','1303'.'%')
                                ->where('kode_cabang',$cabang)
                                ->first();
          $cari_acc_piutang = $cari_acc_piutang1->id_akun;
        }else if($request->cb_pendapatan == 'KARGO'){
          $cari_acc_piutang1 = DB::table('d_akun')
                                ->where('id_akun','like','1302'.'%')
                                ->where('kode_cabang',$cabang)
                                ->first();
          $cari_acc_piutang = $cari_acc_piutang1->id_akun;
        }else if($request->cb_pendapatan == 'KORAN'){
          $cari_acc_piutang = $request->acc_piutang;
        }

        $cari_no_invoice = DB::table('invoice_pembetulan')
                         ->where('ip_nomor',$request->nota_invoice)
                         ->first();
        $ppn_type = null;
        $ppn_persen = 0;
        if ($request->cb_jenis_ppn == 1) {
            $ppn_type = 'pkp';
            $ppn_persen = 10;
            $nilaiPpn=10/100;

            $akunPPN='2398';
        } elseif ($request->cb_jenis_ppn == 2) {
            $ppn_type = 'pkp';
            $ppn_persen = 1;
            $nilaiPpn=1/100;
            $akunPPN='2301';
        } elseif ($request->cb_jenis_ppn == 3) {//include
            $ppn_type = 'npkp';
            $ppn_persen = 1;
            $nilaiPpn=1/101;
            $akunPPN='2302';
        } elseif ($request->cb_jenis_ppn == 5) {//include
            $ppn_type = 'npkp';
            $ppn_persen = 10;
            $nilaiPpn=10/110;
            $akunPPN='2302';
        }

        if ($cari_no_invoice == null) {

            $save_header_invoice = DB::table('invoice_pembetulan')
                                     ->insert([
                                          'ip_nomor'              =>  $request->nota_invoice,
                                          'ip_tanggal'            =>  $tgl,
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
                                          'ip_grup'               =>  $request->grup_item,
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
                                              'ipd_keterangan'    => $do->keterangan_tarif,
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

                $cari_id = DB::table('invoice_pembetulan_d')
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

              $cari_nota = DB::select("SELECT  substring(max(cd_nomor),11) as id from cn_dn_penjualan
                                              WHERE cd_kode_cabang = '$cabang'
                                              AND to_char(created_at,'MM') = '$bulan'
                                              AND to_char(created_at,'YY') = '$tahun'");

              $index = (integer)$cari_nota[0]->id + 1;
              $index = str_pad($index, 5, '0', STR_PAD_LEFT);
              if ($jenis == 'K') {
                $nota = 'KN' . $cabang . $bulan . $tahun . $index;
              }else{  
                $nota = 'DN' . $cabang . $bulan . $tahun . $index;
              }

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
                              'cd_keterangan' => 'invoice pembetulan',
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
                  dd($request->all());

                  $tes = $ppn_persen/(100 + $ppn_persen) * $hasil;
                  dd(round($tes,2));

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
                                  'cdd_jenis_ppn'       => $request->cb_jenis_ppn,
                                  'cdd_jenis_pajak'     => 0,
                                  'cdd_netto_awal'      => $cari_invoice->i_total_tagihan,
                                  'cdd_dpp_akhir'       => $hasil,
                                  'cdd_ppn_akhir'       => round($tes,2),
                                  'cdd_pph_akhir'       => 0,
                                  'cdd_netto_akhir'     => $hasil,
                                ]);

                  if ($jenis == 'K') {
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

                  $update_invoice = DB::table('invoice_pembetulan')
                                        ->where('ip_nomor',$request->nota_invoice)
                                        ->update([
                                          'ip_ref' =>$nota,
                                        ]);


            // JURNAL
            $nota = $request->nota_invoice;

            $id_jurnal=d_jurnal::max('jr_id')+1;
            $delete = d_jurnal::where('jr_ref',$nota)->where('jr_note','INVOICE PEMBETULAN')->delete();
            $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                          'jr_year'   => carbon::parse(str_replace('/', '-', $tgl))->format('Y'),
                          'jr_date'   => carbon::parse(str_replace('/', '-', $tgl))->format('Y-m-d'),
                          'jr_detail' => 'INVOICE PEMBETULAN' .' '.$request->cb_pendapatan,
                          'jr_ref'    => $nota,
                          'jr_note'   => 'INVOICE PEMBETULAN',
                          'jr_insert' => carbon::now(),
                          'jr_update' => carbon::now(),
                          ]);

            if ($request->cb_pendapatan == 'PAKET') {

                $tot_vendor = 0;
                $tot_own = 0;

                for ($i=0; $i < count($request->do_detail); $i++) { 
                  $do = DB::table('delivery_order')
                          ->where('nomor',$request->do_detail[$i])
                          ->first();

                  $tot_vendor += $do->total_vendo;
                  $tot_own += $do->total_dpp;
                }


                $akun     = [];
                $akun_val = [];
                if ($request->cb_jenis_ppn != 4) {
                  // MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
                  if ($ppn_type == 'npkp') {
                    $temp = [$tot_own,$tot_vendor];
                    $hasil = array_search(0, $temp);

                    if ($hasil == false) {
                      $total_ppn = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/2;
                      $tot_own -=$total_ppn;
                      $tot_vendor -=$total_ppn;
                    }elseif ($hasil == 0) {
                      $total_ppn  = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100);
                      $tot_vendor = $tot_vendor - $total_ppn;
                    }elseif ($hasil == 1) {
                      $total_ppn  = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100);
                      $tot_own = $tot_own - $total_ppn;
                    }
                  }
                    // dd($total_tagihan);

                  array_push($akun, $cari_acc_piutang);
                  array_push($akun_val, $total_tagihan);

                  // DISKON
                  // dd($request->diskon2 );
                  if ($request->diskon2 != 0) {
                    $akun_diskon = DB::table('d_akun')
                                  ->where('id_akun','like','5398'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_diskon == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_diskon->id_akun);
                    array_push($akun_val, (float)$request->diskon2);
                  }
                  // JURNAL PPN
                  if (isset($akunPPN)) {
                    $akun_ppn = DB::table('d_akun')
                                  ->where('id_akun','like',$akunPPN.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_ppn == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_ppn->id_akun);
                    array_push($akun_val,(filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100));
                  }
                  // JURNAL PPH
                  if ($request->kode_pajak_lain != '0') {
                    if ($request->kode_pajak_lain != 'T') {
                      $cari_pajak = DB::table('pajak')
                                    ->where('kode',$request->kode_pajak_lain)
                                    ->first();
                      $akun_pph1 = $cari_pajak->acc1;
                      $akun_pph1 = substr($akun_pph1,0, 4);
                      $akun_pph  = DB::table('d_akun')
                                    ->where('id_akun','like',$akun_pph1.'%')
                                    ->where('kode_cabang',$cabang)
                                    ->first();
                      if ($akun_pph == null) {
                        return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                      }
                      array_push($akun, $akun_pph->id_akun);
                      array_push($akun_val,(filter_var($request->pph,FILTER_SANITIZE_NUMBER_INT)/100));
                    }
                  }

                  // PENDAPATAN VENDOR
                  if ($tot_vendor != 0) {
                    $akun_vendor = DB::table('d_akun')
                                  ->where('id_akun','like','4501'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_vendor == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_vendor->id_akun);
                    array_push($akun_val, $tot_vendor);
                  }
                  // PENDAPATAN OWN
                  if ($tot_own != 0) {
                    $akun_own = DB::table('d_akun')
                                  ->where('id_akun','like','4301'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_own == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_own->id_akun);
                    array_push($akun_val, $tot_own);
                  }
                  
                }else{
                  // NON PPN
                  array_push($akun, $cari_acc_piutang);
                  array_push($akun_val, $total_tagihan);
                  // DISKON
                  if ($request->diskon2 != 0) {
                    $akun_diskon = DB::table('d_akun')
                                  ->where('id_akun','like','5398'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_diskon == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_diskon->id_akun);
                    array_push($akun_val, (float)$request->diskon2);
                  }

                  // JURNAL PPH
                  if ($request->kode_pajak_lain != '0') {
                    if ($request->kode_pajak_lain != 'T') {
                      $cari_pajak = DB::table('pajak')
                                    ->where('kode',$request->kode_pajak_lain)
                                    ->first();
                      $akun_pph1 = $cari_pajak->acc1;
                      $akun_pph1 = substr($akun_pph1,0, 4);
                      $akun_pph  = DB::table('d_akun')
                                    ->where('id_akun','like',$akun_pph1.'%')
                                    ->where('kode_cabang',$cabang)
                                    ->first();
                      if ($akun_pph == null) {
                        return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                      }
                      array_push($akun, $akun_pph->id_akun);
                      array_push($akun_val,(filter_var($request->pph,FILTER_SANITIZE_NUMBER_INT)/100));
                    }
                  }

                  // PENDAPATAN VENDOR
                  if ($tot_vendor != 0) {
                    $akun_vendor = DB::table('d_akun')
                                  ->where('id_akun','like','4501'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_vendor == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_vendor->id_akun);
                    array_push($akun_val, $tot_vendor);
                  }
                  // PENDAPATAN OWN
                  if ($tot_own != 0) {
                    $akun_own = DB::table('d_akun')
                                  ->where('id_akun','like','4301'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_own == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_own->id_akun);
                    array_push($akun_val, $tot_own);
                  }
                }
            }elseif ($request->cb_pendapatan == 'KARGO'){
                // KARGO
                $tot_subcon = 0;
                $tot_own = 0;

                for ($i=0; $i < count($request->do_detail); $i++) { 
                  $do = DB::table('delivery_order')
                          ->where('nomor',$request->do_detail[$i])
                          ->first();

                  if ($do->status_kendaraan == 'OWN') {
                    $tot_own += $do->total_net;
                  }else{
                    $tot_subcon += $do->total_net;
                  }
                }


                $akun     = [];
                $akun_val = [];
                if ($request->cb_jenis_ppn != 4) {
                  // MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
                  if ($ppn_type == 'npkp') {
                    $temp = [$tot_own,$tot_subcon];
                    $hasil = array_search(0, $temp);

                    if ($hasil == false) {
                      $total_ppn = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/2;
                      $tot_own -=$total_ppn;
                      $tot_subcon -=$total_ppn;
                    }elseif ($hasil == 0) {
                      $total_ppn  = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100);
                      $tot_subcon = $tot_subcon - $total_ppn;
                    }elseif ($hasil == 1) {
                      $total_ppn  = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100);
                      $tot_own = $tot_own - $total_ppn;
                    }
                  }
                    // dd($total_tagihan);

                  array_push($akun, $cari_acc_piutang);
                  array_push($akun_val, $total_tagihan);

                  // DISKON
                  // dd($request->diskon2 );
                  if ($request->diskon2 != 0) {
                    $akun_diskon = DB::table('d_akun')
                                  ->where('id_akun','like','5398'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_diskon == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_diskon->id_akun);
                    array_push($akun_val, (float)$request->diskon2);
                  }
                  // JURNAL PPN
                  if (isset($akunPPN)) {
                    $akun_ppn = DB::table('d_akun')
                                  ->where('id_akun','like',$akunPPN.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_diskon == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_ppn->id_akun);
                    array_push($akun_val,(filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100));
                  }

                  // JURNAL PPH
                  if ($request->kode_pajak_lain != '0') {
                    if ($request->kode_pajak_lain != 'T') {
                      $cari_pajak = DB::table('pajak')
                                    ->where('kode',$request->kode_pajak_lain)
                                    ->first();
                      $akun_pph1 = $cari_pajak->acc1;
                      $akun_pph1 = substr($akun_pph1,0, 4);
                      $akun_pph  = DB::table('d_akun')
                                    ->where('id_akun','like',$akun_pph1.'%')
                                    ->where('kode_cabang',$cabang)
                                    ->first();
                      if ($akun_pph == null) {
                        return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                      }
                      array_push($akun, $akun_pph->id_akun);
                      array_push($akun_val,(filter_var($request->pph,FILTER_SANITIZE_NUMBER_INT)/100));
                    }
                  }

                  // PENDAPATAN VENDOR
                  if ($tot_subcon != 0) {
                    $akun_vendor = DB::table('d_akun')
                                  ->where('id_akun','like','4401'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_vendor == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_vendor->id_akun);
                    array_push($akun_val, $tot_subcon);
                  }
                  // PENDAPATAN OWN
                  if ($tot_own != 0) {
                    $akun_own = DB::table('d_akun')
                                  ->where('id_akun','like','4201'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_own == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_own->id_akun);
                    array_push($akun_val, $tot_own);
                  }
                }else{
                  // NON PPN
                  array_push($akun, $cari_acc_piutang);
                  array_push($akun_val, $total_tagihan);
                  // DISKON
                  if ($request->diskon2 != 0) {
                    $akun_diskon = DB::table('d_akun')
                                  ->where('id_akun','like','5398'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_diskon == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_diskon->id_akun);
                    array_push($akun_val, (float)$request->diskon2);
                  }

                  // JURNAL PPH
                  if ($request->kode_pajak_lain != '0') {
                    if ($request->kode_pajak_lain != 'T') {
                      $cari_pajak = DB::table('pajak')
                                    ->where('kode',$request->kode_pajak_lain)
                                    ->first();
                      $akun_pph1 = $cari_pajak->acc1;
                      $akun_pph1 = substr($akun_pph1,0, 4);
                      $akun_pph  = DB::table('d_akun')
                                    ->where('id_akun','like',$akun_pph1.'%')
                                    ->where('kode_cabang',$cabang)
                                    ->first();
                      if ($akun_pph == null) {
                        return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                      }
                      array_push($akun, $akun_pph->id_akun);
                      array_push($akun_val,(filter_var($request->pph,FILTER_SANITIZE_NUMBER_INT)/100));
                    }
                  }
                  // PENDAPATAN VENDOR
                  if ($tot_subcon != 0) {
                    $akun_vendor = DB::table('d_akun')
                                  ->where('id_akun','like','4401'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_vendor == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Vendor Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_vendor->id_akun);
                    array_push($akun_val, $tot_subcon);
                  }
                  // PENDAPATAN OWN
                  if ($tot_own != 0) {
                    $akun_own = DB::table('d_akun')
                                  ->where('id_akun','like','4201'.'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
                    if ($akun_own == null) {
                      return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                    }
                    array_push($akun, $akun_own->id_akun);
                    array_push($akun_val, $tot_own);
                  }
                }
            }

            $cari_jurnal_lama = DB::table('d_jurnal')
                                  ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
                                  ->where('jr_ref',$nota)
                                  ->where('jr_note','INVOICE')
                                  ->get();
            // dd($cari_jurnal_lama);
            // dd($akun);

            if ($jenis == 'K') {
              for ($i=0; $i < count($akun); $i++) { 
                for ($a=0; $a < count($cari_jurnal_lama); $a++) { 
                  if ($akun[$i] == $cari_jurnal_lama[$a]->jrdt_acc) {
                    if ($cari_jurnal_lama[$a]->jrdt_value < 0) {
                      $cari_jurnal_lama[$a]->jrdt_value *= -1;
                    }
                    if ($akun_val[$i] < $cari_jurnal_lama[$a]->jrdt_value) {
                      $akun_val[$i] = $cari_jurnal_lama[$a]->jrdt_value - $akun_val[$i];
                    }else{
                      $akun_val[$i] = $akun_val[$i] - $cari_jurnal_lama[$a]->jrdt_value;
                    }
                  }
                }
              }



              $data_akun = [];
              for ($i=0; $i < count($akun); $i++) { 

                $cari_coa = DB::table('d_akun')
                          ->where('id_akun',$akun[$i])
                          ->first();

                if (substr($akun[$i],0, 1)==1) {
                  
                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }else if (substr($akun[$i],0, 4)==2302 or substr($akun[$i],0, 4)==2398) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }else if (substr($akun[$i],0, 1)==2) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }else if (substr($akun[$i],0, 1)==4) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }
                else if (substr($akun[$i],0, 1)==5) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }
              }

            }else{
              
              for ($i=0; $i < count($akun); $i++) { 
                for ($a=0; $a < count($cari_jurnal_lama); $a++) { 
                  if ($akun[$i] == $cari_jurnal_lama[$a]->jrdt_acc) {
                    if ($cari_jurnal_lama[$a]->jrdt_value < 0) {
                      $cari_jurnal_lama[$a]->jrdt_value *= -1;
                    }
                    if ($akun_val[$i] < $cari_jurnal_lama[$a]->jrdt_value) {
                      $akun_val[$i] = $cari_jurnal_lama[$a]->jrdt_value - $akun_val[$i];
                    }else{
                      $akun_val[$i] = $akun_val[$i] - $cari_jurnal_lama[$a]->jrdt_value;
                    }
                  }
                }
              }



              $data_akun = [];
              for ($i=0; $i < count($akun); $i++) { 

                $cari_coa = DB::table('d_akun')
                          ->where('id_akun',$akun[$i])
                          ->first();

                if (substr($akun[$i],0, 1)==1) {
                  
                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }else if (substr($akun[$i],0, 4)==2302 or substr($akun[$i],0, 4)==2398) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }else if (substr($akun[$i],0, 1)==2) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }else if (substr($akun[$i],0, 1)==4) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }
                else if (substr($akun[$i],0, 1)==5) {

                  if ($cari_coa->akun_dka == 'D') {
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'K';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }else{
                    $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                    $data_akun[$i]['jrdt_detailid'] = $i+1;
                    $data_akun[$i]['jrdt_acc']      = $akun[$i];
                    $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                    $data_akun[$i]['jrdt_statusdk'] = 'D';
                    $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                  }
                }
              }
            }
            
            $jurnal_dt = d_jurnal_dt::insert($data_akun);

            $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
            // dd($lihat);
            return response()->json(['status' =>1, 'nota'=>$nota]);    
        }



    });
  }

  public function invoice_pembetulan_edit($id)
  {
    if (Auth::user()->punyaAkses('Invoice Pembetulan','ubah')) {
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

        $i_awal = DB::table('invoice_pembetulan')
                  ->join('invoice','ip_nomor','=','i_nomor')
                  ->where('ip_nomor',$id)
                  ->first();

        $gp     = DB::table('grup_item')
                      ->get();

        $data_dt = DB::table('invoice_pembetulan_d')
                  ->join('invoice_pembetulan','ip_nomor','=','ipd_nomor_invoice')
                  ->join('delivery_order','nomor','=','ipd_nomor_do')
                  ->leftjoin('delivery_orderd','dd_id','=','ipd_nomor_do_dt')
                  ->where('ip_nomor',$id)
                  ->get();

        return view('sales.invoice_pembetulan.invoice_pembetulan_edit',compact('customer','cabang','tgl','tgl1','pajak','data','data_dt','i_awal','gp'));
    }else{
      return redirect()->back();
    }
  }

  public function hapus_invoice_pembetulan(request $request)
  {

    return DB::transaction(function() use ($request) {  

        $invoice = DB::table('invoice')
                      ->where('i_nomor',$request->id)
                      ->first();

        $invoice_pembetulan = DB::table('invoice_pembetulan')
                                ->where('ip_nomor',$request->id)
                                ->first();


        


        if ($invoice_pembetulan->ip_total_tagihan <  $invoice_pembetulan->ip_total_revisi) {

          $debet = $invoice_pembetulan->ip_total_revisi - $invoice_pembetulan->ip_total_tagihan;

          if ($invoice->i_sisa_akhir < $debet) {
            return response()->json(['status'=>2,'ket'=>'Data Tidak Bisa Dihapus Karena Sisa kurang Dari Debet']);
          }

          $selisih = $invoice_pembetulan->ip_total_revisi - $invoice_pembetulan->ip_total_tagihan;

          $hasil = $invoice->i_sisa_akhir - $selisih;

          $hasil1 = $invoice->i_debet - $selisih;

          $update_invoice = DB::table('invoice')
                            ->where('i_nomor',$request->id)
                            ->update([
                              'i_debet' => $hasil1,
                              'i_sisa_akhir'=> $hasil
                            ]);
        }else{

          $selisih = $invoice_pembetulan->ip_total_tagihan - $invoice_pembetulan->ip_total_revisi;

          $hasil = $invoice->i_sisa_akhir + $invoice->i_kredit;

          $hasil1 = $invoice->i_kredit - $selisih;

          $update_invoice = DB::table('invoice')
                            ->where('i_nomor',$request->id)
                            ->update([
                              'i_kredit' => $hasil1,
                              'i_sisa_akhir'=> $hasil
                            ]);
        }

        $invoice_pembetulan = DB::table('invoice_pembetulan')
                            ->where('ip_nomor',$request->id)
                            ->delete();

        $cn_dn_del = DB::table('cn_dn_penjualan')
                            ->where('cd_ref',$request->id)
                            ->delete();

        return response()->json(['status'=>1]);
    });
  }
  public function update_invoice_pembetulan(request $request)
  {
    return DB::transaction(function() use ($request) {  

        $invoice = DB::table('invoice')
                  ->where('i_nomor',$request->nota_invoice)
                  ->first();

        $invoice_pembetulan = DB::table('invoice_pembetulan')
                            ->where('ip_nomor',$request->nota_invoice)
                            ->first();
        if ($invoice_pembetulan->ip_total_tagihan <  $invoice_pembetulan->ip_total_revisi) {

          $selisih = $invoice_pembetulan->ip_total_revisi - $invoice_pembetulan->ip_total_tagihan;

          $hasil = $invoice->i_sisa_akhir - $selisih;

          $hasil1 = $invoice->i_debet - $selisih;

          $update_invoice = DB::table('invoice')
                            ->where('i_nomor',$request->nota_invoice)
                            ->update([
                              'i_debet' => $hasil1,
                              'i_sisa_akhir'=> $hasil
                            ]);
        }else{
          $selisih = $invoice_pembetulan->ip_total_tagihan - $invoice_pembetulan->ip_total_revisi;

          $hasil = $invoice->i_sisa_akhir + $invoice->i_kredit;

          $hasil1 = $invoice->i_kredit - $selisih;

          $update_invoice = DB::table('invoice')
                            ->where('i_nomor',$request->nota_invoice)
                            ->update([
                              'i_kredit' => $hasil1,
                              'i_sisa_akhir'=> $hasil
                            ]);
        }

        $invoice_pembetulan = DB::table('invoice')
                            ->where('i_nomor',$request->nota_invoice)
                            ->first();
    // dd($invoice_pembetulan);

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
        
            $save_header_invoice = DB::table('invoice_pembetulan')
                                     ->where('ip_nomor',$request->nota_invoice)
                                     ->update([
                                          'ip_nomor'              =>  $request->nota_invoice,
                                          'ip_tanggal'            =>  $tgl,
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
                                          'update_by'             =>  Auth::user()->m_name,
                                          'ip_grup'               =>  $request->grup_item,
                                          'update_at'             =>  Carbon::now(),
                                          'ip_pendapatan'         =>  $request->cb_pendapatan
                                     ]);

              $delete = DB::table('invoice_pembetulan_d')
                          ->where('ipd_nomor_invoice',$request->nota_invoice)
                          ->delete();
              // dd($request->all());
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

                $cari_id = DB::table('invoice_pembetulan_d')
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

           
        

                

              $save_cd = DB::table('cn_dn_penjualan')
                             ->where('cd_nomor',$request->nota_cndn)
                             ->update([
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
                              'cd_keterangan' => 'invoice pembetulan',
                              'cd_ref'        => $request->nota_invoice,
                              'cd_jenis_biaya'=> $cari_acc->kode,
                              'updated_at'    => carbon::now(),
                              'update_by'     => Auth::user()->m_username,
                            ]);


                  $cari_invoice = DB::table('invoice')
                                    ->where('i_nomor',$request->nota_invoice)
                                    ->first();
                  $save_cd = DB::table('cn_dn_penjualan')
                             ->where('cd_nomor',$request->nota_cndn)
                             ->first();


                  $save_cdd = DB::table('cn_dn_penjualan_d')
                                ->where('cdd_id',$save_cd->cd_id)
                                ->update([
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

                  if ($jenis == 'K') {
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

                  $update_invoice = DB::table('invoice_pembetulan')
                                        ->where('ip_nomor',$request->nota_invoice)
                                        ->update([
                                          'ip_ref' =>$request->nota_cndn,
                                        ]);

             return response()->json(['status' =>1, 'nota'=>$request->nota_cndn]);    

    });
  }

  public function cetak_nota_pembetulan($id)
  {
    $head = DB::table('invoice_pembetulan')
                  ->join('customer','kode','=','ip_kode_customer')
                  ->where('ip_nomor',$id)
                  ->first();
        $detail = DB::table('invoice_pembetulan_d')
                    ->where('ipd_nomor_invoice',$id)
                    ->get();
        $counting = count($detail); 
  
        if ($counting < 30) {
          $hitung =30 - $counting;
          for ($i=0; $i < $hitung; $i++) { 
            $push[$i]=' ';
          }
        }else{
          $push = [];
        }

        

        // return $push;
        $terbilang = $this->penyebut($head->ip_total_tagihan);
        if ($head->ip_pendapatan == 'PAKET') {
          return view('sales.invoice_pembetulan.print',compact('head','detail','terbilang','push'));
        }else{
          return view('sales.invoice_pembetulan.print_1',compact('head','detail','terbilang','push'));
        }
  }

}
