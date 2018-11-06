
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
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tên</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Giới tính</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Ngày sinh</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="" style="width: 150px">Xử lý</th></tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr role="row" class="odd">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->gender !== null ? $genders[$user->gender] : '' }}</td>
                                <td>{{ $user->birthday }}</td>
                                <td>
                                    <div>
                                        <a class="btn btn-primary" href="information/{{ $user->id }}/edit">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:flex; justify-content:center;align-items:center;">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.box -->

</section>
<!--/.content -->
@endsection
