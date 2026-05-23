<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'message' => 'required|string'
    ]);

    // Send the email to your own inbox
    Mail::to('reyesmaryhannahcaryl@gmail.com')->send(new ContactMail($request->all()));

    return response()->json(['success' => true, 'message' => 'Message sent!']);
});