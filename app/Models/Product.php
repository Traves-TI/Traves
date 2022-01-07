<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Product extends Model
{
    protected $connection = 'traves_db';
    protected $fillable = ['name', 'description', 'price', 'quantity', 'cover', 'image', 'reference', 'slug', 'tax_id', 'status_id', 'product_type_id'];

    /**
     * Function return slug to creation
     */
    static function getSlug($slug){
        $slug = Str::slug($slug, "-");
        $self = new self();
        
        return (is_null($self->all()->where("slug", $slug)->first()))?$slug:false;
    } 

}
