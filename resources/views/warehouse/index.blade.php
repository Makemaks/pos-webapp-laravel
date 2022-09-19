@extends('layout.master')


@section('content')  

    <div>
        {{-- @include('warehouse.partial.indexPartial') --}}
        @include('stock.partial.transferPartial')
    </div>

    {{-- @include('partial.paginationPartial', ['paginator' => $data['warehouseList']]) --}}
@endsection