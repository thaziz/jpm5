<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barang_terima extends Model
{
    protected $table = 'barang_terima';
    protected $primaryKey = 'bt_id';
    protected $fillable = array('bt_id', 'bt_notransaksi','bt_supplier','bt_supplier','bt_status','bt_gudang','bt_flag','bt_idtransaksi');
  
    public $incrementing = false;

}
