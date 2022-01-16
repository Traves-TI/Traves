<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $fillable = ["type"];
    public function companies()
    {
        return $this->hasManyThrough(Company::class, CompanyCompanyType::class, 
                                    'company_type_id', 'id', 
                                    'id', 'company_id')->get();
    }
}
