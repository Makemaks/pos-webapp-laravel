@extends('layout.master')
@php
   
   $booleanViewMenu = 1;
   
@endphp
@section('content')

<div class="uk-align-center uk-width-1-2@m">
    <form method="POST" action="{{ route('registeration.store') }}">
        @csrf
        <h3>{{ __('Register') }}</h3>
        <div class="uk-margin" hidden>
            <label for=""></label>
            <input name="person_person_id" class="uk-input" value="{{$userData['person_person_id']}}" type="text">           
        </div>
        <div class="uk-margin">
            <label for="email" class="uk-form-label">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="uk-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="uk-margin">
            <label for="password" class="uk-form-label">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="uk-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="uk-margin">
            <label for="passwordConfirm" class="uk-form-label">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="passwordConfirm" type="password" class="uk-input" name="passwordConfirm" required autocomplete="new-password">
            </div>
        </div>

        <div class="uk-margin">
            <div class="">
                <button type="submit" class="uk-button uk-button-default">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
