<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;
use App\d_jurnal;
use App\d_jurnal_dt;
use Response;
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
                  ->where('penanda','KWITANSI')
                  ->get();

       
        $akun_bank = DB::table('masterbank')
                  ->get();

        $tgl  = Carbon::now()->format('d/m/Y');
       
        return view('sales.penerimaan_penjualan.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','kas_bank','akun','tgl','akun_biaya','akun_bank','akun_biaya_all'));
    }


    public function index()
    {
        if (Auth::user()->punyaAkses('Kwitansi','all')) {
            $data = DB::table('kwitansi')
                      ->join('customer','kode','=','k_kode_customer')
                      ->take(2000)
                      ->orderBy('k_tanggal','DESC')
                      ->get();
            
        }else{
            $cabang = Auth::user()->kode_cabang;
            $data = DB::table('kwitansi')
                      ->join('customer','kode','=','k_kode_customer')
                      ->where('k_kode_cabang',$cabang)
                      ->orderBy('k_tanggal','DESC')
                      ->take(2000)
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
                                        AND to_char(k_create_at,'MM') = '$bulan'
                                        AND to_char(k_create_at,'YY') = '$tahun'");
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
                                            AND to_char(k_create_at,'MM') = '$bulan'
                                            AND to_char(k_create_at,'YY') = '$tahun'");
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
                  ->where('penanda','KWITANSI')
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
        $jenis_tarif  = $request->jenis_tarif;
        if (isset($request->id)) {
          $id         = $request->id;
        }else{
          $id         = 0;
        }

        return view('sales.penerimaan_penjualan.tabel_invoice',compact('cabang','customer','array_simpan','array_edit','array_harga','id','jenis_tarif'));
    }
    public function datatable_detail_invoice(request $request)
    {   
        // return $request->customer;

      // dd($request->all());
      if (Auth::user()->punyaAkses('Kwitansi','cabang')) {
        $temp_1  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_statusprint','Printed')
                  ->where('i_sisa_akhir','!=',0)
                  // ->where('i_kode_cabang',$request->cabang)
                  ->where('i_pendapatan',$request->jenis_tarif)
                  ->orWhere('k_nomor',$request->id)
                  ->get();
      }else{
        $temp_1  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_akhir','!=',0)
                  ->where('i_statusprint','Printed')
                  ->where('i_kode_cabang',$request->cabang)
                  ->where('i_pendapatan',$request->jenis_tarif)
                  ->orWhere('k_nomor',$request->id)
                  ->get();
      }
       

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
        

        if (Auth::user()->punyaAkses('Kwitansi','cabang')) {
          $temp1_1  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_statusprint','Printed')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_akhir','!=',0)
                  // ->where('i_kode_cabang',$request->cabang)
                  ->get();
        }else{
          $temp1_1  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_statusprint','Printed')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_akhir','!=',0)
                  ->where('i_kode_cabang',$request->cabang)
                  ->get();
        }

      

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
        
        // return $data;
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

                                return number_format($data->i_sisa_akhir,2,',','.');
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
                    $data[$i]->i_sisa_pelunasan = $data[$i]->i_sisa_akhir+$request->array_harga[$a];
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
                  ->where('k_nomor','!=',$request->nota_kwitansi)
                  ->get();
        }else{
            $data = DB::table('kwitansi')
                  ->join('kwitansi_d','k_id','=','kd_id')
                  ->where('kd_nomor_invoice',$request->i_nomor)
                  ->where('k_nomor','!=',$request->nota_kwitansi)
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
          $tgl = str_replace('/', '-', $request->ed_tanggal);
          $tgl = Carbon::parse($tgl)->format('Y-m-d');

          $cari_kwitansi = DB::table('kwitansi')
                             ->where('k_nomor',$request->nota)
                             ->first();


          $k_id = DB::table('kwitansi')
                         ->max('k_id');
          if ($k_id == null) {
              $k_id = 1;
          }else{
              $k_id += 1;
          }


          $user = Auth::user()->m_name;
          if (Auth::user()->m_name == null) {
            return response()->json([
              'status'=>0,
              'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
            ]);
          }

          $cari_nota = DB::table('kwitansi')
                   ->where('k_nomor',$request->nota)
                   ->first();
                   
          if ($cari_nota != null) {
            if ($cari_nota->k_update_by == $user) {
              return 'Data Sudah Ada';
            }else{
              $bulan = Carbon::now()->format('m');

              $tahun = Carbon::now()->format('y');

              $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                              WHERE k_kode_cabang = '$request->cabang'
                                              AND to_char(k_create_at,'MM') = '$bulan'
                                              AND to_char(k_create_at,'YY') = '$tahun'");
              $index = (integer)$cari_nota[0]->id + 1;
              $index = str_pad($index, 5, '0', STR_PAD_LEFT);
              $nota = 'KWT' . $request->cabang . $bulan . $tahun . $index;

            }
          }elseif ($cari_nota == null) {
            $nota = $request->nota;
          }

            
          $save_kwitansi = DB::table('kwitansi')
                             ->insert([
                              'k_id' => $k_id,
                              'k_nomor' => $nota,
                              'k_tanggal'=> $tgl,
                              'k_jenis_tarif'=> $request->jenis_tarif,
                              'k_kode_customer' => $request->customer,
                              'k_jumlah' => $request->jumlah_bayar,
                              'k_keterangan' => $request->ed_keterangan,
                              'k_create_by' => Auth::user()->m_name,
                              'k_update_by' => Auth::user()->m_name,
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

          // $save_kwitansi = DB::table('kwitansi')
          //                     ->where('k_nomor',$nota)
          //                     ->get();
          $del = DB::table('kwitansi_uang_muka')
                  ->where('ku_keterangan','OLD')
                  ->delete();
          $memorial_array = [];
          for ($i=0; $i < count($request->i_nomor); $i++) { 
              // dd($request->all());
              if ($request->i_bayar[$i] != 0) {

                $cari_invoice = DB::table('invoice')
                                  ->where('i_nomor',$request->i_nomor[$i])
                                  ->first();

                if ($request->akun_biaya[$i] == '') {
                    $i_biaya_admin = 0;

                }else{
                    $i_biaya_admin = $request->akun_biaya[$i];
                }

                if ($i_biaya_admin == 'B3') {
                  $memorial = $request->i_kredit[$i];
                  array_push($memorial_array, $request->i_kredit[$i]);
                }else{
                  $memorial = 0;
                }
                // dd($memorial);

                $save_detail = DB::table('kwitansi_d')
                                   ->insert([
                                        'kd_id'             => $k_id,
                                        'kd_dt'             => $i+1,
                                        'kd_k_nomor'        => $nota,
                                        'kd_tanggal_invoice'=> $cari_invoice->i_tanggal,
                                        'kd_nomor_invoice'  => $request->i_nomor[$i],
                                        'kd_keterangan'     => $request->i_keterangan[$i],
                                        'kd_kode_biaya'     => $request->akun_biaya[$i],
                                        'kd_total_bayar'    => $request->i_tot_bayar[$i] ,
                                        'kd_biaya_lain'     => 0,
                                        'kd_memorial'       => $memorial,
                                        'kd_kode_akun_acc'  => $cari_invoice->i_acc_piutang,
                                        'kd_kode_akun_csf'  => $cari_invoice->i_csf_piutang,
                                        'kd_debet'          => $request->i_debet[$i],
                                        'kd_kredit'         => $request->i_kredit[$i],
                                   ]);

                $kwitansi_d = DB::table('kwitansi_d')
                                ->where('kd_id',$k_id)
                                ->get();
                $i_sisa_pelunasan = $cari_invoice->i_sisa_pelunasan - $request->i_tot_bayar[$i] ;
                $i_sisa_akhir = $cari_invoice->i_sisa_akhir - $request->i_tot_bayar[$i] ;

                // dd($i_sisa_akhir);
                $update_invoice = DB::table('invoice')
                                    ->where('i_nomor',$request->i_nomor[$i])
                                    ->update([
                                      'i_sisa_pelunasan' => $i_sisa_pelunasan,
                                      'i_sisa_akhir' => $i_sisa_akhir,
                                      'i_status' => 'Approved',
                                    ]);
              }
          }
          // $cari_kwitansi = DB::table('invoice')
          //                    ->whereIn('i_nomor',$request->i_nomor)
          //                    ->get();
    
          // dd($cari_kwitansi);

          $memorial_array = array_sum($memorial_array);

          $save_kwitansi = DB::table('kwitansi')
                             ->where('k_id',$k_id)
                             ->update([
                              'k_jumlah_memorial' => $memorial_array
                             ]);

          $save_kwitansi = DB::table('kwitansi')
                              ->where('k_nomor',$nota)
                              ->get();

          // JURNAL
          if ($request->cb_jenis_pembayaran == 'T' or $request->cb_jenis_pembayaran == 'C' or $request->cb_jenis_pembayaran == 'U') {
            $id_jurnal=d_jurnal::max('jr_id')+1;
            $delete = d_jurnal::where('jr_ref',$nota)->delete();
            $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                          'jr_year'   => carbon::parse($tgl)->format('Y'),
                          'jr_date'   => carbon::parse($tgl)->format('Y-m-d'),
                          'jr_detail' => 'KWITANSI ' . $request->jenis_tarif,
                          'jr_ref'    => $nota,
                          'jr_note'   => 'KWITANSI',
                          'jr_insert' => carbon::now(),
                          'jr_update' => carbon::now(),
                          ]);
          }

          // PIUTANG DAN UANG MUKA
          if ($request->cb_jenis_pembayaran == 'U') {
            $cari_uang_muka = DB::table('kwitansi_uang_muka')
                                ->where('ku_nomor',$nota)
                                ->get();
            for ($i=0; $i < count($cari_uang_muka); $i++) { 
              if ($cari_uang_muka[$i]->ku_kode_akun_acc == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Invoice Yang Tidak Memiliki Akun Piutang']);
              }
              $akun_temp[$i]  = $cari_uang_muka[$i]->ku_kode_akun_acc;
              $akun_value[$i] = $cari_uang_muka[$i]->ku_jumlah;
            } 
            $akun_temp_fix = array_unique($akun_temp);
            $akun_temp_total = [];
            for ($i=0; $i < count($akun_temp_fix); $i++) { 
              for ($a=0; $a < count($akun_temp); $a++) { 
                if ($akun_temp_fix[$i] == $akun_temp[$a]) {
                  if (!isset($akun_temp_total[$i])) {
                    $akun_temp_total[$i] = 0;
                  }
                  $akun_temp_total[$i] += $akun_value[$a];
                }
              }
            }
          }else if($request->cb_jenis_pembayaran == 'T' or $request->cb_jenis_pembayaran == 'C'){
            $akun_temp_total = [];
            for ($i=0; $i < count($request->i_nomor); $i++) { 
              $cari_akun = DB::table('invoice')
                             ->where('i_nomor',$request->i_nomor[$i])
                             ->first();
              if ($cari_akun->i_acc_piutang == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Invoice Yang Tidak Memiliki Akun Piutang']);
              }
              $akun_temp[$i] = $cari_akun->i_acc_piutang;
            } 
            $akun_temp_fix = array_unique($akun_temp);
            $akun_temp_total = [];

            for ($i=0; $i < count($akun_temp_fix); $i++) { 
              for ($a=0; $a < count($akun_temp); $a++) { 
                if ($akun_temp_fix[$i] == $akun_temp[$a]) {
                  if (!isset($akun_temp_total[$i])) {
                    $akun_temp_total[$i] = 0;
                  }
                  $akun_temp_total[$i] += $request->i_tot_bayar[$a];
                }
              }
            }
          }

          // BIAYA
          $akun_temp_biaya = [];
          for ($i=0; $i < count($request->akun_biaya); $i++) { 
            if ($request->akun_biaya[$i] != '0') {
              $cari_akun = DB::table('akun_biaya')
                           ->where('kode',$request->akun_biaya[$i])
                           ->first();
              if ($cari_akun->acc_biaya == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Biaya Yang Tidak Memiliki Akun']);
              }
              $akun_temp_biaya[$i]   = $cari_akun->acc_biaya;
              $akun_temp_penanda[$i] = $request->akun_biaya[$i];
            }else{
              $akun_temp_biaya[$i]   = '0';
              $akun_temp_penanda[$i] = '0';
            }
          } 
          if (isset($akun_temp_biaya)) {
            $akun_temp_fix_penanda = array_unique($akun_temp_penanda);
            $akun_temp_fix_penanda = array_values($akun_temp_fix_penanda);
            $akun_temp_biaya       = array_values($akun_temp_biaya);
            $akun_temp_total_biaya = [];
            $akun_temp_fix_biaya = [];


            for ($i=0; $i < count($akun_temp_fix_penanda); $i++) { 
              
              for ($a=0; $a < count($request->akun_biaya); $a++) { 
             
                if ($akun_temp_fix_penanda[$i] == $request->akun_biaya[$a]) {
                  $akun_temp_fix_biaya[$i] = $akun_temp_biaya[$a];
                  if (!isset($akun_temp_total_biaya[$i])) {
                    $akun_temp_total_biaya[$i] = 0;
                  }
                  $akun_temp_total_biaya[$i] += $request->i_debet[$a];
                  $akun_temp_total_biaya[$i] += $request->i_kredit[$a];
                }
              }
            }
          }
          // dd($akun_temp_total_biaya);


          $akun = [];
          $akun_val = [];
          $akun_penanda = [];
          if ($request->cb_jenis_pembayaran == 'U') {
            for ($i=0; $i < count($request->i_nomor); $i++) { 
              $cari_akun_um = DB::table('invoice')
                             ->where('i_nomor',$request->i_nomor[$i])
                             ->first();
              if ($cari_akun_um->i_acc_piutang == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Invoice Yang Tidak Memiliki Akun Piutang']);
              }
              $akun_temp_um[$i] = $cari_akun_um ->i_acc_piutang;
            } 
            $akun_temp_fix_um = array_unique($akun_temp_um);
            $akun_temp_um_total = [];

            for ($i=0; $i < count($akun_temp_fix_um); $i++) { 
              for ($a=0; $a < count($akun_temp_um); $a++) { 
                if ($akun_temp_fix_um[$i] == $akun_temp_um[$a]) {
                  if (!isset($akun_temp_um_total[$i])) {
                    $akun_temp_um_total[$i] = 0;
                  }
                  $akun_temp_um_total[$i] += $request->i_tot_bayar[$a];
                }
              }
            }
            for ($i=0; $i < count($akun_temp_fix_um); $i++) { 
              array_push($akun, $akun_temp_fix_um[$i]);
              array_push($akun_val, $akun_temp_um_total[$i]);
              array_push($akun_penanda,'none');
            }

          }else{
            $cari_akun = DB::table('d_akun')
                         ->where('id_akun','LIKE', substr($request->cb_akun_h,0, 4).'%')
                         ->where('kode_cabang',$request->cb_cabang)
                         ->first();
            array_push($akun, $cari_akun->id_akun);
            array_push($akun_val, (float)$request->jumlah_bayar);
            array_push($akun_penanda,'none');
          }
          // dd($akun_temp_total);
          

          for ($i=0; $i < count($akun_temp_fix); $i++) { 
            array_push($akun, $akun_temp_fix[$i]);
            array_push($akun_val, $akun_temp_total[$i]);
            array_push($akun_penanda,'none');
          }

          for ($i=0; $i < count($akun_temp_fix_biaya); $i++) { 
            if ($akun_temp_fix_biaya[$i] != '0') {
              $cari_akun = DB::table('d_akun')
                         ->where('id_akun','LIKE', $akun_temp_fix_biaya[$i].'%')
                         ->where('kode_cabang',$request->cb_cabang)
                         ->first();
              array_push($akun, $cari_akun->id_akun);
              array_push($akun_val, $akun_temp_total_biaya[$i]);
            }
          }
          $penanda = array_merge($akun_penanda,$akun_temp_fix_penanda);
          for ($i=0; $i < count($penanda); $i++) { 
            if ($penanda[$i] != '0') {
              $penanda_fix[$i] = $penanda[$i];
            }
          }
          $penanda_fix = array_values($penanda_fix);
          
          $data_akun = [];
          for ($i=0; $i < count($akun); $i++) { 

            $cari_coa = DB::table('d_akun')
                      ->where('id_akun',$akun[$i])
                      ->first();

            if (substr($akun[$i],0, 2)==11 or substr($akun[$i],0, 2)==10) {
              
              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 2)==13) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2103) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 1)>=5) {
              if ($penanda_fix[$i] == 'B3') {
                if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = 'M';
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = 'M';
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }
              }else{
                if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }
              }
            }
          }
          if ($request->cb_jenis_pembayaran == 'T' or $request->cb_jenis_pembayaran == 'C' or $request->cb_jenis_pembayaran == 'U') {
            $jurnal_dt = d_jurnal_dt::insert($data_akun);
          }
          $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
          // dd($lihat);
  
          return response()->json(['status'=>1,'pesan'=>'data berhasil disimpan']);
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
          // MENGEMBALIKAN UPDATE INVOICE
          $cari_kwitansi_d = DB::table('kwitansi_d')
                            ->where('kd_k_nomor',$request->nota)
                            ->get();
          $invoice_nomor = [];
          for ($i=0; $i < count($cari_kwitansi_d); $i++) { 
            $cari_invoice = DB::table('invoice')
                              ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                              ->first();
            
            $i_sisa_pelunasan = $cari_invoice->i_sisa_pelunasan + $cari_kwitansi_d[$i]->kd_total_bayar;
            $i_sisa_akhir = $cari_invoice->i_sisa_akhir + $cari_kwitansi_d[$i]->kd_total_bayar;


            $update_invoice = DB::table('invoice')
                                    ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                                    ->update([
                                      'i_sisa_pelunasan' => $i_sisa_pelunasan,
                                      'i_sisa_akhir' => $i_sisa_akhir,
                                    ]);

            $ckd = DB::table('kwitansi_d')
                            ->where('kd_nomor_invoice',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                            ->get();
            if ($ckd == null) {
              $update_invoice = DB::table('invoice')
                                    ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                                    ->update([
                                      'i_status' => 'Released',
                                    ]);
            }
            $cari_invoice = DB::table('invoice')
                              ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                              ->first();
            array_push($invoice_nomor, $cari_kwitansi_d[$i]->kd_nomor_invoice);
          }


          if (isset($request->flag_nota)) {
            if ($request->flag_nota == 'H') {
              for ($i=0; $i < count($invoice_nomor); $i++) { 
                $cari_kwitansi_um = DB::table('kwitansi_uang_muka')
                                      ->where('ku_nomor_invoice',$invoice_nomor[$i])
                                      ->where('ku_nomor',$request->nota)
                                      ->get();
                for ($a=0; $a < count($cari_kwitansi_um); $a++) { 
                  $cari_um = DB::table('uang_muka_penjualan')
                               ->where('nomor',$cari_kwitansi_um[$a]->ku_nomor_um)
                               ->first();
                  $hasil = $cari_um->sisa_uang_muka+$cari_kwitansi_um[$a]->ku_jumlah;

                  $update = DB::table('uang_muka_penjualan')
                               ->where('nomor',$cari_kwitansi_um[$a]->ku_nomor_um)
                               ->update([
                                'sisa_uang_muka'=>$hasil
                               ]);
                }
                $cari_kwitansi_um = DB::table('kwitansi_uang_muka')
                                      ->where('ku_nomor_invoice',$invoice_nomor[$i])
                                      ->where('ku_nomor',$request->nota)
                                      ->delete();
              }
            }
          }


          $cari_um_kwitansi = DB::table('uang_muka_penjualan')
                                ->where('ref',$request->nota)
                                ->delete();


          $delete = d_jurnal::where('jr_ref',$request->nota)->delete();

          $hapus = DB::table('kwitansi')
                      ->where('k_nomor',$request->nota)
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
        $customer = DB::select(" SELECT kode,nama,cabang FROM customer ORDER BY nama ASC ");

        $akun = DB::table('d_akun')
                  ->get();

        $akun_biaya = DB::table('akun_biaya')
                  ->get();

        $akun_bank = DB::table('masterbank')
                  ->get();

        $data = DB::table('kwitansi')
                  ->where('k_nomor',$id)
                  ->first();

        $data_dt = DB::table('kwitansi')
                     ->join('kwitansi_d','kd_id','=','k_id')
                     ->join('invoice','i_nomor','=','kd_nomor_invoice')
                     ->where('k_nomor',$id)
                     ->get();
        
        $akun_bank = DB::table('masterbank')
                  ->get();  


        $del = DB::table('kwitansi_uang_muka')
                  ->where('ku_nomor',$data->k_nomor)
                  ->where('ku_keterangan','=','OLD')
                  ->delete();

        for ($i=0; $i < count($data_dt); $i++) { 
          $cari_um = DB::table('kwitansi_uang_muka')
                     ->where('ku_nomor',$data_dt[$i]->k_nomor)
                     ->where('ku_nomor_invoice',$data_dt[$i]->kd_nomor_invoice)
                     ->get();
          for ($a=0; $a < count($cari_um); $a++) { 
            $id_kum = DB::table('kwitansi_uang_muka')
                  ->max('ku_id');
            if ($id_kum == null) {
              $id_kum = 1;
            }else{
              $id_kum+=1;
            }
            $save = DB::table('kwitansi_uang_muka')
                  ->insert([
                      'ku_nomor'           => $cari_um[$a]->ku_nomor,
                      'ku_id'              => $id_kum,
                      'ku_nomor_invoice'   => $cari_um[$a]->ku_nomor_invoice,
                      'ku_kode_akun_acc'   => $cari_um[$a]->ku_kode_akun_acc,
                      'ku_kode_akun_csf'   => $cari_um[$a]->ku_kode_akun_csf,
                      'ku_jumlah'          => $cari_um[$a]->ku_jumlah,
                      'ku_status_um'       => $cari_um[$a]->ku_status_um,
                      'ku_keterangan'      => 'OLD',
                      // 'ku_debet'           => ,
                      // 'ku_kredit'          => ,
                      'ku_nomor_um'        => $cari_um[$a]->ku_nomor_um,
                  ]);
          }
        }
        return view('sales.penerimaan_penjualan.edit_kwitansi',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','akun_bank','akun','tgl','id','data_dt','akun_biaya','data_um'));
    }
    public function detail_kwitansi($id)
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

        $data = DB::table('kwitansi')
                  ->where('k_nomor',$id)
                  ->first();

        $data_dt = DB::table('kwitansi')
                     ->join('kwitansi_d','kd_id','=','k_id')
                     ->join('invoice','i_nomor','=','kd_nomor_invoice')
                     ->where('k_nomor',$id)
                     ->get();
        
        $akun_bank = DB::table('masterbank')
                  ->get();   

        return view('sales.penerimaan_penjualan.detail_kwitansi',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','akun_bank','akun','tgl','id','data_dt','akun_biaya','data_um'));
    }

    public function update_kwitansi(request $request)
    {
      return DB::transaction(function() use ($request) { 
          $tgl = str_replace('/', '-', $request->ed_tanggal);
          $tgl = Carbon::parse($tgl)->format('Y-m-d');

          $cari_kwitansi = DB::table('kwitansi')
                             ->where('k_nomor',$request->nota)
                             ->first();



          $cari_nota = DB::table('kwitansi')
                   ->where('k_nomor',$request->nota)
                   ->first();
                   
          $k_id = $cari_nota->k_id;
          $nota = $request->nota;
            
          $save_kwitansi = DB::table('kwitansi')
                             ->where('k_nomor',$nota)
                             ->update([
                              'k_nomor' => $nota,
                              'k_tanggal'=> $tgl,
                              'k_jenis_tarif'=> $request->jenis_tarif,
                              'k_kode_customer' => $request->customer,
                              'k_jumlah' => $request->jumlah_bayar,
                              'k_keterangan' => $request->ed_keterangan,
                              'k_create_by' => Auth::user()->m_name,
                              'k_update_by' => Auth::user()->m_name,
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

          $del = DB::table('kwitansi_uang_muka')
                  ->where('ku_keterangan','OLD')
                  ->delete();

          // MENGEMBALIKAN UPDATE INVOICE
          $cari_kwitansi_d = DB::table('kwitansi_d')
                            ->where('kd_k_nomor',$nota)
                            ->get();

          for ($i=0; $i < count($cari_kwitansi_d); $i++) { 
            $cari_invoice = DB::table('invoice')
                              ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                              ->first();
            
            $i_sisa_pelunasan = $cari_invoice->i_sisa_pelunasan + $cari_kwitansi_d[$i]->kd_total_bayar;
            $i_sisa_akhir = $cari_invoice->i_sisa_akhir + $cari_kwitansi_d[$i]->kd_total_bayar;


            $update_invoice = DB::table('invoice')
                                    ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                                    ->update([
                                      'i_sisa_pelunasan' => $i_sisa_pelunasan,
                                      'i_sisa_akhir' => $i_sisa_akhir,
                                    ]);

            $ckd = DB::table('kwitansi_d')
                            ->where('kd_nomor_invoice',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                            ->get();
            if ($ckd == null) {
              $update_invoice = DB::table('invoice')
                                    ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                                    ->update([
                                      'i_status' => 'Released',
                                    ]);
            }
            $cari_invoice = DB::table('invoice')
                              ->where('i_nomor',$cari_kwitansi_d[$i]->kd_nomor_invoice)
                              ->first();

            
          }

          $cari_invoice = DB::table('invoice')
                              ->whereIn('i_nomor',$request->i_nomor)
                              ->get();

          $cari_kwitansi_d = DB::table('kwitansi_d')
                            ->where('kd_k_nomor',$nota)
                            ->delete();


          $memorial_array = [];
          for ($i=0; $i < count($request->i_nomor); $i++) { 
            
              // dd($request->all());
              if ($request->i_bayar[$i] != 0) {

                $cari_invoice = DB::table('invoice')
                                  ->where('i_nomor',$request->i_nomor[$i])
                                  ->first();

                if ($request->akun_biaya[$i] == '') {
                    $i_biaya_admin = 0;

                }else{
                    $i_biaya_admin = $request->akun_biaya[$i];
                }

                if ($i_biaya_admin == 'B3') {
                  $memorial = $request->i_kredit[$i];
                  array_push($memorial_array, $request->i_kredit[$i]);
                }else{
                  $memorial = 0;
                }
                // dd($memorial);

                $save_detail = DB::table('kwitansi_d')
                                   ->insert([
                                        'kd_id'             => $k_id,
                                        'kd_dt'             => $i+1,
                                        'kd_k_nomor'        => $nota,
                                        'kd_tanggal_invoice'=> $cari_invoice->i_tanggal,
                                        'kd_nomor_invoice'  => $request->i_nomor[$i],
                                        'kd_keterangan'     => $request->i_keterangan[$i],
                                        'kd_kode_biaya'     => $request->akun_biaya[$i],
                                        'kd_total_bayar'    => $request->i_tot_bayar[$i] ,
                                        'kd_biaya_lain'     => 0,
                                        'kd_memorial'       => $memorial,
                                        'kd_kode_akun_acc'  => $cari_invoice->i_acc_piutang,
                                        'kd_kode_akun_csf'  => $cari_invoice->i_csf_piutang,
                                        'kd_debet'          => $request->i_debet[$i],
                                        'kd_kredit'         => $request->i_kredit[$i],
                                   ]);

                $kwitansi_d = DB::table('kwitansi_d')
                                ->where('kd_id',$k_id)
                                ->get();
                $i_sisa_pelunasan = $cari_invoice->i_sisa_pelunasan - $request->i_tot_bayar[$i] ;
                $i_sisa_akhir = $cari_invoice->i_sisa_akhir - $request->i_tot_bayar[$i] ;

                // dd($i_sisa_akhir);
                $update_invoice = DB::table('invoice')
                                    ->where('i_nomor',$request->i_nomor[$i])
                                    ->update([
                                      'i_sisa_pelunasan' => $i_sisa_pelunasan,
                                      'i_sisa_akhir' => $i_sisa_akhir,
                                    ]);
              }
          }
          // $cari_kwitansi = DB::table('invoice')
          //                    ->whereIn('i_nomor',$request->i_nomor)
          //                    ->get();
    
          // dd($cari_kwitansi);

          $memorial_array = array_sum($memorial_array);

          $save_kwitansi = DB::table('kwitansi')
                             ->where('k_id',$k_id)
                             ->update([
                              'k_jumlah_memorial' => $memorial_array
                             ]);

          $save_kwitansi = DB::table('kwitansi')
                              ->where('k_nomor',$nota)
                              ->get();

          // JURNAL
          if ($request->cb_jenis_pembayaran == 'T' or $request->cb_jenis_pembayaran == 'C' or $request->cb_jenis_pembayaran == 'U') {
            $id_jurnal=d_jurnal::max('jr_id')+1;
            $delete = d_jurnal::where('jr_ref',$nota)->delete();
            $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                          'jr_year'   => carbon::parse($tgl)->format('Y'),
                          'jr_date'   => carbon::parse($tgl)->format('Y-m-d'),
                          'jr_detail' => 'KWITANSI ' . $request->jenis_tarif,
                          'jr_ref'    => $nota,
                          'jr_note'   => 'KWITANSI',
                          'jr_insert' => carbon::now(),
                          'jr_update' => carbon::now(),
                          ]);
          }

          // PIUTANG DAN UANG MUKA
          if ($request->cb_jenis_pembayaran == 'U') {
            $cari_uang_muka = DB::table('kwitansi_uang_muka')
                                ->where('ku_nomor',$nota)
                                ->get();
            for ($i=0; $i < count($cari_uang_muka); $i++) { 
              if ($cari_uang_muka[$i]->ku_kode_akun_acc == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Invoice Yang Tidak Memiliki Akun Piutang']);
              }
              $akun_temp[$i]  = $cari_uang_muka[$i]->ku_kode_akun_acc;
              $akun_value[$i] = $cari_uang_muka[$i]->ku_jumlah;
            } 
            $akun_temp_fix = array_unique($akun_temp);
            $akun_temp_total = [];
            for ($i=0; $i < count($akun_temp_fix); $i++) { 
              for ($a=0; $a < count($akun_temp); $a++) { 
                if ($akun_temp_fix[$i] == $akun_temp[$a]) {
                  if (!isset($akun_temp_total[$i])) {
                    $akun_temp_total[$i] = 0;
                  }
                  $akun_temp_total[$i] += $akun_value[$a];
                }
              }
            }
          }else if($request->cb_jenis_pembayaran == 'T' or $request->cb_jenis_pembayaran == 'C'){
            $akun_temp_total = [];
            for ($i=0; $i < count($request->i_nomor); $i++) { 
              $cari_akun = DB::table('invoice')
                             ->where('i_nomor',$request->i_nomor[$i])
                             ->first();
              if ($cari_akun->i_acc_piutang == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Invoice Yang Tidak Memiliki Akun Piutang']);
              }
              $akun_temp[$i] = $cari_akun->i_acc_piutang;
            } 
            $akun_temp_fix = array_unique($akun_temp);
            $akun_temp_total = [];

            for ($i=0; $i < count($akun_temp_fix); $i++) { 
              for ($a=0; $a < count($akun_temp); $a++) { 
                if ($akun_temp_fix[$i] == $akun_temp[$a]) {
                  if (!isset($akun_temp_total[$i])) {
                    $akun_temp_total[$i] = 0;
                  }
                  $akun_temp_total[$i] += $request->i_tot_bayar[$a];
                }
              }
            }
          }

          // BIAYA
          $akun_temp_biaya = [];
          for ($i=0; $i < count($request->akun_biaya); $i++) { 
            if ($request->akun_biaya[$i] != '0') {
              $cari_akun = DB::table('akun_biaya')
                           ->where('kode',$request->akun_biaya[$i])
                           ->first();
              if ($cari_akun->acc_biaya == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Biaya Yang Tidak Memiliki Akun']);
              }
              $akun_temp_biaya[$i]   = $cari_akun->acc_biaya;
              $akun_temp_penanda[$i] = $request->akun_biaya[$i];
            }else{
              $akun_temp_biaya[$i]   = '0';
              $akun_temp_penanda[$i] = '0';
            }
          } 
          if (isset($akun_temp_biaya)) {
            $akun_temp_fix_penanda = array_unique($akun_temp_penanda);
            $akun_temp_fix_penanda = array_values($akun_temp_fix_penanda);
            $akun_temp_biaya       = array_values($akun_temp_biaya);
            $akun_temp_total_biaya = [];
            $akun_temp_fix_biaya = [];


            for ($i=0; $i < count($akun_temp_fix_penanda); $i++) { 
              
              for ($a=0; $a < count($request->akun_biaya); $a++) { 
             
                if ($akun_temp_fix_penanda[$i] == $request->akun_biaya[$a]) {
                  $akun_temp_fix_biaya[$i] = $akun_temp_biaya[$a];
                  if (!isset($akun_temp_total_biaya[$i])) {
                    $akun_temp_total_biaya[$i] = 0;
                  }
                  $akun_temp_total_biaya[$i] += $request->i_debet[$a];
                  $akun_temp_total_biaya[$i] += $request->i_kredit[$a];
                }
              }
            }
          }
          // dd($akun_temp_total_biaya);


          $akun = [];
          $akun_val = [];
          $akun_penanda = [];
          if ($request->cb_jenis_pembayaran == 'U') {
            for ($i=0; $i < count($request->i_nomor); $i++) { 
              $cari_akun_um = DB::table('invoice')
                             ->where('i_nomor',$request->i_nomor[$i])
                             ->first();
              if ($cari_akun_um->i_acc_piutang == null) {
                return response()->json(['status'=>0,'pesan'=>'Terdapat Invoice Yang Tidak Memiliki Akun Piutang']);
              }
              $akun_temp_um[$i] = $cari_akun_um ->i_acc_piutang;
            } 
            $akun_temp_fix_um = array_unique($akun_temp_um);
            $akun_temp_um_total = [];

            for ($i=0; $i < count($akun_temp_fix_um); $i++) { 
              for ($a=0; $a < count($akun_temp_um); $a++) { 
                if ($akun_temp_fix_um[$i] == $akun_temp_um[$a]) {
                  if (!isset($akun_temp_um_total[$i])) {
                    $akun_temp_um_total[$i] = 0;
                  }
                  $akun_temp_um_total[$i] += $request->i_tot_bayar[$a];
                }
              }
            }
            for ($i=0; $i < count($akun_temp_fix_um); $i++) { 
              array_push($akun, $akun_temp_fix_um[$i]);
              array_push($akun_val, $akun_temp_um_total[$i]);
              array_push($akun_penanda,'none');
            }

          }else{
            $cari_akun = DB::table('d_akun')
                         ->where('id_akun','LIKE', substr($request->cb_akun_h,0, 4).'%')
                         ->where('kode_cabang',$request->cb_cabang)
                         ->first();
            array_push($akun, $cari_akun->id_akun);
            array_push($akun_val, (float)$request->jumlah_bayar);
            array_push($akun_penanda,'none');
          }
          // dd($akun_temp_total);
          

          for ($i=0; $i < count($akun_temp_fix); $i++) { 
            array_push($akun, $akun_temp_fix[$i]);
            array_push($akun_val, $akun_temp_total[$i]);
            array_push($akun_penanda,'none');
          }

          for ($i=0; $i < count($akun_temp_fix_biaya); $i++) { 
            if ($akun_temp_fix_biaya[$i] != '0') {
              $cari_akun = DB::table('d_akun')
                         ->where('id_akun','LIKE', $akun_temp_fix_biaya[$i].'%')
                         ->where('kode_cabang',$request->cb_cabang)
                         ->first();
              array_push($akun, $cari_akun->id_akun);
              array_push($akun_val, $akun_temp_total_biaya[$i]);
            }
          }
          $penanda = array_merge($akun_penanda,$akun_temp_fix_penanda);
          for ($i=0; $i < count($penanda); $i++) { 
            if ($penanda[$i] != '0') {
              $penanda_fix[$i] = $penanda[$i];
            }
          }
          $penanda_fix = array_values($penanda_fix);
          
          $data_akun = [];
          for ($i=0; $i < count($akun); $i++) { 

            $cari_coa = DB::table('d_akun')
                      ->where('id_akun',$akun[$i])
                      ->first();

            if (substr($akun[$i],0, 2)==11 or substr($akun[$i],0, 2)==10) {
              
              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 2)==13) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 4)==2103) {

              if ($cari_coa->akun_dka == 'D') {
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'K';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }else{
                $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                $data_akun[$i]['jrdt_detailid'] = $i+1;
                $data_akun[$i]['jrdt_acc']      = $akun[$i];
                $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                $data_akun[$i]['jrdt_statusdk'] = 'D';
                $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
              }
            }else if (substr($akun[$i],0, 1)>=5) {
              if ($penanda_fix[$i] == 'B3') {
                if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = 'M';
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = $akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = 'M';
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }
              }else{
                if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = -$akun_val[$i];
                  $data_akun[$i]['jrdt_type']     = null;
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
                  $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                }
              }
            }
          }

          if ($request->cb_jenis_pembayaran == 'T' or $request->cb_jenis_pembayaran == 'C' or $request->cb_jenis_pembayaran == 'U') {
            $jurnal_dt = d_jurnal_dt::insert($data_akun);
          }
          $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();

          // dd($lihat);
          return response()->json(['status'=>1,'pesan'=>'data berhasil disimpan']);
      });
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

            }elseif ($request->flag == 'H'){

              for ($i=0; $i < count($request->i_nomor); $i++) { 

               $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->i_nomor)
                          ->where('ku_keterangan',null)
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
                          ->where('ku_keterangan',null)
                          ->delete();
              }
            }elseif ($request->flag == 'RE'){

              for ($i=0; $i < count($request->i_nomor); $i++) { 
                  $cari_kwitansi_um = DB::table('kwitansi_uang_muka')
                                        ->where('ku_keterangan',null)
                                        ->where('ku_nomor_invoice',$request->i_nomor[$i])
                                        ->where('ku_nomor',$request->nota)
                                        ->get();
                  for ($a=0; $a < count($cari_kwitansi_um); $a++) {

                      $cari_um = DB::table('uang_muka_penjualan')
                                   ->where('nomor',$cari_kwitansi_um[$a]->ku_nomor_um)
                                   ->first();
                      $hasil   = $cari_um->sisa_uang_muka + $cari_kwitansi_um[$a]->ku_jumlah;


                      $update  = DB::table('uang_muka_penjualan')
                                   ->where('nomor',$cari_kwitansi_um[$a]->ku_nomor_um)
                                   ->update([
                                    'sisa_uang_muka'=>$hasil
                                   ]);

                  }



                  $cari_kwitansi_um = DB::table('kwitansi_uang_muka')
                                        ->where('ku_nomor_invoice',$request->i_nomor[$i])
                                        ->where('ku_nomor',$request->nota)
                                        ->where('ku_keterangan',null)
                                        ->delete();
              }


              $cari_invoice = DB::table('kwitansi_d')
                                        ->where('kd_k_nomor',$request->nota)
                                        ->get();
             
              for ($i=0; $i < count($cari_invoice); $i++) { 

                $cari_kwitansi_um1 = DB::table('kwitansi_uang_muka')
                                        ->where('ku_nomor',$request->nota)
                                        ->where('ku_keterangan','OLD')
                                        ->where('ku_nomor_invoice',$cari_invoice[$i]->kd_nomor_invoice)
                                        ->get();

                for ($a=0; $a < count($cari_kwitansi_um1); $a++) { 

                  $cari_um1 = DB::table('uang_muka_penjualan')
                                   ->where('nomor',$cari_kwitansi_um1[$a]->ku_nomor_um)
                                   ->first();

                  $hasil   = $cari_um1->sisa_uang_muka - $cari_kwitansi_um1[$a]->ku_jumlah;


                  $update  = DB::table('uang_muka_penjualan')
                                   ->where('nomor',$cari_kwitansi_um1[$a]->ku_nomor_um)
                                   ->update([
                                    'sisa_uang_muka'=>$hasil
                                   ]);

                  $update = DB::table('kwitansi_uang_muka')
                                        ->where('ku_id',$cari_kwitansi_um1[$a]->ku_id)
                                        ->update([
                                          'ku_keterangan'=>null
                                        ]);

                }

              }
              
              

              return json_encode('berhasil');



            }

          }else{

            $cari_um = DB::table('kwitansi_uang_muka')
                          ->where('ku_nomor',$request->nota)
                          ->where('ku_nomor_invoice',$request->ed_nomor_invoice)
                          ->where('ku_keterangan',null)
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
                          ->where('ku_keterangan',null)
                          ->delete();
          }
        }
    });
        
    }

    public function save_um_kwitansi(request $request)
    {

      return DB::transaction(function() use ($request) {  

      $this->hapus_um_kwitansi($request);
        // dd('cari_um');
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
                ->where('ku_keterangan','=',null)
                ->where('ku_nomor_invoice',$request->i_nomor)
                ->get();

      return response()->json(['data' => $data]);
    }

    public function simpan_um_sementara(request $request)
    {
      $data = DB::table('uang_muka_penjualan')
                ->where('kode_customer',$request->customer)
                ->where('kode_cabang',$request->cabang)
                ->get();
      return Response::json(['data'=>$data]);
    }


    public function jurnal(request $req)
    {

      $data = DB::table('d_jurnal')
               ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
               ->join('d_akun','jrdt_acc','=','id_akun')
               ->where('jr_ref',$req->id)
               ->get();


      $d = [];
      $k = [];

      for ($i=0; $i < count($data); $i++) { 
        if ($data[$i]->jrdt_value < 0) {
          $data[$i]->jrdt_value *= -1;
        }
      }

      for ($i=0; $i < count($data); $i++) { 
        if ($data[$i]->jrdt_statusdk == 'D') {
          $d[$i] = $data[$i]->jrdt_value;
        }elseif ($data[$i]->jrdt_statusdk == 'K') {
          $k[$i] = $data[$i]->jrdt_value;
        }
      }
      $d = array_values($d);
      $k = array_values($k);

      $d = array_sum($d);
      $k = array_sum($k);

      return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
    }

}
