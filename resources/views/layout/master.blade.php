@php
use App\Models\Store;
$route = Str::before(Request::route()->getName(), '.');

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | {{ Str::ucfirst($route) }} </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/color.css') }}">

    {{-- stripe --}}
    <script src="https://js.stripe.com/v3/"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <script src="https://jsuites.net/v4/jsuites.webcomponents.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
</head>

<style>
    table {
        border-collapse: collapse;
        font-size: 11px !important;
    }

    .scroll tbody {
        display: block;
        height: 440px;
        overflow: auto;
    }

    .scroll thead,
    .scroll tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
        /* even columns width , fix width of table too*/
    }

</style>

<body>

    <div class="uk-box-shadow-small">
        @include('partial.navigationPartial')
    </div>

    <div>
        <div class="uk-container uk-container-expand">
            <div uk-grid>

                @auth
                    <div class="uk-width-medium@m uk-background-secondary uk-padding">
                        @include('partial.menuPartial')
                    </div>
                @endauth

                <div class="uk-width-expand@m uk-padding">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>


    <!-- UIkit JS -->
    @stack('scripts')
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

    {{-- chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

</body>

</html>
