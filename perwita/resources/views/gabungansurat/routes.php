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
Route::get('coba', function(){
				return view('coba');
			 });
Route::get('seragam', function(){
        return view('seragam.seragam');
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
Route::get('bpjs/daftargaji', function(){
        return view('bpjs.daftargaji');
       });
Route::get('bpjs/input_daftargaji', function(){
        return view('bpjs.input_daftargaji');
       });
Route::get('bpjs/edit_daftargaji', function(){
        return view('bpjs.edit_daftargaji');
       });
Route::get('bpjs/cetak_daftargaji', function(){
        return view('bpjs.cetak_daftargaji');
       });
Route::get('bpjs/rbh', function(){
        return view('bpjs.rbh');
       });
Route::get('bpjs/cetak_rbh', function(){
        return view('bpjs.cetak_rbh');
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

  	