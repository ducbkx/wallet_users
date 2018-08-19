@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Danh mục thu chi</div>

            <div class="panel-body">
                <section class="content">
                    <form class="form-horizontal" action="{{ route('create_transaction') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="Wallet" class="col-md-4 control-label">Kiểu thu chi</label>
                            <div class="col-md-6">
                                <select name="type" id="tranType" class="form-control">
                                    @foreach($types as $value => $text)
                                    <option value="{!! $value !!}">{!! $text !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tên</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))

                                <strong>{{ $errors->first('name') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Parent_id" class="col-md-4 control-label">Nhóm cha</label>
                            <div class="col-md-6">
                                <select class="form-control" id="tranTypeExpense" name="parent_id"  value="{{ old('parent_id') }}">                                   
                                    <option value="0">---</option>
                                    @foreach($tranExpense as $transaction)
                                    <option  value="{!! $transaction['id'] !!}">{!! $transaction['name'] !!}</option>
                                    @endforeach
                                </select>
                                <select class="form-control hidden" id="tranTypeIncome" name="parent_id"  value="{{ old('parent_id') }}">                                   
                                    <option value="0">---</option>
                                    @foreach($tranIncome as $transaction)
                                    <option  value="{!! $transaction['id'] !!}">{!! $transaction['name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Thêm danh mục
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

        $(".form-horizontal").validate({
            rules:
                    {
                        name: {required: true, },
                    },
            messages:
                    {
                        name: {required: "Bạn chưa nhập tên danh mục", },
                    },

        });
        $("#type").change(function () {


        });

    });
</script>
@endsection