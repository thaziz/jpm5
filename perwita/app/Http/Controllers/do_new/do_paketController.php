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
                           '<a href="deliveryorder_paket/'.$data->nomor.'/edit_deliveryorder_paket" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>'.
                            '<a href="deliveryorderform/'.$data->nomor.'/nota" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></a>'.
                            '<a href="deliveryorder_paket/'.$data->nomor.'/hapus_deliveryorder_paket" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>'.
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
            $cabang = DB::select(" select kode, nama, (select dc_diskon from d_disc_cabang x where dc_cabang = y.kode and dc_jenis = 'PAKET') diskon from cabang y group by kode order by kode asc ");
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
      $cabang = $request->c;
      $jenis = $request->d;
      if ($jenis == '' || $jenis == null) {
        $vendor = DB::table('tarif_vendor')
                ->select('vendor.nama','jenis','tujuan.nama as tuj','asal.nama as as','id_tarif_vendor','id_kota_asal_vendor','id_kota_tujuan_vendor','tarif_vendor.cabang_vendor','kode','tarif_vendor','waktu_vendor')
                ->leftjoin('vendor','tarif_vendor.vendor_id','=','vendor.kode')
                ->leftjoin('kota as asal','tarif_vendor.id_kota_asal_vendor','=','asal.id')
                ->leftjoin('kota as tujuan','tarif_vendor.id_kota_tujuan_vendor','=','tujuan.id')
                ->where('id_kota_asal_vendor','=',$asal)
                ->where('id_kota_tujuan_vendor','=',$tujuan)
                ->where('tarif_vendor.cabang_vendor','=',$cabang)
                ->get();
      }else{
        $vendor = DB::table('tarif_vendor')
                ->select('vendor.nama','jenis','tujuan.nama as tuj','asal.nama as as','id_tarif_vendor','id_kota_asal_vendor','id_kota_tujuan_vendor','tarif_vendor.cabang_vendor','kode','tarif_vendor','waktu_vendor')
                ->leftjoin('vendor','tarif_vendor.vendor_id','=','vendor.kode')
                ->leftjoin('kota as asal','tarif_vendor.id_kota_asal_vendor','=','asal.id')
                ->leftjoin('kota as tujuan','tarif_vendor.id_kota_tujuan_vendor','=','tujuan.id')
                ->where('id_kota_asal_vendor','=',$asal)
                ->where('id_kota_tujuan_vendor','=',$tujuan)
                ->where('tarif_vendor.cabang_vendor','=',$cabang)
                ->where('jenis','=',$jenis)
                ->get();
      }

    	
    	// return $vendor;
    	return view('sales.do_new.ajax_modal_vendor',compact('vendor'));
    }

//REPLACE HARGA VENDOR
    public function replace_vendor_deliveryorder_paket(Request $request)
    {
    	$vendor = $request->a;

    	$data = DB::table('tarif_vendor')->join('vendor','vendor.kode','=','tarif_vendor.vendor_id')->where('id_tarif_vendor','=',$vendor)->get();

    	return response()->json($data);

    }

//SAVE DATA
    public function save_deliveryorder_paket(Request $request)
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

      $data = array(
                'nomor' => strtoupper($request->do_nomor),
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
                'total' => filter_var($request->do_tarif_dasar, FILTER_SANITIZE_NUMBER_INT),
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
                'created_at' =>carbon::now(),
                'created_by' =>auth::user()->m_name,
                'total_net' => filter_var($request->do_total_h, FILTER_SANITIZE_NUMBER_INT),
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

    return response()->json(['status'=>'sukses']);


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

      $data = array(
                'nomor' => strtoupper($request->do_nomor),
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
                'total' => filter_var($request->do_tarif_dasar, FILTER_SANITIZE_NUMBER_INT),
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




}
