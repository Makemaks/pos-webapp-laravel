@php
        use App\Helpers\ControllerHelper;
        use App\Models\User;

       
        $arrayAdminMenu = [
            "home" => [],
            "report" => [],
            "product" => [],
            "stock" => [

                "Stock List",
                "Orders",
                "Transfers",
                "Wastages",
                "Returns",
                "Ins &amp; Outs",
                "Suppliers",
                "Case Sizes",
                "Recipes",
                "Start StockTake",
                "Stock Variance",

            ],
            "clerk" => [],
            "programming" => [
                "Departments",
                "Groups",
                "List PLUs",
                "Mix &amp; Match",
                "Mix &amp; Match 2",
                "Finalise Keys",
                "Status Keys,",
                "Transaction Keys",
                "Fixed Characters",
                "Fixed Totalisers",
                "Keyboard Menu Levels",
                "Keyboard Allocation",
                "Receipt",
                "Tags",
                "Tag Groups",
                "Vouchers",
                "Reasons",
                "Tax",
                "Non PLUs",
                "KP Categories",
                "Preset Message",
                "Price Level Scheduler",
            ],
            "sale" => [
                "Sales Explorer",
				"Till Reports",
				"Bill Reports",
            ],
            "customer" => [
                "Customer Groups"
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
                                    <a class="uk-link-reset" href="{{route($keyReplace.'.index')}}">
                                        {{Str::upper($item)}}
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
