<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_note extends Model
{
    protected $table = 'master_note';
    protected $primaryKey = 'mn_id';
    protected $fillable = array('mn_id', 'mn_keterangan','updated_at','created_at');
  
    public $incrementing = false;

}
