@php
    if(isset($active) == false){
        $active = '0';
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
            <form id="settingKeyListID" action="{{route('setting.update', isset($data['settingModel']->setting_id))}}" method="POST">
                @csrf
                @method('PATCH')
                @include('setting.settingKey.index')
            </form>
        </li>

        <li>
           
            <form action="{{ route('setting.store') }}" method="POST" class="uk-form-stacked" id="settingKeyFormID">
                @csrf
                @include('setting.settingKey.create')
            <form>
        </li>
    </ul>
</div>
