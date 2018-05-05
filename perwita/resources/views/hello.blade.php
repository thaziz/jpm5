

@include('partials._head')
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="col-sm-12 ibox float-e-margins" style="background: #7dc5ef;text-align: center">
        <img class="img" width="80" height="40" style="margin-top: 10px;" src="{{ asset('perwita/storage/app/upload/images.jpg') }}"></td>
		<h3>Hai Kamu Memiliki Notifikasi</h3>
	</div>
	<div>
		<p>Terdapat Kontrak {{$status}} Yang Membutuhkan Persetujuan.</p>
		<a href="{{$kontrak}}" title="">{{$kontrak}}</a>
	</div>

	
</body>
</html>


@include('partials._scripts')

