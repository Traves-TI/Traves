<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      
     // Cookie for to recover company id and after connect the databse of current company 
     $arrCompanyID = explode('|', Crypt::decrypt(Cookie::get('company'), false));
     
     $company_id = end($arrCompanyID);

     if($company_id){
        $db_name = ENV('DB_PREFIX', 'traves_') . $company_id;     
        Config::set('database.connections.traves_db.database', $db_name);
     } 

     // até aqui :D
        Schema::defaultStringLength(191);

        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate', 
                function ($perPage = 20, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
    }
        
    }
}
