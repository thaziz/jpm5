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
            $list = DB::table('tarif_vendor')->select('tarif_vendor.*','cabang.*','vendor.*')
                            ->select('tarif_vendor.*','k1.nama as asal','k2.nama as tujuan','cabang.nama as nama_cab')
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


                        $asal   = '<input type="hidden" class="asal" value="'.$data->id_kota_asal_vendor.'">';
                        $tujuan = '<input type="hidden" class="tujuan" value="'.$data->id_kota_tujuan_vendor.'">';
                        $cabang = '<input type="hidden" class="cabang" value="'.$data->cabang_vendor.'">';
                        $vendor = '<input type="hidden" class="vendor_id" value="'.$data->vendor_id.'">';

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
                        return $c.$a .$b. $asal.$tujuan.$cabang.$vendor;
                })
                        ->addColumn('active', function ($data) {
                          if (Auth::user()->punyaAkses('Verifikasi','aktif')) {
                            if($data->status == 'ya'){
                              return '<input checked type="checkbox" onchange="check(this)" class="form-control check">';
                            }else{
                              return '<input type="checkbox" onchange="check(this)" class="form-control check">';
                            }
                          }else{
                              return '-';
                          }
                           
                        })
        ->make(true);

    }

    public function cabang_vendor(Request $request)
    {

    }
    public function get_data (Request $request) {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $vendor = $request->vendor_id;
        $cabang = $request->cabang;
        
        $data = DB::table('tarif_vendor')
                        ->where('id_kota_asal_vendor','=',$asal)
                        ->where('id_kota_tujuan_vendor','=',$tujuan)
                        ->where('vendor_id','=',$vendor)
                        ->where('cabang_vendor','=',$cabang)
                        ->get();

        return response()->json($data);
    }

    public function save_data (Request $request) {
        // dd($request);   
        $simpan='';
        $crud = $request->crud;
        if ($request->cb_keterangan == null ) {
            $request->cb_keterangan = ' - ';
        }
        $id_old                   = [   $request->id_tarif_vendor_reg,
                                        $request->id_tarif_vendor_reg_1,
                                        $request->id_tarif_vendor_reg_2,
                                        $request->id_tarif_vendor_ex,
                                        $request->id_tarif_vendor_ex_1,
                                        $request->id_tarif_vendor_ex_2,];

        $waktu                    = [   $request->waktu_regular,
                                        $request->waktu_regular,
                                        $request->waktu_regular,
                                        $request->waktu_express,
                                        $request->waktu_express,
                                        $request->waktu_express,];

        $tarif                    = [   $request->tarifkertas_reguler,
                                        $request->tarif10kg_reguler,
                                        $request->tarifsel_reguler,
                                        $request->tarifkertas_express,
                                        $request->tarif10kg_express,
                                        $request->tarifsel_express,];

        
        $berat_minimum            = [   $request->berat_minimum_reg,
                                        $request->berat_minimum_reg,
                                        $request->berat_minimum_reg,
                                        $request->berat_minimum_ex,
                                        $request->berat_minimum_ex,
                                        $request->berat_minimum_ex,];
        
        $keterangan               = [   'Tarif Kertas / Kg',
                                        'Tarif <= 10 Kg',
                                        'Tarif Kg selanjutnya <= 10 Kg',
                                        'Tarif Kertas / Kg',
                                        'Tarif <= 10 Kg',
                                        'Tarif Kg selanjutnya <= 10 Kg',];

        $jenis                    = [   'REGULER',
                                        'REGULER',
                                        'REGULER',
                                        'EXPRESS',
                                        'EXPRESS',
                                        'EXPRESS'];
        // return $waktu;
        
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $vendor = $request->vendor_id;
        $cabang = $request->cabang;

        $id_sama = DB::table('tarif_vendor')->max('id_tarif_sama');
                    if ($id_sama == null) {
                        $id_sama = 1 ;
                    }else{
                        $id_sama +=1 ;
                    }   
        // return Carbon::now();
        if ($crud == 'N') {
            // return $waktu;
            for ($i=0; $i <count($tarif) ; $i++) { 
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
                    'berat_minimum' => $berat_minimum[$i],
                    'tarif_dokumen' => $request->tarif_dokumen,
                    'created_at' => Carbon::now(),
                    'jenis' => $jenis[$i],
                    'keterangan' => $keterangan[$i],
                    'created_by' => auth::user()->m_name,
                );
                
                $simpan = DB::table('tarif_vendor')->insert($data[$i]);

            // return $data;
            }
        }elseif ($crud == 'E') {

            for ($i=0; $i <count($tarif) ; $i++) { 
                $id = DB::table('tarif_vendor')->max('id_tarif_vendor');
                    if ($id == null) {
                        $id = 1 ;
                    }else{
                        $id +=1 ;
                    }

                $data[$i] = array(
                    'id_tarif_vendor' => $id_old[$i],
                    'id_tarif_sama' => $id_sama,
                    'id_kota_asal_vendor' => $request->cb_kota_asal,
                    'id_kota_tujuan_vendor' => $request->cb_kota_tujuan,
                    'vendor_id' => $request->cb_vendor,
                    'cabang_vendor' => $request->cb_cabang,
                    'acc_vendor' => $request->cb_acc_penjualan,
                    'csf_vendor' => $request->cb_csf_penjualan,
                    'waktu_vendor' => $waktu[$i],
                    'tarif_vendor' => $tarif[$i],
                    'berat_minimum' => $berat_minimum[$i],
                    'tarif_dokumen' => $request->tarif_dokumen,
                    'updated_at' => Carbon::now(),
                    'jenis' => $jenis[$i],
                    'keterangan' => $keterangan[$i],
                    'updated_by' => auth::user()->m_name,
                );
                
                $simpan = DB::table('tarif_vendor')->where('id_tarif_vendor','=',$id_old[$i])->update($data[$i]);

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
                  $mail->to('dewa17a@gmail.com', 'Admin');
             
                  // Copy carbon dikirimkan ke address "haruna@sairenji" 
                  // dengan nama penerima "Haruna Sairenji"
                  $mail->cc('dewa17a@gmail.com', 'ADMIN JPM');
                  $mail->subject('KONTRAK VERIFIKASI');
            });
            return response()->json(['status'=>1,'crud'=>'N']);
        }else{
            return response()->json(['status'=>0,'crud'=>'N']);
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

    public function check_kontrak_vendor(request $request)
    {
        // dd($request->all());
      // return dd($request->all());

        if ($request->check == 'true') {
         // return $request->check;

            $data_dt = DB::table('tarif_vendor')
                ->where('id_kota_asal_vendor',$request->asal)
                ->where('id_kota_tujuan_vendor',$request->tujuan)
                ->where('cabang_vendor',$request->cabang)
                ->where('vendor_id',$request->vendor_id)
                ->where('jenis',$request->jenis)
                ->update([
                  'status' => 'ya' 
                ]);

             
             return json_encode('success 1');

        }else{

           $data_dt = DB::table('tarif_vendor')
                ->where('id_kota_asal_vendor',$request->asal)
                ->where('id_kota_tujuan_vendor',$request->tujuan)
                ->where('cabang_vendor',$request->cabang)
                ->where('vendor_id',$request->vendor_id)
                ->where('jenis',$request->jenis)
                ->update([
                  'status' => 'tidak' 
                ]);
             return json_encode('success 2');
        }
    }

}
