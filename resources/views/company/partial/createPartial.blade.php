@php
    use App\Models\Company;
    use App\Models\User;
    use App\Models\Store;
    $action =  Str::after(Request::route()->getName(), '.');
@endphp

<div class="">
    <h3>SUPPLIERS</h3>
    
        @php
           
            $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
            $storeList = Store::List('root_store_id', $data['storeModel']->store_id)
            ->get();
          
        @endphp
    

        <input name="parent_company_id" value="{{$data['userModel']->user_id}}" hidden>
        {{-- @if ($data['stockModel'])
            <input name="company_stock_id" value="{{$data['stockModel']->stock_id}}" hidden>
        @endif
        --}}
        
       @isset($data['companyList'])
            @foreach ($data['companyList']->toArray() as $keyStockTransfer => $companyList)
                        
            
                @foreach ($companyList as $keystock => $stock)

                        @if ($keystock == 'company_name')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="text" name="{{$keystock}}" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'company_contact')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="number" name="{{$keystock}}" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'company_opening_hour')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}_From</label>
                                <input type="datetime-local" name="{{$keystock}}[start_from]" class="uk-input" placeholder="Start Date" value="{{ json_decode($stock)->start_from }}">
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}_TO</label>
                                <input type="datetime-local" name="{{$keystock}}[end_to]" class="uk-input" placeholder="End Date" value="{{ json_decode($stock)->end_to }}" >
                            </div>
                        @elseif($keystock == 'company_store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($storeList as $store)
                                            <option value="{{$store->store_id}}" class="uk-input" @if($store->store_id == $stock) selected @endif>
                                                {{$store->store_name}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'company_type')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Company::CompanyType() as $key => $type)
                                            <option value="{{$key}}" class="uk-input" @if($key== $stock) selected @endif>
                                                {{Str::upper($type)}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </div>
                        @elseif($keystock == 'company_store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock}}</a>
                            </div>
                        @endif
                @endforeach
                    
            @break
    
            @endforeach
       @endisset    
</div>

