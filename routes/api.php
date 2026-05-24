<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactMail;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json(['ok' => true]);
});


Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'message' => 'required|string'
    ]);

    $mailer = (string) config('mail.default');
    $transport = (string) config("mail.mailers.{$mailer}.transport");

    // Use stderr-friendly logging for Vercel (and avoid secrets).
    Log::info('contact: attempting to send mail', [
        'mailer' => $mailer,
        'transport' => $transport,
        'has_from' => (bool) config('mail.from.address'),
    ]);

    try {
        // Send the email to your own inbox
        Mail::to('reyesmaryhannahcaryl@gmail.com')->send(new ContactMail($validated));

        Log::info('contact: mail sent');
    } catch (\Throwable $e) {
        // Don't rely on file logging (often read-only on serverless).
        error_log('contact: mail failed: '.$e::class.' - '.$e->getMessage());
        Log::error('contact: mail failed', [
            'exception' => $e::class,
            'message' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to send message.',
            'error' => config('app.debug') ? ($e::class.': '.$e->getMessage()) : null,
        ], 500);
    }

    return response()->json(['success' => true, 'message' => 'Message sent!']);
});