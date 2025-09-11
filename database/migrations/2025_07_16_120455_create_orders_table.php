<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('orders');
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total_price', 10, 2)->default(0); // السعر الكلي
            $table->string('status')->default('قيد المعالجة'); // حالة الطلب
            $table->timestamps();

            // المفتاح الأجنبي
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};