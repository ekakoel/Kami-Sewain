<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Categories::all();
        return view('admin.categories.index', compact('categories'));
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
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required', // Validasi untuk gambar
        ]);

        // Pastikan file ada
        $category = new Categories();
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        if ($request->hasFile('icon')) {
            $iconName = time() . '.' . $request->file('icon')->extension();
            $request->file('icon')->move('images/categories/', $iconName);
            $category->icon = $iconName; // Menyimpan path ikon ke database
        }
        if ($request->hasFile('bg_modal')) {
            $coverName = time() . '.' . $request->file('bg_modal')->extension();
            $request->file('bg_modal')->move('images/categories/image/', $coverName);
            $category->cover = $coverName; // Menyimpan path cover ke database
        }
           
        // Membuat kategori baru
        $category->save();
        

        return redirect()->route('admin.categories.index')->with('success', 'Categories has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ikon tidak harus diubah
        ]);

        // Cari kategori berdasarkan ID
        $category = Categories::findOrFail($id);

        // Perbarui data kategori
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        // Jika ikon diperbarui
        if ($request->hasFile('icon')) {
            // Hapus ikon lama jika ada
            if ($category->icon && file_exists('images/categories/' . $category->icon)) {
                unlink('images/categories/' . $category->icon);
            }
            // Upload ikon baru
            $iconName = time() . '.' . $request->file('icon')->extension();
            $request->icon->move('images/categories/', $iconName);
            $category->icon = $iconName; // Simpan nama ikon baru
        }
        // Jika cover diperbarui
        if ($request->hasFile('background_image')) {
            if ($category->cover && file_exists('images/categories/image/' . $category->cover)) {
                unlink('images/categories/image/' . $category->cover);
            }
            // Upload ikon baru
            $coverName = time() . '.' . $request->file('background_image')->extension();
            $request->background_image->move('images/categories/image/', $coverName);
            $category->cover = $coverName; // Simpan nama cover baru
        }


        $category->save();
        // dd($request->background_image, $category);
        // Simpan kategori

        return redirect()->back()->with('success', 'Category updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        if (file_exists('images/categories/' . $category->icon)) {
            unlink('images/categories/' . $category->icon);
        }
        if (file_exists('images/categories/image/' . $category->cover)) {
            unlink('images/categories/image/' . $category->cover);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }

}
