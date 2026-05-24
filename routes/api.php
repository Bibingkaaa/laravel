<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'message' => 'required|string'
    ]);

    try {
        // Send the email to your own inbox
        Mail::to('reyesmaryhannahcaryl@gmail.com')->send(new ContactMail($validated));
    } catch (\Throwable $e) {
        report($e);

        return response()->json([
            'success' => false,
            'message' => 'Failed to send message.',
        ], 500);
    }

    return response()->json(['success' => true, 'message' => 'Message sent!']);
});