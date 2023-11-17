<?php

namespace App\Http\Controllers;

use App\Mail\GS7Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

class MailController extends Controller
{
    public function sendMail($email,$title)
    {
        $content = [
            'title' => 'Web GS7',
            'body' => $title
        ];

        FacadesMail::to($email)->send(new GS7Mail($content));
        return true;
    }
}