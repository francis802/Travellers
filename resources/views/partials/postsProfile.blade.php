@section("postsProfile")
    @foreach($posts as $post)
    <div class="post-container" id="post-id-{{$post->id}}">
        <header id="post-header">
            <div id="post-author">
                <a href="{{ url('/user/'.$post->author->id) }}" class="post-author-name">
                    {{ $post->author->name }}
                </a>
            </div>
            <div id="edit-delete-post">
                @if ($post->author->id == Auth::user()->id)
                    <a href="{{ url('/post/'.$post->id.'/edit') }}" class="post-edit">
                        <img src="../pen.png" alt="Edit Post">
                    </a>
                @endif
                @if ($post->author->id == Auth::user()->id || Auth::user()->isAdmin())
                <div class="post-delete" data-id="{{$post->id}}">
                    <img type="image" src="../trash-bin.png" alt="Delete Post">
                </div>
                @endif
            </div>
        </header>
        <div class="post-body">
            <a href="{{url('/post/'.$post->id)}}">
                @if ($post->media !== null)
                    <img src="{{ url($post->media) }}" alt="{{ $post->text }}" class="post-img">
                @endif
                <div class="post-body-text">
                    <p class="post-description">{{ $post->text }}</p>
                    <p id="post-date">{{ $post->date }}</p>
                </div>
            </a>
        </div>
    </div>
    @endforeach
@endsection