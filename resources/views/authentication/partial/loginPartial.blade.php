<h3>{{ __('Login') }}</h3>
<div class="uk-margin">
    <label for="email" class="uk-form-label">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="uk-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
</div>

<div class="uk-margin">
    <label for="password" class="uk-form-label">{{ __('Password') }}</label>
        <input id="password" type="password" class="uk-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
</div>

<div class="uk-margin">
        <div class="form-check">
            <input class="uk-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
</div>
<div class="uk-margin">
    <div class="uk-form-controls">
        <label><input class="uk-checkbox uk-margin-small-right" type="checkbox"><small>Accept our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</small></label>
    </div>
</div>

<div class="uk-margin">
    <div class="col-md-8 offset-md-4">
        <button type="submit" class="uk-button uk-button-default">
            {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
            <a class="uk-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</div>