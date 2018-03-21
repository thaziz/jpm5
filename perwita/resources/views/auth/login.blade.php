<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DBoard | Login </title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/dboard/logo/faveicon.png') }}"/>
    <link href="{{ asset('assets/vendors/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/css/inspiniaStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/inspiniaAnimate.css') }}" rel="stylesheet">

    <link href="{{asset('assets/vendors/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/material-design-login/css/style.css') }}">

</head>

<body style="background: url('assets/img/dboard/background/login.png') center center fixed; background-size: cover">

  <hgroup>
  <img src="{{asset('assets/logo_jpm.png')}}"></a>
  <h1>Jawa Pratama Mandiri</h1>
  
</hgroup>
<form role="form" id="login-form">
    <div class="group">
        <input type="text" required name="username" id="username"></span><span class="bar"></span>
        <label>Name</label>
        <span style="padding-left: 5px;color:#ed5565;" class="help-block m-b-none hidden" id="username-error"><small>Inputan username ini wajib diisi !</small></span>
    </div>
    <div class="group">
        <input type="password" required name="password" id="password"></span><span class="bar"></span>
        <label>Password</label> 
        <span style="padding-left: 5px;color:#ed5565;" class="help-block m-b-none hidden" id="password-error"><small>Inputan password ini wajib diisi !</small></span>
    </div>
        <button type="button" class="ladda-button ladda-button-demo btn btn-primary block full-width m-b" data-style="zoom-in">Sign In!
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
        </button>
</form>
    <p class="m-t text-center error-load hidden" style="color:#ed5565;">
        <small>..</small>
    </p>
<footer><a href="http://www.alamraya.co.id/" target="_blank"><img src="{{asset('assets/alamraya.png')}}" width="128px" height="64px"></a>
  <p>Created By <a href="http://www.alamraya.co.id/" target="_blank">Alamraya Sebar Barokah</a></p>
</footer>


    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/material-design-login/js/index.js') }}"></script>
    <!-- Ladda -->
    <script src="{{ asset('assets/vendors/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>


    <script type="text/javascript">
        var buttonLadda = $('.ladda-button-demo').ladda();
        var baseUrl = '{{ url('/') }}';
        $('.ladda-button').click(function(){
            if(validateForm()){
                buttonLadda.ladda('start');
                $.ajax({
                    url         : baseUrl+'/login',
                    type        : 'get',
                    timeout     : 10000,
                    data        : $('#login-form').serialize(),
                    dataType    : 'JSON',
                    success     : function(response){
                        //alert(response.content);
                        //console.log(response);
                          if(response.status == 'sukses'){

toastr.options.onShown = function() { window.location = baseUrl+'/dashboard';
}

				toastr.success(response.nama, "Selamat Datang,");



                             //window.location = baseUrl+'/dashboard';
                            ///alert('1');
                           /* if(response.content == 'authenticate'){
                               // alert('1');
                                window.location = baseUrl+'/dashboard';
                            }else if(response.content == 'gate 2'){
                                //alert('2');
                                window.location = baseUrl+'/login/comp-gate';
                            }*/
                        }
                        else if(response.status == 'gagal'){
                            $('.error-load').removeClass('hidden');
                            $('.error-load small').text(response.content);
                            toastr.error(response.content, "Gagal!");
                            buttonLadda.ladda('stop');
                        }
                    },
                    error       : function(xhr, status){
                        if(status == 'timeout'){
                            $('.error-load').removeClass('hidden');
                            $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                        }
                        else if(xhr.status == 0){
                            $('.error-load').removeClass('hidden');
                            $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                        }
                        else if(xhr.status == 500){
                           $('.error-load').removeClass('hidden');
                            $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                        }

                        buttonLadda.ladda('stop');
                    }
                });

            }
        });

        function validateForm(){
            var username = document.getElementById('username');
            var password = document.getElementById('password');

            //alert(username.value);

            if(username.validity.valueMissing){
                $('#username-error').removeClass('hidden');
                return false;
            }
            else if(password.validity.valueMissing){
                $('#password-error').removeClass('hidden');
                return false;
            }

            return true;
        }

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-full-width",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "30000",
  "hideDuration": "100000",
  "timeOut": "50000",
  "extendedTimeOut": "10000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
    </script>

</body>

</html>
