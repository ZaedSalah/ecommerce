<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // حذف الجدول إذا كان موجود مسبقًا لتجنب أي تعارض
        Schema::dropIfExists('carts');

        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // المستخدم يمكن يكون زائر، لذا nullable
            $table->unsignedBigInteger('user_id')->nullable();

            // العمود الخاص بالمنتج
            $table->unsignedBigInteger('product_id');

            // الكمية، يمكن تعيين قيمة افتراضية
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // مفاتيح اجنبية
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};