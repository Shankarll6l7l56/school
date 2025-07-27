<?php

use App\Http\Controllers\Admin\PricingRuleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailNotificationController;
use App\Http\Controllers\oneTomany\BookController;
use App\Http\Controllers\oneTomany\StudnetController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserAuthenticated;


Route::get('/', function () {
    return view('backend.dashboard');
});

Route::resource('pricing-rules', PricingRuleController::class);

Route::get('/razorpay', [RazorpayController::class, 'index'])->name('razorpay');
Route::post('/razorpay', [RazorpayController::class, 'payment'])->name('razorpay-payment');
Route::get('/razorpay/callback', [RazorpayController::class, 'callback'])->name('razorpay-payment');




Route::get('/contact', [ContactController::class, 'index'])->name('contact');












// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/contact',[HomeController::class,'contact'])->name('contact');

// Route::get('/thanks',[HomeController::class,'thanks'])->name('thanks');

// Route::post('/send-email',[HomeController::class,'sendEmail'])->name('send.email');

////////////////////////////////////////////////////////////////////////////////

// Route::get('/form', function () {
//     return view('mail.form');
// });
// Route::post('/mail-send',[MailNotificationController::class,'sendmail'])->name('mail.send');