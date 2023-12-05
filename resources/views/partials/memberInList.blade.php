@section('memberInList')
    @foreach($members as $member)
    
    <li class="group-in-list">
        <a href="{{ url('/user/'.$member->id) }}" class="group-in-list-name">
            {{ $member->user()->name }}
        </a>
                
    </li>
    
    @endforeach

@endsection