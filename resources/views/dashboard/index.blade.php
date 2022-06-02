@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
@endpush

@section('content')
    <div class="">
        <div>
            @include('dashboard.partial.datePeriodPartial')
        </div>

        <div class="uk-margin uk-child-width-1-2@l uk-grid-match" uk-grid>

            {{-- fixed totals --}}
            <div>
                @include('dashboard.partial.fixedTotalPartial')
                @include('document.button', ['table' => 'fixedTotalPartial'])
            </div>

            {{-- category 1 sales / DEPARTMEN TOTAL --}}
           <div>
                @include('dashboard.partial.departmentTotalPartial')
                @include('document.button', ['table' => 'departmentTotalPartial'])
           </div>

            {{-- group 0 sales --}}
            <div>
                @include('dashboard.partial.groupTotalPartial')
                @include('document.button', ['table' => 'groupTotalPartial'])
            </div>

            {{-- TOP CUSTOMERS --}}
            <div>
                @include('dashboard.partial.topCustomerPartial')
                @include('document.button', ['table' => 'topCustomerPartial'])
            </div>

            {{-- Transaction Key --}}
            <div>
                @include('dashboard.partial.transactionKeyPartial')
                @include('document.button', ['table' => 'transactionKeyPartial'])
            </div>

            {{-- Clerk Breakdown --}}
            <div>
                @include('dashboard.partial.clerkBreakdownPartial')
                @include('document.button', ['table' => 'clerkBreakdownPartial'])
            </div>

            {{-- FINALISE Key --}}
            <div>
                @include('dashboard.partial.finaliseKeyPartial')
                @include('document.button', ['table' => 'finaliseKeyPartial'])
            </div>

            {{-- last 100 sales --}}
            <div>
                @include('dashboard.partial.last100SalePartial')
                @include('document.button', ['table' => 'last100SalePartial'])
            </div>

            {{-- Specials Manager --}}
            <div>
                @include('dashboard.partial.specialsManagerPartial')
                @include('document.button', ['table' => 'specialsManagerPartial'])
            </div>

            {{-- EMPLOYEE TIME AND ATTENDANCE --}}
            <div>
                @include('dashboard.partial.employeePartial')
                @include('document.button', ['table' => 'employeePartial'])
            </div>

            {{-- Plu 0 sales --}}
            <div>
                @include('dashboard.partial.pluSalesPartial')
                @include('document.button', ['table' => 'pluSalesPartial'])
            </div>

            {{-- HOURLY BREAKDOWN --}}
            <div>
                @include('dashboard.partial.hourlyBreakdownPartial')
                @include('document.button', ['table' => 'hourlyBreakdownPartial'])
            </div>

            {{-- SALES BREAKDOWN BY SITE --}}
            <div>
                @include('dashboard.partial.salesBreakdownBySitePartial')
                @include('document.button', ['table' => 'salesBreakdownBySitePartial'])
            </div>

            {{-- STOCK SEARCH --}}
            <div>
                @include('dashboard.partial.stockSearchPartial')
                @include('document.button', ['table' => 'stockSearchPartial'])
            </div>

            {{-- PENDING UPDATES --}}
            <div>
                @include('dashboard.partial.pendingUpdatesPartial')
                @include('document.button', ['table' => 'pendingUpdatesPartial'])
            </div>

            {{-- EAT IN EAT OUT --}}
            <div>
                @include('dashboard.partial.eatInEatOutPartial')
                @include('document.button', ['table' => 'eatInEatOutPartial'])
            </div>

            {{-- LAST Z READ --}}
            <div>
                @include('dashboard.partial.lastZReadPartial')
                @include('document.button', ['table' => 'lastZReadPartial'])
            </div>

            {{-- GP SALES --}}
            <div>
                @include('dashboard.partial.GPSalesPartial')
                @include('document.button', ['table' => 'GPSalesPartial'])
            </div>

            {{-- GP OVERVIEW --}}
            <div>
                @include('dashboard.partial.GPOverviewPartial')
                @include('document.button', ['table' => 'GPOverviewPartial'])
            </div>

        </div>
    </div>
@endsection
