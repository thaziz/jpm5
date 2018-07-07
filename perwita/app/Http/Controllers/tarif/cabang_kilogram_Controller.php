<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use carbon\carbon;
use Yajra\Datatables\Datatables;
use Exception;
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
         $sql = "    SELECT t.kode_cabang,k.kode_kota,t.crud,t.id_provinsi_cabkilogram,t.kode_detail_kilo,t.kode_sama_kilo,t.kode,t.acc_penjualan,t.csf_penjualan, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan ,p.nama provinsi,t.berat_minimum
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
        // dd($req->all());
        if ($req->crud == 'E') {
          $this->update_data($req);
          return response()->json(['status'=>1,'crud'=>'E']);
        }
        $cabang = $req->cb_cabang;
        $provinsi = DB::table('kota')   
                      ->where('id_provinsi',$req->cb_provinsi_tujuan)
                      ->get();

        $validator = DB::table('tarif_cabang_kilogram')   
                      ->where('kode_cabang',$cabang)
                      ->where('id_kota_asal',$req->cb_kota_asal)
                      ->where('id_provinsi_cabkilogram',$req->cb_provinsi_tujuan)
                      ->where('crud','E')
                      ->get();

        

        $reguler = array(
                    '0'     => $req->tarifkertas_reguler,
                    '1'     => $req->tarif0kg_reguler,
                    '2'     => $req->tarif10kg_reguler,
                    '3'     => $req->tarif20kg_reguler,
                    '4'     => $req->tarifkgsel_reguler,
                  );

        $keterangan_reguler = array(
                    '0'     =>'Tarif Kertas / Kg',
                    '1'     =>'Tarif <= 10 Kg',
                    '2'     =>'Tarif Kg selanjutnya <= 10 Kg',
                    '3'     =>'Tarif <= 20 Kg',
                    '4'     =>'Tarif Kg selanjutnya <= 20 Kg',
                  );

        $keterangan_express = array(
                    '0'     =>'Tarif Kertas / Kg',
                    '1'     =>'Tarif <= 10 Kg',
                    '2'     =>'Tarif Kg selanjutnya <= 10 Kg',
                    '3'     =>'Tarif <= 20 Kg',
                    '4'     =>'Tarif Kg selanjutnya <= 20 Kg',
                  );

        $express = array(
                    '0'     => $req->tarifkertas_express,
                    '1'     => $req->tarif0kg_express,
                    '2'     => $req->tarif10kg_express,
                    '3'     => $req->tarif20kg_express,
                    '4'     => $req->tarifkgsel_express,
                  );
        $jenis       = ['KGR','KGE'];
        $jenis_all   = ['REGULER','EXPRESS'];
        $berat_min   = [$req->berat_minimum_reg,$req->berat_minimum_ex];
        $jenis_waktu = [$req->waktu_regular,$req->waktu_express];

        $all_harga      = [$reguler,$express];
        $all_keterangan = [$keterangan_reguler,$keterangan_express];
        // dd($all);

        if (isset($req->cb_provinsi_tujuan)) {
          $delete    = DB::table('tarif_cabang_kilogram')   
                      ->where('kode_cabang',$cabang)
                      ->where('id_kota_asal',$req->cb_kota_asal)
                      ->where('id_provinsi_cabkilogram',$req->cb_provinsi_tujuan)
                      ->where('crud','N')
                      ->delete();

        }else if (isset($req->cb_kota_tujuan)){
          $delete    = DB::table('tarif_cabang_kilogram')   
                      ->where('kode_cabang',$cabang)
                      ->where('id_kota_asal',$req->cb_kota_asal)
                      ->where('id_kota_tujuan',$req->cb_kota_tujuan)
                      ->where('crud','N')
                      ->delete();
                      
          for ($i=0; $i < count($jenis); $i++) { 

            $index = DB::table('tarif_cabang_kilogram')
                             // ->where('kode_cabang',$cabang)
                             ->where('id_kota_asal',$req->cb_kota_asal)
                             ->where('jenis',$jenis_all[$i])
                             ->max('kode_detail_kilo')+1;
            for ($a=0; $a < count($all_harga[$i]); $a++) { 
              $index_fix = str_pad($index, 8,'0',STR_PAD_LEFT);
              $nota = $req->kodekota.'/'. $jenis[$i].$index_fix;
              $cari_provinsi = DB::table('kota')
                                 ->where('id',$req->cb_kota_tujuan)
                                 ->first();
              $save = array(
                    'kode'                    => $nota,
                    'kode_sama_kilo'          => 0,
                    'kode_detail_kilo'        => $index,
                    'keterangan'              => $all_keterangan[$i][$a],
                    'harga'                   => $all_harga[$i][$a],
                    'id_provinsi_cabkilogram' => $cari_provinsi->id_provinsi,
                    'waktu'                   => $jenis_waktu[$i],
                    'jenis'                   => $jenis_all[$i],
                    'id_kota_asal'            => $req->cb_kota_asal,
                    'id_kota_tujuan'          => $req->cb_kota_tujuan,
                    'kode_cabang'             => $req->cb_cabang,
                    'acc_penjualan'           => strtoupper($req->cb_acc_penjualan),
                    'csf_penjualan'           => strtoupper($req->cb_csf_penjualan),
                    'berat_minimum'           => $berat_min[$i],
                    'crud'                    => strtoupper('N'),
              );

              $save_data = [1];
              for ($b=0; $b < count($validator); $b++) { 
                if ($validator[$b]->id_kota_asal == $save['id_kota_asal'] and
                    $validator[$b]->id_kota_tujuan == $save['id_kota_tujuan'] and
                    $validator[$b]->kode_cabang == $save['kode_cabang'] and
                    $validator[$b]->id_provinsi_cabkilogram == $save['id_provinsi_cabkilogram'] and
                    $validator[$b]->keterangan == $save['keterangan']) {
                    array_push($save_data, 0);
                    break;
                }else{
                  array_push($save_data, 1);
                }
              }
              if (in_array(0, $save_data)) {
            // dd($save);
                $save_data = 'TIDAK';
              }else{
                $save_data = 'YA';
              }

              if ($save_data == 'YA') {
                $save = DB::table('tarif_cabang_kilogram')->insert($save);
              }else{
                // dd($save);
              }

              $index++;
            }
          }

          return response()->json(['status'=>1,'crud'=>'N']);
        }

        // SBY/KGR00100424

        // dd($validator);
        for ($i=0; $i < count($jenis); $i++) { 

          $index = DB::table('tarif_cabang_kilogram')
                           // ->where('kode_cabang',$cabang)
                           ->where('id_kota_asal',$req->cb_kota_asal)
                           ->where('jenis',$jenis_all[$i])
                           ->max('kode_detail_kilo')+1;

          for ($a=0; $a < count($all_harga[$i]); $a++) { 
            for ($c=0; $c < count($provinsi); $c++) { 
              $index_fix = str_pad($index, 8,'0',STR_PAD_LEFT);
              $nota = $req->kodekota.'/'. $jenis[$i].$index_fix;

              $save = array(
                    'kode'                    => $nota,
                    'kode_sama_kilo'          => 0,
                    'kode_detail_kilo'        => $index,
                    'keterangan'              => $all_keterangan[$i][$a],
                    'harga'                   => $all_harga[$i][$a],
                    'id_provinsi_cabkilogram' => $req->cb_provinsi_tujuan,
                    'waktu'                   => $jenis_waktu[$i],
                    'jenis'                   => $jenis_all[$i],
                    'id_kota_asal'            => $req->cb_kota_asal,
                    'id_kota_tujuan'          => $provinsi[$c]->id,
                    'kode_cabang'             => $req->cb_cabang,
                    'acc_penjualan'           => strtoupper($req->cb_acc_penjualan),
                    'csf_penjualan'           => strtoupper($req->cb_csf_penjualan),
                    'berat_minimum'           => $berat_min[$i],
                    'crud'                    => strtoupper('N'),
              );
              $save_data = [1];
              for ($b=0; $b < count($validator); $b++) { 
                if ($validator[$b]->id_kota_asal == $save['id_kota_asal'] and
                    $validator[$b]->id_kota_tujuan == $save['id_kota_tujuan'] and
                    $validator[$b]->kode_cabang == $save['kode_cabang'] and
                    $validator[$b]->id_provinsi_cabkilogram == $save['id_provinsi_cabkilogram'] and
                    $validator[$b]->keterangan == $save['keterangan']) {
                    array_push($save_data, 0);
                    break;
                }else{
                  array_push($save_data, 1);
                }
              }
              if (in_array(0, $save_data)) {
            // dd($save);
                $save_data = 'TIDAK';
              }else{
                $save_data = 'YA';
              }
              if ($save_data == 'YA') {
                $save = DB::table('tarif_cabang_kilogram')->insert($save);
              }else{
                // dd($save);
              }

              $index++;
            }

          }
        }


        $save = DB::table('tarif_cabang_kilogram')
                  ->where('kode_cabang',$cabang)
                  ->where('id_kota_asal',$req->cb_kota_asal)
                  ->where('id_provinsi_cabkilogram',$req->cb_provinsi_tujuan)
                  ->get();

        return response()->json(['status'=>1,'crud'=>'N']);
      }); 
    }

    public function update_data(request $req)
    {
      return DB::transaction(function() use ($req) {  
        // dd($req->all());

        $cabang = $req->cb_cabang;
        $provinsi = DB::table('kota')   
                      ->where('id_provinsi',$req->cb_provinsi_tujuan)
                      ->get();

        $validator = DB::table('tarif_cabang_kilogram')   
                      ->where('kode_cabang',$cabang)
                      ->where('id_kota_asal',$req->cb_kota_asal)
                      ->where('id_provinsi_cabkilogram',$req->cb_provinsi_tujuan)
                      ->where('crud','E')
                      ->get();

        

        $reguler = array(
                    '0'     => $req->tarifkertas_reguler,
                    '1'     => $req->tarif0kg_reguler,
                    '2'     => $req->tarif10kg_reguler,
                    '3'     => $req->tarif20kg_reguler,
                    '4'     => $req->tarifkgsel_reguler,
                  );

        $keterangan_reguler = array(
                    '0'     =>'Tarif Kertas / Kg',
                    '1'     =>'Tarif <= 10 Kg',
                    '2'     =>'Tarif Kg selanjutnya <= 10 Kg',
                    '3'     =>'Tarif <= 20 Kg',
                    '4'     =>'Tarif Kg selanjutnya <= 20 Kg',
                  );

        $keterangan_express = array(
                    '0'     =>'Tarif Kertas / Kg',
                    '1'     =>'Tarif <= 10 Kg',
                    '2'     =>'Tarif Kg selanjutnya <= 10 Kg',
                    '3'     =>'Tarif <= 20 Kg',
                    '4'     =>'Tarif Kg selanjutnya <= 20 Kg',
                  );

        $express = array(
                    '0'     => $req->tarifkertas_express,
                    '1'     => $req->tarif0kg_express,
                    '2'     => $req->tarif10kg_express,
                    '3'     => $req->tarif20kg_express,
                    '4'     => $req->tarifkgsel_express,
                  );
        $jenis       = ['KGR','KGE'];
        $jenis_all   = ['REGULER','EXPRESS'];
        $keterangan_join = array_merge($keterangan_reguler,$keterangan_express);
        $harga_join      = array_merge($reguler,$express);
        $kode        = [$req->id_reguler,$req->id_express];
        $berat_min   = [$req->berat_minimum_reg,$req->berat_minimum_ex];
        $jenis_waktu = [$req->waktu_regular,$req->waktu_express];

        $all_harga      = [$reguler,$express];
        $all_keterangan = [$keterangan_reguler,$keterangan_express];



        $kodex    = DB::table('tarif_cabang_kilogram')   
                             ->where('id_kota_asal',$req->asal_old)
                             ->where('id_kota_tujuan',$req->tujuan_old)
                             ->where('id_provinsi_cabkilogram',$req->provinsi_old)
                             ->where('kode_cabang',$req->cabang_old)
                             ->first();


        $kodekota = DB::table('kota')
                      ->where('id',$kodex->id_kota_asal)
                      ->first();

        if ($req->kodekota == $kodekota->kode_kota) {

          for ($i=0; $i < count($keterangan_reguler); $i++) { 
            $cari_provinsi = DB::table('kota')
                               ->where('id',$req->cb_kota_tujuan)
                               ->first();
            $save = array(
                  'harga'                   => $reguler[$i],
                  'id_provinsi_cabkilogram' => $cari_provinsi->id_provinsi,
                  'waktu'                   => $req->waktu_regular,
                  'id_kota_tujuan'          => $req->cb_kota_tujuan,
                  'kode_cabang'             => $req->cb_cabang,
                  'acc_penjualan'           => strtoupper($req->cb_acc_penjualan),
                  'csf_penjualan'           => strtoupper($req->cb_csf_penjualan),
                  'berat_minimum'           => $req->berat_minimum_reg,
                  'crud'                    => strtoupper('E'),
            );

            $reg    = DB::table('tarif_cabang_kilogram')   
                             ->where('id_kota_asal',$req->asal_old)
                             ->where('id_kota_tujuan',$req->tujuan_old)
                             ->where('id_provinsi_cabkilogram',$req->provinsi_old)
                             ->where('kode_cabang',$req->cabang_old)
                             ->where('keterangan',$keterangan_reguler[$i])
                             ->where('jenis','REGULER')
                             ->update($save);
          }


          for ($i=0; $i < count($keterangan_express); $i++) { 
            $cari_provinsi = DB::table('kota')
                               ->where('id',$req->cb_kota_tujuan)
                               ->first();
            $save = array(
                  'harga'                   => $express[$i],
                  'id_provinsi_cabkilogram' => $cari_provinsi->id_provinsi,
                  'waktu'                   => $req->waktu_regular,
                  'id_kota_tujuan'          => $req->cb_kota_tujuan,
                  'kode_cabang'             => $req->cb_cabang,
                  'acc_penjualan'           => strtoupper($req->cb_acc_penjualan),
                  'csf_penjualan'           => strtoupper($req->cb_csf_penjualan),
                  'berat_minimum'           => $req->berat_minimum_ex,
                  'crud'                    => strtoupper('E'),
            );

            $ex    = DB::table('tarif_cabang_kilogram')   
                             ->where('id_kota_asal',$req->asal_old)
                             ->where('id_kota_tujuan',$req->tujuan_old)
                             ->where('id_provinsi_cabkilogram',$req->provinsi_old)
                             ->where('kode_cabang',$req->cabang_old)
                             ->where('keterangan',$keterangan_express[$i])
                             ->where('jenis','EXPRESS')
                             ->update($save);
          }

        }else  if ($req->kodekota != $kodekota->kode_kota){

          $reg    = DB::table('tarif_cabang_kilogram')   
                             ->where('id_kota_asal',$req->asal_old)
                             ->where('id_kota_tujuan',$req->tujuan_old)
                             ->where('id_provinsi_cabkilogram',$req->provinsi_old)
                             ->where('kode_cabang',$req->cabang_old)
                             ->delete();



          for ($i=0; $i < count($jenis); $i++) { 

            $index = DB::table('tarif_cabang_kilogram')
                             ->where('id_kota_asal',$req->cb_kota_asal)
                             ->where('jenis',$jenis_all[$i])
                             ->max('kode_detail_kilo')+1;
            // dd($index);
            for ($a=0; $a < count($all_harga[$i]); $a++) { 

             
              $index_fix = str_pad($index, 8,'0',STR_PAD_LEFT);

              $nota = $req->kodekota .'/'. $jenis[$i].$index_fix;
              
              $cari_provinsi = DB::table('kota')
                                 ->where('id',$req->cb_kota_tujuan)
                                 ->first();
              $save = array(
                    'kode'                    => $nota,
                    'kode_sama_kilo'          => 0,
                    'kode_detail_kilo'        => $index,
                    'keterangan'              => $all_keterangan[$i][$a],
                    'harga'                   => $all_harga[$i][$a],
                    'id_provinsi_cabkilogram' => $cari_provinsi->id_provinsi,
                    'waktu'                   => $jenis_waktu[$i],
                    'jenis'                   => $jenis_all[$i],
                    'id_kota_asal'            => $req->cb_kota_asal,
                    'id_kota_tujuan'          => $req->cb_kota_tujuan,
                    'kode_cabang'             => $req->cb_cabang,
                    'acc_penjualan'           => strtoupper($req->cb_acc_penjualan),
                    'csf_penjualan'           => strtoupper($req->cb_csf_penjualan),
                    'berat_minimum'           => $berat_min[$i],
                    'crud'                    => strtoupper('E'),
              );

              $save = DB::table('tarif_cabang_kilogram')
                        ->insert($save);
          

              $index++;
            }
          }
        }

        return response()->json(['status'=>1,'crud'=>'E']);
        
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
        $hapus = DB::table('tarif_cabang_kilogram')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)
        ->where('crud','!=','E')->delete();
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