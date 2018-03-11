@extends("main")

@section("title", "dashboard")

@section("extra_styles")
<style>
	table#tableItem thead tr th {
		font-weight: bolder;
		font-size: 15px;
		color: darkslategray;
	}

	h5#title{
		text-transform: uppercase;
		font-weight: bolder;
	}
</style>
@endsection

@section("content")
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
                	<div class="ibox-title">
                		<h5>
                			<strong>TAMBAH DATA</strong>
                		</h5>
	                	<div class="ibox-tools"><!-- Horizontal Line --></div>

                    </div> <!-- ibox.title -->

                    <div class="ibox-content">
                		<div class="row">
                			<div class="col-xs-12">
                				<div class="box" id="seragam_box">
                					<div class="box-header">
                						<div class="box-body">
                							<div class="row">
                								@include("laporan_sales.do_kertas.form")
                							</div>

                							<div class="row">
                								@include("laporan_sales.do_kertas.addItem")
                							</div>
                						</div>
                					</div>
                				</div>
                			</div>	
                		</div>
                	</div> <!-- ibox.content -->
                </div> 
			</div> 
		</div> <!-- div.row -->

		<div class="row" id="body">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
                		<h5 hidden id="title">
                			<strong>Tabel Detail Item</strong>
                		</h5>
	                	<div class="ibox-tools"><!-- Horizontal Line --></div>
                    </div> <!-- ibox.title -->

                    <div class="ibox-content">
                		<div class="row">
                			<div class="col-xs-12">
                				<div class="box" id="seragam_box">
                					<div class="box-header">
                						<div class="box-body">
                							<div class="row">
                								<div class="col-md-12">
                									@include("laporan_sales.do_kertas.tableItem")
                								</div>
                							</div>
                						</div>
                					</div>
                				</div>
                			</div>
                		</div>
                	</div> <!-- Content -->
				</div>
			</div>
		</div> <!-- div.row -->
	</div> <!-- div.wrapper -->
@endsection


@section('extra_scripts')
<script type="text/javascript">
	function setCurrency(number) 
	{
		return number.toFixed(2)
					 .replace('.', ',')
					 .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
	}

	function setUnCurrency(number)
	{
		return number.replace(".", "").replace(/[^0-9\-]+/g, "") / 100;
	}

	function calculation()
	{
		var $satuan_satu = $("#satuan_satu"),
			$total_satuan = $("#total_satuan"),
			$satuan_harga = $("#harga_satuan"),
			$kode_item = $("#kode_item"),
			$nominal_satuan1 = $("#nominal_satuan1"),
			$harga = $("#harga"),
			$total = $('#total'),
			$jumlah = $("#jumlah"),
			$netto = $("#netto");

		/*Trigger Item*/
		$("#nama_item").change(function() {
			/*nominal*/
			var $nama_item = $(this).val(),
				$nominal_satuan2 = 0,
				_arr = [$nama_item.split(",")];
			
			$kode_item.attr("value", _arr[0][0]);
			$satuan_satu.attr("value", _arr[0][1]);
			$satuan_harga.attr("value", _arr[0][1]);
			$total_satuan.attr("value", _arr[0][1]);
			$total.attr("value", setCurrency(parseInt(_arr[0][2])));
			$nominal_satuan1.attr("value", setCurrency(parseInt(_arr[0][2])) );
			$harga.attr("value", setCurrency(parseInt(_arr[0][2])));
			$jumlah.attr("value", $total.val());
			$netto.attr("value", $total.val());

			$total.on("keyup", function() {
				$jumlah.attr("value", setCurrency(
					setUnCurrency($total.val()) * setUnCurrency($harga.val())
					)
				);
				$netto.attr("value", setCurrency(
						setUnCurrency($total.val()) * setUnCurrency($harga.val())
					)
				);
			});
    	});

    	$(function() {
			$("input#discount").on("keyup", function() {
				var discount = $(this).val(),
					price = setUnCurrency($jumlah.val()),
					calculation = price * (parseInt(discount) / 100);
					console.log(calculation);
    			($("#rupiah").val(calculation) == "") ? $("#rupiah").val(0) : $("#rupiah").val(setCurrency(calculation));
    			var netto = price - calculation;
    			$netto.val(setCurrency(netto));
    		});
    	});
	}

	function setDatatable()
	{
		/* DataTable Detail Item */
		 var detailTableItem = $('#tableItem').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": true,
            "pageLength": 10,
            "retrieve" : true,
      	});

		 return detailTableItem;
	}

	$(document).ready(function()
	{
		
		/*setDatatable*/
		setDatatable();
		
		/* setCalculation */
		calculation();
		
		/* Trigger Count Sequences */
		$("#add").click(function() {
			var $seq = $("#seq"),
				_COUNT = 1;
			
			$seq.attr("value", _COUNT);
			
			$("#save").click(function() {
				if (_COUNT < 10) {
					_COUNT += 1;
					$seq.attr("value", _COUNT);
				} else if (parseInt($seq.val()) >= 10){
					alert("maximum Sequences");
				}
			});
		});
	});

	$(function()
	{
		$('.date').datepicker({
	        autoclose: true,
	        format: 'yyyy-mm-dd'
    	});

    	var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%"}
		}

       	for (var selector in config) {
			$(selector).chosen(config[selector]);
        }
	});

	$(function()
	{
		$("#DO_number").on("keyup", function(){
			var DO_number = $(this).val(),
				clone = $("#nomor_DO");

			clone.attr("value", DO_number);
		});
	});

    function addItem()
    {	
    	var Form = {
			nomor_do: document.forms["add_item"]["nomor"].value,
			tanggal: document.forms["add_item"]["tanggal"].value,
			kode_kustomer: document.forms["add_item"]["kode_customer"].value,
    	};

    	if(Form.nomor_do !== "" && Form.tanggal !== "" && Form.kode_kustomer !== "") {
    		$(function() {
				$.ajax({
					url: "{{ route('DelOrder.store') }}",
					type: "POST",
					dataType: "JSON",
					data: $("form#not_modalForm").serialize(),
					succes: function(data){
						alert("Sempak Bolong");
					},
					error: function(data) {
						alert("Sempak Tidak Bolong");
					}
				});
			});
    	}
		
		save_method = "add";
		$('input[name = _method]').val('POST');
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('.modal-title').text('Tambah Item');
    }

    function editForm(id)
	{
		save_method = 'edit';
		var 
			kode_item = $("#kode_item"),
			nominal_satuan1 = $("#nominal_satuan1"),
			harga = $("#harga"),
			total = $("#total"),
			harga_satuan = $("#harga_satuan"),
			jumlah = $("#jumlah"),
			diskon = $("#discount"),
			rupiah = $("#rupiah"),
			netto = $("#netto"),
			keterangan = $("#keterangan");

        $('input[name = _method]').val('PATCH');
        $('#modal-form form')[0].reset();

        $.ajax({
			url: "{{ url('sales/edit') }}/"+id+"/DO-tanpa-sales-order",
			type: "GET",
			dataType: "JSON",
			success: function(data){
				
				console.log(data);
				/* Show Modal */
				$('#modal-form').modal('show');
				$('.modal-title').text('Edit Item');
				
				/* getData */
				$("#nama_item_chosen a span").text(data[0].nama);
				$("#id").val(data[0].id);
				kode_item.attr("value", data[0].kode);
				nominal_satuan1.attr("value", data[0].satuan);
				harga.attr("value", data[0].harga);
				total.attr("value", data[0].harga * data[0].jumlah);
				harga_satuan.attr("value", data[0].satuan);
				jumlah.attr("value", data[0].jumlah);
				diskon.attr("value", data[0].diskon);
				rupiah.attr("value", data[0].jumlah);
				netto.attr("value", data[0].total),
				keterangan.attr("value", data[0].keterangan);

				jumlah.on("keyup", function() {
					var calc = $(this).val() * harga.val();
					total.val(calc);
				});

				$("#nama_item").change(function() {
					jumlah.removeAttr("value");
					diskon.removeAttr("value");
					rupiah.removeAttr("value");
					total.removeAttr("value");
					calculation();
				});
			},
			error: function(){
				alert("Nothing Data");
			}
        });
	}

	$(function() 
		{ /* onUpdate */
		$('#modal-form form').on('submit', function(e){
          if(!e.isDefaultPrevented())
          {
            var id = $('#id').val();
            if(save_method == 'add') url = "{{ route('DelOrder.store') }}";
            else  url = "{{ url('sales/update')}}/" + id + "/update-DO-tanpa-sales-order";
			
            $.ajax({
              url: url,
              type: "POST",
              data: $('#modal-form form').serialize(),
              success: function(data){
                $('#modal-form').modal('hide');
              },
              error: function(data){
                alert('Ooops!, Something Error!' );
                console.log(url);
              }
            });

            return false;
          }
        });
	});

	function deleteData(id)
	{
		var popup = confirm("Yakin Akan Menghapus?");
        var yes = true;
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        if (popup == yes) {
			$.ajax({
	            url: "{{ url('sales/destroy')}}/" + id + "/delete-DO-tanpa-sales-order",
	            type: "POST",
	            data: {'_method' : 'DELETE', '_token' : csrf_token},
	            success: function(data){
	              console.log(data);
	            },
	            error: function(){
	              alert("Ooops, Kesalahan Terdeteksi");
	            }
			});
        }
	}

    function redirectTo(route) {
    	window.location = route;
    }


    function setSalesOrder() {
    	/* redirect to Sales Order */
    }
	

	$(function() { /* trigger Check Box Transportation */
		$("#button-transportation").each(function () {

			var $widget = $(this),
				$button = $widget.find("button"),
				$checkbox = $widget.find('input:checkbox'),
				color = $button.data('color'),
				settings = {
					on: {
	                    icon: 'glyphicon glyphicon-check'
	                },
	                off: {
	                    icon: 'glyphicon glyphicon-unchecked'
	                }
				};

				$button.on('click', function () {
					$checkbox.prop('checked', !$checkbox.is(':checked'));
		            $checkbox.triggerHandler('change');
		            console.log($checkbox.val());
		            updateDisplay();
	       		});

	       		$checkbox.on('change', function () {
	            updateDisplay();
	        });

	        // Actions
	        function updateDisplay() {
	            var isChecked = $checkbox.is(':checked');

	            // Set the button's state
	            $button.data('state', (isChecked) ? "on" : "off");

	            // Set the button's icon
	            $button.find('.state-icon')
	                .removeClass()
	                .addClass('state-icon ' + settings[$button.data('state')].icon);

	            // Update the button's color
	            if (isChecked) {
	                $button
	                    .removeClass('btn-default')
	                    .addClass('btn-' + color + ' active');

	                $(".transportation")
	                	.show("slow")
	                	.removeClass("collapse");
	                	$("#ang").attr("value", "Dengan Angkutan");
					//console.log($checkbox.val());
	            }
	            else {
	                $button
	                    .removeClass('btn-' + color + ' active')
	                    .addClass('btn-default');
					
					$(".transportation")
						.addClass("collapse")
						.hide("slow");
					$("#ang").attr("value", "Tanpa Angkutan");
					//console.log($("#ang").val());
	            }
	        }

	        // Initialization
	        function init() {

	            updateDisplay();

	            // Inject the icon if applicable
	            if ($button.find('.state-icon').length === 0) {
	                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
	            }
	        }
	        init();
		});
	});
	
    $(function () { /* trigger Check Box Sales Order */
	    $('.button-checkbox').each(function () {

	        // Settings
	        var $widget = $(this),
	            $button = $widget.find('button'),
	            $checkbox = $widget.find('input:checkbox'),
	            color = $button.data('color'),
	            settings = {
	                on: {
	                    icon: 'glyphicon glyphicon-check'
	                },
	                off: {
	                    icon: 'glyphicon glyphicon-unchecked'
	                }
	            };

	        // Event Handlers
	        $button.on('click', function () {
	            $checkbox.prop('checked', !$checkbox.is(':checked'));
	            $checkbox.triggerHandler('change');
	            updateDisplay();
	        });
	        $checkbox.on('change', function () {
	            updateDisplay();
	        });

	        // Actions
	        function updateDisplay() {
	            var isChecked = $checkbox.is(':checked');

	            // Set the button's state
	            $button.data('state', (isChecked) ? "on" : "off");

	            // Set the button's icon
	            $button.find('.state-icon')
	                .removeClass()
	                .addClass('state-icon ' + settings[$button.data('state')].icon);

	            // Update the button's color
	            if (isChecked) {
	                $button
	                    .removeClass('btn-default')
	                    .addClass('btn-' + color + ' active');
					$("#SO").attr("value", "Pakai SO");

					$("#add").hide("slow");

					if ($("#addSO").length === 0) {
						$("#butt").append(
							'<button onclick=""' + 
							'type="button"' +
							'class="btn btn-success"' +
							'id="addSO"' +
							'style="margin-left: 2px;">' +
								'<strong>Pilih SO</strong>' +
							' </button>'
						);
					}

					$("#addSO").show("slow");
	                //console.log($checkbox.val());
	            }
	            else {
	                $button
	                    .removeClass('btn-' + color + ' active')
	                    .addClass('btn-default');

					$("#SO").attr("value", "Tanpa SO");

	                $("#add").show("slow");
	                $("#addSO").hide("slow");
	            }
	        }

	        // Initialization
	        function init() {

	            updateDisplay();

	            // Inject the icon if applicable
	            if ($button.find('.state-icon').length === 0) {
	                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
	            }
	        }
	        init();
	    });
	});
</script>
@endsection()