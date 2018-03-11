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
                                        <tr>
                                            <td style="width:120px; padding-top: 0.4cm">Nomor Surat Jalan</td>
                                            <td>
                                                <SELECT class="form-control a chosen-select-width" name="u_nsj" id="nomor">
                                                    <option selected="" disabled="" value="">--Pilih Nomor--</option>
                                                    @foreach($data as $a)
                                                    <option value="{{$a->nomor}}">{{$a->nomor}}</option>
                                                    @endforeach
                                                </SELECT>
                                               {{--  <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }} " id="ed_token" > --}}
                                                @if($errors->has('u_o_nomor'))
                                                    <small style="color: #ed5565">{{ $errors->first('u_o_nomor')}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Status Pengiriman</td>
                                            <td>
                                                <Select class="form-control b" name="u_pe" >
                                                    <option value="" disabled=""  selected="">--Pilih Status Pengiriman--</option>
                                                    <option value="MANIFESTED">MANIFESTED</option>
                                                    <option value="TRANSIT">TRANSIT</option>
                                                    <option value="RECEIVED">RECEIVED</option>
                                                    <option value="DELIVERED">DELIVERED</option>
                                                </Select>
                                                @if($errors->has('Status'))
                                                    <small style="color: #ed5565">{{ $errors->first('Status')}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                         <tr>
                                            <td style="padding-top: 0.4cm">Catatan Admin</td>
                                            <td>
                                                <textarea class="form-control c"  value="{{old('catatan')}}" name="u_ca"></textarea>
                                                @if($errors->has('catatan'))
                                                    <small style="color: #ed5565">{{ $errors->first('catatan')}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </form>
                            <form class="" id="storing2">
                                <input type="hidden" name="a1" id="a1" class="a1">
                                <input type="hidden" name="a2" id="a2" class="a2">
                                <input type="hidden" name="a3" id="a3" class="a3">
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
                url: baseUrl + '/updatestatus/data1/'+b,
                type: 'get',
                timeout: 10000,
                dataType: 'json',
                success: function (response) {
                      for (var i=0; i<response.data.length; i++) {
                       asw[i]=response.data[i]['nomor_do'];
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
        url: baseUrl+'/updatestatus/store1',
        type:'get',
        data:data,
         success:function(response){
           window.location = "/jpm/sales/deliveryordercabangtracking"
         }

      })
}
 $('.a').change(function() {
    $('.a1').val($(this).val());
});
  $('.b').change(function() {
    $('.a2').val($(this).val());
});

</script>
@endsection
