<div class="modal fade" id="delete-post-popup-{{$post->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletePostPopup" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="deletePostPopup">Warning: Deleting Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        Are you sure you want to delete this post? This action cannot be undone.
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger post-delete" data-id="{{$post->id}}">Delete</button>
    </div>
    </div>
</div>
</div>

<div class="modal fade" id="share-post-popup-{{$post->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletePostPopup" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="deletePostPopup">Share this Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <div class="row row-cols-1 row-cols-2 g-4">
    @foreach ($sharedUsers as $user)
    <div class="col">
        <div class="card post-share" post-id="{{$post->id}}" user-id="{{$user->id}}">
        <img src="{{$user->profile_photo != null ? url($user->profile_photo) : asset('man.jpg')}}" class="img-fluid rounded-start" alt="{{$user->name}} Profile Photo" style="max-width: 240px; max-height: 240px;">
        <div class="card-body">
            <h5 class="card-title">{{$user->name}}</h5>
            <p class="card-text">{{$user->username}}</p>
        </div>
        </div>
    </div>
    @endforeach
    </div>
    </div>
    </div>
</div>
</div>