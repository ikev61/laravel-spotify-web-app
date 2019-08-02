<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rennokki\Larafy\Larafy;
use App\Album;
use App\Artist;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct() {
        $this->middleware('auth');
        $this->api = new Larafy('e8c7be3ca98d4ab5bc84c0014190b910','24387bd9f9c045de8cc1d7a433f49e21');
    }

    public function index($artist) {

        $oArtist = $this->get_artist_db($artist);

        if(!$oArtist->artist_spotify_id) 
            return redirect()->back()->with('error', $artist.' not found on db');

        $album = $this->fetch_albums($oArtist->artist_spotify_id);
//dd($album);
        $oArtist->images = json_decode($oArtist->images);

        return view('music.artist',['artist'=>$oArtist,'albums'=>$album,'title'=>$artist]);
    }

    private function fetch_albums($artist_id) {

        $limit=20;$offset=0;
        if(isset($_GET['page']) and is_numeric($_GET['page']))
            $offset = $_GET['page'];

        $album = $this->fetch_local_album($artist_id,$limit,$offset);
        if($album)
            return $album;
        $this->download_albums($artist_id,$limit,$offset);
        $album = $this->fetch_local_album($artist_id,$limit,$offset);
        if($album)
            return $album;
        return null;
    }

    private function download_albums($artist_id,$limit,$offset) {

        $albums = $this->album_on_spotify($artist_id,$limit,$offset);
        foreach ($albums->items as $album) {
            $rows = 
            [
                'artist_spotify_id' => $artist_id,
                'spotify_album_id'  => $album->id,
                'name'              => $album->name,
                'limit_group'       => $limit,  //very important, ask me why
                'offset_group'      => $offset  //very important, ask me why
            ];
            Album::create($rows);
        }
    }

    private function fetch_local_album($artist_id,$limit,$offset) {
        //$offset++;//curiosity
        $album = Album::where([['artist_spotify_id','=',$artist_id],['limit_group','=',$limit],['offset_group','=',$offset]])->orderBy('created_at','desc')->paginate(20);
        if(count($album))
            return $album;
        return null;
    }

    private function album_on_spotify($artist_id,$limit,$offset) {
        try {
            return $this->api->getArtistAlbums($artist_id, $limit*2, $offset, ['single']);
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            return null;
        }
    }

    private function get_artist_db ($name) {
        $artist = Artist::where('name', '=', $name)->get();
        if(count($artist))
            return $artist[0];
        return false;
    }

    private function exists_spotify ($name) {
        try {
            $found = $this->api->searchArtists(urlencode($name));
            if(isset($found[0]))
                return $found[0]->id;
            return false;
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            return false;//handle this more responsibily
        }
    }
}
