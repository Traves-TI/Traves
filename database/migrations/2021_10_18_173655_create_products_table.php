<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->decimal("price", 6, 2)->default(0);
            $table->integer("quantity")->default(0);
            $table->string("cover")->nullable();
            $table->string("image")->nullable();
            $table->string("reference")->nullable();
            $table->string("slug")->unique();
            $table->integer("tax_id")->default(0);
            $table->integer("status_id")->default(1);
            $table->integer("product_type_id")->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
