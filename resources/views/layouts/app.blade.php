<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/sidebar.css') }}" rel="stylesheet">
        <link href="{{ url('css/login_register.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/feed.css') }}" rel="stylesheet">
        <link href="{{ url('css/topbar.css') }}" rel="stylesheet">
        <link href="{{ url('css/adminpage.css') }}" rel="stylesheet">
        <link href="{{ url('css/post.css') }}" rel="stylesheet">
        <link href="{{ url('css/comment.css') }}" rel="stylesheet">
        <link href="{{ url('css/notifications.css') }}" rel="stylesheet">
        <link href="{{ url('css/group.css') }}" rel="stylesheet">
        <link href="{{ url('css/message.css') }}" rel="stylesheet">
        <link href="{{ url('css/recovery.css') }}" rel="stylesheet">
      
        <script src="https://kit.fontawesome.com/a2d4a9c2fb.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/admin.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/help.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/post.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/user.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/image.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/search.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/message.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/recover.js') }} defer></script>
    </head>
    <body>
        <main>
            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
</html>