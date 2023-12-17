@section('adminUsers')
    <section id="admin-users">
        <div class="container">
            <div class="row">
                <div class="col-auto table-responsive">
                    <h1>Users</h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</td>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Groups</th>
                                <th scope="col">Delete User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->sortBy('id') as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>
                                        @if ($user->is_deleted)
                                        [Deleted User]
                                        @else
                                        {{$user->name}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->is_deleted)
                                        [Deleted User]
                                        @else
                                        &#64;{{$user->username}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->is_deleted)
                                        [Deleted User]
                                        @else
                                        {{$user->email}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown-center">
                                        <button class="btn btn-secondary dropdown-toggle membership-btn-{{$user->id}} {{$user->is_deleted == true ? 'disabled':''}}" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                            @if($user->isAdmin())
                                                Admin
                                            @elseif($user->isBanned())
                                                Banned
                                            @else
                                                User
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item admin-membership {{$user->isAdmin() ? 'active':''}}" data-id="{{$user->id}}">Admin</a></li>
                                            <li><a class="dropdown-item user-membership {{(!$user->isAdmin() && !$user->isBanned()) ? 'active':''}}" data-id="{{$user->id}}">User</a></li>
                                            <li><a class="dropdown-item banned-membership {{$user->isBanned() ? 'active':''}}" data-id="{{$user->id}}">Banned</a></li>
                                        </ul>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->is_deleted)
                                        <button type="button" class="btn btn-primary" disabled>
                                            Check Groups
                                        </button>
                                        @else
                                            @include('partials.groupsMembership', ['groups' => $groups, 'user' => $user])
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->is_deleted)
                                        <button type="button" class="btn btn-danger" disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @else
                                            @include('partials.deleteAccount', ['user' => $user])
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection