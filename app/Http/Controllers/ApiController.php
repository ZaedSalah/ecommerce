<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // ===================== AUTH =====================

    // تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['success' => true, 'user' => $user, 'token' => $token]);
    }

    // تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['success' => true, 'user' => $user, 'token' => $token]);
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logged out']);
    }

    // ===================== PRODUCTS =====================
    public function allProducts()
    {
        $products = Product::with('Category', 'productPhotos')->get();
        return response()->json(['success' => true, 'products' => $products]);
    }

    public function singleProduct($id)
    {
        $product = Product::with('Category', 'productPhotos')->find($id);
        if (!$product) return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        return response()->json(['success' => true, 'product' => $product]);
    }

    // ===================== CATEGORIES =====================
    public function allCategories()
    {
        $categories = Category::all();
        return response()->json(['success' => true, 'categories' => $categories]);
    }

    public function categoryProducts($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        return response()->json(['success' => true, 'products' => $category->products]);
    }

    // ===================== CART =====================
    public function cart()
    {
        $user_id = Auth::id();
        $cart = Cart::with('product')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user_id = Auth::id();
        $cartItem = Cart::firstOrCreate(
            ['user_id' => $user_id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        if (!$cartItem->wasRecentlyCreated) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }

        return response()->json(['success' => true, 'cartItem' => $cartItem]);
    }

    public function deleteItem($id)
    {
        $item = Cart::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$item) return response()->json(['success' => false, 'message' => 'Item not found'], 404);

        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item removed successfully']);
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $item = Cart::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$item) return response()->json(['success' => false, 'message' => 'Item not found'], 404);

        $item->quantity = $request->quantity;
        $item->save();

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully', 'item' => $item]);
    }

    // ===================== ORDERS =====================
    public function storeOrder(Request $request)
    {
        $request->validate(['address' => 'required|string']);

        $user_id = Auth::id();
        $cartProducts = Cart::with('product')->where('user_id', $user_id)->get();
        if ($cartProducts->isEmpty()) return response()->json(['success' => false, 'message' => 'Cart is empty'], 400);

        $total_price = $cartProducts->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => $user_id,
            'address' => $request->address,
            'total_price' => $total_price
        ]);

        foreach ($cartProducts as $item) {
            $order->details()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
            $item->product->decrement('quantity', $item->quantity);
        }

        Cart::where('user_id', $user_id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order' => $order->load('details.product'),
            'total_price' => $total_price
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with('details.product')->where('user_id', Auth::id())->find($id);
        if (!$order) return response()->json(['success' => false, 'message' => 'Order not found'], 404);

        return response()->json(['success' => true, 'order' => $order]);
    }

    public function userOrders()
    {
        $orders = Order::with('details.product')->where('user_id', Auth::id())->get();
        return response()->json(['success' => true, 'orders' => $orders]);
    }

    // ===================== USER =====================
    public function userInfo()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'user' => $user]);
    }
}
