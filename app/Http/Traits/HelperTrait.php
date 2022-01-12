<?php 

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait HelperTrait{

        Static function DeleteImageStorage($path){
            if(Storage::disk("admin")->exists($path)){
                return Storage::disk("admin")->delete($path);
            }
            return false;
            
        }

    }
?>