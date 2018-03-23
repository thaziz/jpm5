<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class do_kertas_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT dd_id,dd_kode_item,nama,d.dd_kode_satuan,dd_jumlah,d.dd_harga,dd_diskon,dd_total,d.dd_keterangan FROM delivery_orderd d,item i
                    WHERE i.kode=d.dd_kode_item AND d.dd_nomor='$nomor' 
					UNION ALL
         			SELECT i.id,dd_kode_item,i.keterangan nama,d.dd_kode_satuan,dd_jumlah,d.dd_harga,dd_diskon,dd_total,d.dd_keterangan FROM delivery_orderd d,kontrak_d i
                    WHERE i.kode=d.dd_kode_item AND d.dd_nomor='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['dd_id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['dd_id'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('nomor');
        $data = DB::table('delivery_order')->where('nomor', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $nomor = $request->input('nomor');
        $data = DB::table('delivery_orderd')
                    ->where([
                        ['dd_id', '=', $id],
                        ['dd_nomor', '=', $nomor],
                        ])
                    ->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $nomor_old = $request->ed_nomor_old;
        $tampil = $request->ed_tampil;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'tanggal' => strtoupper($request->ed_tanggal),
                'kode_customer' => strtoupper($request->ed_kode_customer),
                'kode_cabang' => strtoupper($request->ed_cabang),
                'jenis' => 'KORAN',
            );

        if ($crud == 'N' and $nomor_old =='') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->cb_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM delivery_order WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' AND jenis='KORAN' 
                            AND nomor LIKE '%KTS".$kode_cabang.$tanggal."%' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='KTS'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='KTS'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number
            $simpan = DB::table('delivery_order')->insert($data);
        } else {
            $simpan = DB::table('delivery_order')->where('nomor', $nomor_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['nomor']=$data['nomor'];
			$item = '<option value=""></option>';
			if ($tampil == 'Y'){
				$customer=$request->cb_customer;
				$sql = " 	SELECT * FROM kontrak k,kontrak_d kd
							WHERE k.nomor=kd.nomor_kontrak AND k.aktif=TRUE AND kd.jenis='KORAN'
							AND k.kode_customer='$customer' " ; 
                $list = DB::select(DB::raw($sql));
               	if ($list !=NULL){ 
					foreach ($list as $row) {
						$item = $item.'<option value="'.$row->kode.'" data-harga="'.number_format($row->harga, 0, ",", ".").'" data-satuan="'.$row->kode_satuan.'"  data-acc="'.$row->acc_penjualan.'" >  '.$row->keterangan.' </option>';
					};        
				$item = $item.'</select>';
				}else{
					$list = DB::select(" SELECT kode,nama,harga,kode_satuan,acc_penjualan FROM item ORDER BY nama ASC ");
					foreach ($list as $row) {
						$item = $item.'<option value="'.$row->kode.'" data-harga="'.number_format($row->harga, 0, ",", ".").'" data-satuan="'.$row->kode_satuan.'" data-acc="'.$row->acc_penjualan.'" >  '.$row->nama.' </option>';
					};        
				}
			}
			$result['item']=$item;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data($nomor_delivery_order=null){
        DB::beginTransaction();
        DB::table('delivery_orderd')->where('dd_nomor' ,'=', $nomor_delivery_order)->delete();
        DB::table('delivery_order')->where('nomor' ,'=', $nomor_delivery_order)->delete();
        DB::commit();
        return redirect('sales/deliveryorderkertas');
    }

    public function save_data_detail (Request $request) {
        // dd($request->all());
        $simpan='';
		$crud = $request->crud;
		$id_old = $request->ed_id_old;
        $cari_dt = DB::table('delivery_orderd')
                     ->where('dd_nomor',strtoupper($request->ed_nomor_do))
                     ->max('dd_nomor_dt');
        if ($cari_dt == null) {
            $cari_dt = 1;
        }else{
            $cari_dt +=1;
        }

        $cari_id = DB::table('delivery_orderd')
                     ->max('dd_id');
        if ($cari_id == null) {
            $cari_id = 1;
        }else{
            $cari_id +=1;
        }
        // return $cari_dt;
        $nomor = strtoupper($request->ed_nomor_do);
        $hitung = count($request->nomor_do);
        $data = array(
            'dd_nomor' => strtoupper($request->ed_nomor_do),
            'dd_nomor_dt' => $cari_dt,
            'dd_kode_item' => strtoupper($request->cb_item),
            'dd_kode_satuan' => strtoupper($request->ed_satuan),
            'dd_jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
            'dd_harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
            'dd_diskon' => filter_var($request->ed_diskon, FILTER_SANITIZE_NUMBER_INT),
            'dd_total' => filter_var($request->ed_total, FILTER_SANITIZE_NUMBER_INT),
            'dd_id_kota_asal' => $request->cb_kota_asal,
            'dd_id_kota_tujuan' => $request->cb_kota_tujuan,
            'dd_keterangan' => strtoupper($request->ed_keterangan),
            'dd_acc_penjualan'=>strtoupper($request->acc_penjualan),
        );
        if ($crud == 'N') {            

			$data['dd_id'] = $cari_id;
			$simpan = DB::table('delivery_orderd')->insert($data);
        }elseif ($crud == 'E') {
            
            $simpan = DB::table('delivery_orderd')
                        ->where([
                                    ['id', '=', $id_old],
                                    ['nomor', '=', $request->ed_nomor_do],
                                ])
                        ->update($data);
        }
        $jml_detail = collect(\DB::select(" SELECT COUNT(dd_id) dd_jumlah FROM delivery_orderd WHERE dd_nomor='$nomor' "))->first();
        $total = collect(\DB::select(" SELECT COALESCE(SUM(dd_diskon),0) ttl_diskon,COALESCE(SUM(dd_total),0) dd_total FROM delivery_orderd WHERE dd_nomor='$nomor' "))->first();
        $data_h = array(
            'nomor' => $nomor,
            'total' => $total->dd_total,
            'diskon' =>$total->ttl_diskon,
        );
        DB::table('delivery_order')->where('nomor', $nomor)->update($data_h);
        $result['error']='';
        $result['result']=1;
        $result['jml_detail']=$jml_detail->dd_jumlah;
        $result['total']=number_format($total->dd_total, 0, ",", ".");
        $result['diskon']=number_format($total->ttl_diskon, 0, ",", ".");
        echo json_encode($result);
    }


    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $nomor = strtoupper($request->nomor);
        $hapus = DB::table('delivery_orderd')
                    ->where([
                                ['dd_id', '=', $id],
                                ['dd_nomor', '=', $nomor],
                            ])
                    ->delete();
        $total = collect(\DB::select(" SELECT COALESCE(SUM(dd_diskon),0) ttl_diskon,COALESCE(SUM(dd_total),0) total FROM delivery_orderd WHERE dd_nomor='$nomor' "))->first();
        $data_h = array(
            'nomor' => $nomor,
            'total' => $total->total,
            'diskon' =>$total->ttl_diskon,
        );
        DB::table('delivery_order')->where('nomor', $nomor)->update($data_h);
        $jml_detail = collect(\DB::select(" SELECT COUNT(dd_id) jumlah FROM delivery_orderd WHERE dd_nomor='$nomor' "))->first();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
            $result['total']=number_format($total->total, 0, ",", ".");
            $result['diskon']=number_format($total->ttl_diskon, 0, ",", ".");
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function index(){
        $sql = "    SELECT d.nomor, d.tanggal, c.nama nama_customer, d.diskon,d.total
                    FROM delivery_order d
                    LEFT JOIN customer c ON c.kode=d.kode_customer
                    WHERE d.jenis='KORAN'
                    ORDER BY d.tanggal DESC LIMIT 1000 ";

        $data =  DB::select($sql);
        return view('sales.do_kertas.index',compact('data'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        $angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama,alamat,telpon FROM customer ORDER BY nama ASC ");
        $item = DB::select(" SELECT kode,nama,harga,kode_satuan,acc_penjualan FROM item ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('delivery_order')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(dd_id) jumlah FROM delivery_orderd WHERE dd_nomor ='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.do_kertas.form',compact('kota','data','cabang','jml_detail','rute','kendaraan','customer','item' ));
    }

    
    

    public function cetak_nota($nomor=null) {
        $head = collect(\DB::select("   SELECT d.nomor,d.tanggal,d.kode_customer,c.nama,c.alamat,c.telpon FROM delivery_order d
                                        LEFT JOIN customer c ON c.kode=d.kode_customer
                                        WHERE nomor='$nomor' "))->first();
        $detail =DB::select("   SELECT d.*,i.dd_nama FROM delivery_orderd d,item i
                                WHERE i.kode=d.dd_kode_item AND d.dd_nomor='$nomor'  ORDER BY id");
    
        return view('sales.do_kertas.print',compact('head','detail'));
    }


}
