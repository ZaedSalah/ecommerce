<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\orderDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem; // لو عندك جدول items; إن لم يوجد تجاهل استخدامه
use App\Models\ProductPhoto;
use Illuminate\Support\Str;
use App\Models\User; // مهم
use Yajra\DataTables\Facades\DataTables; // ضيف هذا فوق مع الـ use

use Carbon\Carbon;



class ProductController extends Controller
{
    public function AddProduct()
    {

        $allcategories = Category::all();
        return view('Products.addproduct', ['allcategories' => $allcategories]);
    }
    public function AddProductImages($productid)
    {
        $product = Product::find($productid);
        // get all photo private this product
        $productImages = ProductPhoto::where('product_id', $productid)->get();
        //   جيبلي كل الصور للمنتج الحالي و وديهه لفيو 
        return view('Products.AddProductimages', ['product' => $product, 'productImages' => $productImages]);
    }

    public function RemoveProduct($productid = null)
    {
        if ($productid) {
            $currentProduct = Product::find($productid);
            if (!$currentProduct) {
                return response()->json(['error' => 'المنتج غير موجود'], 404);
            }

            $currentProduct->delete();

            // سيعيد JSON أو إعادة توجيه حسب الحاجة
            return redirect()->back()->with('success', 'تم حذف المنتج بنجاح');
        } else {
            return redirect()->back()->with('error', 'يجب إدخال معرف المنتج');
        }
    }

    public function RemoveProductphoto($imageid)
    {
        $photo = ProductPhoto::findOrFail($imageid); // لو ما موجود، يرسل 404
        $photo->delete();
        return response()->json(['success' => true]);
    }

    public function EditProduct($productid = null)
    {
        if ($productid != null) {


            $allcategories = Category::all();
            //if not id public or in database dispaly not found ((findorfail or use if cond. to dispaly problem))

            //$currentProduct =  Product::findorfail($productid);
            $currentProduct =  Product::find($productid);
            if ($currentProduct == null) {
                abort(403, 'Can not find this product');
            }

            return view('Products.editproduct', ['product' => $currentProduct, 'allcategories' => $allcategories]);
        } else {
            return redirect('/addproduct');
        }
    }

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15',
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required'
        ]);

        if ($request->id) {
            // تعديل منتج
            $currentProduct = Product::find($request->id);
            $currentProduct->name = $request->name;
            $currentProduct->price = $request->price;
            $currentProduct->purchase_price = $request->purchase_price;
            $currentProduct->quantity = $request->quantity;
            $currentProduct->description = $request->description;
            $currentProduct->category_id = $request->category_id;

            if ($request->hasFile('photo')) {
                if ($currentProduct->imagepath && file_exists(public_path($currentProduct->imagepath))) {
                    unlink(public_path($currentProduct->imagepath));
                }
                $path = $request->photo->move('uploads', Str::uuid()->toString() . '-' . $request->file('photo')->getClientOriginalName());
                $currentProduct->imagepath = $path;
            }

            $currentProduct->save();
            return redirect('/product');
        } else {
            // إضافة منتج جديد
            $newProduct = new Product();
            $newProduct->name = $request->name;
            $newProduct->price = $request->price;
            $newProduct->purchase_price = $request->purchase_price;
            $newProduct->quantity = $request->quantity;
            $newProduct->description = $request->description;
            $newProduct->category_id = $request->category_id;

            if ($request->hasFile('photo')) {
                $path = $request->photo->move('uploads', Str::uuid()->toString() . '-' . $request->file('photo')->getClientOriginalName());
                $newProduct->imagepath = $path;
            }

            $newProduct->save();
            return redirect('/');
        }
    }

    public function AddCategory()
    {
        return view('Categories.addcategory'); // فيو خاص لإضافة الفئة
    }

    public function StoreCategory(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;


        // حفظ الصورة لو موجودة
        if ($request->hasFile('photo')) {
            $fileName = \Illuminate\Support\Str::uuid()->toString() . '-' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('uploads/categories'), $fileName);
            $category->imagepath = 'uploads/categories/' . $fileName;
        }


        $category->save();

        return redirect('/category')->with('success', 'تمت إضافة الفئة بنجاح');
    }
    public function EditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('Categories.editcategory', compact('category'));
    }

    public function UpdateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('photo')) {
            $path = $request->photo->move(
                'uploads/categories',
                \Illuminate\Support\Str::uuid()->toString() . '-' . $request->file('photo')->getClientOriginalName()
            );
            $category->imagepath = $path;
        }

        $category->save();

        return redirect('/')->with('success', 'تم تعديل الفئة بنجاح');
    }
    public function DestroyCategory($id)
    {
        $category = Category::findOrFail($id);

        // تحقق من وجود منتجات مرتبطة بالفئة
        $productsCount = $category->products()->count();
        if ($productsCount > 0) {
            return redirect('/')->with('error', 'لا يمكن حذف الفئة، لأنها تحتوي على منتجات');
        }

        $category->delete();
        return redirect('/')->with('success', 'تم حذف الفئة بنجاح');
    }


    // jquery datatable
    public function ProductsTable()
    {
        $products = Product::all();
        return view('Products.ProductsTable', ['products' => $products]);
    }
    // عند الضغط على الصورة يظهر تفاصيل المنتج
    public function showProduct($productid)
    {
        $product = Product::with('Category', 'productPhotos')->find($productid);

        //يعني جيب المنتجات بالقسم الي ما تسوي هذا الايدي بعدين سوي راندوم للعناصر بمقدار 3 ايتيم
        // يعي جيب كل المنتجات عدا المنتج الحالي 
        $relatedProducts =  Product::where('category_id', $product->category_id)->where('id', '!=', $productid)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('Products.showProduct', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }

    // الداشبورد منا للاخير 
    // دالة موحدة لإدارة كل السكشنات في الداشبورد
    public function index($section = 'home', $id = null)
    {
        // =========================
        // حسابات مشتركة (تُمرَّر لكل الأقسام) — يمنع Undefined variable
        // =========================
        $ordersCount   = Order::count();
        $usersCount    = User::count();
        $productsCount = Product::count();

        // حساب إجمالي المبيعات من orderdetails مباشرة
        $salesTotal = DB::table('orderdetails')
            ->selectRaw('SUM(quantity * price) as total_sales')
            ->value('total_sales') ?? 0;

        // حساب الأرباح (مبيعات - تكلفة شراء)
        $totalProfit = DB::table('orderdetails')
            ->join('products', 'orderdetails.product_id', '=', 'products.id')
            ->selectRaw('SUM((orderdetails.price - products.purchase_price) * orderdetails.quantity) as profit')
            ->value('profit') ?? 0;

        // الآن common array جاهز
        $common = compact('ordersCount', 'usersCount', 'productsCount', 'salesTotal', 'totalProfit');

        switch ($section) {

            // ===== الصفحة الرئيسية =====
            case 'home':
            default:
                $currentYear = now()->year;

                // فلترة GET
                $userFilter    = request()->input('user', '');
                $productFilter = request()->input('product', '');
                $search        = request()->input('search', '');
                $dateFilter    = request()->input('date', '');

                // =========================
                // جدول المستخدمين
                // =========================
                $usersQuery = User::withCount('orders')
                    ->with(['orders' => function ($q) {
                        $q->latest()->limit(1);
                    }]);

                if ($userFilter) {
                    $usersQuery->where('name', 'like', "%$userFilter%");
                }
                if ($search) {
                    $usersQuery->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
                }

                $users = $usersQuery->paginate(10)->withQueryString();

                // =========================
                // جدول المنتجات
                // =========================
                $productsQuery = Product::select('id', 'name', 'price')
                    ->withSum('orderdetails as sold_quantity', 'quantity')
                    ->withSum('orderdetails as total_profit', DB::raw('(price - products.purchase_price) * quantity'))
                    ->with(['orderdetails' => function ($q) {
                        $q->latest()->limit(1);
                    }]);

                if ($productFilter) {
                    $productsQuery->where('name', 'like', "%$productFilter%");
                }
                if ($search) {
                    $productsQuery->where('name', 'like', "%$search%");
                }

                $allProducts = $productsQuery->paginate(5)->withQueryString();

                // =========================
                // بيانات الرسم البياني (آخر 30 يومًا) + ألوان حسب المبيعات
                // =========================
                $chartLabels = [];
                $chartData   = [];
                $chartColors = [];

                for ($i = 29; $i >= 0; $i--) {
                    $date = now()->subDays($i)->startOfDay();
                    $chartLabels[] = $date->format('d-m');

                    // حساب إجمالي المبيعات لليوم الحالي
                    $dailySales = Order::whereDate('created_at', $date)->sum('total_price');
                    $chartData[] = $dailySales;

                    // تحديد اللون حسب قيمة المبيعات
                    if ($dailySales == 0) {
                        $chartColors[] = 'rgba(255, 99, 132, 0.5)'; // أحمر فاتح
                    } elseif ($dailySales < 100) {
                        $chartColors[] = 'rgba(255, 159, 64, 0.5)'; // برتقالي
                    } else {
                        $chartColors[] = 'rgba(75, 192, 192, 0.5)'; // أخضر
                    }
                }

                return view('dashboard.index', array_merge(
                    $common,
                    compact('section', 'users', 'allProducts', 'chartLabels', 'chartData', 'chartColors')
                ));


                // ===== جدول الطلبات =====
            case 'orders':
                $orders = Order::with(['user', 'orderdetails'])->latest()->get();
                return view('dashboard.index', array_merge($common, compact('section', 'orders')));

                // ===== تفاصيل طلب واحد =====
            case 'orderDetails':
                if (!$id) abort(404, 'Order ID not provided');
                $order = Order::with(['orderdetails.product', 'user'])->findOrFail($id);
                return view('dashboard.index', array_merge($common, compact('section', 'order')));

                // ===== جدول الفئات =====
            case 'categories':
                $categories = Category::withCount('products')->get();
                return view('dashboard.index', array_merge($common, compact('section', 'categories')));

                // ===== عرض المنتجات حسب الفئة =====
            case 'categoryProducts':
                if (!$id) abort(404, 'Category ID not provided');
                $category = Category::with('products')->findOrFail($id);
                return view('dashboard.index', array_merge($common, compact('section', 'category')));

                // ===== تفاصيل منتج =====
            case 'productDetails':
                if (!$id) abort(404, 'Product ID not provided');
                $product = Product::with('category')->findOrFail($id);
                return view('dashboard.index', array_merge($common, compact('section', 'product')));

                // ===== إدارة المستخدمين =====
            case 'users':
                $users = User::latest()->get();
                return view('dashboard.index', array_merge($common, compact('section', 'users')));

                // ===== إدارة المنتجات =====
            case 'products':
                $products = Product::with('category')->latest()->get();
                return view('dashboard.index', array_merge($common, compact('section', 'products')));

                // ===== تقارير المبيعات =====
            case 'reports':
                $filter = request()->input('filter', 'daily');
                $productFilter = request()->input('product', 'all');
                $userFilter = request()->input('user', 'all');

                $allProducts = Product::orderBy('name')->get();
                $allUsers = User::orderBy('name')->get();

                // Top products
                $topProducts = DB::table('orderdetails')
                    ->join('products', 'orderdetails.product_id', '=', 'products.id')
                    ->select(
                        'products.name',
                        DB::raw('SUM(orderdetails.quantity) as total_quantity'),
                        DB::raw('SUM(orderdetails.quantity * orderdetails.price) as total_revenue')
                    )
                    ->when($productFilter !== 'all', function ($q) use ($productFilter) {
                        $q->where('products.id', $productFilter);
                    })
                    ->groupBy('products.name')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();

                // Top users
                $topUsers = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select(
                        'users.name',
                        DB::raw('COUNT(orders.id) as total_orders'),
                        DB::raw('SUM(orders.total_price) as total_spent')
                    )
                    ->when($userFilter !== 'all', function ($q) use ($userFilter) {
                        $q->where('users.id', $userFilter);
                    })
                    ->groupBy('users.name')
                    ->orderByDesc('total_spent')
                    ->limit(5)
                    ->get();

                // Sales
                $sales = DB::table('orders')
                    ->join('orderdetails', 'orders.id', '=', 'orderdetails.order_id')
                    ->join('products', 'orderdetails.product_id', '=', 'products.id')
                    ->select(
                        DB::raw(match ($filter) {
                            'daily'   => 'DATE(orders.created_at)',
                            'monthly' => 'DATE_FORMAT(orders.created_at, "%Y-%m")',
                            'yearly'  => 'YEAR(orders.created_at)',
                        } . ' as period'),
                        DB::raw('SUM(orderdetails.quantity * orderdetails.price) as total_sales')
                    )
                    ->when($productFilter !== 'all', function ($q) use ($productFilter) {
                        $q->where('products.id', $productFilter);
                    })
                    ->when($userFilter !== 'all', function ($q) use ($userFilter) {
                        $q->where('orders.user_id', $userFilter);
                    })
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                return view('dashboard.index', array_merge(
                    $common,
                    compact('section', 'topProducts', 'topUsers', 'sales', 'filter', 'allProducts', 'allUsers', 'productFilter', 'userFilter')
                ));
        }
    }


    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->role = $request->role;
        $user->save(); // تأكد من استخدام save() وليس update() في بعض النسخ

        return redirect()->route('dashboard.index', ['section' => 'users'])
            ->with('success', 'تم تحديث صلاحية المستخدم بنجاح');
    }

    // جلب البيانات للجدول مع فلترة حسب الحالة والفئة
    public function getData(Request $request)
    {
        $status = $request->input('status', 'all');
        $category = $request->input('category', 'all');

        $query = Product::with('Category');

        // بحث خارجي
        if (!empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where('name', 'like', "%{$search}%");
        }

        // فلترة حسب الحالة
        if ($status !== 'all') {
            $query->where('quantity', $status === 'available' ? '>' : '<=', 0);
        }

        // فلترة حسب الفئة
        if ($category !== 'all') {
            $query->where('category_id', $category);
        }

        return datatables()->of($query)
            ->addColumn('category_name', fn($p) => $p->Category?->name ?? 'بدون فئة')
            ->addColumn('status', fn($p) => $p->quantity > 0 ? 'available' : 'unavailable')
            ->addColumn('actions', function ($p) {
                return '<a href="' . route('products.edit', $p->id) . '" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil"></i> تعديل</a>
                    <a href="/single-product/' . $p->id . '" class="btn btn-info btn-sm me-1"><i class="bi bi-eye"></i> تفاصيل</a>
                    <form action="/removeproduct/' . $p->id . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-danger btn-sm" onclick="return confirm(\'هل أنت متأكد؟\')"><i class="bi bi-trash"></i> حذف</button>
                    </form>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // بيانات الرسم البياني مع فلترة الحالة والفئة
    public function getChartData(Request $request)
    {
        $status = $request->input('status', 'all');
        $category = $request->input('category', 'all');

        $query = Product::query();

        if ($status !== 'all') {
            $query->where('quantity', $status === 'available' ? '>' : '<=', 0);
        }

        if ($category !== 'all') {
            $query->where('category_id', $category);
        }

        $products = $query->get();

        return response()->json([
            'names' => $products->pluck('name'),
            'quantities' => $products->pluck('quantity'),
            'status' => $products->map(fn($p) => $p->quantity > 0 ? 'available' : 'unavailable')
        ]);
    }

    // جدول مستخدمين
    public function getUsersData(Request $request)
    {
        $query = User::query();

        // البحث
        if (!empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        return datatables()->of($query)
            ->addColumn('actions', function ($user) {
                // هنا نستخدم اسم المستخدم مباشرة في الزر
                return '<button class="btn btn-sm btn-danger" onclick="alert(\'حذف المستخدم ' . $user->name . '\')">حذف</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // للاحصائيات, جلب بيانات وعرض بشكل منفصل عن داشبورد
    public function statistics()
    {
        $totalProducts = Product::count();
        $availableProducts = Product::where('quantity', '>', 0)->count();
        $outOfStockProducts = Product::where('quantity', '<=', 0)->count();
        $totalUsers = User::count();

        // المنتجات حسب الفئة
        $productsByCategory = Product::select('category_id')
            ->selectRaw('count(*) as count')
            ->groupBy('category_id')
            ->with('Category')
            ->get();

        return view('dashboard.stats', [
            'totalProducts' => $totalProducts,
            'availableProducts' => $availableProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'totalUsers' => $totalUsers,
            'productsByCategory' => $productsByCategory
        ]);
    }

    public function getStatsJson()
    {
        $totalProducts = Product::count();
        $availableProducts = Product::where('quantity', '>', 0)->count();
        $outOfStockProducts = $totalProducts - $availableProducts; // بدل الاستعلام مرتين

        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $salesThisMonth = Order::whereMonth('created_at', now()->month)->sum('total_price');
        $salesLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)->sum('total_price');

        return response()->json(compact(
            'totalProducts',
            'availableProducts',
            'outOfStockProducts',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'newUsersThisMonth',
            'salesThisMonth',
            'salesLastMonth'
        ));
    }

    public function ordersPage()
    {
        $orders = Order::with('user')->latest()->get();

        // إعادة البيانات بصيغة جاهزة للعرض
        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'user_name' => $order->name ?? $order->user->name ?? 'غير معروف',
                'user_email' => $order->email ?? $order->user->email ?? 'غير معروف',
                'user_phone' => $order->phone ?? $order->user->phone ?? 'غير معروف',
                'status' => $order->status ?? '-',
                'created_at' => $order->created_at->format('Y-m-d H:i'),
                'total_price' => $order->total_price,
            ];
        });

        return view('dashboard.orders', compact('data'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:معلق,مكتمل,ملغى',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        // إعادة بيانات للرسم البياني إذا أردنا
        $currentYear = now()->year;
        $salesPerMonthRaw = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        $salesPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
            $salesPerMonth[] = $salesPerMonthRaw[$i] ?? 0;
        }

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'status' => $order->status,
            'chartLabels' => $months,
            'chartData' => $salesPerMonth
        ]);
    }
}