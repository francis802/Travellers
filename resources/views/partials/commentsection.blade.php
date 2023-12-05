<div class="comment-section">
    <form class="comment-submit">
        <textarea name="comment" id="comment" cols="40" rows="1" placeholder="Write a comment..."></textarea>
        <button class="comment-create" post-id="{{$post->id}}">Post</i></button>
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
                <div class="comment-body">
                    <p class="comment-text">{{ $comment->text }}</p>
                    <button class="{{Auth::check() && Auth::user()->likedComment($comment->id) ? 'dislike-comment' : 'like-comment'}}" data-id="{{$comment->id}}">
                    <h5 class="like-count">
                    <i class="{{Auth::check() && Auth::user()->likedComment($comment->id) ? 'fa-solid fa-heart fa-1x' : 'fa-regular fa-heart fa-1x'}}" style="color: #cc0f0f;"></i>
                    {{count($comment->likes())}}
                    </h5>
                </button>
                    <p class="comment-date">{{ $comment->date }}</p>
                    <p class="comment-edited" style="display: none;">Edited</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>