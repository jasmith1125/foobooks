<!DOCTYPE html>
<html>
<html class="no-js" lang="en">
<head>

    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Foobooks')</title>
    <link rel='stylesheet' href='' type='text/css'>
    {{ HTML::style('css/foundation.css') }}
	{{ HTML::style('css/app.css') }}
	{{ HTML::script('js/vendor/modernizr.js') }}

    @yield('head')

</head>

<body>
<div class='row'>
<div class="large-12 large-centered small-12 small-centered columns">

<img src='../img/foobooks-logo.png' alt='Foobooks logo'>

@yield('body')

@yield('scripts')
</div>
</div>
   <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script> 
</body>
</html>