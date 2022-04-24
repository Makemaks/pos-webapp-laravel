@php
    use App\Models\Company;

     $iconArray = [
        "reply",
       "forward"
];

  
@endphp

<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li><a href="#" uk-icon="list"></a></li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>
        <h3>SUPPLIERS</h3>
                  
            <table class="uk-table uk-table-responsive uk-table-divider">
                <thead>
                    <tr>
                        
                            @foreach ($data['stockModel']->stock_supplier[1] as $key => $item)
                                @if ($key != 'supplier_id')
                                    <th>{{$key}}</th>
                                @endif
                            @endforeach
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                   
                    @if ($data['stockModel']->stock_supplier)
                        @foreach ($data['stockModel']->stock_supplier as $keyStockSupplier => $stockSupplier)
                            <tr>
                                
                                @foreach ($stockSupplier as $key => $stock)
                                    <td>
                                        @if ($key == 'supplier_id')
                                           
                                            <a href="{{route('company.edit', $stock)}}" class="uk-button uk-button-danger uk-border-rounded"> 
                                                {{$stock}}
                                            </a>
                                                
                                        @elseif($key == 'default')
                                                <input name="{{$key}}[]" class="uk-checkbox" type="checkbox" @if($stock == 0) checked @endif>
                                        @else
                                            @if ($key != 'supplier_id')
                                                <input  name="{{$key}}[]" class="uk-input" type="number" value="{{$stock}}">
                                            @endif
                                        @endif
                                    </td>
                                    
                                @endforeach

                                <td>
                                    <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockSupplier({{$stock}})"></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                  
                </tbody>
            </table>
        </li>

    <li>

        <form action="" class="uk-form-stacked">
          
            @if ($data['stockModel']->stock_supplier)
                @foreach ($data['stockModel']->stock_supplier  as $stock_supplier_key => $stock_supplier)
                    
                    @foreach ($stock_supplier as $key =>$item)
                       
                          
                        @if($key == 'ref')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select">
                                        <option selected disabled>SELECT ...</option>
                                        @if ($data['companyList'])
                                            @foreach ( $data['companyList'] as $key => $item)
                                                <option value="{{$item->supplier_id}}" @if($item->supplier_id == $key) selected @endif>{{$item->company_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                <input class="uk-input" type="number" name="{{$item}}">
                            </div>
                        @endif
                    @endforeach

                    @break

                @endforeach
            @endif

           
                
                
                

               
               
           

           <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
             
        </form>
    </li>
</ul>