@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Company;
    use App\Models\Account;
    use Carbon\Carbon;

    $accountList = new Stock();
    $parentAccount = Account::get();
@endphp

<table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-responsive">
    <thead>
        <tr>
            <th></th>
            <th>REF</th>
                @isset($data['accountList'])
                    @foreach ($data['accountList']->toArray()[0] as $keystock => $item)
                        @if ($keystock != 'account_id' && $keystock != 'account_system_id' && $keystock != 'created_at' && $keystock != 'accountable_id' && $keystock != 'updated_at' && $keystock != 'account_blacklist')
                            <th>{{Str::after($keystock, 'store_')}}</th>
                        @endif
                    @endforeach
                @endisset
        </tr>
    </thead>
    <tbody>
        @isset($data['accountList'])
            @foreach ($data['accountList']->toArray() as $keyAccountData => $accountList)
                <tr>
                    <td>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <input class="uk-checkbox" type="checkbox"
                                    value="{{ $accountList['account_id'] }}"
                                    name="account_checkbox[]">
                            </div>
                        </div>
                    </td>
                    @foreach ($accountList as $keystock => $stock)
                        @if ($keystock == 'account_id')
                            <input class="uk-input" type="text" name="account[{{$keyAccountData}}][{{$keystock}}]" value="{{$stock}}" hidden>
                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded" onclick="">{{$stock}}</button>
                            </td>
                        
                        @elseif ($keystock == 'account_name' || $keystock == 'account_description')
                            <td>
                                <input class="uk-input" type="text" name="account[{{$keyAccountData}}][{{$keystock}}]" value="{{$stock}}">
                            </td>
                        @elseif($keystock == 'account_type')
                            <td>
                                <select class="uk-select" id="form-stacked-select" name="account[{{$keyAccountData}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Account::Type() as $key => $value)
                                            <option value="{{$key}}" class="uk-input" @if($key == $stock) selected @endif>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </td>
                        @elseif($keystock == 'accountable_type')
                            <td>
                                <select class="uk-select" id="form-stacked-select" name="account[{{$keyAccountData}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Account::AccountableType() as $key => $value)
                                            <option value="{{$value}}" class="uk-input" @if($value == $stock) selected @endif>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </td>
                        @elseif($keystock == 'parent_account_id')
                            <td>
                                <select class="uk-select" id="form-stacked-select" name="account[{{$keyAccountData}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($parentAccount as $key => $value)
                                            <option value="{{$value->account_id}}" class="uk-input" @if($value->account_id == $stock) selected @endif>
                                                {{$value->account_id}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </td>
                        @endif
                    @endforeach
                </tr>    
            @endforeach
        @endisset
    </tbody>
</table>