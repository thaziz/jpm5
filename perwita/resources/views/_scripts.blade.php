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
    <!-- AUtocomplete -->
    <link href="{{ asset('assets/vendors/autocomplete/autocomplete.js')}}" rel="stylesheet">
    <!-- Ladda -->
    <script src="{{ asset('assets/vendors/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.jquery.min.js') }}"></script>
    <!-- Stripe -->

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
    
    <script>
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
          
       


         

     

        var dataTableLanguage = {
           "emptyTable": "Tidak ada data",
           "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
           "sSearch": 'Pencarian..',
           "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
           "infoEmpty": "",
           "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             }
          }

        var baseUrl = '{{ url('/') }}';
        //alert(baseUrl);

        $(document).ready(function() {
            //console.log(tour._options.steps[tour.getCurrentStep()]);
            // setTimeout(function() {
            //     toastr.options = {
            //         closeButton: true,
            //         progressBar: true,
            //         showMethod: 'slideDown',
            //         timeOut: 4000
            //     };
            //     toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

            // }, 1300);
        });

        function alertSuccess(message){
            swal({
                title: "Berhasil",
                text: message+"!",
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




    </script>