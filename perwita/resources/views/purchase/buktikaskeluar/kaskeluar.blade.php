<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
  <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <style type="text/css">
    .tandatangan{
    margin-top: 100px;
    margin-left: 40%;
    }
    body{
      font-family: arial;
      font-size: 13px;
    }
    th td {
       border: 1px solid black
    }
    .wrapper{
      width: 1000px;
      margin: -10px 10px 10px 10px;
    }
    .bold{
      font-weight: bold;
    }
    .img{
      margin-left: 10px;
      margin-top: 10px;
    }

    .size{
      font-size: 13px;
    }
    .border {
      border:1px solid;
    }
    .header{
      font-size: 12px;
      margin-top: 20px;
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
      text-align: left;
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
    .right{
      border-right: 1px solid black;
    }
    .bot{
      border-bottom: 1px solid black;
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
      margin-left: 10px;
      margin-top: 10px;
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
    .underline{
      text-decoration: underline;
    }
    .nomorform{
      margin: -10px 0px 0px 700px;
    }
    .pull-right{
    margin-right: 14px;
    padding: 0px 10px 0px 0px;
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
    .gg{
      padding-bottom: -20px;
    }
    .position-fixed{
      position: relative;
    }
    .margin-top-60px{
      margin-top: -48px;
    }
    .margin-top-10px{
      margin-top: -29px;
    }
    .Kwitansi{
      margin-left: 35%;
      font-family: georgia;
      font-size:25px; 
      text-decoration: underline; 
    }
    .minheight{
      min-height: 100px;
    }
    .akirkanan{
      padding-left: 40px;
    }
/*    .table-utama {
      border:1px solid black;
    }*/
    .pembungkus{
      border-right: 1px solid black;
      border-left:  1px solid black;
      border-bottom: 1px solid black;
      min-height: 180px;
    }
    .borderlefttabel{
      border-left: 1px solid black;
    }
    .bordertoptabel{
      border-top: 1px solid black;  
    }


   fieldset.scheduler-border {
    border: 1px groove black !important;
    padding:0 2em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
   }
   @media print, screen{
    legend.scheduler-border {
        font-size: 15px !important;
        z-index: 999;
        text-align: left !important;
        width:auto;
        padding:0 10px ;
        border-bottom:none;
        -webkit-print-color-adjust: exact;
    }
    }

</style>
<body>
 <div class="wrapper">
  <div class="position-fixed">
   <table class="inlineTable">
      <td><img class="img" width="150" height="80" src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}"></td>
   </table>
   <table class="inlineTable size" style="font-size:11px;margin-bottom: 5px;">
    <tr>
      <th style="font-size: 17px;">PT. JAWA PRATAMA MANDIRI</th>
    </tr>
     <tr>
       <td>{{$cari_bkk_id->alamat}}</td>
     </tr>
     <tr>
       <td>Telp. {{$cari_bkk_id->telpon}}</td>
     </tr>
     <tr>
       <td>Email : Ekspedisi@jawapos.co.id</td>
     </tr>
   </table>
    <table class="inlineTable pull-right size" >
     <tr>
       <th width="90">&nbsp;</th>
       <th width="10">&nbsp;</th>
       <th>&nbsp;</th>
       <th>&nbsp;</th>
     </tr>
     <tr>
       <td>No.BKK</td>
       <td>:</td>
       <td>{{$cari_bkk_id->bkk_nota}}</td>
     </tr>
     <tr>
       <td>Tanggal</td>
       <td>:</td>
       <td>{{$tgl}}</td>
     </tr>
     <tr>
        <td>Account Kas</td>
       <td>:</td>
       <td>{{$cari_bkk_id->id_akun}}</td>
     </tr>
     <tr>
       <td colspan="3">
          <p  style="position: absolute; margin-left: 100px;font-size: 12px">{{$cari_bkk_id->nama_akun}}</p>
       </td>
     </tr>
   </table>
   </div>
   <div>
   <div class="Kwitansi bold">
      <p>BUKTI KAS KELUAR</p>
   </div> 
   <div style="margin-top: -35px; margin-right: 5%" class="pull-right">
   </div>
   <div class="blow">
<fieldset class="scheduler-border">
    <legend class="scheduler-border" style=" font-style: italic; background-color: white !important;">Bayar Kepada:</legend>
    <table>
      <tr>
        @if($cari_bkk_id->bkk_supplier != null)
        <td> {{$cari_bkk_id->bkk_supplier}} [ CASH ] </td>
        @else
        <td> - </td>
        @endif
      </tr>
      <tr>
        <td>{{$cari_bkk_id->bkk_keterangan}}</td>
      </tr>
    </table>
</fieldset>
</div>
    </div>
    <div class="pembungkus" >
   <table class="size textcenter table-responsive" width="100%">
     <tr>  
          <th rowspan="2" class="top right textcenter bot" width="5%">No.</th>
          <th colspan="2" class="top right textcenter" width="25%" height="25px">No.Account</th>
          <th rowspan="2" class="top right textcenter" width="40%">Keterangan</th>
          <th rowspan="2" class="top right textcenter" width="7%">D/K</th>
          <th rowspan="2" class="top textcenter" >Jumlah</th>
     </tr>
     <tr height="25px">
          <th class="top right bot textcenter" width="12%">Cash Flow</th>
          <th class="top right bot textcenter">Biaya</th>
     </tr>
     <tr>
         <td class="right textcenter" valign="top" height="300">
         <table> 
         @foreach($cari_bkk_dt as $no=>$val) 
          <tr>  
           <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$no+1}}</td>
          </tr>
          @endforeach
         </table>
       </td>
       <td class="textcenter right" valign="top" height="300">
         <table width="100%">
         @foreach($cari_bkk_dt as $no=>$val) 
          <tr>
           <td></td>
          </tr>
          @endforeach
         </table>
       </td>
        <td class="textcenter top right" valign="top" height="300">
         <table width="100%">
         @foreach($cari_bkk_dt as $no=>$val) 
          <tr>
           <td>{{$val->bkkd_akun}}</td>
          </tr>
          @endforeach
         </table>
       </td>
         <td class="textleft top right" valign="top" height="300">
         <table width="100%">
         @foreach($cari_bkk_dt as $no=>$val) 
          <tr>
           <td>{{$val->bkkd_keterangan}}</td>
          </tr>
          @endforeach
         </table>
       </td>
         <td class="top right" valign="top" height="300">
         <table width="100%">
          @foreach($cari_bkk_dt as $no=>$val) 
          <tr>
            @if($val->bkkd_debit == 'debit')
           <td>D</td>
           @else
           <td>K</td>
           @endif
          </tr>
          @endforeach
         </table>
       </td>
         <td class="textright top right" valign="top" height="300">
         <table width="100%">
          @foreach($cari_bkk_dt as $no=>$val) 
          <tr>
           <td>{{'Rp. ' . number_format($val->bkkd_total,2,',','.')}}</td>
          </tr>
          @endforeach
         </table>
       </td>
     </tr>
     <tr height="25px">
       <td colspan="5" class="top right textright">J u m l a h :</td>
       <td class="textright top right">{{'Rp. ' . number_format($val->bkk_total,2,',','.')}}</td>
     </tr>
     <tr height="25px">
       <td colspan="7" class="textleft top">Terbilang : {{$terbilang}}</td>
     </tr>
   </table>
   <table class="textcenter" width="100%">
     <tr>
       <td class="top right" width="32%">Penerima</td>
       <td class="top right" width="32%">Dikeluarkan Oleh :</td>
       <td class="top">Disetujui Oleh :</td>  
     </tr>
     <tr>
       <td height="100px" class="top right"></td>
       <td class="top right"></td>
       <td class="top"></td>
     </tr>
   </table>
 </div>
</div>

     
 
 
</body>
</html>
<script type="text/javascript">


</script>