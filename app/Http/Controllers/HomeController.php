<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $users = User::All();
        echo"<pre>";
           
       foreach ($users as $user) {
           $companies = $user->companies()->get();
           echo $user->name . PHP_EOL;
           foreach ($companies as $companie) {
               echo ($companie->name) . PHP_EOL;
           }
           echo PHP_EOL;
       }

    }
}
