@extends('layout.master')

@php
    use App\Models\User;
    use App\Models\Account;

    $userModel = User::Person('user_person_id', Auth::user()->user_person_id)
        ->first();

    $accountModel = Account::find($userModel->person_account_id);

@endphp
@section('content')   
<div class="uk-container uk-container-xsmall"> 
    <form id="account-update" action="{{route('account.store')}}" method="POST">
        @csrf
        @if ($accountModel)
            @include('authentication.partial.loginPartial')
        @else
            @include('account.partial.createPartial')
        @endif
    </form>
</div>
@endsection
