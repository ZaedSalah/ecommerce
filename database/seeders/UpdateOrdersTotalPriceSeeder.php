<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class UpdateOrdersTotalPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // نجيب كل الطلبات
        $orders = Order::all();

        foreach ($orders as $order) {
            // نستخدم الدالة الي ضفناها بالموديل
            $order->updateTotalPrice();
        }
    }
}