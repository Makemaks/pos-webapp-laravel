@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
@endpush

@php
    $route = Str::before(Request::route()->getName(), '.');

@endphp


@section('content')
    <div class="">


        <div class="uk-margin">
            @include('partial.reportPartial')
        </div>

        <div class="uk-child-width-1-2@s uk-grid-match" uk-grid>

            {{-- fixed totals --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.fixedTotalPartial')
                    @include('document.button', ['table' => 'fixedTotalPartial'])
                </div>
            </div>

            

        </div>
    </div>
@endsection
