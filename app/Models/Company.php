<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

class Company extends Model
{
    protected $table = "companies";

    protected $fillable = ['name', 'phone', 'email','address','zip_code','city','vat_id','country'];

    public function users()
   {   
        return $this->belongsToMany(User::class,'company_users')->get();
    }

    public function types(){
        return $this->belongsToMany(CompanyType::class,'company_company_types')->get();
    }

    public static function create($data, User $user){
        $company = static::query()->create($data);
                
        if(!$company or !($user->id)) return false;

        $companyUser = CompanyUser::create(
            ["company_id" => $company->id, "user_id" => $user->id]
        );
        if($companyUser){
            return $company;
        }else{
            $company->delete();
            return false;
        }   

    }
    
    public function delete(){
        $delete = static::query()->delete();
        if($delete){
           return CompanyUser::where("company_id", $this->id)->delete();
        }
            return false;
    }

    public function associate(User $user){
        if(!($user->id)) return false;
        $companyUser = CompanyUser::create(
            ["company_id" => $this->id, "user_id" => $user->id]
        );
        return $companyUser;
    }


    public function desassociate(User $user){
        if(!($user->id)) return false;
        $companyUser = CompanyUser::where("company_id", $this->id)
            ->where("user_id", $user->id);
        return $companyUser->delete();
    }



}
