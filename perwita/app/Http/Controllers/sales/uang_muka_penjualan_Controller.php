<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;


class uang_muka_penjualan_Controller extends Controller
{
    public function table_data () {
        $sql = "	SELECT u.*,c.nama FROM uang_muka_penjualan u
					LEFT JOIN customer c ON c.kode=u.kode_customer  ";
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
                                        <button type="button" id="'.$data[$i]['nomor'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('uang_muka_penjualan')->where('nomor', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
					'nomor' => strtoupper($request['ed_nomor']),
					'tanggal' => strtoupper($request['ed_tanggal']),
					'kode_customer' => strtoupper($request['cb_customer']),
					'kode_cabang' => strtoupper($request['cb_cabang']),
					'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
                    'jenis' => strtoupper($request['cb_jenis']),
                    'status' => 'Released',
                    'status_um' => 'CUSTOMER',
					'sisa_uang_muka' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
					'keterangan' => strtoupper($request['ed_keterangan']),
            	);
        
        if ($crud == 'N') {
            $simpan = DB::table('uang_muka_penjualan')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('uang_muka_penjualan')->where('nomor', $request->ed_nomor_old)->update($data);
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
        $hapus = DB::table('uang_muka_penjualan')->where('nomor' ,'=', $id)->delete();
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
        $customer = DB::select(DB::raw(" SELECT kode,nama FROM customer ORDER BY nama ASC "));
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY nama ASC "));
        return view('sales.uang_muka_penjualan.index',compact('customer','cabang'));
    }
    public function nota_uang_muka(request $request)
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from uang_muka_penjualan
                                        WHERE kode_cabang = '$request->cb_cabang'
                                        AND to_char(tanggal,'MM') = '$bulan'
                                        AND to_char(tanggal,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'UMP' . $request->cb_cabang . $bulan . $tahun . $index;

        return response()->json(['nota'=>$nota]);
    }

}
