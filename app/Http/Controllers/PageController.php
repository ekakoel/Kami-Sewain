<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Likes;
use App\Models\BlogTag;
use App\Models\Ratings;
use App\Models\Sliders;
use App\Models\BlogPost;
use App\Models\Products;
use App\Models\Galleries;
use App\Models\Promotion;
use App\Models\Categories;
use App\Models\SocialLink;
use App\Models\BlogCategory;
use App\Models\PageProperty;
use App\Models\ProductColor;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use App\Models\ProductMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home() {
        $now = Carbon::now();
        $business = BusinessProfile::where('id',1)->first();
        $socials = SocialLink::all();
        $latestPosts = BlogPost::where('status','published')->with('categories')->orderBy('created_at', 'desc')->take(4)->get();
        $products = Products::latest()->take(6)->get()->map(function ($product) {
            // Menghitung rata-rata rating
            $product->averageRating = $product->ratings()->avg('rating') ?? 0; // Default ke 0 jika tidak ada rating
            return $product;
        });
        // Mengambil produk populer
        $popularProducts = Products::getTopRatedProducts()->map(function ($product) {
            $product->averageRating = $product->ratings()->avg('rating') ?? 0; // Menghitung rata-rata
            $product->likes_count = $product->likes()->count(); // Menghitung jumlah like
            return $product;
        });
        $categories = Categories::all();
        $topLikedProducts = Products::getTopLikedProducts(6);
        $promotions = Promotion::where('status','Active')
            ->where('expired_date','>=',$now)
            ->get();
        $page = 'home';
        $page_properties = PageProperty::where('page', $page)->first();
        return view('home.index', compact(
            'products',
            'categories',
            'popularProducts',
            'topLikedProducts',
            'page_properties',
            'business',
            'socials',
            'latestPosts',
            'promotions',
        ));
    }
    public function fe_service() {
        $business = BusinessProfile::where('id',1)->first();
        $socials = SocialLink::all();
        $products = Products::where('status','Active')->get();
        $sliderHeaders = Sliders::where('location','services')->where('section','header')->where('status','Active')->get();
        return view('service.index', compact('products'),[
            'sliderHeaders'=>$sliderHeaders,
            'business'=>$business,
            'socials'=>$socials,
        ]);
    }

    public function fe_product()
    {
        $business = BusinessProfile::where('id', 1)->first();
        $socials = SocialLink::all();
        $products = Products::where('status', 'Active')
            ->withCount('likes')
            ->get()
            ->map(function ($product) {
                $product->averageRating = $product->ratings()->avg('rating') ?? 0; // Menghitung rata-rata rating
                return $product;
            });

        // Mengambil rating user
        $userRatings = auth()->check() ? Ratings::where('user_id', auth()->id())->get()->keyBy('products_id') : collect();

        // Page specific data
        $page = 'products';
        $sliderHeaders = Sliders::where('location', 'services')
            ->where('section', 'header')
            ->where('status', 'Active')
            ->get();
        $page_properties = PageProperty::where('page', $page)->first();
        $categories = Categories::all();
        $models = ProductModel::all();
        $materials = ProductMaterial::all();
        $colors = ProductColor::all();
        // Mengirim data ke view
        return view('products.index', compact(
            'business',
            'socials',
            'products',
            'sliderHeaders',
            'page_properties',
            'userRatings',
            'categories',
            'models',
            'materials',
            'colors',
        ));
    }
    


    public function fe_gallery() {
        $business = BusinessProfile::where('id',1)->first();
        $socials = SocialLink::all();
        $page = 'gallery';
        $page_properties = PageProperty::where('page', $page)->first();
        $products = Products::where('status', 'Active')->get();

        $categories = Categories::with(['galleries' => function($query) {
            $query->latest()->take(10);
        }])->get();

        $galleries = $categories->pluck('galleries')->flatten();
        $category = Categories::with('galleries')->get();

        // Menggunakan compact tanpa tanda kurung siku
        return view('gallery.index', compact(
            'products', 
            'categories', 
            'page_properties', 
            'galleries', 
            'category',
            'business',
            'socials',
        ));

    }
    public function fe_about_us() {
        $business = BusinessProfile::where('id',1)->first();
        $page = 'about-us';
        $page_properties = PageProperty::where('page', $page)->first();
        $socials = SocialLink::all();
        $products = Products::latest()->take(6)->get();
        $categories = Categories::all();
        $popularProducts = Products::getTopRatedProducts()->map(function ($product) {
            $product->averageRating = $product->ratings()->avg('rating') ?? 0; // Menghitung rata-rata
            $product->likes_count = $product->likes()->count(); // Menghitung jumlah like
            return $product;
        });
        return view('aboutUs.index', compact(
            'products',
            'business',
            'socials',
            'popularProducts',
            'categories',
            'page_properties',
        ));
    }
    public function fe_contact_us() {
        $business = BusinessProfile::where('id',1)->first();
        $page = 'contact-us';
        $page_properties = PageProperty::where('page', $page)->first();
        $socials = SocialLink::where('type','Social Media')->get();
        $marketplaces = SocialLink::where('type','Marketplace')->get();
        $contacts = SocialLink::where('type','Chat')->get();
        $products = Products::latest()->take(6)->get();
        return view('contacts.index', compact(
            'products',
            'business',
            'socials',
            'contacts',
            'marketplaces',
            'page_properties',
        ));
    }
    public function fe_portfolio() {
        $business = BusinessProfile::where('id',1)->first();
        $posts = BlogPost::where('status','published')->with('author')->latest()->paginate(8); // Ambil 6 post per halaman
        $page = 'portfolio';
        $page_properties = PageProperty::where('page', $page)->first();
        $categories = BlogCategory::all();
        return view('portfolio.index', compact(
            'posts',
            'page',
            'page_properties',
            'business',
            'categories',
            ))->with('paginator', $posts);
    }

    public function portfolio_detail($slug)
    {
        $business = BusinessProfile::where('id',1)->first();
        $page = 'portfolio_detail';
        $page_properties = PageProperty::where('page', $page)->first();
        $post = BlogPost::where('slug',$slug)->first();
        $latestPosts = BlogPost::orderBy('created_at', 'desc')->take(4)->get();
        $categories = BlogCategory::all();
        $comments = $post->comments()->where('parent_id',null)->where('status','approved')->paginate(5);
        $author_name = $post->author->fullname;
        return view('portfolio.detail', [
            'post' => $post,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'page'=>$page,
            'page_properties'=>$page_properties,
            'comments'=>$comments,
            'business'=>$business,
            'author_name'=>$author_name,
        ]);
    }
    public function portfolio_category($slug)
    {
        $business = BusinessProfile::where('id',1)->first();
        $page = 'portfolio_category';
        $page_properties = PageProperty::where('page', $page)->first();
        $category = BlogCategory::where('slug',$slug)->first();
        $posts = $category->posts->where('status','published');
        return view('portfolio.category', [
            'page'=>$page,
            'page_properties'=>$page_properties,
            'posts' => $posts,
            'category' => $category,
            'business' => $business,
        ]);
    }
    public function portfolio_tag($slug)
    {
        $business = BusinessProfile::where('id',1)->first();
        $page = 'portfolio_tag';
        $page_properties = PageProperty::where('page', $page)->first();
        $tag = BlogTag::where('slug',$slug)->first();
        $posts = $tag->posts->where('status','published');
        return view('portfolio.tag', [
            'page'=>$page,
            'page_properties'=>$page_properties,
            'posts' => $posts,
            'tag' => $tag,
            'business' => $business,
        ]);
    }

    public function showProducts()
    {
        $business = BusinessProfile::where('id',1)->first();
        $socials = SocialLink::all();
        $products = Products::with('ratings')->get()->map(function ($product) {
            // Menghitung rata-rata rating, asumsi ada field 'score' dalam tabel ratings
            $product->averageRating = $product->ratings()->avg('rating') ?? 0; // Default ke 0 jika tidak ada rating
            return $product;
        });

        return view('your_view_name', compact(
            'products',
            'business',
            'socials',
        ));
    }
    public function email_verifikasi()
    {
        
        $url = "http://localhost:8000/email/verify/12/c0682c231a41b5e7ece773e7fb1e1eb91438beb2?expires=1729652844&signature=4e01cb2472fb60d715f7d3bacc6ebd81107636c472d29d1e63ccef78e6b4fa40";
        return view('emails.verification', compact(
            'url',
        ));
    }
}
