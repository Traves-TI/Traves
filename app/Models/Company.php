<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";

    public function users()
   {   
        return $this->belongsToMany(User::class,'company_users')->get();
    }

    public function types(){
        return $this->belongsToMany(CompanyType::class,'company_company_types')->get();
    }
}
