@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    @if (session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tạo ví</div>

                <div class="panel-body">
                    <section class="content">
                        <form class="form-horizontal" method="POST" action="{{ route('wallet.create') }}">
                            {{ csrf_field() }}
                            <div class="box-body row">

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Tên ví</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
                                    <label for="money" class="col-md-4 control-label">Tiền trong ví</label>

                                    <div class="col-md-6">
                                        <input id="money" type="number" class="form-control" name="money" required>

                                        @if ($errors->has('money'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('money') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Tạo ví
                                    </button>

                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
