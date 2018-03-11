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
    }
    th td {
       border: 1px solid black
    }
    .wrapper{
      width: 900px;
      margin: 10px 10px 10px 10px;
      border:1px solid black;
    }
    .bold{
      font-weight: bold;
    }
    .img{
      margin-left: 10px;
      margin-top: 10px;
    }
    .size{
      font-size: 12px;
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
    .nomorform{
      margin: -10px 0px 0px 700px;
    }
    .pull-right{
    margin-right: 14px;
    /*width: 200px;*/
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
      margin-top: -60px;
    }
    .margin-top-10px{
      margin-top: -25px;
    }
    .Kwitansi{
      margin-left: 45%;
      font-family: arial;
      font-size:20px;  
    }
    .minheight{
      min-height: 100px;
    }
    
</style>
<body>
 <div class="wrapper">
  <div class="position-fixed">
   <table class="inlineTable">
      <td><img class="img" width="150" height="80" src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}"></td>
   </table>
   <table class="inlineTable size" style="margin-bottom: -5px;">
    <tr>
      <th style="font-size: 18px;">PT. JAWA PRATAMA MANDIRI</th>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
     <tr>
       <td>Jl. Karah Agung no.45 Surabaya</td>
     </tr>
     <tr>
       <td>Telp. 031.8290606, 82518332</td>
     </tr>
     <tr>
       <td>Fax 031.8983999</td>
     </tr>
   </table>
   <table class="inlineTable bold" style="font-size: 16px;">
     <td>
       LIST REIMBURSTMENT
     </td>
   </table>
   <table class="inlineTable pull-right" >
    <tr>
      <td>No : </td>
      <td>{{$data->ik_nota}}</td>
    </tr>
    <tr>
      <td>Tanggal : </td>
      <td>{{$data->ik_tgl_akhir}}</td>
    </tr>
    <tr>
      <td>Cabang :</td>
      <td>{{$data->nama}}</td>
    </tr>
   </table>
   </div>     
   <div style="margin-top: 5px;">
     
   </div>
   <table class="size"  width="100%">
     <tr>
       <th class="textcenter bot right top" width="3%">No</th>
       <th class="textcenter bot right top" width="8%">Tanggal</th>
       <th class="textcenter bot right top" width="13%">No.Reff</th>
       <th class="textcenter bot right top" width="10%">Kode Acc</th>
       <th class="textcenter bot right top" width="40%">Keterangan</th>
       <th class="textcenter bot top">Credit</th>
     </tr>
     @foreach($data_dt as $i => $val)
     <tr>
       <td class="textleft bot right">{{$i+1}}</td>
       <td class="textleft bot right">{{$data->ik_tgl_akhir}}</td>
       <td class="textleft bot right">{{$val->ikd_ref}}</td>
       <td class="textleft bot right">{{$val->ikd_akun}}</td>
       <td class="textleft bot right">{{$val->ikd_keterangan}}</td>
       <td class="textright bot">{{'Rp. ' . number_format($val->ikd_nominal,2,',','.')}}</td>
     </tr>
     @endforeach
     <tr>
       <td colspan="5" class="right textleft"><strong>Terbilang: {{$terbilang}} Rupiah</strong><strong style="float:right;">Total :</strong></td>
       <td class="textright ">{{'Rp. ' . number_format($data->ik_total,2,',','.')}}</td>
     </tr>
   </table>
 </div>
 <div class="wrapper">
      <table width="100%" class="size">
        <tr>
        <th class="bot right textcenter">Dibuat oleh :</th>
        <th class="bot right textcenter">Mengetahui :</th>
        <th class="bot textcenter">Disetujui Oleh :</th>
        </tr>
        <tr>
          <td height="100px" class="right"></td>
          <td class="right"></td>
          <td></td>
        </tr>

      </table>
 </div>
</body>
</html>
