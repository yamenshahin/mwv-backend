<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmailBookController;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class CheckoutController extends Controller
{
    /**
     * Checkout (with Credit) validation the turn job status to booked
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkoutCredit(Request $request) {
        $this->validate($request,[
            'stripeToken' => 'required',
            'id' => 'required',
            'amount' => 'required',
        ]);
                
        try {
            $charge = Stripe::charges()->create([
                'currency' => 'USD',
                'amount'   => $request->amount,
                'source' => $request->stripeToken,
                'receipt_email' => 'yamenhshain@gmail.com',
                'metadata' => [
                    'job_id' => $request->id,
                ], 

            ]);
            // save this info to your database
            JobController::setStatus($request->id, 'booked');
            JobController::setMeta($request->id, 'paymentMethod', 'credit'); 

            // If new user
            if($request->customerEmail)  {
                JobController::setCustomer($request->id, $request->customerEmail);
            }

            //send book emails
            EmailBookController::send($request->id);

            // SUCCESSFUL
            return 'success';
        } catch (CardErrorException $e) {
            // save info to database for failed
            return response()->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
                ], 422);
        }

    }

    /**
     * Checkout (with Cash) validation the turn job status to booked
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkoutCash(Request $request) {
        $this->validate($request,[
            'id' => 'required',
        ]);

        // save this info to your database
        JobController::setStatus($request->id, 'booked'); 
        JobController::setMeta($request->id, 'paymentMethod', 'cash');

        //Place statistic changes
        JobController::setMilesDriven($request->id);
        JobController::setJobsBooked($request->id);

        

        // If new user
        if($request->customerEmail)  {
            JobController::setCustomer($request->id, $request->customerEmail);
        }
        //send book emails
        EmailBookController::send($request->id);
        // SUCCESSFUL
        return 'success';

    }
}
