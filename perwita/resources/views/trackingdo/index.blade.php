@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">.dataTables_filter, .dataTables_info { display: none; }</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin : 8px 5px 0 0"> Tracking DO
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>


                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">



              <div class="box" id="seragam_box">
                <div class="box-header">

    <table >
         <tbody>
            <tr id="filter_col3" data-column="1">
                <td>Pencarian :</td>
                <td align="center">
                <input type="text" class="column_filter fil1" id="col1">
            <button class="fa fa-search btn" id="search"></button></td>
            </tr>
        </tbody>
    </table>

    <table hidden="" >
         <tbody>
            <tr id="filter_col" data-column="1">
                <td>Table 2</td>
                <td align="center">
                <input type="text" class="column_filter fil2" id="col2">
                </td>
            </tr>
        </tbody>
    </table>
        <table hidden="">
         <tbody>
            <tr id="filter_col" data-column="1">
                <td>Table 3</td>
                <td align="center">
                <input type="text" class="column_filter fil3" id="col3">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="sembyunyi" style="display: none;">
    <div class="here">
        
    </div>
    </div>
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
</div>




<div class="row" style="padding-bottom: 50px;"></div>

@endsection



@section('extra_scripts')
<script type="text/javascript">
 /*   $("#tabel_data").DataTable({

    });*/

function filterColumn ( i ) {
    $('.gege').DataTable().column( 1 ).search(
        $('#col'+1).val(),
    ).draw();
    $('.noob').DataTable().column( 1 ).search(
        $('#col'+1).val(),
    ).draw();
    $('.data3').DataTable().column( 1 ).search(
        $('#col'+1).val(),
    ).draw();
}

$(document).ready(function() {

    $('.gege').DataTable({
      "paging" : false,
    });

    $('#search').on('click',function(){
         filterColumn( $(this).parents('tr').attr('data-column') );
    var a = $('#col1').val();
    if (a == ''){
        alert('Harap Diisi Terlebih Dahulu');
        $('.gege').attr('hidden',true);
    }else {
        $('.gege').removeAttr('hidden');
    }
    asnj = $('#col1').val();
          $.ajax({
                url: baseUrl + '/sales/deliveryordercabangtracking/getdata/'+asnj,
                type: 'get',
                timeout: 10000,
                success: function (data) {
                    $('.here').html(data);
                    $('.sembyunyi').css('display','block');
                }

});
    });


$("#col1").autocomplete({
        source: baseUrl+'/sales/deliveryordercabangtracking/autocomplete',
        minLength: 1,
        select: function(event, ui) {
        $('#col9').val(ui.item.id);
        $('#col1').val(ui.item.label);

    }
});
} );


function lol (){
    var a = $('#col1').val();
    if (a == ''){
        alert('diisi mas');
        /*$('.gege').hide();*/
    }else {
        $('.gege').show();
    }
}


    $('.fil1').keyup(function() {
    $('.fil2').val($(this).val());
    $('.fil3').val($(this).val());
});


</script>
@endsection
