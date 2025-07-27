<?php
namespace App\Http\Controllers;

use App\Mail\MailNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailNotificationController extends Controller
{
    public function sendmail(Request $request)
    {
        $to = "ucc.shankarlalkumhar@gmail.com";
        
        $details = [
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city
        ];

        $subject = "New Form Submission";

        Mail::to($to)->send(new MailNotificationMail($details, $subject));

        return back()->with('success', 'Email sent successfully!');
    }
}
