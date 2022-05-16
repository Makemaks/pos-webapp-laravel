@php
        use App\Helpers\ControllerHelper;
        use App\Models\User;

       
        $arrayAdminMenu = [
            "home" => [],
            "report" => [],
            "product" => [],
            "stock" => [

                "stock-list",
                "order",
                "transfer",
                "wastage",
                "return",
                "ins-&-out",
                "supplier",
                "case-size",
                "recipe",
                "start-stocktake",
                "stock-variance",

            ],
            "clerk" => [],
            "programming" => [
                "category",
                "group",
                "plu",
                "mix-&-match",
                "mix-&-match-2",
                "finalise-key",
                "status-keys,",
                "transaction-key",
                "fixed-character",
                "fixed-totaliser",
                "keyboard-menu-level",
                "keyboard-allocation",
                "receipt",
                "tag",
                "tag",
                "voucher",
                "reason",
                "tax",
                "non-plu",
                "kp-categorie",
                "preset-message",
                "price-level-scheduler",
            ],
            "sale" => [
                "sale-explorer",
                "till-report",
                "bill-report",
            ],
            "customer" => [
                "customer-group"
            ],
            "ticket" => [],
            

        ];
@endphp


<div>
    <ul  class="uk-nav-default uk-nav-parent-icon" uk-nav>
        
            @foreach ( $arrayAdminMenu as $key => $arrayMenu)
                
                @php
                    $keyReplace = $key;

                    if ($key == 'product') {
                        $keyReplace= 'stock';
                    }elseif($key == 'clerk'){
                        $keyReplace = 'user';
                    }
                    elseif($key == 'programming'){
                        $keyReplace = 'setting';
                    }
                    elseif($key == 'sale'){
                        $keyReplace = 'order';
                    }
                    elseif($key == 'customer'){
                        $keyReplace = 'person';
                    }

                @endphp

                @if (count($arrayMenu) == 0)
                    <li>
                        <a class="uk-active" href="{{route($keyReplace.'.index')}}">
                            {{Str::upper($key)}}
                        </a>
                    </li>
                @else
                    <li class="uk-parent">
                        <a href="#">{{Str::upper($keyReplace)}}</a>

                        <ul class="uk-nav-sub">
                            @foreach ($arrayMenu as $item)
                                @php
                                    if($item == $route){
                                        $active = 'uk-padding-small uk-box-shadow-small uk-text-danger uk-border-rounded';
                                    }
                                    else{
                                        $active = '';
                                    }
                                @endphp
                        
                            
                                <li>
                                    <a class="uk-link-reset" href="{{route('menu.'.$keyReplace,['view' => $item])}}">
                                        {{Str::upper(Str::replace('-', ' ', $item))}}
                                    </a>
                                </li>
                                
                            @endforeach
                        </ul>
                        
                    </li>
                @endif

            @endforeach
        
        <li class="uk-nav-divider"></li>

        @if (User::UserType()[Auth::User()->user_type] == 'Super Admin' || User::UserType()[Auth::User()->user_type] == 'User')
            <li><a class="uk-margin-small uk-button uk-button-default uk-text-danger" href="">ADMIN</a></li>
        @endif
    </ul>
</div>
