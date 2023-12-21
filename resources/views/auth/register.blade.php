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
      <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control"  required autofocus>
     
      <label for="username">Userame</label>
      <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control"  required autofocus>
      
      <label for="country">Country</label>
      <select id="country" name="country" class="form-select form-select-sm" required aria-label="Select your country">
        @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
        @endforeach
      </select>

      <label for="email">Email</label>
      <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="name@example.com">

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required class="form-control" aria-describedby="passwordHelpBlock">
      <div id="passwordHelpBlock" class="form-text hit"> Your password must be 8-20 characters long.</div>
      

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" required class="form-control" aria-describedby="passwordHelpBlock">
      


    <div id="buttons-container">
      <button class="btn btn-primary" type="submit"> Register </button>
      <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
    </div>

      @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
      @endif

      @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
      @endif

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
  </form>
</section>
@endsection