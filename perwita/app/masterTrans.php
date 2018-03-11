<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\masterTransDt;

class masterTrans extends Model
{
    protected $table = "d_trans";
   	protected $primaryKey = ["tr_code","tr_year"];
   	public $incrementing = false;
   	CONST CREATED_AT = "tr_insert";
   	CONST UPDATED_AT = "tr_update";

   	protected $fillable = ['tr_code','tr_year', 'tr_name', 'tr_provinsi', 'tr_kota', 'tr_locked'];

   	public function detail($tr_code,$year){
         $data = masterTransDt::join('d_akun',function ($join){
         	$join->on('d_trans_dt.trdt_acc','=','d_akun.id_akun');
         })->where("trdt_code", "=", $tr_code)->where('trdt_year',$year)
         ->orderBy('trdt_detailid')->get();    
         /*$html='';     
         $html .='<table class="table">';
         foreach ($data as $key => $value) {
         	$html .='<tr><td>'.$value->trdt_acc.'</td>';
         	$html .='<td>'.$value->nama_akun.'</td>';
         	$html .='<td>'.$value->trdt_accstatusdk.'</td></tr>';

         }
         $html .='</table>';*/
         return $data;
     }
}
