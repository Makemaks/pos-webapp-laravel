@php
   use App\Models\Stock;
   use App\Models\Setting;
   use App\Helpers\ConfigHelper;
   use carbon\carbon;

// Delete 
    $delete_offer = [];    
@endphp

<div>
{{-- <div class="uk-grid-match uk-grid-small uk-child-width-auto@xl" uk-grid> --}}

    <div>
        <div class="uk-card uk-card-default uk-padding">

            @if ($data['settingModel']->edit == false)
                <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
                    Save
                </button>
            @endif

            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingDelete" name="settingDelete">
                Delete
            </button>

       
            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                <li><a href="#" uk-icon="list"></a></li>
                <li><a href="#" uk-icon="plus"></a></li>
            </ul>
            
            <ul class="uk-switcher uk-margin">
                @if ($data['settingModel']->setting_offer && $data['settingModel']->edit == false)
                    <li>
                        <form id="settingUpdate" action="{{route('setting.update', $data['settingModel']->setting_id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <h3>OFFERS</h3>
                                
                            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                                <thead>
                                    <tr>
                                                        

                                        @php
                                            // $collection = collect($data['settingModel']->setting_offer[1]);
                                            $collection = collect(Arr::first($data['settingModel']->setting_offer));
                                            // dd($collection['available_day']);
                                            $available_day = $collection['available_day'] ? true : false;
                                            // dd(collect($collection)->except('available_day'));
                                            $collection = $collection->except('available_day')->collapse();
                                            // dd($collection);
                                        @endphp
                                    

                                        <th>REF</th>
                                            @foreach ( $collection->except(['exception']) as $key => $item)
                                                    <th>{{$key}}</th>
                                            @endforeach

                                            @if($available_day)
                                                <th>Sun</th>
                                                <th>Mon</th>
                                                <th>Tue</th>
                                                <th>Wed</th>
                                                <th>Thu</th>
                                                <th>Fri</th>
                                                <th>Sat</th>
                                            @endif
                                        
                                        {{-- <th>Apply</th> --}}
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                        @foreach ($data['settingModel']->setting_offer as $keyStockoffer => $itemStockoffer)
                                            <tr>
                                                <td>
                                                    <button class="uk-button uk-button-default uk-border-rounded">{{$keyStockoffer}}</button>
                                                </td>
                                                @foreach ($itemStockoffer as $key => $stock)

                                                    {{-- {{dd($itemStockoffer)}}  --}}
                                                
                                                    @if($key == 'integer' || $key == 'decimal')
                                                        @foreach ($stock as $stockkey => $stockitem)
                                                        @if ($stockkey == 'set_menu')
                                                            {{-- {{dd($stock)}} --}}
                                                                <td>
                                                                    <select class="uk-select" id="form-stacked-select" name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                                        <option value="" selected disabled></option>
                                                                        @if ($data['settingModel']->setting_stock_set_menu)
                                                                            @foreach ($data['settingModel']->setting_stock_set_menu  as $key_setting_stock_set_menu  => $item_setting_stock_set_menu)
                                                                                    
                                                                                <option value="{{$key_setting_stock_set_menu}}" @if($key_setting_stock_set_menu == $stock) selected @endif>
                                                                                    {{$item_setting_stock_set_menu['name']}}
                                                                                </option>
                                                                                    
                                                                            @endforeach
                                                                        @endif
                                                                        
                                                                    </select>
                                                                </td>
                                                    
                                                            @else
                                                                <td><input name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="number" value="{{$stockitem}}"></td>
                                                            @endif 
                                                        @endforeach
                                                        
                                                    @endif

                                                    
                                                    @if($key == 'default')
                                                        @foreach ($stock as $stockkey => $stockitem)
                                                                
                                                            @if ($stockkey == 'is_default')
                                                                <td><input class="uk-radio" type="radio" name="default[setting_offer][{{$key}}]" value="{{$keyStockoffer}}" @if($stock == 0) checked @endif></td>
                                                            
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($key == 'boolean')
                                                        @foreach ($stock as $stockkey => $stockitem)
                                                    
                                                            @if ($stockkey == 'status')
                                                            
                                                                <td>
                                                                    <select class="uk-select" id="form-stacked-select" name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                                        <option value="" selected disabled>SELECT ...</option>
                                                                        @foreach (Stock::OfferStatus()  as $key_stock_offer  => $item_stock_offer)
                                                                                
                                                                            <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                                                {{$item_stock_offer}}
                                                                            </option>
                                                                                
                                                                        @endforeach
                                                                    </select>    
                                                                </td>

                                                            
                                                            @else
                                                                <td>
                                                                    <select class="uk-select" id="form-stacked-select" name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                                        <option value="" selected disabled>SELECT ...</option>
                                                                        @foreach (Setting::OfferType()  as $key_stock_offer  => $item_stock_offer)
                                                                                
                                                                            <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                                                {{ Str::upper($item_stock_offer)}}
                                                                            </option>
                                                                                
                                                                        @endforeach
                                                                    </select>    
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($key == 'usage')
                                                        @foreach ($stock as $stockkey => $stockitem)
                                                            <td><input name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}"></td>
                                                        @endforeach
                                                    @endif

                                                    @if($key == 'date')
                                                        @foreach ($stock as $stockkey => $stockitem)
                                                            <td><input name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}"></td>
                                                        @endforeach
                                                    @endif

                                                    @if($key == 'string')
                                                        @foreach ($stock as $stockkey => $stockitem)
                                                            <td><input name="setting_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}"></td>
                                                        @endforeach
                                                    @endif

                                                    @if($key == 'available_day')
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="1" {{in_array(1,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="2" {{in_array(2,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="3" {{in_array(3,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="4" {{in_array(4,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="5" {{in_array(5,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="6" {{in_array(6,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="setting_offer[{{$keyStockoffer}}][available_day][]" value="7" {{in_array(7,$stock) ? 'checked' : ''}}>
                                                        </td>
                                                    @endif
                                                
                                            
                                                @endforeach    

                                                @isset($data['stockModel'])
                                                    <td>
                                                        <input class="uk-radio" type="radio" name="stock_merchandise[stock_offer]" value="{{$keyStockoffer}}" @if(isset($data['stockModel']->stock_merchandise['stock_offer']) == $keyStockoffer) checked @endif>
                                                    </td>
                                                @endisset
                                                
                                            
                                                <td>
                                                    {{-- <button class="uk-button uk-button-default uk-border-rounded" uk-icon="trash" onclick="deleteStockoffer({{$keyStockoffer}})"></button> --}}
                                                    {{-- <form id="settingDelete" action="{{route('setting.destroy', $data['settingModel']->setting_id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE') --}}
                                                    <input type="checkbox" name="setting_offer_delete[]" value="{{$keyStockoffer}}">
                                                    {{-- </form> --}}
                                                </td>    
                                            </tr>
                                        @endforeach
                                    
                                </tbody>
                            </table>
                        </form>
                    </li>
                @endif
                <li>
            
                   @include('setting.partial.settingOfferPartial')

                </li>
            </ul>
          
           
           
        </div>
    </div>
   
    
  
</div>

