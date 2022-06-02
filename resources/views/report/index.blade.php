@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
@endpush
@section('content')
    <div class="">
        @include('report.partial.dropDownPartial')
        <div>
            @include('dashboard.partial.datePeriodPartial')
        </div>
    </div>
@endsection
