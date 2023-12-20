@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    @yield('bar')
    <section id="feed">
        @yield('topbar')    
        <section id="edit-profil-form">
            <form class="login-register-form" method="post" action="{{ url('user/edit') }}" enctype="multipart/form-data">
                @csrf

                <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $old['name']) }}" required autofocus>
            @if ($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span>
            @endif

            <label for="username">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username', $old['username']) }}" required autofocus>
            @if ($errors->has('username'))
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
            @endif

            

            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $old['email']) }}" required autofocus>
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <label for="password">Password</label>
            <input id="password" type="password" placeholder="Your password" name="password" autofocus>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif

            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" type="password" placeholder="Confirm your password" name="password_confirmation" autofocus>

            <p>
                Private profile? <input type="checkbox" name="private" {{old('private', $old['private']) ? 'checked' : '' }}>
            </p>
            <section id="post-choose-photo">
                <div id="preview-container-user">
                    <div id="close-button" onclick="removeImage()" style="{{Auth::user()->profile_photo !== null ? 'block' : 'none'}}">&times;</div>
                    @if (Auth::user()->profile_photo !== null)
                    <img id="image-preview" src="{{url(Auth::user()->profile_photo)}}" alt="Previous Image">
                    @else
                    <img id="image-preview" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                    @endif
                </div>
                <label for="image" id="file-label">
                    @if (Auth::user()->profile_photo !== null)
                    Change Photo
                    @else
                    Select Photo
                    @endif
                </label>
                <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                <input type="hidden" name="clicked_x" id="clicked_x" value="no">
            </section>
                <section class="edit-page-final-buttons">
                    <button class="button" type="submit">Submit</button>
                </section>
            </form>
            @include('partials.deleteAccount', ['user' => Auth::user()])
        </section>
    </section> 
@endsection