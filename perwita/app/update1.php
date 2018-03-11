<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class update1 extends Model{

   
    protected $table = 'update_detail1';   
    protected $primaryKey= 'id_u';
   /*  public $incrementing = false;
    public $remember_token = false;*/
    protected $fillable = ['id_u','id','nomor_suat_jalan_trayek','nomor_do','status'];


}
