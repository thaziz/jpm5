<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cndn extends Model
{
    protected $table = 'cndnpembelian';
    protected $primaryKey = 'cndn_id';
    protected $fillable = array('cndn_id', 'cndn_tgl' , 'cndn_supplier' , 'cndn_acchutangdagang' , 'cndn_acccndn' , 'cndn_bruto' , 'cndn_comp' , 'cndn_nota' , 'cndn_hasilppn' , 'cndn_hasilpph');
  
    public $incrementing = false;

}
