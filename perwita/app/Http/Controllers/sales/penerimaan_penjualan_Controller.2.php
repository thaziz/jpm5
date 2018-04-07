<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;


class penerimaan_penjualan_Controller extends Controller
{
    
    



    public function cetak_nota($nomor) {
        $head = DB::table('kwitansi')
                  ->join('customer','kode','=','k_kode_customer')
                  ->where('k_nomor',$nomor)
                  ->first();

        $detail = DB::table('kwitansi')
                    ->join('kwitansi_d','kd_id','=','k_id')
                    ->join('invoice','kd_nomor_invoice','=','i_nomor')
                     ->where('k_nomor',$nomor)
                    ->get();
        $counting = count($detail );
        if ($counting < 30) {
          $hitung =30 - $counting;
          for ($i=0; $i < $hitung; $i++) { 
            $push[$i]=' ';
          }
        }else{
          $push = [];
        }

        $terbilang =$this->penyebut($head->k_netto);
        return view('sales.penerimaan_penjualan.print',compact('head','detail','terbilang','push'));
    }

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

    public function form($nomor=null)
    {
        $comp = Auth::user()->kode_cabang;
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama,cabang FROM customer ORDER BY nama ASC ");
        $akun = DB::table('d_akun')
                  ->get();

        $akun_biaya = DB::table('akun_biaya')
                  ->get();

        $akun_bank = DB::table('masterbank')
                  ->get();

        $tgl  = Carbon::now()->format('d/m/Y');
       
        return view('sales.penerimaan_penjualan.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','kas_bank','akun','tgl','akun_biaya','akun_bank' ));
    }


    public function index()
    {
        if (Auth::user()->m_level == 'ADMINISTRATOR' || Auth::user()->m_level == 'SUPERVISOR') {
            $data = DB::table('kwitansi')
                      ->join('customer','kode','=','k_kode_customer')
                      ->get();
            
        }else{
            $cabang = Auth::user()->kode_cabang;
            $data = DB::table('kwitansi')
                      ->join('customer','kode','=','k_kode_customer')
                      ->where('k_kode_cabang',$cabang)
                      ->get();
        }

        

        return view('sales.penerimaan_penjualan.index',compact('data'));
        
    }


    public function nota_kwitansi(request $request)
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

        $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                        WHERE k_kode_cabang = '$request->cabang'
                                        AND to_char(k_tanggal,'MM') = '$bulan'
                                        AND to_char(k_tanggal,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'KWT' . $request->cabang . $bulan . $tahun . $index;

        return response()->json(['nota'=>$nota]);
    }
    public function nota_bank(request $request)

    {   if ($request->cb_jenis_pembayaran == 'C' || $request->cb_jenis_pembayaran == 'F') {
            $bulan = Carbon::now()->format('m');

            $tahun = Carbon::now()->format('y');

            $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                            WHERE k_kode_cabang = '$request->cabang'
                                            AND to_char(k_tanggal,'MM') = '$bulan'
                                            AND to_char(k_tanggal,'YY') = '$tahun'");
            $index = (integer)$cari_nota[0]->id + 1;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota = 'CRU' . $request->cabang . $bulan . $tahun . $index;

            return response()->json(['nota'=>$nota]);
        }else{
            $nota = '';
            return response()->json(['nota'=>$nota]);
        }
    }
        
    public function akun_all(request $request)
    {
        $akun = DB::table('d_akun')
                  ->where('kode_cabang',$request->cabang)
                  ->get();
        return view('sales.penerimaan_penjualan.akun_all',compact('akun'));
    }

    public function akun_biaya(request $request)
    {
        $akun = DB::table('akun_biaya')
                  ->get();
        return view('sales.penerimaan_penjualan.akun_biaya',compact('akun'));
    }

    public function akun_bank(request $request)
    {
        $akun = DB::table('masterbank')
                  ->get();
        return view('sales.penerimaan_penjualan.akun_bank',compact('akun'));
    }
    public function cari_invoice(request $request)
    {   
        $cabang       = $request->cb_cabang;
        $customer     = $request->cb_customer;
        $customer     = $request->cb_customer;
        $array_simpan = $request->array_simpan;
        $array_edit   = $request->array_edit;
        $array_harga  = $request->array_harga;

        return view('sales.penerimaan_penjualan.tabel_invoice',compact('cabang','customer','array_simpan','array_edit','array_harga'));
    }
    public function datatable_detail_invoice(request $request)
    {   
        // dd($request->all());
        // return $request->customer;
        $temp_1  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_pelunasan','!=',0)
                  ->where('i_kode_cabang',$request->cabang)
                  ->get();
        if (isset($request->array_edit)) {
            $temp_2  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->whereIn('i_nomor',$request->array_edit)
                  ->get();
            $temp   = array_merge($temp_1,$temp_2);
            $temp = array_map("unserialize", array_unique(array_map("serialize", $temp)));
            $temp = array_values($temp);
        }else{
            $temp = $temp_1;
        }
       
        

        $temp1_1  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_pelunasan','!=',0)
                  ->where('i_kode_cabang',$request->cabang)
                  ->get();

        if (isset($request->array_edit)) {
            $temp1_2  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->whereIn('i_nomor',$request->array_edit)
                  ->get();
            $temp1   = array_merge($temp1_1,$temp1_2);
            $temp1 = array_map("unserialize", array_unique(array_map("serialize", $temp1)));
            $temp1 = array_values($temp1);
        }else{
            $temp1 = $temp1_1;
        }

                  
        for ($i=0; $i < count($temp1); $i++) { 
            if ($temp1[$i]->k_nomor != null) {
                unset($temp[$i]);
            } 
        }

        $temp = array_values($temp);


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
            for ($i=0; $i < count($data); $i++) { 
                for ($a=0; $a < count($request->array_edit); $a++) { 
                    if ($request->array_edit[$a] == $data[$i]->i_nomor) {
                        $data[$i]->i_sisa_pelunasan = $data[$i]->i_sisa_pelunasan+$request->array_harga[$a];
                    }
                }
            }
        

        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('tes', function ($data) {
                                   return     '<input type="checkbox" class="child_check">';
                        })
                        ->addColumn('nomor', function ($data) {
                                return  $data->i_nomor .'<input type="hidden" class="nomor_inv" value="'. $data->i_nomor .'" >';
                        })
                        ->addColumn('i_sisa', function ($data) {

                                return number_format($data->i_sisa_pelunasan,2,',','.');
                        })
                        ->addColumn('i_tagihan', function ($data) {
                                return number_format($data->i_total_tagihan,2,',','.');
                        })
                        ->make(true);
    }

    public function append_invoice(request $request)
    {
        // dd($request->all());

        $data = DB::table('invoice')
                  ->whereIn('i_nomor',$request->nomor)
                  ->get();

        for ($i=0; $i < count($data); $i++) { 
            for ($a=0; $a < count($request->array_edit); $a++) { 
                if ($request->array_edit[$a] == $data[$i]->i_nomor) {
                    $data[$i]->i_sisa_pelunasan = $data[$i]->i_sisa_pelunasan+$request->array_harga[$a];
                }
            }
        }

        return response()->json(['data'=>$data]);
        
    }
    public function riwayat_invoice(request $request)
    {
        
        if (isset($request->id)) {
            $data = DB::table('kwitansi')
                  ->join('kwitansi_d','k_id','=','kd_id')
                  ->where('kd_nomor_invoice',$request->i_nomor)
                  ->where('k_nomor','!=',$request->id)
                  ->get();
        }else{
            $data = DB::table('kwitansi')
                  ->join('kwitansi_d','k_id','=','kd_id')
                  ->where('kd_nomor_invoice',$request->i_nomor)
                  ->get();
        }
        if ($request->cb_jenis_pembayaran != 'U') {
          return view('sales.penerimaan_penjualan.tabel_riwayat',compact('data'));
        }else{
          return view('sales.penerimaan_penjualan.tabel_riwayat1',compact('data'));
        }
    }
    public function riwayat_cn_dn(request $request)
    {
       $data = DB::table('cn_dn_penjualan')
                  ->join('cn_dn_penjualan_d','cd_id','=','cdd_id')
                  ->where('cdd_nomor_invoice',$request->i_nomor)
                  ->get();
        if ($request->cb_jenis_pembayaran != 'U') {
          return view('sales.penerimaan_penjualan.tabel_cn_dn',compact('data'));
        }else{
          return view('sales.penerimaan_penjualan.tabel_cn_dn1',compact('data'));
        } 
    }
    public function auto_biaya(request $request)
    {

        $data = DB::table('d_akun')
                  ->where('id_akun',$request->tes)
                  ->first();

        if ($data->akun_dka == 'D') {
            $data->debet = 'DEBET';
        }else{
            $data->debet = 'KREDIT';
        }

        return response()->json(['data'=>$data]);  
    }
    public function simpan_kwitansi(request $request)
    {
        return DB::transaction(function() use ($request) {  
            // dd($request->all());
        $tgl = str_replace('/', '-', $request->ed_tanggal);
        $tgl = Carbon::parse($tgl)->format('Y-m-d');

        $cari_kwitansi = DB::table('kwitansi')
                           ->where('k_nomor',$request->nota)
                           ->first();
        if ($cari_kwitansi == null) {
            $k_id = DB::table('kwitansi')
                           ->max('k_id');
            if ($k_id == null) {
                $k_id = 1;
            }else{
                $k_id += 1;
            }

            
            $save_kwitansi = DB::table('kwitansi')
                               ->insert([
                                'k_id' => $k_id,
                                'k_nomor' => $request->nota,
                                'k_tanggal'=> $tgl,
                                'k_kode_customer' => $request->customer,
                                'k_jumlah' => $request->jumlah_bayar,
                                'k_keterangan' => $request->ed_keterangan,
                                'k_create_by' => Auth::user()->m_username,
                                'k_update_by' => Auth::user()->m_username,
                                'k_create_at' => Carbon::now(),
                                'k_update_at' => Carbon::now(),
                                'k_kode_cabang' => $request->cb_cabang,
                                'k_jenis_pembayaran' => $request->cb_jenis_pembayaran,
                                'k_kredit' => $request->ed_kredit,
                                'k_debet' => $request->ed_debet,
                                'k_nota_bank' => $request->nota_bank,
                                'k_netto' => $request->ed_netto,
                                'k_kode_akun'=> $request->cb_akun_h
                               ]);
            $memorial_array = [];
            for ($i=0; $i < count($request->i_nomor); $i++) { 
                if ($request->i_bayar[$i] != 0) {
                    $cari_invoice = DB::table('invoice')
                                      ->where('i_nomor',$request->i_nomor[$i])
                                      ->first();

                    if ($request->i_biaya_admin[$i] == '') {
                        $i_biaya_admin[$i] = 0;
                    }else{
                        $i_biaya_admin[$i] = $request->i_biaya_admin[$i];
                    }
          
                    $memorial = (float)$cari_invoice->i_sisa_pelunasan - (float)$request->i_bayar[$i];

                    if ($memorial > 0) {
                       $memorial = 0;
                    }else if ($memorial<0) {
                        $memorial = $memorial * -1;
                    }

                    array_push($memorial_array, $memorial);


                    $save_detail = DB::table('kwitansi_d')
                                     ->insert([
                                          'kd_id'             => $k_id,
                                          'kd_dt'             => $i+1,
                                          'kd_k_nomor'        => $request->nota,
                                          'kd_tanggal_invoice'=> $cari_invoice->i_tanggal,
                                          'kd_nomor_invoice'  => $request->i_nomor[$i],
                                          'kd_keterangan'     => $request->i_keterangan[$i],
                                          'kd_kode_biaya'     => $request->akun_biaya[$i],
                                          'kd_total_bayar'    => $request->i_bayar[$i] ,
                                          'kd_biaya_lain'     => $i_biaya_admin[$i],
                                          'kd_memorial'       => $memorial,
                                     ]);
                    $cari_invoice = DB::table('invoice')
                                      ->where('i_nomor',$request->i_nomor[$i])
                                      ->first();
                    $hasil =  $cari_invoice->i_sisa_pelunasan - $request->i_bayar[$i];
                    // dd($hasil);

                    if ($hasil < 0) {
                        $hasil = 0;
                    }
                    
                    $update_invoice = DB::table('invoice')
                                        ->where('i_nomor',$request->i_nomor[$i])
                                        ->update([
                                            'i_sisa_pelunasan' => $hasil,
                                            'i_status'         => 'Approved',
                                        ]);
                }

            }

    

            $memorial_array = array_sum($memorial_array);
            $save_kwitansi = DB::table('kwitansi')
                               ->where('k_id',$k_id)
                               ->update([
                                'k_jumlah_memorial' => $memorial_array
                               ]);

            return response()->json(['status'=>1,'pesan'=>'data berhasil disimpan']);

        }else{
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('y');

            $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                            WHERE k_kode_cabang = '$request->cb_cabang'
                                            AND to_char(k_tanggal,'MM') = '$bulan'
                                            AND to_char(k_tanggal,'YY') = '$tahun'");
            $index = (integer)$cari_nota[0]->id + 1;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota = 'KWT' . $request->cb_cabang . $bulan . $tahun . $index;

            return response()->json(['status'=>2,'pesan'=>'no nota telah ada','nota'=>$nota]);
        }
    });

    }
    public function cari_um(request $request)
    {
        $temp_1 = DB::table('uang_muka_penjualan')
                  ->where('kode_customer',$request->cb_customer)
                  ->Where('status_um','CUSTOMER')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->where('sisa_uang_muka','!=',0)
                  ->where('nomor_posting','!=',null)
                  ->get();
        $temp_2 = DB::table('uang_muka_penjualan')
                  ->Where('status_um','NON CUSTOMER')
                  ->where('sisa_uang_muka','!=',0)
                  ->where('nomor_posting','!=',null)
                  ->get();

       
        if (isset($request->array_um)) {
            $temp_3 = DB::table('uang_muka_penjualan')
                  ->whereIn('nomor',$request->array_um)
                  ->Where('status_um','CUSTOMER')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->where('nomor_posting','!=',null)
                  ->get();
            $temp   = array_merge($temp_1,$temp_2,$temp_3);
            $temp = array_map("unserialize", array_unique(array_map("serialize", $temp)));
            $temp = array_values($temp);
        }else{
            $temp   = array_merge($temp_1,$temp_2);
            $temp = array_map("unserialize", array_unique(array_map("serialize", $temp)));
            $temp = array_values($temp);
        }
        
        $temp1_1 = DB::table('uang_muka_penjualan')
                  ->where('kode_customer',$request->cb_customer)
                  ->Where('status_um','CUSTOMER')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->where('sisa_uang_muka','!=',0)
                  ->where('nomor_posting','!=',null)
                  ->get();
        $temp1_2 = DB::table('uang_muka_penjualan')
                  ->Where('status_um','NON CUSTOMER')
                  ->where('sisa_uang_muka','!=',0)
                  ->where('nomor_posting','!=',null)
                  ->get();

        if (isset($request->array_um)) {
            $temp1_3 = DB::table('uang_muka_penjualan')
                  ->whereIn('nomor',$request->array_um)
                  ->Where('status_um','CUSTOMER')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->where('nomor_posting','!=',null)
                  ->get();
            $temp1   = array_merge($temp1_1,$temp1_2,$temp1_3);
            $temp1= array_map("unserialize", array_unique(array_map("serialize", $temp1)));
            $temp1 = array_values($temp1);
        }else{
            $temp1   = array_merge($temp1_1,$temp1_2);
            $temp1 = array_map("unserialize", array_unique(array_map("serialize", $temp1)));
            $temp1 = array_values($temp1);
        }

        if (isset($request->simpan_um)) {
            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->simpan_um); $a++) { 
                    if ($request->simpan_um[$a] == $temp1[$i]->nomor) {
                        unset($temp[$i]);
                    }
                }
            }
            $temp = array_values($temp);
            $data = $temp;
            
        }else{
            $data = $temp;
        }

        for ($i=0; $i < count($data); $i++) { 
            for ($a=0; $a < count($request->array_um); $a++) { 
                if ($request->array_um[$a] == $data[$i]->nomor) {
                    $data[$i]->sisa_uang_muka = $data[$i]->sisa_uang_muka+$request->harga_um[$a];
                }
            }
        }
        return view('sales.penerimaan_penjualan.tabel_um',compact('data'));
    }
    public function pilih_um(request $request)
    {

        $find = DB::table('kwitansi_uang_muka')
                  ->where('ku_nomor',$request->nota_kwitansi)
                  ->where('ku_nomor_invoice',$request->ed_nomor_invoice)
                  ->get();
        if ($find != null) {
          $status = 'I';
        }else{
          $status = 'E';
        }
        
        $data = DB::table('uang_muka_penjualan')
                   ->where('nomor',$request->um)
                   ->orWhere('status_um','=','NON CUSTOMER')
                   ->get();
        // for ($i=0; $i < count($data); $i++) { 
        //     for ($a=0; $a < count($request->array_um); $a++) { 
        //         if ($request->array_um[$a] == $data[$i]->nomor) {
        //             $data[$i]->sisa_uang_muka = $data[$i]->sisa_uang_muka+$request->harga_um[$a];
        //         }
        //     }
        // }

        return response()->json(['data'=>$data,'status'=>$status]);
    }

    public function hapus_kwitansi(request $request)
    {

        // dd($request->all());
      if (Auth::user()->punyaAkses('Kwitansi','hapus')) {
          return DB::transaction(function() use ($request) {  

          $cari_kwitansi = DB::table('kwitansi')
                           ->join('kwitansi_d','kd_id','=','k_id')
                           ->where('k_nomor',$request->id)
                           ->get();
          // dd($cari_kwitansi);
          
          $invoice_nomor = [];
          for ($i=0; $i < count($cari_kwitansi); $i++) {

              $cari_invoice = DB::table('invoice')
                                ->where('i_nomor',$cari_kwitansi[$i]->kd_nomor_invoice)
                                ->first();
              $net1 = $cari_kwitansi[$i]->kd_total_bayar-$cari_kwitansi[$i]->kd_memorial;

              $hasil_invoice = $cari_invoice->i_sisa_pelunasan + $net1;

              $update_invoice = DB::table('invoice')
                                   ->where('i_nomor',$cari_kwitansi[$i]->kd_nomor_invoice)
                                   ->update([
                                      'i_sisa_pelunasan'=>$hasil_invoice
                                   ]);

              array_push($invoice_nomor, $cari_kwitansi[$i]->kd_nomor_invoice);
          }


          for ($i=0; $i < count($invoice_nomor); $i++) {

            $cari_um = DB::table('kwitansi_uang_muka')
                      ->where('ku_nomor',$request->id)
                      ->where('ku_nomor_invoice',$invoice_nomor[$i])
                      ->first(); 

            if ($cari_um != null) {
              $cari_um1 = DB::table('uang_muka_penjualan')
                         ->where('nomor',$cari_um->ku_nomor_um)
                         ->first();

              $update = DB::table('uang_muka_penjualan')
                        ->where('nomor',$cari_um1->nomor)
                        ->update([
                          'sisa_uang_muka'=>$cari_um1->sisa_uang_muka+$cari_um[$i]->ku_jumlah
                        ]);
            }

          }

          $cari_um = DB::table('kwitansi_uang_muka')
                      ->where('ku_nomor',$request->nota)
                      ->delete();



          $hapus = DB::table('kwitansi')
                      ->where('k_nomor',$request->id)
                      ->delete();

          for ($i=0; $i < count($invoice_nomor); $i++) { 
              $cari_kwitansi = DB::table('kwitansi')
                           ->join('kwitansi_d','kd_id','=','k_id')
                           ->where('kd_nomor_invoice',$invoice_nomor[$i])
                           ->get();
              
              if (count($cari_kwitansi) == 0) {
                  $update_invoice = DB::table('invoice')
                                   ->where('i_nomor',$invoice_nomor[$i])
                                   ->update([
                                      'i_status'=> 'Released',
                                   ]);
              }

          }

          return response()->json(['status'=> 1]);

        });
      }else{
          return response()->json(['status'=> 2]);
      }
    }
    public function edit_kwitansi($id)
    {
        $comp = Auth::user()->kode_cabang;
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $akun = DB::table('d_akun')
                  ->get();


        $tgl  = Carbon::now()->format('d/m/Y');

        $data = DB::table('kwitansi')
                  ->where('k_nomor',$id)
                  ->first();

        $data_dt = DB::table('kwitansi')
                     ->join('kwitansi_d','kd_id','=','k_id')
                     ->join('invoice','i_nomor','=','kd_nomor_invoice')
                     ->where('k_nomor',$id)
                     ->get();
        $data_bl = DB::table('kwitansi')
                     ->join('kwitansi_biaya_d','kb_id','=','k_id')
                     ->join('d_akun','id_akun','=','kb_kode_akun')
                     ->where('k_nomor',$id)
                     ->get();    

        $data_um = DB::table('kwitansi')
                     ->join('kwitansi_uang_muka','ku_id','=','k_id')
                     ->join('uang_muka_penjualan','nomor','=','ku_nomor_um')
                     ->where('k_nomor',$id)
                     ->get();  
        $akun_bank = DB::table('masterbank')
                  ->get();   

        return view('sales.penerimaan_penjualan.edit_kwitansi',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','akun_bank','akun','tgl','id','data_dt','data_bl','data_um'));
    }
    public function detail_kwitansi($id)
    {
        $comp = Auth::user()->kode_cabang;
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $akun = DB::table('d_akun')
                  ->get();


        $tgl  = Carbon::now()->format('d/m/Y');

        $data = DB::table('kwitansi')
                  ->where('k_nomor',$id)
                  ->first();

        $data_dt = DB::table('kwitansi')
                     ->join('kwitansi_d','kd_id','=','k_id')
                     ->join('invoice','i_nomor','=','kd_nomor_invoice')
                     ->where('k_nomor',$id)
                     ->get();
        $data_bl = DB::table('kwitansi')
                     ->join('kwitansi_biaya_d','kb_id','=','k_id')
                     ->join('d_akun','id_akun','=','kb_kode_akun')
                     ->where('k_nomor',$id)
                     ->get();    

        $data_um = DB::table('kwitansi')
                     ->join('kwitansi_uang_muka','ku_id','=','k_id')
                     ->join('uang_muka_penjualan','nomor','=','ku_nomor_um')
                     ->where('k_nomor',$id)
                     ->get();  
        $akun_bank = DB::table('masterbank')
                  ->get();   

        return view('sales.penerimaan_penjualan.detail_kwitansi',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','akun_bank','akun','tgl','id','data_dt','data_bl','data_um'));
    }

    public function update_kwitansi(request $request)
    {
        // dd($request->all());

        $this->hapus_kwitansi($request);
        return $this->simpan_kwitansi($request);
    }

    public function hapus_um_kwitansi(request $request)
    { 
      return DB::transaction(function() use ($request) { 
            // dd($request->all());
        
        if ($request->flag_nota == '0' or $request->flag_nota == '0' or $request->flag_nota == '') {
          if (isset($request->flag)) {
            if ($request->flag == 'R') {
              for ($i=0; $i < count($request->i_nomor); $i++) { 

               $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->i_nomor[$i])
                          ->get(); 

                if ($cari_um !=null) 
                {
                  for ($a=0; $a < count($cari_um); $a++) { 
                    $cari_um1 = DB::table('uang_muka_penjualan')
                               ->where('nomor',$cari_um[$a]->ku_nomor_um)
                               ->first();

                    $update = DB::table('uang_muka_penjualan')
                              ->where('nomor',$cari_um1->nomor)
                              ->update([
                                'sisa_uang_muka'=>$cari_um1->sisa_uang_muka+$cari_um[$a]->ku_jumlah
                              ]);
                  }
                }

               $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->i_nomor[$i])
                          ->delete();
              }

            }else{

              if ($request->flag == 'H') {
              for ($i=0; $i < count($request->i_nomor); $i++) { 

               $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->i_nomor)
                          ->get(); 

                if ($cari_um !=null) 
                {
                  for ($a=0; $a < count($cari_um); $a++) { 
                    $cari_um1 = DB::table('uang_muka_penjualan')
                               ->where('nomor',$cari_um[$a]->ku_nomor_um)
                               ->first();

                    $update = DB::table('uang_muka_penjualan')
                              ->where('nomor',$cari_um1->nomor)
                              ->update([
                                'sisa_uang_muka'=>$cari_um1->sisa_uang_muka+$cari_um[$a]->ku_jumlah
                              ]);
                  }
                }

               $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->i_nomor)
                          ->delete();
              }
            }
          }
          }else{
            $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->ed_nomor_invoice)
                          ->get();
              for ($i=0; $i < count($cari_um); $i++) { 
                $cari_um1 = DB::table('uang_muka_penjualan')
                             ->where('nomor',$cari_um[$i]->ku_nomor_um)
                             ->first();

                $update = DB::table('uang_muka_penjualan')
                            ->where('nomor',$cari_um1->nomor)
                            ->update([
                              'sisa_uang_muka'=>$cari_um1->sisa_uang_muka+$cari_um[$i]->ku_jumlah
                            ]);
              }

               $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->ed_nomor_invoice)
                          ->delete();
          }
        }
    });
        
    }

    public function save_um_kwitansi(request $request)
    {



      return DB::transaction(function() use ($request) {  


      $this->hapus_um_kwitansi($request);

        for ($i=0; $i < count($request->m_no_um); $i++) { 
          $cari_um = DB::table('uang_muka_penjualan')
                     ->where('nomor',$request->m_no_um[$i])
                     ->first();
          $id = DB::table('kwitansi_uang_muka')
                  ->max('ku_id');
          if ($id == null) {
            $id = 1;
          }else{
            $id+=1;
          }
          $save = DB::table('kwitansi_uang_muka')
                  ->insert([
                      'ku_nomor'           => $request->nota,
                      'ku_id'              => $id,
                      'ku_nomor_invoice'   => $request->ed_nomor_invoice,
                      'ku_kode_akun_acc'   => $cari_um->kode_acc,
                      'ku_kode_akun_csf'   => $cari_um->kode_csf,
                      'ku_jumlah'          => $request->m_jumlah_bayar_um[$i],
                      'ku_status_um'       => $cari_um->status_um,
                      // 'ku_keterangan'      => ,
                      // 'ku_debet'           => ,
                      // 'ku_kredit'          => ,
                      'ku_nomor_um'        => $request->m_no_um[$i],
                  ]);

          $update = DB::table('uang_muka_penjualan')
                     ->where('nomor',$request->m_no_um[$i])
                     ->update([
                      'sisa_uang_muka'=>$cari_um->sisa_uang_muka - $request->m_jumlah_bayar_um[$i]
                     ]);
        }

        return response()->json(['status'=>1]);
      });
    }

    public function kwitansi_cari_um(request $request)
    {
      
      $data = DB::table('kwitansi_uang_muka')
                ->join('uang_muka_penjualan','nomor','=','ku_nomor_um')
                ->where('ku_nomor',$request->nota_kwitansi)
                ->where('ku_nomor_invoice',$request->i_nomor)
                ->get();

      return response()->json(['data' => $data]);
    }

}
