<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'traves_db';
    protected $fillable = ['name', 'description', 'price', 'quantity', 'cover', 'image', 'reference', 'slug', 'tax_id', 'status_id', 'product_type_id'];

 
}
