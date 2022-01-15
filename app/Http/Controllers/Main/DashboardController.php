<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\CompanyDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $CompanyDB = new CompanyDB();
        
        //if(Auth::user()->level != 0){
            return redirect()->route('admin.companies.index');
        //}

        return view("admin.app");
    }
}
