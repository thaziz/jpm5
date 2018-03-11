<html>
    <head>
        <title> Laporan Penerimaan Barang </title>
        <style type="text/css">
            .button {
                background-color: #e7e7e7; /*Grey */
                border: none;
                color: black;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                ;    
            }
            h5{
              font-size:14px;
            }
            text-center{
              float:center;
            }
        </style>

    </head>
    <body>
    <br>
         <table style="width:60%">
            <tr>
                <td style="height:100px;width:25%">LOGO</td>
                <th style="height:100px;width:25%""> <text-center> LAPORAN PENERIMAAN BARANG </text-center></th>
                <td style="height:100px;width:25%""> <h5> No LPB : <?php echo $data['penerimaan'][0]->pb_lpb ?><br> Tgl : <?php echo date('d-M-Y' , strtotime($data['penerimaan'][0]->pb_date)) ?> </h5> </td>
            </tr>
          
          
        </table>

        
        <table style="width:60%">
          <tr>
            <td style="width:18%"> Diterima dari </td>
            <td style="width:30%">  </td>
            <td style="width:18%"> Nomor PO </td>
            <td style="width:30%"> <?php echo $data['penerimaan'][0]->po_no?></td>
          </tr>
          <tr>
          <td> Nomor SJ : </td> <td colspan="3"> <?php echo $data['penerimaan'][0]->pb_suratjalan ?> </td>
        </table>

        <table style="width:60%">
          <tr>
            <th colspan="4"> Diisi oleh Staff Gudang </th>
            <th colspan="2"> Diisi oleh Staff Pembelian </th>
          </tr >

          <tr>
          <th style="width:5%"> No </th>
          <th style="width:41   %"> Uraian Barang </th>
          <th style="width:8%"> Satuan </th>
          <th style="width:5%"> Q </th>
          <th style="width:20%"> Harga Satuan </th>
          <th style="width:20%"> Jumlah </th>
          </tr>

          <?php
          for($i = 0 ; $i < count($data['barang'][0]) ;  $i++) {
          ?>
          <tr height="30px">
             <td> <?php echo $i + 1 ?></td>
             <td> <?php echo $data['barang'][0][$i]->nama_masteritem ?> </td>
             <td> <?php echo $data['barang'][0][$i]->unitstock ?> </td>
             <td> <?php echo $data['barang'][0][$i]->pbdt_qty ?> </td>
             <td style="text-align: right"> <?php echo  "Rp " . number_format( $data['barang'][0][$i]->pbdt_hpp, 2  )  ?> </td>
             <td style="text-align: right;"> <?php echo   "Rp " . number_format( $data['barang'][0][$i]->pbdt_totalharga, 2  )  ?> </td>
          </tr>
          <?php
            }
            ?>
            <tr style="height: 30px">
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
              <tr style="height: 30px">
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
              <tr style="height: 30px">
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
              <tr style="height: 30px">
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>

          <tr>
            <th colspan="2"> JUMLAH
            </th>
            <td> </td>
            <td> </td>
            <td> </td>
            <td style="text-align: right"> <?php echo "Rp " . number_format( $data['penerimaan'][0]->pb_totaljumlah, 2  )  ?></td>
          </tr>

        </table>
        <table style="width:60%">
        <tr>
          <th style="width:12%">
          Penerima Barang
          </th>
          <th style="width:13%">
          Menyetujui
          </th>

          <th style="width:15%">
            Bagian Pembelian
          </th>

          <th style="width:15%">
          Bagian Hutang
          </th>
        </tr>

        <tr style="height:150px">
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        </tr>
        </table>
        1. Bagian Pembelian &nbsp; &nbsp; &nbsp; 2. Bagian Hutang &nbsp; &nbsp; &nbsp; 3. Bagian Gudang <br>
        
        
        JPM/FR/GUD/05-02 Januari 2017-00
    </body>
</html>




