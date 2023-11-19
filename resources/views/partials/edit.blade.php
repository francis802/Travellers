@section('edit')
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

        <label for="country">Country</label>
        <input id="country" type="text" name="country" value="{{ old('country', $old['country']) }}" required autofocus>
        @if ($errors->has('country'))
            <span class="error">
                {{ $errors->first('country') }}
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

            <section class="edit-page-final-buttons">
                <button class="button" type="submit">Submit</button>
            </section>
        </form>
    </section>
@endsection