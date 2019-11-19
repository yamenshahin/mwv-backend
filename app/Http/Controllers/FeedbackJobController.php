<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\Job;
use App\DriverPlace;

class FeedbackJobController extends Controller
{
    
    /**
     * Show resources
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $jobs = Job::select('id')
        ->where([
            ['user_id', '=', $request->userId],
            ['status', '=', 'booked']
        ])
        ->get();
        
        $allFeedbacks = [];
        foreach($jobs as $job) {
            $feedback = Feedback::select('*')
            ->where([
                ['owner_id', '=', $job->id],
                ['status', '=', 'active']
            ])
            ->first();
            if($feedback) {
                array_push($allFeedbacks, $feedback);
            }
        }
        return $allFeedbacks;
        
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
            ['type', '=', 'job'],
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
        $feedback->type = 'job';
        $feedback->status = 'active';

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
