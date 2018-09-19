<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use App\tb_coa;
use App\tb_jurnal;
use App\patty_cash;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Auth;
use Yajra\Datatables\Datatables;
use App\d_jurnal;
use App\d_jurnal_dt;
use Exception;
class pengembalian_bonsem_controller extends Controller
{
    public function index()
    {
    	$cabang = DB::table('cabang')->get();

      $akun     = DB::table('masterbank')
                      ->get();
    	return view('purchase.pengembalian_bonsem.index_pengembalian_bonsem',compact('cabang','akun'));
    }


  public function datatable_pengembalian(request $req)
	{
		if ($req->flag == 'global') {
			$req->nota = '0';
		}else{
			$req->tanggal_awal = '0';
			$req->tanggal_akhir = '0';
			$req->jenis_biaya = '0';
		}
		$nama_cabang = DB::table("cabang")
						 ->where('kode',$req->cabang)
						 ->first();

		if ($nama_cabang != null) {
			$cabang = 'and bp_cabang = '."'$req->cabang'";
		}else{
			$cabang = '';
		}


		if ($req->tanggal_awal == '0' or $req->tanggal_awal == '') {
      $tanggal_awal = '';
		}else{
      $tgl_awal = carbon::parse($req->tanggal_awal)->format('Y-m-d');
      $tanggal_awal = 'and bp_tgl >= '."'$tgl_awal'";
		}

		if ($req->tanggal_akhir == '0' or $req->tanggal_akhir == '') {
			
      $tanggal_akhir = '';
		}else{
      $tgl_akhir = carbon::parse($req->tanggal_akhir)->format('Y-m-d');
      $tanggal_akhir = 'and bp_tgl <= '."'$tgl_akhir'";
		}

		if ($req->nota != '0') {
			if (Auth::user()->punyaAkses('Pengembalian Bonsem','all')) {
				$data = DB::table('bonsem_pengajuan')
						  ->where('bp_terima','DONE')
						  ->where('bp_nota','LIKE','%'.$req->nota.'%')
						  ->where('bp_sisapemakaian','!=',0)
						  ->get();
			}else{
				$cabang = Auth::user()->kode_cabang;
				$data = DB::table('bonsem_pengajuan')
						  ->where('bp_cabang',$cabang)
						  ->where('bp_terima','DONE')
              ->where('bp_nota','LIKE','%'.$req->nota.'%')
						  ->where('bp_sisapemakaian','!=',0)
						  ->get();
			}
		}else{
			if (Auth::user()->punyaAkses('Pengembalian Bonsem','all')) {

				$sql = "SELECT * FROM bonsem_pengajuan where bp_terima = 'DONE' and bp_sisapemakaian != '0' $cabang $tanggal_awal $tanggal_akhir ";

				$data = DB::select($sql);
			}else{
				$cabang = Auth::user()->kode_cabang;
				$sql = "SELECT * FROM bonsem_pengajuan where bp_terima = 'DONE' and bp_cabang = '$cabang' and bp_sisapemakaian != '0' $tanggal_awal $tanggal_akhir";
				$data = DB::select($sql);
			}
		}
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
            ->addColumn('aksi', function ($data) {
                $a = '';
            	if (Auth::user()->punyaAkses('Pengembalian Bonsem','ubah')) {
            		if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                      $a = '<a title="Edit" class="btn btn-xs btn-warning" onclick="pengembalian(\''.$data->bp_id.'\')">
                  			<i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                    }
                }else{
                  	if ($data->bp_status_pengembalian != 'Approve') {
                		if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                          $a = '<a title="Edit" class="btn btn-xs btn-warning" onclick="pengembalian(\''.$data->bp_id.'\')">
                      			<i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                        }
                	}
                }

                $c = '';
                $kembali = 'pengembalian';
                $d = '<a class="btn btn-xs btn-success" onclick="lihat_jurnal(\''.$data->bp_nota.'\',\''.$kembali.'\')" title="lihat jurnal"><i class="fa fa-eye"></i></a>';

                return '<div class="btn-group">' .$a . $c .$d.'</div>' ;
                       

                       
            })
        
            ->addColumn('cabang', function ($data) {
              $kota = DB::table('cabang')
                        ->get();

              for ($i=0; $i < count($kota); $i++) { 
                if ($data->bp_cabang == $kota[$i]->kode) {
                    return $kota[$i]->nama;
                }
              }
            })
            ->addColumn('status', function ($data) {
              if ($data->bp_status_pengembalian == 'Approve') {
                return '<label class="label label-success">APPROVED</label>';
              }else if($data->bp_status_pengembalian == 'Released'){
                return '<label class="label label-warning">RELEASED</label>';
              }else if($data->bp_status_pengembalian == 'Process'){
                return '<label class="label label-info">PROCESS</label>';
              }
            })
            ->addColumn('tagihan', function ($data) {
              return number_format($data->bp_sisapemakaian,2,',','.'  ); 
            })
            ->addColumn('print', function ($data) {
               return $a = '<input type="hidden" class="id_print" value="'.$data->bp_id.'">
                <a title="Print" class="" onclick="printing(\''.$data->bp_id.'\')" >
                <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                </a>';
            })
            ->addIndexColumn()
            ->make(true);
	}


  public function datatable_pengembalian_history(request $req)
  {
    if ($req->flag == 'global') {
      $req->nota = '0';
    }else{
      $req->tanggal_awal = '0';
      $req->tanggal_akhir = '0';
      $req->jenis_biaya = '0';
    }
    $nama_cabang = DB::table("cabang")
             ->where('kode',$req->cabang)
             ->first();

    if ($nama_cabang != null) {
      $cabang = 'and bp_cabang = '."'$req->cabang'";
    }else{
      $cabang = '';
    }


    if ($req->tanggal_awal == '0' or $req->tanggal_awal == '') {
      $tanggal_awal = '';
    }else{
      $tgl_awal = carbon::parse($req->tanggal_awal)->format('Y-m-d');
      $tanggal_awal = 'and bp_tgl >= '."'$tgl_awal'";
    }

    if ($req->tanggal_akhir == '0' or $req->tanggal_akhir == '') {
      
      $tanggal_akhir = '';
    }else{
      $tgl_akhir = carbon::parse($req->tanggal_akhir)->format('Y-m-d');
      $tanggal_akhir = 'and bp_tgl <= '."'$tgl_akhir'";
    }

    if ($req->nota != '0') {
      if (Auth::user()->punyaAkses('Pengembalian Bonsem','all')) {
        $data = DB::table('bonsem_pengajuan')
              ->where('bp_terima','DONE')
              ->where('bp_nota','LIKE','%'.$req->nota.'%')
              ->where('bp_status_pengembalian','LIKE','%Process%')
              ->get();
      }else{
        $cabang = Auth::user()->kode_cabang;
        $data = DB::table('bonsem_pengajuan')
              ->where('bp_cabang',$cabang)
              ->where('bp_terima','DONE')
              ->where('bp_nota','LIKE','%'.$req->nota.'%')
              ->where('bp_status_pengembalian','LIKE','%Process%')
              ->get();
      }
    }else{
      if (Auth::user()->punyaAkses('Pengembalian Bonsem','all')) {

        $sql = "SELECT * FROM bonsem_pengajuan where bp_terima = 'DONE' and bp_status_pengembalian = 'Process' $cabang $tanggal_awal $tanggal_akhir ";

        $data = DB::select($sql);
      }else{
        $cabang = Auth::user()->kode_cabang;
        $sql = "SELECT * FROM bonsem_pengajuan where bp_terima = 'DONE' and bp_cabang = '$cabang' and bp_status_pengembalian = 'Process' $tanggal_awal $tanggal_akhir";
        $data = DB::select($sql);
      }
    }
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
            ->addColumn('aksi', function ($data) {
                $a = '';
              if (Auth::user()->punyaAkses('Pengembalian Bonsem','ubah')) {
                if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                      $a = '<a title="Edit" class="btn btn-xs btn-warning" onclick="pengembalian(\''.$data->bp_id.'\')">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                    }
                }else{
                    if ($data->bp_status_pengembalian != 'Approve') {
                    if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                          $a = '<a title="Edit" class="btn btn-xs btn-warning" onclick="pengembalian(\''.$data->bp_id.'\')">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                        }
                  }
                }

                $c = '';
                $kembali = 'pengembalian';
                $d = '<a class="btn btn-xs btn-success" onclick="lihat_jurnal(\''.$data->bp_nota.'\',\''.$kembali.'\')" title="lihat jurnal"><i class="fa fa-eye"></i></a>';

                return '<div class="btn-group">' .$a . $c .$d.'</div>' ;
                       

                       
            })
        
            ->addColumn('cabang', function ($data) {
              $kota = DB::table('cabang')
                        ->get();

              for ($i=0; $i < count($kota); $i++) { 
                if ($data->bp_cabang == $kota[$i]->kode) {
                    return $kota[$i]->nama;
                }
              }
            })
            ->addColumn('status', function ($data) {
              if ($data->bp_status_pengembalian == 'Approve') {
                return '<label class="label label-success">APPROVED</label>';
              }else if($data->bp_status_pengembalian == 'Released'){
                return '<label class="label label-warning">RELEASED</label>';
              }else if($data->bp_status_pengembalian == 'Process'){
                return '<label class="label label-info">PROCESS</label>';
              }
            })
            ->addColumn('tagihan', function ($data) {
              return number_format($data->bp_sisapemakaian,2,',','.'  ); 
            })
            ->addColumn('print', function ($data) {
               return $a = '<input type="hidden" class="id_print" value="'.$data->bp_id.'">
                <a title="Print" class="" onclick="printing(\''.$data->bp_id.'\')" >
                <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                </a>';
            })
            ->addIndexColumn()
            ->make(true);
  }

  public function edit(Request $req)
  { 
      DB::BeginTransaction();
      try{

        $cari = DB::table('bonsem_pengajuan')
                    ->where('bp_id',$req->bp_id)
                    ->first();
        $update = DB::table('bonsem_pengajuan')
                    ->where('bp_id',$req->bp_id)
                    ->update([
                      'bp_status_pengembalian' => 'Process',
                      'bp_keterangan_pengembalian'=> strtoupper($req->keterangan),
                      'bp_akun_tujuan_pengembalian'=> $req->akun_bank,
                      'bp_tanggal_pengembalian'=> $req->tanggal,
                      'bp_sisapemakaian'=> 0
                    ]);

        // //JURNAL
        $id_jurnal=d_jurnal::max('jr_id')+1;
        // dd($id_jurnal);
        $jenis_bayar = DB::table('jenisbayar')
                 ->where('idjenisbayar',$req->jenis_bayar)
                 ->first();

        $bank = 'KK';
        $km =  get_id_jurnal($bank, $req->cabang);
        d_jurnal::where('jr_detail','PENGEMBALIAN BONSEM')->where('jr_ref',$cari->bp_nota)->delete();
        $jurnal = d_jurnal::create(['jr_id'   => $id_jurnal,
                      'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y'),
                      'jr_date'   => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
                      'jr_detail' => 'PENGEMBALIAN BONSEM',
                      'jr_ref'    => $cari->bp_nota,
                      'jr_note'   => 'BUKTI KAS KELUAR '.strtoupper($req->keterangan),
                      'jr_insert' => carbon::now(),
                      'jr_update' => carbon::now(),
                      'jr_no'   => $km,
                      ]);

        if ($cari->bp_sisapemakaian != 0) {
        
          $akun     = [];
          $akun_val = [];
          $cari_akun = DB::table('d_akun')
                         ->where('id_akun','like','1001%')
                         ->where('kode_cabang',$req->bp_cabang)
                         ->first();
          array_push($akun,$cari_akun->id_akun);
          array_push($akun_val, $cari->bp_sisapemakaian);


          array_push($akun, $cari->bp_akunhutang);
          array_push($akun_val, $cari->bp_sisapemakaian);
          $data_akun = [];
          for ($i=0; $i < count($akun); $i++) { 

            $cari_coa = DB::table('d_akun')
                      ->where('id_akun',$akun[$i])
                      ->first();

            if (substr($akun[$i],0, 4)==1001) {
              if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']      = $akun[$i];
                  $data_akun[$i]['jrdt_value']    = -round($akun_val[$i]);
                          $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->keterangan);
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
              }else{
               
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']    = $akun[$i];
                  $data_akun[$i]['jrdt_value']  = -round($akun_val[$i]);
                          $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->keterangan);
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
              }
            }if (substr($akun[$i],0, 4)==1002) {
              
              if ($cari_coa->akun_dka == 'D') {
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']    = $akun[$i];
                  $data_akun[$i]['jrdt_value']  = round($akun_val[$i]);
                          $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->keterangan);
                  $data_akun[$i]['jrdt_statusdk'] = 'D';
             
              }else{
                  $data_akun[$i]['jrdt_jurnal']   = $id_jurnal;
                  $data_akun[$i]['jrdt_detailid'] = $i+1;
                  $data_akun[$i]['jrdt_acc']    = $akun[$i];
                  $data_akun[$i]['jrdt_value']  = round($akun_val[$i]);
                          $data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->keterangan);
                  $data_akun[$i]['jrdt_statusdk'] = 'K';
              }
            }
          }
          $jurnal_dt = d_jurnal_dt::insert($data_akun);
          $lihat = d_jurnal_dt::where('jrdt_jurnal',$id_jurnal)->get()->toArray();

          
        }
        DB::commit();
        return Response()->json(['status'=>1]);
      }catch(Exception $error){
        DB::rollBack();
        dd($error);

      }
  }

  public function jurnal(Request $req)
  {

    $data= DB::table('d_jurnal')
         ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
         ->join('d_akun','jrdt_acc','=','id_akun')
         ->where('jr_ref',$req->id)
         ->where('jr_detail','PENGEMBALIAN BONSEM')
         ->get();


    $d = [];
    $k = [];
    for ($i=0; $i < count($data); $i++) { 
      if ($data[$i]->jrdt_value < 0) {
        $data[$i]->jrdt_value *= -1;
      }
    }

    for ($i=0; $i < count($data); $i++) { 
      if ($data[$i]->jrdt_statusdk == 'D') {
        $d[$i] = $data[$i]->jrdt_value;
      }elseif ($data[$i]->jrdt_statusdk == 'K') {
        $k[$i] = $data[$i]->jrdt_value;
      }
    }
    $d = array_values($d);
    $k = array_values($k);

    $d = array_sum($d);
    $k = array_sum($k);

    return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
  }
}
