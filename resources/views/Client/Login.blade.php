<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>AIAT INSTITUTE</title>
  <link href="{{ url('backend_template/assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="{{ url('backend_template/assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
  <link href="{{ url('backend_template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link type="text/css" href="{{ url('backend_template/assets/css/argon.css?v=1.0.0') }}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <link   href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

  <script type="text/javascript" src=" https://code.jquery.com/jquery-3.3.1.js"></script>
</head>
<body class="bg-default">
    <!-- Page content -->
    <div class="container pb-5 mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <center>
            <h1 class="text-white">Welcome !!!</h1>
            <div class="flash-message  pl-5 pr-5 mt-2" style="border-radius:0px">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }} text-white p-1" style="color:#ffff;">
                            <b>{{ Session::get('alert-' . $msg) }} </b>
                            <a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                        {{ session()->forget('alert-' . $msg) }}
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->
            </center>
              <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent">
                    <form method="POST" action="{{ url('client/login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label><small><b>Email Address :</b></small></label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        @error('email')
                            <strong>{{ $message }}</strong>
                        @enderror

                        <div class="form-group mb-3">
                            <label><small><b>Password :</b></small></label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" value="{{ old('password') }}" required autocomplete="current-password">
                            </div>
                        </div>
                        @error('password')
                            <strong>{{ $message }}</strong>
                        @enderror


{{--
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-md">Login</button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-center" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <script src="{{ url('backend_template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('backend_template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js ') }}"></script>
    <script src="{{ url('backend_template/assets/js/argon.js?v=1.0.0') }}"></script>
    </body>
    </html>
