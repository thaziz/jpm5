<table id="table_data_invoice" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="text-align: center;">Nomor Invoice</th>
            <th style="text-align: center;">Tanggal</th>
            <th style="text-align: center;">Jml Tagihan</th>
            <th style="text-align: center;">Sisa Tagihan</th>
            <th style="text-align: center;">Aksi</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var cabang   = '{{$cabang}}';
        var customer = '{{$customer}}';
        var array_simpan = [];
        @if(isset($array_simpan))
            @foreach($array_simpan as $i=>$val)
            var temp = "{{$array_simpan[$i]}}";
                array_simpan.push(temp);
            @endforeach
        @endif
        console.log(array_simpan);
    $('#table_data_invoice').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{ route('datatable_detail_invoice') }}',
            data:{cabang,customer,array_simpan}
        },
        columnDefs: [
          {
             targets: 0 ,
             className: 'center'
          },
          {
             targets: 4,
             className: 'center'
          },
          {
             targets: 2,
             className: 'right'
          },
          {
             targets: 3,
             className: 'right'
          }
       ],
        columns: [
            {data: 'nomor', name: 'nomor'},
            {data: 'i_tanggal', name: 'i_tanggal'},
            {data: 'i_tagihan', name: 'i_tagihan'},
            {data: 'i_sisa', name: 'i_sisa'},
            {data: 'tes', name: 'tes'}
        ]
    });
});
</script>