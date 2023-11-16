@extends('layouts.app')

@section('content')
<section class="login-register">
    <section class="logo">
        <img src="../logo.png" width=10% alt="Traveller Logo">
        <h1>Traveller</h1>
    </section>
    <form class="login-register-form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="error">
            {{ $errors->first('email') }}
            </span>
        @endif

        <label for="password" >Password</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>
        <div id="buttons-container">
            <button class="button" type="submit">Login</button>
            <a class="link-button" href="{{ route('register') }}">Register</a>
        </div>
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </form>
</section>
@endsection