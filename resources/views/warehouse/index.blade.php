@extends('layout.master')

@php
    use App\Models\Warehouse;
    use App\Models\Store;
  
@endphp

@section('content')  

    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li>
    
            <a href="#">
                {{Str::upper(Session::get('view'))}}
            </a>
    
        </li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            @include('warehouse.partial.indexPartial')
        </li>
        <li>
            @include('warehouse.partial.inventoryPartial')
        </li>
    </ul>


    {{-- @include('partial.paginationPartial', ['paginator' => $data['warehouseList']]) --}}
@endsection