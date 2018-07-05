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
    <th>Hutang Kredit</th>

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
    <tr>
      <th>1</th>
      <th>tgl</th>
      <th>Saldo AWal :</th>
      <th>0</th>
      <th>0</th>
      <th>0</th>
      <th>0</th>
      <th>0</th>
      <th>0</th>
      <th>0</th>
      <th>0</th>
      <th >{{ $data['saldoawal'][0] }}</th>
    </tr>
  @endforeach
  @foreach ($data['isidetail'] as $is => $isi)
    @foreach ($data['isidetail'][$is] as $isdt => $is_det)
      <tr>  
      </tr>
      <td> 1</td>
      <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      <td>{{ $data['isidetail'][$is][$isdt]->tgl }}</td>
      <td>{{ $data['isidetail'][$is][$isdt]->nota }}</td>
      {{-- hutangbaru --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'hutangbaru' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      {{-- voucher --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      {{-- hutangkredit --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      {{-- byr cash --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      {{-- cek bg/tranfre --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      {{-- return beli --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      {{-- nota debet --}}
      @if ($data['isidetail'][$is][$isdt]->flag == 'VC' )
        <td>{{ $data['isidetail'][$is][$isdt]->nominal }}</td>
      @else
        <td>0</td>
      @endif
      <th ></th>
      
    @endforeach
  <tr>
      <th colspan="3">Total :</th>
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
  @endforeach
  <tr> 
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
