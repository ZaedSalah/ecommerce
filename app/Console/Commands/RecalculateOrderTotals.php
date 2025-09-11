<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class RecalculateOrderTotals extends Command
{
    /**
     * اسم الكوماند
     */
    protected $signature = 'orders:recalculate-totals';

    /**
     * وصف الكوماند
     */
    protected $description = 'إعادة حساب إجمالي المبيعات (total_price) لجميع الطلبات القديمة';

    /**
     * تنفيذ الكوماند
     */
    public function handle()
    {
        $this->info('جاري إعادة حساب إجمالي الطلبات...');

        $count = 0;
        foreach (Order::with('orderdetails')->get() as $order) {
            $order->total_price = $order->orderdetails->sum(function ($detail) {
                return $detail->price * $detail->quantity;
            });
            $order->save();
            $count++;
        }

        $this->info("✅ تم تحديث {$count} طلب بنجاح!");
        return Command::SUCCESS;
    }
}