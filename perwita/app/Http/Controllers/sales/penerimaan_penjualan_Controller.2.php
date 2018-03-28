<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;


class penerimaan_penjualan_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "   SELECT * FROM penerimaan_penjualan_d WHERE nomor_penerimaan_penjualan='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function table_data_detail_biaya (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT ppbd.*,ab.nama nama_biaya FROM penerimaan_penjualan_biaya_d ppbd,akun_biaya ab
                    WHERE ppbd.kode_biaya=ab.kode AND  ppbd.nomor_penerimaan_penjualan='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            //<button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit_biaya" ><i class="glyphicon glyphicon-pencil"></i></button>
            $data[$i]['button'] = ' <div class="btn-group">
                                        
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_invoice'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete_biaya" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('penerimaan_penjualan')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('penerimaan_penjualan_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail_biaya (Request $request) {
        $id =$request->input('id');
        $data = DB::table('penerimaan_penjualan_biaya_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $nomor_old = $request->ed_nomor_old;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'tanggal' => strtoupper($request->ed_tanggal),
                'kode_cabang' => strtoupper($request->ed_cabang),
                'kode_customer' => strtoupper($request->ed_customer),
                'kode_akun' => strtoupper($request->cb_akun_h),
                'jenis_pembayaran' => strtoupper($request->ed_jenis_pembayaran),
                'keterangan' => strtoupper($request->ed_keterangan),
                'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
            );

        if ($crud == 'N' and $nomor_old =='') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->ed_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM penerimaan_penjualan WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='KWT'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='KWT'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number
            $simpan = DB::table('penerimaan_penjualan')->insert($data);
        } else {
            $simpan = DB::table('penerimaan_penjualan')->where('nomor', $nomor_old)->update($data);
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

    public function hapus_data($nomor_penerimaan_penjualan=null){
        $cek_data =DB::table('posting_pembayaran_d')->select('id')->where('nomor_penerimaan_penjualan', $nomor_penerimaan_penjualan)->first();
        $pesan ='';
        if ($cek_data->id !=NULL) {
            $pesan='Nomor penerimaan penjualan '.$nomor_penerimaan_penjualan.' sudah di pakai pada posting pembayaran';
            return view('sales.penerimaan_penjualan.pesan',compact('pesan'));
        }else{
            DB::beginTransaction();
            DB::table('penerimaan_penjualan_d')->where('nomor_penerimaan_penjualan' ,'=', $nomor_penerimaan_penjualan)->delete();
            DB::table('penerimaan_penjualan')->where('nomor' ,'=', $nomor_penerimaan_penjualan)->delete();
            DB::commit();
            return redirect('master_sales/penerimaan_penjualan');
        }
        
    }
    

    public function save_data_detail (Request $request) {
        $simpan='';
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_invoice);
        try {
            DB::beginTransaction();
            
            for ($i=0; $i < $hitung; $i++) {
                $nomor_invoice = strtoupper($request->nomor_invoice[$i]);
                //$jumlah = filter_var($request->jumlah[$i], FILTER_SANITIZE_NUMBER_INT);
                // if ($jumlah != 0 || $jumlah == '') {
                //     $data = array(
                //         'nomor_penerimaan_penjualan' => $nomor,
                //         'nomor_invoice' => $nomor_invoice,
                //         'jumlah' => $jumlah,
                //     );
                //     DB::table('penerimaan_penjualan_d')->insert($data);
                //     DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial + '$jumlah' WHERE nomor='$nomor_invoice' ");
                // }

                $data = array(
                    'nomor_penerimaan_penjualan' => $nomor,
                    'nomor_invoice' => $nomor_invoice,
                    //'jumlah' => $jumlah,
                );
                DB::table('penerimaan_penjualan_d')->insert($data);
                //DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial + '$jumlah' WHERE nomor='$nomor_invoice' ");
                
            } 
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM penerimaan_penjualan_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
            $data_h = array(
                        'jumlah' => $jml_detail->ttl_jumlah,
            );
        
//            $simpan = DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['ttl_jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");    
        }
        echo json_encode($result);
    }

    public function save_data_detail2 (Request $request) {
        $id = $request->id;
        $jumlah = filter_var($request->jumlah, FILTER_SANITIZE_NUMBER_INT);
        $jumlah_old = filter_var($request->jumlah_old, FILTER_SANITIZE_NUMBER_INT);
        $jenis_pembayaran = strtoupper($request->jenis_pembayaran);
        $keterangan = strtoupper($request->keterangan);
        $nomor = strtoupper($request->nomor);
        $nomor_invoice = strtoupper($request->nomor_invoice);
        try {
            DB::beginTransaction();
            $data = array(
                    'jumlah' => $jumlah,
                    'keterangan' => $keterangan,
                );
    
            DB::table('penerimaan_penjualan_d')->where('id', $id)->update($data);
            if ($jenis_pembayaran == 'F') {
                DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial -'$jumlah_old' + '$jumlah'  WHERE nomor='$nomor_invoice' ");
            }else{
                DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial -'$jumlah_old' + '$jumlah', jml_bayar=jml_bayar -'$jumlah_old' + '$jumlah'  WHERE nomor='$nomor_invoice' ");
            }
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah
                                                FROM penerimaan_penjualan_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
            $jml_kredit = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                                FROM penerimaan_penjualan_biaya_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='K' "))->first();
            $jml_debet = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                                FROM penerimaan_penjualan_biaya_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='D' "))->first();
            $data_h = array(
                        'jumlah' => $jml_detail->ttl_jumlah,
                        'debet' => $jml_debet->ttl_jumlah,
                        'kredit' => $jml_kredit->ttl_jumlah,
                        'netto' => $jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah,    
            );
            DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;    
            $result['jml_detail']=$jml_detail->jumlah;
            $result['ttl_jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
            $result['ttl_debet']=number_format($jml_debet->ttl_jumlah, 0, ",", ".");
            $result['ttl_kredit']=number_format($jml_kredit->ttl_jumlah, 0, ",", ".");
            $result['ttl_netto']=number_format($jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah, 0, ",", ".");    
        }
        echo json_encode($result);
    }

    public function save_data_detail_biaya (Request $request) {
        $crud = $request->crud_biaya;
        $id = $request->ed_id;
        $jumlah = filter_var($request->ed_jml_biaya, FILTER_SANITIZE_NUMBER_INT);
        $jenis = strtoupper($request->ed_jenis_biaya);
        $kode_biaya = strtoupper($request->cb_akun_biaya);
        $kode_akun_acc = strtoupper($request->ed_kode_acc);
        $kode_akun_csf = strtoupper($request->ed_kode_csf);
        $keterangan = strtoupper($request->ed_keterangan_biaya);
        $nomor = strtoupper($request->ed_nomor_penerimaan_penjualan);
        $nomor_invoice = strtoupper($request->cb_invoice);
        $simpan ='';
        
        try {
            DB::beginTransaction();
            $data = array(
                    'nomor_penerimaan_penjualan' => $nomor,
                    'nomor_invoice' => $nomor_invoice,
                    'kode_biaya' => $kode_biaya,
                    'kode_akun_acc' => $kode_akun_acc,
                    'kode_akun_csf' => $kode_akun_csf,
                    'jumlah' => $jumlah,
                    'jenis' => $jenis,
                    'keterangan' => $keterangan,
                );
    
            if ($crud == 'N') {
                $simpan = DB::table('penerimaan_penjualan_biaya_d')->insert($data);
            } else {
                $simpan = DB::table('penerimaan_penjualan_de')->where('id', $id)->update($data);
            }
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah
                        FROM penerimaan_penjualan_d 
                        WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
            $jml_kredit = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                        FROM penerimaan_penjualan_biaya_d 
                        WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='K' "))->first();
            $jml_debet = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                        FROM penerimaan_penjualan_biaya_d 
                        WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='D' "))->first();
            $data_h = array(
                            'jumlah' => $jml_detail->ttl_jumlah,
                            'debet' => $jml_debet->ttl_jumlah,
                            'kredit' => $jml_kredit->ttl_jumlah,
                            'netto' => $jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah,    
                    );
            DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['ttl_jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
            $result['ttl_debet']=number_format($jml_debet->ttl_jumlah, 0, ",", ".");
            $result['ttl_kredit']=number_format($jml_kredit->ttl_jumlah, 0, ",", ".");
            $result['ttl_netto']=number_format($jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah, 0, ",", ".");    
        }
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor=$request->nomor;
        $jenis_pembayaran = $request->jenis_pembayaran;
        $data_invoice = collect(\DB::select(" SELECT * FROM penerimaan_penjualan_d  WHERE id='$id' "))->first();
        $jumlah = $data_invoice->jumlah;
        $nomor_invoice = $data_invoice->nomor_invoice;
        $cek_data_biaya =collect(\DB::select("  SELECT id FROM penerimaan_penjualan_biaya_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' AND nomor_invoice='$nomor_invoice' "))->first();
        $cek_data =collect(\DB::select(" SELECT id FROM posting_pembayaran_d  WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
        if ($cek_data_biaya !=NULL) {
            $result['result']='4';
        }else if ($cek_data !=NULL) {
            $result['result']='3';
        }else{
            try {
                DB::beginTransaction();
                if ($jenis_pembayaran == 'F') {
                    DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial - '$jumlah' WHERE nomor='$nomor_invoice' ");
                }else{
                    DB::select(" UPDATE invoice SET jml_bayar_memorial=jml_bayar_memorial - '$jumlah',jml_bayar=jml_bayar - '$jumlah' WHERE nomor='$nomor_invoice' ");
                }
                
                DB::table('penerimaan_penjualan_d')->where('id' ,'=', $id)->delete();
                $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM penerimaan_penjualan_d 
                                                    WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
                $jml_kredit = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                                    FROM penerimaan_penjualan_biaya_d 
                                                    WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='K' "))->first();
                $jml_debet = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                                    FROM penerimaan_penjualan_biaya_d 
                                                    WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='D' "))->first();
                $data_h = array(
                                'jumlah' => $jml_detail->ttl_jumlah,
                                'debet' => $jml_debet->ttl_jumlah,
                                'kredit' => $jml_kredit->ttl_jumlah,
                                'netto' => $jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah,    
                        );
                DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
                $success = true;
            } catch (\Exception $e) {
                $result['error']='gagal';
                $result['result']=2;
                $success = false;
                DB::rollback();
            }
        
            if ($success) {
                DB::commit();
                $result['error']='';
                $result['result']=1;
                $result['jml_detail']=$jml_detail->jumlah;
                $result['ttl_jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
                $result['ttl_debet']=number_format($jml_debet->ttl_jumlah, 0, ",", ".");
                $result['ttl_kredit']=number_format($jml_kredit->ttl_jumlah, 0, ",", ".");
                $result['ttl_netto']=number_format($jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah, 0, ",", ".");    
            }
        }
        echo json_encode($result);
    }

    public function hapus_data_detail_biaya (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor=$request->nomor;
        try {
            DB::beginTransaction();
            DB::table('penerimaan_penjualan_biaya_d')->where('id' ,'=', $id)->delete();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah,COALESCE(SUM(jumlah),0) ttl_jumlah FROM penerimaan_penjualan_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
            $jml_kredit = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                                FROM penerimaan_penjualan_biaya_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='K' "))->first();
            $jml_debet = collect(\DB::select("  SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                                FROM penerimaan_penjualan_biaya_d 
                                                WHERE nomor_penerimaan_penjualan='$nomor' AND jenis='D' "))->first();
            $data_h = array(
                            'jumlah' => $jml_detail->ttl_jumlah,
                            'debet' => $jml_debet->ttl_jumlah,
                            'kredit' => $jml_kredit->ttl_jumlah,
                            'netto' => $jml_detail->ttl_jumlah + $jml_debet->ttl_jumlah - $jml_kredit->ttl_jumlah,    
                    );
            DB::table('penerimaan_penjualan')->where('nomor', $nomor)->update($data_h);
            $success = true;
        } catch (\Exception $e) {
            $result['error']='gagal';
            $result['result']=2;
            $success = false;
            DB::rollback();
        }
    
        if ($success) {
            DB::commit();
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['ttl_jumlah']=number_format($jml_detail->ttl_jumlah, 0, ",", ".");
            $result['ttl_debet']=number_format($jml_debet->ttl_jumlah, 0, ",", ".");
            $result['ttl_kredit']=number_format($jml_kredit->ttl_jumlah, 0, ",", ".");
            $result['ttl_netto']=number_format($jml_detail->ttl_jumlah - $jml_debet->ttl_jumlah + $jml_kredit->ttl_jumlah, 0, ",", ".");    
        }
        
        echo json_encode($result);
    }

 

    

    public function tampil_invoice(Request $request) {
       

    }

    public function tampil_riwayat_invoice(Request $request) {
        $nomor = $request->nomor_invoice;
        $sql = "    select i.nomor nomor_invoice,i.total_tagihan,pd.nomor_penerimaan_penjualan,pd.jumlah as jml_bayar, p.tanggal tgl_bayar,
                    i.total_tagihan - sum(pd.jumlah) OVER (ORDER BY p.tanggal,pd.id) sisa_tagihan,pd.keterangan
                    from invoice i,penerimaan_penjualan_d pd,penerimaan_penjualan p
                    where i.nomor='$nomor' and pd.nomor_invoice=i.nomor and p.nomor=pd.nomor_penerimaan_penjualan ";


        //$sql = "select * from penerimaan_penjualan_d";
        $list = DB::select(DB::raw($sql));
        $tabel_data = ' <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
                        <thead>
                            
                            <tr>
                                <td style="width:17%">Nomor Penerimaan</td>
                                <td style="width:18%">Tanggal</th>
                                <td style="width:10%">Jml Bayar</td>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($list as $row) {
            $tabel_data = $tabel_data.' <tr>
                                                <td>'. $row->nomor_penerimaan_penjualan.'</td>    
                                                <td>'. $row->tgl_bayar.'</td>
                                                <td style="text-align:right">'.number_format($row->jml_bayar, 0, ",", ".").' </td>
                                                <td>'. $row->keterangan.'</td>
                                            </tr>';
        };        
        $tabel_data = $tabel_data.'</tbody> </table>';                    
        // echo '  <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
        //             <thead>
                        
        //                 <tr>
        //                     <td>Nomor Penerimaan</td>
        //                     <td>Tanggal</th>
        //                     <td style="width:20%">Jml Bayar</td>
        //                     <td style="width:20%">Sisa</td>
        //                 </tr>
        //             </thead>
        //             <tbody>
        //             <tr>
        //                 <td colspan = "3" style="background-color: #ffff99;" >Jumlah Tagihan Nomor Invoice : '.$nomor.'</td>
        //                 <td style="text-align:right; background-color: #ffff99;">'.number_format($total_tagihan, 0, ",", ".").' </td>
        //             </tr>';
        // foreach ($list as $row) {
        //     echo '
        //     <tr>
        //         <td>'. $row->nomor_penerimaan_penjualan.'</td>    
        //         <td>'. $row->tgl_bayar.'</td>
        //         <td style="text-align:right">'.number_format($row->jml_bayar, 0, ",", ".").' </td>
        //         <td style="text-align:right">'.number_format($row->sisa_tagihan, 0, ",", ".").' </td>
        //     </tr>';
        // }        
        // echo '</tbody>
        // </table>';    
        // $data = DB::table('invoice')->where('nomor', $nomor)->first();
        // echo json_encode($data);
        $result['html']=$tabel_data;
        $result['invoice']=DB::table('invoice')->where('nomor', $nomor)->first();
        $result['penerimaan_penjualan_d']=DB::table('penerimaan_penjualan_d')->where('id', $request->id)->first();
        $nomor_invoice = $result['penerimaan_penjualan_d']->nomor_invoice;
        $nomor_penerimaan = $result['penerimaan_penjualan_d']->nomor_penerimaan_penjualan;
        $jml_kredit = collect(\DB::select(" SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                            FROM penerimaan_penjualan_biaya_d 
                                            WHERE nomor_penerimaan_penjualan='$nomor_penerimaan' AND nomor_invoice='$nomor_invoice' AND jenis='K' "))->first();
        $jml_debet = collect(\DB::select("  SELECT COALESCE(SUM(jumlah),0) ttl_jumlah
                                            FROM penerimaan_penjualan_biaya_d 
                                            WHERE nomor_penerimaan_penjualan='$nomor_penerimaan' AND nomor_invoice='$nomor_invoice' AND jenis='D' "))->first();
		$nota_debet_kredit = collect(\DB::select("  SELECT COALESCE(SUM(debet),0) ttl_debet,COALESCE(SUM(kredit),0) ttl_kredit FROM nota_debet_kredit 
                                            		WHERE nomor_invoice='$nomor_invoice' "))->first();
		$result['ttl_nota_debet'] = $nota_debet_kredit->ttl_debet;
		$result['ttl_nota_kredit'] = $nota_debet_kredit->ttl_kredit;
        $result['total_biaya_kredit'] = $jml_kredit->ttl_jumlah;                                           
        $result['total_biaya_debet'] = $jml_debet->ttl_jumlah;                                           
        echo json_encode($result);

    }

    public function tampil_invoice_biaya(Request $request) {
        $nomor = $request->nomor;
        $sql = "SELECT nomor_invoice FROM penerimaan_penjualan_d WHERE  nomor_penerimaan_penjualan='$nomor' ";
        $list = DB::select(DB::raw($sql));
        $data_invoice = ' <select class="form-control" name="cb_invoice" id="cb_invoice" >';
        foreach ($list as $row) {
            $data_invoice = $data_invoice.' <option value="'.$row->nomor_invoice.'">'.$row->nomor_invoice.'</option>';
        };
        $result['html'] = $data_invoice.'</select>';           
        echo json_encode($result);

    }

    public function get_data_akun_biaya(Request $request) {
        $id =$request->input('kode');
        $data = DB::table('akun_biaya')->where('kode', $id)->first();
        echo json_encode($data);

    }

    public function cetak_nota($nomor=null) {
        $head = DB::table('kwitansi')
                  ->join('customer','kode','=','k_kode_customer')
                  ->where('k_nomor',$nomor)
                  ->first();

        $detail = DB::table('kwitansi')
                    ->join('kwitansi_d','kd_id','=','k_id')
                    ->join('invoice','kd_nomor_invoice','=','i_nomor')
                    ->get();

        $terbilang =$this->penyebut($head->k_jumlah);
        return view('sales.penerimaan_penjualan.print',compact('head','detail','terbilang'));
    }

    public function penyebut($nilai=null) {
        $_this = new self;
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $_this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $_this->penyebut($nilai/10)." puluh". $_this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $_this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $_this->penyebut($nilai/100) . " ratus" . $_this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $_this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $_this->penyebut($nilai/1000) . " ribu" . $_this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $_this->penyebut($nilai/1000000) . " juta" . $_this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $_this->penyebut($nilai/1000000000) . " milyar" . $_this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $_this->penyebut($nilai/1000000000000) . " trilyun" . $_this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
    }

    public function form($nomor=null)
    {
        $comp = Auth::user()->kode_cabang;
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $akun = DB::table('d_akun')
                  ->where('id_parrent','1001')
                  ->where('kode_cabang',$comp)
                  ->get();


        $tgl  = Carbon::now()->format('d/m/Y');
       
        return view('sales.penerimaan_penjualan.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','kas_bank','akun','tgl' ));
    }


    public function index()
    {
        
        return view('sales.penerimaan_penjualan.index',compact('data'));
    }


    public function datatable_kwitansi()
    {
        $cabang = Auth::user()->kode_cabang;
        $data = DB::table('kwitansi')
                  ->where('k_kode_cabang',$cabang)
                  ->get();
        $data = collect($data);

        return Datatables::of($data)
                        ->addColumn('tes', function ($data) {

                           $string = (string)$data->k_nomor;
                                   return '<div class="btn-group"><button type="button" onclick="edit(\''.$string.'\')" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button>
                                   <button type="button" onclick="ngeprint(\''.$string.'\')" class="btn btn-xs btn-warning"><i class="fa fa-print"></i></button>
                                        <button type="button" onclick="hapus(\''.$string.'\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                         </div>';
                            })
                        ->make(true);
    }
    public function nota_kwitansi(request $request)
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

        $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                        WHERE k_kode_cabang = '$request->cabang'
                                        AND to_char(k_tanggal,'MM') = '$bulan'
                                        AND to_char(k_tanggal,'YY') = '$tahun'");
        $index = (integer)$cari_nota[0]->id + 1;
        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
        $nota = 'KWT' . $request->cabang . $bulan . $tahun . $index;

        return response()->json(['nota'=>$nota]);
    }
    public function nota_bank(request $request)

    {   if ($request->cb_jenis_pembayaran == 'C' || $request->cb_jenis_pembayaran == 'F') {
            $bulan = Carbon::now()->format('m');

            $tahun = Carbon::now()->format('y');

            $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                            WHERE k_kode_cabang = '$request->cabang'
                                            AND to_char(k_tanggal,'MM') = '$bulan'
                                            AND to_char(k_tanggal,'YY') = '$tahun'");
            $index = (integer)$cari_nota[0]->id + 1;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota = 'CRU' . $request->cabang . $bulan . $tahun . $index;

            return response()->json(['nota'=>$nota]);
        }else{
            $nota = '';
            return response()->json(['nota'=>$nota]);
        }
    }
        
    public function akun_all(request $request)
    {
        $akun = DB::table('d_akun')
                  ->where('kode_cabang',$request->cabang)
                  ->get();
        return view('sales.penerimaan_penjualan.akun_all',compact('akun'));
    }

    public function akun_biaya(request $request)
    {
        $akun = DB::table('d_akun')
                  ->where('kode_cabang',$request->cabang)
                  ->get();
        return view('sales.penerimaan_penjualan.akun_biaya',compact('akun'));
    }
    public function cari_invoice(request $request)
    {   
        $cabang       = $request->cb_cabang;
        $customer     = $request->cb_customer;
        $customer     = $request->cb_customer;
        $array_simpan = $request->array_simpan;
        return view('sales.penerimaan_penjualan.tabel_invoice',compact('cabang','customer','array_simpan'));
    }
    public function datatable_detail_invoice(request $request)
    {   
        // dd($request->all());
        // return $request->customer;
        $temp  = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_pelunasan','!=',0)
                  ->where('i_kode_cabang',$request->cabang)
                  ->get();

        $temp1 = DB::table('invoice')
                  ->leftjoin('kwitansi','k_nomor','=','i_nomor')
                  ->where('i_kode_customer',$request->customer)
                  ->where('i_sisa_pelunasan','!=',0)
                  ->where('i_kode_cabang',$request->cabang)
                  ->get();

                  
        for ($i=0; $i < count($temp1); $i++) { 
            if ($temp1[$i]->k_nomor != null) {
                unset($temp[$i]);
            } 
        }

        $temp = array_values($temp);


        if (isset($request->array_simpan)) {

            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->array_simpan); $a++) { 
                    if ($request->array_simpan[$a] == $temp1[$i]->i_nomor) {
                        unset($temp[$i]);
                    }
                    
                }
            }
            $temp = array_values($temp);
            $data = $temp;
            
        }else{

            $data = $temp;
        }

        $data = collect($data);

        return Datatables::of($data)
                        ->addColumn('tes', function ($data) {
                                   return     '<input type="checkbox" class="child_check">';
                        })
                        ->addColumn('nomor', function ($data) {
                                return  $data->i_nomor .'<input type="hidden" class="nomor_inv" value="'. $data->i_nomor .'" >';
                        })
                        ->addColumn('i_sisa', function ($data) {
                                return number_format($data->i_sisa_pelunasan,2,',','.');
                        })
                        ->addColumn('i_tagihan', function ($data) {
                                return number_format($data->i_total_tagihan,2,',','.');
                        })
                        ->make(true);
    }

    public function append_invoice(request $request)
    {
        // dd($request->all());

        $data = DB::table('invoice')
                  ->whereIn('i_nomor',$request->nomor)
                  ->get();

        return response()->json(['data'=>$data]);
        
    }
    public function riwayat_invoice(request $request)
    {
        $data = DB::table('kwitansi')
                  ->join('kwitansi_d','k_id','=','kd_id')
                  ->where('kd_nomor_invoice',$request->i_nomor)
                  ->get();
        return view('sales.penerimaan_penjualan.tabel_riwayat',compact('data'));
    }
    public function riwayat_cn_dn(request $request)
    {
        $data = DB::table('cn_dn_penjualan')
                  ->where('cd_invoice',$request->i_nomor)
                  ->get();
        return view('sales.penerimaan_penjualan.tabel_cn_dn',compact('data'));
    }
    public function auto_biaya(request $request)
    {

        $data = DB::table('d_akun')
                  ->where('id_akun',$request->tes)
                  ->first();

        if ($data->akun_dka == 'D') {
            $data->debet = 'DEBET';
        }else{
            $data->debet = 'KREDIT';
        }
        return response()->json(['data'=>$data]);  
    }
    public function simpan_kwitansi(request $request)
    {
        // dd($request->all());
        return DB::transaction(function() use ($request) {  

        $tgl = str_replace('/', '-', $request->ed_tanggal);
        $tgl = Carbon::parse($tgl)->format('Y-m-d');

        $cari_kwitansi = DB::table('kwitansi')
                           ->where('k_nomor',$request->nota)
                           ->first();
        if ($cari_kwitansi == null) {
            $k_id = DB::table('kwitansi')
                           ->max('k_id');
            if ($k_id == null) {
                $k_id = 1;
            }else{
                $k_id += 1;
            }
            $save_kwitansi = DB::table('kwitansi')
                               ->insert([
                                'k_id' => $k_id,
                                'k_nomor' => $request->nota,
                                'k_tanggal'=> $tgl,
                                'k_kode_customer' => $request->cb_customer,
                                'k_jumlah' => $request->jumlah_bayar,
                                'k_keterangan' => $request->ed_keterangan,
                                'k_create_by' => Auth::user()->m_username,
                                'k_update_by' => Auth::user()->m_username,
                                'k_create_at' => Carbon::now(),
                                'k_update_at' => Carbon::now(),
                                'k_kode_cabang' => $request->cb_cabang,
                                'k_jenis_pembayaran' => $request->cb_jenis_pembayaran,
                                'k_kredit' => $request->ed_debet,
                                'k_nota_bank' => $request->nota_bank,
                                'k_debet' => $request->ed_kredit,
                                'k_netto' => $request->ed_netto,
                                'k_kode_akun'=> $request->cb_akun_h
                               ]);
            $memorial_array = [];
            for ($i=0; $i < count($request->i_nomor); $i++) { 
                if ($request->i_bayar[$i] != 0) {
                    $cari_invoice = DB::table('invoice')
                                      ->where('i_nomor',$request->i_nomor[$i])
                                      ->first();
                    if ($request->i_biaya_admin[$i] == '') {
                        $i_biaya_admin[$i] = 0;
                    }else{
                        $i_biaya_admin[$i] = $request->i_biaya_admin[$i];
                    }

                    $memorial = (float)$cari_invoice->i_sisa_pelunasan - (float)$request->i_bayar[$i];

                    if ($memorial > 0) {
                       $memorial = 0;
                    }else if ($memorial<0) {
                        $memorial = $memorial * -1;
                    }

                    array_push($memorial_array, $memorial);


                    $save_detail = DB::table('kwitansi_d')
                                     ->insert([
                                          'kd_id'             => $k_id,
                                          'kd_dt'             => $i+1,
                                          'kd_k_nomor'        => $request->nota,
                                          'kd_tanggal_invoice'=> $cari_invoice->i_tanggal,
                                          'kd_nomor_invoice'  => $request->i_nomor[$i],
                                          'kd_keterangan'     => $request->i_keterangan[$i],
                                          'kd_kode_biaya'     => $request->akun_biaya[$i],
                                          'kd_total_bayar'    => $request->i_bayar[$i] ,
                                          'kd_biaya_lain'     => $i_biaya_admin[$i],
                                          'kd_memorial'       => $memorial,
                                     ]);
                    $cari_invoice = DB::table('invoice')
                                      ->where('i_nomor',$request->i_nomor[$i])
                                      ->first();
                    $hasil =  $cari_invoice->i_sisa_pelunasan - $request->i_bayar[$i];
                    // dd($hasil);

                    if ($hasil < 0) {
                        $hasil = 0;
                    }
                    
                    $update_invoice = DB::table('invoice')
                                        ->where('i_nomor',$request->i_nomor[$i])
                                        ->update([
                                            'i_sisa_pelunasan' => $hasil,
                                            'i_status'         => 'Approved',
                                        ]);
                }

            }

            for ($i=0; $i < count($request->b_akun); $i++) { 
                $save_biaya = DB::table('kwitansi_biaya_d')
                                 ->insert([
                                      'kb_id' => $k_id,
                                      'kb_dt'=> $i+1,
                                      'kb_kode_akun' => $request->b_akun[$i],
                                      'kb_kode_akun_acc' => $request->b_akun[$i],
                                      'kb_kode_akun_csf' => $request->b_akun[$i],
                                      'kb_jumlah' => $request->b_jumlah[$i],
                                      'kb_keterangan' => $request->b_keterangan[$i],
                                      'kb_debet'    => $request->b_debet[$i],
                                      'kb_kredit'    => $request->b_kredit[$i],
                                 ]);

            }

            for ($i=0; $i < count($request->m_um); $i++) { 
                $save_biaya = DB::table('kwitansi_uang_muka')
                                 ->insert([
                                      'ku_id' => $k_id,
                                      'ku_dt'=> $i+1,
                                      // 'ku_kode_akun' => $request->b_akun[$i],
                                      // 'ku_kode_akun_acc' => $request->b_akun[$i],
                                      // 'ku_kode_akun_csf' => $request->b_akun[$i],
                                      'ku_jumlah' => $request->jumlah_bayar_um[$i],
                                      'ku_keterangan' => $request->m_Keterangan_um[$i],
                                      'ku_kredit'    => $request->jumlah_bayar_um[$i],
                                      'ku_nomor_um'    => $request->m_um[$i],
                                      'ku_jenis'       => $request->m_status_um[$i]
                                 ]);

                $cari_um = DB::table('uang_muka_penjualan')
                                      ->where('nomor',$request->m_um[$i])
                                      ->first();
                $hasil_um =  $cari_um->sisa_uang_muka - $request->jumlah_bayar_um[$i];
                // dd($hasil);

                if ($hasil_um < 0) {
                    $hasil_um = 0;
                }
                
                $update_invoice = DB::table('uang_muka_penjualan')
                                    ->where('nomor',$request->m_um[$i])
                                    ->update([
                                        'sisa_uang_muka' => $hasil_um
                                    ]);


            }

            $memorial_array = array_sum($memorial_array);
            $save_kwitansi = DB::table('kwitansi')
                               ->where('k_id',$k_id)
                               ->update([
                                'k_jumlah_memorial' => $memorial_array
                               ]);

            return response()->json(['status'=>1,'pesan'=>'data berhasil disimpan']);

        }else{
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('y');

            $cari_nota = DB::select("SELECT  substring(max(k_nomor),11) as id from kwitansi
                                            WHERE k_kode_cabang = '$request->cb_cabang'
                                            AND to_char(k_tanggal,'MM') = '$bulan'
                                            AND to_char(k_tanggal,'YY') = '$tahun'");
            $index = (integer)$cari_nota[0]->id + 1;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota = 'KWT' . $request->cb_cabang . $bulan . $tahun . $index;

            return response()->json(['status'=>2,'pesan'=>'no nota telah ada','nota'=>$nota]);
        }
    });

    }
    public function cari_um(request $request)
    {
        $temp = DB::table('uang_muka_penjualan')
                  ->where('kode_customer',$request->cb_customer)
                  ->orWhere('status_um','NON CUSTOMER')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->where('sisa_uang_muka','!=',0)
                  ->where('nomor_posting','!=',null)
                  ->get();

        $temp1 = DB::table('uang_muka_penjualan')
                  ->where('kode_customer',$request->cb_customer)
                  ->orWhere('status_um','NON CUSTOMER')
                  ->where('kode_cabang',$request->cb_cabang)
                  ->where('sisa_uang_muka','!=',0)
                  ->where('nomor_posting','!=',null)
                  ->get();

        if (isset($request->simpan_um)) {
            for ($i=0; $i < count($temp1); $i++) { 
                for ($a=0; $a < count($request->simpan_um); $a++) { 
                    if ($request->simpan_um[$a] == $temp1[$i]->nomor) {
                        unset($temp[$i]);
                    }
                }
            }
            $temp = array_values($temp);
            $data = $temp;
            
        }else{
            $data = $temp;
        }

        return view('sales.penerimaan_penjualan.tabel_um',compact('data'));
    }
    public function pilih_um(request $request)
    {
        $data = DB::table('uang_muka_penjualan')
                   ->where('nomor',$request->um)
                   ->orWhere('status_um','=','NON CUSTOMER')
                   ->first();

        return response()->json(['data'=>$data]);
    }

}
