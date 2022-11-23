@php
    use App\Models\User;
    use App\Models\Store;
    use App\Models\Company;
    use App\Models\Account;
    $action =  Str::after(Request::route()->getName(), '.');
@endphp



<div class="">
    <h3>STORE</h3>
    
        @php
           
            $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
            $storeList = Store::List('root_store_id', $data['storeModel']->store_id)
            ->get();
            $accountList = Account::get();
            $companyList  = Company::Store('company_store_id', $data['userModel']->store_id)->get();
        @endphp
        @isset($data['storeList'])
        @foreach ($data['storeList']->toArray() as $keyStockTransfer => $storeList)
        
        @foreach ($storeList as $keystock => $stock)

                        @if ($keystock == 'store_name' || $keystock == 'store_location')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="text" name="{{$keystock}}" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'store_company_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($companyList as $company)
                                            <option value="{{$company->company_id}}" class="uk-input" @if($company->company_id == $stock) selected @endif>
                                                {{$company->company_name}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'store_account_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($accountList as $account)
                                            <option value="{{$account->account_id}}" class="uk-input" @if($account->account_id == $stock) selected @endif>
                                                {{$account->account_id}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'store_datetime')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="datetime-local" name="{{$keystock}}[started_at]" value="{{ json_decode($stock)->started_at }}">
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="datetime-local" name="{{$keystock}}[ended_at]" value="{{ json_decode($stock)->ended_at }}">
                            </div>
                        @elseif($keystock == 'store_image')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="file" name="store_img" value="{{$stock}}">
                            </div>
                        @endif

                @endforeach
                    
            @break
    
            @endforeach
       @endisset
</div>

