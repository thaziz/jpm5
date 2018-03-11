<style type="">
  table td, table th{
    border:1px solid #000;
    border-collapse: collapse;
  }

</style>

 <table >
      <tr>
        <td rowspan="2" style="width:300px"> <img src="sublogo.png"> </td>
      <!--   <td rowspan="2" style="width:200px;height:100px"> &nbsp; </td> -->
        <td rowspan="2" style="width:400px; text-align: center"> <h3> SURAT PERMINTAAN PEMBELIAN </h3> </td>
      
        <td style="width:100px;padding-left:10px"> NO. SPP &nbsp; &nbsp; : &nbsp; &nbsp; 034/VII/2017 </td>
        <tr>
         <td  style="padding-left:10px"> Tanggal &nbsp; &nbsp; : &nbsp; &nbsp; 19 Juli 2017 </td>
        </tr>
      </tr>
    </table>

    <table>
     <tr>
     
        <td style="width:300px"> Diminta oleh Bagian </td> <td> : </td> <td> Bag. Kendaraan </td>
    </tr>
    <tr>
        <td style="width:300px"> Untuk Keperluan </td> <td> : </td> <td> Service mobil box COD DK 9488 MG </td>
    </tr>
    <tr>
        <td style="width:300px"> Tanggal dibutuhkan </td> <td> : </td> <td> 19 Juli 2017 </td>
      </tr>
    </table>

    <table>
      <tr>
        <td colspan="4"> <b>  Diisi oleh bagian yang membutuhkan barang / jasa </b></td>
        <td colspan="6"> <b style="text-align:center"> Disi oleh bagian pembelian</b></td>
      </tr>
      <tr>
        <td rowspan="2"> No </td>
        <td rowspan="2"> Uraian / Nama Barang Jasa </td>
        <td rowspan="2"> Jumlah </td>
        <td rowspan="2"> Satuan </td>
        <td colspan="3"> Harga Untuk masing - masing supplier </td>
        <td rowspan="2" colspan="2" style="width:100px"> No PO</td>
        <td rowspan="2"> Keterangan </td>
       <tr>
          <td>  Supplier A </td>
          <td> Supplier B </td>
          <td> Supplier C </td>
        </tr>
     
      </tr>

      <tr>
        <td> 1 </td>
        <td> oli Mediteran </td>
        <td> 10 </td>
        <td> ltr </td>
        <td> @Rp 36.000 , 00</td>
        <td> </td>
        <td> </td>
        <td> PO 034 </td>
        <td> SPP 034 </td>
        <td> Server Terdekat lokasi pandaan</td>
      </tr>
      <tr>
        <td colspan=10> &nbsp; </td>
      </tr>
      <tr>
        <td colspan=10> &nbsp; </td>
      </tr>
      <tr>
        <td>  </td>
        <td>  </td>
        <td>  </td>
        <td>  </td>
        <td> <b> Rp 530.000 , 00</b></td>
        <td> </td>
        <td> </td>
        <td>  </td>
        <td>  </td>
        <td> </td>

      </tr>
    </table>
    <table>
      <tr>
        <td rowspan="2"> <b> Catatan</b> </td>
        <td> 1. Hubungi minimal 2 supplier dan tuliskan nama supplier yang dihubungi. bila hanya ada 1 supplier tuliskan di keterangan alasanya.
      </tr>
      <tr>
        <td> 2. Lingkari dan beri paraf pada supplier yang dipilih (yang dilakukan oleh Manager Keuangan dan Akuntansi)</td>
      </tr>
    </table>
    <table>
    <tr>
    <td colspan="2" style="width: 500px">
    <b> Peminta barang / jasa </b>
    </td>
    <td colspan="3" style="width:500px">
        <b> Bagian Pembelian Barang / Jasa </b>
    </td>
    </tr>

    <tr>
      <td>
        Diminta Oleh
      </td>
      <td>
        Disetujui Oleh
      </td>
      <td>
      Staff Pembelian
      </td>
      <td>
        Mengetahui,
      </td>
      <td>
        Manager Keuangan dan Akuntansi
      </td>
    </tr>

    <tr rowspan="4">
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
    </tr>

    
    <tr rowspan="4">
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
      <td > &nbsp;
      </td>
    </tr>

    <tr>
      <td> M. Abbas </td>
      <td> Ari Wiwik </td>
      <td>  &nbsp; </td>
      <td>  &nbsp; </td>
      <td>  &nbsp; </td>
    </tr>




    <tr>
      <td> Tgl: 19 Juli 2017 </td>
      <td> Tgl : 19 Juli 2017 </td>
      <td> Tgl : </td>
      <td> Tgl  : </td>
      <td> Tgl  : </td>
    </tr>
    <tr>
      <td colspan="2"> 1. Arsip yang meminta barang / jasa </td>
      <td colspan="3"> 2. Bahan Pembelian </td>
    </tr>
    </table>





@section('extra_scripts')
<script type="text/javascript">

    tableDetail = $('.tbl-purchase').DataTable({
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
 
   

</script>
@endsection
