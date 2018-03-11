<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\master_akun;
Use App\d_jurnal;
Use App\d_jurnal_dt;
use PDF;


class do_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT d.id, d.kode_item, i.nama,d.jumlah, d.satuan, d.keterangan, d.total, d.harga, d.nomor_so FROM delivery_orderd d,item i
                    WHERE i.kode=d.kode_item AND d.nomor='$nomor' ";

        $list = DB::select($sql);
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function table_data_item () {
        $list = DB::select(DB::raw(" SELECT kode,nama,kode_satuan FROM item "));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Pilih" class="btn btn-warning btn-xs btnpilih" ><i class="glyphicon glyphicon-ok"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_item (Request $request) {
        $id =$request->input('id');
        $data = DB::select(" SELECT kode,nama,kode_satuan,harga FROM item WHERE kode='$id' ");
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('delivery_orderd')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function jumlah_data_detail (Request $request) {
        $nomor =$request->input('nomor');
        $sql = "SELECT COUNT(id) jumlah FROM delivery_orderd  WHERE nomor='$nomor' ";
        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        return DB::transaction(function() use ($request) {              
        $simpan='';
        $crud = $request->crud_h;
        $kota_asal = $request->cb_kota_asal;
        $jumlah=1;
        if ( $request->type_kiriman == 'KILOGRAM' || $request->type_kiriman == 'KERTAS') {
            $jumlah=filter_var($request->ed_berat, FILTER_SANITIZE_NUMBER_INT);
            $kode_satuan='KG';
        }else if($request->type_kiriman == 'KOLI'){
            $jumlah=filter_var($request->ed_koli, FILTER_SANITIZE_NUMBER_INT);
            $kode_satuan='KOLI';
        }else if($request->type_kiriman == 'KARGO PAKET' || $request->type_kiriman == 'KARGO KERTAS'){
            $kode_satuan='KARGO';
        } else if($request->type_kiriman == 'DOKUMEN'){
            $kode_satuan='DOKUMEN';
        }

        if($request->acc_penjualan==''){            
            $dataInfo=['status'=>'gagal','info'=>'Akun Pada Master Item Belum Ada Atau Pencarian Harga Belum Di Lakukan'];
            return json_encode($dataInfo);
        }
        $data = array(
                    'nomor' => strtoupper($request->ed_nomor),
                    'tanggal' => $request->ed_tanggal,
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'pendapatan' => $request->pendapatan,
                    'type_kiriman' => $request->type_kiriman,
                    'jenis_pengiriman' => $request->jenis_kiriman,
                    'kode_tipe_angkutan' => $request->cb_angkutan,
                    'no_surat_jalan' => strtoupper($request->ed_surat_jalan),
                    'nopol' => strtoupper($request->cb_nopol),
                    'lebar' => filter_var($request->ed_lebar, FILTER_SANITIZE_NUMBER_INT),
                    'panjang' => filter_var($request->ed_panjang, FILTER_SANITIZE_NUMBER_INT),
                    'tinggi' => filter_var($request->ed_tinggi, FILTER_SANITIZE_NUMBER_INT),
                    'berat' => filter_var($request->ed_berat, FILTER_SANITIZE_NUMBER_INT),
                    'koli' => strtoupper($request->ed_koli),
                    'kode_outlet' => $request->cb_outlet,
                    'kode_cabang' => $request->cb_cabang,
                    'tarif_dasar' => filter_var($request->ed_tarif_dasar, FILTER_SANITIZE_NUMBER_INT),
                    'tarif_penerus' => filter_var($request->ed_tarif_penerus, FILTER_SANITIZE_NUMBER_INT),
                    'biaya_tambahan' => filter_var($request->ed_biaya_tambahan, FILTER_SANITIZE_NUMBER_INT),
                    'biaya_komisi' => filter_var($request->ed_biaya_komisi, FILTER_SANITIZE_NUMBER_INT),
                    'kode_customer' => $request->cb_customer,
                    'kode_marketing' => $request->cb_marketing,
                    'ppn' => $request->ck_ppn,
                    'company_name_pengirim' => strtoupper($request->ed_company_name_pengirim),
                    'nama_pengirim' => strtoupper($request->ed_nama_pengirim),
                    'alamat_pengirim' => strtoupper($request->ed_alamat_pengirim),
                    'kode_pos_pengirim' => strtoupper($request->ed_kode_pos_pengirim),
                    'telpon_pengirim' => strtoupper($request->ed_telpon_pengirim),
                    'company_name_penerima' => strtoupper($request->ed_company_name_penerima),
                    'nama_penerima' => strtoupper($request->ed_nama_penerima),
                    'alamat_penerima' => strtoupper($request->ed_alamat_penerima),
                    'kode_pos_penerima' => strtoupper($request->ed_kode_pos_penerima),
                    'telpon_penerima' => strtoupper($request->ed_telpon_penerima),
                    'instruksi' => strtoupper($request->ed_instruksi),
                    'deskripsi' => strtoupper($request->ed_deskripsi),
                    'jenis_pembayaran' => strtoupper($request->cb_jenis_pembayaran),
                    'total' => filter_var($request->ed_total_h, FILTER_SANITIZE_NUMBER_INT),
                    'diskon' => filter_var($request->ed_diskon_h, FILTER_SANITIZE_NUMBER_INT),
                    'jenis' => 'PAKET',
                    'kode_satuan' =>$kode_satuan,
                    'jumlah' => $jumlah,
					'jenis_ppn' => $request->cb_jenis_ppn,
                    'acc_penjualan'=>$request->acc_penjualan,
                    
                    //'total_net' => filter_var($request->ed_total_net, FILTER_SANITIZE_NUMBER_INT),
                );
         $totalJurnal=$this->formatRP($request->ed_tarif_dasar) + $this->formatRP($request->ed_tarif_penerus)+ $this->formatRP($request->ed_biaya_tambahan) - $this->formatRP($request->ed_diskon_h) + $this->formatRP($request->ed_biaya_komisi) ;    

        if ($crud == 'N') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->cb_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM delivery_order WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' AND jenis='PAKET' 
                            AND nomor LIKE '%PAK".$kode_cabang.$tanggal."%' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='PAK'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='PAK'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number

             if($request->cb_customer=='CS/001'){
            //$cabang=substr($request->cb_cabang,1);
            $valueJurnal= filter_var($request->ed_total_h, FILTER_SANITIZE_NUMBER_INT);

            $cabang=$request->cb_cabang;
            $akunKas=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '1003%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();

            $akunDana=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '%2001%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                              

                    

           


                  
                if(count($akunKas)==0 ){
                    $dataInfo=['status'=>'gagal','info'=>'Akun Kas Untuk Cabang Belum Tersedia'];
                    return json_encode($dataInfo);

                }
                else if(count($akunDana)==0){
                    $dataInfo=['status'=>'gagal','info'=>'Akun Dana Untuk Cabang Belum Tersedia'];
                    return json_encode($dataInfo);
                }
                
                
                $akun[0]['id_akun']=$akunKas->id_akun;
                $akun[0]['value']=$valueJurnal;
                $akun[0]['dk']='D';
                

                $akun[1]['id_akun']=$akunDana->id_akun;
                $akun[1]['value']=$valueJurnal;
                $akun[1]['dk']='K';


               
                
                $nomor=$data['nomor'];
              
                $id_jurnal=d_jurnal::max('jr_id')+1;
                foreach ($akun as $key => $detailData) {                            
                                $id_jrdt=$key;
                                $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                                $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                                $jurnal_dt[$key]['jrdt_acc']=$detailData['id_akun'];
                                $jurnal_dt[$key]['jrdt_value']=$detailData['value'];
                                $jurnal_dt[$key]['jrdt_statusdk']=$detailData['dk'];
                }

                d_jurnal::create([
                                'jr_id'=>$id_jurnal,
                                'jr_year'=> date('Y',strtotime($request->ed_tanggal)),
                                'jr_date'=> date('Y-m-d',strtotime($request->ed_tanggal)),
                                'jr_detail'=> 'DELIVERY ORDER'.' '.$request->type_kiriman,
                                'jr_ref'=> $nomor,
                                'jr_note'=> 'DELIVERY ORDER',
                                ]);
                    d_jurnal_dt::insert($jurnal_dt);
                
              }




            $simpan = DB::table('delivery_order')->insert($data);
        } elseif ($crud == 'E') {
            if ($request->ed_nomor_old != $request->ed_nomor) {
                $nomor = $request->ed_nomor_old;
            }else{
                $nomor = $request->ed_nomor;
            }



             if($request->cb_customer=='CS/001'){
            //$cabang=substr($request->cb_cabang,1);
            $valueJurnal= filter_var($request->ed_total_h, FILTER_SANITIZE_NUMBER_INT);

            $cabang=$request->cb_cabang;
            $akunKas=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '1003%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();

            $akunDana=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '%2001%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                              

                    

           


                  
                if(count($akunKas)==0 ){
                    $dataInfo=['status'=>'gagal','info'=>'Akun Kas Untuk Cabang Belum Tersedia'];
                    return json_encode($dataInfo);

                }
                else if(count($akunDana)==0){
                    $dataInfo=['status'=>'gagal','info'=>'Akun Dana Untuk Cabang Belum Tersedia'];
                    return json_encode($dataInfo);
                }
                
                
                $akun[0]['id_akun']=$akunKas->id_akun;
                $akun[0]['value']=$valueJurnal;
                $akun[0]['dk']='D';
                

                $akun[1]['id_akun']=$akunDana->id_akun;
                $akun[1]['value']=$valueJurnal;
                $akun[1]['dk']='K';


               
                
                    $nomor=$nomor;
                    $jurnal=d_jurnal::where('jr_ref',$nomor);

                    if(count($jurnal->first())==0){
                        $id_jurnal=d_jurnal::max('jr_id')+1;
                        foreach ($akun as $key => $detailData) {                            
                                $id_jrdt=$key;
                                $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                                $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                                $jurnal_dt[$key]['jrdt_acc']=$detailData['id_akun'];
                                $jurnal_dt[$key]['jrdt_value']=$detailData['value'];
                                $jurnal_dt[$key]['jrdt_statusdk']=$detailData['dk'];
                        }

                        d_jurnal::create([
                                    'jr_id'=>$id_jurnal,
                                    'jr_year'=> date('Y',strtotime($request->ed_tanggal)),
                                    'jr_date'=> date('Y-m-d',strtotime($request->ed_tanggal)),
                                    'jr_detail'=> 'DELIVERY ORDER'.' '.$request->type_kiriman,
                                    'jr_ref'=> $nomor,
                                    'jr_note'=> 'DELIVERY ORDER',
                                    ]);
                        d_jurnal_dt::insert($jurnal_dt);

                    }
                    else{
                    $deleteJurnal=d_jurnal_dt::where('jrdt_jurnal',$jurnal->first()->jr_id);
                    $deleteJurnal->delete(); 
                    foreach ($akun as $key => $detailData) {            
                                $id_jrdt=$key;
                                $jurnal_dt[$key]['jrdt_jurnal']=$jurnal->first()->jr_id;
                                $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                               $jurnal_dt[$key]['jrdt_acc']=$detailData['id_akun'];
                                $jurnal_dt[$key]['jrdt_value']=$detailData['value'];
                                $jurnal_dt[$key]['jrdt_statusdk']=$detailData['dk'];
                        }
                    d_jurnal_dt::insert($jurnal_dt);
                    }
              

              
                
              }

              if($request->cb_customer!='CS/001'){
                    $jurnal=d_jurnal::where('jr_ref',$nomor)->first();
                        if(count($jurnal)!=0)
                        $jurnal->delete();
              }


            $simpan = DB::table('delivery_order')->where('nomor', $nomor)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    });
    }

    public function save_data_detail (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor_d),
                'nomor_so' => strtoupper($request->ed_so),
                'kode_item' => strtoupper($request->ed_kode_item),
                'kode_angkutan' => $request->cb_angkutan,
                'no_surat_jalan' => strtoupper($request->ed_surat_jalan),
                'nopol' => strtoupper($request->cb_nopol),
                'lebar' => filter_var($request->ed_lebar, FILTER_SANITIZE_NUMBER_INT),
                'panjang' => filter_var($request->ed_panjang, FILTER_SANITIZE_NUMBER_INT),
                'tinggi' => filter_var($request->ed_tinggi, FILTER_SANITIZE_NUMBER_INT),
                'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
                'satuan' => strtoupper($request->ed_satuan),
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'biaya_penerus' => filter_var($request->ed_biaya_penerus, FILTER_SANITIZE_NUMBER_INT),
                'diskon' => filter_var($request->ed_diskon, FILTER_SANITIZE_NUMBER_INT),
                'total' => filter_var($request->ed_total_harga, FILTER_SANITIZE_NUMBER_INT),
                'keterangan' => strtoupper($request->ed_keterangan),
            );

        if ($crud == 'N') {
            $simpan = DB::table('delivery_orderd')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('delivery_orderd')->where('id', $request->ed_id)->update($data);
        }
        $nomor = strtoupper($request->ed_nomor_d);
        $total = DB::select("SELECT  SUM(total + diskon) total,SUM(diskon) diskon, SUM(total) total_net FROM delivery_orderd WHERE nomor='$nomor' ");
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['total']=$total;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor = strtoupper($request->nomor);
        $hapus = DB::table('delivery_orderd')->where('id' ,'=', $id)->delete();
        $jml_detail = DB::select("SELECT COUNT(id) jumlah FROM delivery_orderd WHERE nomor='$nomor' ");
        $total = DB::select("SELECT  SUM(total + diskon) total,SUM(diskon) diskon, SUM(total - diskon) total_net FROM delivery_orderd WHERE nomor='$nomor' ");
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail;
            $result['total']=$total;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function hapus_data($nomor=null){
        $cek_data_invoice =DB::table('invoice_d')->select('id')->where('nomor_do', $nomor)->first();
        $cek_data_surat_jalan =DB::table('surat_jalan_trayek_d')->select('id')->where('nomor_do', $nomor)->first();
        $pesan ='';
        if ($cek_data_invoice !=NULL) {
            $pesan='Nomor DO '.$nomor.' sudah di pakai pada invoice';
            return view('sales.do.pesan',compact('pesan'));
        }else if ($cek_data_surat_jalan !=NULL) {
            $pesan='Nomor DO '.$nomor.' sudah di pakai pada surat jalan';
            return view('sales.do.pesan',compact('pesan'));
        }else{
            DB::beginTransaction();
            DB::table('delivery_orderd')->where('nomor' ,'=', $nomor)->delete();
            DB::table('delivery_order')->where('nomor' ,'=', $nomor)->delete();
            d_jurnal::where('jr_ref',$nomor)->delete();
            DB::commit();
            return redirect('sales/deliveryorder');
        }
        
    }


    public function index(){
        $sql = "    SELECT d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan 
                    WHERE d.jenis='PAKET'
                    ORDER BY d.tanggal DESC LIMIT 1000 ";

        $do =  DB::select($sql);
        return view('sales.do.index',compact('do'));
    }

    public function form($nomor=null){
        $jurnal_dt=null;
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,alamat,telpon FROM customer ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT nopol FROM kendaraan ");
        $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
        $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        if ($nomor != null) {
            $do = DB::table('delivery_order')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM delivery_orderd WHERE nomor='$nomor' "))->first();

             $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$nomor')")); 

        }else{
            $do = null;
            $jml_detail = 0;
        }
        return view('sales.do.form',compact('kota','customer', 'kendaraan', 'marketing', 'angkutan', 'outlet', 'do', 'jml_detail','cabang','jurnal_dt' ));
    }
    
    public function form_update_status($nomor=null){
        if ($nomor != null) {
            $do = DB::table('delivery_order')->where('nomor', $nomor)->first();
        }else{
            $do = null;
        }
        return view('sales.do.update_status',compact('do'));
    }
    
    public function save_update_status (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'status' => strtoupper($request->cb_status),
                'id_penerima' => strtoupper($request->ed_id_penerima),
                'catatan_admin' => strtoupper($request->ed_catatan_admin),
            );
        $simpan = DB::table('delivery_order')->where('nomor', $request->ed_nomor)->update($data);
        if($simpan == TRUE){
            return redirect('sales/deliveryorder');
        }
    }

    public function cari_harga(Request $request){
        $asal = $request->input('asal');
        $tujuan = $request->input('tujuan');
        $pendapatan =$request->input('pendapatan');
        $tipe = $request->input('tipe');
        $jenis = $request->input('jenis');
        $angkutan = $request->input('angkutan');
        $cabang = $request->input('cabang');
        if ($tipe == 'DOKUMEN') {
            $sql = " SELECT harga,acc_penjualan FROM tarif_cabang_dokumen WHERE jenis='$jenis' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' ";

            $sql_biaya_penerus = " SELECT harga FROM tarif_penerus_default WHERE jenis='$jenis' AND tipe_kiriman='$tipe' AND kode_cabang='$cabang' ";
        } else if ($tipe == 'KARGO PAKET' or $tipe == 'KARGO KERTAS') {
            $sql = " SELECT harga,acc_penjualan FROM tarif_cabang_kargo WHERE jenis='$jenis' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' AND kode_angkutan='$angkutan' AND kode_cabang='$cabang' ";
        } else if ($tipe == 'KILOGRAM') {
            $berat = $request->input('berat');
            if ($berat <= 10) {
                $keterangan = 'TARIF 0 KG SAMPAI 10 KG';
            } else if ($berat > 10 and $berat <= 20) {
                $keterangan = 'TARIF 10 KG SAMPAI 20 KG';
            } else if ($berat > 20) {
                $keterangan = 'TARIF DI ATAS 20 KG';
            }
            $sql = " SELECT harga,acc_penjualan FROM tarif_cabang_kilogram WHERE jenis='$jenis' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' AND keterangan='$keterangan'  AND kode_cabang='$cabang' ";
            $sql_biaya_penerus = " SELECT harga FROM tarif_penerus_default WHERE jenis='$jenis' AND tipe_kiriman='$tipe' AND keterangan='$keterangan' ";
        } else if ($tipe == 'KOLI') {
            $berat = $request->input('berat');
            if ($berat <= 10) {
                $keterangan = 'TARIF 0 KG SAMPAI 10 KG';
            } else if ($berat > 10 and $berat <= 20) {
                $keterangan = 'TARIF 10 KG SAMPAI 20 KG';
            } else if ($berat > 20 and $berat <= 30) {
                $keterangan = 'TARIF 20 KG SAMPAI 30 KG';
            } else if ($berat > 30) {
                $keterangan = 'TARIF DI ATAS 30 KG';
            }
            $sql = " SELECT harga,acc_penjualan FROM tarif_cabang_koli WHERE jenis='$jenis' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' AND keterangan='$keterangan' AND kode_cabang='$cabang' ";
            $sql_biaya_penerus = " SELECT harga FROM tarif_penerus_default WHERE jenis='$jenis' AND tipe_kiriman='$tipe' AND keterangan='$keterangan' ";
        }else if ($tipe == 'KERTAS') {
            $berat = filter_var($request->input('berat'), FILTER_SANITIZE_NUMBER_INT);
            $sql = " SELECT (harga * '$berat') harga FROM tarif_cabang_kilogram WHERE jenis='$jenis' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' ";
        }
        $data = collect(DB::select($sql));
        $jumlah_data = $data->count();
        if ($jumlah_data > 0) {
            $harga = collect(\DB::select($sql))->first();
            if ($tipe = 'KARGO PAKET' or $tipe ='KARGO KERTAS') {
                $biaya_penerus = 0;
                $result['biaya_penerus'] = 0;
            } else{
                $biaya_penerus = collect(\DB::select($sql_biaya_penerus))->first();
                $result['biaya_penerus'] = number_format($biaya_penerus->harga, 0, ",", ".");
            }
            $result['harga'] = number_format($harga->harga, 0, ",", ".");
            
            $result['jumlah_data'] = $jumlah_data;
            $result['acc_penjualan']=$data[0]->acc_penjualan;
        }else{
            $harga = 0;
            $result['harga'] = 0;
            $result['biaya_penerus'] = 0;
            $result['jumlah_data'] = 0;
            $result['acc_penjualan']=$data[0]->acc_penjualan;
        }

        
        return json_encode($result);
    }
    
    public function cetak_nota($nomor=null) {
        $sql= " SELECT d.*,k.nama asal, kk.nama tujuan, (d.panjang * d.lebar * d.tinggi) dimensi FROM delivery_order d
                LEFT JOIN kota k ON k.id=d.id_kota_asal
                LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
                WHERE nomor='$nomor' ";
        $nota =  collect(\DB::select($sql))->first();
        //$pdf = PDF::loadView('sales.do.nota',compact('nota'))->setPaper('a4', 'potrait');
        return view('sales.do.print',compact('nota'));
        //return view('sales.do.nota',compact('nota'));
    	//return $pdf->stream();
    }

    public function cari_customer(Request $request){
        $id =$request->input('kode_customer');
        $data = DB::table('customer')->where('kode', $id)->first();
        return json_encode($data);
    }

    public function formatRP($nilai){
        $nilai = str_replace(['Rp', '\\', '.', ' '], '', $nilai);        
        $nilai = str_replace(',', '.', $nilai);
        return (float)$nilai;

    }
}
