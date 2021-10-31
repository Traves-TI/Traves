<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class Company extends Model
{


    protected $table = "companies";
    protected $company_table_prefix = "traves_";

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
            $database = $company->createDB();
            
            if($database){
                return $company;
            } else {
                $company->delete();
                return false;
            }
        }else{
            $company->delete();
            return false;
        }   
    }


    public function delete2(){

       $companyUser = CompanyUser::where("company_id", $this->id);
       $parent = 1;
       
       $tasks = [
           ['Obj' => $companyUser, 'Method' => 'delete'],
           ['Obj' => $parent, 'Method' => 'delete'],
             ['Obj' => $this,'Method' => 'deleteDB'],
       ];

        // Variable to control the proccess :D
        $control = true;
        // Our counter variable :P
        $counter = 0;
        // Total of tasks to be executed
        $tasksTotal = count($tasks);
        
        // While everything is ok
        while ($counter != $tasksTotal){
            
            // Get the current item in array
            $row = $tasks[$counter];

            // if anything goes wrong and returns false
            if(!call_user_func($row['Obj'], $row['Method'])){
                // Changes control variable to false 
                $control = false;
                // Ends the while
                break;
            }
            // Increments the variable :P
            $counter++;
        }
         
        if($control) return true;
         
        while($counter >= 0){
         
             $row = $tasks[$counter];
             
             if(!call_user_func($row['Obj'], '<<')){
                 break;
             }  
         
             $counter--;
         }
         
         if($counter == 0){
            // tudo foi restaurado com sucesso
            return false;
         } 
         
         // Alguma coisa deu errada nas restaurações
         
    }

    public function delete(){
        
        $control = [];
     
        // Apaga as relações
        $companyUser = CompanyUser::where("company_id", $this->id);
        
        if($companyUser){

            $companyUser = $companyUser->delete();
            
            //Tenta apagar a company
            $companyDelete = parent::delete();
            
            $deleteDB = false;
            
            // Verifica se a company foi apagada 
            if($companyDelete){
                // TODO- Criar rotina para eliminar as bds das empresas que foram deletadas após 30 dias 
                return true; 
            }else{
                $companyUser = ($companyUser) ? CompanyUser::withTrashed()->find($this->id)->restore() : $companyUser;
            }

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


    public function createDB(){
        return DB::statement('CREATE DATABASE IF NOT EXISTS ' . $this->company_table_prefix . $this->id);
    }
    
    public function deleteDB(){
        return DB::statement('DROP DATABASE IF EXISTS ' . $this->company_table_prefix . $this->id);
    }

}
