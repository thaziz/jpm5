<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;


class do_kargo_Controller extends Controller
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
        $data = array(
                    'nomor' => strtoupper($request->ed_nomor),
                    'tanggal' => $request->ed_tanggal,
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'pendapatan' => $request->pendapatan,
                    'type_kiriman' => $request->type_kiriman,
                    'jenis_pengiriman' => $request->jenis_kiriman,
                    'kode_tipe_angkutan' => $request->cb_tipe_angkutan,
                    'no_surat_jalan' => strtoupper($request->ed_surat_jalan),
                    'nopol' => strtoupper($request->cb_nopol),
                    'id_kendaraan' => strtoupper($request->ed_id_kendaraan),
                    'kode_subcon' => strtoupper($request->ed_kode_subcon),
                    'kode_cabang' => $request->cb_cabang,
                    'tarif_dasar' => filter_var($request->ed_tarif_dasar, FILTER_SANITIZE_NUMBER_INT),
                    'kode_customer' => $request->cb_customer,
                    'kode_marketing' => $request->cb_marketing,
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
                    'jenis' => 'KARGO',
                    'kontrak' => $request->ck_kontrak,
                    'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
                    //'uang_jalan' => filter_var($request->ed_uang_jalan, FILTER_SANITIZE_NUMBER_INT),
                    'status_kendaraan' => strtoupper($request->cb_status_kendaraan),
                    'driver' => strtoupper($request->ed_driver),
                    'co_driver' => strtoupper($request->ed_co_driver),
                    'jenis_tarif' => strtoupper($request->cb_jenis_tarif),
                    'ritase' => strtoupper($request->cb_ritase),
                    'awal_shutle' => strtoupper($request->ed_awal_shuttle),
                    'akhir_shutle' => strtoupper($request->ed_akhir_shuttle),
                    'nomor_do_awal' => strtoupper($request->ed_nomor_do_awal),
                    'tipe' => strtoupper($request->cb_tipe),
                    'kode_satuan' => strtoupper($request->ed_satuan),
                    //'total_net' => filter_var($request->ed_total_net, FILTER_SANITIZE_NUMBER_INT),
                    'acc_penjualan' => $request->acc_penjualan,
                );   
        
        if ($crud == 'N') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->cb_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM delivery_order WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' AND jenis='KARGO' 
                            AND nomor LIKE '%KGO".$kode_cabang.$tanggal."%' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='KGO'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='KGO'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number
            $simpan = DB::table('delivery_order')->insert($data);
        } elseif ($crud == 'E') {
            if ($request->ed_nomor_old != $request->ed_nomor) {
                $nomor = $request->ed_nomor_old;
            }else{
                $nomor = $request->ed_nomor;
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
        if ($cek_data_invoice->id !=NULL) {
            $pesan='Nomor DO '.$nomor.' sudah di pakai pada invoice';
            return view('sales.do_kargo.pesan',compact('pesan'));
        }else if ($cek_data_surat_jalan->id !=NULL) {
            $pesan='Nomor DO '.$nomor.' sudah di pakai pada surat jalan';
            return view('sales.do_kargo.pesan',compact('pesan'));
        }else{
            DB::beginTransaction();
            DB::table('delivery_orderd')->where('nomor' ,'=', $nomor)->delete();
            DB::table('delivery_order')->where('nomor' ,'=', $nomor)->delete();
            DB::commit();
            return redirect('sales/deliveryorderkargo');
        }
    }


    public function index(){
        $sql = "    SELECT d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan 
                    WHERE d.jenis='KARGO'
                    ORDER BY d.tanggal DESC LIMIT 1000 ";

        $do =  DB::select($sql);
        return view('sales.do_kargo.index',compact('do'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,tipe FROM customer ORDER BY nama ASC ");
        $kendaraan = DB::select("   SELECT k.id,k.nopol,k.tipe_angkutan,k.status,k.kode_subcon,s.nama FROM kendaraan k
                                    LEFT JOIN subcon s ON s.kode=k.kode_subcon ");
        $marketing = DB::select(" SELECT kode,nama FROM marketing ORDER BY nama ASC ");
        //$angkutan = DB::select(" SELECT kode,nama FROM angkutan ORDER BY nama ASC ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $tipe_angkutan =DB::select("SELECT kode,nama FROM tipe_angkutan");
        if ($nomor != null) {
            $do = DB::table('delivery_order')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM delivery_orderd WHERE nomor='$nomor' "))->first();
        }else{
            $do = null;
            $jml_detail = 0;
        }
        return view('sales.do_kargo.form',compact('kota','customer', 'kendaraan', 'marketing', 'outlet', 'do', 'jml_detail','cabang','tipe_angkutan' ));
    }
    
    public function form_update_status($nomor=null){
        if ($nomor != null) {
            // $do = DB::table('delivery_order')->where('nomor', $nomor)->first();
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
        $kontrak = $request->input('kontrak');
        $customer = strtoupper($request->input('customer'));
        $jenis_tarif = strtoupper($request->input('jenis_tarif'));
        $tipe_tarif = $request->input('tipe_tarif');
        $asal = $request->input('asal');
        $tujuan = $request->input('tujuan');
        $pendapatan =$request->input('pendapatan');
        $tipe = $request->input('tipe');
        $jenis = $request->input('jenis');
        $angkutan = $request->input('angkutan');
        $tipe_angkutan = $request->input('tipe_angkutan');
        $kode_cabang =$request->input('cabang');
        if ($kontrak == 'YA') {
            $sql= " SELECT d.harga, d.kode_satuan,d.acc_penjualan FROM kontrak k,kontrak_d d
                    WHERE k.nomor=d.nomor_kontrak AND k.aktif=TRUE 
                    AND d.id_kota_asal='$asal' AND d.id_kota_tujuan='$tujuan' AND k.kode_customer='$customer' 
                    AND d.jenis_tarif='$jenis_tarif' AND d.kode_angkutan='$tipe_angkutan' AND k.kode_cabang='$kode_cabang' ";
        }else{
            $sql = " SELECT harga,kode_satuan,acc_penjualan FROM tarif_cabang_kargo WHERE jenis='$jenis_tarif' AND id_kota_asal='$asal' AND id_kota_tujuan='$tujuan' AND kode_angkutan='$tipe_angkutan'  AND kode_cabang='$kode_cabang' ";
        } 
        
        $data = collect(DB::select($sql));
        $jumlah_data = $data->count();
        if ($jumlah_data > 0) {
            $harga = collect(\DB::select($sql))->first();
            if ($tipe = 'KARGO PAKET' or $tipe ='KARGO KERTAS') {
                $biaya_penerus = 0;
                $result['biaya_penerus'] = 0;
            } else{
                $biaya_penerus = 0;//collect(\DB::select($sql_biaya_penerus))->first();
                $result['biaya_penerus'] = number_format($biaya_penerus->harga, 0, ",", ".");
            }
            $result['harga'] = number_format($harga->harga, 0, ",", ".");
            $result['satuan'] = $harga->kode_satuan;
            $result['jumlah_data'] = $jumlah_data;
            $result['acc_penjualan']=$data[0]->acc_penjualan;
        }else{
            $harga = 0;
            $result['harga'] = 0;
            $result['biaya_penerus'] = 0;
            $result['jumlah_data'] = 0;
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
        //return $pdf->stream();
        return view('sales.do_kargo.print',compact('nota'));

    }

    public function cari_customer(Request $request){
        $id =$request->input('kode_customer');
        $data = DB::table('customer')->where('kode', $id)->first();
        return json_encode($data);
    }
    public function tampil_nopol(Request $request){
        $tipe_angkutan =$request->input('tipe_angkutan');
        $status_kendaraan =$request->input('status_kendaraan');
		$list = DB::select(DB::raw("SELECT id,nopol FROM kendaraan WHERE tipe_angkutan='$tipe_angkutan' AND status='$status_kendaraan' "));
		if ($list != NULL){
			$nopol = '<option class="B"></option>';
		}
		$nopol = NULL ; 
		foreach ($list as $row) {
			$nopol = $nopol.'<option value="'.$row->nopol.'" data-id="'.$row->id.'"  >  '.$row->nopol.' </option>';
		};        
        return json_encode($nopol);
		
	}	
}
