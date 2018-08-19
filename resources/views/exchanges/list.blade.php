@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <div>
                <select id="tranType" class="form-group">

                    <option value="0">Chi tiêu</option>
                    <option value="1">Thu nhập</option>
                </select>
            </div>

            <div class="row">
                <div class="col-sm-12" id="typeExpense">
                    <table id="myTable" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tên giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Ví giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Nội dung giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tiền giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Thời gian giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="" style="width: 150px">Xử lý</th></tr>
                        </thead>
                        <tbody>
                            @foreach($exchange_expense as $exchange)
                            <tr role="row" class="odd">
                                <td>{{ $exchange->transaction_id ? $transactions[$exchange->transaction_id]['name'] : '' }}</td>
                                <td>{{ $exchange->wallet_id ? $wallets[$exchange->wallet_id]['name'] : '' }}</td>
                                <td>{{ $exchange->content }}</td>
                                <td>{{ $exchange->money }}</td>
                                <td>{{ $exchange->date }}</td>
                                <td>
                                    <div>
                                        <a class="btn btn-primary" href="exchange/{{ $exchange->id }}/edit">Edit</a>
                                        <a class="btn btn-danger btn-delete" href="exchange/{{ $exchange->id }}/delete">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:flex; justify-content:center;align-items:center;">
                        {{ $exchange_expense->links() }}
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="typeIncome">
                    <table id="myTable" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tên giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Ví giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Nội dung giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tiền giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Thời gian giao dịch</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="" style="width: 150px">Xử lý</th></tr>
                        </thead>
                        <tbody>
                            @foreach($exchange_income as $exchange)
                            <tr role="row" class="odd">
                                <td>{{ $exchange->transaction_id ? $transactions[$exchange->transaction_id]['name'] : '' }}</td>
                                <td>{{ $exchange->wallet_id ? $wallets[$exchange->wallet_id]['name'] : '' }}</td>
                                <td>{{ $exchange->content }}</td>
                                <td>{{ $exchange->money }}</td>
                                <td>{{ $exchange->date }}</td>
                                <td>
                                    <div>
                                        <a class="btn btn-primary" href="exchange/{{ $exchange->id }}/edit">Edit</a>
                                        <a class="btn btn-danger btn-delete" href="exchange/{{ $exchange->id }}/delete">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:flex; justify-content:center;align-items:center;">
                        {{ $exchange_income->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.box -->

</section>
<!--/.content -->
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $("#tranType").on('change', function () {
            var type = $(this).val();
            if(type == 0){
                $("#typeExpense").removeClass('hidden');
                $("#typeIncome").addClass('hidden');
            }
            else{
                $("#typeIncome").removeClass('hidden');
                $("#typeExpense").addClass('hidden');
            }
        });
        $('.btn-delete').on('click', function (e) {
            e.preventDefault();
            var confirmed = confirm('Bạn có chắc chắn xóa trường này?');
            var url = $(this).attr('href');
            if (confirmed) {
                return window.location.replace(url);
            }
        });
    });
</script>
@endsection