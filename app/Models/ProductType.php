<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /* Um produto type pertence a varios produtos */ 
    /*Base table or view not found: 1146 Table 'traves_14.product_types' doesn't exist (SQL: select * from `product_types` where `product_types`.`id` = 1 limit 1) 
      A tabela producyType não esta no driver atual setado que é o do cliente atual, tem que trocar a conexão (talvez) ou copiar a tabela para a base de dados atual :)  
    */ 
  /*  public function products(){
        return $this->belongsToMany();
    }*/


}
