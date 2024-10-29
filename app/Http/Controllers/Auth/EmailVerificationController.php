<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->email))) {
            return redirect()->route('home.index')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home.index')->with('success', 'Email already verified.');
        }

        // Verifikasi email pengguna
        $user->markEmailAsVerified();
        $user->status = 'Active';
        $user->save();

        // Trigger the Verified event
        event(new Verified($user));

        return redirect()->route('home.index')->with('success', 'Email verified successfully!');
    }

    // Metode untuk mengirim ulang email verifikasi
    public function sendVerificationEmail(Request $request)
    {
        // Mengambil pengguna yang sedang diautentikasi
        $user = $request->user();

        $cacheKey = 'resend_verification_email_' . $user->id;
        $lastSent = Cache::get($cacheKey);
        if ($lastSent && now()->diffInMinutes($lastSent) < 1) {
            return back()->with('error', 'You can only resend the verification email once every minute.');
        }
        
        // Membuat tautan verifikasi
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Mengirim email verifikasi
        Mail::to($user->email)->send(new VerificationEmail($url));
        Cache::put($cacheKey, now());
        // Mengembalikan respon atau redirect dengan pesan sukses
        return back()->with('success', 'Verification link sent! Please check your email.');
    }
}
