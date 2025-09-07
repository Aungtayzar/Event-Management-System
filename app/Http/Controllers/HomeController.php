<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(){
        $events = Event::with(['category', 'ticketTypes'])
                      ->where('is_published', true)
                      ->take(3)
                      ->get();
        return view('home', compact('events'));
    }


}
