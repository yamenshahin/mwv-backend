<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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

        if($request->user()) {
            $job->customer_id = $request->user()->id;
        } else {
            $job->customer_id = 0;
        }
        
        $job_meta = [];
        foreach ($request->job_meta as $key => $value) {

            if(in_array($key,['collection', 'delivery', 'waypoints'])) {
                array_push($job_meta, new JobMeta(['key' => $key, 'value' => json_encode($value)])); 
            } else {
                array_push($job_meta, new JobMeta(['key' => $key, 'value' => $value]));
            }
        }

        foreach ($request->driver['price'] as $key => $value) {
            array_push($job_meta, new JobMeta(['key' => $key, 'value' => $value]));
        }
                
        $job->save();
        $job->meta()->saveMany($job_meta);

        return new JobResource($job);
    }

    public function show(Request $request) 
    {
        $customerJobs = Job::select('*')
        ->where('customer_id', '=', $request->user()->id)
        ->orderBy('id', 'desc')
        ->get();
        return JobResource::collection($customerJobs);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCurrent($id)
    {
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();
        return new JobResource($job);
    }

    /**
     * Get total price.
     *
     * @param  int  $id
     * @return float
     */
    public function getTotal($id)
    {
        $job = getCurrent($id);
        foreach ($job->job_metas as $job_meta) {
            if ($job_meta.key ==='total') {
                return $job_meta.value; 
            }
        }
        return 0.00;
    }

    /**
     * Get Description.
     *
     * @param  int  $id
     * @return float
     */
    public function getDescription($id)
    {
        $job = getCurrent($id);
        foreach ($job->job_metas as $job_meta) {
            if ($job_meta.key ==='description') {
                return $job_meta.value; 
            }
        }
        return '';
    }

    /**
     * Get Meta.
     *
     * @param  int  $id
     * @return float
     */
    public function getMeta($id)
    {
        $job = getCurrent($id);
        if($job->job_metas) {
            return $job->job_metas;
        }
        return '';
    }

    /**
     * Set Job Status.
     *
     * @param int $id
     * @param string $status
     * @return void
     */
    public static function setStatus($id, $status) 
    {
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();
        $job->status = $status;
        $job->save();

    }

    /**
     * Set Job Customer ID.
     *
     * @param int $id
     * @param string $custoemrEmail
     * @return void
     */
    public static function setCustomer($id, $customerEmail) 
    {
        $customer = User::select('*')
        ->where('email', '=', $customerEmail )
        ->first();
        
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();
        $job->customer_id = $customer->id;
        $job->save();

    }

    public function edit() 
    {

    }

    public function destroy() 
    {

    }

}
