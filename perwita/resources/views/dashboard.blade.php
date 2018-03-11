@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')
  
  <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
  </style>

@endsection

@section('content')

        <div class="row border-bottom white-bg dashboard-header">
          <center> <span style="font-size:18px;">Hai, {{ Auth::user()->m_name }} Ratu Sejagat</span> </center>
        </div>
   

   <div class="modal inmodal" id="modal-step-info" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content animated bounceInRight">
              <div class="modal-header">
                  <i class="fa fa-step-backward fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;
                  <i class="fa fa-step-forward fa-2x" aria-hidden="true"></i>
                  <h4 class="modal-title" style="color:red">{{ Auth::user()->m_name }} Ratu Sejagat</h4>
                  <small class="font-bold">Selamat Datang Di Aplikasi DBoard dan Selamat Bergabung.</small>
              </div>
              <div class="modal-body">
                  <p>Sistem kami menemukan bahwa anda belum menambahkan satupun perusahaan di Akun DBoard anda. Mungkin ini adalah saat yang tepat bagi kami untuk mengajarkan kepada anda bagaimana cara menambahkan perusahaan di aplikasi DBoard ini.</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary startTour">
                    Ya, Ajarkan Saya &nbsp; <i class="fa fa-play" aria-hidden="true"></i>
                  </button>
              </div>
          </div>
      </div>
  </div>

    

@endsection

@section('extra_scripts')
  <script type="text/javascript">
    
   

  </script>
@endsection