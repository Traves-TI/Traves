<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDO;
use PhpParser\Builder\Function_;

class CompanyDB extends Model
{

    use SoftDeletes;
    
    protected $table = 'company_dbs'; 
    protected $fillable = ['company_id', 'db_name'];
    private $conn = null;
    private $models = [
        Client::class,
        Product::class
    ];

    
    public function __construct(){
        parent::__construct();
        if($this->id){
            dd("o");
        }
        $db = $this->getDB();
        if($db) $this->conn = $db;
        return $this;
    }

/*
    static function getDB($db_name = null){
        
        $backtrace = debug_backtrace();
        if(is_null($db_name) and $backtrace[1]["type"] != '::'){
            if(isset($this->db_name)) {
                $db_name = $this->db_name;
            }
            else {
                return false;
            }
        }
        
        $db = Schema::connection($db_name);
        if($db) return $db;
        return false;
    }
*/

    public function getDB(){
        
        if(!$this->id) return false;
        dd($this->db_name);
        return Schema::connection($this->db_name);
    }

    static function create($company_id){
        
        if(!$company_id) return false;
        
        $db_name = ENV('DB_PREFIX', 'traves_') . $company_id;
        
        $createDB = DB::statement("CREATE DATABASE IF NOT EXISTS {$db_name}");
        
        if(!$createDB) return false;
        
        $self = new self;
     
        $self->fill(
            [
                'company_id' => $company_id,
                'db_name' => $db_name,
            ]
        );

        
       if(!$self->save()){
          DB::statement("DROP DATABASE IF EXISTS {$db_name}");
          return false;
       }else{
          
         $companyDB = self::find($self->id);
            dd($companyDB->id);
            return $companyDB;
       }
        

    }

     // TODO- Criar rotina para eliminar as bds das empresas que foram deletadas após 30 dias 
    static function deleteOld(){
        /*
        $createDB = DB::statement("CREATE DATABASE IF NOT EXISTS {$db_name}");
        // TODO - pegar todo que ta com o coiso do deleted_at != null e deletar
        */ 
    }



    public function copySchemas(){
        if(empty($this->models)) return false;
        $table_names = [];
        foreach ($this->models as $model) {
            $model = new $model;
            $db = DB::select(DB::raw("SHOW CREATE TABLE {$model->getTable()}"));
            
            foreach ($db as $value) {
                $value = (array)$value;
                $table_names[$model->getTable()] = $value["Create Table"];
            }
            
            
            
        }
      
        dd($table_names);
        
    }

}
