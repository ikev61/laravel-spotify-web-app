<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Artists</title>
        @include('layout.style')
    </head>

    <body>
    	<header>
    		@include('layout.header')
    	</header>
        <div class="w3-content w3-padding-top">
        	<h2>Top Artists</h2>
        	<ul class="w3-ul w3-large">
        		@foreach ($artists as $artist)
	            	<li><a href="{{$artist}}">{{$artist}}</a></li>
	            @endforeach
        	</ul>
        </div>
    </body>
    @include('layout.script')
</html>
