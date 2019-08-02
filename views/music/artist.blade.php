@extends('app')

@section('content')
<div class="w3-content w3-padding-top">
	<h2><small><a href="/" class="btn">&larr; </a></small> {{$artist->name}}</h2>
    <div class="w3-row">
        <div class="w3-third">
            <img src="{{$artist->images[0]->url}}" class="w3-image">
        </div>
    	<div class="w3-twothird">
            <ul class="w3-ul w3-large">
                @foreach ($albums as $key => $album)
                    <li><a href="{{Request::url()}}/{{$album['spotify_album_id']}}">{{$album['name']}}</a></li>
                @endforeach
            </ul>  
             <div class="w3-row w3-margin-top w3-padding">
                {{$albums->links()}}
            </div>
        </div>
    </div>
</div>
@endsection