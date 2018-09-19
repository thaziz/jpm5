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
use Yajra\Datatables\Datatables;
// use Intervention\Image\ImageManagerStatic as Image;
use File;
use Storage;

class invoice_Controller extends Controller
{

    public function datatable_invoice(Request $req)
    {
        $nama_cabang = DB::table("cabang")
                 ->where('kode',$req->cabang)
                 ->first();

        if ($nama_cabang != null) {
          $cabang = 'and i_kode_cabang = '."'$req->cabang'";
        }else{
          $cabang = '';
        }


        if ($req->tanggal_awal != '0') {
          $tgl_awal = carbon::parse($req->tanggal_awal)->format('Y-m-d');
          $tanggal_awal = 'and i_tanggal >= '."'$tgl_awal'";
        }else{
          $tanggal_awal = '';
        }

        if ($req->tanggal_akhir != '0') {
          $tgl_akhir = carbon::parse($req->tanggal_akhir)->format('Y-m-d');
          $tanggal_akhir = 'and i_tanggal <= '."'$tgl_akhir'";
        }else{
          $tanggal_akhir = '';
        }

        if ($req->jenis_biaya != '0') {
          $jenis_biaya = 'and i_pendapatan = '."'$req->jenis_biaya'";
        }else{
          $jenis_biaya = '';
        }


        if ($req->nota != '0') {
          if (Auth::user()->punyaAkses('Invoice','all')) {
            $data = DB::table('invoice')
                  ->where('i_nomor','like','%'.$req->nota.'%')
                  ->get();
            if ($data == null) {
              $data = DB::table('invoice')
                  ->where('i_faktur_pajak','like','%'.$req->nota.'%')
                  ->get();
            }
          }else{
            $cabang = Auth::user()->kode_cabang;
            $data = DB::table('invoice')
                  ->where('i_kode_cabang',$cabang)
                  ->where('i_nomor','=',$req->nota)
                  ->get();
            if ($data == null) {
              $data = DB::table('invoice')
                  ->where('i_kode_cabang',$cabang)
                  ->where('i_faktur_pajak','=',$req->nota)
                  ->get();
            }  
          }
        }else{
          if (Auth::user()->punyaAkses('Invoice','all')) {
            $sql = "SELECT * FROM invoice  join cabang on kode = i_kode_cabang where i_nomor != '0' $cabang $tanggal_awal $tanggal_akhir $jenis_biaya order by invoice.create_at DESC";

            $data = DB::select($sql);
          }else{
            $cabang = Auth::user()->kode_cabang;
            $sql = "SELECT * FROM invoice  join cabang on kode = i_kode_cabang where i_nomor != '0' and i_kode_cabang = '$cabang' $tanggal_awal $tanggal_akhir $jenis_biaya order by invoice.create_at DESC";
            $data = DB::select($sql);
          }
        }


        $data = collect($data);

        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            $b = '';
                            $c = '';
                            $d = '';


                            
                            if($data->i_statusprint == 'Released' or Auth::user()->punyaAkses('Invoice','ubah')){
                                if(cek_periode(carbon::parse($data->i_tanggal)->format('m'),carbon::parse($data->i_tanggal)->format('Y') ) != 0){
                                  $a = '<button type="button" onclick="edit(\''.$data->i_nomor.'\')" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></button>';
                                }
                            }else{
                              $a = '';
                            }

                            if(Auth::user()->punyaAkses('Invoice','print')){
                                $b = '<button type="button" onclick="ngeprint(\''.$data->i_nomor.'\')" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></button>';
                            }else{
                              $b = '';
                            }


                            if($data->i_statusprint == 'Released' or Auth::user()->punyaAkses('Invoice','hapus')){
                                if(cek_periode(carbon::parse($data->i_tanggal)->format('m'),carbon::parse($data->i_tanggal)->format('Y') ) != 0){
                                  $c = '<button type="button" onclick="hapus(\''.$data->i_nomor.'\')" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button>';
                                }
                            }else{
                              $c = '';
                            }


                            $d = '<button title="lihat jurnal" type="button" onclick="lihat_jurnal(\''.$data->i_nomor.'\')" class="btn btn-xs btn-primary btnjurnal"><i class="fa fa-eye"></i></button>';
                 
                            return '<div class="btn-group">'.$a . $b .$c .$d.'</div>' ;
                                   
                        })
                        ->addColumn('customer', function ($data) {
                          $kota = DB::table('customer')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->i_kode_customer == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addColumn('faktur_pajak', function ($data) {
                          if ($data->i_faktur_pajak != null) {
                            return '<button class="btn btn-success" onclick="faktur_pajak(\''.$data->i_nomor.'\')">'.$data->i_faktur_pajak.'</button>';
                          }else{
                            return '<button class="btn btn-danger">BELUM TERFAKTUR PAJAK</button>';
                          }
                        })
                        ->addColumn('cabang', function ($data) {
                          $kota = DB::table('cabang')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->i_kode_cabang == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addColumn('tagihan', function ($data) {
                          return number_format($data->i_total_tagihan,2,',','.'  ); 
                        })
                        ->addColumn('sisa', function ($data) {
                          return number_format($data->i_sisa_pelunasan,2,',','.'  ); 
                        })
                        ->addColumn('status', function ($data) {
                            if($data->i_statusprint == 'Released'){
                              return '<label class="label label-warning">'.$data->i_statusprint.'</label>';
                            }else{
                              return '<label class="label label-success">'.$data->i_statusprint.'</label>';
                            }
                        })
                        ->addIndexColumn()
                        ->make(true);

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

    public function append_table(request $req)
    {
      // dd($req->all());
      if ($req->flag =='global') {
      $cab = $req->cabang;
      $tanggal_awal = $req->tanggal_awal;
      if ($tanggal_awal == '') {
        $tanggal_awal = '0';
      }
      $tanggal_akhir = $req->tanggal_akhir;
      if ($tanggal_akhir == '') {
        $tanggal_akhir = '0';
      }
      $jenis_biaya   = $req->jenis_biaya;
      $nota = '0';
    }else{
      $cab = '0';
      $tanggal_awal  = '0';
      $tanggal_akhir = '0';
      $jenis_biaya   = '0';
      $nota = $req->nota;
    }
      return view('sales.invoice.table_invoice',compact('cab','tanggal_awal','tanggal_akhir','jenis_biaya','nota'));
    }

    public function index(){

        // $cabang = DB::table('cabang')
        //             ->get();

        // for ($i=0; $i < count($cabang); $i++) { 
        //   $insert = DB::table('d_akun')
        //               ->insert([
        //                 'id_akun'
        //               ])
        // }

        $cabang = DB::table('cabang')
                    ->get();
        $kota = DB::table('kota')
                  ->get();
        return view('sales.invoice.index',compact('data','cabang'));
    }

    public function form(){
        $customer = DB::table('customer')
                      ->where('nama','!=','NON MEMBER')
                      ->where('nama','!=','NON CUSTOMER')
                      ->where('pic_status','=','AKTIF')
                      ->get();

        $cabang   = DB::table('cabang')
                      ->get();
        $kota     = DB::table('kota')
                      ->get();

        $gp     = DB::table('grup_item')
                      ->get();

 
        // return $customer;
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                      ->get();

        return view('sales.invoice.form',compact('customer','cabang','tgl','tgl1','pajak','gp','kota'));
    }


    public function cetak_nota($id) {
        $id = str_replace('-', '/', $id);
        $head = DB::table('invoice')
                  ->join('customer','kode','=','i_kode_customer')
                  ->where('i_nomor',$id)
                  ->first();

        if ($head->i_pendapatan == 'KARGO' or $head->i_pendapatan == 'PAKET') {
           $detail = DB::table('invoice_d')
                    ->join('delivery_order','id_nomor_do','=','nomor')
                    ->orderBy('tanggal','ASC')
                    ->where('id_nomor_invoice',$id)
                    ->get();
        }else{
           $detail = DB::table('invoice_d')
                    ->join('delivery_orderd','id_nomor_do_dt','=','dd_id')
                    ->where('id_nomor_invoice',$id)
                    ->get();
        }
        $counting = count($detail); 

        if ($head->i_faktur_pajak == null) {
          $faktur_pajak = DB::table('nomor_seri_pajak')
                            ->where('nsp_aktif',true)
                            ->orderBy('nsp_id','ASC')
                            ->first();
          if ($faktur_pajak != null) {
            $update_status = DB::table('invoice')
                               ->where('i_nomor',$id)
                               ->update([
                                'i_statusprint'=>'Printed',
                                'i_faktur_pajak'=>$faktur_pajak->nsp_nomor_pajak
                               ]);

            $update_pajak = DB::table('nomor_seri_pajak')
                              ->where('nsp_nomor_pajak',$faktur_pajak->nsp_nomor_pajak)
                              ->update([
                                'nsp_aktif'=>false
                               ]);
          }else{
            $update_status = DB::table('invoice')
                               ->where('i_nomor',$id)
                               ->update([
                                'i_statusprint'=>'Printed',
                               ]);
          }
          
        }
        
                           
        if ($counting < 30) {
          $hitung =30 - $counting;
          for ($i=0; $i < $hitung; $i++) { 
            $push[$i]=' ';
          }
        }else{
          $push = [];
        }

        $master_bank = DB::table('masterbank')
                         ->where('mb_id',4)
                         ->first();

        $kepala_cabang = DB::table('d_mem')
                         ->where('m_level','KEPALA CABANG')
                         ->where('kode_cabang',Auth::user()->kode_cabang)
                         ->first();
        // return $push;
        $terbilang = $this->penyebut($head->i_total_tagihan);
        if ($head->i_pendapatan == 'PAKET' or $head->i_pendapatan == 'KARGO') {
          return view('sales.invoice.print',compact('head','detail','terbilang','push','master_bank','kepala_cabang'));
        }else{
          return view('sales.invoice.print_1',compact('head','detail','terbilang','push','master_bank','kepala_cabang'));
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
    $bulan = Carbon::parse(str_replace('/', '-', $request->tgl))->format('m');
    $tahun = Carbon::parse(str_replace('/', '-', $request->tgl))->format('y');
    // $update = DB::table('invoice')
    //             ->update(['create_at'=>carbon::now()
    //           ]);
    // return 'asd';
    $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                    WHERE i_kode_cabang = '$request->cabang'
                                    AND i_nomor like 'INV%'
                                    AND to_char(i_tanggal,'MM') = '$bulan'
                                    AND to_char(i_tanggal,'YY') = '$tahun'
                                    ");
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

public function drop_cus(request $request)
{
  $customer = DB::table('customer')
                      ->where('cabang',$request->cabang)
                      ->get();
  return view('sales.invoice.dropdown_customer',compact('customer'));
}
public function cari_do_invoice(request $request)
{   
    // dd($request->all());
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
              ->where('delivery_orderd.dd_grup',$request->grup_item)  
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
              ->where('delivery_orderd.dd_grup',$request->grup_item)  
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
    if (!isset($request->flag)) {
      for ($i=0; $i < count($data1); $i++) { 
        if ($data1[$i]->ipd_nomor_invoice !=null) {
            unset($data[$i]);
        }
      }

      $data = array_values($data);
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
            $cari_do[$i]->harga_netto = $cari_do[$i]->total + $cari_do[$i]->biaya_tambahan - $cari_do[$i]->diskon;

        }

    }else if ($jenis == 'KARGO') {
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
  DB::BeginTransaction();
  try{
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
    $tgl = str_replace('/', '-', $request->tgl);
    $tgl = Carbon::parse($tgl)->format('Y-m-d');

    $total_tagihan  = filter_var($request->total_tagihan, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $netto_total    = filter_var($request->netto_total, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $diskon1        = filter_var($request->diskon1, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $diskon2        = filter_var($request->diskon2, FILTER_SANITIZE_NUMBER_FLOAT);
    $ed_total       = filter_var($request->ed_total, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $total_ppn      = filter_var($request->ppn, FILTER_SANITIZE_NUMBER_FLOAT)/100;
    $total_pph      = filter_var($request->pph, FILTER_SANITIZE_NUMBER_FLOAT)/100;

    if ($request->ed_pendapatan == 'PAKET') {
      $cari_acc_piutang1 = DB::table('d_akun')
                            ->where('id_akun','like','1303'.'%')
                            ->where('kode_cabang',$cabang)
                            ->first();
      $cari_acc_piutang = $cari_acc_piutang1->id_akun;
    }else if($request->ed_pendapatan == 'KARGO'){
      $cari_acc_piutang1 = DB::table('d_akun')
                            ->where('id_akun','like','1302'.'%')
                            ->where('kode_cabang',$cabang)
                            ->first();
      $cari_acc_piutang = $cari_acc_piutang1->id_akun;
    }else if($request->ed_pendapatan == 'KORAN'){
      $cari_acc_piutang = $request->acc_piutang;
    }
    // dd($cari_acc_piutang);
    $cari_no_invoice = DB::table('invoice')
                         ->where('i_nomor',$request->nota_invoice)
                         ->first();

    $request->netto_detail = str_replace(['Rp', '\\', '.', ' '], '', $request->netto_detail);
    $request->netto_detail =str_replace(',', '.', $request->netto_detail);

    $request->diskon2 = str_replace(['Rp', '\\', '.', ' '], '', $request->diskon2);
    $request->diskon2 =str_replace(',', '.', $request->diskon2);
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
    if (Auth::user()->m_name == null) {
      DB::rollBack();
      return response()->json([
        'status'=>0,
        'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
      ]);
    }

    $cari_nota = DB::table('invoice')
             ->where('i_nomor',$request->nota_invoice)
             ->first();
    if ($cari_nota != null) {
      if ($cari_nota->update_by == $user) {
        return 'Data Sudah Ada';
      }else{
          $bulan = Carbon::parse($tgl)->format('m');
          $tahun = Carbon::parse($tgl)->format('y');

          $cari_nota = DB::select("SELECT  substring(max(i_nomor),11) as id from invoice
                                  WHERE i_kode_cabang = '$cabang'
                                  AND i_nomor like 'INV%'
                                  AND to_char(i_tanggal,'MM') = '$bulan'
                                  AND to_char(i_tanggal,'YY') = '$tahun'
                                  ");

          $index = (integer)$cari_nota[0]->id + 1;
          $index = str_pad($index, 3, '0', STR_PAD_LEFT);

        
        $nota = 'INV' . $bulan . $tahun . '/' . $cabang . '/' .$index;
      }
    }elseif ($cari_nota == null) {
      $nota = $request->nota_invoice;
    }
    $nota= str_replace(' ', '', $nota);
    $nota= str_replace('  ', '', $nota);
    if ($request->ed_pendapatan == 'PAKET' || $request->ed_pendapatan == 'KARGO') {
            $save_header_invoice = DB::table('invoice')
                                     ->insert([
                                          'i_nomor'              =>  strtoupper($nota),
                                          'i_tanggal'            =>  $tgl,
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
                                          'i_grup_item'          =>  $request->grup_item,
                                          'i_acc_piutang'        =>  $cari_acc_piutang,
                                          'i_csf_piutang'        =>  $cari_acc_piutang,
                                          'i_grup_item'          =>  $request->grup_item,
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
                                            'id_nomor_invoice' => strtoupper($nota),
                                            'id_nomor_do'      => $request->do_detail[$i],
                                            'create_by'        => Auth::user()->m_name,
                                            'create_at'        => Carbon::now(),
                                            'update_by'        => Auth::user()->m_name,
                                            'update_at'        => Carbon::now(),
                                            'id_tgl_do'        => $do->tanggal,
                                            'id_jumlah'        => $request->dd_jumlah[$i],
                                            'id_keterangan'    => $do->deskripsi,
                                            'id_harga_satuan'  => $do->tarif_dasar,
                                            'id_harga_bruto'   => $request->dd_total[$i],
                                            'id_diskon'        => $request->dd_diskon[$i],
                                            'id_harga_netto'   => $request->harga_netto[$i],
                                            'id_kode_satuan'   => $do->kode_satuan,
                                            'id_kuantum'       => $do->jumlah,
                                            'id_kode_item'     => 'tidak ada',
                                            'id_tipe'          => 'tidak tahu',
                                            'id_acc_penjualan' => $request->akun[$i],
                                        ]);
              $update_do = DB::table('delivery_order')
                                 ->where('nomor',$request->do_detail[$i])
                                 ->update([
                                  'status_do'=>'Approved'
                                 ]);
 
                  
          }


          // //JURNALv
          $id_jurnal=d_jurnal::max('jr_id')+1;
          // dd($id_jurnal);
          $delete = d_jurnal::where('jr_ref',$nota)->delete();
          $mm =  get_id_jurnal('MM', $request->cb_cabang);
          $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                        'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
                        'jr_date'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
                        'jr_detail' => 'INVOICE ' . $request->ed_pendapatan,
                        'jr_ref'    => strtoupper($nota),
                        'jr_note'   => 'INVOICE '.$request->ed_keterangan,
                        'jr_insert' => carbon::now(),
                        'jr_update' => carbon::now(),
                        'jr_no'     => $mm,
                        ]);

          if ($request->ed_pendapatan == 'PAKET') {

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
 
                    $tot_own1 = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/$request->netto_detail * $tot_own;
                    $tot_vendor1 = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/$request->netto_detail * $tot_vendor;
                    $tot_own -= $tot_own1;
                    $tot_vendor -= $tot_vendor1;
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
                    DB::rollBack();

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
                    DB::rollBack();
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
                      DB::rollBack();

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
                    DB::rollBack();

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
                    DB::rollBack();

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
                    DB::rollBack();

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
                      DB::rollBack();

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
                    DB::rollBack();

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
                    DB::rollBack();

                    return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                  }
                  array_push($akun, $akun_own->id_akun);
                  array_push($akun_val, $tot_own);
                }
              }
          }elseif ($request->ed_pendapatan == 'KARGO'){
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
       
                  $tot_own1 = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/$request->netto_detail * $tot_own;
                  $tot_subcon1 = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/$request->netto_detail * $tot_subcon;
                  $tot_own -= $tot_own1;
                  $tot_subcon -= $tot_subcon1;
    
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
                    DB::rollBack();

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
                    DB::rollBack();
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
                      DB::rollBack();

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
                    DB::rollBack();

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
                    DB::rollBack();

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
                    DB::rollBack();

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
                      DB::rollBack();

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
                    DB::rollBack();

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
                    DB::rollBack();

                    return response()->json(['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
                  }
                  array_push($akun, $akun_own->id_akun);
                  array_push($akun_val, $tot_own);
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
            }
          }

          $jurnal_dt = d_jurnal_dt::insert($data_akun);

          $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
          // dd($lihat);
          $check = check_jurnal(strtoupper($nota));


          if ($check == 0) {
            DB::rollBack();
            return response()->json(['status' => 'gagal','info'=>'Jurnal Tidak Balance Gagal Simpan']);
          }
          DB::commit();
          return response()->json(['status' => 1]);

    }else if($request->ed_pendapatan == 'KORAN'){

      $save_header_invoice = DB::table('invoice')
                               ->insert([
                                    'i_nomor'              =>  strtoupper($nota),
                                    'i_tanggal'            =>  $tgl,
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
                                    'i_acc_piutang'        =>  $cari_acc_piutang,
                                    'i_csf_piutang'        =>  $cari_acc_piutang,
                                    'create_at'            =>  Carbon::now(),
                                    'update_by'            =>  Auth::user()->m_name,
                                    'i_grup_item'          =>  $request->grup_item,
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
                                      'id_nomor_invoice' => strtoupper($nota),
                                      'id_nomor_do'      => $request->do_detail[$i],
                                      'create_by'        => Auth::user()->m_name,
                                      'create_at'        => Carbon::now(),
                                      'update_by'        => Auth::user()->m_name,
                                      'update_at'        => Carbon::now(),
                                      'id_tgl_do'        => Carbon::parse($do->tanggal)->format('Y-m-d'),
                                      'id_jumlah'        => $request->dd_jumlah[$i],
                                      'id_keterangan'    => $do->dd_keterangan,
                                      'id_harga_satuan'  => $do->dd_harga,
                                      'id_harga_bruto'   => $request->dd_total[$i],
                                      'id_diskon'        => $request->dd_diskon[$i],
                                      'id_harga_netto'   => $request->harga_netto[$i],
                                      'id_kode_satuan'   => $do->dd_kode_satuan,
                                      'id_kuantum'       => $do->dd_jumlah,
                                      'id_kode_item'     => $do->dd_kode_item,
                                      'id_tipe'          => 'tidak tahu',
                                      'id_acc_penjualan' => $request->akun[$i],
                                      'id_nomor_do_dt'   => $request->do_id[$i]
                                  ]);
          $update_do = DB::table('delivery_order')
                           ->where('nomor',$request->do_detail[$i])
                           ->update([
                            'status_do'=>'Approved'
                           ]);

        }

        // //JURNAL
        $id_jurnal=d_jurnal::max('jr_id')+1;
        // dd($id_jurnal);
        $delete = d_jurnal::where('jr_ref',$nota)->delete();
        $save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
                      'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
                      'jr_date'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
                      'jr_detail' => 'INVOICE ' . $request->ed_pendapatan,
                      'jr_ref'    => $nota,
                      'jr_note'   => 'INVOICE '.$request->ed_keterangan,
                      'jr_insert' => carbon::now(),
                      'jr_update' => carbon::now(),
                      ]); 

        $pendapatan_koran = [];
        $harga_koran      = [];
        for ($i=0; $i < count($request->do_detail); $i++) { 
          $do = DB::table('delivery_orderd')
                  ->where('dd_nomor',$request->do_detail[$i])
                  ->where('dd_id',$request->do_id[$i])
                  ->first();
          $temp = DB::table('item')
                    ->where('kode',$do->dd_kode_item)
                    ->first();
          // dd($temp);          
          array_push($pendapatan_koran, $temp->acc_penjualan);
        }

        $pendapatan_koran = array_unique($pendapatan_koran);

        for ($i=0; $i < count($pendapatan_koran); $i++) { 
          for ($a=0; $a < count($request->do_detail); $a++) { 
            $do = DB::table('delivery_orderd')
                  ->where('dd_nomor',$request->do_detail[$a])
                  ->where('dd_id',$request->do_id[$a])
                  ->first();
            $temp = DB::table('item')
                      ->where('kode',$do->dd_kode_item)
                      ->first();
            if ($temp->acc_penjualan == $pendapatan_koran[$i]) {
              if (!isset($harga_koran[$i])) {
                $harga_koran[$i] = 0;
              }

              $harga_koran[$i] += $request->harga_netto[$a];
            }
          }
        }


        $akun     = [];
        $akun_val = [];
        if ($request->cb_jenis_ppn != 4) {
          // MENAMBAH TOTAL TAGIHAN DAN MENGURANGI TOTAL TAGIHAN
          if ($ppn_type == 'npkp') {
            for ($i=0; $i < count($pendapatan_koran); $i++) { 
              $harga_koran1 = (filter_var($request->ppn,FILTER_SANITIZE_NUMBER_INT)/100)/$request->netto_detail * $harga_koran[$i];
              $harga_koran[$i] -= $harga_koran1;
            }
          }
          // PIUTANG
          // dd(substr($cari_acc_piutang,0, 4));
          $akun_piutang = DB::table('d_akun')
                          ->where('id_akun','like',substr($cari_acc_piutang,0, 4).'%')
                          ->where('kode_cabang',$cabang)
                          ->first();
          if ($akun_piutang == null) {
            DB::rollBack();

            return response()->json(['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
          }
          array_push($akun, $akun_piutang->id_akun);
          array_push($akun_val, $total_tagihan);

          // DISKON
          if ($request->diskon2 != 0) {
            $akun_diskon = DB::table('d_akun')
                          ->where('id_akun','like','5398'.'%')
                          ->where('kode_cabang',$cabang)
                          ->first();
            if ($akun_diskon == null) {
              DB::rollBack();

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
              DB::rollBack();
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
                DB::rollBack();

                return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
              }
              array_push($akun, $akun_pph->id_akun);
              array_push($akun_val,(filter_var($request->pph,FILTER_SANITIZE_NUMBER_INT)/100));
            }
          }
          
          // JURNAL PENDAPATAN
          for ($i=0; $i < count($pendapatan_koran); $i++) { 
             $akun_pendapatan = DB::table('d_akun')
                                  ->where('id_akun','like',substr($pendapatan_koran[$i],0, 4).'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
            if ($akun_pendapatan == null) {
              DB::rollBack();

              return response()->json(['status'=>'gagal','info'=>'Terdapat Akun Pendapatan Yang Tidak Tersedia Untuk Cabang Ini, Harap Hubungi Pihak Terkait']);
            }
            array_push($akun, $akun_pendapatan->id_akun);
            array_push($akun_val,$harga_koran[$i]);
          }
        }else{
          // NON PPN
         // PIUTANG
          $akun_piutang = DB::table('d_akun')
                          ->where('id_akun','like',substr($cari_acc_piutang,0, 4).'%')
                          ->where('kode_cabang',$cabang)
                          ->first();
          if ($akun_piutang == null) {
            DB::rollBack();

            return response()->json(['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
          }
          array_push($akun, $akun_piutang->id_akun);
          array_push($akun_val, $total_tagihan);

          // DISKON
          if ($request->diskon2 != 0) {
            $akun_diskon = DB::table('d_akun')
                          ->where('id_akun','like','5398'.'%')
                          ->where('kode_cabang',$cabang)
                          ->first();
            if ($akun_diskon == null) {
              DB::rollBack();

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
              DB::rollBack();
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
                DB::rollBack();

                return response()->json(['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Ini Tidak Tersedia, Harap Hubungi Pihak Terkait']);
              }
              array_push($akun, $akun_pph->id_akun);
              array_push($akun_val,(filter_var($request->pph,FILTER_SANITIZE_NUMBER_INT)/100));
            }
          }
          // JURNAL PENDAPATAN
          for ($i=0; $i < count($pendapatan_koran); $i++) { 
             $akun_pendapatan = DB::table('d_akun')
                                  ->where('id_akun','like',substr($pendapatan_koran[$i],0, 4).'%')
                                  ->where('kode_cabang',$cabang)
                                  ->first();
            if ($akun_pendapatan == null) {
              DB::rollBack();

              return response()->json(['status'=>'gagal','info'=>'Terdapat Akun Pendapatan Yang Tidak Tersedia Untuk Cabang Ini, Harap Hubungi Pihak Terkait']);
            }
            array_push($akun, $akun_pendapatan->id_akun);
            array_push($akun_val,$harga_koran[$i]);
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
        }
        else if (substr($akun[$i],0, 1)==5) {

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

      $jurnal_dt = d_jurnal_dt::insert($data_akun);

      $lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
      $check = check_jurnal($nota);

      if ($check == 0) {
        DB::rollBack();
        return response()->json(['status' => 'gagal','info'=>'Jurnal Tidak Balance Gagal Simpan']);
      }
      // dd($lihat);
      DB::commit();
      return response()->json(['status' => 1]);
    }
  }catch(Exception $er){
    DB::rollBack();
  }
}


public function edit_invoice($id)
{ 
    // return $id;
    $id = str_replace('-', '/', $id);
    if (auth::user()->punyaAkses('Invoice','ubah')) {
      $data = DB::table('invoice')
              ->where('i_nomor',$id)
                ->first();
      $data_dt = DB::table('invoice_d')
                ->join('delivery_order','nomor','=','id_nomor_do')
                ->leftjoin('delivery_orderd','dd_id','=','id_nomor_do_dt')
                ->where('id_nomor_invoice',$id)
                ->get();

      $customer = DB::table('customer')
                    ->where('pic_status','=','AKTIF')
                    ->get();
                    
      $kota     = DB::table('kota')
                      ->get();     
      $cabang   = DB::table('cabang')
                  ->get();
      $tgl      = Carbon::now()->format('d/m/Y');
      $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

      $pajak    = DB::table('pajak')
                  ->get();

      $gp     = DB::table('grup_item')
                  ->get();



      $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                          FROM d_akun a join d_jurnal_dt jd
                          on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                          (select j.jr_id from d_jurnal j where jr_ref='$id' and jr_note='INVOICE')")); 

      return view('sales.invoice.editInvoice',compact('customer','cabang','tgl','tgl1','pajak','id','data','data_dt','jurnal_dt','kota','gp'));
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
        $id = str_replace('-', '/', $id);
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



    public function jurnal1(request $req)
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


    public function pajak_invoice(request $request)
    {

        $id = $request->invoice;
        $data = DB::table('nomor_seri_pajak')
                  ->where('nsp_nomor_pajak',$request->nomor_pajak)
                  ->first();

        $file = $request->file('file');
        if ($file != null) {
          $filename = 'nomor_seri_pajak/faktur_pajak_'.$data->nsp_id.'.'.$file->getClientOriginalExtension();
          Storage::put($filename,file_get_contents($file));
        }else{
          $filename = $data->nsp_pdf;
        }

        $save = DB::table('nomor_seri_pajak')
                  ->where('nsp_nomor_pajak',$request->nomor_pajak)
                  ->update([
                    'nsp_pdf'=>$filename,
                  ]);

        return response()->json(['status'=>1]);
    }

    public function cari_nomor_pajak(Request $req)
    {
      $data = DB::table('nomor_seri_pajak')
                ->leftjoin('invoice','i_id_pajak','=','nsp_id')
                ->where('nsp_aktif',true)
                ->where('i_id_pajak',null)
                ->get();

      $temp = DB::table('nomor_seri_pajak')
                ->join('invoice','i_id_pajak','=','nsp_id')
                ->where('i_nomor',$req->invoice)
                ->get();
      $data = array_merge($data,$temp);

      return view('sales.invoice.append_modal',compact('data'));
    }
    public function cari_faktur_pajak(request $req)
    {
        $data = DB::table('nomor_seri_pajak')
                ->join('invoice','i_faktur_pajak','=','nsp_nomor_pajak')
                ->where('i_nomor',$req->nomor)
                ->first();
        return response()->json(['data'=>$data]);
    }

    public function jurnal_all(request $req)
    {
      if (Auth::user()->punyaAkses('Invoice','cabang')) {

          $data= DB::table('d_jurnal')
             ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
             ->join('d_akun','jrdt_acc','=','id_akun')
             ->where('jr_detail','like','INVOICE%')
             // ->where('jr_date','>=','2018-07-30')
             ->get();
        

        $head= DB::table('d_jurnal')
             ->where('jr_detail','like','INVOICE%')
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
        // $bpk = [];
        // for ($i=0; $i < count($head); $i++) { 
        //  $bpk[$i] = $data = DB::table('d_jurnal')
        //             ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
        //             ->join('d_akun','jrdt_acc','=','id_akun')
        //             ->where('jr_ref',$head[$i]->jr_ref)
        //             ->get();
        // }

        // $tidak_sama = [];
        // for ($i=0; $i < count($bpk); $i++) { 
        //  $d = 0;
        //  $k = 0;
        //  for ($a=0; $a < count($bpk[$i]); $a++) { 
        //    if ($bpk[$i][$a]->jrdt_statusdk == 'D') {
        //      $d += $bpk[$i][$a]->jrdt_value;
        //    }else{
        //      $k += $bpk[$i][$a]->jrdt_value;
        //    }
        //  }
        //  if ($k < 0) {
        //    $k*=-1;
        //  }
        //  if ($d != $k) {
        //    array_push($tidak_sama, $bpk[$i][0]->jr_ref);
        //  }
        // }
        // $tidak_sama = array_unique($tidak_sama);
        // $tidak_sama = array_values($tidak_sama);
        // dd($tidak_sama);

        $d = array_values($d);
        $k = array_values($k);

        $d = array_sum($d);
        $k = array_sum($k);
        $d = round($d);
        $k = round($k);
        return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
      }
    }

}
