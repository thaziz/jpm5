@if(count($jurnal_dt)!=0)
 <div id="jurnal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content no-padding">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Laporan Jurnal</h5>
                        <h4 class="modal-title">No Invoice:  <u>{{ $nomor or null }}</u> </h4>
                        
                      </div>
                      <div class="modal-body" style="padding: 15px 20px 15px 20px">                            
                                <table id="table_jurnal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode Akun</th>
                                            <th>Akun</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                             $totalDebit=0;
                                             $totalKredit=0;
                                        @endphp
                                        @foreach($jurnal_dt as $value)
                                            <tr>
                                                <td>{{$value->id_akun}}</td>
                                                <td>{{$value->nama_akun}}</td>
                                                <td> @if($value->dk=='D') 
                                                        @php
                                                        $totalDebit+=round(abs($value->jrdt_value));
                                                        @endphp
                                                        {{number_format(abs($value->jrdt_value),0,',','.')}} 
                                                    @endif
                                                </td>
                                                <td>@if($value->dk=='K') 
                                                    @php
                                                        $totalKredit+=round(abs($value->jrdt_value));
                                                    @endphp
                                                    {{number_format(abs($value->jrdt_value),0,',','.')}}
                                                     @endif
                                                </td>
                                            <tr> 
                                        @endforeach                                           
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                                <th colspan="2">Total</th>                                                
                                                <th>{{number_format($totalDebit,2,',','.')}}</th>
                                                <th>{{number_format($totalKredit,2,',','.')}}</th>
                                        <tr>
                                    </tfoot>
                                </table>                            
                          </div>                          
                    </div>
                  </div>
                </div>
@endif

