<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;

class SubscriberController extends Controller
{
    public function checkEmail(Request $request)
    {
        $emailExists = Subscriber::where('email', $request->email)->exists();

        return response()->json(['exists' => $emailExists]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email', // Ganti dengan nama tabel yang sesuai
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email has already been taken.',
        ]);
        $sbs = Subscriber::all();
        $csbs = count($sbs) + 1;
        $subscriber = new Subscriber();
        $subscriber->name = "Subscriber_".$csbs;
        $subscriber->email = $request->email;
        $subscriber->status = "Active";
        $subscriber->save();
        return redirect()->back()->with('success', 'By subscribing, you will receive the latest updates from Kami Sewain via email, including exclusive promotions and exciting offers for your event needs.');

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }
}
