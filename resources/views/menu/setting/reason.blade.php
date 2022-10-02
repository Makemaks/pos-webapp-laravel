@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@section('content')
    <h3>{{Str::upper(Request::get('view'))}}</h3>
    @include('stock.partial.reasonPartial')
@endsection


