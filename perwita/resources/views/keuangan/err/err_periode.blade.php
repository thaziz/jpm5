@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
    body{
      overflow-y: scroll;
    }

    #table{
      width: 100%;
    }

    #table td{
      padding: 8px 20px;
    }

    #table_form, #table-filter{
      border:0px solid black;
      width: 100%;
    }

    #table_form input,{
      padding-left: 5px;
    }

    #table_form td{
      padding: 10px 0px 0px 0px;
      vertical-align: top;
    }

    #table-filter td,
    #table-filter th{
      padding:10px 0px;
    }

    .error-badge{
      color:#ed5565;
      font-weight: 600;
    }

    .error-badge small{
      display: none;
    }

    #table_form .right_side{
      padding-left: 10px;
    }

    .modal-open{
      overflow: inherit;
    }.chosen-select {
        background: red;
    }
  </style>
@endsection

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
		<div class="col-md-12 text-center">
			<span style="font-size: 54pt; font-weight: bold; color: #ccc;"><i class="fa fa-frown-o"></i></span><br/>
			<span style="font-size: 20pt; font-weight: 400; color: #ccc;">Periode Keuangan Untuk Bulan Ini Belum Dibuat...</span>
		</div>
    </div>
</div>

@endsection



@section('extra_scripts')

@endsection