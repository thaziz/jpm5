<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class master_akun extends Model
{
      protected $table = "d_akun";
      protected $primaryKey = "id_akun";
      public $incrementing = false;
      CONST CREATED_AT = "tanggal_buat";
      CONST UPDATED_AT = "terakhir_diupdate";

      protected $fillable = ['id_akun','nama_akun', 'is_parrent', 'id_parrent', 'id_provinsi', 'id_kota', 'is_active', 'level', 'type_akun'];

      public function mutasi_bank_debet(){
         return $this->hasMany('App\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_bank_kredit(){
         return $this->hasMany('App\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_kas_debet(){
         return $this->hasMany('App\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_kas_kredit(){
         return $this->hasMany('App\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_memorial_debet(){
         return $this->hasMany('App\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_memorial_kredit(){
         return $this->hasMany('App\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function provinsi(){
         return $this->belongsTo("App\master_provinsi", "id_provinsi", "id");
      }

      public function kota(){
         return $this->belongsTo("App\master_kota", "id_kota", "id");
      }

      function cek_parrent($id){
         $data = master_akun::where("id_parrent", "$id")->get(); 

         return count($data);
      }

      public function getSubAkun($id_parrent){
         $data = master_akun::where("id_parrent", "=", $id_parrent)->get();
         $cek = "";

         foreach ($data as $dataSubAkun) {
            $prov = "--";
            $kota = "--";
            $dka = ($dataSubAkun->akun_dka == "D") ? "DEBET" : "KREDIT";
            $cek = $cek.'
               <tr class="treegrid-'.$dataSubAkun->id_akun.' treegrid-parent-'.$dataSubAkun->id_parrent.'">
                  <td class="id_akun">'.$dataSubAkun->id_akun.'</td>
                  <td class="nama_akun">'.$dataSubAkun->nama_akun.'</td>
                  <td class="text-center dka">'.$dka.'</td>
                  
                  <td class="text-center">';

                     if($this->cekSaldo($dataSubAkun->id_akun)->saldo_akun != null){
                         $cek = $cek.'
                           <span data-toggle="tooltip" data-placement="top" title="Saldo Pembukaan '.$dataSubAkun->nama_akun.' Bulan Ini Rp. '.number_format($this->cekSaldo($dataSubAkun->id_akun)->saldo_akun).'">
                              <button class="btn btn-xs btn-default"><i class="fa fa-exclamation fa-fw"></i></button>
                           </span>';
                     }else{
                        $cek = $cek.'
                           <span data-toggle="tooltip" data-placement="top" title="Tambahkan Akun Di '.$dataSubAkun->nama_akun.'">
                              <button data-parrent="'.$dataSubAkun->id_akun.'" data-toggle="modal" data-target="#modal_tambah_akun" class="btn btn-xs btn-primary tambahAkun"><i class="fa fa-folder-open fa-fw"></i></button>
                           </span>';
                     }


            $cek = $cek.'<span data-toggle="tooltip" data-placement="top" title="Edit Akun '.$dataSubAkun->nama_akun.'">
                       <button data-parrent="'.$dataSubAkun->id_akun.'" data-toggle="modal" data-target="#modal_edit_akun" class="btn btn-xs btn-warning editAkun"><i class="fa fa-pencil-square fa-fw"></i></button>
                     </span>';

            if($dataSubAkun->cek_parrent($dataSubAkun->id_akun) == 0 && $dataSubAkun->id_parrent != null){
               if($dataSubAkun->cek_jurnal($dataSubAkun->id_akun) == 0){
                  $cek = $cek.'<a onclick="return confirm(\'Apakah Anda Yakin, Semua Data Sub Akun Yang Terkait Dengan Akun Ini Juga Akan Dihapus ??\')" href="'.route("akun.hapus", $dataSubAkun->id_akun).'">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun '.$dataSubAkun->nama_akun.'" class="btn btn-xs btn-danger"><i class="fa fa-eraser fa-fw"></i></button>
                              </a>';
               }else{
                  $cek = $cek.'<a>
                                <button data-toggle="tooltip" data-placement="top" title="Akun Dipakai Di Jurnal. Tidak Bisa Dihapus" class="btn btn-xs btn-default"><i class="fa fa-eraser fa-fw"></i></button>
                              </a>';
               }

            }

            $cek = $cek.'</td>
               </tr>';

            $cek = $cek.$dataSubAkun->getSubAkun($dataSubAkun->id_akun);
         }

         return $cek;

      }

      public function cekSubAkun($id){
         $data = DB::table('d_akun')->where('id_parrent', '=', $id)->get();
         //return $id;
         return count($data);
      }

      public function cekSaldo($id){
         $data = DB::table("d_akun_saldo")->where("id_akun", "=", $id)->where("bulan", "=", date("m"))->where("tahun", date("Y"))->first();

         return (count($data) == 0) ? "???" : $data;
      }

      public function hasSaldo($id){
         $data = DB::table("d_akun_saldo")->where("id_akun", $id)->where("tahun", date("Y"))->first();
         
         if($data->is_active == 0 || is_null($data->saldo_akun))
            return false;

         return true;
      }

      function cek_jurnal($id){
         $cek = DB::table("d_jurnal_dt")->where("jrdt_acc", $id)->select("*")->get();

         return count($cek);
      }
}
