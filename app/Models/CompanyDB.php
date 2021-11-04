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
    protected $dispatchesEvents = [
        'retrieved' => \App\Events\CompanyDbRetrieved::class,
    ];


    private $conn = null;

//    private $database = null;

    private $models = [
        Client::class,
        Product::class
    ];

    public function getDB(){
        if(!$this->id) return false;

        config(['database.connections.traves_db' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'database'  =>  'traves_2', //$this->db_name,
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]]);

        return Schema::connection('traves_db');
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

        
         $self->copyTables();

         $companyDB = self::find($self->id);
         return $companyDB;
       }
        
       return false;

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
      
        return $table_names;   
    }

    public function copyTables(){
        $db = $this->getDB();
        if(!$db) return false;
        
        $queries = $this->copySchemas();
        if(empty($queries)) return false;



        $debug = [];
        foreach($queries as $query) {

            $debug[] = [
                ((bool)$db->getConnection()->query($query)),
                $query,
            ];
        }

        

        $pdo = $db->getConnection()->getRawPdo(); 
        
        $query = $pdo->prepare('select * from livia');
        dd($query);
        dd($debug);
        
    }

}
