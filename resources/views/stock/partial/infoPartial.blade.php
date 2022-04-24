@php
   use App\Models\Stock;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

    <div>
        <div class="uk-card uk-card-default uk-padding">
            <h3>GENERAL</h3>
            <div class="uk-text-center uk-width-1-2">
                @if ( $data['stockModel'] != null && $data['stockModel']->stock_image != null && 
                    Storage::disk('public')->has('uploads/'.$data['stockModel']->stock_image))
                        <img src="{{asset('/storage/uploads/'.$data['stockModel']->stock_image)}}" class="uk-image">
                @else
                    <img src="{{asset('/storage/uploads/placeholder.png')}}" class="uk-image">
                @endif
                <div class="uk-margin" uk-margin>
                    <div uk-form-custom="target: true">
                        <input type="file">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
                </div>
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">NAME</label>
                <input class="uk-input" type="text" value="{{$data['stockModel']->stock_name}}" name="stock_name">
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">GROUP</label>
                <select class="uk-select" name="group_id">
                    <option selected="selected" disabled>Select Group ...</option>
                    @if ($data['settingModel']->setting_stock_group)
                        @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $group)
                            @php
                                $selected = '';
                                if($key == $data['stockModel']->stock_group_category_plu){
                                        $selected = 'selected';
                                }
                            @endphp
                            <option value="{{$key}}"  {{$selected}}>{{$group}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">DEPARTMENT</label>
                <select class="uk-select" name="category_id">
                    <option selected="selected" disabled>Select Category ...</option>
                    @if ($data['settingModel']->setting_stock_group_category_plu)
                        @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $category)
                            @php
                                $selected = '';
                                if($key == $data['stockModel']->stock_category_id){
                                        $selected = 'selected';
                                }
                            @endphp
                            <option value="{{$key}}"  {{$selected}}>{{$category['descriptor']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">DESCRIPTION</label>
                <textarea class="uk-textarea" type="text" name="stock_description">{{$data['stockModel']->stock_description}}</textarea>
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">BRAND</label>
                <input class="uk-input" type="text" value="{{$data['stockModel']->stock_brand}}" name="stock_brand">
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">BARCODE</label>
                <input class="uk-input" type="text" value="{{$data['stockModel']->stock_barcode}}" name="stock_barcode">
            </div>
            
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">VAT</label>
                <select class="uk-select" name="stock_vat_id">
                    <option selected="selected" disabled>Select VAT ...</option>
                    @if ($data['settingModel']->setting_vat)
                        @foreach ($data['settingModel']->setting_vat as $vat)
                            @php
                                $selected = '';
                                if($key == $data['stockModel']->stock_vat_id){
                                        $selected = 'selected';
                                }
                            @endphp
                            <option value="{{$key}}"  {{$selected}}>{{$vat['rate']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        
            
        </div>
    </div>
    
   <div>
        <div class="uk-card uk-card-default uk-padding">
        
            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                <li><a href="#" uk-icon="list"></a></li>
                <li><a href="#" uk-icon="plus"></a></li>
            </ul>
            
            <ul class="uk-switcher uk-margin">
                <li>
                    <h3>PRICE</h3>
                    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                        <thead>
                            <tr>
                                
                                @foreach ($data['stockModel']->stock_cost[1] as $key => $item)
                                    @if ($key != 'supplier_id')
                                        <th>{{$key}}</th>
                                    @endif
                                @endforeach
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            
                                @foreach ($data['stockModel']->stock_cost as $keyStockCost => $stockCost)
                    
                                        <tr>
                                            
                                            @foreach ($stockCost as $key => $stock)
                                                
                                                <td>
                                                   
                                                    @if($key == 'default')
                                                        <input name="stock_cost[]{{$key}}" class="uk-checkbox" type="checkbox" @if($stock == 0) checked @endif>
                                                    @else
                                                        @if ($key != 'supplier_id')
                                                            <input class="uk-input" id="form-stacked-text" type="number" value="{{$stock}}" name="stock_cost[]{{$key}}">
                                                        @endif
                                                    @endif
                                                </td>
                                                
                                            @endforeach
                                            <td>
                                                <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockCost({{$keyStockCost}})"></button>
                                            </td>
                                        </tr>
                                
                                @endforeach
                        
                            
                        </tbody>
                    </table>
                </li>
            
                <li>
            
                    <form action="" class="uk-form-stacked">
                      
                       @foreach ( $data['stockModel']->stock_cost as $keyStockCost => $stockCost )
                            
                            
                           @foreach ($stockCost as $key => $stock)
                                @if ($key != 'default')
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                        <div class="uk-form-controls">
                                            <input class="uk-input" id="form-stacked-text" type="number" value="" name="stock_cost[]{{$key}}">
                                        </div>
                                    </div>
                                @endif
                           @endforeach
            
                           @break
                           
                           
                       @endforeach
            
                       <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
                         
                    </form>
                </li>
            </ul>
            
        </div>
   </div>
   
    
    <div>
        <div class="uk-card uk-card-default uk-padding">
           
            <h3>GROSS PROFIT</h3>
           @if ($data['stockModel']->stock_gross_profit)
                @foreach ($data['stockModel']->stock_gross_profit as $key => $stock_gross_profit)
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                        <input name="stock_cost[]{{$key}}" type="number" step="0.01" class="uk-input" type="text" value="{{$stock_gross_profit}}">
                    </div>
                @endforeach
           @endif
            
        </div>
    </div>
    
</div>

