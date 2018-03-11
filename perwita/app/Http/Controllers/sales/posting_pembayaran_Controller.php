<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class posting_pembayaran_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "   SELECT * FROM posting_pembayaran_d WHERE nomor_posting_pembayaran='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_penerimaan_penjualan'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('posting_pembayaran')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('posting_pembayaran_d')->where('id', $id)->first();
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
                'jenis_pembayaran' => strtoupper($request->ed_jenis_pembayaran),
                'keterangan' => strtoupper($request->ed_keterangan),
                'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
            );

        if ($crud == 'N' and $nomor_old =='') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->ed_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM posting_pembayaran WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='PST'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='PST'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number
            $simpan = DB::table('posting_pembayaran')->insert($data);
        } else {
            $simpan = DB::table('posting_pembayaran')->where('nomor', $nomor_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['nomor']=$data['nomor'];
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data($nomor_posting_pembayaran=null){
        DB::beginTransaction();
		$list = DB::table('posting_pembayaran_d')->get();
        foreach ($list as $row) {
        	DB::select(" UPDATE penerimaan_penjualan SET posting=FALSE WHERE nomor='$row->nomor_penerimaan_penjualan' ");
        }
        DB::table('posting_pembayaran_d')->where('nomor_posting_pembayaran' ,'=', $nomor_posting_pembayaran)->delete();
        DB::table('posting_pembayaran')->where('nomor' ,'=', $nomor_posting_pembayaran)->delete();
        DB::commit();
        return redirect('sales/posting_pembayaran');
    }

    public function save_data_detail (Request $request) {
        $simpan='';
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_penerimaan_penjualan);
        try {
            DB::beginTransaction();
            
            for ($i=0; $i < $hitung; $i++) {
                $nomor_penerimaan_penjualan = strtoupper($request->nomor_penerimaan_penjualan[$i]);
                $jumlah = filter_var($request->jumlah[$i], FILTER_SANITIZE_NUMBER_INT);
                if ($jumlah != 0 || $jumlah == '') {
                    $data = array(
                        'nomor_posting_pembayaran' => $nomor,
                        'nomor_penerimaan_penjualan' => $nomor_penerimaan_penjualan,
                        'jumlah' => $jumlah,
                    );
                    DB::table('posting_pembayaran_d')->insert($data);
                    DB::select(" UPDATE penerimaan_penjualan SET posting=TRUE WHERE nomor='$nomor_penerimaan_penjualan' ");
                }
                
            } 
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM posting_pembayaran_d 
                                                WHERE nomor_posting_pembayaran='$nomor' "))->first();
            $data_h = array(
                        'jumlah' => $jml_detail->ttl_jumlah,
            );
        
            $simpan = DB::table('posting_pembayaran')->where('nomor', $nomor)->update($data_h);
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
            $result['jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");    
        }
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor=$request->nomor;
        $nomor_penerimaan_penjualan = $request->nomor_penerimaan_penjualan;
        try {
            DB::beginTransaction();
            DB::select(" UPDATE penerimaan_penjualan SET posting=FALSE WHERE nomor='$nomor_penerimaan_penjualan' ");
            DB::table('posting_pembayaran_d')->where('id' ,'=', $id)->delete();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM posting_pembayaran_d 
                                                WHERE nomor_posting_pembayaran='$nomor' "))->first();
            $data_h = array(
                    'jumlah' => $jml_detail->ttl_jumlah,
            );
            DB::table('posting_pembayaran')->where('nomor', $nomor)->update($data_h);
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
            $result['jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
        }
        
        echo json_encode($result);
    }

    public function index(){
        $sql = " select * from posting_pembayaran  ";
        $data =  DB::select($sql);
        return view('sales.posting_pembayaran.index',compact('data'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $kas_bank = DB::select(" SELECT kode,nama FROM akun WHERE jenis='KAS' OR jenis='BANK' ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('posting_pembayaran')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM posting_pembayaran_d WHERE nomor_posting_pembayaran='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.posting_pembayaran.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','kas_bank' ));
    }

    public function tampil_penerimaan_penjualan(Request $request) {
        $jenis_pembayaran = $request->jenis_pembayaran;
        $kode_cabang = $request->kode_cabang;
        $sql = "    SELECT nomor,tanggal,jumlah FROM penerimaan_penjualan
                    where posting=FALSE  AND jenis_pembayaran='$jenis_pembayaran' AND kode_cabang='$kode_cabang' ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <input type="checkbox" id="'.$data[$i]['nomor'].'" class="btnpilih" tabindex="-1" > 
                                    <input type="hidden"  id="ed_jumlah_'.$data[$i]['nomor'].'" value="'.$data[$i]['jumlah'].'"> ';         
            // 
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);

    }

}
