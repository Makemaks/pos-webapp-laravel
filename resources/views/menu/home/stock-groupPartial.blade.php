@php
    use App\Helpers\StringHelper;
@endphp
<div class="uk-grid-small uk-child-width-1-4@s uk-text-center" uk-grid>
    @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
    
        <div>
            <a class="uk-link-reset" href="{{route('home.index', ['stock_group_id', $keysetting_stock_group])}}">
        
                <div class="uk-height-small uk-text-center uk-light" style="background-color: #{{StringHelper::getColor()}}">
                    {{$setting_stock_group['description']}}
                </div>
            </a>
        </div>
                                        
    @endforeach
</div>
