<?php

namespace App\Http\Controllers;

use App\ProductsDb;
use App\Models\Likes;
use App\Models\Ratings;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $products_model = new Products();
        $allProducts = $products_model->getProducts();
        $allCategories = $products_model->getProductCategory();

        if (is_null($allProducts)) {
            $noProductsMessage = 'Tidak ada produk yang tersedia.';
        } else {
            $noProductsMessage = '';
        }

        if (is_null($allCategories)) {
            $noCategoriesMessage = 'Tidak ada kategori yang tersedia.';
        } else {
            $noCategoriesMessage = '';
        }
        return view('admin.products.index', compact('allProducts', 'noProductsMessage', 'allCategories', 'noCategoriesMessage'));
    }

    public function rate(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id',
        ]);

        // Cek apakah user sudah memberikan rating sebelumnya
        $existingRating = Ratings::where('user_id', auth()->id())
            ->where('products_id', $id)
            ->first();

        if ($existingRating) {
            // Jika sudah ada, update rating
            $existingRating->rating = $validatedData['rating'];
            $existingRating->save();
        } else {
            // Jika belum ada, buat rating baru
            Ratings::create([
                'user_id' => auth()->id(),
                'products_id' => $validatedData['product_id'],
                'rating' => $validatedData['rating'],
            ]);
        }

        return redirect()->back()->with('success', 'Rating berhasil diberikan!');
    }





    public function get_products(){
        $products_model = new ProductsDb();
        $data = $products_model->getProducts();
        $product_category = $products_model->getProductCategory();
        if($data !== ''){
            return View::make('index')->with('data', $data)->with('product_category', $product_category);
        }else{
            echo "Empty";
        }
    }

    

    public function get_jeans(){

        $category = "Jeans";
        $products_model = new ProductsDb();
        $data = $products_model->getProductsByCategory($category);

        $product_size = $products_model->getProductSize($category);
        $product_color = $products_model->getProductColor($category);
        $product_brand = $products_model->getProductBrand($category);
        $product_max_price = $products_model->getProductMaxPrice($category);
        $product_min_price = $products_model->getProductMinPrice($category);

        
        if($data !== ''){
            return View::make('category')->with('data', $data)->with('product_size', $product_size)->with('product_color', $product_color)->with('product_brand', $product_brand)->with('product_max_price', $product_max_price)->with('product_min_price', $product_min_price)->with('product_category', $category);
        }else{
            echo "Empty";
        }
    }


    public function get_shirts(){

        $category = "Shirts";
        $products_model = new ProductsDb();
        $data = $products_model->getProductsByCategory($category);

        $product_size = $products_model->getProductSize($category);
        $product_color = $products_model->getProductColor($category);
        $product_brand = $products_model->getProductBrand($category);
        $product_max_price = $products_model->getProductMaxPrice($category);
        $product_min_price = $products_model->getProductMinPrice($category);
        
        if($data !== ''){
            return View::make('category')->with('data', $data)->with('product_size', $product_size)->with('product_color', $product_color)->with('product_brand', $product_brand)->with('product_max_price', $product_max_price)->with('product_min_price', $product_min_price)->with('product_category', $category);
        }else{
            echo "Empty";
        }
    }



    public function filter_products(Request $request){

        $input = $request->all();
        $category = $request->input('product_category');

        $selected_size = $request->input('product_size');
        $selected_color = $request->input('product_color');
        $selected_brand = $request->input('product_brand');
        $selected_max_price = $request->input('product_max_price');
        $selected_min_price = $request->input('product_min_price');
        $selected_order = $request->input('order_product_by');
        
        $products_model = new ProductsDb();
        $data = $products_model->getFilteredProducts($request); 

        $product_size = $products_model->getProductSize($category);
        $product_color = $products_model->getProductColor($category);
        $product_brand = $products_model->getProductBrand($category);
        $product_max_price = $products_model->getProductMaxPrice($category);
        $product_min_price = $products_model->getProductMinPrice($category);
       
        if($data !== ''){            
            // echo "<pre/>";
            // print_r($data);
            return View::make('category')->with('data', $data)->with('product_size', $product_size)->with('product_color', $product_color)->with('product_brand', $product_brand)->with('product_max_price', $product_max_price)->with('product_min_price', $product_min_price)->with('product_category', $category)->with('selected_size', $selected_size)->with('selected_color', $selected_color)->with('selected_brand', $selected_brand)->with('selected_max_price', $selected_max_price)->with('selected_min_price', $selected_min_price)->with('selected_order', $selected_order);
        }else{

            return View::make('category')->with('data', $data)->with('product_size', $product_size)->with('product_color', $product_color)->with('product_brand', $product_brand)->with('product_max_price', $product_max_price)->with('product_min_price', $product_min_price)->with('product_category', $category)->with('selected_size', $selected_size)->with('selected_color', $selected_color)->with('selected_brand', $selected_brand)->with('selected_max_price', $selected_max_price)->with('selected_min_price', $selected_min_price)->with('selected_order', $selected_order);
            
        }
    }

    public function filterProducts(Request $request)
    {
        // Ambil data filter dari request
        $type = $request->input('type');
        $category = $request->input('category');
        $color = $request->input('color');
        $material = $request->input('material');

        // Query produk berdasarkan filter yang dipilih
        $products = Products::query()
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
                dd($type);
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
                dd($category);
            })
            ->when($color, function ($query, $color) {
                return $query->where('color', $color);
                dd($color);
            })
            ->when($material, function ($query, $material) {
                return $query->where('material', $material);
                dd($material);
            })
            ->get();

        // Return hasil ke view
        dd($products);
        return response()->json($products);
    }

    public function toggleLike($id)
    {
        $product = Products::findOrFail($id);
        $user = auth()->user(); // Pastikan user sudah login

        if ($product->isLikedByUser($user->id)) {
            // Jika user sudah like, hapus like
            Likes::where('user_id', $user->id)->where('product_id', $id)->delete();
        } else {
            // Jika user belum like, tambahkan like
            Likes::create([
                'user_id' => $user->id,
                'product_id' => $id,
            ]);
        }

        // Hitung jumlah like terbaru
        $likesCount = $product->likes()->count();

        return response()->json([
            'status' => 'success',
            'liked' => !$product->isLikedByUser($user->id), // Balik status like
            'likesCount' => $likesCount,
        ]);
    }




}
