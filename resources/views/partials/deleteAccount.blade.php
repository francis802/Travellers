<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteWaring-{{$user->id}}">
    <i class="fas fa-trash-alt"></i>
</button>

<div class="modal fade" id="deleteWaring-{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteWarningLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteWarningLabel">Warning: Deleting User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        Are you sure you want to delete this account? This action cannot be undone.
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    </div>
</div>
</div>
