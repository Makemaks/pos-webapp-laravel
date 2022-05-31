@php
$route = Str::before(Request::route()->getName(), '.');
if ($data['table'] !== '') {
    $table = $data['table'];
} else {
    $table = '';
}
@endphp

@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
@endpush
@section('content')
    <form action="{{ route($route . '.index') }}" method="GET">
        <div class="">
            @include('report.partial.dropDownPartial')
        </div>
        <hr>
        {{-- results --}}
        @if ($table !== '')
            @include('report.partial.pages.' . $table)
        @endif
        </div>
    </form>
@endsection
