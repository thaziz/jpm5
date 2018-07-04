<div class="col-sm-12">
	<div class="col-sm-6"  >
		<div class="header_vendor" style="text-align: center"><h3>Form Pembayaran Vendor</h3></div>
		<form class="form_vendor">
			<table class="table table_vendor">
				{{ csrf_field() }}
				<tr>
					<td>Tanggal</td>
					<td><input type="text" readonly="" value="{{$tanggal}}" class="form-control tanggal_vendor" name="tanggal_vendor"></td>
				</tr>
				<tr>
					<td>Jatuh Tempo</td>
					<td><input type="text" readonly="" value="{{$tanggal}}" class="form-control jatuh_tempo_vendor" name="jatuh_tempo_vendor"></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><input type="text" value="Released" readonly="" class="form-control status" name="status"></td>
				</tr>
				<tr>
					<td>Vendor</td>
					<td class="nama_vendor_td">
						<select class="form-control chosen-select-width-vendor nama_vendor_baru nama_vendor" name="nama_vendor">
							<option value="0">Pilih - Vendor</option>
							@foreach ($vendor as $val)
								<option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td>No Invoice</td>
					<td><input type="text" class="form-control no_invoice" name="no_invoice"></td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td><input type="text" class="form-control keterangan" name="Keterangan_biaya"></td>
				</tr>
				<tr>
					<td>Total Biaya</td>
					<td><input readonly="" type="text" style="text-align: right" class="form-control total_vendor" value="0" name="total"></td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="button" class="btn btn-primary tambah_data_vendor" ><i class="fa fa-plus"> Tambah Data</i></button>
						<button type="button" class="btn btn-success simpan_data_vendor disabled" ><i class="fa fa-save"> Simpan Data</i></button>
						<button type="button" class="btn btn-warning tt_vendor" ><i class="fa fa-book"> Form Tanda Terima</i></button>
						<button type="button"  class="btn btn-primary uang_muka_vendor disabled" ><i class="fa fa-money"> Uang Muka</i></button>
						<button type="button" onclick="print_penerus()"  class="btn btn-danger pull-right print_vendor" ><i class="fa fa-print"></i></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<div class="col-sm-12">
	<table class="table table-bordered table-hover table_do_vendor">
		<thead>
			<tr>
				<th>No</th>
				<th>Delivery Order</th>
				<th>Tanggal</th>
				<th>Total Tarif</th>
				<th>Tarif Vendor</th>
				<th width="300">Keterangan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>

<script type="text/javascript">
{{-- GLOBAL VARIABLE --}}
var index_vendor = 1;
var array_simpan = [0];
$('.tangal_vendor').datepicker({
	format:'dd/mm/yyyy'
});

$('.jatuh_tempo_vendor').datepicker({
	format:'dd/mm/yyyy'
});

var table_do_vendor = $('.table_do_vendor').DataTable({
	sort:false,
	columnDefs: [
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets: 6,
                 className: 'center'
              },
              {
                 targets: 0,
                 className: 'center'
              },
              {
                 targets:4,
                 className: 'right'
              },
              {
                 targets:3,
                 className: 'right'
              },
            ],
});
var config_vendor = {
           '.chosen-select'           		: {},
           '.chosen-select-deselect'  		: {allow_single_deselect:true},
           '.chosen-select-no-single' 		: {disable_search_threshold:10},
           '.chosen-select-no-results'		: {no_results_text:'Oops, nothing found!'},
           '.chosen-select-width-vendor'    : {width:"100%"}
        }
for (var selector in config_vendor) {
	$(selector).chosen(config_vendor[selector]);
}	 

$('.tambah_data_vendor').click(function(){
	var nama_vendor = $('.nama_vendor').val();
	var cabang 		= $('.cabang').val();
	$.ajax({
	    url : baseUrl + '/fakturpembelian/cari_do_vendor',
	    data : {cabang,nama_vendor,array_simpan},
	    type : "get",
     	success : function(response){
			$('.vendor_div').html(response);
			$('#modal_show_vendor').modal('show');
		}
    }) 
})
$('.tt_vendor').click(function(){
	var cabang = $('.cabang').val();
	var cabang = $('.cabang').val();
    $.ajax({
      url:baseUrl +'/fakturpembelian/nota_tt',
      data: {cabang},
      dataType:'json',
      success:function(data){
        $('.notandaterima').val(data.nota);
        var agen_vendor = $('.nama_vendor').val();
        var jatuh_tempo = $('.jatuh_tempo_vendor').val();
        var total_jml   = $('.total_vendor').val();
        total_jml       = total_jml.replace(/[^0-9\-]+/g,"")*1;
        $('.supplier_tt').val(agen_vendor);
        $('.jatuhtempo_tt').val(jatuh_tempo);
        $('.totalterima_tt_vendor').val(accounting.formatMoney(total_jml, "Rp ", 2, ".",','));
		$('#modal_tt_vendor').modal('show');
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
})

$('.append_vendor').click(function(){
	var nomor_vendor = [];
	table_modal_vendor.$('.check_vendor').each(function(i){
		if ($(this).is(':checked') == true) {
			nomor_vendor.push(table_modal_vendor.$('.nomor_do_vendor').eq(i).text());
			console.log(nomor_vendor);
		}
	})
	$.ajax({
      url:baseUrl +'/fakturpembelian/append_vendor',
      data: {nomor_vendor},
      dataType:'json',
      success:function(data){
      	for (var i = 0; i < data.data.length; i++) {

      		@if(Auth::user()->punyaAkses('Rubah Tarif Vendor','aktif'))
      			var total_tarif = '<input type="text" readonly class="v_total_tarif right form-control full" value="'+accounting.formatMoney(data.data[i].total_net, "", 0, ".",',')+'" name="v_total_tarif[]">';

      			var tarif_vendor = '<input type="text" onkeyup="rubah_angka_vendor()" class="right v_tarif_vendor form-control full" value="'+accounting.formatMoney(data.data[i].total_vendo, "", 0, ".",',')+'" name="v_tarif_vendor[]">';
      		@else 
      			var total_tarif = '<input readonly type="text" value="'+accounting.formatMoney(data.data[i].total_net, "", 0, ".",',')+'"  class="right v_total_tarif form-control full" name="v_total_tarif[]">';
      			var tarif_vendor = '<input readonly type="text" value="'+accounting.formatMoney(data.data[i].total_vendo, "", 0, ".",',')+'" class="right v_tarif_vendor form-control full" name="v_tarif_vendor[]">';
      		@endif

	      	table_do_vendor.row.add([
	      			'<p class="v_id_text">'+index_vendor+'</p>',

	      			'<p class="v_nomor_do_text">'+data.data[i].nomor+'</p>'+
	      			'<input type="hidden" value="'+data.data[i].nomor+'" class="v_nomor_do" name="v_nomor_do[]">',

	      			'<p>'+data.data[i].tanggal+'</p>',

	      			total_tarif,

	      			tarif_vendor,

	      			'<input type="text" value="" class="full form-control v_keterangan" name="v_keterangan[]">',

	      			'<button onclick="hapus_vendor(this)" class="btn btn-danger" type="button"><i class="fa fa-trash"></i>',
	      		]).draw();
	      	index_vendor++;
	      	array_simpan.push(data.data[i].nomor);
      	}
      	var temp = 0;
      	table_do_vendor.$('.v_tarif_vendor').each(function(){
      		temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
      	})
      	$('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))
      	$('.nama_vendor_td').addClass('disabled');
      	$('.cabang_td').addClass('disabled');
      	$('.v_tarif_vendor').maskMoney({
		    precision : 0,
		    thousands:'.',
		    allowZero:true,
		    defaultZero: true
		});
		$('#modal_show_vendor').modal('hide');
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
})


function hapus_vendor(o) {
	var par   = $(o).parents('tr');
	var nomor = $(par).find('.v_nomor_do').val();
	var i 	  = array_simpan.indexOf(nomor);
	array_simpan.splice(i,1);
    table_do_vendor.row(par).remove().draw(false);

    var temp = 0;
  	table_do_vendor.$('.v_tarif_vendor').each(function(){
  		temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
  	})
  	if (temp == 0) {
  		$('.nama_vendor_td').removeClass('disabled');
      	$('.cabang_td').removeClass('disabled');
  	}
  	$('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))

}
function rubah_angka_vendor(){

	var temp = 0;
  	table_do_vendor.$('.v_tarif_vendor').each(function(){
  		temp += $(this).val().replace(/[^0-9\-]+/g,"")*1;
  	})

  	$('.total_vendor').val(accounting.formatMoney(temp, "", 0, ".",','))
}


$('.simpan_vendor_tt').click(function(){
	var selectOutlet = $('.nama_vendor').val();
	var cabang = $('.cabang').val();
	var totalterima_tt_subcon = $('.totalterima_tt_vendor').val();
	if (totalterima_tt_subcon == 'Rp 0,00') {
	toastr.warning('Nilai Tanda Terima Tidak Boleh Nol');
	}
	  swal({
	    title: "Apakah anda yakin?",
	    text: "Simpan Data!",
	    type: "warning",
	    showCancelButton: true,
	    confirmButtonColor: "#DD6B55",
	    confirmButtonText: "Ya, Simpan!",
	    cancelButtonText: "Batal",
	    closeOnConfirm: true
	  },
	  function(){
	       $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });
	      $.ajax({
	      url:baseUrl + '/fakturpembelian/simpan_tt',
	      type:'get',
	      dataType:'json',
	      data:$('.tabel_tt_vendor :input').serialize()+'&'+'agen='+selectOutlet+'&'+$('.head_subcon :input').serialize()+'&cabang='+cabang,
	      success:function(response){
	            swal({
	                title: "Berhasil!",
	                type: 'success',
	                text: "Data berhasil disimpan",
	                timer: 900,
	                showConfirmButton: true
	                },function(){

	                $('.simpan_data_vendor').removeClass('disabled');
	                $('.simpan_vendor_tt').addClass('disabled');
	                $('.tambah_data_vendor').addClass('disabled');
	                });

	      },
	      error:function(data){
	        swal({
	        title: "Terjadi Kesalahan",
	                type: 'error',
	                timer: 900,
	               showConfirmButton: true

	    });
	   }
	  });  
	});
})


$('.simpan_data_vendor').click(function(){
	var temp = 0;
	  $('.v_nomor_do').each(function(){
	    temp+=1;
	  })

	  if (temp == 0) {
	    toastr.warning('Tidak Ada Data');
	    return 1;
	  }

      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          $.ajax({
          url:baseUrl + '/fakturpembelian/save_vendor',
          type:'get',
          data:$('.head1 :input').serialize()
              +'&'+$('.table_vendor :input').serialize()
              +'&'+table_do_vendor.$('input').serialize(),
          success:function(response){
            if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                      $('.simpan_data_vendor').addClass('disabled');
                      $('.idfaktur').val(response.id);
                      $('.save_vendor_um').removeClass('disabled');
                      $('.uang_muka_vendor').removeClass('disabled');

                    });
            }else{
              swal({
                title: response.pesan,
                type: 'error',
                timer: 900,
                showConfirmButton: true

              });
            }
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
    });
})
// UANG MUKA

$('.vendor_dibayar_um').maskMoney({
		    precision : 0,
		    thousands:'.',
		    allowZero:true,
		    defaultZero: true
		});
var vendor_tabel_detail_um = $('.vendor_tabel_detail_um').DataTable();
$('.uang_muka_vendor').click(function(){
	$('#modal_um_vendor').modal('show');
})

function hitung_um_vendor() {
  var temp = 0;
  vendor_tabel_detail_um.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    temp+=b;
  })
    console.log(temp);

  $('.vendor_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));

}
  


var array_um1 = [];
var array_um2 = [];
var array_um1 = [0];
var array_um2 = [0];

$('.vendor_nomor_um').focus(function(){
  var sup = $('.nama_vendor_baru').val();
  if (sup == '0') {
    toastr.warning('Vendor Harus Diisi');
    return false;
  }

  $.ajax({
    url:baseUrl +'/fakturpembelian/vendor_um',
    data: {sup,array_um1,array_um2},
    success:function(data){
      console.log('asd');
      $('.bp_div_um').html(data);
      $('#modal_show_um').modal('show');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })

})
var id_um    = 1;

$('.vendor_tambah_um').click(function(){
  var nota = $('.vendor_nomor_um').val();
  var sup = $('.nama_vendor').val();
  var nofaktur = $('.nofaktur').val();
  var vendor_id_um = $('.vendor_id_um').val();
  var vendor_dibayar_um = $('.vendor_dibayar_um').val();
  vendor_dibayar_um   = vendor_dibayar_um.replace(/[^0-9\-]+/g,"")/1;





  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (vendor_dibayar_um == '' || vendor_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

 $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup},
    dataType:'json',
    success:function(data){

      $('.vendor_nomor_um').val(data.data.nomor);
      $('.vendor_tanggal_um').val(data.data.um_tgl);
      $('.vendor_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.vendor_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.vendor_keterangan_um').val(data.data.um_keterangan);

      if (vendor_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (vendor_id_um == '') {
        vendor_tabel_detail_um.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(vendor_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+vendor_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_vendor(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_vendor(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+vendor_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(vendor_dibayar_um);
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(vendor_dibayar_um, "", 2, ".",','));
      }
      hitung_um_vendor();
      $('.vendor_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um_vendor(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.vendor_id_um').val(tb_faktur_um);
  $('.vendor_nomor_um').val(tb_transaksi_um);
  $('.vendor_tanggal_um').val(tb_tanggal_text);
  $('.vendor_jumlah_um').val(tb_jumlah_um_text);
  $('.vendor_sisa_um').val(tb_sisa_um_text);
  $('.vendor_keterangan_um').val(tb_keterangan_um_text)
  $('.vendor_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um_vendor(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  vendor_tabel_detail_um.row(par).remove().draw(false);

  hitung_um();
}


$('.save_vendor_um').click(function(){

  var temp = 0;
  var vendor_total_um = $('.vendor_total_um').val();
  vendor_tabel_detail_um.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    console.log(b);
    temp+=b;
  })
  var total_jml = $('.total_vendor').val();
  total_jml   = total_jml.replace(/[^0-9\-]+/g,"")*1;

  if (temp > total_jml) {
    toastr.warning("Pembayaran Lebih Besar Dari Total Faktur");
    return false;
  }

  swal({
      title: "Apakah anda yakin?",
      text: "Simpan Data!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, Simpan!",
      cancelButtonText: "Batal",
      closeOnConfirm: true
    },
    function(){
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        $.ajax({
        url:baseUrl + '/fakturpembelian/save_vendor_um',
        type:'post',
        data:$('.head1 :input').serialize()
              +'&'+$('.table_vendor :input').serialize()
              +'&'+vendor_tabel_detail_um.$('input').serialize()+'&vendor_total_um='+vendor_total_um,
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   $('.save_vendor_um').addClass('disabled');
                   $('.uang_muka_vendor').addClass('disabled');
                   
                  });
          }else if(response.status == 0){
            swal({
              title: "Data Faktur Tidak Ada",
              type: 'error',
              timer: 900,
              showConfirmButton: true

            });
          }else if(response.status == 2){
            swal({
              title: "Status Faktur Pending",
              type: 'error',
              timer: 900,
              showConfirmButton: true

            });
          }
        },
        error:function(data){
          swal({
          title: "Terjadi Kesalahan",
                  type: 'error',
                  timer: 900,
                 showConfirmButton: true

      });
     }
    });  
  });
})





function print_penerus() {
  var idfaktur = $('.idfaktur').val();
  console.log(idfaktur);
  window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
}


</script>