@extends('main')

@section('title', 'dashboard')

@section('content')

<?php 
function rupiah($angka){
    $hasil_rupiah = "Rp" . number_format($angka,2,',','.');
    return $hasil_rupiah;
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Laporan Historis Faktur Vs Pelunasan</h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Purchase</a>
            </li>
            <li>
              <a> Laporan Purchase </a>
          </li>
          <li class="active">
            <strong> Historis Faktur Vs Pelunasan </strong>
        </li>

    </ol>
</div>
<div class="col-lg-2">

</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box" id="seragam_box">
                                <div class="box-header">
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                    <div class="col-xs-6">
                                        <table border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 100%;">
                                                        <input type="text" class="form-control" list="list_faktur" name="no_faktur" id="no_faktur" placeholder="Masukkan No Faktur Disini...." autocomplete="off" autofocus="" onchange="showFaktur()">
                                                        <datalist id="list_faktur">
                                                        @foreach($dataFaktur as $faktur)
                                                        <option value="{{ $faktur->fp_nofaktur }}">{{ $faktur->fp_nofaktur }}</option>
                                                        @endforeach
                                                    </datalist>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" style="margin-top: 5px;" onclick="showFaktur()">
                                                            <i class="fa fa-search" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-xs-12">
                                        
                                        
                                        <!-- <table border="0">
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#NoFaktur">
                                                     <i class="fa fa-search" aria-hidden="true"></i>  Cari No Faktur
                                                    </button>
                                                </td>

                                             <td> &nbsp; &nbsp; </td>

                                                 <td colspan="5">
                                                    <input type="text" class="form-control" list="list_faktur" name="no_faktur" id="no_faktur" placeholder="Masukkan No Faktur Disini...." autocomplete="off" autofocus="" onchange="showFaktur()">
                                                    <datalist id="list_faktur">
                                                        @foreach($dataFaktur as $faktur)
                                                        <option value="{{ $faktur->fp_nofaktur }}">{{ $faktur->fp_nofaktur }}</option>
                                                        @endforeach
                                                    </datalist>
                                                </td>
                                            </tr>
                                        </table> -->

                                    <hr>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <h4> Master Faktur Pembelian </h4>
                                            <table class="table table-bordered">
                                                @if($dataFakturPembelian != '')
                                                <tr>
                                                    <th> No Faktur </th>
                                                    <td colspan="3" id="number_faktur"> {{ $dataFakturPembelian->fp_nofaktur }} </td>
                                                </tr>
                                                <tr>
                                                    <th> Tanggal </th>
                                                    <td id="tgl_fp"> {{ $dataFakturPembelian->fp_tgl }} </td>
                                                    <th> Jatuh Tempo </th>
                                                    <td id="jatuh_tempo"> {{ $dataFakturPembelian->fp_jatuhtempo }} </td>
                                                </tr>
                                                <tr>
                                                    <th> Supplier </th>
                                                    <td id="no_supplier"> {{ $dataFakturPembelian->fp_supplier }}</td>
                                                    <td colspan="2" id="nama_supplier"> {{ $dataFakturPembelian->nama_supplier }} </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" id="alamat_supplier"> {{ $dataFakturPembelian->alamat_supplier }}   </td>
                                                </tr>
                                                <tr>
                                                    <th> Keterangan </th>
                                                    <td colspan="3" id="fp_keterangan"> {{ $dataFakturPembelian->fp_keterangan }} </td>
                                                </tr>
                                                <tr>
                                                    <th> No Pajak </th>
                                                    <td id="no_pajak"> {{ $dataFakturPembelian->fpm_nota }} </td>
                                                    <th> Tanggal </th>
                                                    <td id="tgl_pajak"> {{ $dataFakturPembelian->fpm_tgl }} </td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <th> No Faktur </th>
                                                    <td colspan="3">  </td>
                                                </tr>
                                                <tr>
                                                    <th> Tanggal </th>
                                                    <td>  </td>
                                                    <th> Jatuh Tempo </th>
                                                    <td>  </td>
                                                </tr>
                                                <tr>
                                                    <th> Supplier </th>
                                                    <td>  </td>
                                                    <td colspan="2">  </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">  </td>
                                                </tr>
                                                <tr>
                                                    <th> Keterangan </th>
                                                    <td colspan="3">  </td>
                                                </tr>
                                                <tr>
                                                    <th> No Pajak </th>
                                                    <td>  </td>
                                                    <th> Tanggal </th>
                                                    <td>  </td>
                                                </tr>
                                                @endif
                                            </table>
                                            @if($dataSearchFaktur != '')
                                            <table class="table table-bordered table-stripped">

                                                <tr>
                                                    <th> Kode Item </th>
                                                    <th> Update Stock </th>
                                                    <th> Quantity </th>
                                                </tr>
                                                
                                                @foreach($dataSearchFaktur as $key => $s_faktur2)
                                                <tr>
                                                    <td> {{ $s_faktur2->fpdt_kodeitem }} </td>
                                                    <td> {{ $s_faktur2->fpdt_updatedstock }} </td>
                                                    <td> {{ $s_faktur2->fpdt_qty }} </td>
                                                </tr>
                                                @endforeach
                                                
                                            </table>
                                            @endif
                                            <table class="table table-bordered table-stripped">
                                                @if($dataFakturPembelian != '')
                                                <tr>
                                                    <th> Jumlah </th> <td colspan="2" style="text-align: right;"> {{ rupiah($dataFakturPembelian->fp_jumlah) }} </td>
                                                </tr>

                                                <tr>
                                                    <th> Discount </th> <td colspan="2" style="text-align: right;"> @if($dataFakturPembelian->fp_discount == null) 0 @else {{ $dataFakturPembelian->fp_discount }} @endif</td>
                                                </tr>

                                                <tr>
                                                    <th> Jenis PPn </th>
                                                    <td colspan="2"> @if($dataFakturPembelian->fp_jenisppn == "T") Tanpa PPN @elseif($dataFakturPembelian->fp_jenisppn == "I") Include @elseif($dataFakturPembelian->fp_jenisppn == "E") Exclude @endif </td>
                                                </tr>

                                                <tr>
                                                    <th> DPP </th>
                                                    <td colspan="2" style="text-align: right;"> {{ rupiah($dataFakturPembelian->fp_dpp) }} </td>
                                                </tr>

                                                <tr>
                                                    <th> PPN </th>
                                                    <td colspan="2" style="text-align: right;"> @if($dataFakturPembelian->fp_ppn == null) 0 @else {{ $dataFakturPembelian->fp_ppn }} @endif </td>
                                                </tr>

                                                <tr>
                                                    <th> Pajak Lain </th> 
                                                    <td>  {{ $dataFakturPembelian->nama_pph }} </td>
                                                    <td style="text-align: right;"> {{ $dataFakturPembelian->fp_nilaipph }} </td>
                                                </tr>

                                                <tr>
                                                    <th> Nilai Pajak Lain </th> <td colspan="2" style="text-align: right;"> {{ rupiah($dataFakturPembelian->fp_pph) }} </td>
                                                </tr>

                                                <tr>
                                                    <th> Netto </th> 
                                                    <td colspan="2" style="text-align: right"> {{ rupiah($dataFakturPembelian->fp_netto) }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>

                                        <div class="col-xs-6 table-responsive">
                                            <h4> Historis Pembayaran </h4>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th> No Bukti </th>
                                                    <th> Tanggal </th>
                                                    <th> Keterangan </th>
                                                    <th> Debet </th>
                                                    <th> Kredit </th>
                                                </tr>
                                                @if($dataHistoriesResult != '')
                                                @foreach($dataHistoriesResult as $histories)
                                                <tr>
                                                    <td> {{ $histories[0] }} </td>
                                                    <td> {{ $histories[1] }} </td>
                                                    <td> {{ $histories[2] }} </td>
                                                    <td style="text-align: right"> @if(substr($histories[0],0,2) == "FB") {{rupiah($histories[3])}} @endif </td>
                                                    <td style="text-align: right"> @if(substr($histories[0],0,2) != "FB") {{rupiah($histories[3])}} @endif </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td>  </td>
                                                    <td>  </td>
                                                    <td>  </td>
                                                    <td>  </td>
                                                    <td>  </td>
                                                 </tr>
                                                @endif
                                            </table>

                                            <h4> Cek / BG Belum Cair </h4>

                                            <table class="table table-bordered">
                                                <tr>
                                                  <th> No Bukti </th>
                                                  <th> Tanggal </th>
                                                  <th> Keterangan </th>
                                                  <th> Jumlah </th>
                                                  <th> Cek BG </th>
                                              </tr>
                                              @if($dataBG != '')
                                              @foreach($dataBG as $bg)
                                              <tr>
                                                  <td> {{ $bg->fpg_nofpg }} </td>
                                                  <td> {{ $bg->fpg_tgl }} </td>
                                                  <td> {{ $bg->fpg_keterangan }} </td>
                                                  <td> {{ rupiah($bg->fpgdt_jumlahtotal) }} </td>
                                                  <td> {{ $bg->fpgb_nocheckbg }} </td>
                                              </tr>
                                              @endforeach
                                              @else
                                              <tr>
                                                  <td>  </td>
                                                  <td>  </td>
                                                  <td>  </td>
                                                  <td>  </td>
                                                  <td>  </td>
                                              </tr>
                                              @endif
                                          </table>
                                      </div>
                                  </div>


                                  <div class="modal inmodal fade" id="NoFaktur" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title"> No Faktur </h4>

                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                    printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                remaining essentially unchanged.</p>
                                                <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                    printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                remaining essentially unchanged.</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">

                        </div><!-- /.box-footer --> 
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>
</div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

    tableDetail = $('.tbl-item').DataTable({
        responsive: true,
        searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
        });

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    $no = 0;
    $('.carispp').click(function(){
      $no++;
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
  })

    function showFaktur() 
    {
        var parameter = $("#no_faktur").val();
        var token = '{{ csrf_token() }}';
        // console.log(token);
        window.location = baseUrl+'/reportfakturpelunasan/getfakturpelunasan?faktur='+parameter;
    }

</script>
@endsection
