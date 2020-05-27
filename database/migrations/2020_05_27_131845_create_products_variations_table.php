<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_variations', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->integer('type')->nullable()->comment('NULL - Default variation, 1 - Color; 2 - Size');
            $table->integer('initial_inventary');
            $table->integer('actual_inventary');
            $table->decimal('price');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_variations');
    }
}
