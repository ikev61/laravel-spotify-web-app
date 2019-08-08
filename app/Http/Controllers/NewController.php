<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\Larafy\Larafy;
use App\Artist;

class NewController extends Controller
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

    public function index() {
        return view('music.new',['title'=>'Add artist']);
    }

    public function save(Request $request) {

        $data = $request->validate([
            'name' => 'required|max:20'
        ]);

        if($this->exists_on_local($data['name'])) 
            return redirect()->back()->withError("<strong>{$data['name']}</strong> already exist on db, find it <a href='/{$data['name']}'>here</a>");

        $artist = $this->artist_on_spotify($data['name']);
        if(!$artist) 
            return redirect()->back()->withError("<strong>{$data['name']}</strong> has no account on spotify. Try a different name");

        $data['artist_spotify_id'] = $artist->id;
        $data['images'] = json_encode($artist->images);

        Artist::create($data);
        return redirect()->back()->withSuccess("<strong>{$data['name']}</strong> was added. Click <strong><a href='/{$data['name']}'>here</a></strong> to see list of songs");
    }

    private function exists_on_local ($name) {
        $artist = Artist::where('name', '=', $name)->get();
        if(count($artist))
            return $artist;
        return false;
    }

    private function artist_on_spotify ($name) {
        try {
            $found = $this->api->searchArtists(urlencode($name));
            if(isset($found->items[0]))
                return $found->items[0];
            return false;
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            return false;//handle this more responsibily
        }
    }

}
