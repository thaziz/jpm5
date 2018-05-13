<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class uangmukapembeliandt_fp extends Model
{
    protected $table = 'uangmukapembeliandt_fp';
    protected $primaryKey = 'umfpdt_id';
    protected $fillable = array('umfpdt_id' , 'umfpdt_transaksibank' , 'umfpdt_tgl', 'umfpdt_jumlahnum', 
    	'umfpdt_dibayar','umfpdt_keterangan', 'umfpdt_idfp' ,'umfpdt_idum','umfpdt_notaum');
  
    public $incrementing = false;

}
