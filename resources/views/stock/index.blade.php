@extends('layout.master')

@php
   use App\Models\stock;
   foreach ($data['storeList'] as $key => $value) {
        $searchArray[] = [
            'value' => $value->store_id,
            'text' => $value->store_name
        ];
    }
@endphp

@section('content')   
  

   <div>
      <form action="{{route('stock.store')}}" enctype="multipart/form-data" method="POST" >
         @csrf
         @include('partial.uploadPartial')
      </form>
   </div>

   
   @include('stock.partial.indexPartial')
@endsection
