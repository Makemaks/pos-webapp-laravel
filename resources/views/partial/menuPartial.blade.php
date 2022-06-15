@php
    use App\Helpers\ControllerHelper;
    use App\Models\User;
    use App\Models\Setting;

    $route = Str::before(Request::route()->getName(), '.');

@endphp


@php

   if ($route != 'home') {
        $arrayAdminMenu = [
            "dashboard" => [],
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
                "list-plu",
                "mix-&-match",
                "mix-&-match-2",
                "finalise-key",
                "status-keys",
                "transaction-key",
                "fixed-character",
                "fixed-totaliser",
                "keyboard-menu-level",
                "keyboard-allocation",
                "receipt",
                "tag",
                "tag-group",
                "voucher",
                "reason",
                "tax",
                "non-plu",
                "kp-categorie",
                "preset-message",
                "price-level-scheduler",
            ],
            "sale" => [
                "sale",
                "till",
                "bill",
            ],
            "customer" => [
                "customer-explorer"
            ],
            "ticket" => [],
            

        ];
   } else {
        $arrayAdminMenu = [
         /*   
            
            "home" => [
                "category",
                "group",
                "list-plu",
                "mix-&-match",
                "mix-&-match-2",
                "tag",
                "tag-group",
            ],
            
             */

        ];
   }
   

@endphp

<div>
    <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            
            @foreach ( $arrayAdminMenu as $key => $arrayMenu)
                    
                @php
                    $keyReplace = $key;

                    if ($key == 'product') {
                        $keyReplace= 'stock';
                    }
                    elseif($key == 'clerk'){
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
                    

                    $uk_open ='';
                    if(Str::lower(session::get('action')) == $keyReplace || $keyReplace == $route){
                        $uk_open = 'uk-open';
                    }
                        
                @endphp
                

                @if (count($arrayMenu) == 0)
                    <li>
                        <a href="{{route($keyReplace.'.index')}}">
                            {{Str::upper($key)}}
                        </a>
                    </li>
                @else
                        
                    <li class="uk-parent {{$uk_open}}">
                        <a href="#">{{Str::upper($keyReplace)}}</a>

                        <ul class="uk-nav-sub">
                            @foreach ($arrayMenu as $item)
                                @php
                                    $active = '';
                                    if (SESSION::GET('view') == $item) {
                                        $active = 'uk-text-danger';
                                    }
                                @endphp
                                    
                                <li>
                                    <a href="{{route('menu.'.$keyReplace,['view' => $item])}}">
                                        <span class="{{$active}}">{{Str::upper(Str::replace('-', ' ', $item))}}</span>
                                    </a>
                                </li>
                                    
                            @endforeach
                        </ul>
                            
                    </li>
                @endif

            @endforeach
            
        <li class="uk-nav-divider"></li>
            
    </ul>
</div>