@extends('app')

@section('content')
<div class="w3-content w3-padding-top">
	<h2><a href="/{{$artist}}" class="btn">&larr; </a> {{$album->name}}</h2>
    <div class="w3-row">
        <div class="w3-third">
            <img src="{{$album->images[0]->url}}" class="w3-image">
            <div class="w3-black w3-padding-small text-center" style="overflow-x: hidden;max-height: 250pt;overflow-y: auto;">
                @foreach ($album->tracks->items as $track)
                    <small onclick="playURI('{{$track->uri}}')" class="w3-border-white w3-padding-small btn w3-btn" style="display: inline-block;margin: 5pt 0">{{$track->name}}</small>
                @endforeach
            </div><br />
        </div>
    	<div class="w3-twothird w3-padding">
            <h4>Artists:</h4>
            @foreach ($album->artists as $artist)
                <small class="w3-border w3-padding-small" style="display: inline-block;margin-bottom: 2pt">{{$artist->name}}</small>
            @endforeach<br /><br />
            <h4>Type:</h4>
            <small class="w3-border w3-padding-small">{{$album->album_type}}</small><br /><br />
            <h4>Copyrights:</h4>
            @foreach ($album->copyrights as $cright)
                <small class="w3-border w3-padding-small" style="display: inline-block;margin-bottom: 2pt">{{$cright->text}}</small>
            @endforeach<br /><br />
            <h4>Label:</h4>
            <small class="w3-border w3-padding-small">{{$album->label}}</small><br /><br />
            <h4>Release date:</h4>
            <small class="w3-border w3-padding-small">{{$album->release_date}}</small><br /><br />
            <!--<h4>Total tracks:</h4>
            <small class="w3-border w3-padding-small">{{$album->total_tracks}}</small><br /><br />
            <h4>Tracks:</h4>-->
        </div>
    </div>
    <div class="w3-row h2 text-center">
        <a href="{{$album->external_urls->spotify}}" class="btn w3-btn" target="_blank">&#9658; Play album</a>
    </div>
</div>
@endsection

@section('page_js')
    <!-- Load the Spotify Web Playback SDK -->
<script src="https://sdk.scdn.co/spotify-player.js"></script>

<script>
    // Called when the Spotify Web Playback SDK is ready to use
    window.onSpotifyWebPlaybackSDKReady = () => {
        //playURI(uri);
    };

    function playURI(uri) {
        // Define the Spotify Connect device, getOAuthToken has an actual token 
        // hardcoded for the sake of simplicity
        var player = new Spotify.Player({
            name: 'A Spotify Web SDK Player',
            getOAuthToken: callback => {
                callback('BQBuV1Bmw9IdeWk7NtBAg61LgfKdxTJTPlaD2Vt8RVf0nskq_yFvOmWfoob3C7aZ71bCWDvnxAfahgNzfoh1eXQzp8b69dg5Ik4D8EMjPY0IB9n4-9vrcTH8oAlybUQBQV11cCqeAZcJW4w3AME3OK5Axb11w9IFYDavPFz-pL_XHtFgB-973YWLjA');
            },
            volume: 1
        });

        // Called when connected to the player created beforehand successfully
        player.addListener('ready', ({ device_id }) => {
            console.log('Ready with Device ID', device_id);
            const play = ({
                spotify_uri,
                playerInstance: {
                    _options: {
                        getOAuthToken,
                        id
                    }
                }
            }) => {
                getOAuthToken(access_token => {
                    fetch(`https://api.spotify.com/v1/me/player/play?device_id=${id}`, {
                        method: 'PUT',
                        body: JSON.stringify({ uris: [spotify_uri] }),
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${access_token}`
                        },
                    });
                });
            };
            play({
                playerInstance: player,
                spotify_uri: uri,
            });
        });
        // Connect to the player created beforehand, this is equivalent to 
        // creating a new device which will be visible for Spotify Connect
        player.connect();
    }
</script>
@endsection