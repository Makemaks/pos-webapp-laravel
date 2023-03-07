@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Models\Stock;
@endphp

<div>
            
    <div class="uk-grid-small uk-child-width-1-4@s uk-button" uk-grid>

        @foreach (Setting::SettingStockGroup() as $item)
            <div>
                <div onclick="stockGroup({{$loop->iteration}}, '{{$item}}', null)">
            
                    <div class="uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}">
                        
                        <div>

                            <div uk-grid>
                                <div class="uk-width-expand">
                                    <span class="">{{Str::ucfirst($item)}}</span>
                                </div>
                            </div>
                        
                            <div class="uk-margin">
                                
                            </div>
                        
                        </div>
                    
                    </div>
                
                </div>
            </div>
        @endforeach
    
    </div>
</div>

<div class="uk-height-large uk-overflow-auto uk-padding" id="stockGroupID" hidden> 
    @if ($data['settingModel']->setting_stock_set)
   
        <div class="uk-grid-small uk-child-width-1-4@s uk-button" uk-grid>



            @foreach($data['settingModel']->setting_stock_set as $key_setting_stock_set => $item_setting_stock_set)
            
            
                    @php
                        $setting_stock_type = Setting::SettingStockGroup()[$item_setting_stock_set['type']];
                        $where = 'stock_merchandise->'.$setting_stock_type.'_id';
                        $count = Stock::where($where, $key_setting_stock_set)->count();
                    @endphp
            

                    <div>
                        <div onclick="stockGroup({{$key_setting_stock_set}}, '{{$setting_stock_type}}', '{{$item_setting_stock_set['name']}}' )">
                    
                            <div class="uk-padding-small uk-height-small uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}">
                                
                                <div>
                                    <div uk-grid>
                                        <div class="uk-width-expand">
                                            <span class="uk-text-bold">{{Str::ucfirst($item_setting_stock_set['name'])}}</span>
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
        
    @else
        <p class="uk-text-danger">No Records</p>
    @endif
</div>
