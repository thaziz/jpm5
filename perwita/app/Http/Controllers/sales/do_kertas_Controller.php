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
        if (Auth::user()->m_level == 'ADMINISTRATOR' || Auth::user()->m_level == 'SUPERVISOR') {
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
        $head = collect(\DB::select("   SELECT d.nomor,d.tanggal,d.kode_customer,c.nama,c.alamat,c.telpon FROM delivery_order d
                                        LEFT JOIN customer c ON c.kode=d.kode_customer
                                        WHERE nomor='$nomor' "))->first();
        $detail =DB::select("   SELECT d.*,i.nama FROM delivery_orderd d,item i
                                WHERE i.kode=d.dd_kode_item AND d.dd_nomor='$nomor'  ORDER BY dd_id");
    
        return view('sales.do_kertas.print',compact('head','detail'));
    }

    public function nomor_do_kertas(request $request)
    {
        $bulan  = Carbon::now()->format('m');
        $tahun  = Carbon::now()->format('y');
        $cabang = $request->cabang;
        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from delivery_order
                                        WHERE kode_cabang = '$cabang'
                                        AND to_char(tanggal,'MM') = '$bulan'
                                        AND jenis = 'KORAN'
                                        AND to_char(tanggal,'YY') = '$tahun'");

        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);

        $nota = 'KTS' . $cabang . $bulan . $tahun . $index;
        return response()->json(['nota'=>$nota]);
    }

    public function cari_customer_kertas(request $request)
    {
        $customer = DB::table('customer')
                      ->where('kode',$request->customer)
                      ->first();


        return json_encode($customer);
        
    }

    public function cari_item(request $request)
    {
        $data = DB::table('item')
                  ->where('kode',$request->item)
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
                                'nomor'             => $request->ed_nomor,
                                'tanggal'           => $tgl,
                                'kode_customer'     => $request->customer,
                                'pendapatan'        => 'KORAN',
                                'kode_cabang'       => $request->cb_cabang,
                                'diskon'            => $request->ed_diskon_m,
                                'total_net'         => $request->ed_total_m,
                                'jenis'             => 'KORAN',
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
                    $save_detail = DB::table('delivery_orderd')
                                 ->insert([
                                    'dd_id' => $id,
                                    'dd_nomor' => $request->ed_nomor,
                                    'dd_nomor_dt' => $i+1,
                                    'dd_kode_item' => strtoupper($request->d_kode_item[$i]),
                                    'dd_kode_satuan' => strtoupper($request->d_satuan[$i]),
                                    'dd_jumlah' => $request->d_jumlah[$i],
                                    'dd_harga' => $request->d_harga[$i],
                                    'dd_diskon' => $request->d_diskon[$i],
                                    'dd_total' => $request->d_netto[$i],
                                    'dd_id_kota_asal' => $request->d_asal[$i],
                                    'dd_id_kota_tujuan' => $request->d_tujuan[$i],
                                    'dd_keterangan' => strtoupper($request->d_keterangan[$i]),
                                    'dd_acc_penjualan' => strtoupper($request->d_acc[$i]),

                                 ]);
                }
                return response()->json(['status'=>1]);
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

                $nota = 'KTS' . $cabang . $bulan . $tahun . $index;

                $save_head = DB::table('delivery_order')
                               ->insert([
                                'nomor'             => $nota,
                                'tanggal'           => $tgl,
                                'kode_customer'     => $request->customer,
                                'pendapatan'        => 'KORAN',
                                'diskon'            => $request->ed_diskon_m,
                                'kode_cabang'       => $request->cb_cabang,
                                'total_net'         => $request->ed_total_m,
                                'jenis'             => 'KORAN',
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
                    $save_detail = DB::table('delivery_orderd')
                                 ->insert([
                                    'dd_id' => $id,
                                    'dd_nomor' => $nota,
                                    'dd_nomor_dt' => $i+1,
                                    'dd_kode_item' => strtoupper($request->d_kode_item[$i]),
                                    'dd_kode_satuan' => strtoupper($request->d_satuan[$i]),
                                    'dd_jumlah' => $request->d_jumlah[$i],
                                    'dd_harga' => $request->d_harga[$i],
                                    'dd_diskon' => $request->d_diskon[$i],
                                    'dd_total' => $request->d_netto[$i],
                                    'dd_id_kota_asal' => $request->d_asal[$i],
                                    'dd_id_kota_tujuan' => $request->d_tujuan[$i],
                                    'dd_keterangan' => strtoupper($request->d_keterangan[$i]),
                                    'dd_acc_penjualan' => strtoupper($request->d_acc[$i]),

                                 ]);
                }

                    return response()->json(['nota'=>$nota,'status'=>2]);

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

        $data_dt = DB::table('delivery_order')
                  ->join('delivery_orderd','dd_nomor','=','nomor')
                  ->where('nomor',$id)
                  ->get();

        return view('sales.do_kertas.edit_kertas',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','item','id','data_dt'));
    }
    public function update_do_kertas(request $request)
    {
        $this->hapus_do_kertas($request);
        return $this->save_do_kertas($request);
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

        $data_dt = DB::table('delivery_order')
                  ->join('delivery_orderd','dd_nomor','=','nomor')
                  ->where('nomor',$id)
                  ->get();

        return view('sales.do_kertas.detail_kertas',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','item','id','data_dt'));
    }
}
