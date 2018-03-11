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
      font-size: 12px;
    }
    .wrapper{
      border-top: 1px solid black;
      border-right: 1px solid black;
      border-left: 1px solid black;
      width: 1000px;
      margin:  10px 10px 10px 10px;
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
    .borderrighttabel{
      border-right: 1px solid black;
    }
    .borderbottomtabel{
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
    .paddingimg{
      padding: 10px 10px 10px 10px;
      margin-left: 5%;
    }
</style>
<body>
 <div class="wrapper">
   <table width="100%">
    <tr>
      <td class="right bot " width="20%"><img width="180" height="95" class="paddingimg" src="/jpm/perwita/img/logo_jpm.png"></td>
      <td class="right bot textcenter bold" style="font-size: 24px;" width="44%">BUKTI PERMINTAAN DAN PENGELUARAN BARANG</td>
      <td class="bot" valign="top">
        <table>
          <tr>
            <td height="40" valign="top" width="20%" class=" textleft">No. PBBP</td>
            <td valign="top">:</td>
            <td valign="top"></td>
          </tr>
          <tr>
            <td height="40" valign="top" class=" textleft">Tanggal</td>
            <td valign="top">:</td>
            <td valign="top"></td>
          </tr>
        </table>
      </td>
    </tr>
   </table>
   <table width="100%" class="bot">
     <tr>
       <td class="textleft" height="30" valign="top" width="20%">Keperluan Untuk</td>
       <td height="30" valign="top" width="2%">:</td>
       <td class="textleft" valign="top"></td>
     </tr>
   </table>
   <table width="100%">
     <tr>
       <th class="right bot textcenter" width="63.9%">Diisi oleh yang meminta barang</th>
       <th class="bot textcenter">Diisi oleh bagian Gudang</th>
     </tr>
   </table>
   <table width="100%" class="size">
     <tr>
       <td width="8%"  class="right bot textcenter">No</td>
       <td width="30%" class="right bot textcenter">Uraian Barang</td>
       <td width="13%" class="right bot textcenter">Satuan</td>
       <td width="13.1%" class="right bot textcenter">Jumlah Satuan Diminta</td>
       <td width="11%" class="right bot textcenter">Jumlah Satuan Diberi</td>
       <td class="bot textcenter">Keterangan</td>
     </tr>
     <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
       <tr>
       <td class="right bot">&nbsp;</td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="right bot"></td>
       <td class="bot"></td>
     </tr>
   </table>
   <table width="100%">
      <tr>
       <td width="38%" class="right bot textcenter" height="100" valign="top">Diminta Oleh</td>
       <td width="20%" class="right bot textcenter" valign="top">Disetujui Oleh</td>
       <td width="16.8%" class="right bot textcenter" valign="top">Diserahkan Oleh</td>
       <td class="bot textcenter" valign="top">Diterima Oleh</td>
     </tr>
   </table>
 </div>
 <p style="margin-left: 40%;margin-top: -8px;">JOAS-1212-1212-12</p>
</body>
</html>
