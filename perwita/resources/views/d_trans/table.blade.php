<table class="table" id="tbl-master-transaksi">
  <thead>
    <th>No</th>
    <th>Nama Transaksi</th>
    <th>Provinsi / Kota</th>
    <th>Nama Akun</th>
    <th>Debit/kredit</th>
    <th>Aksi</th>

    
  </thead>
  <tbody>
    @foreach($d_trans as $index => $data)
    @php
      $detail=[];
      $detail=$data->detail($data->tr_code,$data->tr_year);
    @endphp
    <tr>  
      <td>      
      {{$index+1}}
      </td>      
      <td>
      {{$data->tr_name}}
      </td>  
      <td>
        @if(count($data->provinsi)!=null || count($data->kota)!=null)
        {{$data->provinsi}} / {{$data->kota}}
        @endif
      </td>
      <td>
      @foreach ($detail as $key => $value)  
          {{$value->nama_akun}} <br>
      @endforeach
      </td>
      <td>
      @foreach ($detail as $key => $value)  
        @if($value->trdt_accstatusdk=='D')
          Debit <br>
        @elseif($value->trdt_accstatusdk=='K')
          Kredit <br>
        @endif
      @endforeach
      </td>
    <td class="text-center">
      <button data-toggle="tooltip" data-placement="top" title="" class="btn btn-xs btn-warning" data-original-title="Edit Akun Aktiva Lancar" onClick="edit({{$data->tr_year}},{{$data->tr_code}})"><i class="fa fa-pencil-square"></i>
      </button>
      <button data-toggle="tooltip" data-placement="top" title="" class="btn btn-xs btn-danger" data-original-title="Hapus Akun Aktiva Lancar" onClick="hapusTable({{$data->tr_year}},{{$data->tr_code}})"><i class="fa fa-eraser"></i>
      </button>
    </td>
  </tr>
  @endforeach
  </tbody>
  
</table>



<script type="text/javascript">
  function edit($year,$code){    
    $.ajax(baseUrl+"/master-transaksi/form", {
           timeout: 5000,
           type: "get",
           data: {year:$year,
                  code:$code,
                  _token: "{{ csrf_token() }}",
                  status:2},           
           success: function (data) {
              $('#form-master-transaksi').html(data);
              $("#modal_tambah_akun").modal('show');
           
           }
        });

  }
 tableDetail = $('#tbl-master-transaksi').DataTable({
          responsive: true,
          searching: true,
          sorting: true,
          paging: true,
          "pageLength": 10,
          "language": dataTableLanguage,
    });

</script>
