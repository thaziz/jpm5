

@include('partials._head')
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="col-sm-12 ibox float-e-margins" style="background: #7dc5ef;">
		<div style="width: 80px;height: 40px; display: inline-block; margin-top: 10px;margin-bottom: 10px; margin-left: 10px;">
        	<img class="img" width="80" height="40" style="" src="{{ asset('perwita/storage/app/upload/images.jpg') }}">
		</div>
		<div style=" display: inline-block;">
			<h3 style="display: inline-block;">Hai Kamu Memiliki Notifikasi</h3>
		</div>
	</div>
	<div style="">
		<p>Terdapat Kontrak {{$status}} Yang Membutuhkan Persetujuan.</p>
		<a class="btn btn-primary" href="{{$kontrak}}" title="">Klik Disini</a>
	</div>

	
</body>
</html>


@include('partials._scripts')

