@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Laporan Neraca</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                   <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with- ">
                    <form method="get">
                    <!-- {!! Form::open(['url' => 'neraca/cari', 'method' => 'GET', 'id' => 'form-pencarian']) !!} -->
                    <div class="form-group form-inline col-md-9">
                        <div class="col-md-2">
                            <label for="exampleInputName2" style="padding-top: 7px;">Cari Tanggal</label>
                        </div> 
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control date col-md-5  s_date" style="width: 100%" id="exampleInputName2"  placeholder="Tanggal Pembelian">

                                <span data-toggle="tooltip" data-placement="bottom" title="Tidak Boleh Kosong" class="input-group-addon tool err_info" id="p_date_info">
                                    <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong>
                                </span>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-flat btn-primary">
                                <span class="fa fa-search"></span>
                            </button> 
                            <a href="{{url('keuangan/neraca')}}"class="btn btn-flat btn-default">
                                <span class="fa fa-repeat"></span>
                            </a> 
                        </div>
                    </div>
                    </form>
                    <!-- {!! Form::close() !!} -->

                </div>
                <!-- /.box-header -->
                <div class="box-body "> 

                    <div class="col-md-6" >

                        <div class="col-md-12" style="">
                            <h3>Aset</h3>
                             <table id="comp_trans" class="table table-bordered" >
                    <thead>
                        <tr>                  
                            <th style="background: #2962FF; color: white; width: 10%;">Kode</th>
                            <th style="background: #2962FF; color: white;">Nama Akun</th>
                            <th class="text-right" style="background: #2962FF; color: white;">Nilai</th>
                            <th class="text-right" style="background: #2962FF; color: white; width:40px">Presentase</th>
                        </tr>
                    </thead>                            
                    <tbody>
                        
                        <tr>
                            <td>1</td>                        
                            <td>canasta</td>                                        
                            <td class="text-right">14</td>    
                            
                            <td class="text-right">0 %</td>
                            
                        </tr>                                
                       
                    </tbody>                              
                </table>
                        </div>                         
                    </div>
                    <div class="col-md-6" style="padding-left: 0px;">
                        <div class="col-md-12" style="">    
                            <h3>Kewajiban</h3>
                             <table id="comp_trans" class="table table-bordered" >
                    <thead>
                        <tr>                  
                            <th style="background: #E53935; color: white;width: 10%;">Kode</th>
                            <th style="background: #E53935; color: white;">Nama Akun</th>
                            <th class="text-right" style="background: #E53935; color: white;">Nilai</th>
                            <th class="text-right" style="background: #E53935; color: white; width:40px">Presentase</th>
                        </tr>
                    </thead>  

                    <tbody>

                        
                        <tr>
                            <td>1</td>                        
                            <td></td>
                            <td class="text-right"></td>       
                            
                            <td class="text-right">0 %</td>
                                                     
                        </tr>
                       
                    </tbody>
                </table>
                            
                        </div>
                        <div class="col-md-12" >    
                            <h3>Modal</h3>
                             <table id="comp_trans" class="table table-bordered" >
                    <thead>
                        <tr>                  
                            <th style="background: #E64A19; color: white;width: 10;">Kode</th>
                            <th style="background: #E64A19; color: white;">Nama Akun</th>
                            <th class="text-right" style="background: #E64A19; color: white;">Nilai</th>
                            <th class="text-right" style="background: #E64A19; color: white; width:40px">Presentase</th>
                        </tr>
                    </thead>                                         
                    <tbody>

                    
                        <tr>
                         <tr>
                            <td>1</td>                        
                            <td></td>
                            <td class="text-right"></td>       
                            
                            <td class="text-right">0 %</td>
                                                     
                        </tr>
                    </tbody>
                </table>
                        </div>                        
                    </div>
                    <div class="col-md-12" style="">
                        <div class="col-md-6" style="">
                            <table class="table table-ed table-hover text" >
                                <tr style="font-weight:bold; border-top: solid 2px #999999; background: #cfd8dc">
                                    <td>
                                        Total
                                    </td>            
                                    <td class="text-right">0</td> 
                                </tr>
                            </table>  
                        </div>
                        <div class="col-md-6" style="">
                            <table class="table table-ed table-hover text" >
                                <tr style="font-weight:bold; border-top: solid 2px #999999; background: #cfd8dc">
                                    <td>
                                        Total
                                    </td>                                    
                                    <td class="text-right">0</td>                                                                    
                                </tr>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
    
    @endsection