<html>
    <head>
       <style type="text/css">

        </style> 
    </head>
    <body>

    <table border="0" class="table">
        <tr>
            <td> No SPP : </td>
            <td> <b> {{$nospp}} </b></td>
        </tr>

        <tr>
            <td> Cabang :  </td>
            <td> <b> {{$namacabang}} </b></td>
        </tr>
    </table>
        <br>
        Yang Terhormat, Cabang {{$namacabang}} <br>
        Berikut kami memberitahukan bahwa progress dari Surat Permintaan Pembelian yaitu : <br>  <br>  

        <table class="table table-border">
            <tr> <th style="padding: 5px 5px 5px 5px; border: 1px solid #ccc; text-align: center; background: #6f6ff3; color: #ffffff"> Status Manager Umum </th> 
            <th style="padding: 5px 5px 5px 5px; border: 1px solid #ccc; text-align: center; background:#6f6ff3; color:#ffffff"> Status Manager Pembelian </th>
            <th style="padding: 5px 5px 5px 5px; border: 1px solid #ccc; text-align: center; background: #6f6ff3; color:#ffffff"> Status Manager Pembelian </th> </tr>
            <tr> <td style="padding: 20px 20px 20px 20px; border: 1px solid #ccc; text-align: center; background: #fefefe; color: 333"> {{$setujumngumum}} </td> 
            <td style="padding: 20px 20px 20px 20px; border: 1px solid #ccc; text-align: center; background: #fefefe; color: 333"> {{$setujumngpem}} </td>
            <td style="padding: 20px 20px 20px 20px; border: 1px solid #ccc; text-align: center; background: #fefefe; color: 333"> {{$setujustaffpemb}} </td>  </tr>
        </table>
    </body>
</html>




<!-- 
  Yang Terhormat cabang : {{$namacabang}}
        Berikut kami memberitahukan bahwa progress dari Surat Permintaan Pembelian dengan No SPP {{$nospp}} yaitu : 
        Status Manager Umum :  {{$setujumngumum}} ; Status Manager Pembelian :   {{$setujumngpem}} ; Status Manager Pembelian : {{$setujustaffpemb}}  -->