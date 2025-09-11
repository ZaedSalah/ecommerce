<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id'); // تعريف العمود أولًا
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('order_id'); // لو عندك جدول orders، يفضل تربط
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // السعر وقت الطلب
            $table->integer('price');
            $table->integer('quantity');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orderdetails');
    }
};