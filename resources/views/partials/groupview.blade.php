@include('partials.topbar')

@section('groupview')
<section id="profile">
    @yield('topbar')
        <section id="user-presentation"> 
            <div id="profile-picture">
                @if ($group->banner_pic !== null)
                    <img src="{{ url($group->banner_pic) }}">
                @else
                    <img src="../man.jpg" alt="Profile Picture">
                @endif
            </div>
                <section id="profile-text">
                    <h3 id="user-name">{{ count($group->members) }}</h3>
                    <section id="user-infos">
                        <p>{{ $group->description }}</p>
                        
                    </section>
                    <p>{{ count($subgroups) }}</p>
                </section>
        </section>

        


        <section id="user-posts">
                @if(count($posts) > 0)
                    <ul id="user-post-list">
                        @include('partials.postsProfile', ['posts' => $posts])
                        @yield('postsProfile')
                    </ul>
                @else
                    <p>This group has no posts.</p>
                @endif
        </section>
</section>
@endsection

