<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function show_register()
    {
        return view('auth.register');
    }

    public function show_login()
    {
        return view('auth.login');
    }


    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);
        $url = URL::temporarySignedRoute(
            'verification.verify', // Nama route
            now()->addMinutes(60), // Link berfungsi selama 60 menit
            ['id' => $user->id, 'hash' => sha1($user->email)] // Parameter
        );
        Mail::to($user->email)->send(new VerificationEmail($url));
        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke halaman dashboard setelah berhasil registrasi
        return redirect()->route('home.index')->with('success', 'Registrasi berhasil! Selamat datang!');
    }

   
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Mendapatkan kredensial dari input
        $credentials = $request->only('email', 'password');

        // Cek apakah kredensial valid dan login
        if (Auth::attempt($credentials)) {
            // Redirect ke halaman dashboard jika berhasil login
            return redirect()->route('home.index')->with('success', 'Login berhasil!');
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }


    // public function login(LoginRequest $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if(!Auth::validate($credentials)):
    //         return redirect()->to('login')
    //             ->withErrors(trans('auth.failed'));
    //     endif;

    //     $user = Auth::getProvider()->retrieveByCredentials($credentials);

    //     Auth::login($user);

    //     return $this->authenticated($request, $user);
    // }

    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('/login');
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user) 
    {
        return redirect()->intended();
    }
}
