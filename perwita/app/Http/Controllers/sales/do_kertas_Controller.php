<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\carbon;
use Auth;


class do_kertas_Controller extends Controller
{
    
    public function index(){
        $cabang = auth::user()->kode_cabang;
        if (Auth::user()->punyaAkses('Delivery Order Koran','all')) {
            $data = DB::table('delivery_order')
                      ->join('customer','kode','=','kode_customer')
                      ->where('jenis','KORAN')
                      ->get();
        }else{
            $data = DB::table('delivery_order')
                      ->join('customer','kode','=','kode_customer')
                      ->where('jenis','KORAN')
                      ->where('kode_cabang',$cabang)
                      ->get();
        }
        $cabang = DB::table('cabang')
                    ->get();

        // $delete = DB::table('delivery_order')
        //             ->delete();

        // $delete = DB::table('delivery_orderd')
        //             ->delete();

        // $delete = DB::table('invoice')
        //             ->delete();

        // $delete = DB::table('invoice_pembetulan')
        //             ->delete();

        // $delete = DB::table('kwitansi')
        //             ->delete();

        // $delete = DB::table('cn_dn_penjualan')
        //             ->delete();

        // $delete = DB::table('uang_muka_penjualan')
        //             ->delete();
        for ($i=0; $i < count($data); $i++) { 
            for ($a=0; $a < count($cabang); $a++) { 
                if ($data[$i]->kode_cabang == $cabang[$a]->kode) {
                    $data[$i]->nama_cabang = $cabang[$a]->nama;
                }
            }
        }
        return view('sales.do_kertas.index',compact('data'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,alamat,telpon FROM customer ORDER BY nama ASC ");
        $item = DB::select(" SELECT kode,nama,harga,kode_satuan,acc_penjualan FROM item ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('delivery_order')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(dd_id) jumlah FROM delivery_orderd WHERE dd_nomor ='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }   
        return view('sales.do_kertas.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','item' ));
    }

    
    

    public function cetak_nota($nomor=null) {
        $head = DB::table('delivery_order')
                  ->join('customer','kode','=','kode_customer')
                  ->where('nomor',$nomor)
                  ->first();
        // dd($head);
        if ($head->kontrak == false) {
           $detail =DB::select("   SELECT d.*,i.nama FROM delivery_orderd d,item i
                                WHERE i.kode=d.dd_kode_item AND d.dd_nomor='$nomor'  ORDER BY dd_id");
        }else{
           $detail=DB::table('delivery_orderd')
                              // ->join('kontrak_customer_d','kcd_dt','=','dd_id_kontrak')
                              // ->where('dd_kode_item',$no_kon[$i])
                              // ->where('kcd_dt',$valid[$i])
                              ->where('dd_nomor',$nomor)
                              ->get();

            $kcd=DB::table('kontrak_customer_d')
                              ->get();
            for ($i=0; $i < count($detail); $i++) { 
                for ($a=0; $a < count($kcd); $a++) { 
                    if ($detail[$i]->dd_kode_item == $kcd[$a]->kcd_kode ) {
                        if ($detail[$i]->dd_id_kontrak == $kcd[$a]->kcd_dt) {
                            $detail[$i]->nama_item = $kcd[$a]->kcd_keterangan;
                        }
                    }
                }
            }
            
        }
        // return $nomor;
        // return $detail;

        $count = count($detail);
        $array = [];
        if ($count<15) {
            $temp = 15- $count;
            for ($i=0; $i < $temp; $i++) { 
                $array[$i] = '';
            }
        }
        // return $array;
    
        return view('sales.do_kertas.print',compact('head','detail','array'));

    }

    public function nomor_do_kertas(request $request)
    {
        $bulan  = Carbon::now()->format('m');
        $tahun  = Carbon::now()->format('y');
        $cabang = $request->cabang;
        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from delivery_order
                                        WHERE kode_cabang = '$cabang'
                                        AND to_char(created_at,'MM') = '$bulan'
                                        AND jenis = 'KORAN'
                                        AND nomor like 'KRN%'
                                        AND to_char(created_at,'YY') = '$tahun'");

        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);

        $nota = 'KRN' . $cabang . $bulan . $tahun . $index;
        return response()->json(['nota'=>$nota]);
    }

    public function cari_customer_kertas(request $request)
    {
        $customer = DB::table('customer')
                      ->where('kode',$request->customer)
                      ->first();

        $cari_kontrak = DB::table('customer')
                      ->leftjoin('kontrak_customer','kc_kode_customer','=','kode')
                      ->join('kontrak_customer_d','kcd_id','=','kc_id')
                      ->where('kc_aktif','AKTIF')
                      ->where('kcd_jenis','KORAN')
                      ->where('kode',$request->customer)
                      ->get();
        if ($cari_kontrak != null) {
            $status = 1;
        }else{
            $status = 2;
        }
        return response()->json(['customer'=>$customer,'status'=>$status]);
        
    }

    public function cari_item(request $request)
    {
        $data = DB::table('item')
                  ->join('grup_item','kode_grup_item','=','grup_item.kode')
                  ->where('item.kode',$request->item)
                  ->first();

        
        return json_encode($data);
        
    }

    public function save_do_kertas(request $request)
    {

        // dd($request->all());
        return DB::transaction(function() use ($request) { 

            $cari_do = DB::table('delivery_order')
                      ->where('nomor',$request->ed_nomor)
                      ->first();
            $tgl = str_replace('/', '-', $request->ed_tanggal);
            $tgl = carbon::parse($tgl)->format('Y-m-d');

            if ($cari_do == null) {
                $save_head = DB::table('delivery_order')
                               ->insert([
                                'nomor'             => str_replace(' ','',strtoupper($request->ed_nomor)),
                                'tanggal'           => $tgl,
                                'kode_customer'     => $request->customer,
                                'pendapatan'        => 'KORAN',
                                'kode_cabang'       => $request->cb_cabang,
                                'diskon'            => $request->ed_diskon_m,
                                'total_net'         => $request->total_net_m,
                                'total'             => $request->ed_total_m+$request->ed_diskon_m,
                                'biaya_tambahan'    => filter_var($request->biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                                'jenis'             => 'KORAN',
                                'kontrak'           => $request->check,
                                'status_do'         => 'Released',
                                'created_by'        =>  Auth::user()->m_name,
                                'created_at'        =>  Carbon::now(),
                                'updated_by'        =>  Auth::user()->m_name,
                                'updated_at'        =>  Carbon::now(),
                                
                               ]);

                for ($i=0; $i < count($request->d_kode_item); $i++) { 
                    $id = DB::table('delivery_orderd')
                            ->max('dd_id');
                    if ($id != null) {
                        $id+=1;
                    }else{
                        $id =1;
                    }
                    // dd($request->all());
                    if ($request->d_kcd_dt[$i] == '') {
                        $d_kcd_dt[$i] = 0;
                    }else{
                        $d_kcd_dt[$i] = $request->d_kcd_dt[$i];
                    }
                    $kcd = DB::table('kontrak_customer_d')
                             ->where('kcd_kode',$request->d_kode_item[$i])
                             ->where('kcd_dt',$d_kcd_dt[$i])
                             ->first();
                    if ($kcd!=null) {
                        $grup = $kcd->kcd_grup;
                    }else{
                        $kcd = DB::table('item')
                             ->where('kode',$request->d_kode_item[$i])
                             ->first();
                        $grup = $kcd->kode_grup_item;
                    }
                    $save_detail = DB::table('delivery_orderd')
                                 ->insert([
                                    'dd_id' => $id,
                                    'dd_nomor' => str_replace(' ','',strtoupper($request->ed_nomor)),
                                    'dd_nomor_dt' => $i+1,
                                    'dd_kode_item' => strtoupper($request->d_kode_item[$i]),
                                    'dd_kode_satuan' => strtoupper($request->d_satuan[$i]),
                                    'dd_jumlah' => $request->d_jumlah[$i],
                                    'dd_harga' => $request->d_harga[$i],
                                    'dd_diskon' => $request->d_diskon[$i],
                                    'dd_total' => $request->d_netto[$i],
                                    'dd_id_kota_asal' => $request->d_asal[$i],
                                    'dd_id_kontrak'   => $d_kcd_dt[$i],
                                    'dd_id_kota_tujuan' => $request->d_tujuan[$i],
                                    'dd_keterangan' => strtoupper($request->d_keterangan[$i]),
                                    'dd_acc_penjualan' => strtoupper($request->d_acc_penjualan[$i]),
                                    'dd_csf_penjualan' => strtoupper($request->d_csf_penjualan[$i]),
                                    'dd_acc_piutang' => strtoupper($request->d_acc_piutang[$i]),
                                    'dd_csf_piutang' => strtoupper($request->d_csf_piutang[$i]),
                                    'dd_grup' => strtoupper( $grup),


                                 ]);
                }
                return response()->json(['status'=>1,'berhasil'=>'success']);
            }else{
                $bulan  = Carbon::now()->format('m');
                $tahun  = Carbon::now()->format('y');
                $cabang = $request->cb_cabang;
                $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from delivery_order
                                                WHERE kode_cabang = '$cabang'
                                                AND to_char(tanggal,'MM') = '$bulan'
                                                AND jenis = 'KORAN'
                                                AND to_char(tanggal,'YY') = '$tahun'");

                $index = (integer)$cari_nota[0]->id + 1;
                $index = str_pad($index, 5, '0', STR_PAD_LEFT);

                $nota = 'KRN' . $cabang . $bulan . $tahun . $index;

                $save_head = DB::table('delivery_order')
                               ->insert([
                                'nomor'             => str_replace(' ','',strtoupper($nota)),
                                'tanggal'           => $tgl,
                                'kode_customer'     => $request->customer,
                                'pendapatan'        => 'KORAN',
                                'diskon'            => $request->ed_diskon_m,
                                'kontrak'           => $request->check,
                                'kode_cabang'       => $request->cb_cabang,
                                'total_net'         => $request->total_net_m,
                                'total'             => $request->ed_total_m+$request->ed_diskon_m,
                                'biaya_tambahan'    => filter_var($request->biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                                'jenis'             => 'KORAN',
                                'created_by'        =>  Auth::user()->m_name,
                                'created_at'        =>  Carbon::now(),
                                'updated_by'         =>  Auth::user()->m_name,
                                'updated_at'         =>  Carbon::now(),
                                'status_do'         => 'Released'
                               ]);
                for ($i=0; $i < count($request->d_kode_item); $i++) { 
                    $id = DB::table('delivery_orderd')
                            ->max('dd_id');
                    if ($id != null) {
                        $id+=1;
                    }else{
                        $id =1;
                    }

                    if ($request->d_kcd_dt[$i] == '') {
                        $d_kcd_dt[$i] = 0;
                    }else{
                        $d_kcd_dt[$i] = $request->d_kcd_dt[$i];
                    }
                    $kcd = DB::table('kontrak_customer_d')
                             ->where('kcd_kode',$request->d_kode_item[$i])
                             ->where('kcd_dt',$d_kcd_dt[$i])
                             ->first();
                    if ($kcd!=null) {
                        $grup = $kcd->kcd_grup;
                    }else{
                        $kcd = DB::table('item')
                             ->where('kode',$request->d_kode_item[$i])
                             ->first();
                        $grup = $kcd->kode_grup_item;
                    }
                    $save_detail = DB::table('delivery_orderd')
                                 ->insert([
                                    'dd_id' => $id,
                                    'dd_nomor' => str_replace(' ','',strtoupper($nota)),
                                    'dd_nomor_dt' => $i+1,
                                    'dd_kode_item' => strtoupper($request->d_kode_item[$i]),
                                    'dd_kode_satuan' => strtoupper($request->d_satuan[$i]),
                                    'dd_jumlah' => $request->d_jumlah[$i],
                                    'dd_harga' => $request->d_harga[$i],
                                    'dd_diskon' => $request->d_diskon[$i],
                                    'dd_total' => $request->d_netto[$i],
                                    'dd_id_kontrak'   => $d_kcd_dt[$i],
                                    'dd_id_kota_asal' => $request->d_asal[$i],
                                    'dd_id_kota_tujuan' => $request->d_tujuan[$i],
                                    'dd_keterangan' => strtoupper($request->d_keterangan[$i]),
                                    'dd_acc_penjualan' => strtoupper($request->d_acc_penjualan[$i]),
                                    'dd_csf_penjualan' => strtoupper($request->d_csf_penjualan[$i]),
                                    'dd_acc_piutang' => strtoupper($request->d_acc_piutang[$i]),
                                    'dd_csf_piutang' => strtoupper($request->d_csf_piutang[$i]),
                                    'dd_grup' => strtoupper( $grup),

                                 ]);
                }

                    return response()->json(['nota'=>$nota,'status'=>2,'berhasil'=>'success']);

            }
        });

    }
    public function hapus_do_kertas(request $request)
    {
        $hapus = DB::table('delivery_order')
                   ->where('nomor',$request->id)
                   ->delete();

     

        return response()->json(['status'=>1]);
    }

    public function edit_do_kertas($id)
    {
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,alamat,telpon FROM customer ORDER BY nama ASC ");
        $item = DB::select(" SELECT kode,nama,harga,kode_satuan,acc_penjualan FROM item ORDER BY nama ASC ");
 

        $data = DB::table('delivery_order')
                  ->where('nomor',$id)
                  ->first();
        if ($data->kontrak == true) {
            $array_valid = DB::table('delivery_order')
                  ->join('delivery_orderd','dd_nomor','=','nomor')
                  ->where('nomor',$id)
                  ->get();

            for ($i=0; $i < count($array_valid); $i++) { 
                $valid[$i] =$array_valid[$i]->dd_id_kontrak;
                $dd_id[$i] =$array_valid[$i]->dd_id;
                $no_kon[$i] =$array_valid[$i]->dd_kode_item;
            }

            $data_dt=DB::table('delivery_orderd')
                              // ->join('kontrak_customer_d','kcd_dt','=','dd_id_kontrak')
                              // ->where('dd_kode_item',$no_kon[$i])
                              // ->where('kcd_dt',$valid[$i])
                              ->where('dd_nomor',$id)
                              ->get();

            $kcd=DB::table('kontrak_customer_d')
                              ->get();
            for ($i=0; $i < count($data_dt); $i++) { 
                for ($a=0; $a < count($kcd); $a++) { 
                    if ($data_dt[$i]->dd_kode_item == $kcd[$a]->kcd_kode ) {
                        if ($data_dt[$i]->dd_id_kontrak == $kcd[$a]->kcd_dt) {
                            $data_dt[$i]->nama_item = $kcd[$a]->kcd_keterangan;
                        }
                    }
                }
            }
            
        }else{
            $data_dt = DB::table('delivery_order')
                  ->join('delivery_orderd','dd_nomor','=','nomor')
                  ->leftjoin('item','dd_kode_item','=','item.kode')
                  ->where('nomor',$id)
                  ->get();
        }
        

        return view('sales.do_kertas.edit_kertas',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','item','id','data_dt'));
    }
    public function update_do_kertas(request $request)
    {

        return DB::transaction(function() use ($request) { 

            $cari_do = DB::table('delivery_order')
                      ->where('nomor',$request->ed_nomor)
                      ->first();
            $tgl = str_replace('/', '-', $request->ed_tanggal);
            $tgl = carbon::parse($tgl)->format('Y-m-d');

            $save_head = DB::table('delivery_order')
                           ->where('nomor',$request->ed_nomor)
                           ->update([
                            'nomor'             => $request->ed_nomor,
                            'tanggal'           => $tgl,
                            'kode_customer'     => $request->customer,
                            'pendapatan'        => 'KORAN',
                            'kode_cabang'       => $request->cb_cabang,
                            'diskon'            => $request->ed_diskon_m,
                            'total_net'         => $request->total_net_m,
                            'total'             => $request->ed_total_m+$request->ed_diskon_m,
                            'biaya_tambahan'    => filter_var($request->biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                            'jenis'             => 'KORAN',
                            'kontrak'           => $request->check,
                            'status_do'         => 'Released',
                            'created_by'        =>  Auth::user()->m_name,
                            'created_at'        =>  Carbon::now(),
                            'updated_by'        =>  Auth::user()->m_name,
                            'updated_at'        =>  Carbon::now(),
                            
                           ]);

            for ($i=0; $i < count($request->d_kode_item); $i++) { 

                $id = DB::table('delivery_orderd')
                        ->max('dd_id');
                if ($id != null) {
                    $id+=1;
                }else{
                    $id =1;
                }
                // dd($request->all());
                if ($request->d_kcd_dt[$i] == '') {
                    $d_kcd_dt[$i] = 0;
                }else{
                    $d_kcd_dt[$i] = $request->d_kcd_dt[$i];
                }
                $kcd = DB::table('kontrak_customer_d')
                         ->where('kcd_kode',$request->d_kode_item[$i])
                         ->where('kcd_dt',$d_kcd_dt[$i])
                         ->first();
                if ($kcd!=null) {
                    $grup = $kcd->kcd_grup;
                }else{
                    $kcd = DB::table('item')
                         ->where('kode',$request->d_kode_item[$i])
                         ->first();
                    $grup = $kcd->kode_grup_item;
                }
                if ($request->d_id[$i] != '' ) {
                    $save_detail = DB::table('delivery_orderd')
                                ->where('dd_id',$request->d_id[$i])
                                ->update([
                                    'dd_id' => $request->d_id[$i],
                                    'dd_nomor' => $request->ed_nomor,
                                    'dd_kode_item' => strtoupper($request->d_kode_item[$i]),
                                    'dd_kode_satuan' => strtoupper($request->d_satuan[$i]),
                                    'dd_jumlah' => $request->d_jumlah[$i],
                                    'dd_harga' => $request->d_harga[$i],
                                    'dd_diskon' => $request->d_diskon[$i],
                                    'dd_total' => $request->d_netto[$i],
                                    'dd_id_kota_asal' => $request->d_asal[$i],
                                    'dd_id_kontrak'   => $d_kcd_dt[$i],
                                    'dd_id_kota_tujuan' => $request->d_tujuan[$i],
                                    'dd_keterangan' => strtoupper($request->d_keterangan[$i]),
                                    'dd_acc_penjualan' => strtoupper($request->d_acc_penjualan[$i]),
                                    'dd_csf_penjualan' => strtoupper($request->d_csf_penjualan[$i]),
                                    'dd_acc_piutang' => strtoupper($request->d_acc_piutang[$i]),
                                    'dd_csf_piutang' => strtoupper($request->d_csf_piutang[$i]),
                                    'dd_grup' => strtoupper($grup),
                             ]);
                }else{
                    $id = DB::table('delivery_orderd')
                            ->max('dd_id');
                    if ($id != null) {
                        $id+=1;
                    }else{
                        $id =1;
                    }

                    $dt = DB::table('delivery_orderd')
                            ->where('dd_nomor',$request->ed_nomor)
                            ->max('dd_nomor_dt');
                    if ($dt != null) {
                        $dt+=1;
                    }else{
                        $dt =1;
                    }


                    $save_detail = DB::table('delivery_orderd')
                                    ->insert([
                                        'dd_id' => $id,
                                        'dd_nomor' => $request->ed_nomor,
                                        'dd_nomor_dt' => $dt,
                                        'dd_kode_item' => strtoupper($request->d_kode_item[$i]),
                                        'dd_kode_satuan' => strtoupper($request->d_satuan[$i]),
                                        'dd_jumlah' => $request->d_jumlah[$i],
                                        'dd_harga' => $request->d_harga[$i],
                                        'dd_diskon' => $request->d_diskon[$i],
                                        'dd_total' => $request->d_netto[$i],
                                        'dd_id_kontrak'   => $d_kcd_dt[$i],
                                        'dd_id_kota_asal' => $request->d_asal[$i],
                                        'dd_id_kota_tujuan' => $request->d_tujuan[$i],
                                        'dd_keterangan' => strtoupper($request->d_keterangan[$i]),
                                        'dd_acc_penjualan' => strtoupper($request->d_acc_penjualan[$i]),
                                        'dd_csf_penjualan' => strtoupper($request->d_csf_penjualan[$i]),
                                        'dd_acc_piutang' => strtoupper($request->d_acc_piutang[$i]),
                                        'dd_csf_piutang' => strtoupper($request->d_csf_piutang[$i]),
                                        'dd_grup' => strtoupper( $grup),
                                    ]);
                }
                
            }
            return response()->json(['status'=>1,'berhasil'=>'success']);
        });
    }

    public function detail_do_kertas($id)
    {
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,alamat,telpon FROM customer ORDER BY nama ASC ");
        $item = DB::select(" SELECT kode,nama,harga,kode_satuan,acc_penjualan FROM item ORDER BY nama ASC ");
 

        $data = DB::table('delivery_order')
                  ->where('nomor',$id)
                  ->first();
        if ($data->kontrak == true) {
            $array_valid = DB::table('delivery_order')
                  ->join('delivery_orderd','dd_nomor','=','nomor')
                  ->where('nomor',$id)
                  ->get();

            for ($i=0; $i < count($array_valid); $i++) { 
                $valid[$i] =$array_valid[$i]->dd_id_kontrak;
                $dd_id[$i] =$array_valid[$i]->dd_id;
                $no_kon[$i] =$array_valid[$i]->dd_kode_item;
            }

            $data_dt=DB::table('delivery_orderd')
                              // ->join('kontrak_customer_d','kcd_dt','=','dd_id_kontrak')
                              // ->where('dd_kode_item',$no_kon[$i])
                              // ->where('kcd_dt',$valid[$i])
                              ->where('dd_nomor',$id)
                              ->get();

            $kcd=DB::table('kontrak_customer_d')
                              ->get();
            for ($i=0; $i < count($data_dt); $i++) { 
                for ($a=0; $a < count($kcd); $a++) { 
                    if ($data_dt[$i]->dd_kode_item == $kcd[$a]->kcd_kode ) {
                        if ($data_dt[$i]->dd_id_kontrak == $kcd[$a]->kcd_dt) {
                            $data_dt[$i]->nama_item = $kcd[$a]->kcd_keterangan;
                        }
                    }
                }
            }
            
        }else{
            $data_dt = DB::table('delivery_order')
                  ->join('delivery_orderd','dd_nomor','=','nomor')
                  ->leftjoin('item','dd_kode_item','=','item.kode')
                  ->where('nomor',$id)
                  ->get();
        }
        return view('sales.do_kertas.detail_kertas',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','item','id','data_dt'));

    }

    public function ganti_item(request $request)
    {
        $status = $request->status;
        $item = DB::select(" SELECT kode,nama,harga,kode_satuan,acc_penjualan FROM item ORDER BY nama ASC ");

        return view('sales.do_kertas.item_kertas',compact('status','item'));
    }
    public function cari_kontrak_kertas(request $request)
    {   
        // dd($request->all());

        if (isset($request->array_kontrak_id)) {
            $array_kontrak = $request->array_kontrak_id;
        }else{
            $array_kontrak = [];
        }

        $cari_kontrak = DB::table('customer')
                      ->leftjoin('kontrak_customer','kc_kode_customer','=','kode')
                      ->join('kontrak_customer_d','kcd_id','=','kc_id')
                      ->join('jenis_tarif','kcd_jenis_tarif','=','jt_id')
                      ->where('kc_aktif','AKTIF')
                      ->where('kcd_jenis','KORAN')
                      ->where('kc_kode_customer',$request->customer)
                      ->get();
        $gp = DB::table('grup_item')
                ->get();

        for ($i=0; $i < count($cari_kontrak); $i++) { 
            for ($a=0; $a < count($gp); $a++) { 
                if ($cari_kontrak[$i]->kcd_grup == $gp[$a]->kode) {
                    $cari_kontrak[$i]->acc_piutang = $gp[$a]->acc_piutang;
                    $cari_kontrak[$i]->csf_piutang = $gp[$a]->csf_piutang;
                }else{
                    $cari_kontrak[$i]->acc_piutang = 0;
                    $cari_kontrak[$i]->csf_piutang = 0;
                }
            }
        }

        // dd($request->all());

        $kota = DB::table('kota')
                   ->get();

        for ($i=0; $i < count($cari_kontrak); $i++) { 
            for ($a=0; $a < count($kota); $a++) { 
                if ($cari_kontrak[$i]->kcd_kota_asal == $kota[$a]->id) {
                    $cari_kontrak[$i]->nama_asal = $kota[$a]->nama;
                }
                if ($cari_kontrak[$i]->kcd_kota_tujuan == $kota[$a]->id) {
                    $cari_kontrak[$i]->nama_tujuan = $kota[$a]->nama;
                }
            }
        }

        // return $cari_kontrak;
        return view('sales.do_kertas.modal_kontrak',compact('cari_kontrak','kota'));
    }
}
