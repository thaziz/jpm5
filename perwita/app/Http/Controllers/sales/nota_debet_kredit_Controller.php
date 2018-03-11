<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class nota_debet_kredit_Controller extends Controller
{
    public function table_data () {
        //$cabang = strtoupper($request->input('kode_cabang'));
		$sql = "	SELECT n.*, c.nama, i.netto,i.ppn,i.pph,i.total_tagihan FROM nota_debet_kredit  n
					LEFT JOIN invoice i ON i.nomor=n.nomor_invoice
					LEFT JOIN customer c ON c.kode=i.kode_customer";

					//WHERE kode_cabang = '$cabang' ";

        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['nomor'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['nomor'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('nota_debet_kredit')->where('nomor', $id)->first();
        echo json_encode($data);
    }


    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
         $data = array(
                  'nomor' => strtoupper($request['ed_nomor']),
                  'tanggal' => strtoupper($request['ed_tanggal']),
                  'nomor_invoice' => strtoupper($request['ed_nomor_invoice']),
                  'debet' => strtoupper($request['ed_debet']),
                  'kredit' => strtoupper($request['ed_kredit']),
                  'keterangan' => strtoupper($request['ed_keterangan']),
                  'kode_cabang' => strtoupper($request['cb_cabang']),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('nota_debet_kredit')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('nota_debet_kredit')->where('nomor', $request->ed_nomor_old)->update($data);
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
        $hapus = DB::table('nota_debet_kredit')->where('nomor' ,'=', $id)->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
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
        $cabang = DB::select(DB::raw(" SELECT * FROM cabang"));
        return view('sales.nota_debet_kredit.index', compact('cabang'));
    }

}
