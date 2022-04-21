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
                            <option value="{{$loop->iteration}}"  {{$selected}}>{{$plu}}</option>
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




</div>




