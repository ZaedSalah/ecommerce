<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // لو عندك أي عمليات تحديث ضرورية بعد تصفير البيانات
        $this->call(UpdateOrdersTotalPriceSeeder::class);

        // لا حاجة لأي بيانات افتراضية

        // استدعاء الادمن
        $this->call(AdminSeeder::class);
    }
}