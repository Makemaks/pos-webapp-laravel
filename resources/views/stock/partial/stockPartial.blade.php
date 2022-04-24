@php
   use App\Models\Stock;
   use App\Models\User;
   use App\Models\Company;


  $userModel = User::Account('account_id', Auth::user()->user_account_id)->first();

     
  /* $companyList = Company::Contact('company_store_id',$userModel->person_user_id)->get(); */
@endphp

<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>
    <div>
        <div class="uk-card uk-card-default uk-padding">
            <h3>GENERAL</h3>
           
            <div class="uk-margin">
                <label><input class="uk-checkbox" type="checkbox" @if ($data['stockModel']->stock_is_disabled)checked @endif> Non Stock</label>
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Minimum" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Maximum" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Days to Order" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <select class="uk-select" name="stock_plu_id">
                    <option selected="selected" disabled>Select PLU ...</option>
                    @if ($data['settingModel']->setting_stock_plu)
                        @foreach (explode(",", $data['settingModel']->setting_stock_plu) as $plu)
                            @php
                                $selected = '';
                                if($loop->iteration == $data['stockModel']->stock_plu){
                                        $selected = 'selected';
                                }
                            @endphp
                            <option >{{$plu}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Qty" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="text" placeholder="Recipe" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Unit Quantity" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Case Quantity" value="{{$data['stockModel']->stock_name}}">
            </div>
        
            <div class="uk-margin">
                <input class="uk-input" type="number" placeholder="Alert Level" value="{{$data['stockModel']->stock_alert_level}}">
            </div>
            
        </div>
    </div>
    
    
    <div>
        <div class="uk-card uk-card-default uk-padding">
            @include('stock.partial.supplierPartial')
        </div>
    </div>
    
    <div>
        <div class="uk-card uk-card-default uk-padding">
            @include('stock.partial.transferPartial')
        </div>
    </div>


    <div>
        <div class="uk-card uk-card-default uk-padding">
           <h3>STOCK & SHELF EDGE LABELS</h3>
            
           <div class="uk-margin uk-background-muted uk-padding uk-panel">
                <h3>SHELF</h3>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">SHEET SIZE</label>

                    <select id="" class="uk-select" name="stock_plu_id">
                        <option value="" disabled selected>SELECT ...</option>
                        @foreach ( $data['settingModel']->setting_stock_label['SHELF'] as $key => $shelf_setting_stock_label)
                        
                            <optgroup label="{{Str::upper($key)}}">
                                @foreach ($shelf_setting_stock_label as $stock_label)
                                    
                                    <option>{{ $stock_label}}</option>
                                
                                @endforeach
                            </optgroup>
                            
                        @endforeach
                    </select>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">NUMBER OF LABELS REQUIRED</label>
                    <input class="uk-input" type="number" value="10">
                </div>

                <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
           </div>


          

           <div class="uk-margin uk-background-muted uk-padding uk-panel">
                <h3>STOCK</h3>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">SHEET SIZE</label>
                
                    <select id="" class="uk-select" name="stock_plu_id">
                        <option value="" disabled selected>SELECT ...</option>
                        @foreach ( $data['settingModel']->setting_stock_label['STOCK'] as $key => $shelf_setting_stock_label)
                        
                            <optgroup label="{{Str::upper($key)}}">
                                @foreach ($shelf_setting_stock_label as $stock_label)
                                    
                                    <option>{{ $stock_label}}</option>
                                
                                @endforeach
                            </optgroup>
                            
                        @endforeach
                    </select>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">NUMBER OF LABELS REQUIRED</label>
                    <input class="uk-input" type="number" value="10">
                </div>

                <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
           </div>
        </div>
    </div>

</div>




