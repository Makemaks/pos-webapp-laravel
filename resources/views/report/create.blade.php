@extends('document.layout')
@php
$alltime = false;
if (Session::has('date')) {
    if (session('date')['started_at'] === '0000-00-00 00:00:00') {
        $alltime = true;
        $title = session('user')['title'];
    }
} else {
    $title = '';
}
if (Session::has('user')) {
    if (session('user')['started_at'] === '0000-00-00 00:00:00') {
        $alltime = true;
        $title = session('user')['title'];
    }
} else {
    $title = '';
}

if (Session::has('title')) {
    $title = session('title')['title'];
}
@endphp
@if ($alltime == true)
    @if (Session::has('date'))
        <p class="uk-text-center" style="font-size: 12px;">Date Range From : ALL TIME</p>
    @endif
    @if (Session::has('user'))
        @php
            $person_id = App\Models\User::find(session('user')['user_id']);
            $staffName = App\Models\Person::find($person_id->user_person_id);
            
        @endphp
        <p class="uk-text-center" style="font-size: 12px;">Date Range From : ALL TIME </p>
        <p class="uk-text-center" style="font-size: 12px;">Staff :
            {{ $staffName->person_name['person_firstname'] }}
            {{ $staffName->person_name['person_lastname'] }}</p>
    @endif
@else
    @if (Session::has('date'))
        <p class="uk-text-center" style="font-size: 12px;">Date Range From : {{ session('date')['started_at'] }} to
            {{ session('date')['ended_at'] }}</p>
    @endif
    @if (Session::has('user'))
        @php
            $person_id = App\Models\User::find(session('user')['user_id']);
            $staffName = App\Models\Person::find($person_id->user_person_id);
            
        @endphp
        <p class="uk-text-center" style="font-size: 12px;">Date Range From : {{ session('user')['started_at'] }} to
            {{ session('user')['ended_at'] }}</p>
        <p class="uk-text-center" style="font-size: 12px;">Staff :
            {{ $staffName->person_name['person_firstname'] }}
            {{ $staffName->person_name['person_lastname'] }}</p>
    @endif
@endif
@section('content')
    <div style="margin-top:-15px;"></div>
    @if ($data['pdfView'])
        {!! $data['pdfView'] !!}
    @endif

    @if ($data['csvView'])
        {!! $data['csvView'] !!}
    @endif
@endsection
