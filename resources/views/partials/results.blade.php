@include('partials.topbar')

@section('results')

<section id="results">
    @yield('topbar')
    <section id="search-results-header">
        <h1>Search Results For: "{{ $searchQuery }}"</h1>
    </section>
    
    @if($searchResults->count() > 0)
            @foreach($searchResults as $user)
            <section id="user-bar">
                <a href="{{ url('/user/'.$user->id) }}" class="profile-info">
                    <div id="profile-picture">
                        <img src="../man.jpg" alt="Profile Picture">
                    </div>
                    @if (Auth::check())
                        <h2 id="user-username">&#64;{{ $user->username }}</h2>
                    @endif
                </a>
            </section>
            @endforeach
    @else
        <p>No results found.</p>
    @endif

@endsection