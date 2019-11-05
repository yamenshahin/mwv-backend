<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Job;
Use App\JobMeta;
use App\Meta;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Job as JobResource;

class WalletController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        
        $jobs = Job::select('*')
        ->where([
            ['user_id', '=', $user->id],
            ['status', '=', 'booked']
        ])
        ->whereHas('job_metas', function (Builder $query) {
            $query->where([
                ['key', '=', 'paid'],
                ['value', '=', 'no']
            ]);
        })
        ->whereHas('job_metas', function (Builder $query) {
            $query->where([
                ['key', '=', 'paymentMethod'],
                ['value', '=', 'credit']
            ]);
        })
        ->get();

        $wallet = 0;
        $total = 0;
        $fee = 0;
        $formatedJobs = JobResource::collection($jobs);
        foreach ($formatedJobs as $job) {
            foreach ($job->job_metas as $job_meta) {
                if ($job_meta->key === 'total') {
                    $total = $job_meta->value;
                } else if($job_meta->key === 'fee') {
                    $fee = $job_meta->value;
                }
            }
            $wallet = $wallet + $total / (1+$fee/100);
        } 
        return round($wallet);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
