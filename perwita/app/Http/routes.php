

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
// Route::get('/', function(){
//     return view('auth.login');
// });
// Route::get('/dashboard', function(){
//     return view('coba');
// });

Route::get('/halaman_kosong', function(){
    return view('kosong');
});

Route::group(['middleware' => 'guest'], function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('index');

    Route::get('login', 'loginController@authenticate');
    Route::post('login', 'loginController@authenticate');
});

/*Route::get('/', function(){
    return view('auth.login');
});*/

Route::group(['middleware' => 'auth'], function () {
Route::get('/dashboard','dashboardController@dashboard');

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

Route::get('setting/groupbaru', 'setting\groupController@groupbaru');

Route::get('setting/daftarmenu', 'setting\groupController@daftarmenu');
Route::get('setting/createdaftarmenu', 'setting\groupController@createdaftarmenu');
Route::get('setting/savedaftarmenu', 'setting\groupController@savedaftarmenu');
// end pengguna

//hak_akses
Route::get('setting/hak_akses', 'setting\hak_akses_Controller@index');
Route::get('setting/hak_akses/cari_data', 'setting\hak_akses_Controller@cari_data');
Route::get('setting/hak_akses/add_level', 'setting\hak_akses_Controller@form');
Route::get('setting/hak_akses/simpan_perubahan', 'setting\hak_akses_Controller@simpan_perubahan');
Route::post('setting/hak_akses/simpan_perubahan', 'setting\hak_akses_Controller@simpan_perubahan');
Route::get('setting/hak_akses/{level}/edit_level', 'setting\hak_akses_Controller@edit');
Route::post('setting/hak_akses/edit_data', 'setting\hak_akses_Controller@edit_data');
Route::get('setting/hak_akses/tabel', 'setting\hak_akses_Controller@table_data');
Route::get('setting/hak_akses/datatable_hak_akses', 'setting\hak_akses_Controller@datatable_hak_akses')->name('datatable_hak_akses');
//Route::get('setting/hak_akses/get_data', 'setting\hak_akses_Controller@get_data');
Route::post('setting/hak_akses/save_data', 'setting\hak_akses_Controller@save_data');
Route::post('setting/hak_akses/hapus_data', 'setting\hak_akses_Controller@hapus_data');
Route::post('setting/hak_akses/edit_hak_akses', 'setting\hak_akses_Controller@edit_hak_akses');
// end hak_akses
// synchronize jurnal
Route::get('setting/sync_jurnal', 'selaras_jurnal@sync_jurnal');
Route::get('setting/sync_jurnal/biaya_penerus_kas', 'selaras_jurnal@biaya_penerus_kas');
Route::get('setting/sync_jurnal/bukti_kas_keluar', 'selaras_jurnal@bukti_kas_keluar');
Route::get('setting/sync_jurnal/invoice', 'selaras_jurnal@invoice');
Route::get('setting/sync_jurnal/master_akun_fitur', 'selaras_jurnal@master_akun_fitur');
Route::get('setting/sync_jurnal/nilai_invoice', 'selaras_jurnal@nilai_invoice');

Route::get('jurnalselaras/jurnalselaras', 'jurnal_pembelian@index');
Route::get('jurnalselaras/fakturpembelian', 'jurnal_pembelian@fakturpembelian');
Route::post('jurnalselaras/item', 'jurnal_pembelian@item');
Route::post('jurnalselaras/notafpg', 'jurnal_pembelian@nofpg');
Route::post('jurnalselaras/tglpo', 'jurnal_pembelian@tglpo');
Route::post('jurnalselaras/fpgbankmasuk', 'jurnal_pembelian@fpgbankmasuk');
Route::get('jurnalselaras/duplicatebank', 'jurnal_pembelian@duplicatebank');
Route::get('jurnalselaras/fpgpostingbank', 'jurnal_pembelian@getupdatefpgbbk');
Route::get('jurnalselaras/notafpgbbkab', 'jurnal_pembelian@nofpgbbkab');
Route::get('jurnalselaras/notaspp', 'jurnal_pembelian@gantispp');
Route::get('jurnalselaras/bankmasuk', 'jurnal_pembelian@bankmasuk');
Route::get('jurnalselaras/kasmasuk', 'jurnal_pembelian@kasmasuk');
Route::get('jurnalselaras/fpg_checkbank', 'jurnal_pembelian@fpg_checkbank');
Route::get('jurnalselaras/get_no_po', 'jurnal_pembelian@get_no_po');

//***PEMBELIAN
//***PEMBELIAN
// Route::get('tes' , 'sales\invoice_Controller@index');

Route::get('kartuhutangrekap' , 'Queryanalisa@kartuhutangrekap');
Route::get('kartuhutangdetail' , 'Queryanalisa@kartuhutangdetail');
Route::get('rekapmutasihutang' , 'Queryanalisa@rekapmutasihutang');
Route::get('rekapmutasihutang' , 'Queryanalisa@rekapmutasihutang');
Route::get('detailmutasihutang' , 'Queryanalisa@detailmutasihutang');
Route::get('rekapanalisahutang' , 'Queryanalisa@rekapanalisahutang');
Route::get('detailanalisahutang' , 'Queryanalisa@detailanalisahutang');



Route::get('suratpermintaanpembelian' , 'PurchaseController@spp_index');
Route::post('suratpermintaanpembelian/savesupplier' , 'PurchaseController@savespp');
Route::post('suratpermintaanpembelian/updatesupplier/{id}' , 'PurchaseController@updatespp');
Route::get('suratpermintaanpembelian/createspp' , 'PurchaseController@createspp');
Route::get('suratpermintaanpembelian/detailspp/{id}' , 'PurchaseController@detailspp');
Route::delete('suratpermintaanpembelian/deletespp/{id}' , 'PurchaseController@deletespp');
Route::post('suratpermintaanpembelian/ajax_supplier' , 'PurchaseController@ajax_supplier');
Route::get('suratpermintaanpembelian/ajax_hargasupplier', 'PurchaseController@ajax_hargasupplier');
Route::post('suratpermintaanpembelian/ajax_jenisitem/', 'PurchaseController@ajax_jenisitem');
Route::get('suratpermintaanpembelian/statusspp/{id}', 'PurchaseController@statusspp');
Route::get('suratpermintaanpembelian/createPDF/{id}', 'PurchaseController@createPdfSpp');
Route::get('suratpermintaanpembelian/getnospp', 'PurchaseController@getnospp');
Route::get('suratpermintaanpembelian/cetakspp/{id}', 'PurchaseController@cetakspp');
Route::get('suratpermintaanpembelian/editspp/{id}', 'PurchaseController@editspp');
Route::get('suratpermintaanpembelian/valgudang', 'PurchaseController@valgudang');
Route::get('suratpermintaanpembelian/kettolak', 'PurchaseController@kettolakspp');
Route::post('suratpermintaanpembelian/setujukabag', 'PurchaseController@sppsetujukabag');



Route::get('testing/analisa', 'PurchaseController@queryanalisa');

Route::get('konfirmasi_order/konfirmasi_order' , 'PurchaseController@confirm_order');
Route::get('konfirmasi_order/konfirmasi_orderdetailkeu/{id}' , 'PurchaseController@confirm_order_dtkeu');
Route::get('konfirmasi_order/konfirmasi_orderdetailpemb/{id}' , 'PurchaseController@confirm_order_dtpemb');
Route::get('konfirmasi_order/ajax_confirmorderdt' , 'PurchaseController@ajax_confirmorderdt');
Route::post('konfirmasi_order/gettotalbiaya' , 'PurchaseController@get_tb');
Route::post('konfirmasi_order/savekonfirmasiorderdetail' , 'PurchaseController@saveconfirmorderdt');
Route::get('konfirmasi_order/cetakkonfirmasi/{id}' , 'PurchaseController@cetakkonfirmasi');
Route::get('konfirmasi_order/ceksupplier' , 'PurchaseController@ceksupplier');
Route::get('konfirmasi_order/cekharga' , 'PurchaseController@cekharga');


Route::get('purchaseorder/ajax', 'PurchaseController@createAjax');
Route::get('purchaseorder/outputsuratspp', 'PurchaseController@pdf_spp');
Route::get('purchaseorder/purchaseorder', 'PurchaseController@purchase_order');
Route::get('purchaseorder/detail/{id}', 'PurchaseController@detailpurchase');
Route::get('purchaseorder/purchasedetail/{id}', 'PurchaseController@purchasedetail');
Route::get('purchaseorder/createpurchase', 'PurchaseController@createpurchase');
Route::get('purchaseorder/ajax_tampilspp', 'PurchaseController@ajax_tampilspp');
Route::post('purchaseorder/savepurchase', 'PurchaseController@savepurchase');
Route::post('purchaseorder/updatepurchase/{id}', 'PurchaseController@updatepurchase');
Route::get('purchaseorder/print/{id}', 'PurchaseController@cetak');
Route::post('purchaseorder/detailpurchasekeuangan', 'PurchaseController@detailpurchasekeuangan');
Route::post('purchaseorder/updatekeuangan', 'PurchaseController@updatekeuangan');
Route::post('purchaseorder/getcabang', 'PurchaseController@getcabang');
Route::get('purchaseorder/grapcabang', 'PurchaseController@grapcabang');
Route::get('purchaseorder/deletepurchase/{id}', 'PurchaseController@deletepurchase');


/*warehouse */
Route::get('penerimaanbarang/penerimaanbarang', 'PurchaseController@penerimaanbarang');
Route::get('penerimaanbarang/detailterimabarang/{id}/{flag}', 'PurchaseController@detailterimabarang');
Route::get('penerimaanbarang/laporanpenerimaan/{id}', 'PurchaseController@laporanpenerimaan');
Route::post('penerimaanbarang/savepenerimaan', 'PurchaseController@savepenerimaan');
Route::get('penerimaanbarang/savepenerimaan', 'PurchaseController@savepenerimaan');
Route::get('penerimaanbarang/gettampil', 'PurchaseController@ajaxpenerimaan');
Route::get('penerimaanbarang/ajaxtampilterima', 'PurchaseController@ajax_tampilterima');
Route::get('penerimaanbarang/changeqtyterima', 'PurchaseController@changeqtyterima');
Route::post('penerimaanbarang/updatepenerimaanbarang', 'PurchaseController@updatepenerimaanbarang');
Route::get('penerimaanbarang/penerimaanbarang/createPDF/{id}', 'PurchaseController@createPdfTerimaBarang');
Route::get('penerimaanbarang/penerimaanbarang/cetak/{id}', 'PurchaseController@cetakterimabarang');
Route::post('penerimaanbarang/cekgudang', 'PurchaseController@cekgudang');
Route::get('penerimaanbarang/detailterimabarang/{id}', 'PurchaseController@detailterimabarang');
Route::get('penerimaanbarang/valgudang', 'PurchaseController@valgudang');
Route::get('penerimaanbarang/hapusdatapenerimaan', 'PurchaseController@hapusdatapenerimaan');
Route::get('penerimaanbarang/lihatjurnal', 'PurchaseController@lihatjurnal');



// PENGELUARAN BARANG
Route::get('pengeluaranbarang/pengeluaranbarang', 'PengeluaranBarangController@index');
Route::get('pengeluaranbarang/edit/{id}', 'PengeluaranBarangController@edit');
Route::get('pengeluaranbarang/akun_biaya_dropdown', 'PengeluaranBarangController@akun_biaya_dropdown');
Route::get('pengeluaranbarang/cari_stock', 'PengeluaranBarangController@cari_stock');
Route::get('pengeluaranbarang/createpengeluaranbarang', 'PengeluaranBarangController@create');
Route::get('pengeluaranbarang/ganti_nota', 'PengeluaranBarangController@ganti_nota');
Route::get('pengeluaranbarang/save_pengeluaran', 'PengeluaranBarangController@save_pengeluaran');
Route::get('pengeluaranbarang/update_pengeluaran/{id}', 'PengeluaranBarangController@update_pengeluaran');
Route::get('pengeluaranbarang/hapus/{id}', 'PengeluaranBarangController@hapus');
Route::get('pengeluaranbarang/createpengeluaranbarang/get_gudang','PengeluaranBarangController@get_gudang');
Route::get('pengeluaranbarang/lihatjurnal','PengeluaranBarangController@lihatjurnal');
// konfirmasi pengeluaran barang
Route::get('konfirmasipengeluaranbarang/konfirmasipengeluaranbarang' , 'PengeluaranBarangController@konfirmpengeluaranbarang');
Route::get('konfirmasipengeluaranbarang/detailkonfirmasipengeluaranbarang/{id}' , 'PengeluaranBarangController@detailkonfirmpengeluaranbarang');
Route::get('konfirmasipengeluaranbarang/printing/{id}' , 'PengeluaranBarangController@printing');
Route::get('konfirmasipengeluaranbarang/approve' , 'PengeluaranBarangController@approve');
Route::post('konfirmasipengeluaranbarang/approve' , 'PengeluaranBarangController@approve');
//stock opname
/*Route::get('stockopname/stockopname' , 'PengeluaranBarangController@stockopname');
Route::get('stockopname/cari_sm/{id}' , 'PengeluaranBarangController@cari_sm');
Route::get('stockopname/berita_acara/{id}' , 'PengeluaranBarangController@berita_acara');
Route::get('stockopname/createstockopname' , 'StockOpnameController@createstockopname');
Route::get('stockopname/detailstockopname' , 'StockOpnameController@detailstockopname');
Route::get('stockopname/save_stock_opname' , 'PengeluaranBarangController@save_stock_opname');
Route::get('stockopname/detailstockopname' , 'PengeluaranBarangController@detailstockopname');*/
//stock opname

Route::get('stockopname/stockopname' , 'PengeluaranBarangController@stockopname');
Route::get('stockopname/cari_sm' , 'PengeluaranBarangController@cari_sm');
Route::get('stockopname/berita_acara/{id}' , 'PengeluaranBarangController@berita_acara');
Route::get('stockopname/createstockopname' , 'PengeluaranBarangController@createstockopname');
/*Route::get('stockopname/save_stock_opname' , 'PengeluaranBarangController@save_stock_opname');
*/Route::get('stockopname/detailstockopname/{id}' , 'StockOpnameController@detailstockopname');
Route::get('stockopname/save_stock_opname' , 'StockOpnameController@savestockopname');
Route::get('stockopname/getnota' , 'PengeluaranBarangController@getnotaopname');
Route::get('stockopname/print/{id}' , 'StockOpnameController@printstockopname');
Route::get('stockopname/delete' , 'StockOpnameController@deletestockopname');
/*Route::get('stockopname/detailstockopname' , 'PengeluaranBarangController@detailstockopname');*/


Route::get('stockgudang/stockgudang' , 'PurchaseController@stockgudang');
Route::get('stockgudang/carigudang' , 'PurchaseController@carigudang');


Route::get('pengeluaranbarang/bppb', function(){
        return view('purchase.pengeluaran_barang.bppb');
});

Route::get('laporanstok/laporanstok', function(){
        return view('purchase.stock_opname.laporan_stok');
});

Route::get('master-keuangan/laporan-neraca',  'laporan_neracaController@index');
Route::get('laporan-neraca/index',  'laporan_neracaController@neraca');
Route::get('master-keuangan/laporan-laba-rugi',  'laba_rugiController@index');

/* end warehouse */
Route::get('fakturpembelian/fakturpembelian', 'PurchaseController@fatkurpembelian');
Route::get('fakturpembelian/createfatkurpembelian', 'PurchaseController@createfatkurpembelian');
Route::get('fakturpembelian/detailfatkurpembelian/{id}', 'PurchaseController@detailfatkurpembelian');
Route::get('fakturpembelian/getchangefaktur', 'PurchaseController@supplierfaktur');
Route::get('fakturpembelian/tampil_po', 'PurchaseController@tampil_po');
Route::post('fakturpembelian/save', 'PurchaseController@savefaktur');
Route::post('fakturpembelian/update_fp', 'PurchaseController@update_fp');
Route::get('fakturpembelian/update_fp', 'PurchaseController@update_fp');
Route::post('fakturpembelian/update_tt', 'PurchaseController@update_tt');
Route::post('fakturpembelian/getnotatt', 'PurchaseController@getnotatt');
Route::post('fakturpembelian/savefakturpo', 'PurchaseController@savefakturpo');
Route::get('fakturpembelian/savefakturpo', 'PurchaseController@savefakturpo');
Route::post('fakturpembelian/updatestockbarang' , 'PurchaseController@updatestockbarang');
Route::get('fakturpembelian/cetakfaktur/{id}' , 'PurchaseController@cetakfaktur');
Route::get('fakturpembelian/cetaktt/{id}' , 'PurchaseController@cetaktt');
Route::post('fakturpembelian/savefakturpajak' , 'PurchaseController@savefakturpajak');
Route::get('fakturpembelian/getbiayalain' , 'PurchaseController@getbiayalain');
Route::post('fakturpembelian/updatefaktur' , 'PurchaseController@updatefaktur');
Route::get('fakturpembelian/updatefaktur' , 'PurchaseController@updatefaktur');
Route::post('fakturpembelian/updatestockbrgfp' , 'PurchaseController@updatestockbrgfp');
Route::post('fakturpembelian/getbarang' , 'PurchaseController@getbarang');
Route::post('fakturpembelian/getbarangfpitem' , 'PurchaseController@getbarangfpitem');
Route::post('fakturpembelian/updatebarangitem' , 'PurchaseController@updatebarangitem');
Route::get('fakturpembelian/hapusfakturpembelian/{id}' , 'PurchaseController@hapusfakturpembelian');
Route::get('fakturpembelian/getum' , 'PurchaseController@getum');
Route::get('fakturpembelian/hasilum' , 'PurchaseController@hasilum');
Route::post('fakturpembelian/bayaruangmuka' , 'PurchaseController@bayaruangmuka');
Route::get('fakturpembelian/datagroupitem' , 'PurchaseController@datagroupitem');
Route::get('fakturpembelian/jurnalumum' , 'PurchaseController@lihatjurnalumum');
Route::post('fakturpembelian/getprovinsi' , 'PurchaseController@getprovinsi');


//BIAYA PENERUS AGEN
Route::get('fakturpembelian/getdatapenerus', 'BiayaPenerusController@getdatapenerus');
Route::get('fakturpembelian/cari_do', 'BiayaPenerusController@cari_do');
Route::get('fakturpembelian/carimaster', 'BiayaPenerusController@carimaster');
Route::get('fakturpembelian/autocomplete_biaya_penerus', 'BiayaPenerusController@autocomplete_biaya_penerus');
Route::get('fakturpembelian/rubahVen', 'BiayaPenerusController@rubahVen');
Route::get('fakturpembelian/cari_do_subcon', 'BiayaPenerusController@cari_do_subcon');
Route::post('fakturpembelian/save_agen', 'BiayaPenerusController@save_agen');
Route::get('fakturpembelian/save_agen', 'BiayaPenerusController@save_agen');
Route::get('fakturpembelian/edit_penerus/{i}', 'BiayaPenerusController@edit');
Route::get('fakturpembelian/cari_kontrak_subcon', 'BiayaPenerusController@cari_kontrak_subcon');
Route::get('fakturpembelian/getdatapenerusedit', 'BiayaPenerusController@getdatapenerusedit');
Route::post('fakturpembelian/update_agen', 'BiayaPenerusController@update_agen');
Route::get('fakturpembelian/update_agen', 'BiayaPenerusController@update_agen');
Route::get('fakturpembelian/simpan_tt', 'BiayaPenerusController@simpan_tt');
Route::get('fakturpembelian/simpan_tt1', 'BiayaPenerusController@simpan_tt1');
Route::get('fakturpembelian/simpan_tt_subcon', 'BiayaPenerusController@simpan_tt_subcon');
Route::get('fakturpembelian/cetak_tt/{id}', 'BiayaPenerusController@cetak_tt');
Route::get('fakturpembelian/hapusbiayapenerus/{id}', 'BiayaPenerusController@hapus_biaya');
Route::get('fakturpembelian/detailbiayapenerus/{id}', 'BiayaPenerusController@detailbiayapenerus')->name('detailbiayapenerus');
Route::get('fakturpembelian/buktibiayapenerus/{id}', 'BiayaPenerusController@buktibiayapenerus')->name('buktibiayapenerus');
Route::get('fakturpembelian/notapenerusagen', 'BiayaPenerusController@notapenerusagen');
Route::get('fakturpembelian/notaoutlet', 'BiayaPenerusController@notaoutlet');
Route::get('fakturpembelian/notasubcon', 'BiayaPenerusController@notasubcon');
Route::get('fakturpembelian/adinott', 'BiayaPenerusController@adinott');
Route::get('fakturpembelian/nota_tt', 'BiayaPenerusController@nota_tt');
Route::get('fakturpembelian/biaya_penerus_um', 'BiayaPenerusController@biaya_penerus_um');
Route::get('fakturpembelian/biaya_penerus/pilih_um', 'BiayaPenerusController@pilih_um');
Route::get('fakturpembelian/biaya_penerus/append_um', 'BiayaPenerusController@append_um');
Route::post('fakturpembelian/save_bp_um', 'BiayaPenerusController@save_bp_um');
Route::get('fakturpembelian/save_bp_um', 'BiayaPenerusController@save_bp_um');
Route::post('fakturpembelian/update_bp_um', 'BiayaPenerusController@update_bp_um');
Route::get('fakturpembelian/outlet_um', 'BiayaPenerusController@outlet_um');
Route::get('fakturpembelian/subcon_um', 'BiayaPenerusController@subcon_um');
Route::get('fakturpembelian/biaya_penerus/jurnal', 'BiayaPenerusController@jurnal');
Route::get('fakturpembelian/biaya_penerus/jurnal_um', 'BiayaPenerusController@jurnal_um');
//PEMBAYARAN OUTLET
Route::get('fakturpembelian/getpembayaranoutlet', 'BiayaPenerusController@getpembayaranoutlet')->name('getpembayaranoutlet');
Route::get('fakturpembelian/cari_outlet', 'BiayaPenerusController@cari_outlet');
Route::get('fakturpembelian/cari_outlet1', 'BiayaPenerusController@cari_outlet1');
// Route::get('fakturpembelian/cari_outlet1/{agen}', 'BiayaPenerusController@cari_outlet1');
Route::get('fakturpembelian/cariNote', 'BiayaPenerusController@cari_note');
Route::post('fakturpembelian/save_outlet', 'BiayaPenerusController@save_outlet');
Route::get('fakturpembelian/save_outlet', 'BiayaPenerusController@save_outlet');
Route::post('fakturpembelian/update_outlet', 'BiayaPenerusController@update_outlet');
Route::get('fakturpembelian/update_outlet', 'BiayaPenerusController@update_outlet');
// master kontrak subcon

Route::get('master_subcon/subcon', 'subconController@subcon');
Route::get('master_subcon/tambahkontraksubcon', 'subconController@tambahkontraksubcon');
Route::get('master_subcon/edit_subcon/{id}', 'subconController@edit_subcon');
Route::get('master_subcon/update_subcon', 'subconController@update_subcon');
Route::get('master_subcon/cek_hapus', 'subconController@cek_hapus');
Route::get('master_subcon/nota_kontrak_subcon', 'subconController@nota_kontrak_subcon');
Route::get('master_subcon/hapus_subcon', 'subconController@hapus_subcon');
Route::get('master_subcon/save_subcon', 'subconController@save_subcon');
Route::get('master_subcon/datatable_kontrak', 'subconController@datatable_kontrak')->name('datatable_kontrak_subcon');
Route::get('master_subcon/set_modal', 'subconController@set_modal');
Route::get('master_subcon/hapus_d_kontrak', 'subconController@hapus_d_kontrak');
Route::get('master_subcon/check_kontrak', 'subconController@check_kontrak');
Route::get('master_subcon/detail/{id}', 'subconController@detail');



// BON SEMENTARA
Route::get('bonsementaracabang/bonsementaracabang', 'BonSementaraController@index');
Route::get('bonsementaracabang/createcabang', 'BonSementaraController@create');
Route::get('bonsementaracabang/getnota', 'BonSementaraController@getnota');
Route::post('bonsementaracabang/save', 'BonSementaraController@savecabang');
Route::get('bonsementaracabang/setujukacab', 'BonSementaraController@setujukacab');
Route::post('bonsementaracabang/updatekacab', 'BonSementaraController@updatekacab');
Route::post('bonsementaracabang/updatecabang', 'BonSementaraController@updatecabang');
Route::get('bonsementaracabang/hapus/{id}', 'BonSementaraController@hapuscabang');
Route::post('bonsementaracabang/terimauang', 'BonSementaraController@terimauang');
Route::post('bonsementaracabang/jurnalumum', 'BonSementaraController@jurnalumum');


Route::get('bonsementarapusat/bonsementarapusat', 'BonSementaraController@indexpusat');
Route::get('bonsementarapusat/setujukacab', 'BonSementaraController@setujukacab');
Route::get('bonsementarapusat/setujukeu', 'BonSementaraController@setujukacab');
Route::get('bonsementarapusat/updatekapus', 'BonSementaraController@updatekapus');
Route::post('bonsementarapusat/updateadmin', 'BonSementaraController@updateadmin');
Route::post('bonsementarapusat/updatekeu', 'BonSementaraController@updatekeu');


//PEMBAYARAN SUBCON
Route::get('fakturpembelian/pilih_kontrak', 'BiayaPenerusController@pilih_kontrak');
Route::get('fakturpembelian/pilih_kontrak_all', 'BiayaPenerusController@pilih_kontrak_all');
Route::get('fakturpembelian/caripodsubcon', 'BiayaPenerusController@caripodsubcon');
Route::get('fakturpembelian/subcon_save', 'BiayaPenerusController@subcon_save');
Route::post('fakturpembelian/subcon_save', 'BiayaPenerusController@subcon_save');
Route::post('fakturpembelian/subcon_update', 'BiayaPenerusController@subcon_update');
Route::get('master_subcon/cari_kontrak', 'BiayaPenerusController@cari_kontrak');
Route::get('fakturpembelian/getpembayaransubcon', 'BiayaPenerusController@getpembayaransubcon')->name('getpembayaransubcon');
Route::get('fakturpembelian/cari_subcon', 'BiayaPenerusController@cari_subcon');

// PEMBAYARAN VENDOR

Route::get('fakturpembelian/getpembayaranvendor', 'pembayaran_vendor_controller@index');
Route::get('fakturpembelian/cari_do_vendor', 'pembayaran_vendor_controller@cari_do_vendor');
Route::get('fakturpembelian/append_vendor', 'pembayaran_vendor_controller@append_vendor');
Route::get('fakturpembelian/save_vendor', 'pembayaran_vendor_controller@save_vendor');
Route::get('fakturpembelian/update_vendor', 'pembayaran_vendor_controller@update_vendor');
Route::post('fakturpembelian/save_vendor_um', 'pembayaran_vendor_controller@save_vendor_um');
Route::post('fakturpembelian/update_vendor_um', 'pembayaran_vendor_controller@update_vendor_um');
Route::get('fakturpembelian/cari_do_vendor_edit', 'pembayaran_vendor_controller@cari_do_vendor_edit');

// FORM
//BIAYA PENERUS KAS
Route::get('biaya_penerus/index', 'KasController@index');
Route::get('biaya_penerus/createkas', 'KasController@create');
Route::get('biaya_penerus/getbbm/{id}', 'KasController@getbbm');
Route::get('biaya_penerus/cariresi', 'KasController@cari_resi');
Route::post('biaya_penerus/cariresi', 'KasController@cari_resi');
Route::post('biaya_penerus/cariresiedit', 'KasController@cariresiedit');
Route::post('biaya_penerus/save_penerus', 'KasController@save_penerus');
Route::get('biaya_penerus/save_penerus', 'KasController@save_penerus');
Route::post('biaya_penerus/update_penerus', 'KasController@update_penerus');
Route::get('biaya_penerus/akun_kas', 'KasController@akun_kas');
Route::get('biaya_penerus/nopol', 'KasController@nopol');
Route::get('biaya_penerus/editkas', 'KasController@edit')->name('editkas');
Route::get('biaya_penerus/ganti_nota', 'KasController@ganti_nota')->name('ganti_nota');
Route::get('biaya_penerus/hapuskas/{id}', 'KasController@hapus')->name('hapuskas');
Route::get('biaya_penerus/buktikas', 'KasController@buktikas')->name('buktikas');
Route::get('biaya_penerus/detailkas', 'KasController@detailkas')->name('detailkas');
Route::get('biaya_penerus/carinopol', 'KasController@carinopol')->name('carinopol');
Route::get('biaya_penerus/jurnal', 'KasController@jurnal');
Route::get('biaya_penerus/append_table', 'KasController@append_table');
Route::get('buktikaskeluar/datatable_bk', 'KasController@datatable_bk')->name('datatable_bk');
Route::get('biaya_penerus/jurnal_all', 'KasController@jurnal_all');
// PENGEMBALIAN
Route::get('pengembalian_bonsem/index', 'pengembalian_bonsem_controller@index');
Route::get('pengembalian_bonsem/create', 'pengembalian_bonsem_controller@create');
Route::get('pengembalian_bonsem/edit', 'pengembalian_bonsem_controller@edit');
Route::get('pengembalian_bonsem/datatable_pengembalian', 'pengembalian_bonsem_controller@datatable_pengembalian')->name('datatable_pengembalian');
Route::get('pengembalian_bonsem/datatable_pengembalian_history', 'pengembalian_bonsem_controller@datatable_pengembalian_history')->name('datatable_pengembalian_history');
Route::get('pengembalian_bonsem/index', 'pengembalian_bonsem_controller@index');
Route::get('pengembalian_bonsem/jurnal', 'pengembalian_bonsem_controller@jurnal');

// BIAYA PENERUS LOADING/UNLOADING
Route::get('biaya_penerus_loading/index', 'loadingController@index');
Route::get('biaya_penerus_loading/append_table', 'loadingController@append_table');
Route::get('biaya_penerus_loading/datatable_bk', 'loadingController@datatable_bk')->name('data_loading');
Route::get('biaya_penerus_loading/create', 'loadingController@create_loading');
Route::get('biaya_penerus_loading/edit', 'loadingController@edit_loading')->name('editkasloading');
Route::post('biaya_penerus_loading/cariresi', 'loadingController@cariresi');
Route::get('biaya_penerus_loading/cariresiedit', 'loadingController@cariresiedit');
Route::get('biaya_penerus_loading/save_loading', 'loadingController@save_loading');
Route::get('biaya_penerus_loading/update_loading', 'loadingController@update_loading');


//BUKTI KAS KELUAR
Route::get('buktikaskeluar/index', 'kasKeluarController@index');
Route::get('buktikaskeluar/create', 'kasKeluarController@create');
Route::get('buktikaskeluar/nota_bukti_kas', 'kasKeluarController@nota_bukti_kas');
Route::get('buktikaskeluar/akun_kas_dropdown', 'kasKeluarController@akun_kas_dropdown');
Route::get('buktikaskeluar/akun_biaya_dropdown', 'kasKeluarController@akun_biaya_dropdown');
Route::get('buktikaskeluar/histori_faktur', 'kasKeluarController@histori_faktur');
Route::get('buktikaskeluar/return_faktur', 'kasKeluarController@return_faktur');
Route::get('buktikaskeluar/debet_faktur', 'kasKeluarController@debet_faktur');
Route::get('buktikaskeluar/kredit_faktur', 'kasKeluarController@kredit_faktur');
Route::get('buktikaskeluar/um_faktur', 'kasKeluarController@um_faktur');
Route::post('buktikaskeluar/save_patty', 'kasKeluarController@save_patty');
Route::get('buktikaskeluar/supplier_dropdown', 'kasKeluarController@supplier_dropdown');
Route::get('buktikaskeluar/cari_hutang', 'kasKeluarController@cari_hutang');
Route::get('buktikaskeluar/cari_faktur', 'kasKeluarController@cari_faktur');
Route::get('buktikaskeluar/cari_faktur_edit', 'kasKeluarController@cari_faktur_edit');
Route::get('buktikaskeluar/append_faktur', 'kasKeluarController@append_faktur');
Route::get('buktikaskeluar/append_faktur_edit', 'kasKeluarController@append_faktur_edit');
Route::get('buktikaskeluar/detail_faktur', 'kasKeluarController@detail_faktur');
Route::post('buktikaskeluar/save_form', 'kasKeluarController@save_form');
Route::get('buktikaskeluar/print', 'kasKeluarController@printing');
Route::get('buktikaskeluar/hapus', 'kasKeluarController@hapus');
Route::get('buktikaskeluar/jurnal_all', 'kasKeluarController@jurnal_all');

Route::get('buktikaskeluar/edit/{id}', 'kasKeluarController@edit');
Route::post('buktikaskeluar/update_form', 'kasKeluarController@update_form');
Route::post('buktikaskeluar/update_patty', 'kasKeluarController@update_patty');
Route::get('buktikaskeluar/jurnal', 'kasKeluarController@jurnal');
Route::get('buktikaskeluar/datatable_bkk', 'kasKeluarController@datatable_bkk')->name('datatable_bkk');
Route::get('buktikaskeluar/append_table', 'kasKeluarController@append_table');
Route::get('buktikaskeluar/patty_cash', 'kasKeluarController@patty_cash');
Route::get('buktikaskeluar/cari_patty', 'kasKeluarController@cari_patty');
Route::get('buktikaskeluar/table_bonsem', 'kasKeluarController@table_bonsem');


// FORM TANDA TERIMA
Route::get('form_tanda_terima_pembelian', 'form_tanda_terima_pembelian_controller@index');
Route::get('form_tanda_terima_pembelian/create', 'form_tanda_terima_pembelian_controller@create');
Route::get('form_tanda_terima_pembelian/edit/{id}', 'form_tanda_terima_pembelian_controller@edit');
Route::get('form_tanda_terima_pembelian/datatable', 'form_tanda_terima_pembelian_controller@datatable')
                                                                            ->name('datatable_form_tt');
Route::get('form_tanda_terima_pembelian/ganti_jt', 'form_tanda_terima_pembelian_controller@ganti_jt')->name('ganti_jt_pembelian');
Route::get('form_tanda_terima_pembelian/nota', 'form_tanda_terima_pembelian_controller@nota');
Route::get('form_tanda_terima_pembelian/save', 'form_tanda_terima_pembelian_controller@save');
Route::get('form_tanda_terima_pembelian/update', 'form_tanda_terima_pembelian_controller@update');
Route::get('form_tanda_terima_pembelian/hapus', 'form_tanda_terima_pembelian_controller@hapus_tt_pembelian')->name('hapus_tt_pembelian');
Route::get('form_tanda_terima_pembelian/cek_ttd', 'form_tanda_terima_pembelian_controller@cek_ttd')->name('cek_ttd');
// IKHTISAR KAS
Route::get('ikhtisar_kas/index', 'ikhtisarController@index');
Route::get('ikhtisar_kas/create', 'ikhtisarController@create');
Route::get('ikhtisar_kas/nota', 'ikhtisarController@nota');
Route::get('ikhtisar_kas/cari_patty', 'ikhtisarController@cari_patty');
Route::get('ikhtisar_kas/tes', 'ikhtisarController@tes');
Route::post('ikhtisar_kas/simpan', 'ikhtisarController@simpan');
Route::get('ikhtisar_kas/edit/{id}', 'ikhtisarController@edit');
Route::post('ikhtisar_kas/update', 'ikhtisarController@update');
Route::get('ikhtisar_kas/hapus/{id}', 'ikhtisarController@hapus');
Route::get('ikhtisar_kas/print/{id}', 'ikhtisarController@cetak');
Route::get('ikhtisar_kas/datatable_ikhtisar', 'ikhtisarController@datatable_ikhtisar')->name('datatable_ikhtisar');
Route::get('ikhtisar_kas/print/{id}', 'ikhtisarController@cetak');
Route::get('ikhtisar_kas/append_table', 'ikhtisarController@append_table');



//PENDING
Route::get('pending/index', 'pendingController@index');
Route::get('pending_kas/index', 'pendingController@index_kas');
Route::get('pending_kas/save_kas/{id}', 'pendingController@save_kas');
Route::get('pending/create', 'pendingController@create')->name('proses');
Route::get('pending/save', 'pendingController@save')->name('save_pending');
Route::post('pending/save', 'pendingController@save')->name('save_pending');
Route::get('pending_subcon/index', 'pendingController@index_subcon');
Route::get('pending_subcon/create', 'pendingController@create_subcon')->name('proses_subcon');
Route::get('pending_subcon/save', 'pendingController@save_subcon');
Route::post('pending_subcon/save', 'pendingController@save_subcon');

// VOucher hutang
Route::get('voucherhutang/voucherhutang', 'v_hutangController@voucherhutang');
Route::get('voucherhutang/createvoucherhutang', 'v_hutangController@createvoucherhutang');
Route::get('voucherhutang/store1', 'v_hutangController@simpan');
Route::get('voucherhutang/detailvoucherhutang/{v_id}', 'v_hutangController@detailvoucherhutang');
Route::get('voucherhutang/editvoucherhutang/{v_id}', 'v_hutangController@editvoucherhutang');
Route::get('voucherhutang/updatevoucherhutang/{v_id}', 'v_hutangController@updatevoucherhutang');
Route::get('voucherhutang/hapusvoucherhutang/{v_id}', 'v_hutangController@hapusvoucherhutang');
Route::get('voucherhutang/print_voucherhutang/{v_id}', 'v_hutangController@cetakvoucherhutang');
Route::get('voucherhutang/getnota', 'v_hutangController@getnota');


Route::get('returnpembelian/returnpembelian', 'ReturnPembelianController@returnpembelian');
Route::get('returnpembelian/createreturnpembelian', 'ReturnPembelianController@createreturnpembelian');
Route::get('returnpembelian/detailreturnpembelian/{id}', 'ReturnPembelianController@detailreturnpembelian');
Route::get('returnpembelian/getpo', 'ReturnPembelianController@getpo');
Route::get('returnpembelian/hslfaktur', 'ReturnPembelianController@hslfaktur');
Route::get('returnpembelian/hasilbarangpo', 'ReturnPembelianController@hasilbarangpo');
Route::get('returnpembelian/getnota', 'ReturnPembelianController@getnota');
Route::post('returnpembelian/save', 'ReturnPembelianController@save');
Route::get('returnpembelian/getbarangpo', 'ReturnPembelianController@getbarangpo');
Route::get('returnpembelian/delete/{id}', 'ReturnPembelianController@hapusdata');
Route::post('returnpembelian/update', 'ReturnPembelianController@updatedata');

Route::get('cndnpembelian/cndnpembelian', 'cndnController@cndnpembelian');
Route::get('cndnpembelian/createcndnpembelian', 'cndnController@createcndnpembelian');
Route::get('cndnpembelian/detailcndnpembelian/{id}', 'cndnController@detailcndnpembelian');
Route::get('cndnpembelian/getnota', 'cndnController@getnota');
Route::get('cndnpembelian/getfaktur', 'cndnController@getfaktur');
Route::get('cndnpembelian/getsupplier', 'cndnController@getsupplier');
Route::get('cndnpembelian/hslfaktur', 'cndnController@hslfaktur');
Route::post('cndnpembelian/save', 'cndnController@save');
Route::get('cndnpembelian/caricndn', 'cndnController@caricndn');
Route::get('cndnpembelian/hapusdata/{id}', 'cndnController@hapusdata');
Route::post('cndnpembelian/update', 'cndnController@updatedata');
Route::post('cndnpembelian/pembayaran', 'cndnController@pembayaran');

Route::get('uangmukapembelian/uangmukapembelian', 'PurchaseController@uangmukapembelian');
Route::get('uangmukapembelian/createuangmukapembelian', 'PurchaseController@createuangmukapembelian');
Route::get('uangmukapembelian/detailuangmukapembelian', 'PurchaseController@detailuangmukapembelian');




Route::get('pelunasanhutangbank/pelunasanhutangbank', 'PurchaseController@pelunasanhutangbank');
Route::get('pelunasanhutangbank/createpelunasanbank', 'PurchaseController@createpelunasanbank');
Route::get('pelunasanhutangbank/detailpelunasanbank/{id}', 'PurchaseController@detailpelunasanbank');
Route::get('pelunasanhutangbank/nocheck', 'PurchaseController@nocheckpelunasanhutangbank');
Route::get('pelunasanhutangbank/getnota', 'PurchaseController@getnobbk');
Route::post('pelunasanhutangbank/getcek', 'PurchaseController@getcek');
Route::post('pelunasanhutangbank/simpan', 'PurchaseController@simpanbbk');
Route::get('pelunasanhutangbank/cetak/{id}', 'PurchaseController@cetakbbk');
Route::post('pelunasanhutangbank/update', 'PurchaseController@updatebbk');
Route::get('pelunasanhutangbank/hapuspelunasanhutang/{id}', 'PurchaseController@hapusbbk');
Route::post('pelunasanhutangbank/lihatjurnal', 'PurchaseController@lihatjurnalpelunasan');
Route::get('queryanalisa', 'Queryanalisa@view');


Route::get('bankmasuk/bankmasuk' ,'BankMasukController@bankmasuk');
Route::get('bankmasuk/databank' ,'BankMasukController@getdata');
Route::post('bankmasuk/saveterima' ,'BankMasukController@saveterima');

Route::get('bankkaslain/bankkaslain', 'PurchaseController@bankkaslain');
Route::get('bankkaslain/createbankkaslain', 'PurchaseController@createbankkaslain');
Route::get('bankkaslain/detailbankkaslain', 'PurchaseController@detailbankkaslain');

Route::get('mutasi_stock/mutasi_stock', 'StockMutController@index');
Route::get('mutasi_stock/createmutasi_stock', 'PurchaseController@createmutasistock');
Route::get('mutasi_stock/detailmutasi_stock', 'PurchaseController@detailmutasistock');

Route::get('formtandaterimatagihan/formtandaterimatagihan', 'PurchaseController@formtandaterimatagihan');
Route::get('formtandaterimatagihan/createformtandaterimatagihan', 'PurchaseController@createformtandaterimatagihan');
Route::get('formtandaterimatagihan/detailformtandaterimatagihan', 'PurchaseController@detailformtandaterimatagihan');


Route::get('formaju/formaju', 'PurchaseController@formaju');
Route::get('formaju/createformaju', 'PurchaseController@createformaju');
Route::get('formaju/detailformaju', 'PurchaseController@detailformaju');

//FPG
Route::get('formfpg/formfpg', 'PurchaseController@formfpg');
Route::get('formfpg/createformfpg', 'PurchaseController@createformfpg');
Route::get('formfpg/detailformfpg/{id}', 'PurchaseController@detailformfpg');
Route::get('formfpg/changesupplier', 'PurchaseController@changesupplier');
Route::post('formfpg/getfaktur', 'PurchaseController@getfaktur');
Route::get('formfpg/getjenisbayar', 'PurchaseController@getjenisbayar');
Route::post('formfpg/getkodeakun', 'PurchaseController@getkodeakun');
Route::post('formfpg/getakunbg', 'PurchaseController@getakunbg');
Route::post('formfpg/saveformfpg', 'PurchaseController@saveformfpg');
Route::post('formfpg/updateformfpg', 'PurchaseController@updateformfpg');
Route::post('formfpg/deletedetailformfpg', 'PurchaseController@deletedetailformfpg');
Route::post('formfpg/deletedetailbankformfpg', 'PurchaseController@deletedetailbankformfpg');
Route::get('formfpg/printformfpg/{id}', 'PurchaseController@printformfpg');
Route::get('formfpg/printformfpg2/{id}', 'PurchaseController@printformfpg2');
Route::get('formfpg/getnofpg', 'PurchaseController@getnofpg');
Route::get('formfpg/hapusfpg/{id}', 'PurchaseController@hapusfpg');
Route::get('formfpg/caritransaksi', 'PurchaseController@caritransaksi');


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
Route::get('masteritem/getaccpersediaan', 'MasterPurchaseController@getaccpersediaan');
Route::get('masteritem/getpersediaan', 'MasterPurchaseController@getpersediaan');


Route::get('masterbank/masterbank', 'MasterPurchaseController@masterbank');
Route::get('masterbank/createmasterbank', 'MasterPurchaseController@createmasterbank');
Route::post('masterbank/savemasterbank', 'MasterPurchaseController@savemasterbank');
Route::post('masterbank/getkodeakunbank', 'MasterPurchaseController@getkodeakunbank');
Route::get('masterbank/detailbank/{id}', 'MasterPurchaseController@detailbank');
Route::delete('masterbank/deletebank/{id}', 'MasterPurchaseController@deletebank');
Route::post('masterbank/updatemasterbank', 'MasterPurchaseController@updatemasterbank');
Route::post('masterbank/lihatdatabank', 'MasterPurchaseController@lihatdatabank');




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
Route::get('mastersupplier/getacchutang', 'MasterPurchaseController@getacchutang');
Route::get('mastersupplier/getnosupplier', 'MasterPurchaseController@getnosupplier');


Route::get('master_supplier/master_supplier', 'MasterPurchaseController@master_supplier');
Route::get('master_supplier/createkontrak', 'MasterPurchaseController@createkontraksupplier');
Route::get('master_supplier/detailkontrak', 'MasterPurchaseController@detailkontraksupplier');
Route::get('master_supplier/hapuskontrak', 'MasterPurchaseController@hapuskontrak');



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

// master aktiva start

Route::get('masteractiva/masteractiva/{id}', 'MasterPurchaseController@masteractiva');

Route::get('masteractiva/detailmasteractiva', 'MasterPurchaseController@detailmasteractiva');
Route::get('masteractiva/detailgarislurusmasteractiva', 'MasterPurchaseController@detailgarislurusmasteractiva');
Route::get('masteractiva/detailsaldomenurunmasteractiva', 'MasterPurchaseController@detailsaldomenurunmasteractiva');
Route::get('masteractiva/createmasteractiva', 'MasterPurchaseController@createmasteractiva');
Route::get('masteractiva/ask_kode/{cabang}', 'MasterPurchaseController@ask_kode_activa');

Route::post('master_aktiva/simpan', 'MasterPurchaseController@aktiva_save');

// end master aktiva

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
Route::get('mastergudang/detailmastergudang/{id}', 'MasterPurchaseController@detailmastergudang');
Route::post('mastergudang/updatemastergudang', 'MasterPurchaseController@updatemastergudang');
Route::delete('mastergudang/deletegudang/{id}', 'MasterPurchaseController@deletegudang');
// BBM DAN PERSEN
Route::get('bbm/index', 'MasterPenerusController@bbm');
Route::get('bbm/update/{kode}/{nama}/{harga}', 'MasterPenerusController@bbm_update');
Route::get('presentase/index', 'MasterPenerusController@presentase');
Route::get('presentase/tambah', 'MasterPenerusController@tambah');
Route::get('presentase/update', 'MasterPenerusController@update');
Route::get('presentase/dropdown', 'MasterPenerusController@dropdown');
Route::get('presentase/hapus', 'MasterPenerusController@hapus')->name('hapusPersen');
Route::get('presentase/update/{kode}/{nama}/{persen}', 'MasterPenerusController@presentase_update');


//*** END PEMBELIAN


// Route::get('laporan_master_penjualan/tarif_cabang_dokumen', 'LaporanMasterController@tarif_cabang_dokumen');
// Route::get('laporan_master_penjualan/tabledokumen', 'LaporanMasterController@tabledokumen')->name('dokumen');
// Route::get('laporan_master_penjualan/tarif_cabang_koli', 'LaporanMasterController@tarif_cabang_koli');
// Route::get('laporan_master_penjualan/tarif_cabang_kargo', 'LaporanMasterController@tarif_cabang_kargo');



Route::post('laporan_master_penjualan/tabledokumen', 'LaporanMasterController@tabledokumen')->name('dokumen');

//===================================== LAPORAN PEMBELIAN BERAWAL =======================================// 

  //LAPORAN MASTER ITEM
  Route::get('masteritem/masteritem/masteritem','LaporanPembelianController@lap_masteritem');
  Route::post('reportmasteritem/reportmasteritem', 'LaporanPembelianController@report_masteritem');
  //END OF

  //LAPORAN MASTER GUDANG
  Route::get('mastergudang/mastergudang/mastergudang','LaporanPembelianController@lap_mastergudang');
  Route::post('reportmastergudang/reportmastergudang', 'LaporanPembelianController@report_mastergudang');
  //END OF

  //LAPORAN MASTER SUPPLIER
  Route::get('mastersupplier/mastersupplier/mastersupplier','LaporanPembelianController@lap_mastersupplier');
  Route::post('reportmastersupplier/reportmastersupplier', 'LaporanPembelianController@report_mastersupplier');
  //END OF

  //LAPORAN SPP
  Route::get('spp/spp/spp', 'LaporanPembelianController@lap_spp');
  Route::post('reportspp/reportspp', 'LaporanPembelianController@report_spp');
  //END OF

  //LAPORAN PURCHASEORDER
  Route::get('masterpo/masterpo/masterpo','LaporanPembelianController@lap_po');
  Route::post('reportpo/reportpo', 'LaporanPembelianController@report_po');
  //END OF

  //LAPORAN MASTER BAYAR BANK
  Route::get('masterbayarbank/masterbayarbank/masterbayarbank','LaporanPembelianController@lap_masterbayarbank');
  Route::post('reportbayarbank/reportbayarbank', 'LaporanPembelianController@report_bayarbank');
  //END OF 

  //LAPORAN MASTER KAS KELUAR
  Route::get('masterkaskeluar/masterkaskeluar/masterkaskeluar','LaporanPembelianController@lap_masterkaskeluar');
  Route::post('report_kaskeluar/report_kaskeluar', 'LaporanPembelianController@report_bayarkas');
  //END OF

  //LAPORAN FAKTUR PEMBELIAN
  Route::get('masterfakturpembelian/masterfakturpembelian/masterfakturpembelian','LaporanPembelianController@lap_fakturpembelian');
  Route::post('reportfakturpembelian/reportfakturpembelian', 'LaporanPembelianController@report_fakturpembelian');
  //END OF

  //LAPORAN KARTU HUTANG
  Route::get('kartuhutang/kartuhutang', 'LaporanPembelianControlle@kartuhutang');
  Route::get('reportkartuhutang/reportkartuhutang', 'LaporanPembelianController@reportkartuhutang');
      //pencarian
      Route::get('carikartuhutang/carikartuhutang_perakun', 'LaporanPembelianController@carikartuhutang_perakun')->name('carikartuhutang_perakun');
      Route::get('carikartuhutang/carikartuhutang_persupplier', 'LaporanPembelianController@carikartuhutang_persupplier')->name('carikartuhutang_persupplier');
      Route::get('carikartuhutang/carikartuhutang_persupplier_detail', 'LaporanPembelianController@carikartuhutang_persupplier_detail')->name('carikartuhutang_persupplier_detail');
      Route::get('carikartuhutang/carikartuhutang_persupplier_detail', 'LaporanPembelianController@carikartuhutang_persupplier_detail')->name('carikartuhutang_persupplier_detail');
  Route::get('reportexcelkartuhutang/reportexcelkartuhutang', 'LaporanPembelianController@reportexcelkartuhutang');
  //END OF

  //LAPORAN MASTER GROUP ITEM
  Route::get('reportmastergroupitem/reportmastergroupitem', 'LaporanPembelianController@reportmastergroupitem');
  //END OF

  //LAPORAN PAJAK MASUKAN
  Route::get('fakturpajakmasukan/fakturpajakmasukan', 'LaporanPembelianController@lap_fakturpajakmasukan');
  Route::post('reportfakturpajakmasukan/reportfakturpajakmasukan', 'LaporanPembelianController@report_fakturpajakmasukan');
  //END OF 

  //LAPORAN PENERIMAAN BARANG
  Route::get('penerimaanbarang/penerimaanbarang/penerimaanbarang', 'LaporanPembelianController@lap_penerimaanbarang');
  Route::post('reportpenerimaanbarang/reportpenerimaanbarang', 'LaporanPembelianController@report_penerimaanbarang');
  //END OF

  //LAPORAN PENGELUARAN BARANG
  Route::get('pengeluaranbarang/pengeluaranbarang/pengeluaranbarang', 'LaporanPembelianController@lap_pengeluaranbarang');
  Route::post('reportpengeluaranbarang/reportpengeluaranbarang', 'LaporanPembelianController@report_pengeluaranbarang');
  //END OF

  //LAPORAN DEPARETMENT
  Route::get('lap_masterdepartment/lap_masterdepartment', 'LaporanPembelianController@lap_department');
  Route::post('reportmasterdepartment/reportmasterdepartment', 'LaporanPembelianController@report_masterdepartment');
  //END OF 

  //LAPORAN DEPARETMENT
  Route::get('lap_masterpresentase/lap_masterpresentase', 'LaporanPembelianController@lap_persen');
  Route::post('reportmasterpresentase/reportmasterpresentase', 'LaporanPembelianController@report_persen');
  //END OF 

  //LAPORAN BBM
  Route::get('lap_bbm/lap_bbm', 'LaporanPembelianController@lap_bbm');
  Route::post('reportbbm/reportbbm', 'LaporanPembelianController@report_bbm');
  //END OF 

  //LAPORAN BBM
  Route::get('lap_voucherhutang/lap_voucherhutang', 'LaporanPembelianController@lap_voucherhutang');
  Route::post('reportvoucherhutang/reportvoucherhutang', 'LaporanPembelianController@report_voucherhutang');
  //END OF

  //LAPORAN BBM
  Route::get('lap_uangmuka/lap_uangmuka', 'LaporanPembelianController@lap_uangmuka');
  Route::post('reportuangmuka/reportuangmuka', 'LaporanPembelianController@report_uangmuka');
  //END OF

  //LAPORAN TANDA TERIMA TAGIHAN
  Route::get('lap_ttt/lap_ttt', 'LaporanPembelianController@lap_ttt');
  Route::post('reporttt/reporttt', 'LaporanPembelianController@report_ttt');
  //END OF 
//================================    BELUM SELESAI    ========================================//

// Route::get('reportkartuhutang/reportkartuhutang', 'LaporanPurchaseController@reportkartuhutang');
Route::get('reportfakturpelunasan/reportfakturpelunasan', 'LaporanPurchaseController@reportfakturpelunasan');
Route::get('kartuhutangajax/kartuhutangajax', 'LaporanPurchaseController@kartuhutangajax');
Route::get('historisuangmukapembelian/historisuangmukapembelian', 'LaporanPurchaseController@historisuangmukapembelian');
//===========================================================================================================================

//==================================== LAPORAN PEMBELIAN BERAKIR ========================================//


//-------------------------INI ADALAH BATAS ANTARA KITA YANG TAK BISA SALING BERSATU-----  WIELIEJARNI//


//_____$$$$_________$$$$
//___$$$$$$$$_____$$$$$$$$
//_$$$$$$$$$$$$_$$$$$$$$$$$$
//$$$$$$$$$$$$$$$$$$$$$$$$$$$
//$$$$$$$$$$$$$$$$$$$$$$$$$$$
//_$$$$$$$$$$$$$$$$$$$$$$$$$
//__$$$$$$$$$$$$$$$$$$$$$$$
//____$$$$$$$$$$$$$$$$$$$
//_______$$$$$$$$$$$$$
//__________$$$$$$$
//____________$$$
//_____________$
//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ LAPORAN MASTER BERSAMA ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥//


//LAPORAN MASTER BERSAMA INDEX
Route::get('laporanbersama/laporanbersama','LaporanMasterController@lap_bersama');
//END OF

//LAPORAN PAJAK
Route::get('lappajak/lappajak','LaporanMasterController@lap_pajak');
Route::post('reportpajak/reportpajak','LaporanMasterController@report_pajak');
//END OF

//LAPORAN PROVINSI 
Route::get('lapprovinsi/lapprovinsi','LaporanMasterController@lap_provinsi');
Route::post('reportprovinsi/reportprovinsi','LaporanMasterController@report_provinsi');
//END OF


//LAPORAN KOTA
Route::get('lapkota/lapkota','LaporanMasterController@lap_kota');
Route::post('reportkota/reportkota','LaporanMasterController@report_kota');
//END OF

//LAPORAN KECAMATAN
Route::get('lapkecamatan/lapkecamatan','LaporanMasterController@lap_kecamatan');
Route::post('reportkecamatan/reportkecamatan','LaporanMasterController@report_kecamatan');
//END OF

//LAPORAN CABANG
Route::get('lapcabang/lapcabang','LaporanMasterController@lap_cabang');
Route::post('reportcabang/reportcabang','LaporanMasterController@report_cabang');
//END OF

//LAPORAN TIPE ANGKUTAN
Route::get('laptipeangkutan/laptipeangkutan','LaporanMasterController@lap_tipeangkutan');
Route::post('reporttipeangkutan/reporttipeangkutan','LaporanMasterController@report_tipeangkutan');
//END OF

//LAPORAN KENDARAAN
Route::get('lapkendaraan/lakendaraan','LaporanMasterController@lap_kendaraan');
Route::post('reportkendaraan/reportkendaraan','LaporanMasterController@report_kendaraan');
//END OF

//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ END OF LAPORAN MASTER BERSAMA ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥//


//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ LAPORAN MASTER DO ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥


//LAPORAN SEMUA DO
Route::get('laporanmasterdo/laporanmasterdo','LaporanMasterController@lap_semuado');
//END OF

//LAPORAN AGEN
Route::get('lapagen/lapagen','LaporanMasterController@lap_agen');
Route::post('reportagen/reportagen','LaporanMasterController@report_agen');
//END OF

//LAPORAN BIAYA
Route::get('lapbiaya/labiaya','LaporanMasterController@lap_biaya');
Route::post('reportbiaya/reportbiaya','LaporanMasterController@report_biaya');
//END OF

//LAPORAN DISKON
Route::get('lapdiskon/lapdiskon','LaporanMasterController@lap_diskon');
Route::post('reportdiskon/reportdiskon','LaporanMasterController@report_diskon');
//END OF

//LAPORAN DISKON PENJUALAN
Route::get('lapdiskonpenjualan/lapdiskonpenjualan','LaporanMasterController@lap_kendaraan');
Route::post('reportkendaraan/reportkendaraan','LaporanMasterController@report_kendaraan');
//END OF

//LAPORAN GRUP CUSTOMER
Route::get('lapgrupcustomer/lapgrupcustomer','LaporanMasterController@lap_grupcustomer');
Route::post('reportgrupcustomer/reportgrupcustomer','LaporanMasterController@report_grupcustomer');
//END OF

//LAPORAN GRUP ITEM
Route::get('lapgrupitem/lapgrupitem','LaporanMasterController@lap_grupitem');
Route::post('reportgrupitem/reportgrupitem','LaporanMasterController@report_grupitem');
//END OF

//LAPORAN ITEM
Route::get('lapitem/lapitem','LaporanMasterController@lap_item');
Route::post('reportitem/reportitem','LaporanMasterController@report_item');
//END OF

//LAPORAN NO SERI PAJAK
Route::get('lapnoseripajak/lapnoseripajak','LaporanMasterController@lap_kendaraan');
Route::post('reportkendaraan/reportkendaraan','LaporanMasterController@report_kendaraan');
//END OF

//LAPORAN RUTE
Route::get('laprute/laprute','LaporanMasterController@lap_rute');
Route::post('reportrute/reportrute','LaporanMasterController@report_rute');
//END OF

//LAPORAN SALDO AWAL PIUTANG LAIN
Route::get('lasaldoawalpiutang/lasaldoawalpiutang','LaporanMasterController@lap_kendaraan');
Route::post('reportkendaraan/reportkendaraan','LaporanMasterController@report_kendaraan');
//END OF

//LAPORAN SALDO PIUTANG
Route::get('lasaldopiutang/lasaldopiutang','LaporanMasterController@lap_kendaraan');
Route::post('reportkendaraan/reportkendaraan','LaporanMasterController@report_kendaraan');
//END OF

//LAPORAN SATUAN
Route::get('lapsatuan/lapsatuan','LaporanMasterController@lap_satuan');
Route::post('reportsatuan/reportsatuan','LaporanMasterController@report_satuan');
//END OF

//LAPORAN SUBCON
Route::get('lapsubcon/lapsubcon','LaporanMasterController@lap_subcon');
Route::post('reportsubcon/reportsubcon','LaporanMasterController@report_subcon');
//END OF

//LAPORAN VENDOR
Route::get('lapvendor/lapvendor','LaporanMasterController@lap_vendor');
Route::post('reportvendor/reportvendor','LaporanMasterController@report_vendor');
//END OF

//LAPORAN ZONA
Route::get('lapzona/lapzona','LaporanMasterController@lap_zona');
Route::post('reportzona/reportzona','LaporanMasterController@report_zona');
//END OF

//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ END OF LAPORAN MASTER DO ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥



//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ END OF LAPORAN OMSET PENJUALAN ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥

//LAPORAN OMZET INDEX
Route::get('diagram/diagram','laporanOmsetController@index');
//END OF

//LAPORAN DIAGRAM
Route::get('diagram_dokargo/diagram_dokargo','laporanOmsetController@diagram_dokargo');
Route::get('caridiagram_dokargo/caridiagram_dokargo','laporanOmsetController@caridiagram_dokargo');

//END OF 

//LAPORAN DIAGRAM
Route::get('diagram_penjualan/diagram_penjualan','LaporanOmsetController@diagram_penjualan');
Route::get('caridiagram_penjualan/caridiagram_penjualan','LaporanOmsetController@caridiagram_penjualan');
//END OF 

//LAPORAN PER-DO
Route::get('diagram_seluruhdo/diagram_seluruhdo','LaporanOmsetController@diagram_seluruhdo');
Route::get('caridiagram_seluruhdo/caridiagram_seluruhdo','LaporanOmsetController@caridiagram_seluruhdo');
//END OF 

//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ END OF LAPORAN OMSET PENJUALAN ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥

//=================================== LAPORAN PENJUALAN BERAWAL =========================================//
//laporan master tarif 
Route::get('laporan_master_penjualan/tarif_cabang_master','LaporanMasterController@tarif_cabang_master');
//end of 
//LAPORAN TARIF
Route::get('laporan_master_penjualan/tarif_cabang_dokumen', 'LaporanMasterController@tarif_cabang_dokumen');
Route::get('laporan_master_penjualan/tarif_cabang_koli', 'LaporanMasterController@tarif_cabang_koli');
Route::get('laporan_master_penjualan/tarif_cabang_kargo', 'LaporanMasterController@tarif_cabang_kargo');
Route::get('laporan_master_penjualan/tarif_cabang_kilogram', 'LaporanMasterController@tarif_cabang_kilogram');
Route::get('laporan_master_penjualan/tarif_cabang_sepeda', 'LaporanMasterController@tarif_cabang_sepeda');
//END OF LAPORAN TARIF

//LAPORAN TARIF PDF
Route::post('reportcabangdokumen/reportcabangdokumen', 'LaporanMasterController@reportcabangdokumen')->name('reportcabangdokumen');
Route::post('reportcabangkoli/reportcabangkoli', 'LaporanMasterController@reportcabangkoli')->name('reportcabangkoli');
Route::post('reportcabangkargo/reportcabangkargo', 'LaporanMasterController@reportcabangkargo')->name('reportcabangkargo');
Route::post('reportcabangkilogram/reportcabangkilogram', 'LaporanMasterController@reportcabangkilogram')->name('reportcabangkilogram');
Route::post('reportcabangsepeda/reportcabangsepeda', 'LaporanMasterController@reportcabangsepeda')->name('reportcabangsepeda');
//END OF LAPORAN TARIF PDF

//========tarif penerus

//TARIF PENERUS
Route::get('laporan_master_penjualan/tarif_penerus_dokumen', 'LaporanMasterController@tarif_penerus_dokumen');
Route::get('laporan_master_penjualan/tarif_penerus_koli', 'LaporanMasterController@tarif_penerus_koli');
Route::get('laporan_master_penjualan/tarif_penerus_default', 'LaporanMasterController@tarif_penerus_default');
Route::get('laporan_master_penjualan/tarif_penerus_kilogram', 'LaporanMasterController@tarif_penerus_kilogram');
Route::get('laporan_master_penjualan/tarif_penerus_sepeda', 'LaporanMasterController@tarif_penerus_sepeda');
//END OF PENERUS  

//LAPORAN PENERUS PDF
Route::post('reportpenerusdokumen/reportpenerusdokumen', 'LaporanMasterController@reportpenerusdokumen')->name('reportpenerusdokumen');
Route::post('reportpeneruskoli/reportpeneruskoli', 'LaporanMasterController@reportpeneruskoli')->name('reportpeneruskoli');
Route::post('reportpenerusdefault/reportpenerusdefault', 'LaporanMasterController@reportpenerusdefault')->name('reportpenerusdefault');
Route::post('reportpeneruskilogram/reportpeneruskilogram', 'laporanmasterController@reportpeneruskilogram')->name('reportpeneruskilogram');
Route::post('reportpenerussepeda/reportpenerussepeda', 'LaporanMasterController@reportpenerussepeda')->name('reportpenerussepeda');
//END OF LAPORAN PENERUS PDF


//=======end of
//LAPORAN PENJUALAN 
Route::get('sales/laporan_penjualan','LaporanMasterController@laporan_penjualan');
Route::post('reportlaporan_penjualan/reportlaporan_penjualan','LaporanMasterController@reportlaporan_penjualan');
Route::get('carilaporan_penjualan/carilaporan_penjualan','LaporanMasterController@carilaporan_penjualan');
//END OF PENJUALAN

//LAPORAN DELIVERY ORDER TOTAL 
Route::get('sales/laporandeliveryorder_total','LaporanMasterController@deliveryorder_total');

Route::get('sales/laporandeliveryorder_total_data','LaporanMasterController@deliveryorder_total_data')->name('deliveryorder_total_data');
Route::get('reportdeliveryorder_total/reportdeliveryorder_total','LaporanMasterController@reportdeliveryorder_total');
Route::get('exceldeliveryorder_total/exceldeliveryorder_total','LaporanMasterController@exceldeliveryorder_total');
Route::get('ajaxcarideliveryorder_total/ajaxcarideliveryorder_total','LaporanMasterController@ajaxcarideliveryorder_total');
Route::get('carideliveryorder_total/carideliveryorder_total','LaporanMasterController@carideliveryorder_total')->name('carideliveryorder_total');

  //masterdetail
  Route::get('ajaxcarideliveryorder_total_masterdetail/ajaxcarideliveryorder_total_masterdetail','LaporanMasterController@ajaxcarideliveryorder_total_masterdetail');
  //end off
  //rekap bulanan
  Route::get('ajaxcarideliveryorder_total_rekapbulanan/ajaxcarideliveryorder_total_rekapbulanan','LaporanMasterController@ajaxcarideliveryorder_total_rekapbulanan');
  //end off
  //rekap tri wulan
  Route::get('ajaxcarideliveryorder_total_rekaptriwulan/ajaxcarideliveryorder_total_rekaptriwulan','LaporanMasterController@ajaxcarideliveryorder_total_rekaptriwulan');
  //end off
  //deial Entry
  Route::get('ajaxcarideliveryorder_total_entry/ajaxcarideliveryorder_total_entry','LaporanMasterController@ajaxcarideliveryorder_total_entry');
  //end off
  //ajaxcarideliveryorder_non_customer
  Route::get('ajaxcarideliveryorder_non_customer/ajaxcarideliveryorder_non_customer','LaporanMasterController@ajaxcarideliveryorder_non_customer');
  //end off
   //ajaxcarideliveryorder_belum_delivered_ok
  Route::get('ajaxcarideliveryorder_belum_delivered_ok/ajaxcarideliveryorder_belum_delivered_ok','LaporanMasterController@ajaxcarideliveryorder_belum_delivered_ok');
  //end off
  //deial mobil
  Route::get('ajaxcarideliveryorder_total_detailnopol/ajaxcarideliveryorder_total_detailnopol','LaporanMasterController@ajaxcarideliveryorder_total_detailnopol');
  //end off
  //deial mobil
  Route::get('ajaxcarideliveryorder_total_detailmobil/ajaxcarideliveryorder_total_detailmobil','LaporanMasterController@ajaxcarideliveryorder_total_detailmobil');
  //end off
  //deial mobil
  Route::get('ajaxcarideliveryorder_total_detailsales/ajaxcarideliveryorder_total_detailsales','LaporanMasterController@ajaxcarideliveryorder_total_detailsales');
  //end off

//END OF DELIVERY ORDER TOTAL

//LAPORAN DELIVERY ORDER PAKET 
Route::post('reportdeliveryorder/reportdeliveryorder','LaporanMasterController@reportdeliveryorder');
Route::get('sales/laporandeliveryorder','LaporanMasterController@deliveryorder');
Route::get('cari_paket/cari_paket', 'LaporanMasterController@cari_paket');
//END OF DELIVERY ORDER PAKET

//LAPORAN DELIVERY ORDER KARGO 
Route::post('reportdeliveryorder/reportdeliveryorder_kargo','LaporanMasterController@reportdeliveryorder_kargo');
Route::get('sales/laporandeliveryorder_kargo','LaporanMasterController@deliveryorder_kargo');
//END OF DELIVERY ORDER KARGO

//LAPORAN DELIVERY ORDER KORAN 
Route::post('reportdeliveryorder/reportdeliveryorder_koran','LaporanMasterController@reportdeliveryorder_koran');
Route::get('sales/laporandeliveryorder_koran','LaporanMasterController@deliveryorder_koran');
Route::get('carideliveryorder_koran/carideliveryorder_koran','LaporanMasterController@carideliveryorder_koran');
//END OF DELIVERY ORDER KORAN

//LAPORAN INVOICE
Route::get('sales/laporan_invoice','LaporanMasterController@invoice');
Route::get('cari_lap_invoice/cari_lap_invoice','LaporanMasterController@cari_lap_invoice');
Route::post('reportinvoice/reportinvoice', 'LaporanMasterController@reportinvoice')->name('reportinvoice');
Route::get('excelinvoice/excelinvoice', 'LaporanMasterController@excelinvoice')->name('excelinvoice');
Route::get('carireport_invoice/carireport_invoice', 'LaporanMasterController@carireport_invoice')->name('carireport_invoice');
Route::get('carientry_invoice/carientry_invoice', 'LaporanMasterController@carientry_invoice')->name('carientry_invoice');
Route::get('carientry_invoice/carientry_invoice', 'LaporanMasterController@carientry_invoice')->name('carientry_invoice');
//
Route::get('cari_invoice_belum_tt/cari_invoice_belum_tt', 'LaporanMasterController@cari_invoice_belum_tt')->name('cari_invoice_belum_tt');
Route::get('cari_invoice_sudah_tt/cari_invoice_sudah_tt', 'LaporanMasterController@cari_invoice_sudah_tt')->name('cari_invoice_sudah_tt');
Route::get('cari_faktur_belum_tt/cari_faktur_belum_tt', 'LaporanMasterController@cari_faktur_belum_tt')->name('cari_faktur_belum_tt');
Route::get('cari_jarak_invoice_dengan_tt/cari_jarak_invoice_dengan_tt', 'LaporanMasterController@cari_jarak_invoice_dengan_tt')->name('cari_jarak_invoice_dengan_tt');
//END OF LAPORAN INVOICE

//LAPORAN KWITANSI
Route::get('sales/laporan_kwitansi','LaporanMasterController@kwitansi');
Route::get('cari_ajaxkwitansi/cari_ajaxkwitansi', 'LaporanMasterController@cari_ajaxkwitansi')->name('cari_ajaxkwitansi');
Route::get('cari_ajaxkwitansi/cari_ajaxkwitansi_belum_posting', 'LaporanMasterController@cari_ajaxkwitansi_belum_posting')->name('cari_ajaxkwitansi_belum_posting');
Route::get('cari_ajaxkwitansi/cari_ajaxkwitansi_sudah_posting', 'LaporanMasterController@cari_ajaxkwitansi_sudah_posting')->name('cari_ajaxkwitansi_sudah_posting');
Route::post('reportkwitansi/reportkwitansi', 'LaporanMasterController@reportkwitansi')->name('reportkwitansi');
//END OF LAPORAN KWITANSI

//LAPORAN INVOICE LAIN
Route::get('sales/laporan_invoice_lain','LaporanMasterController@invoice_lain');
Route::post('reportinvoicelain/reportinvoicelain', 'LaporanMasterController@reportinvoice_lain')->name('reportinvoice_lain');
//END OF LAPORAN INVOICE LAIN

//LAPORAN CN/DN 
Route::get('sales/laporan_cndn','LaporanMasterController@cndn');
Route::post('reportcndn/reportcndn', 'LaporanMasterController@reportcndn')->name('reportcndn');
//END OF LAPORAN CN/DN

//LAPORAN UANG MUKA PENJUALAN 
Route::get('sales/laporan_uangmuka_penjualan','LaporanMasterController@uangmuka');
Route::post('reportuangmukapenjualan/reportuangmukapenjualan', 'LaporanMasterController@reportuangmuka')->name('reportuangmuka');
//END OF LAPORAN UANG MUKA PENJUALAN

//LAPORAN POSTING BAYAR PENJUALAN
Route::get('sales/laporan_posting_bayar','LaporanMasterController@posting_bayar');
Route::post('reportposting_bayar/reportposting_bayar', 'LaporanMasterController@reportposting_bayar')->name('reportposting_bayar');
//END OF LAPORAN BAYAR PENJUALAN

//LAPORAN KARTU PIUTANG
Route::get('laporan_sales/kartu_piutang','LaporanMasterController@kartupiutang');
  //cari kartu piutang cus
  Route::get('cari_kartupiutang/cari_kartupiutang','LaporanMasterController@cari_kartupiutang');
  //cari kartu piutang cus detail
  Route::get('cari_kartupiutang_detail_customer/cari_kartupiutang_detail_customer','LaporanMasterController@cari_kartupiutang_detail_customer');
  //cari kartu piutang akun
  Route::get('cari_kartupiutang_akun/cari_kartupiutang_akun','LaporanMasterController@cari_kartupiutang_akun');
  //cari kartu piutang akun detil
  Route::get('cari_kartupiutang_detail_akun/cari_kartupiutang_detail_akun','LaporanMasterController@cari_kartupiutang_detail_akun');

Route::post('reportpdf_kartupiutang/reportpdf_kartupiutang', 'LaporanMasterController@reportpdf_kartupiutang')->name('reportpdf_kartupiutang');
Route::post('reportexcel_kartupiutang/reportexcel_kartupiutang', 'LaporanMasterController@reportexcel_kartupiutang')->name('reportexcel_kartupiutang');
//END OF 

//analisa piutang
Route::get('laporan_sales/analisa_piutang', 'laporan_sales\analisa_piutang_Controller@index');
Route::get('laporan_sales/analisa_piutang/ajax_lap_analisa_piutang', 'laporan_sales\analisa_piutang_Controller@ajax_lap_analisa_piutang');
Route::get('laporan_sales/analisa_piutang/piutang_dropdown', 'laporan_sales\analisa_piutang_Controller@piutang_dropdown');
// end analisa piutang

//---

 //LAPORAN REKAP CUSTOMER
 Route::get('rekap_customer/rekap_customer','LaporanMasterController@rekap_customer');
 Route::get('cari_rekapcustomer/cari_rekapcustomer','LaporanMasterController@cari_rekapcustomer');
 Route::get('report_rekapcustomer/report_rekapcustomer', 'LaporanMasterController@report_rekapcustomer')->name('report_rekapcustomer');
 Route::get('reportpdf_rekapcustomer/reportpdf_rekapcustomer', 'LaporanMasterController@reportpdf_rekapcustomer')->name('reportpdf_rekapcustomer');
 
 //END OF 

//---

//========================================== LAPORAN PENJUALAN BERAKIR ====================================================//

//**** PENJUALAN***
// Master Sales
// MASTER AKUN FITUR
Route::get('master_sales/master_akun', 'master_sales\master_akun_controller@index');
Route::get('master_sales/datatable_akun', 'master_sales\master_akun_controller@datatable_akun')->name('datatable_akun');
Route::get('master_sales/datatable_item', 'master_sales\master_akun_controller@datatable_item')->name('datatable_item');
Route::get('master_sales/save_akun_patty', 'master_sales\master_akun_controller@save_akun_patty');
Route::get('master_sales/save_akun_item', 'master_sales\master_akun_controller@save_akun_item');
Route::get('master_sales/ganti_akun_patty', 'master_sales\master_akun_controller@ganti_akun_patty');
Route::get('master_sales/ganti_akun_item', 'master_sales\master_akun_controller@ganti_akun_item');
Route::get('master_sales/hapus_akun_patty', 'master_sales\master_akun_controller@hapus_akun_patty');
Route::get('master_sales/hapus_akun_item', 'master_sales\master_akun_controller@hapus_akun_item');
Route::get('master_sales/insert_all', 'master_sales\master_akun_controller@insert_all');

//grup agen
Route::get('master_sales/agen', 'master_sales\agen_Controller@index');
Route::get('master_sales/agen/tabel', 'master_sales\agen_Controller@table_data');
Route::get('master_sales/agen/get_data', 'master_sales\agen_Controller@get_data');
Route::get('master_sales/agen/save_data', 'master_sales\agen_Controller@save_data');
Route::post('master_sales/agen/hapus_data', 'master_sales\agen_Controller@hapus_data');


// end agen

//grup vendor
Route::get('master_sales/vendor', 'master_sales\vendor_Controller@index');
Route::get('master_sales/vendor/tabel', 'master_sales\vendor_Controller@table_data');
Route::get('master_sales/vendor/get_data', 'master_sales\vendor_Controller@get_data');
Route::get('master_sales/vendor/save_data', 'master_sales\vendor_Controller@save_data');
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
Route::get('master_sales/item/pilih_nota', 'master_sales\item_Controller@pilih_nota');
Route::get('master_sales/item/get_data', 'master_sales\item_Controller@get_data');
Route::get('master_sales/item/save_data', 'master_sales\item_Controller@save_data');
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
Route::get('master_sales/customer/save_data', 'master_sales\customer_Controller@save_data');
Route::post('master_sales/customer/hapus_data', 'master_sales\customer_Controller@hapus_data');
Route::get('master_sales/customer/check_status', 'master_sales\customer_Controller@check_status');
// end customer


//biaya
Route::get('master_sales/biaya','master_sales\biaya_Controller@index');
Route::get('master_sales/biaya/save_data','master_sales\biaya_Controller@save');
Route::get('master_sales/biaya/update_data','master_sales\biaya_Controller@update');
Route::get('master_sales/biaya/hapus_data','master_sales\biaya_Controller@hapus');
Route::get('master_sales/biaya/edit_data','master_sales\biaya_Controller@edit');

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
Route::get('master_sales/subcon/save_data', 'master_sales\subcon_Controller@save_data');
Route::post('master_sales/subcon/hapus_data', 'master_sales\subcon_Controller@hapus_data');
// end subcon

//Master Tarif Subcon
Route::get('master_purchase/tarif_subcon', 'subcon_Controller@index');
Route::get('master_purchase/subcon/tabel', 'subcon_Controller@table_data');
Route::get('master_purchase/subcon/get_data', 'subcon_Controller@get_data');
Route::get('master_purchase/subcon/save_data', 'subcon_Controller@save_data');
Route::post('master_purchase/subcon/hapus_data', 'subcon_Controller@hapus_data');
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
Route::get('master_sales/kendaraan_form', 'master_sales\kendaraan_Controller@form')->name('form_kendaraan');
Route::get('master_sales/kendaraan_form/{nomor}/edit', 'master_sales\kendaraan_Controller@form');
Route::get('master_sales/kendaraan_form/{nomor}/hapus_data', 'master_sales\kendaraan_Controller@hapus_data');
Route::post('master_sales/kendaraan/save_data', 'master_sales\kendaraan_Controller@save_data');
Route::get('master_sales/kendaraan/{id}/hapus_data', 'master_sales\kendaraan_Controller@hapus_data');
// end kendaraan

//Nomor seri pajak
Route::get('master_sales/nomorseripajak','master_sales\nomor_seri_pajak_controller@index');
Route::get('master_sales/datatable_nomor_seri_pajak','master_sales\nomor_seri_pajak_controller@datatable_nomor_seri_pajak')->name('datatable_nomor_seri_pajak');
Route::post('master_sales/save_pajak_invoice', 'master_sales\nomor_seri_pajak_controller@save_pajak_invoice');
Route::get('master_sales/cari_faktur_pajak', 'master_sales\nomor_seri_pajak_controller@cari_faktur_pajak');
Route::get('master_sales/cari_id_pajak', 'master_sales\nomor_seri_pajak_controller@cari_id_pajak');
Route::get('master_sales/hapus_faktur_pajak', 'master_sales\nomor_seri_pajak_controller@hapus_faktur_pajak');
Route::get('master_sales/cek_nomor_pajak', 'master_sales\nomor_seri_pajak_controller@cek_nomor_pajak');


//---WILAYAH----------
//provinsi
Route::get('sales/provinsi', function(){
        return view('wilayah.provinsi.index');
});
Route::get('sales/provinsi/tabel', 'wilayah\provinsi_Controller@table_data');
Route::get('sales/provinsi/get_data', 'wilayah\provinsi_Controller@get_data');
Route::post('sales/provinsi/save_data', 'wilayah\provinsi_Controller@save_data');
Route::post('sales/provinsi/hapus_data', 'wilayah\provinsi_Controller@hapus_data');
//end provinsi1


//kota
Route::get('sales/kota', 'wilayah\kota_Controller@index');
Route::get('sales/kota/tabel', 'wilayah\kota_Controller@table_data');
Route::get('sales/kota/get_data', 'wilayah\kota_Controller@get_data');
Route::post('sales/kota/save_data', 'wilayah\kota_Controller@save_data');
Route::post('sales/kota/hapus_data', 'wilayah\kota_Controller@hapus_data');
// end kota

//kecamatan
Route::get('sales/kecamatan', 'wilayah\kecamatan_Controller@index');
Route::get('sales/kecamatan/tabel', 'wilayah\kecamatan_Controller@table_data');
Route::get('sales/kecamatan/get_data', 'wilayah\kecamatan_Controller@get_data');
Route::post('sales/kecamatan/save_data', 'wilayah\kecamatan_Controller@save_data');
Route::post('sales/kecamatan/hapus_data', 'wilayah\kecamatan_Controller@hapus_data');





//kontrak customer
Route::get('master_sales/kontrak', 'master_sales\kontrak_Controller@index');
Route::get('master_sales/kontrak_form', 'master_sales\kontrak_Controller@form');
Route::get('master_sales/drop_cus', 'master_sales\kontrak_Controller@drop_cus');
Route::get('master_sales/edit_kontrak/{id}', 'master_sales\kontrak_Controller@edit_kontrak');
Route::post('master_sales/save_kontrak', 'master_sales\kontrak_Controller@save_kontrak');
Route::get('master_sales/save_kontrak', 'master_sales\kontrak_Controller@save_kontrak');
Route::post('master_sales/update_kontrak', 'master_sales\kontrak_Controller@update_kontrak');
Route::get('master_sales/update_kontrak', 'master_sales\kontrak_Controller@update_kontrak');
Route::get('master_sales/kontrak_set_nota', 'master_sales\kontrak_Controller@kontrak_set_nota');
Route::get('master_sales/set_kode_akun_acc', 'master_sales\kontrak_Controller@set_kode_akun_acc');
Route::get('master_sales/set_kode_akun_csf', 'master_sales\kontrak_Controller@set_kode_akun_csf');
Route::get('master_sales/hapus_kontrak', 'master_sales\kontrak_Controller@hapus_kontrak');
Route::get('master_sales/detail_kontrak/{id}', 'master_sales\kontrak_Controller@detail_kontrak');
Route::get('master_sales/datatable_kontrak', 'master_sales\kontrak_Controller@datatable_kontrak')->name('datatable_kontrak');
Route::get('master_sales/set_modal', 'master_sales\kontrak_Controller@set_modal');
Route::get('master_sales/hapus_d_kontrak', 'master_sales\kontrak_Controller@hapus_d_kontrak');
Route::get('master_sales/check_kontrak', 'master_sales\kontrak_Controller@check_kontrak');
// end kontrak


Route::get('sales/salesorder', function(){
        return view('sales.so.index');
});

Route::get('sales/salesorderform', function(){
        return view('sales.so.form');
});
Route::get('/hello', function(){
        $status = 'Customer';
        $kontrak = 'ini';
        return view('hello',compact('status','kontrak'));
});
/*
Route::get('sales/deliveryordercabangtracking','trackingdoController@index');
Route::get('sales/deliveryordercabangtracking/getdata/{nomor}','trackingdoController@getdata');*/

Route::get('sales/deliveryordercabangtracking','trackingdoController@index');
Route::get('sales/deliveryordercabangtracking/table','trackingdoController@getdata');
Route::get('sales/deliveryordercabangtracking/autocomplete','trackingdoController@autocomplete');
Route::get('sales/deliveryordercabangtracking/getdata/{nomor}','trackingdoController@getdata');


// delivery order


Route::get('sales/deliveryorder', 'sales\do_controller@index');
Route::get('cetak_deliveryorderform/cetak_deliveryorderform', 'sales\do_controller@cetak_form');
Route::get('sales/deliveryorderform', 'sales\do_controller@form');
Route::get('sales/deliveryorderform/{nomor}/edit', 'sales\do_controller@form');
Route::get('sales/deliveryorderform/tabel_data_detail', 'sales\do_controller@table_data_detail')->name('tabledata_detail');
Route::get('sales/deliveryorderform/get_data_detail', 'sales\do_controller@get_data_detail');
Route::get('sales/deliveryorderform/tabel_item', 'sales\do_controller@table_data_item');
Route::get('sales/deliveryorderform/get_item', 'sales\do_controller@get_item');
Route::get('sales/deliveryorderform/cari_harga', 'sales\do_controller@cari_harga');  
Route::get('sales/deliveryorderform/cari_customer', 'sales\do_controller@cari_customer');
Route::get('sales/deliveryorderform/cari_kontrak', 'sales\do_controller@cari_kontrak');
Route::get('sales/deliveryorderform/cari_tipe', 'sales\do_controller@cari_tipe');

Route::post('sales/deliveryorderform/save_data', 'sales\do_controller@save_data');
Route::get('sales/deliveryorderform/save_data', 'sales\do_controller@save_data');
Route::post('sales/deliveryorderform/save_data_detail', 'sales\do_controller@save_data_detail');
Route::get('sales/deliveryorderform/{nomor}/hapus_data', 'sales\do_controller@hapus_data');
Route::post('sales/deliveryorderform/hapus_data_detail', 'sales\do_controller@hapus_data_detail');
Route::get('sales/deliveryorderform/{nomor}/update_status', 'sales\do_controller@form_update_status');
Route::post('sales/deliveryorderform/save_update_status', 'sales\do_controller@save_update_status');
Route::get('sales/deliveryorderform/{nomor}/nota', 'sales\do_Controller@cetak_nota');

Route::get('cari_kodenomor/cari_kodenomor', 'sales\do_controller@cari_kodenomor');
Route::get('sales/cari_replacekontrakcustomer', 'sales\do_controller@cari_replacekontrakcustomer');
Route::get('sales/deliveryorderform/cari_customer_kontrak', 'sales\do_controller@cari_customer_kontrak');

Route::get('sales/cari_modalkontrakcustomer', 'sales\do_controller@cari_modalkontrakcustomer');
Route::get('sales/cari_replacekontrakcustomer', 'sales\do_controller@cari_replacekontrakcustomer');

Route::get('sales/cari_modaldeliveryorder', 'sales\do_controller@cari_modaldeliveryorder');
Route::get('sales/tarif_penerus_dokumen_indentdo/save_data', 'sales\do_controller@tarif_penerus_dokumen_indentdo');

Route::get('sales/cari_modaldeliveryorder_kilogram', 'sales\do_controller@cari_modaldeliveryorder_kilogram');
Route::get('sales/tarif_penerus_kilogram_indentdo/save_data', 'sales\do_controller@tarif_penerus_kilogram_indentdo');

Route::get('sales/cari_modaldeliveryorder_koli', 'sales\do_controller@cari_modaldeliveryorder_koli');
Route::get('sales/tarif_penerus_koli_indentdo/save_data', 'sales\do_controller@tarif_penerus_koli_indentdo');

Route::get('sales/cari_modaldeliveryorder_sepeda', 'sales\do_controller@cari_modaldeliveryorder_sepeda');
Route::get('sales/tarif_penerus_sepeda_indentdo/save_data', 'sales\do_controller@tarif_penerus_sepeda_indentdo');


// Route::get('sales/deliveryorder', 'sales\do_Controller@index');
// Route::get('sales/asd', 'sales\do_controller@asd');
// Route::get('cetak_deliveryorderform/cetak_deliveryorderform', 'sales\do_Controller@cetak_form');
// Route::get('sales/deliveryorderform', 'sales\do_Controller@form');
// Route::get('sales/deliveryorderform/{nomor}/edit', 'sales\do_Controller@form');
// Route::get('sales/deliveryorderform/tabel_data_detail', 'sales\do_Controller@table_data_detail')->name('tabledata_detail');
// Route::get('sales/deliveryorderform/get_data_detail', 'sales\do_Controller@get_data_detail');
// Route::get('sales/deliveryorderform/tabel_item', 'sales\do_Controller@table_data_item');
// Route::get('sales/deliveryorderform/get_item', 'sales\do_Controller@get_item');
// Route::get('sales/deliveryorderform/cari_harga', 'sales\do_Controller@cari_harga');
// Route::get('sales/deliveryorderform/cari_customer', 'sales\do_Controller@cari_customer');
// Route::get('sales/deliveryorderform/cari_kontrak', 'sales\do_Controller@cari_kontrak');
// Route::get('sales/deliveryorderform/cari_tipe', 'sales\do_Controller@cari_tipe'); 

// Route::post('sales/deliveryorderform/save_data', 'sales\do_Controller@save_data');
// Route::get('sales/deliveryorderform/save_data', 'sales\do_Controller@save_data');
// Route::post('sales/deliveryorderform/save_data_detail', 'sales\do_Controller@save_data_detail');
// Route::get('sales/deliveryorderform/{nomor}/hapus_data', 'sales\do_Controller@hapus_data');
// Route::post('sales/deliveryorderform/hapus_data_detail', 'sales\do_Controller@hapus_data_detail');
// Route::get('sales/deliveryorderform/{nomor}/update_status', 'sales\do_Controller@form_update_status');
// Route::post('sales/deliveryorderform/save_update_status', 'sales\do_Controller@save_update_status');
// Route::get('sales/deliveryorderform/{nomor}/nota', 'sales\do_Controller@cetak_nota');

// Route::get('cari_kodenomor/cari_kodenomor', 'sales\do_Controller@cari_kodenomor');
// Route::get('sales/cari_replacekontrakcustomer', 'sales\do_Controller@cari_replacekontrakcustomer');
// Route::get('sales/deliveryorderform/cari_customer_kontrak', 'sales\do_Controller@cari_customer_kontrak');

// Route::get('sales/cari_modalkontrakcustomer', 'sales\do_Controller@cari_modalkontrakcustomer');
// Route::get('sales/cari_replacekontrakcustomer', 'sales\do_Controller@cari_replacekontrakcustomer');

// Route::get('sales/cari_modaldeliveryorder', 'sales\do_Controller@cari_modaldeliveryorder');
// Route::get('sales/tarif_penerus_dokumen_indentdo/save_data', 'sales\do_Controller@tarif_penerus_dokumen_indentdo');

// Route::get('sales/cari_modaldeliveryorder_kilogram', 'sales\do_Controller@cari_modaldeliveryorder_kilogram');
// Route::get('sales/tarif_penerus_kilogram_indentdo/save_data', 'sales\do_Controller@tarif_penerus_kilogram_indentdo');

// Route::get('sales/cari_modaldeliveryorder_koli', 'sales\do_Controller@cari_modaldeliveryorder_koli');
// Route::get('sales/tarif_penerus_koli_indentdo/save_data', 'sales\do_Controller@tarif_penerus_koli_indentdo');

// Route::get('sales/cari_modaldeliveryorder_sepeda', 'sales\do_Controller@cari_modaldeliveryorder_sepeda');
// Route::get('sales/tarif_penerus_sepeda_indentdo/save_data', 'sales\do_Controller@tarif_penerus_sepeda_indentdo');
// //end delivery order










//deny do baru

  //index
  Route::get('sales/deliveryorder_paket', 'do_new\do_paketController@index')->name('deliveryorder_paket');
      //datatable
      Route::get('sales/deliveryorder_paket/datatable_deliveryorder_paket', 'do_new\do_paketController@datatable_deliveryorder_paket')->name('datatable_deliveryorder_paket');
      //cari ajax
      Route::get('sales/ajax_index_deliveryorder_paket/ajax_index_deliveryorder_paket', 'do_new\do_paketController@ajax_index_deliveryorder_paket')->name('ajax_index_deliveryorder_paket');
      //replace ajax
      Route::get('sales/ajax_replace_index_deliveryorder_paket/ajax_replace_index_deliveryorder_paket', 'do_new\do_paketController@ajax_replace_index_deliveryorder_paket')->name('ajax_replace_index_deliveryorder_paket');
  //create
  Route::get('sales/deliveryorder_paket/create_deliveryorder_paket', 'do_new\do_paketController@create_deliveryorder_paket')->name('create_deliveryorder_paket');
      //cari nomor
      Route::get('sales/deliveryorder_paket/cari_nomor_deliveryorder_paket', 'do_new\do_paketController@cari_nomor_deliveryorder_paket')->name('cari_nomor_deliveryorder_paket');
      //cari kecamatan
      Route::get('sales/deliveryorder_paket/cari_kecamatan_deliveryorder_paket', 'do_new\do_paketController@cari_kecamatan_deliveryorder_paket')->name('cari_kecamatan_deliveryorder_paket');
      //cari harga do reguler / tanpa vendor / kontrak
      Route::get('sales/deliveryorder_paket/cari_harga_reguler_deliveryorder_paket', 'do_new\do_paketController@cari_harga_reguler_deliveryorder_paket')->name('cari_harga_reguler_deliveryorder_paket');
      //cari vendor
      Route::get('sales/deliveryorder_paket/cari_vendor_deliveryorder_paket', 'do_new\do_paketController@cari_vendor_deliveryorder_paket')->name('cari_vendor_deliveryorder_paket');
      //replace vendor
      Route::get('sales/deliveryorder_paket/replace_vendor_deliveryorder_paket', 'do_new\do_paketController@replace_vendor_deliveryorder_paket')->name('replace_vendor_deliveryorder_paket');
      //simpan data
      Route::get('sales/deliveryorder_paket/save_deliveryorder_paket', 'do_new\do_paketController@save_deliveryorder_paket')->name('save_deliveryorder_paket');

      //cari akun kas besar
      Route::get('sales/deliveryorder_paket/cari_kas_besar_deliveryorder_paket', 'do_new\do_paketController@cari_kas_besar_deliveryorder_paket')->name('cari_kas_besar_deliveryorder_paket');
  //Edit
  Route::get('sales/deliveryorder_paket/{nomor}/edit_deliveryorder_paket', 'do_new\do_paketController@edit_deliveryorder_paket')->name('edit_deliveryorder_paket');
      //update
      Route::get('sales/deliveryorder_paket/update_deliveryorder_paket', 'do_new\do_paketController@update_deliveryorder_paket')->name('update_deliveryorder_paket');
      //jurnal awal
      Route::get('sales/deliveryorder_paket/jurnal_awal_deliveryorder_paket', 'do_new\do_paketController@jurnal_awal_deliveryorder_paket')->name('jurnal_awal_deliveryorder_paket');
      //jurnal balik
      Route::get('sales/deliveryorder_paket/jurnal_balik_deliveryorder_paket', 'do_new\do_paketController@jurnal_balik_deliveryorder_paket')->name('jurnal_balik_deliveryorder_paket');
  Route::get('sales/deliveryorder_paket/{nomor}/hapus_deliveryorder_paket', 'do_new\do_paketController@hapus_deliveryorder_paket')->name('hapus_deliveryorder_paket');

//end of do baru


// delivery order kargo
Route::get('sales/deliveryorderkargo', 'sales\do_kargo_Controller@index');
Route::get('sales/datatable_do_kargo', 'sales\do_kargo_Controller@datatable_do_kargo')->name('datatable_do_kargo');
Route::get('sales/deliveryorderkargoform', 'sales\do_kargo_Controller@form');
Route::get('sales/cari_nopol_kargo', 'sales\do_kargo_Controller@cari_nopol_kargo');
Route::get('sales/nama_subcon', 'sales\do_kargo_Controller@nama_subcon');
Route::get('sales/cari_kontrak_tarif', 'sales\do_kargo_Controller@cari_kontrak_tarif');
Route::get('sales/cari_kontrak', 'sales\do_kargo_Controller@cari_kontrak');
Route::get('sales/nomor_do_kargo', 'sales\do_kargo_Controller@nomor_do_kargo');
Route::get('sales/hapus_do_kargo', 'sales\do_kargo_Controller@hapus_do_kargo');
Route::get('sales/pilih_kontrak_kargo', 'sales\do_kargo_Controller@pilih_kontrak_kargo');
Route::get('sales/save_do_kargo', 'sales\do_kargo_Controller@save_do_kargo');
Route::get('sales/pilih_tarif_kargo', 'sales\do_kargo_Controller@pilih_tarif_kargo');
Route::get('sales/edit_do_kargo/{id}', 'sales\do_kargo_Controller@edit_do_kargo');
Route::get('sales/detail_do_kargo/{id}', 'sales\do_kargo_Controller@detail_do_kargo');
Route::get('sales/update_do_kargo', 'sales\do_kargo_Controller@update_do_kargo');
Route::get('sales/drop_cus', 'sales\do_kargo_Controller@drop_cus');



Route::get('sales/deliveryorderkargoform/tabel_data_detail', 'sales\do_kargo_Controller@table_data_detail');
Route::get('sales/deliveryorderkargoform/get_data_detail', 'sales\do_kargo_Controller@get_data_detail');
Route::get('sales/deliveryorderkargoform/tabel_item', 'sales\do_kargo_Controller@table_data_item');
Route::get('sales/deliveryorderkargoform/get_item', 'sales\do_kargo_Controller@get_item');
Route::get('sales/deliveryorderkargoform/cari_harga', 'sales\do_kargo_Controller@cari_harga');
Route::get('sales/deliveryorderkargoform/cari_customer', 'sales\do_kargo_Controller@cari_customer');
Route::get('sales/deliveryorderkargoform/tampil_nopol', 'sales\do_kargo_Controller@tampil_nopol');
Route::post('sales/deliveryorderkargoform/save_data', 'sales\do_kargo_Controller@save_data');
Route::post('sales/deliveryorderkargoform/save_data_detail', 'sales\do_kargo_Controller@save_data_detail');
Route::get('sales/deliveryorderkargoform/{nomor}/hapus_data', 'sales\do_kargo_Controller@hapus_data');
Route::post('sales/deliveryorderkargoform/hapus_data_detail', 'sales\do_kargo_Controller@hapus_data_detail');
Route::get('sales/deliveryorderkargoform/{nomor}/update_status', 'sales\do_kargo_Controller@form_update_status');
Route::post('sales/deliveryorderkargoform/save_update_status', 'sales\do_kargo_Controller@save_update_status');
Route::get('sales/deliveryorderkargoform/nota/{nomor}', 'sales\do_kargo_Controller@cetak_nota');


//end delivery order kargo

// delivery order kertas
Route::get('sales/deliveryorderkertas', 'sales\do_kertas_Controller@index');
Route::get('sales/deliveryorderkertas_form', 'sales\do_kertas_Controller@form');
Route::get('sales/nomor_do_kertas', 'sales\do_kertas_Controller@nomor_do_kertas');
Route::get('sales/cari_customer_kertas', 'sales\do_kertas_Controller@cari_customer_kertas');
Route::get('sales/cari_item', 'sales\do_kertas_Controller@cari_item');
Route::get('sales/cetak_nota_kertas/{id}', 'sales\do_kertas_Controller@cetak_nota');
Route::get('sales/save_do_kertas', 'sales\do_kertas_Controller@save_do_kertas');
Route::post('sales/save_do_kertas', 'sales\do_kertas_Controller@save_do_kertas');
Route::get('sales/hapus_do_kertas', 'sales\do_kertas_Controller@hapus_do_kertas');
Route::get('sales/edit_do_kertas/{id}', 'sales\do_kertas_Controller@edit_do_kertas');
Route::get('sales/update_do_kertas', 'sales\do_kertas_Controller@update_do_kertas');
Route::post('sales/update_do_kertas', 'sales\do_kertas_Controller@update_do_kertas');
Route::get('sales/detail_do_kertas/{id}', 'sales\do_kertas_Controller@detail_do_kertas');
Route::get('sales/ganti_item', 'sales\do_kertas_Controller@ganti_item');
Route::get('sales/cari_kontrak_kertas', 'sales\do_kertas_Controller@cari_kontrak_kertas');
Route::get('sales/datatable_do_kertas', 'sales\do_kertas_Controller@datatable_do_kertas')->name('datatable_do_kertas');

// end delivery order kertas

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
Route::get('sales/surat_jalan_trayek_form/ganti_nota', 'sales\surat_jalan_trayek_Controller@ganti_nota');
Route::get('sales/surat_jalan_trayek_form', 'sales\surat_jalan_trayek_Controller@form');
Route::get('sales/surat_jalan_trayek_form/edit/{nomor}', 'sales\surat_jalan_trayek_Controller@edit');
Route::get('sales/surat_jalan_trayek_form/{nomor}/hapus_data', 'sales\surat_jalan_trayek_Controller@hapus_data');
Route::get('sales/surat_jalan_trayek_form/tabel_data_detail', 'sales\surat_jalan_trayek_Controller@table_data_detail');
Route::get('sales/surat_jalan_trayek/tabel', 'sales\surat_jalan_trayek_Controller@table_data');
Route::get('sales/surat_jalan_trayek/get_data', 'sales\surat_jalan_trayek_Controller@get_data');
Route::get('sales/surat_jalan_trayek/get_data_detail', 'sales\surat_jalan_trayek_Controller@get_data_detail');
Route::post('sales/surat_jalan_trayek_form/save_data', 'sales\surat_jalan_trayek_Controller@save_data');
Route::post('sales/surat_jalan_trayek/save_data_detail', 'sales\surat_jalan_trayek_Controller@save_data_detail');
Route::get('sales/surat_jalan_trayek/hapus_data', 'sales\surat_jalan_trayek_Controller@hapus_data');
Route::get('sales/surat_jalan_trayek/hapus_data_detail', 'sales\surat_jalan_trayek_Controller@hapus_data_detail');
Route::get('sales/surat_jalan_trayek_form/nota/{nomor}', 'sales\surat_jalan_trayek_Controller@cetak_nota');
Route::get('sales/surat_jalan_trayek_form/nota_all/{nomor}', 'sales\surat_jalan_trayek_Controller@nota_all');

Route::get('sales/surat_jalan_trayek_form/datatable_sjt', 'sales\surat_jalan_trayek_Controller@datatable_sjt')->name('datatable_sjt');

// end surat jalan by trayek



//invoice penjualan
Route::get('sales/invoice', 'sales\invoice_Controller@index');
Route::post('sales/pajak_invoice', 'sales\invoice_Controller@pajak_invoice');
Route::get('sales/invoice_form', 'sales\invoice_Controller@form');
Route::get('sales/nota_invoice', 'sales\invoice_Controller@nota_invoice');
Route::get('sales/cari_do_invoice', 'sales\invoice_Controller@cari_do_invoice');
Route::get('sales/cari_do_edit_invoice', 'sales\invoice_Controller@cari_do_edit_invoice');
Route::post('sales/append_do', 'sales\invoice_Controller@append_do');
Route::get('sales/pajak_lain', 'sales\invoice_Controller@pajak_lain');
Route::get('sales/jatuh_tempo_customer', 'sales\invoice_Controller@jatuh_tempo_customer');
Route::get('sales/edit_invoice/{i}', 'sales\invoice_Controller@edit_invoice');
Route::get('sales/lihat_invoice/{i}', 'sales\invoice_Controller@lihat_invoice');
Route::get('sales/hapus_invoice', 'sales\invoice_Controller@hapus_invoice');
Route::get('sales/cetak_nota/{id}', 'sales\invoice_Controller@cetak_nota');
Route::get('sales/drop_cus', 'sales\invoice_Controller@drop_cus');
Route::get('sales/invoice/append_table', 'sales\invoice_Controller@append_table');

Route::get('sales/invoice_form/tabel_data_detail', 'sales\invoice_Controller@table_data_detail');
Route::get('sales/invoice/tabel', 'sales\invoice_Controller@table_data');
Route::get('sales/invoice/get_data', 'sales\invoice_Controller@get_data');
Route::get('sales/invoice/get_data_detail', 'sales\invoice_Controller@get_data_detail');
Route::post('sales/simpan_invoice', 'sales\invoice_Controller@simpan_invoice');
Route::get('sales/simpan_invoice', 'sales\invoice_Controller@simpan_invoice');
Route::post('sales/update_invoice', 'sales\invoice_Controller@update_invoice');
Route::get('sales/update_invoice', 'sales\invoice_Controller@update_invoice');
Route::post('sales/invoice/save_data_detail', 'sales\invoice_Controller@save_data_detail');
Route::post('sales/invoice/hapus_data', 'sales\invoice_Controller@hapus_data');
Route::post('sales/invoice/hapus_data_detail', 'sales\invoice_Controller@hapus_data_detail');
Route::get('sales/invoice_form/{nomor}/nota', 'sales\invoice_Controller@cetak_nota');
Route::get('sales/invoice_form/{nilai}/terbilang', 'sales\invoice_Controller@penyebut');
Route::get('sales/datatable_invoice1', 'sales\invoice_Controller@datatable_invoice')->name('datatable_invoice1');
Route::get('sales/invoice/jurnal', 'sales\invoice_Controller@jurnal1');
Route::get('sales/cari_faktur_pajak', 'sales\invoice_Controller@cari_faktur_pajak');
Route::get('sales/cari_nomor_pajak', 'sales\invoice_Controller@cari_nomor_pajak');
// end invoice
Route::get('sales/invoice/jurnal_all', 'sales\invoice_Controller@jurnal_all');


//FORM TANDA TERIMA PENJUALAN
Route::get('sales/form_tanda_terima_penjualan/index', 'form_tanda_terima_penjualan_controller@index');
Route::get('sales/form_tanda_terima_penjualan/nota', 'form_tanda_terima_penjualan_controller@nota');
Route::get('sales/form_tanda_terima_penjualan/create', 'form_tanda_terima_penjualan_controller@create');
Route::post('sales/form_tanda_terima_penjualan/save', 'form_tanda_terima_penjualan_controller@save');
Route::post('sales/form_tanda_terima_penjualan/update', 'form_tanda_terima_penjualan_controller@update');
Route::get('sales/form_tanda_terima_penjualan/edit/{id}', 'form_tanda_terima_penjualan_controller@edit');
Route::get('sales/form_tanda_terima_penjualan/delete', 'form_tanda_terima_penjualan_controller@delete');
Route::get('sales/form_tanda_terima_penjualan/datatable', 'form_tanda_terima_penjualan_controller@datatable')->name('tt_penjualan');
Route::get('sales/form_tanda_terima_penjualan/ganti_jt', 'form_tanda_terima_penjualan_controller@ganti_jt')->name('ganti_jt');
Route::post('sales/form_tanda_terima_penjualan/cari_invoice', 'form_tanda_terima_penjualan_controller@cari_invoice')->name('cari_invoice');
Route::post('sales/form_tanda_terima_penjualan/append_invoice', 'form_tanda_terima_penjualan_controller@append_invoice')->name('append_invoice');
Route::get('sales/form_tanda_terima_penjualan/hapus', 'form_tanda_terima_penjualan_controller@hapus_tt_penjualan')->name('hapus_tt_penjualan');
Route::get('sales/form_tanda_terima_penjualan/printing/{id}', 'form_tanda_terima_penjualan_controller@printing');



// invoice pembetulan
Route::get('sales/invoice_pembetulan', 'sales\invoice_pembetulan_controller@index');
Route::get('sales/invoice_pembetulan_create', 'sales\invoice_pembetulan_controller@invoice_pembetulan_create');
Route::get('sales/invoice_pembetulan_edit/{id}', 'sales\invoice_pembetulan_controller@invoice_pembetulan_edit');
Route::get('sales/cari_invoice_pembetulan', 'sales\invoice_pembetulan_controller@cari_invoice_pembetulan');
Route::get('sales/pilih_invoice_pembetulan', 'sales\invoice_pembetulan_controller@pilih_invoice_pembetulan');
Route::post('sales/simpan_invoice_pembetulan', 'sales\invoice_pembetulan_controller@simpan_invoice_pembetulan');
Route::post('sales/update_invoice_pembetulan', 'sales\invoice_pembetulan_controller@update_invoice_pembetulan');
Route::get('sales/hapus_invoice_pembetulan', 'sales\invoice_pembetulan_controller@hapus_invoice_pembetulan');
Route::get('sales/cetak_nota_pembetulan/{id}', 'sales\invoice_pembetulan_controller@cetak_nota_pembetulan');

// update faktur 

Route::get('sales/faktur_pajak', 'sales\faktur_pajak_Controller@index');
Route::get('sales/faktur_pajak_cari', 'sales\faktur_pajak_Controller@tampil_auto_complete');
Route::post('sales/faktur_pajak/save_data', 'sales\faktur_pajak_Controller@save_data');
// end faktur pajak

// nota debet kredit
Route::get('sales/nota_debet_kredit', 'sales\nota_debet_kredit_Controller@index');
Route::get('sales/nota_debet_kredit/edit/{id}', 'sales\nota_debet_kredit_Controller@edit');
Route::get('sales/nota_debet_kredit/tabel', 'sales\nota_debet_kredit_Controller@table_data')->name('datatable_cn_dn');
Route::get('sales/nota_debet_kredit/create', 'sales\nota_debet_kredit_Controller@create');
Route::get('sales/nota_debet_kredit/cari_invoice', 'sales\nota_debet_kredit_Controller@cari_invoice');
Route::get('sales/nota_debet_kredit/pilih_invoice', 'sales\nota_debet_kredit_Controller@pilih_invoice');
Route::post('sales/nota_debet_kredit/simpan_cn_dn', 'sales\nota_debet_kredit_Controller@simpan_cn_dn');
Route::get('sales/nota_debet_kredit/nomor_cn_dn', 'sales\nota_debet_kredit_Controller@nomor_cn_dn');
Route::get('sales/nota_debet_kredit/riwayat', 'sales\nota_debet_kredit_Controller@riwayat');
Route::post('sales/nota_debet_kredit/update_cn_dn', 'sales\nota_debet_kredit_Controller@update_cn_dn');
Route::get('sales/nota_debet_kredit/hapus_cn_dn', 'sales\nota_debet_kredit_Controller@hapus_cn_dn');

// end nota debet kredit

// uang muka penjualan
Route::get('sales/uang_muka_penjualan', 'sales\uang_muka_penjualan_Controller@index');
Route::get('sales/uang_muka_penjualan/nota_uang_muka', 'sales\uang_muka_penjualan_Controller@nota_uang_muka');
Route::get('sales/uang_muka_penjualan/tabel', 'sales\uang_muka_penjualan_Controller@table_data');
Route::get('sales/uang_muka_penjualan/nota_uang_muka', 'sales\uang_muka_penjualan_Controller@nota_uang_muka');
Route::get('sales/uang_muka_penjualan/get_data', 'sales\uang_muka_penjualan_Controller@get_data');
Route::get('sales/uang_muka_penjualan/edit', 'sales\uang_muka_penjualan_Controller@edit');
Route::get('sales/uang_muka_penjualan/save_data', 'sales\uang_muka_penjualan_Controller@save_data');
Route::get('sales/uang_muka_penjualan/hapus_data', 'sales\uang_muka_penjualan_Controller@hapus_data');
// end uang muka penjualan

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

//kwitansi
Route::get('sales/penerimaan_penjualan', 'sales\penerimaan_penjualan_Controller@index');
Route::get('sales/penerimaan_penjualan_form', 'sales\penerimaan_penjualan_Controller@form');
Route::get('sales/nota_kwitansi', 'sales\penerimaan_penjualan_Controller@nota_kwitansi');
Route::get('sales/nota_bank', 'sales\penerimaan_penjualan_Controller@nota_bank');
Route::get('sales/cari_invoice', 'sales\penerimaan_penjualan_Controller@cari_invoice');
Route::get('sales/akun_biaya', 'sales\penerimaan_penjualan_Controller@akun_biaya');
Route::get('sales/akun_bank', 'sales\penerimaan_penjualan_Controller@akun_bank');
Route::get('sales/akun_all', 'sales\penerimaan_penjualan_Controller@akun_all');
Route::get('sales/append_invoice', 'sales\penerimaan_penjualan_Controller@append_invoice');
Route::post('sales/append_invoice', 'sales\penerimaan_penjualan_Controller@append_invoice');

Route::get('sales/datatable_kwitansi', 'sales\penerimaan_penjualan_Controller@datatable_kwitansi')->name('datatable_kwitansi');
Route::get('sales/datatable_detail_invoice', 'sales\penerimaan_penjualan_Controller@datatable_detail_invoice')->name('datatable_detail_invoice');
Route::get('sales/datatable_invoice', 'sales\penerimaan_penjualan_Controller@datatable_invoice')->name('datatable_invoice');

Route::get('sales/riwayat_invoice', 'sales\penerimaan_penjualan_Controller@riwayat_invoice');
Route::get('sales/cari_um', 'sales\penerimaan_penjualan_Controller@cari_um');
Route::get('sales/pilih_um', 'sales\penerimaan_penjualan_Controller@pilih_um');
Route::get('sales/riwayat_cn_dn', 'sales\penerimaan_penjualan_Controller@riwayat_cn_dn');
Route::get('sales/auto_biaya', 'sales\penerimaan_penjualan_Controller@auto_biaya');
Route::get('sales/simpan_kwitansi', 'sales\penerimaan_penjualan_Controller@simpan_kwitansi');
Route::get('sales/update_kwitansi', 'sales\penerimaan_penjualan_Controller@update_kwitansi');

Route::post('sales/simpan_kwitansi', 'sales\penerimaan_penjualan_Controller@simpan_kwitansi');
Route::post('sales/update_kwitansi', 'sales\penerimaan_penjualan_Controller@update_kwitansi');

Route::get('sales/kwitansi/cetak_nota', 'sales\penerimaan_penjualan_Controller@cetak_nota');
Route::get('sales/hapus_kwitansi', 'sales\penerimaan_penjualan_Controller@hapus_kwitansi');

Route::get('sales/edit_kwitansi', 'sales\penerimaan_penjualan_Controller@edit_kwitansi');
Route::get('sales/detail_kwitansi', 'sales\penerimaan_penjualan_Controller@detail_kwitansi');

Route::post('sales/save_um_kwitansi', 'sales\penerimaan_penjualan_Controller@save_um_kwitansi');
Route::get('sales/kwitansi_cari_um', 'sales\penerimaan_penjualan_Controller@kwitansi_cari_um');

Route::get('sales/hapus_um_kwitansi', 'sales\penerimaan_penjualan_Controller@hapus_um_kwitansi');
Route::get('sales/kwitansi/jurnal', 'sales\penerimaan_penjualan_Controller@jurnal');
Route::get('sales/kwitansi/simpan_um_sementara', 'sales\penerimaan_penjualan_Controller@simpan_um_sementara');
Route::get('sales/kwitansi/simpan_um', 'sales\penerimaan_penjualan_Controller@simpan_um');
Route::post('sales/kwitansi/simpan_um', 'sales\penerimaan_penjualan_Controller@simpan_um');
Route::get('sales/kwitansi/datatable_kwitansi', 'sales\penerimaan_penjualan_Controller@datatable_kwitansi');






//end penerimaan penjualan

//posting_pembayaran
Route::get('sales/posting_pembayaran', 'sales\posting_pembayaran_Controller@index');
Route::get('sales/posting_pembayaran_form/tampil_penerimaan_penjualan', 'sales\posting_pembayaran_Controller@tampil_penerimaan_penjualan');
Route::get('sales/posting_pembayaran_form', 'sales\posting_pembayaran_Controller@form');
Route::get('sales/posting_pembayaran_form/nomor_posting', 'sales\posting_pembayaran_Controller@nomor_posting');
Route::get('sales/posting_pembayaran_form/cari_kwitansi', 'sales\posting_pembayaran_Controller@cari_kwitansi');
Route::get('sales/posting_pembayaran_form/cari_uang_muka', 'sales\posting_pembayaran_Controller@cari_uang_muka');
Route::get('sales/posting_pembayaran_form/append', 'sales\posting_pembayaran_Controller@append');
Route::post('sales/posting_pembayaran_form/simpan_posting', 'sales\posting_pembayaran_Controller@simpan_posting');
Route::get('sales/posting_pembayaran_form/simpan_posting', 'sales\posting_pembayaran_Controller@simpan_posting');
Route::post('sales/posting_pembayaran_form/update_posting', 'sales\posting_pembayaran_Controller@update_posting');
Route::get('sales/posting_pembayaran_edit', 'sales\posting_pembayaran_Controller@edit');
Route::get('sales/posting_pembayaran_hapus', 'sales\posting_pembayaran_Controller@posting_pembayaran_hapus');
Route::get('sales/posting_pembayaran_print/{id}', 'sales\posting_pembayaran_Controller@posting_pembayaran_print');
Route::get('sales/datatable_posting', 'sales\posting_pembayaran_Controller@datatable_posting')->name('datatable_posting');
Route::get('sales/posting_pembayaran_form/akun_dropdown', 'sales\posting_pembayaran_Controller@akun_dropdown');




//end penerimaan penjualan

//Route::get('sales/salesorderform', 'so_Controller@so_form');

// LAPORAN PENJUALAN
//laporan sales order
Route::get('sales/laporansalesorder', function(){
        return view('laporan_sales.so.index');
});

//laporan delivery order
// Route::get('sales/laporandeliveryorder', 'LaporanMasterController@deliveryorder');

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
// Route::get('laporan_sales/kartu_piutang', 'laporan_sales\kartu_piutang_Controller@index');
// Route::get('laporan_sales/kartu_piutang/tampil_data', 'laporan_sales\kartu_piutang_Controller@tampil_kartu_piutang');
// end kartu piutang



//mutasi piutang
Route::get('laporan_sales/mutasi_piutang', 'laporan_sales\mutasi_piutang_Controller@index');
Route::get('laporan_sales/ajax_mutasipiutang_rekap/ajax_mutasipiutang_rekap', 'laporan_sales\mutasi_piutang_Controller@ajax_mutasipiutang_rekap');
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

//golongan_aktiva

Route::get('golonganactiva/golonganactiva/{cabang}', 'MasterPurchaseController@golonganactiva');
Route::get('golonganactiva/creategolonganactiva', 'MasterPurchaseController@creategolonganactiva');

Route::get('golonganactiva/editgolonganactiva/{cabang}/{id}', [
  'uses' => 'MasterPurchaseController@editgolonganactiva',
  'as'   => 'golonganactiva.edit'
]);

Route::get('golonganactiva/hapusgolonganactiva/{cabang}/{id}', [
  'uses' => 'MasterPurchaseController@golongan_hapus',
  'as'   => 'golonganactiva.hapus'
]);

Route::get('golonganactiva/ask_kode/{cabang}', 'MasterPurchaseController@ask_kode');

Route::post('golonganactiva/simpan', 'MasterPurchaseController@golongan_save');
Route::post('golonganactiva/update', 'MasterPurchaseController@golongan_update');

//endgolonganaktiva

Route::get('master_keuangan/err_cek', function(){
  return view('keuangan.err.err_laporan');
});


// periode_keuangan
  
  Route::post('master_keuangan/periode_keuangan/tambah', [
    'uses' => 'master_keuangan\periode_keuangan_controller@make',
    'as'   => 'periode_keuangan.tambah'
  ]);

  Route::post('master_keuangan/periode_keuangan/setting', [
    'uses' => 'master_keuangan\periode_keuangan_controller@setting',
    'as'   => 'periode_keuangan.setting'
  ]);

// end


// neraca saldo
Route::get('master_keuangan/neraca-saldo/single', [
  'uses' => 'master_keuangan\laporan\laporan_neraca_saldo@index_neraca_saldo',
  'as'   => 'neraca_saldo.index'
]);
// end neraca saldo


//neraca

Route::get('master_keuangan/neraca/single/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca@index_neraca_single',
  'as'   => 'neraca.index_single'
]);

Route::get('master_keuangan/neraca/perbandingan/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca@index_neraca_perbandingan',
  'as'   => 'neraca.index_perbandingan'
]);

Route::get('master_keuangan/neraca/pdf/single/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca@print_pdf_neraca_single',
  'as'   => 'neraca.pdf_single'
]);

Route::get('master_keuangan/neraca/pdf/perbandingan/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca@print_pdf_neraca_perbandingan',
  'as'   => 'neraca.pdf_perbandingan'
]);

Route::get('master_keuangan/neraca/excel/single/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca@print_excel_neraca_single',
  'as'   => 'neraca.excel_single'
]);

//endneraca


//neraca_detail

Route::get('master_keuangan/neraca-detail/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca_detail@index_neraca',
  'as'   => 'neraca_detail.index'
]);

Route::get('master_keuangan/neraca-detail/print/{throtle}', [
  'uses' => 'master_keuanganlaporan\laporan_neraca_detailr@print_pdf_neraca',
  'as'   => 'neraca_detail.pdf'
]);

Route::get('master_keuangan/neraca-detail/excel/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_neraca_detail@print_excel_neraca',
  'as'   => 'neraca_detail.excel'
]);

Route::get('master_keuangan/laba_rugi/pdf/perbandingan/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_laba_rugi@print_pdf_laba_rugi_perbandingan',
  'as'   => 'laba_rugi.pdf_perbandingan'
]);

//endneraca_detail


//laba rugi

Route::get('master_keuangan/laba_rugi/single/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_laba_rugi@index_laba_rugi_single',
  'as'   => 'laba_rugi.index_single'
]);

Route::get('master_keuangan/laba_rugi/perbandingan/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_laba_rugi@index_laba_rugi_perbandingan',
  'as'   => 'laba_rugi.index_perbandingan'
]);

Route::get('master_keuangan/laba_rugi/pdf/single/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_laba_rugi@print_pdf_laba_rugi_single',
  'as'   => 'laba_rugi.pdf_single'
]);

//end laba rugi


// buku besar

Route::get('master_keuangan/buku_besar/single', [
  'uses' => 'master_keuangan\laporan\laporan_buku_besar@index_buku_besar_single',
  'as'   => 'buku_besar.index_single'
]);

Route::get('master_keuangan/buku_besar/pdf/single/{throtle}', [
  'uses' => 'master_keuangan\laporan\laporan_buku_besar@print_pdf_buku_besar_single',
  'as'   => 'buku_besar.pdf_single'
]);

// Route::get('master_keuangan/neraca/perbandingan/{throtle}', [
//   'uses' => 'master_keuangan\laporan\laporan_neraca@index_neraca_perbandingan',
//   'as'   => 'neraca.index_perbandingan'
// ]);

// Route::get('master_keuangan/neraca/pdf/single/{throtle}', [
//   'uses' => 'master_keuangan\laporan\laporan_neraca@print_pdf_neraca_single',
//   'as'   => 'neraca.pdf_single'
// ]);

// Route::get('master_keuangan/neraca/pdf/perbandingan/{throtle}', [
//   'uses' => 'master_keuangan\laporan\laporan_neraca@print_pdf_neraca_perbandingan',
//   'as'   => 'neraca.pdf_perbandingan'
// ]);

// Route::get('master_keuangan/neraca/excel/single/{throtle}', [
//   'uses' => 'master_keuangan\laporan\laporan_neraca@print_excel_neraca_single',
//   'as'   => 'neraca.excel_single'
// ]);

// buku besar


// register jurnal
  
  Route::get('master_keuangan/register_jurnal/single', [
    'uses' => 'master_keuangan\laporan\laporan_register_jurnal@print_pdf_register_single',
    'as'   => 'register_jurnal.index_single'
  ]);

// end register jurnal


//kelompok akun
Route::get('master_keuangan/kelompok_akun', 'master_keuangan\kelompok_akun_Controller@index');
Route::get('master_keuangan/kelompok_akun/tabel', 'master_keuangan\kelompok_akun_Controller@table_data');
Route::get('master_keuangan/kelompok_akun/get_data', 'master_keuangan\kelompok_akun_Controller@get_data');
Route::post('master_keuangan/kelompok_akun/save_data', 'master_keuangan\kelompok_akun_Controller@save_data');
Route::post('master_keuangan/kelompok_akun/hapus_data', 'master_keuangan\kelompok_akun_Controller@hapus_data');
// end kelompok akun

//kelompok akun

Route::get('master_keuangan/group_akun', 'master_keuangan\group_akun_controller@index');
Route::get('master_keuangan/group_akun/add', 'master_keuangan\group_akun_controller@add');

Route::post('master_keuangan/group_akun/save', [
    'uses' => 'master_keuangan\group_akun_controller@save',
    'as'  => 'group_akun.save'
]);

Route::get('master_keuangan/group_akun/edit/{id}', 'master_keuangan\group_akun_controller@edit');

Route::post('master_keuangan/group_akun/update', [
    'uses' => 'master_keuangan\group_akun_controller@update',
    'as'  => 'group_akun.update'
]);

Route::get('master_keuangan/group_akun/hapus/{id}', [
    'uses' => 'master_keuangan\group_akun_controller@hapus',
    'as'  => 'group_akun.hapus'
]);

Route::get('master_keuangan/group_akun/list_akun', [
    'uses' => 'master_keuangan\group_akun_controller@list_akun',
    'as'  => 'group_akun.list_akun'
]);

Route::get('master_keuangan/group_akun/list_akun_on_group', [
    'uses' => 'master_keuangan\group_akun_controller@list_akun_on_group',
    'as'  => 'group_akun.list_akun_on_group'
]);

// end kelompok akun

//saldo akun

Route::get('master_keuangan/saldo_akun', [
  'uses' => 'master_keuangan\saldo_akun_controller@index',
  'as'   => 'saldo_akun.index'
]);

Route::get('master_keuangan/saldo_akun/edit/{id}', [
  'uses' => 'master_keuangan\saldo_akun_controller@edit',
  'as'   => 'saldo_akun.edit'
]);

Route::get('master_keuangan/saldo_akun/add/{parrent}', [
  'uses' => 'master_keuangan\saldo_akun_controller@add',
  'as'   => 'saldo_akun.add'
]);

Route::post('master_keuangan/saldo_akun/save_data', [
  'uses' => 'master_keuangan\saldo_akun_controller@save_data',
  'as'   => 'saldo_akun.save'
]);

Route::post('master_keuangan/saldo_akun/update', [
  'uses' => 'master_keuangan\saldo_akun_controller@update',
  'as'   => 'saldo_akun.update'
]);

//end saldo akun

//saldo piutang

// Route::get('master_keuangan/saldo_piutang/cek', [
//   'uses' => 'master_keuangan\saldo_piutang_controller@cek',
//   'as'   => 'saldo_piutang.cek'
// ]);

Route::get('master_keuangan/saldo_piutang/{cabang}', [
  'uses' => 'master_keuangan\saldo_piutang_controller@index',
  'as'   => 'saldo_piutang.index'
]);

Route::get('master_keuangan/saldo_piutang/add/{parrent}', [
  'uses' => 'master_keuangan\saldo_piutang_controller@add',
  'as'   => 'saldo_piutang.add'
]);

Route::post('master_keuangan/saldo_piutang/save', [
  'uses' => 'master_keuangan\saldo_piutang_controller@save',
  'as'   => 'saldo_piutang.save'
]);

Route::post('master_keuangan/saldo_piutang/get_invoice', [
  'uses' => 'master_keuangan\saldo_piutang_controller@invoice',
  'as'   => 'saldo_piutang.invoice'
]);

//end saldo piutang

// transaksi kas
Route::get('keuangan/jurnal_umum', [
  'uses' => 'master_keuangan\d_jurnal_controller@index',
  'as'   => 'jurnal.index'
]);

Route::get('keuangan/jurnal_umum/add', [
  'uses' => 'master_keuangan\d_jurnal_controller@add',
  'as'   => 'jurnal.add'
]);

Route::get('keuangan/jurnal_umum/edit', [
  'uses' => 'master_keuangan\d_jurnal_controller@edit',
  'as'   => 'jurnal.edit'
]);

Route::get('keuangan/jurnal_umum/detail/{id}', [
  'uses' => 'master_keuangan\d_jurnal_controller@getDetail',
  'as'   => 'jurnal.detail'
]);

Route::post('keuangan/jurnal_umum/save_data', [
  'uses'  => 'master_keuangan\d_jurnal_controller@save_data',
  'as'    => 'jurnal.save'
]);

Route::post('keuangan/jurnal_umum/update', [
  'uses'  => 'master_keuangan\d_jurnal_controller@update',
  'as'    => 'jurnal.update'
]);

Route::get('keuangan/jurnal_umum/delete', [
  'uses'  => 'master_keuangan\d_jurnal_controller@delete',
  'as'    => 'jurnal.delete'
]);

Route::get('keuangan/jurnal_umum/show-detail/{id}', [
  'uses' => 'master_keuangan\d_jurnal_controller@showDetail',
  'as'   => 'jurnal.show-detail;'
]);

Route::get('keuangan/jurnal_umum/list_transaksi', [
  'uses' => 'master_keuangan\d_jurnal_controller@list_transaksi',
  'as'   => 'jurnal.list-transaksi'
]);


//end transaksi_kas



// // transaksi Bank

// Route::get('keuangan/transaksi_bank', [
//   'uses' => 'master_keuangan\transaksi_bank_controller@index',
//   'as'   => 'transaksi_bank.index'
// ]);

// Route::get('keuangan/transaksi_bank/add', [
//   'uses' => 'master_keuangan\transaksi_bank_controller@add',
//   'as'   => 'transaksi_bank.add'
// ]);

// Route::get('keuangan/transaksi_bank/detail/{id}', [
//   'uses' => 'master_keuangan\transaksi_bank_controller@getDetail',
//   'as'   => 'transaksi_bank.detail'
// ]);

// Route::post('keuangan/transaksi_bank/save_data', [
//   'uses'  => 'master_keuangan\transaksi_bank_controller@save_data',
//   'as'    => 'transaksi_bank.save'
// ]);

// Route::get('keuangan/transaksi_bank/show-detail/{id}', [
//   'uses' => 'master_keuangan\transaksi_bank_controller@showDetail',
//   'as'   => 'transaksi_bank.show-detail;'
// ]);

// Route::get('keuangan/transaksi_bank/list_transaksi', [
//   'uses' => 'master_keuangan\transaksi_bank_controller@list_transaksi',
//   'as'   => 'transaksi_bank.list-transaksi'
// ]);

// //end transaksi bank


// transaksi Bank

Route::get('keuangan/transaksi_bank', [
  'uses' => 'master_keuangan\transaksi_bank_controller@index',
  'as'   => 'transaksi_bank.index'
]);

Route::get('keuangan/transaksi_bank/add', [
  'uses' => 'master_keuangan\transaksi_bank_controller@add',
  'as'   => 'transaksi_bank.add'
]);

Route::get('keuangan/transaksi_bank/edit', [
  'uses' => 'master_keuangan\transaksi_bank_controller@edit',
  'as'   => 'transaksi_bank.edit'
]);

Route::get('keuangan/transaksi_bank/detail/{id}', [
  'uses' => 'master_keuangan\transaksi_bank_controller@getDetail',
  'as'   => 'transaksi_bank.detail'
]);

Route::post('keuangan/transaksi_bank/save_data', [
  'uses'  => 'master_keuangan\transaksi_bank_controller@save_data',
  'as'    => 'transaksi_bank.save'
]);

Route::post('keuangan/transaksi_bank/update', [
  'uses'  => 'master_keuangan\transaksi_bank_controller@update',
  'as'    => 'transaksi_bank.update'
]);

Route::get('keuangan/transaksi_bank/delete', [
  'uses'  => 'master_keuangan\transaksi_bank_controller@delete',
  'as'    => 'transaksi_bank.delete'
]);

Route::get('keuangan/transaksi_bank/show-detail/{id}', [
  'uses' => 'master_keuangan\transaksi_bank_controller@showDetail',
  'as'   => 'transaksi_bank.show-detail;'
]);

Route::get('keuangan/transaksi_bank/list_transaksi', [
  'uses' => 'master_keuangan\transaksi_bank_controller@list_transaksi',
  'as'   => 'transaksi_bank.list-transaksi'
]);

//end transaksi bank


// transaksi memorial

Route::get('keuangan/transaksi_memorial', [
  'uses' => 'master_keuangan\transaksi_memorial@index',
  'as'   => 'transaksi_bank.index'
]);

Route::get('keuangan/transaksi_memorial/add', [
  'uses' => 'master_keuangan\transaksi_memorial@add',
  'as'   => 'transaksi_memorial.add'
]);

Route::get('keuangan/transaksi_memorial/edit', [
  'uses' => 'master_keuangan\transaksi_memorial@edit',
  'as'   => 'transaksi_memorial.edit'
]);

Route::get('keuangan/transaksi_memorial/detail/{id}', [
  'uses' => 'master_keuangan\transaksi_memorial@getDetail',
  'as'   => 'transaksi_memorial.detail'
]);

Route::post('keuangan/transaksi_memorial/save_data', [
  'uses'  => 'master_keuangan\transaksi_memorial@save_data',
  'as'    => 'transaksi_memorial.save'
]);

Route::post('keuangan/transaksi_memorial/update', [
  'uses'  => 'master_keuangan\transaksi_memorial@update',
  'as'    => 'transaksi_memorial.update'
]);

Route::get('keuangan/transaksi_memorial/delete', [
  'uses'  => 'master_keuangan\transaksi_memorial@delete',
  'as'    => 'transaksi_memorial.delete'
]);

Route::get('keuangan/transaksi_memorial/show-detail/{id}', [
  'uses' => 'master_keuangan\transaksi_memorial@showDetail',
  'as'   => 'transaksi_memorial.show-detail;'
]);

Route::get('keuangan/transaksi_memorial/list_transaksi', [
  'uses' => 'master_keuangan\transaksi_memorial@list_transaksi',
  'as'   => 'transaksi_memorial.list-transaksi'
]);

//end transaksi memorial




//akun
Route::get('master_keuangan/akun', [
  'uses' => 'master_keuangan\akun_controller@index',
  'as'   => 'akun.index'
]);

Route::get('master_keuangan/add/{parrent}', [
  'uses' => 'master_keuangan\akun_controller@add',
  'as'   => 'akun.add'
]);

Route::get('master_keuangan/edit/{parrent}', [
  'uses' => 'master_keuangan\akun_controller@edit',
  'as'   => 'akun.edit'
]);

Route::post('master_keuangan/akun/save_data', [
  'uses' => 'master_keuangan\akun_controller@save_data',
  'as'   => 'akun.save'
]);

Route::post('master_keuangan/akun/update_data', [
  'uses' => 'master_keuangan\akun_controller@update_data',
  'as'   => 'akun.update'
]);

Route::get('master_keuangan/akun/kota/{id_provinsi}', [
  'uses' => 'master_keuangan\akun_controller@kota',
  'as'   => 'akun.kota'
]);

Route::get('master_keuangan/akun/hapus_data/{id}', [
  'uses'=> 'master_keuangan\akun_controller@hapus_data',
  'as'  => 'akun.hapus'

]);

Route::get('master_keuangan/akun/cek_parrent/{id}', [
  'uses'=> 'master_keuangan\akun_controller@cek_parrent',
  'as'  => 'akun.cek_parrent'
]);

Route::get('master_keuangan/akun/share_akun', [
  'uses'=> 'master_keuangan\akun_controller@share_akun',
  'as'  => 'akun.share'
]);

Route::get('master_keuangan/akun/get/{cabang}', [
  'uses'=> 'master_keuangan\akun_controller@get_akun',
  'as'  => 'akun.get'
]);

Route::get('master_keuangan/akun/tabel', 'master_keuangan\akun_controller@table_data');
Route::get('master_keuangan/akun/get_data', 'master_keuangan\akun_controller@get_data');

// end akun

// Desain Neraca

  Route::get('master_keuangan/desain_neraca', [
    'uses'  => 'master_keuangan\desain_neracaController@index',
    'as'    => 'desain_neraca.index'
  ]);

  Route::get('master_keuangan/desain_neraca/add', [
    'uses'  => 'master_keuangan\desain_neracaController@add',
    'as'    => 'desain_neraca.add'
  ]);

  Route::post('master_keuangan/desain_neraca/save', [
    'uses'  => 'master_keuangan\desain_neracaController@save',
    'as'    => 'desain_neraca.save'
  ]);

  Route::get('master_keuangan/desain_neraca/edit/{id}', [
    'uses'  => 'master_keuangan\desain_neracaController@edit',
    'as'    => 'desain_neraca.edit'
  ]);

  Route::post('master_keuangan/desain_neraca/update/{id}', [
    'uses'  => 'master_keuangan\desain_neracaController@update',
    'as'    => 'desain_neraca.update'
  ]);

  Route::get('master_keuangan/desain_neraca/aktifkan/{id}', [
    'uses'  => 'master_keuangan\desain_neracaController@setActive',
    'as'    => 'desain_neraca.aktifkan'
  ]);

  Route::get('master_keuangan/desain_neraca/delete/{id}', [
    'uses'  => 'master_keuangan\desain_neracaController@delete',
    'as'    => 'desain_neraca.delete'
  ]);

  Route::get('master_keuangan/desain_neraca/view/{id}', [
    'uses'  => 'master_keuangan\desain_neracaController@view',
    'as'    => 'desain_neraca.view'
  ]);

// End Desain Neraca

  // Desain Laba Rugi

  Route::get('master_keuangan/desain_laba_rugi', [
    'uses'  => 'master_keuangan\desain_labaRugiController@index',
    'as'    => 'desain_laba_rugi.index'
  ]);

  Route::get('master_keuangan/desain_laba_rugi/add', [
    'uses'  => 'master_keuangan\desain_labaRugiController@add',
    'as'    => 'desain_laba_rugi.add'
  ]);

  Route::post('master_keuangan/desain_laba_rugi/save', [
    'uses'  => 'master_keuangan\desain_labaRugiController@save',
    'as'    => 'desain_laba_rugi.save'
  ]);

  Route::get('master_keuangan/desain_laba_rugi/edit/{id}', [
    'uses'  => 'master_keuangan\desain_labaRugiController@edit',
    'as'    => 'desain_laba_rugi.edit'
  ]);

  Route::post('master_keuangan/desain_laba_rugi/update/{id}', [
    'uses'  => 'master_keuangan\desain_labaRugiController@update',
    'as'    => 'desain_laba_rugi.update'
  ]);

  Route::get('master_keuangan/desain_laba_rugi/aktifkan/{id}', [
    'uses'  => 'master_keuangan\desain_labaRugiController@setActive',
    'as'    => 'desain_laba_rugi.aktifkan'
  ]);

  Route::get('master_keuangan/desain_laba_rugi/delete/{id}', [
    'uses'  => 'master_keuangan\desain_labaRugiController@delete',
    'as'    => 'desain_laba_rugi.delete'
  ]);

  Route::get('master_keuangan/desain_laba_rugi/view/{id}', [
    'uses'  => 'master_keuangan\desain_labaRugiController@view',
    'as'    => 'desain_laba_rugi.view'
  ]);


  // End Desain Laba Rugi

  // Desain Laba Rugi

  Route::get('master_keuangan/desain_arus_kas', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@index',
    'as'    => 'desain_arus_kas.index'
  ]);

  Route::get('master_keuangan/desain_arus_kas/add', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@add',
    'as'    => 'desain_arus_kas.add'
  ]);

  Route::post('master_keuangan/desain_arus_kas/save', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@save',
    'as'    => 'desain_arus_kas.save'
  ]);

  Route::get('master_keuangan/desain_arus_kas/aktifkan/{id}', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@setActive',
    'as'    => 'desain_arus_kas.aktifkan'
  ]);

  Route::get('master_keuangan/desain_arus_kas/view/{id}', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@view',
    'as'    => 'desain_arus_kas.view'
  ]);

  Route::get('master_keuangan/desain_arus_kas/edit/{id}', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@edit',
    'as'    => 'desain_arus_kas.edit'
  ]);

  Route::post('master_keuangan/desain_arus_kas/update/{id}', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@update',
    'as'    => 'desain_arus_kas.update'
  ]);

  Route::get('master_keuangan/desain_arus_kas/delete/{id}', [
    'uses'  => 'master_keuangan\desain_arus_kas_controller@delete',
    'as'    => 'desain_arus_kas.delete'
  ]);


  // End Desain Laba Rugi

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
  Route::get('pjtki/edit3', function(){
          return view('pjtki.edit3');
         });
  //UPDATE STATUS ORDER PAKET DENY
  Route::get('updatestatus','update_o_Controller@index');
  Route::get('updatestatus/up1','update_o_Controller@up1');
  Route::get('updatestatus/up2','update_o_Controller@up2');
  Route::get('updatestatus/up2/autocomplete','update_o_Controller@autocomplete');
  Route::get('updatestatus/store1','update_o_Controller@store1');
  Route::get('updatestatus/store2','update_o_Controller@store2');
  Route::get('updatestatus/data1/{nomor_do}','update_o_Controller@data1');
  Route::get('updatestatus/data2/{nomor}','update_o_Controller@data2');
  // END OF 


  // UPDATE STATUS KARGO DENY
  Route::get('updatestatus_kargo','update_kargo_Controller@index');
  Route::get('updatestatus_kargo/up1','update_kargo_Controller@up1');
  Route::get('updatestatus_kargo/up2','update_kargo_Controller@up2');
  Route::get('updatestatus_kargo/up2/autocomplete','update_kargo_Controller@autocomplete');
  Route::get('updatestatus_kargo/store1','update_kargo_Controller@store1');
  Route::get('updatestatus_kargo/store2','update_kargo_Controller@store2');
  Route::get('updatestatus_kargo/data1/{nomor_do}','update_kargo_Controller@data1');
  Route::get('updatestatus_kargo/data2/{nomor}','update_kargo_Controller@data2');
  //END OF



  //master transaksi
  Route::get('master-transaksi/index', 'd_trans\master_transaksiController@index');
  Route::get('master-transaksi/table', 'd_trans\master_transaksiController@table');
  Route::get('master-transaksi/form', 'd_trans\master_transaksiController@form');
  Route::get('master-transaksi/save-data', 'd_trans\master_transaksiController@save_data');
  Route::get('master-transaksi/update-data', 'd_trans\master_transaksiController@update_data');
  Route::get('master-transaksi/hapus-data', 'd_trans\master_transaksiController@hapus_data');
  Route::get('master-transaksi/set-kota/{id_provinsi}', 'd_trans\master_transaksiController@setKota');
  ///master transaksi

    //uangmuka
    Route::Get('uangmuka','uangmukaController@index');
    Route::Get('uangmuka/create','uangmukaController@create');
      Route::Get('uangmuka/ajax','uangmukaController@ajax');
    Route::Get('uangmuka/store','uangmukaController@store');
    Route::Get('uangmuka/update/{um_id}','uangmukaController@update');
    Route::Get('uangmuka/hapusuangmuka/{um_id}','uangmukaController@hapus');
    Route::get('uangmuka/edituangmuka/{um_id}','uangmukaController@edit');
       Route::get('uangmuka/print_uangmuka/{um_id}','uangmukaController@cetak');
       Route::get('uangmuka/getnota','uangmukaController@getnota');
    //End of uangmuka


  //akses tampilkan jurnal
  Route::get('data/jurnal/{ref}', 'sales\invoice_Controller@jurnal');
  //laporan invoicepenjualan
  Route::get('sales/laporaninvoicepenjualan','laporan_penjualan\laporaninvoiceController@index');
  Route::get('data/jurnal/{ref}/{note}', 'jurnalController@lihatJurnal');
  Route::get('data/jurnal-umum', 'jurnalController@lihatJurnalUmum');
  Route::get('data/jurnal-umum-pembelian', 'jurnalController@lihatJurnalPemb');


  //laporan Do
  // Route::get('sales/laporandeliveryorder','laporan_penjualan\laporandoController@index');
  //laporan penjualan per item
  Route::get('sales/laporaninvoicepenjualanperitem','laporan_penjualan\laporanpenjualanperitemController@index');
  //laporan seluruhnya
  Route::get('sales/laporan','laporanutamaController@seluruhlaporan');
  });



  Route::get('logout', 'mMemberController@logout');




  Route::get('invoiceprint','sales\invoice_Controller@checkinvoice');
  Route::get('date', 'sales\invoice_Controller@date');


  Route::get('sales/zona','zona_Controller@index');
  Route::get('sales/zona/simpan','zona_Controller@simpan');
  Route::get('sales/zona/hapus','zona_Controller@hapus');
  Route::get('sales/zona/getdata','zona_Controller@getdata');


  //penerus dokumen
  Route::get('sales/tarif_penerus_dokumen','tarif\penerus_dokumen_Controller@index');
  Route::get('sales/tarif_penerus_dokumen/hapus_data','tarif\penerus_dokumen_Controller@hapus_data');
  Route::get('sales/tarif_penerus_dokumen/get_data','tarif\penerus_dokumen_Controller@get_data');
  Route::get('sales/tarif_penerus_dokumen/save_data','tarif\penerus_dokumen_Controller@save_data');
  Route::get('sales/tarif_penerus_dokumen/tabel', 'tarif\penerus_dokumen_Controller@table_data');
  Route::get('sales/tarif_penerus_dokumen/get_kota', 'tarif\penerus_dokumen_Controller@get_kota');
  Route::get('sales/tarif_penerus_dokumen/get_kec', 'tarif\penerus_dokumen_Controller@get_kec');


  //penerus koli
  Route::get('sales/tarif_penerus_koli','tarif\penerus_koli_Controller@index');
  Route::get('sales/tarif_penerus_koli/hapus_data','tarif\penerus_koli_Controller@hapus_data');
  Route::get('sales/tarif_penerus_koli/get_data','tarif\penerus_koli_Controller@get_data');
  Route::get('sales/tarif_penerus_koli/save_data','tarif\penerus_koli_Controller@save_data');
  Route::get('sales/tarif_penerus_koli/tabel', 'tarif\penerus_koli_Controller@table_data');
  Route::get('sales/tarif_penerus_koli/get_kota', 'tarif\penerus_koli_Controller@get_kota');
  Route::get('sales/tarif_penerus_koli/get_kec', 'tarif\penerus_koli_Controller@get_kec');

  //penerus kilogram
  Route::get('sales/tarif_penerus_kilogram','tarif\penerus_kilogram_Controller@index');
  Route::get('sales/tarif_penerus_kilogram/hapus_data','tarif\penerus_kilogram_Controller@hapus_data');
  Route::get('sales/tarif_penerus_kilogram/get_data','tarif\penerus_kilogram_Controller@get_data');
  Route::get('sales/tarif_penerus_kilogram/save_data','tarif\penerus_kilogram_Controller@save_data');
  Route::get('sales/tarif_penerus_kilogram/tabel', 'tarif\penerus_kilogram_Controller@table_data');
  Route::get('sales/tarif_penerus_kilogram/get_kota', 'tarif\penerus_kilogram_Controller@get_kota');
  Route::get('sales/tarif_penerus_kilogram/get_kec', 'tarif\penerus_kilogram_Controller@get_kec');

  // tarif cabang sepeda
  Route::get('sales/tarif_cabang_sepeda', 'tarif\cabang_sepeda_Controller@index');
  Route::get('sales/tarif_cabang_sepeda/tabel', 'tarif\cabang_sepeda_Controller@table_data');
  Route::get('sales/tarif_cabang_sepeda/get_data', 'tarif\cabang_sepeda_Controller@get_data');
  Route::get('sales/tarif_cabang_sepeda/save_data', 'tarif\cabang_sepeda_Controller@save_data');
  Route::get('sales/tarif_cabang_sepeda/hapus_data_perkota', 'tarif\cabang_sepeda_Controller@hapus_data_perkota');
  Route::get('sales/tarif_cabang_sepeda/hapus_data', 'tarif\cabang_sepeda_Controller@hapus_data');
  // end tarif cabang sepeda

  //TARIF
  // tarif cabang dokumen
  Route::get('sales/tarif_cabang_dokumen', 'tarif\cabang_dokumen_Controller@index');
  Route::get('sales/tarif_cabang_dokumen/tabel', 'tarif\cabang_dokumen_Controller@table_data');
  Route::get('sales/tarif_cabang_dokumen/get_data', 'tarif\cabang_dokumen_Controller@get_data');
  Route::get('sales/tarif_cabang_dokumen/save_data', 'tarif\cabang_dokumen_Controller@save_data');
  Route::get('sales/tarif_cabang_dokumen/hapus_data', 'tarif\cabang_dokumen_Controller@hapus_data');
  Route::get('sales/tarif_cabang_dokumen/hapus_data_perkota', 'tarif\cabang_dokumen_Controller@hapus_data_perkota');
  // end tarif cabang dokumen

  // tarif cabang kilogram
  Route::get('sales/tarif_cabang_kilogram', 'tarif\cabang_kilogram_Controller@index');
  Route::get('sales/tarif_cabang_kilogram/tabel', 'tarif\cabang_kilogram_Controller@table_data');
  Route::get('sales/tarif_cabang_kilogram/get_data', 'tarif\cabang_kilogram_Controller@get_data');
  Route::get('sales/tarif_cabang_kilogram/save_data', 'tarif\cabang_kilogram_Controller@save_data');
  Route::get('sales/tarif_cabang_kilogram/update_data', 'tarif\cabang_kilogram_Controller@update_data');
  Route::get('sales/tarif_cabang_kilogram/hapus_data', 'tarif\cabang_kilogram_Controller@hapus_data');
  Route::get('sales/tarif_cabang_kilogram/hapus_data_perkota', 'tarif\cabang_kilogram_Controller@hapus_data_perkota');
  Route::get('sales/tarif_cabang_kilogram/panggil_nota', 'tarif\cabang_kilogram_Controller@panggil_nota');
  // end tarif cabang kilogram

  // tarif cabang koli
  Route::get('sales/tarif_cabang_koli', 'tarif\cabang_koli_Controller@index');
  Route::get('sales/tarif_cabang_koli/tabel', 'tarif\cabang_koli_Controller@table_data');
  Route::get('sales/tarif_cabang_koli/get_data', 'tarif\cabang_koli_Controller@get_data');
  Route::get('sales/tarif_cabang_koli/save_data', 'tarif\cabang_koli_Controller@save_data');
  Route::get('sales/tarif_cabang_koli/hapus_data', 'tarif\cabang_koli_Controller@hapus_data');
  Route::get('sales/tarif_cabang_koli/hapus_data_perkota', 'tarif\cabang_koli_Controller@hapus_data_perkota');
  // end tarif cabang koli

  // tarif cabang kargo
  Route::get('sales/tarif_cabang_kargo', 'tarif\cabang_kargo_Controller@index');
  Route::get('sales/tarif_cabang_kargo/tabel', 'tarif\cabang_kargo_Controller@table_data');
  Route::get('sales/tarif_cabang_kargo/get_data', 'tarif\cabang_kargo_Controller@get_data');
  Route::get('sales/tarif_cabang_kargo/save_data', 'tarif\cabang_kargo_Controller@save_data');
  Route::get('sales/tarif_cabang_kargo/hapus_data', 'tarif\cabang_kargo_Controller@hapus_data');
  Route::get('sales/tarif_cabang_kargo/hapus_data_perkota', 'tarif\cabang_kargo_Controller@hapus_data_perkota');
  // end tarif cabang kargo

  // tarif penerus default
  Route::get('sales/tarif_penerus_default', 'tarif\penerus_default_Controller@index');
  Route::get('sales/tarif_penerus_default/tabel', 'tarif\penerus_default_Controller@table_data');
  Route::get('sales/tarif_penerus_default/get_data', 'tarif\penerus_default_Controller@get_data');
  Route::get('sales/tarif_penerus_default/save_data', 'tarif\penerus_default_Controller@save_data');
  Route::get('sales/tarif_penerus_default/hapus_data', 'tarif\penerus_default_Controller@hapus_data');

  // tarif cabang sepeda
  Route::get('sales/tarif_cabang_sepeda', 'tarif\cabang_sepeda_Controller@index');
  Route::get('sales/tarif_cabang_sepeda/tabel', 'tarif\cabang_sepeda_Controller@table_data');
  Route::get('sales/tarif_cabang_sepeda/get_data', 'tarif\cabang_sepeda_Controller@get_data');
  Route::get('sales/tarif_cabang_sepeda/save_data', 'tarif\cabang_sepeda_Controller@save_data');
  Route::get('sales/tarif_cabang_sepeda/hapus_data', 'tarif\cabang_sepeda_Controller@hapus_data');
  // end tarif cabang sepeda

  //TARIF
  // tarif cabang dokumen
  Route::get('sales/tarif_cabang_dokumen', 'tarif\cabang_dokumen_Controller@index');
  Route::get('sales/tarif_cabang_dokumen/tabel', 'tarif\cabang_dokumen_Controller@table_data');
  Route::get('sales/tarif_cabang_dokumen/get_data', 'tarif\cabang_dokumen_Controller@get_data');
  Route::get('sales/tarif_cabang_dokumen/save_data', 'tarif\cabang_dokumen_Controller@save_data');
  Route::get('sales/tarif_cabang_dokumen/hapus_data', 'tarif\cabang_dokumen_Controller@hapus_data');
  Route::get('sales/tarif_cabang_dokumen/hapus_data_perkota', 'tarif\cabang_dokumen_Controller@hapus_data_perkota');
  // end tarif cabang dokumen

  // tarif cabang kilogram
  Route::get('sales/tarif_cabang_kilogram', 'tarif\cabang_kilogram_Controller@index');
  Route::get('sales/tarif_cabang_kilogram/tabel', 'tarif\cabang_kilogram_Controller@table_data');
  Route::get('sales/tarif_cabang_kilogram/get_data', 'tarif\cabang_kilogram_Controller@get_data');
  Route::get('sales/tarif_cabang_kilogram/save_data', 'tarif\cabang_kilogram_Controller@save_data');
  Route::get('sales/tarif_cabang_kilogram/hapus_data', 'tarif\cabang_kilogram_Controller@hapus_data');
  Route::get('sales/tarif_cabang_kilogram/hapus_data_perkota', 'tarif\cabang_kilogram_Controller@hapus_data_perkota');
  // end tarif cabang kilogram

  // tarif cabang koli
  Route::get('sales/tarif_cabang_koli', 'tarif\cabang_koli_Controller@index');
  Route::get('sales/tarif_cabang_koli/tabel', 'tarif\cabang_koli_Controller@table_data');
  Route::get('sales/tarif_cabang_koli/get_data', 'tarif\cabang_koli_Controller@get_data');
  Route::get('sales/tarif_cabang_koli/save_data', 'tarif\cabang_koli_Controller@save_data');
  Route::get('sales/tarif_cabang_koli/hapus_data', 'tarif\cabang_koli_Controller@hapus_data');
  Route::get('sales/tarif_cabang_koli/hapus_data_perkota', 'tarif\cabang_koli_Controller@hapus_data_perkota');
  // end tarif cabang koli

  // tarif cabang kargo
  Route::get('sales/tarif_cabang_kargo', 'tarif\cabang_kargo_Controller@index');
  Route::get('sales/tarif_cabang_kargo/tabel', 'tarif\cabang_kargo_Controller@table_data');
  Route::get('sales/tarif_cabang_kargo/get_data', 'tarif\cabang_kargo_Controller@get_data');
  Route::get('sales/tarif_cabang_kargo/save_data', 'tarif\cabang_kargo_Controller@save_data');
  Route::get('sales/tarif_cabang_kargo/hapus_data', 'tarif\cabang_kargo_Controller@hapus_data');
  // end tarif cabang kargo

  // tarif penerus default
  Route::get('sales/tarif_penerus_default', 'tarif\penerus_default_Controller@index');
  Route::get('sales/tarif_penerus_default/tabel', 'tarif\penerus_default_Controller@table_data');
  Route::get('sales/tarif_penerus_default/get_data', 'tarif\penerus_default_Controller@get_data');
  Route::get('sales/tarif_penerus_default/save_data', 'tarif\penerus_default_Controller@save_data');
  Route::get('sales/tarif_penerus_default/hapus_data', 'tarif\penerus_default_Controller@hapus_data');
  // end tarif penerus default

  // tarif penerus sepeda
  Route::get('sales/tarif_penerus_sepeda', 'tarif\penerus_sepeda_Controller@index');
  Route::get('sales/tarif_penerus_sepeda/tabel', 'tarif\penerus_sepeda_Controller@table_data');
  Route::get('sales/tarif_penerus_sepeda/get_data', 'tarif\penerus_sepeda_Controller@get_data');
  Route::get('sales/tarif_penerus_sepeda/save_data', 'tarif\penerus_sepeda_Controller@save_data');
  Route::get('sales/tarif_penerus_sepeda/hapus_data', 'tarif\penerus_sepeda_Controller@hapus_data');
  Route::get('sales/tarif_penerus_sepeda/get_kota', 'tarif\penerus_sepeda_Controller@get_kota');
  Route::get('sales/tarif_penerus_sepeda/get_kec', 'tarif\penerus_sepeda_Controller@get_kec');


  // tarif cabang VENDOR
  Route::get('sales/tarif_vendor', 'tarif\tarif_vendorController@index');
  Route::get('sales/tarif_vendor/tabel', 'tarif\tarif_vendorController@table_data')->name('tarif_vendor_datatable');
  Route::get('sales/tarif_vendor/get_data', 'tarif\tarif_vendorController@get_data')->name('get_data_tarif_vendor');
  Route::get('sales/tarif_vendor/save_data', 'tarif\tarif_vendorController@save_data');
  Route::get('sales/tarif_vendor/hapus_data', 'tarif\tarif_vendorController@hapus_data');
  Route::get('sales/tarif_vendor/hapus_data_perkota', 'tarif\tarif_vendorController@hapus_data_perkota');
  Route::get('sales/tarif_vendor/cabang_vendor', 'tarif\tarif_vendorController@cabang_vendor')->name('cabang_vendor');
  Route::get('sales/tarif_vendor/check_kontrak_vendor', 'tarif\tarif_vendorController@check_kontrak_vendor')->name('check_kontrak_vendor');
  // end tarif cabang VENDOR

  Route::get('master_sales/group_customer','master_sales\grup_customer_Controller@index');
  Route::get('master_sales/group_customer/tabel','master_sales\grup_customer_Controller@table_data');
  Route::get('master_sales/group_customer/get_data','master_sales\grup_customer_Controller@get_data');
  Route::get('master_sales/group_customer/save_data','master_sales\grup_customer_Controller@save_data');
  Route::get('master_sales/group_customer/hapus_data','master_sales\grup_customer_Controller@hapus_data');
// End Desain Laba Rugi

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
Route::get('pjtki/edit3', function(){
        return view('pjtki.edit3');
       });
//UPDATE STATUS ORDER PAKET DENY
Route::get('updatestatus','update_o_Controller@index');
Route::get('updatestatus/up1','update_o_Controller@up1');
Route::get('updatestatus/up2','update_o_Controller@up2');
Route::get('updatestatus/up2/autocomplete','update_o_Controller@autocomplete');
Route::get('updatestatus/store1','update_o_Controller@store1');
Route::get('updatestatus/store2','update_o_Controller@store2');
Route::get('updatestatus/data1/{nomor_do}','update_o_Controller@data1');
Route::get('updatestatus/data2/{nomor}','update_o_Controller@data2');
// END OF 


// UPDATE STATUS KARGO DENY
Route::get('updatestatus_kargo','update_kargo_Controller@index');
Route::get('updatestatus_kargo/up1','update_kargo_Controller@up1');
Route::get('updatestatus_kargo/up2','update_kargo_Controller@up2');
Route::get('updatestatus_kargo/up2/autocomplete','update_kargo_Controller@autocomplete');
Route::get('updatestatus_kargo/store1','update_kargo_Controller@store1');
Route::get('updatestatus_kargo/store2','update_kargo_Controller@store2');
Route::get('updatestatus_kargo/data1/{nomor_do}','update_kargo_Controller@data1');
Route::get('updatestatus_kargo/data2/{nomor}','update_kargo_Controller@data2');
//END OF



//master transaksi
Route::get('master-transaksi/index', 'd_trans\master_transaksiController@index');
Route::get('master-transaksi/table', 'd_trans\master_transaksiController@table');
Route::get('master-transaksi/form', 'd_trans\master_transaksiController@form');
Route::get('master-transaksi/save-data', 'd_trans\master_transaksiController@save_data');
Route::get('master-transaksi/update-data', 'd_trans\master_transaksiController@update_data');
Route::get('master-transaksi/hapus-data', 'd_trans\master_transaksiController@hapus_data');
Route::get('master-transaksi/set-kota/{id_provinsi}', 'd_trans\master_transaksiController@setKota');
///master transaksi

  //uangmuka
  Route::Get('uangmuka','uangmukaController@index');
  Route::Get('uangmuka/create','uangmukaController@create');
    Route::Get('uangmuka/ajax','uangmukaController@ajax');
  Route::Get('uangmuka/store','uangmukaController@store');
  Route::Get('uangmuka/update/{um_id}','uangmukaController@update');
  Route::Get('uangmuka/hapusuangmuka/{um_id}','uangmukaController@hapus');
  Route::get('uangmuka/edituangmuka/{um_id}','uangmukaController@edit');
     Route::get('uangmuka/print_uangmuka/{um_id}','uangmukaController@cetak');
  //End of uangmuka


//akses tampilkan jurnal
Route::get('data/jurnal/{ref}', 'sales\invoice_Controller@jurnal');
//laporan invoicepenjualan
Route::get('sales/laporaninvoicepenjualan','laporan_penjualan\laporaninvoiceController@index');
Route::get('data/jurnal/{ref}/{note}', 'jurnalController@lihatJurnal');
Route::get('data/jurnal-umum', 'jurnalController@lihatJurnalUmum');


//laporan Do
// Route::get('sales/laporandeliveryorder','laporan_penjualan\laporandoController@index');
//laporan penjualan per item
Route::get('sales/laporaninvoicepenjualanperitem','laporan_penjualan\laporanpenjualanperitemController@index');
//laporan seluruhnya
Route::get('sales/laporan','laporanutamaController@seluruhlaporan');
//LAPORAN PEMBELIAN

//analisa hutang
Route::get('reportanalisausiahutang/reportanalisausiahutang', 'LaporanPembelianController@reportanalisausiahutang');
// Route::get('reportanalisausiahutang/reportanalisausiahutang', 'laporan_pembelian@reportanalisausiahutang');


Route::get('logout', 'mMemberController@logout');

//mutasi hutang
Route::get('laporan_pembelian/mutasi_hutang', 'laporan_pembelian\mutasi_hutang_Controller@index');
Route::get('laporan_pembelian/mutasi_hutang/cari_ajax_mutasi_hutang', 'laporan_pembelian\mutasi_hutang_Controller@cari_ajax_mutasi_hutang')->name('cari_ajax_mutasi_hutang');
Route::get('laporan_pembelian/mutasi_hutang/cari_ajax_mutasi_hutang_detail', 'laporan_pembelian\mutasi_hutang_Controller@cari_ajax_mutasi_hutang_detail')->name('cari_ajax_mutasi_hutang_detail');
// end mutasi hutang

// //pembelian
// Route::get('reportbayarkas/reportbayarkas', 'LaporanPurchaseController@reportbayarkas');
// Route::get('reportbayarbank/reportbayarbank', 'LaporanPurchaseController@reportbayarbank');
// Route::get('reportmutasihutang/reportmutasihutang', 'LaporanPurchaseController@reportmutasihutang');
// Route::get('reportfakturpelunasan/reportfakturpelunasan', 'LaporanPurchaseController@reportfakturpelunasan');
// Route::get('reportanalisausiahutang/reportanalisausiahutang', 'LaporanPurchaseController@reportanalisausiahutang');
// Route::get('historisuangmukapembelian/historisuangmukapembelian', 'LaporanPurchaseController@historisuangmukapembelian');

// Route::get('fakturpajakmasukan/fakturpajakmasukan', 'LaporanPurchaseController@fakturpajakmasukan');
// Route::get('kartuhutang/kartuhutang', 'LaporanPurchaseController@kartuhutang');

// Route::get('kartuhutangajax/kartuhutangajax', 'LaporanPurchaseController@kartuhutangajax');

// Route::get('reportkartuhutang/reportkartuhutang', 'LaporanPurchaseController@reportkartuhutang');
// Route::get('reportexcelkartuhutang/reportexcelkartuhutang', 'LaporanPurchaseController@reportexcelkartuhutang');
// Route::get('reportfakturpajakmasukan/reportfakturpajakmasukan', 'LaporanPurchaseController@reportfakturpajakmasukan');


Route::get('invoiceprint','sales\invoice_Controller@checkinvoice');
Route::get('date', 'sales\invoice_Controller@date');


Route::get('sales/zona','zona_Controller@index');
Route::get('sales/zona/simpan','zona_Controller@simpan');
Route::get('sales/zona/hapus','zona_Controller@hapus');
Route::get('sales/zona/getdata','zona_Controller@getdata');


//penerus dokumen
Route::get('sales/tarif_penerus_dokumen','tarif\penerus_dokumen_Controller@index');
Route::get('sales/tarif_penerus_dokumen/hapus_data','tarif\penerus_dokumen_Controller@hapus_data');
Route::get('sales/tarif_penerus_dokumen/get_data','tarif\penerus_dokumen_Controller@get_data');
Route::get('sales/tarif_penerus_dokumen/save_data','tarif\penerus_dokumen_Controller@save_data');
Route::get('sales/tarif_penerus_dokumen/tabel', 'tarif\penerus_dokumen_Controller@table_data');
Route::get('sales/tarif_penerus_dokumen/get_kota', 'tarif\penerus_dokumen_Controller@get_kota');
Route::get('sales/tarif_penerus_dokumen/get_kec', 'tarif\penerus_dokumen_Controller@get_kec');


//penerus koli
Route::get('sales/tarif_penerus_koli','tarif\penerus_koli_Controller@index');
Route::get('sales/tarif_penerus_koli/hapus_data','tarif\penerus_koli_Controller@hapus_data');
Route::get('sales/tarif_penerus_koli/get_data','tarif\penerus_koli_Controller@get_data');
Route::get('sales/tarif_penerus_koli/save_data','tarif\penerus_koli_Controller@save_data');
Route::get('sales/tarif_penerus_koli/tabel', 'tarif\penerus_koli_Controller@table_data');
Route::get('sales/tarif_penerus_koli/get_kota', 'tarif\penerus_koli_Controller@get_kota');
Route::get('sales/tarif_penerus_koli/get_kec', 'tarif\penerus_koli_Controller@get_kec');

//penerus kilogram
Route::get('sales/tarif_penerus_kilogram','tarif\penerus_kilogram_Controller@index');
Route::get('sales/tarif_penerus_kilogram/hapus_data','tarif\penerus_kilogram_Controller@hapus_data');
Route::get('sales/tarif_penerus_kilogram/get_data','tarif\penerus_kilogram_Controller@get_data');
Route::get('sales/tarif_penerus_kilogram/save_data','tarif\penerus_kilogram_Controller@save_data');
Route::get('sales/tarif_penerus_kilogram/tabel', 'tarif\penerus_kilogram_Controller@table_data');
Route::get('sales/tarif_penerus_kilogram/get_kota', 'tarif\penerus_kilogram_Controller@get_kota');
Route::get('sales/tarif_penerus_kilogram/get_kec', 'tarif\penerus_kilogram_Controller@get_kec');

// tarif cabang sepeda
Route::get('sales/tarif_cabang_sepeda', 'tarif\cabang_sepeda_Controller@index');
Route::get('sales/tarif_cabang_sepeda/tabel', 'tarif\cabang_sepeda_Controller@table_data');
Route::get('sales/tarif_cabang_sepeda/get_data', 'tarif\cabang_sepeda_Controller@get_data');
Route::get('sales/tarif_cabang_sepeda/save_data', 'tarif\cabang_sepeda_Controller@save_data');
Route::get('sales/tarif_cabang_sepeda/hapus_data_perkota', 'tarif\cabang_sepeda_Controller@hapus_data_perkota');
Route::get('sales/tarif_cabang_sepeda/hapus_data', 'tarif\cabang_sepeda_Controller@hapus_data');
// end tarif cabang sepeda

//TARIF
// tarif cabang dokumen
Route::get('sales/tarif_cabang_dokumen', 'tarif\cabang_dokumen_Controller@index');
Route::get('sales/tarif_cabang_dokumen/tabel', 'tarif\cabang_dokumen_Controller@table_data');
Route::get('sales/tarif_cabang_dokumen/get_data', 'tarif\cabang_dokumen_Controller@get_data');
Route::get('sales/tarif_cabang_dokumen/save_data', 'tarif\cabang_dokumen_Controller@save_data');
Route::get('sales/tarif_cabang_dokumen/hapus_data', 'tarif\cabang_dokumen_Controller@hapus_data');
Route::get('sales/tarif_cabang_dokumen/hapus_data_perkota', 'tarif\cabang_dokumen_Controller@hapus_data_perkota');
// end tarif cabang dokumen

// tarif cabang kilogram
Route::get('sales/tarif_cabang_kilogram', 'tarif\cabang_kilogram_Controller@index');
Route::get('sales/tarif_cabang_kilogram/tabel', 'tarif\cabang_kilogram_Controller@table_data');
Route::get('sales/tarif_cabang_kilogram/get_data', 'tarif\cabang_kilogram_Controller@get_data');
Route::get('sales/tarif_cabang_kilogram/save_data', 'tarif\cabang_kilogram_Controller@save_data');
Route::get('sales/tarif_cabang_kilogram/hapus_data', 'tarif\cabang_kilogram_Controller@hapus_data');
Route::get('sales/tarif_cabang_kilogram/hapus_data_perkota', 'tarif\cabang_kilogram_Controller@hapus_data_perkota');
// end tarif cabang kilogram

// tarif cabang koli
Route::get('sales/tarif_cabang_koli', 'tarif\cabang_koli_Controller@index');
Route::get('sales/tarif_cabang_koli/tabel', 'tarif\cabang_koli_Controller@table_data');
Route::get('sales/tarif_cabang_koli/get_data', 'tarif\cabang_koli_Controller@get_data');
Route::get('sales/tarif_cabang_koli/save_data', 'tarif\cabang_koli_Controller@save_data');
Route::get('sales/tarif_cabang_koli/hapus_data', 'tarif\cabang_koli_Controller@hapus_data');
Route::get('sales/tarif_cabang_koli/hapus_data_perkota', 'tarif\cabang_koli_Controller@hapus_data_perkota');
// end tarif cabang koli

// tarif cabang kargo
Route::get('sales/tarif_cabang_kargo', 'tarif\cabang_kargo_Controller@index');
Route::get('sales/tarif_cabang_kargo/tabel', 'tarif\cabang_kargo_Controller@table_data');
Route::get('sales/tarif_cabang_kargo/get_data', 'tarif\cabang_kargo_Controller@get_data');
Route::get('sales/tarif_cabang_kargo/save_data', 'tarif\cabang_kargo_Controller@save_data');
Route::get('sales/tarif_cabang_kargo/hapus_data', 'tarif\cabang_kargo_Controller@hapus_data');
// end tarif cabang kargo

// tarif penerus default
Route::get('sales/tarif_penerus_default', 'tarif\penerus_default_Controller@index');
Route::get('sales/tarif_penerus_default/tabel', 'tarif\penerus_default_Controller@table_data');
Route::get('sales/tarif_penerus_default/get_data', 'tarif\penerus_default_Controller@get_data');
Route::get('sales/tarif_penerus_default/save_data', 'tarif\penerus_default_Controller@save_data');
Route::get('sales/tarif_penerus_default/hapus_data', 'tarif\penerus_default_Controller@hapus_data');

// tarif cabang sepeda
Route::get('sales/tarif_cabang_sepeda', 'tarif\cabang_sepeda_Controller@index');
Route::get('sales/tarif_cabang_sepeda/tabel', 'tarif\cabang_sepeda_Controller@table_data');
Route::get('sales/tarif_cabang_sepeda/get_data', 'tarif\cabang_sepeda_Controller@get_data');
Route::get('sales/tarif_cabang_sepeda/save_data', 'tarif\cabang_sepeda_Controller@save_data');
Route::get('sales/tarif_cabang_sepeda/hapus_data', 'tarif\cabang_sepeda_Controller@hapus_data');
// end tarif cabang sepeda

//TARIF
// tarif cabang dokumen
Route::get('sales/tarif_cabang_dokumen', 'tarif\cabang_dokumen_Controller@index');
Route::get('sales/tarif_cabang_dokumen/tabel', 'tarif\cabang_dokumen_Controller@table_data');
Route::get('sales/tarif_cabang_dokumen/get_data', 'tarif\cabang_dokumen_Controller@get_data');
Route::get('sales/tarif_cabang_dokumen/save_data', 'tarif\cabang_dokumen_Controller@save_data');
Route::get('sales/tarif_cabang_dokumen/hapus_data', 'tarif\cabang_dokumen_Controller@hapus_data');
Route::get('sales/tarif_cabang_dokumen/hapus_data_perkota', 'tarif\cabang_dokumen_Controller@hapus_data_perkota');
// end tarif cabang dokumen

// tarif cabang kilogram
Route::get('sales/tarif_cabang_kilogram', 'tarif\cabang_kilogram_Controller@index');
Route::get('sales/tarif_cabang_kilogram/tabel', 'tarif\cabang_kilogram_Controller@table_data');
Route::get('sales/tarif_cabang_kilogram/get_data', 'tarif\cabang_kilogram_Controller@get_data');
Route::get('sales/tarif_cabang_kilogram/save_data', 'tarif\cabang_kilogram_Controller@save_data');
Route::get('sales/tarif_cabang_kilogram/hapus_data', 'tarif\cabang_kilogram_Controller@hapus_data');
Route::get('sales/tarif_cabang_kilogram/hapus_data_perkota', 'tarif\cabang_kilogram_Controller@hapus_data_perkota');
// end tarif cabang kilogram

// tarif cabang koli
Route::get('sales/tarif_cabang_koli', 'tarif\cabang_koli_Controller@index');
Route::get('sales/tarif_cabang_koli/tabel', 'tarif\cabang_koli_Controller@table_data');
Route::get('sales/tarif_cabang_koli/get_data', 'tarif\cabang_koli_Controller@get_data');
Route::get('sales/tarif_cabang_koli/save_data', 'tarif\cabang_koli_Controller@save_data');
Route::get('sales/tarif_cabang_koli/hapus_data', 'tarif\cabang_koli_Controller@hapus_data');
Route::get('sales/tarif_cabang_koli/hapus_data_perkota', 'tarif\cabang_koli_Controller@hapus_data_perkota');
// end tarif cabang koli

// tarif cabang kargo
Route::get('sales/tarif_cabang_kargo', 'tarif\cabang_kargo_Controller@index');
Route::get('sales/tarif_cabang_kargo/tabel', 'tarif\cabang_kargo_Controller@table_data');
Route::get('sales/tarif_cabang_kargo/get_data', 'tarif\cabang_kargo_Controller@get_data');
Route::get('sales/tarif_cabang_kargo/save_data', 'tarif\cabang_kargo_Controller@save_data');
Route::get('sales/tarif_cabang_kargo/hapus_data', 'tarif\cabang_kargo_Controller@hapus_data');
// end tarif cabang kargo

// tarif penerus default
Route::get('sales/tarif_penerus_default', 'tarif\penerus_default_Controller@index');
Route::get('sales/tarif_penerus_default/tabel', 'tarif\penerus_default_Controller@table_data');
Route::get('sales/tarif_penerus_default/get_data', 'tarif\penerus_default_Controller@get_data');
Route::get('sales/tarif_penerus_default/save_data', 'tarif\penerus_default_Controller@save_data');
Route::get('sales/tarif_penerus_default/hapus_data', 'tarif\penerus_default_Controller@hapus_data');
// end tarif penerus default

// tarif penerus sepeda
Route::get('sales/tarif_penerus_sepeda', 'tarif\penerus_sepeda_Controller@index');
Route::get('sales/tarif_penerus_sepeda/tabel', 'tarif\penerus_sepeda_Controller@table_data');
Route::get('sales/tarif_penerus_sepeda/get_data', 'tarif\penerus_sepeda_Controller@get_data');
Route::get('sales/tarif_penerus_sepeda/save_data', 'tarif\penerus_sepeda_Controller@save_data');
Route::get('sales/tarif_penerus_sepeda/hapus_data', 'tarif\penerus_sepeda_Controller@hapus_data');
Route::get('sales/tarif_penerus_sepeda/get_kota', 'tarif\penerus_sepeda_Controller@get_kota');
Route::get('sales/tarif_penerus_sepeda/get_kec', 'tarif\penerus_sepeda_Controller@get_kec');



Route::get('master_sales/group_customer','master_sales\grup_customer_Controller@index');
Route::get('master_sales/group_customer/tabel','master_sales\grup_customer_Controller@table_data');
Route::get('master_sales/group_customer/get_data','master_sales\grup_customer_Controller@get_data');
Route::get('master_sales/group_customer/save_data','master_sales\grup_customer_Controller@save_data');
Route::get('master_sales/group_customer/hapus_data','master_sales\grup_customer_Controller@hapus_data');

// stock mutasi
Route::get('mutasi_stock/mutasi_stock','StockMutController@index');

// diskon penjualan
Route::get('master_sales/diskonpenjualan' , 'DiskonPenjualanController@index');
Route::get('master_sales/diskonpenjualan/simpan' , 'DiskonPenjualanController@save');
Route::get('master_sales/diskonpenjualan/getAkun' , 'DiskonPenjualanController@getAkun');
Route::get('master_sales/diskonpenjualan/getData' , 'DiskonPenjualanController@getData');
Route::get('master_sales/diskonpenjualan/hapus' , 'DiskonPenjualanController@delete');


//print out do 

Route::get('dopo','LaporanMasterController@dopo');

//STOCK OPNAME

/*Route::get('stockopname/detailstockopname' , 'StockOpnameController@detailstockopname');
*/
//MASTER PERUSAHAAN

Route::get('master/master_perusahaan', 'MasterPerusahaanController@index');
Route::post('master/master_perusahaan/save_data', 'MasterPerusahaanController@simpan');

//END OF
// MASTER TRANSAKSI
Route::get('master/master_transaksi', 'master_transaksi_controller@index');
Route::get('master/master_transaksi/save', 'master_transaksi_controller@save');
Route::get('master/master_transaksi/datatable_transaksi','master_transaksi_controller@datatable_transaksi')->name('datatable_transaksi');
Route::get('master/master_transaksi/edit/{id}', 'master_transaksi_controller@edit');
Route::get('master/master_transaksi/create', 'master_transaksi_controller@create');





Route::get('test/test', 'LaporanMasterController@testtest');










