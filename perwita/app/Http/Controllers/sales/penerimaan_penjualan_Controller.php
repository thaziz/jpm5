<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


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

    public function index(){
        $sql = "    SELECT pp.*,c.nama customer FROM penerimaan_penjualan pp
                    LEFT JOIN customer c ON c.kode=pp.kode_customer ";
        $data =  DB::select($sql);
        return view('sales.penerimaan_penjualan.index',compact('data'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $kas_bank = DB::select(" SELECT kode,nama FROM akun WHERE jenis='KAS' OR jenis='BANK' ORDER BY nama ASC ");
        $akun_biaya = DB::select(" SELECT * FROM akun_biaya ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('penerimaan_penjualan')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM penerimaan_penjualan_d WHERE nomor_penerimaan_penjualan='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.penerimaan_penjualan.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','kas_bank','akun_biaya' ));
    }

    public function tampil_invoice(Request $request) {
        $customer = $request->kode_customer;
        $kode_cabang = $request->kode_cabang;
        $sql = "    SELECT nomor, tanggal, total_tagihan - jml_bayar_memorial sisa_tagihan,total_tagihan FROM invoice i where 
					total_tagihan > jml_bayar_memorial+(select COALESCE(SUM(debet-kredit),0) from nota_debet_kredit where nomor_invoice=i.nomor)
                    AND kode_customer='$customer' AND kode_cabang='$kode_cabang' ";

        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <input type="checkbox"  id="'.$data[$i]['nomor'].'" class="btnpilih" tabindex="-1" > ';         
            // // add new text
            // $data[$i]['jml_bayar'] = '  <input type="text"  id="ed_'.$data[$i]['nomor'].'" name="ed_jumlah_bayar[]" class="form-control angka" style="text-align:right">
            //                             <input type="hidden"  id="ed_bayar'.$data[$i]['nomor'].'" value="'.$data[$i]['sisa_tagihan'].'">
            //                             <input type="hidden"  name="ed_nomor_invoice[]" value="'.$data[$i]['nomor'].'" >
            //                             ';
            // add button info
            $data[$i]['btn_info'] = ' <button type="button" id="'.$data[$i]['nomor'].'" name="'.$data[$i]['nomor'].'" data-toggle="tooltip" title="Info" class="btn btn-success btn-xs btninfo" tabindex="-1"><i class="glyphicon glyphicon-info-sign"></i></button> '
                                ;
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);

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
        $head = collect(\DB::select(" SELECT c.*,p.* FROM penerimaan_penjualan p LEFT JOIN customer c ON c.kode=p.kode_customer WHERE p.nomor='$nomor' "))->first();

        $detail = DB::select("  SELECT d.nomor_invoice,d.jumlah,d.keterangan,i.tanggal,i.total_tagihan FROM penerimaan_penjualan_d d, invoice i
                                WHERE i.nomor=d.nomor_invoice AND d.nomor_penerimaan_penjualan='$nomor'
                                UNION ALL
                                SELECT NULL,d.jumlah,d.keterangan||'('||jenis||')',NULL,NULL FROM penerimaan_penjualan_biaya_d d, invoice i
                                WHERE i.nomor=d.nomor_invoice AND d.nomor_penerimaan_penjualan='$nomor'");
        $terbilang =$this->penyebut($head->jumlah);
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

}
