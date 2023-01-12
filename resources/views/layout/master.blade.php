@php
    use App\Models\Store;
    use App\Models\User;
    $route = Str::before(Request::route()->getName(), '.');
    $action = Request::session()->get('action');
    $view = Request::session()->get('view');
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

    <script src="{{asset('js/app.js')}}"></script>
   
</head>

<body id="screen-lock">

    <div class="uk-box-shadow-small">
        @include('partial.navigationPartial')
    </div>
    
    <div class="uk-container uk-container-expand uk-margin-top">
      
        <div class="uk-grid-collapse" uk-grid>

            @auth
                
                <div class="uk-width-auto@m">
                    <div>
                        @include('partial.menuPartial')
                    </div>
                </div>

            @endauth

            <div class="uk-width-expand@m uk-padding-small">
                @yield('content')
            </div>

            @auth
                
                @if ($route == 'home')
                    <div class="uk-width-1-3@s uk-padding-small">

                        @if($route == 'home')
                        
                            <div id="receiptID">
                                @include('receipt.partial.indexPartial')
                            </div>
                            
                        @endif

                    </div>
                @endif
            @endauth
            
        </div>

        @if ($route == 'home')
            <div class="uk-position-bottom uk-background-default uk-box-shadow-large" style="z-index: 2;">
                @include('partial.numpadPartial')
            </div>
           
            
        @endif

     
    </div>

    @auth
        <div id="modal-lock-screen-center" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h1>Locked <span uk-icon="icon: lock"></span></h1>
                @include('partial.userAuthCheckPartial')
            </div>
        </div>
    @endauth



   @if ($route == 'home')
        <div class="uk-box-shadow-small uk-position-bottom" id="navigationBottomID">
            @include('partial.navigationBottomPartial')
        </div>
   @endif

    <!-- UIkit JS -->
    @stack('scripts')
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

    {{-- chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

</body>

</html>
