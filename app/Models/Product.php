<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Array_;

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

    static function storeImg($image, $company_id){
        if(is_null($image) or is_null($company_id)) return false;
       
        $MIMES = ["gif","png", "jpeg", "jpg"]; 

        
        // Check mime type
        if($image and array_search($image->extension(), $MIMES)){   
           
            // Path of folder of file
            $fileStorage = "/companies/$company_id/products";
            // Se for para ser um unico nome, alterar de storeAs para store
            $pathImage = $image->storeAs($fileStorage, $image->getClientOriginalName(), 'admin' );
          
            
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
