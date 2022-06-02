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
        @else
            <div class="uk-alert-danger uk-border-rounded" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>No data to display.</p>
            </div>
        @endif
        </div>
    </form>
@endsection
