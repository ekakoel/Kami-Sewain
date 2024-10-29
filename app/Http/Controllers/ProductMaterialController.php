<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductMaterial;
use App\Http\Requests\StoreProductMaterialRequest;
use App\Http\Requests\UpdateProductMaterialRequest;

class ProductMaterialController extends Controller
{
    public function index()
    {
        $materials = ProductMaterial::all();
        return view('admin.products.material.index', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $material = new ProductMaterial();
        $material->name = $request->input('name');
        $material->save();
        return redirect()->route('admin.materials.index')->with('success', 'New Material has been added!');
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $material = ProductMaterial::findOrFail($id);
        $material->name = $request->input('name');
        $material->save();

        return redirect()->back()->with('success', 'Material updated successfully');
    }

    public function destroy($id)
    {
        $material = ProductMaterial::find($id);
        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }
        if (file_exists(public_path('images/material/' . $material->icon))) {
            unlink(public_path('images/material/' . $material->icon));
        }
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Material deleted successfully');
    }
}
