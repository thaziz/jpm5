
@if($kontrak == 1)
<table class="table table-bordered table-striped tabel_tarif">
    <thead>
        <tr>
            <th>No Tarif</th>
            <th>Asal Tarif</th>
            <th>Tujuan Tarif</th>
            <th>Jenis Tarif</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        <tr></tr>
        @endforeach
    </tbody>
</table>
@else
<table class="table table-bordered table-striped tabel_tarif">
    <thead>
        <tr>
            <th>No Tarif</th>
            <th>Asal Tarif</th>
            <th>Tujuan Tarif</th>
            <th>Jenis Tarif</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        <tr></tr>
        @endforeach
    </tbody>
</table>
@endif
<script type="text/javascript">
    $('.tabel_tarif').DataTable();
</script>