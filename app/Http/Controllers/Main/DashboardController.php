<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\CompanyDB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $CompanyDB = new CompanyDB();
        
        return redirect()->route('admin.companies.index');
        return view("admin.app");
    }
}
