<!DOCTYPE html>
<html>

	<head>
		<title></title>
	</head>

	<body>
		<button id="cek">Okeee</button>

		<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
		<script>

			console.log(window.opener);

			$("#cek").click(function(){
				alert("cek");
				window.opener.ProcessChildMessage('okee');
			})
			
		</script>
	</body>

</html>