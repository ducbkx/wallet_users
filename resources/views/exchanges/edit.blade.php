@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Sửa giao dịch</div>

            <div class="panel-body">
                <section class="content">
                    <form class="form-horizontal" action="{{ route('exchange.update', $exchange->id) }}" method="POST">
                        {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('transaction_id') ? ' has-error' : '' }}">
                                <label for="transaction_id" class="col-md-4 control-label">Tên giao dịch</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="transaction_id"  value="{{ old('transaction_id') }}">                                   
                                        @foreach($transactions as $transaction)
                                        <option  value="{!!$transaction['id'] !!}" {{ $transaction['id'] == $exchange->transaction_id ? 'selected' : ''  }}>{!! $transaction['name'] !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-4 control-label">Nội dung giao dịch</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="5" name="content">{{ old('content',$exchange->content) }}</textarea>
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
                                <input id="money" type="number" class="form-control" name="money" value="{{ old('money', $exchange->money) }}">

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
                                    Sửa giao dịch
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
