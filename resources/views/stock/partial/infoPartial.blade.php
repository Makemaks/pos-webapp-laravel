@php
   use App\Models\Stock;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2@xl" uk-grid>

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
                <input class="uk-input" type="text" value="{{$data['stockModel']->stock_merchandise['stock_name']}}" name="stock_merchandise[stock_name]">
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">GROUP</label>
                <select class="uk-select" name="stock_merchandise[group_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group_category_plu)
                        @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $group)
                            @if ( $group['type'] == 1 )
                                <option value="{{$key}}" @if($key == $data['stockModel']->stock_merchandise['group_id']) selected @endif>{{$group['description']}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                
                <label class="uk-form-label" for="form-stacked-text">DEPARTMENT</label>
                <select class="uk-select" name="stock_merchandise[category_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group_category_plu)
                        @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $category)
                            @if ($category['type'] == 0)
                                <option value="{{$key}}" @if($key == $data['stockModel']->stock_merchandise['category_id']) selected @endif>
                                    {{$category['description']}}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">PLU</label>
                <select class="uk-select" name="stock_merchandise[master_plu]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group_category_plu)
                        @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $plu)
                            @if ($plu['type'] == 2)
                                <option value="{{$key}}"  @if($key == $data['stockModel']->stock_merchandise['master_plu']) selected @endif>{{$plu['description']}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">DESCRIPTION</label>
                <textarea class="uk-textarea" type="text" name="stock_merchandise[stock_description]">{{$data['stockModel']->stock_merchandise['stock_description']}}</textarea>
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">BRAND</label>
                <select class="uk-select" name="stock_merchandise[brand_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group_category_plu)
                        @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $plu)
                            @if ($plu['type'] == 3)
                            
                                <option value="{{$key}}" @if($key == $data['stockModel']->stock_merchandise['brand_id']) selected @endif>{{$plu['description']}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">VAT</label>
                <input class="uk-input" type="number" value="{{$data['stockModel']->stock_merchandise['stock_vat']}}" name="stock_merchandise[stock_vat]">
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
                                <th>REF</th>
                                @foreach ($data['stockModel']->stock_cost[1] as $key => $item)
                                   
                                        <th>{{$key}}</th>
                                  
                                @endforeach
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            
                                @foreach ($data['stockModel']->stock_cost as $keyStockCost => $stockCost)
                    
                                        <tr>
                                            <td>
                                                <button class="uk-button uk-button-danger uk-border-rounded">{{$keyStockCost}}</button>
                                            </td>
                                            @foreach ($stockCost as $key => $stock)
                                                
                                                <td>
                                                   
                                                    @if($key == 'supplier_id')
                                                        <input class="uk-input" id="form-stacked-text" type="text" value="{{$stock}}" name="stock_cost[{{$keyStockCost}}][{{$key}}]" hidden>
                                                        <button class="uk-button uk-button-danger uk-border-rounded">{{$keyStockCost}}</button>
                                                    @elseif($key == 'default')
                                                        <input class="uk-radio" type="radio" name="default[stock_cost][{{$key}}]" value="{{$keyStockCost}}" @if($stock == 0) checked @endif>
                                                    @else
                                                        <input class="uk-input" id="form-stacked-text" type="number" value="{{$stock}}" name="stock_cost[{{$keyStockCost}}][{{$key}}]">
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
                                @if($key == 'supplier_id')
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                        <select class="uk-select" id="form-stacked-select" name="form[stock_cost][{{$key}}]">
                                            <option value="" selected disabled>SELECT ...</option>
                                            @foreach ($data['companyList']->where('comapny_type', 0)  as $supplier )
                                                    
                                                <option value="{{$supplier->company_id}}">
                                                    {{$supplier->company_name}}
                                                </option>
                                                    
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($key != 'default')
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                        <div class="uk-form-controls">
                                            <input class="uk-input" id="form-stacked-text" type="number" value="" name="form[stock_cost][{{$key}}]">
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
                        <input name="stock_gross_profit[{{$key}}]" type="number" step="0.01" class="uk-input" value="{{$stock_gross_profit}}">
                    </div>
                @endforeach
           @endif
            
        </div>
    </div>
    
</div>

