@extends('layouts.app')
@include('partials.adminbar')
@include('partials.topbar')



@section('content')
    @yield('adminbar')
    <section id="feed">
        @yield('topbar')
        <h3>Groups Proposal's</h3>
            @foreach ($groups as $group)
                <div class="card mb-3" id="country-{{$group->id}}">
                <img src="{{url($group->banner_pic)}}" class="card-img-top banner-pic" alt="{{$group->country->name}} Banner">
                <div class="card-body">
                    <h5 class="card-title">{{$group->country->name}}</h5>
                    <h7 class="card-title">From: {{$group->parentGroup->country->name}}</h7>
                    <p class="card-text">{{$group->description}}</p>
                    <p class="card-text"><small class="text-body-secondary">
                        By <a href="{{ url('/user/'. $group->owners->first()->id) }}">
                    &#64;{{ $group->owners->first()->username }}</h2>
                        </a>
                    </small></p>
                </div>
                <div class="card-footer text-body-secondary text-center">
                    <button type="button" class="btn btn-success accept-group" data-id="{{$group->id}}">Accept</button>
                    <button type="button" class="btn btn-danger reject-group" data-id="{{$group->id}}">Reject</button>
                </div>
                </div>
        @endforeach
        </tbody>
        </table>
        </div>
    </section>
@endsection