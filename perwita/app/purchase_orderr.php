<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_orderr extends Model
{
    protected $table = 'pembelian_order';
    protected $primaryKey = 'po_id';
    protected $fillable = array('po_id', 'po_no', 'po_catatan', 'po_lokasi_kirim', 'po_tglkirim', 'po_bayar', 'po_status', 'po_supplier', 'po_diskon', 'po_ppn', 'po_subtotal' , 'po_totalharga');
	public $incrementing = false;

}
