<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title', 'Industry Arts')</title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/app.css">

    @hasSection('head-scripts')
        @yield('head-scripts')
    @endif

    @hasSection('head-styles')
        @yield('head-styles')
    @endif
</head>

<body>
<div id="container">
    <div id="content">
        @yield('content')
    </div>
</div>

@hasSection('scripts')
    @yield('scripts')
@endif

@hasSection('styles')
    @yield('styles')
@endif
</body>
</html>
