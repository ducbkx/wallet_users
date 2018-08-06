@extends('layouts.app')

@section('content')
<div class="col-xs-8 col-xs-offset-2" style="margin-top: 50px;">
    <table class="table table-hover">
        <tr>
            <td>Tên ví</td>
            <td>Tiền trong ví</td>
            <td>Action</td>
        </tr>
        @foreach ($wallets as $wallet)
        <tr>
            <td>{{ $wallet->name }}</td>
            <td>{{ $wallet->money }}</td>          
            <td>
                <a class="btn btn-primary" href="wallet/{{ $wallet->id }}/edit">Edit</a>
                <a class="btn btn-danger" href="wallet/{{ $wallet->id }}/delete">Delete</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div style="display:flex; justify-content:center;align-items:center;">
      {{ $wallets->links() }}
      </div>

</div>
@endsection

