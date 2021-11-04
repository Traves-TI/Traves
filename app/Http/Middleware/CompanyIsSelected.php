<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class CompanyIsSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(session()->has('company')){

            $company = session()->get('company');
            $db_name = ENV('DB_PREFIX', 'traves_') . $company->id;
            

            Config::set('database.connections.traves_db.database', $db_name); 

        }



        return $next($request);
    }
}
