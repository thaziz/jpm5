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
    .pembungkus{
      min-height: 200px;
      border-bottom: 1px solid black;
      border-right: 1px solid black;
      border-left:  1px solid black;
    }
    .center{
      text-align: center;
    }
</style>
<body>
 <div class="wrapper">
  <div class="position-fixed">
   <table class="inlineTable">
      <td><img class="img" width="80" height="40" src="{{ asset('perwita/storage/app/upload/images.jpg') }}"></td>
   </table>
   <table class="inlineTable size" style="margin-bottom: -20px;margin-top: 20px;">
    <tr>
      <th>{{perusahaan()->mp_nama}}</th>
    </tr>
     <tr>
       <td>{{perusahaan()->mp_alamat}}</td>
     </tr>
     <tr>
       <td>Telp.{{perusahaan()->mp_tlp}}</td>
     </tr>
     <tr>
       <td>Email : ekspedisi@jawapos.co.id</td>
     </tr>
   </table>
   </div>
   <div style="margin-top: 20px;">
   <div class="Kwitansi bold">
      <p>DELIVERY ORDER</p>
   </div>
    <table class="inlineTable pull-right size">
     <tr>
       <th width="90">&nbsp;</th>
       <th width="10">&nbsp;</th>
       <th>&nbsp;</th>
       <th>&nbsp;</th>
     </tr>
     <tr>
       <td>No.Kwitansi</td>
       <td>:</td>
       <td>{{$head->nomor}}</td>
     </tr>
     <tr>
        <td>Tanggal</td>
       <td>:</td>
       <td>{{carbon\carbon::parse($head->tanggal)->format('d/m/Y')}}</td>
     </tr>
     <tr>
        <td>Kode.Cust.</td>
       <td>:</td>
       <td>{{$head->kode_customer}}</td>
     </tr>
   </table>
  
   <table class="size" width="50%">
     <tr>
       <th>Kepada Yth:</th>
     </tr>
     <tr>
       <th>{{$head->nama}}</th>
     </tr>
     <tr>
       <td >{{$head->alamat}}</td>
     </tr>
     <tr>
       <td>{{$head->telpon}}</td>
     </tr>
   </table>
    </div>

    <div class="">
   <table class="size"  width="100%">
     <tr>
       <th class="textcenter bot left right top" width="15%" rowspan="2">Nomor</th>
       <th class="textcenter bot right top" width="15%" colspan="2">Jenis Item</th>
       <th class="textcenter bot right top" width="40%" rowspan="2">Keterangan</th>
       <th class="textcenter bot right top" width="20%" rowspan="2">Kuantum</th>
       
     </tr>
     <tr>
       <th class="textcenter bot right top" width="10%">Kode</th>
       <th class="textcenter bot right top" width="10%">Nama</th>
     </tr>
     @if($head->kontrak==false)
         @foreach($detail as $val)
         <tr>
           <td class="bot left right">{{$val->dd_nomor}} - {{$val->dd_nomor_dt}}</td>
           @if($val->dd_id_kontrak == 0)
           <td class="bot center left right">{{$val->dd_kode_item}}</td>
           @else
           <td class="bot center left right">{{$val->dd_id_kontrak}}</td>
           @endif

           @if(isset($val->kcd_keterangan))
           <td class="bot left right">{{$val->kcd_keterangan}}</td>
           @else
           <td class="bot left right">{{$val->nama}}</td>
           @endif
           <td class="bot left right" >{{$val->dd_keterangan}}</td>
           <td class="bot center left right">{{$val->dd_jumlah}} {{$val->dd_kode_satuan}}</td>
         </tr>
         @endforeach
      @else
         @foreach($detail as $i=>$val)
         <tr>
           <td class="bot left right">{{$val->dd_nomor}} - {{$val->dd_nomor_dt}}</td>
           @if($val->dd_id_kontrak == 0)
           <td class="bot center left right">{{$val->dd_kode_item}}</td>
           @else
           <td class="bot center left right">{{$val->dd_id_kontrak}}</td>
           @endif

           @if(isset($val->nama_item))
           <td class="bot left right">{{$val->nama_item}}</td>
           @else
           <td class="bot left right">{{$val->nama}}</td>
           @endif
           <td class="bot left right" >{{$val->dd_keterangan}}</td>
           <td class="bot center left right">{{$val->dd_jumlah}} {{$val->dd_kode_satuan}}</td>
         </tr>
         @endforeach
      @endif
     @foreach($array as $val)
     <tr>
       <td class=" left ">&nbsp;</td>
       <td >&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td class="right">&nbsp;</td>
     </tr>
     @endforeach 
     <tr>
      <tr>
       <td class="bot left">&nbsp;</td>
       <td class="bot">&nbsp;</td>
       <td class="bot">&nbsp;</td>
       <td class="bot">&nbsp;</td>
       <td class="bot right">&nbsp;</td>
      </tr>
   </table>
   </div>  
   <br> 
   <table width="100%" class="textcenter">
     <tr>
       <th class="textcenter">Mengetahui/Pengirim</th>
       <th class="textcenter">Penerima</th>
       <th class="textcenter">Pemberi Order</th>
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
     <tr>
       <td><input type="text" class="hiddenbordertop bot right left" name=""></td>
       <td><input type="text" class="hiddenbordertop bot right left" name=""></td>
       <td><input type="text" class="hiddenbordertop bot right left" name=""></td>
     </tr>
     <tr>
       <td colspan="4" align="right" style="font-size: 10px">{{Auth::user()->m_username}} - {{carbon\carbon::now()}}</td>
     </tr>
   </table>
 </div>
</body>
</html>
