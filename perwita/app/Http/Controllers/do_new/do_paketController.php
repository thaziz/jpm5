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
	                LEFT JOIN kota k ON k.id=d.id_kota_asal
	                LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	                join customer c on d.kode_customer = c.kode 
	                join cabang cc on d.kode_cabang = cc.kode 
	                WHERE d.jenis='PAKET'
	                ";
	    }
	    else{
	    $sql = "SELECT d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
	                FROM delivery_order d
	                LEFT JOIN kota k ON k.id=d.id_kota_asal
	                LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
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
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
                    join customer c on d.kode_customer = c.kode 
                    join cabang cc on d.kode_cabang = cc.kode 
                    WHERE d.jenis='PAKET'
                    ";
        }
        else{
        $sql = "SELECT d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
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
                           '<a href="deliveryorderform/'.$data->nomor.'/edit" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>'.
                            '<a href="deliveryorderform/'.$data->nomor.'/nota" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></a>'.
                            '<a href="deliveryorderform/'.$data->nomor.'/hapus_data" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>'.
                          '</div>';
                })
                ->make(true);
   }

//FORM CREATE DO PAKET
   public function create_deliveryorder_paket(Request $request)
   {
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
            $cabang = DB::select("select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y group by kode order by kode asc ");
        }else{
            $cabang = DB::select(" select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y where kode = '$authe' group by kode order by kode asc ");
        }
        return view('sales.do_new.create', compact('kota', 'customer', 'kendaraan', 'marketing', 'angkutan', 'outlet', 'do', 'jml_detail', 'cabang', 'jurnal_dt', 'kecamatan', 'kec', 'do_dt','cek_data','cus'));
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

    	$vendor = DB::table('tarif_vendor')
    						->select('vendor.nama','tujuan.nama as tuj','asal.nama as as','id_tarif_vendor','id_kota_asal_vendor','id_kota_tujuan_vendor','vendor.cabang_vendor','kode','tarif_vendor','waktu_vendor')
    						->leftjoin('vendor','tarif_vendor.vendor_id','=','vendor.kode')
    						->leftjoin('kota as asal','tarif_vendor.id_kota_asal_vendor','=','asal.id')
    						->leftjoin('kota as tujuan','tarif_vendor.id_kota_tujuan_vendor','=','tujuan.id')
    						->where('id_kota_asal_vendor','=',$asal)
    						->where('id_kota_tujuan_vendor','=',$tujuan)
    						->get();
    	// return $vendor;
    	return view('sales.do_new.ajax_modal_vendor',compact('vendor'));
    }

//REPLACE HARGA VENDOR
    public function replace_vendor_deliveryorder_paket(Request $request)
    {
    	$vendor = $request->a;

    	$data = DB::table('tarif_vendor')->where('id_tarif_vendor','=',$vendor)->get();

    	return response()->json($data);

    }



  

}
