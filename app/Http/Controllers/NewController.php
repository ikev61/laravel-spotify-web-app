<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('music.new',['title'=>'Add artist']);
    }

    public function save(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:20'
        ]);
        Artist::create($data);
        return redirect()->back()->withSuccess($data['name'].' was stored. Click <a href="/'.$data['name'].'">here</a> to see list of songs');
    }
}
