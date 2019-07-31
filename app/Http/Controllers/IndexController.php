<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //get lists of artists
        $data = ['Drake','Kendrick Lamar','Rihanna','2Pac','Post Malone','Usher','Chris Brown','Wiz Khalifa'];
        return view('index',['artists'=>$data]);
    }
    
}
