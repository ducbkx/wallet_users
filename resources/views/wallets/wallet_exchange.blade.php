@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chuyển tiền giữa các ví</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
                <div class="panel-body">
                    <form class="form-horizontal"  method="POST" action="{{ route('wallet.action_exchange') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('wallet_id_transfers') ? ' has-error' : '' }}">
                            <label for="Wallet" class="col-md-4 control-label">Ví chuyển tiền</label>
                            <div class="col-md-6">
                                <select name="wallet_id_transfers" class="form-control">

                                    @foreach($wallets as $wallet)
                                    <option value="{!! $wallet['id'] !!}">{!! $wallet['name'] !!}</option>
                                    @endforeach         
                                </select>
                                @if ($errors->has('wallet_id_transfers'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('wallet_id_transfers') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Wallet" class="col-md-4 control-label">Ví nhận tiền</label>
                            <div class="col-md-6">
                                <select name="wallet_id_receive" class="form-control">
                                    @foreach($wallets as $wallet)
                                    <option value="{!! $wallet['id'] !!}">{!! $wallet['name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-4 control-label">Nội dung chuyển tiền</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="5" name="content">{{ old('content') }}</textarea>
                                @if ($errors->has('content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
                            <label for="money" class="col-md-4 control-label">Số tiền</label>

                            <div class="col-md-6">
                                <input id="money" type="number" class="form-control" name="money">

                                @if ($errors->has('money'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('money') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Chuyển tiền
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
