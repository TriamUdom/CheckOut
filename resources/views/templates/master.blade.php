<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Title</title>
        @yield('additional_styles')
    </head>
    <body>
        {{-- Nav bar goes here --}}

        <div class="container mainContainer">
            @yield('content')
        </div>

    </body>
</html>
