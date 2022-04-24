@extends('layout.master')


@section('content')  

    <div>
        @include('user.partial.indexPartial')
    </div>

    @include('partial.paginationPartial', ['paginator' => $data['userList']])
@endsection