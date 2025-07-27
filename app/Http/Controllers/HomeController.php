<?php

namespace App\Http\Controllers;

use App\Notifications\SendContentForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class HomeController extends Controller
{
    public function contact(){
        return view('contact');
    }

    public function thanks(){
        return view('thanks');
    }

    public function sendEmail(Request $request){
  
         $data = $request->validate([
            'name'=>'required|string|max:191',
            'email'=>'required|string|max:100',
            'mobile'=>'required|string|max:20',
            'message'=>'required|string|max:255',
         ]);
        //  dd($data);
        Notification::route('mail','ucc.shankarlalkumhar@gmail.com')->notify(new SendContentForm($data));
        return redirect()->route('thanks');
    }
}
