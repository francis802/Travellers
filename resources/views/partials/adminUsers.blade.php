@section('adminUsers')
    <section id="admin-users">
        <div class="container">
            <div class="row">
                <div class="col-12">
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
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <div class="dropdown-center">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                            @if($user->isAdmin())
                                                Admin
                                            @elseif($user->isBanned())
                                                Banned
                                            @else
                                                User
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Admin</a></li>
                                            <li><a class="dropdown-item" href="#">User</a></li>
                                            <li><a class="dropdown-item" href="#">Banned</a></li>
                                        </ul>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        @include('partials.deleteAccount')
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