<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
        <!------ Include the above in your HEAD tag ---------->
    </head>

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->has('email') ||  $errors->has('password'))
            <div class="alert alert-warning">
                Email hoặc mật khẩu không đúng!
            </div>
        @endif
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>

            <div class="col-md-6 col-md-offset-3">
                <section class="login-form">
                    <form role="login" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required class="form-control input-lg"  />
                        </div>
                        
                        <div class="form-group">
                            <input type="password" name="password" class="form-control input-lgf" id="password" placeholder="Mật khẩu" />
                        </div>

                        <div class="pwstrength_viewport_progress"></div>

                        <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Đăng nhập</button>
                        <div>
                            <a href="{{ route('register') }}">Đăng ký</a>&nbsp;&nbsp;&nbsp; <a href="{{ route('password.request') }}">Quên mật khẩu</a>
                        </div>

                    </form>

                </section>  
            </div>

            <div class="col-md-4"></div>
        </div>
    </div>
</html>
