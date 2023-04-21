<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;

class WelcomeController extends Controller
{
    public function index()
    {
    	// update table events
        DB::table('events')
              ->where('start_date', '<', date('Y-m-d'))
              ->where('status', '!=', 'Rejected')
              ->where('status', '!=', 'Cancelled')
              ->update(['status' => 'Done']);

        DB::table('events')
              ->where('start_date', '=', date('Y-m-d'))
              ->where('status', '=', 'Waiting To Do')
              ->update(['status' => 'Doing']);
        // end update table

        $events = Event::all();

        $data = array('events'=>$events);

        return view('welcome', $data);
    }
}
