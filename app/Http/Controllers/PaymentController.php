<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestPayment;

class PaymentController extends Controller
{
    public function requestPayment(Request $request)
    {
        $today = strtotime(date('Y-m-d'));
        $requestDate = strtotime($request->payment);

        $timeDifference = $today - $requestDate;

        $days = $timeDifference / 86400;

        if($days > 6 || $request->payment === 0) {
            $emailRequest = $request->user();
            $emailRequest->subject = 'Request Payment';
            
            Mail::to(env('SITE_MAIN_EMAIL', 'info@hellovans.com'))
            ->send(new RequestPayment($emailRequest)); 
            return date('Y-m-d');
        } else {
            return $request->payment;
        }
    }
}
