<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App;
use App\JobMeta;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookAdmin;
use App\Mail\BookCustomer;
use App\Mail\BookDriver;
use Carbon\Carbon;

class EmailBookController extends Controller
{
    /**
     * Send Email To Admin from User
     *
     * @param int id
     * @return void
     */
    public static function send($id)
    {
        $job = Job::find($id);
        $driver = User::find($job->user_id);

        $job_metas = JobMeta::select('*')
        ->where('job_id', '=', $id)
        ->get();

        $job_meta_array = [];
        $no_json = ['description', 'customerInfoName', 'customerInfoEmail', 'customerInfoPhone', 'paymentMethod'];
        foreach ($job_metas as $job_meta) {
            if($job_meta['key'] === 'movingDate') {
                $job_meta_array[$job_meta['key']] = date( "Y-m-d H:i:s", strtotime($job_meta['value']));
            } else if(in_array($job_meta['key'], $no_json)) {
                $job_meta_array[$job_meta['key']] = $job_meta['value'];
            } else {
                $job_meta_array[$job_meta['key']] = json_decode($job_meta['value']);
            }
            
        }

        $job_object =[
            'job' => $job,
            'job_meta' => $job_meta_array,
            'driver' => $driver,
        ];
        
        if (App::environment('production')) {
            EmailBookController::sendToAdmin($job_object);
            EmailBookController::sendToCustomer($job_object);
            EmailBookController::sendToDriver($job_object);
        } else {
            EmailBookController::sendToCustomer($job_object);
        }
        

    }

    /**
     * Send Email notification To Admin 
     *
     * @param array $job_object
     * @return void
     */
    public static function sendToAdmin($job_object)
    {
       
        Mail::to(env('SITE_MAIN_EMAIL', 'info@hellovans.com'))
        ->send(new BookAdmin($job_object));
    }

    /**
     * Send Email notification to Customer
     *
     * @param array $job_object
     * @return void
     */
    public static function sendToCustomer($job_object)
    {

        Mail::to($job_object['job_meta']['customerInfoEmail'])
        ->send(new BookCustomer($job_object));
        
    }

    /**
     * Send Email notification to Driver
     *
     * @param array $job_object
     * @return void
     */
    public static function sendToDriver($job_object)
    {

        Mail::to($job_object['driver']->email)
        ->send(new BookDriver($job_object));
    }

    
}
