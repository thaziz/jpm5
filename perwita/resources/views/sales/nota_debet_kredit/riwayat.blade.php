<div class="col-md-12">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-rk1"> Riwayat Pembayaran</a></li>
            <li class=""><a data-toggle="tab" href="#tab-cn1">Riwayat CN/DN</a></li>
        </ul>
        <div class="tab-content ">
            <div id="tab-rk1" class="tab-pane active">
                <div class="panel-body riwayat_kwitansi">
                    <table class="table riwayat_cd table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor CN/DN</th>
                            <th>Tanggal</th>
                            <th>Jml Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cd as $val)
                            <tr>
                                <td>{{$val->cd_nomor}}</td>
                                <td>{{$val->cd_tanggal}}</td>
                                <td align="right">{{number_format($val->cdd_dpp_akhir+$val->cdd_ppn_akhir-$val->cdd_pph_akhir, 2, ",", ".")}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div id="tab-cn1" class="tab-pane">
                <div class="panel-body riwayat_cn_dn">
                    <table id="table_cn_dn" class="table tabel_kwitansi table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Kwitansi</th>
                                <th>Tanggal</th>
                                <th>Jml Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($kwitansi as $val)
                                <tr>
                                    <td>{{$val->k_nomor}}</td>
                                    <td>{{$val->k_tanggal}}</td>
                                    <td>{{number_format($val->kd_total_bayar, 2, ",", ".")}}</td>
                                </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.riwayat_cd').DataTable();
    $('.tabel_kwitansi').DataTable();
</script>