<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;
use carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;

class do_kargo_Controller extends Controller
{

    public function index(){
        $cabang = auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Delivery Order','all')) {
            $data = DB::table('delivery_order')
                      ->join('cabang','kode','=','kode_cabang')
                      ->where('jenis','KARGO')
                      ->orderBy('tanggal','DESC')
                      ->get();
        }else{
            $data = DB::table('delivery_order')
                      ->join('cabang','kode','=','kode_cabang')
                      ->where('jenis','KARGO')
                      ->where('kode_cabang',$cabang)
                      ->orderBy('tanggal','DESC')
                      ->get();
        }
        $kota = DB::table('kota')
                  ->get();

        $kota = DB::table('kota')->get();
        $kota1= DB::table('kota')->get();
        $cabang= DB::table('cabang')->get();
        $customer= DB::table('customer')->get();
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_group',1)
                         ->orWhere('jt_group',2)
                         ->orWhere('jt_group',3)
                         ->orderBy('jt_id','ASC')
                         ->get();
        return view('sales.do_kargo.index',compact('data','kota','customer','kota1','cabang','jenis_tarif'));
    }

    public function datatable_do_kargo(Request $req)
    {
      $cabang = DB::table('cabang')
                  ->where('kode',$req->cabang)
                  ->first();

      if ($cabang == null) {
        $cabang == '';
      }else{
        $cabang = 'and kode_cabang ='."'$cabang->kode'";
      }

      if ($req->min == '') {
        $min = '';
      }else{
        $min = 'and tanggal >='."'$req->min'";
      }

      if ($req->max == '') {
        $max = '';
      }else{
        $max = 'and tanggal <='."'$req->max'";
      }

      if ($req->jenis == '') {
        $jenis = '';
      }else{
        $jenis = 'and jenis_pengiriman ='."'$req->jenis'";
      }
      if ($req->customer == '') {
        $customer = '';
      }else{
        $customer = 'and kode_customer ='."'$req->customer'";
      }

      if ($req->kota_asal == '') {
        $kota_asal = '';
      }else{
        $kota_asal = 'and id_kota_asal ='."'$req->kota_asal'";
      }

      if ($req->kota_tujuan == '') {
        $kota_tujuan = '';
      }else{
        $kota_tujuan = 'and id_kota_tujuan ='."'$req->kota_tujuan'";
      }

      if ($req->status == '') {
        $status = '';
      }else{
        $status = 'and status ='."'$req->status'";
      }

      if ($req->do_nomor != '') {
        if (Auth::user()->punyaAkses('Delivery Order','all')) {
            $data = DB::table('delivery_order')
                      ->join('cabang','kode','=','kode_cabang')
                      ->where('jenis','KARGO')
                      ->where('nomor','like','%'.$req->do_nomor.'%')
                      ->orderBy('tanggal','DESC')
                      ->get();
        }else{
            $cabang = Auth::user()->kode_cabang;
            $data = DB::table('delivery_order')
                      ->join('cabang','kode','=','kode_cabang')
                      ->where('jenis','KARGO')
                      ->where('kode_cabang',$cabang)
                      ->where('nomor','like','%'.$req->do_nomor.'%')
                      ->orderBy('tanggal','DESC')
                      ->get();
        }
        
      }else{
        if (Auth::user()->punyaAkses('Delivery Order','all')) {
          $data = DB::table('delivery_order')
                    ->join('cabang','kode','=','kode_cabang')
                    ->whereRaw("jenis = 'KARGO' $min $max $customer $jenis $cabang $kota_asal $kota_tujuan $status")
                    ->orderBy('tanggal','DESC')
                    ->get();
        }else{
          $cabang = Auth::user()->kode_cabang;
          $data = DB::table('delivery_order')
                    ->join('cabang','kode','=','kode_cabang')
                    ->where('jenis','KARGO')
                    ->where('kode_cabang',$cabang)
                    ->whereRaw("jenis = 'KARGO' and kode_cabang='$cabang' $min $max $customer $jenis $kota_asal $kota_tujuan $status")
                    ->orderBy('tanggal','DESC')
                    ->get();
        }
      }

      $data = collect($data);
      // return $data;

      return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {

                            if($data->status_do == 'Released' or Auth::user()->punyaAkses('Delivery Order','ubah')){
                                if(cek_periode(carbon::parse($data->tanggal)->format('m'),carbon::parse($data->tanggal)->format('Y') ) != 0){
                                  $a = '<button type="button" onclick="edit(\''.$data->nomor.'\')" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></button>';
                                }else{
                                  $a = '';
                                }
                            }else{
                              $a = '';
                            }

                            if(Auth::user()->punyaAkses('Delivery Order','print')){
                                $b = '<button type="button" onclick="print(\''.$data->nomor.'\')" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></button>';
                            }else{
                              $b = '';
                            }


                            if($data->status_do == 'Released' or Auth::user()->punyaAkses('Delivery Order','hapus')){
                                if(cek_periode(carbon::parse($data->tanggal)->format('m'),carbon::parse($data->tanggal)->format('Y') ) != 0){
                                  $c = '<button type="button" onclick="hapus(\''.$data->nomor.'\')" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button>';
                                }else{
                                  $c = '';
                                }
                            }else{
                              $c = '';
                            }
                            return $a . $b .$c  ;
                            

                                   
                        })
                        ->addColumn('asal', function ($data) {
                          $kota = DB::table('kota')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->id_kota_asal == $kota[$i]->id) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addColumn('tujuan', function ($data) {
                          $kota = DB::table('kota')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->id_kota_tujuan == $kota[$i]->id) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addIndexColumn()
                        ->make(true);
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");


        $customer = DB::table('customer')
                      ->where('pic_status','AKTIF')
                      ->get();
        $kontrak_customer = DB::table('customer')
                              ->join('kontrak_customer','kc_kode_customer','=','kode')
                              ->join('kontrak_customer_d','kcd_id','=','kc_id')
                              ->where('kcd_jenis','KARGO')
                              ->where('kcd_active',true)
                              ->select('kode')
                              ->groupBy('kode')
                              ->orderBy('kode','ASC')
                              ->get();

        for ($i=0; $i < count($kontrak_customer); $i++) { 
          $kode[$i] = $kontrak_customer[$i]->kode;
        }
        for ($i=0; $i < count($customer); $i++) { 
          for ($a=0; $a < count($kode); $a++) { 
            if ($kode[$a] == $customer[$i]->kode) {
              $customer[$i]->kontrak = 'YA';
            }
          }
        }
        
        $kendaraan = DB::select("   SELECT k.id,k.nopol,k.tipe_angkutan,k.status,k.kode_subcon,s.nama FROM kendaraan k
                                    LEFT JOIN subcon s ON s.kode=k.kode_subcon ");
        $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
        //$angkutan = DB::select(" SELECT kode,nama FROM angkutan ORDER BY nama ASC ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $tipe_angkutan =DB::select("SELECT kode,nama FROM tipe_angkutan");
        $subcon =DB::select("SELECT * FROM subcon");
        $now = Carbon::now()->format('d/m/Y');
        $bulan_depan = Carbon::now()->subDay(-30)->format('d/m/Y');
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_group',1)
                         ->orWhere('jt_group',2)
                         ->orWhere('jt_group',3)
                         ->orderBy('jt_id','ASC')
                         ->get();

        if ($nomor != null) {
            $do = DB::table('delivery_order')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM delivery_orderd WHERE nomor='$nomor' "))->first();
        }else{
            $do = null;
            $jml_detail = 0;
        }

        // for ($i=0; $i < count($customer); $i++) { 
        //   for ($a=0; $a < count($kota); $a++) { 
        //     if ($customer[$i]->kota == $kota[$a]->id) {
        //       $cus[$i]['nama_kota'] = $kota[$a]->nama;
        //       $cus[$i]['nama'] = $customer[$i]->nama;
        //       $cus[$i]['id'] = $customer[$a]->kode;
        //     }
        //   }
        // }

        // return $cus;

      
        return view('sales.do_kargo.form',compact('kota','customer', 'kendaraan', 'marketing', 'outlet', 'do', 'jml_detail','cabang','tipe_angkutan','now','jenis_tarif','bulan_depan','subcon'));
    }
    
    public function form_update_status($nomor=null){
        if ($nomor != null) {
            // $do = DB::table('delivery_order')->where('nomor', $nomor)->first();
        }else{
            $do = null;
        }
        return view('sales.do.update_status',compact('do'));
    }
    
    public function save_update_status (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'status' => strtoupper($request->cb_status),
                'id_penerima' => strtoupper($request->ed_id_penerima),
                'catatan_admin' => strtoupper($request->ed_catatan_admin),
            );
        $simpan = DB::table('delivery_order')->where('nomor', $request->ed_nomor)->update($data);
        if($simpan == TRUE){
            return redirect('sales/deliveryorder');
        }
    }

    public function cari_harga(Request $request){
        $kontrak = $request->input('kontrak');
        $customer = strtoupper($request->input('customer'));
        $jenis_tarif = strtoupper($request->input('jenis_tarif'));
        $tipe_tarif = $request->input('tipe_tarif');
        $asal = $request->input('asal');
        $tujuan = $request->input('tujuan');
        $pendapatan =$request->input('pendapatan');
        $tipe = $request->input('tipe');
        $jenis = $request->input('jenis');
        $angkutan = $request->input('angkutan');
        $tipe_angkutan = $request->input('tipe_angkutan');
        $kode_cabang =$request->input('cabang');
        if ($kontrak == 'YA') {
            $sql= " SELECT d.harga, d.kode_satuan,d.acc_penjualan FROM kontrak k,kontrak_d d
                    WHERE k.nomor=d.nomor_kontrak AND k.aktif=TRUE 
                    AND d.id_kota_asal='$asal' AND d.id_kota_tujuan='$tujuan' AND k.kode_customer='$customer' 
                    AND d.jenis_tarif='$jenis_tarif' AND d.kode_angkutan='$tipe_angkutan' AND k.kode_cabang='$kode_cabang' ";
        }else{
            $sql = " SELECT harga,kode_satuan,acc_penjualan FROM tarif_cabang_kargo WHERE jenis='$jenis_tarif' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' AND kode_angkutan='$tipe_angkutan'  AND kode_cabang='$kode_cabang' ";
        } 
        
        $data = collect(DB::select($sql));
        $jumlah_data = $data->count();
        if ($jumlah_data > 0) {
            $harga = collect(\DB::select($sql))->first();
            if ($tipe = 'KARGO PAKET' or $tipe ='KARGO KERTAS') {
                $biaya_penerus = 0;
                $result['biaya_penerus'] = 0;
            } else{
                $biaya_penerus = 0;//collect(\DB::select($sql_biaya_penerus))->first();
                $result['biaya_penerus'] = number_format($biaya_penerus->harga, 0, ",", ".");
            }
            $result['harga'] = number_format($harga->harga, 0, ",", ".");
            $result['satuan'] = $harga->kode_satuan;
            $result['jumlah_data'] = $jumlah_data;
            $result['acc_penjualan']=$data[0]->acc_penjualan;
        }else{
            $harga = 0;
            $result['harga'] = 0;
            $result['biaya_penerus'] = 0;
            $result['jumlah_data'] = 0;
        }
        
        return json_encode($result);
    }
    
    public function cetak_nota($nomor=null) {
        
        $nomor = str_replace('-', '/', $nomor);

        $nota = DB::table('delivery_order')
                  ->where('nomor',$nomor)
                  ->get();
        $kota = DB::table('kota')
                  ->get();
        $customer = DB::table('customer')
                      ->where('pic_status','AKTIF')
                      ->get(); 

        for ($i=0; $i < count($kota); $i++) { 
            for ($a=0; $a < count($nota); $a++) { 
                if ($nota[$a]->id_kota_asal == $kota[$i]->id) {
                    $nota[$a]->asal = $kota[$i]->nama;
                }

                if ($nota[$a]->id_kota_tujuan == $kota[$i]->id) {
                    $nota[$a]->tujuan = $kota[$i]->nama;
                }
            }
        }

        for ($i=0; $i < count($customer); $i++) { 
            for ($a=0; $a < count($nota); $a++) { 
                if ($nota[$a]->kode_customer == $customer[$i]->kode) {
                    $nota[$a]->nama_customer = $customer[$i]->nama;
                    $nota[$a]->alamat = $customer[$i]->alamat;
                    $nota[$a]->telpon = $customer[$i]->telpon;
                }
            }
        }

        $count = count($nota);
        $array = [];
        if ($count<15) {
            $temp = 15- $count;
            for ($i=0; $i < $temp; $i++) { 
                $array[$i] = '';
            }
        }
        // return $nota;
        //$pdf = PDF::loadView('sales.do.nota',compact('nota'))->setPaper('a4', 'potrait');
        //return $pdf->stream();
        return view('sales.do_kargo.print',compact('nota','array'));

    }
	
    public function cari_nopol_kargo(request $request)
    {   
        // return dd($request->all());
        if ($request->status_kendaraan == 'OWN') {
            $jenis = ['OWN','DPT','SEWA'];
            $data = DB::table('kendaraan')
                  ->join('tipe_angkutan','tipe_angkutan.kode','=','kendaraan.tipe_angkutan')
                  ->whereIn('kendaraan.status',$jenis)
                  ->where('kendaraan.tipe_angkutan',$request->tipe_angkutan)
                  // ->where('kode_cabang',$request->cabang_select)
                  ->get();
        }else{
            $data = DB::table('kendaraan')
                  ->join('tipe_angkutan','tipe_angkutan.kode','=','kendaraan.tipe_angkutan')
                  ->where('kendaraan.tipe_angkutan',$request->tipe_angkutan)
                  ->where('kendaraan.status','SUB')
                  // ->where('kode_cabang',$request->cabang_select)
                  ->where('kendaraan.kode_subcon',strtoupper($request->nama_subcon))
                  ->get();
        }
        
        if ($data == null) {
            $status = 0;
        }else{  
            $status = 1;
        }
        if (isset($request->nopol)) {
            $nopol = $request->nopol;
        }else{
            $nopol = 0;
        }
        return view('sales.do_kargo.dropdown_nopol',compact('data','status','nopol'));
    }
    public function nama_subcon(request $request)
    {
        $nama = DB::table('subcon')
                  ->where('kode',$request->nama_subcon)
                  ->first();
        return response()->json(['nama'=>$nama->nama]);
    }
    public function cari_kontrak_tarif(request $request)
    {
        if ($request->check == 'false') {
           $data = DB::table('tarif_cabang_kargo')
                      ->join('jenis_tarif','jenis','=','jt_id')
                      ->where('id_kota_asal',$request->asal)
                      ->where('id_kota_tujuan',$request->tujuan)
                      ->where('jenis',$request->jenis_tarif)
                      ->where('kode_cabang',$request->cabang_select)
                      ->where('kode_angkutan',$request->tipe_angkutan)
                      ->orderBy('tarif_cabang_kargo.kode','ASC')
                      ->get();

            $asal = DB::table('tarif_cabang_kargo')
                      ->join('kota','id','=','id_kota_asal')
                      ->where('id_kota_asal',$request->asal)
                      ->where('id_kota_tujuan',$request->tujuan)
                      ->where('jenis',$request->jenis_tarif)
                      ->where('kode_cabang',$request->cabang_select)
                      ->where('kode_angkutan',$request->tipe_angkutan)
                      ->orderBy('tarif_cabang_kargo.kode','ASC')
                      ->get();

            $tujuan = DB::table('tarif_cabang_kargo')
                      ->join('kota','id','=','id_kota_tujuan')
                      ->where('id_kota_asal',$request->asal)
                      ->where('jenis',$request->jenis_tarif)
                      ->where('id_kota_tujuan',$request->tujuan)
                      ->where('kode_cabang',$request->cabang_select)
                      ->where('kode_angkutan',$request->tipe_angkutan)
                      ->get();
            for ($i=0; $i < count($data); $i++) { 
                $data[$i]->nama_asal = $asal[$i]->nama;
                $data[$i]->nama_tujuan = $tujuan[$i]->nama;
            }
            $kontrak = 0;
        }else {
            $data = DB::table('kontrak_customer')
                      ->join('kontrak_customer_d','kcd_id','=','kc_id')
                      ->join('jenis_tarif','kcd_jenis_tarif','=','jt_id')
                      ->where('kc_kode_customer',$request->customer)
                      // ->where('kcd_kota_tujuan',$request->tujuan)
                      ->where('kc_kode_cabang',$request->cabang_select)
                      ->where('kcd_jenis','KARGO')
                      ->where('kcd_active',true)
                      ->orderBy('kcd_id','ASC')
                      ->get();

            $kota = DB::table('kota')
                      ->get();

            $tipe_angkutan = DB::table('tipe_angkutan')
                               ->get();


            for ($i=0; $i < count($kota); $i++) { 
                for ($a=0; $a < count($data); $a++) { 
                    if ($data[$a]->kcd_kota_asal == $kota[$i]->id) {
                        $data[$a]->nama_asal = $kota[$i]->nama;
                    }

                    if ($data[$a]->kcd_kota_tujuan == $kota[$i]->id) {
                        $data[$a]->nama_tujuan = $kota[$i]->nama;
                    }
                }
            }
            for ($i=0; $i < count($tipe_angkutan); $i++) { 
              for ($a=0; $a < count($data); $a++) { 
                if ($data[$a]->kcd_kode_angkutan == $tipe_angkutan[$i]->kode) {
                  $data[$a]->nama_angkutan = $tipe_angkutan[$i]->nama;
                }
              }
            }


            $kontrak = 1;
            // return $data;
        }

        return view('sales.do_kargo.modal_tarif',compact('data','kontrak'));
    }
    public function nomor_do_kargo(request $request)
    {
        $bulan  = Carbon::now()->format('m');
        $tahun  = Carbon::now()->format('y');
        $cabang = $request->cabang;
        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from delivery_order
                                        WHERE kode_cabang = '$cabang'
                                        AND to_char(created_at,'MM') = '$bulan'
                                        AND nomor like 'KGO%'
                                        AND to_char(created_at,'YY') = '$tahun'
                                        ");

        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);

        $nota = 'KGO' . $cabang . $bulan . $tahun . $index;

        $cari_diskon = DB::table('d_disc_cabang')
                    ->where('dc_cabang',$request->cabang)
                    ->where('dc_jenis','KARGO')
                    ->first();
        if ($cari_diskon == null) {
          $diskon = 'NONE';
        }else{
          $diskon = $cari_diskon->dc_diskon;
        }
        return response()->json(['nota'=>$nota,'diskon'=>$diskon,]);
    }
    public function pilih_tarif_kargo(request $request)
    {
        $data = DB::table('tarif_cabang_kargo')
                  ->where('kode',$request->kode)
                  ->first();
        return response()->json(['data'=>$data]);
    }
    public function pilih_kontrak_kargo(request $request)
    {
        $data = DB::table('kontrak_customer_d')
                  ->where('kcd_id',$request->kcd_id)
                  ->where('kcd_dt',$request->kcd_dt)
                  ->first();
                  
        return response()->json(['data'=>$data]);
    }
    public function drop_cus(request $request)
    {
        $customer = DB::table('customer')
                      ->where('pic_status','AKTIF')
                      ->where('cabang',$request->cabang)
                      ->get();
        return view('master_sales.kontrak.dropdown_customer',compact('customer'));
    }

    public function hapus_do_kargo(request $request)
    {
        // dd($request->all());
        if (isset($request->no_do_old)) {
            $request->nomor_do = $request->no_do_old;
        }
        $hapus_kargo = DB::table('delivery_order') 
                         ->where('nomor',$request->nomor_do)
                         ->delete();
        return response()->json(['status'=>1]);
    }
    public function save_do_kargo(request $request)
    {
       // dd($request->all());

        if ($request->nomor_do == '') {
            return response()->json(['status' => 3,'text'=>'Nomor DO']); 
        }

        if ($request->tanggal_do == '') {
            return response()->json(['status' => 3,'text'=>'Tanggal']);
        }

        if ($request->customer == '0') {
            return response()->json(['status' => 3,'text'=>'Customer']);
        }

        if ($request->asal_do == 0) {
            return response()->json(['status' => 3,'text'=>'Asal DO']);
        }

        if ($request->tujuan_do == 0) {
            return response()->json(['status' => 3,'text'=>'Tujuan DO']);
        }

        if ($request->jenis_tarif_do == 0) {
            return response()->json(['status' => 3,'text'=>'Jenis Tarif DO']);
        }

        if ($request->status_kendaraan == 'SUB') {

            if ($request->nama_subcon == '0') {

                return response()->json(['status' => 3,'text'=>'Nama Subcon' ]);
            }
        }

        if ($request->tipe_angkutan == 0) {
            return response()->json(['status' => 3,'text'=>'Tipe Angkutan' ]);
        }

        if ($request->tipe_kendaraan == 0) {
            return response()->json(['status' => 3,'text'=>'Tipe Kendaraan']);
        }

        if ($request->keterangan_detail == '') {
            return response()->json(['status' => 3,'text'=>'Keterangan']);
        }

        if ($request->ed_awal_shuttle == '') {
            return response()->json(['status' => 3,'text'=>'Awal Shuttle']);
        }
        if ($request->ed_akhir_shuttle == '') {
            return response()->json(['status' => 3,'text'=>'Akhir Shuttle']);
        }
        if ($request->satuan == '') {
            return response()->json(['status' => 3,'text'=>'Satuan']);
        }
        if ($request->jumlah == '') {
            return response()->json(['status' => 3,'text'=>'Jumlah']);
        }
        
        if ($request->tarif_dasar == '' or $request->tarif_dasar == '0') {
            return response()->json(['status' => 3,'text'=>'Tarif Dasar']);
        }
        if ($request->harga_master == '') {
            return response()->json(['status' => 3,'text'=>'Harga Master']);
        }
        if ($request->kode_tarif == '') {
            return response()->json(['status' => 3,'text'=>'Kode Tarif']);
        }
        if ($request->kcd_id == '') {
            return response()->json(['status' => 3,'text'=>'$request->kcd_id']);
        }
        if ($request->kcd_dt == '') {
            return response()->json(['status' => 3,'text'=>'$request->kcd_dt']);
        }

        if ($request->nama_penerima == '') {
            return response()->json(['status' => 3,'text'=>'Nama Penerima']);
        }

        if ($request->alamat_penerima == '') {
            return response()->json(['status' => 3,'text'=>'Alamat Penerima']);
        }

        if ($request->kode_pos_penerima == '') {
            return response()->json(['status' => 3,'text'=>'Kode Pos Penerima']);
        }

        if ($request->telpon_penerima == '') {
            return response()->json(['status' => 3,'text'=>'Telpon Penerima']);
        }
        if ($request->deskripsi_penerima == '') {
            return response()->json(['status' => 3,'text'=>'Deskripsi']);
        }
    
        if ($request->nama_pengirim == '') {
            return response()->json(['status' => 3,'text'=>'Nama Pengirim']);
        }

        
        // dd($discount);
        return DB::transaction(function() use ($request) {  


        // dd($request->all());
        $cari_do = DB::table('delivery_order')
                      ->where('nomor',$request->nomor_do)
                      ->first();
        if ($cari_do != null) {
            return response()->json(['status' => 3,'text'=>'Nomor Resi Telah Digunakan']);
        }
           // dd('asd');    
        $tgl = str_replace('/', '-', $request->tanggal_do);
        $tgl = Carbon::parse($tgl)->format('Y-m-d');
        $awal = str_replace('/', '-', $request->ed_awal_shuttle);
        $awal = Carbon::parse($awal)->format('Y-m-d');
        $akhir = str_replace('/', '-', $request->ed_akhir_shuttle);
        $akhir = Carbon::parse($akhir)->format('Y-m-d');
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_id',$request->jenis_tarif_do)
                         ->first();
        $nopol = DB::table('kendaraan')
                         ->where('id',$request->tipe_kendaraan)
                         ->first();
        if ($request->kcd_id != 0) {
            $kontrak = true;
        }else{
            $kontrak = false;
        }
        
        if ($cari_do == null) {
        // return $discount;

        if ($request->discount == '' || $request->discount == 0) {
            $discount = 0;
        }else{
            $discount = $request->discount;
        }
        // dd($discount);
        $select_akun = DB::table('d_akun')
                         ->where('id_akun','like','1302'.'%')
                         ->where('kode_cabang',$request->cabang)
                         ->first();
        if ($select_akun == null) {
              return response()->json(['status'=>5]);
        }else{
          $akun_piutang = $select_akun->id_akun;
        }

        if ($request->status_kendaraan == 'OWN') {
          $select_akun = DB::table('d_akun')
                         ->where('id_akun','like','4201'.'%')
                         ->where('kode_cabang',$request->cabang)
                         ->first();
          if ($select_akun == null) {
                return response()->json(['status'=>4]);
          }else{
            $akun_pendapatan = $select_akun->id_akun;
          }
        }else if ($request->status_kendaraan == 'SUB'){
          $select_akun = DB::table('d_akun')
                         ->where('id_akun','like','4401'.'%')
                         ->where('kode_cabang',$request->cabang)
                         ->first();
          if ($select_akun == null) {
                return response()->json(['status'=>4]);
          }else{
            $akun_pendapatan = $select_akun->id_akun;
          }
        }
        
            $save_do = DB::table('delivery_order')
                         ->insert([
                                'nomor'                 => $request->nomor_do,
                                'tanggal'               => $tgl,
                                'id_kota_asal'          => (int)$request->asal_do,
                                'id_kota_tujuan'        => (int)$request->tujuan_do,
                                'biaya_tambahan'        => 0,
                                'pendapatan'            => 'KARGO',
                                'type_kiriman'          => 0,
                                'jenis_pengiriman'      => $jenis_tarif->jt_nama_tarif,
                                'kode_tipe_angkutan'    => $request->tipe_angkutan,
                                'nomor_surat_jalan'     => $request->surat_jalan,
                                'nopol'                 => $nopol->nopol,
                                'id_kendaraan'          => (int)$request->tipe_kendaraan,
                                'kode_subcon'           => strtoupper($request->nama_subcon),
                                'kode_cabang'           => $request->cabang,
                                'type_kiriman'          => 'KARGO',
                                'biaya_tambahan'        => filter_var($request->biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                                'tarif_dasar'           => $request->harga_master,
                                'kode_customer'         => $request->customer,
                                'kode_marketing'        => $request->marketing,
                                'company_name_pengirim' => strtoupper($request->company_pengirim),
                                'nama_pengirim'         => strtoupper($request->nama_pengirim),
                                'alamat_pengirim'       => strtoupper($request->alamat_pengirim),
                                'kode_pos_pengirim'     => strtoupper($request->kode_pos_pengirim),
                                'telpon_pengirim'       => strtoupper($request->telpon_pengirim),
                                'company_name_penerima' => strtoupper($request->company_),
                                'nama_penerima'         => strtoupper($request->nama_penerima),
                                'alamat_penerima'       => strtoupper($request->alamat_penerima),
                                'kode_pos_penerima'     => strtoupper($request->kode_pos_penerima),
                                'telpon_penerima'       => strtoupper($request->telpon_penerima),
                                'instruksi'             => strtoupper($request->intruksi_penerima),
                                'deskripsi'             => strtoupper($request->deskripsi_penerima),
                                'total'                 => $request->tarif_dasar,
                                'total_net'             => $request->total,
                                'diskon'                => filter_var($discount, FILTER_SANITIZE_NUMBER_INT),
                                'jenis'                 => 'KARGO',
                                'kontrak_cus'           => $request->kcd_id,
                                'kontrak_cus_dt'        => $request->kcd_dt,
                                'jumlah'                => $request->jumlah,
                                'status_kendaraan'      => strtoupper($request->status_kendaraan),
                                'driver'                => strtoupper($request->driver),
                                'co_driver'             => strtoupper($request->co_driver),
                                'jenis_tarif'           => $request->jenis_tarif_do,
                                'ritase'                => strtoupper($request->ritase),
                                'awal_shutle'           => strtoupper($awal),
                                'akhir_shutle'          => strtoupper($akhir),
                                'nomor_do_awal'         => strtoupper($request->nomor_do_awal),
                                'kode_satuan'           => strtoupper($request->satuan),
                                'kontrak'               => $kontrak,
                                'created_by'            =>  Auth::user()->m_name,
                                'created_at'            =>  Carbon::now(),
                                'updated_by'            =>  Auth::user()->m_name,
                                'updated_at'            =>  Carbon::now(),
                                'kode_tarif'            => $request->kode_tarif,
                                'keterangan_tarif'      => $request->keterangan_detail,
                                'acc_penjualan'         => $akun_pendapatan,
                                'acc_piutang_do'        => $akun_piutang,
                                'csf_piutang_do'        => $akun_piutang,
                                'acc_pendapatan_do'     => $akun_pendapatan,
                                'csf_pendapatan_do'     => $akun_pendapatan,
                                'status_do'             => 'Released'
                         ]);

            $cari_do = DB::table('delivery_order')
                      ->where('nomor',$request->nomor_do)
                      ->first();
            return response()->json(['nota'=>strtoupper($request->nomor_do),'status'=>1]);

        }else{


            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('y');
            $cabang= $request->cabang;
            $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from delivery_order
                                            WHERE kode_cabang = '$cabang'
                                            AND to_char(tanggal,'MM') = '$bulan'
                                            AND jenis = 'KARGO'
                                            AND to_char(tanggal,'YY') = '$tahun'");

            $index = (integer)$cari_nota[0]->id + 1;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);

            $nota = 'KGO' . $cabang . $bulan . $tahun . $index;

            if ($request->discount == '' || $request->discount == 0) {
                $discount = 0;
            }else{
                $discount = $request->discount;
            }

            $select_akun = DB::table('d_akun')
                         ->where('id_akun','like','1302'.'%')
                         ->where('kode_cabang',$request->cabang)
                         ->first();
            if ($select_akun == null) {
              return response()->json(['status'=>4]);
            }else{
              $akun_piutang = $select_akun->id_akun;
            }


            if ($request->status_kendaraan == 'OWN') {
              $select_akun = DB::table('d_akun')
                             ->where('id_akun','like','4201'.'%')
                             ->where('kode_cabang',$request->cabang)
                             ->first();
              if ($select_akun == null) {
                    return response()->json(['status'=>4]);
              }else{
                $akun_pendapatan = $select_akun->id_akun;
              }
            }else if ($request->status_kendaraan == 'SUB'){
              $select_akun = DB::table('d_akun')
                             ->where('id_akun','like','4202'.'%')
                             ->where('kode_cabang',$request->cabang)
                             ->first();
              if ($select_akun == null) {
                    return response()->json(['status'=>4]);
              }else{
                $akun_pendapatan = $select_akun->id_akun;
              }
            }

            $save_do = DB::table('delivery_order')
                         ->insert([
                                'nomor'                 => str_replace(' ','',strtoupper($nota)),
                                'tanggal'               => $tgl,
                                'id_kota_asal'          => $request->asal_do,
                                'id_kota_tujuan'        => $request->tujuan_do,
                                'pendapatan'            => 'KARGO',
                                'type_kiriman'          => 0,
                                'jenis_pengiriman'      => $jenis_tarif->jt_nama_tarif,
                                'kode_tipe_angkutan'    => $request->tipe_angkutan,
                                'nomor_surat_jalan'     => strtoupper($request->surat_jalan),
                                'nopol'                 => $nopol->nopol,
                                'id_kendaraan'          => $request->tipe_kendaraan,
                                'kode_subcon'           => strtoupper($request->nama_subcon),
                                'kode_cabang'           => $request->cabang,
                                'tarif_dasar'           => $request->harga_master,
                                'type_kiriman'          => 'KARGO',
                                'kode_customer'         => $request->customer,
                                'kode_marketing'        => $request->marketing,
                                'company_name_pengirim' => strtoupper($request->company_pengirim),
                                'nama_pengirim'         => strtoupper($request->nama_pengirim),
                                'alamat_pengirim'       => strtoupper($request->alamat_pengirim),
                                'kode_pos_pengirim'     => strtoupper($request->kode_pos_pengirim),
                                'telpon_pengirim'       => strtoupper($request->telpon_pengirim),
                                'company_name_penerima' => strtoupper($request->company_),
                                'nama_penerima'         => strtoupper($request->nama_penerima),
                                'alamat_penerima'       => strtoupper($request->alamat_penerima),
                                'kode_pos_penerima'     => strtoupper($request->kode_pos_penerima),
                                'telpon_penerima'       => strtoupper($request->telpon_penerima),
                                'instruksi'             => strtoupper($request->intruksi_penerima),
                                'deskripsi'             => strtoupper($request->deskripsi_penerima),
                                'total'                 => $request->tarif_dasar,
                                'total_net'             => $request->total,
                                'diskon'                => filter_var($discount, FILTER_SANITIZE_NUMBER_INT),
                                'jenis'                 => 'KARGO',
                                'kontrak_cus'           => $request->kcd_id,
                                'kontrak_cus_dt'        => $request->kcd_dt,
                                'jumlah'                => $request->jumlah,
                                'status_kendaraan'      => strtoupper($request->status_kendaraan),
                                'driver'                => strtoupper($request->driver),
                                'co_driver'             => strtoupper($request->co_driver),
                                'jenis_tarif'           => $request->jenis_tarif_do,
                                'ritase'                => strtoupper($request->ritase),
                                'awal_shutle'           => strtoupper($awal),
                                'created_by'            =>  Auth::user()->m_name,
                                'created_at'            =>  Carbon::now(),
                                'updated_by'             =>  Auth::user()->m_name,
                                'updated_at'             =>  Carbon::now(),
                                'akhir_shutle'          => strtoupper($akhir),
                                'nomor_do_awal'         => strtoupper($request->nomor_do_awal),
                                'kode_tarif'            => $request->kode_tarif,
                                'kontrak'               => $kontrak,
                                'kode_satuan'           => strtoupper($request->satuan),
                                'acc_penjualan'         => $akun_pendapatan,
                                'acc_piutang_do'        => $akun_piutang,
                                'csf_piutang_do'        => $akun_piutang,
                                'acc_pendapatan_do'     => $akun_pendapatan,
                                'csf_pendapatan_do'     => $akun_pendapatan,
                                'status_do'             => 'Released'
                         ]);
            return response()->json(['nota'=>$nota,'status'=>2]);

        }
        });
    }
    
    public function edit_do_kargo($id)
    {
        $id = str_replace('-', '/', $id);
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,tipe FROM customer ORDER BY nama ASC ");
        $kendaraan = DB::select("   SELECT k.id,k.nopol,k.tipe_angkutan,k.status,k.kode_subcon,s.nama FROM kendaraan k
                                    LEFT JOIN subcon s ON s.kode=k.kode_subcon ");
        $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
        //$angkutan = DB::select(" SELECT kode,nama FROM angkutan ORDER BY nama ASC ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $tipe_angkutan =DB::select("SELECT kode,nama FROM tipe_angkutan");
        $subcon =DB::select("SELECT * FROM subcon");
        $now = Carbon::now()->format('d/m/Y');
        $bulan_depan = Carbon::now()->subDay(-30)->format('d/m/Y');
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_group',1)
                         ->orWhere('jt_group',2)
                         ->orWhere('jt_group',3)
                         ->orderBy('jt_id','ASC')
                         ->get();


        $data = DB::table('delivery_order')
                    ->where('nomor', $id)
                    ->first();
        $subcon_detail = DB::table('delivery_order')
                    ->leftjoin('subcon','kode','=','kode_subcon')
                    ->where('nomor', $id)
                    ->first();

        $cari_diskon = DB::table('d_disc_cabang')
                    ->where('dc_cabang',$data->kode_cabang)
                    ->where('dc_jenis','KARGO')
                    ->first();
        if ($cari_diskon == null) {
          $diskon = 'NONE';
        }else{
          $diskon = $cari_diskon->dc_diskon;
        }
       
        return view('sales.do_kargo.edit_kargo',compact('kota','customer', 'kendaraan', 'marketing', 'outlet', 'data', 'jml_detail','cabang','tipe_angkutan','now','jenis_tarif','bulan_depan','subcon','subcon_detail','diskon'));
    }

    public function update_do_kargo(request $request)
    {
      $this->hapus_do_kargo($request);

       return $this->save_do_kargo($request);
    }
    public function cari_kontrak(request $request)
    {
        // return $request->all();
      
        $data = DB::table('customer')
                  ->join('kontrak_customer','kc_kode_customer','=','kode')
                  ->join('kontrak_customer_d','kcd_id','=','kc_id')
                  ->where('kcd_jenis','KARGO')
                  ->where('kc_kode_customer',$request->customer_do)
                  ->where('kc_kode_cabang',$request->cabang)
                  ->where('kc_aktif','AKTIF')
                  ->orderBy('kode','ASC')
                  ->get();
        $customer = DB::table('customer')
                      ->where('pic_status','AKTIF')
                      ->where('kode',$request->customer_do)
                      ->first();

        if ($data != null) {
            return response()->json(['status'=>1,'data'=>$customer]);
        }else{
            return response()->json(['status'=>0,'data'=>$customer]);
        }
    }
    public function detail_do_kargo($id)
    {

        $id = str_replace('-', '/', $id);
      
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,tipe FROM customer ORDER BY nama ASC ");
        $kendaraan = DB::select("   SELECT k.id,k.nopol,k.tipe_angkutan,k.status,k.kode_subcon,s.nama FROM kendaraan k
                                    LEFT JOIN subcon s ON s.kode=k.kode_subcon ");
        $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
        //$angkutan = DB::select(" SELECT kode,nama FROM angkutan ORDER BY nama ASC ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $tipe_angkutan =DB::select("SELECT kode,nama FROM tipe_angkutan");
        $subcon =DB::select("SELECT * FROM subcon");
        $now = Carbon::now()->format('d/m/Y');
        $bulan_depan = Carbon::now()->subDay(-30)->format('d/m/Y');
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_group',1)
                         ->orWhere('jt_group',2)
                         ->orWhere('jt_group',3)
                         ->orderBy('jt_id','ASC')
                         ->get();


        $data = DB::table('delivery_order')
                    ->where('nomor', $id)
                    ->first();
        $subcon_detail = DB::table('delivery_order')
                    ->leftjoin('subcon','kode','=','kode_subcon')
                    ->where('nomor', $id)
                    ->first();

        $cari_diskon = DB::table('d_disc_cabang')
                    ->where('dc_cabang',$data->kode_cabang)
                    ->where('dc_jenis','KARGO')
                    ->first();
        if ($cari_diskon == null) {
          $diskon = 'NONE';
        }else{
          $diskon = $cari_diskon->dc_diskon;
        }
       
        return view('sales.do_kargo.detail_kargo',compact('kota','customer', 'kendaraan', 'marketing', 'outlet', 'data', 'jml_detail','cabang','tipe_angkutan','now','jenis_tarif','bulan_depan','subcon','subcon_detail','diskon'));
    }
  
}
