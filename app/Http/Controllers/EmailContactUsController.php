<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class EmailContactUsController extends Controller
{
    /**
     * Send Email To Admin from User
     *
     * @param Request $request
     * @param Json $data
     * @return void
     */
    public function send(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'subject' => 'required'
        ]);

        Mail::to(env('SITE_MAIN_EMAIL', 'info@hellovans.com'))
        ->send(new ContactUs($request));
    }
}
