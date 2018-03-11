@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Update Status Order
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="storing">
                        <div class="box-body">

                                <table class="table table-striped table-bordered table-hover ">
                                    <tbody>
                                            <td>Nomor DO</td>
                                            <td>
                                               {{--  <select class="form-control a chosen-select-width" name="nodo" id="nomor" onkeyup="cari()">
                                                    <option selected="" disabled="">--Pilih Nomor DO--</option>
                                                    @foreach($nodo as $nodo)
                                                    <option value="{{$nodo->nomor}}">{{$nodo->nomor}}</option>
                                                    @endforeach
                                                </select> --}}
                                            <input type="hidden" id="nodo" name="nodo" class="form-control tujuan"/>
                                            <input type="text" id="nomor" name="nodo"  class="form-control" placeholder="Masukkan no DO"/>
                                            </td>

                                        <tr>
                                            <td style="padding-top: 0.4cm">Status Pengiriman</td>
                                            <td>
                                                <Select class="form-control b" name="statuspenerima" >
                                                    <option value="" disabled=""  selected="">--Pilih Status Pengiriman--</option>
                                                    <option value="MANIFESTED">MANIFESTED</option>
                                                    <option value="TRANSIT">TRANSIT</option>
                                                    <option value="RECEIVED">RECEIVED</option>
                                                    <option value="DELIVERED">DELIVERED</option>
                                                     <option value="DELIVERED OK">DELIVERED OK </option>
                                                </Select>
                                                @if($errors->has('Status'))
                                                    <small style="color: #ed5565">{{ $errors->first('Status')}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                         <tr>
                                            <td style="padding-top: 0.4cm">Catatan Admin</td>
                                            <td>
                                                <textarea class="form-control"  value="{{old('catatan')}}" name="catatanadmin"></textarea>
                                                @if($errors->has('catatan'))
                                                    <small style="color: #ed5565">{{ $errors->first('catatan')}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Nama Penerima</td>
                                                <td>
                                                    <input type="text" name="namapenerima" class="form-control" value="{{old('catatan')}}">
                                            </td>
                                        </tr>
                                          <tr>
                                            <td style="width:120px; padding-top: 0.4cm">ID Penerima</td>
                                            <td>
                                                <input type="number" name="idpenerima" class="form-control" id="ed_id" >
                                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }} " id="ed_token" >
                                                @if($errors->has('u_o_nomor'))
                                                    <small style="color: #ed5565">{{ $errors->first('u_o_nomor')}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </form>
                             <form class="" id="storing2">
                                <input type="hidden" name="a1" id="a1" class="a1">
                                <input type="hidden" name="a2" id="a2" class="a2">
                            </form>
                    <div class="row">
                    <div class="col-sm-offset-5 ">
                            <button type="button" class="btn btn-primary fa fa-check" id="btnsave" onclick="gege()"> Update Status</button>
                            <a href="{{url('updatestatus')}}" class="btn btn-danger fa fa-minus">&nbsp; Cancel</a>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
       </form>
   </div>
</div>
</div>


<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

var asw = [];
$(document).ready(function() {
     var a =$("#nomor").change(function(){
     var b =$(this).val();
        console.log(b);
          $.ajax({
                url: baseUrl + '/updatestatus/data2/'+b,
                type: 'get',
                timeout: 10000,
                dataType: 'json',
                success: function (response) {
                      for (var i=0; i<response.data.length; i++) {
                       asw[i]=response.data[i]['nomor'];
                     }
                }
});
});
});
function gege(){
    var a=$('#storing').serializeArray();
    var b=$('#storing2').serializeArray();
    var data = {asw:asw,a:a,b:b};
  $.ajax({
        url: baseUrl+'/updatestatus/store2',
        type:'get',
        data:data,
         success:function(response){
          window.location = "/jpm/sales/deliveryordercabangtracking"
         }
      })
}
 $('#nomor').change(function() {
    $('.a1').val($(this).val());
});
  $('.b').change(function() {
    $('.a2').val($(this).val());
});
    $('.a').bind('keyup',function(){
        console.log('as')
    });

  $("#nomor").autocomplete({
        source: baseUrl+'/updatestatus/up2/autocomplete',
        minLength: 1,
        select: function(event, ui) {
        $('#nodo').val(ui.item.id);
        $('#nomor').val(ui.item.label);

    }
});

</script>
@endsection
