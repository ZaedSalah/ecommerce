<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'total_price',
        'status',
        'note'
    ];

    public function orderdetails()
    {
        return $this->hasMany(Orderdetails::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 دالة لحساب وتحديث السعر الكلي
    public function updateTotalPrice()
    {
        $this->total_price = $this->orderdetails()->sum(DB::raw('price * quantity'));
        $this->save();
    }

    //الـ Accessor لحساب الإجمالي:
    public function getTotalAttribute()
    {
        return $this->orderdetails?->sum(function ($d) {
            return $d->price * $d->quantity;
        }) ?? 0;
    }
}