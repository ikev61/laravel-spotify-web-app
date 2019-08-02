<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;

class ArtistsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $artists = Artist::orderBy('created_at','desc')->paginate(15);
        if(!count($artists))
            return view('music.new',['title'=>'New Artist']);
        return view('music.index',['artists'=>$artists,'title'=>'Sporify']);
    }
    
}
