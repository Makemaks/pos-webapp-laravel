@extends('layout.master')


@section('content')  

    <div>
        @include('warehouse.partial.indexPartial')
    </div>

    @include('partial.paginationPartial', ['paginator' => $data['warehouseList']])
@endsection