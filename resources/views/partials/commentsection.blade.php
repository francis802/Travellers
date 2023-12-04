<div class="comment-section">
    <form action="{{ url('comment/create') }}" method="post" class="post-comment-form">
        <textarea name="comment" id="comment" cols="30" rows="1" placeholder="Write a comment..."></textarea>
        @csrf
    </form>
    <ul class="post-comments-list">
        @foreach ($post->comments as $comment)
            <li class="post-comment" id="comment-id-{{$comment->id}}">
                <div class="post-comment-author">
                    <a href="{{ url('/user/'.$comment->author->id) }}" class="post-comment-author-name">
                        {{ $comment->author->name }}
                    </a>
                </div>
                <div class="post-comment-edit-delete">
                    @if ($comment->author->id == Auth::user()->id)
                        <button class="comment-edit" data-id="{{$comment->id}}">
                            <i class="fa-solid fa-pen fa-1x"></i>
                        </button>
                    @endif
                    @if ($comment->author->id == Auth::user()->id || Auth::user()->isAdmin())
                        <button class="comment-delete" data-id="{{$comment->id}}">
                            <i class="fa-solid fa-trash fa-1x"></i>
                        </button>
                    @endif
                </div>
                <p class="comment-text">{{ $comment->text }}</p>
            </li>
        @endforeach
    </ul>
</div>