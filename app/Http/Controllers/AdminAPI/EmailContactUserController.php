<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUser;

class EmailContactUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    /**
     * Send Email To User from Admin
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
            'subject' => 'required',
            'senderEmail' => 'required|email',
        ]);

        Mail::to($request->email)
        ->send(new ContactUser($request));
    }
}
