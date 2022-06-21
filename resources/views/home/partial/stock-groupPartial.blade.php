@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Models\Stock;
@endphp

<div class="uk-margin"> 
    @if ($data['settingModel']->setting_stock_group)
   
        <div class="uk-grid-small uk-child-width-1-4@s uk-button" uk-grid>


            @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
            
            
                    @php
                        $setting_stock_type = Setting::SettingStockGroup()[$setting_stock_group['type'] - 1];
                        $where = 'stock_merchandise->'.$setting_stock_type.'_id';
                        $count = Stock::where($where, $keysetting_stock_group)->count();
                    @endphp
            

                    <div>
                        <div onclick="stockGroup({{$keysetting_stock_group}}, '{{$setting_stock_type}}', '{{$setting_stock_group['name']}}' )">
                    
                            <div class="uk-padding-small uk-height-small uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}">
                                
                                <div>
                                    <div uk-grid>
                                        <div class="uk-width-expand">
                                            <span class="uk-text-lead">{{Str::ucfirst($setting_stock_group['name'])}}</span>
                                        </div>
                                    </div>
                                
                                    <div class="uk-margin">
                                        {{$count}} Item(s)
                                    </div>
                                
                                </div>
                            
                            </div>
                        
                        </div>
                    </div>
                                        
            
                    
            @endforeach
        </div>
        
        <hr>
    @else
    
        <p class="uk-text-danger">No Records</p>
        <hr>
    @endif
</div>


<div class="uk-margin">
    @isset($data['stockList'])
        @include('stock.partial.indexPartial')
    @endisset
</div>

