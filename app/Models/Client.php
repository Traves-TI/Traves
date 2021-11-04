<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = 'traves_db';
    protected $fillable = ['name', 'phone', 'email','address','zip_code','city','vat','parent'];
}
