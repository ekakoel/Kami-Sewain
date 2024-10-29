<?php

namespace App\Http\Controllers;

use App\Models\Ratings;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRatingsRequest;
use App\Http\Requests\UpdateRatingsRequest;

class RatingsController extends Controller
{
    // public function rateProduct(Request $request, $id)
    // {
    //     $request->validate([
    //         'rating' => 'required|integer|min:1|max:5',
    //     ]);
    //     $rating = $request->input('rating');
    //     $user_id = auth()->id();
    //     Ratings::updateOrCreate(
    //         ['products_id' => $id, 'user_id' => $user_id],
    //         ['rating' => $rating]
    //     );
    //     return response()->json(['message' => 'Rating successfully saved!']);
    // }
    public function rateProduct(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:0|max:1', // Allow 0 for dislike
        ]);
    
        $rating = $request->input('rating');
        $user_id = auth()->id();

        if ($rating > 0) {
            
            // Save or update the rating (like)
            Ratings::updateOrCreate(
                ['products_id' => $id, 'user_id' => $user_id],
                ['rating' => $rating]
            );
            return response()->json(['message' => 'Product liked successfully!']);
        
        } else {
            // Remove the rating (unlike)
            Ratings::where('products_id', $id)->where('user_id', $user_id)->delete();
            return response()->json(['message' => 'Product unliked successfully!']);
        }
    }   
}

