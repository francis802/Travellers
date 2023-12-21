@extends('layouts.app')

@section('content')
<section id="cont">
<section class="login-register">
    <section class="logo">
        <img src="../logo.png" width=10% alt="Traveller Logo">
        <h1>Traveller</h1>
    </section>
    <form class="login-register-form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
        

        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" required class="form-control" aria-describedby="passwordHelpBlock">
        

        <div id="buttons-container">
            <button class="btn btn-primary" type="submit">Login</button>
            <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
        </div>
        
    </form>
    @if ($errors->has('email'))
            <span class="error">
            {{ $errors->first('email') }}
            </span>
        @endif
    @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
    @endif
    @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
     @endif

     <a href="{{ url('/recovery/') }}">Forgot your password?</a>
</section>
</section>
</section>
@endsection