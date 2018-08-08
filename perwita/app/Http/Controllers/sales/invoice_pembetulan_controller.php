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

        if ($tagihan_awal == $total_tagihan) {
          return response()->json(['status'=>0,'pesan'=>'Invoice Tidak ada perubahan']);
        }
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
            $akunPPN='2301';
        } elseif ($request->cb_jenis_ppn == 5) {//include
            $ppn_type = 'npkp';
            $ppn_persen = 10;
            $nilaiPpn=10/110;
            $akunPPN='2398';
        }


        $user = Auth::user()->m_name;

        $cari_nota = DB::table('invoice_pembetulan')
                 ->where('ip_nomor',$request->nota_invoice)
                 ->first();
                 
        if ($cari_nota == null) {
          $nota = $request->nota_invoice;
        }elseif ($cari_nota != null) {
          return 'nota sudah ada';
        }

        $save_header_invoice = DB::table('invoice_pembetulan')
                                 ->insert([
                                      'ip_nomor'              =>  $nota,
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
                                        'ipd_nomor_invoice' => $nota,
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
           $save_detail_invoice = DB::table('invoice_pembetulan_d')
                                    ->insert([
                                        'ipd_id'            => $cari_id,
                                        'ipd_nomor_invoice' => $Nota,
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
                        'cd_ref'        => $nota,
                        'cd_jenis_biaya'=> $cari_acc->kode,
                        'created_at'    => carbon::now(),
                        'updated_at'    => carbon::now(),
                        'created_by'    => Auth::user()->m_username,
                        'update_by'     => Auth::user()->m_username,
                      ]);


        $cari_invoice = DB::table('invoice')
                          ->where('i_nomor',$request->nota_invoice)
                          ->first();

        if ($ppn_type == 'npkp') {
          $nilai_ppn = $ppn_persen/(100 + $ppn_persen) * $hasil;
          $cari_pph  = $hasil - $request->diskon2;
        }else{
          $nilai_ppn = $ppn_persen/100 * $hasil;
        }
        $hasil_dpp = $hasil - $nilai_ppn;
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
                        'cdd_dpp_akhir'       => $hasil_dpp,
                        'cdd_ppn_akhir'       => round($nilai_ppn,2),
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

        // JURNAL CN/DN
        if ($jenis == 'K') {
          $jenis = "KREDIT";
        }else{
          $jenis = "DEBET";
        }
        $id_jurnal=d_jurnal::max('jr_id')+1;
        $delete = d_jurnal::where('jr_ref',$nota)->delete();
        $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                      'jr_year'   => carbon::now()->format('Y'),
                      'jr_date'   => carbon::now()->format('Y-m-d'),
                      'jr_detail' => $jenis.' NOTA',
                      'jr_ref'    => $nota,
                      'jr_note'   => 'DEBET KREDIT NOTA',
                      'jr_insert' => carbon::now(),
                      'jr_update' => carbon::now(),
                      ]);
        // PIUTANG
        $invoic = [];
        $akun_piutang_temp = [];
        $nilai_piutang_temp = [];
        $akun_pendapatan_temp = [];
        $nilai_pendapatan_temp = [];
        $inv = $request->nota_invoice;
        array_push($invoic,$inv);
        for ($i=0; $i < count($invoic); $i++) { 

          $tot_vendor  = 0;
          $tot_own     = 0;
          $akun_vendor = [];
          $akun_own = [];
          $invoice = DB::table('invoice')
                        ->where('i_nomor',$invoic[$i])
                        ->first();
          
          if ($invoice->i_pendapatan == 'PAKET') {
            $akun_vendor = DB::table('d_akun')
                              ->where('id_akun','like','4501'.'%')
                              ->where('kode_cabang',$invoice->i_kode_cabang)
                              ->first();

            $akun_own = DB::table('d_akun')
                            ->where('id_akun','like','4301'.'%')
                            ->where('kode_cabang',$invoice->i_kode_cabang)
                            ->first(); 

            $invoice_d = DB::table('invoice_d')
                        ->join('delivery_order','nomor','=','id_nomor_do')
                        ->where('id_nomor_invoice',$invoic[$i])
                        ->get();
            for ($a=0; $a < count($invoice_d); $a++) { 
              $tot_vendor += $invoice_d[$a]->total_vendo;
              $tot_own += $invoice_d[$a]->total_dpp;
            }
            $tot_vendor1 = (filter_var($tagihan_awal-$total_tagihan,FILTER_SANITIZE_NUMBER_INT)/100)/$invoice->i_total_tagihan * $tot_vendor;
            $tot_own1 = ($tagihan_awal-$total_tagihan)/$invoice->i_total_tagihan * $tot_own;
            if (round($tot_vendor1) != 0) {
              array_push($akun_pendapatan_temp, $akun_vendor->id_akun);
              array_push($nilai_pendapatan_temp, $tot_vendor1);
            }

            if (round($tot_own1) != 0) {
              array_push($akun_pendapatan_temp, $akun_own->id_akun);
              array_push($nilai_pendapatan_temp, $tot_own1);
            }
          }else if ($invoice->i_pendapatan == 'KARGO') {
             $akun_vendor = DB::table('d_akun')
                              ->where('id_akun','like','4401'.'%')
                              ->where('kode_cabang',$invoice->i_kode_cabang)
                              ->first();

            $akun_own = DB::table('d_akun')
                            ->where('id_akun','like','4201'.'%')
                            ->where('kode_cabang',$invoice->i_kode_cabang)
                            ->first();

            $invoice_d = DB::table('invoice_d')
                        ->join('delivery_order','nomor','=','id_nomor_do')
                        ->where('id_nomor_invoice',$invoic[$i])
                        ->get();

            for ($a=0; $a < count($invoice_d); $a++) { 
              if ($invoice_d[$a]->kode_subcon == 'OWN') {
                $tot_own += $invoice_d[$a]->total_net;
              }else{
                $tot_vendor += $invoice_d[$a]->total_net;
              }
            }
            $tot_vendor1 = ($tagihan_awal-$total_tagihan)/$invoice->i_total_tagihan * $tot_vendor;
            $tot_own1 = ($tagihan_awal-$total_tagihan)/$invoice->i_total_tagihan * $tot_own;
            if (round($tot_vendor1) != 0) {
              array_push($akun_pendapatan_temp, $akun_vendor->id_akun);
              array_push($nilai_pendapatan_temp, $tot_vendor1);
            }

            if (round($tot_own1) != 0) {
              array_push($akun_pendapatan_temp, $akun_own->id_akun);
              array_push($nilai_pendapatan_temp, $tot_own1);
            }
          }else if ($invoice->i_pendapatan == 'KORAN') {

            $invoice_d = DB::table('invoice_d')
                        ->join('delivery_orderd','dd_id','=','id_nomor_do_dt')
                        ->where('id_nomor_invoice',$invoic[$i])
                        ->get();
            $temp = DB::table('item')
                  ->where('kode',$do_d->dd_kode_item)
                  ->first();

            $akun_koran = DB::table('d_akun')
                              ->where('id_akun','like',substr($temp->acc_penjualan,0, 4).'%')
                              ->where('kode_cabang',$invoice->i_kode_cabang)
                              ->first();

            $dpp = $tagihan_awal-$total_tagihan;
            $total = $dpp/$invoice->i_total_tagihan * $invoice_d->dd_total;
            array_push($akun_pendapatan_temp, $akun_koran);
            array_push($nilai_pendapatan_temp, $total);
          }

          array_push($akun_piutang_temp, $invoice->i_acc_piutang);
          array_push($nilai_piutang_temp, $tagihan_awal-$total_tagihan);
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

        for ($i=0; $i < count($akun_pendapatan_fix); $i++) { 
          $array_sum = array_sum($nilai_pendapatan_fix);
          $ppnnya    = round($nilai_ppn,2);
          $hasilnya     = $ppnnya/$array_sum*$nilai_pendapatan_fix[$i];
          $nilai_pendapatan_fix[$i]-=$hasilnya;
        }

        $akun_ppn_fix = [];
        $nilai_ppn_fix = [];
        $akun = DB::table('d_akun')
                  ->where('id_akun','like',$akunPPN.'%')
                  ->where('kode_cabang',$cabang)
                  ->first();

        array_push($akun_ppn_fix, $akun->id_akun);
        array_push($nilai_ppn_fix,round($nilai_ppn,2));



        $akun     = [];
        $akun_val = [];


        for ($i=0; $i < count($akun_piutang_fix); $i++) { 
            array_push($akun,$akun_piutang_fix[$i]);
            array_push($akun_val,$nilai_piutang_fix[$i]);
        }

        for ($i=0; $i < count($akun_pendapatan_fix); $i++) { 
            array_push($akun,$akun_pendapatan_fix[$i]);
            array_push($akun_val,$nilai_pendapatan_fix[$i]);
        }

        for ($i=0; $i < count($akun_ppn_fix); $i++) { 
            array_push($akun,$akun_ppn_fix[$i]);
            array_push($akun_val,$nilai_ppn_fix[$i]);
        }

        // dd($jenis);
        if ($jenis == 'KREDIT') {
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
                $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2302 or substr($akun[$i],0, 4)==2398) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2305 or substr($akun[$i],0, 4)==2306 or substr($akun[$i],0, 4)==2307 or substr($akun[$i],0, 4)==2308 or substr($akun[$i],0, 4)==2309) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2301) {
                if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }
              }else if (substr($akun[$i],0, 1)==4) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }
          }
        }else{
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
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2302 or substr($akun[$i],0, 4)==2398) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2305 or substr($akun[$i],0, 4)==2306 or substr($akun[$i],0, 4)==2307 or substr($akun[$i],0, 4)==2308 or substr($akun[$i],0, 4)==2309) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2301) {
                if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }
              }else if (substr($akun[$i],0, 1)==4) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 1)==5) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }
          }
        }

        $jurnal_dt = d_jurnal_dt::insert($data_akun);

        $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
        return response()->json(['status' =>1, 'nota'=>$nota]);    

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
              if ($request->cb_pendapatan == 'PAKET' or $request->cb_pendapatan == 'KARGO') {
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
