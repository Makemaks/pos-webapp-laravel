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
                "status-key",
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
                "set-menu",
                "non-plu",
                "kp-category",
                "preset-message",
                "price-level-scheduler",
            ],
            "sale" => [
                "sale",
                "till",
                "bill",
            ],
            "customer" => [
                "person",
                "company"
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


@if ($route != 'home')
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



                        $uk_open ='';
                        if(Str::lower(Session::get('action')) == $keyReplace || $keyReplace == $route){
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
                                        if (Session::get('view') == $item) {
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

@else


@endif







