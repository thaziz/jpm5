 <table id="addColumn"  class="table table-bordered table-striped no-random-color">
                    <thead class="red-bg-color">
                        <tr>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Customer </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Status </th>
                            <th> Detail </th>
                          
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                    <tr>
                      <td colspan="8">Total net</td>
                      <td id="total_grandtotal"></td>
                    </tr>
                  </table>


    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

    <script type="text/javascript" src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/vendors/datatables/dataTables.responsive.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
           function format ( d ) {
              return  '<table class="table">'+
                        '<tr>'+
                        '<td>Tipe</td>'+
                        '<td>:</td>'+
                        '<td>'+d.type_kiriman+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Jenis</td>'+
                        '<td>:</td>'+
                        '<td>'+d.jenis_pengiriman+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Pendapatan</td>'+
                        '<td>:</td>'+
                        '<td>'+d.pendapatan+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>customer</td>'+
                        '<td>:</td>'+
                        '<td>'+d.cab+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>DPP</td>'+
                        '<td>:</td>'+
                        '<td>'+d.total_dpp+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Vendor</td>'+
                        '<td>:</td>'+
                        '<td>'+d.total_vendo+'</td>'+
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
                    '<tr>'+
                        '<td>Aksi</td>'+
                        '<td>:</td>'+
                        '<td>'+d.button+'</td>'+
                    '</tr>'+
                    '</table>'
                      ;
              }
              var min = '{{$min}}';
              var max = '{{$max}}';
              var asal = '{{$asal}}';
              var tujuan = '{{$tujuan}}';
              var cabang = '{{$cabang}}';
              var tipe = '{{$tipe}}';
              var status = '{{$status}}';
              var jenis = '{{$jenis}}';
              var pendapatan = '{{$pendapatan}}';
              var customer = '{{$customer}}';
              var nomor = '{{$nomor}}';

              var table =  $('#addColumn').DataTable({
                    processing: true,
                    // responsive:true,
                    serverSide: true,
                    ajax: {
                        url:'{{ route('ajax_index_deliveryorder_paket') }}',
                        data:{min,max,asal,tujuan,cabang,tipe,status,jenis,pendapatan,customer,nomor}
                    },
                    "columns": [
                    { "data": "nomor" },
                    { "data": "tanggal" },
                    { "data": "cus" },
                    { "data": "nama_pengirim" },
                    { "data": "nama_penerima" },
                    { "data": "asal" },
                    { "data": "tujuan" },
                    { "data": "status" },
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
    })


      
 
</script>