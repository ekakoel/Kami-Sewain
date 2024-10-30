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
    public function update_status_user(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => $request->status,
        ]);
        return back()->with('success', 'User status changed successfully');
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
        
        Log::info('Password successfully updated for the user: '.$user->id);
    
        return back()->with('success', 'Password updated successfully.');
    }

    public function updateImage(Request $request)
    {
       
        // dd($request->profile_img);
        $user = Auth::user();
        $directory = public_path('images/profile/');
        if ($request->hasFile('profile_img')) {
            if ($user->profile_img) {
                $oldCoverPath = $directory . $user->profile_img;
                if (file_exists($oldCoverPath)) {
                    unlink($oldCoverPath); // Menghapus file lama
                }
            }
            $user_profile_img = time() . '_profile_img_user_'.$user->name.".". $request->profile_img->getClientOriginalExtension();
            $request->profile_img->move('images/profile', $user_profile_img);
            $user->profile_img = $user_profile_img;
        }

        
        $user->update([
            'profile_img' => $user_profile_img,
        ]);
        

        return redirect()->back()->with('success', 'Profile image updated successfully!');
    }

}
