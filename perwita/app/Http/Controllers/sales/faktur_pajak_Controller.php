<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class faktur_pajak_Controller extends Controller
{

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('surat_jalan_trayek')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = 'E';//$request->crud;
        $data = array(
                'no_faktur_pajak' => strtoupper($request->no_faktur_pajak),
            );

        if ($crud == 'N') {
            $simpan = DB::table('invoice')->insert($data);
        }elseif ($crud == 'E' ) {
            $simpan = DB::table('invoice')->where('nomor', $request->nomor_invoice)->update($data);
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
	
    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('surat_jalan_trayek_d')->where('id', $id)->first();
        echo json_encode($data);
    }

	public function tampil_auto_complete(Request $request){
		$cabang = strtoupper($request['cabang']);
		$nomor = strtoupper($request['term']);
		$results = array();
        $queries = DB::select("	SELECT nomor,tanggal,c.nama,i.pendapatan,i.no_faktur_pajak,i.total_tagihan FROM  invoice i
								LEFT JOIN customer c ON c.kode=i.kode_customer
								WHERE i.kode_cabang='$cabang' AND nomor like '%".$nomor."%' LIMIT 100 ");
        if ($queries == null){
            $results[] = [ 'nomor' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($queries as $query)
            {
                $results[] = [ 	'nomor' => $query->nomor,
								'label' => $query->nomor,
								'tanggal' => $query->tanggal,
								'nama' => $query->nama,
								'pendapatan' => $query->pendapatan,
								'no_faktur_pajak' => $query->no_faktur_pajak,
								'total_tagihan' => number_format($query->total_tagihan, 0, ",", "."),
							];

            }

        }
		return response()->json($results);
	}

	public function index(){
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
		return view('sales.faktur_pajak.form', compact('cabang'));
	}

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        if ($nomor != null) {
            $data = DB::table('surat_jalan_trayek')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM surat_jalan_trayek_d WHERE nomor_surat_jalan_trayek ='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.faktur_pajak.form',compact('kota','data','cabang','jml_detail','rute','kendaraan' ));
    }

}
