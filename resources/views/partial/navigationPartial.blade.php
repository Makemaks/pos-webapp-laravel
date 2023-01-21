@php
use App\Models\User;
use App\Models\Store;
use App\Models\Receipt;
use App\Models\Setting;
use App\Models\Attendance;
use App\Helpers\ControllerHelper;
use App\Helpers\DateTimeHelper;

    $route = Str::before(Request::route()->getName(), '.');

   if (Auth::check()) {

        $userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $storeModel = Store::Account('store_id', $userModel->store_id)->first();
        $storeList = Store::List('root_store_id', $storeModel->store_id)
        ->orWhere('store_id', $storeModel->store_id)
        ->get();
    }

    $count = 0;
    $cartList = null;
    $awaitingCartList = [];

    if (Auth::check()) {
        if (Session::has('user-session-' . Auth::user()->user_id . '.cartList')) {
            $cartList = Session::get('user-session-' . Auth::user()->user_id . '.cartList');
            $count = count($cartList);
        }
    }
@endphp


<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">
    <nav class="uk-background-default" uk-navbar style="position: relative; z-index: 980;">

        <div class="uk-navbar-left">

            

            <div class="uk-navbar-item uk-visible@s">
                <div>
                    @isset($storeModel)
                        <h3 class="uk-margin-remove-bottom" title="S{{$storeModel->store_id}} : A{{$userModel->person_account_id}}">{{$storeModel->company_name}}</h3>
                        <p class="uk-text-meta uk-margin-remove-top" title="S{{$storeModel->store_id}} : A{{$userModel->person_account_id}}">{{$storeModel->store_name}}</p>
                    @endisset
                </div>
            </div>

            @auth
            
                @if (User::UserType()[Auth::User()->user_type] == 'Super Admin' && User::UserType()[Auth::User()->user_type] == 'Admin' || $route != 'home')
                    
                   
                    <div class="uk-navbar-item uk-visible@s">
                        <div>
                        
                            <form action="{{route('home.index')}}">
                                @csrf
                                <select name="store-form" class="uk-select" onchange="this.form.submit()">
                                    <option selected disabled></option>
                                    
                                    @isset($storeList)
                                        @foreach ($storeList as $store)
                                            <option value="{{$store->store_id}}" @if($store->store_id == $storeModel->store_id) selected  @endif>{{$store->store_name}} - {{$store->store_id}} - {{$storeModel->store_id}}</option>
                                        @endforeach
                                    @endisset
                                    
                                </select>
                            </form>
                        
                            
                        </div>
                    </div>
                    
                @endif

            @endauth

           {{-- <div class="uk-navbar-item">
                <div class="uk-button-group">
                    <div class="">
                        <button onclick="setFocus('barcodeInputID')" uk-icon="list" class="uk-button uk-button-default uk-border-rounded"></button>
                        <input type="text" id="barcodeInputID" hidden>
                    </div>
                
                    <div class="">
                        <button onclick="createSearch()" uk-icon="plus" class="uk-button uk-button-default uk-border-rounded"></button>
                    </div>
                
                    
                
                <div class="">
                        <button uk-icon="grid" onclick="showKeypad()" class="uk-button uk-button-default uk-border-rounded"></button>
                    </div>
                </div>
           </div>
      --}}
        </div>

        <div class="uk-navbar-center">
            @if ($route == 'home')
                <div class="uk-navbar-item">
                    <div class="uk-button-group">
                        <input id="searchInputID" class="uk-input uk-form-width-large" type="text" autofocus onclick="showKeypad()" 
                        onchange="searchInput(this)" autocomplete="off">

                        <div class="uk-button-group">
                        {{--  <button class="uk-button uk-button-default">Dropdown</button> --}}
                            <div class="uk-inline">
                                <button class="uk-button uk-button-default" type="button"><span uk-icon="icon:  triangle-down"></span></button>
                                <div uk-dropdown="mode: click; boundary: ! .uk-button-group; boundary-align: true;">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <li class="uk-active"><a href="#">Stock</a></li>
                                        
                                
                                        <li class="uk-nav-header">Header</li>
                                        <li><a href="#">Item</a></li>
                                        <li><a href="#">Item</a></li>
                                        <li class="uk-nav-divider"></li>
                                        <li><a href="#">Item</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="uk-navbar-right uk-margin-right">
            @include('partial.crudPartial')


            <div class="uk-navbar-item">
                <div class="uk-button-group">
                    <a class="uk-button uk-button-default uk-border-rounded" href="{{ route('home.index') }}">
                        <span uk-icon="home"></span>
                    </a>
                    <div class="uk-inline">
                        <button class="uk-border-rounded uk-button uk-button-default" type="button">
                            <span uk-icon="icon: cart"></span>
                            <span id="cartCountID" class="uk-label"> {{ $count }}</span>
                        </button>

                        <div uk-dropdown="mode: click; boundary: ! .uk-button-group; boundary-align: true;">
                            <ul class="uk-nav uk-dropdown-nav">
                                <li class="uk-nav-header" uk-icon="icon: cart"></li>
                                <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded" href="{{route('receipt.index', ['view' => 'checkout'])}}">CheckOut</a></li>
                                <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded" href="{{route('receipt.index', ['view' => 'suspend'])}}">Suspend</a></li>
                                <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded" href="{{route('receipt.index', ['view' => 'awaiting'])}}">Awaiting .. </a></li>
                                <li class="uk-nav-header" uk-icon="icon: trash"></li>
                                <li class="uk-nav-divider"></li>
                                <li><a class="uk-margin-small uk-button uk-button-default uk-text-danger uk-border-rounded" href="{{route('receipt.index', ['view' => 'empty'])}}">Empty Cart</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="uk-inline">
                        <button class="uk-border-rounded uk-button uk-button-default" type="button"
                            uk-icon="user">
                        </button>
                        <div uk-dropdown="mode: click">
                            <ul class="uk-nav uk-dropdown-nav">
                                {{-- <li class="uk-nav-header" uk-icon="icon: user"></li> --}}
                                @auth
                                    <li class="uk-nav-header"  uk-icon="user"></li>
                                    <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded"
                                            href="{{ route('user.show', $userModel->user_id) }}">Profile</a></li>
                                    <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded"
                                            href="{{ route('authentication.logout') }}">Logout</a></li>

                                    <li class="uk-nav-header" uk-icon="icon: clock"></li>
                                    <li class="uk-nav-divider"></li>
                                    <li><a class="uk-margin-small uk-button uk-button-default uk-text-danger uk-border-rounded"
                                            href="{{ route('authentication.clock-out') }}">ClockOut</a></li>

                                    
                                    @if (User::UserType()[Auth::User()->user_type] == 'Super Admin' || User::UserType()[Auth::User()->user_type] == 'Admin')
                                        <li class="uk-nav-header" uk-icon="icon: thumbnails"></li>
                                        <li class="uk-nav-divider"></li>
                                        <li><a class="uk-margin-small uk-button uk-button-default uk-text-danger uk-border-rounded"
                                            href="{{ route('dashboard.index') }}">Admin</a></li>
                                    @endif

                                 
                                @else
                                    <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded"
                                            href="{{ route('authentication.login') }}">Login</a></li>
                                    <li><a class="uk-margin-small uk-button uk-button-default uk-border-rounded"
                                            href="{{ route('authentication.register') }}">Register</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>

               
            </div>

            @auth
                <div class="uk-navbar-item">
                    <div>
                        <h3 class="uk-margin-remove-bottom uk-text-right" title="U{{$userModel->user_id}} : A{{$userModel->person_account_id}}">{{ json_decode($userModel->person_name, true)['person_firstname'] }}</h3>
                        <p class="uk-text-meta uk-margin-remove-top" title="S{{$storeModel->store_id}} : P{{$userModel->person_id}}">
                            Clocked in {{DateTimeHelper::DateTime(Attendance::Clock('user_id', $userModel->user_id)->first()->created_at)['time']}}
                        </p>
                    </div>
                </div>
            @endauth


        </div>

    </nav>
</div>
