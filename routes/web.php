<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/jesus', 'HomeController@index')->name('login');

Auth::routes();

Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth']], function(){
    
    Route::get("/admin", 'Main\DashboardController@index')->name('admin.dashboard');

    Route::name("admin.")->prefix('admin')->group(function(){

        Route::resource('/companies', Main\CompanyController::class);

        // Rotas dos modelos loucões
        Route::resource('/clients', Main\ClientController::class);
        Route::resource('/products', Main\ProductController::class);
        Route::get("/products/recover/{id}", 'Main\ProductController@recoverProduct')->name('product.recover');
      
    });

});