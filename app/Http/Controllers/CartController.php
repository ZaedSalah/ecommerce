<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderdetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function cart()
    {
        $user_id = Auth::user()->id;
        $cartProducts = Cart::with('product')
            ->where('user_id', $user_id)
            ->get()
            ->filter(function ($item) {
                return $item->product->quantity > 0; // فقط المنتجات المتوفرة
            });

        return view('Products.cart', ['cartProducts' => $cartProducts]);
    }

    public function Completeorder()
    {
        $user_id = Auth::user()->id;
        $cartProducts = Cart::with('product')->where('user_id', $user_id)->get();
        return view('Products.Completeorder', ['cartProducts' => $cartProducts]);
    }
    public function previousorder()
    {
        $user_id = Auth::user()->id;
        //  كل وذ يعني لازم ريليشن وسويته بالمودل الاوردر
        $result = Order::with('Orderdetails')->where('user_id', $user_id)->get();
        return view('Products.previousorder', ['order' => $result]);
    }

    public function StoreOrder(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $user_id = Auth::id();

        $newOrder = Order::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'note' => $validatedData['note'],
            'user_id' => $user_id,
        ]);

        $cartProducts = Cart::with('product')->where('user_id', $user_id)->get();

        foreach ($cartProducts as $item) {
            Orderdetails::create([
                'order_id' => $newOrder->id,
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);

            // تحديث كمية المنتج
            $product = $item->product;
            if ($product->quantity >= $item->quantity) {
                $product->quantity -= $item->quantity;
                $product->save();
            } else {
                return redirect()->back()->with('error', "المنتج {$product->name} غير متوفر بالكمية المطلوبة");
            }
        }

        // تفريغ السلة
        Cart::where('user_id', $user_id)->delete();

        // إعادة التوجيه للواجهة الرئيسية مع رسالة نجاح
        return redirect('/')->with('success', 'تم ارسال الطلب بنجاح');
    }

    public function deleteItem($id)
    {
        $item = Cart::find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'العنصر غير موجود');
        }

        $item->delete();

        return redirect()->back()->with('success', 'تم حذف العنصر بنجاح');
    }
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'العنصر غير موجود');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'تم تعديل الكمية بنجاح');
    }
}