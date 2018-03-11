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

    #tree th{
      padding:5px;
      border: 1px solid #ccc;
      font-weight: 600;
    }

    #tree td.secondTree{
      padding-left: 40px;
    }

    #tree td{
      border: 0px;
      padding: 5px;
    }

    #tree td.{
      color:blue;
    }

    #tree td.highlight{
      border-top:2px solid #aaa;
      border-bottom: 2px solid #aaa;
      color:#222;
    }

    #tree td.break{
      padding: 10px 0px;
      background: #eee;
    }

    #bingkai td.header{
      font-weight: bold;
    }

    #bingkai td.child{
      padding-left: 20px;
    }

    #bingkai td.total{
      border-top: 2px solid #999;
      font-weight: 600;
    }

    #bingkai td.no-border{
      border: 0px;
    }

</style>

<div class="row" style="margin-top: 20px; padding-right: 15px;">
    <div class="col-md-12">                           
      <table id="tree" width="100%">

          <tbody>
            <td style="border: 1px solid #ccc">
              <table width="100%" style="border: 0px solid red; font-size: 8pt;" id="bingkai">
                <tr>
                  <?php $DatatotalAktiva = 0; $totalHeader = 0;?>
                  @foreach($data as $dataAktiva)
                    <?php 
                      $header = ""; $child = ""; $total = ""; 

                      if($dataAktiva["jenis"] == 1){
                        $header = "header"; $totalHeader = 0;
                      }

                      if($dataAktiva["parrent"] != "")
                        $child = "child";

                      if($dataAktiva["jenis"] == 3)
                        $total = "total";
                    ?>


                    @if($dataAktiva["type"] == "aktiva")
                      
                        @if($dataAktiva["jenis"] == "4")
                          <tr><td colspan="2">&nbsp;</td></tr>
                        @else
                          <tr>
                            <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                            @if($dataAktiva["jenis"] == 2)

                              <?php 
                                $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                              ?>

                              <td class="text-right {{ $total }}">XXX.XXX.XXX</td>
                            @elseif($dataAktiva["jenis"] == 3)
                              <?php 
                                $show = ($totalHeader < 0) ? "(".number_format($totalHeader).")" : number_format($totalHeader); 
                              ?>

                              <td class="text-right {{ $total }}">XXX.XXX.XXX</td>
                            @endif
                          </tr>
                        @endif

                      <?php $DatatotalAktiva+= $dataAktiva["total"]; $totalHeader+= $dataAktiva["total"]; ?>
                    @endif

                  @endforeach
                </tr>
              </table>
            </td>
          </tbody>           
      </table>
    </div>
</div>

<div class="row" style="margin-bottom: 20px; padding-right: 15px;">
	<div class="col-md-12 m-t">                           
	  <table id="tree" width="100%" style="font-size: 8pt;">
	      <thead>
	        <tr>
	          <th class="text-center" width="70%">Total Akhir Laba Rugi</th>
	          <th class="text-right">XXX.XXX.XXX</th>
	        </tr>
	      </thead>         
	  </table>
	</div>
</div>

<div class="row" style="margin-bottom: 20px; padding-right: 15px;">
	<div class="col-md-3 col-md-offset-7">
		<a href="{{ route("laba_rugi.index", "bulan?m=".date("m")."&y=".date("Y")."") }}"><button type="button" class="btn btn-primary">Pergi Ke Halaman Laba Rugi</button></a>
	</div>
</div>





