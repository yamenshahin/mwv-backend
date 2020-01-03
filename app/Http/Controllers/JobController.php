<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Job;
use App\JobMeta;
use App\Meta;
use App\DriverPlace;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Job as JobResource;
use App\Http\Requests\JobStoreRequest;

class JobController extends Controller
{

    /**
     * Insert new Job with job metas (authenticated/logged in user && un-authenticated/non-logged in user)
     *
     * @param JobStoreRequest $request
     * @return JSON
     */
    public function store(JobStoreRequest $request) {
        $job = new Job;
        $job->user()->associate($request->driver['user']['id']);

        if($request->user()) {
            $job->customer_id = $request->user()->id;
        } else {
            $job->customer_id = 0;
        }
        
        $job_meta = [];
        //get totalTime
        foreach ($request->job_meta as $key => $value) {
            if($key === 'totalTime') {
                $total_time = $value;
            }
        }
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
        
        //get current fee
        $default_fee = Meta::select('*')
        ->where('key', '=', 'defaultFee')
        ->first();
        
        array_push($job_meta, new JobMeta(['key' => 'fee', 'value' => $default_fee->value]));

        array_push($job_meta, new JobMeta(['key' => 'placeId', 'value' => $request->driver['placeId']]));

        $job->save();
        $job->meta()->saveMany($job_meta);

        return new JobResource($job);
    }
    /**
     * Insert new Job with job metas (authenticated/logged in user)
     *
     * @param JobStoreRequest $request
     * @return JSON
     */
    public function storeAuthenticated(JobStoreRequest $request)
    {
        return $this->store($request);
    }

    /**
     * Insert new Job with job metas (un-authenticated/non-logged in user)
     *
     * @param JobStoreRequest $request
     * @return JSON
     */
    public function storeUnauthenticated(JobStoreRequest $request)
    {

        return $this->store($request);
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
     * Get Single Meta.
     *
     * @param  int  $id
     * @return string
     */
    public static function getSingleMeta($id, $key)
    {
        $meta_value = JobMeta::select('value')
        ->where([
            ['job_id', '=', $id],
            ['key', '=', $key]
        ])
        ->first();

        return $meta_value->value;
    }

    /**
     * Set Meta.
     *
     * @param  int  $id
     * @param  string  $key
     * @param  string  $value
     * @return float
     */
    public static function setMeta($id, $key, $value)
    {
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();

        if(in_array($key,['collection', 'delivery', 'waypoints'])) {
            $job_meta = new JobMeta(['key' => $key, 'value' => json_encode($value)]); 
        } else {
            $job_meta = new JobMeta(['key' => $key, 'value' => $value]);
        }
        $job->save();
        $job->meta()->save($job_meta);

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

    public static function setMilesDriven($id)
    {
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();

        $place = DriverPlace::select('*')
        ->where('user_id', '=', $job->user_id)
        ->first();

        $job_meta = JobMeta::select('*')
        ->where([
            ['job_id', '=', $id],
            ['key', '=', 'milesDriven']
        ])
        ->first();

        $place->miles_driven = $place->miles_driven + $job_meta->value;

        $place->save();


    }

    public static function setJobsBooked($id)
    {
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();

        $place = DriverPlace::select('*')
        ->where('user_id', '=', $job->user_id)
        ->first();

        $place->jobs_booked = $place->jobs_booked + 1;

        $place->save();
    }

    /**
     * Get Driver Place ID
     *
     * @param int $id
     * @return int
     */
    public static function getPlaceId($id)
    {
        $job = Job::select('*')
        ->where('id', '=', $id )
        ->first();

        $place = DriverPlace::select('*')
        ->where('user_id', '=', $job->user_id)
        ->first();

        return $place->id;
    }

    public function edit($id) 
    {

    }

    public function destroy() 
    {

    }

}
