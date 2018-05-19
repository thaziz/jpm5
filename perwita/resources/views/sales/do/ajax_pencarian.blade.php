 <table id="addColumn"  class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tsssujuan </th>
                            <th> Tipe </th>
                            <th> Detail </th>
                          
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                    <tr>
                      <td colspan="7">Total net</td>
                      <td id="total_grandtotal"></td>
                    </tr>
                  </table>
    

    
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
<script type="text/javascript">

      function format ( d ) {
      return  '<table class="table">'+
                '<tr>'+
                    '<td>status</td>'+
                    '<td>:</td>'+
                    '<td>'+d.status+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>pendapatan</td>'+
                    '<td>:</td>'+
                    '<td>'+d.pendapatan+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>customer</td>'+
                    '<td>:</td>'+
                    '<td>'+d.cus+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>total net</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_net+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>cabang</td>'+
                    '<td>:</td>'+
                    '<td>'+d.cab+'</td>'+
                '</tr>'+
            '</table>'
              ;
      }
 
      var table =  $('#addColumn').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('carideliveryorder_total') }}',
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "nama_pengirim" },
            { "data": "nama_penerima" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "type_kiriman" },
            {
                "class": "details-control",
                "orderable": false,
                "data": null,
                "defaultContent": "",
            },
            ]
      });
    
     var detailRows = [];

       $('#addColumn tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
                  </script>