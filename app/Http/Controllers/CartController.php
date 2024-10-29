<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    
    public function addToCart(Request $request, $id)
    {
        $product = Products::find($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->cover,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request, $id)
    {
        if ($request->id && $request->quantity) {
            $product = Products::find($id);
            $cart = session()->get('cart', []);
            
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
            }

            session()->put('cart', $cart);
            return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart.view')->with('error', 'Invalid request to update cart.');
    }
    
    public function removeItem(Request $request)
    {
        $cart = session()->get('cart');
        
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        
        return response()->json(['message' => 'Item removed successfully!']);
    }

    
    public function viewCart()
    {
        $user = Auth::user();
        $business = BusinessProfile::where('id',1)->first();
        $cart = session()->get('cart', []);
        $promotions = $user->promotions()->wherePivot('status', 'Unused')->get();
        $promos = Promotion::where('status','Active')->get();
        return view('cart.view', compact('cart','business','promotions','promos'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.view')->with('success', 'Product removed successfully');
    }

    
}
