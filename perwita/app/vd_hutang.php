<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class vd_hutang extends Model{

   
    protected $table = 'v_hutangd';   
    protected $primaryKey= 'vd_id';
   /*  public $incrementing = false;
    public $remember_token = false;*/
    protected $fillable = ['vd_id','vd_no','vd_acc','vd_keterangan','vd_nominal'];


}
