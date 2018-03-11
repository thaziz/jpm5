<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
Route::get('/', function(){
    return view('auth.login');
});
Route::get('/dashboard', function(){
    return view('coba');
});

Route::get('/halaman_kosong', function(){
    return view('kosong');
});

Route::get('login', function(){
    return view('auth.login');
});
Route::get('cek_login', 'login_Controller@authenticate');
Route::get('abc', 'login_Controller@abc');
Route::get('logout', 'login_Controller@logout');

Route::get('seragam', function(){
        return view('seragam.seragam');
       });

//purchase
Route::get('purchase/suratpermintaanpembelian', function(){
        return view('purchase.spp.index');
});

//********SETTING********
//pengguna
Route::get('setting/pengguna', 'setting\pengguna_Controller@index');
Route::get('setting/pengguna/tabel', 'setting\pengguna_Controller@table_data');
Route::get('setting/pengguna/get_data', 'setting\pengguna_Controller@get_data');
Route::post('setting/pengguna/save_data', 'setting\pengguna_Controller@save_data');
Route::post('setting/pengguna/hapus_data', 'setting\pengguna_Controller@hapus_data');
// end pengguna

//hak_akses
Route::get('setting/hak_akses', 'setting\hak_akses_Controller@index');
Route::get('setting/hak_akses/add_level', 'setting\hak_akses_Controller@form');
Route::get('setting/hak_akses/{level}/edit_level', 'setting\hak_akses_Controller@form');
Route::get('setting/hak_akses/tabel', 'setting\hak_akses_Controller@table_data');
//Route::get('setting/hak_akses/get_data', 'setting\hak_akses_Controller@get_data');
Route::post('setting/hak_akses/save_data', 'setting\hak_akses_Controller@save_data');
Route::post('setting/hak_akses/hapus_data', 'setting\hak_akses_Controller@hapus_data');
Route::post('setting/hak_akses/edit_hak_akses', 'setting\hak_akses_Controller@edit_hak_akses');
// end hak_akses


//***PEMBELIAN
Route::get('suratpermintaanpembelian' , 'PurchaseController@spp_index');
Route::post('suratpermintaanpembelian/savesupplier' , 'PurchaseController@savespp');
Route::post('suratpermintaanpembelian/updatesupplier/{id}' , 'PurchaseController@updatespp');
Route::get('suratpermintaanpembelian/createspp' , 'PurchaseController@createspp');
Route::get('suratpermintaanpembelian/detailspp/{id}' , 'PurchaseController@detailspp');
Route::delete('suratpermintaanpembelian/deletespp/{id}' , 'PurchaseController@deletespp');
Route::post('suratpermintaanpembelian/ajax_supplier' , 'PurchaseController@ajax_supplier');
Route::get('suratpermintaanpembelian/ajax_hargasupplier/{id}', 'PurchaseController@ajax_hargasupplier');
Route::post('suratpermintaanpembelian/ajax_jenisitem/', 'PurchaseController@ajax_jenisitem');
Route::get('suratpermintaanpembelian/statusspp/{id}', 'PurchaseController@statusspp');
Route::get('suratpermintaanpembelian/createPDF/{id}', 'PurchaseController@createPdfSpp');
Route::post('suratpermintaanpembelian/getnospp', 'PurchaseController@getnospp');

Route::get('konfirmasi_order/konfirmasi_order' , 'PurchaseController@confirm_order');
Route::get('konfirmasi_order/konfirmasi_orderdetail/{id}' , 'PurchaseController@confirm_order_dt');
Route::get('konfirmasi_order/ajax_confirmorderdt' , 'PurchaseController@ajax_confirmorderdt');
Route::post('konfirmasi_order/gettotalbiaya' , 'PurchaseController@get_tb');
Route::post('konfirmasi_order/savekonfirmasiorderdetail' , 'PurchaseController@saveconfirmorderdt');

Route::get('purchaseorder/ajax', 'PurchaseController@createAjax');
Route::get('purchaseorder/outputsuratspp', 'PurchaseController@pdf_spp');
Route::get('purchaseorder/purchaseorder', 'PurchaseController@purchase_order');
Route::get('purchaseorder/detail/{id}', 'PurchaseController@detailpurchase');
Route::get('purchaseorder/purchasedetail/{id}', 'PurchaseController@purchasedetail');
Route::get('purchaseorder/createpurchase', 'PurchaseController@createpurchase');
Route::get('purchaseorder/ajax_tampilspp', 'PurchaseController@ajax_tampilspp');
Route::post('purchaseorder/savepurchase', 'PurchaseController@savepurchase');
Route::post('purchaseorder/updatepurchase/{id}', 'PurchaseController@updatepurchase');


/*warehouse */

Route::get('penerimaanbarang/penerimaanbarang', 'PurchaseController@penerimaanbarang');
Route::get('penerimaanbarang/detailterimabarang/{id}/{flag}', 'PurchaseController@detailterimabarang');
Route::get('penerimaanbarang/laporanpenerimaan/{id}', 'PurchaseController@laporanpenerimaan');
Route::post('penerimaanbarang/savepenerimaan', 'PurchaseController@savepenerimaan');
Route::get('penerimaanbarang/gettampil', 'PurchaseController@ajaxpenerimaan');
Route::get('penerimaanbarang/ajaxtampilterima', 'PurchaseController@ajax_tampilterima');
Route::get('penerimaanbarang/changeqtyterima', 'PurchaseController@changeqtyterima');
Route::get('penerimaanbarang/detailterimabarang/createPDF/{id}/{index}/{flag}', 'PurchaseController@createPdfTerimaBarang');



Route::get('pengeluaranbarang/pengeluaranbarang', 'PurchaseController@pengeluaranbarang');
Route::get('pengeluaranbarang/detailpengeluaranbarang', 'PurchaseController@detailpengeluaranbarang');
Route::get('pengeluaranbarang/createpengeluaranbarang', 'PurchaseController@createpengeluaranbarang');

Route::get('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang' , 'PurchaseController@konfirmpengeluaranbarang');
Route::get('konfirmasipengeluaranbarang/detailkonfirmasipengeluaranbarang' , 'PurchaseController@detailkonfirmpengeluaranbarang');

Route::get('stockopname/stockopname' , 'PurchaseController@stockopname');
Route::get('stockopname/createstockopname' , 'PurchaseController@createstockopname');
Route::get('stockopname/detailstockopname' , 'PurchaseController@detailstockopname');


Route::get('stockgudang/stockgudang' , 'PurchaseController@stockgudang');


Route::get('pengeluaranbarang/bppb', function(){
        return view('purchase.pengeluaran_barang.bppb');
});

Route::get('laporanstok/laporanstok', function(){
        return view('purchase.stock_opname.laporan_stok');
});


/* end warehouse */
Route::get('fakturpembelian/fakturpembelian', 'PurchaseController@fatkurpembelian');
Route::get('fakturpembelian/createfatkurpembelian', 'PurchaseController@createfatkurpembelian');
Route::get('fakturpembelian/detailfatkurpembelian/{id}', 'PurchaseController@detailfatkurpembelian');
Route::get('fakturpembelian/getchangefaktur', 'PurchaseController@supplierfaktur');
Route::get('fakturpembelian/tampil_po', 'PurchaseController@tampil_po');
Route::post('fakturpembelian/save', 'PurchaseController@savefaktur');
Route::post('fakturpembelian/update_fp', 'PurchaseController@update_fp');
Route::post('fakturpembelian/savefakturpo', 'PurchaseController@savefakturpo');
Route::post('fakturpembelian/updatestockbarang' , 'PurchaseController@updatestockbarang');
Route::get('fakturpembelian/cetakfaktur/{id}' , 'PurchaseController@cetakfaktur');
Route::get('fakturpembelian/cetaktt/{id}' , 'PurchaseController@cetaktt');


//BIAYA PENERUS AGEN
Route::get('fakturpembelian/getdatapenerus', 'BiayaPenerusController@getdatapenerus');
Route::get('fakturpembelian/caripod', 'BiayaPenerusController@caripod');
Route::get('fakturpembelian/carimaster/{vendor}', 'BiayaPenerusController@carimaster');
Route::get('fakturpembelian/auto/{i}', 'BiayaPenerusController@auto');
Route::post('fakturpembelian/save_agen', 'BiayaPenerusController@save_agen');
Route::get('fakturpembelian/detailbiayapenerus/{i}', 'BiayaPenerusController@edit');
Route::get('fakturpembelian/getdatapenerusedit', 'BiayaPenerusController@getdatapenerusedit');
Route::post('fakturpembelian/update_agen', 'BiayaPenerusController@update_agen');
Route::get('fakturpembelian/simpan_tt', 'BiayaPenerusController@simpan_tt');
Route::get('fakturpembelian/cetak_tt', 'BiayaPenerusController@cetak_tt');
Route::get('fakturpembelian/hapusbiayapenerus/{id}', 'BiayaPenerusController@hapus_biaya');
Route::get('fakturpembelian/detailbiayapenerus', 'BiayaPenerusController@detailbiayapenerus')->name('detailbiayapenerus');
Route::get('fakturpembelian/buktibiayapenerus', 'BiayaPenerusController@buktibiayapenerus')->name('buktibiayapenerus');
// ganti nota fp
Route::get('fakturpembelian/notapenerusagen', 'BiayaPenerusController@notapenerusagen');
Route::get('fakturpembelian/notaoutlet', 'BiayaPenerusController@notaoutlet');
Route::get('fakturpembelian/notasubcon', 'BiayaPenerusController@notasubcon');
//PEMBAYARAN OUTLET
Route::get('fakturpembelian/getpembayaranoutlet', 'BiayaPenerusController@getpembayaranoutlet')->name('getpembayaranoutlet');
Route::post('fakturpembelian/cari_outlet/{agen}', 'BiayaPenerusController@cari_outlet');
Route::post('fakturpembelian/cari_outlet1/{agen}', 'BiayaPenerusController@cari_outlet1');
Route::get('fakturpembelian/cariNote', 'BiayaPenerusController@cari_note');
Route::post('fakturpembelian/save_outlet', 'BiayaPenerusController@save_outlet');
Route::post('fakturpembelian/update_outlet', 'BiayaPenerusController@update_outlet');
//PEMBAYARAN SUBCON
Route::get('fakturpembelian/getpembayaransubcon', 'BiayaPenerusController@getpembayaransubcon')->name('getpembayaransubcon');
Route::get('fakturpembelian/cari_subcon', 'BiayaPenerusController@cari_subcon');
Route::get('master_subcon/subcon', 'subconController@subcon');
Route::get('master_subcon/tambahkontraksubcon', 'subconController@tambahkontraksubcon');
Route::get('master_subcon/edit_subcon/{id}', 'subconController@edit_subcon');
Route::get('master_subcon/update_subcon', 'subconController@update_subcon');
Route::get('master_subcon/save_subcon', 'subconController@save_subcon');
Route::get('master_subcon/cari_kontrak/{id}', 'BiayaPenerusController@cari_kontrak');
Route::get('fakturpembelian/pilih_kontrak', 'BiayaPenerusController@pilih_kontrak');
Route::get('fakturpembelian/caripodsubcon', 'BiayaPenerusController@caripodsubcon');
Route::get('fakturpembelian/subcon_save', 'BiayaPenerusController@subcon_save');

//BIAYA PENERUS KAS
Route::get('biaya_penerus/index', 'KasController@index');
Route::get('biaya_penerus/createkas', 'KasController@create');
Route::get('biaya_penerus/getbbm/{id}', 'KasController@getbbm');
Route::post('biaya_penerus/cariresi', 'KasController@cari_resi');
Route::get('biaya_penerus/save_penerus', 'KasController@save_penerus');
Route::post('biaya_penerus/update_penerus', 'KasController@update_penerus');
Route::get('biaya_penerus/editkas', 'KasController@edit')->name('editkas');
Route::get('biaya_penerus/hapuskas/{id}', 'KasController@hapus')->name('hapuskas');
Route::get('biaya_penerus/buktikas', 'KasController@buktikas')->name('buktikas');
Route::get('biaya_penerus/detailkas', 'KasController@detailkas')->name('detailkas');
Route::get('biaya_penerus/carinopol', 'KasController@carinopol')->name('carinopol');

//BUKTI KAS KELUAR
Route::get('buktikaskeluar/index', 'kasKeluarController@index');
Route::get('buktikaskeluar/create', 'kasKeluarController@create');
Route::get('buktikaskeluar/simpan_patty', 'kasKeluarController@simpan_patty');
Route::get('buktikaskeluar/edit', 'kasKeluarController@edit');
Route::get('buktikaskeluar/hapus', 'kasKeluarController@hapus');
Route::get('buktikaskeluar/patty_cash', 'kasKeluarController@patty_cash');
Route::get('buktikaskeluar/cari_patty', 'kasKeluarController@cari_patty');
// IKHTISAR KAS
Route::get('ikhtisar_kas/index', 'ikhtisarController@index');
Route::get('ikhtisar_kas/create', 'ikhtisarController@create');
Route::get('ikhtisar_kas/cari_patty', 'ikhtisarController@cari_patty');
Route::post('ikhtisar_kas/simpan', 'ikhtisarController@simpan');
//PENDING 
Route::get('pending/index', 'pendingController@index');
Route::get('pending/create', 'pendingController@create')->name('proses');
Route::get('pending/save', 'pendingController@save')->name('save_pending');


Route::get('voucherhutang/voucherhutang', 'v_hutangController@voucherhutang');
Route::get('voucherhutang/createvoucherhutang', 'v_hutangController@createvoucherhutang');
Route::get('voucherhutang/createvoucherhutang/store1', 'v_hutangController@store1');
Route::get('voucherhutang/detailvoucherhutang/{v_id}', 'v_hutangController@detailvoucherhutang');
Route::get('voucherhutang/editvoucherhutang/{v_id}', 'v_hutangController@editvoucherhutang');
Route::get('voucherhutang/updatevoucherhutang/{v_id}', 'v_hutangController@updatevoucherhutang');
Route::get('voucherhutang/hapusvoucherhutang/{v_id}', 'v_hutangController@hapusvoucherhutang');



Route::get('returnpembelian/returnpembelian', 'PurchaseController@returnpembelian');
Route::get('returnpembelian/createreturnpembelian', 'PurchaseController@createreturnpembelian');
Route::get('returnpembelian/detailreturnpembelian', 'PurchaseController@detailreturnpembelian');

Route::get('cndnpembelian/cndnpembelian', 'PurchaseController@cndnpembelian');
Route::get('cndnpembelian/createcndnpembelian', 'PurchaseController@createcndnpembelian');
Route::get('cndnpembelian/detailcndnpembelian', 'PurchaseController@detailcndnpembelian');

Route::get('uangmukapembelian/uangmukapembelian', 'PurchaseController@uangmukapembelian');
Route::get('uangmukapembelian/createuangmukapembelian', 'PurchaseController@createuangmukapembelian');
Route::get('uangmukapembelian/detailuangmukapembelian', 'PurchaseController@detailuangmukapembelian');


Route::get('pelunasanhutang/pelunasanhutang', 'PurchaseController@pelunasanhutang');
Route::get('pelunasanhutang/createpelunasanhutang', 'PurchaseController@createpelunasanhutang');
Route::get('pelunasanhutang/detailpelunasanhutang', 'PurchaseController@detailpelunasanhutang');


Route::get('pelunasanhutangbayarbank/pelunasanhutangbayarbank', 'PurchaseController@pelunasanhutangbayarbank');
Route::get('pelunasanhutangbayarbank/createpelunasanhutangbayarbank', 'PurchaseController@createpelunasanhutangbayarbank');
Route::get('pelunasanhutangbayarbank/detailpelunasanhutangbayarbank', 'PurchaseController@detailpelunasanhutangbayarbank');

Route::get('bankkaslain/bankkaslain', 'PurchaseController@bankkaslain');
Route::get('bankkaslain/createbankkaslain', 'PurchaseController@createbankkaslain');
Route::get('bankkaslain/detailbankkaslain', 'PurchaseController@detailbankkaslain');

Route::get('mutasi_stock/mutasi_stock', 'PurchaseController@mutasistock');
Route::get('mutasi_stock/createmutasi_stock', 'PurchaseController@createmutasistock');
Route::get('mutasi_stock/detailmutasi_stock', 'PurchaseController@detailmutasistock');

Route::get('formtandaterimatagihan/formtandaterimatagihan', 'PurchaseController@formtandaterimatagihan');
Route::get('formtandaterimatagihan/createformtandaterimatagihan', 'PurchaseController@createformtandaterimatagihan');
Route::get('formtandaterimatagihan/detailformtandaterimatagihan', 'PurchaseController@detailformtandaterimatagihan');


Route::get('formaju/formaju', 'PurchaseController@formaju');
Route::get('formaju/createformaju', 'PurchaseController@createformaju');
Route::get('formaju/detailformaju', 'PurchaseController@detailformaju');

Route::get('formfpg/formfpg', 'PurchaseController@formfpg');
Route::get('formfpg/createformfpg', 'PurchaseController@createformfpg');
Route::get('formfpg/detailformfpg', 'PurchaseController@detailformfpg');
Route::post('formfpg/changesupplier', 'PurchaseController@changesupplier');
Route::post('formfpg/getfaktur', 'PurchaseController@getfaktur');
Route::get('formfpg/getjenisbayar', 'PurchaseController@getjenisbayar');
Route::post('formfpg/getkodeakun', 'PurchaseController@getkodeakun');
Route::post('formfpg/getakunbg', 'PurchaseController@getakunbg');

Route::get('pelaporanfakturpajakmasukan/pelaporanfakturpajakmasukan', 'PurchaseController@pelaporanfakturpajakmasukan');
Route::get('pelaporanfakturpajakmasukan/createpelaporanfakturpajakmasukan', 'PurchaseController@createpelaporanfakturpajakmasukan');
Route::get('pelaporanfakturpajakmasukan/detailpelaporanfakturpajakmasukan', 'PurchaseController@detailpelaporanfakturpajakmasukan');

Route::get('memorialpurchase/memorialpurchase', 'PurchaseController@memorialpurchase');
Route::get('memorialpurchase/creatememorialpurchase', 'PurchaseController@creatememorialpurchase');
Route::get('memorialpurchase/detailmemorialpurchase', 'PurchaseController@detailmemorialpurchase');



//Master Purchase
Route::get('masteritem/masteritem', 'MasterPurchaseController@masteritem');
Route::get('masteritem/createitem', 'MasterPurchaseController@createmasteritem');
Route::post('masteritem/saveitem', 'MasterPurchaseController@saveitem');
Route::get('masteritem/edititem/{id}', 'MasterPurchaseController@edititem');
Route::post('masteritem/updateitem/{id}', 'MasterPurchaseController@updateitem');
Route::delete('masteritem/deleteitem/{id}', 'MasterPurchaseController@deleteitem');



Route::get('masterbank/masterbank', 'MasterPurchaseController@masterbank');
Route::get('masterbank/createmasterbank', 'MasterPurchaseController@createmasterbank');
Route::post('masterbank/savemasterbank', 'MasterPurchaseController@savemasterbank');
Route::post('masterbank/getkodeakunbank', 'MasterPurchaseController@getkodeakunbank');
Route::get('masterbank/detailbank/{id}', 'MasterPurchaseController@detailbank');
Route::delete('masterbank/deletebank/{id}', 'MasterPurchaseController@deletebank');



Route::get('mastergroupitem/mastergroupitem', 'MasterPurchaseController@mastergroupitem');
Route::get('mastergroupitem/createmastergroupitem', 'MasterPurchaseController@createmastergroupitem');
Route::get('mastergroupitem/detailmastergroupitem/{id}', 'MasterPurchaseController@detailmastergroupitem');
Route::post('mastergroupitem/savemastergroupitem', 'MasterPurchaseController@savemastergroupitem');
Route::post('mastergroupitem/updatemastergroupitem/{id}', 'MasterPurchaseController@updatemastergroupitem');
Route::delete('mastergroupitem/deletemastergroupitem/{id}', 'MasterPurchaseController@deletemastergroupitem');



Route::get('konfirmasisupplier/konfirmasisupplier', 'MasterPurchaseController@konfirmasisupplier');
Route::get('konfirmasisupplier/detailkonfirmasisupplier/{id}', 'MasterPurchaseController@detailkonfirmasisupplier');
Route::post('konfirmasisupplier/updatekonfirmasisupplier/{id}', 'MasterPurchaseController@updatekonfirmasisupplier');





Route::get('mastersupplier/mastersupplier', 'MasterPurchaseController@mastersupplier');
Route::get('mastersupplier/createmastersupplier', 'MasterPurchaseController@createmastersupplier');
Route::get('mastersupplier/ajaxkota/{id}', 'MasterPurchaseController@ajax_kota');
Route::post('mastersupplier/savesupplier', 'MasterPurchaseController@savesupplier');
Route::get('mastersupplier/editsupplier/{id}', 'MasterPurchaseController@editsupplier');
Route::post('mastersupplier/updatesupplier/{id}', 'MasterPurchaseController@updatesupplier');
Route::delete('mastersupplier/deletesupplier/{id}', 'MasterPurchaseController@deletesupplier');
Route::get('mastersupplier/detailsupplier/{id}', 'MasterPurchaseController@detailsupplier');
Route::get('mastersupplier/createPdfMasterSupplier', 'MasterPurchaseController@createPdfMasterSupplier');




Route::get('masterdepartment/masterdepartment', 'MasterPurchaseController@masterdepartment');
Route::get('masterdepartment/createmasterdepartment', 'MasterPurchaseController@createmasterdepartment');
Route::post('masterdepartment/savemasterdepartment', 'MasterPurchaseController@savemasterdepartment');
Route::post('masterdepartment/updatemasterdepartment/{id}', 'MasterPurchaseController@updatemasterdepartment');
Route::get('masterdepartment/detailmasterdepartment/{id}', 'MasterPurchaseController@detailmasterdepartment');
Route::delete('masterdepartment/deletemasterdepartment/{id}', 'MasterPurchaseController@deletemasterdepartment');
Route::get('masterdepartment/createPdfMasterDepartment', 'MasterPurchaseController@createPdfMasterDepartment');




Route::get('masterjenisitem/masterjenisitem', 'MasterPurchaseController@masterjenisitem');
Route::get('masterjenisitem/createmasterjenisitem', 'MasterPurchaseController@createmasterjenisitem');
Route::post('masterjenisitem/savemasterjenisitem', 'MasterPurchaseController@savemasterjenisitem');
Route::post('masterjenisitem/updatemasterjenisitem/{id}', 'MasterPurchaseController@updatemasterjenisitem');
Route::get('masterjenisitem/detailmasterjenisitem/{id}', 'MasterPurchaseController@detailmasterjenisitem');
Route::delete('masterjenisitem/deletemasterjenisitem/{id}', 'MasterPurchaseController@deletemasterjenisitem');
Route::post('masterjenisitem/kodejenis', 'MasterPurchaseController@kodejenisitem');


Route::get('masteractiva/masteractiva', 'MasterPurchaseController@masteractiva');
Route::get('masteractiva/detailmasteractiva', 'MasterPurchaseController@detailmasteractiva');
Route::get('masteractiva/detailgarislurusmasteractiva', 'MasterPurchaseController@detailgarislurusmasteractiva');
Route::get('masteractiva/detailsaldomenurunmasteractiva', 'MasterPurchaseController@detailsaldomenurunmasteractiva');
Route::get('masteractiva/createmasteractiva', 'MasterPurchaseController@createmasteractiva');


Route::get('golonganactiva/golonganactiva', 'MasterPurchaseController@golonganactiva');
Route::get('golonganactiva/creategolonganactiva', 'MasterPurchaseController@creategolonganactiva');

Route::get('notadebit/notadebit', 'MasterPurchaseController@nota_debit');
Route::get('notadebit/detailnotadebit', 'MasterPurchaseController@detailnota_debit');
Route::get('notadebit/createnotadebit', 'MasterPurchaseController@createnota_debit');



Route::get('masterbarang/masterbarang', 'MasterPurchaseController@master_barang');
Route::get('masterbarang/createmasterbarang', 'MasterPurchaseController@createmaster_barang');
Route::get('masterbarang/detailmasterbarang', 'MasterPurchaseController@detailmaster_barang');


Route::get('jeniskendaraan/jeniskendaraan', 'MasterPurchaseController@jeniskendaraan');
Route::get('jeniskendaraan/createjeniskendaraan', 'MasterPurchaseController@createjeniskendaraan');
Route::get('jeniskendaraan/detailjeniskendaraan', 'MasterPurchaseController@detailjeniskendaraan');


Route::get('modelkendaraan/modelkendaraan', 'MasterPurchaseController@modelkendaraan');
Route::get('modelkendaraan/createmodelkendaraan', 'MasterPurchaseController@createmodelkendaraan');
Route::get('modelkendaraan/detailmodelkendaraan', 'MasterPurchaseController@detailmodelkendaraan');


Route::get('mastergudang/mastergudang', 'MasterPurchaseController@mastergudang');
Route::get('mastergudang/createmastergudang', 'MasterPurchaseController@createmastergudang');
Route::post('mastergudang/savemastergudang', 'MasterPurchaseController@savemastergudang');
Route::get('mastergudang/detailmastergudang', 'MasterPurchaseController@detailmastergudang');
Route::delete('mastergudang/deletegudang/{id}', 'MasterPurchaseController@deletegudang');

// master persen dan bbm
Route::get('bbm/index', 'MasterPenerusController@bbm');
Route::get('bbm/update/{kode}/{nama}/{harga}', 'MasterPenerusController@bbm_update');
Route::get('presentase/index', 'MasterPenerusController@presentase');
Route::get('presentase/tambah', 'MasterPenerusController@tambah');
Route::get('presentase/hapus', 'MasterPenerusController@hapus')->name('hapusPersen');
Route::get('presentase/update/{kode}/{nama}/{persen}', 'MasterPenerusController@presentase_update');


//Laporan
Route::get('reportspp/reportspp', 'LaporanPurchaseController@reportspp');
Route::POST('reportspp/table', 'LaporanPurchaseController@tablespp')->name('tabel');
Route::get('reportpo/reportpo', 'LaporanPurchaseController@reportpo');
Route::post('reportspp/tablepo', 'LaporanPurchaseController@tablepo')->name('tabel1');
Route::get('reportmasteritem/reportmasteritem', 'LaporanPurchaseController@reportmasteritem');
Route::get('reportmastergroupitem/reportmastergroupitem', 'LaporanPurchaseController@reportmastergroupitem');
Route::get('reportmasterdepartment/reportmasterdepartment', 'LaporanPurchaseController@reportmasterdepartment');
Route::get('reportmastergudang/reportmastergudang', 'LaporanPurchaseController@reportmastergudang');
Route::get('reportmastersupplier/reportmastersupplier', 'LaporanPurchaseController@reportmastersupplier');
Route::get('reportfakturpembelian/reportfakturpembelian', 'LaporanPurchaseController@reportfakturpembelian');
Route::get('reportbayarkas/reportbayarkas', 'LaporanPurchaseController@reportbayarkas');
Route::get('reportbayarbank/reportbayarbank', 'LaporanPurchaseController@reportbayarbank');
Route::get('reportmutasihutang/reportmutasihutang', 'LaporanPurchaseController@reportmutasihutang');
Route::get('reportkartuhutang/reportkartuhutang', 'LaporanPurchaseController@reportkartuhutang');
Route::get('reportfakturpelunasan/reportfakturpelunasan', 'LaporanPurchaseController@reportfakturpelunasan');
Route::get('reportanalisausiahutang/reportanalisausiahutang', 'LaporanPurchaseController@reportanalisausiahutang');
Route::get('reportfakturpajakmasukan/reportfakturpajakmasukan', 'LaporanPurchaseController@reportfakturpajakmasukan');
Route::get('historisuangmukapembelian/historisuangmukapembelian', 'LaporanPurchaseController@historisuangmukapembelian');
Route::get('laporan_master_penjualan/tarif_cabang_dokumen', 'LaporanMasterController@tarif_cabang_dokumen');
Route::get('laporan_master_penjualan/tabledokumen', 'LaporanMasterController@tabledokumen')->name('dokumen');
Route::get('laporan_master_penjualan/tarif_cabang_koli', 'LaporanMasterController@tarif_cabang_koli');
Route::get('laporan_master_penjualan/tarif_cabang_kargo', 'LaporanMasterController@tarif_cabang_kargo');



//*** END PEMBELIAN



//**** PENJUALAN***
// Master Sales


//grup agen
Route::get('master_sales/agen', 'master_sales\agen_Controller@index');
Route::get('master_sales/agen/tabel', 'master_sales\agen_Controller@table_data');
Route::get('master_sales/agen/get_data', 'master_sales\agen_Controller@get_data');
Route::post('master_sales/agen/save_data', 'master_sales\agen_Controller@save_data');
Route::post('master_sales/agen/hapus_data', 'master_sales\agen_Controller@hapus_data');
// end agen

//grup vendor
Route::get('master_sales/vendor', 'master_sales\vendor_Controller@index');
Route::get('master_sales/vendor/tabel', 'master_sales\vendor_Controller@table_data');
Route::get('master_sales/vendor/get_data', 'master_sales\vendor_Controller@get_data');
Route::post('master_sales/vendor/save_data', 'master_sales\vendor_Controller@save_data');
Route::post('master_sales/vendor/hapus_data', 'master_sales\vendor_Controller@hapus_data');
// end vendor

//grup rute
Route::get('master_sales/rute', 'master_sales\rute_Controller@index');
Route::get('master_sales/ruteform', 'master_sales\rute_Controller@form');
Route::get('master_sales/ruteform/{nomor}/edit', 'master_sales\rute_Controller@form');
Route::get('master_sales/ruteform/{nomor}/hapus_data', 'master_sales\rute_Controller@hapus_data');
Route::get('master_sales/ruteform/tabel_data_detail', 'master_sales\rute_Controller@table_data_detail');
Route::get('master_sales/rute/tabel', 'master_sales\rute_Controller@table_data');
Route::get('master_sales/rute/get_data', 'master_sales\rute_Controller@get_data');
Route::get('master_sales/rute/get_data_detail', 'master_sales\rute_Controller@get_data_detail');
Route::post('master_sales/rute/save_data', 'master_sales\rute_Controller@save_data');
Route::post('master_sales/rute/save_data_detail', 'master_sales\rute_Controller@save_data_detail');
Route::post('master_sales/rute/hapus_data', 'master_sales\rute_Controller@hapus_data');
Route::post('master_sales/rute/hapus_data_detail', 'master_sales\rute_Controller@hapus_data_detail');
// end rute

//grup item
Route::get('master_sales/grup_item', 'master_sales\grup_item_Controller@index');
Route::get('master_sales/grup_item/tabel', 'master_sales\grup_item_Controller@table_data');
Route::get('master_sales/grup_item/get_data', 'master_sales\grup_item_Controller@get_data');
Route::post('master_sales/grup_item/save_data', 'master_sales\grup_item_Controller@save_data');
Route::post('master_sales/grup_item/hapus_data', 'master_sales\grup_item_Controller@hapus_data');
// end grup item


//pajak
Route::get('master_sales/pajak', 'master_sales\pajak_Controller@index');
Route::get('master_sales/pajak/tabel', 'master_sales\pajak_Controller@table_data');
Route::get('master_sales/pajak/get_data', 'master_sales\pajak_Controller@get_data');
Route::get('master_sales/pajak/save_data', 'master_sales\pajak_Controller@save_data');
Route::post('master_sales/pajak/hapus_data', 'master_sales\pajak_Controller@hapus_data');
// end pajak

//item
Route::get('master_sales/item', 'master_sales\item_Controller@index');
Route::get('master_sales/item/tabel', 'master_sales\item_Controller@table_data');
Route::get('master_sales/item/get_data', 'master_sales\item_Controller@get_data');
Route::post('master_sales/item/save_data', 'master_sales\item_Controller@save_data');
Route::post('master_sales/item/hapus_data', 'master_sales\item_Controller@hapus_data');
// end item


//satuan
Route::get('master_sales/satuan', 'master_sales\satuan_Controller@index');
Route::get('master_sales/satuan/tabel', 'master_sales\satuan_Controller@table_data');
Route::get('master_sales/satuan/get_data', 'master_sales\satuan_Controller@get_data');
Route::post('master_sales/satuan/save_data', 'master_sales\satuan_Controller@save_data');
Route::post('master_sales/satuan/hapus_data', 'master_sales\satuan_Controller@hapus_data');
// end satuan

//customer
Route::get('master_sales/customer', 'master_sales\customer_Controller@index');
Route::get('master_sales/customer/tabel', 'master_sales\customer_Controller@table_data');
Route::get('master_sales/customer/get_data', 'master_sales\customer_Controller@get_data');
Route::post('master_sales/customer/save_data', 'master_sales\customer_Controller@save_data');
Route::post('master_sales/customer/hapus_data', 'master_sales\customer_Controller@hapus_data');
// end customer


//biaya
Route::get('master_sales/biaya', function(){
        return view('master_sales.biaya.index');
});

//saldo piutang
Route::get('master_sales/saldopiutang', function(){
        return view('master_sales.saldo_piutang.index');
});

//Piutang lain
Route::get('master_sales/saldoawalpiutanglain', function(){
        return view('master_sales.piutang_lain.index');
});
Route::get('master_sales/saldoawalpiutanglainform', function(){
        return view('master_sales.piutang_lain.form');
});

//cabang
Route::get('master_sales/cabang', 'master_sales\cabang_Controller@index');
Route::get('master_sales/cabang/tabel', 'master_sales\cabang_Controller@table_data');
Route::get('master_sales/cabang/get_data', 'master_sales\cabang_Controller@get_data');
Route::post('master_sales/cabang/save_data', 'master_sales\cabang_Controller@save_data');
Route::post('master_sales/cabang/hapus_data', 'master_sales\cabang_Controller@hapus_data');
// end cabang

//subcon
Route::get('master_sales/subcon', 'master_sales\subcon_Controller@index');
Route::get('master_sales/subcon/tabel', 'master_sales\subcon_Controller@table_data');
Route::get('master_sales/subcon/get_data', 'master_sales\subcon_Controller@get_data');
Route::post('master_sales/subcon/save_data', 'master_sales\subcon_Controller@save_data');
Route::post('master_sales/subcon/hapus_data', 'master_sales\subcon_Controller@hapus_data');
// end subcon

//tipe angkutan
Route::get('master_sales/tipe_angkutan', 'master_sales\tipe_angkutan_Controller@index');
Route::get('master_sales/tipe_angkutan/tabel', 'master_sales\tipe_angkutan_Controller@table_data');
Route::get('master_sales/tipe_angkutan/get_data', 'master_sales\tipe_angkutan_Controller@get_data');
Route::post('master_sales/tipe_angkutan/save_data', 'master_sales\tipe_angkutan_Controller@save_data');
Route::post('master_sales/tipe_angkutan/hapus_data', 'master_sales\tipe_angkutan_Controller@hapus_data');
// end tipe angkutan

//kendaraan
Route::get('master_sales/kendaraan', 'master_sales\kendaraan_Controller@index');
Route::get('master_sales/kendaraan_form', 'master_sales\kendaraan_Controller@form');
Route::get('master_sales/kendaraan_form/{nomor}/edit', 'master_sales\kendaraan_Controller@form');
Route::get('master_sales/kendaraan_form/{nomor}/hapus_data', 'master_sales\kendaraan_Controller@hapus_data');
Route::post('master_sales/kendaraan/save_data', 'master_sales\kendaraan_Controller@save_data');
// end kendaraan

//Nomor seri pajak
Route::get('master_sales/nomorseripajak', function(){
        return view('master_sales.nomor_seri_pajak.index');
});


//---WILAYAH----------
//provinsi
Route::get('sales/provinsi', function(){
        return view('wilayah.provinsi.index');
});
Route::get('sales/provinsi/tabel', 'wilayah\provinsi_Controller@table_data');
Route::get('sales/provinsi/get_data', 'wilayah\provinsi_Controller@get_data');
Route::post('sales/provinsi/save_data', 'wilayah\provinsi_Controller@save_data');
Route::post('sales/provinsi/hapus_data', 'wilayah\provinsi_Controller@hapus_data');
//end provinsi


//kota
Route::get('sales/kota', 'wilayah\kota_Controller@index');
Route::get('sales/kota/tabel', 'wilayah\kota_Controller@table_data');
Route::get('sales/kota/get_data', 'wilayah\kota_Controller@get_data');
Route::post('sales/kota/save_data', 'wilayah\kota_Controller@save_data');
Route::post('sales/kota/hapus_data', 'wilayah\kota_Controller@hapus_data');
// end kota

//kecamatan
Route::get('sales/kecamatan', function(){
        return view('kota.kecamatan.index');
});



//TARIF
// tarif cabang dokumen
Route::get('sales/tarif_cabang_dokumen', 'tarif\cabang_dokumen_Controller@index');
Route::get('sales/tarif_cabang_dokumen/tabel', 'tarif\cabang_dokumen_Controller@table_data');
Route::get('sales/tarif_cabang_dokumen/get_data', 'tarif\cabang_dokumen_Controller@get_data');
Route::post('sales/tarif_cabang_dokumen/save_data', 'tarif\cabang_dokumen_Controller@save_data');
Route::post('sales/tarif_cabang_dokumen/hapus_data', 'tarif\cabang_dokumen_Controller@hapus_data');
// end tarif cabang dokumen

// tarif cabang kilogram
Route::get('sales/tarif_cabang_kilogram', 'tarif\cabang_kilogram_Controller@index');
Route::get('sales/tarif_cabang_kilogram/tabel', 'tarif\cabang_kilogram_Controller@table_data');
Route::get('sales/tarif_cabang_kilogram/get_data', 'tarif\cabang_kilogram_Controller@get_data');
Route::post('sales/tarif_cabang_kilogram/save_data', 'tarif\cabang_kilogram_Controller@save_data');
Route::post('sales/tarif_cabang_kilogram/hapus_data', 'tarif\cabang_kilogram_Controller@hapus_data');
// end tarif cabang kilogram

// tarif cabang koli
Route::get('sales/tarif_cabang_koli', 'tarif\cabang_koli_Controller@index');
Route::get('sales/tarif_cabang_koli/tabel', 'tarif\cabang_koli_Controller@table_data');
Route::get('sales/tarif_cabang_koli/get_data', 'tarif\cabang_koli_Controller@get_data');
Route::post('sales/tarif_cabang_koli/save_data', 'tarif\cabang_koli_Controller@save_data');
Route::post('sales/tarif_cabang_koli/hapus_data', 'tarif\cabang_koli_Controller@hapus_data');
// end tarif cabang koli

// tarif cabang kargo
Route::get('sales/tarif_cabang_kargo', 'tarif\cabang_kargo_Controller@index');
Route::get('sales/tarif_cabang_kargo/tabel', 'tarif\cabang_kargo_Controller@table_data');
Route::get('sales/tarif_cabang_kargo/get_data', 'tarif\cabang_kargo_Controller@get_data');
Route::post('sales/tarif_cabang_kargo/save_data', 'tarif\cabang_kargo_Controller@save_data');
Route::post('sales/tarif_cabang_kargo/hapus_data', 'tarif\cabang_kargo_Controller@hapus_data');
// end tarif cabang kargo

// tarif penerus default
Route::get('sales/tarif_penerus_default', 'tarif\penerus_default_Controller@index');
Route::get('sales/tarif_penerus_default/tabel', 'tarif\penerus_default_Controller@table_data');
Route::get('sales/tarif_penerus_default/get_data', 'tarif\penerus_default_Controller@get_data');
Route::post('sales/tarif_penerus_default/save_data', 'tarif\penerus_default_Controller@save_data');
Route::post('sales/tarif_penerus_default/hapus_data', 'tarif\penerus_default_Controller@hapus_data');
// end tarif penerus default

//kontrak
Route::get('master_sales/kontrak', 'master_sales\kontrak_Controller@index');
Route::get('master_sales/kontrak_form', 'master_sales\kontrak_Controller@form');
Route::get('master_sales/kontrak_form/{nomor}/edit', 'master_sales\kontrak_Controller@form');
Route::get('master_sales/kontrak_form/{nomor}/hapus_data', 'master_sales\kontrak_Controller@hapus_data');
Route::get('master_sales/kontrak_form/tabel_data_detail', 'master_sales\kontrak_Controller@table_data_detail');
Route::get('master_sales/kontrak/tabel', 'master_sales\kontrak_Controller@table_data');
Route::get('master_sales/kontrak/get_data', 'master_sales\kontrak_Controller@get_data');
Route::get('master_sales/kontrak/get_data_detail', 'master_sales\kontrak_Controller@get_data_detail');
Route::post('master_sales/kontrak/save_data', 'master_sales\kontrak_Controller@save_data');
Route::post('master_sales/kontrak/save_data_detail', 'master_sales\kontrak_Controller@save_data_detail');
Route::post('master_sales/kontrak/hapus_data', 'master_sales\kontrak_Controller@hapus_data');
Route::post('master_sales/kontrak/hapus_data_detail', 'master_sales\kontrak_Controller@hapus_data_detail');
// end kontrak


Route::get('sales/salesorder', function(){
        return view('sales.so.index');
});

Route::get('sales/salesorderform', function(){
        return view('sales.so.form');
});


//Tracking DO

Route::get('sales/deliveryordercabangtracking','trackingdoController@index');
Route::get('sales/deliveryordercabangtracking/table','trackingdoController@getdata');
Route::get('sales/deliveryordercabangtracking/autocomplete','trackingdoController@autocomplete');
Route::get('sales/deliveryordercabangtracking/getdata/{nomor}','trackingdoController@getdata');

// delivery order
Route::get('sales/deliveryorder', 'sales\do_Controller@index');
Route::get('sales/deliveryorderform', 'sales\do_Controller@form');
Route::get('sales/deliveryorderform/{nomor}/edit', 'sales\do_Controller@form');
Route::get('sales/deliveryorderform/tabel_data_detail', 'sales\do_Controller@table_data_detail');
Route::get('sales/deliveryorderform/get_data_detail', 'sales\do_Controller@get_data_detail');
Route::get('sales/deliveryorderform/tabel_item', 'sales\do_Controller@table_data_item');
Route::get('sales/deliveryorderform/get_item', 'sales\do_Controller@get_item');
Route::get('sales/deliveryorderform/cari_harga', 'sales\do_Controller@cari_harga');
Route::get('sales/deliveryorderform/cari_customer', 'sales\do_Controller@cari_customer');
Route::post('sales/deliveryorderform/save_data', 'sales\do_Controller@save_data');
Route::post('sales/deliveryorderform/save_data_detail', 'sales\do_Controller@save_data_detail');
Route::get('sales/deliveryorderform/{nomor}/hapus_data', 'sales\do_Controller@hapus_data');
Route::post('sales/deliveryorderform/hapus_data_detail', 'sales\do_Controller@hapus_data_detail');
Route::get('sales/deliveryorderform/{nomor}/update_status', 'sales\do_Controller@form_update_status');
Route::post('sales/deliveryorderform/save_update_status', 'sales\do_Controller@save_update_status');
Route::get('sales/deliveryorderform/{nomor}/nota', 'sales\do_Controller@cetak_nota');

//end delivery order

// delivery order kargo
Route::get('sales/deliveryorderkargo', 'sales\do_kargo_Controller@index');
Route::get('sales/deliveryorderkargoform', 'sales\do_kargo_Controller@form');
Route::get('sales/deliveryorderkargoform/{nomor}/edit', 'sales\do_kargo_Controller@form');
Route::get('sales/deliveryorderkargoform/tabel_data_detail', 'sales\do_kargo_Controller@table_data_detail');
Route::get('sales/deliveryorderkargoform/get_data_detail', 'sales\do_kargo_Controller@get_data_detail');
Route::get('sales/deliveryorderkargoform/tabel_item', 'sales\do_kargo_Controller@table_data_item');
Route::get('sales/deliveryorderkargoform/get_item', 'sales\do_kargo_Controller@get_item');
Route::get('sales/deliveryorderkargoform/cari_harga', 'sales\do_kargo_Controller@cari_harga');
Route::get('sales/deliveryorderkargoform/cari_customer', 'sales\do_kargo_Controller@cari_customer');
Route::post('sales/deliveryorderkargoform/save_data', 'sales\do_kargo_Controller@save_data');
Route::post('sales/deliveryorderkargoform/save_data_detail', 'sales\do_kargo_Controller@save_data_detail');
Route::get('sales/deliveryorderkargoform/{nomor}/hapus_data', 'sales\do_kargo_Controller@hapus_data');
Route::post('sales/deliveryorderkargoform/hapus_data_detail', 'sales\do_kargo_Controller@hapus_data_detail');
Route::get('sales/deliveryorderkargoform/{nomor}/update_status', 'sales\do_kargo_Controller@form_update_status');
Route::post('sales/deliveryorderkargoform/save_update_status', 'sales\do_kargo_Controller@save_update_status');
Route::get('sales/deliveryorderkargoform/{nomor}/nota', 'sales\do_kargo_Controller@cetak_nota');

//end delivery order kargo

//update status order cabang
Route::get('sales/updatestatusordercabang', function(){
        return view('sales.do_cabang.update_status');
});

//tracking dekivery order cabang
/*Route::get('sales/deliveryordercabangtracking', function(){
        return view('sales.do_cabang.tracking');
});*/

// surat jalan by trayek
Route::get('sales/surat_jalan_trayek', 'sales\surat_jalan_trayek_Controller@index');
Route::get('sales/surat_jalan_trayek_form/tampil_do', 'sales\surat_jalan_trayek_Controller@tampil_do');
Route::get('sales/surat_jalan_trayek_form', 'sales\surat_jalan_trayek_Controller@form');
Route::get('sales/surat_jalan_trayek_form/{nomor}/edit', 'sales\surat_jalan_trayek_Controller@form');
Route::get('sales/surat_jalan_trayek_form/{nomor}/hapus_data', 'sales\surat_jalan_trayek_Controller@hapus_data');
Route::get('sales/surat_jalan_trayek_form/tabel_data_detail', 'sales\surat_jalan_trayek_Controller@table_data_detail');
Route::get('sales/surat_jalan_trayek/tabel', 'sales\surat_jalan_trayek_Controller@table_data');
Route::get('sales/surat_jalan_trayek/get_data', 'sales\surat_jalan_trayek_Controller@get_data');
Route::get('sales/surat_jalan_trayek/get_data_detail', 'sales\surat_jalan_trayek_Controller@get_data_detail');
Route::post('sales/surat_jalan_trayek/save_data', 'sales\surat_jalan_trayek_Controller@save_data');
Route::post('sales/surat_jalan_trayek/save_data_detail', 'sales\surat_jalan_trayek_Controller@save_data_detail');
Route::post('sales/surat_jalan_trayek/hapus_data', 'sales\surat_jalan_trayek_Controller@hapus_data');
Route::post('sales/surat_jalan_trayek/hapus_data_detail', 'sales\surat_jalan_trayek_Controller@hapus_data_detail');
Route::get('sales/surat_jalan_trayek_form/{nomor}/nota', 'sales\surat_jalan_trayek_Controller@cetak_nota');
// end surat jalan by trayek



//invoice penjualan
Route::get('sales/invoice', 'sales\invoice_Controller@index');
Route::get('sales/invoice_form', 'sales\invoice_Controller@form');
Route::get('sales/invoice_form/tampil_do', 'sales\invoice_Controller@tampil_do');
Route::get('sales/invoice_form/{nomor}/edit', 'sales\invoice_Controller@form');
Route::get('sales/invoice_form/{nomor}/hapus_data', 'sales\invoice_Controller@hapus_data');
Route::get('sales/invoice_form/tabel_data_detail', 'sales\invoice_Controller@table_data_detail');
Route::get('sales/invoice/tabel', 'sales\invoice_Controller@table_data');
Route::get('sales/invoice/get_data', 'sales\invoice_Controller@get_data');
Route::get('sales/invoice/get_data_detail', 'sales\invoice_Controller@get_data_detail');
Route::post('sales/invoice/save_data', 'sales\invoice_Controller@save_data');
Route::post('sales/invoice/save_data_detail', 'sales\invoice_Controller@save_data_detail');
Route::post('sales/invoice/hapus_data', 'sales\invoice_Controller@hapus_data');
Route::post('sales/invoice/hapus_data_detail', 'sales\invoice_Controller@hapus_data_detail');
Route::get('sales/invoice_form/{nomor}/nota', 'sales\invoice_Controller@cetak_nota');
Route::get('sales/invoice_form/{nilai}/terbilang', 'sales\invoice_Controller@penyebut');
// end invoice

//invoice lain
Route::get('sales/invoice_lain', 'sales\invoice_lain_Controller@index');
Route::get('sales/invoice_lain/tabel', 'sales\invoice_lain_Controller@table_data');
Route::get('sales/invoice_lain/get_data', 'sales\invoice_lain_Controller@get_data');
Route::post('sales/invoice_lain/save_data', 'sales\invoice_lain_Controller@save_data');
Route::post('sales/invoice_lain/hapus_data', 'sales\invoice_lain_Controller@hapus_data');
// end invoice

Route::group(["prefix" => "surat"], function(){
    Route::get('/', [
      'uses' => "LaporanPurchaseController@surat",
      'as' => "report.surat"
    ]);
});

/* Create PDF */
Route::group(["prefix" => "table"], function(){
    Route::get('/master-item', [
        'uses' => 'LaporanPurchaseController@masterItemViewReport',
        'as' => 'masterItem.ViewReport'
    ]);

    Route::get('/master-item-group', [
      'uses' => 'LaporanPurchaseController@masterItemGroupViewReport',
      'as' => 'masterItemGroup.ViewReport'
    ]);

    Route::get('/master-department', [
      'uses' => 'LaporanPurchaseController@masterDepartmentViewReport',
      'as' => 'masterDepartment.ViewReport'
    ]);

    Route::get('/master-gudang', [
      'uses' => 'LaporanPurchaseController@masterGudangViewReport',
      'as' => 'masterGudang.ViewReport'
    ]);

    Route::get('/master-supplier', [
      'uses' => 'LaporanPurchaseController@masterSupplierViewReport',
      'as' => 'masterSupplier.ViewReport'
    ]);
});


//fakturpajak
Route::get('sales/fakturpajak', function(){
        return view('sales.faktur_pajak.index');
});

Route::get('sales/fakturpajakform', function(){
        return view('sales.faktur_pajak.form');
});

//penerimaanpenjualan
Route::get('sales/penerimaan_penjualan', 'sales\penerimaan_penjualan_Controller@index');
Route::get('sales/penerimaan_penjualan_form/tampil_invoice', 'sales\penerimaan_penjualan_Controller@tampil_invoice');
Route::get('sales/penerimaan_penjualan_form/tampil_invoice_biaya', 'sales\penerimaan_penjualan_Controller@tampil_invoice_biaya');
Route::get('sales/penerimaan_penjualan_form/get_data_akun_biaya', 'sales\penerimaan_penjualan_Controller@get_data_akun_biaya');
Route::get('sales/penerimaan_penjualan_form/tampil_riwayat_invoice', 'sales\penerimaan_penjualan_Controller@tampil_riwayat_invoice');
Route::get('sales/penerimaan_penjualan_form', 'sales\penerimaan_penjualan_Controller@form');
Route::get('sales/penerimaan_penjualan_form/{nomor}/edit', 'sales\penerimaan_penjualan_Controller@form');
Route::get('sales/penerimaan_penjualan_form/{nomor}/hapus_data', 'sales\penerimaan_penjualan_Controller@hapus_data');
Route::get('sales/penerimaan_penjualan_form/tabel_data_detail', 'sales\penerimaan_penjualan_Controller@table_data_detail');
Route::get('sales/penerimaan_penjualan_form/tabel_data_detail_biaya', 'sales\penerimaan_penjualan_Controller@table_data_detail_biaya');
Route::get('sales/penerimaan_penjualan/tabel', 'sales\penerimaan_penjualan_Controller@table_data');
Route::get('sales/penerimaan_penjualan/get_data', 'sales\penerimaan_penjualan_Controller@get_data');
Route::get('sales/penerimaan_penjualan/get_data_detail', 'sales\penerimaan_penjualan_Controller@get_data_detail');
Route::post('sales/penerimaan_penjualan/save_data', 'sales\penerimaan_penjualan_Controller@save_data');
Route::post('sales/penerimaan_penjualan/save_data_detail', 'sales\penerimaan_penjualan_Controller@save_data_detail');
Route::post('sales/penerimaan_penjualan/save_data_detail2', 'sales\penerimaan_penjualan_Controller@save_data_detail2');
Route::post('sales/penerimaan_penjualan/save_data_detail_biaya', 'sales\penerimaan_penjualan_Controller@save_data_detail_biaya');
Route::post('sales/penerimaan_penjualan/hapus_data', 'sales\penerimaan_penjualan_Controller@hapus_data');
Route::post('sales/penerimaan_penjualan/hapus_data_detail', 'sales\penerimaan_penjualan_Controller@hapus_data_detail');
Route::post('sales/penerimaan_penjualan/hapus_data_detail_biaya', 'sales\penerimaan_penjualan_Controller@hapus_data_detail_biaya');
Route::get('sales/penerimaan_penjualan/{nomor}/nota', 'sales\penerimaan_penjualan_Controller@cetak_nota');

//end penerimaan penjualan

//posting_pembayaran
Route::get('sales/posting_pembayaran', 'sales\posting_pembayaran_Controller@index');
Route::get('sales/posting_pembayaran_form/tampil_penerimaan_penjualan', 'sales\posting_pembayaran_Controller@tampil_penerimaan_penjualan');
Route::get('sales/posting_pembayaran_form', 'sales\posting_pembayaran_Controller@form');
Route::get('sales/posting_pembayaran_form/{nomor}/edit', 'sales\posting_pembayaran_Controller@form');
Route::get('sales/posting_pembayaran_form/{nomor}/hapus_data', 'sales\posting_pembayaran_Controller@hapus_data');
Route::get('sales/posting_pembayaran_form/tabel_data_detail', 'sales\posting_pembayaran_Controller@table_data_detail');
Route::get('sales/posting_pembayaran/tabel', 'sales\posting_pembayaran_Controller@table_data');
Route::get('sales/posting_pembayaran/get_data', 'sales\posting_pembayaran_Controller@get_data');
Route::get('sales/posting_pembayaran/get_data_detail', 'sales\posting_pembayaran_Controller@get_data_detail');
Route::post('sales/posting_pembayaran/save_data', 'sales\posting_pembayaran_Controller@save_data');
Route::post('sales/posting_pembayaran/save_data_detail', 'sales\posting_pembayaran_Controller@save_data_detail');
Route::post('sales/posting_pembayaran/hapus_data', 'sales\posting_pembayaran_Controller@hapus_data');
Route::post('sales/posting_pembayaran/hapus_data_detail', 'sales\posting_pembayaran_Controller@hapus_data_detail');

//end penerimaan penjualan

//Route::get('sales/salesorderform', 'so_Controller@so_form');

// LAPORAN PENJUALAN
//laporan sales order
Route::get('sales/laporansalesorder', function(){
        return view('laporan_sales.so.index');
});

//laporan delivery order
Route::get('sales/laporandeliveryorder', function(){
        return view('laporan_sales.do.index');
});

Route::group(["prefix" => "sales"], function(){

  Route::get("/do-home", [
        'uses' => 'sales\DeliveryOrderController@index',
        'as' => 'DelOrder.index'
    ]);

  Route::get("/add-delivery-order", [
        'uses' => 'sales\DeliveryOrderController@redirectToAddForm',
        'as' => 'DelOrder.redirect'
  ]);
  
  Route::post("/post-delivery-order", [
        'uses' => 'sales\DeliveryOrderController@store',
        'as' => 'DelOrder.store' 
  ]);

  Route::get("/edit/{id}/DO-tanpa-sales-order", [
        'uses' => 'sales\DeliveryOrderController@edit',
        'as' => 'DelOrder.edit'
  ]);

  Route::patch("/update/{id}/update-DO-tanpa-sales-order", [
        'uses' => 'sales\DeliveryOrderController@update',
        'as' => 'DelOrder.update'
  ]);

  Route::delete("/destroy/{id}/delete-DO-tanpa-sales-order", [
        'uses' => 'sales\DeliveryOrderController@destroy',
        'as' => 'DelOrder.destroy'
  ]);
});

//laporan penjualan
Route::get('sales/laporaninvoicepenjualan', function(){
        return view('laporan_sales.penjualan.index');
});

//laporan penjualan per item
Route::get('sales/laporaninvoicepenjualanperitem', function(){
        return view('laporan_sales.penjualan_per_item.index');
});

//kartu piutang
Route::get('laporan_sales/kartu_piutang', 'laporan_sales\kartu_piutang_Controller@index');
Route::get('laporan_sales/kartu_piutang/tampil_data', 'laporan_sales\kartu_piutang_Controller@tampil_kartu_piutang');
// end kartu piutang

//analisa piutang
Route::get('laporan_sales/analisa_piutang', 'laporan_sales\analisa_piutang_Controller@index');
Route::get('laporan_sales/analisa_piutang/tampil_data', 'laporan_sales\analisa_piutang_Controller@tampil_analisa_piutang');
// end analisa piutang

//mutasi piutang
Route::get('laporan_sales/mutasi_piutang', 'laporan_sales\mutasi_piutang_Controller@index');
Route::get('laporan_sales/mutasi_piutang/tampil_data', 'laporan_sales\mutasi_piutang_Controller@tampil_mutasi_piutang');
// end mutasi piutang

//piutang jatuh tempo
Route::get('sales/laporanpiutangjatuhtempo', function(){
        return view('laporan_sales.piutang_jatuh_tempo.index');
});


//form_surat_surat

//1
Route::get('form_surat_surat/pengalamankerja', function(){
        return view('form_surat_surat.pengalamankerja');
});
Route::get('printSurat', 'SuratController@pdf_pengalamankerja');

//2
Route::get('form_surat_surat/tidaklagibekerja', function(){
        return view('form_surat_surat.tidaklagibekerja');
});
Route::get('SuratTidakLagiBekerja', 'SuratController@pdf_tidaklagibekerja');

//3
Route::get('form_surat_surat/legalisirdataupah', function(){
        return view('form_surat_surat.legalisirdataupah');
});
Route::get('LegalisirDataUpah', 'SuratController@pdf_legalisirdataupah');

//4
Route::get('form_surat_surat/surattidakaktifBPJS', function(){
        return view('form_surat_surat.surattidakaktifBPJS');
});
Route::get('surattidakaktifBPJS', 'SuratController@pdf_surattidakaktifBPJS');

//5
Route::get('form_surat_surat/suratlaporanpekerjaresign', function(){
        return view('form_surat_surat.suratlaporanpekerjaresign');
});
Route::get('suratlaporanpekerjaresign', 'SuratController@pdf_suratlaporanpekerjaresign');

//6
Route::get('form_surat_surat/pengajuanpinjambank', function(){
        return view('form_surat_surat.pengajuanpinjambank');
});
Route::get('suratpengajuanpinjambank', 'SuratController@pdf_suratpengajuanpinjambank');

//7
Route::get('form_surat_surat/pengantarpendaftaranbpjskesehatan', function(){
        return view('form_surat_surat.pengantarpendaftaranbpjskesehatan');
});
Route::get('suratpengantarpendaftaranbpjskesehatan', 'SuratController@pdf_suratpengantarpendaftaranbpjskesehatan');

//8
Route::get('form_surat_surat/keterangankerjapengajuankpr', function(){
        return view('form_surat_surat.keterangankerjapengajuankpr');
});
Route::get('suratketerangankerjapengajuankpr', 'SuratController@pdf_suratketerangankerjapengajuankpr');
//9
Route::get('form_surat_surat/keterangankerjapengajuankpr', function(){
        return view('form_surat_surat.keterangankerjapengajuankpr');
});
Route::get('suratketerangankerjapengajuankpr', 'SuratController@pdf_suratketerangankerjapengajuankpr');




//********KEUANGAN********
//kelompok akun
Route::get('master_keuangan/kelompok_akun', 'master_keuangan\kelompok_akun_Controller@index');
Route::get('master_keuangan/kelompok_akun/tabel', 'master_keuangan\kelompok_akun_Controller@table_data');
Route::get('master_keuangan/kelompok_akun/get_data', 'master_keuangan\kelompok_akun_Controller@get_data');
Route::post('master_keuangan/kelompok_akun/save_data', 'master_keuangan\kelompok_akun_Controller@save_data');
Route::post('master_keuangan/kelompok_akun/hapus_data', 'master_keuangan\kelompok_akun_Controller@hapus_data');
// end kelompok akun

//saldo akun

Route::get('master_keuangan/saldo_akun', [
  'uses' => 'master_keuangan\saldo_akun_controller@index',
  'as'   => 'saldo_akun.index'
]);

Route::get('master_keuangan/saldo_akun/add/{parrent}', [
  'uses' => 'master_keuangan\saldo_akun_controller@add',
  'as'   => 'saldo_akun.add'
]);

Route::post('master_keuangan/saldo_akun/save_data', [
  'uses' => 'master_keuangan\saldo_akun_controller@save_data',
  'as'   => 'saldo_akun.save'
]);

//end saldo akun

// jurnal_umum
Route::get('keuangan/jurnal_umum', [
  'uses' => 'master_keuangan\d_jurnal_controller@index',
  'as'   => 'jurnal.index'
]);

Route::get('keuangan/jurnal_umum/add', [
  'uses' => 'master_keuangan\d_jurnal_controller@add',
  'as'   => 'jurnal.add'
]);

Route::get('keuangan/jurnal_umum/detail/{id}', [
  'uses' => 'master_keuangan\d_jurnal_controller@getDetail',
  'as'   => 'jurnal.detail'
]);

Route::post('keuangan/jurnal_umum/save_data', [
  'uses'  => 'master_keuangan\d_jurnal_controller@save_data',
  'as'    => 'jurnal.save'
]);

Route::get('keuangan/jurnal_umum/show-detail/{id}', [
  'uses' => 'master_keuangan\d_jurnal_controller@showDetail',
  'as'   => 'jurnal.show-detail;'
]);

Route::get('keuangan/jurnal_umumform', 'operasional_keuangan\jurnal_umum_Controller@form');
Route::get('keuangan/jurnal_umumform/{nomor}/edit', 'operasional_keuangan\jurnal_umum_Controller@form');
Route::get('keuangan/jurnal_umumform/tabel_data_detail', 'operasional_keuangan\jurnal_umum_Controller@table_data_detail');
Route::get('keuangan/jurnal_umumform/get_data_detail', 'operasional_keuangan\jurnal_umum_Controller@get_data_detail');

Route::post('keuangan/jurnal_umumform/save_data_detail', 'operasional_keuangan\jurnal_umum_Controller@save_data_detail');
Route::get('keuangan/jurnal_umumform/{nomor}/hapus_data', 'operasional_keuangan\jurnal_umum_Controller@hapus_data');
Route::post('keuangan/jurnal_umumform/hapus_data_detail', 'operasional_keuangan\jurnal_umum_Controller@hapus_data_detail');
Route::post('keuangan/jurnal_umumform/save_update_status', 'operasional_keuangan\jurnal_umum_Controller@save_update_status');

//end jurnal_umum

//akun
Route::get('master_keuangan/akun', [
  'uses' => 'master_keuangan\akun_Controller@index',
  'as'   => 'akun.index'
]);

Route::get('master_keuangan/add/{parrent}', [
  'uses' => 'master_keuangan\akun_Controller@add',
  'as'   => 'akun.add'
]);

Route::get('master_keuangan/edit/{parrent}', [
  'uses' => 'master_keuangan\akun_Controller@edit',
  'as'   => 'akun.edit'
]);

Route::post('master_keuangan/akun/save_data', [
  'uses' => 'master_keuangan\akun_Controller@save_data',
  'as'   => 'akun.save'
]);

Route::post('master_keuangan/akun/update_data/{id}', [
  'uses' => 'master_keuangan\akun_Controller@update_data',
  'as'   => 'akun.update'
]);

Route::get('master_keuangan/akun/kota/{id_provinsi}', [
  'uses' => 'master_keuangan\akun_Controller@kota',
  'as'   => 'akun.kota'
]);

Route::get('master_keuangan/akun/hapus_data/{id}', [
  'uses'=> 'master_keuangan\akun_Controller@hapus_data',
  'as'  => 'akun.hapus'

]);

Route::get('master_keuangan/akun/cek_parrent/{id}', [
  'uses'=> 'master_keuangan\akun_Controller@cek_parrent',
  'as'  => 'akun.cek_parrent'

]);

Route::get('master_keuangan/akun/tabel', 'master_keuangan\akun_Controller@table_data');
Route::get('master_keuangan/akun/get_data', 'master_keuangan\akun_Controller@get_data');

// end akun

// penerimaan
Route::get('keuangan/penerimaan', 'operasional_keuangan\penerimaan_Controller@index');
Route::get('keuangan/penerimaanform', 'operasional_keuangan\penerimaan_Controller@form');
Route::get('keuangan/penerimaanform/{nomor}/edit', 'operasional_keuangan\penerimaan_Controller@form');
Route::get('keuangan/penerimaanform/tabel_data_detail', 'operasional_keuangan\penerimaan_Controller@table_data_detail');
Route::get('keuangan/penerimaanform/get_data_detail', 'operasional_keuangan\penerimaan_Controller@get_data_detail');
Route::post('keuangan/penerimaanform/save_data', 'operasional_keuangan\penerimaan_Controller@save_data');
Route::post('keuangan/penerimaanform/save_data_detail', 'operasional_keuangan\penerimaan_Controller@save_data_detail');
Route::get('keuangan/penerimaanform/{nomor}/hapus_data', 'operasional_keuangan\penerimaan_Controller@hapus_data');
Route::post('keuangan/penerimaanform/hapus_data_detail', 'operasional_keuangan\penerimaan_Controller@hapus_data_detail');
Route::post('keuangan/penerimaanform/save_update_status', 'operasional_keuangan\penerimaan_Controller@save_update_status');

//end penerimaan
// pengeluaran
Route::get('keuangan/pengeluaran', 'operasional_keuangan\pengeluaran_Controller@index');
Route::get('keuangan/pengeluaranform', 'operasional_keuangan\pengeluaran_Controller@form');
Route::get('keuangan/pengeluaranform/{nomor}/edit', 'operasional_keuangan\pengeluaran_Controller@form');
Route::get('keuangan/pengeluaranform/tabel_data_detail', 'operasional_keuangan\pengeluaran_Controller@table_data_detail');
Route::get('keuangan/pengeluaranform/get_data_detail', 'operasional_keuangan\pengeluaran_Controller@get_data_detail');
Route::post('keuangan/pengeluaranform/save_data', 'operasional_keuangan\pengeluaran_Controller@save_data');
Route::post('keuangan/pengeluaranform/save_data_detail', 'operasional_keuangan\pengeluaran_Controller@save_data_detail');
Route::get('keuangan/pengeluaranform/{nomor}/hapus_data', 'operasional_keuangan\pengeluaran_Controller@hapus_data');
Route::post('keuangan/pengeluaranform/hapus_data_detail', 'operasional_keuangan\pengeluaran_Controller@hapus_data_detail');
Route::post('keuangan/pengeluaranform/save_update_status', 'operasional_keuangan\pengeluaran_Controller@save_update_status');

//end pengeluaran

//END KEUANGAN

// master hrd canasta
Route::get('master_hrd/index', function(){
        return view('master_hrd.index');
       });
Route::get('master_hrd/index2', function(){
        return view('master_hrd.index2');
       });
Route::get('master_hrd/index3', function(){
        return view('master_hrd.index3');
       });
Route::get('master_hrd/create1', function(){
        return view('master_hrd.create1');
       });
Route::get('master_hrd/edit1', function(){
        return view('master_hrd.edit1');
       });
Route::get('master_hrd/create2', function(){
        return view('master_hrd.create2');
       });
Route::get('master_hrd/edit2', function(){
        return view('master_hrd.edit2');
       });
Route::get('master_hrd/create3', function(){
        return view('master_hrd.create3');
       });
Route::get('master_hrd/edit3', function(){
        return view('master_hrd.edit3');
       });
// BPJS
Route::get('bpjs/datapeserta', function(){
        return view('bpjs.datapeserta');
       });
Route::get('bpjs/input_datapeserta', function(){
        return view('bpjs.input_datapeserta');
       });
Route::get('bpjs/edit_datapeserta', function(){
        return view('bpjs.edit_datapeserta');
       });
Route::get('bpjs/cetak_datapeserta', function(){
        return view('bpjs.cetak_datapeserta');
       });
Route::get('bpjs/daftarbpjs', function(){
        return view('bpjs.daftarbpjs');
       });
Route::get('bpjs/input_daftarbpjs', function(){
        return view('bpjs.input_daftarbpjs');
       });
Route::get('bpjs/edit_daftarbpjs', function(){
        return view('bpjs.edit_daftarbpjs');
       });
Route::get('bpjs/cetak_daftarbpjs', function(){
        return view('bpjs.cetak_daftarbpjs');
       });
Route::get('bpjs/keluarbpjs', function(){
        return view('bpjs.keluarbpjs');
       });
Route::get('bpjs/input_keluarbpjs', function(){
        return view('bpjs.input_keluarbpjs');
       });
Route::get('bpjs/edit_keluarbpjs', function(){
        return view('bpjs.edit_keluarbpjs');
       });
Route::get('bpjs/cetak_keluarbpjs', function(){
        return view('bpjs.cetak_keluarbpjs');
       });
Route::get('bpjs/rbh', function(){
        return view('bpjs.rbh');
       });
Route::get('bpjs/cetak_rbh', function(){
        return view('bpjs.cetak_rbh');
       });

//penggajian

//daftargaji
Route::get('penggajian/daftargaji', function(){
        return view('penggajian.daftargaji');
       });
Route::get('penggajian/input_daftargaji', function(){
        return view('penggajian.input_daftargaji');
       });
Route::get('penggajian/edit_daftargaji', function(){
        return view('penggajian.edit_daftargaji');
       });
Route::get('penggajian/cetak_daftargaji', function(){
        return view('penggajian.cetak_daftargaji');
       });


//master upah tenaga kerja
Route::get('penggajian/master_upah_tenaga_kerja', function(){
        return view('penggajian.master_upah_tenaga_kerja');
       });
Route::get('penggajian/input_daftarupahtenagakerja', function(){
        return view('penggajian.input_daftarupahtenagakerja');
       });
Route::get('penggajian/edit_master_upah_tenaga_kerja', function(){
        return view('penggajian.edit_master_upah_tenaga_kerja');
       });

// MANAGEMENT KEUANGAN
Route::get('keuangan/aruskas', function(){
        return view('keuangan.aruskas');
       });
Route::get('keuangan/neraca', function(){
        return view('keuangan.neraca');
       });
Route::get('keuangan/labarugi', function(){
        return view('keuangan.labarugi');
       });
Route::get('keuangan/hutang', function(){
        return view('keuangan.hutang');
       });
Route::get('keuangan/piutang', function(){
        return view('keuangan.piutang');
       });

// PTJKI

Route::get('pjtki/index', function(){
        return view('pjtki.index');
       });
Route::get('pjtki/index3', function(){
        return view('pjtki.index3');
       });
Route::get('pjtki/create1', function(){
        return view('pjtki.create1');
       });
Route::get('pjtki/edit1', function(){
        return view('pjtki.edit1');
       });
Route::get('pjtki/create3', function(){
        return view('pjtki.create3');
       });

Route::get('master-keuangan/laporan-neraca',  'laporan_neracaController@index');
Route::get('laporan-neraca/index',  'laporan_neracaController@neraca');
Route::get('master-keuangan/laporan-laba-rugi',  'laba_rugiController@index');



Route::get('pjtki/edit3', function(){
        return view('pjtki.edit3');
       });
//Data Update Status
//Data Update Status
Route::get('updatestatus','update_o_Controller@index');
Route::get('updatestatus/up1','update_o_Controller@up1');
Route::get('updatestatus/up2','update_o_Controller@up2');
Route::get('updatestatus/up2/autocomplete','update_o_Controller@autocomplete');
Route::get('updatestatus/store1','update_o_Controller@store1');
Route::get('updatestatus/store2','update_o_Controller@store2');
Route::get('updatestatus/data1/{nomor_do}','update_o_Controller@data1');
Route::get('updatestatus/data2/{nomor}','update_o_Controller@data2');

//Po PRINT
Route::get('purchaseorder/print/{id}', 'PurchaseController@cetak');
Route::get('kwitansi', 'kwitansiController@kwitansi');
Route::get('invoice',  'kwitansiController@invoice');
Route::get('pembayaran_outlet',  'kwitansiController@outlet');
Route::get('suratjalan',  'kwitansiController@suratjalan');
Route::get('nota',  'kwitansiController@nota');
Route::get('faktur_pembelian',  'kwitansiController@faktur');
Route::get('fpg',  'kwitansiController@fpg');
Route::get('po',  'kwitansiController@po');