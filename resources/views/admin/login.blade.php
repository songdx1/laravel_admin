<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @if(!is_null($favicon = Admin::favicon()))
  <link rel="shortcut icon" href="{{$favicon}}">
  @endif

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/admin-lte/plugins/fontawesome-free/css/all.min.css") }}">
  

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
  <!-- Theme style --><!-- Bootstrap 4.6 -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/admin-lte/dist/css/adminlte.min.css") }}">

</head>
<body class="hold-transition login-page" @if(config('admin.login_background_image'))style="background: url({{config('admin.login_background_image')}}) no-repeat;background-size: cover;"@endif>
<div class="login-box">
  <div class="login-logo">
    <a href="{{ admin_url('/') }}"><b>{{config('admin.name')}}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-body">
      <p class="login-box-msg">{{ trans('admin.login') }}</p>
      <form action="{{ admin_url('auth/login') }}" method="post">

        <div class="input-group mb-3">
          @if($errors->has('username'))
            @foreach($errors->get('username') as $message)
              <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i>{{$message}}</label>
            @endforeach
          @endif
          <input type="text" class="form-control" placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          @if($errors->has('password'))
            @foreach($errors->get('password') as $message)
              <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i>{{$message}}</label>
            @endforeach
          @endif
          <input type="password" class="form-control" placeholder="{{ trans('admin.password') }}" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            @if(config('admin.auth.remember'))
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" value="1" {{ (!old('username') || old('remember')) ? 'checked' : '' }} >
              <label for="remember">
              {{ trans('admin.remember_me') }}
              </label>
            </div>
            @endif
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary btn-block">{{ trans('admin.login') }}</button>
          </div>
          <!-- /.col -->
        </div>

      </form>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ admin_asset("vendor/admin-lte/plugins/jquery/jquery.min.js")}} "></script>
<!-- Bootstrap 4 -->
<script src="{{ admin_asset("vendor/admin-lte/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{ admin_asset("vendor/admin-lte/dist/js/adminlte.min.js")}}"></script>
</body>
</html>
