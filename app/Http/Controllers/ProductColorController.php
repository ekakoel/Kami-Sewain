<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;;
use App\Models\ProductColor;
use App\Http\Requests\StoreProductColorRequest;
use App\Http\Requests\UpdateProductColorRequest;

class ProductColorController extends Controller
{
    public function index()
    {
        $colors = ProductColor::all();
        return view('admin.products.color.index', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:255',
        ]);
        
        $color = new ProductColor();
        $color->name = $request->input('name');
        $color->color_code = $request->input('color_code');
        $color->save();
        return redirect()->route('admin.colors.index')->with('success', 'New Color has been added!');
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:255',
        ]);
        // dd($request->input('color_code'));
        $color = ProductColor::findOrFail($id);
        $color->name = $request->input('name');
        $color->color_code = $request->input('color_code');
        $color->save();

        return redirect()->back()->with('success', 'Color updated successfully');
    }

    public function destroy($id)
    {
        $color = ProductColor::find($id);
        if (!$color) {
            return response()->json(['error' => 'Color not found'], 404);
        }
        if (file_exists(public_path('images/color/' . $color->icon))) {
            unlink(public_path('images/color/' . $color->icon));
        }
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully');
    }
}
