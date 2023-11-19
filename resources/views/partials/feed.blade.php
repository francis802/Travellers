@include('partials.topbar')

@section('feed')

<section id="feed">
    @yield('topbar')
    <section id="user-bar">
        <a href="{{ url('/user/'.Auth::user()->id) }}" class="profile-info">
            <div id="profile-picture">
                <img src="../man.jpg" alt="Profile Picture">
            </div>
            @if (Auth::check())
                <h2 id="user-username">&#64;{{ Auth::user()->username }}</h2>
            @endif
        </a>
        <input type="text" placeholder="Search here...">
    </section>

    <section id="buttons">
        <button id="forYouButton" class="underline" onclick="toggleButton('forYouButton')">For You</button>
        <button id="followingButton" onclick="toggleButton('followingButton')">Following</button>
    </section>

    <script>
        function toggleButton(buttonId) {
            const buttons = document.querySelectorAll('#buttons button');
            buttons.forEach(button => {
                button.classList.remove('underline');
            });
            const selectedButton = document.getElementById(buttonId);
            selectedButton.classList.add('underline');
        }
    </script>
    
    <section id="fy-posts">
        <ul id="user-post-list">
        @if(count($publicPosts) == 0)
        echo("<p>"dcsdcsdcsdc"</p>")
        @endif
            @foreach($publicPosts as $post)
                <li class="post">
                    <section class="post-container">
                        <div id="post-header">
                            @if($post->id == Auth::user()->id || Auth::user()->isAdmin())
                                <a id="edit-post" href="">...</a>
                            @endif
                        </div>
                        <div id="post-content">
                            <p>{{ $post->text }}</p>
                            
                        </div>
                        <div id="post-interaction">

                        </div>
                        
                    </section>
                </li>
            @endforeach
            </ul>
        </section>
    
</section>

@endsection
