 $cari_invoice = DB::table('invoice')
                                    ->where('i_nomor',$request->i_nomor[$i])
                                    ->first();
          // dd($cari_invoice);

                  if ($request->akun_biaya[$i] == '') {
                      $i_biaya_admin[$i] = 0;
                  }else{
                      $i_biaya_admin[$i] = $request->i_biaya_admin[$i];
                  }

                  $cd = DB::table('cn_dn_penjualan')
                          ->join('cn_dn_penjualan_d','cdd_id','=','cd_id')
                          ->where('cdd_nomor_invoice',$request->i_nomor[$i])
                          ->get();
                  // dd($cd);
                  if ($cd != null) {
                    $cd_kredit = [];
                    $cd_debit = [];
                    $cd_net = [];
                    for ($e=0; $e < count($cd); $e++) { 
                      if ($cd[$e]->cd_jenis == 'K') {
                        array_push($cd_kredit, $cd[$e]->cdd_netto_akhir);
                        array_push($cd_debit, 0);
                        array_push($cd_net,$cd[$e]->cdd_netto_akhir);
                      }else{
                        array_push($cd_debit, $cd[$e]->cdd_netto_akhir);
                        array_push($cd_kredit, 0);
                        array_push($cd_net,$cd[$e]->cdd_netto_akhir);
                      }
                    }

                    $cd_kredit = array_sum($cd_kredit);
                    $cd_debit = array_sum($cd_debit);
                    $bayar    = (float)$request->i_bayar[$i]+$cd_kredit;
                    $sisa_bayar =(float)$cari_invoice->i_sisa_pelunasan+$cd_debit;
                    $memorial =  $sisa_bayar - $bayar;
                  }else{
                    $memorial = (float)$cari_invoice->i_sisa_pelunasan - (float)$request->i_bayar[$i];
                  }
                  dd($cari_invoice->i_sisa_pelunasan);
                  
                  if ($memorial > 0) {
                     $memorial = 0;
                  }else if ($memorial<0) {
                      $memorial = $memorial * -1;
                  }
                  
                  array_push($memorial_array, $memorial);
                  $acc = DB::table('customer')
                           ->where('kode',$request->customer)
                           ->first();
                  $save_detail = DB::table('kwitansi_d')
                                   ->insert([
                                        'kd_id'             => $k_id,
                                        'kd_dt'             => $i+1,
                                        'kd_k_nomor'        => $request->nota,
                                        'kd_tanggal_invoice'=> $cari_invoice->i_tanggal,
                                        'kd_nomor_invoice'  => $request->i_nomor[$i],
                                        'kd_keterangan'     => $request->i_keterangan[$i],
                                        'kd_kode_biaya'     => $request->akun_biaya[$i],
                                        'kd_total_bayar'    => $request->i_tot_bayar[$i] ,
                                        'kd_biaya_lain'     => $i_biaya_admin[$i],
                                        'kd_memorial'       => $memorial,
                                        'kd_kode_akun_acc'  => $acc->acc_piutang,
                                        'kd_kode_akun_csf'  => $acc->csf_piutang,
                                        'kd_debet'          => $request->i_debet[$i],
                                        'kd_kredit'         => $request->i_kredit[$i],
                                   ]);

                  $cari_invoice = DB::table('invoice')
                                    ->where('i_nomor',$request->i_nomor[$i])
                                    ->first();
                  

                  $sisa_akhir =  $cari_invoice->i_sisa_akhir - $request->i_tot_bayar[$i];
                  if ($sisa_akhir < 0) {
                    $sisa_akhir1 = $sisa_akhir * -1;

                    $pengurang  =  $request->i_tot_bayar[$i] - $sisa_akhir1;

                    $hasil =  $cari_invoice->i_sisa_pelunasan - $pengurang;
                    $sisa_akhir = 0;
                  }else{
                    $hasil =  $cari_invoice->i_sisa_pelunasan - $request->i_tot_bayar[$i];
                  }
                  

                  if ($hasil < 0) {
                      $hasil = 0;
                  }
                  
                  $update_invoice = DB::table('invoice')
                                      ->where('i_nomor',$request->i_nomor[$i])
                                      ->update([
                                          'i_sisa_pelunasan' => $hasil,
                                          'i_sisa_akhir'     => $sisa_akhir,
                                          'i_status'         => 'Approved',
                                      ]);



                                                    if ($request->akun_biaya[$i] == 'U2') {
                  $akun_biaya = DB::table('akun_biaya')
                                  ->where('kode','U2')
                                  ->first();
                  $bulan = Carbon::now()->format('m');
                  $tahun = Carbon::now()->format('y');

                  $cari_nota = DB::select("SELECT  substring(max(nomor),11) as id from uang_muka_penjualan
                                                  WHERE kode_cabang = '$request->cb_cabang'
                                                  AND to_char(tanggal,'MM') = '$bulan'
                                                  AND to_char(tanggal,'YY') = '$tahun'");
                  $index = (integer)$cari_nota[0]->id + 1;
                  $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                  $nota = 'UMP' . $request->cb_cabang . $bulan . $tahun . $index;

                  $insert_um = DB::table('uang_muka_penjualan')
                                 ->insert([
                                    'nomor' => $nota,
                                    'tanggal' => $tgl,
                                    'kode_customer' => $request->customer,
                                    'kode_cabang' => $request->cb_cabang,
                                    'jumlah' => $request->i_kredit[$i],
                                    'jenis' => 'U',
                                    'status' => 'Released',
                                    'status_um' => 'CUSTOMER',
                                    'sisa_uang_muka' => $request->i_kredit[$i],
                                    'keterangan' => '',
                                    'kode_acc' => $akun_biaya->acc_biaya,
                                    'kode_csf' => $akun_biaya->csf_biaya,
                                    'ref' => $request->nota,
                                 ]);
              }