<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class kartu_piutang_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('kartu_piutang')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('kartu_piutang')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'keterangan' => strtoupper($request->ed_keterangan),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('kartu_piutang')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('kartu_piutang')->where('kode', $request->ed_kode_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('kartu_piutang')->where('kode' ,'=', $id)->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function index(){
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        return view('laporan_sales.kartu_piutang.index',compact('customer'));
    }

    public function tampil_kartu_piutang(Request $request) {
        $mulai = $request->mulai;
        $sampai = $request->sampai;
        $customer = $request->customer;
        $sql = "    SELECT SUM(jumlah) saldo_awal FROM 
                    (
                        SELECT COALESCE(SUM(total_tagihan),0) as jumlah FROM invoice WHERE kode_customer='$customer' AND tanggal < '$mulai'
                        UNION ALL
                        SELECT COALESCE(SUM(-pd.jumlah),0) as jumlah FROM penerimaan_penjualan_d pd, penerimaan_penjualan p
                        WHERE pd.nomor_penerimaan_penjualan=p.nomor AND p.kode_customer='$customer' and p.tanggal < '$mulai'
                    ) gabungan ";

        $saldo_awal = collect(\DB::select($sql))->first()->saldo_awal;
        $sql = "    SELECT *,
                    SUM(total_tagihan) OVER(PARTITION BY kode_customer
                    ORDER BY kode_customer, tanggal,keterangan
                    rows between unbounded preceding and current row) + $saldo_awal saldo
                    FROM
                    (
                        SELECT i.kode_customer,i.nomor,i.tanggal,i.total_tagihan,i.keterangan,i.total_tagihan tambah,'0' AS kurang,'INV' AS menu from invoice i
                        UNION ALL
                        SELECT p.kode_customer,p.nomor,p.tanggal,-pd.jumlah, pd.keterangan,'0',pd.jumlah,'KW' FROM penerimaan_penjualan_d pd, penerimaan_penjualan p
                        WHERE pd.nomor_penerimaan_penjualan=p.nomor AND p.jenis_pembayaran<>'F'
                    ) gabungan
                    where tanggal between '$mulai' AND '$sampai'  AND kode_customer='$customer' " ;
 
        $list = DB::select(DB::raw($sql));
        $tabel_data = ' <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td style="width:17%">No Bukti</td>
                                <td style="width:12%">Tanggal</th>
                                <td>Keterangan</td>
                                <td style="width:10%">Tambah</td>
                                <td style="width:10%">Kurang</td>
                                <td style="width:10%">Saldo</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan = "5" style="background-color: #ffff99;" >SALDO AWAL</td>
                            <td style="text-align:right; background-color: #ffff99;">'.number_format($saldo_awal, 0, ",", ".").' </td>
                        </tr>';
        foreach ($list as $row) {
            $tabel_data = $tabel_data.' <tr>
                                            <td>'. $row->menu.'  '.$row->nomor.'</td>    
                                            <td>'. $row->tanggal.'</td>
                                            <td>'. $row->keterangan.'</td>
                                            <td style="text-align:right">'.number_format($row->tambah, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->kurang, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->saldo, 0, ",", ".").' </td>
                                        </tr>';
        };        
        $tabel_data = $tabel_data.'</tbody> </table>';                    
        $result['html']=$tabel_data;
        // $result['invoice']=DB::table('invoice')->where('nomor', $nomor)->first();
        // $result['penerimaan_penjualan_d']=DB::table('penerimaan_penjualan_d')->where('id', $request->id)->first();
        echo json_encode($result);
    }

}
