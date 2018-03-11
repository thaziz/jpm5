<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class biaya_penerus extends Model
{
    protected $table = 'biaya_penerus';
    protected $primaryKey = 'bp_id';
    protected $fillable = array('bp_id', 'bp_faktur','bp_tipe_vendor','bp_status' , 'bp_kode_vendor' , 'bp_keterangan','created_at','updated_at','bp_invoice','bp_total_penerus','bp_id_persen');
  
    public $incrementing = false;

}
