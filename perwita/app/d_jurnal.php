<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_jurnal extends Model
{
	protected $table = 'd_jurnal';
    protected $primaryKey = 'jr_id';
    public $incrementing = false;
    public $remember_token = false;

    //public $timestamps = false;
    const UPDATED_AT = 'jr_update';
    const CREATED_AT = 'jr_insert';
    
    
    protected $fillable = ['jr_id', 'jr_year','jr_date', 'jr_detail','jr_ref','jr_note','jr_no'];


    public function detail(){
    	return $this->hasMany('App\d_jurnal_dt', 'jrdt_jurnal', 'jr_id');
    }
}
