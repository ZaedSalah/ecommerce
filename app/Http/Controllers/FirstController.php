<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class FirstController extends Controller
{
    public function MainPage()
    {
        $categories =  Category::all();
        return view('welcome', ['categories' => $categories]);
    }
    public function about()
    {
        return view('about');
    }
    // عرض صفحة التواصل معنا
    public function contactPage()
    {
        return view('contact'); // صفحة contact.blade.php
    }

    // إرسال الرسالة
    public function send(Request $request)
    {
        // ✅ التحقق من البيانات
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        try {
            // ✅ إرسال الإيميل
            Mail::send([], [], function ($mail) use ($validated) {
                $mail->to('zaed4149@gmail.com') // ضع إيميلك هنا
                    ->subject($validated['subject'])
                    ->html("
                        <h3>رسالة جديدة من {$validated['name']}</h3>
                        <p><strong>البريد:</strong> {$validated['email']}</p>
                        <p><strong>الموضوع:</strong> {$validated['subject']}</p>
                        <p><strong>الرسالة:</strong><br>{$validated['message']}</p>
                     ");
            });

            return back()->with('success', 'تم إرسال رسالتك بنجاح ✅');
        } catch (\Exception $e) {
            return back()->with('error', 'حصل خطأ أثناء إرسال الرسالة: ' . $e->getMessage());
        }
    }


    public function GetCategoryProducts($catid = null)
    {

        if ($catid) {
            $product =  Product::where('category_id', $catid)->paginate(3);

            return view('product', ['products' => $product]);
        }
        //$catid == null
        else {
            $product =  Product::paginate(6);
            return view('product', ['products' => $product]);
        }
    }

    public function GetAllCategorywithProducts()
    {
        $categories = Category::all();
        $product = Product::paginate(6);
        // categories & products this is migrations
        return view('category', ['products' => $product, 'categories' => $categories]);
    }

    public function reviews()
    {
        // عرض جميع الآراء
        $reviews = Review::latest()->paginate(2); // آخر التعليقات أولاً، 10 لكل صفحة
        return view('reviews', compact('reviews'));
    }

    public function storeReview(Request $request)
    {
        // تحقق من صحة البيانات
        $request->validate([
            'name'    => 'required|max:50',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        $newReview = new Review();
        $newReview->user_id = Auth::id();   // ربط بالرجل المسجل
        $newReview->name    = $request->name;
        $newReview->subject = $request->subject;
        $newReview->message = $request->message;
        $newReview->rating  = $request->rating;

        $newReview->save();

        return redirect()->route('reviews.index')->with('success', 'تم إضافة رأيك بنجاح ✅');
    }
    // حذف مستخدم
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'المستخدم غير موجود');
        }

        $user->delete();

        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح');
    }
}