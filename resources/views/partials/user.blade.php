@section('user')
<section id="profile">
    @if (Auth::check())
        <section id="user-presentation"> 
            <section id="profile-text">
                <h3 id="user-username">&#64;{{ Auth::user()->username }}</h3>
            </section>
            <section id="profile-buttons-area">
                <a class="button" href=""> Edit </a>
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
            </section>
            
        </section>
        <section id="user-posts">
            <p>There are no posts yet.</p>
        </section>
    @else
        <p>Still working.</p>
    @endif
</section>
@endsection