<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use carbon\carbon;

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
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_do'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
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
        dd($request->all());
        $simpan='';
        $crud = $request->crud_h;
        $nomor_old = $request->ed_nomor_old;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'tanggal' => strtoupper($request->ed_tanggal),
                'nama_rute' => strtoupper($request->ed_nama_rute),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_cabang' => strtoupper($request->ed_cabang),
                'kode_rute' => strtoupper($request->ed_kode_rute),
                'id_kendaraan' => strtoupper($request->cb_nopol),
                'nopol' => strtoupper($request->ed_nopol),
                'sopir' => strtoupper($request->ed_sopir),
            );

        if ($crud == 'N' and $nomor_old =='') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->ed_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM surat_jalan_trayek WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='SJT'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='SJT'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number

           $simpan = DB::table('surat_jalan_trayek')->insert($data);

        } else {
            $simpan = DB::table('surat_jalan_trayek')->where('nomor', $nomor_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['nomor']=$data['nomor'];
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function save_data_detail (Request $request) {
        $simpan='';
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_do);
        for ($i=0; $i < $hitung; $i++) {
            $data = array(
                'nomor_surat_jalan_trayek' => $nomor,
                'nomor_do' => strtoupper($request->nomor_do[$i]),
            );
            $simpan = DB::table('surat_jalan_trayek_d')->insert($data);
            //DB::table('surat_jalan_trayek_d')->insert($data);
        } 
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM surat_jalan_trayek_d WHERE nomor_surat_jalan_trayek='$nomor' "))->first();
        $result['error']='';
        $result['result']=1;
        $result['jml_detail']=$jml_detail->jumlah;
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('surat_jalan_trayek_d')->where('id' ,'=', $id)->delete();
        $nomor = strtoupper($request->nomor);
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM surat_jalan_trayek_d WHERE nomor_surat_jalan_trayek='$nomor' "))->first();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
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

    public function cetak_nota($nomor=null) {
        $head =collect(\DB::select("    SELECT c.nama nama_cabang,sj.nomor,sj.tanggal,sj.kode_rute FROM surat_jalan_trayek sj
                                        LEFT JOIN cabang c ON c.kode=sj.kode_cabang  WHERE sj.nomor='$nomor' "))->first();
        $detail =DB::select("   SELECT * FROM surat_jalan_trayek_d d, delivery_order o
                                WHERE o.nomor=d.nomor_do  AND d.nomor_surat_jalan_trayek='$nomor' ");
    
        $rute = DB::select("    SELECT * FROM rute h,rute_d d
                                        WHERE h.kode=d.kode_rute  AND h.kode='$head->kode_rute' ");
        //dd($rute);
        return view('sales.surat_jalan_trayek.print',compact('head','detail','rute'));
    }


}
