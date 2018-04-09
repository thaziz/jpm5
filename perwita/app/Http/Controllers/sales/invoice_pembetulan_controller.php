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
    dd($request->all());


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

    if ($request->ed_pendapatan == 'PAKET' || $request->ed_pendapatan == 'KARGO') {

        if ($cari_no_invoice == null) {

          $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'ip_nomor'              =>  $request->nota_invoice,
                                          'ip_tanggal'            =>  Carbon::now(),
                                          'ip_keterangan'         =>  $request->ed_keterangan,
                                          'ip_tgl_mulaip_do'      =>  $do_awal,
                                          'ip_tgl_sampaip_do'     =>  $do_akhir,
                                          'ip_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'ip_total'              =>  $total_tagihan,
                                          'ip_netto_detail'       =>  $netto_total,
                                          'ip_diskon1'            =>  $diskon1,
                                          'ip_diskon2'            =>  $diskon2,
                                          'ip_total_tagihan'      =>  $total_tagihan,
                                          'ip_netto'              =>  $ed_total,
                                          'ip_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'ip_ppntpe'             =>  $ppn_type,
                                          'ip_ppnrte'             =>  $ppn_persen,
                                          'ip_ppnrp'              =>  $total_ppn,
                                          'ip_kode_pajak'         =>  $request->kode_pajak_lain,
                                          'ip_pajak_lain'         =>  $total_pph,
                                          'ip_tagihan'            =>  $total_tagihan,
                                          'ip_kode_customer'      =>  $request->ed_customer,
                                          'ip_kode_cabang'        =>  $cabang,
                                          'create_by'             =>  Auth::user()->m_name,
                                          'create_at'             =>  Carbon::now(),
                                          'update_by'             =>  Auth::user()->m_name,
                                          'update_at'             =>  Carbon::now(),
                                          'ip_pendapatan'         =>  $request->ed_pendapatan
                                     ]);

            for ($i=0; $i < count($request->do_detail); $i++) { 

                $cari_id = DB::table('invoice_d')
                             ->max('id_id');

                 if ($cari_id == null ) {
                     $cari_id = 1;
                 }else{
                     $cari_id += 1;
                 }
                 $do = DB::table('delivery_order')
                         ->where('nomor',$request->do_detail[$i])
                         ->first();

                 $save_detail_invoice = DB::table('invoice_d')
                                          ->insert([
                                              'id_id'            => $cari_id,
                                              'id_nomor_invoice' => $request->nota_invoice,
                                              'id_nomor_do'      => $request->do_detail[$i],
                                              'create_by'        => Auth::user()->m_name,
                                              'create_at'        => Carbon::now(),
                                              'update_by'        => Auth::user()->m_name,
                                              'update_at'        => Carbon::now(),
                                              'id_tgl_do'        => $do->tanggal,
                                              'id_jumlah'        => $request->dd_jumlah[$i],
                                              'id_keterangan'    => $do->deskripsi,
                                              'id_harga_satuan'  => $request->dd_harga[$i],
                                              'id_harga_bruto'   => $request->dd_total[$i],
                                              'id_diskon'        => $request->dd_diskon[$i],
                                              'id_harga_netto'   => $request->harga_netto[$i],
                                              'id_kode_satuan'   => $do->kode_satuan,
                                              'id_kuantum'       => $do->jumlah,
                                              'id_kode_item'     => 'tidak ada',
                                              'id_tipe'          => 'tidak tahu',
                                              'id_acc_penjualan' => $do->acc_penjualan
                                          ]);

            }
        }
      
    }

  }
}
