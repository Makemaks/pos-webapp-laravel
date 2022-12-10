@php
    use App\Models\User;
    use App\Models\Store;
    use App\Models\Company;
    use App\Models\Account;
    $action =  Str::after(Request::route()->getName(), '.');
@endphp



<div class="">
    <h3>ACCOUNT</h3>
    
        @php
           
            $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
            $storeList = Store::List('root_store_id', $data['storeModel']->store_id)
            ->get();
            $parentAccount = Account::get();
            $userList = User::get();
        @endphp
        @isset($data['accountList'])
        @foreach ($data['accountList']->toArray() as $keyAccountData => $accountList)
        
        @foreach ($accountList as $keystock => $stock)
                        @if ($keystock == 'account_system_id')
                        <input class="uk-input" type="hidden" name="{{$keystock}}" value="1">
                        @elseif ($keystock == 'accountable_id')
                        <input class="uk-input" type="hidden" name="{{$keystock}}" value="1">
                        @elseif ($keystock == 'account_name' || $keystock == 'account_description')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="text" name="{{$keystock}}" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'account_type')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Account::Type() as $key => $type)
                                            <option value="{{$key}}" class="uk-input" @if($key== $stock) selected @endif>
                                                {{Str::upper($type)}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </div>
                        @elseif($keystock == 'accountable_type')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_' ) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Account::AccountableType() as $key => $type)
                                            <option value="{{$type}}" class="uk-input" @if($type== $stock) selected @endif>
                                                {{Str::upper($type)}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </div>
                        @elseif($keystock == 'parent_account_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper ('PARENT ' . Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                    <option value="" selected disabled>SELECT ...</option>
                                        @foreach ($parentAccount as $key => $data)
                                            <option value="{{$data->account_id}}" class="uk-input">
                                                {{Str::upper($data->account_id)}}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        @elseif($keystock == 'account_blacklist')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' ) . ' TYPE') }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}[type]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Account::AccountBlacklistType() as $key => $type)
                                            <option value="{{$key}}" class="uk-input">
                                                {{Str::upper($type)}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' ) . ' DESCRIPTION') }}</label>
                                <input class="uk-input" type="text" name="{{$keystock}}[description]" value="">
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' ) . ' REASON') }}</label>
                                <input class="uk-input" type="text" name="{{$keystock}}[reason]" value="">
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' ) . ' START TIME') }}</label>
                                <input class="uk-input" type="datetime-local" name="{{$keystock}}[start_time]" value="">
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' ) . ' END TIME') }}</label>
                                <input class="uk-input" type="datetime-local" name="{{$keystock}}[end_time]" value="">
                            </div>
                            <div>
                                <input class="uk-input" type="hidden" name="{{$keystock}}[blocked_access]" value="{}">
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' ) . ' USER') }}</label>
                                <select class="uk-select" id="form-stacked-select" name="{{$keystock}}[user]">
                                    <option value="" selected disabled>SELECT ...</option>
                                        @foreach ($userList as $key => $type)
                                            <option value="{{$key}}" class="uk-input">
                                                {{Str::upper($type->email)}}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        @endif

                @endforeach
                    
            @break
    
            @endforeach
       @endisset
</div>

