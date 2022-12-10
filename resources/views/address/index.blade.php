@extends('layout.master')

@inject ('personModel', 'App\Models\Person')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')

@section('content')
   <div> @include('stock.partial.addressPartial')</div>
@endsection