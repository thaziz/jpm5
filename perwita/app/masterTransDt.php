<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterTransDt extends Model
{		
    protected $table = "d_trans_dt";
   	protected $primaryKey = ["trdt_year","trdt_code"];
   	public $incrementing = false;
   	public $timestamps = false;

   	protected $fillable = ['trdt_code','trdt_year',"trdt_detailid", 'trdt_acc', 'trdt_accdk','trdt_accstatusdk'];
}
