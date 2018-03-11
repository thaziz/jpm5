@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Supplier </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Master Supplier </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Detail Data Master Supplier
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                        <a class="btn btn-danger" href="{{url('konfirmasisupplier/konfirmasisupplier')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                    </div>
                </div>
                @foreach($data['master'] as $sup)
                <form method="post" action="{{url('konfirmasisupplier/updatekonfirmasisupplier/'. $sup->idsup .'')}}"  enctype="multipart/form-data" class="form-horizontal">

                <div class="ibox-content">
                  
                        <div class="row">
            <div class="col-xs-12">
            
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
               

                  
                  <div class="box-body">
                       <div class="row">
                          <div class="col-xs-6">

                          <table border="0" class="table">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">
                          <tr>
                            <td width="200px"> Cabang Pemohon </td>
                            <td width="400px">  <input type="text" class="form-control" name="nama_supplier" value="{{$sup->nama}}" disabled=""> </td>
                          </tr>

                          <tr>
                            <td >
                            Nama Supplier
                            </td>
                            <td>
                               <input type="text" class="form-control" name="nama_supplier" value="{{$sup->nama_supplier}}" disabled="">
                            </td>
                          </tr>

                          <tr>
                            <td>    Alamat </td>
                            <td>
                              <input type="text" class="form-control" name="alamat" value="{{$sup->alamat}}" disabled="">
                            </td>
                          </tr>


                          <tr>
                            <td>
                              Provinsi
                            </td>
                            <td>
                              <input type="text" class="form-control" name="alamat" value="{{$sup->propinsi}}" disabled="">
                            </td>
                          </tr>

                          
                           <tr>
                            <td> Kota </td>
                            <td>
                                 <input type="text" class="form-control" name="alamat" value="{{$sup->kota}}" disabled="">
                            </td>
                            </td>
                          </tr>


                          <tr>
                            <td>
                              Kode Pos
                            </td>
                            <td>
                              <input type="text" class="form-control" name="kodepos" value="{{$sup->kodepos}}" disabled="">
                            </td>
                          </tr>



                          <tr>
                            <td>
                              No Telp / Fax
                            </td>
                            <td>
                               <input type="text" class="form-control" name="kodepos" value="{{$sup->telp}}" disabled="">
                            </td>
                          </tr>

                          </table>
                          
                         </div>

                         <div class="col-xs-6">
                          <table border="0" class="table">
                          <tr>
                            <td width="200px">
                              Contact Person
                            </td>
                            <td>
                               <input type="number" class="form-control" name="cp" value="{{$sup->contact_person}}" disabled="">
                            </td>
                          </tr>

                          <tr>
                            <td>   Syarat Kredit  </td>
                            <td>
                               <input type="text" class="form-control" name="syarat_kredit" value="{{$sup->syarat_kredit}}" disabled="">
                            </td>
                          </tr>

                           <tr>
                            <td> Plafon Kredit </td>
                             <td>
                               <input type="text" class="form-control" name="plafon_kredit" value="{{$sup->plafon}}" disabled="">
                            </td>
                          </tr>


                           <tr>
                            <td> Mata Uang </td>
                            <td>
                                  <input type="text" class="form-control" name="plafon_kredit" value="{{$sup->currency}}" disabled="">
                            </td>
                          </tr>


                          <tr>
                            <td> NO NPWP </td>
                            <td>
                                <input type="text" class="form-control" name="plafon_kredit" value="{{$sup->pajak_npwp}}" disabled="">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Acc Hutang Dagang
                            </td>
                            <td> <input type="text" class="form-control" value="{{$sup->acc_hutang}}" disabled=""> </td>
                          </tr>

                          <tr>
                            <td>
                              Status
                            </td>
                            <td>
                               <input type="text" class="form-control" value="{{$sup->status}}" disabled=""> 
                            </td>
                          </tr>
                          </table>

                         </div>
                         </div>

                         <hr>

                       <b>  Informasi Pajak Supplier </b>

                         <hr>

                          <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="200px">
                               No Seri Pajak Supplier 
                            </td>
                            <td>
                                 <input type="text" class="form-control" name="plafon_kredit" value="{{$sup->noseri_pajak}}" disabled="">
                            </td>
                            <td> &nbsp; </td> <td> &nbsp; </td>

                             <?php
                              if($sup->ppn != '') {
                                echo " <td>   <input id='checkbox1' type='checkbox' checked disabled>
                                <label for='checkbox1' >
                                PPn Masukan
                                </label> </td>";
                              }


                          

                            
                              if($sup->pph23 != '') {
                                 echo " <td>   <input id='checkbox1' type='checkbox' name='pajak_pph' checked disabled>
                                <label for='checkbox1'>
                                PPh Pasal 23
                                </label> </td>";
                              }
                           

                             

                             if($sup->pph26 != '')
                              {
                                  echo " <td>   <input id='checkbox1' type='checkbox' name='pajak_pph' checked disabled>
                                <label for='checkbox1'>
                                PPh Pasal 26
                                </label> </td>";
                              }
                              echo "</tr>";
                            ?>
                          </tr>


                           <tr>
                           
                           
                            </tr>
                          </table>
                  
                         </div>

                         @if($data['item'] != '') 
                         <div class="col-sm-12">
                          <br>

                           <table class="table table-stripped table-border  ">
                              <tr>
                                <th> No </th>
                                <th> Nama Barang </th>
                                <th> Harga </th>
                                <th> Update Stock </th>
                              </tr>
                              @foreach($data['item'] as $index=>$item)
                              <tr>
                                <td> {{$index + 1}} </td>
                                <td> {{$item->nama_masteritem}}</td>
                                <td> Rp {{number_format($item->is_harga, 2)}} </td>
                                <td>{{$item->is_updatestock}} </td>
                              </tr>
                              @endforeach
                           </table>
                         </div>
                         @endif
                    </div>
             
                
                <div class="box-footer">
                  <div class="pull-right">
                    @if($sup->status == 'BELUM DI SETUJUI')
                       <input class="btn btn-success" name="setuju" value="SETUJU" type="submit"> 

                      <input class="btn btn-warning" name="setuju" value="TIDAK SETUJU" type="submit"> 

                    @endif
                     @endforeach
                    </form>
                    </div>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
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
