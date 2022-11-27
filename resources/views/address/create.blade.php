@extends('layout.master')



@section('content')
    <form id="store-update" action="{{route('address.store')}}" method="POST">
        @csrf
        <div class="uk-container uk-container-xsmall">
            @include('address.partial.createPartial')
        </div>
        
   </form>
@endsection