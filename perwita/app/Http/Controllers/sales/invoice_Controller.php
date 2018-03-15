<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;
use App\master_akun;
use App\d_jurnal;
use App\d_jurnal_dt;
use Carbon\Carbon;
use Auth;


class invoice_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $pendapatan = strtoupper($request->input('pendapatan'));
		if ($pendapatan =='KORAN'){
			$sql = "   SELECT *,nomor_do ||'-'||id_do AS nomor FROM invoice_d WHERE nomor_invoice='$nomor'  ";
		}else{
			$sql = "   SELECT *,nomor_do AS nomor FROM invoice_d WHERE nomor_invoice='$nomor'  ";
		}
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_do'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('invoice')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('invoice_d')->where('id', $id)->first();
        echo json_encode($data);
    }



    public function index(){
        $data = DB::table('invoice')
                  ->join('customer','i_kode_customer','=','kode')
                  ->get();
        return view('sales.invoice.index',compact('data'));
    }

    public function form(){
        $customer = DB::table('customer')
                      ->get();

        $cabang   = DB::table('cabang')
                      ->get();
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                      ->get();

        return view('sales.invoice.form',compact('customer','cabang','tgl','tgl1','pajak'));
    }


    public function cetak_nota($nomor=null) {
        $head = collect(\DB::select(" SELECT c.*,i.* FROM invoice i LEFT JOIN customer c ON c.kode=i.kode_customer WHERE i.nomor='$nomor' "))->first();
		$pendapatan = $head->pendapatan;
		if ($pendapatan == 'KORAN'){
        	$detail = DB::select(" SELECT *,nomor_do ||'-'||id_do AS nomor FROM invoice_d d WHERE d.nomor_invoice='$nomor' ");
		}else{
        	$detail = DB::select(" SELECT *,nomor_do AS nomor FROM invoice_d d WHERE d.nomor_invoice='$nomor' ");
		}
        $terbilang = $this->penyebut($head->total_tagihan);
        return view('sales.invoice.print',compact('head','detail','terbilang'));
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

    public function groupJurnal($data) {
        $total=0;
        $ppn=0;        
        $groups = array();
        $key = 0;
        $c=0;
        foreach ($data as $item) {
            
            $key = $item['akunPendapatan'];
            if (!array_key_exists($key, $groups)) {
                if($item['ppn']!=3){                    
                $groups[$key] = array(                  
                    'akunPendapatan' => $item['akunPendapatan'],                    
                    'subtotal' => $item['subtotal'],
                    'diskon'   =>$item['diskon'],
                    'ppn'   =>$item['ppn'],
                );   
                }

                else if($item['ppn']==3){      
                    $total=round(($item['subtotal']-$item['diskon'])*100/101,2);
                    $ppn=round($total*1/100,2);                                                            
                    $groups[$key] = array(                  
                        'akunPendapatan' => $item['akunPendapatan'],                    
                        'subtotal' =>$total,
                        'diskon'   =>$item['diskon'],                    
                        'ppn'   =>$ppn,    
                    );  

                }   

                
                
            } else {
                if($item['ppn']!=3){
                    $groups[$key]['subtotal'] = 
                    $groups[$key]['subtotal'] + $item['subtotal'];   
                    $groups[$key]['diskon']  = $item['diskon'];                       
                }
                else if($item['ppn']==3){ 
                    $total=round(($item['subtotal']-$item['diskon'])*100/101,2);
                    $ppn=round($total*1/100,2);                                        
                    $groups[$key]['subtotal'] = $groups[$key]['subtotal'] + $total;    
                    $groups[$key]['diskon']  =$groups[$key]['diskon']+ $item['diskon'];
                    $groups[$key]['ppn']  = $groups[$key]['ppn']+$ppn;
                }      
            }
            $key++;
        }                
        return $groups;
    }
    



 public function jurnal($nomor=null){
        $jurnal_dt=null;
            
             $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$nomor')")); 


        return view('sales.invoice.jurnal',compact('nomor','jurnal_dt'));
    }
    
public function nota_invoice(request $request){
    // dd($request->all());
    $bulan = Carbon::now()->format('m');
    $tahun = Carbon::now()->format('y');

    $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                    WHERE i_kode_cabang = '$request->cabang'
                                    AND to_char(i_tanggal,'MM') = '$bulan'
                                    AND to_char(i_tanggal,'YY') = '$tahun'");
    $index = (integer)$cari_nota[0]->id + 1;
    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
    $nota = 'INV' . $request->cabang . $bulan . $tahun . $index;

    return response()->json([
                         'nota'=>$nota
                        ]);
}
public function jatuh_tempo_customer(request $request)
{
    $cus = DB::table('customer')
             ->where('kode',$request->cus)
             ->first();
    $jt = $cus->syarat_kredit;
    $tgl = str_replace('/', '-' ,$request->tgl);
    $tgl = Carbon::parse($tgl)->format('Y-m-d');

    $tgl = Carbon::parse($tgl)->subDays(-$jt)->format('d/m/Y');

    return response()->json([
                         'jt' =>$jt,
                         'tgl'=>$tgl
                       ]);
}
public function cari_do_invoice(request $request)
{   
    // dd($request->all());
    $do_awal = str_replace('/', '-' ,$request->do_awal);
    $do_akhir = str_replace('/', '-' ,$request->do_akhir);
    $do_awal = Carbon::parse($do_awal)->format('Y-m-d');
    $do_akhir = Carbon::parse($do_akhir)->format('Y-m-d');
    $jenis = $request->cb_pendapatan;
    if ($request->cb_pendapatan == 'KORAN') {

      $temp = DB::table('delivery_order')
              ->join('delivery_orderd','delivery_orderd.dd_nomor','=','delivery_order.nomor')
              ->leftjoin('invoice_d','delivery_orderd.dd_id','=','invoice_d.id_nomor_do_dt')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

      $temp1 = DB::table('delivery_order')
              ->join('delivery_orderd','delivery_orderd.dd_nomor','=','delivery_order.nomor')
              ->leftjoin('invoice_d','delivery_orderd.dd_id','=','invoice_d.id_nomor_do_dt')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

        if (isset($request->array_simpan)) {
            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->array_simpan); $a++) { 
                    if ($request->array_simpan[$a] == $temp1[$i]->dd_id) {
                        unset($temp[$i]);
                    }
                }
            }

            $data = $temp;
            
        }else{
            $data = $temp;
        }
    }else if ($request->cb_pendapatan == 'PAKET' || $jenis == 'KARGO') {
        $temp = DB::table('delivery_order')
              ->leftjoin('invoice_d','delivery_order.nomor','=','invoice_d.id_nomor_do')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

        $temp1 = DB::table('delivery_order')
              ->leftjoin('invoice_d','delivery_order.nomor','=','invoice_d.id_nomor_do')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

        if (isset($request->array_simpan)) {
            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->array_simpan); $a++) { 
                    if ($request->array_simpan[$a] == $temp1[$i]->nomor) {
                        unset($temp[$i]);
                    }
                }
            }

            $data = $temp;
            
        }else{
            $data = $temp;
        }
    }
    

    return view('sales.invoice.tableDo',compact('data','jenis'));
}
public function append_do(request $request)
{
    // dd($request->all());
    $jenis = $request->cb_pendapatan;

    if ($jenis == 'KORAN') {

        $cari_do = DB::table('delivery_orderd')
                     ->join('delivery_order','delivery_order.nomor','=','delivery_orderd.dd_nomor')
                     ->whereIn('delivery_orderd.dd_nomor',$request->nomor_do)
                     ->whereIn('dd_id',$request->nomor_dt)
                     ->get();

        $cari_kota  = DB::table('kota')
                        ->get();

        for ($i=0; $i < count($cari_do); $i++) { 
           for ($a=0; $a < count($cari_kota); $a++) { 
               if ($cari_kota[$a]->id == $cari_do[$i]->dd_id_kota_asal) {
                   $cari_do[$i]->nama_kota_asal = $cari_kota[$a]->nama;
               }
               if ($cari_kota[$a]->id == $cari_do[$i]->dd_id_kota_tujuan) {
                   $cari_do[$i]->nama_kota_tujuan = $cari_kota[$a]->nama;
               }
           }
            $cari_do[$i]->harga_netto = $cari_do[$i]->dd_total - $cari_do[$i]->dd_diskon;

        }

    }else if ($jenis == 'PAKET' || $jenis == 'KARGO') {

        $cari_do = DB::table('delivery_order')
                     ->whereIn('delivery_order.nomor',$request->nomor_do)
                     ->get();

        $cari_kota  = DB::table('kota')
                        ->get();

        for ($i=0; $i < count($cari_do); $i++) { 
           for ($a=0; $a < count($cari_kota); $a++) { 
               if ($cari_kota[$a]->id == $cari_do[$i]->id_kota_asal) {
                   $cari_do[$i]->nama_kota_asal = $cari_kota[$a]->nama;
               }
               if ($cari_kota[$a]->id == $cari_do[$i]->id_kota_tujuan) {
                   $cari_do[$i]->nama_kota_tujuan = $cari_kota[$a]->nama;
               }
           }
            $cari_do[$i]->harga_netto = $cari_do[$i]->total - $cari_do[$i]->diskon;

        }

    }
        
    return response()->json([
                         'data' => $cari_do,
                         'jenis' => $jenis
                       ]);
}
public function pajak_lain(request $request)
{
    $persen = DB::table('pajak')
                ->where('kode',$request->pajak_lain)
                ->first();

    return response()->json(['persen' => $persen]);
}
public function simpan_invoice(request $request)
{
    // dd($request->all());
  
    $do_awal        = str_replace('/', '-', $request->do_awal);
    $do_akhir       = str_replace('/', '-', $request->do_awal);
    $ed_jatuh_tempo = str_replace('/', '-', $request->ed_jatuh_tempo);
    $do_awal        = Carbon::parse($do_awal)->format('Y-m-d');
    $do_akhir       = Carbon::parse($do_akhir)->format('Y-m-d');
    $ed_jatuh_tempo = Carbon::parse($ed_jatuh_tempo)->format('Y-m-d');

    $total_tagihan  = filter_var($request->total_tagihan, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $netto_total    = filter_var($request->netto_total, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $diskon1        = filter_var($request->diskon1, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $diskon2        = filter_var($request->diskon2, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $ed_total       = filter_var($request->ed_total, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $total_ppn      = filter_var($request->ppn, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $total_pph      = filter_var($request->pph, FILTER_SANITIZE_NUMBER_FLOAT)/100;

    $cari_no_invoice = DB::table('invoice')
                         ->where('i_nomor',$request->nota_invoice)
                         ->first();


    if ($request->cb_jenis_ppn == 1) {
        $ppn_type = 'pkp';
        $ppn_persen = 10;
    } elseif ($request->cb_jenis_ppn == 2) {
        $ppn_type = 'pkp';
        $ppn_persen = 1;
    } elseif ($request->cb_jenis_ppn == 3) {
        $ppn_type = 'npkp';
        $ppn_persen = 1;
    } elseif ($request->cb_jenis_ppn == 5) {
        $ppn_type = 'npkp';
        $ppn_persen = 10;
    }
    if ($request->ed_pendapatan == 'PAKET' || $request->ed_pendapatan == 'KARGO') {

        if ($cari_no_invoice == null) {

            $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  $request->nota_invoice,
                                          'i_tanggal'            =>  Carbon::now(),
                                          'i_keterangan'         =>  $request->ed_keterangan,
                                          'i_tgl_mulai_do'       =>  $do_awal,
                                          'i_tgl_sampai_do'      =>  $do_akhir,
                                          'i_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'i_total'              =>  $total_tagihan,
                                          'i_netto_detail'       =>  $netto_total,
                                          'i_diskon1'            =>  $diskon1,
                                          'i_diskon2'            =>  $diskon2,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  Auth::user()->kode_cabang,
                                          'create_by'            =>  Auth::user()->m_name,
                                          'create_at'            =>  Carbon::now(),
                                          'update_by'            =>  Auth::user()->m_name,
                                          'update_at'            =>  Carbon::now(),
                                          'i_pendapatan'         =>  $request->ed_pendapatan
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

             return response()->json(['status' => 1]);

        }else{

             $bulan = Carbon::now()->format('m');
             $tahun = Carbon::now()->format('y');

             $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                            WHERE i_kode_cabang = '$request->cabang'
                                            AND to_char(i_tanggal,'MM') = '$bulan'
                                            AND to_char(i_tanggal,'YY') = '$tahun'");
             $index = (integer)$cari_nota[0]->id + 1;
             $index = str_pad($index, 5, '0', STR_PAD_LEFT);
             $nota = 'INV' . $request->cabang . $bulan . $tahun . $index;


             $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  $nota,
                                          'i_tanggal'            =>  Carbon::now(),
                                          'i_keterangan'         =>  $request->ed_keterangan,
                                          'i_tgl_mulai_do'       =>  $do_awal,
                                          'i_tgl_sampai_do'      =>  $do_akhir,
                                          'i_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'i_total'              =>  $total_tagihan,
                                          'i_netto_detail'       =>  $netto_total,
                                          'i_diskon1'            =>  $diskon1,
                                          'i_diskon2'            =>  $diskon2,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  Auth::user()->kode_cabang,
                                          'create_by'            =>  Auth::user()->m_name,
                                          'create_at'            =>  Carbon::now(),
                                          'update_by'            =>  Auth::user()->m_name,
                                          'update_at'            =>  Carbon::now(),
                                          'i_pendapatan'         =>  $request->ed_pendapatan
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
                                              'id_keterangan'    => $o->deskripsi,
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

             return response()->json(['status' => 2]);
        }

    }else if($request->ed_pendapatan == 'KORAN'){

        if ($cari_no_invoice == null) {

            $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  $request->nota_invoice,
                                          'i_tanggal'            =>  Carbon::now(),
                                          'i_keterangan'         =>  $request->ed_keterangan,
                                          'i_tgl_mulai_do'       =>  $do_awal,
                                          'i_tgl_sampai_do'      =>  $do_akhir,
                                          'i_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'i_total'              =>  $total_tagihan,
                                          'i_netto_detail'       =>  $netto_total,
                                          'i_diskon1'            =>  $diskon1,
                                          'i_diskon2'            =>  $diskon2,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  Auth::user()->kode_cabang,
                                          'create_by'            =>  Auth::user()->m_name,
                                          'create_at'            =>  Carbon::now(),
                                          'update_by'            =>  Auth::user()->m_name,
                                          'update_at'            =>  Carbon::now(),
                                          'i_pendapatan'         =>  $request->ed_pendapatan
                                     ]);
             for ($i=0; $i < count($request->do_detail); $i++) { 

                $cari_id = DB::table('invoice_d')
                             ->max('id_id');

                 if ($cari_id == null ) {
                     $cari_id = 1;
                 }else{
                     $cari_id += 1;
                 }
                 $do = DB::table('delivery_orderd')
                         ->join('delivery_order','nomor','=','dd_nomor')
                         ->where('dd_id',$request->do_id[$i])
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
                                              'id_keterangan'    => $do->dd_keterangan,
                                              'id_harga_satuan'  => $request->dd_harga[$i],
                                              'id_harga_bruto'   => $request->dd_total[$i],
                                              'id_diskon'        => $request->dd_diskon[$i],
                                              'id_harga_netto'   => $request->harga_netto[$i],
                                              'id_kode_satuan'   => $do->dd_kode_satuan,
                                              'id_kuantum'       => $do->dd_jumlah,
                                              'id_kode_item'     => $do->dd_kode_item,
                                              'id_tipe'          => 'tidak tahu',
                                              'id_acc_penjualan' => $do->dd_acc_penjualan,
                                              'id_nomor_do_dt'   => $request->do_id[$i]
                                          ]);
             }

             return response()->json(['status' => 1]);

        }else{

             $bulan = Carbon::now()->format('m');
             $tahun = Carbon::now()->format('y');

             $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                            WHERE i_kode_cabang = '$request->cabang'
                                            AND to_char(i_tanggal,'MM') = '$bulan'
                                            AND to_char(i_tanggal,'YY') = '$tahun'");
             $index = (integer)$cari_nota[0]->id + 1;
             $index = str_pad($index, 5, '0', STR_PAD_LEFT);
             $nota = 'INV' . $request->cabang . $bulan . $tahun . $index;


             $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  $nota,
                                          'i_tanggal'            =>  Carbon::now(),
                                          'i_keterangan'         =>  $request->ed_keterangan,
                                          'i_tgl_mulai_do'       =>  $do_awal,
                                          'i_tgl_sampai_do'      =>  $do_akhir,
                                          'i_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'i_total'              =>  $total_tagihan,
                                          'i_netto_detail'       =>  $netto_total,
                                          'i_diskon1'            =>  $diskon1,
                                          'i_diskon2'            =>  $diskon2,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  Auth::user()->kode_cabang,
                                          'create_by'            =>  Auth::user()->m_name,
                                          'create_at'            =>  Carbon::now(),
                                          'update_by'            =>  Auth::user()->m_name,
                                          'update_at'            =>  Carbon::now(),
                                          'i_pendapatan'         =>  $request->ed_pendapatan
                                     ]);

             for ($i=0; $i < count($request->do_detail); $i++) { 
                
                $cari_id = DB::table('invoice_d')
                             ->max('id_id');

                 if ($cari_id == null ) {
                     $cari_id = 1;
                 }else{
                     $cari_id += 1;
                 }
                 $do = DB::table('delivery_orderd')
                         ->join('delivery_order','nomor','=','dd_nomor')
                         ->where('id',$request->do_id[$i])
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
                                              'id_keterangan'    => $do->dd_keterangan,
                                              'id_harga_satuan'  => $request->dd_harga[$i],
                                              'id_harga_bruto'   => $request->dd_total[$i],
                                              'id_diskon'        => $request->dd_diskon[$i],
                                              'id_harga_netto'   => $request->harga_netto[$i],
                                              'id_kode_satuan'   => $do->dd_kode_satuan,
                                              'id_kuantum'       => $do->dd_jumlah,
                                              'id_kode_item'     => $do->dd_kode_item,
                                              'id_tipe'          => 'tidak tahu',
                                              'id_acc_penjualan' => $do->dd_acc_penjualan,
                                              'id_nomor_do_dt'   => $request->do_id[$i]
                                          ]);
             }

             return response()->json(['status' => 2]);
        }
    }
        
}
}
