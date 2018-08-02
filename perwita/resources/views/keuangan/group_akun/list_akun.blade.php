<div class="row">
	<div class="col-md-4">
		<div class="input-group input-group-sm">
		  <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-search"></i></span>
		  <select class="form-control" id="list_akun_search_context">

		  	<?php $value = ($withChecked == 'true') ? 2 : 1 ?>

		  	<option value="{{ $value }}">Kode Akun</option>
		  	<option value="{{ $value+1 }}">Nama Akun</option>
		  	<option value="{{ $value+2 }}">Cabang</option>
		  </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="input-group input-group-sm">
		  <input type="text" class="form-control form-sm" placeholder="Kata Kunci" id="list_akun_search_keyword">
		</div>
	</div>

	<div class="col-md-12 m-t" style="height: 450px; overflow: scroll;">
		<table class="table table-bordered tabel-list no-margin" id="table" style="padding:0px; font-size: 8pt;">
			<thead>
				<tr>
					@if($withChecked == 'true')
						<th style="position: sticky;top: 0px;" width="5%">*</th>
					@endif

					<th style="position: sticky;top: 0px;" width="15%">Kode Akun</th>
					<th style="position: sticky;top: 0px;" width="60%">Nama Akun</th>
					<th style="position: sticky;top: 0px;" width="20%">Cabang</th>
				</tr>
			</thead>

			<tbody id="searchable_list">
				@foreach($data as $key => $akun)
					<tr>
						@if($withChecked == 'true')
							<td style="background: white;" class="text-center"><input type="checkbox" value="{{ $akun->id_akun }}" class="checkedbox"></td>
						@endif

						<td style="background: white;">{{ $akun->id_akun }}</td>
						<td style="background: white;">{{ $akun->nama_akun }}</td>
						<td style="background: white;">{{ $akun->nama }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var windowTimeOut = null;

		$('.checkedbox').change(function(){
			if($(this).is(':checked'))
				list_akun.push($(this).val());
			else
				list_akun.splice(list_akun.findIndex(u => u == $(this).val()), 1);
		})

		$('#list_akun_search_keyword').keyup(function(evt){
			var field = $('#searchable_list'); var length_search = $(this).val().length;
			var search_val = $(this).val().toUpperCase();
			
			__debounce(
				function(){
					field.children('tr').each(function(){
						if(search_val != $(this).children('td:nth-child('+$('#list_akun_search_context').val()+')').text().substring(0, length_search).toUpperCase())
							$(this).css('display', 'none')
						else
							$(this).css('display', '')
					});
				}, 500)
		})

		function __debounce(calback, timer){
            window.clearTimeout(windowTimeOut);

            windowTimeOut = window.setTimeout(calback, timer)
        }
	})
</script>