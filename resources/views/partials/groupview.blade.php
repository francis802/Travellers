@include('partials.topbar')

@section('groupview')
<section id="feed">
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
                    <h3 id="user-name">{{ $group->country->name }}</h3>
                    <section id="user-infos">
                        <p class="infos-with-margin">{{ $group->description }}</p>
                        <p class="infos-with-margin"><a href="">{{ count($subgroups) }} Subgroups</a></p>
                        <p class="infos-with-margin"><a href="{{ url('/group/'.$group->id.'/members') }}">{{ count($members) }} Members</a></p>
                    </section>
                </section>
                <section id="profile-buttons-area">
                        <a class="button" href="{{ url('/group/'.$group->id.'/edit') }}"> Edit </a>
                        <a class="button" href=""> Follow </a>
                </section>
                
        </section>

        


        <section id="user-posts">
                @if(count($posts) > 0)
                    <ul id="user-post-list">
                        @foreach($posts as $post)
                            @include('partials.post', ['post' => $post])
                        @endforeach
                    </ul>
                @else
                    <p>This group has no posts.</p>
                @endif
        </section>
</section>
@endsection

