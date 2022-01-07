<?php

namespace App\Providers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

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
      
        // Check is Cookie exist
        if(!is_null(Cookie::get('company'))){
            
            // Cookie for to recover company id and after connect the databse of current company 
            try{
                $arrCompanyID = explode('|', Crypt::decrypt(Cookie::get('company'), false));
            }catch(DecryptException $e){

                return redirect()->back();
            }
                if(is_array($arrCompanyID)){

                $company_id = end($arrCompanyID);

                if($company_id){
                    $db_name = ENV('DB_PREFIX', 'traves_') . $company_id;     
                    Config::set('database.connections.traves_db.database', $db_name);
                }
            } 

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
