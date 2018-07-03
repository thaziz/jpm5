<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Response;

class uang_muka_penjualan_Controller extends Controller
{
    public function table_data () {
        $cabang = Auth::user()->kode_cabang;

        if (Auth::user()->punyaAkses('Uang Muka Penjualan','all')) {

            $sql = "	SELECT u.*,c.nama FROM uang_muka_penjualan u
    					LEFT JOIN customer c ON c.kode=u.kode_customer  ";
        }else{

            $sql = "    SELECT u.*,c.nama FROM uang_muka_penjualan u
                        LEFT JOIN customer c ON c.kode=u.kode_customer  
                        where u.kode_cabang = '$cabang'";
        }

        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {


              $div_1  =   '<div class="btn-group">';
              if (Auth::user()->punyaAkses('Uang Muka Penjualan','ubah')) {
                if ($data[$i]['status'] != 'Approved') {
                    $div_2  = '<button type="button" onclick="edit(\''.$data[$i]['nomor'].'\')" id="'.$data[$i]['nomor'].'"  class="btn btn-xs btn-warning">'.
                            '<i class="fa fa-pencil"></i></button>';
                }else{
                    $div_2 = '';
                }
                  
              }else{
                $div_2 = '';
              }
              if (Auth::user()->punyaAkses('Uang Muka Penjualan','hapus')) {

                if ($data[$i]['status'] != 'Approved') {
                    if ($data[$i]['status'] != 'Approved') {
                        $div_3  = '<button type="button" onclick="hapus(\''.$data[$i]['nomor'].'\')" id="'.$data[$i]['nomor'].'" name="'.$data[$i]['nama'].'" class="btn btn-xs btn-danger">'.
                        '<i class="fa fa-trash"></i></button>';
                    }else{
                        $div_3 = '';
                    }
              }else{
                $div_3 = '';
              }
              $div_4   = '</div>';

               $div_1 . $div_2 . $div_3 . $div_4;
                }
            // add new button
              $data[$i]['button'] = $div_1 . $div_2 . $div_3 . $div_4;

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
        // dd($request->all());
        $simpan='';
        $crud = $request->crud;
        $akun = DB::table('d_akun')
                  ->where('id_akun','like','2103%')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->first();
        $data = array(
					'nomor' => strtoupper($request['ed_nomor']),
					'tanggal' => strtoupper($request['ed_tanggal']),
					'kode_customer' => strtoupper($request['cb_customer']),
					'kode_cabang' => strtoupper($request['cb_cabang']),
					'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
                    'jenis' => 'U',
                    'status' => 'Released',
                    'status_um' => 'CUSTOMER',
					'sisa_uang_muka' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
                    'keterangan' => strtoupper($request['ed_keterangan']),
                    'kode_acc' =>$akun->id_akun,
                    'kode_csf' => $akun->id_akun,
					'id_bank' => $request->cb_akun_h,
            	);
        
        if ($crud == 'N'){
            $cari_nota = DB::table('uang_muka_penjualan')
                            ->where('nomor',strtoupper($request->ed_nomor))
                            ->first();
            if ($cari_nota != null) {
                return Response::json(['status'=>0,'pesan'=>'Nomor Nota Sudah Digunakan']);
            }

            $data['create_at'] = Carbon::now();
            $data['update_at'] = Carbon::now();
            $data['create_by'] = Auth::user()->m_name;
            $data['update_by'] = Auth::user()->m_name;
            $simpan = DB::table('uang_muka_penjualan')->insert($data);
        }elseif ($crud == 'E') {
            $data['update_at'] = Carbon::now();
            $data['update_by'] = Auth::user()->m_name;
            $simpan = DB::table('uang_muka_penjualan')->where('nomor', $request->ed_nomor_old)->update($data);
        }

        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            return Response::json(['status'=>0,'pesan'=>'Terjadi Kesalahan']);
        }
        $result['crud']=$crud;
        return Response::json(['status'=>1,'pesan'=>'Data Berhasil Disimpan']);
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $cari = DB::table('uang_muka_penjualan')->where('nomor' ,'=', $id)->first();
        if ($cari->status_um == 'Approved') {
            return response()->json(['status'=>0]);
        }
        $hapus = DB::table('uang_muka_penjualan')->where('nomor' ,'=', $id)->delete();
        $hapus = DB::table('uang_muka_penjualan')->where('nomor' ,'=', $id)->first();
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

        $akun_bank = DB::table('masterbank')
                  ->get();

        return view('sales.uang_muka_penjualan.index',compact('customer','cabang','akun_bank'));
    }
    public function nota_uang_muka(request $request)
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');
        if (!isset($request->cb_cabang)) {
            $cabang = Auth::user()->kode_cabang;
        }else{
            $cabang = $request->cb_cabang;
        }

        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from uang_muka_penjualan
                                        WHERE kode_cabang = '$cabang'
                                        AND to_char(create_at,'MM') = '$bulan'
                                        AND to_char(create_at,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'UMP' . $cabang . $bulan . $tahun . $index;

        return response()->json(['nota'=>$nota]);
    }


    public function edit(request $req)
    {
        $data = DB::table('uang_muka_penjualan')
                  ->where('nomor',$req->id)
                  ->first();
        return Response::json(['data'=>$data]);
    }
}
