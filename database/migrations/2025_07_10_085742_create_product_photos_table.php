<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();
            $table->text('imagepath');

            // أضف هذا السطر أولاً
            $table->unsignedBigInteger('product_id');

            // ثم ضف العلاقة
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('product_photos');
    }
};