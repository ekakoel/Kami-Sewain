<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductModelRequest;
use App\Http\Requests\UpdateProductModelRequest;

class ProductModelController extends Controller
{
    
    public function index()
    {
        $models = ProductModel::all();
        return view('admin.products.model.index', compact('models'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $slug = Str::slug($request->input('name'));
        $originalSlug = $slug;
        $count = 1;
        while (ProductModel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $model = new ProductModel();
        $model->name = $request->input('name');
        $model->slug =$slug;
        $model->save();
        return redirect()->route('admin.models.index')->with('success', 'New Model has been added!');
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $model = ProductModel::findOrFail($id);
        $model->name = $request->input('name');
        $model->save();

        return redirect()->back()->with('success', 'Model updated successfully');
    }

    public function destroy($id)
    {
        $model = ProductModel::find($id);
        if (!$model) {
            return response()->json(['error' => 'Model not found'], 404);
        }
        if (file_exists(public_path('images/model/' . $model->icon))) {
            unlink(public_path('images/model/' . $model->icon));
        }
        $model->delete();
        return redirect()->route('admin.models.index')->with('success', 'Model deleted successfully');
    }


}
