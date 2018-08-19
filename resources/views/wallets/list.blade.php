
@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-12">
                    <table id="myTable" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tên ví</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tiền trong ví</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="" style="width: 150px">Xử lý</th></tr>
                        </thead>
                        <tbody>
                            @foreach($wallets as $wallet)
                            <tr role="row" class="odd">
                                <td>{{ $wallet->name }}</td>
                                <td>{{ $wallet->money }}</td>
                                <td>
                                    <div>
                                        <a class="btn btn-primary" href="wallet/{{ $wallet->id }}/edit">Edit</a>
                                        <a class="btn btn-danger btn-delete" href="wallet/{{ $wallet->id }}/delete">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:flex; justify-content:center;align-items:center;">
                        {{ $wallets->links() }}
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
        $('.btn-delete').on('click', function (e) {
           e.preventDefault();
           var confirmed = confirm('Bạn có chắc chắn xóa ví này?');
           var url = $(this).attr('href');
           if (confirmed) {
               return window.location.replace(url);
           }
        });
    </script>
@endsection