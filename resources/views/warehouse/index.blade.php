@extends('layout.master')

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
@endpush
@section('content')  

    <div>
        {{-- @include('warehouse.partial.indexPartial') --}}
        @include('stock.partial.transferPartial')
    </div>

    {{-- @include('partial.paginationPartial', ['paginator' => $data['warehouseList']]) --}}
@endsection