<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\DriverPlace;

class DriverPlaceFeedbackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedback = Feedback::select('*')
        ->where([
            ['owner_id', '=', $request->job['id']],
            ['type', '=', 'place'],
        ])
        ->first();
        if($feedback) {
            return 'Done';
        } 

        $feedback =  new Feedback;
        $feedback->owner_id =  intval($request->job['id']);
        $feedback->giver_id = auth()->user()->id;
        $feedback->comment = $request->comment;
        $feedback->stars = intval($request->stars);
        $feedback->type = 'place';

        $feedback->save();

        $driver_place = DriverPlace::select('*')
        ->where('user_id', '=',  intval($request->job['driver']['id']))
        ->first();

        $driver_place->stars = $driver_place->stars + $request->stars;
        $driver_place->votes = $driver_place->votes + 1;

        $driver_place->save();

        return $feedback;
        
    }
}
