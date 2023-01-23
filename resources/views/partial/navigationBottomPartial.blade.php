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
    $awaitingCartList = [];


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

            <div class="uk-navbar-item" id="useCustomerID">
                @include('person.partial.personPartial', ['data' => $data, 'view' => 'receipt'])
            </div>
    

           <div class="uk-navbar-item">
                <div class="uk-button-group">
               
                </div>
           </div>
     
        </div>

       

        <div class="uk-navbar-right uk-margin-right">



            <div class="uk-navbar-item" id="cancelButtonID" hidden>
                <button class="uk-button uk-border-rounded uk-button-large uk-light" type="button" style="background-color: #{{StringHelper::getColor()}}" onclick="SettingKey('cancel')">
                    CANCEL
               </button>
            </div> 

          

            <div class="uk-navbar-item" id="confirmButtonID">
               <form id="order-store" action="{{route( 'order.store') }}" method="POST">
                    @csrf
               </form>
               <button form="order-store" value="order_setting_key" type="submit" class="uk-button uk-border-rounded uk-button-large uk-light" type="button" style="background-color: #{{StringHelper::getColor()}}">
                    CONFIRM
                </button>
            </div>

          
            <div class="uk-navbar-item" id="payButtonID" hidden>
                <button class="uk-button uk-border-rounded uk-button-large uk-light" onclick="StoreSettingKey()" type="button" style="background-color: #{{StringHelper::getColor()}}">
                    <span uk-icon="tag"></span>
                </button>
            </div>


        </div>

    </nav>
</div>
