

<div class="card mb-3" id="post-id-{{$post->id}}">
    <div class="card-header post-header">
        <div id="post-author">
            <a href="{{ url('/user/'.$post->author->id) }}" class="post-author-name">
                @if ($post->author->is_deleted)
                    [Deleted User]
                @else
                    {{ $post->author->name }}
                @endif
            </a>
        </div>

        <div id="edit-delete-post" class="btn-group dropstart">
            <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">...</button>
            <ul class="dropdown-menu">
                @if ($post->author->id == Auth::user()->id)
                    <li>
                        <a href="{{ url('/post/'.$post->id.'/edit') }}" class="post-edit dropdown-item">
                            <img src="../pen.png" alt="Edit Post">
                            Edit
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                @endif
                @if ($post->author->id == Auth::user()->id || Auth::user()->isAdmin())
                    <li>
                        <div class="post-delete dropdown-item" data-id="{{$post->id}}">
                            <img type="image" src="../trash-bin.png" alt="Delete Post">
                            Delete
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        
    </div>
    <div class="card-body">
        <a href="{{url('/post/'.$post->id)}}">
            @if ($post->media !== null)
                <img src="../images/post/post-{{$post->id}}.jpg"  alt="{{ $post->text }}" class="card-img-top">
            @endif
            <div class="post-body-text">
                <p class="post-description">{{ $post->text }}</p>
            </div>
        </a>
    </div>
        <div class="card-footer">
            <ul class="post-footer-links">
                <button class="{{Auth::check() && Auth::user()->likedPost($post->id) ? 'dislike-post' : 'like-post'}}" data-id="{{$post->id}}">
                    <h5 class="like-count">
                    <i class="{{Auth::check() && Auth::user()->likedPost($post->id) ? 'fa-solid fa-heart fa-2x' : 'fa-regular fa-heart fa-2x'}}" style="color: #cc0f0f;"></i>
                    {{count($post->likes())}}
                    </h5>
                </button>
                <button class="comment-post">
                    <h5 class="comment-count">
                    <i class="fa-regular fa-comment fa-2x"></i>
                    {{ count($post->comments) }}
                    </h5>
                </button>
                <button class="share-post">
                    <h5>
                    <i class="fa-regular fa-share-from-square fa-2x" style="color: #000000;"></i>
                    </h5>
                </button>
            </ul>
        </div>

        @if(url()->current() == url('/post/'.$post->id))
            @include('partials.commentsection', ['post'=>$post])
        @endif
</div>

