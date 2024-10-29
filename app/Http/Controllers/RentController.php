<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rent;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RentMakingRequest;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business = BusinessProfile::where('id',1)->first();
        // if (Auth::guard('admin')->check()) {
        $now = Carbon::now();
        $user_id = Auth::user()->id;
        $orders = Orders::with('products')->where('user_id',$user_id)->where('status','!=','archived')->where('rental_end_date','>=',$now)->get();
        return view('rents', compact('orders','business'));
        // } else {
        //     $rents = DB::table('rents')
        //         ->join('cars', 'rents.car_id', '=', 'cars.id')
        //         ->where('rents.user_id', Auth::user()->id)
        //         ->select('rents.*', 'cars.*')
        //         ->get();
        //     return view('rents')->with(compact('rents','business'));
        // }
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
    public function store(RentMakingRequest $request, $id)
    {
        $car = Car::find($id);

        $validatedData = $request->validated();
        $rent = new Rent();
        $rent->start_date = $validatedData['start_date'];
        $rent->end_date = $validatedData['end_date'];
        $rent->payement_method = $validatedData['payement_method'];
        $rent->payement_method = $validatedData['payement_method'];
        $nbDay = Carbon::parse($rent->end_date)
            ->diffInDays(Carbon::parse($rent->start_date));
        $rent->total_cost = $nbDay * $car->daily_rate;
        $rent->payement_status = "en attente";
        $rent->car_id = $id;
        $rent->user_id = Auth::user()->id;
        if ($rent->save()) {
            $car->available = false;
            $car->save();
        }

        return redirect()->back()->with('success', "Vous venez de louez la voiture pour à " . $rent->total_cost . " FCFA pour " . $nbDay . " jours");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rent = Rent::findOrFail($id);

        if (Auth::guard('admin')->check()) {
            return view('admin.rent-details', ['rent' => $rent]);
        } else {
            return view('rents');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rent = Rent::findOrFail($id);

        if (Auth::guard('admin')->check()) {
            return view('admin.rent-edit', ['rent' => $rent]);
        } else {
            return view('rents');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        if (Auth::guard('admin')->check()) {
            $rent = Rent::findOrFail($id);
            $rent->delete();
            return redirect()->route('admin.orders.index')->with('success', 'La location a été supprimée avec succès.');
        } else {
            return redirect()->route('orders.index');
        }
    }
}
