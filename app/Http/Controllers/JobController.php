<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
Use App\JobMeta;

class JobController extends Controller
{
    public function store(Request $request)
    {
        $job = new Job;
        $job->user()->associate($request->user());

        $job_meta = new JobMeta;
        $job_meta->key = $request->key;
        $job_meta->value = $request->value;

        $job->save();
        $job->meta()->save($job_meta);

    }
}
