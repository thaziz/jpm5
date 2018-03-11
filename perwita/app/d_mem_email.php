<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mem_email extends Model
{
    protected $table = 'd_mem_email';
    protected $primaryKey = ['me_member', 'me_email'];
    CONST UPDATED_AT = 'me_update';
    CONST CREATED_AT = 'me_insert';
    public $incrementing = false;

    protected $fillable = ['me_status', 'me_isprimary'];

    public function member(){
    	return $this->belongsTo('App\d_mem', 'me_member', 'm_id');
    }
}
