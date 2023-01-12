@php
    use App\Models\Account;

    $action = Request::session()->get('action');
    $view = Request::session()->get('view');
@endphp

<button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="accountUpdate" value="accountUpdate">
    Save
</button>

<button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="accountUpdate" value="accountDelete" name="accountDelete">
    Delete
</button>

<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li>
        <a href="#">Account</a>
    </li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>
        
        <form id="accountUpdate" action="{{route('account.update', 'account')}}" method="POST">
            @csrf
            @method('PATCH')

            @include('partial.scheduleModalPartial', ['view' => $view, 'action' => $action])
            
            <div>       
                <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">

                    <thead>
                        <tr>
                            <th></th>
                            <th>REF</th>
                            @foreach (collect($data['accountList']->first())->except('account_id','account_blacklist','created_at','updated_at') as $key => $item)
                                <th>{{$key}}</th>
                            @endforeach
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data['accountList']  as $key_account => $account)
                            <tr>
                                <td>
                                    <input type="checkbox" name="account_delete[]" value="{{$account->account_id}}">
                                </td>
                                <td>
                                    <button class="uk-button uk-button-default uk-border-rounded">{{$account->account_id}}</button>
                                </td>
                                @foreach(collect($account)->except('created_at','updated_at') as $key_account_data => $account_data) 
                                    @if($key_account_data == 'account_id')
                                        <input type="hidden" name="account[{{$key_account}}][{{$key_account_data}}]" value="{{$account_data}}">
                                    @elseif($key_account_data == 'account_system_id')
                                        <td><input class="uk-input" type="text" name="account[{{$key_account}}][{{$key_account_data}}]" value="{{$account_data}}"></td>
                                    @elseif($key_account_data == 'accountable_id')
                                        <td><input class="uk-input" type="text" name="account[{{$key_account}}][{{$key_account_data}}]" value="{{$account_data}}"></td>
                                    @elseif($key_account_data == 'accountable_type')
                                        <td><input class="uk-input" type="text" name="account[{{$key_account}}][{{$key_account_data}}]" value="{{$account_data}}"></td>
                                    @elseif($key_account_data == 'account_name')
                                        <td><input class="uk-input" type="text" name="account[{{$key_account}}][{{$key_account_data}}]" value="{{$account_data}}"></td>
                                    @elseif($key_account_data == 'account_type')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="account[{{$key_account}}][{{$key_account_data}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                @foreach(Account::Type() as $key_account_type => $type)
                                                    <option value="{{$key_account_type}}" {{$key_account_type == $account_data ? 'selected' : ''}}>
                                                        {{$type}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @elseif($key_account_data == 'account_description')
                                        <td><textarea class="uk-textarea" name="account[{{$key_account}}][{{$key_account_data}}]">{{$account_data}}</textarea></td>
                                    @elseif($key_account_data == 'parent_account_id')
                                        <td><input class="uk-input" type="text" name="account[{{$key_account}}][{{$key_account_data}}]" value="{{$account_data}}"></td>
                                    {{-- @elseif($key_account_data == 'account_blacklist')
                                        <td>{{$account_data}}</td> --}}
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        
                </table>
                @include('partial.paginationPartial', ['paginator' => $data['accountList']])
            </div>
        </form>
    </li>
    
       
    <li>
        <form action="{{ route('account.store') }}" method="POST">
            @csrf
            <div uk-grid>
                @foreach(collect($data['accountList']->first())->except('account_id','created_at','updated_at') as $key_account_form => $account_data) 
                    <div>
                        <label class="uk-form-label" for="form-stacked-text">{{Str::title(str_replace('_',' ',$key_account_form))}}</label>
                        @if($key_account_form == 'account_type')
                            <select class="uk-select" id="form-stacked-select" name="form[{{$key_account_form}}]">
                                <option value="" selected disabled>SELECT ...</option>
                                @foreach(Account::Type() as $key_account_type => $type)
                                    <option value="{{$key_account_type}}">
                                        {{$type}}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($key_account_form == 'account_description')
                            <textarea class="uk-textarea" name="form[{{$key_account_form}}]"></textarea>
                        @else
                            <input name="form[{{$key_account_form}}]" class="uk-input" type="text" placeholder="{{Str::title(str_replace('_',' ',$key_account_form))}}">
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="uk-child-width-expand@m" uk-grid>
                <div>
                    <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" type="submit">
                        SAVE
                    </button>
                </div>     
            </div>
        </form>
    </li>
</ul>