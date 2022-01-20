<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTypeCompany extends Model
{
    protected $table = "company_type_companies";
    protected $connection = 'traves_main';

    protected $fillable = ["company_type_id", 'company_id'];
}
