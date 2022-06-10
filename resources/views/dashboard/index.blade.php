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

        <div class="uk-child-width-1-2@s uk-grid-match" uk-grid>

            {{-- fixed totals --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.fixedTotalPartial')
                    @include('document.button', ['table' => 'fixedTotalPartial'])
                </div>
            </div>

            {{-- category 1 sales / DEPARTMEN TOTAL --}}
           <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.departmentTotalPartial')
                    @include('document.button', ['table' => 'departmentTotalPartial'])
                </div>
           </div>

            {{-- group 0 sales --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.groupTotalPartial')
                    @include('document.button', ['table' => 'groupTotalPartial'])
                </div>
            </div>

             {{-- Plu 0 sales --}}
             <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.pluSalesPartial')
                    @include('document.button', ['table' => 'pluSalesPartial'])
                </div>
            </div>

            {{-- TOP CUSTOMERS --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.topCustomerPartial')
                    @include('document.button', ['table' => 'topCustomerPartial'])
                </div>
            </div>

            {{-- Transaction Key --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.transactionKeyPartial')
                    @include('document.button', ['table' => 'transactionKeyPartial'])
                </div>
            </div>

            {{-- Clerk Breakdown --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.clerkBreakdownPartial')
                    @include('document.button', ['table' => 'clerkBreakdownPartial'])
                </div>
            </div>

            {{-- FINALISE Key --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.finaliseKeyPartial')
                    @include('document.button', ['table' => 'finaliseKeyPartial'])
                </div>
            </div>

            {{-- last 100 sales --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.last100SalePartial')
                    @include('document.button', ['table' => 'last100SalePartial'])
                </div>
            </div>

            {{-- Specials Manager --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.specialsManagerPartial')
                    @include('document.button', ['table' => 'specialsManagerPartial'])
                </div>
            </div>

            {{-- EMPLOYEE TIME AND ATTENDANCE --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.employeePartial')
                    @include('document.button', ['table' => 'employeePartial'])
                </div>
            </div>

            {{-- HOURLY BREAKDOWN --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.hourlyBreakdownPartial')
                    @include('document.button', ['table' => 'hourlyBreakdownPartial'])
                </div>
            </div>

            {{-- SALES BREAKDOWN BY SITE --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.salesBreakdownBySitePartial')
                    @include('document.button', ['table' => 'salesBreakdownBySitePartial'])
                </div>
            </div>

            {{-- STOCK SEARCH --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.stockSearchPartial')
                    @include('document.button', ['table' => 'stockSearchPartial'])
                </div>
            </div>

            {{-- PENDING UPDATES --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.pendingUpdatesPartial')
                    @include('document.button', ['table' => 'pendingUpdatesPartial'])
                </div>
            </div>

            {{-- EAT IN EAT OUT --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.eatInEatOutPartial')
                    @include('document.button', ['table' => 'eatInEatOutPartial'])
                </div>
            </div>

            {{-- LAST Z READ --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.lastZReadPartial')
                    @include('document.button', ['table' => 'lastZReadPartial'])
                </div>
            </div>

            {{-- GP SALES --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.GPSalesPartial')
                    @include('document.button', ['table' => 'GPSalesPartial'])
                </div>
            </div>

            {{-- GP OVERVIEW --}}
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    @include('dashboard.partial.GPOverviewPartial')
                    @include('document.button', ['table' => 'GPOverviewPartial'])
                </div>
            </div>

        </div>
    </div>
@endsection
