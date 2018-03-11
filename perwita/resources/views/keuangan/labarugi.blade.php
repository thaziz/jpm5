@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Laporan LabaRugi</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                	<div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title"></h3> -->
                </div>
                <!-- /.box-header -->
                <div class="box-body "> 
                    <div> 
                        @if (Session::has('flash_message'))
                        <div class="alert alert-danger {{ Session::has('penting') ? 'alert-important' : '' }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ Session::get('flash_message') }}
                        </div>
                        @endif                       
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="col-xs-12">                          
                            <div class="table-responsive">
                                <table id="labarugi" class="table table-bordered table-striped">                                    
                            <thead>
                                <tr>
                                    <th style="">Detail</th>
                                    <th style=" text-align:right;">Nilai</th>
                                    <th style=" text-align:right;">Total</th>                                                                                    
                                    <th style=" text-align:right;">Presentase</th>                                                                                    
                                </tr>   
                            <thead>
                            <tbody class="hasil">
                                <tr>
                                    <th style="">PENDAPATAN/ REVENUE</th>
                                    <th style=""></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr> 

                                <tr>                                            
                                    <td style="padding-left: 30px;">NIVADA</td>
                                    <td style="text-align: right;"></td>                                                                                    
                                    <td style=" text-align:right;"></td>                                        
									
                                    <td style=" text-align:right;">0%</td>                                                                                    
				
                                </tr>                                        
                                

                                <tr>
                                    <th style="padding-left: 50px;">Total Pendapatan</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">0</td>                                                                  
                                    <td style=" text-align:right;"></td> 
                                </tr>

                                <tr>
                                    <th style="">HPP/COGS</th>
                                    <th style=""></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr>
                                
                                <tr>                                            
                                    <td style="padding-left: 30px;">NIVADA</td>
                                    <td style=" text-align:right;">0</td>                                   
                                    <td style=" text-align:right;"></td> 
									
                                    <td style=" text-align:right;">0%</td>    
						
                                </tr>
                                
                                <tr>
                                    <th style="padding-left: 50px;">Total HPP</th>
                                    <th style=""></th>                    
                                    <td style=" text-align:right;">0</td>                                   
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style="padding-left: 50px;">Laba Kotor</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">0</th> 
                                    <td style=" text-align:right;"></td> 


                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style=""> BIAYA / EXPENSES</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                
                                <tr>                                            
                                    <td style="padding-left: 30px;"></td>
                                    <td style=" text-align:right;"></td>                                   
                                    <td style=" text-align:right;"></td>  
									
                                    <td style=" text-align:right;">0%</td>    
									
                                </tr>
                               
                                <tr>
                                    <th style="padding-left: 50px;">Total Biaya</th>
                                    <th style=""></th> 
                                    <td style=" text-align:right;">0</td>                                   
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style=""> DEPRESIASI / DEPRECIACION </th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>                                        
                               
                                <tr>                                            
                                    <td style="padding-left: 30px;"></td>
                                    <td style=" text-align:right;"></td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                                
                                <tr>
                                    <th style="">  AMORTISASI / AMORTIZATION</th>
                                    <th style=""></th> 
                                    <th style="">-</th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                               
                                <tr>                                            
                                    <td style="padding-left: 30px;"></td>
                                    <td style=" text-align:right;"></td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                                
                                <tr>                                                                                        
                                    <th style="">LABA OPERASIONAL / OPERATIONAL PROFIT</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;"></th> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                </tr>
                                <tr>                                            
                                    <th style=""> PENDAPATAN LAIN-LAIN</th>
                                    <th style=""></th> 
                                    <th style=" text-align:right;"></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                               
                                <tr>                                            
                                    <td style="padding-left: 30px;"></td>
                                    <td style=" text-align:right;"></td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                              
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>                                            
                                    <th style=""> PENGELUARAN LAIN-LAIN</th>
                                    <th style=""></th>                                           
                                    <th style=" text-align:right;"></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                               
                                <tr>                                            
                                    <td style="padding-left: 30px;"></td>
                                    <td style=" text-align:right;"></td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                               
                                <tr>
                                    <th style="padding-left: 50px;"> LABA/RUGI LAIN-LAIN</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;"></th> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                <tr>
                                    <th style=""> BUNGA / INTEREST</th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style=""> PAJAK / TAX </th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                
                                <tr>                                            
                                    <td style="padding-left: 30px;"></td>
                                    <td style=" text-align:right;"></td>                                   
                                    <td style=" text-align:right;"></td> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                               
                                <tr>
                                    <th style=""></th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr style=" border-top: 3px solid #cccccc">
                                    <th style="padding-left: 50px;"> NET PROFIT</th>
                                    <th style=""></th>                                             
                                    <td style=" text-align:right;"></th> 
                                    <th style=""></th> 
                                </tr>
                            </tbody>
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
</div>



<div class="row" style="padding-bottom: 50px;"></div>
@endsection