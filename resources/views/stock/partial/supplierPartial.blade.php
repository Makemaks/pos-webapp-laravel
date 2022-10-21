@php
    use App\Models\Company;

    $iconArray = [
        "reply",
       "forward"
    ];


  
@endphp

<h3>SUPPLIERS</h3>
                  

<ul class="uk-subnav uk-subnav-pill" uk-switcher="@isset($active) {{$active}} @endisset">
    <li><a href="#" uk-icon="list"></a></li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>
    
        <table class="uk-table uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>REF</th>
                    @foreach ($data['stockModel']->stock_supplier[1] as $key => $item)
                        <th>{{$key}}</th>
                    @endforeach
                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
                @if ($data['stockModel']->stock_supplier && $data['stockModel']->stock_id)
                    @foreach ($data['stockModel']->stock_supplier as $keyStockSupplier => $stockSupplier)
                        <tr>
                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded">{{$keyStockSupplier}}</button>
                            </td>
                            @foreach ($stockSupplier as $key => $stock)
                                <td>
                                    
                                    @if ($key == 'supplier_id')
                                        
                                        <select class="uk-select" id="form-stacked-select" name="stock_supplier[{{$keyStockSupplier}}][{{$key}}]">
                                            <option value="" selected disabled>SELECT ...</option>
                                            @foreach ($data['companyList']->where('comapny_type', 0)  as $supplier )
                                                    
                                                <option value="{{$supplier->company_id}}" @if($supplier->company_id == $stock) selected @endif>
                                                    {{$supplier->company_name}}
                                                </option>
                                                    
                                            @endforeach
                                        </select>
                                            
                                    @elseif($key == 'default')
                                            <input name="default[stock_supplier][{{$key}}]" value="{{$keyStockSupplier}}" class="uk-radio" type="radio" @if($stock == 0) checked @endif>
                                    @else
                                        @if ($key != 'supplier_id')
                                            <input  name="stock_supplier[{{$keyStockSupplier}}][{{$key}}]" class="uk-input" type="number" value="{{$stock}}">
                                        @endif
                                    @endif
                                </td>
                                
                            @endforeach

                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded" uk-icon="trash" onclick="deleteStockSupplier({{$stock}})"></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                
            </tbody>
        </table>
    </li>

    <li>

        <table class="uk-table uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>REF</th>
                    <th>DEFAULT</th>
                    @foreach ($data['stockModel']->stock_supplier[1] as $key => $item)
                        <th>{{$key}}</th>
                    @endforeach
                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
                @for ($keyStockSupplier = 0; $keyStockSupplier < 5; $keyStockSupplier++)
                    <tr>
                        <td>
                            <button class="uk-button uk-button-default uk-border-rounded">{{$keyStockSupplier}}</button>
                        </td>
                        <td>
                            <input name="default[stock_supplier][{{$key}}]" value="{{$keyStockSupplier}}" class="uk-radio" type="radio"{{--  @if($stock == 0) checked @endif --}}>
                        </td>
                        
                            @foreach ($data['stockModel']->stock_supplier[1] as $key =>$item)
                                @if($key == 'supplier_id')
                                    <td>
                                        <select class="uk-select" id="form-stacked-select" name="form[stock_supplier][{{$key}}]">
                                            <option value="" selected disabled>SELECT ...</option>
                                            @foreach ($data['companyList']->where('comapny_type', 0)  as $supplier )
                                                    
                                                <option value="{{$supplier->company_id}}">
                                                    {{$supplier->company_name}}
                                                </option>
                                                    
                                            @endforeach
                                        </select>
                                    </td>
                                @elseif($key != 'default')
                                    <td><input class="uk-input" type="number" name="form[stock_supplier][{{$key}}]"></td>
                                @endif
                            @endforeach
                        
                     
                        <td>
                            <button class="uk-button uk-button-default uk-border-rounded" uk-icon="trash" {{-- onclick="deleteStockSupplier({{$stock}})" --}}></button>
                        </td>
                    </tr>
                @endfor
                
            </tbody>
        </table>

      {{--   <form action="" class="uk-form-stacked">
          
            @if ($data['stockModel']->stock_supplier)
                @foreach ($data['stockModel']->stock_supplier  as $keyStockSupplier => $stock_supplier)
                    
                    @foreach ($stock_supplier as $key =>$item)
                       
                          
                       
                        @if($key == 'supplier_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[stock_supplier][{{$key}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    @foreach ($data['companyList']->where('comapny_type', 0)  as $supplier )
                                            
                                        <option value="{{$supplier->company_id}}">
                                            {{$supplier->company_name}}
                                        </option>
                                            
                                    @endforeach
                                </select>
                            </div>
                        @elseif($key != 'default')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                <input class="uk-input" type="number" name="form[stock_supplier][{{$key}}]">
                            </div>
                        @endif
                    @endforeach

                    @break

                @endforeach
            @endif
           

           <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push"></button>
             
        </form> --}}
    </li>
</ul>