<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;
use App\DriverPlace;
use App\Http\Resources\AdminAPI\FeedbackJobDetailed as FeedbackJobDetailedResource;

class FeedbackJobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();

        return FeedbackJobDetailedResource::collection($feedbacks);
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
            ['owner_id', '=', $request->id],
            ['type', '=', 'job'],
        ])
        ->first();
        if($feedback) {

            $feedback->comment = $request->feedback['comment'];
            $feedback->stars = $request->feedback['stars'];
            $feedback->status = $request->feedback['status'];
            $feedback->save();
            return 'Done';
        } 

        $feedback =  new Feedback;
        $feedback->owner_id =  $request->id;
        $feedback->giver_id = $request->customer['id'];
        $feedback->comment = $request->feedback['comment'];
        $feedback->stars = $request->feedback['stars'];
        $feedback->status = $request->feedback['status'];
        $feedback->type = 'job';
        $feedback->save();

        $driver_place = DriverPlace::select('*')
        ->where('user_id', '=',  $request->driver['id'])
        ->first();

        $driver_place->stars = $driver_place->stars + $request->feedback['stars'];
        $driver_place->votes = $driver_place->votes + 1;

        $driver_place->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
