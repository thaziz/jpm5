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

   	public function provinsi(){
   		return $this->belongsTo("App\master_provinsi", "id_provinsi", "id");
   	}

      public function kota(){
         return $this->belongsTo("App\master_kota", "id_kota", "id");
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
                  if($this->cekSaldo($dataSubAkun->id_akun)->is_active == 0){
                     $cek = $cek.'
                        <span data-toggle="tooltip" data-placement="top" title="Tambahkan Akun Di '.$dataSubAkun->nama_akun.'">
                              <button data-parrent="'.$dataSubAkun->id_akun.'" data-toggle="modal" data-target="#modal_tambah_akun" class="btn btn-xs btn-primary tambahAkun"><i class="fa fa-folder-open"></i></button>
                        </span>';
                  }else{
                     $cek = $cek.'
                        <span data-toggle="tooltip" data-placement="top" title="Saldo Pembukaan '.$dataSubAkun->nama_akun.' Tahun Ini Rp. '.number_format($this->cekSaldo($dataSubAkun->id_akun)->saldo_akun).'">
                              <button class="btn btn-xs btn-default"><i class="fa fa-exclamation fa-fw"></i></button>
                        </span>';
                  }

            $cek = $cek.'<span data-toggle="tooltip" data-placement="top" title="Edit Akun '.$dataSubAkun->nama_akun.'">
                       <button data-parrent="'.$dataSubAkun->id_akun.'" data-toggle="modal" data-target="#modal_edit_akun" class="btn btn-xs btn-warning editAkun"><i class="fa fa-pencil-square"></i></button>
                     </span>

                     <a onclick="return confirm(\'Apakah Anda Yakin, Semua Data Sub Akun Yang Terkait Dengan Akun Ini Juga Akan Dihapus ??\')" href="'.route("akun.hapus", $dataSubAkun->id_akun).'">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun '.$dataSubAkun->nama_akun.'" class="btn btn-xs btn-danger"><i class="fa fa-eraser"></i></button>
                              </a>
                  </td>
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
         $data = DB::table("d_akun_saldo")->where("id_akun", "=", $id)->where("tahun", "=", date("Y"))->first();

            return $data;
      }

      public function hasSaldo($id){
         $data = DB::table("d_akun_saldo")->where("id_akun", $id)->where("tahun", date("Y"))->first();
         
         if($data->is_active == 0)
            return false;

         return true;
      }
}
