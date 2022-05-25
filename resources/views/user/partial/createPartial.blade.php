@php
use App\Models\User;
$action = Str::after(Request::route()->getName(), '.');
@endphp
<div class="">
    <fieldset class="uk-fieldset">

        <legend class="uk-legend"></legend>

        <div class="uk-margin uk-text-center">
            <img class="uk-border-rounded" src="{{ $data['userModel']->user_image }}" width="200" height="200">
            <div class="uk-margin" uk-margin>
                <div uk-form-custom="target: true">
                    <input type="file">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                </div>
            </div>
            {{-- <div class="uk-margin">
                @if ($data['userModel']->user_id)
                    @if ($data['userModel']->person_barcode)
                        {!! $data['userModel']->person_barcode !!}
                        <a class="uk-margin uk-border-rounded uk-button uk-button-default uk-text-primary"
                            href="{{ route('init.print', ['membershipCard', $data['userModel']->user_id]) }}"
                            uk-icon="icon: print"></a>
                    @else
                        <a class="uk-border-rounded uk-button uk-button-default uk-text-primary"
                            href="{{ route('init.card', ['user', $data['userModel']->user_id]) }}"
                            uk-icon="icon: credit-card"></a>
                    @endif
                @endif
            </div> --}}
        </div>

        @include('person.partial.createPartial')


        <div class="uk-margin">
            <select class="uk-select" name="user_type">
                @foreach (User::UserType() as $typeItem => $typeValue)
                    <option value="{{ $typeItem }}"
                        {{ old('user_type', $data['userModel']->user_type) == $typeItem ? ' selected="selected"' : '' }}>
                        {{ Str::ucfirst($typeValue) }}</option>
                @endforeach
            </select>
        </div>

        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="Email" name="email"
                value="{{ old('email', $data['userModel']->email) }}">
        </div>
        @error('email')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror

        <div class="uk-margin">
            <input class="uk-input" name="password" type="password" placeholder="Password"
                value="{{ old('password') }}">
        </div>
        @error('passoword')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
        {{-- <div class="uk-margin">
            <button type="button" class="uk-button uk-button-default" onclick="generatePassword()">Generate</button>
            <button type="button" class="uk-button uk-button-default" onclick="showPassword(this)">Show</button>
        </div> --}}

        {{-- <div class="uk-margin">
            <select name="user_is_notifiable" class="uk-select">
                @foreach (User::SelectType() as $count => $type)
                        <option value="{{$count}}" {{ old('user_is_notifiable', $data['userModel']->user_is_notifiable) == $count ? 'selected' : '' }}>{{$type}}</option>
                    @endforeach
            </select>
        </div>

        <div class="uk-margin">
            <select name="user_is_disabled" class="uk-select">
                @foreach (User::SelectType() as $count => $type)
                        <option value="{{$count}}" {{ old('user_is_disabled', $data['userModel']->user_is_disabled) == $count ? 'selected' : '' }}>{{$type}}</option>
                    @endforeach
            </select>
        </div> --}}

        @include('user.partial.employmentPartial')

    </fieldset>

</div>
