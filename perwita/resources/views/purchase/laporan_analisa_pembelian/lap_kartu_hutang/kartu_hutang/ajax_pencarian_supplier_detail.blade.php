{{-- @include('partials._scripts') --}}

<table class="table table-bordered table-striped">
  <tr>
    <th rowspan="2">No.</th>
    <th rowspan="2">Tanggal</th>
    <th rowspan="2">No Bukti</th>
    <th rowspan="2">Keterangan</th>
    <th colspan="3">KREDIT</th>
    <th colspan="4">DEBET</th>
    <th rowspan="2">SALDO</th>
  </tr>
  
  <tr>
    <th>Hutang Baru</th>
    <th>Hutang Voucher</th>
    <th>Nota Kredit</th>

    <th>Bayar cash</th>
    <th>Cek BG/Transfer</th>
    <th>Retur Beli</th>
    <th>Nota Debet</th>
  </tr>
  @foreach ($data['carisupp'] as $i => $sup)
    <tr>
      <th colspan="12">Supplier :  [{{ $data['carisupp'][0][$i]->no_supplier }}] {{ $data['carisupp'][0][$i]->nama_supplier }}</th>
    </tr>
  @endforeach
  @foreach ($data['saldoawal'] as $s => $saldo)
    <tr align="right">
      <th align="right">1</th>
      <th align="right">-</th>
      <th align="right">Saldo Awal :</th>
      <th align="right">-</th>
      <th align="right">0</th>
      <th align="right">0</th>
      <th align="right">0</th>
      <th align="right">0</th>
      <th align="right">0</th>
      <th align="right">0</th>
      <th align="right">0</th>
      <th align="right" ><input type="hidden" value="{{ $data['saldoawal'][$s] }}" name="" class="saldo saldo_{{ $s }}">
      {{ $data['saldoawal'][0] }}</th>
    </tr>
  @endforeach
  @foreach ($data['isidetail'] as $is => $isi)
    @foreach ($data['isidetail'][$is] as $isdt => $is_det)
      <tr align="right">  
        <td> {{ $is+1 }}</td>
        <td>{{ $data['isidetail'][$is][$isdt]->tgl }}</td>
        <td>{{ $data['isidetail'][$is][$isdt]->nota }}</td>
        <td>{{ $data['isidetail'][$is][$isdt]->keterangan }}</td>
        {{-- hutangbaru --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'hutangbaru' )
          <td><input type="hidden" class="hutangbaru hutangbaru_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="hutangbaru hutangbaru_{{ $is }}" value="0">
          0</td>
        @endif
        {{-- voucher --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
          <td><input type="hidden" class="vc vc_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="vc vc_{{ $is }}" value="0">
          0</td>
        @endif
        {{-- NOTA KREDIT --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'CN' )
          <td><input type="hidden" class="cn cn_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="cn cn_{{ $is }}" value="0">
          0</td>
        @endif
        {{-- byr cash --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'K' )
          <td><input type="hidden" class="k k_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="k k_{{ $is }}" value="0">
          0</td>
        @endif
        {{-- cek bg/tranfre --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'BG' )
          <td><input type="hidden" class="bg bg_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="bg bg_{{ $is }}" value="0">
          0</td>
        @endif
        {{-- return beli --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'RN' )
          <td><input type="hidden" class="rn rn_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="rn rn_{{ $is }}" value="0">
          0</td>
        @endif
        {{-- nota debet --}}
        @if ($data['isidetail'][$is][$isdt]->flag == 'DN' )
          <td><input type="hidden" class="dn dn_{{ $is }}" value="{{  $data['isidetail'][$is][$isdt]->nominal }}">
            {{ $data['isidetail'][$is][$isdt]->nominal }}</td>
        @else
          <td><input type="hidden" class="dn dn_{{ $is }}" value="0">
          0</td>
        @endif
        
        <th class="total"></th>
      </tr>
      
    @endforeach
  <tr>
      <th  align="right" colspan="3">Total :</th>
      <th  align="right" ></th>
      <th  align="right" class="hut_baru hut_baru_{{ $is }}"></th>
      <th  align="right" class="hut_voc hut_voc_{{ $is }}"></th>
      <th  align="right" class="not_kredit not_kredit_{{ $is }}"></th>
      <th  align="right" class="b_cash b_cash_{{ $is }}"></th>
      <th  align="right" class="cek_bg cek_bg_{{ $is }}"></th>
      <th  align="right" class="return_beli return_beli_{{ $is }}"></th>
      <th  align="right" class="no_debet no_debet_{{ $is }}"></th>
      <th  align="right" class="grand grand_{{ $is }}"></th>
  </tr>
  @endforeach
  <tr align="right"> 
    <th colspan="3">Grand Total :</th>
    <th ></th> 
    <th ></th> 
    <th ></th> 
    <th ></th> 
    <th ></th> 
    <th ></th> 
    <th ></th> 
    <th ></th> 
    <th ></th> 
  </tr>

</table>
