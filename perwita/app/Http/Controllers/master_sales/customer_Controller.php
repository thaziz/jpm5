<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;

class customer_Controller extends Controller
{
    public function table_data () {

         $cabang = Auth::user()->kode_cabang;
      if (Auth::user()->punyaAkses('Customer','all')) {
         $list = DB::table('customer')->get();
      }else{
         $list = DB::table('customer')->where('cabang',$cabang)->get();
      }

      $data = collect($list);
      return Datatables::of($data)
        ->addColumn('button', function ($data) {
            $c =  '<div class="btn-group">'.
                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-sm btnedit" title="edit" id="'.$data->kode.'">'.
                   '<label class="fa fa-pencil"></label></button>'.
                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-sm btndelete" title="hapus" id="'.$data->kode.'">'.
                   '<label class="fa fa-trash"></label></button>'.
                  '</div>';
            $kode = '<input type="hidden" class="kode" value="'.$data->kode.'">';
            return $c.$kode;
        })
        ->addColumn('active', function ($data) {
            if (Auth::user()->punyaAkses('Verifikasi','aktif')) {
                if($data->pic_status == 'AKTIF'){
                  return '<input checked type="checkbox" onchange="check(this)" class="form-control check">';
                }else{
                  return '<input type="checkbox" onchange="check(this)" class="form-control check">';
                }
            }else{
                return '-';
            }
        })
        ->make(true);

    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('customer')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $day = carbon::now()->format('d');
         // $kodecabang =  auth::user()->kode_cabang;

        if ($request->ed_kode == null || $request->ed_kode == '') {
             $kodekode = DB::table('customer')->max('id_cus');
              if ($kodekode == '' ) {
                 $kodekode=1;
               }
               else{
                  $kodekode+=1;
               }

             

               $request->cabang;
               
              $kodekode = str_pad($kodekode, 5, '0', STR_PAD_LEFT);
                 $kodekode =  /*$kodecabang.*/'CS-'.$request->cabang.'/'.$kodekode;
        }else{
           $kodekode = $request->ed_kode;
        }
          $idcuskode = DB::table('customer')->max('id_cus');
              if ($idcuskode == '' ) {
                 $idcuskode=1;
               }
               else{
                  $idcuskode+=1;
               }

        $simpan='';
        $crud = $request->crud;
       if ($request->ck_pph23 == null || $request->ck_pph23 == '') {
           $request->ck_pph23 = false;
       }
       if ($request->ck_ppn == null || $request->ck_ppn == '') {
           $request->ck_ppn = false;
       }
        
        if ($crud == 'N') {
             $data = array(
                'id_cus'=>$idcuskode,
                'kode' => $kodekode/*strtoupper($request->ed_kode)*/,
                'nama' => strtoupper($request->ed_nama),
                'alamat' => strtoupper($request->ed_alamat),
                'kota' => strtoupper($request->cb_kota),
                'telpon' => strtoupper($request->ed_telpon),
                'cabang' => $request->cabang,
                'plafon'=> strtoupper($request->ed_plafon),
                'kode_bank'  => strtoupper($request->ed_kode_bank),
                'group_customer' =>strtoupper($request->group_customer),
                'syarat_kredit' => strtoupper($request->ed_syarat_kredit),

                'pic_nama' => strtoupper($request->nama_pic),
                'pic_alamat'=>strtoupper($request->alamat_pic) ,
                'pic_fax'=>strtoupper($request->fax_pic) ,
                'pic_status'=>strtoupper($request->status_pic) ,
                'pic_email'=>strtoupper($request->email_pic) ,
                'pic_telpon'=>strtoupper($request->telp_pic) ,
                'acc_piutang' => strtoupper($request->ed_acc_piutang),
                'csf_piutang' => strtoupper($request->ed_csf_piutang),

                'pajak_npwp' => strtoupper($request->ed_npwp),
                'pajak_tarif' => strtoupper($request->pajak_tarif),
                'pajak_nama' => strtoupper($request->nama_pajak),
                'pajak_alamat'=>strtoupper($request->alamat_pajak) ,
                'pajak_kota'=>strtoupper($request->kota_pajak) ,
                'nama_pph23'  => strtoupper($request->cb_nama_pajak_23),
                'type_faktur_ppn'  => strtoupper($request->cb_type_faktur),
 
                'hold_id' => 'HL',
                'comp_id' => 'EM',
                'sub_comp_id'  => 1,
                'pph23' => $request->ck_pph23,
                'ppn' => $request->ck_ppn,
            );
            $simpan = DB::table('customer')->insert($data);
        }elseif ($crud == 'E') {

              $request->cabang;
               
              $kodekode = str_pad($request->id_cus, 5, '0', STR_PAD_LEFT);
              $kodekode =  /*$kodecabang.*/'CS-'.$request->cabang.'/'.$kodekode;

             $data = array(
                'id_cus'=>$request->id_cus,
                'kode' => $kodekode,
                'nama' => strtoupper($request->ed_nama),
                'alamat' => strtoupper($request->ed_alamat),
                'kota' => strtoupper($request->cb_kota),
                'telpon' => strtoupper($request->ed_telpon),
                'cabang' => $request->cabang,
                'plafon'=> strtoupper($request->ed_plafon),
                'kode_bank'  => strtoupper($request->ed_kode_bank),
                'group_customer' =>strtoupper($request->group_customer),
                'syarat_kredit' => strtoupper($request->ed_syarat_kredit),

                'pic_nama' => strtoupper($request->nama_pic),
                'pic_alamat'=>strtoupper($request->alamat_pic) ,
                'pic_fax'=>strtoupper($request->fax_pic) ,
                'pic_status'=>strtoupper($request->status_pic) ,
                'pic_email'=>strtoupper($request->email_pic) ,
                'pic_telpon'=>strtoupper($request->telp_pic) ,
                'acc_piutang' => strtoupper($request->ed_acc_piutang),
                'csf_piutang' => strtoupper($request->ed_csf_piutang),

                'pajak_npwp' => strtoupper($request->ed_npwp),
                'pajak_tarif' => strtoupper($request->pajak_tarif),
                'pajak_nama' => strtoupper($request->nama_pajak),
                'pajak_alamat'=>strtoupper($request->alamat_pajak) ,
                'pajak_kota'=>strtoupper($request->kota_pajak) ,
                'nama_pph23'  => strtoupper($request->cb_nama_pajak_23),
                'type_faktur_ppn'  => strtoupper($request->cb_type_faktur),
                'hold_id' => 'HL',
                'comp_id' => 'EM',
                'sub_comp_id'  => 1,
                'pph23' => $request->ck_pph23,
                'ppn' => $request->ck_ppn,
            );
            $simpan = DB::table('customer')->where('kode', $request->ed_kode_old)->update($data);
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
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('customer')->where('kode' ,'=', $id)->delete();
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
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        $accpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $group_customer = DB::select(DB::raw(" SELECT group_id,group_nama FROM group_customer ORDER BY group_id ASC "));
        $bank = DB::select(DB::raw(" SELECT id_akun, nama_akun, id_parrent, id_provinsi, akun_dka, is_active, tanggal_buat, terakhir_diupdate, kode_cabang, type_akun FROM d_akun where nama_akun like '%KAS KECIL%' or nama_akun like '%KAS BESAR%'  or nama_akun like '%BANK%' order by nama_akun ASC;
         "));
        $csfpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $cabang = DB::table('cabang')->get();   
        $pajak = DB::table('pajak')->get();
        return view('master_sales.customer.index', compact('kota','cabang','accpenjualan','csfpenjualan','bank','group_customer','pajak'));
    }
    public function check_status(Request $req)
    {
       if ($req->check == 'true') {
         // return $req->check;

            $data_dt = DB::table('customer')
                ->where('kode',$req->kode)
                ->update([
                  'pic_status' => 'AKTIF' 
                ]);

             return json_encode('success 1');

        }else{

           $data_dt = DB::table('customer')
                ->where('kode',$req->kode)
                ->update([
                  'pic_status' => 'NON-AKTIF' 
                ]);
                
             return json_encode('success 2');
        }
    }

}
