<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterSupplierPurchase extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'idsup';
    protected $fillable = array('no_supplier', 'nama_supplier', 'alamat', 'kota', 'propinsi', 'kodepos', 'telp', 'contact_person', 'syarat_kredit', 'plafon', 'currency', 'pajak_npwp', 'pajak_nama', 'pajak_alamat', 'pajak_kota' , 'acc_hutang', 'ppn', 'pph23' , 'pph26', 'noseri_pajak', 'idcabang' , 'status', 'kontrak', 'no_kontrak', 'idsup');
 
public $incrementing = false;

}
