@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
 
.pad{
  padding: 10px 10px 10px 10px; 
  }



</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Diagram
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                
                <div class="ibox-content" style="min-height: 500px;">
                        <div class="row col-sm-6 col-sm-offset-3" style="margin-top: 100px;">
            


                            <table align="center" class="table  " >
                              <thead>
                                <tr class="pad">
                                  <td><a href="{{ url('diagram_penjualan/diagram_penjualan') }}" class="btn btn-info"><i class="fa fa-search"></i> Penjualan</a></td>
                                  <td><a href="{{ url('diagram_dototal/diagram_dototal') }}" class="btn btn-info"><i class="fa fa-search"></i> Total</a></td>
                                  <td><a href="{{ url('diagram_dopaket/diagram_dopaket') }}" class="btn btn-info"><i class="fa fa-search"></i> Paket</a></td>
                                  <td><a href="{{ url('diagram_dokoran/diagram_dokoran') }}" class="btn btn-info"><i class="fa fa-search"></i> Koran</a></td>
                                  <td><a href="{{ url('diagram_dokargo/diagram_dokargo') }}" class="btn btn-info"><i class="fa fa-search"></i> Kargo</a></td>
                                </tr>
                              </thead>
                            </table>


                        </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
   

</script>
@endsection
