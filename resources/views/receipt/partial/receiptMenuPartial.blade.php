@php
    use App\Models\Person;
    $openControlID = '';
    $closeControlID = 'hidden';

   

    if ( count( Session::get('user-session-'.Auth::user()->user_id.'.'.'setupList'.'.'.'0'.'.'.'customer') ) > 0 ) {
        
        
        $setupList =  Session::get('user-session-'.Auth::user()->user_id.'.'.'setupList'.'.'.'0'.'.'.'customer');
        $data['personModel'] = Person::find($setupList['value']);
        $removeCustomerID = '';
        $showCustomerID = 'hidden';
    }else{
        $removeCustomerID = 'hidden';
        $showCustomerID = '';
    }

    if ( Session::has('user-session-' . Auth::user()->user_id . '.cartList') ) {
        
        if (Session::has('edit_cart') && count( Session::get('user-session-' . Auth::user()->user_id . '.cartList'))  >= 1) {
            $a = Session::get('user-session-' . Auth::user()->user_id . '.cartList');
            $openControlID = 'hidden';
            $closeControlID = '';
        }

    }
   
    
@endphp


<div class="uk-margin-remove-bottom" uk-grid>

    <div class="uk-width-expand">
            
        <div id="useCustomerID">
            @include('person.partial.personPartial', ['data' => $data, 'view' => 'receipt'])
        </div>

    </div>

    <div class="uk-align-right">

        <div class="uk-button-group">

            <div id="showCustomerID" {{$showCustomerID}}>
                <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="showCustomer()" uk-icon="user">
                    <span uk-icon="plus"></span>
                </button>
            </div>
            
            <div id="removeCustomerID" {{$removeCustomerID}}>
                <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="removeCustomer()" uk-icon="user">
                    <span uk-icon="minus"></span>
                </button>
            </div>

            <div class="uk-inline">
                <button class="uk-button uk-button-default  uk-border-rounded" type="button" uk-icon="file-text">
                    {{-- <span uk-icon="plus"></span> --}}
                </button>
                <div uk-dropdown="mode: click">
                    <ul class="uk-nav uk-dropdown-nav">
                  
                       
                        <li class="uk-nav-header" uk-icon="icon: cart"></li>
                        <li> <button class="uk-margin-small uk-button uk-button-default uk-border-rounded uk-width-expand" onclick="update(this)">
                            Discount</button></li>
                        <li> <button class="uk-margin-small uk-button uk-button-default uk-border-rounded uk-width-expand" onclick="update(this)">
                            Delivery</button></li>
                        <li> <button class="uk-margin-small uk-button uk-button-default uk-border-rounded uk-width-expand" onclick="update(this)">
                            Refund</button></li>
                        <li> <button class="uk-margin-small uk-button uk-button-default uk-border-rounded uk-width-expand" onclick="update(this)">
                            Float</button></li>
                      
                    </ul>
                </div>
            </div>

            <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="control(0)" uk-icon="pencil" {{$openControlID}}></button>
            <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="control(1)" uk-icon="close" id="controlHideID" {{$closeControlID}}></button>
        </div>

    </div>
  
</div>



