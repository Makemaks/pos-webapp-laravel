@php
    use App\Helpers\StringHelper;
    use App\Models\Store;
    use App\Models\Account;
@endphp


<div class="uk-grid-match uk-child-width-1-4@m" uk-grid>
    @if ($data['accountList'])
        @foreach ($data['accountList'] as $account)
            @php
                 $storeModel = Store::Root('store_account_id',$account->account_id)
                ->first();
            @endphp
            <div href="{{route('account.show', $account->account_id)}}">
                    <div class="uk-card uk-card uk-card-default uk-card-small uk-card-body">
                        <ul class="uk-iconnav uk-padding-small">
                           
                            <li><a href="{{route('account.edit', $account->account_id)}}" class="" uk-icon="icon: pencil"></a></li>
                            
                            @if ($account->root_account_id)
                                <li><a href="{{route('authentication.admin-store', 1)}}" class="" uk-icon="icon: sign-in"></a></li>
                            @endif

                            @if ($storeModel != NULL)
                                <li><a href="{{route('authentication.admin-store', $storeModel->store_id)}}" uk-icon="link" class="uk-button uk-button-default"></a></li>
                            @endif

                        </ul>

                        <div class="">
                            <div class="uk-section" style="background-color: #{{StringHelper::getColor()}}"></div>
                        </div>
                        <div class="uk-card-body">
                            <div class="uk-position-center uk-text-center uk-light"> 
                                {{Account::AccountType()[$account->account_type]}}
                                @if ($storeModel)
                                    {{$storeModel->store_name}}
                                @endif
                            </div>
                            
                        </div>
                        <div>
                            <h3 class="uk-text-center">
                                {{-- <a class="uk-button uk-button-text" href="{{route('account-manager.dashboard', $account->account_id)}}">{{$account->account_name}}</a> --}}
                            </h3>
                            <p>{{$account->account_business_hours}}</p>

                        </div>
                    </div>
            </div>
           
        @endforeach
    @endif
</div>
