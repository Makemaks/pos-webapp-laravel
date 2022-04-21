@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

    <div>
        <div class="uk-card uk-card-default uk-padding">
       
            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                <li><a href="#" uk-icon="list"></a></li>
                <li><a href="#" uk-icon="plus"></a></li>
            </ul>
            
            <ul class="uk-switcher uk-margin">
                <li>
                    <h3>OFFERS</h3>
                              
                        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                            <thead>
                                <tr>
                                    @if ($data['stockModel']->stock_offers)
                                        @foreach ($data['stockModel']->stock_offers[1] as $key => $item)
                                            <th>{{$key}}</th>
                                        @endforeach
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @if ($data['stockModel']->stock_offers)
                                    @foreach ($data['stockModel']->stock_offers as $keyStockoffers => $stockoffers)
                                        <tr>
                                            
                                            @foreach ($stockoffers as $key => $stock)
                                                <td>
                                               
                                                @if($key == 'default')
                                                        <input name="stock_offers[]{{$key}}[]" class="uk-checkbox" type="checkbox" @if($stock == 0) checked @endif>
                                                @else
                                                    <input class="uk-input" id="form-stacked-text" type="number" value="{{$stock}}" name="stock_offers[]{{$key}}[]">
                                                @endif
                                                </td>
                                                
                                            @endforeach
                                            <td>
                                                <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockoffers({{$keyStockoffers}})"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                              
                            </tbody>
                        </table>
                    </li>
            
                <li>
            
                    <form action="" class="uk-form-stacked">
                      
                        <h3>Offers</h3>
                        @if ($data['stockModel']->stock_offers)
                            @foreach ($data['stockModel']->stock_offers  as $stock_offers_key => $stock_offers)
                                @foreach ($stock_offers as $key =>$item)
                                   @if ($key != 'default')
                                        <div class="uk-margin">
                                            <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                            <input class="uk-input" type="number" value="" name="stock_offers[]{{$key}}">
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
          
           
           
        </div>
    </div>
   
    
  
</div>

