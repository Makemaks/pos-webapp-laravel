@extends('layout.master')

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
@endpush
@section('content')  

    <div>
        @include('stock.partial.accountPartial')
    </div>

    {{-- @include('partial.paginationPartial', ['paginator' => $data['warehouseList']]) --}}
@endsection