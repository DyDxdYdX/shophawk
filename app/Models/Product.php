<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'product_link',
        'price',
        'img_link',
        'brand'
    ];
}
