<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class penerimaan_penjualan_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "   SELECT * FROM penerimaan_penjualan_d WHERE nomor_penerimaan_penjualan='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                        <button type="button" id="'.$data[$i]['nomor_invoice'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Info" class="btn btn-success btn-xs btninfo" tabindex="-1"><i class="glyphicon glyphicon-info-sign"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('penerimaan_penjualan')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('penerimaan_penjualan_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $nomor_old = $request->ed_nomor_old;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'tanggal' => strtoupper($request->ed_tanggal),
                'kode_cabang' => strtoupper($request->ed_cabang),
                'kode_customer' => strtoupper($request->ed_customer),
                'jenis_pembayaran' => strtoupper($request->cb_jenis_pembayaran),
                'keterangan' => strtoupper($request->ed_keterangan),
                'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
            );

        if ($crud == 'N' and $nomor_old =='') {
            $simpan = DB::table('penerimaan_penjualan')->insert($data);
        } else {
            $simpan = DB::table('penerimaan_penjualan')->where('nomor', $nomor_old)->update($data);
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

    public function hapus_data($nomor_penerimaan_penjualan=null){
        DB::beginTransaction();
        DB::table('penerimaan_penjualan_d')->where('kode_penerimaan_penjualan' ,'=', $nomor_penerimaan_penjualan)->delete();
        DB::table('penerimaan_penjualan')->where('kode' ,'=', $nomor_penerimaan_penjualan)->delete();
        DB::commit();
        return redirect('master_sales/penerimaan_penjualan');
    }

    public function save_data_detail (Request $request) {
        $simpan='';
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_invoice);
        $type_kiriman = strtoupper($request->type_kiriman); 
        try {
            DB::beginTransaction();
            
            for ($i=0; $i < $hitung; $i++) {
                $nomor_invoice = strtoupper($request->nomor_invoice[$i]);
                $jumlah = filter_var($request->jumlah[$i], FILTER_SANITIZE_NUMBER_INT);
                if ($jumlah != 0 || $jumlah == '') {
                    $data = array(
                        'nomor_penerimaan_penjualan' => $nomor,
                        'nomor_invoice' => $nomor_invoice,
                        'jumlah' => $jumlah,
                    );
                    DB::table('penerimaan_penjualan_d')->insert($data);
                    DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial + '$jumlah' WHERE nomor='$nomor_invoice' ");
                }
                
            } 
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM penerimaan_penjualan_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
            $data_h = array(
                        'terpakai' => $jml_detail->ttl_jumlah,
            );
        
            $simpan = DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['terpakai']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");    
        }
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor=$request->nomor;
        $type_kiriman = strtoupper($request->type_kiriman);
        $data_invoice = collect(\DB::select(" SELECT * FROM penerimaan_penjualan_d  WHERE id='$id' "))->first();
        $jumlah = $data_invoice->jumlah;
        $nomor_invoice = $data_invoice->nomor_invoice;
        try {
            DB::beginTransaction();
            DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial - '$jumlah' WHERE nomor='$nomor_invoice' ");
            DB::table('penerimaan_penjualan_d')->where('id' ,'=', $id)->delete();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM penerimaan_penjualan_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
            $data_h = array(
                    'terpakai' => $jml_detail->ttl_jumlah,
            );
            DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
            
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['terpakai']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
        }
        
        echo json_encode($result);
    }

    public function index(){
        $sql = "    SELECT pp.*,c.nama customer FROM penerimaan_penjualan pp
                    LEFT JOIN customer c ON c.kode=pp.kode_customer ";
        $data =  DB::select($sql);
        return view('sales.penerimaan_penjualan.index',compact('data'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $kas_bank = DB::select(" SELECT kode,nama FROM akun WHERE jenis='KAS' OR jenis='BANK' ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('penerimaan_penjualan')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM penerimaan_penjualan_d WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.penerimaan_penjualan.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','kas_bank' ));
    }

    public function tampil_invoice(Request $request) {
        $customer = $request->kode_customer;
        $kode_cabang = $request->kode_cabang;
        $sql = "    SELECT nomor, tanggal, total_tagihan - jml_bayar_memorial sisa_tagihan FROM invoice where jml_bayar_memorial < total_tagihan 
                    AND kode_customer='$customer' ";

        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <input type="checkbox"  id="'.$data[$i]['nomor'].'" class="btnpilih" tabindex="-1" > ';         
            // add new text
            $data[$i]['jml_bayar'] = '  <input type="text"  id="ed_'.$data[$i]['nomor'].'" name="ed_jumlah_bayar[]" class="form-control angka" style="text-align:right">
                                        <input type="hidden"  id="ed_bayar'.$data[$i]['nomor'].'" value="'.$data[$i]['sisa_tagihan'].'">
                                        <input type="hidden"  name="ed_nomor_invoice[]" value="'.$data[$i]['nomor'].'" >
                                        ';
            // add button info
            $data[$i]['btn_info'] = ' <button type="button" id="'.$data[$i]['nomor'].'" name="'.$data[$i]['nomor'].'" data-toggle="tooltip" title="Info" class="btn btn-success btn-xs btninfo" tabindex="-1"><i class="glyphicon glyphicon-info-sign"></i></button> '
                                ;
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);

    }

    public function tampil_riwayat_invoice(Request $request) {
        $nomor = $request->nomor_invoice;
        $sql = "    select i.nomor nomor_invoice,i.total_tagihan,pd.nomor_penerimaan_penjualan,pd.jumlah as jml_bayar, p.tanggal tgl_bayar,
                    i.total_tagihan - sum(pd.jumlah) OVER (ORDER BY p.tanggal,pd.id) sisa_tagihan
                    from invoice i,penerimaan_penjualan_d pd,penerimaan_penjualan p
                    where i.nomor='$nomor' and pd.nomor_invoice=i.nomor and p.nomor=pd.nomor_penerimaan_penjualan ";

        $list = DB::select(DB::raw($sql));
        $total_tagihan = collect(\DB::select($sql))->first()->total_tagihan;
        echo '  <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
                    <thead>
                        
                        <tr>
                            <td>Nomor Penerimaan</td>
                            <td>Tanggal</th>
                            <td style="width:20%">Jml Bayar</td>
                            <td style="width:20%">Sisa</td>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan = "3" style="background-color: #ffff99;" >Jumlah Tagihan Nomor Invoice : '.$nomor.'</td>
                        <td style="text-align:right; background-color: #ffff99;">'.number_format($total_tagihan, 0, ",", ".").' </td>
                    </tr>';
        foreach ($list as $row) {
            echo '
            <tr>
                <td>'. $row->nomor_penerimaan_penjualan.'</td>    
                <td>'. $row->tgl_bayar.'</td>
                <td style="text-align:right">'.number_format($row->jml_bayar, 0, ",", ".").' </td>
                <td style="text-align:right">'.number_format($row->sisa_tagihan, 0, ",", ".").' </td>
            </tr>';
        }        
        echo '</tbody>
        </table>';    

    }

}
