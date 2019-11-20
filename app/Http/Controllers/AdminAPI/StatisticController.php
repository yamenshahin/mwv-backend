<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Job;

class StatisticController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type === 'user') {
            return $this->user();
        } elseif ($request->type === 'job') {
            return $this->job();
        }
    }

    /**
     * Display a listing of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return [
            'userAll' => User::all()->count(),
            'customer' => User::where('role', '=', 'customer')->count(),
            'driver' => User::where('role', '=', 'driver')->count(),
        ];
    }

    /**
     * Display a listing of job.
     *
     * @return \Illuminate\Http\Response
     */
    public function job()
    {
        return [
            'jobAll' => Job::all()->count(),
            'booked' => Job::where('status', '=', 'booked')->count(),
            'unbooked' => Job::where('status', '=', 'unbooked')->count(),
        ];
    }

}
