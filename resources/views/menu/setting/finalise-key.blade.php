@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
use App\Models\Setting;
use App\Models\Project;
@endphp

@section('content')
<div>
                            
    <h3>{{Str::upper(Request::get('view'))}}</h3>
    @if ($data['settingModel']->setting_setting_key)
        <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">

            <thead>
                <tr>
                    <th>REF</th>
                   @foreach ($data['settingModel']->setting_setting_key[1] as $key => $item)
                        <th>{{$key}}</th>
                   @endforeach
                   <th></th>
                </tr>
            </thead>

            <tbody>
               
                
                @foreach ($data['settingModel']->setting_setting_key  as $keysetting_setting_key => $setting_setting_key)
                    @if ($setting_setting_key['type'] == Session::get('view'))
                        <tr>
                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_setting_key}}</button>
                            </td>
                          
                            @foreach ($setting_setting_key as $key => $value)          

                                    <td>
                                        @if ($key == 'code')
                                            
                                            <input class="uk-input" type="number" name="setting_setting_key[{{$keysetting_setting_key}}][{{$key}}]" value="{{$value}}">
                                        @elseif ($key == 'type')
                                                        
                                            <select class="uk-select" name="setting_setting_key[{{$keysetting_setting_key}}][{{$key}}]">
                                                <option selected="selected" disabled>SELECT ...</option>
                                            
                                                @foreach (Setting::SettingGroup() as $key => $setting_group)
                                                        
                                                    <option @if($key == $setting_setting_key['type']) selected @endif value="setting_setting_key[{{$keysetting_setting_key}}][{{$key}}]">
                                                        {{Str::upper($value)}}
                                                    </option>
                                                        
                                                @endforeach
                                            
                                            </select>
                                        @elseif ($key == 'name')
                                            
                                                <textarea class="uk-textarea" name="setting_setting_key[{{$keysetting_setting_key}}][{{$key}}]"> {{$value}}</textarea>
                                          
                                        @endif
                                    </td>
                                
                                

                            @endforeach

                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded" uk-icon="trash" onclick="deleteStockCost({{$keysetting_setting_key}})"></button>
                            </td>
                        </tr>
                    
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

     
</div>
@endsection


