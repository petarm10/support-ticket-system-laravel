<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">{{ __('Name') }}</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

    <label for="email">{{ __('E-Mail Address') }}</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>

    <label for="password">{{ __('Password') }}</label>
    <input id="password" type="password" name="password" required>

    <label for="password-confirm">{{ __('Confirm Password') }}</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <button type="submit">
        {{ __('Register') }}
    </button>
</form>
