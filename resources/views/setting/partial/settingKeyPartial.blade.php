@php

    $route = Str::before(Request::route()->getName(), '.');
    $active = '0';

    if (Str::contains($route, 'home')) {
        $active = '1';
    }

    if (Session::has('view') == false) {
        Session::flash('view', 'Setting Key');
    }
@endphp

<div>
  
    <ul class="uk-subnav uk-subnav-pill" uk-switcher='active:{{$active}}'>
        <li>
            <a href="#">{{Str::upper(Session::get('view'))}}</a>
        </li>
        <li ><a href="#" uk-icon="plus"></a></li>
    </ul>      

    <ul class="uk-switcher uk-margin">
        <li>
           
                @include('setting.settingKey.index')
            
        </li>

        <li>
           
            
                @include('setting.settingKey.create')
            
        </li>
    </ul>
</div>
