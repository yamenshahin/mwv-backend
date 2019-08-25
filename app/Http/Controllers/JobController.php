<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
Use App\JobMeta;
use App\Http\Resources\Job as JobResource;
use App\Http\Requests\JobCreateRequest;

class JobController extends Controller
{
    /**
     * Insert new Job with job metas
     *
     * @param Request $request
     * @return void
     */
    public function store(JobCreateRequest $request)
    {
        $job = new Job;
        $job->user()->associate($request->user());

        $job_metas = [];
        foreach($request->job_metas as $job_meta_entry) {
            array_push($job_metas, new JobMeta(['key' => $job_meta_entry['key'], 'value' => $job_meta_entry['value']]));
        }

        $job->save();
        $job->meta()->saveMany($job_metas);

        return new JobResource($job);
    }
}
