<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FirstController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Middleware\Customauth;
use App\Http\Middleware\CheckRoleMiddleware;


Auth::routes();

//   middleware
Route::middleware([Customauth::class])->get('/', [FirstController::class, 'MainPage']);
Route::middleware([Customauth::class])->get('/about', [FirstController::class, 'about']);

// صفحة التواصل معنا (GET)
Route::middleware([Customauth::class])->get('/contact', [FirstController::class, 'contactPage'])->name('contact.page');
// إرسال الرسالة (POST)
Route::middleware([Customauth::class])->post('/contact/send', [FirstController::class, 'send'])->name('contact.send');


Route::get('/product/{catid?}', [FirstController::class, 'GetCategoryProducts']);
Route::get('/category', [FirstController::class, 'GetAllCategorywithProducts']);

Route::get('/reviews', [FirstController::class, 'reviews'])->name('reviews.index');
Route::post('/reviews', [FirstController::class, 'storeReview'])->name('reviews.store');

Route::get('/addproduct', [ProductController::class, 'AddProduct'])
    ->middleware([CheckRoleMiddleware::class . ':admin'])
    ->name('products.add');


Route::delete('/removeproduct/{productid}', [ProductController::class, 'RemoveProduct'])->name('products.remove');
Route::get('/editproduct/{productid?}', [ProductController::class, 'EditProduct'])->name('products.edit');
Route::post('/storeproduct', [ProductController::class, 'StoreProduct']);

// يخلي /search يقبل GET و POST
Route::match(['get', 'post'], '/search', function (Request $request) {
    $search = $request->input('searchkey');

    $products = Product::where('name', 'like', '%' . $search . '%')
        ->paginate(12)
        ->appends(['searchkey' => $search]); // يخلي قيمة البحث تبقى مع الصفحات

    return view('product', [
        'products' => $products,
        'search' => $search
    ]);
});

// add Category Routes
Route::get('/addcategory', [ProductController::class, 'AddCategory'])
    ->middleware([CheckRoleMiddleware::class . ':admin,superadmin'])
    ->name('categories.add');

Route::post('/storecategory', [ProductController::class, 'StoreCategory'])
    ->middleware([CheckRoleMiddleware::class . ':admin,superadmin'])
    ->name('categories.store');
Route::get('/categories/{id}/edit', [ProductController::class, 'EditCategory'])->name('categories.edit');
Route::put('/categories/{id}', [ProductController::class, 'UpdateCategory'])->name('categories.update');
Route::delete('/categories/{id}', [ProductController::class, 'DestroyCategory'])->name('categories.destroy');



// jquery datatable
Route::get('/productsTable', [ProductController::class, 'ProductsTable']);
Route::get('/single-product/{productid}', [ProductController::class, 'showProduct']);


Route::get('/AddProductImages/{productid}', [ProductController::class, 'AddProductImages']);
Route::delete('/removeproductphoto/{imageid}', [ProductController::class, 'RemoveProductphoto'])->name('productphotos.delete');


Route::get('/cart', [CartController::class, 'cart'])->middleware('auth');

// Order
Route::get('/Completeorder', [CartController::class, 'Completeorder'])->middleware('auth');
Route::get('/previousorder', [CartController::class, 'previousorder'])->middleware('auth');
Route::post('/StoreOrder', [CartController::class, 'StoreOrder']);


// حذف منتج من السلة
Route::delete('/cart/remove/{id}', [CartController::class, 'deleteItem'])->middleware('auth:sanctum');

// تحديث كمية منتج في السلة
Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity'])->middleware('auth:sanctum');

Route::get('/addproducttocart/{productid}', function ($productid) {
    $user_id = Auth::id(); // أو Auth::user()->id

    // التحقق إذا المنتج موجود مسبقًا في السلة
    $rseult = Cart::where('user_id', $user_id)->where('product_id', $productid)->first();

    if ($rseult) {
        // إذا موجود، زيادة الكمية
        $rseult->quantity += 1;
        $rseult->save();
    } else {
        // إذا غير موجود، إنشاء عنصر جديد
        $newCart = new Cart();
        $newCart->product_id = $productid;
        $newCart->user_id = $user_id;
        $newCart->quantity = 1;
        $newCart->save();
    }

    // الرجوع إلى صفحة السلة
    return redirect('/cart'); // الأفضل redirect بدل view
})->middleware('auth');

// roule admin &  superadmin

Route::get('/admin/index', function () {
    return 'Welcome to Admin Panel!';
})->middleware([CheckRoleMiddleware::class . ':admin,superadmin']);

// dashboard
// راوت داشبورد موحد
Route::get('/dashboard/{section?}/{id?}', [ProductController::class, 'index'])
    ->middleware([CheckRoleMiddleware::class . ':admin,superadmin'])
    ->name('dashboard.index');


Route::put('dashboard/user-role/{id}', [ProductController::class, 'updateUserRole'])
    ->name('dashboard.userRole.update')
    ->middleware([CheckRoleMiddleware::class . ':admin,superadmin']);


Route::get('/products/data', [ProductController::class, 'getData'])
    ->name('products.data');

Route::get('/products/chart-data', [ProductController::class, 'getChartData'])
    ->name('products.chartData');

Route::get('/users/data', [ProductController::class, 'getUsersData'])
    ->name('users.data');

Route::delete('/delete-user/{id}', [FirstController::class, 'delete'])
    ->middleware([CheckRoleMiddleware::class . ':admin'])
    ->name('users.delete');

Route::get('/dashboard/stats-json', [ProductController::class, 'getStatsJson'])->name('dashboard.stats-json');
Route::get('/dashboard/orders', [ProductController::class, 'ordersPage'])->name('dashboard.ordersPage');
Route::patch('/dashboard/orders/{id}/status', [ProductController::class, 'updateOrderStatus'])->name('dashboard.orders.updateStatus');