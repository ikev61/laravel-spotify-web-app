<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\Larafy\Larafy;
use App\Album;
use App\AlbumDetail;

class AlbumController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct() {
        //$this->middleware('auth');
        $this->api = new Larafy('e8c7be3ca98d4ab5bc84c0014190b910','24387bd9f9c045de8cc1d7a433f49e21');
    }

    public function index($artist,$id) {

        $album = $this->get_album($id);
        if(!count($album)) 
            return redirect()->back()->with('error', $id.' not a valid album_id');

        $data = json_decode($album->detail);
        return view('music.album',['album'=>$data,'artist'=>$artist,'title'=>$data->name]);
    }

    public function get_album($id) {
        $album = $this->from_db($id);
        if(count($album))
            return $album[0];

        $this->download_to_local($id);

        $album = $this->from_db($id);
        if(count($album))
            return $album[0];
        return null;
    }


    private function from_db($id) {
        return AlbumDetail::where('spotify_album_id', '=', $id)->get();
    }

    private function download_to_local($id) {
        $album = $this->from_spotify ($id);

        if(count($album)>0) {
            $data = array(
                'spotify_album_id'  => $id,
                'detail'            => json_encode($album[0])
            );
            AlbumDetail::create($data);
            return true;
        }
        return null;
    }

    private function from_spotify ($id) {
        try {
            return $this->api->getAlbums($id);
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            return null;
        }
        return null;
    }    

}
