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

  	/* Route Login */

		 Route::get('/', [
		 	'uses'  => 'loginController@showLogin',
		 	'as'	=> 'login.show'
		 ]);

		 Route::get('login', [
		 	'uses'  => 'loginController@authenticate',
		 	'as'	=> 'login.authenticate'
		 ]);

		 Route::get('logout', [
		 	'uses'  => 'loginController@logout',
		 	'as'	=> 'login.logout'
		 ]);

		 Route::get('login/comp-gate', [
		 	'uses'  => 'loginController@showGate',
		 	'as'	=> 'login.showGate'
		 ]);

		 Route::post('login/comp-gate', [
		 	'uses'  => 'loginController@compCheck',
		 	'as'	=> 'login.compCheck'
		 ]);
		 Route::post('login/comp-gatec', [
		 	'uses'  => 'loginController@compCheck',
		 	'as'	=> 'login.compCheck'
		 ]);

		 Route::get('login/email-verification', [
		 	'uses'  => 'loginController@showEmaliVerication',
		 	'as'	=> 'login.showEmaliVerication'
		 ]);

		 Route::post('login/email-verification', [
		 	'uses'  => 'loginController@sendVerification',
		 	'as'	=> 'login.sendVerification'
		 ]);

		 Route::get('login/email-verification/success', [
		 	'uses'  => 'loginController@vericationSuccess',
		 	'as'	=> 'login.vericationSuccess'
		 ]);

		 Route::get('verify-email/{code}', [
		 	'uses'	=> 'loginController@verifiedEmail',
		 	'as'	=> 'login.verifiedEmail'
		 ]);

		 Route::get('gate/step1', [
		 	'uses'	=> 'loginController@step1Show',
		 	'as'	=> 'login.step1Show'
		 ]);

		 Route::post('gate/step1', [
		 	'uses'	=> 'loginController@passwordReset',
		 	'as'	=> 'login.passwordReset'
		 ]);

		 Route::get('gate/step2', [
		 	'uses'	=> 'loginController@step2Show',
		 	'as'	=> 'login.step2Show'
		 ]);

		 Route::post('gate/step2', [
		 	'uses'	=> 'loginController@addComp',
		 	'as'	=> 'login.addComp'
		 ]);

	/* Route Login End  selesai*/

	/* route setelah login */

		Route::group(['middleware' => ['auth', 'step']], function(){
			Route::get('dashboard', function(){
				return view('dashboard');
			 })->name('dashboard');
                         
			/*--------- Profile Penguna ---------------*/
                         Route::get('profile/profile-pengguna', [
					'uses'	=> 'profile_penggunaController@index',
					'as'	=> 'profile_pengguna.index'
				]);
                         Route::get('profile-pengguna/{id}/edit', [
					'uses'	=> 'profile_penggunaController@edit',
					'as'	=> 'profile_penggunaController.edit'
				]);
                         Route::get('profile/tambah-email/store', [
					'uses'	=> 'profile_penggunaController@tambah_email',
					'as'	=> 'profile_penggunaController.tambah_email'
				]);
                         Route::get('profile/profile-pengguna/update/{id}', [
					'uses'	=> 'profile_penggunaController@update',
					'as'	=> 'profile_pengguna.update'                             
				]);
                         Route::get('profile/hapus-email/{email}', [
					'uses'	=> 'profile_penggunaController@hapus_email',
					'as'	=> 'profile_pengguna.hapus_email'                             
				]);
                         Route::get('profile/log-pengguna', [
					'uses'	=> 'profile_penggunaController@log_pengguna',
					'as'	=> 'profile_pengguna.log_pengguna'                             
				]);
			/*--------- Profile Penguna Selesai ---------------*/
			/*route master-perusahaan */

				Route::get('data-master/master-perusahaan', [
					'uses'	=> 'd_compController@index',
					'as'	=> 'master-perusahaan.index'
				]);

				Route::get('data-master/master-perusahaan/create', [
					'uses'	=> 'd_compController@create',
					'as'	=> 'master-perusahaan.create'
				]);

				Route::post('data-master/master-perusahaan', [
					'uses'	=> 'd_compController@store',
					'as'	=> 'master-perusahaan.store'
				]);

				Route::get('data-master/master-perusahaan/data', [
					'uses'	=> 'd_compController@data',
					'as'	=> 'master-perusahaan.data'
				]);

			/*route master-perusahaan selesai */ 


			
			
			

			/* nang kene mas route sampeyan */
			
						//d_comp_coa    			
			Route::get('data-master/master-akun/generate_akun/{route}/{id_comp}', [
				'uses' => 'd_comp_coaController@generate_akun',
				'as' => 'd_comp_coa.generate_akun'
			]);
			Route::get('data-master/master-akun', [
				'uses' => 'd_comp_coaController@index',
				'as' => 'd_comp_coa.index'
			]);
			Route::get('data-master/master-akun/store', [
				'uses' => 'd_comp_coaController@store',
				'as' => 'd_comp_coa.store'
			]);
			Route::get('data-master/master-akun/coa_level/{id}', [
				'uses' => 'd_comp_coaController@coa_level',
				'as' => 'd_comp_coa.coa_level'
			]);
			Route::get('data-master/master-akun/coa_level/{id}', [
				'uses' => 'd_comp_coaController@coa_level',
				'as' => 'd_comp_coa.coa_level'
			]);
			Route::get('data-master/master-akun/sub_akun/{id}', [
				'uses' => 'd_comp_coaController@create_sub_akun',
				'as' => 'd_comp_coa.sub_akun'
			]);
			Route::get('data-master/master-akun/edit/{id}', [
				'uses' => 'd_comp_coaController@edit',
				'as' => 'd_comp_coa.edit'
			]);
			Route::get('data-master/master-akun/update/{id}', [
				'uses' => 'd_comp_coaController@update',
				'as' => 'd_comp_coa.update'
			]);
			Route::get('data-master/master-akun/delete/{id}', [
				'uses' => 'd_comp_coaController@delete',
				'as' => 'd_comp_coa.delete'
			]);
			//---------selesai d_comp_coa
			//d_comp_trans
			Route::get('data-master/master-transaksi-akun', [
				'uses' => 'd_comp_transController@index_view',
				'as' => 'd_comp_trans.index_view'
			]);
			Route::get('data-master/master-transaksi-akun/index_view', [
				'uses' => 'd_comp_transController@index_view',
				'as' => 'd_comp_trans.index'
			]);
			Route::get('data-master/master-transaksi-akun/data', [
				'uses' => 'd_comp_transController@index_data',
				'as' => 'd_comp_trans.index'
			]);
			Route::get('data-master/master-transaksi-akun/create', [
				'uses' => 'd_comp_transController@create',
				'as' => 'd_comp_trans.create'
			]);
			Route::get('data-master/master-transaksi-akun/store', [
				'uses' => 'd_comp_transController@store',
				'as' => 'd_comp_trans.store'
			]);
			Route::get('data-master/master-transaksi-akun/edit/{tr_code}/{tr_codesub}', [
				'uses' => 'd_comp_transController@edit',
				'as' => 'd_comp_trans.edit'
			]);
			Route::get('data-master/master-transaksi-akun/update/{id}/{tr_codesub}', [
				'uses' => 'd_comp_transController@update',
				'as' => 'd_comp_trans.update'
			]);
			Route::Delete('data-master/master-transaksi-akun/delete/{id}/{tr_code}', [
				'uses' => 'd_comp_transController@destroy',
				'as' => 'd_comp_trans.destroy'
			]);
			Route::get('data-master/master-transaksi-akun/kode/{id}', [
				'uses' => 'd_comp_transController@kode',
				'as' => 'd_comp_trans.kode'
			]);
			Route::get('data-master/master-transaksi-akun/cheknama/{nama}/{kode}', [
				'uses' => 'd_comp_transController@chekNamaTransaksi',
				'as' => 'd_comp_trans.chekNamaTransaksi'
			]);
                        Route::get('data-master/master-transaksi-akun/set-akun/{code}/{cashtype}', [
				'uses' => 'd_comp_transController@setAkun',
				'as' => 'd_comp_trans.setAkun'
			]);
			//---selesai d_comp_trans
			//entri transaksi
			Route::get('entri-transaksi/data-transaksi', [
				'uses' => 'entri_transaksiController@index',
				'as' => 'entri_transaksiController.index'
			]);
			Route::get('entri-transaksi/data-transaksi/get', [
				'uses' => 'entri_transaksiController@index_data',
				'as' => 'entri_transaksiController.index_data'
			]);

		//     Route::get('transaksi', 'keuanganController@jurnal');
		//    Route::get('transaksi/get', 'keuanganController@v_jurnal');



			Route::get('entri-transaksi/data-transaksi/create', [
				'uses' => 'entri_transaksiController@create',
				'as' => 'entri_transaksiController.create'
			]);
			Route::get('entri-transaksi/data-transaksi/store', [
				'uses' => 'entri_transaksiController@store',
				'as' => 'entri_transaksiController.store'
			]);
			Route::get('entri-transaksi/data-transaksi/edit/{id}', [
				'uses' => 'entri_transaksiController@edit',
				'as' => 'entri_transaksiController.edit'
			]);
			Route::get('entri-transaksi/data-transaksi/duplikasi/{id}', [
				'uses' => 'entri_transaksiController@duplikasi_transaksi',
				'as' => 'entri_transaksiController.duplikasi_transaksi'
			]);
			Route::get('entri-transaksi/data-transaksi/simpan-duplikasi/{id}', [
				'uses' => 'entri_transaksiController@simpanduplikasi',
				'as' => 'entri_transaksiController.edit'
			]);
			Route::get('entri-transaksi/data-transaksi/update/{id}', [
				'uses' => 'entri_transaksiController@update',
				'as' => 'entri_transaksiController.update'
			]);
			Route::DELETE('entri-transaksi/data-transaksi/destroy/{id}', [
				'uses' => 'entri_transaksiController@destroy',
				'as' => 'entri_transaksiController.destroy'
			]);
			//----------entri transaksi selesai--------
			//laporan keuangan
			//neraca
			Route::get('laporan-keuangan/neraca', [
				'uses' => 'laporan_keuanganController@neraca',
				'as' => 'laporan_keuanganController.neraca'
			]);
			Route::get('laporan-keuangan/neraca/cari', [
				'uses' => 'laporan_keuanganController@cari_neraca',
				'as' => 'laporan_keuanganController.cari_neraca'
			]);
                        Route::get('laporan-keuangan/neraca-per', [
				'uses' => 'laporan_keuanganController@neracaper',
				'as' => 'laporan_keuanganController.neracaper'
			]);
			//-------neraca selesai
			//labarugi
			Route::get('laporan-keuangan/laba-rugi', [
				'uses' => 'laporan_keuanganController@labarugi',
				'as' => 'laporan_keuanganController.labarugi'
			]);
			Route::get('laporan-keuangan/laba-rugi-per', [
				'uses' => 'laporan_keuanganController@labarugiper',
				'as' => 'laporan_keuanganController.labarugi'
			]);
			Route::get('laporan-keuangan/laba-rugi/periode', [
				'uses' => 'laporan_keuanganController@labarugiperiode',
				'as' => 'laporan_keuanganController.labarugi'
			]);
			Route::get('laporan-keuangan/laba-rugi/periode/bulan', [
				'uses' => 'laporan_keuanganController@labarugiperiodebulan',
				'as' => 'laporan_keuanganController.labarugi'
			]);
			//------labarugi selesai
			//arus khas
			Route::get('laporan-keuangan/arus-kas', [
				'uses' => 'laporan_keuanganController@aruskas',
				'as' => 'laporan_keuanganController.labarugi'
                        ]);
			Route::get('laporan-keuangan/arus-kas-per', [
				'uses' => 'laporan_keuanganController@aruskasPer',
				'as' => 'laporan_keuanganController.labarugi'
                        ]);
			Route::get('laporan-keuangan/arus-kas/periode', [
				'uses' => 'laporan_keuanganController@arus_khas_periode',
				'as' => 'laporan_keuanganController.arus_khas_periode'
                        ]);
			Route::get('laporan-keuangan/arus-kas/periode/bulan', [
				'uses' => 'laporan_keuanganController@arus_khas_periode_bulan',
				'as' => 'laporan_keuanganController.arus_khas_periode_bulan'
                        ]);
    //---------arus khas selesai
			
			/* sampai kene mas */ 
			
			
			

    });
		Route::get('send-email-validation', 'emailController@sendValidation');

	/* route setelah login selesai */