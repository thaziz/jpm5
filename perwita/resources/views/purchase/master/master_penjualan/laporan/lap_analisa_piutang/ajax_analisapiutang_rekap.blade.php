@if ($laporan == 'invoice')
  <table id="addColumn" class="table table-bordered table-striped tbl-item">
    <thead class="head_awal" >
       <tr>
          <th align="center"> Invoice</th>
          <th align="center"> Customer</th>
          <th align="center"> Tanggal</th>
          <th align="center"> Jatuh Tempo</th>
          <th align="center"> Saldo Awal</th>
          <th align="center"> Terbayar</th>
          <th align="center"> Sisa Saldo</th>
          <th align="center"> Umur</th>
          <th align="center"> Belum jatuh tempo </th>
          <th align="center"> Umur 0 s/d 30 </th>
          <th align="center"> Umur 31 s/d 60 </th>
          <th align="center"> Umur 61 s/d 90 </th>
          <th align="center"> Umur 91 s/d 120 </th>
          <th align="center"> Lebih dari 120 </th>
      </tr> 
    </thead>        
    <tbody>
      @foreach ($invoice as $i=>$data)
        <tr>
          <td>{{ $data->i_nomor }}</td>
          <td width="90">{{ $data->i_kode_customer }}</td>
          @if ($data->i_tanggal_tanda_terima != null)
            <td width="75">{{ $data->i_tanggal_tanda_terima }}</td>
          @else
            <td width="75">{{ $data->i_tanggal }}</td>
          @endif

          @if ($data->i_jatuh_tempo_tt != null)
            <td width="75">{{ $data->i_jatuh_tempo_tt }}</td>
          @else
            <td width="75">{{ $data->i_jatuh_tempo }}</td>
          @endif
          <td>{{ number_format($data->i_total_tagihan, 2, ",", ".") }}</td>
          <td>{{ number_format($data->i_total_tagihan-$data->i_sisa_akhir, 2, ",", ".") }}</td>
          <td>{{ number_format($data->i_sisa_akhir, 2, ",", ".") }}</td>
          <td>{{ $umur[$i] }} </td>
          <td>{{ number_format($invoice_0[$i],2,",",".") }}</td>
          <td>{{ number_format($invoice_0_30[$i],2,",",".") }}</td>
          <td>{{ number_format($invoice_31_60[$i],2,",",".") }}</td>
          <td>{{ number_format($invoice_61_90[$i],2,",",".") }}</td>
          <td>{{ number_format($invoice_91_120[$i],2,",",".") }}</td>
          <td>{{ number_format($invoice_120[$i],2,",",".") }}</td>
        </tr>
      @endforeach
      @if ($invoice == null)
        <tr>
          <td align="center" colspan="14"><h3>Tidak Ada Data</h3></td>
        </tr>
      @endif
    </tbody>  
    <tfoot>
        <tr class="bg-success">
          <td colspan="4"><b>Total :</b></td>
          <td><b>{{ number_format($total_invoice,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_terbayar,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_sisa_saldo,2,",",".") }}</b></td>
          <td><b>{{ $total_umur }}</b></td>
          <td><b>{{ number_format($total_invoice_0,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_invoice_0_30,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_invoice_31_60,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_invoice_61_90,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_invoice_91_120,2,",",".") }}</b></td>
          <td><b>{{ number_format($total_invoice_120,2,",",".") }}</b></td>
        </tr>
    </tfoot>
  </table>
@elseif($laporan == 'hirarki')
  <table class="table table-bordered" width="100%">
    <tr class="head">
      <th align="center"> Cabang</th>
      <th align="center"> Total Saldo Awal</th>
      <th align="center"> Total Terbayar</th>
      <th align="center"> Total Sisa Saldo</th>
      <th align="center"> Total Umur</th>
      <th align="center"> Total Belum jatuh tempo </th>
      <th align="center"> Total Umur 0 s/d 30 </th>
      <th align="center"> Total Umur 31 s/d 60 </th>
      <th align="center"> Total Umur 61 s/d 90 </th>
      <th align="center"> Total Umur 91 s/d 120 </th>
      <th align="center"> Total Lebih dari 120 </th> 
    </tr>
    @php
      $hasil1_2   = [];
      $hasil2_2   = [];
      $hasil3_2   = [];
      $hasil4_2   = [];
      $hasil5_2   = [];
      $hasil6_2   = [];
      $hasil7_2   = [];
      $hasil8_2   = [];
      $hasil9_2   = [];
      $hasil10_2  = [];
    @endphp
    @foreach ($cab as $i=>$val)
    <tr class="trigger_cabang trigger_cabang_{{ $i }}" onclick="hilang_cabang(this)">
      <td>
        {{ $cab_nama[$i] }}
        <input type="hidden" class="value_cabang" value="{{ $i }}">
      </td>
      <td>
        @php
          $temp1 = 0;
          for ($z=0; $z < count($total_invoice[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice[$i][$z]); $z1++) { 
              $hasil = $total_invoice[$i][$z][$z1];
              $temp1 += $hasil;
            }
          }
          array_push($hasil1_2, $temp1);
          echo number_format($temp1 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp2 = 0;
          for ($z=0; $z < count($total_terbayar[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_terbayar[$i][$z]); $z1++) { 
              $hasil = $total_terbayar[$i][$z][$z1];
              $temp2 += $hasil;
            }
          }
          array_push($hasil2_2, $temp2);
          echo number_format($temp2 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp3 = 0;
          for ($z=0; $z < count($total_sisa_saldo[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_sisa_saldo[$i][$z]); $z1++) { 
              $hasil = $total_sisa_saldo[$i][$z][$z1];
              $temp3 += $hasil;
            }
          }
          array_push($hasil3_2, $temp3);
          echo number_format($temp3 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp4 = 0;
          for ($z=0; $z < count($total_umur[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_umur[$i][$z]); $z1++) { 
              $hasil = $total_umur[$i][$z][$z1];
              $temp4 += $hasil;
            }
          }
          array_push($hasil4_2, $temp4);
          echo $temp4;
        @endphp
      </td>
      <td>
        @php
          $temp5 = 0;
          for ($z=0; $z < count($total_invoice_0[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice_0[$i][$z]); $z1++) { 
              $hasil = $total_invoice_0[$i][$z][$z1];
              $temp5 += $hasil;
            }
          }
          array_push($hasil5_2, $temp5);
          echo number_format($temp5 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp6 = 0;
          for ($z=0; $z < count($total_invoice_0_30[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice_0_30[$i][$z]); $z1++) { 
              $hasil = $total_invoice_0_30[$i][$z][$z1];
              $temp6 += $hasil;
            }
          }
          array_push($hasil6_2, $temp6);
          echo number_format($temp6 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp7 = 0;
          for ($z=0; $z < count($total_invoice_31_60[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice_31_60[$i][$z]); $z1++) { 
              $hasil = $total_invoice_31_60[$i][$z][$z1];
              $temp7 += $hasil;
            }
          }
          array_push($hasil7_2, $temp7);
          echo number_format($temp7 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp8 = 0;
          for ($z=0; $z < count($total_invoice_61_90[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice_61_90[$i][$z]); $z1++) { 
              $hasil = $total_invoice_61_90[$i][$z][$z1];
              $temp8 += $hasil;
            }
          }
          array_push($hasil8_2, $temp8);
          echo number_format($temp8 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp9 = 0;
          for ($z=0; $z < count($total_invoice_91_120[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice_91_120[$i][$z]); $z1++) { 
              $hasil = $total_invoice_91_120[$i][$z][$z1];
              $temp9 += $hasil;
            }
          }
          array_push($hasil9_2, $temp9);
          echo number_format($temp9 , 2, ",", ".");
        @endphp
      </td>
      <td>
        @php
          $temp10 = 0;
          for ($z=0; $z < count($total_invoice_120[$i]); $z++) { 
            for ($z1=0; $z1 < count($total_invoice_120[$i][$z]); $z1++) { 
              $hasil = $total_invoice_120[$i][$z][$z1];
              $temp10 += $hasil;
            }
          }
          array_push($hasil10_2, $temp10);
          echo number_format($temp10 , 2, ",", ".");
        @endphp
      </td>
    </tr>
    @if (isset($akun[$i]))
      <tr class="cabang cabang_{{ $i }}">
        <td colspan="11">
          <table class="table table-bordered ">
            <tr class="head">
              <th align="center"> Akun</th>
              <th align="center"> Total Saldo Awal</th>
              <th align="center"> Total Terbayar</th>
              <th align="center"> Total Sisa Saldo</th>
              <th align="center"> Total Umur</th>
              <th align="center"> Total Belum jatuh tempo </th>
              <th align="center"> Total Umur 0 s/d 30 </th>
              <th align="center"> Total Umur 31 s/d 60 </th>
              <th align="center"> Total Umur 61 s/d 90 </th>
              <th align="center"> Total Umur 91 s/d 120 </th>
              <th align="center"> Total Lebih dari 120 </th> 
            </tr>
            @php
              $hasil1_1   = [];
              $hasil2_1   = [];
              $hasil3_1   = [];
              $hasil4_1   = [];
              $hasil5_1   = [];
              $hasil6_1   = [];
              $hasil7_1   = [];
              $hasil8_1   = [];
              $hasil9_1   = [];
              $hasil10_1  = [];
            @endphp
            @foreach ($akun[$i] as $i1=>$val)
            <tr class="trigger_akun trigger_akun_{{ $i1 }}" onclick="hilang_akun(this)">
              <td>
                {{ $akun_nama[$i][$i1] }}
                <input type="hidden" class="value_akun" value="{{ $i1 }}">
              </td>
              <td>
                @php
                  $temp1 = 0;
                  for ($z=0; $z < count($total_invoice[$i][$i1]); $z++) { 
                    $hasil = $total_invoice[$i][$i1][$z];
                    $temp1 += $hasil;
                  }
                  array_push($hasil1_1, $temp1);
                  echo number_format($temp1 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp2 = 0;
                  for ($z=0; $z < count($total_terbayar[$i][$i1]); $z++) { 
                    $hasil = $total_terbayar[$i][$i1][$z];
                    $temp2 += $hasil;
                  }
                  array_push($hasil2_1, $temp2);
                  echo number_format($temp2 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp3 = 0;
                  for ($z=0; $z < count($total_sisa_saldo[$i][$i1]); $z++) { 
                    $hasil = $total_sisa_saldo[$i][$i1][$z];
                    $temp3 += $hasil;
                  }
                  array_push($hasil3_1, $temp3);
                  echo number_format($temp3 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp4 = 0;
                  for ($z=0; $z < count($total_umur[$i][$i1]); $z++) { 
                    $hasil = $total_umur[$i][$i1][$z];
                    $temp4 += $hasil;
                  }
                  array_push($hasil4_1, $temp4);
                  echo $temp4;
                @endphp
              </td>
              <td>
                @php
                  $temp5 = 0;
                  for ($z=0; $z < count($total_invoice_0[$i][$i1]); $z++) { 
                    $hasil = $total_invoice_0[$i][$i1][$z];
                    $temp5 += $hasil;
                  }
                  array_push($hasil5_1, $temp5);
                  echo number_format($temp5 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp6 = 0;
                  for ($z=0; $z < count($total_invoice_0_30[$i][$i1]); $z++) { 
                    $hasil = $total_invoice_0_30[$i][$i1][$z];
                    $temp6 += $hasil;
                  }
                  array_push($hasil6_1, $temp6);
                  echo number_format($temp6 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp7 = 0;
                  for ($z=0; $z < count($total_invoice_31_60[$i][$i1]); $z++) { 
                    $hasil = $total_invoice_31_60[$i][$i1][$z];
                    $temp7 += $hasil;
                  }
                  array_push($hasil7_1, $temp7);
                  echo number_format($temp7 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp8 = 0;
                  for ($z=0; $z < count($total_invoice_61_90[$i][$i1]); $z++) { 
                    $hasil = $total_invoice_61_90[$i][$i1][$z];
                    $temp8 += $hasil;
                  }
                  array_push($hasil8_1, $temp8);
                  echo number_format($temp8 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp9 = 0;
                  for ($z=0; $z < count($total_invoice_91_120[$i][$i1]); $z++) { 
                    $hasil = $total_invoice_91_120[$i][$i1][$z];
                    $temp9 += $hasil;
                  }
                  array_push($hasil9_1, $temp9);
                  echo number_format($temp9 , 2, ",", ".");
                @endphp
              </td>
              <td>
                @php
                  $temp10 = 0;
                  for ($z=0; $z < count($total_invoice_120[$i][$i1]); $z++) { 
                    $hasil = $total_invoice_120[$i][$i1][$z];
                    $temp10 += $hasil;
                  }
                  array_push($hasil10_1, $temp10);
                  echo number_format($temp10 , 2, ",", ".");
                @endphp
              </td>
            </tr>
            @if (isset($customer[$i][$i1]))
            <tr class="akun akun_{{ $i1 }}">
              <td colspan="11">
                <table class="table table-bordered ">
                  <tr class="head">
                    <th align="center"> Customer</th>
                    <th align="center"> Total Saldo Awal</th>
                    <th align="center"> Total Terbayar</th>
                    <th align="center"> Total Sisa Saldo</th>
                    <th align="center"> Total Umur</th>
                    <th align="center"> Total Belum jatuh tempo </th>
                    <th align="center"> Total Umur 0 s/d 30 </th>
                    <th align="center"> Total Umur 31 s/d 60 </th>
                    <th align="center"> Total Umur 61 s/d 90 </th>
                    <th align="center"> Total Umur 91 s/d 120 </th>
                    <th align="center"> Total Lebih dari 120 </th> 
                  </tr>
                  @php
                    $hasil1   = [];
                    $hasil2   = [];
                    $hasil3   = [];
                    $hasil4   = [];
                    $hasil5   = [];
                    $hasil6   = [];
                    $hasil7   = [];
                    $hasil8   = [];
                    $hasil9   = [];
                    $hasil10  = [];
                  @endphp
                  @foreach ($customer[$i][$i1] as $i2=>$val)
                  <tr class="trigger_customer trigger_customer_{{ $i2 }}" onclick="hilang_customer(this)">
                    <td>
                      {{ $customer_nama[$i][$i1][$i2] }}
                      <input type="hidden" class="value_customer" value="{{ $i2 }}">
                    </td>
                    <td>
                      @php
                        $temp1 = 0;
                        $hasil = $total_invoice[$i][$i1][$i2];
                        $temp1 += $hasil;
                        array_push($hasil1, $temp1);
                        echo number_format($temp1 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp2 = 0;
                        $hasil = $total_terbayar[$i][$i1][$i2];
                        $temp2 += $hasil;
                        array_push($hasil2, $temp2);
                        echo number_format($temp2 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp3 = 0;
                        $hasil = $total_sisa_saldo[$i][$i1][$i2];
                        $temp3 += $hasil;
                        array_push($hasil3, $temp3);
                        echo number_format($temp3 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp4 = 0;
                        $hasil = $total_umur[$i][$i1][$i2];
                        $temp4 += $hasil;
                        array_push($hasil4, $temp4);
                        echo $temp4;
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp5 = 0;
                        $hasil = $total_invoice_0[$i][$i1][$i2];
                        $temp5 += $hasil;
                        array_push($hasil5, $temp5);
                        echo number_format($temp5 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp6 = 0;
                        $hasil = $total_invoice_0_30[$i][$i1][$i2];
                        $temp6 += $hasil;
                        array_push($hasil6, $temp6);
                        echo number_format($temp6 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp7 = 0;
                        $hasil = $total_invoice_31_60[$i][$i1][$i2];
                        $temp7 += $hasil;
                        array_push($hasil7, $temp7);
                        echo number_format($temp7 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp8 = 0;
                        $hasil = $total_invoice_61_90[$i][$i1][$i2];
                        $temp8 += $hasil;
                        array_push($hasil8, $temp8);
                        echo number_format($temp8 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp9 = 0;
                        $hasil = $total_invoice_91_120[$i][$i1][$i2];
                        $temp9 += $hasil;
                        array_push($hasil9, $temp9);
                        echo number_format($temp9 , 2, ",", ".");
                      @endphp
                    </td>
                    <td>
                      @php
                        $temp10 = 0;
                        $hasil = $total_invoice_120[$i][$i1][$i2];
                        $temp10 += $hasil;
                        array_push($hasil10, $temp10);
                        echo number_format($temp10 , 2, ",", ".");
                      @endphp
                    </td>
                  </tr>
                  <tr class="customer customer_{{ $i2 }}">
                    <td colspan="11">
                      <table class="table table-bordered">
                        <tr class="head">
                          <th align="center"> Invoice</th>
                          <th align="center"> Tanggal</th>
                          <th align="center"> Jatuh Tempo</th>
                          <th align="center"> Saldo Awal</th>
                          <th align="center"> Terbayar</th>
                          <th align="center"> Sisa Saldo</th>
                          <th align="center"> Umur</th>
                          <th align="center"> Belum jatuh tempo </th>
                          <th align="center"> Umur 0 s/d 30 </th>
                          <th align="center"> Umur 31 s/d 60 </th>
                          <th align="center"> Umur 61 s/d 90 </th>
                          <th align="center"> Umur 91 s/d 120 </th>
                          <th align="center"> Lebih dari 120 </th>
                        </tr>
                        @foreach ($invoice[$i][$i1][$i2] as $i3=>$val)
                        <tr class="">
                          <td>{{ $invoice[$i][$i1][$i2][$i3]->i_nomor }}</td>
                          @if ($invoice[$i][$i1][$i2][$i3]->i_tanggal_tanda_terima != null)
                            <td width="75">{{ $invoice[$i][$i1][$i2][$i3]->i_tanggal_tanda_terima }}</td>
                          @else
                            <td width="75">{{ $invoice[$i][$i1][$i2][$i3]->i_tanggal }}</td>
                          @endif
                          @if ($invoice[$i][$i1][$i2][$i3]->i_jatuh_tempo_tt != null)
                            <td width="75">{{ $invoice[$i][$i1][$i2][$i3]->i_jatuh_tempo_tt }}</td>
                          @else
                            <td width="75">{{ $invoice[$i][$i1][$i2][$i3]->i_jatuh_tempo }}</td>
                          @endif
                          <td>{{ number_format($invoice[$i][$i1][$i2][$i3]->i_total_tagihan, 2, ",", ".") }}</td>
                          <td>
                            {{ number_format($invoice[$i][$i1][$i2][$i3]->i_total_tagihan - 
                               $invoice[$i][$i1][$i2][$i3]->i_sisa_akhir, 2, ",", ".") }}
                          </td>
                          <td>{{ number_format($invoice[$i][$i1][$i2][$i3]->i_sisa_akhir, 2, ",", ".") }}</td>
                          <td>{{ $umur[$i][$i1][$i2][$i3][0] }}</td>
                          <td>{{ number_format($invoice_0[$i][$i1][$i2][$i3][0], 2, ",", ".")}}</td>
                          <td>{{ number_format($invoice_0_30[$i][$i1][$i2][$i3][0] , 2, ",", ".")}}</td>
                          <td>{{ number_format($invoice_31_60[$i][$i1][$i2][$i3][0] , 2, ",", ".")}}</td>
                          <td>{{ number_format($invoice_61_90[$i][$i1][$i2][$i3][0]  , 2, ",", ".")}}</td>
                          <td>{{ number_format($invoice_91_120[$i][$i1][$i2][$i3][0] , 2, ",", ".")}}</td>
                          <td>{{ number_format($invoice_120[$i][$i1][$i2][$i3][0] , 2, ",", ".")}}</td> 
                        </tr>
                        @endforeach
                        <tfoot>
                          <tr  class="bg-info" style="color: white" >
                            <td colspan="3" align="right">Total :</td>
                            <td>{{ number_format($total_invoice[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_terbayar[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_sisa_saldo[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ $total_umur[$i][$i1][$i2]}}</td>
                            <td>{{ number_format($total_invoice_0[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_invoice_0_30[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_invoice_31_60[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_invoice_61_90[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_invoice_91_120[$i][$i1][$i2] , 2, ",", ".") }}</td>
                            <td>{{ number_format($total_invoice_120[$i][$i1][$i2] , 2, ",", ".") }}</td>
                          </tr>
                        </tfoot>
                      </table>
                    </td>
                  </tr>
                  @endforeach
                  <tfoot>
                    <tr  class="bg-primary" style="color: white" >
                      <td colspan="1" align="right">Total :</td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil1),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil2),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil3),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo array_sum($hasil4);
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil5),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil6),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil7),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil8),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil9),2,",",'.');
                        @endphp
                      </td>
                      <td>
                        @php
                          echo number_format(array_sum($hasil10),2,",",'.');
                        @endphp
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </td>
            </tr>
            @endif
            @endforeach
            <tfoot>
              <tr  class="bg-success" style="color: white" >
                <td colspan="1" align="right">Total :</td>
                <td>
                  @php
                    echo number_format(array_sum($hasil1_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil2_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil3_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo array_sum($hasil4_1);
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil5_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil6_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil7_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil8_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil9_1),2,",",'.');
                  @endphp
                </td>
                <td>
                  @php
                    echo number_format(array_sum($hasil10_1),2,",",'.');
                  @endphp
                </td>
              </tr>
            </tfoot>
          </table>
        </td>
      </tr>
    @endif
    @endforeach
    @if ($cab == null)
      <tr>
        <td align="center" colspan="14"><h3>Tidak Ada Data</h3></td>
      </tr>
    @endif
    <tfoot>
      <tr  class="bg-success" style="color: white" >
        <td colspan="1" align="right">Total :</td>
        <td>
          @php
            echo number_format(array_sum($hasil1_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil2_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil3_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo array_sum($hasil4_2);
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil5_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil6_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil7_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil8_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil9_2),2,",",'.');
          @endphp
        </td>
        <td>
          @php
            echo number_format(array_sum($hasil10_2),2,",",'.');
          @endphp
        </td>
      </tr>
    </tfoot>
  </table>
@endif
  


<script type="text/javascript">
  $(document).ready(function(){

  })
</script>