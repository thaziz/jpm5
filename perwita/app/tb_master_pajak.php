<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_master_pajak extends Model
{
    protected $table = 'pajak';
    protected $fillable = array('kode', 'nama','nilai','version' , 'create_by' , 'create_at', 'update_by' , 'update_at', 'id');  
    public $incrementing = false;

}
