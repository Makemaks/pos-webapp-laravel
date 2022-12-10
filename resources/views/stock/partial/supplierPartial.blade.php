@php
    use App\Models\Company;
<<<<<<< HEAD

    $iconArray = [
        "reply",
       "forward"
    ];


  
=======
    use App\Models\Stock;
    use Carbon\Carbon;
   
    $companyList = new Stock();
 
>>>>>>> 9b8207d1b5c7eed09b9c567e53f1cb1960b27d4b
@endphp
@if (count($data['companyList']) )
    <ul class="uk-subnav">
        <li>
            <template></template>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="stockTransaferUpdate" value="stockTransaferUpdate">
            Save
            </button>
        </li>
        <li>
            <div>
                <button class="uk-button uk-button-default uk-border-rounded" type="submit" form="stockTransaferUpdate" name="deleteButton" value="deleteButton">DELETE</button>
            </div>
        </li>
    </ul>
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="list"></a></li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>

<<<<<<< HEAD
<h3>SUPPLIERS</h3>
                  

<ul class="uk-subnav uk-subnav-pill" uk-switcher="{{$active}}">
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
=======
    <ul class="uk-switcher uk-margin">
        <li>
            <form id="stockTransaferUpdate" action="{{route('company.update', $data['companyList']->toarray()[0]['company_id'])}}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                <h3>TRANSFERS</h3>
                   @include('company.partial.indexPartial')
                </div>
            </form>
        </li>
>>>>>>> 9b8207d1b5c7eed09b9c567e53f1cb1960b27d4b

        <li>
            <form action="{{ route('company.store') }}" method="POST">
                @csrf
                @method('POST')
                @include('company.partial.createPartial')
                <div class="uk-child-width-expand@m" uk-grid>
                    <div>
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push" type="submit"></button>
                    </div>     
                </div>
            </form>
        </li>
    </ul>

<<<<<<< HEAD
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
=======
@endif
>>>>>>> 9b8207d1b5c7eed09b9c567e53f1cb1960b27d4b
