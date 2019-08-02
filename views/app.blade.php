<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{$title ?? 'Authentication'}}</title>
    @include('layout.style')
    @yield('page_css')
</head>
<body>
    <header>
        @include('layout.header')
    </header>
    @if(session()->has('error'))
        <div class="w3-sand jumbotron">
            {!!session()->get('error')!!}
        </div>
    @endif
    @if(session()->has('success'))
        <div class="w3-green jumbotron">
            {!!session()->get('success')!!}
        </div>
    @endif
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
    @include('layout.script')
    @yield('page_js')
</html>