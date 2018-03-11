<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class d_uangmuka extends Model{

   
    protected $table = 'd_uangmuka';   
    protected $primaryKey= 'um_id';
   /*  public $incrementing = false;
    public $remember_token = false;*/
    protected $fillable = ['um_nomorbukti','um_tgl','um_supplier','um_alamat','um_keterangan','um_jumlah','um_jenissup','um_comp'];


}
