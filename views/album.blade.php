<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{$album->name}} </title>
        @include('layout.style')
    </head>

    <body>
    	<header>
    		@include('layout.header')
    	</header>
        <div class="w3-content w3-padding-top">
        	<h2><small><a href="http://localhost/spotify/public/{{$artist}}">back to {{$artist}}</a></small> | {{$album->name}}</h2>
            <div class="w3-row">
                <div class="w3-third">
                    <img src="{{$album->images[0]->url}}" class="w3-image">
                </div>
            	<div class="w3-twothird w3-padding">
                    <h4>Album type:</h4>
                    <small class="w3-border w3-padding-small">{{$album->album_type}}</small>
                    <h4>Artists:</h4>
                    @foreach ($album->artists as $artist)
                        <small class="w3-border w3-padding-small">{{$artist->name}}</small>
                    @endforeach
                    <h4>Copyrights:</h4>
                    @foreach ($album->copyrights as $cright)
                        <small class="w3-border w3-padding-small">{{$cright->text}}</small>
                    @endforeach
                    <h4>Label:</h4>
                    <small class="w3-border w3-padding-small">{{$album->label}}</small>
                    <h4>Release date:</h4>
                    <small class="w3-border w3-padding-small">{{$album->release_date}}</small>
                    <h4>Total tracks:</h4>
                    <small class="w3-border w3-padding-small">{{$album->total_tracks}}</small>
                    <h4>Tracks:</h4>
                    @foreach ($album->tracks->items as $track)
                        <small class="w3-border w3-padding-small">{{$track->name}}</small>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
    @include('layout.script')
</html>
