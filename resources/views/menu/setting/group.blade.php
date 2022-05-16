@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
use App\Models\Setting;
use App\Models\Project;
@endphp

@section('content')
<div>
                            
    <h3>{{Str::upper(Setting::SettingGroup()[Session::get('view')])}}</h3>
    @if ($data['settingModel']->setting_stock_group)
        <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">

            <thead>
                <tr>
                    <th>REF</th>
                   @foreach ($data['settingModel']->setting_stock_group[1] as $key => $item)
                        <th>{{$key}}</th>
                   @endforeach
                   <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
                    @if ($setting_stock_group['type'] == Session::get('view'))
                        <tr>
                            <td>
                                <button class="uk-button uk-button-danger uk-border-rounded">{{$keysetting_stock_group}}</button>
                            </td>
                          
                            @foreach ($setting_stock_group as $key => $value)

                               
                                
                                    <td>
                                        @if ($key == 'code')
                                       
                                            <input class="uk-input" type="number" value="" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]" value="{{$setting_stock_group['code']}}">
                                        @elseif ($key == 'type')
                                                        
                                            <select class="uk-select" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">
                                                <option selected="selected" disabled>SELECT ...</option>
                                            
                                                @foreach (Setting::SettingGroup() as $key => $setting_group)
                                                        
                                                    <option value="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">{{Str::upper($setting_group)}}</option>
                                                        
                                                @endforeach
                                            
                                            </select>
                                        @elseif ($key == 'description')
                                            
                                                <textarea class="uk-textarea" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]"> {{$setting_stock_group['description']}}</textarea>
                                          
                                        @endif
                                    </td>
                                
                                

                            @endforeach

                            <td>
                                <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockCost({{$keysetting_stock_group}})"></button>
                            </td>
                        </tr>
                    
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

     
</div>
@endsection


