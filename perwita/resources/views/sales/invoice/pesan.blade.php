@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>




<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h2>Data tidak bisa di hapus</h2>

        <div class="error-desc">
           {{$pesan}}<br/>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>





@endsection



@section('extra_scripts')


</script>
@endsection
