<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Title</title>
        <link rel="stylesheet" href="/css/app.css" />
        @yield('additional_styles')
    </head>
    <body>
        {{-- Nav bar goes here --}}

        <div class="container mainContainer">
            @yield('content')
        </div>

    </body>
</html>
