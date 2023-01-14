@push('scripts')
    <script src="{{ asset('js/gateway.js') }}"></script>
@endpush

@php

    use App\Helpers\NumpadHelper;
    use App\Helpers\StringHelper;
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\KeyHelper;

    use App\Models\Setting;
    use App\Models\Person;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Receipt;

    $route = Str::before(Request::route()->getName(), '.'); 
   
    $openControlID = '';
    $closeControlID = 'hidden';
    
    $disabled = 'disabled';

    if ($route == 'home' || Str::contains($route, 'api')) {
        $array = [
            'name',
            'value',
            'setting_key_group',
            'setting_key_type',
        ];
    }else{
        $disabled = '';
    }
  
    if ( Session::has('user-session-'.Auth::user()->user_id.'.setupList')) {
        $data['setupList'] = Session::get('user-session-'.Auth::user()->user_id.'.setupList');
    }
   
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

   
    if(Session::has('user-session-'.Auth::user()->user_id.'.cartList')){
        $stockList = Session::get('user-session-'.Auth::user()->user_id.'.cartList');
        // /$stockList = Receipt::SessionCartInitialize($data['cartList'], $data['setupList']);
    }
  
@endphp

@include('receipt.partial.tablePartial')