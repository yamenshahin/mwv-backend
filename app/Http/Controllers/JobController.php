<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
Use App\JobMeta;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Job as JobResource;
use App\Http\Requests\JobStoreRequest;

class JobController extends Controller
{
    /**
     * Insert new Job with job metas
     *
     * @param JobStoreRequest $request
     * @return JSON
     */
    public function store(JobStoreRequest $request)
    {
        $job = new Job;
        $job->user()->associate($request->driver['user']['id']);
        $job->customer_id = $request->user()->id;
        
        $job_meta = [];
        foreach ($request->job_meta as $key => $value) {

            if(in_array($key,['collection', 'delivery', 'waypoints'])) {
                array_push($job_meta, new JobMeta(['key' => $key, 'value' => json_encode($value)])); 
            } else {
                array_push($job_meta, new JobMeta(['key' => $key, 'value' => $value]));
            }
        }
                
        $job->save();
        $job->meta()->saveMany($job_meta);

        return new JobResource($job);
    }

    public function show(Request $request) 
    {
        $customerJobs = Job::select('*')
        ->where('customer_id', '=', $request->user()->id)
        ->get();
        return JobResource::collection($customerJobs);
    }

    public function edit() 
    {

    }

    public function destroy() 
    {

    }

}
