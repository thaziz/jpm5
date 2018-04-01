<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class do_kertas_Controller extends Controller
{
    
    public function index(){
        $sql = "    SELECT d.nomor, d.tanggal, c.nama nama_customer, d.diskon,d.total
                    FROM delivery_order d
                    LEFT JOIN customer c ON c.kode=d.kode_customer
                    WHERE d.jenis='KORAN'
                    ORDER BY d.tanggal DESC LIMIT 1000 ";

        $data =  DB::select($sql);
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

    public function nota_do_kertas(request $request)
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


}
