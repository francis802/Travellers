@section('edit')
    <form class="edit-page-form" method="post" action="{{ url('user/edit') }}" enctype="multipart/form-data">
        @csrf

        <section class="edit-page-info-options">
            <section class="edit-page-names-options">
                <h3 for="name">Name</h3>
                <input placeholder="Your name" type="text" name="name" value="{{ old('name', $old['name']) }}" required autofocus></input>
                
                <h3 for="username">Username</h3>
                <input type="text" placeholder="Your username" name="username" value="{{ old('username', $old['username']) }}" required autofocus></input>
                
            </section>
        </section>

        <section class="edit-page-config-options">   
            <h3 for="email">Email</h3>
            <input type="text" name="email" placeholder="Your email" value="{{ old('email', $old['email']) }}" required autofocus></input>
            
            <h3 for="password">Password</h3>
            <input type="password" name="password" placeholder="Your password" autofocus></input>
            <h3 for="password_confirmation">Confirm password</h3>
            <input type="password" name="password_confirmation" placeholder="Confirm your password" autofocus></input>
                  
        </section>
    </form>
@endsection