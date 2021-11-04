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

    public function setDB(){
        $this->conn = $this->getDB();
    }

    public function getDB(){

        if(!$this->id) return false;

        if(!is_null($this->conn) OR $this->conn) return $this->conn;


        config(['database.connections.traves_db' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database'  =>  $this->db_name,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
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

            try {

                // try to execute the queries
                $result = $db->getConnection()->statement(DB::raw($query));
                // store the results and the queries for debug :P
                $debug[] = [
                    ((bool)$result),
                    $query,
                ];

            } catch(\Illuminate\Database\QueryException $e){
                // In case of an exceotion we store the message and the query
                $debug[] = [false, ($e->getMessage()), $query];
            }

           
        }

        //TODO we neeeeeed to check if the tables were created with no fail, because in case of a table that do not is created, the system will be corrupted. SO we need to rollback everything D:
            /*
        foreach($debug as $row){
            if(!isset($row[0]) OR $row[0] == false){
                dd($debug); break;
            }
        }

        dd($debug);
*/

    }

}
