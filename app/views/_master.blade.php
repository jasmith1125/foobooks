<!DOCTYPE html>
<html>
<head>

    <title>@yield('title','Foobooks')</title>
    <meta charset='utf-8'>

    <link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/flatly/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='/css/foobooks.css' type='text/css'>

    @yield('head')


</head>
<body>

    @if(Session::get('flash_message'))
        <div class='flash-message'>{{ Session::get('flash_message') }}</div>
    @endif

    <nav>
        <ul>
        @if(Auth::check())
            <li><a href='/logout'>Log out {{ Auth::user()->email; }}</a></li>
            <li><a href='/book'>View all Books</a></li>
            <li><a href='/book/create'>+ Add Book</a></li>
        @else
            <li><a href='/signup'>Sign up</a> or <a href='/login'>Log in</a></li>
        @endif
        </ul>
    </nav>


    <a href='/'><img class='logo' src='/img/foobooks-logo.png' alt='Foobooks logo'></a>

    <a href='https://github.com/susanBuck/foobooks'>View on Github</a>

    @yield('content')

    @yield('/body')

</body>
</html>




