
@if($status==1)

                        <table class="table table_form simpan-form-table" id="tambah-master">
                          <td width="30%">Nama Transaksi</td>
                          <td width="70%"><input type="text" value="" name="nama_transaksi" class="form-control input-sm"></td>
                          <tr>
                            <td>Provinsi</td>
                            <td>
                              <select class="form-control" id="id_provinsi" name="provinsi" onclick="kota()">
                                <option  value=0 hidden="" selected>-- Pilih Provinsi --</option>                                
                                <option>-</option>
                                @foreach($provinsi as $data)
                                  <option value="{{$data->id}}">{{$data->nama}}</option>
                                @endforeach
                              </select>                              
                            </td>
                          </tr>
                          <tr>
                            <td>Kota</td>
                            <td id="select-kota">
                              <select class="form-control" name="kota">
                                <option value=0 hidden="" selected>-- Pilih Kota --</option>   
                                <option>-</option>                             
                              </select>                              
                            </td>
                          </tr>
                       
                         
                          
                        </table>

                        <strong>Akun Debet</strong> 
                            <button class="btn btn-primary btn-xs" onclick="akunDebet()">
                            <i class="fa fa-plus"></i>
                            </button>
                        <table class="table simpan-form-table" id="table-debet">
                          <tr>
                          </tr>
                          <tr class="debet-0">
                            <td width="30%">Pilih Akun</td>
                            <td width="70%">                            
                              <select class="form-control" name="akun_debet[]">
                                <option value="" hidden="" selected>-- Pilih Akun Debet --</option>
                                @foreach($akun as $data)
                                <option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>
                                @endforeach
                              </select>                  
                            </td>  
                            <td>                              
                              <div style="margin-top: 8%">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger" data-original-title="Hapus Akun" onclick="hapusDebet('0')"><i class="fa fa-minus"></i></button>
                              </div>
                            </td>                     
                          </tr>                                                   
                        </table>
                           
                          
                          <strong>Akun Kredit</strong> 
                          <button class="btn btn-primary btn-xs" onclick="akunKredit()">
                            <i class="fa fa-plus"></i>
                          </button>

                          <table  class="table simpan-form-table" id="table-kredit">  
                          <tr>                              
                          </tr>                                                                           
                           <tr class="kredit-0">
                            <td width="30%">Pilih Akun</td>
                            <td width="70%">                            
                              <select class="form-control" name="akun_kredit[]">
                                <option value="" hidden="" selected>-- Pilih Akun Kredit --</option>
                                @foreach($akun as $data)
                                <option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>
                                @endforeach
                              </select>                  
                            </td>  
                            <td>                              
                              <div style="margin-top: 8%">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger" data-original-title="Hapus Akun" onclick="hapusKredit('0')"><i class="fa fa-minus"></i></button>
                              </div>
                            </td>                     
                          </tr>  

                        </table>                      
                      <div class="modal-footer no-padding">
    <div class="col-md-7 no-padding">
      <small class="" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>

    <input type="submit" class="btn btn-sm btn-danger" id="btn-tutup" value="Tutup" onclick="Tutup()">
    <input type="submit" class="btn btn-sm btn-primary" id="btn_simpan" value="Simpan Data" onclick="simpanTable()">





<script type="text/javascript">
  var row_index_debet=1;
var row_index_kredit=1;
  function akunDebet(){
     row_index_debet;
$html='<tr class="debet-'+row_index_debet+'">'+
        '<td width="30%">Pilih Akun</td>'+
        '<td width="70%">'+        
        '<select class="form-control" name="akun_debet[]">'+
        '<option value="" hidden="" selected>-- Pilih Akun Debet --</option>'+
                                @foreach($akun as $data)
                                '<option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>'+
                                @endforeach
                              '</select>'+
        '</td>'+
        '<td>'+
        '<div style="margin-top: 8%">'+
        '<button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger"'+
        'data-original-title="Hapus Akun" onclick="hapusDebet('+row_index_debet+')"><i class="fa fa-minus"></i></button>'+
        '</div>'+
        '</td>'+
        '</tr>';
        $('#table-debet tr:last').after($html);
        row_index_debet++;
}

function akunKredit(){
     row_index_kredit;
$html='<tr class="kredit-'+row_index_kredit+'">'+
        '<td width="30%">Pilih Akun</td>'+
        '<td width="70%">'+        
        '<select class="form-control" name="akun_kredit[]">'+
        '<option value="" hidden="" selected>-- Pilih Akun Kredit --</option>'+
                                @foreach($akun as $data)
                                '<option value="{{$data->id_akun}}|{{$data->akun_dka}}">{{$data->nama_akun}}</option>'+
                                @endforeach
                              '</select>'+
        '</td>'+
        '<td>'+
        '<div style="margin-top: 8%">'+
        '<button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger"'+
        'data-original-title="Hapus Akun" onclick="hapusKredit('+row_index_kredit+')"><i class="fa fa-minus"></i></button>'+
        '</div>'+
        '</td>'+
        '</tr>';
        $('#table-kredit tr:last').after($html);
        row_index_kredit++;
}

function hapusDebet(row_index){  
  $('.debet-'+row_index).remove();
}

function hapusKredit(row_index){  
  $('.kredit-'+row_index).remove();
}
</script>


@elseif($status==2)


                        <table class="table table_form simpan-form-table" id="tambah-master">
                          <td width="30%">Namall Transaksi</td>
                          <td width="70%">
                            <input type="hidden" name="year" value="{{$d_trans->tr_year}}">
                            <input type="hidden" name="code" value="{{$d_trans->tr_code}}">
                            <input type="text" name="nama_transaksi" class="form-control input-sm" value="{{$d_trans->tr_name}}">
                          </td>
                          <tr>
                            <td>Provinsi</td>
                            <td>
                              <select class="form-control" id="id_provinsi" name="provinsi" onclick="kota()">
                                <option @if(count($d_trans->tr_provinsi)==0) selected @endif value=0 hidden="" >-- Pilih Provinsi --</option>   
                                <option value=0 >-</option>                                
                                @foreach($provinsi as $data)
                                  <option @if($d_trans->tr_provinsi==$data->id) selected="" @endif value="{{$data->id}}">{{$data->nama}}</option>
                                @endforeach
                              </select>                              
                            </td>
                          </tr>
                          <tr>
                            <td>Kota</td>
                            <td id="select-kota">
                              <select class="form-control" name="kota">
                                <option  @if(count($d_trans->tr_kota)==0) selected @endif value=0 hidden="" selected>-- Pilih Kota --</option>   
                                <option value=0 >-</option>                             
                                @foreach($kota as $data)
                                  <option @if($d_trans->tr_kota==$data->id) selected="" @endif value="{{$data->id}}">{{$data->nama}}</option>
                                @endforeach
                              </select>                              
                            </td>
                          </tr>
                       
                         
                          
                        </table>

                        <strong>Akun Debet</strong> 
                            <button class="btn btn-primary btn-xs" onclick="akunDebet()">
                            <i class="fa fa-plus"></i>
                            </button>
                        <table class="table simpan-form-table" id="table-debet">
                          <tr>
                          </tr>
                          @foreach($d_trans_dt as $index => $dataDetail)
                          @if($dataDetail->trdt_accstatusdk=='D')
                          <tr class="debet-{{$index}}">
                            <td width="30%">Pilih Akun</td>
                            <td width="70%">                            
                              <select class="form-control" name="akun_debet[]">                                
                                @foreach($akun as $data)
                                <option @if($dataDetail->trdt_acc==$data->id_akun) selected="" @endif value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>
                                @endforeach
                              </select>                  
                            </td>  
                            <td>                              
                              <div style="margin-top: 8%">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger" data-original-title="Hapus Akun" onclick="hapusDebet({{$index}})"><i class="fa fa-minus"></i></button>
                              </div>
                            </td>                     
                          </tr>  
                          @endif
                          @endforeach                                                
                        </table>
                           
                          
                          <strong>Akun Kredit</strong> 
                          <button class="btn btn-primary btn-xs" onclick="akunKredit()">
                            <i class="fa fa-plus"></i>
                          </button>

                          <table  class="table simpan-form-table" id="table-kredit">  
                          <tr>                              
                          </tr>  
                          @foreach($d_trans_dt as $index => $dataDetail)
                            @if($dataDetail->trdt_accstatusdk=='K')                                                                         
                           <tr class="kredit-{{$index}}">
                            <td width="30%">Pilih Akun</td>
                            <td width="70%">                            
                              <select class="form-control" name="akun_kredit[]">
                                <option value="" hidden="" selected>-- Pilih Akun Kredit --</option>
                                @foreach($akun as $data)
                                <option @if($dataDetail->trdt_acc==$data->id_akun) selected="" @endif value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>
                                @endforeach
                              </select>                  
                            </td>  
                            <td>                              
                              <div style="margin-top: 8%">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger" data-original-title="Hapus Akun" onclick="hapusKredit({{$index}})"><i class="fa fa-minus"></i></button>
                              </div>
                            </td>                     
                          </tr>  
                          @endif
                          @endforeach
                        </table>                      
                      <div class="modal-footer">
    <div class="col-md-8">
      <small class="pull-right" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>
        <input type="submit" class="btn btn-sm btn-danger" id="btn-tutup" value="Tutup" onclick="Tutup()">
        <input type="submit" class="btn btn-sm btn-primary" id="btn_simpan" value="Simpan Data" onclick="updateTable()">
                      </div>





<script type="text/javascript">
  var row_index_debet={{count($d_trans_dt)}};
  var row_index_kredit={{count($d_trans_dt)}};
  function akunDebet(){
     row_index_debet;     
$html='<tr class="debet-'+row_index_debet+'">'+
        '<td width="30%">Pilih Akun</td>'+
        '<td width="70%">'+        
        '<select class="form-control" name="akun_debet[]">'+
        '<option value="" hidden="" selected>-- Pilih Akun Debet --</option>'+
                                @foreach($akun as $data)
                                '<option value="{{$data->id_akun}}|{{$data->dk}}">{{$data->nama_akun}}</option>'+
                                @endforeach
                              '</select>'+
        '</td>'+
        '<td>'+
        '<div style="margin-top: 8%">'+
        '<button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger"'+
        'data-original-title="Hapus Akun" onclick="hapusDebet('+row_index_debet+')"><i class="fa fa-minus"></i></button>'+
        '</div>'+
        '</td>'+
        '</tr>';
        $('#table-debet tr:last').after($html);
        row_index_debet++;
}

function akunKredit(){
     row_index_kredit;
     alert(row_index_kredit);
$html='<tr class="kredit-'+row_index_kredit+'">'+
        '<td width="30%">Pilih Akun</td>'+
        '<td width="70%">'+        
        '<select class="form-control" name="akun_kredit[]">'+
        '<option value="" hidden="" selected>-- Pilih Akun Kredit --</option>'+
                                @foreach($akun as $data)
                                '<option value="{{$data->id_akun}}|{{$data->akun_dka}}">{{$data->nama_akun}}</option>'+
                                @endforeach
                              '</select>'+
        '</td>'+
        '<td>'+
        '<div style="margin-top: 8%">'+
        '<button data-toggle="tooltip" data-placement="top" title="Hapus Akun" class="btn btn-xs btn-danger"'+
        'data-original-title="Hapus Akun" onclick="hapusKredit('+row_index_kredit+')"><i class="fa fa-minus"></i></button>'+
        '</div>'+
        '</td>'+
        '</tr>';
        $('#table-kredit tr:last').after($html);
        row_index_kredit++;
}

function hapusDebet(row_index){  
  $('.debet-'+row_index).remove();
}

function hapusKredit(row_index){  
  $('.kredit-'+row_index).remove();
}
</script>

@endif

