@include('partials.topbar')
<section id="feed">
    @yield('topbar')
    <h1>Admin Console</h1>
    <h3> Welcome {{Auth::user()->name}}!</h3>

</section>