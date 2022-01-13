<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;
  
    protected $connection = 'traves_db';
    protected $fillable = ['name', 'description', 'price', 'quantity', 'cover', 'image', 'reference', 'slug', 'tax_id', 'status_id', 'product_type_id'];

    /**
     * Function return slug to creation
     */
    static function getSlug($slug){
        $slug = Str::slug($slug, "-");
        $self = new self();
        $product = null;
        /* Get all products, excludeds include */ 
        $product = (!is_null($self))?($self->withTrashed()->where("slug", $slug)->first()):$product;
        
        /* If not null, check if is trashed */ 
        if(!(is_null($product))){
            /* If not trashed, return error the same name  */
          if(!($product->trashed())) return false;      
          /* If trashed return the product excluded */
          else return $product;
        /* If product is null, return the slug */ 
        }else{
            return $slug;
        }
        
    } 

    static function storeImg($image, $pathStorage){
        if(is_null($image) or is_null($pathStorage)) return false;
       
        $MIMES = ["gif","png", "jpeg", "jpg"]; 

        // Check mime type
        if($image and array_search($image->extension(), $MIMES)){   
           
            $pathImage = $image->storeAs($pathStorage, $image->hashName(), 'admin' );
          
            if(!is_null($pathImage)){
                return $pathImage;
            }else{
                $errors["product.image.store"] = __("Occurs an error at image upload, please contact the administrator :D");
            }
        }else{
            $errors["product.image"] = __('The type of file don\'t allow. Send file gif, png, jpg or jpeg');
        }
        return $errors;
    }



}
