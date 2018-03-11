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
                       
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                 @foreach($data as $sup)
                  <form method="post" action="{{url('mastersupplier/updatesupplier/'.$sup->no_supplier .'')}}"  enctype="multipart/form-data" class="form-horizontal">

                  
                  <div class="box-body">
                       <div class="row">
                          <div class="col-xs-6">

                          <table border="0">

                         

                          <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                          <tr>
                            <td width="100px">
                            Nama Supplier
                            </td>
                            <td>
                               <input type="text" class="form-control" name="nama_supplier" value="{{$sup->nama_supplier}}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>    Alamat </td>
                            <td>
                              <input type="text" class="form-control" name="alamat" value="{{$sup->alamat}}">
                            </td>
                          </tr>
                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                         

                         

                          <tr>
                            <td>
                              Provinsi
                            </td>
                            <td>
                              <input type="text" class="form-control" name="provinsi" value="{{$sup->propinsi}}">
                            </td>
                          </tr>

                          

                          <tr>
                            <td>
                            &nbsp;
                            </td>
                          </tr>

                           <tr>
                            <td> Kota </td>
                            <td>
                                 <input type="text" class="form-control" name="kota" value="{{$sup->kota}}">
                            </td>
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>
                              Kode Pos
                            </td>
                            <td>
                              <input type="text" class="form-control" name="kodepos" value="{{$sup->kodepos}}">
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>
                              No Telp / Fax
                            </td>
                            <td>
                               <input type="text" class="form-control" name="notelp" value="{{$sup->telp}}">
                            </td>
                          </tr>

                          </table>
                          
                         </div>

                         <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="100px">
                              Contact Person
                            </td>
                            <td>
                               <input type="number" class="form-control" name="cp" value="{{$sup->contact_person}}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>   Syarat Kredit  </td>
                            <td>
                               <input type="text" class="form-control" name="syarat_kredit" value="{{$sup->syarat_kredit}}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Plafon Kredit </td>
                             <td>
                               <input type="text" class="form-control" name="plafon_kredit" value="{{$sup->plafon}}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Mata Uang </td>
                            <td>
                                  <input type="text" class="form-control" name="currency" value="{{$sup->currency}}">
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td> NO NPWP </td>
                            <td>
                                <input type="text" class="form-control" name="no_npwp" value="{{$sup->pajak_npwp}}">
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>
                              Acc Hutang Dagang
                            </td>
                            <td> <input type="text" class="form-control"> </td>
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
                                 <input type="text" class="form-control" name="noseri_pajak" value="{{$sup->noseri_pajak}}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                         
                           <tr>
                           



                            <?php
                              if(isset($sup->ppn)) {
                                echo " <td>   <input id='checkbox1' type='checkbox' checked name='ppn'>
                                <label for='checkbox1' >
                                PPn Masukan
                                </label> </td>";
                              }

                              else {
                                 echo " <td>   <input id='checkbox1' type='checkbox' name='ppn'>
                                <label for='checkbox1' >
                                PPn Masukan
                                </label> </td>";
                              }

                              echo "</tr>";

                              echo "<tr>";
                              if(isset($sup->pph23)) {
                                 echo " <td>   <input id='checkbox1' type='checkbox' name='pajak_pph' checked>
                                <label for='checkbox1'>
                                PPh Pasal 23
                                </label> </td>";
                              }
                              else {
                                 echo " <td>   <input id='checkbox1' type='checkbox' name='pajak_pph'>
                                <label for='checkbox1' >
                                PPh Pasal 23
                                </label> </td>";
                              }
                              echo "</tr>";

                              echo "<tr>";

                             if(isset($sup->pph26))
                              {
                                  echo " <td>   <input id='checkbox1' type='checkbox' name='pajak_pph' checked>
                                <label for='checkbox1'>
                                PPh Pasal 26
                                </label> </td>";
                              }
                              else {
                                 echo " <td>   <input id='checkbox1' type='checkbox' checked>
                                <label for='checkbox1' >
                                PPh Pasal 26
                                </label> </td>";
                              }
                              echo "</tr>";
                            ?>
                            </tr>
                          </table>
                     @endforeach
                         </div>


                    </div>
                  

                   
             
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
                <div class="box-footer">
                  <div class="pull-right">
                        <a class="btn btn-warning" href={{url('mastersupplier/mastersupplier')}}> Kembali </a>
                         <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
                    
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
