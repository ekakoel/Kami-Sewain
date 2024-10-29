<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Http\Requests\StoreLikesRequest;
use App\Http\Requests\UpdateLikesRequest;

class LikesController extends Controller
{
   public function toggleLike($id)
    {
        try {
            $product = Products::findOrFail($id);
            $user = auth()->user();

            // Check if the user already liked the product
            if ($user->likes()->where('products_id', $product->id)->exists()) {
                // If liked, remove the like
                $user->likes()->detach($product->id);
                $liked = false;
            } else {
                // If not liked, add the like
                $user->likes()->attach($product->id);
                $liked = true;
            }

            // Get the new like count
            $likeCount = $product->likedByUsers()->count();

            // Return response as JSON
            return response()->json([
                'success' => true,
                'like_count' => $likeCount,
                'liked' => $liked,
            ]);
        } catch (\Exception $e) {
            // Log the error and return error response
            \Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
