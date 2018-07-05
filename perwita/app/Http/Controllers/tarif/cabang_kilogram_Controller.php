<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use carbon\carbon;
use Yajra\Datatables\Datatables;

class cabang_kilogram_Controller extends Controller
{
    public function table_data () {
        set_time_limit(600);
        ini_set('memory_limit', '1000M');
        $cabang = Auth::user()->kode_cabang;
      if (Auth::user()->punyaAkses('Tarif Cabang Kilogram','all')) {
          $sql = DB::table('tarif_cabang_kilogram')
                 ->get();
        }else{
          $sql = DB::table('tarif_cabang_kilogram')
                ->where('kode_cabang',$cabang)
                ->get();
        }

        $asal = DB::table('kota')
                  ->get();

        $tujuan = DB::table('kota')
                  ->get();

        $provinsi = DB::table('provinsi')
                  ->get();

        $cabang = DB::table('cabang')
                  ->get();


        for ($i=0; $i < count($sql); $i++) { 
          for ($a=0; $a < count($asal); $a++) { 
            if ($sql[$i]->id_kota_asal == $asal[$a]->id) {
              $sql[$i]->asal = $asal[$a]->nama;
            }
          }

          for ($a=0; $a < count($tujuan); $a++) { 
            if ($sql[$i]->id_kota_tujuan == $tujuan[$a]->id) {
              $sql[$i]->tujuan = $asal[$a]->nama;
            }
          }


          for ($a=0; $a < count($provinsi); $a++) { 
            if ($sql[$i]->id_provinsi_cabkilogram == $provinsi[$a]->id) {
              $sql[$i]->provinsi = $provinsi[$a]->nama;
            }
          }

          for ($a=0; $a < count($cabang); $a++) { 
            if ($sql[$i]->kode_cabang == $cabang[$a]->kode) {
              $sql[$i]->cabang = $provinsi[$a]->nama;
            }
          }

          if (!isset($sql[$i]->provinsi)) {
            $sql[$i]->provinsi = '-';
          }
        }


        $data = collect($sql);
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {

                                if ($data->crud == 'E') {
                                  $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','ubah')) {
                                    $div_2  = '<div class="btn-group">
                                    <button type="button" id="'.$data->id_kota_asal.'" data-tujuan="'.$data->id_kota_tujuan.'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }

                                  if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','hapus')) {
                                    $div_3  = '<button type="button" disabled="" id="'.$data->kode_sama_kilo.'" name="'.$data->kode_sama_kilo.'"  data-asal="'.$data->asal.'" data-prov="'.$data->provinsi.'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button><button type="button" id="'.$data->id_kota_asal.'" name="'.$data->id_kota_tujuan.'" data-asal="'.$data->asal.'" data-tujuan="'.$data->tujuan.'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                  }else{
                                    $div_3 = '';
                                  }

                                  $div_4   = '</div>';
                                  return$all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                }else if($data->crud == 'N'){

                                  $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Tarif Cabang Kilogram','ubah')) {
                                    $div_2  = '<button type="button" id="'.$data->id_kota_asal.'" data-tujuan="'.$data->id_kota_tujuan.'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Tarif Cabang Kilogram','hapus')) {
                                    $div_3  = '<button type="button" id="'.$data->kode_sama_kilo.'" name="'.$data->kode_sama_kilo.'"  data-asal="'.$data->asal.'" data-prov="'.$data->provinsi.'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                    <button type="button" id="'.$data->id_kota_asal.'" name="'.$data->id_kota_tujuan.'" data-asal="'.$data->asal.'" data-tujuan="'.$data->tujuan.'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                  }else{
                                    $div_3 = '';
                                  }
                                  $div_4   = '</div>';
                                  return$all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                }
                                   
                        })
                        ->addIndexColumn()
                        ->make(true);
    }

    public function get_data (Request $request) {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
         $sql = "    SELECT t.kode_cabang,k.kode_kota,t.crud,t.id_provinsi_cabkilogram,t.kode_detail_kilo,t.kode_sama_kilo,t.kode,t.acc_penjualan,t.csf_penjualan, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan ,p.nama provinsi 
                    FROM tarif_cabang_kilogram t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabkilogram
                    where t.id_kota_asal = '$asal' AND t.id_kota_tujuan = '$tujuan'
                    ORDER BY t.kode_detail_kilo ASC ";
        
        $data = DB::select(DB::raw($sql));
        // $data = DB::table('tarif_cabang_kilogram')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail_kilo','ASC')->get();
        echo json_encode([$data]);
            }

  
    public function save_data (Request $req) {
      return DB::transaction(function() use ($req) {  
        $provinsi = DB::table('kota')   
                      ->where('id_provinsi',$req->cb_provinsi_tujuan)
                      ->get();
        dd($provinsi);



      }); 
    }


    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('tarif_cabang_kilogram')->where('kode_sama_kilo' ,'=', $id)->where('crud','!=','E')->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }
     public function hapus_data_perkota (Request $request) {
        // dd($request);
        $hapus='';
        $asal=$request->id;
        $tujuan=$request->name;
        $hapus = DB::table('tarif_cabang_kilogram')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->delete();
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
        $kota = DB::select(DB::raw(" SELECT id,nama,kode_kota FROM kota ORDER BY nama ASC "));
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY nama ASC "));
        $akun= DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $prov = DB::select(DB::raw("SELECT p.id,k.id_provinsi,p.nama FROM kota as k left join  provinsi as p on p.id =k.id_provinsi group by p.id,k.id_provinsi order by p.id"));

        
        return view('tarif.cabang_kilogram.index',compact('kota','cabang','akun','prov'));
    }

}
