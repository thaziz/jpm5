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
        var cabang      = '{{$cabang}}';
        var customer    = '{{$customer}}';
        var id          = '{{$id}}';
        var jenis_tarif = '{{$jenis_tarif}}';
        var array_simpan = [];
        var array_edit = [];
        var array_harga = [];
        @if(isset($array_simpan))
            @foreach($array_simpan as $i=>$val)
            var temp = "{{$array_simpan[$i]}}";
                array_simpan.push(temp);
            @endforeach
        @endif

        @if(isset($array_edit))
            @foreach($array_edit as $i=>$val)
            var temp1 = "{{$array_edit[$i]}}";
                array_edit.push(temp1);
            @endforeach
        @endif


        @if(isset($array_harga))
            @foreach($array_harga as $i=>$val)
            var temp2 = "{{$array_harga[$i]}}";
                array_harga.push(temp2);
            @endforeach
        @endif


    var table_invoice = $('#table_data_invoice').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{ route('datatable_detail_invoice') }}',
            data:{cabang,customer,array_simpan,array_edit,array_harga,id,jenis_tarif}
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