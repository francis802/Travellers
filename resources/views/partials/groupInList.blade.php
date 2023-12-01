@section('groupInList')
    @foreach($groups as $group)
    
    <li class="group-in-list">
        <a href="{{ url('/group/'.$group->id) }}" class="group-in-list-name">
            {{ $group->description }}
        </a>
                
    </li>
    
    @endforeach

@endsection