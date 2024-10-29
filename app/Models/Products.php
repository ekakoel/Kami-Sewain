<?php

namespace App\Models;

use App\Models\User;
use App\Models\Likes;
use App\Models\Orders;
use App\Models\Categories;
use App\Models\ProductColor;
use App\Models\ProductModel;
use App\Models\ProductMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'cover',
        'alt',
        'category_id',
        'model_id',
        'material_id',
        'sku',
        'price',
        'color_id',
        'production_date',
        'stock',
        'status',
    ];
    public function secondaryImages()
    {
        return $this->hasMany(Image::class,'product_id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id');
    }
    public function model()
    {
        return $this->belongsTo(ProductModel::class,'model_id');
    }
    public function color()
    {
        return $this->belongsTo(ProductColor::class,'color_id');
    }
    public function material()
    {
        return $this->belongsTo(ProductMaterial::class,'material_id');
    }
    public function ratings()
    {
        return $this->belongsToMany(User::class, 'ratings', 'products_id', 'user_id')->withTimestamps();
    }

    public function likes()
    {
        return $this->hasMany(Likes::class,'product_id');
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Method to get top liked products
    public static function getTopLikedProducts($limit = 6)
    {
        return self::withCount('likes') // Counting the likes
            ->orderBy('likes_count', 'desc') // Sorting by like count in descending order
            ->take($limit) // Limit the result
            ->get();
    }
    
    public static function getTopRatedProducts($limit = 5)
    {
        return self::with('ratings') // Mengambil relasi ratings
            ->withCount(['ratings as average_rating' => function($query) {
                $query->select(\DB::raw('coalesce(avg(rating), 0)'));
            }]) // Hitung rata-rata rating
            ->orderBy('average_rating', 'desc') // Urutkan berdasarkan rata-rata
            ->take($limit) // Ambil sesuai limit
            ->get();
    }
    
    public function scopeOrderByPopularity($query)
    {
        return $query->withCount('ratings')->orderBy('ratings_count', 'desc');
    }

    public function getProducts()
    {
        $products = self::all();
        if ($products->isEmpty()) {
            return null;
        }
        return $products;
    }
    public function getProductCategory()
    {
        $categories = Categories::all();
        if ($categories->isEmpty()) {
            return null;
        }
        return $categories;
    }
    public function orders()
    {
        return $this->belongsToMany(Orders::class, 'order_products')
                    ->withPivot('quantity', 'price','total_price')
                    ->withTimestamps();
    }

}
