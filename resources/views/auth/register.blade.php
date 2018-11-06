
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
        <!------ Include the above in your HEAD tag ---------->
    </head>

    <div class="container">
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>

            <div class="col-md-6 col-md-offset-3">
                <section class="login-form">
                    <form role="login" method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Tên">

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Mật khẩu">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"placeholder="Nhập lại mật khẩu">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <label for="gender" class="col-md-3 control-label input-lgf">Giới tính</label>
                                    <select name="gender" class="form-control">
                                        @foreach($genders as $value => $text)
                                        <option value="{!! $value !!}">{!! $text !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <label for="birthday" class="col-md-3 control-label">Ngày sinh</label>
                                    <input id="birthday" type="date" class="form-control input-lgf" name="birthday" value="{{ old('birthday') }}">

                                    @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="pwstrength_viewport_progress"></div>
                            <div class="col-md-12">
                                <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Đăng ký</button>
                            </div>
                            <div>
                                <a href="{{ route('login') }}">Đăng nhập</a>&nbsp;&nbsp;&nbsp; <a href="{{ route('password.request') }}">Quên mật khẩu</a>
                            </div>
                    </form>
                </section>  
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</html>
