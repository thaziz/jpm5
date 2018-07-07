<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\carbon;
use Yajra\Datatables\Datatables;
use Auth;
use Mail;

class tarif_VendorController extends Controller
{
    public function table_data () {

        $cabang = Auth::user()->kode_cabang;

        if (Auth::user()->punyaAkses('Tarif Penerus Vendor','all')) {
            $list = DB::table('tarif_vendor')
                            ->select('tarif_vendor.*','cabang.nama as cabang','vendor.*')
                            ->leftjoin('cabang','cabang.kode','=','tarif_vendor.cabang_vendor')
                            ->leftjoin('kota as k1','k1.id','=','tarif_vendor.id_kota_asal_vendor')
                            ->leftjoin('kota as k2','k2.id','=','tarif_vendor.id_kota_tujuan_vendor')
                            ->leftjoin('vendor','vendor.kode','=','tarif_vendor.vendor_id')
                            ->get();
        }else{
            $list = DB::table('tarif_vendor')->select('tarif_vendor.*','cabang.*','vendor.*')
                            ->select('tarif_vendor.*','k1.nama as asal','k2.nama as tujuan','cabang.nama as nama_cab')
                            ->leftjoin('cabang','cabang.kode','=','tarif_vendor.cabang_vendor')
                            ->leftjoin('kota as k1','k1.id','=','tarif_vendor.id_kota_asal_vendor')
                            ->leftjoin('kota as k2','k2.id','=','tarif_vendor.id_kota_tujuan_vendor')
                            ->leftjoin('vendor','vendor.kode','=','tarif_vendor.vendor_id')
                            ->where('tarif_vendor.cabang_vendor',$cabang)
                            ->get();
        }


        $data = collect($list);
        // echo json_encode($datax);
        return Datatables::of($data)
        ->addColumn('button', function ($data) {
                           $c =  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-sm" title="edit" id="'.$data->id_tarif_sama.'">'.
                                   '<label class="fa fa-pencil"></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-sm" title="hapus" id="'.$data->id_tarif_sama.'">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';




                        $data1 = DB::table("tarif_vendor")
                              ->where('id_kota_asal_vendor',$data->id_kota_asal_vendor)
                              ->where('id_kota_tujuan_vendor',$data->id_kota_tujuan_vendor)
                              ->where('cabang_vendor',$data->cabang_vendor)
                              ->where('vendor_id',$data->vendor_id)
                              ->get();
                        for ($i=0; $i < count($data1); $i++) { 
                            $a[$i]= '<input type="hidden" class="waktu_'.$data1[$i]->jenis.'" value="'.$data1[$i]->waktu_vendor.'">';
                        } 

                        for ($i=0; $i < count($data1); $i++) { 
                            $b[$i] = '<input type="hidden" class="tarif_'.$data1[$i]->jenis.'" value="'.$data1[$i]->waktu_vendor.'">';
                        } 
                        $a = implode('', $a);
                        $b = implode('', $b);
                        return $c.$a .$b;
                })

        ->make(true);

    }

    public function cabang_vendor(Request $request)
    {

    }
    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('tarif_vendor')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);   
        $simpan='';
        $crud = $request->crud;
        if ($request->cb_keterangan == null ) {
            $request->cb_keterangan = ' - ';
        }
        $waktu = [$request->waktu_regular,$request->waktu_express];
        $tarif = [$request->tarifkertas_reguler,$request->tarifkertas_express];
        // return $waktu;
        
        $id_sama = DB::table('tarif_vendor')->max('id_tarif_sama');
                    if ($id_sama == null) {
                        $id_sama = 1 ;
                    }else{
                        $id_sama +=1 ;
                    }   
        $jenis = ['REGULER','EXPRESS'];
        // return Carbon::now();
        if ($crud == 'N') {
            // return $waktu;
            for ($i=0; $i <count($waktu) ; $i++) { 
                $id = DB::table('tarif_vendor')->max('id_tarif_vendor');
                    if ($id == null) {
                        $id = 1 ;
                    }else{
                        $id +=1 ;
                    }

                $data[$i] = array(
                    'id_tarif_vendor' => $id,
                    'id_tarif_sama' => $id_sama,
                    'id_kota_asal_vendor' => $request->cb_kota_asal,
                    'id_kota_tujuan_vendor' => $request->cb_kota_tujuan,
                    'vendor_id' => $request->cb_vendor,
                    'cabang_vendor' => $request->cb_cabang,
                    'acc_vendor' => $request->cb_acc_penjualan,
                    'csf_vendor' => $request->cb_csf_penjualan,
                    'waktu_vendor' => $waktu[$i],
                    'tarif_vendor' => $tarif[$i],
                    'created_at' => Carbon::now(),
                    'jenis' => $jenis[$i],
                    'created_by' => auth::user()->m_name,
                );
                
                $simpan = DB::table('tarif_vendor')->insert($data[$i]);

            // return $data;
            }
        }elseif ($crud == 'E') {
            for ($i=0; $i <count($waktu) ; $i++) { 
                $id = DB::table('tarif_vendor')->max('id_tarif_vendor');
                    if ($id == null) {
                        $id = 1 ;
                    }else{
                        $id +=1 ;
                    }

                $data[$i] = array(
                    'id_tarif_vendor' => $id,
                    'id_tarif_sama' => $id_sama,
                    'id_kota_asal_vendor' => $request->cb_kota_asal,
                    'id_kota_tujuan_vendor' => $request->cb_kota_tujuan,
                    'vendor_id' => $request->cb_vendor,
                    'cabang_vendor' => $request->cb_cabang,
                    'acc_vendor' => $request->cb_acc_penjualan,
                    'csf_vendor' => $request->cb_csf_penjualan,
                    'waktu_vendor' => $waktu[$i],
                    'tarif_vendor' => $tarif[$i],
                    'created_at' => Carbon::now(),
                    'jenis' => $jenis[$i],
                    'created_by' => auth::user()->m_name,
                );
                
                $simpan = DB::table('tarif_vendor')->where('id', $request->ed_id)->update($data[$i]);

            // return $data;
            }
        }
        if($simpan == TRUE){
            

            $data = ['kontrak'=>url('sales/tarif_vendor'),'status'=>'Tarif Vendor'];

            Mail::send('email.email', $data, function ($mail)
                {
                  // Email dikirimkan ke address "momo@deviluke.com" 
                  // dengan nama penerima "Momo Velia Deviluke"
                  $mail->from('jpm@gmail.com', 'SYSTEM JPM');
                  $mail->to('denyprasetyo41@gmail.com', 'Admin');
             
                  // Copy carbon dikirimkan ke address "haruna@sairenji" 
                  // dengan nama penerima "Haruna Sairenji"
                  $mail->cc('denyprasetyo41@gmail.com', 'ADMIN JPM');
             
                  $mail->subject('KONTRAK VERIFIKASI');
            });
            return response()->json(['status'=>1]);
        }else{
            
            return response()->json(['status'=>0]);
        }
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('tarif_vendor')->where('id' ,'=', $id)->delete();
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
        // return'a';
        $kota = DB::select(DB::raw(" SELECT id,kode_kota,nama FROM kota ORDER BY nama ASC "));
        $zona = DB::select(DB::raw(" SELECT * FROM zona ORDER BY nama ASC "));
        $prov = DB::select(DB::raw(" SELECT * FROM provinsi ORDER BY nama ASC "));
        $akun = DB::select(DB::raw(" SELECT * FROM d_akun "));
        $vendor = DB::table('vendor')->get();
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY kode ASC "));
        return view('tarif.tarif_vendor.index',compact('kota','zona','cabang','prov','akun','vendor'));
    }

}
