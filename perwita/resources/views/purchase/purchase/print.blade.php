<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
  <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
  <style type="text/css">
    body{
      font-family: "Times New Roman", Times, serif;
    }
    .wrapper{
      border: 5px double black;
      width: 900px;
      margin: 10px 10px 10px 10px;
    }
    .bold{
      font-weight: bold;
    }
    .img{
      margin-left: 80px;
      margin-top: 10px;
    }
    .border{
      border:1px solid;
    }
    .header{
      font-size: 23px;
      margin-left: 180px;
      font-family: georgia;
    }
    .full-right{
      margin-bottom: 27px; 
      padding-right:10px; 
      padding-left:10px;
    }
    .bottomheader{
      border-bottom: 1px solid black;
    }
    .kepada{
     border-bottom: 1px solid;
     right:120%;
    }
    .tabel2{
      padding: 10px 10px;
      display: inline-block;
    }
    .jarak1{
      padding: -10px -10px -10px -10px;
    }
    .inlineTable {
      display: inline-block;
    }
    .tabel-utama{
      margin-left: 10px;
      width: 97%;
    }
    .textcenter{
      text-align: center;
    }
    .jarak{
      padding: 10px 10px 10px 10px;
    }
    .textright{
      text-align: right;
      padding-right: 5px;
    }
    .textleft{
      text-indent: 5px;
    }
    .hiddenborderleft{
      border-left:  0px ;
    }
    .hiddenborderright{
      border-right:  0px ;
    }
    .hiddenbordertop{
      border-top:  0px ;
    }
    .hiddenborderbottom{
      border-bottom:  0px ;
    }
    .borderright{
      border-right: 1px solid black;
      padding-right: 100px; 
    }
    .inputheader{
      width: 285px;
      border-bottom: 1px solid black;
    }
    .fontpenting{
      font-size: 11px;
      margin-top: 100px;
      font-family: georgia;
      padding: 3px 3px 3px 3px;
    }
    .ataspenting{
      margin:  20px 0px 2px 10px;
    }
    .tabelpenting{
      margin: 0px 0px 10px 10px;
      border:1px 1px 0px 1px solid black;
      width: 112%;
    }
    .headpenting{
      font-family: georgia;
      padding: 3px 3px 3px 3px;
    }
    .tab{
      margin-left: 30px;
    }
    .boldtandatangan{
      font-weight: bold;
      font-size: 11px;
    }
    .tandatangandiv{
      margin-top: -225px;
      margin-left: 585px;
      margin-bottom: 10px;
    }
    .headtandatangan{
      text-align: center;
      width:  287px;
      padding-bottom: 70px;
    }
    .top{
      border-top: 1px solid black;
    }
    .bot{
      border-bottom: 1px solid black;
    }
    .bottabelutama{
      border-bottom: 1px solid grey;
    }
    .right{
      border-right: 1px solid black;
    }
    .left{
      border-left: 1px solid black;
    }
    .note{
      margin: 0px 10px 10px 10px;
      text-decoration: underline;
    }
    .nomorform{
      margin: -10px 0px 0px 700px;
    }
    .pull-right{
    margin-top: 20px;
    margin-right: 14px;
    padding: 0px 10px 0px 10px;
    }
    .paddingbottom{
      padding-bottom: 60px; 
    }
    .fixed{
      position: absolute;
    }
    .catatanpadding{
      padding-left: 10px;
    }
</style>
<body>
 <div class="wrapper">
  <div class="row">
    <table>
    <td class="logo borderright">
    <div>
      <p><img class="img" src="/jpm/perwita/img/logo_jpm.png"></p>
    </div>
    </td>
    <td>
      <p class="header">PURCHASE ORDER</p>
    </td>
    </table>
  </div>
  <div class="bottomheader">
    
  </div>
     <table class="inlineTable tabel2 table-responsive">
                <tr>
                    <th>Kepada Yth.</th>
                </tr>
                 <tr>
                    <td class="bold">
                    <input type="" name="" readonly="" class="inputheader hiddenborderleft hiddenborderright hiddenbordertop" @if ($a === null) value="&nbps;" @else value="{{$a}}" @endif>
                  </td>
                 </tr>
                  <tr>
                    <td class="bold">
                    <input type="" name="" readonly="" class="inputheader hiddenborderleft hiddenborderright hiddenbordertop" @if ($b === null) value="&nbps;" @else value="{{$b}}" @endif>
                  </td>
                 </tr>
                  <tr>
                    <td class="bold">
                    <input type="" name="" readonly="" class="inputheader hiddenborderleft hiddenborderright hiddenbordertop" 
                     @if ($c === null) value="&nbps;" @else value="{{$c}}" @endif>
                  </td>
                 </tr>
    </table>
    <table class="inlineTable border pull-right pull-right table-responsive">
       <thead>
                <tr>
                  <td style="width: 100px;">Tanggal</td>
                  <td>:</td>
                  <td>{{ \Carbon\Carbon::parse($d)->format('d F Y')}} </td>
                </tr>
                <tr>
                  <td >No. PO</td>
                  <td>:</td>
                  <td>{{$e}}</td>
                </tr>
                <tr>
                  <td >No. SPP</td>
                  <td>:</td>
                  <td>{{$f}}</td>
                </tr>
       </thead>
    </table>
    <table class="tabel2 table-responsive">
      <td>Dengan ini kami memesan barang-barang / jasa sebagai berikut :  </td>
    </table>
    <div>
    <table border="1" class="tabel-utama table-responsive">
          <thead>
          <tr>
                <th class="textcenter jarak" width="5%">No.</th>
                <th class="textcenter" width="30%">Nama dan Spesifikasi Barang/Jasa</th>
                <th class="textcenter" width="15%">Lokasi Gudang</th>
                <th class="textcenter" width="10%">Jumlah</th>
                <th class="textcenter" width="10%">Satuan</th>
                <th class="textcenter" width="15%">Harga Satuan</th>
                <th class="textcenter" width="15%">Jumlah Harga</th>
          </tr>
       </thead>
       <tbody>
        @foreach($data2['podt'] as $index=>$podt)  
        <tr>
                <td class="textcenter">{{$index+1}}</td>
                <td class="textleft">{{$podt->nama_masteritem}}</td>
                <td class="textleft">{{$podt->mg_namagudang}}</td>
                <td class="textcenter">{{$podt->podt_qtykirim}}</td>
                <td class="textleft">{{$podt->unitstock}}</td>
                <td class="textright">{{number_format($podt->podt_jumlahharga, 2,",",".")}}</td>
                <td class="textright">{{number_format($podt->podt_totalharga,2,",",".")}}</td>
        </tr>
        @endforeach
        <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
        </tr>
        <tr>
          <td class="hiddenborderright hiddenbordertop hiddenborderbottom hiddenborderleft fixed" width="8%">
            <table>
              <tr class="textleft">
                <td align="left" class="paddingbottom" rowspan="4">Catatan :</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
          </td>
          <td  colspan="4" class="hiddenborderleft hiddenborderright">
            <table style="margin-left: 10px;">
              <tr> 
                <th align="left" class="paddingbottom catatanpadding" rowspan="4"></th>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
          </td>
          <td class="hiddenborderbottom">
            <table width="100%" class="textcenter hiddenborderleft hiddenborderright hiddenbordertop">
              <tr >
                <td class="bottabelutama ">Sub Total</td>
              </tr>
              <tr>
                <td class="bottabelutama">Discount</td>
              </tr>
              <tr>
                <td class="bottabelutama">P P n</td>
              </tr>
              <tr>
                <td>Total</td>
              </tr>
            </table>
          </td>
           <td >
            <table width="100%" class="textright hiddenborderleft hiddenborderright hiddenbordertop">
              <tr>
                <td class="bottabelutama textright">{{number_format($j,2,",",".")}}</td>
              </tr>
              <tr>
                <td class="bottabelutama textright">{{$k}} %</td>
              </tr>
              <tr>
                <td class="bottabelutama textright">{{$L}} %</td>
              </tr>
              <tr>
                <td class="textright">{{number_format($m,2,",",".")}}</td>
              </tr>
            </table>
          </td>
        </tr>
       </tbody>
    </table>
    <table class="ataspenting">
      <tr>
        <td style="width: 200px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 200px;">Jangka Waktu Pembayaran</td>
        <td>:</td>
        <td>{{$n}} hari dari TT</td>
      </tr>
      <tr>
        <td style="width: 200px;">Tanggal Pengiriman</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($g)->format('d F Y')}} </td>
      </tr>
      
    </table>
    <table>
      <tr>
          <td>
            <table class="tabelpenting top bot left ">
              <tr >
                <th class="headpenting">PENTING :</th>
              </tr>
              <tr>
                <td class="fontpenting">1. <span class="tab">Mohon Mencantumkan No.PO di atas pada Invoice dan Surat Jalan Anda</td>
              </tr>
             <tr>
                <td class="fontpenting">2. <span class="tab">Spesifikasi barang dalam PO ini tidak dapat diganti tanpa pemberitahuan tertulis dari kami</td>
              </tr>
               <tr>
                <td class="fontpenting">3. <span class="tab">Perusahaan kami berhk membatalkan PO ini apabila tidak tepat waktu pengirimannya</td>
              </tr>
              <tr>
                <td class="fontpenting">4. <span class="tab">Semua biaya untuk retur barang yang tidak sesuai dengan PO ini dibebankan kepada Supplier</td>
              </tr>
              <tr>
                <td class="fontpenting">5. <span class="tab">Pengiriman barang harus dilakukan selama jam kerja kami</td>
              </tr>
              <tr>
                <td class="fontpenting">6. <span class="tab">Setelah menerima PO ini mohon ditandatangani dan difaxkan kembali</td>
              </tr>
            </table>
          </td>
        </tr>
    </table>
    <div class="tandatangandiv">
    <table>
      <tr>
            <table class="tandatangan border">
              <tr>
                <th class="headtandatangan boldtandatangan">PT JAWA PRATAMA MANDIRI</th>
              </tr>
              <tr>
                <td class="border textleft">Tgl :</td>
              </tr>
              <tr>
                <th class="headtandatangan boldtandatangan">SUPPLIER</th>
              </tr>
               <tr>
                <td class="border textleft">Tgl :</td>
              </tr>
            </table>
        </tr>
    </table>
    </div>
    </div>
 </div>
 <div>
  <div>
    <table class="nomorform" >
      <tr>
        <td>{{$h}}</td>
      </tr>
    </table>
  </div>
   <table class="note">
     <tr>
       <td class="textleft">Note :</td>
     </tr>
     <tr>
       <td class="textleft">Tandatangan beserta nama terang</td>
     </tr>
     <tr>
       <td class="textleft">Apabila persetujuan supplier melalui telp., dicantumkan nama, tgl, waktu & no.tlp</td>
     </tr>
   </table>
 </div>
</body>
</html>