@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Tạo giao dịch</div>

            <div class="panel-body">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
            </div>
            <div class="panel-body">
                <section class="content">
                    <form class="form-horizontal" action="{{ route('create_exchange') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="Type" class="col-md-4 control-label">Loại giao dịch</label>
                            <div class="col-md-6">
                                <select name="type" id="tranType" class="form-control">
                                    @foreach($types as $value => $text)
                                    <option value="{!! $value !!}" @if(old('type') == $value) {{ 'selected' }} @endif>{!! $text !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Wallet" class="col-md-4 control-label">Chọn ví</label>
                            <div class="col-md-6">
                                <select name="wallet_id" class="form-control">

                                    @foreach($wallets as $wallet)
                                    <option value="{!! $wallet['id'] !!}" @if(old('wallet_id') == $wallet['id']) {{ 'selected' }} @endif>{!! $wallet['name'] !!}</option>
                                    @endforeach         
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tên giao dịch</label>

                            <div class="col-md-6">
                                <select class="form-control" id="tranTypeExpense" name="transaction_id"  value="{{ old('parent_id') }}">                                   
                                    @foreach($tranExpense as $transaction)
                                    <option  value="{!! $transaction['id'] !!}" @if(old('transaction_id') == $transaction['id']) {{ 'selected' }} @endif>{!! $transaction['name'] !!}</option>
                                    @endforeach
                                </select>
                                <select class="form-control hidden" id="tranTypeIncome" name="transaction_id"  value="{{ old('parent_id') }}">                                   
                                    @foreach($tranIncome as $transaction)
                                    <option  value="{!! $transaction['id'] !!}" @if(old('transaction_id') == $transaction['id']) {{ 'selected' }} @endif>{!! $transaction['name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-4 control-label">Nội dung giao dịch</label>

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
                                <input id="money" type="number" class="form-control" name="money" value="{{ old('money') }}">

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
                                    Tạo giao dịch
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $("#tranTypeIncome").attr('disabled', 'disabled');
        $("#tranType").on('change', function () {
            var type = $(this).val();
            if (type == 0) {
                $("#tranTypeExpense").removeClass('hidden');
                $("#tranTypeIncome").addClass('hidden');
                $("#tranTypeExpense").attr('disabled', false);
                $("#tranTypeIncome").attr('disabled', 'disabled');
            } else {
                $("#tranTypeIncome").removeClass('hidden');
                $("#tranTypeExpense").addClass('hidden');
                $("#tranTypeIncome").attr('disabled', false);
                $("#tranTypeExpense").attr('disabled', 'disabled');
            }
        });
    });
</script>
@endsection