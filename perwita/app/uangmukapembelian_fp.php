<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class uangmukapembelian_fp extends Model
{
    protected $table = 'uangmukapembelian_fp';
    protected $primaryKey = 'umfp_id';
    protected $fillable = array('umfp_id', 'umfp_totalbiaya', 'umfp_tgl', 'umfp_idfp' , 'created_by' , 'updated_by');
    public $incrementing = false;

}
