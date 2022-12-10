@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Company;
    use App\Models\Account;
    use Carbon\Carbon;

    $storeList = new Stock();
    $accountList = Account::get();
    $companyList  = Company::Store('company_store_id', $data['userModel']->store_id)->get();
@endphp

<table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-responsive">
    <thead>
        <tr>
            <th></th>
            <th>REF</th>
                @isset($data['storeList'])
                    @foreach ($data['storeList']->toArray()[0] as $keystock => $item)
                        @if ($keystock != 'store_id' && $keystock != 'store_stock_id' && $keystock != 'created_at' && $keystock != 'root_store_id' && $keystock != 'updated_at' && $keystock != 'store_image')
                            <th>{{Str::after($keystock, 'store_')}}</th>
                        @endif
                    @endforeach
                @endisset
            <th></th>
        </tr>
    </thead>
    <tbody>
        @isset($data['storeList'])
            @foreach ($data['storeList']->toArray() as $keyStockTransfer => $storeList)
                <tr>
                    <td>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <input class="uk-checkbox" type="checkbox"
                                    value="{{ $storeList['store_id'] }}"
                                    name="store_checkbox[]">
                            </div>
                        </div>
                    </td>
                    @foreach ($storeList as $keystock => $stock)
                        @if ($keystock == 'store_id')
                            <input class="uk-input" type="text" name="store[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}" hidden>
                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded" onclick="">{{$stock}}</button>
                            </td>
                        
                        @elseif ($keystock == 'store_name' || $keystock == 'store_location')
                            <td>
                                <input class="uk-input" type="text" name="store[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </td>
                        @elseif ($keystock == 'store_account_id')
                            <td>
                                <select class="uk-select" id="form-stacked-select" name="store[{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($accountList as $account)
                                            <option value="{{$account->account_id}}" class="uk-input" @if($account->account_id == $stock) selected @endif>
                                                {{$account->account_id}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </td>
                        @elseif ($keystock == 'store_company_id')
                            <td>
                                <select class="uk-select" id="form-stacked-select" name="store[{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                        @foreach ($companyList as $company)
                                            <option value="{{$company->company_id}}" class="uk-input" @if($company->company_id == $stock) selected @endif>
                                                {{$company->company_name}}
                                            </option>
                                        @endforeach
                                </select>
                            </td>
                        @elseif ($keystock == 'store_datetime')
                            <td>
                                <input class="uk-input" placeholder="Start Date" type="datetime-local" name="store[{{$keyStockTransfer}}][started_at]"
                                value="{{ isset(json_decode($stock)->started_at) ? json_decode($stock)->started_at : '' }}">
                            </td>
                            <td>
                                <input class="uk-input" placeholder="Start Date" type="datetime-local" name="store[{{$keyStockTransfer}}][ended_at]"
                                value="{{ isset(json_decode($stock)->ended_at) ? json_decode($stock)->ended_at : '' }}">
                            </td>
                        
                        @endif
                    @endforeach
                </tr>    
            @endforeach
        @endisset
    </tbody>
</table>