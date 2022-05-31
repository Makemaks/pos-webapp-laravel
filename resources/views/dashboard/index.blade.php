@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
@endpush

@php
$route = Str::before(Request::route()->getName(), '.');
@endphp

@section('content')
    <div class="">
        <div>
            @include('dashboard.partial.datePeriodPartial')
        </div>

        <div class="uk-margin uk-child-width-1-2@l" uk-grid uk-height-match style="margin-top: 5vh !important;">

            {{-- fixed totals --}}
            @include('dashboard.partial.fixedTotalPartial')

            {{-- category 1 sales / DEPARTMEN TOTAL --}}
            @include('dashboard.partial.departmentTotalPartial')

            {{-- group 0 sales --}}
            @include('dashboard.partial.groupTotalPartial')

            {{-- TOP CUSTOMERS --}}
            @include('dashboard.partial.topCustomerPartial')

            {{-- Transaction Key --}}
            @include('dashboard.partial.transactionKeyPartial')

            {{-- Clerk Breakdown --}}
            @include('dashboard.partial.clerkBreakdownPartial')

            {{-- FINALISE Key --}}
            @include('dashboard.partial.finaliseKeyPartial')

            {{-- last 100 sales --}}
            @include('dashboard.partial.last100SalePartial')

            {{-- Specials Manager --}}
            @include('dashboard.partial.specialsManagerPartial')

            {{-- EMPLOYEE TIME AND ATTENDANCE --}}
            @include('dashboard.partial.employeePartial')

            {{-- Plu 0 sales --}}
            @include('dashboard.partial.pluSalesPartial')

            {{-- HOURLY BREAKDOWN --}}
            @include('dashboard.partial.hourlyBreakdownPartial')

            {{-- SALES BREAKDOWN BY SITE --}}
            @include('dashboard.partial.salesBreakdownBySitePartial')

            {{-- STOCK SEARCH --}}
            @include('dashboard.partial.stockSearchPartial')

            {{-- PENDING UPDATES --}}
            @include('dashboard.partial.pendingUpdatesPartial')

            {{-- EAT IN EAT OUT --}}
            @include('dashboard.partial.eatInEatOutPartial')

            {{-- LAST Z READ --}}
            @include('dashboard.partial.lastZReadPartial')

            {{-- GP SALES --}}
            @include('dashboard.partial.GPSalesPartial')

            {{-- GP OVERVIEW --}}
            @include('dashboard.partial.GPOverviewPartial')

        </div>
    </div>
@endsection
