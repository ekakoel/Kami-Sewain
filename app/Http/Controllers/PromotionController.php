<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;

class PromotionController extends Controller
{

    public function index()
    {
        $now = Carbon::now();
        $promotions = Promotion::all();
        $activePromotions = Promotion::where('expired_date','>=',$now)->get();
        $expiredPromotions = Promotion::where('expired_date','<',$now)->withCount(['users as claimed_count' => function ($query) {
            $query->where('promotion_holders.status', 'Used');
        }])->get();
        return view('admin.promotions.index', compact('activePromotions','expiredPromotions'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'promotion_code' => 'nullable|string',
            'discount_percent' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'minimum_transaction' => 'required|numeric',
            'amount' => 'required|numeric',
            'expired_date' => 'required|date',
            'description' => 'required|string',
        ]);
        
        Promotion::create([
            'name' => $request->name,
            'promotion_code' => $request->promotion_code,
            'discount_percent' => $request->discount_percent,
            'discount_amount' => $request->discount_amount,
            'minimum_transaction' => $request->minimum_transaction,
            'amount' => $request->amount,
            'expired_date' => $request->expired_date,
            'description' => $request->description,
            'status' => "Draft",
        ]);
        return redirect()->route('admin.promotions')->with('success', 'New Promotion has been added!');
        
    }


    public function show(Promotion $promotion)
    {
        //
    }


    public function edit(Promotion $promotion)
    {
        //
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'promotion_code' => 'nullable|string',
            'discount_percent' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'amount' => 'required|numeric',
            'expired_date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|in:Active,Draft,Expired',
        ]);

        // Mendapatkan data promosi dan memperbarui
        $promotion = Promotion::findOrFail($id);
        if ($request->edit_type == 'percent') {
            $discount_percent = $request->discount_percent;
            $discount_amount = NULL;
        }elseif($request->edit_type == 'amount'){
            $discount_percent = NULL;
            $discount_amount = $request->discount_amount;
        }
        // dd($request->edit_type);
        $promotion->update([
            'name' => $request->name,
            'promotion_code' => $request->promotion_code,
            'discount_percent' => $discount_percent,
            'discount_amount' => $discount_amount,
            'amount' => $request->amount,
            'expired_date' => $request->expired_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Promotion updated successfully.');
    }


    public function destroy($id)
    {
        // Cari promotion berdasarkan ID
        $promo = Promotion::find($id);

        // Jika promotion tidak ditemukan, redirect dengan pesan error
        if (!$promo) {
            return redirect()->route('promotions.index')->with('error', 'Promotion not found.');
        }

        // Hapus promotion
        $promo->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.promotions')->with('success', 'Promotion deleted successfully.');
    }

    public function claimPromo(Request $request, $promotionId)
    {
        // Pastikan pengguna sudah login
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in to claim this promotion.');
        }

        // Temukan promosi berdasarkan ID
        $promotion = Promotion::findOrFail($promotionId);

        // Periksa apakah promosi sudah mencapai batas klaim
        $claimedCount = $promotion->users()->count();  // Hitung berapa kali sudah diklaim
        if ($claimedCount >= $promotion->amount) {
            return redirect()->route('user.show')->with('error', 'This promotion has reached its claim limit.');
        }

        // Periksa apakah pengguna sudah mengklaim promosi ini
        if ($user->promotions()->where('promotion_id', $promotionId)->exists()) {
            return redirect()->route('user.show')->with('error', 'You have already claimed this promotion.');
        }

        // Periksa apakah promosi telah kedaluwarsa
        $today = now()->toDateString();
        if ($promotion->expired_date < $today) {
            return redirect()->route('user.show')->with('error', 'This promotion has expired and cannot be claimed.');
        }

        // Klaim promosi dengan menyimpannya ke tabel pivot bersama expired_date dan status
        $user->promotions()->attach($promotionId, [
            'expired_date' => $promotion->expired_date,
            'status' => 'Unused'
        ]);

        return redirect()->route('user.show')->with('success', 'Promotion successfully claimed!');
    }



    public function usePromotion($promotionId)
    {
        $user = Auth::user();

        // Temukan promosi yang dimiliki pengguna dengan status "Unused"
        $promotion = $user->promotions()->wherePivot('promotion_id', $promotionId)->wherePivot('status', 'Unused')->first();

        if (!$promotion) {
            return back()->with('error', 'Promotion cannot be used or has already been used.');
        }

        session(['promotion' => [
            'id' => $promotion->id,
        ]]);

        // Update status promosi menjadi "Used"
        // $user->promotions()->updateExistingPivot($promotionId, ['status' => 'Used']);

        return redirect()->route('products.index')->with('success', 'Promotion applied! It will be used during checkout.');
    }

    public function cartUsePromotion($promotionId)
    {
        $user = Auth::user();

        // Temukan promosi yang dimiliki pengguna dengan status "Unused"
        $promotion = $user->promotions()->wherePivot('promotion_id', $promotionId)->wherePivot('status', 'Unused')->first();

        if (!$promotion) {
            return back()->with('error', 'Promotion cannot be used or has already been used.');
        }

        session(['promotion' => [
            'id' => $promotion->id,
        ]]);

        // Update status promosi menjadi "Used"
        // $user->promotions()->updateExistingPivot($promotionId, ['status' => 'Used']);
        return back()->with('success', 'Promotion applied!');
    }
    public function removePromotion(Request $request)
    {
        $request->session()->forget('promotion'); // Hapus session promotion
        return redirect()->back()->with('success', 'Promotion removed');
    }
}
