<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\Larafy\Larafy;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct() {
        $this->api = new Larafy('e8c7be3ca98d4ab5bc84c0014190b910','24387bd9f9c045de8cc1d7a433f49e21');
    }

    public function index($artist) {
        $founds = $this->get_search($artist);
        if(!isset($founds->items[0])) 
            return redirect()->back()->with('error', $artist.' not a valid keyword');
        $first_match = $founds->items[0];
        $album = $this->get_album($first_match->id);
        return view('artist',['artist'=>$first_match,'albums'=>$album->items]);
    }

    private function get_search($artist) {
        $founds = null;
        try {
            $founds = $this->api->searchArtists(urlencode($artist));
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            dd($e->getAPIResponse()); // Get the JSON API response.
        }
        return $founds;
    }

    private function get_album($id) {
        $founds = null;
        try {
            $founds = $this->api->getArtistAlbums($id, 20, 0, ['single']);
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            dd($e->getAPIResponse()); // Get the JSON API response.
        }
        return $founds;
    }

}
