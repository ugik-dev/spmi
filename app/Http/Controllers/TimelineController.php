<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        $title = 'Time Line';
        $timelines = Timeline::all();
        return view('app.timeline', compact('title', 'timelines'));
    }
}
