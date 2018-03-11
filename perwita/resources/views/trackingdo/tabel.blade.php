<br>
<br>
<br>
     <div class="box-body">
                    <table id="example" class="table table-bordered table-striped gege " cellspacing="10">
                        <thead>
                            <tr>
                                <th  hidden="">nomor</th>
                                <th>Nomor Pengiriman</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Kota Asal</th>
                                <th>Kota Tujuan</th>

                            </tr>
                        </thead>

                        <tbody>
                               @foreach($data as $index => $a)
                            <tr>
                                <td  hidden="">{{$index+1}}</td>
                                <td>{{$a->nomor}}</td>
                                <td>{{$a->tanggal}}</td>
                                <td>{{$a->asal}}</td>
                                <td>{{$a->tujuan}}</td>
                            </tr>
                       @endforeach
                        </tbody>

                    </table>
                </div>
                 <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped gege noob " cellspacing="10">
                        <thead>
                            <tr>
                                <th  hidden="">Nomor</th>
                                 <th hidden="">Nomor Pengiriman</th>
                                <th>Pengirim</th>
                                <th>Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $b)
                            <tr>
                                <td hidden=""></td>
                                <td hidden="">{{$b->nomor}}</td>
                                <td> @if ($b->nama_pengirim == null) Data Kosong @else {{$b->nama_pengirim}} @endif </td>
                                <td> @if ($b->nama_penerima == null) Data Kosong @else {{$b->nama_penerima}} @endif </td>
                            </tr>
                            <tr>
                                <td hidden=""></td>
                                <td hidden="">{{$b->nomor}}</td>
                                <td> @if ($b->alamat_pengirim == null) Data Kosong @else {{$b->alamat_pengirim}} @endif </td>
                                <td> @if ($b->alamat_penerima == null) Data Kosong @else {{$b->alamat_penerima}} @endif </td>
                            </tr>
                                <tr>
                                <td  hidden=""></td>
                                <td hidden="">{{$b->nomor}}</td>
                                <td>{{$b->telpon_pengirim}}</td>
                                <td>{{$b->telpon_penerima}}</td>
                            </tr>
                               <tr>
                                <td  hidden=""></td>
                                <td hidden="">{{$b->nomor}}</td>
                                <td>{{$b->asal}}</td>
                                <td>{{$b->tujuan}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                  <div class="box-body">
                    <table id="tabel_data" class="table table-bordered table-striped gege data3" cellspacing="10">
                        <thead>
                            <tr>
                                <th  hidden="">noll</th>
                                <th  hidden="">noll</th>
                                <th>Status Tgl Pengiriman</th>
                                <th>Kota</th>
                                <th>Status Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($data3 as $c)
                            <tr>
                                <td hidden=""></td>
                                <td hidden="">{{$c->nomor_do}}</td>
                                <td>{{$c->created_at}}{{-- {{ \Carbon\Carbon::parse($c->created_at)->format('d F Y')}} --}}</td>
                                <td>Surabaya</td>
                                <td>{{$c->status}}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
<script type="text/javascript">
     $('.gege').DataTable({
      "paging" : false,
    });
</script>