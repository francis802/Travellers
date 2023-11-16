@extends('layouts.app')

@section('content')
<section class="login-register">
    <section class="logo">
        <img src="../logo.png" width=10% alt="Traveller Logo">
        <h1>Traveller</h1>
    </section>
  <form class="login-register-form" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}

      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
      @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
      @endif

      <label for="username">Username</label>
      <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
      @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
      @endif

      <label for="country">Country</label>
      <input id="country" type="text" name="country" value="{{ old('country') }}" required autofocus>
      @if ($errors->has('country'))
        <span class="error">
            {{ $errors->first('country') }}
        </span>
      @endif

      <label for="email">E-Mail Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" required>

    <div id="buttons-container">
      <button class="button" type="submit"> Register </button>
      <a class="link-button" href="{{ route('login') }}">Login</a>
  </form>
</section>
@endsection