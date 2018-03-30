<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use carbon\carbon;
use Auth;
use Session;

class kontrak_Controller extends Controller
{

    public function index(){
        $cabang = session::get('cabang');
        // $cabang = Auth::user()->kode_cabang;
        if (Auth::user()->m_level == 'ADMINISTRATOR' || Auth::user()->m_level == 'SUPERVISOR') {
            $data =  DB::table('kontrak_customer')
                   ->join('customer','kode','=','kc_kode_customer')
                   ->get();
        }else{
            $data =  DB::table('kontrak_customer')
                   ->join('customer','kode','=','kc_kode_customer')
                   ->where('kc_kode_cabang',$cabang)
                   ->get(); 
        }
        

        return view('master_sales.kontrak.index',compact('data'));
    }
    
    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $tipe_angkutan = DB::select(" SELECT * FROM tipe_angkutan ORDER BY nama ASC ");
        $satuan = DB::table('satuan')
                         ->get();
        $jenis_tarif = DB::table('jenis_tarif')
                         ->orderBy('jt_id','ASC')
                         ->get();
        $now1    = Carbon::now()->subDay(-30)->format('d/m/Y');
        $now    = Carbon::now()->format('d/m/Y');

        
        return view('master_sales.kontrak.form',compact('kota','customer','data','cabang','satuan','tipe_angkutan','akun','now','now1','jenis_tarif'));
    }
    public function drop_cus(request $request)
    {
        // $cabang = session::get('cabang');
        // $cabang = Auth::user()->kode_cabang;
        $customer = DB::table('customer')
                      ->leftjoin('kontrak_customer','kc_kode_customer','=','kode')
                      ->where('cabang',$request->cabang)
                      ->where('kc_kode_customer',null)
                      ->get();
        return view('master_sales.kontrak.dropdown_customer',compact('customer'));
    }

    public function kontrak_set_nota(request $request)
    {   

        $month    = Carbon::now()->format('m');
        $year     = Carbon::now()->format('y');
        $idfaktur = DB::table('kontrak_customer')
                      ->where('kc_kode_cabang' , $request->cabang)
                      ->max('kc_nomor');
        //  dd($nosppid);
            // return $idfaktur;
            if(isset($idfaktur)) {
                $explode  = explode("/", $idfaktur);
                $idfaktur = $explode[2];
                $idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
                $idfaktur = str_replace('-', '', $idfaktur) ;
                $string   = (int)$idfaktur + 1;
                $idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);

            }else{

                $idfaktur = '001';
            }

        $nota = 'KNK' . $month . $year . '/' . $request->cabang . '/' .  $idfaktur;
        return response()->json(['nota'=>$nota]);
    }
    public function set_kode_akun_acc(request $request)
    {   
       $data = DB::table('d_akun')
                 ->where('kode_cabang',$request->cabang)
                 ->where('id_parrent','LIKE','%'.'13'.'%')
                 ->get();
       return view('master_sales.kontrak.acc_drop',compact('data'));
    }
     public function set_kode_akun_csf(request $request)
    {
       $data = DB::table('d_akun')
                 ->where('kode_cabang',$request->cabang)
                 ->where('id_parrent','LIKE','%'.'13'.'%')
                 ->get();
       return view('master_sales.kontrak.csf_drop',compact('data'));
    }
    public function save_kontrak(request $request)
    {   
        // dd($request->all());
        $cari_kontrak = DB::table('kontrak_customer')
                          ->where('kc_nomor',$request->kontrak_nomor)
                          ->first();
        $mulai = str_replace('/', '-', $request->ed_mulai);
        $akhir = str_replace('/', '-', $request->ed_akhir);
        $tgl = str_replace('/', '-', $request->ed_tanggal);
        $mulai = Carbon::parse($mulai)->format('Y-m-d');
        $akhir = Carbon::parse($akhir)->format('Y-m-d');
        $tgl = Carbon::parse($tgl)->format('Y-m-d');


        if ($cari_kontrak == null) {
            $id = DB::table('kontrak_customer')
                    ->max('kc_id');
            if ($id == null) {
                $id = 1;
            }else{
                $id += 1;
            }
            if ($request->ck_aktif == 'on') {
               $kc_aktif = 'AKTIF';
            }else{
               $kc_aktif = 'NON AKTIF';
            }
            $save_kontrak = DB::table('kontrak_customer')
                              ->insert([
                                'kc_id'             => $id,
                                'kc_tanggal'        => $tgl,
                                'kc_kode_customer'  => $request->id_subcon,
                                'kc_keterangan'     => $request->ed_keterangan,
                                'kc_kode_cabang'    => $request->cabang,
                                'kc_created_by'     => Auth::user()->m_username,
                                'kc_created_at'     => Carbon::now(),
                                'kc_updated_at'     => Carbon::now(),
                                'kc_updated_by'     => Auth::user()->m_username,
                                'kc_mulai'          => $mulai,
                                'kc_akhir'          => $akhir,
                                'kc_aktif'          => $kc_aktif,
                                'kc_nomor'          => $request->kontrak_nomor
                              ]);
        }else{
            return response()->json(['status'=>2]);
        }

        for ($i=0; $i < count($request->kota_asal); $i++) { 

            $save_detail = DB::table('kontrak_customer_d')
                             ->insert([
                                'kcd_id'            => $id,
                                'kcd_dt'            => $i+1,
                                'kcd_kota_asal'     => $request->kota_asal[$i],
                                'kcd_kota_tujuan'   => $request->kota_tujuan[$i],
                                'kcd_jenis'         => $request->jenis_modal[$i],
                                'kcd_harga'         => filter_var($request->harga[$i], FILTER_SANITIZE_NUMBER_INT),
                                'kcd_keterangan'    => $request->keterangan[$i],
                                'kcd_kode_satuan'   => $request->satuan[$i],
                                'kcd_type_tarif'    => $request->type_tarif[$i],
                                'kcd_jenis_tarif'   => $request->jenis_tarif[$i],
                                'kcd_kode_angkutan' => $request->tipe_angkutan[$i],
                                'kcd_acc_penjualan' => $request->akun_acc[$i],
                                'kcd_csf_penjualan' => $request->akun_csf[$i],
                                'kcd_kode'          => $request->kontrak_nomor,
                             ]);
        }

        return response()->json(['status'=>1]);

    }
    public function hapus_kontrak(request $request)
    {
        $hapus_detail = DB::table('kontrak_customer')
                          ->where('kc_id',$request->id)
                          ->delete();
        return response()->json(['status'=>1]);
    }
    public function edit_kontrak($id)
    {   
        $data    = DB::table('kontrak_customer')
                  ->join('customer','kode','=','kc_kode_customer')
                  ->where('kc_id',$id)
                  ->first();

        $data_dt = DB::table('kontrak_customer_d')              
                  ->join('jenis_tarif','jt_id','=','kcd_jenis_tarif')
                  ->join('tipe_angkutan','kode','=','kcd_kode_angkutan')
                  ->where('kcd_id',$id)
                  ->get();
        $asal    = DB::table('kontrak_customer_d')
                  ->join('kota','id','=','kcd_kota_asal')
                  ->where('kcd_id',$id)
                  ->get();
        $tujuan  = DB::table('kontrak_customer_d')
                  ->join('kota','id','=','kcd_kota_tujuan')
                  ->where('kcd_id',$id)
                  ->get();
                  
        for ($i=0; $i < count($data_dt); $i++) { 
            $data_dt[$i]->nama_asal = $asal[$i]->nama;
            $data_dt[$i]->nama_tujuan = $tujuan[$i]->nama;
        }

        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $tipe_angkutan = DB::select(" SELECT * FROM tipe_angkutan ORDER BY nama ASC ");
        $satuan = DB::table('satuan')
                         ->get();
        $jenis_tarif = DB::table('jenis_tarif')
                         ->orderBy('jt_id','ASC')
                         ->get();
        $now1    = Carbon::now()->subDay(-30)->format('d/m/Y');
        $now    = Carbon::now()->format('d/m/Y');

        
        return view('master_sales.kontrak.edit_kontrak',compact('data','data_dt','kota','customer','data','cabang','satuan','tipe_angkutan','now','now1','jenis_tarif'));
    }
    public function update_kontrak(request $request)
    {   
        // dd($request->all());
       $cari_kontrak = DB::table('kontrak_customer')
                          ->where('kc_nomor',$request->kontrak_nomor)
                          ->first();
        $mulai = str_replace('/', '-', $request->ed_mulai);
        $akhir = str_replace('/', '-', $request->ed_akhir);
        $tgl = str_replace('/', '-', $request->ed_tanggal);
        $mulai = Carbon::parse($mulai)->format('Y-m-d');
        $akhir = Carbon::parse($akhir)->format('Y-m-d');
        $tgl = Carbon::parse($tgl)->format('Y-m-d');


            if ($request->ck_aktif == 'on') {
               $kc_aktif = 'AKTIF';
            }else{
               $kc_aktif = 'NON AKTIF';
            }
            $save_kontrak = DB::table('kontrak_customer')
                              ->where('kc_nomor',$request->kontrak_nomor)
                              ->update([
                                'kc_id'             => $cari_kontrak->kc_id,
                                'kc_tanggal'        => $tgl,
                                'kc_kode_customer'  => $request->id_subcon,
                                'kc_keterangan'     => $request->ed_keterangan,
                                'kc_kode_cabang'    => $request->cabang,
                                'kc_created_by'     => Auth::user()->m_username,
                                'kc_created_at'     => Carbon::now(),
                                'kc_updated_at'     => Carbon::now(),
                                'kc_updated_by'     => Auth::user()->m_username,
                                'kc_mulai'          => $mulai,
                                'kc_akhir'          => $akhir,
                                'kc_aktif'          => $kc_aktif,
                                'kc_nomor'          => $request->kontrak_nomor
                              ]);

        $delete_detail = DB::table('kontrak_customer_d')
                            ->where('kcd_id',$cari_kontrak->kc_id)
                            ->delete();
        for ($i=0; $i < count($request->kota_asal); $i++) { 
            $save_detail = DB::table('kontrak_customer_d')
                             ->insert([
                                'kcd_id'            => $cari_kontrak->kc_id,
                                'kcd_dt'            => $i+1,
                                'kcd_kota_asal'     => $request->kota_asal[$i],
                                'kcd_kota_tujuan'   => $request->kota_tujuan[$i],
                                'kcd_jenis'         => $request->jenis_modal[$i],
                                'kcd_harga'         => filter_var($request->harga[$i], FILTER_SANITIZE_NUMBER_INT),
                                'kcd_keterangan'    => $request->keterangan[$i],
                                'kcd_kode_satuan'   => $request->satuan[$i],
                                'kcd_kode_angkutan' => $request->tipe_angkutan[$i],
                                'kcd_type_tarif'    => $request->type_tarif[$i],
                                'kcd_jenis_tarif'   => $request->jenis_tarif[$i],
                                'kcd_acc_penjualan' => $request->akun_acc[$i],
                                'kcd_csf_penjualan' => $request->akun_csf[$i],
                                'kcd_kode'          => $request->kontrak_nomor,
                             ]);
        }
        return response()->json(['status'=>1]);

    }
}
