<?php 

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait HelperTrait{

        Static function DeleteImageStorage($path){
            dd(Storage::disk("admin")->delete($path));
        }

    }
?>