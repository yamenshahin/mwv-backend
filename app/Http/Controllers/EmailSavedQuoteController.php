<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SavedQuote;

class EmailSavedQuoteController extends Controller
{
    /**
     * Send Email To User from Admin
     *
     * @param Request $request
     * @param Json $data
     * @return void
     */
    public function sendQuote(Request $request)
    {
        Mail::to($request->job_meta['customerInfoEmail'])
        ->send(new SavedQuote($request));
    }
}
