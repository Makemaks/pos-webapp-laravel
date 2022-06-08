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
                
                @isset ($data['stockModel']->stock_merchandise['stock_name'])
                    <input class="uk-input" type="text" value="{{  old('stock_merchandise[stock_name]', $data['stockModel']->stock_merchandise['stock_name'] ) }}" name="stock_merchandise[stock_name]">
                @else
                    <input class="uk-input" type="text" value="{{  old('stock_merchandise[stock_name]') }}" name="stock_merchandise[stock_name]">
                @endisset
            </div>

          
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">GROUP</label>
                <select class="uk-select" name="stock_merchandise[group_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group)
                        @foreach ($data['settingModel']->setting_stock_group as $key => $group)
                            @if ( $group['type'] == 1 )
                                @isset ($data['stockModel']->stock_merchandise['group_id'])
                                    <option value="{{$key}}" @if($key == old('stock_merchandise[group_id]', $data['stockModel']->stock_merchandise['group_id']) ) selected @endif>{{$group['description']}}</option>
                                @else
                                    <option value="{{$key}}" @if($key == old('stock_merchandise[group_id]') ) selected @endif>{{$group['description']}}</option>
                                @endisset
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                
                <label class="uk-form-label" for="form-stacked-text">DEPARTMENT</label>
                <select class="uk-select" name="stock_merchandise[category_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group)
                        @foreach ($data['settingModel']->setting_stock_group as $key => $category)
                            @if ($category['type'] == 0)
                                @isset ($data['stockModel']->stock_merchandise['category_id'])
                                    <option value="{{$key}}" @if($key == old( 'stock_merchandise[category_id]', $data['stockModel']->stock_merchandise['category_id']) ) selected @endif>
                                        {{$category['description']}}
                                    </option>
                                @else
                                    <option value="{{$key}}" @if($key == old( 'stock_merchandise[category_id]') ) selected @endif>
                                        {{$category['description']}}
                                    </option>
                               
                                @endisset
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">PLU</label>
                <select class="uk-select" name="stock_merchandise[plu_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group)
                        @foreach ($data['settingModel']->setting_stock_group as $key => $plu)
                            @if ($plu['type'] == 2)
                                    @isset($data['stockModel']->stock_merchandise['plu_id'])
                                        <option value="{{$key}}"  @if($key == old( 'stock_merchandise[plu_id]', $data['stockModel']->stock_merchandise['plu_id']) ) selected @endif>{{$plu['description']}}</option>
                                    @else
                                        <option value="{{$key}}"  @if($key == old( 'stock_merchandise[plu_id]') ) selected @endif>{{$plu['description']}}</option>
                                    @endisset
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">BRAND</label>
                <select class="uk-select" name="stock_merchandise[brand_id]">
                    <option selected="selected" disabled>SELECT ...</option>
                    @if ($data['settingModel']->setting_stock_group)
                        @foreach ($data['settingModel']->setting_stock_group as $key => $plu)
                            @if ($plu['type'] == 3)
                            
                                @isset($data['stockModel']->stock_merchandise['brand_id'])
                                    <option value="{{$key}}" @if($key == old('stock_merchandise[brand_id]', $data['stockModel']->stock_merchandise['brand_id'])) selected @endif>{{$plu['description']}}</option>
                                @else
                                    <option value="{{$key}}" @if($key == old('stock_merchandise[brand_id]')) selected @endif>{{$plu['description']}}</option>
                                @endisset
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">DESCRIPTION</label>

                @isset($data['stockModel']->stock_merchandise['stock_description'])
                    <textarea class="uk-textarea" type="text" name="stock_merchandise[stock_description]">{{old('stock_merchandise[stock_description]', $data['stockModel']->stock_merchandise['stock_description'])}}</textarea>
                @else
                    <textarea class="uk-textarea" type="text" name="stock_merchandise[stock_description]">{{old('stock_merchandise[stock_description]')}}</textarea>
                @endisset
                
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">VAT</label>
                
                @isset($data['stockModel']->stock_merchandise['stock_vat'])
                    <input class="uk-input" type="number" step="0.01" value="{{old( 'stock_merchandise[stock_vat]', $data['stockModel']->stock_merchandise['stock_vat'])}}" name="stock_merchandise[stock_vat]">
                    @else
                    <input class="uk-input" type="number" step="0.01" value="{{old( 'stock_merchandise[stock_vat]')}}" name="stock_merchandise[stock_vat]">
                @endisset
                
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
                    <div class="uk-overflow-auto">
                        <table class="uk-table uk-table-small uk-table-divider">
                            <thead>
                                <tr>
                                    <th>REF</th>
                                   
                                        @for ($i = 0; $i < $data['settingModel']->setting_group['group_stock_cost']; $i++)
                                            <th>{{$i + 1}}</th>
                                        @endfor
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                    
                                    
                                    @if ($data['stockModel']->stock_cost && $data['stockModel']->stock_id)
                                        
                                       @for ($i = 0; $i < count($data['stockModel']->stock_cost[1]); $i++)
                                            <tr>
                                                <td>
                                                    <button class="uk-button uk-button-danger uk-border-rounded">
                                                        {{$i + 1}}
                                                    </button>
                                                </td>
                                                @for ($j=0; $j < count($data['stockModel']->stock_cost); $j++)
                                                    <td>
                                                        @php
                                                           $price = $data['stockModel']->stock_cost[$j + 1][$i + 1]['price'];
                                                        @endphp
                                                        <input class="uk-input" id="form-stacked-text" type="number" step="0.01" value="{{$price}}" name="stock_cost[{{$j + 1}}][{{$i + 1}}][price]">
                                                        
                                                    </td>
                                                    
                                                @endfor
                                               
                                              
                                                @for ($q=count($data['stockModel']->stock_cost); $q < $data['settingModel']->setting_group['group_stock_cost']; $q++)
                                              
                                                    <td>
                                                 
                                                        <input class="uk-input" id="form-stacked-text" type="number" step="0.01" value="" name="stock_cost[{{$q + 1}}][{{$i + 1}}][price]">
                                                        
                                                    </td>
                                                    
                                                @endfor
                                               
                                            </tr>
                                       @endfor
                                        
                                       
                                    @endif
                                
                            </tbody>
                        </table>
                    </div>
                </li>
            
                <li>
                    <h3>PRICE</h3>
                    <div class="uk-overflow-auto">
                      
                        <table class="uk-table uk-table-small uk-table-divider">
                            <thead>
                                <tr>
                                    <th>REF</th>
                                    @for ($i = 0; $i < $data['settingModel']->setting_group['group_stock_cost']; $i++)
                                       
                                            <th>{{$i + 1}}</th>
                                      
                                    @endfor
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                    
                                   

                                    @if ($data['stockModel']->stock_cost && $data['stockModel']->stock_id)
                                        
                                       @for ($i = count($data['stockModel']->stock_cost[1]); $i < count($data['stockModel']->stock_cost[1]) * 2; $i++)
                                            <tr>
                                                <td>
                                                    <button class="uk-button uk-button-danger uk-border-rounded">
                                                        {{$i + 1}}
                                                    </button>
                                                </td>
                                                @for ($j=0; $j < count($data['stockModel']->stock_cost); $j++)
                                                    <td>
                                                        <input class="uk-input" id="form-stacked-text" type="number" step="0.01" value="" name="form[stock_cost][{{$i + 1}}][{{$j + 1}}][price]">
                                                        
                                                    </td>
                                                    
                                                @endfor

                                            
                                                @for ($q=count($data['stockModel']->stock_cost); $q < $data['settingModel']->setting_group['group_stock_cost']; $q++)
                                            
                                                    <td>
                                                    
                                                        <input class="uk-input" id="form-stacked-text" type="number" step="0.01" value="" name="form[stock_cost][{{$i + 1}}][{{$q + 1}}][price]">
                                                        
                                                    </td>
                                                    
                                                @endfor                
                                                
                                            </tr>
                                       @endfor
                                        
                                       
                                    @endif
                                
                            </tbody>
                        </table>
                                
            
                       <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
                         
                    </div>
                </li>
            </ul>
            
        </div>
   </div>
   
   <div>
        <div class="uk-card uk-card-default uk-padding">
           
            <h3>QUANTITY</h3>
           
            <div class="uk-overflow-auto">
                      
                <table class="uk-table uk-table-small uk-table-divider">
                    <thead>
                        <tr>
                            <th>REF</th>
                            @for ($i = 0; $i < $data['settingModel']->setting_group['group_stock_cost']; $i++)
                               
                                    <th>{{$i + 1}}</th>
                              
                            @endfor
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            
                            @php

                            @endphp

                            @if ($data['stockModel']->stock_cost && $data['stockModel']->stock_id)
                                
                               @for ($i = 0; $i < 1; $i++)
                                    <tr>
                                        <td>
                                            <button class="uk-button uk-button-danger uk-border-rounded">
                                                {{$i + 1}}
                                            </button>
                                        </td>

                                        @for ($j=0; $j < count($data['stockModel']->stock_cost_quantity); $j++)
                                            <td>
                                                <input class="uk-input" id="form-stacked-text" type="number" value="{{$data['stockModel']->stock_cost_quantity[$j + 1]}}" name="stock_cost_quantity[{{$j + 1}}]">
                                                
                                            </td>
                                            
                                        @endfor

                                    
                                    
                                        @for ($q=count($data['stockModel']->stock_cost_quantity); $q < $data['settingModel']->setting_group['group_stock_cost']; $q++)
                                   
                                            <td>
                                            
                                                <input class="uk-input" id="form-stacked-text" type="number" value="" name="stock_cost_quantity[{{$q + 1}}]">
                                                
                                            </td>
                                            
                                        @endfor                
                                        
                                    </tr>
                               @endfor
                                
                               
                            @endif
                        
                    </tbody>
                </table>
               
                 
            </div>
            
        </div>
    </div>
    
    <div>
        <div class="uk-card uk-card-default uk-padding">
           
            <h3>GROSS PROFIT</h3>
           @if ($data['stockModel']->stock_gross_profit)
                @foreach ($data['stockModel']->stock_gross_profit as $key => $stock_gross_profit)
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                        <input name="form[stock_gross_profit][{{$key}}]" type="number" step="0.01" step="0.01" class="uk-input" value="{{$stock_gross_profit}}">
                    </div>
                @endforeach
           @endif
            
        </div>
    </div>
    
</div>

