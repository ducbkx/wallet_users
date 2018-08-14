@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Wallet</div>

                <div class="panel-body">
                    <form class="form-horizontal"  method="POST" action="{{ route('wallet.action_exchange') }}">
                        {{ csrf_field() }}

                <div class="form-group">
                    <label for="Wallet" class="col-md-4 control-label">Ví chuyển tiền</label>
                    <div class="col-md-6">
                        <select name="wallet_id" class="form-control">
                            @foreach($wallets as $value => $wallet)
                            <option value="{!! $value !!}">{!! $wallet['name'] !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Wallet" class="col-md-4 control-label">Ví nhận tiền</label>
                    <div class="col-md-6">
                        <select name="wallet_id" class="form-control">
                            @foreach($wallets as $value => $wallet)
                            <option value="{!! $value !!}">{!! $wallet['name'] !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
                    <label for="money" class="col-md-4 control-label">Số tiền</label>

                    <div class="col-md-6">
                        <input id="money" type="number" class="form-control" name="money" required>

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
