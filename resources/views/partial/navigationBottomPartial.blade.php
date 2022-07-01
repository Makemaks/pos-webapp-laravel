@php
use App\Models\User;
use App\Models\Store;
use App\Models\Receipt;
use App\Models\Setting;
use App\Models\Person;
use App\Helpers\ControllerHelper;
use App\Helpers\StringHelper;


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
$cartAwaitingList = [];

if (Auth::check()) {
    if (Session::has('user-session-' . Auth::user()->user_id . '.cartList')) {
        $cartList = Session::get('user-session-' . Auth::user()->user_id . '.cartList');
        $count = Receipt::Quantity($cartList);
    }
}
@endphp


<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">
    <nav class="uk-background-default" uk-navbar style="position: relative; z-index: 920;">

        <div class="uk-navbar-left">

           

           <div class="uk-navbar-item">
                <div class="uk-button-group">
               
                </div>
           </div>
     
        </div>

       

        <div class="uk-navbar-right uk-margin-right">

            <div class="uk-navbar-item">
                <div class="uk-button-group">
                   

                    @auth
                        
                        @if (Person::PersonType()[$data['userModel']->person_type] == 'Customer')
                            <div class="uk-inline">
                                <button class="uk-border-rounded uk-button uk-button-default" type="button">Pay</button>
                                <div uk-dropdown="mode: click">
                                    <ul class="uk-nav uk-dropdown-nav">
                                    
                                    </ul>
                                </div>
                            </div>
                        @else
                           
                        @endif

                    @endauth

                </div>
            </div>

            <div class="uk-navbar-item" hidden>
                <a href="{{route( 'order.store', ['order_finalise_key' => Session::get('order_finalise_key')] )}}" class="uk-button uk-border-rounded uk-button-large uk-light" type="button" style="background-color: #{{StringHelper::getColor()}}">
                    CONFIRM
                </a>
            </div>

            <div class="uk-navbar-item">

                <div class="uk-inline">
                    <button class="uk-button uk-border-rounded uk-button-large uk-light" type="button" style="background-color: #{{StringHelper::getColor()}}">
                         PAY 
                    </button>
                    <div uk-dropdown="mode: click">
                        <ul class="uk-nav uk-dropdown-nav">
                      
                           
                            <li class="uk-nav-header" uk-icon="icon: cart"></li>
                           @foreach (Setting::SettingKeyType() as $setting_key)
                            
                                <li><button class="uk-margin-small uk-button uk-button-default uk-border-rounded  uk-width-expand" onclick="finaliseKey('{{Str::lower($setting_key)}}')">
                                    {{ $setting_key}}
                                </button></li>
                             
                           @endforeach
                          
                        </ul>
                    </div>
                </div>
            </div>


        </div>

    </nav>
</div>
