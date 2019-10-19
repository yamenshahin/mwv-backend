<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailController extends Controller
{
    /**
     * Send an email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request  $request) 
    {   
        $header = $this->selectTemplate('header');
        $footer = $this->selectTemplate('footer');

        if(auth()->guard('api')->check()) {
            $template = $this->selectTemplate($request->templateId, true);
            $template = str_replace('%USERNAME%', $request->user('api')->name, $template);

            $address = $request->user('api')->email;

            return response()->json([
                'header' => $header,
                'footer' => $footer,
                'template' => $template
                ], 200);
            
        } else {
            $template = $this->selectTemplate($request->templateId);
            $address = $request->address;
            
            return response()->json([
                'header' => $header,
                'footer' => $footer,
                'template' => $template
                ], 200);
        }
    }

    /**
     * Select email's template
     *
     * @param [type] $templateId
     * @param boolean $logged
     * @return string
     */
    public function selectTemplate($templateId, $logged = false)
    {
        if ($logged) {
            $templateId = $templateId . '_logged';
        }

        $template = Email::select('text')
        ->where('template_id', '=', $templateId)
        ->first();

        return $template->text;
    }
}
