@extends('layout.master')

@section('content')    
    <form action="setting.store" method="POST">
        @csrf
        @method('PATCH')
        @include('setting.partial.createPartial')
    </form>

   
@endsection
