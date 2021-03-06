<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use carbon\carbon;
use Auth;
use Exception;
use Session;
use PDF;
class surat_jalan_trayek_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT sjd.*,d.tanggal,id_kota_tujuan, k.nama tujuan, d.alamat_penerima,d.type_kiriman FROM surat_jalan_trayek_d sjd,delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_tujuan  
                    WHERE  d.nomor=sjd.nomor_do AND sjd.nomor_surat_jalan_trayek='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" onclick="hapus(\''.$data[$i]['nomor_do'].'\')" name="'.$data[$i]['nomor_do'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function datatable_sjt()
    {
        // $nama_cabang = DB::table("cabang")
        //      ->where('kode',$req->cabang)
        //      ->first();

        // if ($nama_cabang != null) {
        //   $cabang = 'and i_kode_cabang = '."'$req->cabang'";
        // }else{
        //   $cabang = '';
        // }

        if (Auth::user()->punyaAkses('Surat Jalan By Trayek','all')) {
            $sql = "SELECT * FROM surat_jalan_trayek  where nomor != '0' ";
            $data = DB::select($sql);
        }else{
            $cabang = auth::user()->kode_cabang;
            $data = DB::table('surat_jalan_trayek')
                      ->where('kode_cabang',$cabang)
                      ->get();
        }

        $data = collect($data);

        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            $b = '';
                            $c = '';

                            if(Auth::user()->punyaAkses('Surat Jalan By Trayek','ubah')){
                                $a = '<a href="'.url('sales/surat_jalan_trayek_form/edit/'.$data->nomor).'" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></a>';
                            }

                            if(Auth::user()->punyaAkses('Surat Jalan By Trayek','print')){
                                $b = '<a href="'.url('sales/surat_jalan_trayek_form/nota/'.$data->nomor).'" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></a>';
                            }


                            if(Auth::user()->punyaAkses('Surat Jalan By Trayek','hapus')){
                                $c = '<a href="'.url('sales/surat_jalan_trayek/hapus_data?id='.$data->nomor) .'" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>';
                            }

                            return '<div class="btn-group">'.$a . $b .$c.'</div>' ;
                                   
                        })
                        ->addColumn('cabang', function ($data) {
                          $kota = DB::table('cabang')
                                    ->get();
                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->kode_cabang == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addIndexColumn()
                        ->make(true);
    }
    public function ganti_nota(request $req)
    {
        $bulan = Carbon::parse($req->tanggal)->format('m');
        $tahun = Carbon::parse($req->tanggal)->format('y');
        // $update = DB::table('invoice')
        //             ->update(['create_at'=>carbon::now()
        //           ]);
        // return 'asd';
        $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from surat_jalan_trayek
                                        WHERE kode_cabang = '$req->cabang'
                                        AND nomor like 'SJT%'
                                        AND to_char(tanggal,'MM') = '$bulan'
                                        AND to_char(tanggal,'YY') = '$tahun'
                                        ");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'SJT' . $req->cabang . $bulan . $tahun . $index;
        return response()->json(['nota'=>$nota]);
    }


    public function save_data (Request $request) {
        return DB::transaction(function() use ($request){
            $cari = DB::table('surat_jalan_trayek')
                      ->where('nomor',$request->ed_nomor)
                      ->first();

            if ($cari == null) {
                $id_kendaraan = DB::table('kendaraan')
                                  ->where('nopol',strtoupper($request->ed_nopol))
                                  ->first();
                $data = array(
                    'nomor' => strtoupper($request->ed_nomor),
                    'tanggal' => strtoupper($request->tanggal),
                    'nama_rute' => strtoupper($request->ed_nama_rute),
                    'keterangan' => strtoupper($request->ed_keterangan),
                    'kode_cabang' => strtoupper($request->cabang),
                    'kode_rute' => strtoupper($request->ed_kode_rute),
                    'id_kendaraan' => $id_kendaraan->id,
                    'nopol' => strtoupper($request->ed_nopol),
                    'sopir' => strtoupper($request->ed_sopir),
                    'create_by' => Auth::user()->m_name,
                    'update_by' => Auth::user()->m_name,
                    'created_at'=>carbon::now(),
                    'update_at'=>carbon::now(),
                );

                $save = DB::table('surat_jalan_trayek')
                          ->insert($data);
            }else{
                $id_kendaraan = DB::table('kendaraan')
                                  ->where('nopol',strtoupper($request->ed_nopol))
                                  ->first();
                $data = array(
                    'nomor' => strtoupper($request->ed_nomor),
                    'tanggal' => strtoupper($request->tanggal),
                    'nama_rute' => strtoupper($request->ed_nama_rute),
                    'keterangan' => strtoupper($request->ed_keterangan),
                    'kode_cabang' => strtoupper($request->cabang),
                    'kode_rute' => strtoupper($request->ed_kode_rute),
                    'id_kendaraan' => $id_kendaraan->id,
                    'nopol' => strtoupper($request->ed_nopol),
                    'sopir' => strtoupper($request->ed_sopir),
                    'update_by' => Auth::user()->m_name,
                    'update_at'=>carbon::now(),
                );

                $save = DB::table('surat_jalan_trayek')
                          ->where('nomor',$request->ed_nomor)
                          ->update($data);
            }

            for ($i=0; $i < count($request->array_check); $i++) { 
                $do = DB::table('delivery_order')
                        ->where('nomor',$request->array_check[$i])
                        ->first();

                $update = DB::table('delivery_order')
                        ->where('nomor',$request->array_check[$i])
                        ->update([
                            'no_surat_jalan_trayek'=> strtoupper($request->ed_nomor),
                        ]);

                $data = array(
                    'nomor_surat_jalan_trayek' => $request->ed_nomor,
                    'nomor_do' => strtoupper($request->array_check[$i]),
                );

                $simpan = DB::table('surat_jalan_trayek_d')->insert($data);
            }
            $simpan = DB::table('surat_jalan_trayek_d')->where('nomor_surat_jalan_trayek',$request->ed_nomor)->get();
            // dd($simpan);
            return response()->json(['status'=>1]);
        });
    }
    public function hapus_data_detail (Request $request) {
        $update = DB::table('delivery_order')
                    ->where('nomor',$request->id)
                    ->update([
                        'no_surat_jalan_trayek'=> null,
                    ]);
        $delete = DB::table('surat_jalan_trayek_d')
                    ->where('nomor_do',$request->id)
                    ->delete();

        return response()->json(['status'=>1]);
    }

    public function index(){
        $sql = "    SELECT sj.*,c.nama cabang FROM surat_jalan_trayek sj
                    LEFT JOIN cabang c ON c.kode=sj.kode_cabang ";
        $data =  DB::select($sql);
        return view('sales.surat_jalan_trayek.index',compact('data'));
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
        return view('sales.surat_jalan_trayek.form',compact('kota','data','cabang','jml_detail','rute','kendaraan' ));
    }

    public function edit($nomor)
    {
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
        return view('sales.surat_jalan_trayek.edit',compact('kota','data','cabang','jml_detail','rute','kendaraan'));
    }
    
    public function tampil_do(Request $request){
        $tgl = explode('-',$request->range_date);
        $tgl[0] = str_replace('/', '-', $tgl[0]);
        $tgl[1] = str_replace('/', '-', $tgl[1]);
        $tgl[0] = str_replace(' ', '', $tgl[0]);
        $tgl[1] = str_replace(' ', '', $tgl[1]);
        $start  = Carbon::parse($tgl[0])->format('Y-m-d');
        $end    = Carbon::parse($tgl[1])->format('Y-m-d');

        $data = DB::table('delivery_order')
                  ->where('kode_cabang',$request->cabang)
                  ->where('tanggal','>=',$start)
                  ->where('tanggal','<=',$end)
                  ->where('no_surat_jalan_trayek','=',null)
                  ->take(1000)
                  ->get();
        for ($i=0; $i < count($data); $i++) { 
            $kota = DB::table('kota')
                      ->get();
            $button = '<input type="checkbox" class="form-control check">';
            $do     = $data[$i]->nomor.'<input type="hidden" class="form-control nomor_do" value="'.$data[$i]->nomor.'" class="nomor_do[]">';
            for ($a=0; $a < count($kota); $a++) { 
                if ($kota[$a]->id == $data[$i]->id_kota_tujuan) {
                    $tujuan = $kota[$a]->nama;
                }
         
            }
            $data[$i]->button = $button;
            $data[$i]->tujuan = $tujuan;
            $data[$i]->nomor  = $do;
        }
        $data = array('data' => $data);
        echo json_encode($data);
    }

    public function cetak_nota($nomor) {
        $head =collect(\DB::select("    SELECT c.nama nama_cabang,sj.nomor,sj.tanggal,sj.kode_rute FROM surat_jalan_trayek sj
                                        LEFT JOIN cabang c ON c.kode=sj.kode_cabang  WHERE sj.nomor='$nomor' "))->first();
        $detail =DB::select("   SELECT * FROM surat_jalan_trayek_d d, delivery_order o
                                WHERE o.nomor=d.nomor_do  AND d.nomor_surat_jalan_trayek='$nomor' ");
    
        $rute = DB::select("    SELECT * FROM rute h,rute_d d
                                        WHERE h.kode=d.kode_rute  AND h.kode='$head->kode_rute' ");

        for ($i=0; $i < count($rute); $i++) { 
            $last = $rute[$i]->kota;
        }

       


        return view('sales.surat_jalan_trayek.print',compact('head','detail','rute','last'));
    }

    public function nota_all($tanggal)
    {
        $head = DB::table('surat_jalan_trayek')
                  ->where('tanggal',$tanggal)
                  ->get();

        $last = [];
        $detail = [];
        $rute = [];
        for ($i=0; $i < count($head); $i++) { 
            $detail[$i] = DB::table('surat_jalan_trayek_d')
                            ->join('delivery_order','nomor','=','nomor_do')
                            ->where('nomor_surat_jalan_trayek',$head[$i]->nomor)
                            ->get();
            $rute[$i] = DB::table('rute')
                          ->join('rute_d','kode','=','kode_rute')
                          ->where('kode',$head[$i]->kode_rute)
                          ->get();
            for ($a=0; $a < count($rute[$i]); $a++) { 
                $last[$i] = $rute[$i][$a]->kota;
            }
        }
        // $pdf = PDF::loadView('sales.surat_jalan_trayek.print_all',compact('head','detail','rute','last'))
        //             ->setPaper('a4','potrait');
        // return $pdf->stream('all_trayek_'.$tanggal.'.pdf');
        return view('sales.surat_jalan_trayek.print_all',compact('head','detail','rute','last'));
    }



    public function hapus_data(Request $req)
    {
        return DB::transaction(function() use ($request){
            $data = DB::table('surat_jalan_trayek_d')
                      ->where('nomor_surat_jalan_trayek',$req->id)
                      ->get();

            for ($i=0; $i < count($data); $i++) { 
                $do = DB::table('delivery_order')
                        ->where('nomor',$data[$i]->nomor_do)
                        ->update([
                            'no_surat_jalan_trayek' => null
                        ]);
            }

            $data = DB::table('surat_jalan_trayek')
                      ->where('nomor',$req->id)
                      ->delete();
            Session::flash('message', "BERHASIL DIHAPUS");
            return redirect()->back();
        });
    }


}
