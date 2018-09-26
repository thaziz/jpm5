<!-- Mainly scripts -->
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/vendors/jquery-ui/jquery-ui.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendors//metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('assets/vendors/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('assets/vendors/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/peity/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('assets/js/inspinia.js') }}"></script>
    <script src="{{ asset('assets/vendors/pace/pace.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>

    <!-- Ladda -->
    <script src="{{ asset('assets/vendors/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.jquery.min.js') }}"></script>

    <!-- sweetalert -->
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Datatable -->
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
	
	  <!-- bootbox  -->    
    <script src="{{ asset('assets/vendors/bootbox/bootbox.js') }}"></script>
        
    
    <script src="{{ asset('assets/vendors/bootstrapTour/bootstrap-tour.min.js') }}"></script>
	
    
    <!-- datepicker  --> 
    <script src="{{ asset('assets/vendors/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendors/daterangepicker/daterangepicker.js') }}"></script>
        

       <!-- Money  --> 
    <script src="{{ asset('assets/vendors/money/dist/jquery.maskMoney.js') }}"></script>
    <script src="{{ asset('assets/vendors/accounting/accounting.min.js') }}"></script>
    <!--confirm -->
    <script src="{{ asset('assets/vendors/confirm/bootstrap-confirmation.js') }}"></script>
    
    
    <script src="{{ asset('assets/vendors/idle-timer/idle-timer.min.js') }}"></script>
    
    <!-- Chosen -->
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js') }}"></script>
    <!-- mask money -->
    <script src="{{ asset('assets/js/jquery.maskMoney.js') }}"></script>
    <!-- touchspin -->
    <script src="{{ asset('assets/vendors/touchspin/touchspin.js') }}"></script>
    {{-- Auto Complete --}}
    

    {{-- HIGHCHART --}}
    <script src="{{ asset('assets/vendors/highchart/exporting.js') }}"></script>
    <script src="{{ asset('assets/vendors/highchart/highcharts.js') }}"></script>
    <script src="{{ asset('assets/vendors/highchart/highcharts-3d.js') }}"></script>
    
    {{-- END OF --}}

    <script src="{{ asset('assets/js-cookie/js.cookie.js') }}"></script>

    <script>

        var datepicker_today = $('.datepicker_today').datepicker({
          format:"yyyy-mm-dd",
          autoclose:true
        }).datepicker("setDate", "0");
        var datepicker_date = $('.datepicker_date').datepicker({
          format:"yyyy-mm-dd",
          autoclose:true
        });

   /*     $('body').removeClass('fixed-sidebar');
        $("body").toggleClass("mini-navbar");*/

          $('[data-toggle="tooltip"]').tooltip({container : 'body'});
//          if(screen.width > 768){
//              alert('besar');
//              $('body').addClass('fixed-sidebar');
//          }else if(screen.width <= 768){
//              alert('kecil');
//              $('body').removeClass('fixed-sidebar');
//            $("body").toggleClass("mini-navbar");
//            SmoothlyMenu();
//          }
          
       

          var config = {
                '.chosen-select'           : {search_contains:true},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }


        var dataTableLanguage = {
           "emptyTable": "Tidak ada data",
           "sInfoFiltered": ". Telah Di Filter Dari _MAX_ total Data",
           "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
           "sSearch": 'Pencarian..',
           "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
           "sZeroRecords": "Tidak Menemukan Data Yang Sesuai Dengan Pencarian",
           "infoEmpty": "",
           "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
            },
        }

        var baseUrl = '{{ url('/') }}';
        //alert(baseUrl);

        $(document).ready(function() {
           $("#setting_periode").click(function(evt){
                evt.preventDefault();
                $("#modal_periode").modal("show");
           })

           $("#register_jurnal").click(function(evt){
                evt.preventDefault();
                $("#modal_register_jurnal").modal("show");
           })

           $("#register_jurnal").click(function(evt){
                evt.preventDefault();
                $("#modal_register_jurnal").modal("show");
           })


           // script for neraca saldo

              $("#neraca_saldo").click(function(evt){
                    evt.preventDefault();
                    $("#modal_neraca_saldo").modal("show");
                    html = '<option value="---">-- Pilih Cabang</option>'; $("#buku_besar_cabang_txt").fadeIn(100);

                    $.ajax(baseUrl+"/purchaseorder/grapcabang", {
                       timeout: 15000,
                       type: "get",
                       dataType: 'json',
                       success: function (data) {
                           $.each(data, function(i, n){
                                html = html + '<option value="'+n.kode+'">'+n.nama+'</option>';
                           })

                           $("#buku_besar_cabang").html(html);
                           $("#buku_besar_cabang_txt").fadeOut(300);
                       },
                       error: function(request, status, err) {
                          if (status == "timeout") {
                            alert("Request Timeout. Gagal Mengambil Data Cabang.");
                          }else {
                            alert("Internal Server Error. Gagal Mengambil Data Cabang.");
                          }

                          $(".cek").removeAttr("disabled");
                      }
                    });
               })

           // end neraca saldo



           // script for buku besar

           $("#buku_besar").click(function(evt){
                evt.preventDefault();
                $("#modal_buku_besar").modal("show");
                // html = '<option value="---">-- Pilih Cabang</option>'; $("#buku_besar_cabang_txt").fadeIn(100);

                // $.ajax(baseUrl+"/purchaseorder/grapcabang", {
                //    timeout: 15000,
                //    type: "get",
                //    dataType: 'json',
                //    success: function (data) {
                //        $.each(data, function(i, n){
                //             html = html + '<option value="'+n.kode+'">'+n.nama+'</option>';
                //        })

                //        $("#buku_besar_cabang").html(html);
                //        $("#buku_besar_cabang_txt").fadeOut(300);
                //    },
                //    error: function(request, status, err) {
                //       if (status == "timeout") {
                //         alert("Request Timeout. Gagal Mengambil Data Cabang.");
                //       }else {
                //         alert("Internal Server Error. Gagal Mengambil Data Cabang.");
                //       }

                //       $(".cek").removeAttr("disabled");
                //   }
                // });
           })

           // buku besar end

           $("#option_periode").click(function(evt){
                evt.preventDefault();
                $("#modal_option_periode").modal("show");
           })
        });

        function alertSuccess(message){
            swal({
                title: "Berhasil",
                text: "Data Berhasil Disimpan ! ",
                type: "success"
            });
        }

        function alertDelete(message, data, id){
            swal({
                title: "Apa Anda Yakin?",
                text: message+"!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Saya Yakin!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url         : baseUrl+'/master/'+data+'/delete/'+id,
                    type        : 'get',
                    success     :function(response){
                        //console.log(response);
                        swal("Deleted!", "Data "+data+" Berhasil Dihapus.", "success");
                        loadTable('update');
                    },
                    error       : function(){
                        swal("Error", "Server Sedang Mengalami Masalah", "error");
                    }
                })
            });
        }

        function loadTableError(message, withCenterClass = false){
            if(withCenterClass){
                var html = '<center><i style="margin-bottom:8px; color:#999" class="fa fa-ambulance fa-5x" aria-hidden="true" style="color:"></i><br/>'+
                            '<span style="color:#999">"ups ..'+message+'"</span><br/>'+
                            '<a href="{{ Request::url() }}">muat ulang</a></center>';
            }else{
                var html = '<i style="margin-bottom:8px; color:#999" class="fa fa-ambulance fa-5x" aria-hidden="true" style="color:"></i><br/>'+
                            '<span style="color:#999">"ups ..'+message+'"</span><br/>'+
                            '<a href="{{ Request::url() }}">muat ulang</a>';
            }

            return html;
        }
		$(document).ready(function () {
            $(document).idleTimer(2000000);
            });
            $(document).on("idle.idleTimer", function(event, elem, obj){    //            alert('klose');
               // window.location = baseUrl+"/logout";
            });
            $(document).on("active.idleTimer", function(event, elem, obj, triggerevent){    
    
        });
    
   // setTimeout(function(){ alert("Hello"); }, 3000);

   function pilihCabang(){
    var kodeCabang=$('#kode-cabang').val();
        $.ajax({
                    url         : baseUrl+'/cabang/'+kodeCabang,
                    type        : 'get',
                    success     :function(response){                        
                        location.reload();
                        
                    },
                    error       : function(){
                        swal("Error", "Server Sedang Mengalami Masalah", "error");
                    }
                });
   }

$(".mask_money_dn").maskMoney({thousands:'.', decimal:',', precision:-1});


    </script>

    <script type="text/javascript">


      $(function(){
        skinChanger();
      });

        $('.rightbar-btn-trigger button').click(function(){
            $('.rightbar-outer').removeClass('rightbar-outer-hidden');
            $('.rightbar').removeClass('rightbar-hidden');
            $('body').addClass('rightbar-appear');
        });
        $('.rightbar-outer, .btn-close-rightbar').click(function(){
            $('.rightbar-outer').addClass('rightbar-outer-hidden');
            $('.rightbar').addClass('rightbar-hidden');
            $('body').removeClass('rightbar-appear');
        });
      
      $(document).ready(function(){
        $sidebar = Cookies.get('sidebar_jpm5');

        if ($sidebar) {
          $('body').removeAttr('class').addClass($sidebar + '-bg-color');
          $('.rightbar .rightbar-body .list-skins[data-theme="' + $sidebar + '"]').addClass('active');
          // $('.table:not(.no-random-color) thead').removeAttr('class').addClass($sidebar +'-bg-color');
        } else {
          $('body').addClass('deep-blue-bg-color');
          $statement = $('.rightbar .rightbar-body .list-skins[data-theme="deep-blue"]').addClass('active');
          // $('.table:not(.no-random-color) thead').removeAttr('class').addClass('deep-blue-bg-color');
        }
      });
        



      function skinChanger(){
        $('.rightbar .rightbar-body .list-skins').click(function(){
          
          $body = $('body');
          $this = $(this);

          var existTheme = $('.rightbar .rightbar-body .list-skins.active').data('theme');
          $('.rightbar .rightbar-body .list-skins').removeClass('active');

          $body.removeClass(existTheme + '-bg-color');
          $this.addClass('active');

          $body.addClass($this.data('theme')+'-bg-color');

          
          $('.table:not(.no-random-color) thead').removeAttr('class').addClass($this.data('theme')+'-bg-color');

          Cookies.set('sidebar_jpm5', $this.data('theme'), { expires : 365 });

        });
      }

      $(document).on('keypress','.hanya_angka',function (e) {
         //if the letter is not digit then display error and don't type anything
         if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
            //display error message
            return false;
        }
       });

    </script>