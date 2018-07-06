<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use carbon\carbon;
use Auth;
use Session;
use Mail;
use Yajra\Datatables\Datatables;
class kontrak_Controller extends Controller
{

    public function index(){
        $cabang = session::get('cabang');
        $jabatan = Auth::user()->m_level;
        $cab     = DB::table('cabang')
                     ->get();
        // $cabang = Auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Kontrak Customer','all')) {
            $data =  DB::table('kontrak_customer')
                   ->join('customer','kode','=','kc_kode_customer')
                   ->orderBy('kc_tanggal','DESC')
                   ->get();
        }else{
            $data =  DB::table('kontrak_customer')
                   ->join('customer','kode','=','kc_kode_customer')
                   ->where('kc_kode_cabang',$cabang)
                   ->orderBy('kc_tanggal','DESC')
                   ->get(); 
        }
        
    
        return view('master_sales.kontrak.index',compact('data','cab'));
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
        $grup_item = DB::select(DB::raw(" SELECT kode,nama FROM grup_item ORDER BY nama ASC "));
        $now1    = Carbon::now()->subDay(-30)->format('d/m/Y');
        $now    = Carbon::now()->format('d/m/Y');

        
        return view('master_sales.kontrak.form',compact('kota','customer','data','cabang','satuan','tipe_angkutan','akun','now','now1','jenis_tarif','grup_item'));
    }
    public function drop_cus(request $request)
    {
        // $cabang = session::get('cabang');
        // $cabang = Auth::user()->kode_cabang;
        $customer = DB::table('customer')
                      // ->leftjoin('kontrak_customer','kc_kode_customer','=','kode')
                      // ->where('kc_kode_cabang',$request->cabang)
                      // ->where('kc_kode_customer',null)
                      ->get();

        $kota     = DB::table("kota")
                      ->get();

        for ($i=0; $i < count($customer); $i++) { 
          for ($a=0; $a < count($kota); $a++) { 
            if ($customer[$i]->kota == $kota[$a]->id) {
                $customer[$i]->nama_kota = $kota[$a]->nama;
            }
          }
        }
        // return $customer;
        return view('master_sales.kontrak.dropdown_customer',compact('customer','kota'));
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
                 ->where('id_akun','like','4'.'%')
                 ->get();
       return view('master_sales.kontrak.acc_drop',compact('data'));
    }
     public function set_kode_akun_csf(request $request)
    {
       $data = DB::table('d_akun')
                 ->where('id_akun','like','4'.'%')
                 ->get();
       return view('master_sales.kontrak.csf_drop',compact('data'));
    }
    public function save_kontrak(request $request)
    {   
        // dd($request->all());
        $cari_kontrak = DB::table('kontrak_customer')
                          ->where('kc_nomor',$request->kontrak_nomor)
                          ->where('kc_kode_cabang',$request->cabang)
                          ->where('kc_kode_customer',$request->customer)
                          ->first();
        $mulai = str_replace('/', '-', $request->ed_mulai);
        $akhir = str_replace('/', '-', $request->ed_akhir);
        $tgl = str_replace('/', '-', $request->ed_tanggal);
        $mulai = Carbon::parse($mulai)->format('Y-m-d');
        $akhir = Carbon::parse($akhir)->format('Y-m-d');
        $tgl = Carbon::parse($tgl)->format('Y-m-d');

        if ($cari_kontrak != null) { 

            $cari_id = DB::table('kontrak_customer')
                          ->where('kc_nomor',$request->kontrak_nomor)
                          ->first();

            if ($cari_id != null) {
              $id = $cari_id->kc_id;
            }else{
              $id = DB::table('kontrak_customer')
                    ->max('kc_id');
              if ($id == null) {
                  $id = 1;
              }else{
                  $id += 1;
              }
            }

           
            if ($request->ck_aktif == 'on') {
               $kc_aktif = 'AKTIF';
            }else{
               $kc_aktif = 'NON AKTIF';
            }

            $data = array(
                      'kc_id'             => $id,
                      'kc_tanggal'        => $tgl,
                      'kc_kode_customer'  => $request->customer,
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
            );


            if ($cari_id != null) {

              $save_kontrak = DB::table('kontrak_customer')
                              ->where('kc_id',$id)
                              ->update($data);
            }else{
              $save_kontrak = DB::table('kontrak_customer')
                              ->insert($data);
            }
            
        }else{ 

            $cari_id = DB::table('kontrak_customer')
                          ->where('kc_nomor',$request->kontrak_nomor)
                          ->first();

            if ($cari_id != null) {
              $id = $cari_id->kc_id;
            }else{
              $id = DB::table('kontrak_customer')
                    ->max('kc_id');
              if ($id == null) {
                  $id = 1;
              }else{
                  $id += 1;
              }
            }

           
            if ($request->ck_aktif == 'on') {
               $kc_aktif = 'AKTIF';
            }else{
               $kc_aktif = 'NON AKTIF';
            }

            $data = array(
                      'kc_id'             => $id,
                      'kc_tanggal'        => $tgl,
                      'kc_kode_customer'  => $request->customer,
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
            );


            
         
              if ($cari_id != null) {

                $save_kontrak = DB::table('kontrak_customer')
                                ->where('kc_id',$id)
                                ->update($data);
              }else{
                $save_kontrak = DB::table('kontrak_customer')
                                ->insert($data);
              }
        }


        if ($request->id_detail == 0) {
          $dt = DB::table('kontrak_customer_d')
                    ->where('kcd_kode',$request->kontrak_nomor)
                    ->max('kcd_dt');

          if ($dt == null) {
              $dt = 1;
          }else{
              $dt += 1;
          }
        }else{
          $dt = $request->id_detail;
        }
        
        $data_dt = array(
                            'kcd_id'            => $id,
                            'kcd_dt'            => $dt,
                            'kcd_kota_asal'     => $request->asal_modal,
                            'kcd_kota_tujuan'   => $request->tujuan_modal,
                            'kcd_jenis'         => $request->jenis_modal,
                            'kcd_harga'         => filter_var($request->harga_modal, FILTER_SANITIZE_NUMBER_INT),
                            'kcd_keterangan'    => $request->keterangan_modal,
                            'kcd_kode_satuan'   => $request->satuan_modal,
                            'kcd_type_tarif'    => $request->tipe_tarif_modal,
                            'kcd_jenis_tarif'   => $request->jenis_tarif_modal,
                            'kcd_kode_angkutan' => $request->tipe_angkutan_modal,
                            'kcd_acc_penjualan' => $request->acc_akun_modal,
                            'kcd_csf_penjualan' => $request->csf_akun_modal,
                            'kcd_kode'          => $request->kontrak_nomor,
                            'kcd_active'        => false,
                            'kcd_grup'          => $request->grup_item_modal,
                        );

         $data = ['kontrak'=>url('master_sales/edit_kontrak/'.$request->id),'status'=>'Customer'];

        Mail::send('hello', $data, function ($mail)
            {
              // Email dikirimkan ke address "momo@deviluke.com" 
              // dengan nama penerima "Momo Velia Deviluke"
              $mail->from('jpm@gmail.com', 'SYSTEM JPM');
              $mail->to('dewa17a@gmail.com', 'Admin');
         
              // Copy carbon dikirimkan ke address "haruna@sairenji" 
              // dengan nama penerima "Haruna Sairenji"
              $mail->cc('dewa17a@gmail.com', 'ADMIN JPM');
         
              $mail->subject('KONTRAK VERIFIKASI');
            });

        if ($request->id_detail == 0) {
          $save_detail = DB::table('kontrak_customer_d')
                          ->insert($data_dt);
        }else{
          $save_detail = DB::table('kontrak_customer_d')
                          ->where('kcd_kode',$request->kontrak_nomor)
                          ->where('kcd_dt',$request->id_detail)
                          ->update($data_dt);
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
        $kota    = DB::table('kota')
                  ->get();

        $grup_item = DB::select(DB::raw(" SELECT kode,nama FROM grup_item ORDER BY nama ASC "));
                  
        for ($i=0; $i < count($data_dt); $i++) { 
          for ($a=0; $a < count($kota); $a++) { 
            if ($kota[$a]->id == $data_dt[$i]->kcd_kota_asal) {
              $data_dt[$i]->nama_asal = $kota[$a]->nama;
            }
            if ($kota[$a]->id == $data_dt[$i]->kcd_kota_tujuan) {
              $data_dt[$i]->nama_tujuan = $kota[$a]->nama;
            }
          }
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

        for ($i=0; $i < count($kota); $i++) { 
          if ($data->kota == $kota[$i]->id) {
            $data->nama_kota = $kota[$i]->nama;
          }
        }
        

        return view('master_sales.kontrak.edit_kontrak',compact('data','data_dt','kota','customer','data','cabang','satuan','tipe_angkutan','now','now1','jenis_tarif','grup_item','id'));
    }
  
    public function detail_kontrak($id)
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
        $kota    = DB::table('kota')
                  ->get();

        $grup_item = DB::select(DB::raw(" SELECT kode,nama FROM grup_item ORDER BY nama ASC "));
                  
        for ($i=0; $i < count($data_dt); $i++) { 
          for ($a=0; $a < count($kota); $a++) { 
            if ($kota[$a]->id == $data_dt[$i]->kcd_kota_asal) {
              $data_dt[$i]->nama_asal = $kota[$a]->nama;
            }
            if ($kota[$a]->id == $data_dt[$i]->kcd_kota_tujuan) {
              $data_dt[$i]->nama_tujuan = $kota[$a]->nama;
            }
          }
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

        for ($i=0; $i < count($kota); $i++) { 
          if ($data->kota == $kota[$i]->id) {
            $data->nama_kota = $kota[$i]->nama;
          }
        }
        

        return view('master_sales.kontrak.detail_kontrak',compact('data','data_dt','kota','customer','data','cabang','satuan','tipe_angkutan','now','now1','jenis_tarif','grup_item','id'));
    }

    public function datatable_kontrak(request $request)
    {

      // DD($request->all());
        $data = DB::table('kontrak_customer_d')
                  ->where('kcd_kode',$request->nota)
                  ->orderBy('kcd_dt','ASC')
                  ->get();
        
        
        // return $data;
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('harga', function ($data) {
                                return number_format($data->kcd_harga,0,',','.');
                        })
                        ->addColumn('asal', function ($data) {

                          $kota = DB::table('kota')
                                    ->get();

                          $tipe_angkutan = DB::table('tipe_angkutan')
                                    ->get();

                          for ($a=0; $a < count($kota); $a++) { 
                            if ($data->kcd_kota_asal == $kota[$a]->id) {
                              $kota_asal = $kota[$a]->nama;
                            }
                          }
                          return $data->kcd_kota_asal . '-' . $kota_asal;
                                
                        })
                        ->addColumn('tujuan', function ($data) {

                          $kota = DB::table('kota')
                                    ->get();

                          $tipe_angkutan = DB::table('tipe_angkutan')
                                    ->get();

                          for ($a=0; $a < count($kota); $a++) { 
                            if ($data->kcd_kota_tujuan == $kota[$a]->id) {
                              $kota_tujuan = $kota[$a]->nama;
                            }
                          }
                          return $data->kcd_kota_tujuan . '-' . $kota_tujuan;
                        })
                        ->addColumn('angkutan', function ($data) {
                          $kota = DB::table('kota')
                                    ->get();

                          $tipe_angkutan = DB::table('tipe_angkutan')
                                    ->get();

                          for ($a=0; $a < count($tipe_angkutan); $a++) { 
                            if ($data->kcd_kode_angkutan == $tipe_angkutan[$a]->kode) {
                              $angkutan = $tipe_angkutan[$a]->nama;
                            }
                          }
                          return $data->kcd_kode_angkutan . '-' . $angkutan;
                        })
                        ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-warning edit btn-sm" title="edit">'.
                                   '<label class="fa fa-pencil"></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger hapus btn-sm" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })
                        ->addColumn('active', function ($data) {
                          if (Auth::user()->punyaAkses('Verifikasi','aktif')) {
                            if($data->kcd_active == true){
                              return '<input checked type="checkbox" onchange="check(this)" class="form-control check">';
                            }else{
                              return '<input type="checkbox" onchange="check(this)" class="form-control check">';
                            }
                          }else{
                              return '-';
                          }
                           
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->make(true);
    }

    public function set_modal(request $request)
    {
      $data = DB::table('kontrak_customer_d')
                ->where('kcd_kode',$request->nota)
                ->where('kcd_dt',$request->kcd_dt)
                ->first();
      return response()->json(['data'=>$data]);
    }

    public function hapus_d_kontrak(request $request)
    {
      $data = DB::table('kontrak_customer_d')
                ->where('kcd_kode',$request->nota)
                ->where('kcd_dt',$request->kcd_dt)
                ->delete();
    }

    public function check_kontrak(request $request)
    {
        // dd($request->all());
      // return dd($request->all());

        if ($request->check == 'true') {
         // return $request->check;

            $data_dt = DB::table('kontrak_customer_d')
                ->where('kcd_kode',$request->nota)
                ->where('kcd_dt',$request->kcd_dt)
                ->update([
                  'kcd_active' => true 
                ]);

             
             return json_encode('success 1');

        }else{

          $data_dt = DB::table('kontrak_customer_d')
                ->where('kcd_kode',$request->nota)
                ->where('kcd_dt',$request->kcd_dt)
                ->update([
                  'kcd_active' => $request->check 
                ]);
             return json_encode('success 2');
        }
    }
}
