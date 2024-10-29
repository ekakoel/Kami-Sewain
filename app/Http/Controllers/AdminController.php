<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Ratings;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductColor;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\ProductMaterial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $data_products = new Products();
        $products = Products::all();
        $activeProducts = Products::where('status','Active')->get();
        $draftProducts = Products::where('status','Draft')->get();
        $allProducts = $data_products->getProducts();
        $productCategories = Categories::all();

        if (is_null($allProducts)) {
            $noProductsMessage = 'Tidak ada produk yang tersedia.';
        } else {
            $noProductsMessage = '';
        }

        if (is_null($productCategories)) {
            $noCategoriesMessage = 'Tidak ada kategori yang tersedia.';
        } else {
            $noCategoriesMessage = '';
        }
        return view('admin.index', compact('products','activeProducts','draftProducts','allProducts', 'noProductsMessage', 'productCategories', 'noCategoriesMessage'));
    }
    public function products()
    {
        $data_products = new Products();
        $products = Products::withCount('likes')
            ->get()
            ->map(function ($product) {
                $product->averageRating = $product->ratings()->avg('rating') ?? 0; // Menghitung rata-rata rating
                return $product;
            });
        $userRatings = auth()->check() ? Ratings::where('user_id', auth()->id())->get()->keyBy('products_id') : collect();
        $allProducts = $data_products->getProducts();

        if (is_null($allProducts)) {
            $noProductsMessage = 'Tidak ada produk yang tersedia.';
        } else {
            $noProductsMessage = '';
        }

        return view('admin.products.index', compact('products','allProducts'));
    }

    public function create()
    {
        $categories = Categories::all();
        $materials = ProductMaterial::all();
        $models = ProductModel::all();
        $colors = ProductColor::all();
        return view('admin.products.create', compact(
            'categories',
            'materials',
            'models',
            'colors',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'model_id' => 'required|exists:product_models,id',
            'material_id' => 'nullable|exists:product_materials,id',
            'color_id' => 'nullable|exists:product_colors,id',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric',
            'production_date' => 'nullable|date',
            'stock' => 'required|integer',
        ]);

        $product = new Products();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->model_id = $request->model_id;
        $product->material_id = $request->material_id;
        $product->color_id = $request->color_id;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->production_date = $request->production_date;
        $product->stock = $request->stock;
        $product->status = "Draft";
        $product->alt = $request->type." ".$request->name;

        // Handle image upload
        if ($request->hasFile('cover')) {
            $directory = public_path('images/products/');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $coverName = time() . '.' . $request->cover->extension();
            if ($request->cover->move($directory, $coverName)) {
                $product->cover = $coverName;
            } else {
                return back()->with('error', 'Failed to upload cover image.');
            }
        }

        $product->save();

        $imageNames = ['Front', 'Right', 'Left', 'Back', 'Top'];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                if ($image && $key < 5) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images/products/'), $imageName);
                    $product->secondaryImages()->create([
                        'name' => $imageNames[$key],
                        'url' => $imageName,
                        'alt' => $imageNames[$key],
                    ]);
                }
            }
        }
        return redirect()->route('admin.products.detail',$product->id)->with('success', 'Product added successfully.');
    }


    public function detail_product($id)
    {

        $product = Products::findOrFail($id);
        $product_rating = $product->ratings()->avg('rating') ?? 0;
        $userRatings = auth()->check() ? Ratings::where('user_id', auth()->id())->get()->keyBy('products_id') : collect();

        return view('admin.products.detail', compact('product','userRatings'));
    }


    public function edit_product($id)
    {
        $product = Products::with('secondaryImages')->findOrFail($id);
        $categories = Categories::all();
        $materials = ProductMaterial::all();
        $models = ProductModel::all();
        $colors = ProductColor::all();
        return view('admin.products.edit', compact(
            'product', 
            'categories',
            'materials',
            'models',
            'colors',
        ));
    }

    public function update_product(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        // // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'material' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'production_date' => 'required|date',
            'status' => 'required|string|max:125',
            'cover' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048', // Validasi cover image
            'images.*' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048', // Validasi gambar tambahan
        ]);
         if ($request->hasFile('cover')) {
            if ($product->cover) {
                Storage::delete('images/products/' . $product->cover);
            }
            $product_cover = time() . '_cover_product_'.$request->name.".". $request->cover->getClientOriginalExtension();
            $request->cover->move('images/products', $product_cover);
            $product->cover = $product_cover;
        }
        // Update produk
        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'material_id' => $request->material,
            'model_id' => $request->model,
            'color_id' => $request->color,
            'price' => $request->price,
            'stock' => $request->stock,
            'production_date' => $request->production_date,
            'status' => $request->status,
        ]);
        $imageNames = ['Front', 'Right', 'Left', 'Back', 'Top'];
        $test = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                if ($image && $key < 5) {
                    $imageName = time() . '_' .$imageNames[$key]."_image_product_".$product->name.".". $image->getClientOriginalExtension();
                    $image->move(public_path('images/products/'), $imageName);
                    $secondary_image = $product->secondaryImages->where('name',$imageNames[$key])->first();
                    if ($secondary_image) {
                        if ($secondary_image->url) {
                            Storage::delete('images/products/' . $secondary_image->url);
                        }
                        $secondary_image->update([
                            'name' => $imageNames[$key],
                            'url' => $imageName,
                            'alt' => $imageNames[$key],
                        ]);
                        array_push($test, $image." = ".$secondary_image->name);
                    } else {
                        $product->secondaryImages()->create([
                            'name' => $imageNames[$key],
                            'url' => $imageName,
                            'alt' => $imageNames[$key],
                        ]);
                    }
                }
            }
        }
        // dd($test);
        return redirect()->route('admin.products.detail',['id'=>$id])->with('success', 'Product updated successfully');
    }

    // public function deleteImage($id)
    // {
    //     $image = ProductImage::find($id);

    //     if ($image) {
    //         // Hapus file gambar dari storage
    //         Storage::delete('images/products/' . $image->url);

    //         // Hapus data dari database
    //         $image->delete();

    //         return response()->json(['success' => 'Image deleted successfully.']);
    //     }

    //     return response()->json(['error' => 'Image not found.'], 404);
    // }
    public function deleteImage($id)
    {
        try {
            // Cari gambar berdasarkan ID
            $image = Image::findOrFail($id);
            
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }
            // Path gambar
            $imagePath = '/images/products/' . $image->url;
            
            // Hapus gambar dari storage jika file tersebut ada
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
    
            // Hapus record dari database
            $image->delete();
            return response()->noContent(); 
        } catch (\Exception $e) {
            // Tangkap error dan log errornya
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete image'], 500);
        }
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        if ($product->cover && is_string($product->cover) && file_exists(public_path('images/products/' . $product->cover))) {
            unlink(public_path('images/products/' . $product->cover)); // Menghapus gambar
        }
        foreach ($product->secondaryImages as $image) {
            if (isset($image->url) && is_string($image->url) && file_exists(public_path('images/products/' . $image->url))) {
                unlink(public_path('images/products/' . $image->url)); // Menghapus gambar
            }
            $image->delete();
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }
    
    public function checkSku(Request $request)
    {
        Log::info('Checking SKU: ' . $request->input('sku'));
        $sku = $request->input('sku');
        $exists = Products::where('sku', $sku)->exists();

        return response()->json(['exists' => $exists]);
    }
}
