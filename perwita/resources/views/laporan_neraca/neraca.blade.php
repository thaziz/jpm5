@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
  .row-eq-height {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
}

    #table_form input{
      padding-left: 5px;
    }

    #table_form td,
    #table_form th{
      padding:10px 0px;
    }

    .tree td,
    .tree th{
      padding:5px;
      border-bottom: 1px solid #ccc;
      font-weight: 600;
    }

    .tree td.secondTree{
      padding-left: 40px;
    }

    .tree td.{
      color:blue;
    }

    .tree td.highlight{
      border-top:2px solid #aaa;
      border-bottom: 2px solid #aaa;
      color:#222;
    }

    .tree td.break{
      padding: 10px 0px;
      background: #eee;
    }

  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Laporan Neraca </h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Laporan Neraca  </strong>
              </li>

          </ol>
      </div>

      <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
        <table border="0" width="100%" id="table_form">
          <tr>
            <th width="5%" class="text-center">Per : </th>
            <td width="25%">
              {{--<select style="width:35%">
                <option>Hari Ini</option>
                <option>Kemarin</option>
              </select>--}}
              <input type="text" value="{{ date("d/m/Y") }}" style="width:50%">

            </td>

            <th width="12%" class="text-center">Bandingkan Periode : </th>
            <td width="25%">
              <input type="text" value="{{ date("d/m/Y") }}" style="width:40%">

              <input type="text" value="{{ date("d/m/Y") }}" style="width:40%">
            </td>

            <td width="10%">
              <button class="btn btn-success btn-sm">Filter</button>
            </td>
          </tr>
        </table>
      </div>
  </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Menampilkan Neraca Pada Tanggal {{ date("d/m/Y") }}
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Cetak PDF
                        </button>

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-pdf"></i> &nbsp;Cetak Excel
                        </button>
                    </div>
                </div>
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-xs-12">
                      
                      <div class="box" id="seragam_box">
                        <div class="box-header">
                        </div><!-- /.box-header -->
                        <div class="box-body" style="min-height: 330px;">
                          <div class="row-eq-height">
                          <div class="col-md-6">                           
                          <table  border="0" width="100%" class="tree">
                              <tr class="treegrid-ase treegrid-parent">
                              <th colspan="3"><strong>ASET</strong></th>
                            </tr>
                            <tr class="treegrid-aktiva-lancar treegrid-parent-ase">
                              <td colspan="3"><strong>AKTIVA LANCAR</strong></td>
                            </tr>

                            @php
                              $jmlAktivaLancar=0;
                            @endphp
                            @foreach($kas as  $index => $data)          
                              @php
                              $jmlAktivaLancar+=$data->saldo;
                              @endphp                             
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >KAS</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach                          

                             @foreach($bank as  $index => $data)                                       
                                @php
                                  $jmlAktivaLancar+=$data->saldo;
                                @endphp          
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >BANK</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                           @foreach($deposito as  $index => $data)                                       
                              @php
                                  $jmlAktivaLancar+=$data->saldo;
                              @endphp          
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >DEPOSITO</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                          @foreach($piutangUsaha as  $index => $data)                                       
                                @php
                                  $jmlAktivaLancar+=$data->saldo;
                                @endphp          
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >PIUTANG USAHA</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                          @foreach($uangMukaPembelian as  $index => $data)                                       
                              @php
                                  $jmlAktivaLancar+=$data->saldo;
                              @endphp          
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >UANG MUKA PEMBELIAN</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                            @foreach($persediaan as  $index => $data)                                       
                                @php
                                  $jmlAktivaLancar+=$data->saldo;
                                @endphp          
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >PERSEDIAAN</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 
                            <tr>
                              <td colspan="2"><strong>JUMLAH AKTIVA LANCAR</strong></td>
                              <td class="text-right"><strong>{{number_format($jmlAktivaLancar,'2',',','.')}}</strong></td>
                            <tr>
                            <tr><td colspan="3" class="break"></td></tr>

{{--Aktiva Tidak Lancar--}}
                             <tr class="treegrid-aktiva-lancar treegrid-parent-ase">
                              <td colspan="3"><strong>AKTIVA TIDAK LANCAR</strong></td>
                            </tr>
                             @php
                                  $jmlAktivaTdkLancar=0;
                             @endphp   
                            @foreach($aktivaTetap as  $index => $data)  
                                  @php
                                  $jmlAktivaTdkLancar+=$data->saldo;
                                  @endphp                                       
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >AKTIVA TETAP</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach                          
                             @foreach($akmlsiAktivaTetap as  $index => $data) 
                                   @php
                                  $jmlAktivaTdkLancar+=$data->saldo;
                                  @endphp                                       
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td >( - )  AKMLSI AKTIVA TETAP </td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 
                            <tr>
                              <td colspan="2"><strong>JUMLAH AKTIVA TIDAK LANCAR</strong></td>
                              <td class="text-right"><strong>{{number_format($jmlAktivaTdkLancar,'2',',','.')}}</strong></td>
                            <tr>
                            <tr><td colspan="3" class="break"></td></tr>

                           

{{--NILAI BUKU AKTIVA TETAP--}}

                             <tr class="treegrid-aktiva-lancar treegrid-parent-ase">
                              <td colspan="3"><strong>NILAI BUKU AKTIVA TETAP</strong></td>
                            </tr>
                             @php
                                  $jmlNilaiBuku=0;
                             @endphp   
                            
                            @foreach($aktivaLain2 as  $index => $data)   
                                 @php
                                  $jmlNilaiBuku=0;
                             @endphp                                     
                            <tr class="treegrid-k treegrid-parent-aktiva-lancar">                                  
                                  <td>AKTIVA LAIN-2</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalAset[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalAset[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach  
                             <tr>
                              <td colspan="2"><strong>Jumlah NILAI BUKU AKTIVA TETAP</strong></td>
                              <td class="text-right"><strong>{{number_format($jmlNilaiBuku,'2',',','.')}}</strong></td>
                            <tr>
                            <tr><td colspan="3" class="break"></td></tr>                        

                          </table>
                        </div>

                          <div class="col-md-6">
                          <table  border="0" width="100%" class="tree">
                            <tr class="treegrid-kewajiban" >
                              <th colspan="3"><strong>KEWAJIBAN</strong></th>
                            </tr>                            
                            <tr class="treegrid-kewajiban-lancar treegrid-parent-kewajiban">                                  
                              <td colspan="3"><strong>KEWAJIBAN LANCAR</strong></td>
                            </tr>
                                  @php
                                    $kewajibanLancar=0;
                                  @endphp 
                            @foreach($hutangBank as  $index => $data)                                       
                                    @php
                                      $kewajibanLancar+=$data->saldo;
                                    @endphp 
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>HUTANG BANK</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 
                              @foreach($hutangPajak as  $index => $data)                                       
                                    @php
                                      $kewajibanLancar+=$data->saldo;
                                    @endphp 
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>HUTANG PAJAK</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                            @foreach($hutangUsahaDagang as  $index => $data)                                       
                                  @php
                                      $kewajibanLancar+=$data->saldo;
                                  @endphp 
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>HUTANG USAHA/DAGANG</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 
                             @foreach($dana as  $index => $data)                                       
                                  @php
                                      $kewajibanLancar+=$data->saldo;
                                  @endphp 
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>Dana Customer</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                            @foreach($hutangHarusDibayar as  $index => $data)                                       
                                @php
                                      $kewajibanLancar+=$data->saldo;
                                @endphp 
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>HUTANG YG. HARUS DIBAYAR</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                            <tr>
                              <td colspan="2"><strong>JUMLAH KEWAJIBAN LANCAR</strong></td>
                              <td class="text-right"><strong>{{number_format($kewajibanLancar,'2',',','.')}}</strong></td>
                            <tr>
                            <tr><td colspan="3" class="break"></td></tr>   

                            <tr class="treegrid-kewajiban-lancar treegrid-parent-kewajiban">                                  
                                  <td colspan="3"><strong>KEWAJIBAN TIDAK LANCAR</strong></td>
                            </tr>
                               @php
                                      $kewajibanTidakLancar=0;
                                @endphp 
                            @foreach($hutangAfiliasi as  $index => $data)
                                @php
                                      $kewajibanTidakLancar+=$data->saldo;
                                @endphp                                        
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>HUTANG AFILIASI</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                            <tr>
                              <td colspan="2"><strong>JUMLAH KEWAJIBAN TIDAK LANCAR</strong></td>
                              <td class="text-right"><strong>{{number_format($kewajibanTidakLancar,'2',',','.')}}</strong></td>
                            <tr>
                            <tr><td colspan="3" class="break"></td></tr> 



                             <tr class="treegrid-kewajiban-lancar treegrid-parent-kewajiban">                                 
                                  <td colspan="3"><strong>KEWAJIBAN JANGKA PANJANG</strong></td>
                            </tr>
                              @php
                                      $kewajibanJangkaPanjang=0;
                              @endphp                                       
                            @foreach($ekuitas as  $index => $data)  
                              @php
                                      $kewajibanJangkaPanjang+=$data->saldo;
                              @endphp                                        
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>EKUITAS</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 

                             @foreach($labaRugi as  $index => $data)    
                              @php
                                      $kewajibanJangkaPanjang+=$data->saldo;
                              @endphp                                      
                            <tr class="treegrid-k treegrid-parent-kewajiban-lancar">
                                  <td>LABA RUGI</td>
                                  <td class="text-right">{{number_format($data->saldo,2,',','.')}}</td>
                                  <td class="text-right">
                                    @if($totalKM[0]->totalaset==0)
                                      0%
                                     @else
                                    {{ number_format(($data->saldo/$totalKM[0]->totalaset)*100,2,',','.'
                                    )}} %
                                     @endif
                                  </td>                                                              
                            </tr>
                            @endforeach 
                            <tr>
                              <td colspan="2"><strong>Jumlah KEWAJIBAN JANGKA PANJANG</strong></td>
                              <td class="text-right"><strong>{{number_format($kewajibanJangkaPanjang,'2',',','.')}}</strong></td>
                            <tr>
                            <tr><td colspan="3" class="break"></td></tr> 
                            
                          </table>
                          </div>
                          </div>
                          <br>
                        <div class="col-md-6">
                          <table class="table">
                            <tr class="treegrid-total-liabilitas-dan-modal">
                              <td colspan="2" class="highlight"><strong>Total Aset</strong></td>
                              <td class="highlight text-right"><strong>{{number_format($totalAset[0]->totalaset,2,',','.')}}</strong></td>
                            </tr>
                          </table>
                        </div>

                         <div class="col-md-6">
                          <table class="table">
                              <tr class="treegrid-total-liabilitas-dan-modal">
                              <td colspan="2" class="highlight"><strong>Total Kewajiban Dan Modal</strong></td>
                              <td class="highlight text-right"><strong>{{number_format($totalKM[0]->totalaset,2,',','.')}}</strong></td>
                            </tr>
                          </table>
                        </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">
                          <div class="pull-right">  
                            
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

 <!-- modal -->
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Akun</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->



@endsection



@section('extra_scripts')

<script src="{{ asset('assets/vendors/bootstrap-treegrid/js/jquery.treegrid.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function(){
    //$("#tree").DataTable();
    $(".tree").treegrid({
          treeColumn: 0,
          initialState: "expanded",

    });

    $("#tree2").treegrid({
          treeColumn: 0,
          initialState: "expanded",

    });


    $("#tree3").treegrid({
          treeColumn: 0,
          initialState: "expanded",

    });

             $('body').removeClass('fixed-sidebar');
            $("body").toggleClass("mini-navbar");
  })

</script>
@endsection





