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
                            ->select('tarif_vendor.*','k1.nama as asal','k2.nama as tujuan','cabang.nama as nama_cab')
                            ->leftjoin('cabang','cabang.kode','=','tarif_vendor.cabang_vendor')
                            ->leftjoin('kota as k1','k1.id','=','tarif_vendor.id_kota_asal_vendor')
                            ->leftjoin('kota as k2','k2.id','=','tarif_vendor.id_kota_tujuan_vendor')
                            ->leftjoin('vendor','vendor.kode','=','tarif_vendor.vendor_id')
                            ->get();
        }else{
            $list = DB::table('tarif_vendor')
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
                                $a = '';
                                $b = '';
                                if (Auth::user()->punyaAkses('Tarif Penerus Vendor','ubah')) {
                                   $a =  '<button type="button" onclick="edit(\''.$data->id_tarif_vendor.'\')" class="btn btn-info btn-sm" title="edit"><label class="fa fa-pencil"></label></button>';
                                }

                                if (Auth::user()->punyaAkses('Tarif Penerus Vendor','hapus')) {
                                   $b =  '<button type="button" onclick="hapus(\''.$data->id_tarif_vendor.'\')" class="btn btn-danger btn-sm" title="hapus"><label class="fa fa-trash"></label></button>';
                                }

                                   
                    return '<div class="btn-group">'.$a.$b.'</div>';

                })->addColumn('active', function ($data) {
                  if (Auth::user()->punyaAkses('Verifikasi','aktif')) {
                    if($data->status == 'ya'){
                      return '<input checked type="checkbox" onchange="check(\''.$data->id_tarif_vendor.'\',\''.$data->status.'\')" class="form-control check">';
                    }else{
                      return '<input type="checkbox" onchange="check(\''.$data->id_tarif_vendor.'\',\''.$data->status.'\')" class="form-control check">';
                    }
                  }else{
                      return '-';
                  }
                   
                })->addColumn('vendor', function ($data) {
                    $vendor = DB::table('vendor')
                              ->get();
                    foreach ($vendor as $key => $value) {
                        if ($data->vendor_id == $value->kode) {
                            return $value->nama;
                        }
                    }
                   
                })->make(true);

    }

    public function cabang_vendor(Request $request)
    {

    }
    public function get_data (Request $req) {
        
        $data = DB::table('tarif_vendor')
                        ->where('id_tarif_vendor','=',$req->id)
                        ->first();

        return response()->json(['data'=>$data]);
    }

    public function save_data (Request $req) {
        DB::beginTransaction();
        try {
            if ($req->ed_kode_old == '') {
                $id = DB::table("tarif_vendor")
                        ->max('id_tarif_vendor')+1;
                $data = array(
                    'id_tarif_vendor' => $id,
                    'id_tarif_sama' => 0,
                    'id_kota_asal_vendor' => $req->cb_kota_asal,
                    'id_kota_tujuan_vendor' => $req->cb_kota_tujuan,
                    'vendor_id' => $req->cb_vendor,
                    'cabang_vendor' => $req->cb_cabang,
                    'acc_vendor' => $req->cb_acc_penjualan,
                    'csf_vendor' => $req->cb_csf_penjualan,
                    'waktu_vendor' => $req->waktu_regular,
                    'tarif_vendor' => $req->tarifkertas_reguler,
                    'tarif_kurang_10' => $req->tarif10kg_reguler,
                    'tarif_setelah_10' => $req->tarifsel_reguler,
                    'berat_minimum' => $req->berat_minimum_reg,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'jenis_angkutan' => $req->jenis_angkutan,
                    'jenis_tarif' => $req->jenis_tarif,
                    'created_by' => auth::user()->m_name,
                    'updated_by' => auth::user()->m_name,
                );
                
                $simpan = DB::table('tarif_vendor')->insert($data);

              
                // if($simpan == TRUE){
                    
                //     $data = ['kontrak'=>url('sales/tarif_vendor'),'status'=>'Tarif Vendor'];

                //     Mail::send('email.email', $data, function ($mail)
                //         {
                //           // Email dikirimkan ke address "momo@deviluke.com" 
                //           // dengan nama penerima "Momo Velia Deviluke"
                //           $mail->from('jpm@gmail.com', 'SYSTEM JPM');

                //           $mail->to('puspitadury1987@gmail.com', 'Admin');
                     
                //           // Copy carbon dikirimkan ke address "haruna@sairenji" 
                //           // dengan nama penerima "Haruna Sairenji"
                //           $mail->cc('puspitadury1987@gmail.com', 'ADMIN JPM');
                          
                //           $mail->subject('KONTRAK VERIFIKASI');
                //     });
                //     DB::commit();
                //     return response()->json(['status'=>1,'crud'=>'N']);
                // }else{
                    DB::commit();
                    return response()->json(['status'=>1,'crud'=>'N']);
                // }
            }else{
                $data = array(
                    'id_tarif_sama' => 0,
                    'id_kota_asal_vendor' => $req->cb_kota_asal,
                    'id_kota_tujuan_vendor' => $req->cb_kota_tujuan,
                    'vendor_id' => $req->cb_vendor,
                    'cabang_vendor' => $req->cb_cabang,
                    'acc_vendor' => $req->cb_acc_penjualan,
                    'csf_vendor' => $req->cb_csf_penjualan,
                    'waktu_vendor' => $req->waktu_regular,
                    'tarif_vendor' => $req->tarifkertas_reguler,
                    'tarif_kurang_10' => $req->tarif10kg_reguler,
                    'tarif_setelah_10' => $req->tarifsel_reguler,
                    'berat_minimum' => $req->berat_minimum_reg,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'jenis_angkutan' => $req->jenis_angkutan,
                    'jenis_tarif' => $req->jenis_tarif,
                    'created_by' => auth::user()->m_name,
                    'updated_by' => auth::user()->m_name,
                );
                
                $simpan = DB::table('tarif_vendor')->where('id_tarif_vendor',$req->ed_kode_old)->update($data);
                DB::commit();
                return response()->json(['status'=>2,'crud'=>'E']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
            
    }



    public function hapus_data (Request $req) {

        $data = DB::table('tarif_vendor')
                        ->where('id_tarif_vendor','=',$req->id)
                        ->delete();

        return response()->json(['status'=>1,'crud'=>'E']);
    }

    public function index(){
        
        $cabang = Auth::user()->kode_cabang;
        $kota = DB::select(DB::raw(" SELECT id,kode_kota,nama FROM kota ORDER BY nama ASC "));
        $zona = DB::select(DB::raw(" SELECT * FROM zona ORDER BY nama ASC "));
        $prov = DB::select(DB::raw(" SELECT * FROM provinsi ORDER BY nama ASC "));
        if (Auth::user()->punyaAkses('Tarif Penerus Vendor','cabang')) {
            $akun = DB::select(DB::raw(" SELECT * FROM d_akun where id_akun like '4%'"));
        }else{
            $akun = DB::select(DB::raw(" SELECT * FROM d_akun where id_akun like '4%' and kode_cabang = '$cabang'"));
        }
        $vendor = DB::table('vendor')->get();
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY kode ASC "));
        return view('tarif.tarif_vendor.index',compact('kota','zona','cabang','prov','akun','vendor'));
    }

    public function check_kontrak_vendor(request $request)
    {
        // dd($request->all());
      // return dd($request->all());

        if ($request->status == 'tidak') {
         // return $request->check;
            $data_dt = DB::table('tarif_vendor')
                ->where('id_tarif_vendor',$request->id)
                ->update([
                  'status' => 'ya' 
                ]);

            return response()->json(['status'=>1,'crud'=>'E']);
        }else{
            $data_dt = DB::table('tarif_vendor')
                ->where('id_tarif_vendor',$request->id)
                ->update([
                  'status' => 'tidak' 
                ]);
            return response()->json(['status'=>2,'crud'=>'E']);
        }
    }

}
