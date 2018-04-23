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
      width: 900px;
      margin:  10px 10px 10px 10px;
    }
     .wrapper2{
      width: 900px;
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
    .hiden{
      width: 145px;
      border-bottom: 1px solid black;
    }
    .italic{
      font-style: italic;
    }
    .botdouble{
    border-bottom:4px double black;
    }
    .topdouble{
    border-top:4px double black;
    }
     @media print, screen{
    td.grey {
        -webkit-print-color-adjust: exact;
    }
    }
</style>
<body>
 <div class="wrapper">
   <table width="100%">
    <tr>
      <td class="right bot " width="30%"><img width="180" height="95" class="paddingimg" src="/jpm/perwita/img/logo_jpm.png"></td>
      <td class="right bot textcenter bold" style="font-size: 20px;" width="44%">LAPORAN PENERIMAAN BARANG</td>
      <td class="bot" valign="top">
        <table>
          <tr>
            <td valign="top" class=" textleft" width="25%">No. LPB</td>
            <td valign="top" width="8%">: </td>
            <td valign="top">
                <table width="100%"> 
                    <tr>  
                      <td class="hiden">  
                     {{$data['judul']['0']->pb_lpb}}
                      </td>
                    </tr>
                </table>
            </td>
          </tr>
          <tr>  
              <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class=" textleft">Tanggal</td>
            <td valign="top">:</td>
            <td valign="top">
               <table width="100%"> 
                    <tr>  
                      <td class="hiden">  
                          &nbsp;  {{ Carbon\Carbon::parse($data['judul']['0']->pb_date)->format('d-M-Y ') }}
                      </td>
                    </tr>
                </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
   </table>
   <table width="100%" class="bot">
     <tr class="bot">
       <td class="textleft" valign="top" width="15%">Diterima Dari</td>
       <td valign="top" width="2%">: </td>
       <td valign="top" width="35%"> {{$data['judul']['0']->pb_terimadari}}</td>
     
       <td class="textleft" valign="top" width="15%">Nomor PO</td>
       <td valign="top" width="2%">: </td>
       <td valign="top"> 
          @if($data['flag'] == 'FP')
          {{$data['judul']['0']->fp_nofaktur}}
          @elseif ($data['flag'] == 'PO'  )
          {{$data['judul']['0']->po_no}}
          @else
          {{$data['judul']['0']->pb_nota}}
          @endif
       </td>
     </tr>
     <tr >
       <td class="textleft" valign="top" width="15%">Nomor SJ</td>
       <td valign="top" width="2%">: </td>
       <td valign="top" width="35%">  {{$data['judul']['0']->pb_suratjalan}} </td>
       <td>&nbsp;</td>
       <td></td>
       <td></td>
     </tr>
   </table>
   <table width="100%">
     <tr>
       <th class="right bot textcenter italic" width="72.8%">Diisi oleh Staff Gudang</th>
       <th class="bot textcenter italic">Diisi oleh bagian Gudang</th>
     </tr>
   </table>
   <table width="100%" class="size">
     <tr>
       <td width="8%"  class="right botdouble textcenter">No</td>
       <td width="45%" class="right botdouble textcenter">Uraian Barang</td>
       <td width="10%" class="right botdouble textcenter">Satuan</td>
       <td width="10%" class="right botdouble textcenter">Quantity</td>
       <td width="10%" class="right botdouble textcenter">Harga Satuan</td>
       <td class="botdouble textcenter">Jumlah</td>
     </tr>
     <span hidden="true"></span>
     <span hidden="true"></span>

        <?php $n = 1; ?>
       @for($i = 0; $i < count($data['barang']); $i++) 

        @for($j = 0; $j < count($data['barang'][$i]); $j++)
           <tr>
           <td class="right bot" align="center">&nbsp; <?php echo $n ?></td>
           <td class="right bot" align="center"> {{$data['barang'][$i][$j]->nama_masteritem}}</td>
           <td class="right bot" align="center"> {{$data['barang'][$i][$j]->unitstock}} </td>
           <td class="right bot" align="center"> {{$data['barang'][$i][$j]->pbdt_qty}}</td>
           <td class="right bot" align="right">Rp  </td>
           <td class="bot" align="right">Rp  </td>
           <span hidden="true"></span>
           <span hidden="true" align="right"></span>
       </tr>
            <?php $n++ ?>
        @endfor
      @endfor
      
      <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr>
        <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr> <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr> <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr> <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr> <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr> <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr> <tr>
         <td class="right bot" height="20px"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="right bot"></td>
         <td class="bot"></td>
         <span hidden="true"></span>
         <span hidden="true"></span>
       </tr>
  
     <tr class="botdouble topdouble">
       <th class="right bot textcenter" colspan="2">JUMLAH</th>
       <td class="right bot grey" style="background-color: #d8d8d8 !important; "></td>
       <td class="right bot" align="center"></td>
       <td class="right bot grey" style="background-color: #d8d8d8 !important;"></td>
       <td class="bot" align="right">Rp </td>
     </tr>
   </table>
   <table width="100%">
      <tr>
       <td width="32%" class="right bot textcenter" height="100" valign="top">Penerima Barang</td>
       <td width="21%" class="right bot textcenter" valign="top">Menyetujui</td>
       <td width="20%" class="right bot textcenter" valign="top">Bagian Pembelian</td>
       <td class="bot textcenter" valign="top">Bagian Hutang</td>
     </tr>
   </table>
 </div>
 <div class="wrapper2">  
 <table width="100%">
   <tr>
     <td width="5%">1.</td>
     <td width="33%">Bagian Pembelian</td>
     <td width="5%">2.</td>
     <td width="33%">Bagian Hutang</td>
     <td width="5%">3.</td>
     <td width="33%">Bagian Gudang</td>
   </tr>
 </table>
 <p style="margin-left: 75%;margin-top: 2%;">PSKK-123123-12312</p>
 </div> 
</body>
</html>
