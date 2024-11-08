<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ShippingsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductModelController;
use App\Http\Controllers\ProductMaterialController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;


Auth::routes();
// ====================================================================================================
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'PageController@home')->name('home.index');
    Route::get('/service', 'PageController@fe_service')->name('service.index');
    Route::get('/product', 'PageController@fe_product')->name('products.index');
    Route::get('/gallery', 'PageController@fe_gallery')->name('gallery.index');
    Route::get('/about-us', 'PageController@fe_about_us')->name('about.index');
    Route::get('/contact-us', 'PageController@fe_contact_us')->name('contacts.index');
    // PORTFOLIO
    Route::get('/portfolio', 'PageController@fe_portfolio')->name('portfolio.index');
    Route::get('/portfolio/{slug}','PageController@portfolio_detail')->name('portfolio.detail');
    Route::get('/portfolio/categories/{slug}', 'PageController@portfolio_category')->name('portfolio.category');
    Route::get('/portfolio/tags/{slug}', 'PageController@portfolio_tag')->name('portfolio.tag');
    // CONTACT US
    Route::view('/contacts', 'contacts')->name('contacts.show');

    // SUBSCRIBE
    Route::get('/check-email', [SubscriberController::class, 'checkEmail']);
    Route::post('/subscribe', 'SubscriberController@signup')->name('subscribe');
    Route::get('/search', [ProductsController::class, 'filter_products'])->name('filter.perform');
    Route::post('/send-message-us', [EmailController::class, 'sendMessage'])->name('contact.send');
    Route::get('/products/filter', [ProductsController::class, 'filterProducts'])->name('products.filter');

    // USER
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/disconnection', 'AuthController@logout')->name('logout.perform');
        Route::get('/profil', 'UserController@show')->name('user.show');
        Route::get('/profil/edit/{email}', 'UserController@edit')->name('user.edit')->middleware(['ensureActive']);
        Route::post('/profil/update', 'UserController@update')->name('user.updateProfile')->middleware(['ensureActive']);
        Route::post('/profil/update-pass', [UserController::class, 'updatePassword'])->name('profile.updatePassword')->middleware(['ensureActive']);
    });
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::delete('/profil/destroy/{email}', 'UserController@destroy')->name('user.destroy');
        Route::put('/profile/update-image', [UserController::class, 'updateImage'])->name('profile.updateImage');

        // PROMOTION
        Route::post('/promotions/{promotion}/claim', [PromotionController::class, 'claimPromo'])->name('promotions.claim');
        Route::post('/promotion/{id}/use', [PromotionController::class, 'usePromotion'])->name('promotions.use');
        Route::post('/promotion/cart/{id}/use', [PromotionController::class, 'cartUsePromotion'])->name('cart.promotions.use');
        Route::post('/promotion/remove', [PromotionController::class, 'removePromotion'])->name('promotion.remove');

        // CART
        Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view')->middleware(['ensureActive']);
        Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add')->middleware(['ensureActive']);
        Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update')->middleware(['ensureActive']);
        Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove')->middleware(['ensureActive']);
        // CHECKOUT
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware(['ensureActive']);
        Route::post('/checkout/process', [OrdersController::class, 'create_order'])->name('checkout.process')->middleware(['ensureActive']);

        // ORDERS
        Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index')->middleware(['ensureActive']);
        Route::get('/orders/{orderno}', [OrdersController::class, 'detail_orders'])->name('orders.detail')->middleware(['ensureActive']);
        Route::delete('/orders/destroy/{orderno}', [OrdersController::class, 'destroy_orders'])->name('orders.destroy')->middleware(['ensureActive']);

        // RECEIPT
        Route::post('/receipts', [OrderReceiptController::class, 'store'])->name('receipts.store')->middleware(['ensureActive']);

        // PRODUCT RATINGS
        Route::post('/product/{id}/rate', [RatingsController::class, 'rateProduct'])->name('product.rate');
        Route::post('/product/{id}/like', [ProductsController::class, 'toggleLike'])->name('product.like');
        Route::post('/products/{id}/rate', [ProductsController::class, 'rate'])->name('products.rate');

        // BLOG
        Route::get('/admin-portfolio', [BlogPostController::class, 'user_index'])->name('portfolio.view');
        Route::get('/blog/{id}', [BlogPostController::class, 'show'])->name('blog.show');
        Route::get('/categories/{category}', [BlogCategoryController::class, 'show'])->name('category.show');
        Route::get('/tags/{tag}', [BlogTagController::class, 'show'])->name('tag.show');
        Route::post('/blog/{post}/comments', [BlogCommentController::class, 'store'])->name('blog.comments.store')->middleware(['ensureActive']);
        Route::post('/send-message-us', [EmailController::class, 'sendMessage'])->name('contact.send')->middleware(['ensureActive']);
    });

    // ADMIN
    Route::group(['prefix' => 'admin'], function () {
        // Route::get('/registration', 'AdminAuthController@show_register')->name('admin.register.show');
        // Route::post('/registration', 'AdminAuthController@register')->name('admin.register.perform');
        Route::get('/login-adm', 'AdminAuthController@show_login')->name('admin.login.show');
        Route::post('/f-login-adm', 'AdminAuthController@login')->name('admin.login.perform');

        Route::group(['middleware' => ['adminauth']], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.home');
            Route::get('/disconnection', 'AdminAuthController@logout')->name('admin.logout.perform');
            Route::get('/admin/car', 'CarController@index')->name('admin.car.index');
            Route::get('/admin/car/{id}', 'CarController@show')->where('id', '[0-9]+')->name('admin.car.show');
            Route::get('/admin/car/create', 'CarController@create')->name('admin.car.create');
            Route::post('/admin/car/create', 'CarController@store')->name('admin.car.store');
            Route::get('/admin/car/edit/{id}', 'CarController@edit')->name('admin.car.edit');
            Route::put('/admin/car/edit/{id}', 'CarController@update')->name('admin.car.update');
            Route::delete('/admin/car/delete/{id}', 'CarController@destroy')->name('admin.car.destroy');

            
            // USERMAN
            Route::get('/users', [UserController::class, 'index'])->middleware('adminPos:Developer')->name('admin.users.index');
            Route::put('/users/update/{id}', [UserController::class, 'update_status_user'])->middleware('adminPos:Developer')->name('admin.update.status.user');
            Route::put('/users/block/{id}', [UserController::class, 'block_user'])->middleware('adminPos:Developer')->name('admin.user.block');

            // CONTACTS
            Route::get('/contacts', [EmailController::class, 'index'])->name('admin.contacts');

            //PORTFOLIO
            Route::get('/portfolio', [BlogPostController::class, 'index'])->name('admin.portfolio');
            Route::get('/portfolio/create', [BlogPostController::class, 'create_portfolio'])->name('admin.portfolio.create');
            Route::put('/portfolio/add', [BlogPostController::class, 'add_portfolio'])->name('admin.portfolio.add');
            Route::get('/portfolio/{id}', [BlogPostController::class, 'detail_portfolio'])->name('admin.portfolio.detail');
            Route::get('/portfolio/{id}/edit', [BlogPostController::class, 'edit_portfolio'])->name('admin.portfolio.edit');
            Route::put('/portfolio/{id}/update', [BlogPostController::class, 'update'])->name('admin.portfolio.update');
            Route::delete('/portfolio/destroy/{id}', [BlogPostController::class, 'destroy'])->name('admin.portfolio.destroy');
            Route::post('/portfolio/{post}/comments', [BlogCommentController::class, 'store_comment'])->name('portfolio.comments.store');
            Route::post('/comment/approve', [BlogCommentController::class, 'approveComment'])->name('comment.approve');
            
            // COMMENTS
            Route::get('/comments', [BlogCommentController::class, 'index'])->name('admin.comments');
            Route::get('/comment/{id}', [BlogCommentController::class, 'detail_comment'])->name('admin.comment.detail');
            Route::delete('/comments/destroy/{id}', [BlogCommentController::class, 'destroy'])->name('admin.comments.destroy');

            Route::post('/comment/{id}/approve', [BlogCommentController::class, 'approve'])->name('admin.comment.approve');
            Route::post('/comment/{id}/reject', [BlogCommentController::class, 'reject'])->name('admin.comment.reject');

            //PRODUCT
            Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
            Route::get('/products/create', [AdminController::class, 'create'])->name('admin.products.create');
            Route::post('/products/add', [AdminController::class, 'store'])->name('admin.products.store');
            Route::get('/product-{id}', [AdminController::class, 'detail_product'])->name('admin.products.detail');
            Route::get('/product/{id}/edit', [AdminController::class, 'edit_product'])->name('admin.products.edit');
            Route::post('/check-sku', [AdminController::class, 'checkSku'])->name('check.sku');
            Route::post('/product/{id}/update', [AdminController::class, 'update_product'])->name('admin.products.update');
            Route::delete('/product/{id}', [AdminController::class, 'destroy'])->name('product.destroy');

            // DELETE PRODUCT IMAGES
            Route::delete('/image/{id}/delete', [AdminController::class, 'deleteImage'])->name('admin.image.delete');

            // PROMOTIONS
            Route::get('/promotions', [PromotionController::class, 'index'])->name('admin.promotions');
            Route::post('/promotions/store', [PromotionController::class, 'store'])->name('promotions.store');
            Route::put('/promotions/update/{id}', [PromotionController::class, 'update'])->name('promotions.update');
            Route::delete('/promotion/destroy/{id}',  [PromotionController::class, 'destroy'])->name('promotions.destroy');

            // BLOG
            Route::get('/blog', 'BlogPostController@index')->name('admin.blogs.index');
            Route::get('/blogs', 'BlogPostController@index')->name('blog.index');
            Route::get('/blog/create', 'BlogPostController@create')->name('blog.create');
            Route::get('/blog/edit/{id}', 'BlogPostController@edit')->name('blog.edit');
            Route::get('/blog/update/{id}', 'BlogPostController@update')->name('blog.update');
            Route::delete('/blog/destroy/{id}', 'BlogPostController@destroy')->name('blog.destroy');

            // CATEGORIES
            Route::get('/categories', [CategoriesController::class, 'index'])->name('admin.categories.index');
            Route::post('/category/store', [CategoriesController::class, 'store'])->name('admin.category.store');
            Route::patch('/category/{id}', [CategoriesController::class, 'update'])->name('admin.category.update');
            Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('admin.category.destroy');

            // MODELS
            Route::get('/models', [ProductModelController::class, 'index'])->name('admin.models.index');
            Route::post('/model/store', [ProductModelController::class, 'store'])->name('admin.model.store');
            Route::patch('/model/{id}', [ProductModelController::class, 'update'])->name('admin.model.update');
            Route::delete('/models/{id}', [ProductModelController::class, 'destroy'])->name('admin.model.destroy');

            // MATERIALS
            Route::get('/materials', [ProductMaterialController::class, 'index'])->name('admin.materials.index');
            Route::post('/material/store', [ProductMaterialController::class, 'store'])->name('admin.material.store');
            Route::patch('/material/{id}', [ProductMaterialController::class, 'update'])->name('admin.material.update');
            Route::delete('/materials/{id}', [ProductMaterialController::class, 'destroy'])->name('admin.material.destroy');

            // COLORS
            Route::get('/colors', [ProductColorController::class, 'index'])->name('admin.colors.index');
            Route::post('/color/store', [ProductColorController::class, 'store'])->name('admin.color.store');
            Route::patch('/color/update/{id}', [ProductColorController::class, 'update'])->name('admin.color.update');
            Route::delete('/colors/{id}', [ProductColorController::class, 'destroy'])->name('admin.color.destroy');
            
            // ORDERS
            Route::get('/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
            Route::get('/order-{id}', [OrderAdminController::class, 'detail_order'])->name('admin.order.detail');
            Route::get('/order/edit/{id}', [OrderAdminController::class, 'edit_order'])->name('admin.order.edit');
            Route::post('/order/store', [OrderAdminController::class, 'store'])->name('admin.order.store');
            Route::patch('/order/{id}', [OrderAdminController::class, 'update'])->name('admin.order.update');
            Route::post('/order/paid/{id}', [OrderAdminController::class, 'set_order_to_paid'])->name('admin.order.set.paid');
            Route::post('/order/reject/{id}', [OrderAdminController::class, 'set_order_to_reject'])->name('admin.order.set.reject');
            Route::post('/order/payment/{id}', [OrderAdminController::class, 'set_order_to_payment'])->name('admin.order.set.payment');
            Route::post('/order/validate/receipt/{id}', [OrderAdminController::class, 'validate_receipt'])->name('admin.order.validate.receipt');
            Route::delete('/orders/{id}', [OrderAdminController::class, 'destroy'])->name('admin.order.destroy');
            
            //SHIPPINGS
            Route::get('/shippings', [ShippingsController::class, 'index'])->name('admin.shippings');
            Route::post('/shipping/{id}', [ShippingsController::class, 'send_product'])->name('admin.shipping.send');
            Route::post('/shipping/update/{id}', [ShippingsController::class, 'update_shipping_product'])->name('admin.shipping.update');
            Route::post('/shipping/take/{id}', [ShippingsController::class, 'take_shipping_product'])->name('admin.shipping.take');

            // RECEIPT
            Route::post('/receipts/upload', [OrderAdminController::class, 'store_receipt'])->name('admin.receipts.upload');
            Route::delete('/receipt/destroy/{id}', [OrderAdminController::class, 'destroy_receipt'])->name('admin.order.destroy.receipt');
        });
    });
});

require __DIR__.'/auth.php';
