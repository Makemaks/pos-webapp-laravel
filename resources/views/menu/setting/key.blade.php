@extends('layout.master')

@php
    use App\Models\Setting;
@endphp

@section('content')
<div>
    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
        Save
    </button>

    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingDelete" name="settingDelete">
        Delete
    </button>

    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li>
           
            <a href="#">
                {{Str::upper(Session::get('view'))}}
            </a>
           
        </li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>      

    <ul class="uk-switcher uk-margin">
        <li>
            <form id="settingUpdate" action="{{route('setting.update', $data['settingModel']->setting_id)}}" method="POST">
                @csrf
                @method('PATCH')
                @if ($data['settingModel']->setting_key)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach (Arr::first($data['settingModel']->setting_key) as $key => $item)
                                    <th>{{$key}}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['settingModel']->setting_key  as $keysetting_key => $setting_key)
                                @if ($setting_key['group'] == Session::get('group'))
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_key_delete[]" value="{{$keysetting_key}}">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_key}}</button>
                                        </td>
                                        @foreach ($setting_key as $key => $value)

                                            <td>
                                               
                                               
                                                @if ($key == 'value')
                                                    <input class="uk-input" type="number" name="setting_key[{{$keysetting_key}}][{{$key}}]" value="{{$value}}">
                                                @elseif ($key == 'type')
                                                                
                                                    <select class="uk-select" name="setting_key[{{$keysetting_key}}][{{$key}}]">
                                                        <option selected="selected" disabled>SELECT ...</option>
                                                    
                                                        @foreach (Setting::SettingGroup() as $key => $setting_group)
                                                                
                                                            <option @if($key == $setting_key['type']) selected @endif value="setting_key[{{$keysetting_key}}][{{$key}}]">
                                                                {{Str::upper($value)}}
                                                            </option>
                                                                
                                                        @endforeach
                                                    
                                                    </select>
                                                    
                                                @elseif ($key == 'description')
                                                    
                                                        <textarea class="uk-textarea" name="setting_key[{{$keysetting_key}}][{{$key}}]"> {{$value}}</textarea>

                                                @elseif ($key == 'status')
                                                    <select class="uk-select" id="form-stacked-select" name="setting_key[{{$keysetting_key}}][{{$key}}]">
                                                        <option value="" selected disabled>SELECT ...</option>
                                                        @foreach (Setting::SettingOfferStatus()  as $keySettingOfferStatus  => $valueSettingOfferStatus)
                                                                
                                                            <option value="{{$keySettingOfferStatus}}" @if($keySettingOfferStatus == $value) selected @endif>
                                                                {{$valueSettingOfferStatus}}
                                                            </option>
                                                                
                                                        @endforeach
                                                        
                                                    </select>    

                                                @elseif ($key == 'group')
                                                    <select class="uk-select" id="form-stacked-select" name="setting_key[{{$keysetting_key}}][{{$key}}]">
                                                        <option value="" selected disabled>SELECT ...</option>
                                                        @foreach (Setting::SettingKeyGroup() as $keySettingKeyGroup =>$valueSettingKeyGroup)
                                                                
                                                            <option value="{{$keySettingKeyGroup}}" @if($keySettingKeyGroup == $value) selected @endif>
                                                                {{$valueSettingKeyGroup}}
                                                            </option>
                                                                
                                                        @endforeach
                                                    </select>
                                                
                                                @elseif ($key == 'image')
                                                    <input class="uk-input" type="text" value="{{$value}}" name="setting_key[{{$keysetting_key}}][{{$key}}]">

                                                @elseif ($key == 'setting_key_type')
                                                    <select class="uk-select" id="form-stacked-select" name="setting_key[{{$keysetting_key}}][{{$key}}]">
                                                        <option value="" selected disabled>SELECT ...</option>
                                                        @foreach ($data['settingModel']->setting_key_type  as $key_setting_key_type  => $item_setting_key_type)
                                                            <option value="{{$key_setting_key_type}}" @if($key_setting_key_type == $value) selected @endif>
                                                                {{$item_setting_key_type}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                
                                            </td>

                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </form>
        </li>

        <li>
            @include('setting.partial.settingKeyPartial')
        </li>
    </ul>
</div>
@endsection


