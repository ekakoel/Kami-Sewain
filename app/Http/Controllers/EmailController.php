<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;

class EmailController extends Controller
{
    public function index()
    {
        $contacts = Email::all();
        return view('admin.contacts.index', compact(
            'contacts',
        ));
    }
    public function sendMessage(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        // Simpan email ke database
        $email = Email::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => "Contact Message",
            'message' => $request->message,
            'user_id' => Auth::user()->id,
            'status' => 'Unread',
        ]);
        $data = [
            'name' => $email->name,
            'email' => $email->email,
            'pesan' => $email->message,
        ];
        Mail::send('emails.contact', $data, function ($mail) use ($request) {
            $mail->to('e-admin@balikamitour.com')
                ->subject('New Contact Message');
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
