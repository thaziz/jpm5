<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use App\d_jurnal;
use App\d_jurnal_dt;
use Yajra\Datatables\Datatables;
use Exception;
class posting_pembayaran_Controller extends Controller
{
    public function datatable_posting (Request $request) {
        $cabang = auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Posting Pembayaran','all')) {
            $data = DB::table('posting_pembayaran')
                      ->join('cabang','kode','=','kode_cabang')
                      ->get();
        }else{
            $data = DB::table('posting_pembayaran')
                      ->join('cabang','kode','=','kode_cabang')
                      ->where('kode_cabang',$cabang)
                      ->get();
        }

        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {

                            $a = '';
                            $b = '';
                            $c = '';
                          
                            if(Auth::user()->punyaAkses('Posting Pembayaran','ubah')){
                                if(cek_periode(carbon::parse($data->tanggal)->format('m'),carbon::parse($data->tanggal)->format('Y') ) != 0){
                                  $a = '<button type="button" onclick="edit(\''.$data->nomor.'\')" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></button>';
                                }
                            }else{
                              $a = '';
                            }

                            if(Auth::user()->punyaAkses('Posting Pembayaran','print')){
                                $b = '<button type="button" onclick="ngeprint(\''.$data->nomor.'\')" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></button>';
                            }else{
                              $b = '';
                            }


                            if(Auth::user()->punyaAkses('Posting Pembayaran','hapus')){
                                if(cek_periode(carbon::parse($data->tanggal)->format('m'),carbon::parse($data->tanggal)->format('Y') ) != 0){
                                  $c = '<button type="button" onclick="hapus(\''.$data->nomor.'\')" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button>';
                                }
                            }else{
                              $c = '';
                            }
                            return $a . $b .$c  ;
                                   
                        })
                        ->addColumn('jumlah_text', function ($data) {
                          return number_format($data->jumlah,2,',','.'  ); 
                        })
                        
                        ->addColumn('pembayaran', function ($data) {
                          if ($data->jenis_pembayaran == 'C') {
                              $a = 'TRANSFER';
                          }
                          if ($data->jenis_pembayaran == 'T') {
                              $a = 'TUNAI/KWITANSI';
                          }
                          if ($data->jenis_pembayaran == 'L') {
                              $a = 'LAIN-LAIN';
                          }
                          if ($data->jenis_pembayaran == 'F') {
                              $a = 'CHEQUIE/BG';
                          }
                          if ($data->jenis_pembayaran == 'B') {
                              $a = 'NOTA/BIAYA LAIN';
                          }
                          if ($data->jenis_pembayaran == 'U') {
                              $a = 'UANG MUKA/DP';
                          }
                          return '<label class="label label-warning">'.$a.'</label>';
                        })
                        ->addIndexColumn()
                        ->make(true);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('posting_pembayaran')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('posting_pembayaran_d')->where('id', $id)->first();
        echo json_encode($data);
    }


    public function hapus_data($nomor_posting_pembayaran=null){
        DB::beginTransaction();
		$list = DB::table('posting_pembayaran_d')->get();
        foreach ($list as $row) {
        	DB::select(" UPDATE penerimaan_penjualan SET posting=FALSE WHERE nomor='$row->nomor_penerimaan_penjualan' ");
        }
        DB::table('posting_pembayaran_d')->where('nomor_posting_pembayaran' ,'=', $nomor_posting_pembayaran)->delete();
        DB::table('posting_pembayaran')->where('nomor' ,'=', $nomor_posting_pembayaran)->delete();
        DB::commit();
        return redirect('sales/posting_pembayaran');
    }

    public function save_data_detail (Request $request) {
        $simpan='';
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_penerimaan_penjualan);
        try {
            DB::beginTransaction();
            
            for ($i=0; $i < $hitung; $i++) {
                $nomor_penerimaan_penjualan = strtoupper($request->nomor_penerimaan_penjualan[$i]);
                $jumlah = filter_var($request->jumlah[$i], FILTER_SANITIZE_NUMBER_INT);
                if ($jumlah != 0 || $jumlah == '') {
                    $data = array(
                        'nomor_posting_pembayaran' => $nomor,
                        'nomor_penerimaan_penjualan' => $nomor_penerimaan_penjualan,
                        'jumlah' => $jumlah,
                    );
                    DB::table('posting_pembayaran_d')->insert($data);
                    DB::select(" UPDATE penerimaan_penjualan SET posting=TRUE WHERE nomor='$nomor_penerimaan_penjualan' ");
                }
                
            } 
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM posting_pembayaran_d 
                                                WHERE nomor_posting_pembayaran='$nomor' "))->first();
            $data_h = array(
                        'jumlah' => $jml_detail->ttl_jumlah,
            );
        
            $simpan = DB::table('posting_pembayaran')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");    
        }
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor=$request->nomor;
        $nomor_penerimaan_penjualan = $request->nomor_penerimaan_penjualan;
        try {
            DB::beginTransaction();
            DB::select(" UPDATE penerimaan_penjualan SET posting=FALSE WHERE nomor='$nomor_penerimaan_penjualan' ");
            DB::table('posting_pembayaran_d')->where('id' ,'=', $id)->delete();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM posting_pembayaran_d 
                                                WHERE nomor_posting_pembayaran='$nomor' "))->first();
            $data_h = array(
                    'jumlah' => $jml_detail->ttl_jumlah,
            );
            DB::table('posting_pembayaran')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
        }
        
        echo json_encode($result);
    }

    public function index(){
        $cabang = Auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Kwitansi','all')) {
            $data  = DB::table('posting_pembayaran')
                      ->take(2000)
                      ->get();
        }else{
            $data  = DB::table('posting_pembayaran')
                      ->where('kode_cabang',$cabang)
                      ->take(2000)
                      ->get();
        }
        return view('sales.posting_pembayaran.index',compact('data'));
    }



    public function form($nomor=null){  
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer order by kode ASC");
        $akun     = DB::table('masterbank')
                      ->get();
        if ($nomor != null) {
            $data = DB::table('posting_pembayaran')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM posting_pembayaran_d WHERE nomor_posting_pembayaran='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.posting_pembayaran.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','akun' ));
    }

    public function tampil_penerimaan_penjualan(Request $request) {
        $jenis_pembayaran = $request->jenis_pembayaran;
        $kode_cabang = $request->kode_cabang;
        $sql = "    SELECT nomor,tanggal,jumlah FROM penerimaan_penjualan
                    where posting=FALSE  AND jenis_pembayaran='$jenis_pembayaran' AND kode_cabang='$kode_cabang' ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <input type="checkbox" id="'.$data[$i]['nomor'].'" class="btnpilih" tabindex="-1" > 
                                    <input type="hidden"  id="ed_jumlah_'.$data[$i]['nomor'].'" value="'.$data[$i]['jumlah'].'"> ';         
            // 
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);

    }

    public function nomor_posting(request $request)
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from posting_pembayaran
                                        WHERE kode_cabang = '$request->cabang'
                                        AND to_char(tanggal,'MM') = '$bulan'
                                        AND to_char(tanggal,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'BM' . $request->cabang . $bulan . $tahun . $index;

        return response()->json(['nota'=>$nota]);

    }

    public function cari_kwitansi(request $request)
    {
        if ($request->cb_jenis_pembayaran != 'T') {

          $akun_bank = DB::table("masterbank")
                       ->where('mb_id',$request->akun_bank)
                       ->first();

          $temp = DB::table('kwitansi')
                    ->where('k_kode_cabang',$request->cabang)
                    ->where('k_nomor_posting','=',null)
                    ->where('k_jenis_pembayaran',$request->cb_jenis_pembayaran)
                    ->where('k_id_bank',$request->akun_bank)
                    ->get();

          $temp1 = $temp;

          $kwitansi_edit = DB::table('kwitansi')
                            ->whereIn('k_nomor',$request->nomor)
                            ->get();
          $temp = array_merge($temp,$kwitansi_edit);
          $temp1 = array_merge($temp1,$kwitansi_edit);
          $temp = array_values($temp);
          $temp1 = array_values($temp1);

          if (isset($request->array_simpan)) {

              for ($i=0; $i < count($temp1); $i++) { 
                  for ($a=0; $a < count($request->array_simpan); $a++) { 
                      if ($request->array_simpan[$a] == $temp1[$i]->k_nomor) {
                          unset($temp[$i]);
                      }
                      
                  }
              }
              $temp = array_values($temp);
              $data = $temp;
              
          }else{

              $data = $temp;
          }

        }else{
          $kwitansi = DB::table('kwitansi')
                    ->select('k_nomor','k_tanggal','k_netto')
                    ->where('k_kode_cabang',$request->cabang)
                    ->where('k_nomor_posting','=',null)
                    ->where('k_jenis_pembayaran',$request->cb_jenis_pembayaran)
                    ->get();

          $do = DB::table('delivery_order')
                    ->select('nomor as k_nomor','tanggal as k_tanggal','total_net as k_netto')
                    ->join('d_jurnal','nomor','=','jr_ref')
                    ->where('kode_cabang',$request->cabang)
                    ->where('posting','=',null)
                    ->get();

          $kwitansi_edit = DB::table('kwitansi')
                            ->select('k_nomor','k_nomor','k_netto')
                            ->whereIn('k_nomor',$request->nomor)
                            ->get();

          $do_edit = DB::table('delivery_order')
                            ->select('nomor as k_nomor','tanggal as k_tanggal','total_net as k_netto')
                            ->whereIn('nomor',$request->nomor)
                            ->get();

          $temp = array_merge($kwitansi,$do,$kwitansi_edit,$do_edit);

          $temp1 = $temp;

          if (isset($request->array_simpan)) {

              for ($i=0; $i < count($temp1); $i++) { 
                  for ($a=0; $a < count($request->array_simpan); $a++) { 
                      if ($request->array_simpan[$a] == $temp1[$i]->k_nomor) {
                          unset($temp[$i]);
                      }
                      
                  }
              }
              $temp = array_values($temp);
              $data = $temp;
              
          }else{

              $data = $temp;
          }
        }
        return view('sales.posting_pembayaran.table_kwitansi',compact('data'));
    }   

    public function cari_uang_muka(request $request)
    {
        $data = DB::table('uang_muka_penjualan')
                  ->where('kode_cabang',$request->cabang)
                  ->where('id_bank',$request->akun_bank)
                  ->where('nomor_posting',null)
                  ->get();
        return view('sales.posting_pembayaran.table_uang_muka',compact('data'));
    }
    public function append(request $request)
    {   
        // return $request->sall();
        if ($request->cb_jenis_pembayaran != 'U') {

            for ($i=0; $i < count($request->tanggal); $i++) { 
              if (strtotime($request->tanggal[$i]) > strtotime($request->ed_tanggal)) {
                return response()->json(['status'=>'0']);
              }
            }

            $kw = DB::table('kwitansi')
                      ->join('customer','kode','=','k_kode_customer')
                      ->select('k_nomor','k_tanggal','k_netto','nama')
                      ->whereIn('k_nomor',$request->nomor)
                      ->get();

            $do = DB::table('delivery_order')
                      ->join('customer','kode','=','kode_customer')
                      ->select('nomor as k_nomor','tanggal as k_tanggal','total_net as k_netto','nama')
                      ->whereIn('nomor',$request->nomor)
                      ->get();

            $data = array_merge($kw,$do);
            return response()->json(['status'=>'1','data'=>$data]);
        }else{

            $data = DB::table('uang_muka_penjualan')
                  ->join('customer','kode','=','kode_customer')
                  ->whereIn('nomor',$request->nomor)
                  ->get();


            return response()->json(['status'=>'1','data'=>$data]);
        }
       
    }
    public function simpan_posting(request $request)
    {
        return DB::transaction(function() use ($request) {  


            $akun        = DB::table('masterbank')
                             ->where('mb_id',$request->akun_bank)
                             ->first();

            $user = Auth::user()->m_name;
            if (Auth::user()->m_name == null) {
                return response()->json([
                  'status'=>0,
                  'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
                ]);
            }

            $cari_nota = DB::table('posting_pembayaran')
                              ->where('nomor',$request->nomor_posting)
                              ->first();

            if ($cari_nota != null) {
                if ($cari_nota->nomor == $user) {
                  return 'Data Sudah Ada';
                }else{
                  
                    $bulan = Carbon::now()->format('m');
                    $tahun = Carbon::now()->format('y');

                    $cari_nota = DB::select("SELECT  substring(max(nomor),8) as id from posting_pembayaran
                                                    WHERE kode_cabang = '$request->cabang'
                                                    AND to_char(create_at,'MM') = '$bulan'
                                                    AND to_char(create_at,'YY') = '$tahun'");
                    $index = (integer)$cari_nota[0]->id + 1;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota = 'BM' . $request->cabang . $bulan . $tahun . $index;

                }
            }elseif ($cari_nota == null) {
                $nota = $request->nomor_posting;
            }


            $save_posting = DB::table('posting_pembayaran')
                              ->insert([
                                  'nomor' =>$nota,
                                  'tanggal' =>$request->ed_tanggal,
                                  'nomor_cek' =>$request->nomor_cek,
                                  'kode_akun_kredit' => $akun->mb_kode,
                                  'kode_akun_debet' => $akun->mb_kode,
                                  'jumlah' => $request->ed_jumlah,
                                  'keterangan' =>  $request->ed_keterangan,
                                  'create_by' => Auth::user()->m_name,
                                  'update_by' => Auth::user()->m_name ,
                                  'create_at' => Carbon::now(),
                                  'update_at' => Carbon::now(),
                                  'jenis_pembayaran' => $request->cb_jenis_pembayaran,
                                  'kode_cabang' => $request->cb_cabang
                              ]);



            for ($i=0; $i < count($request->d_nomor_kwitansi); $i++) { 



                $id = DB::table('posting_pembayaran_d')
                        ->max('id');
                if ($id == null) {
                    $id = 1;
                }else{
                    $id += 1;
                }

                $save_detail = DB::table('posting_pembayaran_d')
                                 ->insert([
                                    'id' => $id,
                                    'nomor_posting_pembayaran' =>$nota,
                                    'nomor_penerimaan_penjualan'=>$request->d_nomor_kwitansi[$i],
                                    'jumlah' =>$request->d_netto[$i],
                                    'create_by' =>Auth::user()->m_username,
                                    'create_at' =>Carbon::now(),
                                    'update_by'=>Auth::user()->m_username,
                                    'update_at'=> Carbon::now(),
                                    'kode_customer'=> $request->d_customer[$i],
                                    'keterangan'=> $request->d_keterangan[$i],
                                    'kode_acc'=> $request->d_kode_akun[$i],
                                    'kode_csf'=> $request->d_kode_akun[$i],
                                    'nomor_cek' => $request->d_cek[$i]
                                 ]);

                if ($request->cb_jenis_pembayaran != 'U') {


                    $update_kwitansi = DB::table('kwitansi')
                                         ->where('k_nomor',$request->d_nomor_kwitansi[$i])
                                         ->update([
                                            'k_nomor_posting'   => $request->nomor_posting,
                                            'k_tgl_posting'     => $request->ed_tanggal,
                                         ]);

                    $update_kwitansi = DB::table('delivery_order')
                                         ->where('nomor',$request->d_nomor_kwitansi[$i])
                                         ->update([
                                            'posting'             => $request->nomor_posting,
                                            'tanggal_posting'     => $request->ed_tanggal,
                                         ]);
                }else{
                    $update_kwitansi = DB::table('uang_muka_penjualan')
                                         ->where('nomor',$request->d_nomor_kwitansi[$i])
                                         ->update([
                                            'nomor_posting'   => $request->nomor_posting,
                                            'tgl_posting'     => $request->ed_tanggal,
                                            'status'          => 'Approved',
                                         ]);
                }
            }


            // JURNAL
            
            ////////// JURNAL PEMBAYARAN CHEQUE/BG DAN TRANSFER
            if ($request->cb_jenis_pembayaran == 'F' or $request->cb_jenis_pembayaran == 'C') {

                $bank = 'BM'.$request->akun_bank;

                $km =  get_id_jurnal($bank, $request->cb_cabang);




                $id_jurnal=d_jurnal::max('jr_id')+1;
                $delete = d_jurnal::where('jr_ref',$nota)->delete();
                $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                              'jr_year'   => carbon::parse($request->ed_tanggal)->format('Y'),
                              'jr_date'   => carbon::parse($request->ed_tanggal)->format('Y-m-d'),
                              'jr_detail' => 'POSTING PEMBAYARAN ' . $request->cb_jenis_pembayaran,
                              'jr_ref'    => $nota,
                              'jr_note'   => 'POSTING PEMBAYARAN '.$request->ed_keterangan,
                              'jr_insert' => carbon::now(),
                              'jr_update' => carbon::now(),
                              'jr_no'     => $km,
                              ]);
                $temp_akun_piutang = [];
                $temp_nominal_piutang = [];
                $biaya = [];
                $debet = [];
                $kredit = [];

                for ($i=0; $i < count($request->d_nomor_kwitansi); $i++) { 
                    $kwitansi = DB::table('kwitansi_d')
                                  ->where('kd_k_nomor',$request->d_nomor_kwitansi[$i])
                                  ->get();
          
                    for ($c=0; $c < count($kwitansi); $c++) { 
                      array_push($biaya, $kwitansi[$c]->kd_kode_biaya);
                      array_push($debet, $kwitansi[$c]->kd_debet);
                      array_push($kredit,$kwitansi[$c]->kd_kredit);
                      array_push($temp_akun_piutang, $kwitansi[$c]->kd_kode_akun_acc);
                      array_push($temp_nominal_piutang, $kwitansi[$c]->kd_total_bayar);
                    }
                    
                    
                }
                $fix_akun_piutang = array_unique($temp_akun_piutang);
            
                $fix_nominal_akun = [];
                for ($i=0; $i < count($fix_akun_piutang); $i++) { 
                    for ($a=0; $a < count($temp_akun_piutang); $a++) { 
                        if ($fix_akun_piutang[$i] == $temp_akun_piutang[$a]) {
                            if (!isset($fix_nominal_akun[$i])) {
                                $fix_nominal_akun[$i] = 0;
                            }
                            $fix_nominal_akun[$i] += $temp_nominal_piutang[$a];
                        }
                    }
                }


                // BIAYA
                $akun_temp_biaya = [];
                for ($i=0; $i < count($biaya); $i++) { 
                  if ($biaya[$i] != '0') {
                    $cari_akun = DB::table('akun_biaya')
                                 ->where('kode',$biaya[$i])
                                 ->first();
                    if ($cari_akun->acc_biaya == null) {
                      return response()->json(['status'=>0,'pesan'=>'Terdapat Biaya Yang Tidak Memiliki Akun']);
                    }
                    $akun_temp_biaya[$i]   = $cari_akun->acc_biaya;
                    $akun_temp_penanda[$i] = $biaya[$i];
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
                    
                    for ($a=0; $a < count($biaya); $a++) { 
                   
                      if ($akun_temp_fix_penanda[$i] == $biaya[$a]) {
                        $akun_temp_fix_biaya[$i] = $akun_temp_biaya[$a];
                        if (!isset($akun_temp_total_biaya[$i])) {
                          $akun_temp_total_biaya[$i] = 0;
                        }
                        $akun_temp_total_biaya[$i] += $debet[$a];
                        $akun_temp_total_biaya[$i] += $kredit[$a];
                      }
                    }
                  }
                }

                $master_bank        = DB::table('masterbank')
                                         ->where('mb_id',$request->akun_bank)
                                         ->first();

                $akun = [];
                $akun_val = [];

                
                // if ($request->cb_jenis_pembayaran == 'F') {
                array_push($akun, $master_bank->mb_kode);
                array_push($akun_val, $request->ed_jumlah);
                // }else{
                //   $cari_akun = DB::table('d_akun')
                //                ->where('id_akun','LIKE','2498%')
                //                ->where('kode_cabang',$request->cb_cabang)
                //                ->first();

                //   array_push($akun, $cari_akun->id_akun);
                //   array_push($akun_val, $request->ed_jumlah);
                // }        
                

                for ($i=0; $i < count($fix_akun_piutang); $i++) { 
                    array_push($akun, $fix_akun_piutang[$i]);
                    array_push($akun_val, $fix_nominal_akun[$i]);
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
                $data_akun = [];
                for ($i=0; $i < count($akun); $i++) { 

                    $cari_coa = DB::table('d_akun')
                            ->where('id_akun',$akun[$i])
                            ->first();

                    if (substr($akun[$i],0, 4)==1001 or substr($akun[$i],0, 4)==1003 or substr($akun[$i],0, 4)==1099 or substr($akun[$i],0, 2)==11) {
                    
                        if ($cari_coa->akun_dka == 'D') {
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'D';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }else{
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'K';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }
                    }if (substr($akun[$i],0, 4)==2498) {
                    
                        if ($cari_coa->akun_dka == 'D') {
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'K';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }else{
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'D';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }
                    }else if (substr($akun[$i],0, 2)==13) {
                        if ($cari_coa->akun_dka == 'D') {
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'K';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }else{
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'D';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }
                    }
                }
            }elseif($request->cb_jenis_pembayaran == 'T'){

                $bank = 'BM'.$request->akun_bank;

                $km =  get_id_jurnal($bank, $request->cb_cabang);

                $id_jurnal=d_jurnal::max('jr_id')+1;
                $delete = d_jurnal::where('jr_ref',$nota)->delete();
                $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                              'jr_year'   => carbon::parse($request->ed_tanggal)->format('Y'),
                              'jr_date'   => carbon::parse($request->ed_tanggal)->format('Y-m-d'),
                              'jr_detail' => 'POSTING PEMBAYARAN ' . $request->cb_jenis_pembayaran,
                              'jr_ref'    => $nota,
                              'jr_note'   => 'POSTING PEMBAYARAN '. strtoupper($request->ed_keterangan),
                              'jr_insert' => carbon::now(),
                              'jr_update' => carbon::now(),
                              'jr_no'     => $km,
                              ]);
                $temp_akun_piutang = [];
                $temp_nominal_piutang = [];
                for ($i=0; $i < count($request->d_nomor_kwitansi); $i++) { 
                    $kwitansi = DB::table('kwitansi')
                                  ->where('k_nomor',$request->d_nomor_kwitansi[$i])
                                  ->first();

                    $do = DB::table('delivery_order')
                                  ->where('nomor',$request->d_nomor_kwitansi[$i])
                                  ->first();
                    try{
                      array_push($temp_akun_piutang, $kwitansi->k_kode_akun);
                      array_push($temp_nominal_piutang, $kwitansi->k_netto);
                    }catch(Exception $e){

                    }
                    
                    try{
                      array_push($temp_akun_piutang, $do->acc_piutang_do);
                      array_push($temp_nominal_piutang, $do->total_net);
                    }catch(Exception $e){
                      
                    }

                    
                    
                }
                $fix_akun_piutang = array_unique($temp_akun_piutang);
                $fix_nominal_akun = [];
                for ($i=0; $i < count($fix_akun_piutang); $i++) { 
                    for ($a=0; $a < count($temp_akun_piutang); $a++) { 
                        if ($fix_akun_piutang[$i] == $temp_akun_piutang[$a]) {
                            if (!isset($fix_nominal_akun[$i])) {
                                $fix_nominal_akun[$i] = 0;
                            }
                            $fix_nominal_akun[$i] += $temp_nominal_piutang[$a];
                        }
                    }
                }

                $master_bank        = DB::table('masterbank')
                                         ->where('mb_id',$request->akun_bank)
                                         ->first();

                $akun = [];
                $akun_val = [];
                array_push($akun, $master_bank->mb_kode);
                array_push($akun_val, $request->ed_jumlah);

                for ($i=0; $i < count($fix_akun_piutang); $i++) { 
                    array_push($akun, $fix_akun_piutang[$i]);
                    array_push($akun_val, $fix_nominal_akun[$i]);
                }

                $data_akun = [];
                for ($i=0; $i < count($akun); $i++) { 

                    $cari_coa = DB::table('d_akun')
                            ->where('id_akun',$akun[$i])
                            ->first();

                    if ($i == 0) {
                        if ($cari_coa->akun_dka == 'D') {
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'D';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }else{
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'K';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }
                    }else{

                        if ($cari_coa->akun_dka == 'D') {
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'K';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }else{
                            $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                            $data_akun[$i]['jrdt_detailid'] = $i+1;
                            $data_akun[$i]['jrdt_acc']      = $akun[$i];
                            $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                            $data_akun[$i]['jrdt_type']     = null;
                            $data_akun[$i]['jrdt_statusdk'] = 'D';
                            $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
                        }
                    }
                }
            }

            if ($request->cb_jenis_pembayaran == 'F' or $request->cb_jenis_pembayaran == 'C' or $request->cb_jenis_pembayaran == 'T') {
                $jurnal_dt = d_jurnal_dt::insert($data_akun);
                $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
            }
            return response()->json(['status'=>1,'pesan'=>'data berhasil disimpan']);

            
        });
    }
    
    public function posting_pembayaran_hapus(request $request)
    {
        // dd($request->all());
        $cari_detail = DB::table('posting_pembayaran_d')
                         ->where('nomor_posting_pembayaran',$request->id)
                         ->get(); 

        for ($i=0; $i < count($cari_detail); $i++) { 
            $update = DB::table('kwitansi')
                        ->where('k_nomor',$cari_detail[$i]->nomor_penerimaan_penjualan)
                        ->update([
                            'k_nomor_posting' => null,
                            'k_tgl_posting'   => null,
                        ]); 
        }
        $hapus = DB::table('posting_pembayaran')
                   ->where('nomor',$request->id)
                   ->delete();

        return response()->json(['pesan'=>'Data Berhasil Dihapus']);
    }

    public function edit($id)
    {
        if (Auth::user()->punyaAkses('Posting Pembayaran','ubah')) {
            $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
            $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
            $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
            $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
            $customer = DB::select(" SELECT kode,nama,cabang FROM customer order by kode ASC");
            $akun     = DB::table('masterbank')
                          ->get();

            $data = DB::table('posting_pembayaran')
                      ->where('nomor',$id)
                      ->first();

            $data_dt = DB::table('posting_pembayaran_d')
                         ->leftjoin('customer','kode','=','kode_customer')
                         ->where('nomor_posting_pembayaran',$id)
                         ->get();

            return view('sales.posting_pembayaran.edit_posting',compact('id','data','data_dt','cabang','kota','rute','kendaraan','akun','customer'));
        }else{
            return redirect()->back();
        }
        
    }

    public function update_posting(request $request)
    {
        $this->posting_pembayaran_hapus($request);
        return $this->simpan_posting($request);
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

    public function posting_pembayaran_print($id)
    {
        $data = DB::table('posting_pembayaran')
                  ->join('cabang','kode','=','kode_cabang')
                  ->where('nomor',$id)
                  ->first();

        $data_dt = DB::table('posting_pembayaran_d')
                     ->join('masterbank','mb_kode','=','kode_acc')
                     ->leftjoin('kwitansi','nomor_penerimaan_penjualan','=','k_nomor')
                     ->where('nomor_posting_pembayaran',$id)
                     ->get();
        $sebut = $this->penyebut($data->jumlah);
        return view('sales.posting_pembayaran.print',compact('data','data_dt','sebut'));

    }
}
