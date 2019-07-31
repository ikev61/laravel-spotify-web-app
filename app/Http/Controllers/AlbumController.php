<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\Larafy\Larafy;

class AlbumController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct() {
        $this->api = new Larafy('e8c7be3ca98d4ab5bc84c0014190b910','24387bd9f9c045de8cc1d7a433f49e21');
    }

    public function index($artist,$id) {
        $album = $this->get_album($id);
        if(!$album) 
            return redirect()->action('ArtistController@index',['artist'=>$artist]);
        return view('album',['album'=>$album[0],'artist'=>$artist]);
    }

    private function get_album($id) {
        $album = null;
        try {
            $album = $this->api->getAlbums($id);
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            dd($e->getAPIResponse()); // Get the JSON API response.
        }
        return $album;
    }
}
