<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetails extends Model
{
    use HasFactory;

    protected $table = 'orderdetails'; // تمام، إذا الجدول اسمه هيج

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    protected static function booted()
    {
        $updateOrderTotal = function ($detail) {
            $order = $detail->order;
            if ($order) {
                $order->total_price = $order->orderdetails()
                    ->selectRaw('SUM(quantity * price) as total')
                    ->value('total') ?? 0;
                $order->save();
            }
        };

        static::saved($updateOrderTotal);
        static::deleted($updateOrderTotal);
    }
}