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
     $cabang = auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Invoice','all')) {
            $data = DB::table('invoice')
                      ->join('customer','kode','=','i_kode_customer')
                      ->take(2000)
                      ->get();
        }else{
            $data = DB::table('invoice')
                      ->join('customer','kode','=','i_kode_customer')
                      ->where('i_kode_cabang',$cabang)
                      ->take(2000)
                      ->get();
        }
        $kota = DB::table('kota')
                  ->get();
        return view('sales.invoice.index',compact('data'));
    }

    public function form(){
        $customer = DB::table('customer')
                      ->where('nama','!=','NON MEMBER')
                      ->where('nama','!=','NON CUSTOMER')
                      ->get();

        $cabang   = DB::table('cabang')
                      ->get();
        $kota     = DB::table('kota')
                      ->get();

        for ($i=0; $i < count($customer); $i++) { 
          for ($a=0; $a < count($kota); $a++) { 
            if ($customer[$i]->kota == $kota[$a]->id) {
               $customer[$i]->nama_kota = $kota[$a]->nama;
            }
          }
        }
        // return $customer;
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                      ->get();

        return view('sales.invoice.form',compact('customer','cabang','tgl','tgl1','pajak'));
    }


    public function cetak_nota($id) {
        $head = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_nomor',$id)
                  ->first();
        $detail = DB::table('invoice_d')
                    ->where('id_nomor_invoice',$id)
                    ->get();
        $counting = count($detail); 
  
        $update_status = DB::table('invoice')
                           ->where('i_nomor',$id)
                           ->update([
                            'i_statusprint'=>'Printed'
                           ]);
                           
        if ($counting < 30) {
          $hitung =30 - $counting;
          for ($i=0; $i < $hitung; $i++) { 
            $push[$i]=' ';
          }
        }else{
          $push = [];
        }

        

        // return $push;
        $terbilang = $this->penyebut($head->i_total_tagihan);
        if ($head->i_pendapatan == 'PAKET') {
          return view('sales.invoice.print',compact('head','detail','terbilang','push'));
        }else{
          return view('sales.invoice.print_1',compact('head','detail','terbilang','push'));
        }
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

  /*  public function groupJurnal($data) {
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
    */



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
             ->where('kode',$request->customer)
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

public function drop_cus(request $request)
{
  $customer = DB::table('customer')
                      ->where('cabang',$request->cabang)
                      ->get();
  return view('sales.invoice.dropdown_customer',compact('customer'));
}
public function cari_do_invoice(request $request)
{   
    $do_awal = str_replace('/', '-' ,$request->do_awal);
    $do_akhir = str_replace('/', '-' ,$request->do_akhir);
    $do_awal = Carbon::parse($do_awal)->format('Y-m-d');
    $do_akhir = Carbon::parse($do_akhir)->format('Y-m-d');
    $jenis = $request->cb_pendapatan;
    $id = '0';
    if ($request->cb_pendapatan == 'KORAN') {

     $temp = DB::table('delivery_order')
              ->join('delivery_orderd','delivery_orderd.dd_nomor','=','delivery_order.nomor')
              ->leftjoin('invoice_d','delivery_orderd.dd_id','=','invoice_d.id_nomor_do_dt')
              ->leftjoin('invoice_pembetulan_d','delivery_orderd.dd_id','=','invoice_pembetulan_d.ipd_nomor_do_dt')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->orderBy('tanggal','desc')
              ->get();

      $temp1 = DB::table('delivery_order')
              ->join('delivery_orderd','delivery_orderd.dd_nomor','=','delivery_order.nomor')
              ->leftjoin('invoice_d','delivery_orderd.dd_id','=','invoice_d.id_nomor_do_dt')
              ->leftjoin('invoice_pembetulan_d','delivery_orderd.dd_id','=','invoice_pembetulan_d.ipd_nomor_do_dt')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->orderBy('tanggal','desc')
              ->get();

        if (isset($request->array_simpan)) {
            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->array_simpan); $a++) { 
                    if ($request->array_simpan[$a] == $temp1[$i]->dd_id) {
                        unset($temp[$i]);
                    }
                }
            }
            $temp = array_values($temp);
            $data = $temp;
            $data1 = $temp;
            
        }else{
            $data = $temp;
            $data1 = $temp;
        }
    }else if ($request->cb_pendapatan == 'PAKET' || $jenis == 'KARGO') {
      // dd($request->all());
       $temp = DB::table('delivery_order')
              ->leftjoin('invoice_d','delivery_order.nomor','=','invoice_d.id_nomor_do')
              ->leftjoin('invoice_pembetulan_d','delivery_order.nomor','=','invoice_pembetulan_d.ipd_nomor_do')
              ->where('delivery_order.kode_cabang','=',$request->cabang)
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

        $temp1 = DB::table('delivery_order')
              ->leftjoin('invoice_d','delivery_order.nomor','=','invoice_d.id_nomor_do')
              ->leftjoin('invoice_pembetulan_d','delivery_order.nomor','=','invoice_pembetulan_d.ipd_nomor_do')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
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
            $data1= $temp;
            
        }else{
            $data = $temp;
            $data1 = $temp;
        }
    }
    $data = array_values($data);
    $data1 = array_values($data1);

    for ($i=0; $i < count($data1); $i++) { 
      if ($data1[$i]->ipd_nomor_invoice !=null) {
          unset($data[$i]);
      }
    }
    $data = array_values($data);
    $customer = DB::table('customer')
                      ->get();
    for ($i=0; $i < count($data); $i++) { 
      for ($a=0; $a < count($customer); $a++) { 
        if ($data[$i]->kode_customer == $customer[$a]->kode) {
           $data[$i]->nama_customer = $customer[$a]->nama;
        }
      }
    }
    // return $data;
   $id = $request->id;
    return view('sales.invoice.tableDo',compact('data','jenis','id'));
}
public function append_do(request $request)
{
  
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
            $cari_do[$i]->acc_penjualan=$cari_do[$i]->dd_acc_penjualan;

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
   return DB::transaction(function() use ($request) {  


    $delete = DB::table('invoice')
                ->where('i_nomor',$request->nota_invoice);
                
    if(count($delete->first())!=0){
        $delete->delete();
    }
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

    $cari_no_invoice = DB::table('invoice')
                         ->where('i_nomor',$request->nota_invoice)
                         ->first();
    // dd($request->all());
    // dd($total_tagihan);
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
                                          'i_total_tagihan'      =>  $total_tagihan,
                                          'i_sisa_pelunasan'     =>  $total_tagihan,
                                          'i_sisa_akhir'         =>  $total_tagihan,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_status'             =>  'Released',
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->kode_pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  $cabang,
                                          'create_by'            =>  Auth::user()->m_name,
                                          'i_statusprint'        =>  'Released',
                                          'create_at'            =>  Carbon::now(),
                                          'update_by'            =>  Auth::user()->m_name,
                                          'update_at'            =>  Carbon::now(),
                                          'i_pendapatan'         =>  $request->ed_pendapatan
                                     ]);

            // $cari_no_invoice = DB::table('invoice')
            //              ->where('i_nomor',$request->nota_invoice)
            //              ->first();
            //   dd($cari_no_invoice);
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
                $update_do = DB::table('delivery_order')
                                   ->where('nomor',$request->do_detail[$i])
                                   ->update([
                                    'status_do'=>'Approved'
                                   ]);
   

    $diskonItem=round($request->diskon2*($request->harga_netto[$i]/$request->netto_detail),2);//diskon persen per item total

    $d[$i]=round($request->netto_detail,2);//diskon persen per item total

    $totalStlhDiskon=$request->harga_netto[$i]-$diskonItem;   

                      $dataItem[$i]['acc_penjualan']=$request->akun[$i];
                      $dataItem[$i]['dd_diskon']=$request->dd_diskon[$i]; //diskon per item                 
                      /*$dataItem[$i]['dd_total']=$request->dd_total[$i];//total per item sblm diskon*/
                      if($request->cb_jenis_ppn== 3 || $request->cb_jenis_ppn== 5){//include

                      /*$dataItem[$i]['harga_netto']=((($request->dd_total[$i]-$request->dd_diskon[$i]-$diskonItem)*100)
                                                  /(100+$ppn_persen))+$request->dd_diskon[$i]+$diskonItem;//total per item stlh diskon*/
                                                  
                      $dataItem[$i]['harga_netto']=(((($request->dd_total[$i]-$request->dd_diskon[$i])-$diskonItem)*100)



                                                  /(100+$ppn_persen))+$request->dd_diskon[$i]+$diskonItem;//total per item stlh diskon
                     } else {
                        $dataItem[$i]['harga_netto']=$request->dd_total[$i];
                      
                      }                      
                    /*  dd(((($request->dd_total[$i]-$request->dd_diskon[$i]-$diskonItem)*100)
                                                  /(100+$ppn_persen))+$request->dd_diskon[$i]+$diskonItem);*/
                      $dataItem[$i]['diskon2']=$diskonItem;// presentase diskon global
                      $dataItem[$i]['ppn']=$totalStlhDiskon*$nilaiPpn;                      
                      $dataItem[$i]['pajak_lain']=$totalStlhDiskon*((int)$request->pajak_lain/100);
                      /*$dataItem[$i]['netto_detail']=$request->netto_detail;  */              
                    
             }
             
             // $tes = DB::table('invoice_d')
             //             ->where('id_nomor_invoice',$request->nota_invoice)
             //             ->get();

             //    dd($tes);
$jurnal=d_jurnal::where('jr_ref', $request->nota_invoice)->where('jr_note','INVOICE');
            if(count($jurnal->first())!=0){
              $jurnal->delete();
            }

if(count($dataItem)==0){
    return response()->json(['status' => 1,'display'=>0]);
}
      $Nilaijurnal=$this->groupJurnal($dataItem);

            foreach ($Nilaijurnal as  $indexakun=> $dataJurnal) {  
        if($dataJurnal['acc_penjualan']==''){
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Pada DO Belum Ada.'];
              DB::rollback();
              return json_encode($dataInfo);
        }
       $acc=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$dataJurnal['acc_penjualan'].'%')
                  // ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();       
          
        if(count($acc)!=0){
        $akun[$indexakun]['id_akun']=$acc->id_akun;
        $akun[$indexakun]['value']=round($dataJurnal['totalInvoice'],2);
        $akun[$indexakun]['dk']='K';
        $indexakun++;   

        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Belum Tersedia'];
      DB::rollback();
            return json_encode($dataInfo);
        }        
      
    }  

      if($request->accPiutang==''){
            $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Pada Customer Belum Ada.'];
              DB::rollback();
              return json_encode($dataInfo);
        }

        // return $cabang;
        // return$request->accPiutang;
      $akunPiutang=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$request->accPiutang.'%')                                    
                  // ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                    

                  if(count($akunPiutang)==0){
                        $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Belum Tersedia'];
                        DB::rollback();
                        return json_encode($dataInfo);
                    }

                $akun[$indexakun]['id_akun']=$akunPiutang->id_akun;
                $akun[$indexakun]['value']=round($total_tagihan,2);
                $akun[$indexakun]['dk']='D';
                $indexakun++;



    if($request->diskon1!=0 || $request->diskon2!=0){
        $akunDiskon=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '5298%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunDiskon)!=0){
                $akun[$indexakun]['id_akun']=$akunDiskon->id_akun;
                $akun[$indexakun]['value']=-(round($diskon1+$request->diskon2,2));
                $akun[$indexakun]['dk']='D';
                $indexakun++;
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        } 
    }


if($request->cb_jenis_ppn!=4){
      $akunPPN=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$akunPPH.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPN)!=0){

                $akun[$indexakun]['id_akun']=$akunPPN->id_akun;
                $akun[$indexakun]['value']=round($total_ppn,2);
                $akun[$indexakun]['dk']='K';
                $indexakun++;
        }
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        }
}


if($request->pajak_lain!='T' && $request->pajak_lain!='0' && $request->pajak_lain!='undefined'){

          $akunPPH=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '2305%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPH)!=0){            
                $akun[$indexakun]['id_akun']=$akunPPH->id_akun;
                $akun[$indexakun]['value']=-$total_pph;                
                $akun[$indexakun]['dk']='D';
                $indexakun++;
            }                    
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        }
      }



            
            $id_jurnal=d_jurnal::max('jr_id')+1;
            $id_jrdt=1;
                foreach ($akun as $key => $data) {   
                        
                        $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                        $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt;
                        $jurnal_dt[$key]['jrdt_acc']=$data['id_akun'];
                        $jurnal_dt[$key]['jrdt_value']=$data['value'];
                        $jurnal_dt[$key]['jrdt_statusdk']=$data['dk'];
                        $id_jrdt++;
                }
            d_jurnal::create([
                        'jr_id'=>$id_jurnal,
                        'jr_year'=> date('Y',strtotime($do_awal)),
                        'jr_date'=> $do_awal,
                        'jr_detail'=> 'INVOICE'.' '.$request->ed_pendapatan,
                        'jr_ref'=>  $request->nota_invoice,
                        'jr_note'=> 'INVOICE',
                        ]);
            d_jurnal_dt::insert($jurnal_dt);
           




             return response()->json(['status' => 1]);

        }else{

             $bulan = Carbon::now()->format('m');
             $tahun = Carbon::now()->format('y');
             $cabang= Auth::user()->kode_cabang;
             $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                            WHERE i_kode_cabang = '$cabang'
                                            AND to_char(i_tanggal,'MM') = '$bulan'
                                            AND to_char(i_tanggal,'YY') = '$tahun'");
             $index = (integer)$cari_nota[0]->id + 1;
             $index = str_pad($index, 5, '0', STR_PAD_LEFT);
             $nota = 'INV' . Auth::user()->kode_cabang . $bulan . $tahun . $index;


             $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  $nota,
                                          'i_tanggal'            =>  Carbon::now(),
                                          'i_keterangan'         =>  $request->ed_keterangan,
                                          'i_tgl_mulai_do'       =>  $do_awal,
                                          'i_tgl_sampai_do'      =>  $do_akhir,
                                          'i_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'i_total'              =>  $total_tagihan,
                                          'i_total_tagihan'      =>  $total_tagihan,
                                          'i_sisa_pelunasan'     =>  $total_tagihan,
                                          'i_sisa_akhir'         =>  $total_tagihan,
                                          'i_netto_detail'       =>  $netto_total,
                                          'i_diskon1'            =>  $diskon1,
                                          'i_status'             =>  'Released',
                                          'i_diskon2'            =>  $diskon2,
                                          'i_statusprint'        =>  'Released',
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->kode_pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  $cabang,
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
                    $update_do = DB::table('delivery_order')
                                   ->where('nomor',$request->do_detail[$i])
                                   ->update([
                                    'status_do'=>'Approved'
                                   ]);

    $request->netto_detail = str_replace(['Rp', '\\', '.', ' '], '', $request->netto_detail);
    $request->netto_detail =str_replace(',', '.', $request->netto_detail);

    $request->diskon2 = str_replace(['Rp', '\\', '.', ' '], '', $request->diskon2);
    $request->diskon2 =str_replace(',', '.', $request->diskon2);
    $diskonItem=$request->diskon2*$request->harga_netto[$i]/$request->netto_detail;
    $totalStlhDiskon=$request->harga_netto[$i]-$diskonItem;    
                      $dataItem[$i]['acc_penjualan']=$request->akun[$i];
                      $dataItem[$i]['dd_diskon']=$request->dd_diskon[$i]; //diskon per item                 
                      /*$dataItem[$i]['dd_total']=$request->dd_total[$i];//total per item sblm diskon*/
                      if($request->cb_jenis_ppn== 3 || $request->cb_jenis_ppn== 5)//include
                      $dataItem[$i]['harga_netto']=(($request->dd_total[$i]-$request->dd_diskon[$i]-$diskonItem)*100
                                                  /(100+$ppn_persen))+$request->dd_diskon[$i]+$diskonItem;//total per item stlh diskon
                      else {
                        $dataItem[$i]['harga_netto']=$request->dd_total[$i];
                      
                      }
                      $dataItem[$i]['diskon2']=$diskonItem;// presentase diskon global
                      $dataItem[$i]['ppn']=$totalStlhDiskon*$nilaiPpn;                      
                      $dataItem[$i]['pajak_lain']=$totalStlhDiskon*($request->pajak_lain/100);
             }

$jurnal=d_jurnal::where('jr_ref', $request->nota_invoice)->where('jr_note','INVOICE');
            if(count($jurnal->first())!=0){
              $jurnal->delete();
            }
if(count($dataItem)==0){
    return response()->json(['status' => 1,'display'=>0]);
}
               $Nilaijurnal=$this->groupJurnal($dataItem);

            foreach ($Nilaijurnal as  $indexakun=> $dataJurnal) {  
        if($dataJurnal['acc_penjualan']==''){
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Pada DO Belum Ada.'];
              DB::rollback();
              return json_encode($dataInfo);
        }
       $acc=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$dataJurnal['acc_penjualan'].'%')
                  // ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                   
        if(count($acc)!=0){
        $akun[$indexakun]['id_akun']=$acc->id_akun;
        $akun[$indexakun]['value']=round($dataJurnal['totalInvoice'],2);
        $akun[$indexakun]['dk']='K';
        $indexakun++;              
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Belum Tersedia'];
      DB::rollback();
            return json_encode($dataInfo);
        }        
      
    }  

      if($request->accPiutang==''){
            $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Pada Customer Belum Ada.'];
              DB::rollback();
              return json_encode($dataInfo);
        }
      $akunPiutang=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$request->accPiutang.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                    

                  if(count($akunPiutang)==0){
                        $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Belum Tersedia'];
                        DB::rollback();
                        return json_encode($dataInfo);
                    }

                $akun[$indexakun]['id_akun']=$akunPiutang->id_akun;
                $akun[$indexakun]['value']=round($total_tagihan,2);
                $akun[$indexakun]['dk']='D';
                $indexakun++;



    if($request->diskon1!=0 || $request->diskon2!=0){
        $akunDiskon=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '5298%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunDiskon)!=0){
                $akun[$indexakun]['id_akun']=$akunDiskon->id_akun;
                $akun[$indexakun]['value']=-(round($diskon1+$diskon2,2));
                $akun[$indexakun]['dk']='D';
                $indexakun++;
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        } 
    }


if($request->cb_jenis_ppn!=4){
      $akunPPN=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$akunPPH.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPN)!=0){

                $akun[$indexakun]['id_akun']=$akunPPN->id_akun;
                $akun[$indexakun]['value']=round($total_ppn,2);
                $akun[$indexakun]['dk']='K';
                $indexakun++;
        }
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        }
}


if($request->pajak_lain!='T' && $request->pajak_lain!='0' && $request->pajak_lain!='undefined'){
          $akunPPH=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '2305%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPH)!=0){            
                $akun[$indexakun]['id_akun']=$akunPPH->id_akun;
                $akun[$indexakun]['value']=-$total_pph;                
                $akun[$indexakun]['dk']='D';
                $indexakun++;
            }                    
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        }
      }



            
            $id_jurnal=d_jurnal::max('jr_id')+1;
            $id_jrdt=1;
                foreach ($akun as $key => $data) {   
                        
                        $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                        $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt;
                        $jurnal_dt[$key]['jrdt_acc']=$data['id_akun'];
                        $jurnal_dt[$key]['jrdt_value']=$data['value'];
                        $jurnal_dt[$key]['jrdt_statusdk']=$data['dk'];
                        $id_jrdt++;
                }
            d_jurnal::create([
                        'jr_id'=>$id_jurnal,
                        'jr_year'=> date('Y',strtotime($do_awal)),
                        'jr_date'=> $do_awal,
                        'jr_detail'=> 'INVOICE'.' '.$request->ed_pendapatan,
                        'jr_ref'=>  $request->nota_invoice,
                        'jr_note'=> 'INVOICE',
                        ]);
            d_jurnal_dt::insert($jurnal_dt);
           


             return response()->json(['status' => 2,'nota'=>$nota]);
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
                                          'i_sisa_akhir'         =>  $total_tagihan,
                                          'i_total_tagihan'      =>  $total_tagihan,
                                          'i_sisa_pelunasan'     =>  $total_tagihan,
                                          'i_status'             =>  'Released',
                                          'i_diskon1'            =>  $diskon1,
                                          'i_diskon2'            =>  $diskon2,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_statusprint'        =>  'Released',
                                          'i_kode_pajak'         =>  $request->kode_pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  $cabang,
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
                  // dd($request->do_id);
                 $save_detail_invoice = DB::table('invoice_d')
                                          ->insert([
                                              'id_id'            => $cari_id,
                                              'id_nomor_invoice' => $request->nota_invoice,
                                              'id_nomor_do'      => $request->do_detail[$i],
                                              'create_by'        => Auth::user()->m_name,
                                              'create_at'        => Carbon::now(),
                                              'update_by'        => Auth::user()->m_name,
                                              'update_at'        => Carbon::now(),
                                              'id_tgl_do'        => Carbon::parse($do->tanggal)->format('Y-m-d'),
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
                  $update_do = DB::table('delivery_order')
                                   ->where('nomor',$request->do_detail[$i])
                                   ->update([
                                    'status_do'=>'Approved'
                                   ]);

                                          $request->netto_detail = str_replace(['Rp', '\\', '.', ' '], '', $request->netto_detail);
    $request->netto_detail =str_replace(',', '.', $request->netto_detail);

    $request->diskon2 = str_replace(['Rp', '\\', '.', ' '], '', $request->diskon2);
    $request->diskon2 =str_replace(',', '.', $request->diskon2);
    $diskonItem=$request->diskon2*$request->harga_netto[$i]/$request->netto_detail;
    $totalStlhDiskon=$request->harga_netto[$i]-$diskonItem;    
                      $dataItem[$i]['acc_penjualan']=$request->akun[$i];
                      $dataItem[$i]['dd_diskon']=$request->dd_diskon[$i]; //diskon per item                 
                      /*$dataItem[$i]['dd_total']=$request->dd_total[$i];//total per item sblm diskon*/
                      if($request->cb_jenis_ppn== 3 || $request->cb_jenis_ppn== 5)//include
                      $dataItem[$i]['harga_netto']=(($request->dd_total[$i]-$request->dd_diskon[$i]-$diskonItem)*100
                                                  /(100+$ppn_persen))+$request->dd_diskon[$i]+$diskonItem;//total per item stlh diskon
                      else {
                        $dataItem[$i]['harga_netto']=$request->dd_total[$i];
                      
                      }
                      $dataItem[$i]['diskon2']=$diskonItem;// presentase diskon global
                      $dataItem[$i]['ppn']=$totalStlhDiskon*$nilaiPpn;                      
                      $dataItem[$i]['pajak_lain']=$totalStlhDiskon*($request->pajak_lain/100);


             }


$jurnal=d_jurnal::where('jr_ref', $request->nota_invoice)->where('jr_note','INVOICE');
            if(count($jurnal->first())!=0){
              $jurnal->delete();
            }
if(count($dataItem)==0){
    return response()->json(['status' => 1,'display'=>0]);
}
               $Nilaijurnal=$this->groupJurnal($dataItem);

            foreach ($Nilaijurnal as  $indexakun=> $dataJurnal) {  
              
        if($dataJurnal['acc_penjualan']=='' || $dataJurnal['acc_penjualan']=="null"){
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Pada DO Belum Ada.'];
              DB::rollback();
              return json_encode($dataInfo);
        }

        // return $dataxJurnal['acc_penjualan'];
       $acc=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$dataJurnal['acc_penjualan'].'%')
                  // ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                   
        if(count($acc)!=0){
        $akun[$indexakun]['id_akun']=$acc->id_akun;
        $akun[$indexakun]['value']=round($dataJurnal['totalInvoice'],2);
        $akun[$indexakun]['dk']='K';
        $indexakun++;              
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Belum Tersedia'];
      DB::rollback();
            return json_encode($dataInfo);
        }        
      
    }  

      if($request->accPiutang==''){
            $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Pada Customer Belum Ada.'];
              DB::rollback();
              return json_encode($dataInfo);
        }
      $akunPiutang=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$request->accPiutang.'%')                                    
                  // ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                    

                  if(count($akunPiutang)==0){
                        $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Belum Tersedia'];
                        DB::rollback();
                        return json_encode($dataInfo);
                    }

                $akun[$indexakun]['id_akun']=$akunPiutang->id_akun;
                $akun[$indexakun]['value']=round($total_tagihan,2);
                $akun[$indexakun]['dk']='D';
                $indexakun++;



    if($request->diskon1!=0 || $request->diskon2!=0){
        $akunDiskon=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '5298%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunDiskon)!=0){
                $akun[$indexakun]['id_akun']=$akunDiskon->id_akun;
                $akun[$indexakun]['value']=-(round($diskon1+$diskon2,2));
                $akun[$indexakun]['dk']='D';
                $indexakun++;
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        } 
    }


if($request->cb_jenis_ppn!=4){
      $akunPPN=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$akunPPH.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPN)!=0){

                $akun[$indexakun]['id_akun']=$akunPPN->id_akun;
                $akun[$indexakun]['value']=round($total_ppn,2);
                $akun[$indexakun]['dk']='K';
                $indexakun++;
        }
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        }
}


if($request->pajak_lain!='T' && $request->pajak_lain!='0' && $request->pajak_lain!='undefined'){
          $akunPPH=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '2305%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPH)!=0){            
                $akun[$indexakun]['id_akun']=$akunPPH->id_akun;
                $akun[$indexakun]['value']=-$total_pph;                
                $akun[$indexakun]['dk']='D';
                $indexakun++;
            }                    
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
                      return json_encode($dataInfo);
        }
      }



            
            $id_jurnal=d_jurnal::max('jr_id')+1;
            $id_jrdt=1;
                foreach ($akun as $key => $data) {   
                        
                        $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                        $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt;
                        $jurnal_dt[$key]['jrdt_acc']=$data['id_akun'];
                        $jurnal_dt[$key]['jrdt_value']=$data['value'];
                        $jurnal_dt[$key]['jrdt_statusdk']=$data['dk'];
                        $id_jrdt++;
                }
            d_jurnal::create([
                        'jr_id'=>$id_jurnal,
                        'jr_year'=> date('Y',strtotime($do_awal)),
                        'jr_date'=> $do_awal,
                        'jr_detail'=> 'INVOICE'.' '.$request->ed_pendapatan,
                        'jr_ref'=>  $request->nota_invoice,
                        'jr_note'=> 'INVOICE',
                        ]);
            d_jurnal_dt::insert($jurnal_dt);
           
           

             return response()->json(['status' => 1]);

        }else{

             $bulan = Carbon::now()->format('m');
             $tahun = Carbon::now()->format('y');
             $cabang= Auth::user()->kode_cabang;
             $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                            WHERE i_kode_cabang = '$cabang'
                                            AND to_char(i_tanggal,'MM') = '$bulan'
                                            AND to_char(i_tanggal,'YY') = '$tahun'");
             $index = (integer)$cari_nota[0]->id + 1;
             $index = str_pad($index, 5, '0', STR_PAD_LEFT);
             $nota = 'INV' . Auth::user()->kode_cabang . $bulan . $tahun . $index;

             $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  $nota,
                                          'i_tanggal'            =>  Carbon::now(),
                                          'i_keterangan'         =>  $request->ed_keterangan,
                                          'i_tgl_mulai_do'       =>  $do_awal,
                                          'i_tgl_sampai_do'      =>  $do_akhir,
                                          'i_jatuh_tempo'        =>  $ed_jatuh_tempo,
                                          'i_total'              =>  $total_tagihan,
                                          'i_total_tagihan'      =>  $total_tagihan,
                                          'i_netto_detail'       =>  $netto_total,
                                          'i_sisa_pelunasan'     =>  $total_tagihan,
                                          'i_sisa_akhir'         =>  $total_tagihan,
                                          'i_status'             =>  'Released',
                                          'i_diskon1'            =>  $diskon1,
                                          'i_diskon2'            =>  $diskon2,
                                          'i_netto'              =>  $ed_total,
                                          'i_jenis_ppn'          =>  $request->cb_jenis_ppn,
                                          'i_ppntpe'             =>  $ppn_type,
                                          'i_statusprint'        =>  'Released',
                                          'i_ppnrte'             =>  $ppn_persen,
                                          'i_ppnrp'              =>  $total_ppn,
                                          'i_kode_pajak'         =>  $request->kode_pajak_lain,
                                          'i_pajak_lain'         =>  $total_pph,
                                          'i_tagihan'            =>  $total_tagihan,
                                          'i_kode_customer'      =>  $request->ed_customer,
                                          'i_kode_cabang'        =>  $cabang,
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
                  $update_do = DB::table('delivery_order')
                                   ->where('nomor',$request->do_detail[$i])
                                   ->update([
                                    'status_do'=>'Approved'
                                   ]);

    $request->netto_detail = str_replace(['Rp', '\\', '.', ' '], '', $request->netto_detail);
    $request->netto_detail =str_replace(',', '.', $request->netto_detail);

    $request->diskon2 = str_replace(['Rp', '\\', '.', ' '], '', $request->diskon2);
    $request->diskon2 =str_replace(',', '.', $request->diskon2);
    $diskonItem=$request->diskon2*$request->harga_netto[$i]/$request->netto_detail;
    $totalStlhDiskon=$request->harga_netto[$i]-$diskonItem;    
                      $dataItem[$i]['acc_penjualan']=$request->akun[$i];
                      $dataItem[$i]['dd_diskon']=$request->dd_diskon[$i]; //diskon per item                 
                      /*$dataItem[$i]['dd_total']=$request->dd_total[$i];//total per item sblm diskon*/
                      if($request->cb_jenis_ppn== 3 || $request->cb_jenis_ppn== 5)//include
                      $dataItem[$i]['harga_netto']=(($request->dd_total[$i]-$request->dd_diskon[$i]-$diskonItem)*100
                                                  /(100+$ppn_persen))+$request->dd_diskon[$i]+$diskonItem;//total per item stlh diskon
                      else {
                        $dataItem[$i]['harga_netto']=$request->dd_total[$i];
                      
                      }
                      $dataItem[$i]['diskon2']=$diskonItem;// presentase diskon global
                      $dataItem[$i]['ppn']=$totalStlhDiskon*$nilaiPpn;                      
                      $dataItem[$i]['pajak_lain']=$totalStlhDiskon*($request->pajak_lain/100);
             }

             return response()->json(['status' => 2,'nota'=>$nota]);
        }
    }
     });
        
}


public function edit_invoice($id)
{ 
    // return $id;
    if (auth::user()->punyaAkses('Invoice Penjualan','ubah')) {
      $data = DB::table('invoice')
              ->where('i_nomor',$id)
                ->first();
      $data_dt = DB::table('invoice_d')
                ->join('delivery_order','nomor','=','id_nomor_do')
                ->leftjoin('delivery_orderd','dd_id','=','id_nomor_do_dt')
                ->where('id_nomor_invoice',$id)
                ->get();

      $customer = DB::table('customer')
                  ->get();

      $cabang   = DB::table('cabang')
                  ->get();
      $tgl      = Carbon::now()->format('d/m/Y');
      $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

      $pajak    = DB::table('pajak')
                  ->get();

      $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                          FROM d_akun a join d_jurnal_dt jd
                          on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                          (select j.jr_id from d_jurnal j where jr_ref='$id' and jr_note='INVOICE')")); 

      return view('sales.invoice.editInvoice',compact('customer','cabang','tgl','tgl1','pajak','id','data','data_dt','jurnal_dt'));
    }else{
      return redirect()->back();
    }
   
}
public function cari_do_edit_invoice(request $request)
{
    $do_awal = str_replace('/', '-' ,$request->do_awal);
    $do_akhir = str_replace('/', '-' ,$request->do_akhir);
    $do_awal = Carbon::parse($do_awal)->format('Y-m-d');
    $do_akhir = Carbon::parse($do_akhir)->format('Y-m-d');
    $jenis = $request->cb_pendapatan;
    $id = $request->id;
    if ($request->cb_pendapatan == 'KORAN') {

      $temp = DB::table('delivery_order')
              ->join('delivery_orderd','delivery_orderd.dd_nomor','=','delivery_order.nomor')
              ->leftjoin('invoice_d','delivery_orderd.dd_id','=','invoice_d.id_nomor_do_dt')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

      $temp1 = DB::table('delivery_order')
              ->join('delivery_orderd','delivery_orderd.dd_nomor','=','delivery_order.nomor')
              ->leftjoin('invoice_d','delivery_orderd.dd_id','=','invoice_d.id_nomor_do_dt')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
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
            $temp = array_values($temp);
            $data = $temp;
            
        }else{
            $data = $temp;
        }
    }else if ($request->cb_pendapatan == 'PAKET' || $jenis == 'KARGO') {
        $temp = DB::table('delivery_order')
              ->leftjoin('invoice_d','delivery_order.nomor','=','invoice_d.id_nomor_do')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.tanggal','<=',$do_akhir)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
              ->where('delivery_order.jenis',$request->cb_pendapatan)
              ->where('delivery_order.kode_customer',$request->customer)
              ->get();

        $temp1 = DB::table('delivery_order')
              ->leftjoin('invoice_d','delivery_order.nomor','=','invoice_d.id_nomor_do')
              ->where('delivery_order.tanggal','>=',$do_awal)
              ->where('delivery_order.kode_cabang','=',$request->cabang)
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
    
     $customer = DB::table('customer')
                      ->get();
    for ($i=0; $i < count($data); $i++) { 
      for ($a=0; $a < count($customer); $a++) { 
        if ($data[$i]->kode_customer == $customer[$a]->kode) {
           $data[$i]->nama_customer = $customer[$a]->nama;
        }
      }
    }

    return view('sales.invoice.tableDo',compact('data','jenis','id'));
}

public function hapus_invoice(request $request)
{
  return DB::transaction(function() use ($request) {  

    $cari = DB::table('invoice')
               ->join('invoice_d','id_nomor_invoice','=','i_nomor')
               ->where('i_nomor',$request->id)
               ->get();
    $temp = [];
    for ($i=0; $i < count($cari); $i++) { 
      $update_do = DB::table('delivery_order')
                 ->where('nomor',$cari[$i]->id_nomor_do)
                 ->update([
                  'status_do'=>'Released'
                 ]);
      $temp[$i] = $cari[$i]->id_nomor_do;
    }
    

    $hapus = DB::table('invoice')
               ->where('i_nomor',$request->id)
               ->delete();

    for ($i=0; $i < count($temp); $i++) { 
      $cari_do = DB::table('invoice_d')
                   ->where('id_nomor_do',$temp[$i])
                   ->first();
      if ($cari_do != null) {
        $update_do = DB::table('delivery_order')
                 ->where('nomor',$temp[$i])
                 ->update([
                  'status_do'=>'Approved'
                 ]);
      }
    }
    

    $jurnal=d_jurnal::where('jr_ref', $request->id)->where('jr_note','INVOICE');
        if(count($jurnal->first())!=0){
              $jurnal->delete();
        }
    return 'berhasil';
  });
}

public function update_invoice(request $request)
{
    // dd($request->all());
   

    return $this->simpan_invoice($request);
/*
    $cari_invoice =DB::table('invoice')
                    ->where('i_nomor',$request->nota_invoice)
                    ->first();*/

    /*if ($cari_invoice == null ){
      return response()->json(['status'=>0,'pesan'=>'data tidak berhasil disimpan']);
    }else{
      return response()->json(['status'=>1,'pesan'=>'data berhasil disimpan']);
    }*/
}

  //funngsi Thoriq
 

  public function groupJurnal($data) {
      $groups = array();
      $key = 0;

      foreach ($data as $item) {

          $key = $item['acc_penjualan'];
          if (!array_key_exists($key, $groups)) {
              $groups[$key] = array(                  
                  'acc_penjualan' => $item['acc_penjualan'],                                  
                  'diskon1'       => $item['dd_diskon'],
                  'diskon2'       => $item['diskon2'],
                  'totalInvoice'  => $item['harga_netto'],
                  /*'totalInvoice'  => $item['harga_netto']-$item['diskon2'],*/
                  


              );              
          } else {          
            
              $groups[$key]['totalInvoice'] = $groups[$key]['totalInvoice'] +$item['harga_netto'];        
              /*$groups[$key]['totalInvoice'] = $groups[$key]['totalInvoice'] + ($item['harga_netto']-$item['diskon2']);        */
              $groups[$key]['diskon1'] = $groups[$key]['diskon1'] + $item['dd_diskon']+
                                         $groups[$key]['diskon2'] + $item['diskon2'];   
              $groups[$key]['diskon2'] = $groups[$key]['diskon2'] + $item['diskon2'];        

          }
          $key++;
      }
      return $groups;
  }

    public function lihat_invoice($id)
    {
        $data = DB::table('invoice')
              ->where('i_nomor',$id)
              ->first();
        $data_dt = DB::table('invoice_d')
                  ->join('delivery_order','nomor','=','id_nomor_do')
                  ->leftjoin('delivery_orderd','dd_id','=','id_nomor_do_dt')
                  ->where('id_nomor_invoice',$id)
                  ->get();

        $customer = DB::table('customer')
                    ->get();

        $cabang   = DB::table('cabang')
                    ->get();
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                    ->get();

        $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                            FROM d_akun a join d_jurnal_dt jd
                            on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                            (select j.jr_id from d_jurnal j where jr_ref='$id' and jr_note='INVOICE')")); 

        return view('sales.invoice.lihat_invoice',compact('customer','cabang','tgl','tgl1','pajak','id','data','data_dt','jurnal_dt'));
    }
}
