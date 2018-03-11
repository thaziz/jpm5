<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;
use App\master_akun;
use App\d_jurnal;
use App\d_jurnal_dt;


class invoice_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $pendapatan = strtoupper($request->input('pendapatan'));
		if ($pendapatan =='KORAN'){
			$sql = "   SELECT *,nomor_do ||'-'||id_do AS nomor FROM invoice_d WHERE nomor_invoice='$nomor'  ";
		}else{
			$sql = "   SELECT *,nomor_do AS nomor FROM invoice_d WHERE nomor_invoice='$nomor'  ";
		}
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

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('invoice')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('invoice_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $nomor = strtoupper($request->ed_nomor);
        $cek_data =DB::table('penerimaan_penjualan_d')->select('id')->where('nomor_invoice', $nomor)->first();
        if ($cek_data !=NULL) {
            $result['result']='3';
        }else{
            $simpan='';
            $crud = $request->crud_h;
            $nomor_old = strtoupper($request->ed_nomor_old);
            $data = array(
                    'nomor' => strtoupper($request->ed_nomor),
                    'tanggal' => strtoupper($request->ed_tanggal),
                    'jatuh_tempo' =>strtoupper($request->ed_jatuh_tempo),
                    'kode_customer' => strtoupper($request->ed_customer),
                    'type_kiriman' => strtoupper($request->ed_type_kiriman),
                    'pendapatan' => strtoupper($request->ed_pendapatan),
                    'keterangan' => strtoupper($request->ed_keterangan),
                    'jenis_ppn' => strtoupper($request->cb_jenis_ppn),
                    'kode_pajak' => strtoupper($request->cb_pajak),
                    // 'tgl_mulai_do' => strtoupper($request->ed_tanggal_mulai_do),
                    // 'tgl_sampai_do' => strtoupper($request->ed_tanggal_sampai_do),
                    'kode_cabang' => strtoupper($request->ed_cabang),
                    //'no_faktur_pajak' => strtoupper($request->ed_no_faktur_pajak),
                    'total' => filter_var($request->ed_total, FILTER_SANITIZE_NUMBER_INT), 
                    'diskon' => filter_var($request->ed_diskon, FILTER_SANITIZE_NUMBER_INT),
                    'netto' => filter_var($request->ed_netto, FILTER_SANITIZE_NUMBER_INT),
                    'pph' => filter_var($request->ed_pph, FILTER_SANITIZE_NUMBER_INT), 
                    'ppn' => filter_var($request->ed_ppn, FILTER_SANITIZE_NUMBER_INT), 
                    'total_tagihan' => filter_var($request->ed_total_tagihan, FILTER_SANITIZE_NUMBER_INT), 
                );

            if ($crud == 'N' and $nomor_old =='') {
                //auto number
                if ($data['nomor'] ==''){
                    $tanggal = strtoupper($request->ed_tanggal);
                    $kode_cabang = strtoupper($request->ed_cabang);
                    $tanggal = date_create($tanggal);
                    $tanggal = date_format($tanggal,'ym');
                    $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                                FROM invoice WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' ";
                    $list = collect(\DB::select($sql))->first();
                    if ($list->nomor == ''){
                        //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                        $data['nomor']='INV'.$kode_cabang.$tanggal.'00001';
                    } else{
                        $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                        $data['nomor']='INV'.$kode_cabang.$tanggal.$kode;
                    }
                }
                // end auto number
                $simpan = DB::table('invoice')->insert($data);

            } else {
                $simpan = DB::table('invoice')->where('nomor', $nomor_old)->update($data);
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
        }
        echo json_encode($result);
    }

    public function hapus_data($nomor_invoice=null){
        $cek_data =DB::table('penerimaan_penjualan_d')->select('id')->where('nomor_invoice', $nomor_invoice)->first();
		$cek_data1 =DB::table('nota_debet_kredit')->select('id')->where('nomor_invoice', $nomor_invoice)->first();
        $pesan ='';
        if ($cek_data !=NULL) {
            $pesan='Nomor invoice '.$nomor_invoice.' sudah di pakai pada penerimaan penjualan atau kwitansi';
            return view('sales.invoice.pesan',compact('pesan'));
		}else if ($cek_data1 !=NULL){
            $pesan='Nomor invoice '.$nomor_invoice.' sudah di pakai pada penerimaan nota debet kredit';
            return view('sales.invoice.pesan',compact('pesan'));
        }else{
            DB::beginTransaction();
            DB::table('invoice_d')->where('nomor_invoice' ,'=', $nomor_invoice)->delete();
            DB::table('invoice')->where('nomor' ,'=', $nomor_invoice)->delete();
            DB::commit();
            return redirect('sales/invoice');
        }
    }

    public function save_data_detail (Request $request) {
        return DB::transaction(function() use ($request) {  
        /*
        jenis ppn
        4= ppnrte="0" ppntpe="npkp"NON PPN
        1= ppnrte="10" ppntpe="pkp" >EXCLUDE 10 %
        2= ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %
        3= ppnrte="1" ppntpe="npkp" >INCLUDE 1 %
        5= ppnrte="10" ppntpe="npkp" >INCLUDE 10 %
        */
        $id_akun=[];
        $simpan='';
        $id_do=NULL;
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_do);
        $diskon = filter_var($request->diskon, FILTER_SANITIZE_NUMBER_INT);
        $jenis_ppn = strtoupper($request->jenis_ppn);
        $pendapatan = strtoupper($request->pendapatan);
        $type_kiriman = strtoupper($request->type_kiriman);
        $pajak = $request->pajak;
        $kode_satuan= NULL;
        $jumlah=1;
        $kuantum=NULL;
        for ($i=0; $i < $hitung; $i++) {
            $nomor_do = strtoupper($request->nomor_do[$i]);
            $sql = "    SELECT d.*, k.nama asal, kk.nama tujuan FROM delivery_order d
                        LEFT JOIN kota k ON k.id=d.id_kota_asal
                        LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan 
                        WHERE d.nomor='$nomor_do' ";
            if ($pendapatan == 'KORAN'){
                $posisi_ke=strpos($nomor_do,"-");
                $id_do= substr($nomor_do,$posisi_ke + 1);
                $nomor_do=substr($nomor_do,0,$posisi_ke);
                $sql = "    SELECT dd.*,d.nomor,d.tanggal FROM delivery_orderd dd,delivery_order d
                            WHERE  d.nomor=dd.nomor AND d.nomor='$nomor_do' AND dd.id='$id_do' ";
            }
            $data_do = collect(\DB::select($sql))->first();
            // if ($pendapatan == 'PAKET' or $pendapatan='KARGO'){
            //     if ($type_kiriman == 'KILOGRAM' or $type_kiriman == 'KOLI' or $type_kiriman == 'KORAN') {
            //         $tipe = $type_kiriman ;
            //         $harga_satuan = $data_do->total + $data_do->diskon;//round(($data_do->total + $data_do->diskon) / $data_do->berat);
            //         $harga_brutto = $data_do->total + $data_do->diskon;
            //         $keterangan = $data_do->asal.' KE '.$data_do->tujuan.' '.$data_do->tanggal ;
            //     } else if ($type_kiriman == 'DOKUMEN') {
            //         $tipe = 'DOKUMEN' ;
            //         $harga_satuan = $data_do->total + $data_do->diskon;
            //         $harga_brutto = $data_do->total + $data_do->diskon;
            //         $keterangan = $data_do->asal.' KE '.$data_do->tujuan.' '.$data_do->tanggal ;
            //     } else {
            //         $tipe = $type_kiriman ;
            //         $harga_satuan = $data_do->total + $data_do->diskon;
            //         $harga_brutto = $data_do->total + $data_do->diskon;
            //         if ($type_kiriman == 'KARGO PAKET' or $type_kiriman == 'KARGO KERTAS' ) {
            //             $keterangan = $data_do->asal.' KE '.$data_do->tujuan.' '.$data_do->nomor.' '.$data_do->nopol ;
            //         } else {
            //             $keterangan = $data_do->asal.' KE '.$data_do->tujuan.' '.$data_do->tanggal ;
            //         }
            //     }
            // }
            if ($pendapatan == 'PAKET'){
                $tipe = $type_kiriman ;
                $harga_satuan = $data_do->total;// + $data_do->diskon;
                $harga_brutto = $data_do->total;// + $data_do->diskon;
                $kuantum= $data_do->jumlah.' '.$data_do->kode_satuan;
                if ($type_kiriman == 'KILOGRAM' || $type_kiriman == 'KORAN') {
                    $kuantum= $data_do->jumlah.' '.$data_do->kode_satuan;
                }else if($type_kiriman == 'KOLI'){
                    $kuantum= $data_do->jumlah.' '.$data_do->kode_satuan;
                }else if ($type_kiriman == 'DOKUMEN'){
                    $kuantum= $data_do->kode_satuan;
                }
                $jumlah=$data_do->jumlah;
                $kode_satuan=$data_do->kode_satuan;
                $keterangan = $data_do->asal.' KE '.$data_do->tujuan.' '.$data_do->tanggal ;
            }else if ($pendapatan == 'KARGO'){
                if ($data_do->kontrak==TRUE){
                    $harga_satuan = $data_do->tarif_dasar;
                    $kuantum=$data_do->jumlah.' '.$data_do->kode_satuan;
                    $jumlah=$data_do->jumlah;
                    $kode_satuan=$data_do->kode_satuan;
                    $harga_brutto=$data_do->total;
                }else{
                    if ($data_do->diskon > 0){
                        $harga_satuan = $data_do->total;
                        $harga_brutto = $data_do->total;
                        $jumlah=$data_do->jumlah;
                        $kode_satuan=$data_do->kode_satuan;
                        $kuantum=$data_do->jumlah.' '.$data_do->kode_satuan;
                    }else{
                        $harga_satuan = $data_do->tarif_dasar;
                        $kuantum=$data_do->jumlah.' '.$data_do->kode_satuan;
                        $jumlah=$data_do->jumlah;
                        $kode_satuan=$data_do->kode_satuan;
                    }
                }
                $tipe = 'KARGO' ;
                $kode_satuan =$data_do->kode_satuan;
                $keterangan = $data_do->no_surat_jalan.' PENGIRIMAN KARGO DARI'.$data_do->asal.' KE '.$data_do->tujuan.' '.$data_do->tanggal ;
            }else if ($pendapatan == 'KORAN'){
                $tipe = 'KORAN' ;
                $jumlah = $data_do->jumlah;
                $kuantum = $jumlah.' '.$data_do->kode_satuan;
                $harga_satuan = $data_do->harga;
                $harga_brutto = $data_do->total + $data_do->diskon;
                $keterangan = $data_do->keterangan ;
                $kode_satuan =$data_do->kode_satuan;
            }
            
            $data = array(
                'nomor_invoice' => $nomor,
                'nomor_do' => $nomor_do,
                'tgl_do' => $data_do->tanggal,
                'harga_netto' => $data_do->total,
                'harga_satuan' => $harga_satuan,
                'harga_bruto' => $harga_brutto,
                'diskon' => $diskon,
                'keterangan' => $keterangan,
                'kuantum' => $kuantum,
                'jumlah' => $jumlah,
                'kode_satuan' => $kode_satuan,
                'tipe' => $tipe,
                'id_do' => $id_do,
                'acc_penjualan'=>$data_do->acc_penjualan,
            );  
            DB::table('invoice_d')->insert($data);
        } 
        $invoice_d = collect(\DB::select("  SELECT  COALESCE(SUM(harga_netto),0) ttl_harga_netto FROM invoice_d WHERE nomor_invoice='$nomor' "))->first();
        $invoiceLengkap = collect(\DB::select("  SELECT  COALESCE((harga_netto),0) netto,acc_penjualan FROM invoice_d WHERE nomor_invoice='$nomor' "));

        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM invoice_d WHERE nomor_invoice='$nomor' "))->first();
        $nilai_pajak = collect(\DB::select(" SELECT * FROM pajak WHERE kode='$pajak' "))->first();
        $netto = $invoice_d->ttl_harga_netto - $diskon; 
        $ppn=0; 
        if ($jenis_ppn == 1) {
            $ppn =round($invoice_d->ttl_harga_netto * 0.1);
        }elseif ($jenis_ppn == 2) {
            $ppn = round($invoice_d->ttl_harga_netto * 0.01);
        }elseif ($jenis_ppn == 4) {
            $ppn =0;
        }elseif ($jenis_ppn == 3) {
            $ppn = round(($invoice_d->ttl_harga_netto / 100.1)) ;
            $netto = $netto - $ppn;
        }elseif ($jenis_ppn == 5) {
            $ppn = round(($invoice_d->ttl_harga_netto / 10.1)) ;
            $netto = $netto - $ppn;
        }
        $pph =  round($netto * $nilai_pajak->nilai/100);
        $data_h = array(
            'total' => $invoice_d->ttl_harga_netto,
            'diskon' => $diskon,
            'netto' => $netto,
            'ppn' => $ppn,
            'pph' => $pph,
            'total_tagihan' => $ppn + $netto - $pph,
        );

        if($jenis_ppn==3){    

$jumlahPiutang= $ppn + $netto - $pph;  

}
//exclude
else if($jenis_ppn!=3){
    $jumlahPiutang= $ppn + $netto - $pph;      
}




$cabang=$request->cabang;
//dd($request->cabang);

$Nilaijurnal=[];    

$diskonItem=$diskon/count($invoiceLengkap);


foreach ($invoiceLengkap as $idx => $value) {
               $id_akun[$idx]['akunPendapatan']=$value->acc_penjualan;
               $id_akun[$idx]['subtotal']=$value->netto;
               $id_akun[$idx]['ppn']=$jenis_ppn;
               $id_akun[$idx]['pph']=$nilai_pajak->nilai;
               $id_akun[$idx]['diskon']=$diskonItem;
        }
    
$Nilaijurnal=$this->groupJurnal($id_akun);

$indexakun=0;
$totalPiutang=0;
$totalPPH=0;
$totalPPN=0;
$nilaiPendapatan=0;
//$cabang='C001';
//dd($request->all());


foreach ($Nilaijurnal as  $dataJurnal) {    
    if($jenis_ppn==3){    
            $nilaiPendapatan=$dataJurnal['subtotal']+$dataJurnal['diskon'];
        }
        else if($jenis_ppn!=3){
            $nilaiPendapatan=$dataJurnal['subtotal'];
        }
    
       $akunPendapatan=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$dataJurnal['akunPendapatan'].'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                  
                  
        if(count($akunPendapatan)!=0){
        $akun[$indexakun]['id_akun']=$akunPendapatan->id_akun;
        $akun[$indexakun]['value']=$nilaiPendapatan;
        $akun[$indexakun]['dk']='K';
        $indexakun++;      
        
        //$totalPiutang+=$dataJurnal['subtotal']-$dataJurnal['ppn'];

        $totalPPH+=round($dataJurnal['subtotal'],2)*round($nilai_pajak->nilai/100,2);
        $totalPPN+=$dataJurnal['ppn'] ;
        $totalPiutang+=($dataJurnal['subtotal']+$totalPPN-$totalPPH);
        
        //$totalPiutang+=$dataJurnal['subtotal']+$totalPPN-$totalPPH;
        
        
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Pendapatan Untuk Cabang Belum Tersedia'];
	    DB::rollback();
            return json_encode($dataInfo);
        }       
}      

//include
if($jenis_ppn==3){    
        $jumlahPiutang= $totalPiutang;      
        $ppn=$totalPPN;
        $pph=round($totalPPH,2);
        



}

//exclude
else if($jenis_ppn!=3){
    $jumlahPiutang= $ppn + $netto - $pph;      
}


        $akunPiutang=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$request->acc_piutang.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();   





        if(count($akunPiutang)!=0){
            
                $akun[$indexakun]['id_akun']=$akunPiutang->id_akun;
                $akun[$indexakun]['value']=$jumlahPiutang;
                $akun[$indexakun]['dk']='D';
                $indexakun++;               

        }

        else{
            
            $dataInfo=['status'=>'gagal','info'=>'Akun Piutang Untuk Cabang Belum Tersedia'];
	      DB::rollback();
            return json_encode($dataInfo);
        }         
    if($jenis_ppn!=4){
        //include 3
        //exclude 2
         $akunPPN=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '2301%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 
        if(count($akunPPN)!=0){

                $akun[$indexakun]['id_akun']=$akunPPN->id_akun;
                $akun[$indexakun]['value']=$ppn;
                $akun[$indexakun]['dk']='K';
                $indexakun++;
        }
        else{
            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
		DB::rollback();
                      return json_encode($dataInfo);
        } 
    }

    if($pajak!='T'){        
        $akunPPH=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '2305%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunPPH)!=0){            
                $akun[$indexakun]['id_akun']=$akunPPH->id_akun;
                $akun[$indexakun]['value']=$pph;                
                $akun[$indexakun]['dk']='D';
                $indexakun++;
            }                    
        else{            
            $dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
		DB::rollback();
                      return json_encode($dataInfo);
        } 
    }

    if($diskon!=0){
        $akunDiskon=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', '5298%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first(); 

        if(count($akunDiskon)!=0){
                $akun[$indexakun]['id_akun']=$akunDiskon->id_akun;
                $akun[$indexakun]['value']=$diskon;
                $akun[$indexakun]['dk']='D';
                $indexakun++;
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Diskon Untuk Cabang Belum Tersedia'];
		DB::rollback();
                      return json_encode($dataInfo);
        } 
    }


        



              $jurnal=d_jurnal::where('jr_ref',$nomor);

              if(count($jurnal->first())==0){
              $id_jurnal=d_jurnal::max('jr_id')+1;
                foreach ($akun as $key => $data) {   
                        $id_jrdt=$key;
                        $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                        $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                        $jurnal_dt[$key]['jrdt_acc']=$data['id_akun'];
                        $jurnal_dt[$key]['jrdt_value']=$data['value'];
                        $jurnal_dt[$key]['jrdt_statusdk']=$data['dk'];
                }
            d_jurnal::create([
                        'jr_id'=>$id_jurnal,
                        'jr_year'=> date('Y',strtotime($request->tgl)),
                        'jr_date'=> $request->tgl,
                        'jr_detail'=> 'INVOICE'.' '.$pendapatan,
                        'jr_ref'=> $nomor,
                        'jr_note'=> 'INVOICE',
                        ]);
            d_jurnal_dt::insert($jurnal_dt);
        }else{           
            $a=d_jurnal_dt::where('jrdt_jurnal',$jurnal->first()->jr_id);

            $a->delete(); 
            foreach ($akun as $key => $data) {            
                        $id_jrdt=$key;
                        $jurnal_dt[$key]['jrdt_jurnal']=$jurnal->first()->jr_id;
                        $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                       $jurnal_dt[$key]['jrdt_acc']=$data['id_akun'];
                        $jurnal_dt[$key]['jrdt_value']=$data['value'];
                        $jurnal_dt[$key]['jrdt_statusdk']=$data['dk'];
                }
            d_jurnal_dt::insert($jurnal_dt);
        }

            
          

        
           

            
        


        $simpan = DB::table('invoice')->where('nomor', $nomor)->update($data_h);
        $result['error']='';
        $result['result']=1;
        $result['jml_detail']=$jml_detail->jumlah;
        $result['total']=number_format($invoice_d->ttl_harga_netto, 0, ",", ".");
        $result['ppn']=number_format($ppn, 0, ",", ".");
        $result['pph']=$pph;
        $result['diskon']=number_format($diskon, 0, ",", ".");
        $result['netto']=number_format($netto);
        $result['total_tagihan']=number_format($ppn + $netto - $pph) ;
        echo json_encode($result);
    });
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor=$request->nomor;
        $cek_data =DB::table('penerimaan_penjualan_d')->select('id')->where('nomor_invoice', $nomor)->first();
        if ($cek_data !=NULL) {
            $result['result']='3';
        }else{
            $diskon = filter_var($request->diskon, FILTER_SANITIZE_NUMBER_INT);
            $jenis_ppn = strtoupper($request->jenis_ppn);
            $pajak = $request->pajak;
            $type_kiriman = strtoupper($request->type_kiriman);
            $hapus = DB::table('invoice_d')->where('id' ,'=', $id)->delete();
            $invoice_d = collect(\DB::select("  SELECT  COALESCE(SUM(harga_netto),0) ttl_harga_netto FROM invoice_d WHERE nomor_invoice='$nomor' "))->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM invoice_d WHERE nomor_invoice='$nomor' "))->first();
            $nilai_pajak = collect(\DB::select(" SELECT * FROM pajak WHERE kode='$pajak' "))->first();
            $netto = $invoice_d->ttl_harga_netto - $diskon; 
            $ppn=0;
            if ($jenis_ppn == 1) {
                $ppn =round($invoice_d->ttl_harga_netto * 0.1);
            }elseif ($jenis_ppn == 2) {
                $ppn = round($invoice_d->ttl_harga_netto * 0.01);
            }elseif ($jenis_ppn == 4) {
                $ppn =0;
            }elseif ($jenis_ppn == 3) {
                $ppn = round(($invoice_d->ttl_harga_netto / 100.1)) ;
                $netto = $netto - $ppn;
            }elseif ($jenis_ppn == 5) {
                $ppn = round(($invoice_d->ttl_harga_netto / 10.1)) ;
                $netto = $netto - $ppn;
            }
            $pph =  round($netto * $nilai_pajak->nilai/100);
            $data_h = array(
                'total' => $invoice_d->ttl_harga_netto,
                'diskon' => $diskon,
                'netto' => $netto,
                'ppn' => $ppn,
                'pph' => $pph,
                'total_tagihan' => $ppn + $netto - $pph,
            );
            $simpan = DB::table('invoice')->where('nomor', $nomor)->update($data_h);
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['total']=number_format($invoice_d->ttl_harga_netto, 0, ",", ".");
            $result['ppn']=number_format($ppn, 0, ",", ".");
            $result['pph']=$pph;
            $result['diskon']=number_format($diskon, 0, ",", ".");
            $result['netto']=number_format($netto);
            $result['total_tagihan']=number_format($ppn + $netto - $pph) ;
        }
        echo json_encode($result);
    }

    public function index(){
        $sql = "    SELECT i.*,c.nama customer FROM invoice i
                    LEFT JOIN customer c ON c.kode=i.kode_customer ";
        $data =  DB::select($sql);
        return view('sales.invoice.index',compact('data'));
    }

    public function form($nomor=null){
        $jurnal_dt=null;
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $customer = DB::select(" SELECT kode,nama,syarat_kredit FROM customer ORDER BY nama ASC ");
        $pajak = DB::select(" SELECT kode,nama,nilai FROM pajak ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('invoice')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM invoice_d WHERE nomor_invoice='$nomor' "))->first();
             $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$nomor')")); 

        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.invoice.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','pajak','jurnal_dt' ));
    }

    public function tampil_do(Request $request) {
        $customer = $request->kode_customer;
        $type_kiriman = $request->type_kiriman;
        $pendapatan = $request->pendapatan;
        $kode_cabang = $request->kode_cabang;
        $tgl_mulai_do = $request->tgl_mulai_do;
        $tgl_sampai_do = $request->tgl_sampai_do;
        if ($pendapatan == 'KORAN'){
            $sql = "    SELECT d.nomor ||'-'||dd.id AS nomor ,dd.id,d.nomor AS nomor_d, d.tanggal,dd.total
                        FROM delivery_order d, delivery_orderd dd
                        WHERE NOT EXISTS (SELECT * FROM invoice_d i WHERE d.nomor=i.nomor_do AND dd.id=i.id_do) 
                        AND dd.nomor=d.nomor AND d.kode_customer='$customer' AND d.jenis='$pendapatan' 
                        AND d.kode_cabang='$kode_cabang' AND d.tanggal BETWEEN '$tgl_mulai_do' AND '$tgl_sampai_do' ";
        }else if($pendapatan == 'KARGO'){
            $sql = "    SELECT d.nomor, d.tanggal,d.total
                        FROM delivery_order d
                        WHERE NOT EXISTS (SELECT * FROM invoice_d i WHERE d.nomor=i.nomor_do ) 
                        AND d.kode_customer='$customer' AND d.jenis='$pendapatan' 
                        AND d.kode_cabang='$kode_cabang' AND d.tanggal BETWEEN '$tgl_mulai_do' AND '$tgl_sampai_do' ";
        }else{
            $sql = "    SELECT d.nomor, d.tanggal,d.total
                        FROM delivery_order d
                        WHERE NOT EXISTS (SELECT * FROM invoice_d i WHERE d.nomor=i.nomor_do ) 
                        AND d.kode_customer='$customer' AND d.pendapatan = '$pendapatan' 
                        AND d.kode_cabang='$kode_cabang' AND d.tanggal BETWEEN '$tgl_mulai_do' AND '$tgl_sampai_do' ";
        }       

        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = '<input type="checkbox"  id="'.$data[$i]['nomor'].'" class="btnpilih" >';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function cetak_nota($nomor=null) {
        $head = collect(\DB::select(" SELECT c.*,i.* FROM invoice i LEFT JOIN customer c ON c.kode=i.kode_customer WHERE i.nomor='$nomor' "))->first();
		$pendapatan = $head->pendapatan;
		if ($pendapatan == 'KORAN'){
        	$detail = DB::select(" SELECT *,nomor_do ||'-'||id_do AS nomor FROM invoice_d d WHERE d.nomor_invoice='$nomor' ");
		}else{
        	$detail = DB::select(" SELECT *,nomor_do AS nomor FROM invoice_d d WHERE d.nomor_invoice='$nomor' ");
		}
        $terbilang = $this->penyebut($head->total_tagihan);
        return view('sales.invoice.print',compact('head','detail','terbilang'));
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

    public function groupJurnal($data) {
        $total=0;
        $ppn=0;        
        $groups = array();
        $key = 0;
        $c=0;
        foreach ($data as $item) {
            
            $key = $item['akunPendapatan'];
            if (!array_key_exists($key, $groups)) {
                if($item['ppn']!=3){                    
                $groups[$key] = array(                  
                    'akunPendapatan' => $item['akunPendapatan'],                    
                    'subtotal' => $item['subtotal'],
                    'diskon'   =>$item['diskon'],
                    'ppn'   =>$item['ppn'],
                );   
                }

                else if($item['ppn']==3){      
                    $total=round(($item['subtotal']-$item['diskon'])*100/101,2);
                    $ppn=round($total*1/100,2);                                                            
                    $groups[$key] = array(                  
                        'akunPendapatan' => $item['akunPendapatan'],                    
                        'subtotal' =>$total,
                        'diskon'   =>$item['diskon'],                    
                        'ppn'   =>$ppn,    
                    );  

                }   

                
                
            } else {
                if($item['ppn']!=3){
                    $groups[$key]['subtotal'] = 
                    $groups[$key]['subtotal'] + $item['subtotal'];   
                    $groups[$key]['diskon']  = $item['diskon'];                       
                }
                else if($item['ppn']==3){ 
                    $total=round(($item['subtotal']-$item['diskon'])*100/101,2);
                    $ppn=round($total*1/100,2);                                        
                    $groups[$key]['subtotal'] = $groups[$key]['subtotal'] + $total;    
                    $groups[$key]['diskon']  =$groups[$key]['diskon']+ $item['diskon'];
                    $groups[$key]['ppn']  = $groups[$key]['ppn']+$ppn;
                }      
            }
            $key++;
        }                
        return $groups;
    }
    

    public function ppn($jenis_ppn,$subtotal){
        
        if ($jenis_ppn == 1) {            
            $ppn =round($subtotal * 0.1,2);
        }elseif ($jenis_ppn == 2) {            
            $ppn = round($subtotal * 0.01,2);
        }elseif ($jenis_ppn == 4) {            
            $ppn =0;
        }elseif ($jenis_ppn == 3) {                                    
            $ppn = round(($subtotal*1/100),2);                      
        }elseif ($jenis_ppn == 5) {            
            $ppn = round(($subtotal/ 10.1),2) ;
            
        }
        return $ppn;
    }

 public function jurnal($nomor=null){
        $jurnal_dt=null;
            
             $jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$nomor')")); 


        return view('sales.invoice.jurnal',compact('nomor','jurnal_dt'));
    }
    
    
    

}
