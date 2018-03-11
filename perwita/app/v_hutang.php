<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class v_hutang extends Model{

   
    protected $table = 'v_hutang';   
    protected $primaryKey= 'v_id';
   /*  public $incrementing = false;
    public $remember_token = false;*/
    protected $fillable = ['v_id','v_nomorbukti','v_tgl','v_tempo','keterangan','v_supid','v_pelunasan'];


}
