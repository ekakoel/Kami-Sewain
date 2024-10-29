<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(20);

        if (Auth::guard('admin')->check()) {
            return view('admin.users.index')->with(compact('users'));
        } else {
            return redirect()->back();
        }
    }

    public function show()
    {
        $user = Auth::user();
        $promotions = $user->promotions()->wherePivot('status', 'Unused')->get();
        
        return view('profile')->with(compact('user','promotions'));
    }

    public function edit(string $id)
    {
        
        if (Auth::guard('admin')->check()) {
            $user = Admin::find($id);
            return view('admin.user-edit')->with(compact('user'));
        } else {
            $user = User::find($id);
            return view('profile.edit',[
                'user'=>$user,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'telephone' => $request->telephone,
        ]);
        return redirect()->route('user.show')->with('success', 'Profile updated successfully');
    }
    
    public function updatePassword(Request $request)
    {
        // Validasi
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $user = Auth::user();
        
        // Cek password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            Log::info('Password saat ini salah untuk user: '.$user->id);
            throw ValidationException::withMessages(['current_password' => 'Current password is incorrect.']);
        }
    
        // Hash dan simpan password baru
        $user->password = Hash::make($request->password);
        $user->save();
        
        Log::info('Password berhasil diperbarui untuk user: '.$user->id);
    
        return back()->with('success', 'Password updated successfully.');
    }


    // use Illuminate\Support\Facades\Hash;

    // $password = '123456789';
    // $hashedPassword = '$2y$10$657r/hxNbYxw8YEZKOuVru6y1CcRt54z1n15VTo5KkkUJMWyZOsTu';

    // if (Hash::check($password, $hashedPassword)) {
    //     echo "Password cocok!";
    // } else {
    //     echo "Password tidak cocok.";
    // }


    // $user = App\Models\User::find(1);
    // $passwordInput = '1234567890';
    // $storedHash = $user->password;
    
    // if (Hash::check($passwordInput, $storedHash)) {
    //     echo "Password cocok!";
    // } else {
    //     echo "Password tidak cocok.";
    // }

}
