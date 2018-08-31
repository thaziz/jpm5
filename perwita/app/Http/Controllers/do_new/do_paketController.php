<?php

namespace App\Http\Controllers\do_new;
ini_set('max_execution_time', 3600);
use App\biaya_penerus;
use App\do_dt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\master_akun;
Use App\d_jurnal;
Use App\d_jurnal_dt;
use PDF;
use Auth;
use Carbon\carbon;
use Yajra\Datatables\Datatables;    
class do_paketController extends Controller
{
   

//INDEX
   public function index()
   {
  	 	$authe = Auth::user()->kode_cabang; 
	    if (Auth::user()->punyaAkses('Delivery Order','all')) {
	    $sql = "SELECT d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
	                FROM delivery_order d
	                JOIN kota k ON k.id=d.id_kota_asal
	                JOIN kota kk ON kk.id=d.id_kota_tujuan
	                join customer c on d.kode_customer = c.kode 
	                join cabang cc on d.kode_cabang = cc.kode 
	                WHERE d.jenis='PAKET'
	                ";
	    }
	    else{
	    $sql = "SELECT d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
	                FROM delivery_order d
	                JOIN kota k ON k.id=d.id_kota_asal
	                JOIN kota kk ON kk.id=d.id_kota_tujuan
	                join customer c on d.kode_customer = c.kode 
	                join cabang cc on d.kode_cabang = cc.kode 
	                WHERE d.jenis='PAKET'
	                and kode_cabang = '$authe'
	                 ";
	    }
	    

	    $do = DB::select($sql);
	    $kota = DB::table('kota')->get();
	    $kota1= DB::table('kota')->get();
	    $cabang= DB::table('cabang')->get();
	    $customer= DB::table('customer')->get();
	    return view('sales.do_new.index', compact('customer','do','kota','kota1','cabang'));
   }


//DATATABLE 
   public function datatable_deliveryorder_paket(Request $request)
   {
   		$nomor = strtoupper($request->input('nomor'));
        $authe = Auth::user()->kode_cabang; 
        if (Auth::user()->punyaAkses('Delivery Order','all')) {
        $sql = "SELECT d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    JOIN kota k ON k.id=d.id_kota_asal
                    JOIN kota kk ON kk.id=d.id_kota_tujuan
                    join customer c on d.kode_customer = c.kode 
                    join cabang cc on d.kode_cabang = cc.kode 
                    WHERE d.jenis='PAKET'
                    ";
        }
        else{
        $sql = "SELECT d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    JOIN kota k ON k.id=d.id_kota_asal
                    JOIN kota kk ON kk.id=d.id_kota_tujuan
                    join customer c on d.kode_customer = c.kode 
                    join cabang cc on d.kode_cabang = cc.kode 
                    WHERE d.jenis='PAKET'
                    and kode_cabang = '$authe'
                     ";
        }

        $list = DB::select($sql);
        $data = collect($list);

        return Datatables::of($data)
                ->addColumn('button', function ($data) {
                  return  '<div class="btn-group">'.
                           '<a href="deliveryorder_paket/'.$data->nomor.'/edit_deliveryorder_paket" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>'.
                            '<a href="deliveryorderform/'.$data->nomor.'/nota" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></a>'.
                            '<a href="deliveryorder_paket/'.$data->nomor.'/hapus_deliveryorder_paket" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>'.
                          '</div>';
                })
                ->make(true);
   }

   public function hapus_deliveryorder_paket(Request $request,$nomor)
    {
      $data = DB::table('delivery_order')->where('nomor',$nomor)->delete();
      return redirect('sales/deliveryorder_paket');
    }

//FORM CREATE DO PAKET
   public function create_deliveryorder_paket(Request $request)
   {
        
        $kota = DB::select("SELECT id,nama FROM kota ORDER BY nama ASC ");
        $kecamatan = DB::select(" SELECT id,nama FROM kecamatan ORDER BY nama ASC ");
        $masterbank = DB::select(" SELECT mb_kode,mb_nama FROM masterbank where mb_sericek is null ORDER BY mb_kode ASC ");

        $customer = DB::table('customer as c')
                             ->select('c.kode','c.nama','c.alamat','c.telpon','kc.kc_aktif','kcd.kcd_jenis')
                             ->leftjoin('kontrak_customer as kc','kc.kc_kode_customer','=','c.kode')
                             ->leftjoin('kontrak_customer_d as kcd','kcd.kcd_kode','=','kc.kc_nomor')
                             ->groupBy('kc.kc_aktif','c.kode','kcd.kcd_jenis')
                             ->where('kcd.kcd_jenis','=','PAKET')
                             ->where('pic_status','=','AKTIF')
                             ->orderBy('c.kode','ASC')
                             ->get();

        if ($customer == null) {
            $cus = DB::table('customer as c')
                             ->select('c.kode','c.nama','c.alamat','c.telpon')
                             ->get();
        }else{
            $temp= [];
            for ($i=0; $i < count($customer); $i++) { 
                $temp[$i]=$customer[$i]->kode;
            }
            $cus = DB::table('customer as c')
                             ->select('c.kode','c.nama','c.alamat','c.telpon')
                             ->whereNotIn('c.kode',$temp)
                             ->get();
        }
        
        $kendaraan = DB::select(" SELECT nopol FROM kendaraan ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
        $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        $authe = Auth::user()->kode_cabang; 


        $kec = null;
        $do = null;
        $do_dt = null;

        $do = null;
        $jml_detail = 0;
        


        if ($authe == '000') {
            $cabang = DB::select(" select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y group by kode order by kode asc ");
        }else{
            $cabang = DB::select(" select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y where kode = '$authe' group by kode order by kode asc ");
        }

        return view('sales.do_new.create', compact('kota', 'customer', 'kendaraan', 'marketing', 'angkutan', 'outlet', 'do', 'jml_detail', 'cabang', 'jurnal_dt', 'kecamatan', 'kec', 'do_dt','cek_data','cus','do_dt','masterbank'));
   }

//CARI NOMOR DO PAKET
   public function cari_nomor_deliveryorder_paket(Request $request){
        // dd($request->all());
		    $tanggal = strtoupper($request->b);
        $kode_cabang = strtoupper($request->a);
        $tanggal = date_create($tanggal);
        $tanggal = date_format($tanggal, 'ym');

	      $sql = " SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
	             FROM delivery_order WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' AND jenis='PAKET'
	             AND nomor LIKE '%PAK" . $kode_cabang . $tanggal . "%' ";
        $list = collect(\DB::select($sql))->first();
        
        if ($list->nomor == '') {
            $data['nomor'] = 'PAK' . $kode_cabang . $tanggal . '00001';
        } else {
            $kode = substr_replace('00000', $list->nomor, -strlen($list->nomor));
            $data['nomor'] = 'PAK' . $kode_cabang . $tanggal . $kode;
        }

        if ($request->a == '') {
            $kodekode = '';
        }else{
            $kodekode = $data['nomor'];
        }

        return response()->json(['nomor'=>$kodekode]);
    }


//CARI KECAMATAN DO PAKET
    public function cari_kecamatan_deliveryorder_paket(Request $request)
    {
        // dd($request->all());
  	  $req_kec = $request->a; 
      $kecamatan = DB::select(DB::raw(" SELECT id,nama,id_kota FROM kecamatan WHERE id_kota = $req_kec ORDER BY nama ASC "));

      return $kecamatan;
    }

//CARI VENDOR 
    public function cari_vendor_deliveryorder_paket(Request $request)
    {
        // dd($request->all());
      $asal = $request->a;
      $tujuan = $request->b;
      $cabang = $request->c;
      $jenis = $request->d;
      $type = $request->e;
      $berat = $request->f;

      //jenis jika kosong
      if ($jenis != '' || $jenis != null ) {
          $jenis_sql = "and tarif_vendor.jenis = '$request->d'";
      }else{
          $jenis_sql = '';
      }        

      if ($type == 'DOKUMEN') {
         $vendor = DB::select("SELECT vendor.nama,jenis,tujuan.nama as tuj,asal.nama as as,id_tarif_vendor,id_kota_asal_vendor,id_kota_tujuan_vendor,
                                    tarif_vendor.cabang_vendor,kode,tarif_dokumen as tarif_vendor,waktu_vendor,tarif_vendor.status from tarif_vendor 
                                        left join vendor on tarif_vendor.vendor_id = vendor.kode
                                        left join kota as asal on tarif_vendor.id_kota_asal_vendor = asal.id
                                        left join kota as tujuan on tarif_vendor.id_kota_tujuan_vendor = tujuan.id
                                        where id_kota_asal_vendor = $asal
                                        and id_kota_tujuan_vendor = $tujuan
                                        and tarif_vendor.cabang_vendor = '$cabang'
                                        and tarif_vendor.status = 'ya'
                                        $jenis_sql
                                    ");
      }else if($type == 'KILOGRAM'){
        if ($berat < 10) {
            $vendor = DB::select("SELECT vendor.nama,jenis,tujuan.nama as tuj,asal.nama as as,id_tarif_vendor,id_kota_asal_vendor,id_kota_tujuan_vendor,
                                        tarif_vendor.cabang_vendor,kode,(tarif_vendor*$berat) as tarif_vendor,waktu_vendor,tarif_vendor.status from tarif_vendor 
                                            left join vendor on tarif_vendor.vendor_id = vendor.kode
                                            left join kota as asal on tarif_vendor.id_kota_asal_vendor = asal.id
                                            left join kota as tujuan on tarif_vendor.id_kota_tujuan_vendor = tujuan.id
                                            where id_kota_asal_vendor = $asal
                                            and id_kota_tujuan_vendor = $tujuan
                                            and tarif_vendor.cabang_vendor = '$cabang'
                                            and tarif_vendor.status = 'ya'
                                            and keterangan = 'Tarif Kertas / Kg'
                                            $jenis_sql
                                    ");
        }else if($berat == 10){
            $vendor = DB::select("SELECT vendor.nama,jenis,tujuan.nama as tuj,asal.nama as as,id_tarif_vendor,id_kota_asal_vendor,id_kota_tujuan_vendor,
                                        tarif_vendor.cabang_vendor,kode,tarif_vendor,waktu_vendor,tarif_vendor.status from tarif_vendor 
                                            left join vendor on tarif_vendor.vendor_id = vendor.kode
                                            left join kota as asal on tarif_vendor.id_kota_asal_vendor = asal.id
                                            left join kota as tujuan on tarif_vendor.id_kota_tujuan_vendor = tujuan.id
                                            where id_kota_asal_vendor = $asal
                                            and id_kota_tujuan_vendor = $tujuan
                                            and tarif_vendor.cabang_vendor = '$cabang'
                                            and tarif_vendor.status = 'ya'
                                            and keterangan = 'Tarif <= 10 Kg'
                                            $jenis_sql
                                    ");
        }else if ($berat > 10) {
            $cari_vendor10kg = DB::select("SELECT tarif_vendor from tarif_vendor 
                                            left join vendor on tarif_vendor.vendor_id = vendor.kode
                                            left join kota as asal on tarif_vendor.id_kota_asal_vendor = asal.id
                                            left join kota as tujuan on tarif_vendor.id_kota_tujuan_vendor = tujuan.id
                                            where id_kota_asal_vendor = $asal
                                            and id_kota_tujuan_vendor = $tujuan
                                            and tarif_vendor.cabang_vendor = '$cabang'
                                            and tarif_vendor.status = 'ya'
                                            and keterangan = 'Tarif <= 10 Kg'
                                            $jenis_sql
                                    ");

            $vendor = DB::select("SELECT vendor.nama,jenis,tujuan.nama as tuj,asal.nama as as,id_tarif_vendor,id_kota_asal_vendor,id_kota_tujuan_vendor,
                                            tarif_vendor.cabang_vendor,kode,((tarif_vendor*($berat-10))+".$cari_vendor10kg[0]->tarif_vendor.") as tarif_vendor,waktu_vendor,tarif_vendor.status from tarif_vendor 
                                            left join vendor on tarif_vendor.vendor_id = vendor.kode
                                            left join kota as asal on tarif_vendor.id_kota_asal_vendor = asal.id
                                            left join kota as tujuan on tarif_vendor.id_kota_tujuan_vendor = tujuan.id
                                            where id_kota_asal_vendor = $asal
                                            and id_kota_tujuan_vendor = $tujuan
                                            and tarif_vendor.cabang_vendor = '$cabang'
                                            and tarif_vendor.status = 'ya'
                                            and keterangan = 'Tarif Kg selanjutnya <= 10 Kg'
                                            $jenis_sql
                                    ");

        }
      }
    	// return $vendor;
      return response()->json($vendor);
    	return view('sales.do_new.ajax_modal_vendor',compact('vendor'));
    }
//REPLACE HARGA VENDOR
    public function replace_vendor_deliveryorder_paket(Request $request)
    {
        $vendor = $request->a;

        $data = DB::table('tarif_vendor')->join('vendor','vendor.kode','=','tarif_vendor.vendor_id')->where('id_tarif_vendor','=',$vendor)->get();

        return response()->json($data);

    }


//CARI HARGA REGULER DO PAKET TANPA VENDOR DAN TANPA KONTRAK
    public function cari_harga_reguler_deliveryorder_paket(Request $request)
    {
      // dd($request->all());
        $asal = $request->kota_asal;
        $tujuan = $request->tujuan;
        $kecamatan = $request->kecamatan;
        $pendapatan = $request->pendapatan;
        $tipe = $request->tipe;
        $jenis = $request->jenis;
        $angkutan = $request->angkutan;
        $cabang = $request->cabang;
        $biaya_penerus = null;

//============= DOKUMEN START =============================================\\
        if ($tipe == 'DOKUMEN') {
            //cari tarif zona
            $sql = " SELECT harga,acc_penjualan FROM tarif_cabang_dokumen WHERE jenis='$jenis' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' AND kode_cabang='$cabang'";
            $data = collect(DB::select($sql));

            // return $data;
            //kondisi jika express dan reguler
            if ($jenis == 'EXPRESS'){
                $sql_biaya_penerus = "SELECT harga_zona as harga FROM tarif_penerus_dokumen join zona on id_zona = tarif_express WHERE type='$tipe' and id_kota='$tujuan' and id_kecamatan='$kecamatan'";
                $biaya_penerus = collect(DB::select($sql_biaya_penerus))->first();
            }else if($jenis == 'REGULER'){
                $sql_biaya_penerus = "SELECT harga_zona as harga FROM tarif_penerus_dokumen join zona on id_zona = tarif_reguler WHERE type='$tipe' and id_kota='$tujuan' and id_kecamatan='$kecamatan' ";
                $biaya_penerus = collect(DB::select($sql_biaya_penerus))->first();
            }

            // return json_encode($biaya_penerus);

            //jika kosong
            if ($biaya_penerus == null){
                $sql_biaya_penerus = "SELECT harga FROM tarif_penerus_default WHERE jenis='$jenis' AND tipe_kiriman='$tipe' AND cabang_default='$cabang'";
                $biaya_penerus_default = collect(DB::select($sql_biaya_penerus))->first();
            }

            //output
            if (count($data) > 0) {
                $harga = collect(\DB::select($sql))->first();
                if ( isset($biaya_penerus->harga) == null || isset($biaya_penerus->harga) == 0 ) {
                    $result['biaya_penerus'] = 0;
                }else{
                    $result['biaya_penerus'] = $biaya_penerus->harga;
                }
                $result['harga'] = $harga->harga;
                $result['acc_penjualan'] = $data[0]->acc_penjualan;
                $result['jumlah_data'] = count($biaya_penerus);
                return response()->json([
                    'biaya_penerus' => $result['biaya_penerus'],
                    'harga' => $harga->harga,
                    'tipe' => $tipe,
                    'acc_penjualan' => $data[0]->acc_penjualan,
                    'jumlah_data' => $result['jumlah_data'],
                ]);
            }
            
            else{
                return response()->json([
                    'status' => 'kosong'
                ]);
            }
        }
//============= KILOGRAM START =================================================\\
        elseif ($tipe == 'KILOGRAM'){
            // dd($request->all());
            $berat = $request->berat;
            
            if ($berat == 0) {
                $berat = 1;
            }else{
                $berat = $request->berat;
            }

            $tarif = null;
            $biaya_penerus = null;
            if ($berat < 10){
                $tarif = DB::table('tarif_cabang_kilogram')
                        ->select('acc_penjualan', DB::raw('(harga * '.$berat.') as harga'),'berat_minimum')
                        ->where('jenis', '=', $jenis)
                        ->where('id_kota_asal', '=', $asal)
                        ->where('id_kota_tujuan', '=', $tujuan)
                        ->where('keterangan', '=', 'Tarif Kertas / Kg')
                        ->where('kode_cabang', '=', $cabang)
                        ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_10express_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_10reguler_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                }

            } elseif ($berat == 10){
                $tarif = DB::table('tarif_cabang_kilogram')
                    ->select('acc_penjualan', 'harga','berat_minimum')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif <= 10 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_10express_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_10reguler_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                }

                

            } elseif ($berat > 10 && $berat < 20){
                $tarifAwal = DB::table('tarif_cabang_kilogram')
                    ->select('harga','berat_minimum')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif <= 10 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if (count($tarifAwal) > 0){
                    $tarifAwal = $tarifAwal[0]->harga;
                } else {
                    return response()->json([
                        'status' => 'kosong'
                    ]);
                }

                $tarif = DB::table('tarif_cabang_kilogram')
                    ->select('acc_penjualan', DB::raw('('.$tarifAwal.' + (harga * ('.$berat.' - 10))) as harga'),'berat_minimum')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif Kg selanjutnya <= 10 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_20express_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_20reguler_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                }

            }elseif ($berat == 20){
                $tarif = DB::table('tarif_cabang_kilogram')
                    ->select('acc_penjualan', 'harga','berat_minimum')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif <= 20 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_20express_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_20reguler_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                }

            }elseif ($berat > 20){
                $tarifAwal = DB::table('tarif_cabang_kilogram')
                    ->select('harga','berat_minimum')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif <= 20 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if (count($tarifAwal) > 0){
                    $tarifAwal = $tarifAwal[0]->harga;
                } else {
                    return response()->json([
                        'status' => 'kosong'
                    ]);
                }

                $tarif = DB::table('tarif_cabang_kilogram')
                    ->select('acc_penjualan', DB::raw('('.$tarifAwal.' + (harga * ('.$berat.' - 20))) as harga'),'berat_minimum')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif Kg selanjutnya <= 20 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_20express_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_kilogram')
                        ->join('zona', 'id_zona', '=', 'tarif_20reguler_kilo')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_kilo', '=', $tujuan)
                        ->where('id_kecamatan_kilo', '=', $kecamatan)
                        ->get();
                }

            }

            if (isset($tarif[0]->berat_minimum) == 0 || isset($tarif[0]->berat_minimum) == null) {
                $berat_minimum = 0;
            }else{
                $berat_minimum = $tarif[0]->berat_minimum;
            }
            if ($tarif != null) {
                if (count($biaya_penerus) < 1){
                    $biaya_penerus = DB::table('tarif_penerus_default')
                        ->select('harga as tarif_penerus')
                        ->where('jenis', '=', $jenis)
                        ->where('tipe_kiriman', '=', 'KILOGRAM')
                        ->get();

                    if (count($biaya_penerus) < 1){
                        $biaya_penerus = 0;
                    } else {
                      $biaya_penerus = $biaya_penerus[0]->tarif_penerus;
                    }
                } else {
                    $biaya_penerus = $biaya_penerus[0]->tarif_penerus;
                }
                // return $tarif;
                return response()->json([
                    'biaya_penerus' => $biaya_penerus,
                    'harga' => $tarif[0]->harga,
                    'acc_penjualan' => $tarif[0]->acc_penjualan,
                    'tipe' => $tipe,
                    'batas' => $berat_minimum,
                ]);
            }
            else{
                return response()->json([
                    'status' => 'kosong'
                ]);
            }
        }
//============= KOLI START =====================================================\\
        elseif ($tipe == 'KOLI'){
            //dd($request);
            $berat = $request->berat;
            $koli = $request->koli;
            $tarif = null;
            $biaya_penerus = null;
            if ($berat < 10){
                $tarif = DB::table('tarif_cabang_koli')
                    ->select('acc_penjualan', 'harga')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif Koli < 10 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_10express_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_10reguler_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->get();
                }
            } elseif ($berat < 20){
                $tarif = DB::table('tarif_cabang_koli')
                    ->select('acc_penjualan', 'harga')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif Koli < 20 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_20express_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->where('id_kecamatan_koli', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_20reguler_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->where('id_kecamatan_koli', '=', $kecamatan)
                        ->get();
                }
            } elseif ($berat <= 30){
                $tarif = DB::table('tarif_cabang_koli')
                    ->select('acc_penjualan', 'harga')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif Koli < 30 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_30express_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->where('id_kecamatan_koli', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_30reguler_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->where('id_kecamatan_koli', '=', $kecamatan)
                        ->get();
                }
            } elseif ($berat > 30){
                $tarif = DB::table('tarif_cabang_koli')
                    ->select('acc_penjualan', 'harga')
                    ->where('jenis', '=', $jenis)
                    ->where('id_kota_asal', '=', $asal)
                    ->where('id_kota_tujuan', '=', $tujuan)
                    ->where('keterangan', '=', 'Tarif Koli > 30 Kg')
                    ->where('kode_cabang', '=', $cabang)
                    ->get();

                if ($jenis == 'EXPRESS'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_>30express_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->where('id_kecamatan_koli', '=', $kecamatan)
                        ->get();
                } elseif ($jenis == 'REGULER'){
                    $biaya_penerus = DB::table('tarif_penerus_koli')
                        ->join('zona', 'id_zona', '=', 'tarif_>30reguler_koli')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_koli', '=', $tujuan)
                        ->where('id_kecamatan_koli', '=', $kecamatan)
                        ->get();
                }
            }
    
            if ($tarif != null) {
                if (count($biaya_penerus) < 1){
                    $biaya_penerus = DB::table('tarif_penerus_default')
                        ->select('harga as tarif_penerus')
                        ->where('jenis', '=', $jenis)
                        ->where('tipe_kiriman', '=', 'KOLI')
                        ->get();

                    if (count($biaya_penerus) < 1){
                        $biaya_penerus = 0;
                    } else {
                        $biaya_penerus = $biaya_penerus[0]->tarif_penerus;
                    }
                } else {
                    $biaya_penerus = $biaya_penerus[0]->tarif_penerus;
                }
            
                return response()->json([
                    'biaya_penerus' => $biaya_penerus,
                    'harga' => $tarif[0]->harga,
                    'acc_penjualan' => $tarif[0]->acc_penjualan,
                    'tipe' => $tipe,
                    'jenis' => $jenis,
                ]);
            }
            else{
                return response()->json([
                    'status' => 'kosong'
                ]);
            }
        }
//============= SEPEDA START ===================================================\\
        elseif ($tipe == 'SEPEDA'){

            $jenisSepeda = $request->sepeda;
            $beratSepeda = $request->berat_sepeda;
            $totalHarga = null;
            $biaya_penerus = null;
            $acc_penjualan = null;

            for ($i = 0; $i < count($jenisSepeda); $i++){

                if ($jenisSepeda[$i] == 'SEPEDA'){
                    $tarif = DB::table('tarif_cabang_sepeda')
                        ->select('harga', 'acc_penjualan')
                        ->where('id_kota_asal', '=', $asal)
                        ->where('id_kota_tujuan', '=', $tujuan)
                        ->where('kode_cabang', '=', $cabang)
                        ->where('jenis', '=', 'sepeda_pancal')
                        ->get();

                    $penerus = DB::table('tarif_penerus_sepeda')
                        ->join('zona', 'id_zona', '=', 'sepeda')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_sepeda', '=', $tujuan)
                        ->where('id_kecamatan_sepeda', '=', $kecamatan)
                        ->get();

                    if (count($penerus) < 1){
                        $penerus = DB::table('tarif_penerus_default')
                            ->select('harga as tarif_penerus')
                            ->where('jenis', '=', 'REGULER')
                            ->where('tipe_kiriman', '=', 'SEPEDA')
                            ->get();

                        if (count($penerus) < 1){
                            $penerus = 0;
                        } else {
                            $penerus = $penerus[0]->tarif_penerus;
                        }
                    }
                    // return $penerus; 

                    if ($tarif != null) {
                        $totalHarga = $totalHarga + $tarif[0]->harga;
                            if ($penerus != null) {
                                $biaya_penerus = $biaya_penerus + $penerus[0]->tarif_penerus;
                            }else{
                                $biaya_penerus = $biaya_penerus + $penerus;
                            }
                        $acc_penjualan = $tarif[0]->acc_penjualan;
                    }
                    else{
                        return response()->json([
                            'status' => 'kosong'
                        ]);
                    }
                } elseif ($jenisSepeda[$i] == 'SPORT'){
                    $tarif = DB::table('tarif_cabang_sepeda')
                        ->select('harga', 'acc_penjualan')
                        ->where('id_kota_asal', '=', $asal)
                        ->where('id_kota_tujuan', '=', $tujuan)
                        ->where('kode_cabang', '=', $cabang)
                        ->where('jenis', '=', 'laki_sport')
                        ->get();

                    $penerus = DB::table('tarif_penerus_sepeda')
                        ->join('zona', 'id_zona', '=', 'sport')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_sepeda', '=', $tujuan)
                        ->where('id_kecamatan_sepeda', '=', $kecamatan)
                        ->get();

                    if (count($penerus) < 1){
                        $penerus = DB::table('tarif_penerus_default')
                            ->select('harga as tarif_penerus')
                            ->where('jenis', '=', 'REGULER')
                            ->where('tipe_kiriman', '=', 'SEPEDA')
                            ->get();

                        if (count($penerus) < 1){
                            $penerus = 0;
                        } else {
                            $penerus = $penerus[0]->tarif_penerus;
                        }
                    } else {
                        $penerus = $penerus[0]->tarif_penerus;
                    }

                    if ($tarif != null) {
                        $totalHarga = $totalHarga + $tarif[0]->harga;
                        $biaya_penerus = $biaya_penerus + $penerus;
                        $acc_penjualan = $tarif[0]->acc_penjualan;
                    }
                    else{
                        return response()->json([
                            'status' => 'kosong'
                        ]);
                    }
                } elseif ($jenisSepeda[$i] == 'BETIC'){
                    $tarif = DB::table('tarif_cabang_sepeda')
                        ->select('harga', 'acc_penjualan')
                        ->where('id_kota_asal', '=', $asal)
                        ->where('id_kota_tujuan', '=', $tujuan)
                        ->where('kode_cabang', '=', $cabang)
                        ->where('jenis', '=', 'bebek_matik')
                        ->get();

                     $penerus = DB::table('tarif_penerus_sepeda')
                        ->join('zona', 'id_zona', '=', 'matik')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_sepeda', '=', $tujuan)
                        ->where('id_kecamatan_sepeda', '=', $kecamatan)
                        ->get();

                        
                    if (count($penerus) < 1){
                        $penerus = DB::table('tarif_penerus_default')
                            ->select('harga as tarif_penerus')
                            ->where('jenis', '=', 'REGULER')
                            ->where('tipe_kiriman', '=', 'SEPEDA')
                            ->get();

                        if (count($penerus) < 1){
                            $penerus = 0;
                        } else {
                            $penerus = $penerus[0]->tarif_penerus;
                        }
                    } else {
                        $penerus = $penerus[0]->tarif_penerus;
                    }

                    if ($tarif != null) {
                        $totalHarga = $totalHarga + $tarif[0]->harga;
                        $biaya_penerus = $biaya_penerus + $penerus;
                        $acc_penjualan = $tarif[0]->acc_penjualan;
                    }
                    else{
                        return response()->json([
                            'status' => 'kosong'
                        ]);
                    }
                } elseif ($jenisSepeda[$i] == 'MOGE'){
                    $tarif = DB::table('tarif_cabang_sepeda')
                        ->select('harga', 'acc_penjualan')
                        ->where('id_kota_asal', '=', $asal)
                        ->where('id_kota_tujuan', '=', $tujuan)
                        ->where('kode_cabang', '=', $cabang)
                        ->where('jenis', '=', 'moge')
                        ->get();

                    $penerus = DB::table('tarif_penerus_sepeda')
                        ->join('zona', 'id_zona', '=', 'moge')
                        ->select('harga_zona as tarif_penerus')
                        ->where('id_kota_sepeda', '=', $tujuan)
                        ->where('id_kecamatan_sepeda', '=', $kecamatan)
                        ->get();

                    if (count($penerus) < 1){
                        $penerus = DB::table('tarif_penerus_default')
                            ->select('harga as tarif_penerus')
                            ->where('jenis', '=', 'REGULER')
                            ->where('tipe_kiriman', '=', 'SEPEDA')
                            ->get();

                        if (count($penerus) < 1){
                            $penerus = 0;
                        } else {
                            $penerus = $penerus[0]->tarif_penerus;
                        }
                    } else {
                        $penerus = $penerus[0]->tarif_penerus;
                    }

                    if ($tarif != null) {
                        $totalHarga = $totalHarga + $tarif[0]->harga;
                        $biaya_penerus = $biaya_penerus + $penerus;
                        $acc_penjualan = $tarif[0]->acc_penjualan;

                    }
                    else{
                        return response()->json([
                            'status' => 'kosong'
                        ]);
                    }
                }
            }

            if ($biaya_penerus == null) {
                $penerus = DB::table('tarif_penerus_default')
                    ->select('harga')
                    ->where('jenis', '=', 'REGULER')
                    ->where('tipe_kiriman', '=', $tipe)
                    ->where('cabang_default')
                    ->get();

                if (count($penerus) > 0){
                    $biaya_penerus = $penerus[0]->harga;
                } else {
                    $biaya_penerus = 0;
                }
            }
            return response()->json([
                'biaya_penerus' => $biaya_penerus,
                'harga' => $totalHarga,
                'acc_penjualan' => $acc_penjualan,
                'tipe' => $tipe,
                'jenis' => $jenisSepeda,

            ]);
        }

        
    }



//SAVE DATA
    public function save_deliveryorder_paket(Request $request)
    {
        // dd($request->all()); 
      // DB::beginTransaction();
      // try {

          $cek_data_do = DB::table('delivery_order')->where('nomor','=',$request->do_nomor)->get();
          if ($cek_data_do != null  ) {
              return response()->json(['status'=>1]);
          }

          $simpan = '';
          $cabang = $request->do_cabang;
          $kota_asal = $request->do_kota_asal;
          $jumlah = 1;
          $jml_unit = null;
          if ($request->type_kiriman == 'KILOGRAM' || $request->type_kiriman == 'KERTAS') {
              $jumlah = filter_var($request->do_berat, FILTER_SANITIZE_NUMBER_INT);
              $kode_satuan = 'KG';
          } else if ($request->type_kiriman == 'KOLI') {
              $jumlah = filter_var($request->do_koli, FILTER_SANITIZE_NUMBER_INT);
              $kode_satuan = 'KOLI';
          } else if ($request->type_kiriman == 'KARGO PAKET' || $request->type_kiriman == 'KARGO KERTAS') {
              $kode_satuan = 'KARGO';
          } else if ($request->type_kiriman == 'DOKUMEN') {
              $kode_satuan = 'DOKUMEN';
          } else if ($request->type_kiriman == 'SEPEDA') {
              $kode_satuan = 'SEPEDA';
          }

          $select_akun = DB::table('d_akun')
                       ->where('id_akun','like','1303'.'%')
                       ->where('kode_cabang',$request->do_cabang)
                       ->first();
          if ($request->do_bank == null) {
            if ($select_akun == null) {
              $dataInfo = ['status' => 'gagal', 'info' => 'Akun Piutang Pada Cabang Ini Belum Tersedia'];
              return json_encode($dataInfo);
            }else{
              $akun_piutang = $select_akun->id_akun;
            }
          }else{
            $akun_piutang = $request->do_bank;
          }
          
          //cek nama username/user
          $namanama  = Auth::user()->m_nama;
          if ($namanama == null) {
              $namanama  = Auth::user()->m_nama;
          }else{
              $namanama  = Auth::user()->m_username;
          }

          if ($request->kontrak_tr == '') {
              $bol_kon = false;
          }else{
              $bol_kon = $request->kontrak_tr;
          }
          if ($request->kontrak_cus == '') {
              $cus_kon = 0;
          }else{
              $cus_kon = $request->kontrak_cus;
          }
          if ($request->kontrak_cus_dt == '') {
              $cus_kon_dt = 0;
          }else{
              $cus_kon_dt = $request->kontrak_cus_dt;
          }

          if ($request->do_jenis_ppn == 2 ) {
              $ppn_value = $request->do_jml_ppn;
              $ppn_bol = true;
          }else{
              $ppn_value = 0;
              $ppn_bol = false;
          }
          // TARIF DASAR + TARIF PENERUS = TOTAL;
          $total = filter_var($request->do_tarif_dasar, FILTER_SANITIZE_NUMBER_INT)+filter_var($request->do_tarif_penerus, FILTER_SANITIZE_NUMBER_INT);
          $data = array(
                    'nomor'                 => str_replace(' ','',strtoupper($request->do_nomor)),
                    'tanggal'               => $request->do_tanggal,
                    'catatan_admin'         => '-',
                    'id_kota_asal'          => $request->do_kota_asal,
                    'id_kota_tujuan'        => $request->do_kota_tujuan,
                    'id_kecamatan_tujuan'   => $request->do_kecamatan_tujuan,
                    'pendapatan'            => $request->pendapatan,
                    'type_kiriman'          => $request->type_kiriman,
                    'jenis_pengiriman'      => $request->jenis_kiriman,
                    'kode_tipe_angkutan'    => $request->do_angkutan,
                    'no_surat_jalan'        => strtoupper($request->do_surat_jalan),
                    'nopol'                 => strtoupper($request->do_nopol),
                    'lebar'                 => filter_var($request->do_lebar, FILTER_SANITIZE_NUMBER_INT),
                    'panjang'               => filter_var($request->do_panjang, FILTER_SANITIZE_NUMBER_INT),
                    'tinggi'                => filter_var($request->do_tinggi, FILTER_SANITIZE_NUMBER_INT),
                    'berat'                 => filter_var($request->do_berat, FILTER_SANITIZE_NUMBER_INT),
                    'koli'                  => filter_var($request->do_koli, FILTER_SANITIZE_NUMBER_INT),
                    'kode_outlet'           => $request->do_outlet,
                    'kode_cabang'           => $request->do_cabang,
                    'tarif_dasar'           => filter_var($request->do_tarif_dasar, FILTER_SANITIZE_NUMBER_INT),
                    'tarif_penerus'         => filter_var($request->do_tarif_penerus, FILTER_SANITIZE_NUMBER_INT),
                    'biaya_tambahan'        => filter_var($request->do_biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                    'biaya_komisi'          => filter_var($request->do_biaya_komisi, FILTER_SANITIZE_NUMBER_INT),
                    'kode_customer'         => $request->do_customer,
                    'kode_marketing'        => $request->do_marketing,
                    'ppn_val'               => filter_var($ppn_value, FILTER_SANITIZE_NUMBER_INT),
                    'ppn'                   => $ppn_bol,
                    'company_name_pengirim' => strtoupper($request->do_company_name_pengirim),
                    'nama_pengirim'         => strtoupper($request->do_nama_pengirim),
                    'alamat_pengirim'       => strtoupper($request->do_alamat_pengirim),
                    'kode_pos_pengirim'     => strtoupper($request->do_kode_pos_pengirim),
                    'telpon_pengirim'       => strtoupper($request->do_telpon_pengirim),
                    'company_name_penerima' => strtoupper($request->do_company_name_penerima),
                    'nama_penerima'         => strtoupper($request->do_nama_penerima),
                    'alamat_penerima'       => strtoupper($request->do_alamat_penerima),
                    'kode_pos_penerima'     => strtoupper($request->do_kode_pos_penerima),
                    'telpon_penerima'       => strtoupper($request->do_telpon_penerima),
                    'instruksi'             => strtoupper($request->do_instruksi),
                    'deskripsi'             => strtoupper($request->do_deskripsi),
                    'jenis_pembayaran'      => strtoupper($request->do_jenis_pembayaran),
                    'total'                 => $total,
                    'diskon'                => filter_var($request->do_diskon_v, FILTER_SANITIZE_NUMBER_INT),
                    'diskon_value'          => filter_var($request->do_diskon_p, FILTER_SANITIZE_NUMBER_INT),
                    'jenis'                 => 'PAKET',
                    'kode_satuan'           => $kode_satuan,
                    'jumlah'                => $jumlah,
                    'jenis_ppn'             => $request->do_jenis_ppn,
                    'acc_penjualan'         => $request->acc_penjualan,
                    'acc_piutang_do'        => $akun_piutang,
                    'csf_piutang_do'        => $akun_piutang,
                    'created_by'            => $namanama,
                    'updated_by'            => $namanama,
                    'total_vendo'           => filter_var($request->do_vendor, FILTER_SANITIZE_NUMBER_INT),
                    'total_dpp'             => filter_var($request->do_dpp, FILTER_SANITIZE_NUMBER_INT),
                    'kontrak'               =>  $bol_kon,
                    'kontrak_cus'           => $cus_kon,
                    'kontrak_cus_dt'        => $cus_kon_dt,
                    'tarif_vendor_bol'      => $request->tarif_vendor_bol,
                    'id_tarif_vendor'       => $request->id_tarif_vendor,
                    'nama_tarif_vendor'     => $request->nama_tarif_vendor,
                    'created_at'            => carbon::now(),
                    'created_by'            => auth::user()->m_name,
                    'total_net'             => filter_var($request->do_total_h, FILTER_SANITIZE_NUMBER_INT),
          );
        DB::table('delivery_order')->insert($data);  
        //end save do


        //simpan update status status 
        $increment = DB::table('u_s_order_do')->max('id');

        if ($increment == 0) {
            $increment = 1;
        }else{
            $increment += 1;
        }

        $data1 = array(
            'no_do' => strtoupper($request->do_nomor),
            'status' => 'MANIFESTED',
            'nama' => strtoupper($request->do_nama_pengirim),
            'catatan' => '-',
            'asal_barang' => $request->do_kota_asal,
            'id'=>$increment,
        );
        $simpan = DB::table('u_s_order_do')->insert($data1); 

        if ($request->nama_customer_hidden == 'NON CUSTOMER') {
            
          $tarif_vendor   = filter_var($request->do_vendor, FILTER_SANITIZE_NUMBER_FLOAT);
          $tarif_own      = filter_var($request->do_dpp, FILTER_SANITIZE_NUMBER_FLOAT);
          $tarif_ppn      = str_replace(",",".",$request->do_jml_ppn);
          $total_tarif    = $tarif_vendor + $tarif_own;

          $hitung_vendor  = (float)$tarif_ppn/$total_tarif*$tarif_vendor;
          $hitung_own     = (float)$tarif_ppn/$total_tarif*$tarif_own;

          $hitung_ppn     = $hitung_vendor+$hitung_own;
          $hitung_vendor_jurnal = round($tarif_vendor-$hitung_vendor,2);
          $hitung_own_jurnal = round($tarif_own-$hitung_own,2);
          $hitung_total   = round($hitung_ppn+$hitung_vendor_jurnal+$hitung_own_jurnal);

          $cari_akun      = DB::table('d_akun')->where('id_akun','like','1003%')->where('kode_cabang','=',$cabang)->get();
          // $cari_akun_ppn  = DB::table('d_akun')->where('id_akun','like','2301%')->where('kode_cabang','=',$cabang)->get();
          $cari_akun_vendor = DB::table('d_akun')->where('id_akun','like','4501%')->where('kode_cabang','=',$cabang)->get();
          $cari_akun_titipan = DB::table('d_akun')->where('id_akun','like','2498%')->where('kode_cabang','=',$cabang)->get();

          $max = DB::table('d_jurnal')->max('jr_id');
            if ($max == null) {
              $max = 1;
            }else{
              $max += 1;
            }

          $dt = Carbon::now();
          $bank = 'KM'.$request->akun_bank;

          $km =  get_id_jurnal($bank, $request->cb_cabang);

          $simpan_utama = DB::table('d_jurnal')->insert([
                              'jr_id'=>$max,
                              'jr_year'=>$dt->year,
                              'jr_date'=>$request->do_tanggal,
                              'jr_detail'=>'DEVLIERY ORDER PAKET',
                              'jr_ref'=>$request->do_nomor,
                              'jr_note'=>'DEVLIERY ORDER PAKET',
                              'jr_insert'=>$request->do_tanggal,
                              'jr_update'=>$dt,
                              'jr_no'    =>$km,
                            ]);
          $acc            = [  $cari_akun[0]->id_akun
                              // ,$cari_akun_ppn[0]->id_akun
                              // ,$cari_akun_vendor[0]->id_akun
                              ,$cari_akun_titipan[0]->id_akun
                            ];

          $jrdt_status_dk = ['D','K'];

          $jrdt_value     = [  $total_tarif,
                               // $hitung_ppn,
                               // $tarif_vendor,
                               $total_tarif
                             ];



          for ($i=0; $i <count($acc) ; $i++) { 
            if ($jrdt_value[$i] != 0) {
              $simpan_detil = DB::table('d_jurnal_dt')->insert([
                              'jrdt_jurnal'=>$max,
                              'jrdt_detailid'=>$i+1,
                              'jrdt_value'=>$jrdt_value[$i],
                              'jrdt_acc'=>$acc[$i],
                              'jrdt_statusdk'=>$jrdt_status_dk[$i],
                            ]);
            }
          }
          
          
        }
        // dd($request->all());

        if ($data['kode_satuan'] == "SEPEDA"){
            $data['jenis_pengiriman'] = 'REGULER';
            $jml_unit = $request->do_jml_unit;
        }

        if ($data['kode_satuan'] == "SEPEDA"){
            for ($i = 0; $i < $jml_unit; $i++){
                $dt = new do_dt();
                $dt->id_do = $request->do_nomor;
                $dt->id_do_dt = $i + 1;
                $dt->berat = $request->do_berat_unit[$i];
                $dt->jenis = $request->do_jenis_unit[$i];
                $dt->save();
            }
        }

        return response()->json(['status'=>'sukses']);
    // }catch (\Exception $e) {
        
    //     DB::rollback();

    //     return response()->json(['status'=>'gagal']);
    // }

    }

    public function edit_deliveryorder_paket(Request $request,$nomor)
    {
      

      $data = DB::table('delivery_order')
                        ->select('delivery_order.*','kota.nama as kota_nama','kecamatan.nama as kecamatan_nama')
                        ->join('kota','kota.id','=','delivery_order.id_kota_tujuan')
                        ->join('kecamatan','kecamatan.id','=','delivery_order.id_kecamatan_tujuan')
                        ->where('nomor','=',$nomor)
                        ->first();
      

      json_encode($data);      
      $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
      $kecamatan = DB::select(" SELECT id,nama FROM kecamatan ORDER BY nama ASC ");
      $customer = DB::table('customer as c')
                             ->select('c.kode','c.nama','c.alamat','c.telpon','kc.kc_aktif','kcd.kcd_jenis')
                             ->leftjoin('kontrak_customer as kc','kc.kc_kode_customer','=','c.kode')
                             ->leftjoin('kontrak_customer_d as kcd','kcd.kcd_kode','=','kc.kc_nomor')
                             ->groupBy('kc.kc_aktif','c.kode','kcd.kcd_jenis')
                             ->where('kcd.kcd_jenis','=','PAKET')
                             ->orderBy('c.kode','ASC')
                             ->get();
      if ($customer == null) {
            $cus = DB::table('customer as c')
                             ->select('c.kode','c.nama','c.alamat','c.telpon')
                             ->get();
      }else{
            $temp= [];
            for ($i=0; $i < count($customer); $i++) { 
                $temp[$i]=$customer[$i]->kode;
            }
            $cus = DB::table('customer as c')
                             ->select('c.kode','c.nama','c.alamat','c.telpon')
                             ->whereNotIn('c.kode',$temp)
                             ->get();
      }
                             
      $kendaraan = DB::select(" SELECT nopol FROM kendaraan ");
      $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
      $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
      $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
      $authe = Auth::user()->kode_cabang; 
      if ($authe == '000') {
          $cabang = DB::select(" select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y group by kode order by kode asc ");
      }else{
          $cabang = DB::select(" select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y where kode = '$authe' group by kode order by kode asc ");
      }




      return view('sales.do_new.edit', compact('data','kota', 'customer', 'kendaraan', 'marketing', 'angkutan', 'outlet', 'do', 'jml_detail', 'cabang', 'jurnal_dt', 'kecamatan', 'kec', 'do_dt','cek_data','cus'));      
      
    }


    public function update_deliveryorder_paket(Request $request)
    {
      // dd($request->all());
      $simpan = '';

      $kota_asal = $request->do_kota_asal;
      $jumlah = 1;
      $jml_unit = null;
      if ($request->type_kiriman == 'KILOGRAM' || $request->type_kiriman == 'KERTAS') {
          $jumlah = filter_var($request->do_berat, FILTER_SANITIZE_NUMBER_INT);
          $kode_satuan = 'KG';
      } else if ($request->type_kiriman == 'KOLI') {
          $jumlah = filter_var($request->do_koli, FILTER_SANITIZE_NUMBER_INT);
          $kode_satuan = 'KOLI';
      } else if ($request->type_kiriman == 'KARGO PAKET' || $request->type_kiriman == 'KARGO KERTAS') {
          $kode_satuan = 'KARGO';
      } else if ($request->type_kiriman == 'DOKUMEN') {
          $kode_satuan = 'DOKUMEN';
      } else if ($request->type_kiriman == 'SEPEDA') {
          $kode_satuan = 'SEPEDA';
      }

      $select_akun = DB::table('d_akun')
                   ->where('id_akun','like','1303'.'%')
                   ->where('kode_cabang',$request->do_cabang)
                   ->first();

      if ($select_akun == null) {
          $dataInfo = ['status' => 'gagal', 'info' => 'Akun Piutang Pada Cabang Ini Belum Tersedia'];
          return json_encode($dataInfo);
      }else{
        $akun_piutang = $select_akun->id_akun;
      }
      //cek nama username/user
      $namanama  = Auth::user()->m_nama;
      if ($namanama == null) {
          $namanama  = Auth::user()->m_nama;
      }else{
          $namanama  = Auth::user()->m_username;
      }

      if ($request->kontrak_tr == '') {
          $bol_kon = false;
      }else{
          $bol_kon = $request->kontrak_tr;
      }
      if ($request->kontrak_cus == '') {
          $cus_kon = 0;
      }else{
          $cus_kon = $request->kontrak_cus;
      }
      if ($request->kontrak_cus_dt == '') {
          $cus_kon_dt = 0;
      }else{
          $cus_kon_dt = $request->kontrak_cus_dt;
      }

      if ($request->do_jenis_ppn == 2) {
          $ppn_value = $request->do_jml_ppn;
          $ppn_bol = true;
      }else{
          $ppn_value = 0;
          $ppn_bol = false;
      }

      $total = filter_var($request->do_tarif_dasar, FILTER_SANITIZE_NUMBER_INT)+filter_var($request->do_tarif_penerus, FILTER_SANITIZE_NUMBER_INT);
      $data = array(
                'nomor' => str_replace(' ','',strtoupper($request->do_nomor)),
                'tanggal' => $request->do_tanggal,
                'catatan_admin' => '-',
                'id_kota_asal' => $request->do_kota_asal,
                'id_kota_tujuan' => $request->do_kota_tujuan,
                'id_kecamatan_tujuan' => $request->do_kecamatan_tujuan,
                'pendapatan' => $request->pendapatan,
                'type_kiriman' => $request->type_kiriman,
                'jenis_pengiriman' => $request->jenis_kiriman,
                'kode_tipe_angkutan' => $request->do_angkutan,
                'no_surat_jalan' => strtoupper($request->do_surat_jalan),
                'nopol' => strtoupper($request->do_nopol),
                'lebar' => filter_var($request->do_lebar, FILTER_SANITIZE_NUMBER_INT),
                'panjang' => filter_var($request->do_panjang, FILTER_SANITIZE_NUMBER_INT),
                'tinggi' => filter_var($request->do_tinggi, FILTER_SANITIZE_NUMBER_INT),
                'berat' => filter_var($request->do_berat, FILTER_SANITIZE_NUMBER_INT),
                'koli' => filter_var($request->do_koli, FILTER_SANITIZE_NUMBER_INT),
                'kode_outlet' => $request->do_outlet,
                'kode_cabang' => $request->do_cabang,
                'tarif_dasar' => filter_var($request->do_tarif_dasar, FILTER_SANITIZE_NUMBER_INT),
                'tarif_penerus' => filter_var($request->do_tarif_penerus, FILTER_SANITIZE_NUMBER_INT),
                'biaya_tambahan' => filter_var($request->do_biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                'biaya_komisi' => filter_var($request->do_biaya_komisi, FILTER_SANITIZE_NUMBER_INT),
                'kode_customer' => $request->do_customer,
                'kode_marketing' => $request->do_marketing,
                'ppn_val' => filter_var($ppn_value, FILTER_SANITIZE_NUMBER_INT),
                'ppn' => $ppn_bol,
                'company_name_pengirim' => strtoupper($request->do_company_name_pengirim),
                'nama_pengirim' => strtoupper($request->do_nama_pengirim),
                'alamat_pengirim' => strtoupper($request->do_alamat_pengirim),
                'kode_pos_pengirim' => strtoupper($request->do_kode_pos_pengirim),
                'telpon_pengirim' => strtoupper($request->do_telpon_pengirim),
                'company_name_penerima' => strtoupper($request->do_company_name_penerima),
                'nama_penerima' => strtoupper($request->do_nama_penerima),
                'alamat_penerima' => strtoupper($request->do_alamat_penerima),
                'kode_pos_penerima' => strtoupper($request->do_kode_pos_penerima),
                'telpon_penerima' => strtoupper($request->do_telpon_penerima),
                'instruksi' => strtoupper($request->do_instruksi),
                'deskripsi' => strtoupper($request->do_deskripsi),
                'jenis_pembayaran' => strtoupper($request->do_jenis_pembayaran),
                'total' => $total,
                'diskon' => filter_var($request->do_diskon_v, FILTER_SANITIZE_NUMBER_INT),
                'diskon_value' => filter_var($request->do_diskon_p, FILTER_SANITIZE_NUMBER_INT),
                'jenis' => 'PAKET',
                'kode_satuan' => $kode_satuan,
                'jumlah' => $jumlah,
                'jenis_ppn' => $request->do_jenis_ppn,
                'acc_penjualan' => $request->acc_penjualan,
                'acc_piutang_do'        => $akun_piutang,
                'csf_piutang_do'        => $akun_piutang,
                'created_by'        => $namanama,
                'updated_by'        => $namanama,
                'total_vendo'        => filter_var($request->do_vendor, FILTER_SANITIZE_NUMBER_INT),
                'total_dpp'        => filter_var($request->do_dpp, FILTER_SANITIZE_NUMBER_INT),
                'kontrak'        =>  $bol_kon,
                'kontrak_cus'        => $cus_kon,
                'kontrak_cus_dt'        => $cus_kon_dt,
                'tarif_vendor_bol' =>$request->tarif_vendor_bol,
                'id_tarif_vendor' =>$request->id_tarif_vendor,
                'nama_tarif_vendor' =>$request->nama_tarif_vendor,
                'updated_at' =>carbon::now(),
                'updated_by' =>auth::user()->m_name,
                'total_net' => filter_var($request->do_total_h, FILTER_SANITIZE_NUMBER_INT),
      );
    
    DB::table('delivery_order')
                ->where('nomor','=',$request->do_nomor)
                ->update($data);
    //end save do
                
    return response()->json(['status'=>'sukses']);
          
    }

    public function formatRP($nilai)
    {
        $nilai = str_replace(['Rp', '\\', '.', ' '], '', $nilai);
        $nilai = str_replace(',', '.', $nilai);
        return (float)$nilai;

    }


//LIHAT JURNAL AWAL
    public function jurnal_awal_deliveryorder_paket(Request $request)
    {
        $data = DB::table('d_jurnal')
                  ->select('jr_ref','jrdt_acc','nama_akun','jrdt_statusdk','jrdt_value')
                  ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
                  ->join('d_akun','jrdt_acc','=','id_akun')
                  ->where('jr_ref','=',$request->id)
                  ->where('jr_note','DEVLIERY ORDER PAKET')
                  ->get();

        if ($data == null) {
          return response()->json(['status'=>'kosong']);
        }else{
          return view('sales.do_new.modal_jurnal_awal_do', compact('data'));
        }
    }
//LIHAT JURNAL BALIK 
    public function jurnal_balik_deliveryorder_paket(Request $request)
    {
        $data = DB::table('d_jurnal')
                  ->select('jr_ref','jrdt_acc','jrdt_statusdk','nama_akun','jrdt_value')
                  ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
                  ->join('d_akun','jrdt_acc','=','id_akun')
                  ->where('jr_ref','=',$request->id)
                  ->where('jr_note','DEVLIERY ORDER PAKET BALIK')
                  ->get();

        if ($data == null) {
          return response()->json(['status'=>'kosong']);
        }else{
          return view('sales.do_new.modal_jurnal_balik_do', compact('data'));
        }
    }
 //CARI KAS BESAR
    public function cari_kas_besar_deliveryorder_paket(Request $request)
    {
        $data = DB::table('d_akun')
                  ->where('id_akun','like','%1003%')
                  ->where('kode_cabang','=',$request->a)
                  ->first();

        if ($data == null) {
          return response()->json(['status'=>'kosong']);
        }else{
          return response()->json($data);
        }
    }
  // ajax_index_deliveryorder_paket
    public function ajax_index_deliveryorder_paket(Request $request)
    {
      // dd($request->all());
    //asal
    if ($request->asal != '') {
      $asal_fil = (int)$request->asal;
      $asal = ' AND d.id_kota_asal = '.$asal_fil.'';
    }else{
      $asal = '';
    }
    //tujuan
    if ($request->tujuan != '') {
      $tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
    }else{
      $tujuan = '';
    }
    //cabang
    if ($request->cabang != '') {
      $cabang = " AND d.kode_cabang = '".$request->cabang."' ";
    }else{
      $cabang ='';
    }
    //tipe
    if ($request->tipe != '') {
      $tipe = " AND d.type_kiriman = '".$request->tipe."' ";
    }else{
      $tipe ='';
    }
    //status
    if ($request->status != '' || $request->status != null) {
      $status = " AND d.status = '".$request->status."' ";
    }else{
      $status = '';
    }
    //pendapatan
    if ($request->pendapatan != '' || $request->pendapatan != null) {
      $pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
    }else{
      $pendapatan = '';
    }
    //jenis
    if ($request->jenis != '' || $request->jenis != null) {
      $jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
    }else{
      $jenis = '';
    }
    //customer
    if ($request->customer != '' || $request->customer != null) {
      $customer = " AND d.kode_customer = '".$request->customer."' ";
    }else{
      $customer = '';
    }
    
    //jenis

    
    //customer
    if ($request->max != '' || $request->max != null) {
      $max = " AND d.tanggal <= '".$request->max."' ";
    }else{
      $max = '';
    }
    
    if ($request->nomor != '' || $request->nomor != null) {
      $nomor = "d.nomor = '".$request->nomor."' ";
      if ($request->min != '' || $request->min != null) {
      $min = "AND d.tanggal >= '".$request->min."' ";
      }else{
        $min = '';
      }
    }else{
      $nomor = '';
      if ($request->min != '' || $request->min != null) {
      $min = "d.tanggal >= '".$request->min."' ";
      }else{
        $min = '';
      }
    }
    // return $request->nomor;
    // dd($request->all());
    if ($nomor == '') {
      // return 'a';
        $data  = DB::select("SELECT d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total 
        FROM delivery_order as d 
        LEFT JOIN kota k ON k.id=d.id_kota_asal
              LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
              join customer c on d.kode_customer = c.kode 
              join cabang cc on d.kode_cabang = cc.kode 

        WHERE ".$nomor." ".$min." ".$max." ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
    }else{
        $data  = DB::select("SELECT d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total 
        FROM delivery_order as d 
        LEFT JOIN kota k ON k.id=d.id_kota_asal
              LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
              join customer c on d.kode_customer = c.kode 
              join cabang cc on d.kode_cabang = cc.kode 

        WHERE ".$nomor." ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
    }
    
        $data = collect($data);

        // return $data;
    return Datatables::of($data)
              ->addColumn('button', function ($data) {
                  return  '<div class="btn-group">'.
                           '<a href="deliveryorder_paket/'.$data->nomor.'/edit_deliveryorder_paket" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>'.
                            '<a href="deliveryorderform/'.$data->nomor.'/nota" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></a>'.
                            '<a href="deliveryorder_paket/'.$data->nomor.'/hapus_deliveryorder_paket" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>'.
                          '</div>';
                })
              ->make(true);
    }
    public function ajax_replace_index_deliveryorder_paket(Request $request)
    { 
    $min = $request->min;
    $max = $request->max;
    $asal =$request->asal;
    $tujuan=$request->tujuan;
    $cabang=$request->cabang;
    $tipe=$request->tipe;
    $status=$request->status;
    $jenis=$request->jenis;
    $pendapatan=$request->pendapatan;
    $customer=$request->customer;
    $nomor=$request->do_nomor;

        return view('sales.do_new.ajax_index',compact('min','max','asal','tujuan','cabang','tipe','status','pendapatan','jenis','customer','nomor'));
    }
}
