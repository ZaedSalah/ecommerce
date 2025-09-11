<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'purchase_price',
        'quantity',
        'description',
        'category_id',
        'imagepath'
    ];


    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // relation  between category and product
    }

    public function ProductPhotos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(Orderdetails::class, 'product_id');
    }
}